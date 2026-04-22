<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = ['user_id','nim','alamat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skripsi()
    {
        return $this->hasOne(Skripsi::class);
    }
}
