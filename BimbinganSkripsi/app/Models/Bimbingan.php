<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'tipe_bimbingan',
        'file',
        'komentar',
        'status'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}