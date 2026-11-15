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
        Schema::create('surat_sosialisasis', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_surat')->default('Permohonan Sosialisasi');
            $table->string('nomor_surat_full');
            $table->string('no_urut')->nullable();
            $table->string('kode_surat')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->string('nama_kebijakan')->nullable();
            $table->string('nama_tempat')->nullable();
            $table->string('hari_tanggal')->nullable();
            $table->string('waktu')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->string('file_template')->nullable()->default('surat.sosialisasi.permohonan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_sosialisasis');
    }
};
