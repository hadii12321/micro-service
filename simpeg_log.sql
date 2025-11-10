-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 10, 2025 at 11:37 PM
-- Server version: 11.7.2-MariaDB
-- PHP Version: 8.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simpeg_log`
--

-- --------------------------------------------------------

--
-- Table structure for table `audits`
--

CREATE TABLE `audits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(100) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `event` varchar(50) NOT NULL,
  `auditable_type` varchar(100) NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `url` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `threat_activity_logs`
--

CREATE TABLE `threat_activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `country_code` char(2) DEFAULT NULL,
  `region` varchar(10) DEFAULT NULL,
  `region_name` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lon` decimal(11,8) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `isp` varchar(200) DEFAULT NULL,
  `org` varchar(200) DEFAULT NULL,
  `as` varchar(200) DEFAULT NULL,
  `method` varchar(10) NOT NULL,
  `url` text NOT NULL,
  `header_user_agent` text DEFAULT NULL,
  `referer` text DEFAULT NULL,
  `browser_detected` varchar(100) DEFAULT NULL,
  `os_detected` varchar(100) DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `validation_score` tinyint(3) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `threat_blacklist_logs`
--

CREATE TABLE `threat_blacklist_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `country_code` char(2) DEFAULT NULL,
  `region` varchar(10) DEFAULT NULL,
  `region_name` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lon` decimal(11,8) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `isp` varchar(200) DEFAULT NULL,
  `org` varchar(200) DEFAULT NULL,
  `as` varchar(200) DEFAULT NULL,
  `header_user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPRESSED;

-- --------------------------------------------------------

--
-- Table structure for table `threat_logs`
--

CREATE TABLE `threat_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `country_code` char(2) DEFAULT NULL,
  `region` varchar(10) DEFAULT NULL,
  `region_name` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lon` decimal(11,8) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `isp` varchar(200) DEFAULT NULL,
  `org` varchar(200) DEFAULT NULL,
  `as` varchar(200) DEFAULT NULL,
  `method` varchar(10) NOT NULL,
  `url` text NOT NULL,
  `header_user_agent` text DEFAULT NULL,
  `referer` text DEFAULT NULL,
  `parameters` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `threat_category` varchar(100) NOT NULL,
  `threat_description` text DEFAULT NULL,
  `browser_detected` varchar(100) DEFAULT NULL,
  `os_detected` varchar(100) DEFAULT NULL,
  `device_type` varchar(50) DEFAULT NULL,
  `is_legitimate` tinyint(1) DEFAULT 0,
  `validation_score` tinyint(3) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audits`
--
ALTER TABLE `audits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_type`,`user_id`),
  ADD KEY `idx_auditable` (`auditable_type`,`auditable_id`),
  ADD KEY `idx_event` (`event`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_ip_address` (`ip_address`),
  ADD KEY `idx_user_created` (`user_id`,`created_at`),
  ADD KEY `idx_auditable_created` (`auditable_type`,`auditable_id`,`created_at`),
  ADD KEY `idx_event_created` (`event`,`created_at`);

--
-- Indexes for table `threat_activity_logs`
--
ALTER TABLE `threat_activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_address` (`ip_address`),
  ADD KEY `idx_country_code` (`country_code`),
  ADD KEY `idx_method` (`method`),
  ADD KEY `idx_browser_detected` (`browser_detected`),
  ADD KEY `idx_os_detected` (`os_detected`),
  ADD KEY `idx_device_type` (`device_type`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_ip_created` (`ip_address`,`created_at`),
  ADD KEY `idx_country_created` (`country_code`,`created_at`),
  ADD KEY `idx_browser_created` (`browser_detected`,`created_at`),
  ADD KEY `idx_daily_stats` (`created_at`,`country_code`,`browser_detected`);

--
-- Indexes for table `threat_blacklist_logs`
--
ALTER TABLE `threat_blacklist_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_unique_ip_ua` (`ip_address`,`header_user_agent`(100)),
  ADD KEY `idx_ip_address` (`ip_address`),
  ADD KEY `idx_country_code` (`country_code`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_ip_created` (`ip_address`,`created_at`);

--
-- Indexes for table `threat_logs`
--
ALTER TABLE `threat_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip_address` (`ip_address`),
  ADD KEY `idx_country_code` (`country_code`),
  ADD KEY `idx_threat_category` (`threat_category`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_is_legitimate` (`is_legitimate`),
  ADD KEY `idx_validation_score` (`validation_score`),
  ADD KEY `idx_ip_created` (`ip_address`,`created_at`),
  ADD KEY `idx_country_created` (`country_code`,`created_at`),
  ADD KEY `idx_threat_created` (`threat_category`,`created_at`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audits`
--
ALTER TABLE `audits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `threat_activity_logs`
--
ALTER TABLE `threat_activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `threat_blacklist_logs`
--
ALTER TABLE `threat_blacklist_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `threat_logs`
--
ALTER TABLE `threat_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
