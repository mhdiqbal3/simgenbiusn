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
        Schema::table('surat_internals', function (Blueprint $table) {
            $table->string('nomor_surat')->nullable();
            $table->string('jenis_surat')->nullable(); // Peringatan, Tugas, Undangan
            $table->date('tanggal_surat')->nullable();
            $table->string('perihal')->nullable();
            $table->json('data')->nullable(); // Untuk menyimpan field dinamis seperti nama, jabatan, kegiatan, dll.
            $table->string('file_template')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_internals', function (Blueprint $table) {
            //
        });
    }
};
