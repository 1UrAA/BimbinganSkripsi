<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sidang;
use App\Models\Ruangan;
use App\Models\Dosen;
use App\Models\Penguji;
use App\Models\NilaiSidang;
use App\Models\Skripsi;
use Illuminate\Support\Facades\Auth;

class SidangController extends Controller
{
    // Dashboard Tunggal untuk Sidang berdasar peran
    public function index()
    {
        $user = Auth::user();

        // 1. MAHASISWA: Pengajuan & Status Sidang (Sempro & Akhir)
        if ($user->role === 'mahasiswa') {
            $sidangSempro = Sidang::with(['ruangan', 'pengujis.dosen.user', 'nilai.dosen.user'])->where('mahasiswa_id', $user->mahasiswa->id)->where('jenis_sidang', 'proposal')->latest()->first();
            $sidangAkhir = Sidang::with(['ruangan', 'pengujis.dosen.user', 'nilai.dosen.user'])->where('mahasiswa_id', $user->mahasiswa->id)->where('jenis_sidang', 'akhir')->latest()->first();
            $skripsi = Skripsi::where('mahasiswa_id', $user->mahasiswa->id)->first();
            return view('sidang.mahasiswa', compact('sidangSempro', 'sidangAkhir', 'skripsi'));
        }

        // 2. ADMIN PRODI: Memplot jadwal dan penguji untuk mahasiswanya
        if ($user->role === 'admin_prodi') {
            $sidangs = Sidang::whereHas('mahasiswa', function($q) use ($user) {
                $q->whereHas('user', function($u) use ($user) {
                    $u->where('prodi_id', $user->prodi_id);
                });
            })->with(['mahasiswa.user', 'ruangan', 'pengujis.dosen.user'])->orderBy('created_at', 'desc')->get();
            
            $ruangans = Ruangan::all();
            
            $dosens = Dosen::whereHas('user', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            })->get();

            return view('sidang.admin', compact('sidangs', 'ruangans', 'dosens'));
        }

        // 3. DOSEN: Memberi nilai kepada mahasiswa yang diujinya
        if ($user->role === 'dosen') {
            $pengujians = Penguji::with(['sidang.mahasiswa.user', 'sidang.ruangan', 'sidang.mahasiswa.skripsi'])->where('dosen_id', $user->dosen->id)->get();
            $nilaiSudah = NilaiSidang::where('dosen_id', $user->dosen->id)->get()->keyBy('sidang_id');

            return view('sidang.dosen', compact('pengujians', 'nilaiSudah'));
        }

        abort(403);
    }

    // Aksi Mahasiswa: Mendaftar Sidang (Proposal atau Akhir)
    public function daftarSidang(Request $request)
    {
        $user = Auth::user();
        $skripsi = Skripsi::where('mahasiswa_id', $user->mahasiswa->id)->first();

        $request->validate([
            'jenis' => 'required|in:proposal,akhir',
            'judul' => 'required|string'
        ]);

        if (!$skripsi || $skripsi->status_pembimbing_2 !== 'diterima') {
            return back()->with('error', 'Persyaratan Skripsi belum lengkap (Belum punya 2 Pembimbing sah).');
        }

        if ($request->jenis == 'proposal') {
            if (!$skripsi->acc_sempro_p1 || !$skripsi->acc_sempro_p2) {
                return back()->with('error', 'Pendaftaran Ditolak: Anda belum mendapat ACC Seminar Proposal dari kedua Pembimbing Anda.');
            }
        } else {
            if (!$skripsi->acc_akhir_p1 || !$skripsi->acc_akhir_p2) {
                return back()->with('error', 'Pendaftaran Ditolak: Anda belum mendapat ACC Sidang Akhir dari kedua Pembimbing Anda.');
            }
        }

        Sidang::create([
            'mahasiswa_id' => $user->mahasiswa->id,
            'jenis_sidang' => $request->jenis,
            'judul' => $request->judul,
            'status' => 'diajukan'
        ]);

        return back()->with('success', 'Berhasil mendaftar antrean. Pantau jadwal ' . strtoupper($request->jenis) . ' Anda di sini.');
    }

    // Aksi Admin Prodi: Menambah Ruangan
    public function storeRuangan(Request $request)
    {
        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi' => $request->lokasi
        ]);
        return back()->with('success', 'Ruangan baru berhasil didaftarkan.');
    }

    // Aksi Admin Prodi: Menjadwalkan & Plotting Penguji (2 Dosen)
    public function jadwalkanSidang(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required',
            'ruangan_id' => 'required|exists:ruangans,id',
            'penguji_1_id' => 'required|exists:dosens,id',
            'penguji_2_id' => 'required|exists:dosens,id|different:penguji_1_id'
        ]);

        $sidang = Sidang::findOrFail($id);
        $sidang->update([
            'tanggal' => $request->tanggal,
            'jam' => $request->jam,
            'ruangan_id' => $request->ruangan_id,
            'status' => 'terjadwal'
        ]);

        // Reset penguji lama
        Penguji::where('sidang_id', $sidang->id)->delete();
        
        // Tetapkan penguji 1 & 2
        Penguji::create(['sidang_id' => $sidang->id, 'dosen_id' => $request->penguji_1_id, 'peran' => 'penguji_1']);
        Penguji::create(['sidang_id' => $sidang->id, 'dosen_id' => $request->penguji_2_id, 'peran' => 'penguji_2']);

        return back()->with('success', 'Jadwal dan Dosen Penguji berhasil ditetapkan dan mahasiswa telah dijadwalkan sidang!');
    }

    // Aksi Dosen: Memasukkan Nilai Akhir
    public function evaluasiSidang(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'status' => 'required|in:lulus,revisi,mengulang'
        ]);

        $dosen_id = Auth::user()->dosen->id;

        $isPenguji = Penguji::where('sidang_id', $id)->where('dosen_id', $dosen_id)->exists();
        if (!$isPenguji) abort(403, 'Akses ditolak: Anda bukan penguji pada sidang mahasiswa ini.');

        NilaiSidang::updateOrCreate(
            ['sidang_id' => $id, 'dosen_id' => $dosen_id],
            [
                'nilai' => $request->nilai,
                'catatan' => $request->catatan,
                'status' => $request->status
            ]
        );

        // Hitung total nilai masuk
        $totalNilaiMasuk = NilaiSidang::where('sidang_id', $id)->count();
        if ($totalNilaiMasuk >= 2) {
            $sidang = Sidang::find($id);
            // Periksa apakah ada yang memvonis gagal / mengulang
            $adaGagal = NilaiSidang::where('sidang_id', $id)->where('status', 'mengulang')->exists();
            
            if ($adaGagal) {
                // Vonis gagal
                $sidang->update(['status' => 'ditolak']);
                
                // HUKUMAN: Cabut Izin Tarik Kembali ke Fase Bimbingan
                $skripsi = Skripsi::where('mahasiswa_id', $sidang->mahasiswa_id)->first();
                if ($sidang->jenis_sidang == 'proposal') {
                    $skripsi->update(['acc_sempro_p1' => false, 'acc_sempro_p2' => false]);
                } else {
                    $skripsi->update(['acc_akhir_p1' => false, 'acc_akhir_p2' => false]);
                }
            } else {
                // Semua lulus/revisi (Lulus)
                $sidang->update(['status' => 'selesai']);
            }
        }

        return back()->with('success', 'Evaluasi Anda berhasil dilampirkan!');
    }
}