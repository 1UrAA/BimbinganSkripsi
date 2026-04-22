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
        Schema::create('pengujis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sidang_id');
            $table->foreignId('dosen_id');
            $table->string('peran');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengujis');
    }
};
