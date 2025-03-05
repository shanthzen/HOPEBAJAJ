-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2025 at 10:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hope_student_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `enrolled_students`
--

CREATE TABLE `enrolled_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_credential` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  `student_photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `enrolled_students`
--

INSERT INTO `enrolled_students` (`id`, `name`, `full_name`, `email`, `user_credential`, `contact_number`, `whatsapp_number`, `batch_id`, `batch_no`, `batch_timings`, `faculty_name`, `enrollment_date`, `course_enrolled`, `status`, `id_proof_type`, `id_proof_number`, `date_of_birth`, `gender`, `qualification`, `college_name`, `college_address`, `looking_for_job`, `photo`, `student_signature`, `created_at`, `updated_at`, `deleted_at`, `is_pursuing`, `student_photo`) VALUES
(1, 'Shanth Kumar', 'Shanth Kumar', 'user15@hopeww.in', NULL, '9900322444', '9900322444', NULL, '2', '18:54:00', 'Neha', '2025-02-11', 'Default Course', 'active', 'Aadhar', '615522781974', '2025-02-21', 'Male', 'bcom', 'IGNOU', 'Tejus’ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,', 1, NULL, 'students/signatures/88QxyrhV8iDsNQHA31aiocV6LXuUvTUMDZgRIgFU.jpg', '2025-02-11 05:52:45', '2025-02-11 09:29:40', NULL, 0, 'students/photos/pkW8Iu9LVc4YztrDBNEwhZBN5Fz4HgiqVHqjKxuv.jpg'),
(2, 'Shanth Kumar', 'Shanth Kumar', 'shanth101@hopeww.in', NULL, '9900322444', '9900322444', NULL, '10', '23:39:00', 'Neha', '2025-02-12', 'Default Course', 'active', 'Aadhar', '635522781974', '2025-02-15', 'Male', 'bca', 'IGNOU', 'Tejus’ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,', 0, NULL, 'students/signatures/KdPhITdysYwvWTBkt9tjJtkZmC6X0la7tE0M80eW.jpg', '2025-02-12 10:39:41', '2025-02-12 10:40:01', NULL, 1, 'students/photos/FCceswrnRu7Op1BxeaDUCl63ou09r8wn22FJ9bQ1.jpg'),
(3, 'Shanth Kumar', 'Shanth Kumar', 'shanth33@hopeww.in', NULL, '9900322444', '9900322444', NULL, '10', '11:42:00', 'Neha', '2025-02-13', 'Default Course', 'active', 'Aadhar', '665512781974', '2025-02-15', 'Male', 'bca', 'IGNOU', 'Tejus’ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,', 0, NULL, 'students/signatures/ltINJt7XFbafgFSibxJrIiEZ1SCEYMRu1E4QhH5v.jpg', '2025-02-12 23:42:11', '2025-02-12 23:42:11', NULL, 1, 'students/photos/ZUuMD3ImZAjpKpVwWpBncVZY8sNdDJjILdcjUjqh.jpg'),
(4, 'Shanth Kumar', 'Shanth Kumar', 'shanthw@hopeww.in', NULL, '9900322444', '9900322444', NULL, '10', '15:12:00', 'Neha', '2025-02-13', 'Default Course', 'active', 'Aadhar', '615722781974', '2025-02-14', 'Male', 'bca', 'IGNOU', 'Tejus’ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,', 1, NULL, 'students/signatures/PFG7GA8nLsGaMU86InL5CEJOeLDucfgM1dB9l8YE.jpg', '2025-02-13 03:12:32', '2025-02-13 03:12:32', NULL, 0, 'students/photos/flUh3WwmeJUhnQ8ObPnD6XO5HBPihErqwaS1NV3V.jpg'),
(5, 'Shanth Kumar', 'Shanth Kumar', 'user100@hopeww.in', NULL, '9900322444', '9900322444', NULL, '10', '15:49:00', 'Neha', '2025-02-13', 'Default Course', 'active', 'Aadhar', '615222781974', '2025-02-14', 'Male', 'bca', 'IGNOU', 'Tejus’ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,', 0, NULL, 'students/signatures/CHD0dK74XcjGXC9Aw0emANV8sIt934eywyxf3pHO.jpg', '2025-02-13 03:49:21', '2025-02-13 03:49:21', NULL, 1, 'students/photos/LiHgFXvdDl60RRJalfhXe1wkoevQ5NZvkAH6O2Xy.jpg'),
(6, 'Shanth Kumar', 'Shanth Kumar', 'uselr@hopeww.in', '12345678', '9900322444', '9900322444', NULL, '10', '17:09:00', 'Neha', '2025-02-13', 'Default Course', 'active', 'Aadhar', '615532781974', '2025-02-15', 'Male', 'bca', 'IGNOU', 'Tejus’ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,', 0, NULL, 'students/signatures/spU5BqllDNkhULoEycOujaKwOMrFYGCZudvGPpSD.jpg', '2025-02-13 04:08:17', '2025-02-13 04:21:27', NULL, 1, 'students/photos/vv6Wfafp2bcceAYPhHcNNd6p65bReUQTCvjo7rkv.jpg'),
(7, 'Shanth Kumar G', 'Shanth Kumar G', 'user13@hopeww.in', NULL, '9900322444', '9900322444', NULL, '10', '20:10:00', 'Neha', '2025-02-14', 'Default Course', 'active', 'Aadhar', '515522781974', '2025-02-12', 'Male', 'bca', 'IGNOU', 'Tejus’ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,', 1, NULL, 'students/signatures/vKb0Ef8iyh3N0R9VmgzuJBc9MIYATFKo1VemNRr4.jpg', '2025-02-14 06:07:58', '2025-02-14 06:07:58', NULL, 0, 'students/photos/zdiyjruXaLU70uDaji0aE5UX6Hd860Ofajq22uzo.jpg'),
(8, 'SK', 'SK', 'user36@hopeww.in', NULL, '9900322444', '9900322444', NULL, '10', '20:00:00', 'Neha', '2025-02-14', 'Default Course', 'active', 'Aadhar', '675522781974', '2025-02-20', 'Male', 'bca', 'IGNOU', 'Tejus’ No. 18, Saraswatiammal Road, Vivekananda Nagar, Maruthi Sevanagar,', 0, NULL, 'students/signatures/n5iw5b0q3srAk1eI7Xgz2CpI9ekNqfjR5XLMjD2u.jpg', '2025-02-14 06:57:40', '2025-02-14 06:57:40', NULL, 1, 'students/photos/XBLcnXxWAa6dE8qHnMOsoC7tDg3MRaxRN2ndGtOQ.jpg'),
(9, 'Shanth', 'Shanth', 'shanth@hopeww.in', NULL, '9900700999', '9900700999', NULL, '2', '14:28:00', 'Neha', '2025-02-16', 'Default Course', 'active', 'Aadhar', '799456123456', '2025-02-14', 'Male', 'ba', 'ignou', 'djflsjflsdjf', 0, NULL, 'students/signatures/YCimcWjD2RknA00iH1Qt8HZ49OgJomlRPJOXKRE7.jpg', '2025-02-16 03:27:27', '2025-02-16 03:27:27', NULL, 1, 'students/photos/tUzSV0aOBByKugHKkYd6VuKwe0Bx04WbvDyIXUw8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `export_histories`
--

CREATE TABLE `export_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `format` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `export_histories`
--

