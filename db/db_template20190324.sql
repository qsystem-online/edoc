-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Mar 2019 pada 17.01
-- Versi server: 10.1.35-MariaDB
-- Versi PHP: 7.1.24

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_template`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fst_owner_by` enum('USER','CUSTOMER','SUPLIER','') NOT NULL,
  `fin_owner_id` int(11) NOT NULL,
  `fst_name` varchar(256) NOT NULL,
  `fst_address` text NOT NULL,
  `fbl_primary` tinyint(1) NOT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `address`
--

INSERT INTO `address` (`fin_id`, `fst_owner_by`, `fin_owner_id`, `fst_name`, `fst_address`, `fbl_primary`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(11, 'USER', 1, 'Devi Bastian', 'Taman Manggis indah L no 17', 0, 'ACTIVE', '2019-02-27 16:26:57', 1, '2019-02-27 16:26:57', 1),
(13, 'USER', 1, 'Devi Tangerang', 'Perum Puri Permata Blok F no 11 CIpondoh - Tangerang', 1, 'ACTIVE', '2019-02-27 16:57:41', 1, '2019-02-27 16:57:41', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE `blog` (
  `blog_id` int(5) UNSIGNED NOT NULL,
  `blog_title` varchar(100) NOT NULL,
  `blog_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `blog`
--

INSERT INTO `blog` (`blog_id`, `blog_title`, `blog_description`) VALUES
(1, 'a', NULL),
(2, 'b', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cm_detail_penjualan`
--

DROP TABLE IF EXISTS `cm_detail_penjualan`;
CREATE TABLE `cm_detail_penjualan` (
  `fin_id` bigint(20) NOT NULL,
  `fin_penjualan_id` bigint(20) DEFAULT NULL,
  `id_product` int(10) DEFAULT NULL,
  `fin_qty` int(10) DEFAULT NULL,
  `fdc_harga` decimal(12,0) DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cm_detail_penjualan`
--

INSERT INTO `cm_detail_penjualan` (`fin_id`, `fin_penjualan_id`, `id_product`, `fin_qty`, `fdc_harga`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(1, 1, 1, 10, '5000', NULL, NULL, NULL, NULL),
(2, 7, 20, 2, '250000', '2019-03-24 14:08:13', 1, '2019-03-24 14:08:13', 1),
(3, 8, 20, 1, '250000', '2019-03-24 14:40:28', 1, '2019-03-24 14:40:28', 1),
(4, 8, 26, 2, '250000', '2019-03-24 14:40:28', 1, '2019-03-24 14:40:28', 1),
(5, 9, 25, 1, '250000', '2019-03-24 15:24:54', 1, '2019-03-24 15:24:54', 1),
(6, 10, 30, 1, '250000', '2019-03-24 15:26:28', 1, '2019-03-24 15:26:28', 1),
(7, 11, 30, 1, '250000', '2019-03-24 15:27:19', 1, '2019-03-24 15:27:19', 1),
(8, 12, 30, 1, '250000', '2019-03-24 15:38:12', 1, '2019-03-24 15:38:12', 1),
(9, 13, 20, 1, '250000', '2019-03-24 15:38:52', 1, '2019-03-24 15:38:52', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cm_header_penjualan`
--

DROP TABLE IF EXISTS `cm_header_penjualan`;
CREATE TABLE `cm_header_penjualan` (
  `fin_id` bigint(20) NOT NULL,
  `fdt_date` date DEFAULT NULL,
  `fst_customer_name` varchar(256) DEFAULT NULL,
  `fdc_disc` decimal(10,0) DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_insert_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `cm_header_penjualan`
--

INSERT INTO `cm_header_penjualan` (`fin_id`, `fdt_date`, `fst_customer_name`, `fdc_disc`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`, `fst_active`) VALUES
(1, '2019-03-23', 'Devi Bastian', '10', '2019-03-23 19:01:05', 1, NULL, NULL, 'ACTIVE'),
(4, '2019-03-24', 'Devi Bastian', '5', '2019-03-24 14:05:05', 1, '2019-03-24 14:05:05', 1, 'DELETED'),
(7, '2019-03-24', 'devi2', '5', '2019-03-24 14:08:13', 1, '2019-03-24 14:08:13', 1, 'ACTIVE'),
(8, '2019-03-24', 'Devi Lagi', '5', '2019-03-24 14:40:27', 1, '2019-03-24 14:40:27', 1, 'ACTIVE'),
(9, '2019-03-24', 'Devi Bastian', '10', '2019-03-24 15:24:54', 1, '2019-03-24 15:24:54', 1, 'ACTIVE'),
(10, '2019-03-24', 'Devi Bastian', '0', '2019-03-24 15:26:28', 1, '2019-03-24 15:26:28', 1, 'ACTIVE'),
(11, '2019-03-24', 'Devi Bastian', '0', '2019-03-24 15:27:19', 1, '2019-03-24 15:27:19', 1, 'ACTIVE'),
(12, '2019-03-24', 'Devi Bastian', '0', '2019-03-24 15:38:12', 1, '2019-03-24 15:38:12', 1, 'ACTIVE'),
(13, '2019-03-24', 'Devi Bastian', '0', '2019-03-24 15:38:52', 1, '2019-03-24 15:38:52', 1, 'ACTIVE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cm_products`
--

DROP TABLE IF EXISTS `cm_products`;
CREATE TABLE `cm_products` (
  `id_product` int(10) UNSIGNED NOT NULL,
  `id_product_category` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `price` decimal(13,2) NOT NULL,
  `sequence` int(5) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` varchar(64) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Product Table - Erick Wellem';

--
-- Dumping data untuk tabel `cm_products`
--

INSERT INTO `cm_products` (`id_product`, `id_product_category`, `title`, `content`, `price`, `sequence`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 9, 'W210', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also be designated as W.', '250000.00', 1, '2018-06-04 09:05:00', 'erickwellem', '2018-07-20 23:31:03', 'andy'),
(2, 10, 'SW240', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also classified as W. Color quality classified as Second Quality Scorched.', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '2018-07-20 23:20:51', 'andy'),
(4, 12, 'DESSERT', 'Dessert Quality', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '0000-00-00 00:00:00', ''),
(5, 12, 'Fourth Quality', 'White whole', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '0000-00-00 00:00:00', ''),
(7, 3, 'Cashew Nut Shell Liquid', '<p>An extraction of cashew nut shell. It has an innumerable application such as friction linings, paints, laminating resins, rubber compounding resins, etc.</p>', '250000.00', 3, '2018-06-04 09:05:00', 'erickwellem', '0000-00-00 00:00:00', ''),
(8, 4, 'Cashew Shell Cake', 'Cake of cashew nut shell after being pressed. It is an efficient biomass.', '250000.00', 4, '2018-06-04 09:05:00', 'erickwellem', '2018-06-18 06:33:17', 'erickwellem'),
(9, 5, 'Cashew Husk', 'Cashew Husk product description will be available soon', '250000.00', 5, '2018-06-04 09:05:00', 'erickwellem', '2018-06-18 19:39:21', 'erickwellem'),
(10, 5, 'Cashew Hull', 'Soft skin of cashew obtained from cashew peeling activities. It can be mixed for animal feed.', '250000.00', 6, '2018-06-04 09:05:00', 'erickwellem', '2018-06-18 06:38:54', 'erickwellem'),
(11, 5, 'Cashew Milled', 'Crushed milled rotten cashew. Physical characteristic light to dark brown color and have a lightly texture. It can be mixed for animal feed.', '250000.00', 7, '2018-06-04 09:05:00', 'erickwellem', '2018-06-18 06:36:29', 'erickwellem'),
(12, 5, 'Rice Bran', 'Hard outer layers of rice grain taken from rice grain milled process using for animal feed industries. Physical Characteristic dark brown color and light to medium light texture.', '250000.00', 8, '2018-06-04 09:05:00', 'erickwellem', '2018-06-18 06:13:48', 'erickwellem'),
(13, 6, 'Flat Bean', 'Flat cocoa bean. Physical characteristic dark brown color and contain with small amount of cocoa nibs. It can be mixed for animal feed. The other usage is for small confectionery industry by take the fat content through extraction process.', '250000.00', 9, '2018-06-04 12:49:01', 'erickwellem', '2018-06-18 06:17:08', 'erickwellem'),
(14, 6, 'Cocoa Shell and Broken Bean', 'Mixture of cocoa shell and broken bean. Physical characteristic Light to dark brown color and have a grainy texture. Mostly use for small confectionery by extraction the fat content, also can use for animal feed mixed concentrate.', '250000.00', 10, '2018-06-04 12:50:52', 'erickwellem', '2018-06-18 06:31:04', 'erickwellem'),
(15, 6, 'Cocoa Waste', '100% cocoa waste. Small flat beans, pieces of shell, dust, dried cocoa pulp, dried cocoa placenta, small amount of nibs, and all non-cocoa materials. Physical characteristic dark brown color. It can be mixed for animal feed. The other usage is for small confectionery industry by take the fat content through extraction process.', '250000.00', 11, '2018-06-04 12:52:31', 'erickwellem', '2018-06-18 06:20:00', 'erickwellem'),
(16, 7, 'Rice', 'PT Comextra Majora healthy rice, free from preservatives and bleach.', '250000.00', 12, '2018-06-04 12:54:54', 'erickwellem', '2018-06-18 06:10:16', 'erickwellem'),
(18, 15, 'CNSL', '<p>Ekstrak kulit kacang mede. Memiliki aplikasi yang tak terhitung seperti lapisan anti gores, cat, resin laminating, resin peracikan karet, dll.</p>', '250000.00', 3, '2018-06-04 09:05:00', 'erickwellem', '2018-06-05 16:59:24', 'andy'),
(19, 16, 'Cake Kulit Mede', '<p>Olahan kacang mede yang digiling merupakan biomasa yang efisien*</p>', '250000.00', 4, '2018-06-04 09:05:00', 'erickwellem', '2018-06-29 21:59:23', 'andy'),
(20, 17, 'Ampas Kulit Kacang Mede', '<p>Deskripsi produk Ampas Kulit Kacang Mede akan segera tersedia</p>', '250000.00', 5, '2018-06-04 09:05:00', 'erickwellem', '0000-00-00 00:00:00', ''),
(21, 17, 'Kulit Ari Mede Giling', '<p>Kulit halus dari jambu mede diperoleh dari kupasan mede, dapat dicampur untuk pakan ternak.</p>', '250000.00', 6, '2018-06-04 09:05:00', 'erickwellem', '2018-06-29 22:06:21', 'andy'),
(22, 17, 'Mede Giling', '<p>Kacang mete yang dihancurkan. Cahaya karakteristik fisik untuk warna coklat gelap dan memiliki tekstur ringan. Dapat dicampur untuk pakan ternak.</p>', '250000.00', 7, '2018-06-04 09:05:00', 'erickwellem', '2018-06-29 21:58:24', 'andy'),
(23, 17, 'Dedak Beras', '<p>Lapisan luar beras yang keras diambil dari proses penggilingan padi yang digunakan untuk pakan ternak industri. Karakteristik Fisik warna coklat tua dan tekstur ringan hingga sedang.</p>', '250000.00', 8, '2018-06-04 09:05:00', 'erickwellem', '2018-06-18 06:14:42', 'erickwellem'),
(24, 18, 'Biji Pipih', '<p>Biji kakao pipih. Karakteristik fisiknya berwarna coklat gelap dan mengandung sedikit biji kakao yang dapat dicampur untuk pakan ternak. Penggunaan lainnya adalah untuk industri gula-gula rumahan dengan mengambil konten lemak melalui proses ekstraksi.</p>', '250000.00', 9, '2018-06-04 12:49:01', 'erickwellem', '2018-06-18 06:18:10', 'erickwellem'),
(25, 18, 'Kulit Ari Kakao dan Biji Pecah', '<p>Campuran cangkang kakao dan pecahannya. Karakteristik fisik berwarna coklat terang ke gelap dan memiliki tekstur kasar. Sebagian besar digunakan untuk kembang gula dengan mengekstraksi kandungan lemak, juga dapat digunakan untuk pakan ternak dicampur konsentrat.</p>', '250000.00', 10, '2018-06-04 12:50:52', 'erickwellem', '2018-06-29 22:20:18', 'andy'),
(26, 18, 'Limbah Kakao', '<p>100% limbah kakao. Biji pipih kecil, potongan cangkang, debu, ampas coklat kering, plasenta cocoa kering, sedikit biji, dan semua bahan non-kakao. Karakteristik fisik berwarna coklat gelap. Dapat dicampur untuk pakan ternak. Penggunaan lainnya adalah untuk industri kembang gula dengan mengambil konten lemak melalui proses ekstraksi.</p>', '250000.00', 11, '2018-06-04 12:52:31', 'erickwellem', '2018-06-29 21:57:21', 'andy'),
(27, 19, 'Beras', '<p>Deskripsi produk Beras akan segera tersedia#</p>', '250000.00', 12, '2018-06-04 12:54:54', 'erickwellem', '2018-06-18 06:11:24', 'erickwellem'),
(29, 2, 'Cocoa Bean', 'Sulawesi cocoa bean well dry, sorted and cleaned by machine and packing into jute bag.', '250000.00', 2, '2018-06-07 00:40:29', 'erickwellem', '2018-06-18 06:42:38', 'erickwellem'),
(30, 14, 'Biji Kakao', 'Biji Kakao', '250000.00', 2, '2018-06-07 00:42:07', 'erickwellem', '2018-06-18 06:43:23', 'erickwellem'),
(31, 8, 'Limousin cattle', 'Limousin cattle', '250000.00', 1, '2018-06-17 22:56:42', 'andy', '2018-06-18 06:08:19', 'erickwellem'),
(32, 3, 'Cashew Nut Shell Liquid (CNSL)', 'An extraction of cashew nut shell. It has an innumerable application such as friction linings, paints, laminating resins, rubber compounding resins, etc.', '250000.00', 3, '2018-06-18 04:44:43', 'erickwellem', '2018-06-18 06:05:43', 'erickwellem'),
(33, 9, 'W240', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also be designated as W.', '250000.00', 2, '2018-06-18 03:33:31', 'erickwellem', '2018-07-20 23:12:02', 'andy'),
(34, 9, 'W320', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also be designated as W.', '250000.00', 3, '2018-06-18 03:57:01', 'erickwellem', '2018-07-20 23:29:48', 'andy'),
(35, 9, 'W450', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also be designated as W.', '250000.00', 3, '2018-06-18 03:57:01', 'erickwellem', '2018-07-20 23:10:45', 'andy'),
(36, 9, 'WS', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also be designated as W.', '250000.00', 3, '2018-06-18 03:57:01', 'erickwellem', '2018-07-20 23:28:51', 'andy'),
(37, 9, 'LWP', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also be designated as W.', '250000.00', 3, '2018-06-18 03:57:01', 'erickwellem', '2018-07-20 23:28:14', 'andy'),
(38, 9, 'SWP', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also be designated as W.', '250000.00', 3, '2018-06-18 03:57:01', 'erickwellem', '2018-07-20 23:27:31', 'andy'),
(39, 10, 'SW320', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also classified as W. Color quality classified as Second Quality Scorched.', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '2018-07-20 23:26:59', 'andy'),
(40, 10, 'SW360', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also classified as W. Color quality classified as Second Quality Scorched.', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '2018-07-20 23:26:19', 'andy'),
(41, 10, 'LSP', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also classified as W. Color quality classified as Second Quality Scorched.', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '2018-07-20 23:25:30', 'andy'),
(42, 11, 'SSW400', 'A cashew kernel is classified as whole if it has the characteristic shape of a cashew kernel and not more than 1/8th of the kernel has been broken off. This grade may also classified d as W. Color quality classified as Third Quality Scorched.', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '2018-07-20 23:24:11', 'andy'),
(43, 12, 'SK1', 'Cahsew kernels would qualify as First or Second Quality, except that they have pitted spots.', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '2018-07-20 23:23:13', 'andy'),
(44, 24, 'DW2', 'Dessert Quality', '250000.00', 0, '2018-06-04 09:05:00', 'erickwellem', '2018-07-20 23:22:40', 'andy'),
(45, 8, 'Livestock', '<a href=\"http://www.comextra.com/feedback\">LIMOUSIN CATTLE</a><br>\r\n<a href=\"http://www.comextra.com/feedback\">SIMMENTAL CATTLE</a><br>\r\n<a href=\"http://www.comextra.com/feedback\">BRANGUS CATTLE</a><br>\r\n<a href=\"http://www.comextra.com/feedback\">BALI CATTLE</a>', '250000.00', 1, '2018-06-29 22:27:44', 'andy', '2018-06-29 22:33:29', 'andy'),
(46, 20, 'Peternakan', '<a href=\"http://www.comextra.com/kontak\">SAPI LIMOSIN</a><br>\r\n<a href=\"http://www.comextra.com/kontak\">SAPI SIMENTAL</a><br>\r\n<a href=\"http://www.comextra.com/kontak\">SAPI BRANGUS</a><br>\r\n<a href=\"http://www.comextra.com/kontak\">SAPI BALI</a>', '250000.00', 1, '2018-06-29 22:28:51', 'andy', '2018-06-30 07:22:17', 'andy');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cm_products_categories`
--

DROP TABLE IF EXISTS `cm_products_categories`;
CREATE TABLE `cm_products_categories` (
  `id_product_category` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `parent_category` int(10) UNSIGNED NOT NULL,
  `description` text NOT NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'no',
  `sequence` int(5) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `created_by` varchar(64) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Product Categories Table - Erick Wellem';

--
-- Dumping data untuk tabel `cm_products_categories`
--

INSERT INTO `cm_products_categories` (`id_product_category`, `title`, `parent_category`, `description`, `published`, `sequence`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Cashew Kernel', 0, 'Cashew Kernel Product Category', 'yes', 1, '2018-05-10 13:14:16', 'erickwellem', '2018-06-11 16:01:59', 'erickwellem'),
(2, 'Cocoa Bean', 0, 'Cocoa Bean Product Category', 'yes', 2, '2018-05-10 13:16:36', 'erickwellem', '2018-06-07 01:08:15', 'erickwellem'),
(3, 'Cashew Nut Shell Liquid (CNSL)', 0, 'Cashew Nut Shell Liquid (CNSL) Product Category', 'yes', 3, '2018-05-10 13:26:29', 'erickwellem', '2018-06-04 17:11:03', 'erickwellem'),
(4, 'Cashew Shell Cake', 0, 'Cashew Shell Cake Product Category', 'yes', 4, '2018-05-10 13:28:44', 'erickwellem', '2018-06-04 17:11:33', 'erickwellem'),
(5, 'Animal Feed', 0, 'Animal Feed Product Category', 'yes', 5, '2018-05-10 13:34:27', 'erickwellem', '2018-06-04 17:04:00', 'erickwellem'),
(6, 'Cocoa by Produce', 0, 'Cocoa by Produce Product Category', 'yes', 6, '2018-05-10 13:35:16', 'erickwellem', '2018-06-04 17:13:33', 'erickwellem'),
(7, 'Rice', 0, 'Rice Product Category', 'yes', 7, '2018-05-10 13:35:53', 'erickwellem', '2018-06-04 17:17:18', 'erickwellem'),
(8, 'Livestock', 0, 'Livestock Product Category', 'yes', 8, '2018-05-10 13:36:19', 'erickwellem', '2018-06-04 11:17:58', 'erickwellem'),
(13, 'Kacang Mede', 0, 'Kacang Mede Product Category', 'yes', 1, '2018-05-10 13:14:16', 'erickwellem', '2018-06-07 01:06:19', 'erickwellem'),
(14, 'Biji Kakao', 0, 'Biji Kakao Product Category', 'yes', 2, '2018-05-10 13:16:36', 'erickwellem', '2018-06-07 01:07:03', 'erickwellem'),
(15, 'CNSL', 0, 'CNSL Product Category', 'yes', 3, '2018-05-10 13:26:29', 'erickwellem', '2018-06-04 17:11:58', 'erickwellem'),
(16, 'Cake Kulit Mede', 0, 'Cangkang Mede Product Category', 'yes', 4, '2018-05-10 13:28:44', 'erickwellem', '2018-06-29 23:22:13', 'andy'),
(17, 'Pakan Ternak', 0, 'Makanan Ternak Product Category', 'yes', 5, '2018-05-10 13:34:27', 'erickwellem', '2018-06-30 08:43:06', 'andy'),
(18, 'Produk Turunan Kakao', 0, 'Produk Turunan Kakao Product Category', 'yes', 6, '2018-05-10 13:35:16', 'erickwellem', '2018-06-04 17:16:43', 'erickwellem'),
(19, 'Beras', 0, 'Beras Product Category', 'yes', 7, '2018-05-10 13:35:53', 'erickwellem', '2018-06-04 17:05:54', 'erickwellem'),
(20, 'Peternakan', 0, 'Ternak Product Category', 'yes', 8, '2018-05-10 13:36:19', 'erickwellem', '2018-06-29 23:13:05', 'andy');

-- --------------------------------------------------------

--
-- Struktur dari tabel `email`
--

DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fst_owner_by` enum('USER','CUSTOMER','','') NOT NULL,
  `fin_owner_id` int(11) NOT NULL,
  `fst_email` text NOT NULL,
  `fbl_primary` tinyint(1) NOT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fst_group_name` varchar(256) NOT NULL,
  `fst_desc` text NOT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`fin_id`, `fst_group_name`, `fst_desc`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(1, 'Administrator', 'Super User', 'ACTIVE', '2019-02-13 00:00:00', 1, '0000-00-00 00:00:00', 0),
(2, 'User', 'User', 'ACTIVE', '2019-02-13 00:00:00', 1, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_order` int(11) NOT NULL,
  `fst_menu_name` varchar(256) NOT NULL,
  `fst_caption` varchar(256) NOT NULL,
  `fst_icon` varchar(256) NOT NULL,
  `fst_type` enum('HEADER','TREEVIEW','','') NOT NULL DEFAULT 'HEADER',
  `fst_link` text,
  `fin_parent_id` int(11) NOT NULL,
  `fbl_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`fin_id`, `fin_order`, `fst_menu_name`, `fst_caption`, `fst_icon`, `fst_type`, `fst_link`, `fin_parent_id`, `fbl_active`) VALUES
(1, 1, 'main_navigation', 'MAIN NAVIGATION', '', 'HEADER', NULL, 0, 1),
(2, 2, 'sample_tamplet', 'Sample Tamplate\r\n\r\n', '<i class=\"fa fa-dashboard\"></i>', 'TREEVIEW', NULL, 0, 1),
(3, 1, 'general_form', 'General Form', '<i class=\"fa fa-circle-o\"></i>', 'TREEVIEW', 'welcome/general_element', 2, 1),
(4, 2, 'pagging', 'Pagination', '<i class=\"fa fa-circle-o\"></i>', 'TREEVIEW', 'welcome/pagination', 2, 1),
(5, 3, 'layout_options', 'Layout Options', '<i class=\"fa fa-files-o\"></i>', 'TREEVIEW', 'layout_option.htrml', 0, 1),
(6, 4, 'forms', 'Forms', '<i class=\"fa fa-edit\"></i>', 'TREEVIEW', 'forms.htrml', 0, 1),
(7, 1, 'form_general', 'General Element', '<i class=\"fa fa-circle-o\"></i>', 'TREEVIEW', 'welcome/general_element', 6, 1),
(8, 2, 'form_advanced', 'Advanced Elements', '<i class=\"fa fa-circle-o\"></i>', 'TREEVIEW', 'welcome/advanced_element', 6, 1),
(9, 3, 'form_editors', 'Editors', '<i class=\"fa fa-circle-o\"></i>', 'TREEVIEW', 'welcome/editor', 6, 1),
(10, 5, 'system_admin', 'SYSTEM ADMIN', '', 'HEADER', '', 0, 1),
(11, 6, 'users_list', 'User Management', '<i class=\"fa fa-edit\"></i>', 'TREEVIEW', 'system/user/list', 0, 1),
(12, 7, 'transaksi_penjualan', 'Penjualan', '<i class=\"fa fa-edit\"></i>', 'TREEVIEW', 'sample/penjualan', 0, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fst_username` varchar(50) NOT NULL,
  `fst_password` varchar(256) NOT NULL,
  `fst_fullname` varchar(256) NOT NULL,
  `fst_gender` enum('M','F') NOT NULL,
  `fdt_birthdate` date NOT NULL,
  `fst_birthplace` varchar(256) NOT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`fin_id`, `fst_username`, `fst_password`, `fst_fullname`, `fst_gender`, `fdt_birthdate`, `fst_birthplace`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(1, 'devibong@yahoo.com', '06a6077b0cfcb0f4890fb5f2543c43be', 'Devi Bastian', 'M', '1978-08-26', 'Pematang Siantar', 'DELETED', '2019-02-04 08:32:10', 1, '2019-02-04 08:32:10', 1),
(2, 'donna.natalisa@yahoo.com', '06a6077b0cfcb0f4890fb5f2543c43be', 'Donna Natalisa', 'M', '1977-12-08', 'Jakarta', 'ACTIVE', '2019-02-04 08:32:10', 1, '2019-02-04 08:32:10', 1),
(25, 'devibong1@gmail.com', '4a094e453e6ee6a8253def63db4d1509', 'Devi Bastian', 'M', '1978-08-26', 'P. Siantar', 'ACTIVE', '2019-02-13 16:47:53', 1, '2019-02-13 16:47:53', 1),
(33, 'test@test.com', '4a094e453e6ee6a8253def63db4d1509', 'ini user test', 'M', '2019-03-06', 'Jakarta', 'DELETED', '2019-03-01 10:14:58', 1, '2019-03-01 10:14:58', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_group`
--

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_user_id` int(10) NOT NULL,
  `fin_group_id` int(10) NOT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_group`
--

INSERT INTO `user_group` (`fin_id`, `fin_user_id`, `fin_group_id`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(9, 1, 1, 'ACTIVE', '2019-02-13 16:47:53', 1, '2019-02-13 16:47:53', 1),
(10, 1, 2, 'ACTIVE', '2019-02-13 16:47:53', 1, '2019-02-13 16:47:53', 1),
(13, 33, 1, 'ACTIVE', '2019-03-01 10:14:58', 1, '2019-03-01 10:14:58', 1),
(14, 33, 2, 'ACTIVE', '2019-03-01 10:14:58', 1, '2019-03-01 10:14:58', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `address`
--
ALTER TABLE `address`
  ADD UNIQUE KEY `fin_id` (`fin_id`),
  ADD UNIQUE KEY `unique_name` (`fst_owner_by`,`fin_owner_id`,`fst_name`);

--
-- Indeks untuk tabel `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indeks untuk tabel `cm_detail_penjualan`
--
ALTER TABLE `cm_detail_penjualan`
  ADD PRIMARY KEY (`fin_id`);

--
-- Indeks untuk tabel `cm_header_penjualan`
--
ALTER TABLE `cm_header_penjualan`
  ADD PRIMARY KEY (`fin_id`);

--
-- Indeks untuk tabel `cm_products`
--
ALTER TABLE `cm_products`
  ADD PRIMARY KEY (`id_product`);

--
-- Indeks untuk tabel `cm_products_categories`
--
ALTER TABLE `cm_products_categories`
  ADD PRIMARY KEY (`id_product_category`);

--
-- Indeks untuk tabel `email`
--
ALTER TABLE `email`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `groups`
--
ALTER TABLE `groups`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `user_group`
--
ALTER TABLE `user_group`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `address`
--
ALTER TABLE `address`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `cm_detail_penjualan`
--
ALTER TABLE `cm_detail_penjualan`
  MODIFY `fin_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `cm_header_penjualan`
--
ALTER TABLE `cm_header_penjualan`
  MODIFY `fin_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `cm_products`
--
ALTER TABLE `cm_products`
  MODIFY `id_product` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `cm_products_categories`
--
ALTER TABLE `cm_products_categories`
  MODIFY `id_product_category` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `email`
--
ALTER TABLE `email`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `groups`
--
ALTER TABLE `groups`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `user_group`
--
ALTER TABLE `user_group`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
