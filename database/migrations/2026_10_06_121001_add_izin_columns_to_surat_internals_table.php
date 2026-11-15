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
            $table->string('nama_undangan_izin')->nullable();
            $table->string('kepada_izin')->nullable();
            $table->string('nama_kegiatan_izin')->nullable();
            $table->string('status_anggota_izin')->nullable();
            $table->string('tanggal_kegiatan_izin')->nullable();
            $table->string('waktu_kegiatan_izin')->nullable();
            $table->string('tempat_kegiatan_izin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_internals', function (Blueprint $table) {
            $table->dropColumn([
                'nama_undangan_izin',
                'kepada_izin',
                'nama_kegiatan_izin',
                'status_anggota_izin',
                'tanggal_kegiatan_izin',
                'waktu_kegiatan_izin',
                'tempat_kegiatan_izin'
            ]);
        });
    }
};
