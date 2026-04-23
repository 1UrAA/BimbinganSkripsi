<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    protected $table = 'skripsis';
    protected $fillable = [
        'mahasiswa_id', 'judul', 'file_proposal',
        'pembimbing_1_id', 'status_pembimbing_1',
        'pembimbing_2_id', 'status_pembimbing_2',
        'acc_sempro_p1', 'acc_sempro_p2', 'acc_akhir_p1', 'acc_akhir_p2'
    ];

    public function mahasiswa() { return $this->belongsTo(Mahasiswa::class); }
    public function pembimbing1() { return $this->belongsTo(Dosen::class, 'pembimbing_1_id'); }
    public function pembimbing2() { return $this->belongsTo(Dosen::class, 'pembimbing_2_id'); }
}
