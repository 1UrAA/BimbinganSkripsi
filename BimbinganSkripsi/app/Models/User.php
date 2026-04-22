<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'prodi_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function bimbingans(){
        return $this->hasMany(Bimbingan::class, 'mahasiswa_id');
    }

    public function sidangs(){
        return $this->hasMany(Sidang::class, 'mahasiswa_id');
    }

    public function pengujis(){
        return $this->hasMany(Penguji::class, 'dosen_id');
    }

    public function nilaiSidangs(){
        return $this->hasMany(NilaiSidang::class, 'dosen_id');
    }

    public function prodi(){
        return $this->belongsTo(Prodi::class);
    }

    public function mahasiswa(){
        return $this->hasOne(Mahasiswa::class);
    }

    public function dosen(){
        return $this->hasOne(Dosen::class);
    }
}
