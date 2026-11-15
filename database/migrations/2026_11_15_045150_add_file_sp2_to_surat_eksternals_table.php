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
        Schema::table('surat_eksternals', function (Blueprint $table) {
            if (!Schema::hasColumn('surat_eksternals', 'file_sp2')) {
                $table->string('file_sp2')->nullable()->after('alasan_sp2');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_eksternals', function (Blueprint $table) {
            if (Schema::hasColumn('surat_eksternals', 'file_sp2')) {
                $table->dropColumn('file_sp2');
            }
        });
    }
};
