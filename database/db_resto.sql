-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2026 at 01:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pesanan_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('owner','kasir','pelayan','dapur') NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `role`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Budi Santoso', 'dapur', 1, '2026-01-29 19:12:21', '2026-01-29 19:12:21'),
(2, 'Siti Nurhaliza', 'kasir', 1, '2026-01-29 19:12:21', '2026-01-29 19:12:21'),
(3, 'Ahmad Riyanto', 'pelayan', 1, '2026-01-29 19:12:21', '2026-01-29 19:12:21'),
(4, 'Dwi Handoko', 'pelayan', 1, '2026-01-29 19:12:21', '2026-01-29 19:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_menu`
--

INSERT INTO `kategori_menu` (`id`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Makanan Pokok', '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(2, 'Minuman', '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(3, 'Dessert', '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(4, 'Appetizer', '2026-01-29 19:11:16', '2026-01-29 19:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_meja` varchar(10) NOT NULL,
  `status` enum('available','booked','occupied') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`id`, `nomor_meja`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Meja 1', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(2, 'Meja 2', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(3, 'Meja 3', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(4, 'Meja 4', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(5, 'Meja 5', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(6, 'Meja 6', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(7, 'Meja 7', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(8, 'Meja 8', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(9, 'Meja 9', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46'),
(10, 'Meja 10', 'available', '2026-01-29 19:11:46', '2026-01-29 19:11:46');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `kategori_id`, `nama_menu`, `harga`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nasi Kuning', 15000.00, 1, '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(2, 1, 'Nasi Goreng', 18000.00, 1, '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(3, 1, 'Mie Goreng', 17000.00, 1, '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(4, 2, 'Iced Tea', 5000.00, 1, '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(5, 2, 'Kopi Hitam', 8000.00, 1, '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(6, 3, 'Es Krim', 12000.00, 1, '2026-01-29 19:11:16', '2026-01-29 19:11:16'),
(7, 4, 'Lumpia', 8000.00, 1, '2026-01-29 19:11:16', '2026-01-29 19:11:16');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_10_010220_create_operational_days_table', 2),
(5, '2026_01_10_010330_create_meja_table', 2),
(6, '2026_01_10_010353_create_karyawan_table', 2),
(7, '2026_01_10_010414_create_kategori_menu_table', 2),
(8, '2026_01_10_010432_create_menu_table', 2),
(9, '2026_01_10_010451_create_stok_menu_harian_table', 2),
(10, '2026_01_10_010508_create_pesanan_table', 2),
(11, '2026_01_10_010524_create_detail_pesanan_table', 2),
(12, '2026_01_10_010535_create_payment_table', 2),
(14, '2026_01_10_101759_create_personal_access_tokens_table', 1),
(15, '2026_01_23_022113_update_detail_pesanan_table', 3),
(16, '2026_01_24_003921_drop_operational_days_table', 4),
(17, '2026_01_30_000000_recreate_operational_days_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `operational_days`
--

CREATE TABLE `operational_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operational_days`
--

INSERT INTO `operational_days` (`id`, `tanggal`, `status`, `created_at`, `updated_at`) VALUES
(1, '2026-01-30', 'open', '2026-01-29 19:13:00', '2026-01-29 19:13:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pesanan_id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `metode_pembayaran` enum('cash','qris') NOT NULL,
  `total_bayar` decimal(10,2) NOT NULL,
  `waktu_bayar` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'api-token', '07d344fb56ef2796343ab1e49a5c53a124b57a09a26aef580a83ad4f62ca72ab', '[\"*\"]', NULL, NULL, '2026-01-10 02:38:07', '2026-01-10 02:38:07'),
(2, 'App\\Models\\User', 3, 'api-token', 'ee074bb001fe076d48caf156d4d8e60e736bd272e4002319d3009c06a543a8d0', '[\"*\"]', NULL, NULL, '2026-01-10 02:38:23', '2026-01-10 02:38:23'),
(3, 'App\\Models\\User', 3, 'api-token', '167496354bb6cc163231e2ae4535a0c0436cda204606fb7dfe48a65850a6695b', '[\"*\"]', NULL, NULL, '2026-01-10 02:46:46', '2026-01-10 02:46:46'),
(4, 'App\\Models\\User', 3, 'api-token', 'de8181c8368bd6f1f7304b9754455faf91d0df9da35fad8729a0bf8c9ddbb7db', '[\"*\"]', NULL, NULL, '2026-01-10 02:46:52', '2026-01-10 02:46:52'),
(5, 'App\\Models\\User', 3, 'api-token', '35bc670ee4a9a1183d1d9f64c3ab6bc69ccfa3b1d405578a09cc24ec0179b7d9', '[\"*\"]', NULL, NULL, '2026-01-10 02:52:13', '2026-01-10 02:52:13'),
(6, 'App\\Models\\User', 3, 'api-token', '0dd488ab7e9dc95187bc9417ffd8449516afbaef8d7e38df9ba82672e1665e74', '[\"*\"]', NULL, NULL, '2026-01-10 02:52:22', '2026-01-10 02:52:22'),
(7, 'App\\Models\\User', 3, 'api-token', '22c6557724c1f67bea2f70d1b918d015c0ceee7cce7b4195b17e42fd3ef8ef6c', '[\"*\"]', NULL, NULL, '2026-01-10 03:01:58', '2026-01-10 03:01:58'),
(8, 'App\\Models\\User', 3, 'api-token', '7157c40449da3797191c11e3b91e936ec54712fa61ed12ceda12f7d777b512aa', '[\"*\"]', NULL, NULL, '2026-01-10 03:02:10', '2026-01-10 03:02:10'),
(9, 'App\\Models\\User', 2, 'api-token', '29457255e7350743960a5e1edc2c869d28fa4fbad222aeb61d0a8473713be207', '[\"*\"]', NULL, NULL, '2026-01-10 03:16:22', '2026-01-10 03:16:22'),
(10, 'App\\Models\\User', 1, 'api-token', 'a6413c5638b2961cb58f84fad9c2c0acb44fd20eac4799e4d1565efb58aad957', '[\"*\"]', NULL, NULL, '2026-01-10 03:16:55', '2026-01-10 03:16:55'),
(11, 'App\\Models\\User', 1, 'api-token', '5fd5b00ed12e96bb535868986fd69b923dcedc69153fa15ea3abdfd1f5a90009', '[\"*\"]', NULL, NULL, '2026-01-10 03:17:05', '2026-01-10 03:17:05'),
(12, 'App\\Models\\User', 1, 'api-token', 'e8c2a9e70edf1488044c360f29c868afdafed53709fc0ac2f27dd0e5264fa203', '[\"*\"]', NULL, NULL, '2026-01-10 03:17:29', '2026-01-10 03:17:29'),
(13, 'App\\Models\\User', 2, 'api-token', '02bd6f2809efd04e99e5283b1a6d5542edb6161e27c166e5aceed3605d96ecd8', '[\"*\"]', NULL, NULL, '2026-01-10 03:17:43', '2026-01-10 03:17:43'),
(14, 'App\\Models\\User', 3, 'api-token', '905c5e7dd5b29e18df97856415efca25593ea773ad3ca803a9565c98a07fb252', '[\"*\"]', NULL, NULL, '2026-01-10 03:17:57', '2026-01-10 03:17:57'),
(15, 'App\\Models\\User', 3, 'api-token', '5966bb7c43ee5086fa6f359d9ef1ee63c5958f9af08f4e41acd3e374fc71d006', '[\"*\"]', NULL, NULL, '2026-01-10 03:20:12', '2026-01-10 03:20:12'),
(16, 'App\\Models\\User', 3, 'api-token', 'ba3c37e0ea6edb99db648b3787f8523312a179373e81a83666af4bac6ecf94d4', '[\"*\"]', NULL, NULL, '2026-01-10 03:20:32', '2026-01-10 03:20:32'),
(17, 'App\\Models\\User', 3, 'api-token', 'd77521521c6157a6515293675824b05c8969844f904be457e88393cbeae211fa', '[\"*\"]', NULL, NULL, '2026-01-10 03:21:04', '2026-01-10 03:21:04'),
(18, 'App\\Models\\User', 3, 'api-token', '9bc19f10cb614318966e4c505d82212bcf75ff910e3bd2e1afc744e3f7676667', '[\"*\"]', NULL, NULL, '2026-01-10 03:21:25', '2026-01-10 03:21:25'),
(19, 'App\\Models\\User', 3, 'api-token', 'f4d8441840a8181038d9a6e85613abd9978b7eae97b85c33f3a2d7e12a3d6f2d', '[\"*\"]', NULL, NULL, '2026-01-10 03:21:39', '2026-01-10 03:21:39'),
(20, 'App\\Models\\User', 3, 'api-token', 'bef7cc1f921ca592bcc0eee5ead77691e13ab3039e91c1e766b5219d917d3c4c', '[\"*\"]', NULL, NULL, '2026-01-23 03:01:21', '2026-01-23 03:01:21'),
(21, 'App\\Models\\User', 3, 'api-token', 'aa449b917032a1ed5803ebf44842520b8961443babb6e0e1d034fa02a189e455', '[\"*\"]', NULL, NULL, '2026-01-23 03:01:23', '2026-01-23 03:01:23'),
(22, 'App\\Models\\User', 3, 'api-token', '1727f0e0f4f67d27e2d5770205eb0894c6e69d1368613dcbdabb65bbeca1f89e', '[\"*\"]', NULL, NULL, '2026-01-23 03:01:31', '2026-01-23 03:01:31'),
(23, 'App\\Models\\User', 2, 'api-token', '709eea55457eceeed47eb461c0d6c748d4dc84aed2a4337b11e023b69cc607e3', '[\"*\"]', NULL, NULL, '2026-01-23 16:27:04', '2026-01-23 16:27:04'),
(24, 'App\\Models\\User', 2, 'api-token', '4f71ad0d45ef538e6fab20703c2dbcfd8df0bd493874fa1465336d656eeea6d8', '[\"*\"]', NULL, NULL, '2026-01-23 16:30:53', '2026-01-23 16:30:53'),
(25, 'App\\Models\\User', 2, 'api-token', '13acb94f4076ea74f69ada7f44eaee964d4badc3e32b9c9ce31e0f69ba9731f5', '[\"*\"]', NULL, NULL, '2026-01-23 16:33:38', '2026-01-23 16:33:38'),
(26, 'App\\Models\\User', 2, 'api-token', 'c5d476104bc98ee3b9ce9ca5a44e32057a1b76347e55f47596134f4eb89e0538', '[\"*\"]', NULL, NULL, '2026-01-23 16:36:36', '2026-01-23 16:36:36'),
(27, 'App\\Models\\User', 2, 'api-token', '973de0b8d2f963f84b5196f4a2cd8a4ebc7f55cc95b5ccd138de2eb17230b8c7', '[\"*\"]', NULL, NULL, '2026-01-23 16:48:42', '2026-01-23 16:48:42'),
(28, 'App\\Models\\User', 2, 'api-token', 'b9424bab458ccf7865d5a9f3af960b81b6c6a8574a8da34e483f0336c0be5bf1', '[\"*\"]', NULL, NULL, '2026-01-23 16:51:07', '2026-01-23 16:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `operational_day_id` bigint(20) UNSIGNED NOT NULL,
  `meja_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis_pesanan` enum('dine_in','take_away') NOT NULL,
  `status` enum('open','paid','cancelled') NOT NULL DEFAULT 'open',
  `ditangani_oleh` bigint(20) UNSIGNED NOT NULL,
  `waktu_pesan` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('77sg5GPOLdRFTiBKakCkUrKtU6P9eG8qK5uofYYk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibVBEU2p4N1NkVGNFRFV2WmpsVXpFOVVOM1FaUTdjV0pZb0dFWTB2UCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768043618),
('FZ1V1GtxzUVwBRXI3X02fDwJknp5dMQNTsDjuWSk', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidFdFQ2JpQWhuNmJMMHUybEZTcTJ5a294UldIbk14N1IySkJQMnJOOSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769165995),
('i6geXobnNMqBI6kMlh5ZoyRSSJsFuMKrx1kmMG1C', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibkJGR1BlTFlZcUY3bWt4OWEyU3ByU2dENE10aVdGVVUyd2R6S1lBUiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769774774),
('mEUZ3zl6mS8DD4G8fc905wYHbDagMjNZ7hMZ0Wjb', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaXZ6T3M3SmtTVEZSdGtVMmlWc1VzaUFhSjF2ekNFYzNvaldDM21JQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769215668),
('WRHijS65rtFbVrTLUvX7Nm9f9FxEh7vxIpDRRf9N', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2dMdGRQRk41Y0FNNExzdHFuTXhKUkNDN3pGSHNFb2ZmUm9iMWZ5ZiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768031884);

-- --------------------------------------------------------

--
-- Table structure for table `stok_menu_harian`
--

CREATE TABLE `stok_menu_harian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `operational_day_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_menu_harian`
--

INSERT INTO `stok_menu_harian` (`id`, `operational_day_id`, `menu_id`, `stok`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 50, '2026-01-29 19:14:20', '2026-01-29 19:14:20'),
(2, 1, 2, 50, '2026-01-29 19:14:20', '2026-01-29 19:14:20'),
(3, 1, 3, 50, '2026-01-29 19:14:21', '2026-01-29 19:14:21'),
(4, 1, 4, 50, '2026-01-29 19:14:21', '2026-01-29 19:14:21'),
(5, 1, 5, 50, '2026-01-29 19:14:21', '2026-01-29 19:14:21'),
(6, 1, 6, 50, '2026-01-29 19:14:21', '2026-01-29 19:14:21'),
(7, 1, 7, 50, '2026-01-29 19:14:21', '2026-01-29 19:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Resto', 'admin@resto.com', NULL, '$2y$12$wAnubqfCRHZGFX3br9Ph5eaRoLSkX2aG4esSjJSWKONCkpmUNsLtG', NULL, '2026-01-10 06:38:37', '2026-01-10 03:11:58'),
(2, 'Kasir Resto', 'kasir@resto.com', NULL, '$2y$12$4vc26/ldWfK7mB9EGbvmYu26ZZ802ifB.wSlc/yW6KRZhHJ8h9GZi', NULL, '2026-01-10 06:55:54', '2026-01-10 03:12:27'),
(3, 'Test Kasir', 'test@resto.com', NULL, '$2y$12$zpybSeZ7iLi0iE92cloXX.cKoMhhwxlQRw3Citmid1bxt19Z6DGwm', NULL, '2026-01-10 02:36:53', '2026-01-10 02:36:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_pesanan_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `detail_pesanan_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operational_days`
--
ALTER TABLE `operational_days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_pesanan_id_foreign` (`pesanan_id`),
  ADD KEY `payment_karyawan_id_foreign` (`karyawan_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pesanan_operational_day_id_foreign` (`operational_day_id`),
  ADD KEY `pesanan_meja_id_foreign` (`meja_id`),
  ADD KEY `pesanan_ditangani_oleh_foreign` (`ditangani_oleh`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stok_menu_harian`
--
ALTER TABLE `stok_menu_harian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stok_menu_harian_operational_day_id_menu_id_unique` (`operational_day_id`,`menu_id`),
  ADD KEY `stok_menu_harian_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `operational_days`
--
ALTER TABLE `operational_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_menu_harian`
--
ALTER TABLE `stok_menu_harian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pesanan_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_menu` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `karyawan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ditangani_oleh_foreign` FOREIGN KEY (`ditangani_oleh`) REFERENCES `karyawan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_meja_id_foreign` FOREIGN KEY (`meja_id`) REFERENCES `meja` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_operational_day_id_foreign` FOREIGN KEY (`operational_day_id`) REFERENCES `operational_days` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stok_menu_harian`
--
ALTER TABLE `stok_menu_harian`
  ADD CONSTRAINT `stok_menu_harian_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `stok_menu_harian_operational_day_id_foreign` FOREIGN KEY (`operational_day_id`) REFERENCES `operational_days` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
