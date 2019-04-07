-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Apr 2019 pada 16.15
-- Versi server: 10.1.35-MariaDB
-- Versi PHP: 7.1.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_edoc`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `access_token`
--

DROP TABLE IF EXISTS `access_token`;
CREATE TABLE `access_token` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_user_id` int(11) NOT NULL,
  `fst_token` varchar(64) NOT NULL,
  `fdt_expiration_datetime` datetime DEFAULT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE `documents` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fst_name` varchar(256) NOT NULL,
  `fst_source` enum('INTERNAL','EXTERNAL') NOT NULL DEFAULT 'INTERNAL',
  `fst_created_via` enum('MANUAL','API') NOT NULL DEFAULT 'MANUAL',
  `fin_confidential_lvl` int(2) NOT NULL DEFAULT '5' COMMENT '0=Top management, 1=Upper management, 2=Middle management, 3=Supervisors, 4=Line workers, 5=public',
  `fst_view_scope` enum('PRIVATE','GLOBAL','CUSTOM') DEFAULT 'PRIVATE',
  `fst_print_scope` enum('PRIVATE','GLOBAL','CUSTOM') NOT NULL DEFAULT 'PRIVATE',
  `fbl_flow_control` tinyint(1) NOT NULL DEFAULT '0',
  `fin_flow_control_schema` int(11) DEFAULT NULL,
  `fst_search_marks` varchar(256) DEFAULT NULL,
  `fst_memo` text,
  `fdt_published_date` date DEFAULT NULL,
  `fbl_flow_completed` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `documents`
--

INSERT INTO `documents` (`fin_id`, `fst_name`, `fst_source`, `fst_created_via`, `fin_confidential_lvl`, `fst_view_scope`, `fst_print_scope`, `fbl_flow_control`, `fin_flow_control_schema`, `fst_search_marks`, `fst_memo`, `fdt_published_date`, `fbl_flow_completed`, `fst_active`, `fdt_insert_datetime`, `fin_insert_id`, `fdt_update_datetime`, `fin_update_id`) VALUES
(1, 'test', 'INTERNAL', 'MANUAL', 5, 'PRIVATE', 'PRIVATE', 1, NULL, NULL, NULL, NULL, 0, 'ACTIVE', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_access_histories`
--

DROP TABLE IF EXISTS `document_access_histories`;
CREATE TABLE `document_access_histories` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_document_id` bigint(20) NOT NULL,
  `fin_user_id` int(11) NOT NULL,
  `fst_access_mode` enum('VIEW','PRINT') NOT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_custom_permission`
--

DROP TABLE IF EXISTS `document_custom_permission`;
CREATE TABLE `document_custom_permission` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_document_id` bigint(20) NOT NULL,
  `fin_user_id` int(11) NOT NULL,
  `fbl_view` tinyint(1) NOT NULL DEFAULT '0',
  `fbl_print` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_details`
--

DROP TABLE IF EXISTS `document_details`;
CREATE TABLE `document_details` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_document_id` bigint(20) NOT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='suatu dokumen bisa berupa kumpulan dari dokumen2 lainnya';

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_files`
--

DROP TABLE IF EXISTS `document_files`;
CREATE TABLE `document_files` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_document_id` bigint(20) NOT NULL,
  `fst_memo` text,
  `fin_version` int(2) NOT NULL DEFAULT '0',
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_file_histories`
--

DROP TABLE IF EXISTS `document_file_histories`;
CREATE TABLE `document_file_histories` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_file_id` bigint(20) NOT NULL,
  `fst_memo` text,
  `fin_version` int(2) NOT NULL DEFAULT '0',
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `document_flow_control`
--

DROP TABLE IF EXISTS `document_flow_control`;
CREATE TABLE `document_flow_control` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_document_id` bigint(20) NOT NULL,
  `fin_seq_no` int(2) NOT NULL DEFAULT '1',
  `fin_user_id` bigint(20) NOT NULL,
  `fst_control_status` enum('NEED APPROVAL','READY TO APPROVE','APPROVED') NOT NULL DEFAULT 'NEED APPROVAL',
  `fst_memo` text,
  `fdt_approved_datetime` datetime DEFAULT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `flow_control_schema_detail`
--

DROP TABLE IF EXISTS `flow_control_schema_detail`;
CREATE TABLE `flow_control_schema_detail` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fin_flow_control_schema_id` bigint(20) NOT NULL,
  `fin_user_id` bigint(20) DEFAULT NULL,
  `fin_seq_no` int(2) DEFAULT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `flow_control_schema_header`
--

DROP TABLE IF EXISTS `flow_control_schema_header`;
CREATE TABLE `flow_control_schema_header` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fst_name` varchar(256) DEFAULT NULL,
  `fst_memo` text,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_groups`
--

DROP TABLE IF EXISTS `master_groups`;
CREATE TABLE `master_groups` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fst_name` varchar(256) NOT NULL,
  `fin_level` int(2) NOT NULL COMMENT '0=Top management, 1=Upper management, 2=Middle management, 3=Supervisors, 4=Line workers, 5=public',
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `reference_document_list`
--

DROP TABLE IF EXISTS `reference_document_list`;
CREATE TABLE `reference_document_list` (
  `fin_id` bigint(20) UNSIGNED NOT NULL,
  `fst_reff_no` varbinary(256) NOT NULL,
  `fin_document_id` bigint(20) NOT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `fst_address` text,
  `fst_phone` varchar(100) DEFAULT NULL,
  `fst_email` varchar(100) DEFAULT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `access_token`
--
ALTER TABLE `access_token`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`fin_id`),
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `document_access_histories`
--
ALTER TABLE `document_access_histories`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `document_custom_permission`
--
ALTER TABLE `document_custom_permission`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `document_details`
--
ALTER TABLE `document_details`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `document_files`
--
ALTER TABLE `document_files`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `document_file_histories`
--
ALTER TABLE `document_file_histories`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `document_flow_control`
--
ALTER TABLE `document_flow_control`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `flow_control_schema_detail`
--
ALTER TABLE `flow_control_schema_detail`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `flow_control_schema_header`
--
ALTER TABLE `flow_control_schema_header`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `master_groups`
--
ALTER TABLE `master_groups`
  ADD UNIQUE KEY `fin_id` (`fin_id`);

--
-- Indeks untuk tabel `reference_document_list`
--
ALTER TABLE `reference_document_list`
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
-- AUTO_INCREMENT untuk tabel `access_token`
--
ALTER TABLE `access_token`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `documents`
--
ALTER TABLE `documents`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `document_access_histories`
--
ALTER TABLE `document_access_histories`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `document_custom_permission`
--
ALTER TABLE `document_custom_permission`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `document_details`
--
ALTER TABLE `document_details`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `document_files`
--
ALTER TABLE `document_files`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `document_file_histories`
--
ALTER TABLE `document_file_histories`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `document_flow_control`
--
ALTER TABLE `document_flow_control`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `flow_control_schema_detail`
--
ALTER TABLE `flow_control_schema_detail`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `flow_control_schema_header`
--
ALTER TABLE `flow_control_schema_header`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_groups`
--
ALTER TABLE `master_groups`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `reference_document_list`
--
ALTER TABLE `reference_document_list`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user_group`
--
ALTER TABLE `user_group`
  MODIFY `fin_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
