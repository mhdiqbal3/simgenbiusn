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
            $table->string('ttd_kepanitiaan')->nullable()->after('kegiatan_st');
            $table->string('stempel_kepanitiaan')->nullable()->after('ttd_kepanitiaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_internals', function (Blueprint $table) {
            $table->dropColumn(['ttd_kepanitiaan', 'stempel_kepanitiaan']);
        });
    }
};
