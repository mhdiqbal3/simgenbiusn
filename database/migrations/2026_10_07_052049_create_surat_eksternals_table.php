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
        Schema::create('surat_eksternals', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_surat');
            $table->string('nomor_surat_full');
            $table->string('no_urut')->nullable();
            $table->string('kode_surat')->nullable();
            $table->string('kode_divisi')->nullable();
            $table->string('bulan')->nullable();
            $table->string('tahun')->nullable();
            $table->string('file_template')->nullable();
            
            $table->string('ttd_kepanitiaan')->nullable();
            $table->string('stempel_kepanitiaan')->nullable();
            $table->string('nama_ketua_panitia')->nullable();
            $table->string('nama_sekretaris_panitia')->nullable();
            
            $table->string('nama_anggota')->nullable();
            $table->string('nim_anggota')->nullable();
            $table->string('jurusan_anggota')->nullable();
            $table->string('alasan_sp2')->nullable();
            $table->string('periode_pengurus')->nullable();
            
            $table->string('nama_kegiatan')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->string('hari_tanggal')->nullable();
            $table->string('waktu')->nullable();
            $table->string('nama_tempat')->nullable();
            
            $table->string('tema_kegiatan')->nullable();
            $table->string('nama_alat')->nullable();
            $table->json('barang_jumlah')->nullable();
            
            $table->string('tujuan_kegiatan')->nullable();
            $table->string('nama_materi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_eksternals');
    }
};
