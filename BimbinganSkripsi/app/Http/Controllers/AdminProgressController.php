<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Bimbingan;
use Illuminate\Http\Request;

class AdminProgressController extends Controller
{
    // Daftar semua mahasiswa beserta status progres skripsi
    public function index()
    {
        $mahasiswas = Mahasiswa::with(['user', 'skripsi.pembimbing1.user', 'skripsi.pembimbing2.user'])
                        ->get();

        return view('admin_prodi.progress', compact('mahasiswas'));
    }

    // Detail progres satu mahasiswa: tahapan + jumlah bimbingan
    public function detail($id)
    {
        $mahasiswa = Mahasiswa::with([
            'user',
            'skripsi.pembimbing1.user',
            'skripsi.pembimbing2.user',
        ])->findOrFail($id);

        $bimbingans = Bimbingan::with('dosen.user')
                        ->where('mahasiswa_id', $id)
                        ->orderBy('created_at', 'asc')
                        ->get();

        $totalP1 = $bimbingans->where('tipe_bimbingan', 'pembimbing_1')->count();
        $totalP2 = $bimbingans->where('tipe_bimbingan', 'pembimbing_2')->count();

        return view('admin_prodi.detail_mahasiswa', compact('mahasiswa', 'bimbingans', 'totalP1', 'totalP2'));
    }
}
