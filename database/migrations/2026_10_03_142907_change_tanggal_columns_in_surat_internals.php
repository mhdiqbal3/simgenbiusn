<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_internals', function (Blueprint $table) {
            $table->string('tanggal_kegiatan')->nullable()->change();
            $table->string('tanggal_kegiatan_st')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('surat_internals', function (Blueprint $table) {
            $table->date('tanggal_kegiatan')->nullable()->change();
            $table->date('tanggal_kegiatan_st')->nullable()->change();
        });
    }
};
