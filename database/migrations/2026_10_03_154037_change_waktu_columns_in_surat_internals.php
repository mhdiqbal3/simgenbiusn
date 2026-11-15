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
            $table->string('waktu_kegiatan')->nullable()->change();
            $table->string('waktu_kegiatan_st')->nullable()->change();
            $table->string('no_urut')->nullable()->change();
            $table->string('kode_surat')->nullable()->change();
            $table->string('kode_divisi')->nullable()->change();
            $table->string('bulan')->nullable()->change();
            $table->string('tahun')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('surat_internals', function (Blueprint $table) {
            //
        });
    }
};
