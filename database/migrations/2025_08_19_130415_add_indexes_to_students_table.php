<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Menambahkan index pada kolom 'nama' dan 'kelas' untuk mempercepat pencarian
            $table->index('nama');
            $table->index('kelas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Perintah untuk menghapus index jika migrasi di-rollback
            $table->dropIndex(['nama']);
            $table->dropIndex(['kelas']);
        });
    }
};