INSERT INTO `export_histories` (`id`, `type`, `format`, `status`, `file_path`, `created_at`, `updated_at`) VALUES
(1, 'students', 'csv', 'completed', 'students_export_2025-02-12_160022.csv', '2025-02-12 10:30:22', '2025-02-12 10:30:22'),
(2, 'graduates', 'csv', 'completed', 'graduates_export_2025-02-12_160028.csv', '2025-02-12 10:30:28', '2025-02-12 10:30:28'),
(3, 'placements', 'csv', 'completed', 'placement_details_2025-02-12_160031.csv', '2025-02-12 10:30:31', '2025-02-12 10:30:31'),
(4, 'students', 'csv', 'completed', 'students_export_2025-02-12_161950.csv', '2025-02-12 10:49:50', '2025-02-12 10:49:50'),
(5, 'students', 'csv', 'completed', 'students_export_2025-02-13_095203.csv', '2025-02-13 04:22:03', '2025-02-13 04:22:03'),
(6, 'placements', 'csv', 'completed', 'placement_details_2025-02-14_101446.csv', '2025-02-14 04:44:46', '2025-02-14 04:44:46'),
(7, 'placements', 'csv', 'completed', 'placement_details_2025-02-14_225916.csv', '2025-02-14 17:29:16', '2025-02-14 17:29:16');

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
-- Table structure for table `graduates`
--

