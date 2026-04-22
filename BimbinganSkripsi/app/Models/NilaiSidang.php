<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NilaiSidang extends Model
{
    protected $fillable = [
        'sidang_id',
        'dosen_id',
        'nilai',
        'catatan',
        'status' // lulus, revisi
    ];

    public function sidang()
    {
        return $this->belongsTo(Sidang::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}
