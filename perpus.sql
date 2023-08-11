-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Bulan Mei 2021 pada 05.33
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel-26`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$Gkl0ebt2cEdc2S6iOdbtWuKrb6seXGDpe/yGsHG3t.PyU6jN/E.aO', 'default.jpg', '2021-05-07 01:10:11', '2021-05-07 01:10:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `klasifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku_siswa`
--

CREATE TABLE `buku_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buku_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenggat` date NOT NULL,
  `dikembalikan` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(10, 'A', '2021-03-30 10:00:23', '2021-03-30 10:00:23'),
(11, 'B', '2021-03-30 10:00:33', '2021-03-30 10:00:33'),
(12, 'C', '2021-03-30 10:00:41', '2021-03-30 10:00:41'),
(13, 'D', '2021-03-30 10:00:50', '2021-03-30 10:00:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kunjungan`
--

CREATE TABLE `kunjungan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `klasifikasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel_siswa`
--

CREATE TABLE `mapel_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mapel_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `siswa_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenggat` date NOT NULL,
  `dikembalikan` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(103, '2019_08_19_000000_create_failed_jobs_table', 1),
(104, '2021_02_09_224214_create_kategori_table', 1),
(105, '2021_03_02_095804_create_buku_table', 1),
(106, '2021_03_02_095922_create_siswa_table', 1),
(107, '2021_03_02_100539_create_tingkat_table', 1),
(108, '2021_03_02_100547_create_kelas_table', 1),
(109, '2021_03_02_100701_create_buku_siswa_table', 1),
(110, '2021_03_02_100854_create_operasi_table', 1),
(111, '2021_03_24_102243_create_admin_table', 1),
(112, '2021_03_25_165915_create_kunjungan_table', 1),
(113, '2021_04_12_061721_create_mapel_table', 1),
(114, '2021_04_12_063707_create_mapel_siswa_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `operasi`
--

CREATE TABLE `operasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `denda_per_hari` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `operasi`
--

INSERT INTO `operasi` (`id`, `denda_per_hari`, `created_at`, `updated_at`) VALUES
(1, 500, '2021-05-07 01:10:11', '2021-05-07 01:10:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` int(11) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `tingkat_id`, `kelas_id`, `password`, `created_at`, `updated_at`) VALUES
(1, 202107001, 'AAN', 1, 10, '12345678', '2021-03-30 10:01:51', '2021-03-30 10:01:51'),
(175, 202107003, 'ADE DADIH MUHARAM', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(176, 202107008, 'AJENG KARTINI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(177, 202107010, 'ALDI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(178, 202107011, 'ALDIANSYAH', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(179, 202107016, 'ANDIKA RAHMAT  FEBRIAN', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(180, 202107017, 'ANDRI MAULANA', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(181, 202107024, 'DANI RAMDANI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(182, 202107026, 'DIAN', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(183, 202107028, 'EVA SITI KHOFIFAH', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(184, 202107032, 'HENNI HANDAYANI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(185, 202107043, 'KALIM RAMADANI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(186, 202107044, 'LISTIA MAULIDA DAMAYANTI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(187, 202107045, 'LUTFI AJIS NUGRAHA', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(188, 202107047, 'MIFTAH PAUZAN', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(189, 202107051, 'MUHAMAD SURYA ALFARIZI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(190, 202107055, 'NAJLIA HAMIDAH', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(191, 202107057, 'NOVI  ISTIQOMAH', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(192, 202107058, 'NURMALASARI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(193, 202107061, 'PIPIT PITRIANI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(194, 202107066, 'RAMA APRILIANA', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(195, 202107070, 'RIZKI RAMDANI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(196, 202107077, 'SEILA MONICA SARI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(197, 202107078, 'SHALSA ATRIANA', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(198, 202107079, 'SHIVANI LUTHFIA OKTAVIANI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(199, 202107080, 'SIFA ROSIDAH FAUZIAH', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(200, 202107082, 'SITI AAS AISAH', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(201, 202107083, 'SITI NURAENI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(202, 202107084, 'TAUFIK NURUL HIDAYAH', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(203, 202107088, 'VINA RAMADHANI', 1, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(204, 202107002, 'ABRIEL PRATAMA', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(205, 202107005, 'AGUS FERDIANSYAH', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(206, 202107012, 'ALEX  SETIAWAN', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(207, 202107013, 'ALYA ZAHRA', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(208, 202107019, 'ARIYA  IRAWAN', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(209, 202107020, 'ASEP LUTFI AHSANUL HAMDI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(210, 202107022, 'ASRI YANI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(211, 202107023, 'BAYU BAROKAH', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(212, 202107027, 'ERNA MARLINA', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(213, 202107033, 'HILMAN SAEPUL ROHMAN', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(214, 202107036, 'INA FEBRIANTI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(215, 202107037, 'IQBAL BUKHORI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(216, 202107041, 'JAJANG JAMALUDIN', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(217, 202107042, 'JULIA AGUSTINA', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(218, 202107048, 'MUHAMAD ANDIK P', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(219, 202107053, 'NABILA FAUZIAH LATHIFAH', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(220, 202107054, 'NADIA NURDIANTI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(221, 202107056, 'NINA NURAENI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(222, 202107059, 'PAJAR AZMI ANUGRAHA', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(223, 202107060, 'PARIDA NURHASANAH', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(224, 202107067, 'RESAN RUDIANA', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(225, 202107071, 'RIMA APRILIANI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(226, 202107076, 'SASKIA KIRANA RAMADANI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(227, 202107081, 'SILVIA CAHYADI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(228, 202107089, 'VIRA SEPTIANI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(229, 202107090, 'WINA NURSARI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(230, 202107092, 'YANI SOPYANI', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(231, 202107093, 'YANTI MAESAROH', 1, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(232, 202107004, 'ADITYA RAY', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(233, 202107006, 'AHMAD RIJQI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(234, 202107009, 'AJENG NURJANAH', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(235, 202107014, 'AMANDA APRILIYANTI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(236, 202107015, 'AMELIA', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(237, 202107018, 'ARIS SALIM ABDULAH', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(238, 202107021, 'ASEP MUHIDIN', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(239, 202107025, 'DESY NURPAJRIANI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(240, 202107029, 'FIRDAUSA DWI PUTRIA', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(241, 202107031, 'HANIFAH SITI NURPAUJIAH', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(242, 202107034, 'IKA', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(243, 202107035, 'ILHAM FATHIRRIANSYAH', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(244, 202107038, 'IRFAN HILMI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(245, 202107040, 'IRHAM MUHAMMAD DHAFIEN', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(246, 202107046, 'MAWAR SITI MAULIDHA', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(247, 202107050, 'MUHAMAD PAJAR PEBRIANA', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(248, 202107052, 'MUHAMMAD RIZQI SAPUTRA', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(249, 202107062, 'PUPUT PUTRIANI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(250, 202107063, 'PUTRI PUSPASARI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(251, 202107064, 'RAINA INAYATUL HUDA', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(252, 202107065, 'RAISYA NURHASANAH', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(253, 123456789, 'RASYA SETIANI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(254, 202107072, 'RIPALDI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(255, 202107074, 'RIZKY FADILAH', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(256, 202107075, 'SAHRUL JUNIAWAN', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(257, 202107085, 'TENDI SUTENDI', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(258, 202107087, 'URIP', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(259, 202107091, 'YANA AHMAD SAHID', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(260, 202107094, 'YUDA ARIF RAHMAN', 1, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(261, 192007004, 'Ade siti Rohmah', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(262, 192007010, 'Andini Wulandari', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(263, 192007040, 'Anisa', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(264, 192007015, 'Anisa Siti Rohmah', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(265, 987654321, 'Devia Lis Sulastri', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(266, 192007020, 'Diana Widianingsih', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(267, 192007021, 'Dimas Nugraha', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(268, 192007025, 'Gilang Adia Pratama', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(269, 192007006, 'Gugun Gunawan', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(270, 192007026, 'Hendra Gunawan', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(271, 192007031, 'Hilmi Fauzi', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(272, 192007039, 'Lisna Listiana', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(273, 192007042, 'Muhamad Haris', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(274, 102007046, 'Niva Astari', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(275, 192007048, 'Parid Mutiana', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(276, 192007052, 'Rifki Ramdani', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(277, 192007054, 'Rizki Mulyana', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(278, 102007056, 'Septiana Ramadhan', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(279, 192007061, 'Siti nuraidah', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(280, 192007062, 'Sri Ai Nurjanah', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(281, 192007063, 'Surya Saputra', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(282, 192007067, 'Tia Ta\'dilulhaq', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(283, 192007068, 'Wahyu Ahmad fikri', 2, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(284, 192007001, 'Abdul Hayat', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(285, 678954321, 'Abiliani', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(286, 192007002, 'Ade Fahmi agustin', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(287, 192007005, 'Adit', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(288, 192007007, 'Ahmad Saparudin', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(289, 192007013, 'Anida', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(290, 192007018, 'Dede Vina Yulian', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(291, 192007019, 'Dewi Srimulyani', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(292, 192007027, 'Haris Hermawan', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(293, 192007030, 'Hilda Solihah', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(294, 192007032, 'Hilmi Salamthan', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(295, 192007035, 'Ilham Ramdhani', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(296, 192007038, 'Linda Angelia', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(297, 192007044, 'Muhamad Rizki Iman', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(298, 192007047, 'Nurdin', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(299, 192007050, 'Rian', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(300, 192007057, 'Sipa Khoirun Nisa', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(301, 102007055, 'Selvia Anggraeni', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(302, 192007060, 'Siti Maesaroh', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(303, 192007066, 'Syahda Nuraida', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(304, 192007059, 'Siti Ayu Patmawati', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(305, 192007069, 'Wardah Nurajizah', 2, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(306, 192007003, 'Ade Gani', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(307, 192007009, 'Aldi Nurul Padli', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(308, 192007011, 'Aneng', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(309, 192007012, 'Anggi Rahmawati', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(310, 192007016, 'Dafa Murtadlo S', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(311, 192007017, 'Dede Rifki', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(312, 192007022, 'Eka Ramdani', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(313, 192007024, 'Fitria Febriani', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(314, 192007029, 'Hermawan', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(315, 192007033, 'Holik', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(316, 192007034, 'Ikbal Maolana', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(317, 192007037, 'Ki Agus Eka Candra Winata', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(318, 192007041, 'Mamat Hidayat', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(319, 192007043, 'Muhammad Reyhian', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(320, 192007045, 'Naila Azkiatunisa', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(321, 192007023, 'Palahudin', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(322, 192007049, 'Raihan Akmal Abdullah', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(323, 192007051, 'Rida Aulia', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(324, 192007053, 'Risma Agustina', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(325, 192007055, 'Selvia Anggraeni', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(326, 192007064, 'Suryana', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(327, 192007065, 'Susi Susanti', 2, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(328, 181907001, 'Aa Dadi Wahyudi', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(329, 189070042, 'Ade Yudistira', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(330, 181907002, 'Ade Ridwan', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(331, 181907012, 'Anugrah Mutiara', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(332, 181907016, 'Didin', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(333, 181907022, 'Elza Sandra Febrian', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(334, 181907030, 'Hendri Herdiana 8b', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(335, 181907032, 'Hera Herdiani', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(336, 181907037, 'Irna Rahmawati', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(337, 181907041, 'Komarudin', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(338, 181907044, 'Mila Siti Pajriah', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(339, 181907048, 'Muhammad Lutfi R', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(340, 567432198, 'Muhammad Tobagus Sohabudin', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(341, 181907049, 'Naila Saidah P', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(342, 181907051, 'Novi Lestari', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(343, 181907023, 'Enur Nurhayati', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(344, 181907052, 'Padli Maulana', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(345, 181907025, 'Pafi Nasrulloh', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(346, 181907053, 'Puspita Dewi', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(347, 181907055, 'Rian', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(348, 181907057, 'Rija Astiafuzi', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(349, 984567213, 'Santi Rismawanti', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(350, 181907064, 'Siti Nurhhidayah', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(351, 181907068, 'Sri Yulianti', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(352, 181907075, 'Yoga pratama', 4, 10, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(353, 181907006, 'Ahmad Firdaus', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(354, 181907008, 'Anggi', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(355, 181907010, 'Anisa Nurfitriani', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(356, 181907013, 'Dea laty Kusmilawati', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(357, 181907014, 'Deni Kusnadi', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(358, 181907018, 'Dimas Julianar', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(359, 181907019, 'Dina Novianti', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(360, 181907024, 'Eri Setiawan', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(361, 181907026, 'Fitriani', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(362, 181907029, 'Hena', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(363, 181907033, 'Herlin', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(364, 181907034, 'Herlina Yulianti', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(365, 181907035, 'Ikhsan Bachtiar', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(366, 181907036, 'Ipan Maulana', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(367, 181907038, 'Irzi Noverba', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(368, 181907046, 'Muhamad Zaenudin', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(369, 181907047, 'Muhammad Dika H', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(370, 181907050, 'Nita Nanda', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(371, 181907054, 'Reni Ruhyani', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(372, 547821963, 'Reza Maulana', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(373, 181907058, 'Risa Nurazizah', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(374, 985321764, 'Tatang Permana', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(375, 181907070, 'Susan Rinti Antika', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(376, 181907071, 'Syahrul Rafi Awaludin', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(377, 181907059, 'Rizki Maulana', 4, 11, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(378, 678453219, 'Ari Rahmayadi', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(379, 181907015, 'Dian Saputra', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(380, 181907017, 'Dila Rahmawati', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(381, 181907021, 'Diva Al Diera', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(382, 181907027, 'Gita Indriawan', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(383, 181907028, 'Heldi Herdiana', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(384, 181907039, 'Iwan Ridwan', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(385, 181907040, 'Jajang Arul', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(386, 181907042, 'Mayangsari', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(387, 181907043, 'Mila Nurwahidah', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(388, 181907045, 'Muhammad Ali', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(389, 181907117, 'Puspita Wulandari', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(390, 181907056, 'Riana Febriyanti P', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(391, 181907061, 'Riyan Maulana S', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(392, 181907060, 'Rizki Alfian Januar', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(393, 181907063, 'Sara Agustina', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(394, 181907069, 'Steapani Dwi Hendiansyah', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(395, 181907065, 'Siti Susanti', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(396, 181907066, 'Sopiyani', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(397, 181907067, 'Sri Handayani', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(398, 181907074, 'Yaya Munawar', 4, 12, '12345678', '2021-04-01 08:15:56', '2021-04-01 08:15:56'),
(399, 964123578, 'AGUNG GUNAWAN', 2, 11, '12345678', '2021-04-01 08:22:34', '2021-04-01 08:22:34'),
(400, 498236571, 'MAHER GUNAWAN', 2, 12, '12345678', '2021-04-01 08:24:22', '2021-04-01 08:24:22'),
(401, 231498576, 'SIFA KHOIRUNISA', 2, 12, '12345678', '2021-04-01 08:25:52', '2021-04-01 08:25:52'),
(402, 765982134, 'ADINDA FIRDA LESTARI PUTRI', 4, 12, '12345678', '2021-04-01 08:29:48', '2021-04-01 08:29:48'),
(403, 132976458, 'ADE SAID MAULANA R', 4, 12, '12345678', '2021-04-01 08:30:40', '2021-04-01 08:30:40'),
(404, 945821367, 'ANISA FEBRIANTI', 4, 12, '12345678', '2021-04-01 08:31:26', '2021-04-01 08:31:26'),
(405, 412378569, 'HENDRI HERDIANA', 4, 12, '12345678', '2021-04-01 08:32:59', '2021-04-01 08:32:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tingkat`
--

CREATE TABLE `tingkat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tingkat`
--

INSERT INTO `tingkat` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'VII', '2021-03-30 09:58:45', '2021-03-30 09:58:45'),
(2, 'VIII', '2021-03-30 09:59:14', '2021-03-30 09:59:14'),
(4, 'IX', '2021-03-31 17:23:52', '2021-03-31 17:23:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `buku_siswa`
--
ALTER TABLE `buku_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `mapel_siswa`
--
ALTER TABLE `mapel_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `operasi`
--
ALTER TABLE `operasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tingkat`
--
ALTER TABLE `tingkat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `buku_siswa`
--
ALTER TABLE `buku_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `kunjungan`
--
ALTER TABLE `kunjungan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `mapel_siswa`
--
ALTER TABLE `mapel_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT untuk tabel `operasi`
--
ALTER TABLE `operasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT untuk tabel `tingkat`
--
ALTER TABLE `tingkat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
