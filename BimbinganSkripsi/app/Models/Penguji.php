<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penguji extends Model
{
    protected $fillable = [
        'sidang_id',
        'dosen_id',
        'peran' // penguji_1, penguji_2
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
