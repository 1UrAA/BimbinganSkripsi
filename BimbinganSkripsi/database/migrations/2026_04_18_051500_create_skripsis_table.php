<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('skripsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->string('judul')->nullable();
            $table->foreignId('pembimbing_1_id')->nullable()->constrained('dosens')->nullOnDelete();
            $table->foreignId('pembimbing_2_id')->nullable()->constrained('dosens')->nullOnDelete();
            $table->enum('status_pembimbing_2', ['none', 'menunggu', 'ditolak', 'diterima'])->default('none');
            
            // ACC Gates for Milestones
            $table->boolean('acc_sempro_p1')->default(false);
            $table->boolean('acc_sempro_p2')->default(false);
            $table->boolean('acc_akhir_p1')->default(false);
            $table->boolean('acc_akhir_p2')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('skripsis');
    }
};
