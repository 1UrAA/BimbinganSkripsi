<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Buat Superadmin
        User::create([
            'name' => 'Superadmin Skripsi',
            'email' => 'superadmin@contoh.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // Buat Prodi Dummy
        $prodi = Prodi::create([
            'nama_prodi' => 'Sistem Informasi'
        ]);

        // Buat Admin Prodi
        User::create([
            'name' => 'Admin Prodi SI',
            'email' => 'admin@si.contoh.com',
            'password' => Hash::make('password'),
            'role' => 'admin_prodi',
            'prodi_id' => $prodi->id
        ]);
    }
}
