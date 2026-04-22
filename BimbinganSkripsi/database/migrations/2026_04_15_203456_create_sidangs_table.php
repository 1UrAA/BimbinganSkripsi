<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sidangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id');
            $table->string('judul');
            $table->date('tanggal')->nullable();
            $table->time('jam')->nullable();
            $table->foreignId('ruangan_id')->nullable();
            $table->enum('jenis_sidang', ['proposal', 'akhir'])->default('akhir');
            $table->enum('status',['diajukan','terjadwal','selesai','ditolak'])->default('diajukan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sidangs');
    }
};
