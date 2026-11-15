-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 08, 2026 at 10:39 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `genbi`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` bigint UNSIGNED NOT NULL,
  `nim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `devisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `anggarans`
--

CREATE TABLE `anggarans` (
  `id` bigint UNSIGNED NOT NULL,
  `kegiatan_id` bigint UNSIGNED NOT NULL,
  `nama_barang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `jumlah` int NOT NULL,
  `satuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devisis`
--

CREATE TABLE `devisis` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_devisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `warna` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'blue',
  `ikon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `devisis`
--

INSERT INTO `devisis` (`id`, `nama_devisi`, `deskripsi`, `warna`, `ikon`, `created_at`, `updated_at`) VALUES
(1, 'Pengurus Inti', 'Terdiri dari Ketua, Sekretaris, dan Bendahara. Bertanggung jawab atas jalannya roda organisasi, administrasi, sirkulasi keuangan, serta mengambil keputusan strategis komisariat.', 'gray', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3-4h1m-1 4h1m-5 8h8\"></path>', NULL, NULL),
(2, 'Pendidikan & Kebudayaan', 'Berfokus pada peningkatan kapasitas akademik anggota dan masyarakat, serta pelestarian nilai-nilai kebudayaan lokal melalui kegiatan seminar, diskusi, dan pelatihan.', 'blue', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253\"></path>', NULL, NULL),
(3, 'Pengabdian Masyarakat', 'Menjadi jembatan antara GenBI dan masyarakat. Menyelenggarakan kegiatan sosial, bantuan kemanusiaan, dan program pemberdayaan untuk menebar energi positif secara langsung.', 'emerald', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z\"></path>', NULL, NULL),
(4, 'Publikasi Dekorasi & Dokumentasi', 'Divisi Publikasi, Dekorasi & Dokumentasi. Menjadi ujung tombak penyebaran informasi, mengelola media sosial, dan mendokumentasikan setiap momen penting kegiatan GenBI.', 'purple', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z\"></path><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 13a3 3 0 11-6 0 3 3 0 016 0z\"></path>', NULL, '2026-06-09 04:30:00'),
(5, 'Kewirausahaan', 'Menumbuhkan jiwa entrepreneurship anggota. Menggagas ide bisnis kreatif, pencarian dana mandiri (Danus), dan mendorong kemandirian finansial organisasi.', 'orange', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08-.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"></path>', NULL, NULL),
(6, 'Lingkungan Hidup', 'Bergerak di bidang pelestarian alam. Menginisiasi program penghijauan, kampanye sadar sampah, dan menanamkan kepedulian lingkungan kepada anggota maupun masyarakat sekitar.', 'teal', '<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z\"></path>', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `infos`
--

CREATE TABLE `infos` (
  `id` bigint UNSIGNED NOT NULL,
  `visi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `misi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `komitmen` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pelanggaran` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `qris` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `apresiasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sp` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `kriteria_beasiswa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `dokumen_beasiswa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `infos`
--

INSERT INTO `infos` (`id`, `visi`, `misi`, `komitmen`, `pelanggaran`, `qris`, `apresiasi`, `sp`, `kriteria_beasiswa`, `dokumen_beasiswa`, `created_at`, `updated_at`) VALUES
(1, 'Terwujudnya GenBI Komisariat USN Kolaka yang kuat secara internal dan aktif\r\nmembangun hubungan eksternal sebagai Frontliner, Agent of Change, dan Future Leader.', '1. Memperkuat tata kelola internal organisasi secara profesional, disiplin, dan akuntabel.\r\n2. Mengimplementasikan peran Frontliner Bank Indonesia melalui edukasi CBP Rupiah,\r\nliterasi keuangan, dan penguatan ekonomi digital.\r\n3. Mendorong peran Agent of Change melalui program kerja yang inovatif, berdampak,\r\ndan berkelanjutan.\r\n4. Membangun kader sebagai Future Leader melalui peningkatan kapasitas dan\r\npengembangan kompetensi kepemimpinan.\r\n5. Memperluas hubungan eksternal organisasi dengan melakukan kolaborasi strategis\r\nbersama kampus, pemerintah, dan pemangku kepentingan lainnya.', 'GenBI Sultra Komisariat USN Kolaka juga berkomitmen untuk menciptakan\r\nlingkungan yang inklusif dan mendukung bagi anggotanya. Oleh karena itu, rancangan\r\naktivitas juga mencakup kegiatan masyarakat dan kebersamaan yang dapat mempererat ikatan\r\nantaranggota. Hal ini diharapkan dapat menciptakan atmosfer positif di kampus dan\r\nmembantu mahasiswa merasa lebih terhubung dengan rekan- rekan mereka.\r\nDengan merancang aktivitas dan anggaran ini, GenBI Sultra Komisariat USN Kolaka\r\nberharap dapat memberikan kontribusi yang signifikan dalam mencetak generasi mahasiswa\r\nyang aktif, kreatif, dan peduli terhadap lingkungannya serta mampu memberikan dampak\r\npositif bagi masyarakat secara luas.', 'Tidak Hadir Tanpa Laporan : + 10 Poin\r\nTidak Hadir dengan Laporan : + 1 Poin\r\nKetahuan Berbohong : + 50 Poin\r\nMelakukan Hal Negatif yang berdampak Pada Komsat : + 100 Poin', 'Tidak paham CBPR, Qris, PEKA : + 50 Poin\r\nTidak Mengumpulkan Scan Qris : + 8 Poin\r\nKuran Target Sqan Qris : + 4 Poin', 'Rajin: -3 Poin\r\nAktif: -2 Poin', 'SP 1 (Komisariat): 25\r\nSP 2 (Wilayah): 26 - 50\r\nSP 3 (Pembina): >50', 'Mahasiswa aktif dan terdata pada PDDikti.\r\nTelah menyelesaikan min. 40 SKS (berada di semester 4 s/d semester 6) pada Prodi yang ditentukan.\r\nMemiliki IPK minimal 3.00 (skala 4.00).\r\nUsia maksimal 23 tahun (belum genap 24 tahun) saat menerima beasiswa.\r\nMembuat Resume Pribadi (CV).\r\nMembuat Surat Motivasi (termasuk rencana karir setelah lulus).\r\nTidak sedang menerima beasiswa/ikatan dinas dari instansi lain.\r\nMemiliki pengalaman aktivitas sosial yang bermanfaat bagi masyarakat.\r\nBerasal dari keluarga berlatar belakang ekonomi pra sejahtera (kurang mampu).\r\nTidak melanggar norma kampus, sosial, serta bebas pidana & narkoba.\r\nBersedia berperan aktif dalam komunitas GenBI dan tunduk pada seluruh syarat ketentuan program beasiswa Bank Indonesia.', 'Biodata Mahasiswa (sesuai lampiran).\r\nSalinan KTP atau KTM yang masih berlaku.\r\nSalinan Kartu Keluarga (KK).\r\nLembar Kartu Hasil Studi (KHS) 3 semester terakhir.\r\nSurat Keterangan Aktif Kuliah.\r\nResume Pribadi (CV).\r\nMotivation Letter (dalam Bahasa Indonesia).\r\nSurat Rekomendasi dari 1 tokoh (akademik/non-akademik).\r\nSurat Keterangan tidak sedang menerima beasiswa instansi lain.\r\nSurat Keterangan Keluarga Tidak Mampu (dari kelurahan/kecamatan).\r\nSurat Pernyataan kesanggupan aktif di komunitas GenBI.\r\nSalinan buku rekening bank (bagian depan dalam) atas nama mahasiswa.', '2026-06-03 21:04:14', '2026-11-08 00:42:33');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_poins`
--

CREATE TABLE `kategori_poins` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aturan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kegiatans`
--

