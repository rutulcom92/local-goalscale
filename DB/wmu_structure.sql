-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2020 at 02:43 PM
-- Server version: 5.7.30-0ubuntu0.18.04.1
-- PHP Version: 7.2.24-0ubuntu0.18.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wmu`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goals`
--

CREATE TABLE `goals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `goal_start_date` datetime DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `participant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `goal_change` bigint(20) DEFAULT NULL,
  `last_activity_date` datetime DEFAULT NULL,
  `goal_closed_date` datetime DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 => Inactive, 1 => Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_activity`
--

CREATE TABLE `goal_activity` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `goal_id` bigint(20) UNSIGNED NOT NULL,
  `update_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_ranking` enum('0','1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL,
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `date_of_activity` datetime NOT NULL,
  `parent_activity_id` bigint(20) NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_activity_attachments`
--

CREATE TABLE `goal_activity_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `goal_activity_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_scale`
--

CREATE TABLE `goal_scale` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `goal_id` bigint(20) UNSIGNED NOT NULL,
  `value` enum('0','1','2','3','4') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 => Inactive, 1 => Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_status`
--

CREATE TABLE `goal_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `goal_tag`
--

CREATE TABLE `goal_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED DEFAULT NULL,
  `goal_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_users` bigint(20) DEFAULT NULL,
  `num_providers` bigint(20) DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci,
  `logo_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_goals` bigint(20) DEFAULT NULL,
  `avg_goal_change` float DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `organization_org_type`
--

CREATE TABLE `organization_org_type` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `org_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `org_types`
--

CREATE TABLE `org_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `participant_provider`
--

CREATE TABLE `participant_provider` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `participant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `program_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization_id` bigint(20) UNSIGNED NOT NULL,
  `contact_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci,
  `date_added` datetime DEFAULT NULL,
  `record_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_org_admin`
--

CREATE TABLE `program_org_admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_participant`
--

CREATE TABLE `program_participant` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED DEFAULT NULL,
  `participant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_provider`
--

CREATE TABLE `program_provider` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `program_supervisor`
--

CREATE TABLE `program_supervisor` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `program_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provider_supervisors`
--

CREATE TABLE `provider_supervisors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supervisor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provider_types`
--

CREATE TABLE `provider_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `org_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reference_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `state_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tag_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tag_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `org_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 => Inactive, 1 => Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag_groups`
--

CREATE TABLE `tag_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `org_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 => Inactive, 1 => Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag_types`
--

CREATE TABLE `tag_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0 => Inactive, 1 => Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
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
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8mb4_unicode_ci,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record_num` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organization_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` longtext COLLATE utf8mb4_unicode_ci,
  `last_login` datetime DEFAULT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `inactive_date` date DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_types`
--

CREATE TABLE `users_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '0=>Blocked, 1=>Active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gender` enum('M','F','O') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'M => Male, F =>\n            Female, O => Other',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `dob` datetime DEFAULT NULL,
  `program_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `num_users` int(11) DEFAULT NULL,
  `num_providers` int(11) DEFAULT NULL,
  `num_goals` int(11) DEFAULT NULL,
  `num_users_goals` int(11) DEFAULT NULL,
  `avg_goal_change` float DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `last_modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `countries_country_code_index` (`country_code`),
  ADD KEY `countries_name_index` (`name`);

--
-- Indexes for table `goals`
--
ALTER TABLE `goals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goals_status_id_foreign` (`status_id`),
  ADD KEY `goals_participant_id_foreign` (`participant_id`),
  ADD KEY `goals_provider_id_foreign` (`provider_id`),
  ADD KEY `goals_name_index` (`name`),
  ADD KEY `goals_goal_start_date_index` (`goal_start_date`),
  ADD KEY `goals_last_activity_date_index` (`last_activity_date`),
  ADD KEY `goals_goal_closed_date_index` (`goal_closed_date`),
  ADD KEY `goals_created_by_foreign` (`created_by`),
  ADD KEY `goals_last_modified_by_foreign` (`last_modified_by`);

