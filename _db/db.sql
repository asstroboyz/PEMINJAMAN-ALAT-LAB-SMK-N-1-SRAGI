-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 19, 2025 at 02:59 PM
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
(8, '::1', 'Ganda@gmail.com', 22, '2025-09-19 21:58:44', 1);

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
  `kode_barang` varchar(255) NOT NULL,
  `id_master_barang` varchar(255) NOT NULL,
  `sn` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kondisi` varchar(100) NOT NULL,
  `spesifikasi` varchar(110) NOT NULL,
  `id_satuan` int NOT NULL,
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

INSERT INTO `inventaris` (`kode_barang`, `id_master_barang`, `sn`, `foto`, `kondisi`, `spesifikasi`, `id_satuan`, `ruangan_id`, `status`, `qrcode`, `file`, `created_at`, `updated_at`, `deleted_at`) VALUES
('CEK-20250908-415-20250916-001', 'CEK-20250908-415', NULL, NULL, 'baru', 'asd', 3, 2, 'tersedia', 'cek-20250908-415-20250916-001-cek_1758030639', 'assets/media/qrcode/cek-20250908-415-20250916-001-cek_1758030639.png', '2025-09-16 20:50:39', '2025-09-16 20:50:39', NULL),
('CEK-20250908-415-20250916-002', 'CEK-20250908-415', NULL, NULL, 'baru', 'asd', 3, 1, 'tersedia', 'cek-20250908-415-20250916-002-cek_1758030639', 'assets/media/qrcode/cek-20250908-415-20250916-002-cek_1758030639.png', '2025-09-16 20:50:39', '2025-09-16 20:50:39', NULL),
('CEK-20250908-415-20250916-003', 'CEK-20250908-415', NULL, NULL, 'rusak', 'asd', 2, 18, 'tersedia', 'cek-20250908-415-20250916-003-cek_1758031182', 'assets/media/qrcode/cek-20250908-415-20250916-003-cek_1758031182.png', '2025-09-16 20:59:42', '2025-09-16 20:59:42', NULL),
('CEK-20250908-435-20250916-001', 'CEK-20250908-435', NULL, NULL, 'baru', '', 4, 14, 'tersedia', 'cek-20250908-435-20250916-001-cek_1758030976', 'assets/media/qrcode/cek-20250908-435-20250916-001-cek_1758030976.png', '2025-09-16 20:56:16', '2025-09-16 20:56:16', NULL),
('CEK-20250908-435-20250916-002', 'CEK-20250908-435', NULL, NULL, 'baru', 'asdasd', 2, 18, 'tersedia', 'cek-20250908-435-20250916-002-cek_1758031158', 'assets/media/qrcode/cek-20250908-435-20250916-002-cek_1758031158.png', '2025-09-16 20:59:18', '2025-09-16 20:59:18', NULL),
('CEK-20250908-435-20250916-003', 'CEK-20250908-435', NULL, NULL, 'baru', 'asdasd', 2, 17, 'tersedia', 'cek-20250908-435-20250916-003-cek_1758031158', 'assets/media/qrcode/cek-20250908-435-20250916-003-cek_1758031158.png', '2025-09-16 20:59:19', '2025-09-16 20:59:19', NULL);

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
(1, 'Laptop'),
(2, 'Monitor'),
(3, 'Printer'),
(4, 'Router'),
(5, 'Switch'),
(6, 'Access Point'),
(7, 'PC Rakitan'),
(8, 'Proyektor'),
(9, 'Tools');

-- --------------------------------------------------------

--
-- Table structure for table `master_barang`
--

CREATE TABLE `master_barang` (
  `kode_brg` varchar(255) NOT NULL,
  `nama_brg` varchar(255) NOT NULL,
  `kategori_id` int DEFAULT NULL,
  `merk_id` int DEFAULT NULL,
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

INSERT INTO `master_barang` (`kode_brg`, `nama_brg`, `kategori_id`, `merk_id`, `tipe_serie`, `jenis_brg`, `spesifikasi`, `foto`, `id_satuan`, `is_active`, `created_at`, `updated_at`) VALUES
('BUK-20250914-390', 'buku', 7, 4, '2342', 'tools', 'sad', NULL, 2, 1, '2025-09-14 07:20:05', '2025-09-14 07:20:05'),
('BUK-20250914-433', 'buku buku', 9, 17, '234', 'hrd', 'buku', NULL, 2, 1, '2025-09-14 07:20:59', '2025-09-14 07:20:59'),
('C-20250914-413', 'c', 3, 9, '423', 'sfw', '-', NULL, 2, 1, '2025-09-14 07:14:23', '2025-09-14 07:14:23'),
('CEK-20250908-415', 'Cek', 2, 2, '234', 'hrd', 'aa', NULL, 2, 1, '2025-09-08 01:17:33', '2025-09-08 01:17:33'),
('CEK-20250908-435', 'Cek', 2, 2, '234', 'hrd', 'aa', NULL, 2, 1, '2025-09-08 01:19:21', '2025-09-08 01:19:21'),
('LAP-001', 'Laptop Lenovo ThinkPad', 1, 1, 'T14 Gen2', 'hrd', 'Core i5, 8GB RAM, 256GB SSD', NULL, 1, 1, '2025-09-05 23:41:34', '2025-09-05 23:41:34'),
('LAP-002', 'Laptop Asus ExpertBook', 1, 2, 'B1400CEAE', 'hrd', 'Core i3, 8GB RAM, 256GB SSD', NULL, 1, 1, '2025-09-05 23:41:34', '2025-09-05 23:41:34'),
('LEG-20250916-740', 'legion', 2, 1, 'R27s', 'hrd', 'baru dong', '1758028792_1cd3fccf1a07df2b22f0.jpeg', 2, 1, '2025-09-16 20:19:52', '2025-09-16 20:19:52'),
('MIN-20250914-179', 'minin', 2, 1, NULL, 'tools', 'sad', NULL, 3, 1, '2025-09-14 07:23:48', '2025-09-14 07:23:48'),
('MON-001', 'Monitor Lenovo', 2, 1, 'G24F-10', 'hrd', '24 inch, IPS, 165Hz', NULL, 2, 1, '2025-09-05 23:41:34', '2025-09-05 23:41:34'),
('MON-002', 'Monitor LG', 2, 7, '24MK600', 'hrd', '24 inch, IPS, HDMI', NULL, 2, 1, '2025-09-05 23:41:34', '2025-09-05 23:41:34'),
('PRI-20250914-646', 'Printer', 6, 12, NULL, 'hrd', '-', NULL, 2, 1, '2025-09-14 07:01:24', '2025-09-14 07:01:24'),
('PRN-001', 'Printer Epson EcoTank', 3, 8, 'L3110', 'tools', 'All-in-One, Print Scan Copy', NULL, 3, 1, '2025-09-05 23:41:34', '2025-09-05 23:41:34'),
('RED-20250914-313', 'redmi 12', 9, 16, NULL, 'tools', 'a', '1757809639_23055900856aa6feafe1.jpeg', 3, 1, '2025-09-14 07:27:19', '2025-09-14 07:27:19'),
('RTR-001', 'Router MikroTik', 4, 11, 'RB750', 'tools', '5 Port, Fast Ethernet', NULL, 4, 1, '2025-09-05 23:41:34', '2025-09-05 23:41:34'),
('TLS-001', 'Crimping Tool', 9, 15, 'CP-376TR', 'tools', 'RJ45/11, Full Steel', NULL, 5, 1, '2025-09-05 23:41:34', '2025-09-05 23:41:34');

-- --------------------------------------------------------

--
-- Table structure for table `merk_barang`
--

CREATE TABLE `merk_barang` (
  `id` int NOT NULL,
  `nama_merk` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `merk_barang`
--

INSERT INTO `merk_barang` (`id`, `nama_merk`) VALUES
(1, 'Lenovo'),
(2, 'Asus'),
(3, 'HP'),
(4, 'Acer'),
(5, 'Dell'),
(6, 'Samsung'),
(7, 'LG'),
(8, 'Epson'),
(9, 'Canon'),
(10, 'Brother'),
(11, 'MikroTik'),
(12, 'TP-Link'),
(13, 'Cisco'),
(14, 'Tenda'),
(15, 'Pro\'sKit'),
(16, 'Krisbow'),
(17, 'Nankai'),
(18, 'Unifi'),
(19, 'no-brand');

-- --------------------------------------------------------

--
-- Table structure for table `merk_kategori_barang`
--

CREATE TABLE `merk_kategori_barang` (
  `id` int NOT NULL,
  `kategori_id` int NOT NULL,
  `merk_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `merk_kategori_barang`
