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
        Schema::table('surat_sosialisasis', function (Blueprint $table) {
            $table->string('hari')->nullable()->after('nama_tempat');
            $table->date('tanggal')->nullable()->after('hari');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_sosialisasis', function (Blueprint $table) {
            $table->dropColumn(['hari', 'tanggal']);
        });
    }
};
