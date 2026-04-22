<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sidang extends Model
{
    protected $fillable = [
        'mahasiswa_id',
        'judul',
        'tanggal',
        'jam',
        'ruangan_id',
        'jenis_sidang',
        'status' // diajukan, terjadwal, selesai
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function pengujis()
    {
        return $this->hasMany(Penguji::class);
    }

    public function nilai()
    {
        return $this->hasMany(NilaiSidang::class);
    }
}