--
-- Indexes for table `goal_activity`
--
ALTER TABLE `goal_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_activity_date_of_activity_index` (`date_of_activity`),
  ADD KEY `goal_activity_parent_activity_id_index` (`parent_activity_id`),
  ADD KEY `goal_activity_created_by_foreign` (`created_by`),
  ADD KEY `goal_activity_goal_id_foreign` (`goal_id`),
  ADD KEY `goal_activity_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `goal_activity_participant_id_foreign` (`participant_id`);

--
-- Indexes for table `goal_activity_attachments`
--
ALTER TABLE `goal_activity_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_activity_attachments_file_location_index` (`name`),
  ADD KEY `goal_activity_attachments_created_by_foreign` (`created_by`),
  ADD KEY `goal_activity_attachments_goal_activity_id_foreign` (`goal_activity_id`),
  ADD KEY `goal_activity_attachments_last_modified_by_foreign` (`last_modified_by`);

--
-- Indexes for table `goal_scale`
--
ALTER TABLE `goal_scale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_scale_name_index` (`name`),
  ADD KEY `goal_scale_created_by_foreign` (`created_by`),
  ADD KEY `goal_scale_goal_id_foreign` (`goal_id`),
  ADD KEY `goal_scale_last_modified_by_foreign` (`last_modified_by`);

--
-- Indexes for table `goal_status`
--
ALTER TABLE `goal_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_status_created_by_foreign` (`created_by`),
  ADD KEY `goal_status_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `goal_status_name_index` (`name`);

--
-- Indexes for table `goal_tag`
--
ALTER TABLE `goal_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `goal_tag_created_by_foreign` (`created_by`),
  ADD KEY `goal_tag_goal_id_foreign` (`goal_id`),
  ADD KEY `goal_tag_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `goal_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organizations_name_index` (`name`),
  ADD KEY `organizations_contact_email_index` (`contact_email`),
  ADD KEY `organizations_contact_phone_index` (`contact_phone`),
  ADD KEY `organizations_image_index` (`image`),
  ADD KEY `organizations_logo_image_index` (`logo_image`),
  ADD KEY `organizations_date_added_index` (`date_added`),
  ADD KEY `organizations_city_index` (`city`),
  ADD KEY `organizations_zip_index` (`zip`),
  ADD KEY `organizations_record_num_index` (`record_num`),
  ADD KEY `organizations_num_users_index` (`num_users`),
  ADD KEY `organizations_num_providers_index` (`num_providers`),
  ADD KEY `organizations_state_id_foreign_key` (`state_id`);

--
-- Indexes for table `organization_org_type`
--
ALTER TABLE `organization_org_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organization_org_type_organization_id_foreign` (`organization_id`),
  ADD KEY `organization_org_type_org_type_id_foreign` (`org_type_id`),
  ADD KEY `organization_org_type_created_by_foreign` (`created_by`),
  ADD KEY `organization_org_type_last_modified_by_foreign` (`last_modified_by`);

--
-- Indexes for table `org_types`
--
ALTER TABLE `org_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `org_types_created_by_foreign` (`created_by`),
  ADD KEY `org_types_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `org_types_name_index` (`name`);

