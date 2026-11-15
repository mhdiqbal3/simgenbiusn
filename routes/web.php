<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
// Import semua Controller
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PoinController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratController;

// 1. Rute untuk meng-install tabel otomatis (Diproteksi: Hanya Admin atau Mode Lokal)
Route::get('/setup-notif', function () {
    if (!app()->environment('local') && (!auth()->check() || auth()->user()->role !== 'admin')) {
        abort(403, 'Akses ditolak: Hanya admin yang dapat menjalankan setup ini.');
    }
    if (!Schema::hasTable('notifikasis')) {
        Schema::create('notifikasis', function ($table) {
            $table->id();
            $table->string('nim');
            $table->text('pesan');
            $table->string('jenis')->default('warning');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
        return "BERHASIL! Tabel Notifikasi sudah dibuat di Database. Silakan kembali ke web.";
    }
    return "Tabel sudah siap.";
});

// 2. Rute untuk fitur "Tandai sudah dibaca"
Route::post('/notifikasi/read', function () {
    // Menyesuaikan dengan kolom yang ada di tabel users (nim atau username)
    $nim = auth()->user()->nim ?? auth()->user()->username;
    DB::table('notifikasis')->where('nim', $nim)->update(['is_read' => true]);
    return back();
})->name('notifikasi.read');

// Rute Profil
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

// ==========================================
// 1. HALAMAN LOGIN & PEMULIHAN (Dilengkapi Rate Limiting untuk Mencegah Brute Force)
// ==========================================
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1')->name('login.proses');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/lupa-password', [AuthController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/lupa-password', [AuthController::class, 'processForgot'])->middleware('throttle:5,1')->name('password.reset');

// Dynamic Sitemap XML
Route::get('/sitemap.xml', function () {
    $baseUrl = url('/');
    $lastMod = date('Y-m-d');
    $content = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    $content .= "  <url>\n    <loc>{$baseUrl}</loc>\n    <lastmod>{$lastMod}</lastmod>\n    <changefreq>daily</changefreq>\n    <priority>1.0</priority>\n  </url>\n";
    $content .= "  <url>\n    <loc>{$baseUrl}/lupa-password</loc>\n    <lastmod>{$lastMod}</lastmod>\n    <changefreq>monthly</changefreq>\n    <priority>0.5</priority>\n  </url>\n";
    $content .= '</urlset>';

    return response($content, 200)->header('Content-Type', 'application/xml');
});

// ==========================================
// 2. HALAMAN DALAM (Wajib Login / Satpam 'auth')
// ==========================================
Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD (Semua yang login bisa akses) ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-info', [App\Http\Controllers\DashboardController::class, 'updateInfo'])->name('dashboard.update_info');
    Route::post('/dashboard/update-poin', [App\Http\Controllers\DashboardController::class, 'updatePoin'])->name('dashboard.update_poin');
    Route::post('/dashboard/upload-dokumentasi', [App\Http\Controllers\DashboardController::class, 'uploadDokumentasi'])->name('dashboard.upload_dokumentasi');
    Route::post('/dashboard/hapus-dokumentasi', [App\Http\Controllers\DashboardController::class, 'hapusDokumentasi'])->name('dashboard.hapus_dokumentasi');
    Route::post('/dashboard/devisi', [\App\Http\Controllers\DashboardController::class, 'storeDevisi'])->name('dashboard.store_devisi');
    Route::put('/dashboard/devisi/{id}', [\App\Http\Controllers\DashboardController::class, 'updateDevisi'])->name('dashboard.update_devisi');
    Route::delete('/dashboard/devisi/{id}', [\App\Http\Controllers\DashboardController::class, 'destroyDevisi'])->name('dashboard.destroy_devisi');
    Route::post('/dashboard/kategori-poin', [\App\Http\Controllers\DashboardController::class, 'storeKategoriPoin'])->name('dashboard.kategori_poin.store');
    Route::put('/dashboard/kategori-poin/{id}', [\App\Http\Controllers\DashboardController::class, 'updateKategoriPoin'])->name('dashboard.kategori_poin.update');
    Route::delete('/dashboard/kategori-poin/{id}', [\App\Http\Controllers\DashboardController::class, 'destroyKategoriPoin'])->name('dashboard.kategori_poin.destroy');

    // --- POIN KEAKTIFAN ---
    // Semua bisa melihat poin
    Route::get('/poin', [PoinController::class, 'index'])->middleware('role:admin,sekretaris,anggota')->name('poin');
    // TAPI HANYA Admin & Sekretaris yang bisa simpan/ubah poin
    Route::post('/poin/update', [PoinController::class, 'updatePoin'])->middleware('role:admin,sekretaris')->name('poin.update');
    Route::post('/poin/edit-keterangan', [App\Http\Controllers\PoinController::class, 'editKeterangan'])->name('poin.edit_keterangan');
    Route::post('/poin/{id}/batal', [PoinController::class, 'batalPoin'])->name('poin.batal');
    Route::match(['post', 'delete'], '/poin/reset-all', [PoinController::class, 'resetAll'])->middleware('role:admin,sekretaris')->name('poin.reset');

    // ==========================================
    // KELOMPOK A: KHUSUS ADMIN & SEKRETARIS
    // ==========================================
    Route::middleware(['role:admin,sekretaris'])->group(function () {

        // Kelola User
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('users.index');
            Route::post('/store', [UserController::class, 'store'])->name('users.store');
            Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        });

        // Absensi
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi');
        Route::post('/absensi/store', [AbsensiController::class, 'store'])->name('absensi.store');
    });

    // ==========================================
    // KELOMPOK B: KHUSUS ADMIN, SEKRETARIS & BENDAHARA
    // ==========================================
    Route::middleware(['role:admin,sekretaris,bendahara'])->group(function () {

        // Kegiatan
        Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan');
        Route::post('/kegiatan/store', [KegiatanController::class, 'store'])->name('kegiatan.store');
        Route::put('/kegiatan/update/{id}', [KegiatanController::class, 'update'])->name('kegiatan.update');
        Route::delete('/kegiatan/hapus/{id}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');
        Route::delete('/kegiatan/reset-all', [KegiatanController::class, 'resetAll'])->name('kegiatan.reset');

        // Laporan Umum
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/cetak-word/{devisi}', [LaporanController::class, 'cetakWord'])->name('laporan.cetakWord');
        Route::get('/laporan/preview/{devisi}', [LaporanController::class, 'preview'])->name('laporan.preview');
        Route::get('/laporan/absensi/{id}', [LaporanController::class, 'cetakAbsensi'])->name('laporan.absensi');
        Route::get('/laporan/poin', [LaporanController::class, 'cetakPoin'])->name('laporan.poin');
        Route::delete('/laporan/hapus', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    });

    // ==========================================
    // KELOMPOK B2: KHUSUS ADMIN & SEKRETARIS (SURAT INTERNAL, EKSTERNAL & KELOLA SOSIALISASI)
    // ==========================================
    Route::middleware(['role:admin,sekretaris'])->group(function () {

        // Surat Internal
        Route::get('/surat-internal', [SuratController::class, 'internal'])->name('surat.internal');
        Route::post('/surat-internal/store', [SuratController::class, 'storeInternal'])->name('surat.internal.store');
        Route::put('/surat-internal/update/{id}', [SuratController::class, 'updateInternal'])->name('surat.internal.update');
        Route::get('/surat-internal/download/{id}', [SuratController::class, 'downloadInternal'])->name('surat.internal.download');
        Route::delete('/surat-internal/hapus/{id}', [SuratController::class, 'destroyInternal'])->name('surat.internal.destroy');
        Route::get('/surat-internal/template/{jenis}', [SuratController::class, 'downloadTemplate'])->name('surat.template.download');

        // Surat Eksternal
        Route::get('/surat-eksternal', [SuratController::class, 'eksternal'])->name('surat.eksternal');
        Route::post('/surat-eksternal/store', [SuratController::class, 'storeEksternal'])->name('surat.eksternal.store');
        Route::get('/surat-eksternal/download/{id}', [SuratController::class, 'downloadEksternal'])->name('surat.eksternal.download');
        Route::get('/surat-eksternal/amplop/{id}', [SuratController::class, 'downloadAmplopEksternal'])->name('surat.eksternal.amplop.download');
        Route::post('/surat-eksternal/amplop/download', [SuratController::class, 'downloadCustomAmplopEksternal'])->name('surat.eksternal.amplop.custom_download');
        Route::get('/surat-eksternal/daftar-hadir/{id}', [SuratController::class, 'downloadDaftarHadirEksternal'])->name('surat.eksternal.daftar_hadir.download');
        Route::post('/surat-eksternal/daftar-hadir/download', [SuratController::class, 'downloadCustomDaftarHadirEksternal'])->name('surat.eksternal.daftar_hadir.custom_download');
        Route::put('/surat-eksternal/update/{id}', [SuratController::class, 'updateEksternal'])->name('surat.eksternal.update');
        Route::delete('/surat-eksternal/hapus/{id}', [SuratController::class, 'destroyEksternal'])->name('surat.eksternal.destroy');
        Route::get('/surat-eksternal/template/{jenis}', [SuratController::class, 'downloadTemplateEksternal'])->name('surat.eksternal.template.download');

        // Kelola Sosialisasi (Tambah, Update, Hapus Surat Sosialisasi)
        Route::post('/sosialisasi/store', [SuratController::class, 'storeSosialisasi'])->name('surat.sosialisasi.store');
        Route::put('/sosialisasi/update/{id}', [SuratController::class, 'updateSosialisasi'])->name('surat.sosialisasi.update');
        Route::delete('/sosialisasi/hapus/{id}', [SuratController::class, 'destroySosialisasi'])->name('surat.sosialisasi.destroy');
    });

    // ==========================================
    // KELOMPOK B3: AKSES SOSIALISASI (ADMIN, SEKRETARIS & ANGGOTA PENUGASAN SOSIALISASI)
    // ==========================================
    Route::middleware(['akses_sosialisasi'])->group(function () {
        Route::get('/sosialisasi', [SuratController::class, 'sosialisasi'])->name('surat.sosialisasi');
        Route::get('/unduh-sosialisasi', function() { return redirect()->route('surat.sosialisasi'); });
        Route::get('/sosialisasi/download/{id}', [SuratController::class, 'downloadSosialisasi'])->name('surat.sosialisasi.download');
        Route::get('/sosialisasi/template', [SuratController::class, 'downloadTemplateSosialisasi'])->name('surat.sosialisasi.template.download');
        Route::get('/sosialisasi/template/{jenis}', [SuratController::class, 'downloadTemplateEksternal'])->name('surat.sosialisasi.template.jenis');
        Route::get('/sosialisasi/amplop/{id}', [SuratController::class, 'downloadAmplopSosialisasi'])->name('surat.sosialisasi.amplop.download');
        Route::post('/sosialisasi/amplop/download', [SuratController::class, 'downloadCustomAmplopEksternal'])->name('surat.sosialisasi.amplop.custom_download');
        Route::post('/sosialisasi/daftar-hadir/download', [SuratController::class, 'downloadCustomDaftarHadirSosialisasi'])->name('surat.sosialisasi.daftar_hadir.custom_download');
        Route::get('/sosialisasi/sertifikat/{id}', [SuratController::class, 'sertifikatSosialisasi'])->name('surat.sosialisasi.sertifikat');
        Route::post('/sosialisasi/sertifikat/custom', [SuratController::class, 'customSertifikatSosialisasi'])->name('surat.sosialisasi.sertifikat.custom');
        Route::post('/sosialisasi/sertifikat/word', [SuratController::class, 'downloadWordSertifikatSosialisasi'])->name('surat.sosialisasi.sertifikat.word');
        Route::get('/sosialisasi/template/sertifikat', [SuratController::class, 'downloadTemplateSertifikatSosialisasi'])->name('surat.sosialisasi.template.sertifikat');
    });

    // ==========================================
    // KELOMPOK C: KHUSUS ADMIN & BENDAHARA
    // ==========================================
    Route::middleware(['role:admin,bendahara'])->group(function () {

        // Anggaran
        Route::get('/rancangan-anggaran', [AnggaranController::class, 'index'])->name('anggaran');
        Route::post('/rancangan-anggaran/store', [AnggaranController::class, 'store'])->name('anggaran.store');
    });
});
// ==========================================
// 3. RUTE VERIFIKASI QR CODE (Bisa diakses tanpa login)
// ==========================================
Route::get('/verifikasi-dokumen', [\App\Http\Controllers\LaporanController::class, 'verifikasiDokumen'])->name('verifikasi.dokumen');
Route::get('/verifikasi-laporan/{jenis}/{id}', [App\Http\Controllers\LaporanController::class, 'verifikasi'])->name('laporan.verifikasi');
