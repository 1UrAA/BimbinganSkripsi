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
        Schema::create('nilai_sidangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sidang_id');
            $table->foreignId('dosen_id');
            $table->integer('nilai');
            $table->text('catatan')->nullable();
            $table->enum('status',['lulus','revisi','mengulang']);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_sidangs');
    }
};
