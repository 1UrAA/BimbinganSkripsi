<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bimbingan;
use App\Models\Skripsi;
use Illuminate\Support\Facades\Auth;

class BimbinganController extends Controller
{
    // Dashboard Bimbingan (Bisa diakses Mahasiswa atau Dosen)
    public function index(){
        $user = Auth::user();
        
        if ($user->role === 'mahasiswa') {
            // Data untuk Mahasiswa
            $data = Bimbingan::with(['dosen.user'])->where('mahasiswa_id', $user->mahasiswa->id)->orderBy('created_at','desc')->get();
            $skripsi = Skripsi::where('mahasiswa_id', $user->mahasiswa->id)->first();
            return view('bimbingan.mahasiswa', compact('data', 'skripsi'));
        }

        if ($user->role === 'dosen') {
            // Data antrean Bimbingan Masuk ke Dosen ini
            $data = Bimbingan::with(['mahasiswa.user', 'mahasiswa.skripsi'])->where('dosen_id', $user->dosen->id)->orderBy('created_at','desc')->get();
            
            // Mengambil daftar mahasiswa bimbingan unik
            $mahasiswaBimbingan = Skripsi::with('mahasiswa.user')
                ->where('pembimbing_1_id', $user->dosen->id)
                ->orWhere('pembimbing_2_id', $user->dosen->id)
                ->get();
                
            return view('bimbingan.dosen', compact('data', 'mahasiswaBimbingan'));
        }

        abort(403);
    }

    // Mahasiswa Kirim Dokumen
    public function store(Request $request){
        $user = Auth::user();
        if ($user->role !== 'mahasiswa') abort(403);

        $request->validate([
            'tipe_bimbingan' => 'required|in:pembimbing_1,pembimbing_2',
            'file' => 'required|mimes:pdf,doc,docx|max:10000'
        ]);

        $skripsi = Skripsi::where('mahasiswa_id', $user->mahasiswa->id)->first();
        if (!$skripsi) return back()->with('error', 'Data skripsi tidak ditemukan.');

        $dosen_id = $request->tipe_bimbingan === 'pembimbing_1' ? $skripsi->pembimbing_1_id : $skripsi->pembimbing_2_id;
        
        if (!$dosen_id) {
            return back()->with('error', 'Dosen pembimbing tujuan belum tersedia.');
        }

        $file = $request->file('file');
        $nama = time().'_BIMBINGAN_'.$user->mahasiswa->nim.'.'.$file->extension();
        $file->move(public_path('uploads'), $nama);

        Bimbingan::create([
            'mahasiswa_id' => $user->mahasiswa->id,
            'dosen_id' => $dosen_id,
            'tipe_bimbingan' => $request->tipe_bimbingan,
            'file' => $nama,
            'status' => 'menunggu'
        ]);

        return back()->with('success', 'Dokumen Bimbingan berhasil dikirim ke Dosen terkait!');
    }

    // Dosen Memberi Review/ACC
    public function review(Request $request, $id){
        $user = Auth::user();
        if ($user->role !== 'dosen') abort(403);

        $bimbingan = Bimbingan::findOrFail($id);
        
        // Pastikan hanya dosen tujuan yang bisa review
        if ($bimbingan->dosen_id != $user->dosen->id) abort(403);

        $request->validate([
            'status' => 'required|in:menunggu,revisi,acc'
        ]);

        $bimbingan->update([
            'komentar' => $request->komentar,
            'status' => $request->status
        ]);

        return back()->with('success', 'Review berhasil disimpan.');
    }

    // Dosen Upload File Koreksi (file yang sudah dicoret/direvisi)
    public function uploadKoreksi(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'dosen') abort(403);

        $bimbingan = Bimbingan::findOrFail($id);
        if ($bimbingan->dosen_id != $user->dosen->id) abort(403);

        $request->validate([
            'file_koreksi' => 'required|mimes:pdf,doc,docx|max:10000'
        ]);

        $file     = $request->file('file_koreksi');
        $namaFile = time().'_KOREKSI_'.$bimbingan->mahasiswa->nim.'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $namaFile);

        $bimbingan->update(['file_koreksi' => $namaFile]);

        return back()->with('success', 'File koreksi berhasil diupload dan dikirim ke mahasiswa.');
    }

    // Dosen Memberikan ACC Pintu Kelayakan Ujian
    public function accUjian(Request $request, $skripsi_id)
    {
        $user = Auth::user();
        if ($user->role !== 'dosen') abort(403);

        $request->validate([
            'jenis' => 'required|in:sempro,akhir',
            'status' => 'required|boolean'
        ]);

        $skripsi = Skripsi::findOrFail($skripsi_id);
        
        $isP1 = $skripsi->pembimbing_1_id == $user->dosen->id;
        $isP2 = $skripsi->pembimbing_2_id == $user->dosen->id;
        
        if (!$isP1 && !$isP2) abort(403);

        if ($request->jenis == 'sempro') {
            if ($isP1) $skripsi->acc_sempro_p1 = $request->status;
            if ($isP2) $skripsi->acc_sempro_p2 = $request->status;
        } else {
            if ($isP1) $skripsi->acc_akhir_p1 = $request->status;
            if ($isP2) $skripsi->acc_akhir_p2 = $request->status;
        }

        $skripsi->save();

        return back()->with('success', 'Hak Akses Ujian Mahasiswa berhasil di-'.($request->status ? 'Buka' : 'Cabut').'.');
    }
}