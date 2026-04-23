<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skripsi;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;

class SkripsiController extends Controller
{
    public function index() {
        $user = Auth::user();

        if ($user->role === 'mahasiswa') {
            $skripsi = Skripsi::with(['pembimbing1.user', 'pembimbing2.user'])
                              ->where('mahasiswa_id', $user->mahasiswa->id)
                              ->first();
            // Ambil semua dosen (tanpa filter prodi, karena sekarang bebas)
            $dosens = Dosen::with('user')->get();
            return view('skripsi.mahasiswa', compact('skripsi', 'dosens'));
        }

        if ($user->role === 'dosen') {
            // Semua pengajuan P1 yang masuk ke dosen ini (menunggu)
            $pengajuanP1 = Skripsi::with(['mahasiswa.user'])
                ->where('pembimbing_1_id', $user->dosen->id)
                ->where('status_pembimbing_1', 'menunggu')
                ->get();

            // Semua pengajuan P2 yang masuk ke dosen ini (menunggu)
            $pengajuanP2 = Skripsi::with(['mahasiswa.user'])
                ->where('pembimbing_2_id', $user->dosen->id)
                ->where('status_pembimbing_2', 'menunggu')
                ->get();

            return view('skripsi.dosen', compact('pengajuanP1', 'pengajuanP2'));
        }

        abort(403);
    }

    // Mahasiswa Ajukan Pembimbing 1 (sekarang mahasiswa yg pilih)
    public function ajukanP1(Request $request) {
        $user = Auth::user();
        if ($user->role !== 'mahasiswa') abort(403);

        $request->validate([
            'judul'          => 'required|string|max:500',
            'pembimbing_1_id'=> 'required|exists:dosens,id',
            'file_proposal'  => 'required|mimes:pdf,doc,docx|max:10000',
        ]);

        $mahasiswa = $user->mahasiswa;
        $skripsi   = Skripsi::where('mahasiswa_id', $mahasiswa->id)->first();

        // Jangan ajukan ulang jika sudah menunggu / diterima
        if ($skripsi && in_array($skripsi->status_pembimbing_1, ['menunggu', 'diterima'])) {
            return back()->with('error', 'Pengajuan Pembimbing 1 sudah ada atau sudah diterima.');
        }

        // Upload file proposal
        $file    = $request->file('file_proposal');
        $namaFile = time().'_PROPOSAL_'.$mahasiswa->nim.'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $namaFile);

        if ($skripsi) {
            $skripsi->update([
                'judul'            => $request->judul,
                'file_proposal'    => $namaFile,
                'pembimbing_1_id'  => $request->pembimbing_1_id,
                'status_pembimbing_1' => 'menunggu',
                // Reset P2 jika P1 berubah
                'pembimbing_2_id'  => null,
                'status_pembimbing_2' => 'none',
            ]);
        } else {
            Skripsi::create([
                'mahasiswa_id'        => $mahasiswa->id,
                'judul'               => $request->judul,
                'file_proposal'       => $namaFile,
                'pembimbing_1_id'     => $request->pembimbing_1_id,
                'status_pembimbing_1' => 'menunggu',
            ]);
        }

        return back()->with('success', 'Pengajuan Pembimbing 1 berhasil dikirim. Menunggu persetujuan dosen.');
    }

    // Mahasiswa Ajukan Pembimbing 2
    public function ajukanP2(Request $request) {
        $user = Auth::user();
        if ($user->role !== 'mahasiswa') abort(403);

        $request->validate([
            'judul'           => 'required|string|max:500',
            'pembimbing_2_id' => 'required|exists:dosens,id',
            'file_proposal'   => 'nullable|mimes:pdf,doc,docx|max:10000',
        ]);

        $skripsi = Skripsi::where('mahasiswa_id', $user->mahasiswa->id)->first();

        if (!$skripsi || $skripsi->status_pembimbing_1 !== 'diterima') {
            return back()->with('error', 'Pembimbing 1 harus sudah menerima pengajuan sebelum mengajukan Pembimbing 2.');
        }

        if ($skripsi->pembimbing_1_id == $request->pembimbing_2_id) {
            return back()->with('error', 'Dosen Pembimbing 2 tidak boleh sama dengan Pembimbing 1.');
        }

        if (in_array($skripsi->status_pembimbing_2, ['menunggu', 'diterima'])) {
            return back()->with('error', 'Pengajuan Pembimbing 2 sudah ada atau sudah diterima.');
        }

        $updateData = [
            'judul'               => $request->judul,
            'pembimbing_2_id'     => $request->pembimbing_2_id,
            'status_pembimbing_2' => 'menunggu',
        ];

        // Update file proposal jika ada upload baru
        if ($request->hasFile('file_proposal')) {
            $file     = $request->file('file_proposal');
            $namaFile = time().'_PROPOSAL2_'.$user->mahasiswa->nim.'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $namaFile);
            $updateData['file_proposal'] = $namaFile;
        }

        $skripsi->update($updateData);

        return back()->with('success', 'Pengajuan Pembimbing 2 berhasil dikirim. Menunggu persetujuan dosen.');
    }

    // Download Proposal dengan nama file yang benar
    public function downloadProposal($id) {
        $skripsi  = Skripsi::with('mahasiswa')->findOrFail($id);
        $filePath = public_path('uploads/' . $skripsi->file_proposal);

        if (!$skripsi->file_proposal || !file_exists($filePath)) {
            return back()->with('error', 'File proposal tidak ditemukan.');
        }

        // Tentukan ekstensi dari nama file yang tersimpan
        $ext          = pathinfo($skripsi->file_proposal, PATHINFO_EXTENSION);
        $namaUnduh    = 'Proposal_' . ($skripsi->mahasiswa->nim ?? 'mahasiswa') . ($ext ? '.'.$ext : '.docx');

        return response()->download($filePath, $namaUnduh);
    }

    // Dosen Merespon Pengajuan Pembimbing 1
    public function responP1(Request $request, $id) {
        $user = Auth::user();
        if ($user->role !== 'dosen') abort(403);

        $skripsi = Skripsi::findOrFail($id);
        if ($skripsi->pembimbing_1_id != $user->dosen->id) abort(403);

        $skripsi->update([
            'status_pembimbing_1' => $request->action === 'terima' ? 'diterima' : 'ditolak'
        ]);

        $pesan = $request->action === 'terima' ? 'Anda telah menjadi Pembimbing 1 mahasiswa ini.' : 'Pengajuan Pembimbing 1 telah ditolak.';
        return back()->with('success', $pesan);
    }

    // Dosen Merespon Pengajuan Pembimbing 2
    public function responP2(Request $request, $id) {
        $user = Auth::user();
        if ($user->role !== 'dosen') abort(403);

        $skripsi = Skripsi::findOrFail($id);
        if ($skripsi->pembimbing_2_id != $user->dosen->id) abort(403);

        $skripsi->update([
            'status_pembimbing_2' => $request->action === 'terima' ? 'diterima' : 'ditolak'
        ]);

        $pesan = $request->action === 'terima' ? 'Anda telah menjadi Pembimbing 2 mahasiswa ini.' : 'Pengajuan Pembimbing 2 telah ditolak.';
        return back()->with('success', $pesan);
    }
}
