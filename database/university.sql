-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 06:17 PM
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
-- Database: `university`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic_calendars`
--

CREATE TABLE `academic_calendars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `academic_term_id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `is_holiday` tinyint(1) NOT NULL DEFAULT 0,
  `is_campus_closed` tinyint(1) NOT NULL DEFAULT 0,
  `color_code` varchar(255) DEFAULT NULL,
  `visibility` varchar(255) NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `academic_terms`
--

CREATE TABLE `academic_terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `registration_start_date` date NOT NULL,
  `registration_end_date` date NOT NULL,
  `add_drop_deadline` date DEFAULT NULL,
  `withdrawal_deadline` date DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `academic_year` varchar(255) DEFAULT NULL,
  `term_type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
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
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', '2025-05-18 18:04:15', '$2y$12$URhggHnjCAZoZP2dLOP4yemQ8rYSQJpA7..27eA4s3ybAqympJymO', NULL, '2025-05-18 18:04:15', '2025-05-18 18:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `target_audience` varchar(255) NOT NULL DEFAULT 'all',
  `target_id` bigint(20) UNSIGNED DEFAULT NULL,
  `importance` varchar(255) NOT NULL DEFAULT 'normal',
  `publish_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `show_on_dashboard` tinyint(1) NOT NULL DEFAULT 1,
  `send_email` tinyint(1) NOT NULL DEFAULT 0,
  `send_notification` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `documents` text DEFAULT NULL COMMENT 'JSON array of document paths',
  `notes` text DEFAULT NULL COMMENT 'Admissions officer notes',
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `user_id`, `status`, `documents`, `notes`, `reviewed_by`, `reviewed_at`, `rejection_reason`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 13, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 09:15:21', '2025-05-24 09:15:21', NULL),
(2, 14, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 09:29:52', '2025-05-24 09:29:52', NULL),
(3, 15, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 09:31:28', '2025-05-24 09:31:28', NULL),
(4, 16, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 09:40:25', '2025-05-24 09:40:25', NULL),
(5, 17, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 09:46:13', '2025-05-24 09:46:13', NULL),
(6, 18, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 09:52:22', '2025-05-24 09:52:22', NULL),
(7, 19, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 10:01:59', '2025-05-24 10:01:59', NULL),
(8, 20, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 10:02:38', '2025-05-24 10:02:38', NULL),
(9, 21, 'pending', NULL, 'Application submitted through registration form.', NULL, NULL, NULL, '2025-05-24 10:20:32', '2025-05-24 10:20:32', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `status` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('university_management_system_cache_5046elvina@dcpa.net|127.0.0.1', 'i:1;', 1748089426),
('university_management_system_cache_5046elvina@dcpa.net|127.0.0.1:timer', 'i:1748089426;', 1748089426),
('university_management_system_cache_5c785c036466adea360111aa28563bfd556b5fba', 'i:2;', 1747951895),
('university_management_system_cache_5c785c036466adea360111aa28563bfd556b5fba:timer', 'i:1747951895;', 1747951895),
('university_management_system_cache_admin@example.com|127.0.0.1', 'i:1;', 1748097063),
('university_management_system_cache_admin@example.com|127.0.0.1:timer', 'i:1748097063;', 1748097063),
('university_management_system_cache_c1dfd96eea8cc2b62785275bca38ac261256e278', 'i:1;', 1747668849),
('university_management_system_cache_c1dfd96eea8cc2b62785275bca38ac261256e278:timer', 'i:1747668849;', 1747668849),
('university_management_system_cache_joycreation1034@gmail.com|127.0.0.1', 'i:1;', 1747825393),
('university_management_system_cache_joycreation1034@gmail.com|127.0.0.1:timer', 'i:1747825393;', 1747825393),
('university_management_system_cache_mohamed230104326@sut.edu.eg|127.0.0.1', 'i:1;', 1748088995),
('university_management_system_cache_mohamed230104326@sut.edu.eg|127.0.0.1:timer', 'i:1748088995;', 1748088995),
('university_management_system_cache_register||127.0.0.1', 'i:5;', 1747951860),
('university_management_system_cache_register||127.0.0.1:timer', 'i:1747951860;', 1747951860),
('university_management_system_cache_register|5046elvina@dcpa.net|127.0.0.1', 'i:1;', 1748089404),
('university_management_system_cache_register|5046elvina@dcpa.net|127.0.0.1:timer', 'i:1748089404;', 1748089404),
('university_management_system_cache_register|585entitled@dcpa.net|127.0.0.1', 'i:1;', 1748090485),
('university_management_system_cache_register|585entitled@dcpa.net|127.0.0.1:timer', 'i:1748090485;', 1748090485),
('university_management_system_cache_register|662ideal@dcpa.net|127.0.0.1', 'i:1;', 1748089947),
('university_management_system_cache_register|662ideal@dcpa.net|127.0.0.1:timer', 'i:1748089947;', 1748089947),
('university_management_system_cache_register|740devoted@ptct.net|127.0.0.1', 'i:1;', 1748066073),
('university_management_system_cache_register|740devoted@ptct.net|127.0.0.1:timer', 'i:1748066073;', 1748066073),
('university_management_system_cache_register|912pink@dcpa.net|127.0.0.1', 'i:2;', 1748092882),
('university_management_system_cache_register|912pink@dcpa.net|127.0.0.1:timer', 'i:1748092882;', 1748092882),
('university_management_system_cache_register|baher@sut.edu.eg|127.0.0.1', 'i:1;', 1748091779),
('university_management_system_cache_register|baher@sut.edu.eg|127.0.0.1:timer', 'i:1748091779;', 1748091779),
('university_management_system_cache_register|dependentfred@dcpa.net|127.0.0.1', 'i:1;', 1748089923),
('university_management_system_cache_register|dependentfred@dcpa.net|127.0.0.1:timer', 'i:1748089923;', 1748089923),
('university_management_system_cache_register|gabriel275@dcpa.net|127.0.0.1', 'i:2;', 1748084077),
('university_management_system_cache_register|gabriel275@dcpa.net|127.0.0.1:timer', 'i:1748084077;', 1748084077),
('university_management_system_cache_register|grayjaquelin@dcpa.net|127.0.0.1', 'i:1;', 1748090832),
('university_management_system_cache_register|grayjaquelin@dcpa.net|127.0.0.1:timer', 'i:1748090832;', 1748090832),
('university_management_system_cache_register|joycreation1034@gmail.com|127.0.0.1', 'i:1;', 1747668822),
('university_management_system_cache_register|joycreation1034@gmail.com|127.0.0.1:timer', 'i:1747668822;', 1747668822),
('university_management_system_cache_register|m7md1hp@gmail.com|127.0.0.1', 'i:5;', 1747951710),
('university_management_system_cache_register|m7md1hp@gmail.com|127.0.0.1:timer', 'i:1747951709;', 1747951709),
('university_management_system_cache_register|me@mydomain.com|127.0.0.1', 'i:1;', 1748085692),
('university_management_system_cache_register|me@mydomain.com|127.0.0.1:timer', 'i:1748085692;', 1748085692),
('university_management_system_cache_register|rose7530@dcpa.net|127.0.0.1', 'i:1;', 1748085970),
('university_management_system_cache_register|rose7530@dcpa.net|127.0.0.1:timer', 'i:1748085970;', 1748085970),
('university_management_system_cache_register|salmon3110@dcpa.net|127.0.0.1', 'i:1;', 1748066104),
('university_management_system_cache_register|salmon3110@dcpa.net|127.0.0.1:timer', 'i:1748066104;', 1748066104),
('university_management_system_cache_register|sareesilver@dcpa.net|127.0.0.1', 'i:1;', 1748091818),
('university_management_system_cache_register|sareesilver@dcpa.net|127.0.0.1:timer', 'i:1748091818;', 1748091818),
('university_management_system_cache_register|yasmeen2617@dcpa.net|127.0.0.1', 'i:1;', 1748091202),
('university_management_system_cache_register|yasmeen2617@dcpa.net|127.0.0.1:timer', 'i:1748091202;', 1748091202),
('university_management_system_cache_rose7530@dcpa.net|127.0.0.1', 'i:1;', 1748088850),
('university_management_system_cache_rose7530@dcpa.net|127.0.0.1:timer', 'i:1748088850;', 1748088850),
('university_management_system_cache_salmon3110@dcpa.net|127.0.0.1', 'i:1;', 1748066194),
('university_management_system_cache_salmon3110@dcpa.net|127.0.0.1:timer', 'i:1748066194;', 1748066194),
('university_management_system_cache_sareesilver@dcpa.net|127.0.0.1', 'i:1;', 1748092588),
('university_management_system_cache_sareesilver@dcpa.net|127.0.0.1:timer', 'i:1748092588;', 1748092588),
('university_management_system_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:47:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:20:\"view-own-application\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:18:\"submit-application\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:22:\"update-own-application\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:8;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:17:\"view-applications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:20:\"approve-applications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:19:\"reject-applications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:19:\"manage-applications\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:19:\"generate-student-id\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:12:\"manage users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:10:\"edit users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:14:\"manage courses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:12:\"view courses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:4;i:1;i:6;i:2;i:9;i:3;i:10;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:14:\"create courses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:12:\"edit courses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"delete courses\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:15:\"manage students\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"view students\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:6;i:1;i:9;i:2;i:10;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:13:\"edit students\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:17:\"manage admissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:15:\"view admissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:18:\"approve admissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:17:\"reject admissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:14:\"manage finance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:12:\"view finance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:12:\"edit finance\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:21:\"manage academic terms\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:19:\"view academic terms\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:21:\"create academic terms\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:19:\"edit academic terms\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:15:\"manage calendar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:13:\"view calendar\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:4;i:1;i:6;i:2;i:9;i:3;i:10;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:22:\"create calendar events\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:20:\"edit calendar events\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:15:\"manage programs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:13:\"view programs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:6;i:1;i:9;i:2;i:10;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:15:\"create programs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:13:\"edit programs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:17:\"access admin area\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:6;i:1;i:9;i:2;i:10;}}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:16:\"view system info\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:6;i:1;i:9;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:18:\"view activity logs\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:13:\"view schedule\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:15:\"create schedule\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:15:\"update schedule\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:15:\"delete schedule\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:6;}}}s:5:\"roles\";a:6:{i:0;a:3:{s:1:\"a\";i:8;s:1:\"b\";s:9:\"applicant\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"Admissions\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:7:\"Student\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:9;s:1:\"b\";s:9:\"registrar\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:10;s:1:\"b\";s:7:\"faculty\";s:1:\"c\";s:3:\"web\";}}}', 1748187048),
('university_management_system_cache_testadmin@example.com|127.0.0.1', 'i:1;', 1748043416),
('university_management_system_cache_testadmin@example.com|127.0.0.1:timer', 'i:1748043416;', 1748043416);

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
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `professor` varchar(255) NOT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `credits` int(11) NOT NULL DEFAULT 3,
  `semester` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `progress` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'in_progress',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `code`, `professor`, `schedule`, `location`, `credits`, `semester`, `department`, `progress`, `status`, `created_at`, `updated_at`, `department_id`) VALUES
(1, 'Database Systems', 'CS 340', 'Prof. Johnson', 'Mon/Wed/Fri 9:00 AM - 10:50 AM', 'SCI 102', 3, 'Fall 2023', 'Computer Science', 65, 'in_progress', '2025-05-18 18:04:15', '2025-05-18 18:04:15', NULL),
(2, 'Web Development', 'CS 290', 'Prof. Smith', 'Tue/Thu 1:00 PM - 2:50 PM', 'ENG 201', 4, 'Fall 2023', 'Computer Science', 42, 'in_progress', '2025-05-18 18:04:15', '2025-05-18 18:04:15', NULL),
(3, 'Software Engineering', 'CS 361', 'Prof. Davis', 'Mon/Wed 11:00 AM - 12:50 PM', 'ENG 305', 3, 'Fall 2023', 'Computer Science', 78, 'in_progress', '2025-05-18 18:04:15', '2025-05-18 18:04:15', NULL),
(4, 'Introduction to Programming', 'CS 161', 'Prof. Williams', 'Mon/Wed/Fri 10:00 AM - 11:50 AM', 'SCI 101', 4, 'Spring 2023', 'Computer Science', 100, 'completed', '2025-05-18 18:04:15', '2025-05-18 18:04:15', NULL),
(5, 'Data Structures', 'CS 261', 'Prof. Green', 'Tue/Thu 9:00 AM - 10:50 AM', 'ENG 202', 4, 'Spring 2023', 'Computer Science', 100, 'completed', '2025-05-18 18:04:15', '2025-05-18 18:04:15', NULL),
(6, 'Computer Architecture', 'CS 271', 'Prof. White', 'Tue/Thu 1:00 PM - 2:20 PM', 'ENG 101', 3, 'Fall 2022', 'Computer Science', 100, 'completed', '2025-05-18 18:04:15', '2025-05-18 18:04:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_user`
--

CREATE TABLE `course_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `role_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `faculty_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `head_of_department` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `faculty_id`, `name`, `code`, `description`, `head_of_department`, `created_at`, `updated_at`) VALUES
(1, 1, 'Computer Science', 'CS', 'Computer Science and Software Engineering', 'Dr. John Smith', '2025-05-22 22:14:46', '2025-05-22 22:14:46'),
(2, 1, 'Electrical Engineering', 'EE', 'Electrical and Electronic Engineering', 'Dr. Sarah Johnson', '2025-05-22 22:14:46', '2025-05-22 22:14:46'),
(3, 2, 'Physics', 'PHY', 'Physics and Applied Physics', 'Dr. Michael Brown', '2025-05-22 22:14:46', '2025-05-22 22:14:46'),
(4, 2, 'Chemistry', 'CHEM', 'Chemistry and Chemical Engineering', 'Dr. Emily Davis', '2025-05-22 22:14:46', '2025-05-22 22:14:46'),
(5, 3, 'Business Administration', 'BA', 'Business and Management Studies', 'Dr. Robert Wilson', '2025-05-22 22:14:46', '2025-05-22 22:14:46'),
(6, 4, 'English Literature', 'ENG', 'English Language and Literature', 'Dr. Lisa Anderson', '2025-05-22 22:14:46', '2025-05-22 22:14:46');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `student_id`, `title`, `type`, `file_path`, `file_size`, `uploaded_at`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, '353rwew', 'form', 'documents/w3fG6qbNRqDEifOCdc4gcNadZyPvxo4heVttOn2t.png', '9.6 KB', '2025-05-22 19:31:10', 'pending', '2025-05-22 19:31:10', '2025-05-22 19:31:10');

-- --------------------------------------------------------

--
-- Table structure for table `email_verifications`
--

CREATE TABLE `email_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_verifications`
--

INSERT INTO `email_verifications` (`id`, `user_id`, `email`, `otp`, `expires_at`, `verified`, `created_at`, `updated_at`) VALUES
(1, 14, 'dependentfred@dcpa.net', '371575', '2025-05-24 09:39:52', 0, '2025-05-24 09:29:52', '2025-05-24 09:29:52'),
(2, 15, '662ideal@dcpa.net', '675494', '2025-05-24 09:41:28', 0, '2025-05-24 09:31:28', '2025-05-24 09:31:28'),
(3, 16, '585entitled@dcpa.net', '067875', '2025-05-24 12:41:29', 1, '2025-05-24 09:40:25', '2025-05-24 09:41:29'),
(4, 16, '585entitled@dcpa.net', '175782', '2025-05-24 09:55:27', 0, '2025-05-24 09:45:27', '2025-05-24 09:45:27'),
(5, 17, 'grayjaquelin@dcpa.net', '397599', '2025-05-24 12:46:29', 1, '2025-05-24 09:46:13', '2025-05-24 09:46:29'),
(6, 18, 'yasmeen2617@dcpa.net', '299033', '2025-05-24 10:02:22', 0, '2025-05-24 09:52:22', '2025-05-24 09:52:22'),
(7, 19, 'baher@sut.edu.eg', '651388', '2025-05-24 10:11:59', 0, '2025-05-24 10:01:59', '2025-05-24 10:01:59'),
(8, 20, 'sareesilver@dcpa.net', '084290', '2025-05-24 13:02:53', 1, '2025-05-24 10:02:38', '2025-05-24 10:02:53'),
(9, 21, '912pink@dcpa.net', '282328', '2025-05-24 13:20:48', 1, '2025-05-24 10:20:32', '2025-05-24 10:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `progress` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `academic_term_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `exam_type` varchar(255) NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `duration_minutes` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `weight` decimal(5,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `total_marks` int(11) NOT NULL,
  `passing_marks` int(11) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `allow_retake` tinyint(1) NOT NULL DEFAULT 0,
  `is_proctored` tinyint(1) NOT NULL DEFAULT 0,
  `is_online` tinyint(1) NOT NULL DEFAULT 0,
  `allowed_materials` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`allowed_materials`)),
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `exam_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `score` decimal(8,2) NOT NULL DEFAULT 0.00,
  `grade` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `feedback` text DEFAULT NULL,
  `section_scores` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`section_scores`)),
  `is_absent` tinyint(1) NOT NULL DEFAULT 0,
  `is_excused` tinyint(1) NOT NULL DEFAULT 0,
  `absence_reason` text DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `graded_at` datetime DEFAULT NULL,
  `graded_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`id`, `name`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Faculty of Engineering', 'ENG', 'Engineering and Technology programs', '2025-05-22 22:14:46', '2025-05-22 22:14:46'),
(2, 'Faculty of Science', 'SCI', 'Natural and Physical Sciences', '2025-05-22 22:14:46', '2025-05-22 22:14:46'),
(3, 'Faculty of Business', 'BUS', 'Business and Management programs', '2025-05-22 22:14:46', '2025-05-22 22:14:46'),
(4, 'Faculty of Arts', 'ART', 'Humanities and Social Sciences', '2025-05-22 22:14:46', '2025-05-22 22:14:46');

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
-- Table structure for table `financial_aid`
--

CREATE TABLE `financial_aid` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('scholarship','grant','loan','waiver') NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `percentage` decimal(5,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','approved','rejected','active','expired') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`documents`)),
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_records`
--

CREATE TABLE `financial_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enrollment_id` bigint(20) UNSIGNED NOT NULL,
  `points` decimal(5,2) NOT NULL,
  `letter_grade` varchar(255) NOT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `recipient_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `is_starred` tinyint(1) NOT NULL DEFAULT 0,
  `sender_archived` tinyint(1) NOT NULL DEFAULT 0,
  `recipient_archived` tinyint(1) NOT NULL DEFAULT 0,
  `sender_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `recipient_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_attachments`
--

CREATE TABLE `message_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` int(11) NOT NULL,
  `is_image` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, '2023_11_15_000001_create_courses_table', 1),
(5, '2025_04_19_142543_create_permission_tables', 1),
(6, '2025_04_20_144739_create_admins_table', 1),
(7, '2025_04_27_164238_add_social_login_columns_to_users_table', 1),
(8, '2025_04_27_164346_add_google_id_to_users_table', 1),
(9, '2023_11_16_000000_create_course_user_table', 2),
(10, '2025_05_21_201154_create_oauth_auth_codes_table', 3),
(11, '2025_05_21_201155_create_oauth_access_tokens_table', 3),
(12, '2025_05_21_201156_create_oauth_refresh_tokens_table', 3),
(13, '2025_05_21_201157_create_oauth_clients_table', 3),
(14, '2025_05_21_201158_create_oauth_personal_access_clients_table', 3),
(15, '2023_05_24_000001_create_academic_terms_table', 4),
(16, '2023_05_24_000002_create_academic_calendars_table', 4),
(17, '2023_05_24_000003_create_programs_table', 4),
(18, '2025_05_24_052503_add_fields_to_students_raw_sql', 5),
(19, '2025_05_24_085230_add_verification_code_columns_to_users_table', 6),
(20, '2025_05_24_120212_create_applications_table', 7),
(21, '2025_05_24_122428_create_email_verifications_table', 8),
(22, '2025_05_24_153604_create_payments_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(4, 'App\\Models\\User', 4),
(4, 'App\\Models\\User', 6),
(4, 'App\\Models\\User', 8),
(4, 'App\\Models\\User', 9),
(4, 'App\\Models\\User', 10),
(4, 'App\\Models\\User', 11),
(4, 'App\\Models\\User', 12),
(5, 'App\\Models\\User', 5),
(6, 'App\\Models\\User', 22),
(6, 'App\\Models\\User', 23),
(7, 'App\\Models\\User', 7),
(8, 'App\\Models\\User', 13),
(8, 'App\\Models\\User', 14),
(8, 'App\\Models\\User', 15),
(8, 'App\\Models\\User', 16),
(8, 'App\\Models\\User', 17),
(8, 'App\\Models\\User', 18),
(8, 'App\\Models\\User', 19),
(8, 'App\\Models\\User', 20),
(8, 'App\\Models\\User', 21);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notification_type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `channel` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `error_message` text DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_preferences`
--

CREATE TABLE `notification_preferences` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notification_type` varchar(255) NOT NULL,
  `email_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `sms_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `in_app_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `push_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('564f1119c2848ff98c2d89adf65567bef033fb059bc03e0fa8b60da393df7d0acc9d5d407b5b42fe', 1, '0196ff37-c313-7063-bfe5-af3457532388', 'Personal Access Token', '[]', 0, '2025-05-23 19:18:14', '2025-05-23 19:18:14', '2026-05-23 22:18:14');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
('0196ff37-c313-7063-bfe5-af3457532388', NULL, 'University Management System', '$2y$12$XhZVRCpKufr5XL.eb2JnR.wfCvXCnjLSUnHYZQAkO9CCXYOKmikm2', 'users', '', 1, 0, 0, '2025-05-23 19:16:06', '2025-05-23 19:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `client_id` char(36) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `financial_record_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `receipt_number` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_plans`
--

CREATE TABLE `payment_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `number_of_installments` int(11) NOT NULL,
  `installment_amount` decimal(10,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(255) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'view-own-application', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(2, 'submit-application', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(3, 'update-own-application', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(4, 'view-applications', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(5, 'approve-applications', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(6, 'reject-applications', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(7, 'manage-applications', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(8, 'generate-student-id', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(9, 'manage users', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(10, 'view users', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(11, 'create users', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(12, 'edit users', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(13, 'delete users', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(14, 'manage courses', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(15, 'view courses', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(16, 'create courses', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(17, 'edit courses', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(18, 'delete courses', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(19, 'manage students', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(20, 'view students', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(21, 'edit students', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(22, 'manage admissions', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(23, 'view admissions', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(24, 'approve admissions', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(25, 'reject admissions', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(26, 'manage finance', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(27, 'view finance', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(28, 'edit finance', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(29, 'manage academic terms', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(30, 'view academic terms', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(31, 'create academic terms', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(32, 'edit academic terms', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(33, 'manage calendar', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(34, 'view calendar', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(35, 'create calendar events', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(36, 'edit calendar events', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(37, 'manage programs', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(38, 'view programs', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(39, 'create programs', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(40, 'edit programs', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(41, 'access admin area', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(42, 'view system info', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(43, 'view activity logs', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(44, 'view schedule', 'web', '2025-05-24 12:20:02', '2025-05-24 12:20:02'),
(45, 'create schedule', 'web', '2025-05-24 12:20:02', '2025-05-24 12:20:02'),
(46, 'update schedule', 'web', '2025-05-24 12:20:02', '2025-05-24 12:20:02'),
(47, 'delete schedule', 'web', '2025-05-24 12:20:02', '2025-05-24 12:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `prerequisites`
--

CREATE TABLE `prerequisites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `prerequisite_course_id` bigint(20) UNSIGNED NOT NULL,
  `min_grade` varchar(255) NOT NULL DEFAULT 'C',
  `notes` text DEFAULT NULL,
  `can_be_concurrent` tinyint(1) NOT NULL DEFAULT 0,
  `can_be_waived` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `credits_required` int(11) NOT NULL,
  `degree_type` varchar(255) NOT NULL,
  `duration_years` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `coordinator_name` varchar(255) DEFAULT NULL,
  `coordinator_email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_requirements`
--

CREATE TABLE `program_requirements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `required_credits` int(11) NOT NULL DEFAULT 3,
  `min_grade` varchar(255) NOT NULL DEFAULT 'C',
  `requirement_type` varchar(255) NOT NULL DEFAULT 'core',
  `semester_recommended` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admissions', 'web', '2025-05-18 18:04:13', '2025-05-18 18:04:13'),
(2, 'Professor', 'web', '2025-05-18 18:04:13', '2025-05-18 18:04:13'),
(3, 'TA', 'web', '2025-05-18 18:04:13', '2025-05-18 18:04:13'),
(4, 'Student', 'web', '2025-05-18 18:04:13', '2025-05-18 18:04:13'),
(5, 'IT Support', 'web', '2025-05-18 18:04:13', '2025-05-18 18:04:13'),
(6, 'admin', 'web', NULL, NULL),
(7, 'super_admin', 'web', '2025-05-23 20:33:25', '2025-05-23 20:33:25'),
(8, 'applicant', 'web', '2025-05-24 09:09:29', '2025-05-24 09:09:29'),
(9, 'registrar', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27'),
(10, 'faculty', 'web', '2025-05-24 12:18:27', '2025-05-24 12:18:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 8),
(2, 8),
(3, 8),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 6),
(10, 6),
(11, 6),
(12, 6),
(13, 6),
(14, 6),
(15, 4),
(15, 6),
(15, 9),
(15, 10),
(16, 6),
(17, 6),
(18, 6),
(19, 6),
(19, 9),
(20, 6),
(20, 9),
(20, 10),
(21, 6),
(21, 9),
(22, 6),
(22, 9),
(23, 6),
(23, 9),
(24, 6),
(24, 9),
(25, 6),
(25, 9),
(26, 6),
(27, 6),
(28, 6),
(29, 6),
(29, 9),
(30, 6),
(30, 9),
(31, 6),
(31, 9),
(32, 6),
(32, 9),
(33, 6),
(33, 9),
(34, 4),
(34, 6),
(34, 9),
(34, 10),
(35, 6),
(35, 9),
(36, 6),
(36, 9),
(37, 6),
(38, 6),
(38, 9),
(38, 10),
(39, 6),
(40, 6),
(41, 6),
(41, 9),
(41, 10),
(42, 6),
(42, 9),
(43, 6),
(44, 6),
(45, 6),
(46, 6),
(47, 6);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `room` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT 'lecture',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE `scholarships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `amount_type` varchar(255) NOT NULL DEFAULT 'fixed',
  `minimum_gpa` decimal(3,2) DEFAULT NULL,
  `minimum_credits` int(11) DEFAULT NULL,
  `duration_semesters` int(11) DEFAULT NULL,
  `renewable` tinyint(1) NOT NULL DEFAULT 0,
  `renewal_criteria` text DEFAULT NULL,
  `eligibility_criteria` text DEFAULT NULL,
  `application_deadline` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `max_recipients` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `instructor` varchar(255) NOT NULL,
  `room` varchar(255) NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
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
('UE3VYDbPR5jde924CjsUmVkkK06YNcNRykmKzdH0', 22, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOXFBeUZ4UzgxYmdlQVMxZXhpajZnOWxDWklPQnhrSU1NRFY1QklQVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vcHJvamVjdC5sb2NhbGhvc3QuY29tL2Rhc2hib2FyZCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjIyO30=', 1748102478);

-- --------------------------------------------------------

--
-- Table structure for table `social_connections`
--

CREATE TABLE `social_connections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(255) NOT NULL,
  `provider_id` varchar(255) NOT NULL,
  `token` text DEFAULT NULL,
  `refresh_token` text DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `program` varchar(255) NOT NULL,
  `credits_completed` int(11) DEFAULT 0,
  `gpa` decimal(3,2) DEFAULT 0.00,
  `academic_standing` varchar(255) DEFAULT 'Good',
  `advisor` varchar(255) DEFAULT NULL,
  `level` varchar(255) NOT NULL,
  `admission_date` date NOT NULL,
  `expected_graduation_date` date DEFAULT NULL,
  `financial_hold` tinyint(1) DEFAULT 0,
  `academic_hold` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `user_id`, `student_id`, `national_id`, `address`, `department_id`, `program`, `credits_completed`, `gpa`, `academic_standing`, `advisor`, `level`, `admission_date`, `expected_graduation_date`, `financial_hold`, `academic_hold`, `created_at`, `updated_at`) VALUES
(3, 1, '234242424242', NULL, NULL, 6, 'CYB', 0, 0.00, 'Good', NULL, 'Freshman', '0002-02-08', '2029-05-22', 0, 0, '2025-05-22 19:17:16', '2025-05-22 19:17:16'),
(4, 7, '123132131313', NULL, NULL, 6, '123123131', 0, 0.00, 'Good', NULL, 'Freshman', '2005-02-02', '2029-05-24', 0, 0, '2025-05-23 21:14:11', '2025-05-23 21:14:11');

-- --------------------------------------------------------

--
-- Table structure for table `student_requests`
--

CREATE TABLE `student_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) DEFAULT 'pending',
  `description` text NOT NULL,
  `response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_scholarship`
--

CREATE TABLE `student_scholarship` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `scholarship_id` bigint(20) UNSIGNED NOT NULL,
  `amount_awarded` decimal(10,2) NOT NULL,
  `award_date` date NOT NULL,
  `valid_from` date NOT NULL,
  `valid_until` date DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `github_id` varchar(255) DEFAULT NULL,
  `linkedin_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `verification_code_expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `google_id`, `password`, `github_id`, `linkedin_id`, `remember_token`, `avatar`, `created_at`, `updated_at`, `verification_code`, `verification_code_expires_at`) VALUES
(1, 'Mohamed', 'mohamed230104326@sut.edu.eg', '2025-05-14 22:10:55', NULL, '$2y$12$0iNTKXrh.BUvdslBwk/Oi.M4j8McL0IzB34ZQMt5tP/JNs7bFETiW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Test Admin', 'testadmin@example.com', '2025-05-23 20:33:25', NULL, '$2y$12$p3L8jeKqXtPogPCr3VvzLexQn/u8cRhcROgYiA7Vug13u7ajcmk4G', NULL, NULL, 'zmLoTf8b42', NULL, '2025-05-23 20:33:25', '2025-05-23 20:33:25', NULL, NULL),
(8, 'Test Test', 'me@mydomain.com', NULL, NULL, '$2y$12$PIEEXsJNMQy7aqqyYiI7U.rOemWJ08h5PAxzF0mbGmluidIygK2FO', NULL, NULL, NULL, NULL, '2025-05-24 02:49:43', '2025-05-24 02:49:43', NULL, NULL),
(9, 'my first name my last name', '740devoted@ptct.net', NULL, NULL, '$2y$12$yEKj1VJgVFc/oaNRknrAMO9dMdqsQL.3To5a/zOoq.0w18mjn9OI2', NULL, NULL, NULL, NULL, '2025-05-24 02:52:07', '2025-05-24 02:52:07', NULL, NULL),
(10, 'my first name my last name', 'salmon3110@dcpa.net', NULL, NULL, '$2y$12$WpzLjHVZyx2sFuBNP1lmv.rmG5PDayfBRJ5WrAscdK4xLel3lf2mC', NULL, NULL, NULL, NULL, '2025-05-24 02:54:04', '2025-05-24 02:54:04', '600557', '2025-05-24 03:24:04'),
(11, 'Ahmed Ahmed', 'gabriel275@dcpa.net', '2025-05-24 03:05:15', NULL, '$2y$12$QCYKdF6EOAyat5nuGsuYXO8yGjHNl9rxA5BlorItQS0Iyu8HIP/aq', NULL, NULL, NULL, NULL, '2025-05-24 03:05:15', '2025-05-24 03:05:15', NULL, NULL),
(12, 'Mohamed Saied', 'rose7530@dcpa.net', '2025-05-24 08:25:10', NULL, '$2y$12$Mb3migfx.B4xDofA3jQs1.nhnsLSNMGOZW29AK97/LsG6wsSsxSqW', NULL, NULL, NULL, NULL, '2025-05-24 08:25:10', '2025-05-24 08:25:10', NULL, NULL),
(13, 'Mohamed Saied', '5046elvina@dcpa.net', '2025-05-24 09:15:21', NULL, '$2y$12$nBfAfOkB6PPF2e93rrfBPOWNSXIzH413wD9yWjZ4gzq37/rmjWs5a', NULL, NULL, NULL, NULL, '2025-05-24 09:15:21', '2025-05-24 09:15:21', NULL, NULL),
(14, 'Mohamed Tarek', 'dependentfred@dcpa.net', NULL, NULL, '$2y$12$4caNwvB5ub91w6n9Lyi3duSHQT3kSG2z5VqTgwE1eQkxspWXKRHXm', NULL, NULL, NULL, NULL, '2025-05-24 09:29:51', '2025-05-24 09:29:51', NULL, NULL),
(15, 'Mohamed Tarek', '662ideal@dcpa.net', NULL, NULL, '$2y$12$g0AuBsSiNa/ny8PIkkpNlum3MoV25ykPEMki/DWE45LO21bLhGk0m', NULL, NULL, NULL, NULL, '2025-05-24 09:31:28', '2025-05-24 09:31:28', NULL, NULL),
(16, 'Mohamed Tarooka', '585entitled@dcpa.net', '2025-05-24 09:41:29', NULL, '$2y$12$em8.lHOEMGjqFxsmlWmMkO0Nug73fj7lqGNBVHdX0cwy8h8vn9fsm', NULL, NULL, NULL, NULL, '2025-05-24 09:40:25', '2025-05-24 09:41:29', NULL, NULL),
(17, 'Essam Amr', 'grayjaquelin@dcpa.net', '2025-05-24 09:46:29', NULL, '$2y$12$RzxugjMbXrnVQsi5brAaG.SPub8mc2LzEUYbYo4GBcnveYw4Vl78e', NULL, NULL, NULL, NULL, '2025-05-24 09:46:13', '2025-05-24 09:46:29', NULL, NULL),
(18, 'Mohamed Tarek', 'yasmeen2617@dcpa.net', NULL, NULL, '$2y$12$1Y.MsiVel2Vx0N2aHFYksekw6LaI6Pu7O7.XrLiSlK5q9bOJ11GIu', NULL, NULL, NULL, NULL, '2025-05-24 09:52:22', '2025-05-24 09:52:22', NULL, NULL),
(19, 'mohamed baher', 'baher@sut.edu.eg', NULL, NULL, '$2y$12$3rEISSja7DPbiAmCAWcp9ezdxNqgnMKEjlJ1WKc7guXBkrb0iKHM6', NULL, NULL, NULL, NULL, '2025-05-24 10:01:59', '2025-05-24 10:01:59', NULL, NULL),
(20, 'mohamed baher', 'sareesilver@dcpa.net', '2025-05-24 10:02:53', NULL, '$2y$12$Sb1SX2e3nmhYhtkbr9OsN..DOvTRZ9XC./XmldLRbsSpfRRQF.Fua', NULL, NULL, NULL, NULL, '2025-05-24 10:02:38', '2025-05-24 10:02:53', NULL, NULL),
(21, 'Mohamed Saied', '912pink@dcpa.net', '2025-05-24 10:20:48', NULL, '$2y$12$kwLF5p7FB1F1hmrsADQAu.OzuzSBBjuGz/oWk3STGEHTmLrh/4s7q', NULL, NULL, NULL, NULL, '2025-05-24 10:20:32', '2025-05-24 10:20:48', NULL, NULL),
(22, 'Admin User', 'admin@example.com', '2025-05-24 11:29:41', NULL, '$2y$12$Wp8Zgx8LINEX4mgOAz1KsuuRjeoBdQYYwPwhPPAWSFdWTKeMQ9Tla', NULL, NULL, NULL, NULL, '2025-05-24 11:29:41', '2025-05-24 11:29:41', NULL, NULL),
(23, 'Super Admin', 'superadmin@example.com', '2025-05-24 12:19:16', NULL, '$2y$12$pgRavXpGpgr//spbzHBlae9R0icXiN.Ktti8IaRWullnVH0yTnDOy', NULL, NULL, NULL, NULL, '2025-05-24 12:19:16', '2025-05-24 12:19:16', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic_calendars`
--
ALTER TABLE `academic_calendars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `academic_calendars_academic_term_id_foreign` (`academic_term_id`);

--
-- Indexes for table `academic_terms`
--
ALTER TABLE `academic_terms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `academic_terms_code_unique` (`code`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `announcements_author_id_foreign` (`author_id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_user_id_foreign` (`user_id`),
  ADD KEY `applications_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_student_id_foreign` (`student_id`),
  ADD KEY `attendances_section_id_foreign` (`section_id`);

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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_courses_department` (`department_id`);

--
-- Indexes for table `course_user`
--
ALTER TABLE `course_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_user_user_id_course_id_role_type_unique` (`user_id`,`course_id`,`role_type`),
  ADD KEY `course_user_course_id_foreign` (`course_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_code_unique` (`code`),
  ADD KEY `departments_faculty_id_foreign` (`faculty_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_student_id_foreign` (`student_id`);

--
-- Indexes for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_verifications_user_id_foreign` (`user_id`),
  ADD KEY `email_verifications_email_otp_index` (`email`,`otp`),
  ADD KEY `email_verifications_expires_at_index` (`expires_at`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollments_user_id_foreign` (`user_id`),
  ADD KEY `enrollments_course_id_foreign` (`course_id`),
  ADD KEY `enrollments_section_id_foreign` (`section_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exams_course_id_foreign` (`course_id`),
  ADD KEY `exams_section_id_foreign` (`section_id`),
  ADD KEY `exams_academic_term_id_foreign` (`academic_term_id`),
  ADD KEY `exams_created_by_foreign` (`created_by`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `exam_result_unique` (`exam_id`,`student_id`),
  ADD KEY `exam_results_exam_id_foreign` (`exam_id`),
  ADD KEY `exam_results_student_id_foreign` (`student_id`),
  ADD KEY `exam_results_graded_by_foreign` (`graded_by`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculties_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `financial_aid`
--
ALTER TABLE `financial_aid`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_aid_student_id_foreign` (`student_id`),
  ADD KEY `financial_aid_approved_by_foreign` (`approved_by`);

--
-- Indexes for table `financial_records`
--
ALTER TABLE `financial_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `financial_records_student_id_foreign` (`student_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `grades_enrollment_id_foreign` (`enrollment_id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_recipient_id_foreign` (`recipient_id`),
  ADD KEY `messages_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_attachments_message_id_foreign` (`message_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notification_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `notification_preferences`
--
ALTER TABLE `notification_preferences`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `notif_pref_unique` (`user_id`,`notification_type`),
  ADD KEY `notification_preferences_user_id_foreign` (`user_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_financial_record_id_foreign` (`financial_record_id`);

--
-- Indexes for table `payment_plans`
--
ALTER TABLE `payment_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_plans_student_id_foreign` (`student_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `prerequisites`
--
ALTER TABLE `prerequisites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prereq_unique` (`course_id`,`prerequisite_course_id`),
  ADD KEY `prerequisites_course_id_foreign` (`course_id`),
  ADD KEY `prerequisites_prerequisite_course_id_foreign` (`prerequisite_course_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `programs_code_unique` (`code`),
  ADD KEY `programs_department_id_foreign` (`department_id`);

--
-- Indexes for table `program_requirements`
--
ALTER TABLE `program_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_requirements_program_id_foreign` (`program_id`),
  ADD KEY `program_requirements_course_id_foreign` (`course_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_course_id_foreign` (`course_id`);

--
-- Indexes for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `scholarships_created_by_foreign` (`created_by`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_course_id_foreign` (`course_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `social_connections`
--
ALTER TABLE `social_connections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `social_connections_provider_provider_id_unique` (`provider`,`provider_id`),
  ADD KEY `social_connections_user_id_foreign` (`user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_student_id_unique` (`student_id`),
  ADD KEY `students_user_id_foreign` (`user_id`),
  ADD KEY `students_department_id_foreign` (`department_id`);

--
-- Indexes for table `student_requests`
--
ALTER TABLE `student_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_requests_student_id_foreign` (`student_id`);

--
-- Indexes for table `student_scholarship`
--
ALTER TABLE `student_scholarship`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `scholarship_award_unique` (`student_id`,`scholarship_id`,`award_date`),
  ADD KEY `student_scholarship_student_id_foreign` (`student_id`),
  ADD KEY `student_scholarship_scholarship_id_foreign` (`scholarship_id`);

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
-- AUTO_INCREMENT for table `academic_calendars`
--
ALTER TABLE `academic_calendars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `academic_terms`
--
ALTER TABLE `academic_terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_user`
--
ALTER TABLE `course_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_verifications`
--
ALTER TABLE `email_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_aid`
--
ALTER TABLE `financial_aid`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_records`
--
ALTER TABLE `financial_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_preferences`
--
ALTER TABLE `notification_preferences`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_plans`
--
ALTER TABLE `payment_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `prerequisites`
--
ALTER TABLE `prerequisites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `program_requirements`
--
ALTER TABLE `program_requirements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scholarships`
--
ALTER TABLE `scholarships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `social_connections`
--
ALTER TABLE `social_connections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student_requests`
--
ALTER TABLE `student_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_scholarship`
--
ALTER TABLE `student_scholarship`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic_calendars`
--
ALTER TABLE `academic_calendars`
  ADD CONSTRAINT `academic_calendars_academic_term_id_foreign` FOREIGN KEY (`academic_term_id`) REFERENCES `academic_terms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `applications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `course_user`
--
ALTER TABLE `course_user`
  ADD CONSTRAINT `course_user_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `email_verifications`
--
ALTER TABLE `email_verifications`
  ADD CONSTRAINT `email_verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_academic_term_id_foreign` FOREIGN KEY (`academic_term_id`) REFERENCES `academic_terms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exams_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_results_graded_by_foreign` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `exam_results_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `financial_aid`
--
ALTER TABLE `financial_aid`
  ADD CONSTRAINT `financial_aid_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `financial_aid_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `financial_records`
--
ALTER TABLE `financial_records`
  ADD CONSTRAINT `financial_records_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_enrollment_id_foreign` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `messages_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD CONSTRAINT `message_attachments_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD CONSTRAINT `notification_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_preferences`
--
ALTER TABLE `notification_preferences`
  ADD CONSTRAINT `notification_preferences_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_financial_record_id_foreign` FOREIGN KEY (`financial_record_id`) REFERENCES `financial_records` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_plans`
--
ALTER TABLE `payment_plans`
  ADD CONSTRAINT `payment_plans_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prerequisites`
--
ALTER TABLE `prerequisites`
  ADD CONSTRAINT `prerequisites_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prerequisites_prerequisite_course_id_foreign` FOREIGN KEY (`prerequisite_course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_requirements`
--
ALTER TABLE `program_requirements`
  ADD CONSTRAINT `program_requirements_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_requirements_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `scholarships`
--
ALTER TABLE `scholarships`
  ADD CONSTRAINT `scholarships_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_connections`
--
ALTER TABLE `social_connections`
  ADD CONSTRAINT `social_connections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_requests`
--
ALTER TABLE `student_requests`
  ADD CONSTRAINT `student_requests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_scholarship`
--
ALTER TABLE `student_scholarship`
  ADD CONSTRAINT `student_scholarship_scholarship_id_foreign` FOREIGN KEY (`scholarship_id`) REFERENCES `scholarships` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_scholarship_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
