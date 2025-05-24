-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2025 at 05:57 PM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
