-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: hope_student_management
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
-- Table structure for table `batches`
--

DROP TABLE IF EXISTS `batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `batch_name` varchar(255) NOT NULL,
  `batch_code` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `faculty_name` varchar(255) NOT NULL,
  `max_students` int(11) NOT NULL DEFAULT 30,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `batches_batch_code_unique` (`batch_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `batches`
--

LOCK TABLES `batches` WRITE;
/*!40000 ALTER TABLE `batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `batches` ENABLE KEYS */;
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
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
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
  PRIMARY KEY (`key`)
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
-- Table structure for table `enrolled_students`
--

DROP TABLE IF EXISTS `enrolled_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrolled_students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `plain_password` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `batch_id` bigint(20) unsigned DEFAULT NULL,
  `batch_no` varchar(255) NOT NULL,
  `batch_timings` time DEFAULT NULL,
  `faculty_name` varchar(255) DEFAULT NULL,
  `enrollment_date` date DEFAULT NULL,
  `course_enrolled` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `id_proof_type` varchar(255) DEFAULT NULL,
  `id_proof_number` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `college_name` varchar(255) DEFAULT NULL,
  `college_address` text DEFAULT NULL,
  `looking_for_job` tinyint(1) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL,
  `student_signature` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_pursuing` tinyint(1) NOT NULL DEFAULT 0,
  `student_photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `enrolled_students_email_unique` (`email`),
  UNIQUE KEY `enrolled_students_id_proof_number_unique` (`id_proof_number`),
  KEY `enrolled_students_batch_id_foreign` (`batch_id`),
  KEY `enrolled_students_user_id_foreign` (`user_id`),
  CONSTRAINT `enrolled_students_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  CONSTRAINT `enrolled_students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrolled_students`
--

LOCK TABLES `enrolled_students` WRITE;
/*!40000 ALTER TABLE `enrolled_students` DISABLE KEYS */;
INSERT INTO `enrolled_students` VALUES (1,2,'Shanth Kumar','Shanth Kumar','user15@hopeww.in',NULL,'9900322444','9900322444',NULL,'2','18:54:00','Neha','2025-02-11','Default Course','active','Aadhar','615522781974','2025-02-21','Male','bcom','IGNOU','TejusΓÇÖ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,',1,NULL,'students/signatures/88QxyrhV8iDsNQHA31aiocV6LXuUvTUMDZgRIgFU.jpg','2025-02-11 05:52:45','2025-02-11 09:29:40',NULL,0,'students/photos/pkW8Iu9LVc4YztrDBNEwhZBN5Fz4HgiqVHqjKxuv.jpg'),(2,5,'Shanth Kumar','Shanth Kumar','shanth101@hopeww.in','Admin@123','9900322444','9900322444',NULL,'10','23:39:00','Neha','2025-02-12','Default Course','active','Aadhar','635522781974','2025-02-15','Male','bca','IGNOU','TejusΓÇÖ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,',0,NULL,'students/signatures/KdPhITdysYwvWTBkt9tjJtkZmC6X0la7tE0M80eW.jpg','2025-02-12 10:39:41','2025-02-12 10:40:01',NULL,1,'students/photos/FCceswrnRu7Op1BxeaDUCl63ou09r8wn22FJ9bQ1.jpg'),(3,6,'Shanth Kumar','Shanth Kumar','shanth33@hopeww.in','Admin@123','9900322444','9900322444',NULL,'10','11:42:00','Neha','2025-02-13','Default Course','active','Aadhar','665512781974','2025-02-15','Male','bca','IGNOU','TejusΓÇÖ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,',0,NULL,'students/signatures/ltINJt7XFbafgFSibxJrIiEZ1SCEYMRu1E4QhH5v.jpg','2025-02-12 23:42:11','2025-02-12 23:42:11',NULL,1,'students/photos/ZUuMD3ImZAjpKpVwWpBncVZY8sNdDJjILdcjUjqh.jpg');
/*!40000 ALTER TABLE `enrolled_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `export_histories`
--

DROP TABLE IF EXISTS `export_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `export_histories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `format` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `export_histories`
--

LOCK TABLES `export_histories` WRITE;
/*!40000 ALTER TABLE `export_histories` DISABLE KEYS */;
INSERT INTO `export_histories` VALUES (1,'students','csv','completed','students_export_2025-02-12_160022.csv','2025-02-12 10:30:22','2025-02-12 10:30:22'),(2,'graduates','csv','completed','graduates_export_2025-02-12_160028.csv','2025-02-12 10:30:28','2025-02-12 10:30:28'),(3,'placements','csv','completed','placement_details_2025-02-12_160031.csv','2025-02-12 10:30:31','2025-02-12 10:30:31'),(4,'students','csv','completed','students_export_2025-02-12_161950.csv','2025-02-12 10:49:50','2025-02-12 10:49:50');
/*!40000 ALTER TABLE `export_histories` ENABLE KEYS */;
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
-- Table structure for table `graduates`
--