--

INSERT INTO `merk_kategori_barang` (`id`, `kategori_id`, `merk_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 1),
(7, 2, 6),
(8, 2, 7),
(9, 2, 5),
(10, 2, 2),
(11, 3, 8),
(12, 3, 9),
(13, 3, 10),
(14, 3, 3),
(15, 4, 11),
(16, 4, 12),
(17, 4, 13),
(18, 4, 14),
(19, 5, 12),
(20, 5, 13),
(21, 5, 14),
(22, 6, 12),
(23, 6, 18),
(24, 6, 14),
(25, 7, 1),
(26, 7, 2),
(27, 7, 4),
(28, 7, 5),
(29, 8, 3),
(30, 8, 6),
(31, 8, 8),
(32, 9, 15),
(33, 9, 16),
(34, 9, 17),
(35, 9, 19);

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
  `inventaris_id` varchar(255) DEFAULT NULL,
  `ruangan_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `status` enum('dipinjam','kembali sebagian','kembali semua') DEFAULT 'dipinjam',
  `catatan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(4, 'LEG-20250916-740', '2025-09-16', NULL, 'Barang HRD baru, pengecekan awal');

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
(1, 'LAP-001-20250916-001', 'LAP-001', NULL, 'masuk', 'Inventaris baru ditambahkan', 1, NULL, NULL, '2025-09-16 20:47:48', '2025-09-16 20:47:48'),
(2, 'LAP-001-20250916-002', 'LAP-001', NULL, 'masuk', 'Inventaris baru ditambahkan', 1, NULL, NULL, '2025-09-16 20:47:48', '2025-09-16 20:47:48'),
(3, 'CEK-20250908-415-20250916-001', 'CEK-20250908-415', NULL, 'masuk', 'Inventaris baru ditambahkan', 1, NULL, NULL, '2025-09-16 20:50:39', '2025-09-16 20:50:39'),
(4, 'CEK-20250908-415-20250916-002', 'CEK-20250908-415', NULL, 'masuk', 'Inventaris baru ditambahkan', 1, NULL, NULL, '2025-09-16 20:50:39', '2025-09-16 20:50:39'),
(5, 'CEK-20250908-435-20250916-001', 'CEK-20250908-435', NULL, 'masuk', 'Inventaris baru ditambahkan', 1, NULL, NULL, '2025-09-16 20:56:16', '2025-09-16 20:56:16'),
(6, 'CEK-20250908-435-20250916-002', 'CEK-20250908-435', NULL, 'masuk', 'Inventaris baru ditambahkan', 1, NULL, NULL, '2025-09-16 20:59:18', '2025-09-16 20:59:18'),
(7, 'CEK-20250908-435-20250916-003', 'CEK-20250908-435', NULL, 'masuk', 'Inventaris baru ditambahkan', 1, NULL, NULL, '2025-09-16 20:59:19', '2025-09-16 20:59:19'),
(8, 'CEK-20250908-415-20250916-003', 'CEK-20250908-415', NULL, 'masuk', 'Inventaris baru ditambahkan', 1, NULL, NULL, '2025-09-16 20:59:42', '2025-09-16 20:59:42');

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
  ADD PRIMARY KEY (`kode_barang`),
  ADD KEY `id_satuan` (`id_satuan`),
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
  ADD KEY `fk_master_barang_kategori` (`kategori_id`),
  ADD KEY `fk_master_barang_merk` (`merk_id`);

--
-- Indexes for table `merk_barang`
--
ALTER TABLE `merk_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merk_kategori_barang`
--
ALTER TABLE `merk_kategori_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `merk_id` (`merk_id`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `merk_barang`
--
ALTER TABLE `merk_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `merk_kategori_barang`
--
ALTER TABLE `merk_kategori_barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman_header`
--
ALTER TABLE `peminjaman_header`
  MODIFY `peminjaman_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengecekan`
--
ALTER TABLE `pengecekan`
  MODIFY `pengecekan_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `fk_master_barang_kategori` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_barang` (`id`),
  ADD CONSTRAINT `fk_master_barang_merk` FOREIGN KEY (`merk_id`) REFERENCES `merk_barang` (`id`),
  ADD CONSTRAINT `fk_merk_barang` FOREIGN KEY (`merk_id`) REFERENCES `merk_barang` (`id`);

--
-- Constraints for table `merk_kategori_barang`
--
ALTER TABLE `merk_kategori_barang`
  ADD CONSTRAINT `merk_kategori_barang_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_barang` (`id`),
  ADD CONSTRAINT `merk_kategori_barang_ibfk_2` FOREIGN KEY (`merk_id`) REFERENCES `merk_barang` (`id`);

--
-- Constraints for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD CONSTRAINT `fk_peminjaman_detail_header` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman_header` (`peminjaman_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_detail_inventaris` FOREIGN KEY (`inventaris_id`) REFERENCES `inventaris` (`kode_barang`) ON DELETE CASCADE,
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
