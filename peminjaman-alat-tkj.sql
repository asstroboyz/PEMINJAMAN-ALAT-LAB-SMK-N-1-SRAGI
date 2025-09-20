-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 20, 2025 at 01:14 PM
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
-- Database: `peminjaman-alat-tkj`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

CREATE TABLE `auth_activation_attempts` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'site administrator'),
(2, 'user', 'regular user');

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

CREATE TABLE `auth_groups_permissions` (
  `group_id` int UNSIGNED NOT NULL DEFAULT '0',
  `permission_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_groups_permissions`
--

INSERT INTO `auth_groups_permissions` (`group_id`, `permission_id`) VALUES
(1, 1),
(1, 1),
(1, 2),
(1, 2),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

CREATE TABLE `auth_groups_users` (
  `group_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_groups_users`
--

INSERT INTO `auth_groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 1),
(1, 20),
(1, 22),
(2, 14),
(3, 15),
(3, 17),
(3, 18),
(3, 19),
(3, 21),
(4, 16);

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

CREATE TABLE `auth_logins` (
  `id` int UNSIGNED NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'Ganda@gmail.com', 22, '2025-09-06 19:04:32', 1),
(2, '::1', 'Ganda@gmail.com', 22, '2025-09-06 19:04:51', 1),
(3, '::1', 'Ganda@gmail.com', 22, '2025-09-08 00:56:54', 1),
(4, '::1', 'Ganda@gmail.com', 22, '2025-09-08 22:46:56', 1),
(5, '::1', 'Ganda@gmail.com', 22, '2025-09-14 07:00:26', 1),
(6, '::1', 'admin', NULL, '2025-09-16 20:08:01', 0),
(7, '::1', 'Ganda@gmail.com', 22, '2025-09-16 20:08:06', 1),
(8, '::1', 'Ganda@gmail.com', 22, '2025-09-19 21:58:44', 1),
(9, '::1', 'Ganda@gmail.com', 22, '2025-09-20 19:33:41', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

CREATE TABLE `auth_permissions` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `auth_permissions`
--

INSERT INTO `auth_permissions` (`id`, `name`, `description`) VALUES
(1, 'manage user\'s', 'Manage All user\'s'),
(2, 'manage-profile', 'Manage user\'s profile');

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

CREATE TABLE `auth_reset_attempts` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `expires` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

CREATE TABLE `auth_users_permissions` (
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `permission_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` int NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `id_master_barang` varchar(255) NOT NULL,
  `kondisi` varchar(100) NOT NULL,
  `stok` int DEFAULT '0',
  `spesifikasi` varchar(110) NOT NULL,
  `ruangan_id` int DEFAULT NULL,
  `status` enum('tersedia','dipinjam','rusak','hilang') DEFAULT 'tersedia',
  `qrcode` text NOT NULL,
  `file` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `kode_barang`, `id_master_barang`, `kondisi`, `stok`, `spesifikasi`, `ruangan_id`, `status`, `qrcode`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '', 'LEN-20250919-711', 'baru', 1, 'sads', 16, 'tersedia', '', '', '2025-09-19 22:44:53', '2025-09-19 22:44:53', NULL),
(2, '', 'LEN-20250919-711', 'rusak', 1, 'asdas', 14, 'tersedia', '', '', '2025-09-19 22:45:03', '2025-09-19 22:45:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori_barang`
--

INSERT INTO `kategori_barang` (`id`, `nama_kategori`) VALUES
(1, 'Laptop');

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `kode_brg` varchar(255) NOT NULL,
  `nama_brg` varchar(255) NOT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `kategori_id` int DEFAULT NULL,
  `tipe_serie` varchar(100) DEFAULT NULL,
  `jenis_brg` enum('hrd','sfw','tools') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `spesifikasi` text,
  `foto` varchar(255) DEFAULT NULL,
  `id_satuan` int DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_barang`
--

INSERT INTO `master_barang` (`kode_brg`, `nama_brg`, `merk`, `kategori_id`, `tipe_serie`, `jenis_brg`, `spesifikasi`, `foto`, `id_satuan`, `is_active`, `created_at`, `updated_at`) VALUES
('LEN-20250919-711', 'Lenovo', 'lenovo', 1, '1', 'hrd', '1', '1758295155_2e4dbe6b7db9e6e6f1ba.jpeg', 3, 1, '2025-09-19 22:19:15', '2025-09-19 22:19:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_detail`
--

CREATE TABLE `peminjaman_detail` (
  `id` int NOT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `peminjaman_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `jumlah_kembali` int DEFAULT '0',
  `kondisi_kembali` enum('baik','rusak','hilang') DEFAULT 'baik',
  `detail` text NOT NULL,
  `inventaris_id` int DEFAULT NULL,
  `ruangan_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman_detail`
--

INSERT INTO `peminjaman_detail` (`id`, `id_user`, `peminjaman_id`, `jumlah`, `jumlah_kembali`, `kondisi_kembali`, `detail`, `inventaris_id`, `ruangan_id`) VALUES
(1, 22, 1, 1, 0, '', 'Peminjaman dari ruangan 16 ke UKS', 1, 16);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_header`
--

CREATE TABLE `peminjaman_header` (
  `peminjaman_id` int NOT NULL,
  `kode_transaksi` varchar(50) NOT NULL,
  `tanggal_permintaan` date NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali_rencana` datetime DEFAULT NULL,
  `tanggal_kembali_real` datetime DEFAULT NULL,
  `id_user` int UNSIGNED NOT NULL,
  `approved_by` int DEFAULT NULL,
  `ruangan_id_pinjam` int DEFAULT NULL,
  `ruangan_id_sebelum` int DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `catatan` text,
  `alasan_reject` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman_header`
--

INSERT INTO `peminjaman_header` (`peminjaman_id`, `kode_transaksi`, `tanggal_permintaan`, `tanggal_pinjam`, `tanggal_kembali_rencana`, `tanggal_kembali_real`, `id_user`, `approved_by`, `ruangan_id_pinjam`, `ruangan_id_sebelum`, `status`, `catatan`, `alasan_reject`) VALUES
(1, 'PINJAM-20250920193616', '2025-09-20', '2025-09-20 00:00:00', '2025-09-23 00:00:00', NULL, 22, NULL, 1, 16, 'pengajuan', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengecekan`
--

CREATE TABLE `pengecekan` (
  `pengecekan_id` int NOT NULL,
  `id_inventaris` varchar(255) NOT NULL,
  `tanggal_pengecekan` date NOT NULL,
  `ruangan_id_lama` int DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengecekan`
--

INSERT INTO `pengecekan` (`pengecekan_id`, `id_inventaris`, `tanggal_pengecekan`, `ruangan_id_lama`, `keterangan`) VALUES
(1, 'CEK-20250908-435', '2025-09-08', NULL, 'Barang HRD baru, pengecekan awal'),
(2, 'PRI-20250914-646', '2025-09-14', NULL, 'Barang HRD baru, pengecekan awal'),
(3, 'BUK-20250914-433', '2025-09-14', NULL, 'Barang HRD baru, pengecekan awal'),
(4, 'LEG-20250916-740', '2025-09-16', NULL, 'Barang HRD baru, pengecekan awal'),
(5, 'LEN-20250919-711', '2025-09-19', NULL, 'Barang HRD baru, pengecekan awal');

-- --------------------------------------------------------

--
-- Table structure for table `ruangan`
--

CREATE TABLE `ruangan` (
  `id` int NOT NULL,
  `nama_ruangan` varchar(100) NOT NULL,
  `keterangan` text,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ruangan`
--

INSERT INTO `ruangan` (`id`, `nama_ruangan`, `keterangan`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Lab TKJ 1', 'Laboratorium TKJ - Komputer Jaringan Kubu 1', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(2, 'Lab TKJ 2', 'Laboratorium TKJ - Komputer Jaringan Kubu 2', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(3, 'Lab TJAT', 'Lab TJAT (Teknik Jaringan Akses Telekomunikasi)', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(4, 'Lab TJKt', 'Lab TJKt (Teknik Jaringan Komputer Telekomunikasi)', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(5, 'Lab AKL', 'Laboratorium Akuntansi Keuangan Lembaga', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(6, 'Lab KI', 'Laboratorium Kimia Industri', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(7, 'Lab Komputer Umum', 'Lab komputer untuk pelajaran umum', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(8, 'Ruang Akuntansi', 'Ruangan praktek & simulasi akuntansi', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(9, 'Ruang Kelas AKL', 'Kelas khusus Akuntansi', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(10, 'Ruang Kelas TKJ', 'Kelas khusus TKJ', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(11, 'Ruang Guru', 'Ruangan Guru', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(12, 'Ruang Kepala Sekolah', 'Ruangan Kepala Sekolah', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(13, 'Ruang BK', 'Bimbingan Konseling', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(14, 'Ruang TU', 'Tata Usaha', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(15, 'Perpustakaan', 'Perpustakaan', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(16, 'UKS', 'Unit Kesehatan Sekolah', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(17, 'Ruang OSIS', 'Organisasi Siswa Intra Sekolah', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(18, 'Ruang Musik', 'Ruang seni & musik', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(19, 'Ruang Serbaguna', 'Aula / ruang serbaguna', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(20, 'Mushola', 'Tempat ibadah', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(21, 'Gudang Alat', 'Gudang penyimpanan inventaris alat', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24'),
(22, 'Ruang Rapat', 'Ruang meeting / rapat guru & manajemen', 1, '2025-09-03 21:21:24', '2025-09-03 21:21:24');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `satuan_id` int NOT NULL,
  `nama_satuan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`satuan_id`, `nama_satuan`, `created_at`, `updated_at`) VALUES
(2, 'UNIT', '2024-02-06 22:29:33', '2024-02-06 22:29:33'),
(3, 'PAKET', '2024-02-06 22:29:48', '2024-02-06 22:29:48'),
(4, 'PCS', '2024-02-10 21:41:14', '2024-02-10 21:41:14'),
(5, 'RIM', '2024-02-10 21:41:59', '2024-02-10 21:41:59'),
(7, 'BUAH', '2024-02-20 23:18:56', '2024-02-20 23:18:56'),
(8, 'BIJI', '2024-02-20 23:19:12', '2024-02-20 23:19:12'),
(9, 'PACK', '2024-02-20 23:19:24', '2024-02-20 23:19:24'),
(10, 'BOX', '2024-02-20 23:19:34', '2024-02-20 23:19:34');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_barang`
--

CREATE TABLE `transaksi_barang` (
  `id` int NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `id_master_barang` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime DEFAULT NULL,
  `jenis_transaksi` enum('masuk','keluar','rusak','pindah','afkir') DEFAULT NULL,
  `informasi_tambahan` text,
  `jumlah_perubahan` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_barang`
--

INSERT INTO `transaksi_barang` (`id`, `kode_barang`, `id_master_barang`, `tanggal_transaksi`, `jenis_transaksi`, `informasi_tambahan`, `jumlah_perubahan`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '', 'LEN-20250919-711', '2025-09-19 22:36:32', 'masuk', 'Tambah 10 unit, kondisi: bekas, lokasi: ', 10, NULL, NULL, '2025-09-19 22:36:32', '2025-09-19 22:36:32'),
(2, '', 'LEN-20250919-711', '2025-09-19 22:44:53', 'masuk', 'Tambah 1 unit, kondisi: baru, lokasi: 16', 1, NULL, NULL, '2025-09-19 22:44:53', '2025-09-19 22:44:53'),
(3, '', 'LEN-20250919-711', '2025-09-19 22:45:03', 'masuk', 'Tambah 1 unit, kondisi: rusak, lokasi: 14', 1, NULL, NULL, '2025-09-19 22:45:03', '2025-09-19 22:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'profil.svg',
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `fullname`, `foto`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(22, 'Ganda@gmail.com', 'admin', NULL, 'profil.svg', '$2y$10$mXIeRd6/UgI4E3Y7JWB3/eoh/z1XGjzEIlhJQK6iO/Prp5Dzrt2rW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2025-08-30 18:50:05', '2025-08-30 18:50:30', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `group_id_permission_id` (`group_id`,`permission_id`);

--
-- Indexes for table `auth_groups_users`
--
ALTER TABLE `auth_groups_users`
  ADD KEY `auth_groups_users_user_id_foreign` (`user_id`),
  ADD KEY `group_id_user_id` (`group_id`,`user_id`);

--
-- Indexes for table `auth_logins`
--
ALTER TABLE `auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auth_tokens_user_id_foreign` (`user_id`),
  ADD KEY `selector` (`selector`);

--
-- Indexes for table `auth_users_permissions`
--
ALTER TABLE `auth_users_permissions`
  ADD KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  ADD KEY `user_id_permission_id` (`user_id`,`permission_id`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_master_barang` (`id_master_barang`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD PRIMARY KEY (`kode_brg`),
  ADD KEY `fk_master_barang_kategori` (`kategori_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_permintaan_barang_barang` (`inventaris_id`),
  ADD KEY `id_permintaan_barang` (`peminjaman_id`),
  ADD KEY `fk_peminjaman_detail_user` (`id_user`);

--
-- Indexes for table `peminjaman_header`
--
ALTER TABLE `peminjaman_header`
  ADD PRIMARY KEY (`peminjaman_id`),
  ADD KEY `fk_peminjaman_header_user` (`id_user`),
  ADD KEY `fk_header_ruangan_pinjam` (`ruangan_id_pinjam`),
  ADD KEY `fk_header_ruangan_sebelum` (`ruangan_id_sebelum`);

--
-- Indexes for table `pengecekan`
--
ALTER TABLE `pengecekan`
  ADD PRIMARY KEY (`pengecekan_id`),
  ADD KEY `pengecekan_ibfk_1` (`id_inventaris`),
  ADD KEY `fk_pengecekan_ruangan` (`ruangan_id_lama`);

--
-- Indexes for table `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`satuan_id`);

--
-- Indexes for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode_barang` (`kode_barang`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_activation_attempts`
--
ALTER TABLE `auth_activation_attempts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `auth_logins`
--
ALTER TABLE `auth_logins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `auth_permissions`
--
ALTER TABLE `auth_permissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_reset_attempts`
--
ALTER TABLE `auth_reset_attempts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peminjaman_header`
--
ALTER TABLE `peminjaman_header`
  MODIFY `peminjaman_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengecekan`
--
ALTER TABLE `pengecekan`
  MODIFY `pengecekan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `satuan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaksi_barang`
--
ALTER TABLE `transaksi_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_groups_permissions`
--
ALTER TABLE `auth_groups_permissions`
  ADD CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `master_barang`
--
ALTER TABLE `master_barang`
  ADD CONSTRAINT `fk_kategori_barang` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_barang` (`id`),
  ADD CONSTRAINT `fk_master_barang_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_barang` (`id`);

--
-- Constraints for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD CONSTRAINT `fk_peminjaman_detail_header` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman_header` (`peminjaman_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_detail_inventaris` FOREIGN KEY (`inventaris_id`) REFERENCES `inventaris` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_detail_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peminjaman_header`
--
ALTER TABLE `peminjaman_header`
  ADD CONSTRAINT `fk_header_ruangan_pinjam` FOREIGN KEY (`ruangan_id_pinjam`) REFERENCES `ruangan` (`id`),
  ADD CONSTRAINT `fk_header_ruangan_sebelum` FOREIGN KEY (`ruangan_id_sebelum`) REFERENCES `ruangan` (`id`),
  ADD CONSTRAINT `fk_peminjaman_header_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengecekan`
--
ALTER TABLE `pengecekan`
  ADD CONSTRAINT `fk_pengecekan_ruangan` FOREIGN KEY (`ruangan_id_lama`) REFERENCES `ruangan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
