-- ==========================================
-- DAFTAR AKUN UNTUK TESTING APLIKASI
-- ==========================================
-- [Superadmin]
-- Email: superadmin@contoh.com
-- Password: password (default)
--
-- [Admin Prodi - Sistem Informasi]
-- Email: admin@si.contoh.com
-- Password: password (default)
--
-- [Dosen] - Daftar manual via /register (pilih peran: Dosen, isi NIDN)
-- Email: dosen1@gmail.com / dosen2@gmail.com / dst.
-- Password: sesuai saat registrasi
--
-- [Mahasiswa] - Daftar manual via /register (pilih peran: Mahasiswa, isi NIM)
-- Email: mahasiswa@test.com / dst.
-- Password: sesuai saat registrasi
--
-- CATATAN ALUR PEMBIMBING (versi terbaru):
-- Mahasiswa mengajukan Pembimbing 1 (isi judul + upload proposal + pilih dosen)
-- Dosen terima/tolak dari menu Skripsi Saya
-- Setelah P1 diterima, mahasiswa bisa ajukan Pembimbing 2 (proses sama)
-- Prodi TIDAK terlibat dalam pemilihan pembimbing
-- ==========================================
---- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: bimbinganskripsi
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bimbingans`
--

DROP TABLE IF EXISTS `bimbingans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bimbingans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint(20) unsigned NOT NULL,
  `dosen_id` bigint(20) unsigned NOT NULL,
  `tipe_bimbingan` enum('pembimbing_1','pembimbing_2') NOT NULL DEFAULT 'pembimbing_1',
  `file` varchar(255) NOT NULL,
  `komentar` text DEFAULT NULL,
  `status` enum('menunggu','revisi','acc') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bimbingans`
--

LOCK TABLES `bimbingans` WRITE;
/*!40000 ALTER TABLE `bimbingans` DISABLE KEYS */;
INSERT INTO `bimbingans` VALUES (1,1,1,'pembimbing_1','1776676444_BIMBINGAN_H233600447.docx',NULL,'acc','2026-04-20 01:14:05','2026-04-20 01:15:12'),(2,1,2,'pembimbing_2','1776676455_BIMBINGAN_H233600447.docx',NULL,'revisi','2026-04-20 01:14:15','2026-04-20 01:16:36');
/*!40000 ALTER TABLE `bimbingans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-admin@sususetia.com|127.0.0.1','i:1;',1776745148),('laravel-cache-admin@sususetia.com|127.0.0.1:timer','i:1776745148;',1776745148),('laravel-cache-lutthpijurali12@gmail.com|127.0.0.1','i:2;',1776745273),('laravel-cache-lutthpijurali12@gmail.com|127.0.0.1:timer','i:1776745272;',1776745273),('laravel-cache-mahasiswa1@test.com|127.0.0.1','i:1;',1776909781),('laravel-cache-mahasiswa1@test.com|127.0.0.1:timer','i:1776909781;',1776909781);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dosens`
--

DROP TABLE IF EXISTS `dosens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dosens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nidn` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dosens_nidn_unique` (`nidn`),
  KEY `dosens_user_id_foreign` (`user_id`),
  CONSTRAINT `dosens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosens`
--

LOCK TABLES `dosens` WRITE;
/*!40000 ALTER TABLE `dosens` DISABLE KEYS */;
INSERT INTO `dosens` VALUES (1,4,'12345678','oke','2026-04-20 01:07:29','2026-04-20 01:07:29'),(2,5,'12345679','okegas','2026-04-20 01:08:12','2026-04-20 01:08:12');
/*!40000 ALTER TABLE `dosens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswas`
--

DROP TABLE IF EXISTS `mahasiswas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mahasiswas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nim` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mahasiswas_nim_unique` (`nim`),
  KEY `mahasiswas_user_id_foreign` (`user_id`),
  CONSTRAINT `mahasiswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswas`
--