--
-- Indexes for table `participant_provider`
--
ALTER TABLE `participant_provider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participant_provider_provider_id_foreign` (`provider_id`),
  ADD KEY `participant_provider_participant_id_foreign` (`participant_id`),
  ADD KEY `participant_provider_created_by_foreign` (`created_by`),
  ADD KEY `participant_provider_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `participant_provider_program_id_foreign` (`program_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `programs_country_id_foreign` (`country_id`),
  ADD KEY `programs_state_id_foreign` (`state_id`),
  ADD KEY `programs_name_index` (`name`),
  ADD KEY `programs_contact_email_index` (`contact_email`),
  ADD KEY `programs_contact_phone_index` (`contact_phone`),
  ADD KEY `programs_address_index` (`address`),
  ADD KEY `programs_city_index` (`city`),
  ADD KEY `programs_zip_index` (`zip`),
  ADD KEY `programs_image_index` (`image`),
  ADD KEY `programs_date_added_index` (`date_added`),
  ADD KEY `programs_record_num_index` (`record_num`),
  ADD KEY `programs_created_by_foreign` (`created_by`),
  ADD KEY `programs_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `programs_organization_id_foreign` (`organization_id`);

--
-- Indexes for table `program_org_admin`
--
ALTER TABLE `program_org_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_org_admin_program_id_foreign` (`program_id`),
  ADD KEY `program_org_admin_admin_id_foreign` (`admin_id`),
  ADD KEY `program_org_admin_created_by_foreign` (`created_by`),
  ADD KEY `program_org_admin_last_modified_by_foreign` (`last_modified_by`);

--
-- Indexes for table `program_participant`
--
ALTER TABLE `program_participant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_participant_program_id_foreign` (`program_id`),
  ADD KEY `program_participant_id_foreign` (`participant_id`),
  ADD KEY `program_participant_created_by_foreign` (`created_by`),
  ADD KEY `program_participant_last_modified_by_foreign` (`last_modified_by`);

--
-- Indexes for table `program_provider`
--
ALTER TABLE `program_provider`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_provider_program_id_foreign` (`program_id`),
  ADD KEY `program_provider_provider_id_foreign` (`provider_id`),
  ADD KEY `program_provider_created_by_foreign` (`created_by`),
  ADD KEY `program_provider_last_modified_by_foreign` (`last_modified_by`);

--
-- Indexes for table `program_supervisor`
--
ALTER TABLE `program_supervisor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_supervisor_program_id_foreign` (`program_id`),
  ADD KEY `program_supervisor_supervisor_id_foreign` (`supervisor_id`),
  ADD KEY `program_supervisor_created_by_foreign` (`created_by`),
  ADD KEY `program_supervisor_last_modified_by_foreign` (`last_modified_by`);

