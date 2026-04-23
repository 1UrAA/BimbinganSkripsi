<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('skripsis', function (Blueprint $table) {
            // Status pengajuan Pembimbing 1 (mirip seperti status_pembimbing_2)
            $table->enum('status_pembimbing_1', ['none', 'menunggu', 'ditolak', 'diterima'])
                  ->default('none')
                  ->after('pembimbing_1_id');
            // File proposal yang dikirim saat mengajukan pembimbing
            $table->string('file_proposal')->nullable()->after('judul');
        });
    }

    public function down(): void {
        Schema::table('skripsis', function (Blueprint $table) {
            $table->dropColumn(['status_pembimbing_1', 'file_proposal']);
        });
    }
};
