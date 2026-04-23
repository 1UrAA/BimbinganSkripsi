<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BimbinganController;
use App\Http\Controllers\SidangController;
use App\Http\Controllers\AdminSidangController;
use App\Http\Controllers\NilaiSidangController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function(){

    Route::get('/dashboard', fn()=>view('dashboard'))->name('dashboard');

    // Bimbingan handled inside role middleware below

    Route::middleware(['role:mahasiswa,dosen'])->group(function () {
        Route::get('/skripsi', [\App\Http\Controllers\SkripsiController::class, 'index'])->name('skripsi.index');
        Route::get('/skripsi/proposal/{id}', [\App\Http\Controllers\SkripsiController::class, 'downloadProposal'])->name('skripsi.proposal');
        Route::post('/skripsi/ajukan-p1', [\App\Http\Controllers\SkripsiController::class, 'ajukanP1'])->name('skripsi.ajukanP1');
        Route::post('/skripsi/respon-p1/{id}', [\App\Http\Controllers\SkripsiController::class, 'responP1'])->name('skripsi.responP1');
        Route::post('/skripsi/ajukan-p2', [\App\Http\Controllers\SkripsiController::class, 'ajukanP2'])->name('skripsi.ajukanP2');
        Route::post('/skripsi/respon-p2/{id}', [\App\Http\Controllers\SkripsiController::class, 'responP2'])->name('skripsi.responP2');
        
        Route::get('/bimbingan', [\App\Http\Controllers\BimbinganController::class, 'index'])->name('bimbingan.index');
        Route::post('/bimbingan', [\App\Http\Controllers\BimbinganController::class, 'store'])->name('bimbingan.store');
        Route::post('/bimbingan/{id}/review', [\App\Http\Controllers\BimbinganController::class, 'review'])->name('bimbingan.review');
        Route::post('/bimbingan/acc/{skripsi_id}', [\App\Http\Controllers\BimbinganController::class, 'accUjian'])->name('bimbingan.acc');
        
        // Sidang Mahasiswa & Dosen
        Route::get('/sidang', [\App\Http\Controllers\SidangController::class, 'index'])->name('sidang.index');
        Route::post('/sidang/daftar', [\App\Http\Controllers\SidangController::class, 'daftarSidang'])->name('sidang.daftar');
        Route::post('/sidang/{id}/evaluasi', [\App\Http\Controllers\SidangController::class, 'evaluasiSidang'])->name('sidang.evaluasi');
    });

    Route::middleware(['role:admin_prodi'])->group(function () {
        Route::resource('mahasiswa', \App\Http\Controllers\MahasiswaController::class);
        Route::resource('dosen', \App\Http\Controllers\DosenController::class);
        
        // Kelola Sidang Admin Prodi
        Route::get('/admin/sidang', [\App\Http\Controllers\SidangController::class, 'index'])->name('admin.sidang.index');
        Route::post('/admin/sidang/ruangan', [\App\Http\Controllers\SidangController::class, 'storeRuangan'])->name('admin.sidang.ruangan');
        Route::post('/admin/sidang/{id}/jadwal', [\App\Http\Controllers\SidangController::class, 'jadwalkanSidang'])->name('admin.sidang.jadwal');
    });

    Route::middleware(['role:superadmin'])->group(function () {
        Route::resource('prodi', \App\Http\Controllers\ProdiController::class);
        Route::resource('akun_admin', \App\Http\Controllers\AkunAdminController::class);
    });

    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';