--
-- Indexes for table `provider_supervisors`
--
ALTER TABLE `provider_supervisors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_supervisors_created_by_foreign` (`created_by`),
  ADD KEY `provider_supervisors_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `provider_supervisors_provider_id_foreign` (`provider_id`),
  ADD KEY `provider_supervisors_supervisor_id_foreign` (`supervisor_id`);

--
-- Indexes for table `provider_types`
--
ALTER TABLE `provider_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `provider_types_created_by_foreign` (`created_by`),
  ADD KEY `provider_types_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `provider_types_name_index` (`name`),
  ADD KEY `provider_types_org_type_id_foreign` (`org_type_id`);

--
-- Indexes for table `site_content`
--
ALTER TABLE `site_content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `site_content_created_by_foreign` (`created_by`),
  ADD KEY `site_content_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `site_content_reference_key_index` (`reference_key`);
ALTER TABLE `site_content` ADD FULLTEXT KEY `site_content_content_index` (`content`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`),
  ADD KEY `states_state_code_index` (`state_code`),
  ADD KEY `states_name_index` (`name`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tags_tag_type_id_foreign` (`tag_type_id`),
  ADD KEY `tags_tag_group_id_foreign` (`tag_group_id`),
  ADD KEY `tags_org_type_id_foreign` (`org_type_id`),
  ADD KEY `tags_created_by_foreign` (`created_by`),
  ADD KEY `tags_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `tags_tag_index` (`tag`);

--
-- Indexes for table `tag_groups`
--
ALTER TABLE `tag_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_groups_org_type_id_foreign` (`org_type_id`),
  ADD KEY `tag_groups_created_by_foreign` (`created_by`),
  ADD KEY `tag_groups_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `tag_groups_name_index` (`name`);

--
-- Indexes for table `tag_types`
--
ALTER TABLE `tag_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_types_created_by_foreign` (`created_by`),
  ADD KEY `tag_types_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `tag_types_type_index` (`type`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_first_name_index` (`first_name`),
  ADD KEY `users_last_name_index` (`last_name`),
  ADD KEY `users_email_verified_at_index` (`email_verified_at`),
  ADD KEY `users_password_index` (`password`),
  ADD KEY `users_phone_index` (`phone`),
  ADD KEY `users_city_index` (`city`),
  ADD KEY `users_zip_index` (`zip`),
  ADD KEY `users_record_num_index` (`record_num`),
  ADD KEY `users_image_index` (`image`),
  ADD KEY `users_last_login_index` (`last_login`),
  ADD KEY `users_organization_id_foreign` (`organization_id`),
  ADD KEY `users_state_id_foreign` (`state_id`),
  ADD KEY `users_user_type_id_foreign` (`user_type_id`);

--
-- Indexes for table `users_types`
--
ALTER TABLE `users_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_types_name_index` (`name`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_details_dob_index` (`dob`),
  ADD KEY `user_details_avg_goal_change_index` (`avg_goal_change`),
  ADD KEY `user_details_num_goals_index` (`num_goals`),
  ADD KEY `user_details_num_users_goals_index` (`num_users_goals`),
  ADD KEY `user_details_num_users_index` (`num_users`),
  ADD KEY `user_details_created_by_foreign` (`created_by`),
  ADD KEY `user_details_last_modified_by_foreign` (`last_modified_by`),
  ADD KEY `user_details_program_id_foreign` (`program_id`),
  ADD KEY `user_details_provider_id_foreign` (`provider_id`),
  ADD KEY `user_details_provider_type_id_foreign` (`provider_type_id`),
  ADD KEY `user_details_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `goals`
--
ALTER TABLE `goals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `goal_activity`
--
ALTER TABLE `goal_activity`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;
--
-- AUTO_INCREMENT for table `goal_activity_attachments`
--
ALTER TABLE `goal_activity_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `goal_scale`
--
ALTER TABLE `goal_scale`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;
--
-- AUTO_INCREMENT for table `goal_status`
--
ALTER TABLE `goal_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `goal_tag`
--
ALTER TABLE `goal_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `organizations`
--
ALTER TABLE `organizations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `organization_org_type`
--
ALTER TABLE `organization_org_type`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
--
-- AUTO_INCREMENT for table `org_types`
--
ALTER TABLE `org_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `participant_provider`
--
ALTER TABLE `participant_provider`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `program_org_admin`
--
ALTER TABLE `program_org_admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `program_participant`
--
ALTER TABLE `program_participant`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=194;
--
-- AUTO_INCREMENT for table `program_provider`
--
ALTER TABLE `program_provider`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;
--
-- AUTO_INCREMENT for table `program_supervisor`
--
ALTER TABLE `program_supervisor`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- AUTO_INCREMENT for table `provider_supervisors`
--
ALTER TABLE `provider_supervisors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;
--
-- AUTO_INCREMENT for table `provider_types`
--
ALTER TABLE `provider_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `site_content`
--
ALTER TABLE `site_content`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;
--
-- AUTO_INCREMENT for table `tag_groups`
--
ALTER TABLE `tag_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tag_types`
--
ALTER TABLE `tag_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;
--
-- AUTO_INCREMENT for table `users_types`
--
ALTER TABLE `users_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=189;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `goals`
--
ALTER TABLE `goals`
  ADD CONSTRAINT `goals_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goals_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goals_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goals_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goals_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `goal_status` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goal_activity`
--
ALTER TABLE `goal_activity`
  ADD CONSTRAINT `goal_activity_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_activity_goal_id_foreign` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_activity_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_activity_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goal_activity_attachments`
--
ALTER TABLE `goal_activity_attachments`
  ADD CONSTRAINT `goal_activity_attachments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_activity_attachments_goal_activity_id_foreign` FOREIGN KEY (`goal_activity_id`) REFERENCES `goal_activity` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_activity_attachments_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goal_scale`
--
ALTER TABLE `goal_scale`
  ADD CONSTRAINT `goal_scale_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_scale_goal_id_foreign` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_scale_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `goal_status`
--
ALTER TABLE `goal_status`
  ADD CONSTRAINT `goal_status_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `goal_status_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `goal_tag`
--
ALTER TABLE `goal_tag`
  ADD CONSTRAINT `goal_tag_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_tag_goal_id_foreign` FOREIGN KEY (`goal_id`) REFERENCES `goals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_tag_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `goal_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_state_id_foreign_key` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organization_org_type`
--
ALTER TABLE `organization_org_type`
  ADD CONSTRAINT `organization_org_type_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `organization_org_type_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `organization_org_type_org_type_id_foreign` FOREIGN KEY (`org_type_id`) REFERENCES `org_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `organization_org_type_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `org_types`
--
ALTER TABLE `org_types`
  ADD CONSTRAINT `org_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `org_types_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `participant_provider`
--
ALTER TABLE `participant_provider`
  ADD CONSTRAINT `participant_provider_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `participant_provider_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `participant_provider_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `participant_provider_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `participant_provider_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`),
  ADD CONSTRAINT `programs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `programs_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `programs_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `programs_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `program_org_admin`
--
ALTER TABLE `program_org_admin`
  ADD CONSTRAINT `program_org_admin_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_org_admin_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `program_org_admin_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `program_org_admin_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_participant`
--
ALTER TABLE `program_participant`
  ADD CONSTRAINT `program_participant_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_participant_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_participant_participant_id_foreign` FOREIGN KEY (`participant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_participant_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_provider`
--
ALTER TABLE `program_provider`
  ADD CONSTRAINT `program_provider_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `program_provider_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `program_provider_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_provider_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `program_supervisor`
--
ALTER TABLE `program_supervisor`
  ADD CONSTRAINT `program_supervisor_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_supervisor_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_supervisor_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_supervisor_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provider_supervisors`
--
ALTER TABLE `provider_supervisors`
  ADD CONSTRAINT `provider_supervisors_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_supervisors_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_supervisors_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_supervisors_supervisor_id_foreign` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `provider_types`
--
ALTER TABLE `provider_types`
  ADD CONSTRAINT `provider_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_types_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `provider_types_org_type_id_foreign` FOREIGN KEY (`org_type_id`) REFERENCES `org_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `site_content`
--
ALTER TABLE `site_content`
  ADD CONSTRAINT `site_content_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `site_content_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tags`
--
ALTER TABLE `tags`
  ADD CONSTRAINT `tags_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tags_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tags_org_type_id_foreign` FOREIGN KEY (`org_type_id`) REFERENCES `org_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tags_tag_group_id_foreign` FOREIGN KEY (`tag_group_id`) REFERENCES `tag_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tags_tag_type_id_foreign` FOREIGN KEY (`tag_type_id`) REFERENCES `tag_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_groups`
--
ALTER TABLE `tag_groups`
  ADD CONSTRAINT `tag_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tag_groups_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tag_groups_org_type_id_foreign` FOREIGN KEY (`org_type_id`) REFERENCES `org_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_types`
--
ALTER TABLE `tag_types`
  ADD CONSTRAINT `tag_types_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tag_types_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_organization_id_foreign` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `users_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_details`
--
ALTER TABLE `user_details`
  ADD CONSTRAINT `user_details_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_details_last_modified_by_foreign` FOREIGN KEY (`last_modified_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_details_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_details_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_details_provider_type_id_foreign` FOREIGN KEY (`provider_type_id`) REFERENCES `provider_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_details_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
