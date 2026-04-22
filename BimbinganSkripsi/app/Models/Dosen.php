<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $fillable = ['user_id','nidn','alamat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skripsiSebagaiP1() { return $this->hasMany(Skripsi::class, 'pembimbing_1_id'); }
    public function pengajuanP2() { return $this->hasMany(Skripsi::class, 'pembimbing_2_id'); }
}