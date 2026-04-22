<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NilaiSidang;

class NilaiSidangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sidang_id' => 'required|exists:sidangs,id',
            'nilai' => 'required|integer|min:0|max:100',
            'status' => 'required|in:lulus,revisi'
        ]);

        NilaiSidang::create([
            'sidang_id' => $request->sidang_id,
            'dosen_id' => Auth::id(),
            'nilai' => $request->nilai,
            'catatan' => $request->catatan,
            'status' => $request->status
        ]);

        return back()->with('success', 'Nilai berhasil disimpan');
    }
}