DROP TABLE IF EXISTS `graduates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `graduates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `certificate_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(255) NOT NULL,
  `aadhar_number` varchar(12) DEFAULT NULL,
  `id_proof_type` varchar(255) NOT NULL,
  `id_proof_number` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `course_duration` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_days_attended` int(11) NOT NULL,
  `certificate_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `graduates_id_proof_number_unique` (`id_proof_number`),
  UNIQUE KEY `graduates_certificate_no_unique` (`certificate_no`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `graduates`
--

LOCK TABLES `graduates` WRITE;
/*!40000 ALTER TABLE `graduates` DISABLE KEYS */;
INSERT INTO `graduates` VALUES (1,'Shan','2','1234','2025-02-11 05:53:22','2025-02-11 05:53:22',NULL,'9900122333',NULL,'Aadhar','615522781974','CN','CD','2025-02-22','2025-02-28',10,'graduates/certificates/EQzcHzSbvsYDNAl16CwqWIlVJcsX0dO1V5CCd9M9.pdf'),(2,'SK','2','12345','2025-02-11 08:01:44','2025-02-11 08:02:12','2025-02-11 08:02:12','9900122333',NULL,'Aadhar','615522781975','CN','3 months','2025-02-12','2025-02-28',30,NULL),(3,'SK','2','12346','2025-02-11 08:03:08','2025-02-11 08:16:07',NULL,'9900122333','615522781978','Aadhar','61552278198','BCA','3 months','2025-02-21','2025-02-28',1,'graduates/certificates/l02BfVRkBUn0nUniuEchehE5YXfIPeSNnZ0UBFgS.pdf');
/*!40000 ALTER TABLE `graduates` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2014_10_12_000000_create_users_table',1),(4,'2025_02_11_071141_add_role_to_users_table',1),(5,'2025_02_11_094114_create_batches_table',1),(6,'2025_02_11_094115_create_enrolled_students_table',1),(7,'2025_02_11_094116_create_graduates_table',1),(8,'2025_02_11_094117_create_placed_students_table',1),(9,'2025_02_11_103956_add_user_id_to_enrolled_students_table',1),(10,'2025_02_11_104056_add_missing_columns_to_enrolled_students_table',1),(11,'2025_02_11_104446_modify_enrollment_date_in_enrolled_students_table',1),(12,'2025_02_11_104753_modify_course_enrolled_in_enrolled_students_table',1),(13,'2025_02_11_105139_create_placements_table',1),(14,'2025_02_11_110333_update_graduates_table_structure',1),(15,'2025_02_11_114745_update_placed_students_table',1),(16,'2025_02_11_000000_create_export_histories_table',2),(17,'2025_02_11_134446_add_aadhar_number_to_graduates_table',3),(18,'2025_02_11_135000_add_plain_password_to_enrolled_students_table',4),(19,'2025_02_12_155955_create_export_histories_table',5),(20,'2025_02_12_163408_create_password_reset_tokens_table',6);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
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
INSERT INTO `password_reset_tokens` VALUES ('shanth@hopeww.in','$2y$12$j5a7.2VeK.NJb5ACGiAKKesW8MgudQato.KgGu19/yiqdaDuCFFta','2025-02-12 11:14:50');
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `placed_students`
--

DROP TABLE IF EXISTS `placed_students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `placed_students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sl_no` varchar(255) NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `supporting_documents` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `placed_students`
--

LOCK TABLES `placed_students` WRITE;
/*!40000 ALTER TABLE `placed_students` DISABLE KEYS */;
INSERT INTO `placed_students` VALUES (1,'1','2','Shan','9900122333','HOPE','SA',500000.00,'placements/documents/V271dmyeBIHkxpo2eQ86dI93MhyTSJggWiyPAhW7.pdf','2025-02-11 05:51:38','2025-02-11 09:28:52',NULL),(2,'2','2','kumar','9900122337','HOPE','SAm',250000.00,'placements/documents/97GX96gNzL9pQtrm9RmCkmrO9TSK4clKehc0UyOv.pdf','2025-02-11 07:54:51','2025-02-11 09:29:08',NULL),(3,'4','2','Regan','9900124333','HOPE','SA',800000.00,'placements/documents/dhcEA6TATxaaLSwDu7ZdwOlwq6bjO3CRul0oAzlv.pdf','2025-02-11 07:58:06','2025-02-11 09:28:32',NULL);
/*!40000 ALTER TABLE `placed_students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `placements`
--

DROP TABLE IF EXISTS `placements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `placements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sl_no` int(11) NOT NULL,
  `batch_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `supporting_documents` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `placements`
--

LOCK TABLES `placements` WRITE;
/*!40000 ALTER TABLE `placements` DISABLE KEYS */;
/*!40000 ALTER TABLE `placements` ENABLE KEYS */;
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
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Shantha Kumar','shanth@hopeww.in',NULL,'$2y$12$h35wtTDym.1IXFW.dynNX.Rh7xU2mjsyKpkzbLLCd7WVS1Y7MV1oK','admin',NULL,'2025-02-11 05:51:07','2025-02-11 05:51:07'),(2,'Shanth Kumar','user15@hopeww.in',NULL,'$2y$12$kN5L36Oek7zG9xBLUUB3lu/XEMT/pS6a0XVpWGoKs9Hn8.4TlQgai','user',NULL,'2025-02-11 05:52:45','2025-02-11 08:30:34'),(5,'Shanth Kumar','shanth101@hopeww.in',NULL,'$2y$12$RFmlH1LQrU2d08i69w5z7eD4umxD4cQIiP.E6ZosVqR9YSMlZlq.a','student',NULL,'2025-02-12 10:39:41','2025-02-12 10:39:41'),(6,'Shanth Kumar','shanth33@hopeww.in',NULL,'$2y$12$1rB72gEeJq0nvsv6j7otDunkXYMHXWCbsFVWvlk601PQyJ9Y0elBC','student',NULL,'2025-02-12 23:42:11','2025-02-12 23:42:11');
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

-- Dump completed on 2025-02-13 11:02:48
