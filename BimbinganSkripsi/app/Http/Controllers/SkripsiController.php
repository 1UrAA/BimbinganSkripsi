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
            $skripsi = Skripsi::with(['pembimbing1.user', 'pembimbing2.user'])->where('mahasiswa_id', $user->mahasiswa->id)->first();
            $dosens = Dosen::whereHas('user', function($q) use ($user) {
                $q->where('prodi_id', $user->prodi_id);
            })->with('user')->get();
            return view('skripsi.mahasiswa', compact('skripsi', 'dosens'));
        }

        if ($user->role === 'dosen') {
            $pengajuan = Skripsi::with(['mahasiswa.user'])->where('pembimbing_2_id', $user->dosen->id)
                                ->where('status_pembimbing_2', 'menunggu')->get();
            return view('skripsi.dosen', compact('pengajuan'));
        }
        
        abort(403);
    }

    public function ajukanP2(Request $request) {
        $user = Auth::user();
        if ($user->role !== 'mahasiswa') abort(403);

        $request->validate([
            'pembimbing_2_id' => 'required|exists:dosens,id'
        ]);

        $skripsi = Skripsi::where('mahasiswa_id', $user->mahasiswa->id)->first();
        if (!$skripsi || !$skripsi->pembimbing_1_id) {
            return back()->with('error', 'Anda belum memiliki Pembimbing 1. Hubungi Admin Prodi terlebih dahulu.');
        }

        if ($skripsi->pembimbing_1_id == $request->pembimbing_2_id) {
            return back()->with('error', 'Dosen Pembimbing 2 tidak boleh sama dengan Pembimbing 1.');
        }

        $skripsi->update([
            'pembimbing_2_id' => $request->pembimbing_2_id,
            'status_pembimbing_2' => 'menunggu'
        ]);

        return back()->with('success', 'Pengajuan Pembimbing 2 berhasil dikirim.');
    }

    public function responP2(Request $request, $id) {
        $user = Auth::user();
        if ($user->role !== 'dosen') abort(403);

        $skripsi = Skripsi::findOrFail($id);
        if ($skripsi->pembimbing_2_id != $user->dosen->id) abort(403);

        $skripsi->update([
            'status_pembimbing_2' => $request->action === 'terima' ? 'diterima' : 'ditolak'
        ]);

        return back()->with('success', 'Berhasil merespon pengajuan mahasiswa.');
    }
}