LOCK TABLES `mahasiswas` WRITE;
/*!40000 ALTER TABLE `mahasiswas` DISABLE KEYS */;
INSERT INTO `mahasiswas` VALUES (1,3,'H233600447','No.08 Rt.27 Jl.cut mutia','2026-04-20 01:06:00','2026-04-20 01:06:00'),(2,6,'H233600453','Jl.Cut meutia','2026-04-20 20:33:12','2026-04-20 20:33:12'),(3,7,'12345678','Jl. Test No. 1','2026-04-22 17:44:29','2026-04-22 17:44:29');
/*!40000 ALTER TABLE `mahasiswas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0000_01_01_000000_create_prodis_table',1),(2,'0001_01_01_000000_create_users_table',1),(3,'0001_01_01_000001_create_cache_table',1),(4,'0001_01_01_000002_create_jobs_table',1),(5,'2026_04_15_203455_create_bimbingans_table',1),(6,'2026_04_15_203456_create_sidangs_table',1),(7,'2026_04_15_203457_create_ruangans_table',1),(8,'2026_04_15_203458_create_pengujis_table',1),(9,'2026_04_15_203459_create_nilai_sidangs_table',1),(10,'2026_04_18_050615_create_mahasiswas_table',1),(11,'2026_04_18_050929_create_dosens_table',1),(12,'2026_04_18_051500_create_skripsis_table',1),(13,'2026_04_23_020000_add_p1_proposal_to_skripsis_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai_sidangs`
--

DROP TABLE IF EXISTS `nilai_sidangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nilai_sidangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sidang_id` bigint(20) unsigned NOT NULL,
  `dosen_id` bigint(20) unsigned NOT NULL,
  `nilai` int(11) NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('lulus','revisi','mengulang') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_sidangs`
--

LOCK TABLES `nilai_sidangs` WRITE;
/*!40000 ALTER TABLE `nilai_sidangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `nilai_sidangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengujis`
--

DROP TABLE IF EXISTS `pengujis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pengujis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sidang_id` bigint(20) unsigned NOT NULL,
  `dosen_id` bigint(20) unsigned NOT NULL,
  `peran` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengujis`
--

LOCK TABLES `pengujis` WRITE;
/*!40000 ALTER TABLE `pengujis` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengujis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodis`
--

DROP TABLE IF EXISTS `prodis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prodis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_prodi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodis`
--

LOCK TABLES `prodis` WRITE;
/*!40000 ALTER TABLE `prodis` DISABLE KEYS */;
INSERT INTO `prodis` VALUES (1,'Sistem Informasi','2026-04-20 01:00:19','2026-04-20 01:00:19');
/*!40000 ALTER TABLE `prodis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ruangans`
--

DROP TABLE IF EXISTS `ruangans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ruangans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ruangans`
--

LOCK TABLES `ruangans` WRITE;
/*!40000 ALTER TABLE `ruangans` DISABLE KEYS */;
INSERT INTO `ruangans` VALUES (1,'Lab Jarkom','Gedung J','2026-04-20 01:10:41','2026-04-20 01:10:41'),(2,'Lab RPL','Gedung J','2026-04-20 01:11:19','2026-04-20 01:11:19');
/*!40000 ALTER TABLE `ruangans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sidangs`
--

DROP TABLE IF EXISTS `sidangs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sidangs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jam` time DEFAULT NULL,
  `ruangan_id` bigint(20) unsigned DEFAULT NULL,
  `jenis_sidang` enum('proposal','akhir') NOT NULL DEFAULT 'akhir',
  `status` enum('diajukan','terjadwal','selesai','ditolak') NOT NULL DEFAULT 'diajukan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sidangs`
--

LOCK TABLES `sidangs` WRITE;
/*!40000 ALTER TABLE `sidangs` DISABLE KEYS */;
/*!40000 ALTER TABLE `sidangs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skripsis`
--

DROP TABLE IF EXISTS `skripsis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skripsis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mahasiswa_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `file_proposal` varchar(255) DEFAULT NULL,
  `pembimbing_1_id` bigint(20) unsigned DEFAULT NULL,
  `status_pembimbing_1` enum('none','menunggu','ditolak','diterima') NOT NULL DEFAULT 'none',
  `pembimbing_2_id` bigint(20) unsigned DEFAULT NULL,
  `status_pembimbing_2` enum('none','menunggu','ditolak','diterima') NOT NULL DEFAULT 'none',
  `acc_sempro_p1` tinyint(1) NOT NULL DEFAULT 0,
  `acc_sempro_p2` tinyint(1) NOT NULL DEFAULT 0,
  `acc_akhir_p1` tinyint(1) NOT NULL DEFAULT 0,
  `acc_akhir_p2` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skripsis_mahasiswa_id_foreign` (`mahasiswa_id`),
  KEY `skripsis_pembimbing_1_id_foreign` (`pembimbing_1_id`),
  KEY `skripsis_pembimbing_2_id_foreign` (`pembimbing_2_id`),
  CONSTRAINT `skripsis_mahasiswa_id_foreign` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `skripsis_pembimbing_1_id_foreign` FOREIGN KEY (`pembimbing_1_id`) REFERENCES `dosens` (`id`) ON DELETE SET NULL,
  CONSTRAINT `skripsis_pembimbing_2_id_foreign` FOREIGN KEY (`pembimbing_2_id`) REFERENCES `dosens` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skripsis`
--

LOCK TABLES `skripsis` WRITE;
/*!40000 ALTER TABLE `skripsis` DISABLE KEYS */;
INSERT INTO `skripsis` VALUES (1,1,'Pemantauan Populasi Ikan Sapu Sapu','1776910908_PROPOSAL2_H233600447.docx',2,'diterima',1,'diterima',1,0,0,0,'2026-04-20 01:09:42','2026-04-22 18:22:49'),(2,2,NULL,NULL,1,'none',2,'diterima',0,0,0,0,'2026-04-20 20:34:27','2026-04-20 20:41:08'),(3,3,'Pemantauan Populasi Ikan Sapu Sapu','1776908890_PROPOSAL_12345678.docx',1,'diterima',NULL,'none',0,0,0,0,'2026-04-22 17:48:11','2026-04-22 17:52:20');
/*!40000 ALTER TABLE `skripsis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('superadmin','admin_prodi','dosen','mahasiswa') NOT NULL DEFAULT 'mahasiswa',
  `prodi_id` bigint(20) unsigned DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_prodi_id_foreign` (`prodi_id`),
  CONSTRAINT `users_prodi_id_foreign` FOREIGN KEY (`prodi_id`) REFERENCES `prodis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Superadmin Skripsi','superadmin@contoh.com','superadmin',NULL,NULL,'$2y$12$iX..uSnbBg23.RRl0FkWTueeo8GKnjMtJAxGd3/mbZikNkP5r9JFi','tgKTDhD8Purg4Eh3zO3tZvdrNxLc5Iivk1pfEynPxsm4EJAQyKkuJaYXZJym','2026-04-20 01:00:19','2026-04-20 01:00:19'),(2,'Admin Prodi SI','admin@si.contoh.com','admin_prodi',1,NULL,'$2y$12$LfBSeAj5xkXNbo8v7CgpPORg48jrNbd1lcgODBcaKvdSRERDUabDW','Zk8eJEXkEklSrqsmMr7dPwudrso8ctH1hLACNDMCUaiPFxwlW6c1Tjvp4hSL','2026-04-20 01:00:19','2026-04-20 01:00:19'),(3,'Luthpi Jurali Hamid','luthpijurali12@gmail.com','mahasiswa',1,NULL,'$2y$12$H8VFLMllM5EhddQffcwiCeK1K7q/MTBdG2FvVDayk7cLszuVUNmLm','7n0hOP0R3KTes1mqqZnsdSXvXFk7EPMrtnDYXi3lVUWXLFGPRZWxj1owdlb4','2026-04-20 01:06:00','2026-04-20 20:27:27'),(4,'dosen1','dosen1@gmail.com','dosen',1,NULL,'$2y$12$d1a2NCtsZ4xsZrSbRm8dUO6kfyuAr3QRmcPO2JxrySy.QoSjUd.rC','ddFBoE8KhughgyCsvihUMfQVnmBl1dmgPwia7QniuT5McbizMpwygm2hO4iN','2026-04-20 01:07:29','2026-04-20 01:09:54'),(5,'dosen2','dosen2@gmail.com','dosen',1,NULL,'$2y$12$ip3bQJte/IEvQRBzKM7/GeHKKPQ2r42QnSCiVKkpgOYt7vPE1d57u','IWHzGHKYh7vQaBNaRJgYCRvg5nep4iYVhXoS2GFvloHXSZLa71ZiDB9JBn7u','2026-04-20 01:08:12','2026-04-20 01:08:12'),(6,'mahasiswa 2','luthpijurali04@gmail.com','mahasiswa',1,NULL,'$2y$12$KkZARaYNVk7WooecKFAEz.14UuxmfWjO2jF3LZCX4lz7jbJujLwfq','T5ijvCuJf7WgJggLozKkdgJivcF52DKUyeWEePHQHbRFz0ITJxbygFZeqGnR','2026-04-20 20:33:12','2026-04-20 20:34:27'),(7,'luthpiMahasiswa Test','mhs@test.com','mahasiswa',1,NULL,'$2y$12$HfYJdohFSjvl.gNTvolABu0JxltSrpdb24ciXvlZ9Ue11h0jLEC.a',NULL,'2026-04-22 17:44:29','2026-04-22 17:44:29');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-23 10:24:41