CREATE TABLE `kegiatans` (
  `id` bigint UNSIGNED NOT NULL,
  `devisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kegiatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pengertian` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tujuan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `manfaat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `waktu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kegiatans`
--

INSERT INTO `kegiatans` (`id`, `devisi`, `nama_kegiatan`, `pengertian`, `tujuan`, `manfaat`, `waktu`, `tanggal`, `tempat`, `created_at`, `updated_at`) VALUES
(1, 'Semua Devisi', 'Rapat Bulanan', NULL, NULL, NULL, '08:00', '2026-10-03', 'CoC', '2026-10-03 04:50:28', '2026-10-03 04:50:28'),
(2, 'Lingkungan Hidup', 'GenBI Berdasi', NULL, NULL, NULL, '08:00', '2026-10-04', 'Popalia', '2026-10-03 06:06:17', '2026-10-03 06:06:17'),
(3, 'Pendidikan & Kebudayaan', 'GenBI Mengajar', NULL, NULL, NULL, '15:00', '2026-10-05', 'Ulu Baula', '2026-10-03 06:06:47', '2026-10-03 06:06:47'),
(4, 'Pengabdian Masyarakat', 'Gensyar Ramadhan', NULL, NULL, NULL, '08:00', '2026-10-07', 'Auditorium', '2026-10-03 17:45:43', '2026-10-03 17:45:43'),
(5, 'Publikasi Dekorasi & Dokumentasi', 'Pelatihan Dokumentasi', NULL, NULL, NULL, '08:00', '2026-10-08', 'Teppoe Kolaka', '2026-10-03 17:46:25', '2026-10-03 17:46:25'),
(6, 'Kewirausahaan', 'GenBI-Mart', NULL, NULL, NULL, '08:00', '2026-10-09', 'Rumah Adat', '2026-10-03 17:47:03', '2026-10-03 17:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `laporans`
--

CREATE TABLE `laporans` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_15_144958_create_kegiatans_table', 1),
(6, '2026_04_15_145017_create_absensis_table', 1),
(7, '2026_04_15_145031_create_poins_table', 1),
(8, '2026_04_15_145050_create_anggarans_table', 1),
(9, '2026_04_15_145110_create_laporans_table', 1),
(10, '2026_04_17_024732_add_role_to_users_table', 1),
(11, '2026_04_17_070729_add_nim_jurusan_to_users_table', 1),
(12, '2026_04_18_033359_add_tujuan_manfaat_to_kegiatans_table', 2),
(13, '2026_05_22_060826_add_request_reset_to_users_table', 3),
(15, '2026_06_04_040014_create_infos_table', 4),
(16, '2026_06_09_110333_create_devisis_table', 5),
(17, '2026_08_25_041426_create_kategori_poins_table', 6),
(18, '2026_10_03_000001_create_surat_internals_table', 7),
(19, '2026_10_03_072206_add_undangan_fields_to_surat_internals', 8),
(20, '2026_10_03_115720_create_surat_internals_table', 9),
(21, '2026_10_03_122558_add_file_template_to_surat_internals', 10),
(22, '2026_10_03_142907_change_tanggal_columns_in_surat_internals', 11),
(23, '2026_10_03_154037_change_waktu_columns_in_surat_internals', 12),
(24, '2026_10_04_050539_add_berkas_sp_to_surat_internals_table', 13),
(25, '2026_10_06_121001_add_izin_columns_to_surat_internals_table', 14),
(26, '2026_10_06_131528_add_kepanitiaan_uploads_to_surat_internals_table', 15),
(27, '2026_10_07_052049_create_surat_eksternals_table', 16),
(28, '2026_10_08_125000_create_surat_sosialisasis_table', 17),
(29, '2026_10_08_165000_add_hari_and_tanggal_to_surat_sosialisasis_table', 18),
(30, '2026_10_08_153020_add_stempel_to_users_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint UNSIGNED NOT NULL,
  `nim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'warning',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifikasis`
--

INSERT INTO `notifikasis` (`id`, `nim`, `pesan`, `jenis`, `is_read`, `created_at`, `updated_at`) VALUES
(1, '2212301132', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Paham CBPR, Qris, PEKA', 'warning', 1, '2026-05-03 03:24:19', '2026-05-03 03:24:19'),
(2, '2212301132', 'Admin memperbarui detail riwayat poin Anda. Keterangan: Absensi (Hadir 100%) | Kegiatan Lain: Lupa Up Scan Qris | Rajin mengikuti kegiatan | Tidak Paham CBPR, Qris, PEKA masa seorang iqbal tidak paham CBPR, Qris Dan PEKA', 'info', 1, '2026-05-03 03:43:42', '2026-05-03 03:43:42'),
(3, '2212301132', 'Admin memperbarui detail riwayat poin Anda. Keterangan: Absensi (Hadir 100%) | Kegiatan Lain: Kegiatan Lain: Lupa Up Scan Qris | Rajin mengikuti kegiatan | Tidak Paham CBPR, Qris, PEKA | masa seorang iqbal tidak paham CBPR, Qris Dan PEKA', 'info', 1, '2026-05-03 21:27:07', '2026-05-03 21:27:07'),
(8, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengikuti Rapat/ Zoom tanpa Konfirmasi = +5 Poin', 'warning', 1, '2026-05-25 05:49:13', '2026-05-25 05:49:13'),
(9, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Lupa Up Scan Qris = +2 Poin', 'warning', 1, '2026-05-25 05:49:34', '2026-05-25 05:49:34'),
(10, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Kurang Target Scan Qris = +4 Poin', 'warning', 1, '2026-05-25 06:02:16', '2026-05-25 06:02:16'),
(11, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak mengumpulkan Scan Qris Bulanan = +8 Poin', 'warning', 1, '2026-05-25 06:12:25', '2026-05-25 06:12:25'),
(12, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengikuti Rapat/ Zoom tanpa Konfirmasi = +5 Poin', 'warning', 1, '2026-05-28 22:38:45', '2026-05-28 22:38:45'),
(13, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Paham CBPR, Qris, PEKA = +50 Poin', 'warning', 0, '2026-05-29 23:24:57', '2026-05-29 23:24:57'),
(14, '221920972', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Melakukan Hal Negatif Yang Berdampak Pada Komisariat = +100 Poin', 'warning', 0, '2026-06-03 21:33:02', '2026-06-03 21:33:02'),
(15, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Rajin = -3 Poin', 'warning', 0, '2026-06-03 21:37:26', '2026-06-03 21:37:26'),
(16, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Aktif = -2 Poin', 'warning', 0, '2026-06-03 21:38:22', '2026-06-03 21:38:22'),
(17, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Hadir Tanpa Laporan (A) = +10 Poin', 'warning', 0, '2026-06-03 21:38:37', '2026-06-03 21:38:37'),
(19, '221920972', 'Admin memperbarui detail riwayat poin Anda.', 'info', 0, '2026-06-04 05:35:37', '2026-06-04 05:35:37'),
(20, '221920972', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Kurang Scan Qris = +4 Poin', 'warning', 0, '2026-06-04 05:44:01', '2026-06-04 05:44:01'),
(21, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengumpulkan Scan Qris = +8 Poin', 'warning', 0, '2026-08-21 00:33:36', '2026-08-21 00:33:36'),
(22, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengumpulkan Scan Qris = +8 Poin', 'warning', 0, '2026-08-21 00:33:58', '2026-08-21 00:33:58'),
(23, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Kuran Target Sqan Qris = +4 Poin', 'warning', 0, '2026-08-21 00:34:07', '2026-08-21 00:34:07'),
(24, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengumpulkan Scan Qris = +8 Poin', 'warning', 0, '2026-08-21 00:36:46', '2026-08-21 00:36:46'),
(25, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak paham CBPR, Qris, PEKA = +50 Poin', 'warning', 0, '2026-08-21 00:37:49', '2026-08-21 00:37:49'),
(26, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Kuran Target Sqan Qris = +4 Poin', 'warning', 0, '2026-08-21 00:38:01', '2026-08-21 00:38:01'),
(27, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: like postingan = +2 Poin', 'warning', 0, '2026-08-24 21:29:36', '2026-08-24 21:29:36'),
(28, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: like postingan = +2 Poin', 'warning', 0, '2026-08-24 21:30:30', '2026-08-24 21:30:30'),
(29, '221130462', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: like postingan = +2 Poin', 'warning', 0, '2026-08-26 23:04:17', '2026-08-26 23:04:17'),
(30, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Rajin = -3 Poin', 'warning', 0, '2026-08-31 06:09:41', '2026-08-31 06:09:41'),
(31, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Kuran Target Sqan Qris = +4 Poin', 'warning', 0, '2026-08-31 06:14:02', '2026-08-31 06:14:02'),
(32, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengumpulkan Scan Qris = +8 Poin', 'warning', 0, '2026-08-31 06:18:03', '2026-08-31 06:18:03'),
(33, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Kuran Target Sqan Qris = +4 Poin', 'warning', 0, '2026-08-31 06:18:14', '2026-08-31 06:18:14'),
(34, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengumpulkan Scan Qris = +8 Poin', 'warning', 0, '2026-08-31 06:18:25', '2026-08-31 06:18:25'),
(35, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Kuran Target Sqan Qris = +4 Poin', 'warning', 0, '2026-08-31 06:18:38', '2026-08-31 06:18:38'),
(36, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Aktif = -2 Poin', 'warning', 0, '2026-08-31 06:18:51', '2026-08-31 06:18:51'),
(37, '221920972', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: tes baru = +2 Poin', 'warning', 0, '2026-09-10 01:02:21', '2026-09-10 01:02:21'),
(38, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak paham CBPR, Qris, PEKA = +50 Poin', 'warning', 0, '2026-10-03 06:07:43', '2026-10-03 06:07:43'),
(52, '221920972', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tes = -4 Poin', 'warning', 0, '2026-10-03 17:52:47', '2026-10-03 17:52:47'),
(53, '221130462', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Aktif = -2 Poin', 'warning', 0, '2026-10-03 17:52:57', '2026-10-03 17:52:57'),
(54, '241220615', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak paham CBPR, Qris, PEKA = +50 Poin', 'warning', 0, '2026-10-03 20:05:24', '2026-10-03 20:05:24'),
(55, '241220615', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Ayam = -50 Poin', 'warning', 0, '2026-10-06 22:36:41', '2026-10-06 22:36:41'),
(56, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Ayam = -50 Poin', 'warning', 0, '2026-10-06 22:37:02', '2026-10-06 22:37:02'),
(57, '221220630', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Kuran Target Sqan Qris = +4 Poin', 'warning', 0, '2026-10-06 22:37:14', '2026-10-06 22:37:14'),
(60, '231830982', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak paham CBPR, Qris, PEKA = +50 Poin', 'warning', 0, '2026-10-06 22:37:54', '2026-10-06 22:37:54'),
(61, '231820921', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak paham CBPR, Qris, PEKA = +50 Poin', 'warning', 0, '2026-10-08 04:35:40', '2026-10-08 04:35:40'),
(62, '231820921', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak paham CBPR, Qris, PEKA = +50 Poin', 'warning', 0, '2026-10-08 04:35:53', '2026-10-08 04:35:53'),
(63, '242331193', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengumpulkan Scan Qris = +8 Poin', 'warning', 0, '2026-11-07 00:43:10', '2026-11-07 00:43:10'),
(64, '242331193', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengumpulkan Scan Qris = +8 Poin', 'warning', 0, '2026-11-07 00:43:29', '2026-11-07 00:43:29'),
(65, '242331193', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak Mengumpulkan Scan Qris = +8 Poin', 'warning', 0, '2026-11-07 00:43:37', '2026-11-07 00:43:37'),
(66, '242331193', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tes = +2 Poin', 'warning', 0, '2026-11-07 00:43:55', '2026-11-07 00:43:55'),
(67, '242331193', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidur = -1 Poin', 'warning', 0, '2026-11-07 00:44:04', '2026-11-07 00:44:04'),
(68, '231810907', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Tidak paham CBPR, Qris, PEKA = +50 Poin', 'warning', 0, '2026-11-07 00:44:15', '2026-11-07 00:44:15'),
(69, '240320106', 'Ada pembaruan pada Poin Keaktifan / SP Anda. Keterangan: Melakukan Hal Negatif yang berdampak Pada Komsat = +100 Poin', 'warning', 0, '2026-11-07 00:44:27', '2026-11-07 00:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poins`
--

CREATE TABLE `poins` (
  `id` bigint UNSIGNED NOT NULL,
  `nim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `devisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_poin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `sp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Aman',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poins`
--

INSERT INTO `poins` (`id`, `nim`, `nama_lengkap`, `jurusan`, `devisi`, `total_poin`, `sp`, `keterangan`, `created_at`, `updated_at`) VALUES
(19, '221920972', 'Nurhalifah', 'Manajemen', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(21, '221220630', 'Ari Wibowo', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(27, '231830982', 'Muh Rifqi Apriansyah', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(28, '242331193', 'Dinda Wulandari', 'Ekonomi Pembagunan', NULL, '25', 'SP 1', 'Tidak Mengumpulkan Scan Qris = +8 Poin | Tidak Mengumpulkan Scan Qris = +8 Poin | Tidak Mengumpulkan Scan Qris = +8 Poin | Tes = +2 Poin | Tidur = -1 Poin', '2026-05-11 18:35:16', '2026-11-07 00:44:04'),
(29, '231810907', 'Nabila', 'Akuntansi', NULL, '50', 'SP 2', 'Tidak paham CBPR, Qris, PEKA = +50 Poin', '2026-05-11 18:35:16', '2026-11-07 00:44:16'),
(30, '240320106', 'Mudma Inna', 'Pendidikan Matematika', NULL, '100', 'SP 3', 'Melakukan Hal Negatif yang berdampak Pada Komsat = +100 Poin', '2026-05-11 18:35:16', '2026-11-07 00:44:28'),
(31, '240510141', 'Devi', 'Agribisnis', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(32, '241830947', 'Aliya Ma\'rifat Putri Nur', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(33, '221130470', 'Yulianda', 'Hukum', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(34, '240511400', 'Indra Yasa', 'Agribisnis', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(36, '241921017', 'Aisyah Aprilia Sari', 'Manajemen', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(38, '241810891', 'Warda', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(39, '241820924', 'Tina', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(40, '241220615', 'Safaldi', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(43, '231820939', 'Herda', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(44, '221120436', 'Yani Apriyani', 'Hukum', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(45, '241820910', 'Sela Marsida', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(46, '241820921', 'Muhammad Hamiludin', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(47, '240310103', 'Putri Meilani', 'Pendidikan Matematika', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(48, '232218402', 'Muhammad Ilham', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(49, '241810884', 'Rifana', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(52, '221220616', 'Wahida Jafar', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(53, '221130507', 'Rut Afrina Perzenya Sitorus', 'Hukum', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(55, '221220645', 'Astrid', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(56, '241230683', 'Dimas R', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(57, '241820903', 'Reza Ardita Bahtiar', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(58, '240330110', 'Ni Luh Sujayanti', 'Pendidikan Matematika', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(59, '231830956', 'Muh Agus Salim', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(60, '231030372', 'Nurmagfira', 'Administrasi Publik', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(61, '231030386', 'Nurul Mawaddah', 'Administrasi Publik', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(62, '231820921', 'Rivaldi', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(64, '230930302', 'Dirga', 'Teknik Pertambangan', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(65, '231820940', 'Septa Pryatno', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(67, '241220632', 'Meilan Faulana', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(68, '231831475', 'Shakila Revadianti Pracilia', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(69, '241931063', 'Imun', 'Manajemen', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(70, '242231139', 'Jumarni', 'Ilmu Komputer', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(72, '241220626', 'Pandi Wiranto', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-05-11 18:35:16', '2026-11-06 22:13:07'),
(74, '241130488', 'Agung Pramadana', 'Hukum', NULL, '0', 'Aman', '-', '2026-10-06 18:15:11', '2026-11-06 22:13:07'),
(75, '241830949', 'Azzalia Alifiah Syahira Suherman', 'Akuntansi', NULL, '0', 'Aman', '-', '2026-10-06 18:15:11', '2026-11-06 22:13:07'),
(76, '240310102', 'Elsa Savira Putri', 'Pendidikan Matematika', NULL, '0', 'Aman', '-', '2026-10-06 22:35:06', '2026-11-06 22:13:07'),
(77, '241120478', 'Andi Ibrahim', 'Hukum', NULL, '0', 'Aman', '-', '2026-10-06 22:35:07', '2026-11-06 22:13:07'),
(78, '252211300', 'Khaerunnisa', 'Ilmu Komputer', NULL, '0', 'Aman', '-', '2026-10-06 22:35:07', '2026-11-06 22:13:07'),
(79, '250330583', 'Muh. Idrus', 'Pendidikan Matematika', NULL, '0', 'Aman', '-', '2026-10-06 22:35:07', '2026-11-06 22:13:07'),
(80, '250330593', 'Andi Zaizafun Alfianti Salzabil', 'Pendidikan Matematika', NULL, '0', 'Aman', '-', '2026-10-06 22:35:07', '2026-11-06 22:13:07'),
(81, '250330569', 'Nur Azizah Salwa', 'Pendidikan Matematika', NULL, '0', 'Aman', '-', '2026-10-06 22:35:07', '2026-11-06 22:13:07'),
(82, '251221006', 'Alisa Syahyarani', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-10-06 22:35:07', '2026-11-06 22:13:07'),
(83, '251221014', 'Asfirah Nasar', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-10-06 22:35:07', '2026-11-06 22:13:07'),
(84, '251010809', 'Hasmawati', 'Administrasi Publik', NULL, '0', 'Aman', '-', '2026-10-06 22:35:07', '2026-11-06 22:13:07'),
(85, '242231159', 'Afni Melati', 'Ilmu Komputer', NULL, '0', 'Aman', '-', '2026-11-07 00:39:58', '2026-11-07 00:39:58'),
(86, '251931246', 'Andi Afdal', 'Manajemen', NULL, '0', 'Aman', '-', '2026-11-07 00:39:58', '2026-11-07 00:39:58'),
(87, '251210986', 'Arti Besse Uleng', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-11-07 00:39:58', '2026-11-07 00:39:58'),
(88, '241210601', 'Komang Sri Ayu Lestari', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-11-07 00:39:58', '2026-11-07 00:39:58'),
(89, '251221011', 'Israwan Ryan Saputra', 'Sistem Informasi', NULL, '0', 'Aman', '-', '2026-11-07 00:39:58', '2026-11-07 00:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `surat_eksternals`
--

CREATE TABLE `surat_eksternals` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat_full` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_urut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_divisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ttd_kepanitiaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stempel_kepanitiaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ketua_panitia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_sekretaris_panitia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_anggota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nim_anggota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan_anggota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alasan_sp2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `periode_pengurus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hari_tanggal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_tempat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tema_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_alat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barang_jumlah` json DEFAULT NULL,
  `tujuan_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_materi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_eksternals`
--

INSERT INTO `surat_eksternals` (`id`, `jenis_surat`, `nomor_surat_full`, `no_urut`, `kode_surat`, `kode_divisi`, `bulan`, `tahun`, `file_template`, `ttd_kepanitiaan`, `stempel_kepanitiaan`, `nama_ketua_panitia`, `nama_sekretaris_panitia`, `nama_anggota`, `nim_anggota`, `jurusan_anggota`, `alasan_sp2`, `periode_pengurus`, `nama_kegiatan`, `tempat_kegiatan`, `hari_tanggal`, `waktu`, `nama_tempat`, `tema_kegiatan`, `nama_alat`, `barang_jumlah`, `tujuan_kegiatan`, `nama_materi`, `created_at`, `updated_at`) VALUES
(16, 'SP-3', '001/B/SP3/GENBI-KOMS-USN/XI/2026', '001', 'SP3', NULL, NULL, NULL, 'surat.eksternal.sp3', NULL, NULL, NULL, NULL, 'Mudma Inna', '240320106', 'Pendidikan Matematika', 'Nomor: 002/SP-2/GENBI-SULTRA/XI/2026 tanggal 7 November 2026', '2025/2026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, NULL, '2026-11-07 03:33:52', '2026-11-07 03:33:52'),
(17, 'Permohonan', '002/B/PERM/GENBI-KOMS-USN/XI/2026', '002', 'PERM', NULL, NULL, NULL, 'surat.eksternal.permohonan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'GenBI-Mart', 'Auditorium', 'Senin, 9 Oktober 2026', '08.00', 'Rektor USN Kolaka', NULL, NULL, '[]', NULL, NULL, '2026-11-07 03:37:31', '2026-11-07 03:37:31'),
(19, 'Peminjaman', '003/B/PJM/GENBI-KOMS-USN/XI/2026', '003', 'PJM', NULL, NULL, NULL, 'surat.eksternal.peminjaman', NULL, NULL, 'Arti Besse Uleng', 'Asfirah Nasar', NULL, NULL, NULL, NULL, NULL, 'GenBI-Mart', 'Rumah Adat', 'Jumat, 9 Oktober 2026', '08.00', 'Rektor USN Kolaka', 'Memperdaya UMKM', 'Auditorium', '[{\"nama\": \"Videotron\", \"jumlah\": \"1 Unit\"}]', NULL, NULL, '2026-11-07 03:56:32', '2026-11-07 03:56:32'),
(20, 'Undangan Eksternal', '004/B/UND/GENBI-KOMS-USN/XI/2026', '004', 'UND', NULL, NULL, NULL, 'surat.eksternal.undangan', NULL, NULL, 'Arti Besse Uleng', 'Asfirah Nasar', NULL, NULL, NULL, NULL, NULL, 'GenBI-Mart', 'Rumah Adat', 'Jumat, 9 Oktober 2026', '08.00', 'Rektor USN Kolaka', 'Memperdaya UMKM', NULL, '[]', 'Meningkatkan UMKM', NULL, '2026-11-07 04:00:45', '2026-11-07 04:00:45'),
(21, 'Undangan Narasumber', '005/B/UND/GENBI-KOMS-USN/XI/2026', '005', 'UND', NULL, NULL, NULL, 'surat.eksternal.undangan_narasumber', NULL, NULL, 'Arti Besse Uleng', 'Asfirah Nasar', NULL, NULL, NULL, NULL, NULL, 'GenBI-Mart', 'Rumah Adat', 'Jumat, 9 Oktober 2026', '08.00', 'Dosen', 'Memperdaya UMKM', NULL, '[]', 'Meningkatkan UMKM', 'memperdaya UMKM', '2026-11-07 04:10:02', '2026-11-07 04:10:02'),
(22, 'Kerjasama', '006/B/KER/GENBI-KOMS-USN/XI/2026', '006', 'KER', NULL, NULL, NULL, 'surat.eksternal.kerjasama', NULL, NULL, 'Arti Besse Uleng', 'Asfirah Nasar', NULL, NULL, NULL, NULL, NULL, 'GenBI-Mart', 'Rumah Adat', 'Jumat, 9 Oktober 2026', '08.00', 'Rektor USN Kolaka', 'Memperdaya UMKM', NULL, '[]', 'Meningkatkan UMKM', NULL, '2026-11-07 04:13:34', '2026-11-07 04:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `surat_internals`
--

CREATE TABLE `surat_internals` (
  `id` bigint UNSIGNED NOT NULL,
  `no_urut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_divisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_surat_full` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `berkas_sp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anggota_sp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisi_sp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_undangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_ketua_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `anggota_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `divisi_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kegiatan_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ttd_kepanitiaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stempel_kepanitiaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tema_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_kegiatan_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_kegiatan_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_kegiatan_st` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `file_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_undangan_izin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kepada_izin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kegiatan_izin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_anggota_izin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_kegiatan_izin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu_kegiatan_izin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_kegiatan_izin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_internals`
--

INSERT INTO `surat_internals` (`id`, `no_urut`, `kode_surat`, `jenis_surat`, `kode_divisi`, `bulan`, `tahun`, `nomor_surat_full`, `nama_sp`, `berkas_sp`, `anggota_sp`, `divisi_sp`, `nama_undangan`, `tanggal_kegiatan`, `waktu_kegiatan`, `tempat_kegiatan`, `nama_ketua_st`, `anggota_st`, `jabatan_st`, `divisi_st`, `kegiatan_st`, `ttd_kepanitiaan`, `stempel_kepanitiaan`, `tema_st`, `tanggal_kegiatan_st`, `waktu_kegiatan_st`, `tempat_kegiatan_st`, `created_at`, `updated_at`, `file_template`, `nama_undangan_izin`, `kepada_izin`, `nama_kegiatan_izin`, `status_anggota_izin`, `tanggal_kegiatan_izin`, `waktu_kegiatan_izin`, `tempat_kegiatan_izin`) VALUES
(53, '001', 'A', 'Surat Peringatan', 'SP-1', 'XI', '2026', '001/SP-1/GENBI-KOMS-USN/XI/2026', 'Pertama (SP 1)', NULL, 'Dinda Wulandari', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-07 02:33:17', '2026-11-07 02:33:17', 'surat.internal.peringatan', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, '002', 'A', 'Surat Peringatan', 'SP-2', 'XI', '2026', '002/SP-2/GENBI-SULTRA/XI/2026', 'Kedua (SP 2)', 'uploads/berkas_sp/1794047691_DRAF JUKNIS SURAT USN.docx.pdf', 'Nabila', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-07 02:34:51', '2026-11-07 02:34:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, '003', 'A', 'Surat Undangan', 'UND', 'XI', '2026', '003/A/UND/GENBI-KOMS-USN/XI/2026', NULL, NULL, NULL, NULL, 'GenBI-Mart', 'Jumat, 9 Oktober 2026', '08.00', 'Rumah Adat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-11-07 02:35:49', '2026-11-07 02:35:49', 'surat.internal.undangan', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, '004', 'A', 'Surat Tugas', 'TGS', 'XI', '2026', '004/A/TGS/GENBI-KOMS-USN/XI/2026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Arti Besse Uleng', 'Ketua Panitia', 'Kewirausahaan', 'GenBI-Mart', 'uploads/kepanitiaan/1794047863_ttd.jpg', NULL, 'Memperdaya UMKM', 'Jumat, 9 Oktober 2026', '08.00', 'Rumah Adat', '2026-11-07 02:37:43', '2026-11-07 02:37:43', 'surat.internal.tugas', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, '005', 'A', 'Surat Tugas', 'TGS', 'XI', '2026', '005/A/TGS/GENBI-KOMS-USN/XI/2026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Asfirah Nasar', 'Sekretaris Panitia', 'Kewirausahaan', 'GenBI-Mart', 'uploads/kepanitiaan/1794047911_ttd.PNG', 'uploads/kepanitiaan/1794047911_stempel.png', 'Memperdaya UMKM', 'Jumat, 9 Oktober 2026', '08.00', 'Rumah Adat', '2026-11-07 02:38:31', '2026-11-07 02:38:31', 'surat.internal.tugas', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, '006', 'A', 'Surat Tugas Sosialisasi', 'TS', 'XI', '2026', '006/A/TS/GENBI-KOMS-USN/XI/2026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Aisyah Aprilia Sari', 'Ketua Kelompok', 'Pengabdian Masyarakat', 'Kelompok 1', NULL, NULL, 'CBPR QRIS PeKA', NULL, NULL, NULL, '2026-11-07 02:39:41', '2026-11-07 02:39:41', 'surat.internal.tugas_sosialisasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, '007', 'A', 'Surat Tugas Sosialisasi', 'TS', 'XI', '2026', '007/A/TS/GENBI-KOMS-USN/XI/2026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Aliya Ma\'rifat Putri Nur', 'Sekretaris Kelompok', 'Publikasi Dekorasi & Dokumentasi', 'Kelompok 1', NULL, NULL, 'CBPR QRIS PeKA', NULL, NULL, NULL, '2026-11-07 02:41:14', '2026-11-07 02:41:14', 'surat.internal.tugas_sosialisasi', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat_sosialisasis`
--

CREATE TABLE `surat_sosialisasis` (
  `id` bigint UNSIGNED NOT NULL,
  `jenis_surat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Permohonan Sosialisasi',
  `nomor_surat_full` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_urut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_kebijakan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_tempat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `hari_tanggal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_kegiatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_template` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'surat.sosialisasi.permohonan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_sosialisasis`
--

INSERT INTO `surat_sosialisasis` (`id`, `jenis_surat`, `nomor_surat_full`, `no_urut`, `kode_surat`, `bulan`, `tahun`, `nama_kebijakan`, `nama_tempat`, `hari`, `tanggal`, `hari_tanggal`, `waktu`, `tempat_kegiatan`, `file_template`, `created_at`, `updated_at`) VALUES
(4, 'Permohonan Sosialisasi', '001/B/PERM/GENBI-KOMS-USN/XI/2026', '001', 'PERM', 'XI', '2026', 'CBPR QRIS PeKA', 'Kepala Sekolah SMA Negeri A', 'Senin', '2026-11-02', 'Senin, 2 November 2026', '08.00', 'SMA Negeri A', 'surat.sosialisasi.permohonan', '2026-11-07 04:14:38', '2026-11-07 04:14:38'),
(5, 'Permohonan Sosialisasi', '002/B/PERM/GENBI-KOMS-USN/XI/2026', '002', 'PERM', 'XI', '2026', 'CBPR', 'Kepala Sekolah SMA Negeri B', 'Senin', '2026-11-09', 'Senin, 9 November 2026', '08.00', 'SMA Negeri B', 'surat.sosialisasi.permohonan', '2026-11-07 05:32:16', '2026-11-07 06:06:30'),
(6, 'Permohonan Sosialisasi', '003/B/PERM/GENBI-KOMS-USN/XI/2026', '003', 'PERM', 'XI', '2026', 'CBPR', 'Kepala Sekolah SMA Negeri C', 'Selasa', '2026-11-10', 'Selasa, 10 November 2026', '08.00', 'SMA Negeri C', 'surat.sosialisasi.permohonan', '2026-11-07 07:27:48', '2026-11-07 07:27:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_reset` tinyint(1) NOT NULL DEFAULT '0',
  `role` enum('admin','sekretaris','bendahara','anggota') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anggota',
  `nim` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `devisi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ttd` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stempel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `otp` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `request_reset`, `role`, `nim`, `jurusan`, `devisi`, `jabatan`, `photo`, `ttd`, `stempel`, `remember_token`, `created_at`, `updated_at`, `otp`, `otp_expires_at`) VALUES
(1, 'Agung Pramadana', 'agung@gmail.com', NULL, '$2y$12$tQVDzRB2d//dwS.xRlYFTe/7qZ2bS3oXOyyonVfPe/XqJwbPi73aK', 0, 'admin', '241130488', 'Hukum', NULL, NULL, 'profiles/Bzpw1u99mc3DpWOvRFvealXLjzhV7xbqgFenEopB.png', 'ttd/yMUXRbwRbKQ9usnUI0raTBjOGalEZYwLjjLfLtMd.jpg', 'stempel/yxYMT5LG7dykOrJUppuqAtuszbD2BnnigYxKZ4Ii.png', NULL, '2026-04-17 18:49:04', '2026-11-08 00:44:30', '147945', '2026-08-21 09:05:36'),
(2, 'Elsa Savira Putri', 'elsa@gmail.com', NULL, '$2y$12$6z9BUDE1nAejbYzrUzErc.s7iashg1dRTjKCgxwzQ4H1Z9Tep7ePS', 0, 'sekretaris', '240310102', 'Pendidikan Matematika', NULL, NULL, 'profiles/BPG1fEQ4v4gAwZOKMAjnAHjzQGB3n2WkOhQwyD7z.jpg', 'ttd/R9dg5LdMJapoGa0KSnHpFyrSVG9FFrgDoON4KLZ4.jpg', NULL, NULL, '2026-04-17 18:49:04', '2026-11-08 02:36:28', NULL, NULL),
(3, 'Ari Wibowo', 'ari@gmail.com', NULL, '$2y$12$YJjy58C325tdWuMI4gMPLuiW5ZDz6IZxMvL5FwyPIhWtdOXMjjSo2', 0, 'anggota', '221220630', 'Sistem Informasi', 'Lingkungan Hidup', NULL, 'profiles/VWZcawyvJcokNAQd3z2Gyq086TrB9pMXRMZDohGC.jpg', NULL, NULL, NULL, '2026-04-17 18:52:44', '2026-11-07 19:21:36', NULL, NULL),
(9, 'Azzalia Alifiah Syahira Suherman', 'azzalia@gmail.com', NULL, '$2y$12$vjvRhQAATmaw6xtgDpYIl.NgsBEUWSKtbRKxBxniyw3adjgiLom9a', 0, 'bendahara', '241830949', 'Akuntansi', NULL, NULL, 'profiles/tY3okiGr4lC21HTvXSdbXAidzGs83uJ9bpP2LlHT.jpg', NULL, NULL, NULL, '2026-04-24 23:03:22', '2026-11-07 19:21:09', NULL, NULL),
(18, 'Muh Rifqi Apriansyah', 'rifqi@gmail.com', NULL, '$2y$12$vIZwGc1EBjj3J3d7.1b1IeQTu.h1o8rqLOaBQvmawwpA7Zb/.8dtq', 0, 'anggota', '231830982', 'Akuntansi', 'Pendidikan & Kebudayaan', 'Ketua Devisi Pendidikan & Kebudayaan', 'profiles/uEnpzTDxJTcsuGOvlKk7XJOsFpzB3B4ahrDpUd3d.jpg', NULL, NULL, NULL, '2026-05-11 17:52:51', '2026-11-07 19:20:42', NULL, NULL),
(19, 'Dinda Wulandari', 'dinda@gmail.com', NULL, '$2y$12$jE/xN8pvzbsazs/dIlJbBOkRNP8qpRST8oORxRt.jazMGLzGxFFKy', 0, 'anggota', '242331193', 'Ekonomi Pembagunan', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 17:54:00', '2026-11-07 19:20:19', NULL, NULL),
(20, 'Nabila', 'nabila@gmail.com', NULL, '$2y$12$Grekt2xvuhoal/l8mH6OuuMU//bm5HDrdlN306bApS2tmlhkFbjpi', 0, 'anggota', '231810907', 'Akuntansi', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 17:54:44', '2026-11-07 19:20:01', NULL, NULL),
(21, 'Mudma Inna', 'mudma@gmail.com', NULL, '$2y$12$tv700ckpRQ8s2CLrWMzSrefOo89mmIm/5Qj75Fbesyk0hAusVxzWO', 0, 'anggota', '240320106', 'Pendidikan Matematika', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 17:55:35', '2026-11-07 19:19:33', NULL, NULL),
(22, 'Devi', 'devi@gmail.com', NULL, '$2y$12$mQQPdQa/WgO4YZjN6N3/7.xB5kQvonHFYO9VZ0TFIIcWJYax86P56', 0, 'anggota', '240510141', 'Agribisnis', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 17:56:47', '2026-11-07 19:19:09', NULL, NULL),
(23, 'Aaliya Ma\'rifat Putri Nur', 'aliya@gmail.com', NULL, '$2y$12$BiO7VRX2n2MyHnGZO6Y7Fu.4J0UVTzjveb8kwhu/dzOlDB6KI/o6K', 0, 'anggota', '241830947', 'Akuntansi', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-05-11 17:58:15', '2026-11-07 19:18:46', NULL, NULL),
(24, 'Yulianda', 'yuli@gmail.com', NULL, '$2y$12$Jw/YKHW6Y1F2dMNPd5LqTOfTUIcvEqCOyrEFXMS0Ox9suEXrwkT7a', 0, 'anggota', '221130470', 'Hukum', 'Pengabdian Masyarakat', NULL, NULL, NULL, NULL, NULL, '2026-05-11 17:59:02', '2026-11-07 19:18:15', NULL, NULL),
(25, 'Indra Yasa', 'indra@gmail.com', NULL, '$2y$12$LNK2lPsNKsKPfEX7gE/zh.A/QLXe3kl6sUlL.XMQSzBrDG/..Wyaq', 0, 'anggota', '240511400', 'Agribisnis', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-05-11 17:59:50', '2026-11-07 19:17:50', NULL, NULL),
(27, 'Aisyah Aprilia Sari', 'aisyah@gmail.com', NULL, '$2y$12$ND.oxAYbp.tH8mZj0bnBVu9aHpbAxqUIVMmcYvc.Y1peTt5KVIV/a', 0, 'anggota', '241921017', 'Manajemen', 'Pengabdian Masyarakat', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:02:24', '2026-11-07 18:58:32', NULL, NULL),
(29, 'Warda', 'warda@gmail.com', NULL, '$2y$12$JHyVzEacav1SPxJlaWrldOY9tdU3vjC4.SMi0QWso9Z9O8AewKDFW', 0, 'anggota', '241810891', 'Akuntansi', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:03:51', '2026-11-07 19:17:25', NULL, NULL),
(30, 'Tina', 'tina@gmail.com', NULL, '$2y$12$oNye1l8wO9LVVD/RbZWyQugt2OGgJjeD6JTMj0nSEzhE.FrILWbWG', 0, 'anggota', '241820924', 'Akuntansi', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:04:29', '2026-11-07 19:17:04', NULL, NULL),
(31, 'Safaldi', 'safaldi@gmail.com', NULL, '$2y$12$Hu4QPiaSrgC7QZ1AjQrPmesAhfgOM/7nmIKG2TIi7J4Fqr9pNFxWy', 0, 'anggota', '241220615', 'Sistem Informasi', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:05:03', '2026-11-07 19:16:41', NULL, NULL),
(34, 'Herda', 'herda@gmail.com', NULL, '$2y$12$/7MvvvD4UU.NBJF.qWxjRO5ALp/mGaiV.m0czXYOxgF/nUyQTL13q', 0, 'anggota', '231820939', 'Akuntansi', 'Pengabdian Masyarakat', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:06:55', '2026-11-07 19:16:20', NULL, NULL),
(35, 'Yani Apriyani', 'yani@gmail.com', NULL, '$2y$12$y7er262jgn7hVDQV88zL6uGU/ejhI30rT.ISImHUuO1W8lcoTYIO6', 0, 'anggota', '221120436', 'Hukum', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:07:40', '2026-11-07 19:15:58', NULL, NULL),
(36, 'Sela Marsida', 'sela@gmail.com', NULL, '$2y$12$KzxoE7.NjecyWDur6bCNqeQBlYIC9EktyTb8bjJ5rJ5533DR133vG', 0, 'anggota', '241820910', 'Akuntansi', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:08:15', '2026-11-07 19:15:34', NULL, NULL),
(37, 'Muhammad Hamiludin', 'udin@gmail.com', NULL, '$2y$12$0y3nPozrmViv4j7W4ZhAduVfk.SJAuOxkHimS.pn.09bBGAuL.9.2', 0, 'anggota', '241820921', 'Akuntansi', 'Pendidikan & Kebudayaan', 'Ketua Devisi Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, '2026-05-11 18:08:55', '2026-11-07 19:15:13', NULL, NULL),
(38, 'Putri Meilani', 'putri@gmail.com', NULL, '$2y$12$x/Ch.iXfN4aDnvoAT/L20edyA02PZMMegd71uJNn7KXW16CVCxRyS', 0, 'anggota', '240310103', 'Pendidikan Matematika', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:09:43', '2026-11-07 19:14:50', NULL, NULL),
(39, 'Muhammad Ilham', 'ilham@gmail.com', NULL, '$2y$12$XWHN3GOO7hvJi6CvtloKv.jTZcf3uxN4zHnd.u4oHACzoNTdoSGE2', 0, 'anggota', '232218402', 'Akuntansi', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:10:20', '2026-11-07 19:14:21', NULL, NULL),
(40, 'Rifana', 'rifana@gmail.com', NULL, '$2y$12$k3jC3fxTLuur0.dpoiI5Oei8zoU0kYv6oOJ4rrr6jK8mGXiUP0C9K', 0, 'anggota', '241810884', 'Akuntansi', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:10:53', '2026-11-07 19:13:55', NULL, NULL),
(43, 'Wahida Jafar', 'wahida@gmail.com', NULL, '$2y$12$H502TqO7pSYSznx7f8iKpOUKlt74wOx.9tB5TUXlWIqjnJFKi3d8q', 0, 'anggota', '221220616', 'Sistem Informasi', 'Pengabdian Masyarakat', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:13:11', '2026-11-07 19:13:33', NULL, NULL),
(44, 'Rut Afrina Perzenya Sitorus', 'rut@gmail.com', NULL, '$2y$12$abnMxnjpuzCpoz4RN4dQu.BDX5Zvr9vmdcFjQK/MVc5HQeWonl2zu', 0, 'anggota', '221130507', 'Hukum', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:14:23', '2026-11-07 19:13:14', NULL, NULL),
(46, 'Astrid', 'astrid@gmail.com', NULL, '$2y$12$jAhJdFvFx3OyZpWHG2Qsv.4YdcxGzkArWO9Dfj5TDpE8O4vW4ep42', 0, 'anggota', '221220645', 'Sistem Informasi', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:15:32', '2026-11-07 19:12:53', NULL, NULL),
(47, 'Dimas R', 'dimas@gmail.com', NULL, '$2y$12$YsGMvrqr8708CdaA/rU8W.dbh5uA2RVLRiOrO02k2LNRSpDRiG.56', 0, 'anggota', '241230683', 'Sistem Informasi', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:16:07', '2026-11-07 19:12:31', NULL, NULL),
(48, 'Rezah Ardita Bahtiar', 'reza@gmail.com', NULL, '$2y$12$u4j7ZktmsorxJo40Gt0qhOsJwgwB4MPSdmzDoNB0n3EVLyCDSc27S', 0, 'anggota', '241820903', 'Akuntansi', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:16:54', '2026-11-07 19:12:09', NULL, NULL),
(49, 'Ni Luh Sujayanti', 'niluh@gmail.com', NULL, '$2y$12$JO6i0wdWGrT7gkoQdAf/MedKhsSYQH0zj2vNTdVSmD6odNHTSKvK6', 0, 'anggota', '240330110', 'Pendidikan Matematika', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:17:50', '2026-11-07 19:11:50', NULL, NULL),
(50, 'Muh Agus Salim', 'agus@gmail.com', NULL, '$2y$12$M9bzew4wuZHbSfvA2mJmT.vfRVb8zPEnGVfLvUSo.KrBpQUfjreIK', 0, 'anggota', '231830956', 'Akuntansi', 'Lingkungan Hidup', 'Ketua Devisi Lingkungan Hidup', NULL, NULL, NULL, NULL, '2026-05-11 18:18:19', '2026-11-07 19:11:30', NULL, NULL),
(51, 'Nurmagfira', 'magfira@gmail.com', NULL, '$2y$12$Ones6hZw1JcBa9z0n8sWp.cTj3n1zU9W2nmTKPNgYmG0tUlYZ9wdu', 0, 'anggota', '231030372', 'Administrasi Publik', 'Kewirausahaan', 'Ketua Devisi Kewirausahaan', NULL, NULL, NULL, NULL, '2026-05-11 18:19:37', '2026-11-07 19:11:11', NULL, NULL),
(52, 'Nurul Mawaddah', 'nurul@gmail.com', NULL, '$2y$12$Zj/96BDNFgqJvb.hE47Jpulqi4EIAS5vGw6N1o00P1IKQKXk6EB2e', 0, 'anggota', '231030386', 'Administrasi Publik', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:20:30', '2026-11-07 19:10:41', NULL, NULL),
(53, 'Rivaldi', 'rivaldi@gmail.com', NULL, '$2y$12$YpRjNkwWVyutWzieUNMJqetecnAu8MDXbmOdIYCtEgTDU3hRb7ZWm', 0, 'anggota', '231820921', 'Akuntansi', 'Pengabdian Masyarakat', 'Ketua Devisi Pengabdian Masyarakat', NULL, NULL, NULL, NULL, '2026-05-11 18:21:02', '2026-11-07 19:10:12', NULL, NULL),
(55, 'Dirga', 'dirga@gmail.com', NULL, '$2y$12$twukylEglL.MhHEF9NvOYOcgpjwqL81EJ3n4J/JtrS1Dj7gLUSVBq', 0, 'anggota', '230930302', 'Teknik Pertambangan', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:22:43', '2026-11-07 19:09:52', NULL, NULL),
(56, 'Septa Pryatno', 'septa@gmail.com', NULL, '$2y$12$qL3fMY7eMwDgNPjoGVdfse.DpKQE0CkTdMeAZwtdIEJz13RFCrSja', 0, 'anggota', '231820940', 'Akuntansi', 'Publikasi Dekorasi & Dokumentasi', 'Ketua Devisi Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, '2026-05-11 18:23:26', '2026-11-07 19:09:23', NULL, NULL),
(58, 'Melan Faulana', 'melan@gmail.com', NULL, '$2y$12$ItFtiuHpnG1rtp5rJSnIuuE6htlULCOs55IINCF7DZXuDTf6Im2ii', 0, 'anggota', '241220632', 'Sistem Informasi', 'Lingkungan Hidup', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:25:16', '2026-11-07 19:09:04', NULL, NULL),
(59, 'Shakila Revadianti Pracilia', 'shakila@gmail.com', NULL, '$2y$12$XzEvQ3wtB5ztnQoDxrFxGOWAoQfwwPey2BDqd8G4CIE15GSi3UzoC', 0, 'anggota', '231831475', 'Akuntansi', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:26:13', '2026-11-07 19:08:42', NULL, NULL),
(60, 'Imun', 'imun@gmail.com', NULL, '$2y$12$Da5akAYPGdtDCicC1SYOauwd0VAFbhD3njUvTwOVEiitAp126Ckk6', 0, 'anggota', '241931063', 'Manajemen', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:27:00', '2026-11-07 19:08:06', NULL, NULL),
(61, 'Jumarni', 'jumarni@gmail.com', NULL, '$2y$12$lGRhqp.A0fYeaWcLvoidIuFe.47kEsQguBmlvxu2OGi7PuWZXefPa', 0, 'anggota', '242231139', 'Ilmu Komputer', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:27:37', '2026-11-07 19:07:40', NULL, NULL),
(63, 'Pandi Wiranto', 'pandi@gmail.com', NULL, '$2y$12$2Q2hCXzdaXxZJ2gj1oAyVugVMYoSwWdVadXG/DXbW9vMw4AxOAS3i', 0, 'anggota', '241220626', 'Sistem Informasi', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-05-11 18:28:45', '2026-11-07 19:07:19', NULL, NULL),
(67, 'Nurhalifah', 'halifah@gmail.com', NULL, '$2y$12$fkuj8DMP9ktepmJxiGNF5O/XsK9aq2zdeNYuEHuIUTq/T0wem8.Wm', 0, 'anggota', '221920972', 'Manajemen', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-10-06 17:47:16', '2026-11-07 19:06:59', NULL, NULL),
(68, 'Andi Ibrahim', 'ibrahim@gmail.com', NULL, '$2y$12$rMsahZpncsov9B6vcMatgOR.n/cib5o7ZOLoci232zX8zxH1xXSUm', 0, 'anggota', '241120478', 'Hukum', 'Pengabdian Masyarakat', NULL, NULL, NULL, NULL, NULL, '2026-10-06 18:31:44', '2026-11-07 19:06:35', NULL, NULL),
(74, 'Khaerunnisa', 'khaerunnisa@gmail.com', NULL, '$2y$12$6B3nKhTdClsSNy8/W3ERbu9LxUg8uhb5n7wbfTNDSJdo4PkV3EKcK', 0, 'anggota', '252211300', 'Ilmu Komputer', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-10-06 18:42:43', '2026-11-07 19:06:14', NULL, NULL),
(77, 'Muh. Idrus', 'idrus@gmail.com', NULL, '$2y$12$VnOebOriTzA1KCvrLzWMDuD4Ob/Tx/KeZTa9EFjCqh0112K.0rfV2', 0, 'anggota', '250330583', 'Pendidikan Matematika', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-10-06 18:55:07', '2026-11-07 19:05:46', NULL, NULL),
(78, 'Andi Zaizafun Alfianti Salzabil', 'zaiza@gmail.com', NULL, '$2y$12$31MGgGUWdExOf2UtlMuXKebfz8OIN.scXWz6fyM02BoRsawf/6pTS', 0, 'anggota', '250330593', 'Pendidikan Matematika', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-10-06 18:58:24', '2026-11-07 19:05:26', NULL, NULL),
(79, 'Nur Azizah Salwa', 'wawa@gmail.com', NULL, '$2y$12$V1uTtwB/rTIvJ5i/OfqP/.7IMEpVA/wuqUWUBuKj4PZyceN.FIt5m', 0, 'anggota', '250330569', 'Pendidikan Matematika', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-10-06 18:59:11', '2026-11-07 19:05:10', NULL, NULL),
(80, 'Alisa Syahyarani', 'alisa@gmail.com', NULL, '$2y$12$qfVEOok7R7wIfShXwYwQPOEnP90U7Wn4H9/l6.5sx5pQWJOVCri5G', 0, 'anggota', '251221006', 'Sistem Informasi', 'Pengabdian Masyarakat', NULL, NULL, NULL, NULL, NULL, '2026-10-06 19:03:10', '2026-11-07 19:04:49', NULL, NULL),
(81, 'Asfirah Nasar', 'asfirah@gmail.com', NULL, '$2y$12$gGSMJhakNIOetTAI6i/FpOPRvhMnXbbeR9bkRxlAuZW75saxHVi5G', 0, 'anggota', '251221014', 'Sistem Informasi', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-10-06 19:06:51', '2026-11-07 19:04:34', NULL, NULL),
(82, 'Hasmawati', 'hasmawati@gmail.com', NULL, '$2y$12$fWZivtuyHx4SZoCEfak53emiBECAtJKFxfg.vnvYmrPC9nFf4n0aa', 0, 'anggota', '251010809', 'Administrasi Publik', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-10-06 19:08:25', '2026-11-07 19:03:50', NULL, NULL),
(83, 'Afni Melati', 'afni@gmail.com', NULL, '$2y$12$2w3Nr1qZ1.GKn5Cl6I7Eje8GeZpzQMme9grLnD/jgjoU3Rj4n7/dy', 0, 'anggota', '242231159', 'Ilmu Komputer', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-11-07 00:20:50', '2026-11-07 19:03:16', NULL, NULL),
(84, 'Andi Afdal', 'afdal@gmail.com', NULL, '$2y$12$mmSOjqtEuLD5hOpqlXBGP.XtGegNtD/xPGfl0ij4kpbn2rdGwScq.', 0, 'anggota', '251931246', 'Manajemen', 'Pendidikan & Kebudayaan', NULL, NULL, NULL, NULL, NULL, '2026-11-07 00:28:37', '2026-11-07 19:02:59', NULL, NULL),
(85, 'Arti Besse Uleng', 'arti@gmail.com', NULL, '$2y$12$2T9CDnRIATDWNH594nicluD5Aj95/D0nleQ5d4QaRTKIkzZIytvIy', 0, 'anggota', '251210986', 'Sistem Informasi', 'Kewirausahaan', NULL, NULL, NULL, NULL, NULL, '2026-11-07 00:30:47', '2026-11-07 19:02:33', NULL, NULL),
(86, 'Komang Sri Ayu Lestari', 'sri@gmail.com', NULL, '$2y$12$3XtkIR55Xt6XJTTuaKXvfuGLbWTlKWDBWqp4ug9WFTBELdtMeSZuS', 0, 'anggota', '241210601', 'Sistem Informasi', 'Pengabdian Masyarakat', NULL, NULL, NULL, NULL, NULL, '2026-11-07 00:31:57', '2026-11-07 19:03:31', NULL, NULL),
(87, 'Israwan Ryan Saputra', 'israwan@gmail.com', NULL, '$2y$12$vafzwmwXcKx5g36PXYOxJulw2yJQhx4WbpxiSkj6oa44NmOUneN1O', 0, 'anggota', '251221011', 'Sistem Informasi', 'Publikasi Dekorasi & Dokumentasi', NULL, NULL, NULL, NULL, NULL, '2026-11-07 00:33:13', '2026-11-07 19:01:21', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `anggarans`
--
ALTER TABLE `anggarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggarans_kegiatan_id_foreign` (`kegiatan_id`);

--
-- Indexes for table `devisis`
--
ALTER TABLE `devisis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `infos`
--
ALTER TABLE `infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_poins`
--
ALTER TABLE `kategori_poins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kegiatans`
--
ALTER TABLE `kegiatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporans`
--
ALTER TABLE `laporans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `poins`
--
ALTER TABLE `poins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_eksternals`
--
ALTER TABLE `surat_eksternals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_internals`
--
ALTER TABLE `surat_internals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_sosialisasis`
--
ALTER TABLE `surat_sosialisasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nim_unique` (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anggarans`
--
ALTER TABLE `anggarans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devisis`
--
ALTER TABLE `devisis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infos`
--
ALTER TABLE `infos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori_poins`
--
ALTER TABLE `kategori_poins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kegiatans`
--
ALTER TABLE `kegiatans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `laporans`
--
ALTER TABLE `laporans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poins`
--
ALTER TABLE `poins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `surat_eksternals`
--
ALTER TABLE `surat_eksternals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `surat_internals`
--
ALTER TABLE `surat_internals`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `surat_sosialisasis`
--
ALTER TABLE `surat_sosialisasis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggarans`
--
ALTER TABLE `anggarans`
  ADD CONSTRAINT `anggarans_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
