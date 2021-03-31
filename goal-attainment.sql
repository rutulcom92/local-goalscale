-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 21, 2021 at 05:14 PM
-- Server version: 5.7.26
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goal-attainment`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_type` varchar(255) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_type`, `event_name`, `created_at`) VALUES
(1, 'goal', 'Goals imported', '2021-01-23 00:00:00'),
(2, 'goal', 'Goal updated', '2021-01-23 00:00:00'),
(3, 'goal', 'Goal created', '2021-01-23 00:00:00'),
(4, 'user', 'Logged in', '2021-01-23 00:00:00'),
(5, 'user', 'User created', '2021-01-23 00:00:00'),
(6, 'user', 'User updated', '2021-01-23 00:00:00'),
(7, 'goal', 'Goal discontinued', '2021-01-23 00:00:00'),
(8, 'user', 'Logged out', '2021-01-23 00:00:00'),
(9, 'user', 'Password changed', '2021-02-09 00:00:00'),
(10, 'user', 'To many login attempts', '2021-02-09 00:00:00'),
(11, 'user', 'Incorrect credentials', '2021-02-09 00:00:00'),
(12, 'goal', 'Goal viewed', '2021-02-09 00:00:00'),
(13, 'organization', 'Organization added', '2021-02-12 00:00:00'),
(14, 'organization', 'Organization updated', '2021-02-12 00:00:00'),
(15, 'supervisor', 'Supervisor added', '2021-02-12 00:00:00'),
(16, 'supervisor', 'Supervisor updated', '2021-02-12 00:00:00'),
(17, 'program', 'Program added', '2021-02-12 00:00:00'),
(18, 'program', 'Program updated', '2021-02-12 00:00:00'),
(19, 'provider', 'Provider added', '2021-02-12 00:00:00'),
(20, 'provider', 'Provider updated', '2021-02-12 00:00:00'),
(21, 'participant', 'Participant added', '2021-02-12 00:00:00'),
(22, 'participant', 'Participant updated', '2021-02-12 00:00:00'),
(23, 'user', 'Users list imported', '2021-02-13 00:00:00'),
(24, 'user', 'Administrator added', '2021-02-13 00:00:00'),
(25, 'user', 'Administrator updated', '2021-02-13 00:00:00'),
(26, 'goal', 'Goal activity', '2021-02-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `log_events`
--

DROP TABLE IF EXISTS `log_events`;
CREATE TABLE IF NOT EXISTS `log_events` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `related_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