CREATE TABLE `graduates` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `certificate_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `graduates`
--

INSERT INTO `graduates` (`id`, `name`, `batch_no`, `certificate_no`, `created_at`, `updated_at`, `deleted_at`, `phone_number`, `aadhar_number`, `id_proof_type`, `id_proof_number`, `course_name`, `course_duration`, `start_date`, `end_date`, `total_days_attended`, `certificate_path`) VALUES
(1, 'Shan', '2', '1234', '2025-02-11 05:53:22', '2025-02-11 05:53:22', NULL, '9900122333', NULL, 'Aadhar', '615522781974', 'CN', 'CD', '2025-02-22', '2025-02-28', 10, 'graduates/certificates/EQzcHzSbvsYDNAl16CwqWIlVJcsX0dO1V5CCd9M9.pdf'),
(2, 'SK', '2', '12345', '2025-02-11 08:01:44', '2025-02-11 08:02:12', '2025-02-11 08:02:12', '9900122333', NULL, 'Aadhar', '615522781975', 'CN', '3 months', '2025-02-12', '2025-02-28', 30, NULL),
(3, 'SK', '2', '12346', '2025-02-11 08:03:08', '2025-02-11 08:16:07', NULL, '9900122333', '615522781978', 'Aadhar', '61552278198', 'BCA', '3 months', '2025-02-21', '2025-02-28', 1, 'graduates/certificates/l02BfVRkBUn0nUniuEchehE5YXfIPeSNnZ0UBFgS.pdf'),
(4, 'Desktop', '10', '12341', '2025-02-14 04:42:42', '2025-02-14 04:43:09', NULL, '9900122333', '615522881978', 'Aadhar', '615521781974', 'Python', '3 months', '2025-02-19', '2025-02-26', 10, 'graduates/certificates/VLrod3di7EN5jMkzxt3KnGdhClDhO9EGD8FZRzPp.jpg'),
(5, 'Kumar', '2', '123456432', '2025-02-14 17:18:27', '2025-02-14 17:18:27', NULL, '9900700999', NULL, 'Aadhar', '789457123456', 'bb', '5', '2025-02-20', '2025-02-28', 1, 'graduates/certificates/w7zHrnNlBuHCSU2L5YHqm84d62xS7RPjrCrzi7cL.jpg');

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2025_02_11_071141_add_role_to_users_table', 1),
(5, '2025_02_11_094114_create_batches_table', 1),
(6, '2025_02_11_094115_create_enrolled_students_table', 1),
(7, '2025_02_11_094116_create_graduates_table', 1),
(8, '2025_02_11_094117_create_placed_students_table', 1),
(9, '2025_02_11_103956_add_user_id_to_enrolled_students_table', 1),
(10, '2025_02_11_104056_add_missing_columns_to_enrolled_students_table', 1),
(11, '2025_02_11_104446_modify_enrollment_date_in_enrolled_students_table', 1),
(12, '2025_02_11_104753_modify_course_enrolled_in_enrolled_students_table', 1),
(13, '2025_02_11_105139_create_placements_table', 1),
(14, '2025_02_11_110333_update_graduates_table_structure', 1),
(15, '2025_02_11_114745_update_placed_students_table', 1),
(16, '2025_02_11_000000_create_export_histories_table', 2),
(17, '2025_02_11_134446_add_aadhar_number_to_graduates_table', 3),
(18, '2025_02_11_135000_add_plain_password_to_enrolled_students_table', 4),
(19, '2025_02_12_155955_create_export_histories_table', 5),
(20, '2025_02_12_163408_create_password_reset_tokens_table', 6),
(21, '2025_02_13_143000_remove_user_columns_from_enrolled_students', 7),
(22, '2025_02_13_095009_add_user_credential_to_enrolled_students_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('shanth@hopeww.in', '$2y$12$j5a7.2VeK.NJb5ACGiAKKesW8MgudQato.KgGu19/yiqdaDuCFFta', '2025-02-12 11:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `placed_students`
--

CREATE TABLE `placed_students` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `placed_students`
--

INSERT INTO `placed_students` (`id`, `sl_no`, `batch_no`, `name`, `phone_number`, `company_name`, `designation`, `salary`, `supporting_documents`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '1', '2', 'Shan', '9900122333', 'HOPE', 'SA', 500000.00, 'placements/documents/V271dmyeBIHkxpo2eQ86dI93MhyTSJggWiyPAhW7.pdf', '2025-02-11 05:51:38', '2025-02-11 09:28:52', NULL),
(2, '2', '2', 'kumar', '9900122337', 'HOPE', 'SAm', 250000.00, 'placements/documents/97GX96gNzL9pQtrm9RmCkmrO9TSK4clKehc0UyOv.pdf', '2025-02-11 07:54:51', '2025-02-11 09:29:08', NULL),
(3, '4', '2', 'Regan', '9900124333', 'HOPE', 'SA', 800000.00, 'placements/documents/dhcEA6TATxaaLSwDu7ZdwOlwq6bjO3CRul0oAzlv.pdf', '2025-02-11 07:58:06', '2025-02-11 09:28:32', NULL),
(4, '5', '10', 'Desktop', '9900122333', 'HOPE1', 'SAm', 400000.00, 'placements/documents/QQeBiPu0Fn8MTi8nyjcjbnw0zbcEu1UZGvePsWeb.jpg', '2025-02-14 04:39:33', '2025-02-14 04:39:33', NULL),
(5, '5', '10', 'SK', '9900122337', 'HOPE', 'SA', 44500000.00, 'placements/documents/2duisF8pJaKVDHhzDLqH503bSXogcsOcldtBEV1q.jpg', '2025-02-14 06:05:35', '2025-02-14 17:21:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `placements`
--

CREATE TABLE `placements` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Shantha Kumar G', 'shanth@hopeww.in', NULL, '$2y$12$h35wtTDym.1IXFW.dynNX.Rh7xU2mjsyKpkzbLLCd7WVS1Y7MV1oK', 'admin', NULL, '2025-02-11 05:51:07', '2025-02-14 04:38:42'),
(2, 'Shanth Kumar', 'user15@hopeww.in', NULL, '$2y$12$88xiEwM1F74xGZQ0WaAiuOjc5/85/HaSBQrzMmGXbna4XPx.YHBBq', 'user', NULL, '2025-02-11 05:52:45', '2025-02-14 06:38:32'),
(5, 'Shanth Kumar', 'shanth101@hopeww.in', NULL, '$2y$12$RFmlH1LQrU2d08i69w5z7eD4umxD4cQIiP.E6ZosVqR9YSMlZlq.a', 'student', NULL, '2025-02-12 10:39:41', '2025-02-12 10:39:41'),
(6, 'Shanth Kumar', 'shanth33@hopeww.in', NULL, '$2y$12$1rB72gEeJq0nvsv6j7otDunkXYMHXWCbsFVWvlk601PQyJ9Y0elBC', 'student', NULL, '2025-02-12 23:42:11', '2025-02-12 23:42:11'),
(7, 'Shanth Kumar', 'uselr@hopeww.in', NULL, '$2y$12$RaWzWUBv.j1.M1/m03eGMeJHrlMNRz8cY0NUz/o.jTN3NQdGMSVyq', 'user', NULL, '2025-02-13 04:16:11', '2025-02-13 04:18:54'),
(8, 'Shanth Kumar G', 'user13@hopeww.in', NULL, '$2y$12$gp/cmZ7XV.Zz/ZCu7fFwsO8q3sIgn8bBuTED4ud4qAbbwoKSVfJnu', 'user', NULL, '2025-02-14 06:07:59', '2025-02-14 06:07:59'),
(9, 'Media HOPE', 'media@hopeww.in', NULL, '$2y$12$KC4XQftyiuIsCMrS/josHOb/VzlfUMtJeI1iBHmQeEEcm2ajqcCzq', 'user', NULL, '2025-02-16 02:45:41', '2025-02-16 02:45:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batches_batch_code_unique` (`batch_code`);

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
-- Indexes for table `enrolled_students`
--
ALTER TABLE `enrolled_students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `enrolled_students_email_unique` (`email`),
  ADD UNIQUE KEY `enrolled_students_id_proof_number_unique` (`id_proof_number`),
  ADD KEY `enrolled_students_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `export_histories`
--
ALTER TABLE `export_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `graduates`
--
ALTER TABLE `graduates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `graduates_id_proof_number_unique` (`id_proof_number`),
  ADD UNIQUE KEY `graduates_certificate_no_unique` (`certificate_no`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `placed_students`
--
ALTER TABLE `placed_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `placements`
--
ALTER TABLE `placements`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enrolled_students`
--
ALTER TABLE `enrolled_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `export_histories`
--
ALTER TABLE `export_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `graduates`
--
ALTER TABLE `graduates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `placed_students`
--
ALTER TABLE `placed_students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `placements`
--
ALTER TABLE `placements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrolled_students`
--
ALTER TABLE `enrolled_students`
  ADD CONSTRAINT `enrolled_students_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
