-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2024 at 07:41 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `captcha_code`
--

CREATE TABLE `captcha_code` (
  `cpid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `cpcode` varchar(6) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `captcha_code`
--

INSERT INTO `captcha_code` (`cpid`, `uid`, `cpcode`, `createdate`) VALUES
(26, 276, '7915', '2022-06-01 11:28:27'),
(27, 277, '2271', '2022-06-01 11:30:15'),
(28, 278, '6046', '2022-06-01 11:33:58'),
(30, 280, '1225', '2022-06-03 08:14:39'),
(31, 282, '9599', '2022-06-03 09:32:47'),
(32, 283, '5148', '2024-02-08 01:38:09'),
(33, 284, '0523', '2024-08-17 05:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `cid` int(11) NOT NULL,
  `company` varchar(20) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `updateby` varchar(20) DEFAULT NULL,
  `isedit` int(11) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`cid`, `company`, `createdate`, `updatedate`, `createby`, `updateby`, `isedit`, `isdeleted`, `status`) VALUES
(1, 'Binance', '2022-04-20 21:07:44', '2022-06-02 08:55:06', 'admin', 'admin', 1, 0, 'created'),
(14, 'fdssdffd', '2022-05-07 06:38:18', NULL, 'admin', NULL, 0, 0, 'created'),
(15, 'fdssdffd', '2022-05-07 06:46:31', '2022-05-08 01:44:56', 'admin', 'admin', 1, 0, 'created'),
(16, 'fsfs', '2022-05-07 06:47:51', NULL, 'admin', NULL, 0, 0, 'created'),
(17, 'ghfhfjhfg', '2022-05-07 06:51:07', NULL, 'admin', NULL, 0, 0, 'created'),
(18, 'thththtj', '2022-05-07 06:51:31', NULL, 'admin', NULL, 0, 0, 'created'),
(19, 'dfsdfsf', '2022-05-07 06:52:04', NULL, 'admin', NULL, 0, 0, 'created'),
(20, 'bdgbdgdvbd', '2022-05-07 07:15:38', NULL, 'admin', NULL, 0, 0, 'created'),
(21, 'bfggd', '2022-05-07 07:30:20', NULL, 'admin', NULL, 0, 0, 'created'),
(22, 'bgbfbfd', '2022-05-07 07:30:49', NULL, 'admin', NULL, 0, 0, 'created'),
(23, 'dvdvfd', '2022-05-07 07:31:32', NULL, 'admin', NULL, 0, 0, 'created'),
(24, 'dfgdgdf', '2022-05-07 07:43:15', NULL, 'admin', NULL, 0, 0, 'created'),
(25, 'mnbnngn', '2022-05-07 07:48:40', NULL, 'admin', NULL, 0, 0, 'created'),
(26, 'vdvdvvv', '2022-05-07 07:49:49', NULL, 'admin', NULL, 0, 0, 'created'),
(27, 'jgjjhf', '2022-05-07 07:52:15', NULL, 'admin', NULL, 0, 0, 'created'),
(28, 'new', '2022-05-07 09:32:27', '2022-05-08 12:38:46', 'admin', 'admin', 1, 0, 'created'),
(29, 'bfbfbfbf', '2022-05-08 12:39:05', NULL, 'admin', NULL, NULL, 0, 'created'),
(30, 'bdfgbdv', '2022-05-08 12:39:38', NULL, 'admin', NULL, NULL, 0, 'created'),
(31, 'Test', '2024-08-29 12:10:01', '2024-08-29 12:39:06', 'admin', 'admin', 1, 0, 'created');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `ntfid` int(11) NOT NULL,
  `notification` text DEFAULT NULL,
  `createdate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`ntfid`, `notification`, `createdate`) VALUES
(1, 'test Eevent 1', '2022-05-05 13:57:03'),
(2, 'test Eevent 2', '2022-05-05 14:01:24'),
(3, 'test message', '2022-05-05 14:30:09'),
(4, 'test message', '2022-05-05 14:31:09'),
(5, 'test message', '2022-05-05 14:32:09'),
(6, 'test message', '2022-05-05 14:33:09'),
(7, 'test message', '2022-05-05 14:34:09'),
(8, 'test message', '2022-05-05 14:35:09'),
(9, 'test message', '2022-05-05 14:36:09'),
(10, 'test message', '2022-05-05 14:37:09'),
(11, 'test message', '2022-05-05 14:38:09'),
(12, 'test message', '2022-05-05 14:39:09'),
(13, 'test message', '2022-05-05 14:40:09'),
(14, 'test message', '2022-05-05 14:41:09'),
(15, 'test message', '2022-05-05 14:42:09'),
(16, 'test message', '2022-05-05 14:43:09'),
(17, 'test message', '2022-05-05 14:44:09'),
(18, 'test message', '2022-05-05 14:45:09'),
(19, 'test message', '2022-05-05 14:46:09'),
(20, 'test message', '2022-05-05 14:47:09'),
(21, 'test message', '2022-05-05 14:48:09'),
(22, 'test message', '2022-05-05 14:49:09'),
(23, 'test message', '2022-05-05 14:50:09'),
(24, 'test message', '2022-05-05 14:51:09'),
(25, 'test message', '2022-05-05 14:52:09'),
(26, 'test message', '2022-05-05 14:53:09'),
(27, 'test message', '2022-05-05 14:54:09'),
(28, 'test message', '2022-05-05 14:55:09'),
(29, 'test message', '2022-05-05 14:56:09'),
(30, 'test message', '2022-05-05 14:57:09'),
(31, 'test message', '2022-05-05 14:58:09'),
(32, 'test message', '2022-05-05 14:59:09'),
(33, 'test message', '2022-05-05 15:00:09'),
(34, 'test message', '2022-05-05 15:01:09'),
(35, 'test message', '2022-05-05 15:02:09'),
(36, 'test message', '2022-05-05 15:03:09'),
(37, 'test message', '2022-05-05 15:04:09'),
(38, 'test message', '2022-05-05 15:05:09'),
(39, 'test message', '2022-05-05 15:06:09'),
(40, 'test message', '2022-05-05 15:07:09'),
(41, 'test message', '2022-05-05 15:08:09'),
(42, 'test message', '2022-05-05 15:09:09'),
(43, 'test message', '2022-05-05 15:10:09'),
(44, 'test message', '2022-05-05 15:11:09'),
(45, 'test message', '2022-05-05 15:12:09'),
(46, 'test message', '2022-05-05 15:13:09'),
(47, 'test message', '2022-05-05 15:14:09'),
(48, 'test message', '2022-05-05 15:15:09'),
(49, 'test message', '2022-05-05 15:16:09'),
(50, 'test message', '2022-05-05 15:17:09'),
(51, 'test message', '2022-05-05 15:18:09'),
(52, 'test message', '2022-05-05 15:19:09'),
(53, 'test message', '2022-05-05 15:20:09'),
(54, 'test message', '2022-05-05 15:21:09'),
(55, 'test message', '2022-05-05 15:22:09'),
(56, 'test message', '2022-05-05 15:23:09'),
(57, 'test message', '2022-05-05 15:24:09'),
(58, 'test message', '2022-05-05 15:25:09'),
(59, 'test message', '2022-05-05 15:26:09'),
(60, 'test message', '2022-05-05 15:27:09'),
(61, 'test message', '2022-05-05 15:28:09'),
(62, 'test message', '2022-05-05 15:29:09'),
(63, 'test message', '2022-05-05 15:30:09'),
(64, 'test message', '2022-05-05 15:31:09'),
(65, 'test message', '2022-05-05 15:32:09'),
(66, 'test message', '2022-05-05 15:33:09'),
(67, 'test message', '2022-05-05 15:34:09'),
(68, 'test message', '2022-05-05 15:35:09'),
(69, 'test message', '2022-05-05 15:36:09'),
(70, 'test message', '2022-05-05 15:37:09'),
(71, 'test message', '2022-05-05 15:38:09'),
(72, 'test message', '2022-05-05 15:39:09'),
(73, 'test message', '2022-05-05 15:40:09'),
(74, 'test message', '2022-05-05 15:41:09'),
(75, 'test message', '2022-05-05 15:42:09'),
(76, 'test message', '2022-05-05 15:43:09'),
(77, 'test message', '2022-05-05 15:44:09'),
(78, 'test message', '2022-05-05 15:45:09'),
(79, 'test message', '2022-05-05 15:46:09'),
(80, 'test message', '2022-05-05 15:47:09'),
(81, 'test message', '2022-05-05 15:48:09'),
(82, 'test message', '2022-05-05 15:49:09'),
(83, 'test message', '2022-05-05 15:50:09'),
(84, 'test message', '2022-05-05 15:51:09'),
(85, 'test message', '2022-05-05 15:52:09'),
(86, 'test message', '2022-05-05 15:53:09'),
(87, 'test message', '2022-05-05 15:54:09'),
(88, 'test message', '2022-05-05 15:55:09');

-- --------------------------------------------------------

--
-- Table structure for table `password_history`
--

CREATE TABLE `password_history` (
  `phid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_history`
--

INSERT INTO `password_history` (`phid`, `uid`, `type`, `password`, `createdate`, `createby`, `status`, `remarks`) VALUES
(3, 276, 'login', 'user123', '2022-06-01 11:28:27', 'user123', 'created', 'login password created'),
(4, 276, 'transaction', '4455', '2022-06-01 11:28:27', 'user123', 'created', 'transaction password created'),
(5, 277, 'login', 'konain1', '2022-06-01 11:30:15', 'konain', 'created', 'login password created'),
(6, 277, 'transaction', '3322', '2022-06-01 11:30:15', 'konain', 'created', 'transaction password created'),
(7, 278, 'login', 'ahsan12', '2022-06-01 11:33:58', 'ahsan', 'created', 'login password created'),
(8, 278, 'transaction', '2211', '2022-06-01 11:33:58', 'ahsan', 'created', 'transaction password created'),
(11, 280, 'login', 'ahmed12', '2022-06-03 08:14:39', 'ahmed', 'created', 'login password created'),
(12, 280, 'transaction', '11', '2022-06-03 08:14:39', 'ahmed', 'created', 'transaction password created'),
(13, 282, 'login', 'sajid12', '2022-06-03 09:32:47', 'sajid', 'created', 'login password created'),
(14, 282, 'transaction', '11', '2022-06-03 09:32:47', 'sajid', 'created', 'transaction password created'),
(15, 283, 'login', 'kashan1', '2024-02-08 01:38:09', 'kashan', 'created', 'login password created'),
(16, 283, 'transaction', '1234', '2024-02-08 01:38:09', 'kashan', 'created', 'transaction password created'),
(17, 284, 'login', 'New1234', '2024-08-17 05:44:17', 'New', 'created', 'login password created'),
(18, 284, 'transaction', '2233', '2024-08-17 05:44:17', 'New', 'created', 'transaction password created');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `roleid` int(11) NOT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`roleid`, `role`) VALUES
(1, 'cp admin'),
(2, 'admin'),
(3, 'agent'),
(4, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tier_level`
--

CREATE TABLE `tier_level` (
  `tlvid` int(11) NOT NULL,
  `title` varchar(30) DEFAULT NULL,
  `level` varchar(3) DEFAULT NULL,
  `tno` int(11) DEFAULT NULL,
  `lrange` varchar(50) DEFAULT NULL,
  `com` varchar(20) DEFAULT NULL,
  `pcom` double DEFAULT NULL,
  `unlockdate` datetime DEFAULT NULL,
  `islock` tinyint(1) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tier_level`
--

INSERT INTO `tier_level` (`tlvid`, `title`, `level`, `tno`, `lrange`, `com`, `pcom`, `unlockdate`, `islock`, `status`) VALUES
(1, 'Tier 1', 'LV1', 50, '$100-500', '5%', 0.1, '2022-05-17 20:10:39', 0, 'unlock'),
(2, 'Tier 2', 'LV2', 55, '$500-1000', '8%', 0.14, '2022-05-17 20:17:18', 1, 'lock'),
(3, 'Tier 3', 'LV3', 60, '$1000-2000', '10%', 0.16, '2022-05-17 20:13:50', 1, 'lock'),
(4, 'Tier 4', 'LV4', 70, '$2000 or more', '12%', 0.17, NULL, 1, 'lock');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `roleid` int(11) DEFAULT NULL,
  `uname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `encpass` text DEFAULT NULL,
  `decpass` text DEFAULT NULL,
  `uimgname` varchar(20) DEFAULT NULL,
  `uimgguid` text DEFAULT NULL,
  `ccode` varchar(6) DEFAULT NULL,
  `ctitle` varchar(2) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `refcode` varchar(10) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `deletedate` datetime DEFAULT NULL,
  `blacklistdate` datetime DEFAULT NULL,
  `restoredate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `updateby` varchar(20) DEFAULT NULL,
  `deleteby` varchar(20) DEFAULT NULL,
  `blockby` varchar(20) DEFAULT NULL,
  `restoreby` varchar(20) DEFAULT NULL,
  `isedit` tinyint(1) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `isblock` tinyint(1) DEFAULT NULL,
  `istop` tinyint(1) DEFAULT NULL,
  `isrestore` tinyint(1) DEFAULT NULL,
  `isnew` tinyint(1) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `roleid`, `uname`, `email`, `encpass`, `decpass`, `uimgname`, `uimgguid`, `ccode`, `ctitle`, `mobile`, `country`, `refcode`, `createdate`, `updatedate`, `deletedate`, `blacklistdate`, `restoredate`, `createby`, `updateby`, `deleteby`, `blockby`, `restoreby`, `isedit`, `isdeleted`, `isblock`, `istop`, `isrestore`, `isnew`, `ip`, `status`, `remarks`) VALUES
(1, 1, 'admin', 'kashandeveloper@gmail.com', 'e6e061838856bf47e1de730719fb2609', 'admin@123', 'default image\n', 'profile_40x40.png', NULL, NULL, '03101136367', NULL, NULL, '2022-04-15 18:37:45', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, NULL),
(276, 4, 'user123', NULL, '6ad14ba9986e3615423dfca256d04e3f', 'user123', 'profile image', 'messi.jpg', '92', 'pk', '+923101136367', 'Pakistan (‫پاکستان‬‎)', 'ddagm8', '2022-06-01 11:28:27', '2022-06-02 08:26:32', '2022-06-02 08:27:15', '2022-06-02 07:53:53', '2022-06-02 08:28:33', NULL, 'user123', 'admin', 'admin', 'admin', NULL, 0, 0, NULL, 1, 0, NULL, 'new', NULL),
(277, 4, 'konain', NULL, 'd3985fd48d53d7a9f24b0b84d0a0a288', 'konain1', 'profile image', 'messi.jpg', '92', 'pk', '+923404445433', 'Pakistan (‫پاکستان‬‎)', '0Q8xKZ', '2022-06-01 11:30:15', '2022-06-03 01:41:24', NULL, NULL, NULL, NULL, 'konain', NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, NULL, 'new', NULL),
(278, 4, 'ahsan', NULL, '241138a9ffd584b5b228a8b02bef0671', 'ahsan12', 'default image', 'grab.png', '90', 'tr', '+905012345678', 'Turkey (Türkiye)', 'VkrcR3', '2022-06-01 11:33:58', NULL, '2022-06-02 06:30:39', '2022-06-02 08:34:43', '2022-06-02 08:36:27', NULL, NULL, NULL, 'admin', 'admin', NULL, 0, 0, NULL, 1, 0, NULL, 'new', NULL),
(280, 4, 'ahmed', NULL, '3ab66a6d1c52730432b5bd38a366c148', 'ahmed12', 'default image', 'grab.png', '92', 'pk', '+923122442124', 'Pakistan (‫پاکستان‬‎)', '2uOdGc', '2022-06-03 08:14:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, NULL, 'new', NULL),
(282, 4, 'sajid', NULL, '4b19837ef331661676b1c2b5c49a5fbb', 'sajid12', 'default image', 'grab.png', '92', 'pk', '+923172228544', 'Pakistan (‫پاکستان‬‎)', 'VkrcR3', '2022-06-03 09:32:47', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, NULL, 'new', NULL),
(283, 4, 'kashan', NULL, '58244e65b503ac6210ef50c62da3b938', 'kashan1', 'default image', 'grab.png', '', '', '', '', '0Q8xKZ', '2024-02-08 01:38:09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, NULL, 'new', NULL),
(284, 4, 'New', NULL, '7b8b1db5ae3bc0f6eba1b3426485d45d', 'New1234', 'default image', 'grab.png', '92', 'pk', '+923310237751', 'Pakistan (??????????)', '0Q8xKZ', '2024-08-17 05:44:17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 0, NULL, 'new', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `acid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `activitydate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`acid`, `uid`, `remarks`, `activitydate`, `device`, `ip`, `status`) VALUES
(0, 276, 'user login', '2022-06-14 02:42:05', 'dj', '192.168.2.103', 'login'),
(8, 276, 'user signup', '2022-06-01 11:28:27', 'dj', '192.168.8.102', 'signup'),
(9, 276, 'user login', '2022-06-01 11:28:27', 'dj', '192.168.8.102', 'login'),
(10, 276, 'user logout', '2022-06-01 11:28:49', 'dj', '192.168.8.102', 'login'),
(11, 277, 'user signup', '2022-06-01 11:30:15', 'dj', '192.168.8.102', 'signup'),
(12, 277, 'user login', '2022-06-01 11:30:15', 'dj', '192.168.8.102', 'login'),
(13, 277, 'user logout', '2022-06-01 11:31:05', 'dj', '192.168.8.102', 'login'),
(14, 276, 'user login', '2022-06-01 11:31:15', 'dj', '192.168.8.102', 'login'),
(15, 276, 'user logout', '2022-06-01 11:31:49', 'dj', '192.168.8.102', 'login'),
(16, 278, 'user signup', '2022-06-01 11:33:58', 'dj', '192.168.8.102', 'signup'),
(17, 278, 'user login', '2022-06-01 11:33:58', 'dj', '192.168.8.102', 'login'),
(18, 278, 'user logout', '2022-06-01 12:09:00', 'dj', '192.168.8.102', 'login'),
(19, 276, 'user login', '2022-06-01 12:12:57', 'dj', '192.168.8.102', 'login'),
(20, 276, 'user deposit', '2022-06-01 12:16:38', 'dj', '192.168.8.102', 'deposit'),
(21, 1, 'cp admin login', '2022-06-01 12:17:07', 'dj', '192.168.8.102', 'login'),
(22, 1, 'cp admin logout', '2022-06-01 12:17:15', 'dj', '192.168.8.102', 'login'),
(23, 1, 'cp admin login', '2022-06-01 12:17:47', 'dj', '192.168.8.102', 'login'),
(24, 1, 'approve deposit', '2022-06-01 12:18:15', 'dj', '192.168.8.102', 'approve'),
(25, 276, 'user tier level', '2022-06-01 09:18:23', 'dj', '192.168.8.102', 'created'),
(26, 276, 'user tier level', '2022-06-01 09:18:23', 'dj', '192.168.8.102', 'created'),
(27, 276, 'user tier level', '2022-06-01 09:18:23', 'dj', '192.168.8.102', 'created'),
(28, 276, 'user tier level', '2022-06-01 09:18:23', 'dj', '192.168.8.102', 'created'),
(29, 276, 'user no of order', '2022-06-01 12:18:26', 'dj', '192.168.8.102', 'created'),
(30, 276, 'user order', '2022-06-01 12:38:33', 'dj', '192.168.8.102', 'created'),
(31, 276, 'user order confirm', '2022-06-01 12:38:50', 'dj', '192.168.8.102', 'created'),
(32, 276, 'other commission', '2022-06-01 12:38:51', 'dj', '192.168.8.102', 'created'),
(33, 276, 'user logout', '2022-06-01 12:39:31', 'dj', '192.168.8.102', 'login'),
(34, 277, 'user login', '2022-06-01 12:40:12', 'dj', '192.168.8.102', 'login'),
(35, 277, 'user tier level', '2022-06-01 09:40:20', 'dj', '192.168.8.102', 'created'),
(36, 277, 'user tier level', '2022-06-01 09:40:20', 'dj', '192.168.8.102', 'created'),
(37, 277, 'user tier level', '2022-06-01 09:40:20', 'dj', '192.168.8.102', 'created'),
(38, 277, 'user tier level', '2022-06-01 09:40:20', 'dj', '192.168.8.102', 'created'),
(39, 277, 'user deposit', '2022-06-01 12:40:48', 'dj', '192.168.8.102', 'deposit'),
(40, 1, 'approve deposit', '2022-06-01 12:41:54', 'dj', '192.168.8.102', 'approve'),
(41, 277, 'user no of order', '2022-06-01 12:43:16', 'dj', '192.168.8.102', 'created'),
(42, 277, 'user order', '2022-06-01 12:43:27', 'dj', '192.168.8.102', 'created'),
(43, 277, 'user order confirm', '2022-06-01 12:43:40', 'dj', '192.168.8.102', 'created'),
(44, 277, 'other commission', '2022-06-01 12:43:41', 'dj', '192.168.8.102', 'created'),
(45, 277, 'user logout', '2022-06-01 12:44:09', 'dj', '192.168.8.102', 'login'),
(46, 276, 'user login', '2022-06-01 12:44:20', 'dj', '192.168.8.102', 'login'),
(47, 276, 'user logout', '2022-06-01 12:53:13', 'dj', '192.168.8.102', 'login'),
(48, 277, 'user login', '2022-06-01 12:53:56', 'dj', '192.168.8.102', 'login'),
(49, 277, 'user logout', '2022-06-01 12:54:39', 'dj', '192.168.8.102', 'login'),
(50, 278, 'user login', '2022-06-01 12:55:02', 'dj', '192.168.8.102', 'login'),
(51, 278, 'user deposit', '2022-06-01 12:55:22', 'dj', '192.168.8.102', 'deposit'),
(52, 1, 'approve deposit', '2022-06-01 12:55:41', 'dj', '192.168.8.102', 'approve'),
(53, 278, 'user tier level', '2022-06-01 09:55:49', 'dj', '192.168.8.102', 'created'),
(54, 278, 'user tier level', '2022-06-01 09:55:49', 'dj', '192.168.8.102', 'created'),
(55, 278, 'user tier level', '2022-06-01 09:55:49', 'dj', '192.168.8.102', 'created'),
(56, 278, 'user tier level', '2022-06-01 09:55:49', 'dj', '192.168.8.102', 'created'),
(57, 278, 'user no of order', '2022-06-01 12:55:50', 'dj', '192.168.8.102', 'created'),
(58, 278, 'user order', '2022-06-01 12:55:52', 'dj', '192.168.8.102', 'created'),
(59, 278, 'user order confirm', '2022-06-01 12:55:59', 'dj', '192.168.8.102', 'created'),
(60, 278, 'other commission', '2022-06-01 12:56:00', 'dj', '192.168.8.102', 'created'),
(61, 278, 'user logout', '2022-06-01 12:56:06', 'dj', '192.168.8.102', 'login'),
(62, 277, 'user login', '2022-06-01 12:56:16', 'dj', '192.168.8.102', 'login'),
(63, 277, 'user logout', '2022-06-01 12:57:23', 'dj', '192.168.8.102', 'login'),
(64, 276, 'user login', '2022-06-01 12:57:33', 'dj', '192.168.8.102', 'login'),
(65, 276, 'user logout', '2022-06-01 12:59:53', 'dj', '192.168.8.102', 'login'),
(66, 277, 'user login', '2022-06-01 01:00:16', 'dj', '192.168.8.102', 'login'),
(67, 276, 'user login', '2022-06-01 01:46:51', 'dj', '192.168.8.102', 'login'),
(68, 276, 'user order', '2022-06-01 03:28:08', 'dj', '192.168.8.102', 'created'),
(69, 276, 'user order confirm', '2022-06-01 03:28:15', 'dj', '192.168.8.102', 'created'),
(70, 276, 'other commission', '2022-06-01 03:28:16', 'dj', '192.168.8.102', 'created'),
(71, 276, 'user login', '2022-06-01 04:13:48', 'dj', '192.168.8.102', 'login'),
(72, 276, 'user login', '2022-06-01 05:59:22', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(73, 276, 'user deposit', '2022-06-01 06:49:19', 'DESKTOP-SJ45L77', '192.168.88.10', 'deposit'),
(74, 1, 'cp admin login', '2022-06-01 06:49:57', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(75, 1, 'approve deposit', '2022-06-01 06:50:06', 'DESKTOP-SJ45L77', '192.168.88.10', 'approve'),
(76, 276, 'user order', '2022-06-01 06:50:25', 'DESKTOP-SJ45L77', '192.168.88.10', 'created'),
(77, 276, 'user order confirm', '2022-06-01 06:50:36', 'DESKTOP-SJ45L77', '192.168.88.10', 'created'),
(78, 276, 'other commission', '2022-06-01 06:50:37', 'DESKTOP-SJ45L77', '192.168.88.10', 'created'),
(79, 276, 'user login', '2022-06-01 11:48:06', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(80, 276, 'user logout', '2022-06-02 12:03:07', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(81, 276, 'user login', '2022-06-02 12:03:16', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(82, 276, 'user logout', '2022-06-02 12:03:21', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(83, 277, 'user login', '2022-06-02 12:03:32', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(84, 277, 'user logout', '2022-06-02 12:03:40', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(85, 276, 'user login', '2022-06-02 12:03:48', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(86, 276, 'user update profile image', '2022-06-02 12:49:31', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(87, 276, 'user update profile image', '2022-06-02 12:50:10', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(88, 276, 'user update profile image', '2022-06-02 12:54:29', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(89, 276, 'user update profile image', '2022-06-02 01:03:21', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(90, 276, 'user update profile image', '2022-06-02 01:03:33', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(91, 276, 'user update profile image', '2022-06-02 01:03:45', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(92, 276, 'user update profile image', '2022-06-02 01:04:46', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(93, 276, 'user update profile image', '2022-06-02 01:05:02', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(94, 276, 'user update profile image', '2022-06-02 01:05:17', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(95, 276, 'user update profile image', '2022-06-02 01:05:31', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(96, 276, 'user update profile image', '2022-06-02 01:05:46', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(97, 276, 'user update profile image', '2022-06-02 01:05:58', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(98, 276, 'user update profile image', '2022-06-02 01:06:05', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(99, 276, 'user update profile image', '2022-06-02 01:06:31', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(100, 276, 'user update profile image', '2022-06-02 01:06:45', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(101, 276, 'user update profile image', '2022-06-02 01:07:07', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(102, 276, 'user update profile image', '2022-06-02 01:07:28', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(103, 276, 'user update profile image', '2022-06-02 01:11:05', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(104, 276, 'user update profile image', '2022-06-02 01:13:28', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(105, 276, 'user update profile image', '2022-06-02 01:13:40', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(106, 276, 'user update profile image', '2022-06-02 01:31:38', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(107, 276, 'user update profile image', '2022-06-02 01:31:44', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(108, 276, 'user logout', '2022-06-02 01:32:45', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(109, 276, 'user login', '2022-06-02 05:45:16', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(110, 276, 'user update profile image', '2022-06-02 05:59:34', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(111, 276, 'user update profile image', '2022-06-02 05:59:48', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(112, 276, 'user update profile image', '2022-06-02 06:00:22', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(113, 276, 'user update profile image', '2022-06-02 06:00:56', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(114, 276, 'user update profile image', '2022-06-02 06:01:02', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(115, 276, 'user update profile image', '2022-06-02 06:01:16', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(116, 276, 'user update profile image', '2022-06-02 06:12:59', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(117, 1, 'cp admin login', '2022-06-02 06:26:10', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(118, 1, 'delete user', '2022-06-02 07:28:13', 'DESKTOP-SJ45L77', '192.168.88.10', 'delete'),
(119, 1, 'restore user', '2022-06-02 07:29:38', 'DESKTOP-SJ45L77', '192.168.88.10', 'restore'),
(120, 1, 'delete user', '2022-06-02 07:31:59', 'DESKTOP-SJ45L77', '192.168.88.10', 'delete'),
(121, 1, 'restore user', '2022-06-02 07:32:05', 'DESKTOP-SJ45L77', '192.168.88.10', 'restore'),
(122, 1, 'delete user', '2022-06-02 07:32:16', 'DESKTOP-SJ45L77', '192.168.88.10', 'delete'),
(123, 1, 'restore user', '2022-06-02 07:32:28', 'DESKTOP-SJ45L77', '192.168.88.10', 'restore'),
(124, 1, 'block user', '2022-06-02 07:45:34', 'DESKTOP-SJ45L77', '192.168.88.10', 'block'),
(125, 1, 'restore block user', '2022-06-02 07:45:43', 'DESKTOP-SJ45L77', '192.168.88.10', 'restore'),
(126, 1, 'block user', '2022-06-02 07:53:53', 'DESKTOP-SJ45L77', '192.168.88.10', 'block'),
(127, 1, 'restore block user', '2022-06-02 07:56:19', 'DESKTOP-SJ45L77', '192.168.88.10', 'restore'),
(128, 1, 'delete user', '2022-06-02 07:56:41', 'DESKTOP-SJ45L77', '192.168.88.10', 'delete'),
(157, 276, 'user login', '2022-06-02 08:20:24', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(158, 276, 'user logout', '2022-06-02 08:20:40', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(159, 276, 'user login', '2022-06-02 08:25:03', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(160, 276, 'user update profile image', '2022-06-02 08:26:32', 'DESKTOP-SJ45L77', '192.168.88.10', 'update'),
(161, 1, 'delete user', '2022-06-02 08:27:15', 'DESKTOP-SJ45L77', '192.168.88.10', 'delete'),
(162, 276, 'user logout', '2022-06-02 08:28:18', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(163, 1, 'restore user', '2022-06-02 08:28:33', 'DESKTOP-SJ45L77', '192.168.88.10', 'restore'),
(164, 1, 'block user', '2022-06-02 08:34:43', 'DESKTOP-SJ45L77', '192.168.88.10', 'block'),
(165, 276, 'user login', '2022-06-02 08:35:29', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(166, 276, 'user logout', '2022-06-02 08:35:32', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(167, 276, 'user login', '2022-06-02 08:35:50', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(168, 276, 'user logout', '2022-06-02 08:35:53', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(169, 1, 'restore block user', '2022-06-02 08:36:27', 'DESKTOP-SJ45L77', '192.168.88.10', 'restore'),
(170, 1, 'cp admin logout', '2022-06-02 08:49:43', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(171, 1, 'cp admin login', '2022-06-02 08:53:14', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(172, 1, 'update wallet address', '2022-06-02 08:55:06', 'DESKTOP-SJ45L77', '192.168.88.10', 'approve'),
(173, 276, 'user login', '2022-06-02 08:55:29', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(174, 276, 'user logout', '2022-06-03 12:35:25', 'DESKTOP-SJ45L77', '192.168.88.10', 'login'),
(175, 276, 'user login', '2022-06-03 01:13:18', 'host.sofxol.com', '104.193.108.203', 'login'),
(176, 276, 'user logout', '2022-06-03 01:14:23', 'host.sofxol.com', '104.193.108.203', 'login'),
(177, 277, 'user login', '2022-06-03 01:14:30', 'host.sofxol.com', '104.193.108.203', 'login'),
(178, 277, 'user logout', '2022-06-03 01:21:00', 'host.sofxol.com', '104.193.108.203', 'login'),
(179, 277, 'user login', '2022-06-03 01:21:22', 'host.sofxol.com', '104.193.108.203', 'login'),
(180, 277, 'user logout', '2022-06-03 01:39:46', 'host.sofxol.com', '104.193.108.203', 'login'),
(181, 277, 'user login', '2022-06-03 01:40:31', 'host.sofxol.com', '104.193.108.203', 'login'),
(182, 277, 'user logout', '2022-06-03 01:41:01', 'host.sofxol.com', '104.193.108.203', 'login'),
(183, 277, 'user login', '2022-06-03 01:41:10', 'host.sofxol.com', '104.193.108.203', 'login'),
(184, 277, 'user update profile image', '2022-06-03 01:41:24', 'host.sofxol.com', '104.193.108.203', 'update'),
(185, 277, 'user logout', '2022-06-03 01:42:02', 'host.sofxol.com', '104.193.108.203', 'login'),
(186, 278, 'user login', '2022-06-03 01:42:17', 'host.sofxol.com', '104.193.108.203', 'login'),
(187, 278, 'user logout', '2022-06-03 01:42:50', 'host.sofxol.com', '104.193.108.203', 'login'),
(188, 1, 'cp admin login', '2022-06-03 01:46:03', 'host.sofxol.com', '104.193.108.203', 'login'),
(189, 276, 'user login', '2022-06-03 02:32:34', 'host.sofxol.com', '104.193.108.203', 'login'),
(190, 276, 'user login', '2022-06-03 03:16:56', 'host.sofxol.com', '104.193.108.203', 'login'),
(191, 276, 'user logout', '2022-06-03 03:20:26', 'host.sofxol.com', '104.193.108.203', 'login'),
(192, 276, 'user login', '2022-06-03 03:20:51', 'host.sofxol.com', '104.193.108.203', 'login'),
(193, 276, 'user logout', '2022-06-03 03:20:57', 'host.sofxol.com', '104.193.108.203', 'login'),
(194, 277, 'user login', '2022-06-03 03:21:41', 'host.sofxol.com', '104.193.108.203', 'login'),
(195, 277, 'user logout', '2022-06-03 03:24:00', 'host.sofxol.com', '104.193.108.203', 'login'),
(196, 278, 'user login', '2022-06-03 09:27:13', 'host.sofxol.com', '104.193.108.203', 'login'),
(197, 278, 'user order', '2022-06-03 09:28:23', 'host.sofxol.com', '104.193.108.203', 'created'),
(198, 278, 'user order confirm', '2022-06-03 09:28:32', 'host.sofxol.com', '104.193.108.203', 'created'),
(199, 278, 'user logout', '2022-06-03 09:29:27', 'host.sofxol.com', '104.193.108.203', 'login'),
(200, 277, 'user login', '2022-06-03 02:50:46', 'host.sofxol.com', '104.193.108.203', 'login'),
(201, 277, 'user logout', '2022-06-03 02:56:47', 'host.sofxol.com', '104.193.108.203', 'login'),
(202, 278, 'user login', '2022-06-03 02:57:00', 'host.sofxol.com', '104.193.108.203', 'login'),
(203, 278, 'user logout', '2022-06-03 02:58:14', 'host.sofxol.com', '104.193.108.203', 'login'),
(204, 276, 'user login', '2022-06-03 02:58:40', 'host.sofxol.com', '104.193.108.203', 'login'),
(205, 276, 'user logout', '2022-06-03 03:06:27', 'host.sofxol.com', '104.193.108.203', 'login'),
(206, 278, 'user login', '2022-06-03 03:06:50', 'host.sofxol.com', '104.193.108.203', 'login'),
(207, 278, 'user logout', '2022-06-03 03:07:49', 'host.sofxol.com', '104.193.108.203', 'login'),
(208, 277, 'user login', '2022-06-03 03:08:14', 'host.sofxol.com', '104.193.108.203', 'login'),
(209, 277, 'user logout', '2022-06-03 03:11:55', 'host.sofxol.com', '104.193.108.203', 'login'),
(210, 276, 'user login', '2022-06-03 03:12:09', 'host.sofxol.com', '104.193.108.203', 'login'),
(211, 1, 'cp admin login', '2022-06-03 03:19:33', 'host.sofxol.com', '104.193.108.203', 'login'),
(212, 276, 'user login', '2022-06-03 03:34:18', 'host.sofxol.com', '104.193.108.203', 'login'),
(213, 276, 'user logout', '2022-06-03 03:35:15', 'host.sofxol.com', '104.193.108.203', 'login'),
(214, 277, 'user login', '2022-06-03 03:35:27', 'host.sofxol.com', '104.193.108.203', 'login'),
(215, 276, 'user login', '2022-06-03 05:34:36', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(216, 1, 'cp admin login', '2022-06-03 06:10:25', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(217, 276, 'user logout', '2022-06-03 06:23:13', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(218, 277, 'user login', '2022-06-03 06:23:23', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(219, 277, 'user logout', '2022-06-03 06:36:39', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(220, 276, 'user login', '2022-06-03 06:36:46', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(221, 276, 'user logout', '2022-06-03 06:47:12', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(222, 277, 'user login', '2022-06-03 06:47:26', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(223, 277, 'user logout', '2022-06-03 07:03:42', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(249, 278, 'user logout', '2022-06-03 08:13:13', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(250, 280, 'user signup', '2022-06-03 08:14:39', 'DESKTOP-SJ45L77', '192.168.8.101', 'signup'),
(251, 280, 'user login', '2022-06-03 08:14:39', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(252, 280, 'user deposit', '2022-06-03 08:18:02', 'DESKTOP-SJ45L77', '192.168.8.101', 'deposit'),
(253, 1, 'approve deposit', '2022-06-03 08:18:11', 'DESKTOP-SJ45L77', '192.168.8.101', 'approve'),
(254, 280, 'user tier level', '2022-06-03 05:18:40', 'DESKTOP-SJ45L77', '192.168.8.101', 'created'),
(255, 280, 'user tier level', '2022-06-03 05:18:40', 'DESKTOP-SJ45L77', '192.168.8.101', 'created'),
(256, 280, 'user tier level', '2022-06-03 05:18:40', 'DESKTOP-SJ45L77', '192.168.8.101', 'created'),
(257, 280, 'user tier level', '2022-06-03 05:18:40', 'DESKTOP-SJ45L77', '192.168.8.101', 'created'),
(258, 280, 'user no of order', '2022-06-03 08:18:41', 'DESKTOP-SJ45L77', '192.168.8.101', 'created'),
(259, 280, 'user order', '2022-06-03 08:18:42', 'DESKTOP-SJ45L77', '192.168.8.101', 'created'),
(260, 280, 'user order confirm', '2022-06-03 08:18:53', 'DESKTOP-SJ45L77', '192.168.8.101', 'created'),
(261, 280, 'user logout', '2022-06-03 08:19:00', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(262, 278, 'user login', '2022-06-03 08:19:42', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(263, 278, 'user logout', '2022-06-03 08:22:32', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(264, 277, 'user login', '2022-06-03 08:24:06', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(265, 277, 'user logout', '2022-06-03 08:26:54', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(266, 278, 'user login', '2022-06-03 08:27:14', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(267, 278, 'user logout', '2022-06-03 08:27:30', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(268, 276, 'user login', '2022-06-03 08:27:40', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(269, 276, 'user logout', '2022-06-03 08:29:33', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(270, 277, 'user login', '2022-06-03 08:29:42', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(271, 277, 'user logout', '2022-06-03 09:26:13', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(272, 282, 'user signup', '2022-06-03 09:32:47', 'DESKTOP-SJ45L77', '192.168.8.101', 'signup'),
(273, 282, 'user login', '2022-06-03 09:32:47', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(274, 282, 'user logout', '2022-06-03 09:38:09', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(275, 277, 'user login', '2022-06-03 09:38:25', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(276, 277, 'user logout', '2022-06-03 10:08:34', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(277, 282, 'user login', '2022-06-03 10:08:43', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(278, 282, 'user deposit', '2022-06-03 10:09:06', 'DESKTOP-SJ45L77', '192.168.8.101', 'deposit'),
(279, 1, 'approve deposit', '2022-06-03 10:09:16', 'DESKTOP-SJ45L77', '192.168.8.101', 'approve'),
(280, 282, 'user logout', '2022-06-03 10:09:24', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(281, 277, 'user login', '2022-06-03 10:09:34', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(282, 277, 'user logout', '2022-06-03 10:35:45', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(283, 278, 'user login', '2022-06-03 10:35:59', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(284, 278, 'user logout', '2022-06-03 10:37:45', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(285, 276, 'user login', '2022-06-03 10:37:53', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(286, 276, 'user logout', '2022-06-03 10:51:57', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(287, 277, 'user login', '2022-06-03 10:52:05', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(288, 277, 'user logout', '2022-06-03 10:54:09', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(289, 278, 'user login', '2022-06-03 10:54:17', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(290, 278, 'user logout', '2022-06-03 11:05:50', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(291, 277, 'user login', '2022-06-03 11:10:17', 'DESKTOP-SJ45L77', '192.168.8.101', 'login'),
(292, 276, 'user login', '2022-06-19 03:39:37', 'dj', '192.168.2.104', 'login'),
(293, 276, 'user logout', '2022-06-19 03:39:49', 'dj', '192.168.2.104', 'login'),
(294, 276, 'user login', '2022-06-22 12:02:47', 'dj', '192.168.8.100', 'login'),
(295, 276, 'user logout', '2022-06-22 12:53:37', 'dj', '192.168.8.100', 'login'),
(296, 276, 'user login', '2022-06-22 12:57:44', 'dj', '192.168.8.100', 'login'),
(297, 276, 'user deposit', '2022-06-22 01:00:20', 'dj', '192.168.8.100', 'deposit'),
(298, 276, 'user login', '2022-11-12 11:12:22', 'dj', '192.168.100.3', 'login'),
(299, 276, 'user order', '2022-11-12 11:13:52', 'dj', '192.168.100.3', 'created'),
(300, 276, 'user order confirm', '2022-11-12 11:14:05', 'dj', '192.168.100.3', 'created'),
(301, 276, 'user order', '2022-11-12 11:14:26', 'dj', '192.168.100.3', 'created'),
(302, 276, 'user order confirm', '2022-11-12 11:14:38', 'dj', '192.168.100.3', 'created'),
(303, 276, 'user order', '2022-11-12 11:14:48', 'dj', '192.168.100.3', 'created'),
(304, 276, 'user order confirm', '2022-11-12 11:15:03', 'dj', '192.168.100.3', 'created'),
(305, 276, 'user logout', '2022-11-12 11:25:01', 'dj', '192.168.100.3', 'login'),
(306, 277, 'user login', '2022-11-12 11:25:19', 'dj', '192.168.100.3', 'login'),
(307, 277, 'user order', '2022-11-12 11:27:19', 'dj', '192.168.100.3', 'created'),
(308, 277, 'user order confirm', '2022-11-12 11:27:28', 'dj', '192.168.100.3', 'created'),
(309, 276, 'user login', '2022-11-12 11:28:34', 'dj', '192.168.100.3', 'login'),
(310, 277, 'user order', '2022-11-12 11:30:52', 'dj', '192.168.100.3', 'created'),
(311, 277, 'user order confirm', '2022-11-12 11:31:04', 'dj', '192.168.100.3', 'created'),
(312, 276, 'user login', '2023-06-10 12:31:14', 'dj', '192.168.2.102', 'login'),
(313, 276, 'user login', '2024-02-08 01:34:59', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(314, 283, 'user signup', '2024-02-08 01:38:09', 'DESKTOP-24L4L3E', '192.168.0.105', 'signup'),
(315, 283, 'user login', '2024-02-08 01:38:09', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(316, 283, 'user tier level', '2024-02-07 09:38:28', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(317, 283, 'user tier level', '2024-02-07 09:38:28', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(318, 283, 'user tier level', '2024-02-07 09:38:28', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(319, 283, 'user tier level', '2024-02-07 09:38:28', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(320, 283, 'user deposit', '2024-02-08 01:39:52', 'DESKTOP-24L4L3E', '192.168.0.105', 'deposit'),
(321, 283, 'user deposit', '2024-02-08 01:40:44', 'DESKTOP-24L4L3E', '192.168.0.105', 'deposit'),
(322, 283, 'user deposit', '2024-02-08 01:41:49', 'DESKTOP-24L4L3E', '192.168.0.105', 'deposit'),
(323, 283, 'user logout', '2024-02-08 01:42:32', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(324, 276, 'user login', '2024-02-08 01:42:40', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(325, 276, 'user order', '2024-02-08 01:44:39', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(326, 276, 'user order confirm', '2024-02-08 01:44:49', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(327, 276, 'user order', '2024-02-08 01:44:59', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(328, 276, 'user order confirm', '2024-02-08 01:45:09', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(329, 276, 'user logout', '2024-02-08 01:45:37', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(330, 283, 'user login', '2024-02-08 01:46:16', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(331, 283, 'user deposit', '2024-02-08 01:46:34', 'DESKTOP-24L4L3E', '192.168.0.105', 'deposit'),
(332, 283, 'user deposit', '2024-02-08 01:53:52', 'DESKTOP-24L4L3E', '192.168.0.105', 'deposit'),
(333, 283, 'user logout', '2024-02-08 01:55:06', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(334, 277, 'user login', '2024-02-08 01:55:21', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(335, 277, 'user deposit', '2024-02-08 01:55:51', 'DESKTOP-24L4L3E', '192.168.0.105', 'deposit'),
(336, 277, 'user order', '2024-02-08 01:56:27', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(337, 277, 'user order confirm', '2024-02-08 01:56:35', 'DESKTOP-24L4L3E', '192.168.0.105', 'created'),
(338, 277, 'user logout', '2024-02-08 01:56:49', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(339, 276, 'user login', '2024-02-08 01:56:53', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(340, 276, 'user logout', '2024-02-08 01:57:23', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(341, 277, 'user login', '2024-02-08 01:57:53', 'DESKTOP-24L4L3E', '192.168.0.105', 'login'),
(342, 276, 'user login', '2024-08-11 12:44:26', 'DESKTOP-24L4L3E', '192.168.2.104', 'login'),
(343, 276, 'user deposit', '2024-08-11 12:51:03', 'DESKTOP-24L4L3E', '192.168.2.104', 'deposit'),
(344, 276, 'user deposit', '2024-08-11 12:51:30', 'DESKTOP-24L4L3E', '192.168.2.104', 'deposit'),
(345, 1, 'cp admin login', '2024-08-11 12:56:18', 'DESKTOP-24L4L3E', '192.168.2.104', 'login'),
(346, 1, 'approve deposit', '2024-08-11 12:56:43', 'DESKTOP-24L4L3E', '192.168.2.104', 'approve'),
(347, 1, 'approve deposit', '2024-08-11 12:59:04', 'DESKTOP-24L4L3E', '192.168.2.104', 'approve'),
(348, 276, 'user no of order', '2024-08-11 12:59:19', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(349, 276, 'user order', '2024-08-11 12:59:22', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(350, 276, 'user order confirm', '2024-08-11 12:59:30', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(351, 276, 'user order', '2024-08-11 12:59:41', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(352, 276, 'user order confirm', '2024-08-11 12:59:49', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(353, 276, 'user order', '2024-08-11 01:00:48', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(354, 276, 'user order confirm', '2024-08-11 01:00:56', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(355, 276, 'user order', '2024-08-11 01:01:02', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(356, 276, 'user order confirm', '2024-08-11 01:01:09', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(357, 276, 'user order', '2024-08-11 01:01:12', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(358, 276, 'user order confirm', '2024-08-11 01:01:20', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(359, 276, 'user logout', '2024-08-11 01:05:28', 'DESKTOP-24L4L3E', '192.168.2.104', 'login'),
(360, 277, 'user login', '2024-08-11 01:05:47', 'DESKTOP-24L4L3E', '192.168.2.104', 'login'),
(361, 277, 'user deposit', '2024-08-11 01:06:09', 'DESKTOP-24L4L3E', '192.168.2.104', 'deposit'),
(362, 277, 'user deposit', '2024-08-11 01:06:40', 'DESKTOP-24L4L3E', '192.168.2.104', 'deposit'),
(363, 1, 'approve deposit', '2024-08-11 01:07:01', 'DESKTOP-24L4L3E', '192.168.2.104', 'approve'),
(364, 1, 'approve deposit', '2024-08-11 01:07:01', 'DESKTOP-24L4L3E', '192.168.2.104', 'approve'),
(365, 277, 'user no of order', '2024-08-11 01:07:28', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(366, 277, 'user order', '2024-08-11 01:07:35', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(367, 277, 'user order confirm', '2024-08-11 01:07:43', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(368, 277, 'user order', '2024-08-11 01:07:48', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(369, 277, 'user order confirm', '2024-08-11 01:07:55', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(370, 277, 'user order', '2024-08-11 01:07:59', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(371, 277, 'user order confirm', '2024-08-11 01:08:07', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(372, 277, 'user order', '2024-08-11 01:08:11', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(373, 277, 'user order confirm', '2024-08-11 01:08:20', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(374, 277, 'user order', '2024-08-11 01:08:22', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(375, 277, 'user order confirm', '2024-08-11 01:08:31', 'DESKTOP-24L4L3E', '192.168.2.104', 'created'),
(376, 277, 'user logout', '2024-08-11 01:08:53', 'DESKTOP-24L4L3E', '192.168.2.104', 'login'),
(377, 276, 'user login', '2024-08-11 01:09:12', 'DESKTOP-24L4L3E', '192.168.2.104', 'login'),
(378, 276, 'user login', '2024-08-14 09:28:17', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(379, 276, 'user login', '2024-08-15 09:59:58', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(380, 276, 'user login', '2024-08-16 09:06:36', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(381, 276, 'user login', '2024-08-16 09:06:37', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(382, 276, 'user login', '2024-08-16 10:23:29', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(383, 276, 'user login', '2024-08-16 12:25:17', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(384, 276, 'user login', '2024-08-16 03:09:49', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(385, 276, 'user login', '2024-08-16 05:19:46', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(386, 276, 'user login', '2024-08-16 11:38:09', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(387, 276, 'user login', '2024-08-16 11:38:10', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(388, 276, 'user login', '2024-08-17 09:58:23', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(389, 276, 'user login', '2024-08-17 05:10:33', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(390, 276, 'user order', '2024-08-17 05:11:21', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(391, 276, 'user order confirm', '2024-08-17 05:11:27', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(392, 276, 'user order', '2024-08-17 05:17:09', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(393, 276, 'user order confirm', '2024-08-17 05:17:19', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(394, 276, 'user order', '2024-08-17 05:17:30', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(395, 276, 'user order confirm', '2024-08-17 05:17:41', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(396, 276, 'user order', '2024-08-17 05:17:52', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(397, 276, 'user order confirm', '2024-08-17 05:18:03', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(398, 276, 'user order', '2024-08-17 05:22:41', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(399, 276, 'user order confirm', '2024-08-17 05:22:52', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(400, 284, 'user signup', '2024-08-17 05:44:17', 'd2.my-control-panel.com', '192.168.168.2', 'signup'),
(401, 284, 'user login', '2024-08-17 05:44:17', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(402, 284, 'user login', '2024-08-17 05:48:33', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(403, 284, 'user login', '2024-08-17 06:14:25', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(404, 276, 'user login', '2024-08-17 06:17:47', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(405, 276, 'user login', '2024-08-17 09:12:00', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(406, 276, 'user login', '2024-08-18 12:31:08', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(407, 276, 'user order', '2024-08-18 01:14:15', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(408, 276, 'user order confirm', '2024-08-18 01:14:25', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(409, 276, 'user login', '2024-08-18 02:43:00', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(410, 276, 'user login', '2024-08-18 10:09:58', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(411, 276, 'user login', '2024-08-20 09:21:58', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(412, 276, 'user order', '2024-08-20 09:22:58', 'd2.my-control-panel.com', '192.168.168.2', 'created'),
(413, 276, 'user login', '2024-08-25 01:43:03', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(414, 276, 'user login', '2024-08-25 07:15:46', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(415, 276, 'user login', '2024-08-26 04:16:07', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(416, 276, 'user login', '2024-08-26 04:25:01', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(417, 276, 'user login', '2024-08-27 10:31:07', 'd2.my-control-panel.com', '192.168.168.2', 'login'),
(418, 276, 'user login', '2024-08-27 11:46:53', 'Kashan', '192.168.14.104', 'login'),
(419, 276, 'user order', '2024-08-27 12:00:58', 'Kashan', '192.168.14.104', 'created'),
(420, 276, 'user order confirm', '2024-08-27 12:01:10', 'Kashan', '192.168.14.104', 'created'),
(421, 276, 'user no of order', '2024-08-27 12:03:37', 'Kashan', '192.168.14.104', 'created'),
(422, 276, 'user order', '2024-08-27 12:03:39', 'Kashan', '192.168.14.104', 'created'),
(423, 276, 'user order confirm', '2024-08-27 12:03:47', 'Kashan', '192.168.14.104', 'created'),
(424, 276, 'user no of order', '2024-08-27 12:06:34', 'Kashan', '192.168.14.104', 'created'),
(425, 276, 'user order', '2024-08-27 12:06:38', 'Kashan', '192.168.14.104', 'created'),
(426, 276, 'user order confirm', '2024-08-27 12:06:52', 'Kashan', '192.168.14.104', 'created'),
(427, 276, 'user no of order', '2024-08-27 12:19:21', 'Kashan', '192.168.14.104', 'created'),
(428, 276, 'user no of order', '2024-08-27 12:20:23', 'Kashan', '192.168.14.104', 'created'),
(429, 276, 'user no of order', '2024-08-27 12:21:58', 'Kashan', '192.168.14.104', 'created'),
(430, 276, 'user no of order', '2024-08-27 12:24:14', 'Kashan', '192.168.14.104', 'created'),
(431, 276, 'user no of order', '2024-08-27 12:24:54', 'Kashan', '192.168.14.104', 'created'),
(432, 276, 'user order', '2024-08-27 01:02:36', 'Kashan', '192.168.14.104', 'created'),
(433, 276, 'user order confirm', '2024-08-27 01:02:44', 'Kashan', '192.168.14.104', 'created'),
(434, 276, 'user order', '2024-08-27 01:02:52', 'Kashan', '192.168.14.104', 'created'),
(435, 276, 'user order confirm', '2024-08-27 01:03:00', 'Kashan', '192.168.14.104', 'created'),
(436, 276, 'user order', '2024-08-27 01:05:22', 'Kashan', '192.168.14.104', 'created'),
(437, 276, 'user order', '2024-08-27 01:06:23', 'Kashan', '192.168.14.104', 'created'),
(438, 276, 'user order confirm', '2024-08-27 01:06:30', 'Kashan', '192.168.14.104', 'created'),
(439, 276, 'user order', '2024-08-27 01:06:36', 'Kashan', '192.168.14.104', 'created'),
(440, 276, 'user order confirm', '2024-08-27 01:06:43', 'Kashan', '192.168.14.104', 'created'),
(441, 276, 'user order', '2024-08-27 01:07:43', 'Kashan', '192.168.14.104', 'created'),
(442, 276, 'user order confirm', '2024-08-27 01:07:50', 'Kashan', '192.168.14.104', 'created'),
(443, 276, 'user order', '2024-08-27 01:07:55', 'Kashan', '192.168.14.104', 'created'),
(444, 276, 'user order cancel', '2024-08-27 01:08:03', 'Kashan', '192.168.14.104', 'created'),
(445, 276, 'user order', '2024-08-27 03:00:58', 'Kashan', '192.168.14.104', 'created'),
(446, 276, 'user order confirm', '2024-08-27 03:01:11', 'Kashan', '192.168.14.104', 'created'),
(447, 276, 'user order', '2024-08-27 03:04:35', 'Kashan', '192.168.14.104', 'created'),
(448, 276, 'user order', '2024-08-27 03:14:02', 'Kashan', '192.168.14.104', 'created'),
(449, 276, 'user order', '2024-08-27 03:14:44', 'Kashan', '192.168.14.104', 'created'),
(450, 276, 'user order', '2024-08-27 03:20:22', 'Kashan', '192.168.14.104', 'created'),
(451, 276, 'user order', '2024-08-27 03:22:32', 'Kashan', '192.168.14.104', 'created'),
(452, 276, 'user order', '2024-08-27 03:24:30', 'Kashan', '192.168.14.104', 'created'),
(453, 276, 'user order', '2024-08-27 03:26:11', 'Kashan', '192.168.14.104', 'created'),
(454, 276, 'user order', '2024-08-27 03:28:50', 'Kashan', '192.168.14.104', 'created'),
(455, 276, 'user order confirm', '2024-08-27 03:29:05', 'Kashan', '192.168.14.104', 'created'),
(456, 276, 'user order', '2024-08-27 03:29:12', 'Kashan', '192.168.14.104', 'created'),
(457, 276, 'user order confirm', '2024-08-27 03:29:20', 'Kashan', '192.168.14.104', 'created'),
(458, 276, 'user order', '2024-08-27 03:29:22', 'Kashan', '192.168.14.104', 'created'),
(459, 276, 'user order confirm', '2024-08-27 03:29:37', 'Kashan', '192.168.14.104', 'created'),
(460, 276, 'user order', '2024-08-27 03:30:10', 'Kashan', '192.168.14.104', 'created'),
(461, 276, 'user order confirm', '2024-08-27 03:30:18', 'Kashan', '192.168.14.104', 'created'),
(462, 276, 'user order', '2024-08-27 03:31:47', 'Kashan', '192.168.14.104', 'created'),
(463, 276, 'user order confirm', '2024-08-27 03:31:55', 'Kashan', '192.168.14.104', 'created'),
(464, 276, 'user order', '2024-08-27 03:31:56', 'Kashan', '192.168.14.104', 'created'),
(465, 276, 'user order confirm', '2024-08-27 03:32:09', 'Kashan', '192.168.14.104', 'created'),
(466, 276, 'user order', '2024-08-27 03:32:10', 'Kashan', '192.168.14.104', 'created'),
(467, 276, 'user order confirm', '2024-08-27 03:32:22', 'Kashan', '192.168.14.104', 'created'),
(468, 276, 'user order', '2024-08-27 03:32:24', 'Kashan', '192.168.14.104', 'created'),
(469, 276, 'user order confirm', '2024-08-27 03:32:31', 'Kashan', '192.168.14.104', 'created'),
(470, 276, 'user order', '2024-08-27 03:32:33', 'Kashan', '192.168.14.104', 'created'),
(471, 276, 'user order cancel', '2024-08-27 03:32:50', 'Kashan', '192.168.14.104', 'created'),
(472, 276, 'user order', '2024-08-27 03:33:02', 'Kashan', '192.168.14.104', 'created'),
(473, 276, 'user order confirm', '2024-08-27 03:33:23', 'Kashan', '192.168.14.104', 'created'),
(474, 276, 'user order', '2024-08-27 03:33:41', 'Kashan', '192.168.14.104', 'created'),
(475, 276, 'user order confirm', '2024-08-27 03:33:53', 'Kashan', '192.168.14.104', 'created'),
(476, 276, 'user order', '2024-08-27 03:34:13', 'Kashan', '192.168.14.104', 'created'),
(477, 276, 'user order confirm', '2024-08-27 03:34:29', 'Kashan', '192.168.14.104', 'created'),
(478, 276, 'user order', '2024-08-27 03:34:42', 'Kashan', '192.168.14.104', 'created'),
(479, 276, 'user order confirm', '2024-08-27 03:34:53', 'Kashan', '192.168.14.104', 'created'),
(480, 276, 'user logout', '2024-08-27 04:27:20', 'Kashan', '192.168.14.104', 'login'),
(481, 284, 'user login', '2024-08-27 04:27:36', 'Kashan', '192.168.14.104', 'login'),
(482, 284, 'user logout', '2024-08-27 04:27:52', 'Kashan', '192.168.14.104', 'login'),
(483, 277, 'user login', '2024-08-27 04:28:02', 'Kashan', '192.168.14.104', 'login'),
(484, 277, 'user no of order', '2024-08-27 04:29:30', 'Kashan', '192.168.14.104', 'created'),
(485, 277, 'user order', '2024-08-27 04:29:34', 'Kashan', '192.168.14.104', 'created'),
(486, 277, 'user order confirm', '2024-08-27 04:29:42', 'Kashan', '192.168.14.104', 'created'),
(487, 277, 'user order', '2024-08-27 04:30:21', 'Kashan', '192.168.14.104', 'created'),
(488, 277, 'user order confirm', '2024-08-27 04:30:29', 'Kashan', '192.168.14.104', 'created'),
(489, 277, 'user logout', '2024-08-27 04:30:37', 'Kashan', '192.168.14.104', 'login'),
(490, 276, 'user login', '2024-08-27 04:30:52', 'Kashan', '192.168.14.104', 'login'),
(491, 276, 'user logout', '2024-08-27 04:44:08', 'Kashan', '192.168.14.104', 'login'),
(492, 276, 'user login', '2024-08-27 04:44:39', 'Kashan', '192.168.14.104', 'login'),
(493, 277, 'user login', '2024-08-27 04:44:59', 'Kashan', '192.168.14.104', 'login'),
(494, 277, 'user order', '2024-08-27 04:45:19', 'Kashan', '192.168.14.104', 'created'),
(495, 277, 'user order confirm', '2024-08-27 04:45:50', 'Kashan', '192.168.14.104', 'created'),
(496, 277, 'user order', '2024-08-27 04:53:43', 'Kashan', '192.168.14.104', 'created'),
(497, 277, 'user order confirm', '2024-08-27 04:53:51', 'Kashan', '192.168.14.104', 'created'),
(498, 277, 'user order', '2024-08-27 05:13:02', 'Kashan', '192.168.14.104', 'created'),
(499, 277, 'user order confirm', '2024-08-27 05:13:17', 'Kashan', '192.168.14.104', 'created'),
(500, 277, 'user order', '2024-08-27 05:14:27', 'Kashan', '192.168.14.104', 'created'),
(501, 277, 'user order confirm', '2024-08-27 05:14:35', 'Kashan', '192.168.14.104', 'created'),
(502, 277, 'user order', '2024-08-27 05:14:41', 'Kashan', '192.168.14.104', 'created'),
(503, 277, 'user order confirm', '2024-08-27 05:14:48', 'Kashan', '192.168.14.104', 'created'),
(504, 276, 'user login', '2024-08-28 11:54:03', 'Kashan', '192.168.47.62', 'login'),
(505, 277, 'user login', '2024-08-28 02:28:09', 'Kashan', '192.168.14.104', 'login'),
(506, 277, 'user order', '2024-08-28 02:29:33', 'Kashan', '192.168.14.104', 'created'),
(507, 277, 'user order confirm', '2024-08-28 02:29:48', 'Kashan', '192.168.14.104', 'created'),
(508, 277, 'user order', '2024-08-28 02:29:54', 'Kashan', '192.168.14.104', 'created'),
(509, 277, 'user order confirm', '2024-08-28 02:30:05', 'Kashan', '192.168.14.104', 'created'),
(510, 277, 'user order', '2024-08-28 02:30:14', 'Kashan', '192.168.14.104', 'created'),
(511, 277, 'user order confirm', '2024-08-28 02:30:22', 'Kashan', '192.168.14.104', 'created'),
(512, 277, 'user order', '2024-08-28 02:56:36', 'Kashan', '192.168.14.104', 'created'),
(513, 277, 'user order confirm', '2024-08-28 02:56:45', 'Kashan', '192.168.14.104', 'created'),
(514, 277, 'user order', '2024-08-28 02:57:15', 'Kashan', '192.168.14.104', 'created'),
(515, 277, 'user order confirm', '2024-08-28 02:57:22', 'Kashan', '192.168.14.104', 'created'),
(516, 277, 'user order', '2024-08-28 02:57:26', 'Kashan', '192.168.14.104', 'created'),
(517, 277, 'user order confirm', '2024-08-28 02:57:33', 'Kashan', '192.168.14.104', 'created'),
(518, 277, 'user order', '2024-08-28 02:57:42', 'Kashan', '192.168.14.104', 'created'),
(519, 277, 'user order confirm', '2024-08-28 02:57:51', 'Kashan', '192.168.14.104', 'created'),
(520, 277, 'user order', '2024-08-28 02:57:55', 'Kashan', '192.168.14.104', 'created'),
(521, 277, 'user order confirm', '2024-08-28 02:58:06', 'Kashan', '192.168.14.104', 'created'),
(522, 277, 'user order', '2024-08-28 02:58:09', 'Kashan', '192.168.14.104', 'created'),
(523, 277, 'user order confirm', '2024-08-28 02:58:17', 'Kashan', '192.168.14.104', 'created'),
(524, 277, 'user order', '2024-08-28 02:58:21', 'Kashan', '192.168.14.104', 'created'),
(525, 277, 'user order confirm', '2024-08-28 02:58:28', 'Kashan', '192.168.14.104', 'created'),
(526, 277, 'user order', '2024-08-28 02:59:06', 'Kashan', '192.168.14.104', 'created'),
(527, 277, 'user order confirm', '2024-08-28 02:59:16', 'Kashan', '192.168.14.104', 'created'),
(528, 277, 'user order', '2024-08-28 02:59:21', 'Kashan', '192.168.14.104', 'created'),
(529, 277, 'user order confirm', '2024-08-28 02:59:28', 'Kashan', '192.168.14.104', 'created'),
(530, 277, 'user order', '2024-08-28 02:59:32', 'Kashan', '192.168.14.104', 'created'),
(531, 277, 'user order confirm', '2024-08-28 02:59:41', 'Kashan', '192.168.14.104', 'created'),
(532, 277, 'user order', '2024-08-28 03:00:46', 'Kashan', '192.168.14.104', 'created'),
(533, 277, 'user order confirm', '2024-08-28 03:00:55', 'Kashan', '192.168.14.104', 'created'),
(534, 277, 'user order', '2024-08-28 03:01:19', 'Kashan', '192.168.14.104', 'created'),
(535, 277, 'user order confirm', '2024-08-28 03:01:26', 'Kashan', '192.168.14.104', 'created'),
(536, 277, 'user order', '2024-08-28 03:17:21', 'Kashan', '192.168.14.104', 'created'),
(537, 277, 'user order confirm', '2024-08-28 03:17:28', 'Kashan', '192.168.14.104', 'created'),
(538, 277, 'user order', '2024-08-28 03:17:45', 'Kashan', '192.168.14.104', 'created'),
(539, 277, 'user order confirm', '2024-08-28 03:17:53', 'Kashan', '192.168.14.104', 'created'),
(540, 277, 'user order', '2024-08-28 03:17:56', 'Kashan', '192.168.14.104', 'created'),
(541, 277, 'user order confirm', '2024-08-28 03:18:04', 'Kashan', '192.168.14.104', 'created'),
(542, 277, 'user order', '2024-08-28 03:18:09', 'Kashan', '192.168.14.104', 'created'),
(543, 277, 'user order confirm', '2024-08-28 03:18:17', 'Kashan', '192.168.14.104', 'created'),
(544, 277, 'user order', '2024-08-28 03:18:20', 'Kashan', '192.168.14.104', 'created'),
(545, 277, 'user order confirm', '2024-08-28 03:18:27', 'Kashan', '192.168.14.104', 'created'),
(546, 276, 'user order', '2024-08-28 04:13:24', 'Kashan', '192.168.14.104', 'created'),
(547, 276, 'user order confirm', '2024-08-28 04:13:32', 'Kashan', '192.168.14.104', 'created'),
(548, 1, 'cp admin login', '2024-08-28 04:50:29', 'Kashan', '192.168.14.104', 'login'),
(549, 1, 'cp admin login', '2024-08-29 11:07:33', 'Kashan', '192.168.10.184', 'login'),
(550, 276, 'user login', '2024-08-29 12:06:42', 'Kashan', '192.168.10.184', 'login'),
(551, 276, 'user no of order', '2024-08-29 12:06:50', 'Kashan', '192.168.10.184', 'created'),
(552, 1, 'add wallet address', '2024-08-29 12:10:01', 'Kashan', '192.168.10.184', 'created'),
(553, 1, 'update wallet address', '2024-08-29 12:12:04', 'Kashan', '192.168.10.184', 'approve'),
(554, 1, 'update wallet address', '2024-08-29 12:17:22', 'Kashan', '192.168.10.184', 'approve'),
(555, 1, 'update wallet address', '2024-08-29 12:22:57', 'Kashan', '192.168.10.184', 'approve'),
(556, 1, 'update wallet address', '2024-08-29 12:23:21', 'Kashan', '192.168.10.184', 'approve'),
(557, 1, 'update wallet address', '2024-08-29 12:39:06', 'Kashan', '192.168.10.184', 'active'),
(558, 1, 'cp admin login', '2024-08-30 10:36:34', 'Kashan', '192.168.2.124', 'login'),
(559, 276, 'user login', '2024-08-30 10:38:35', 'Kashan', '192.168.2.124', 'login'),
(560, 276, 'user deposit', '2024-08-30 11:39:29', 'Kashan', '192.168.2.124', 'deposit'),
(561, 1, 'cp admin login', '2024-09-19 07:40:09', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login'),
(562, 1, 'cp admin login', '2024-09-19 08:15:49', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login'),
(563, 1, 'cp admin login', '2024-09-19 08:24:53', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login'),
(564, 1, 'cp admin logout', '2024-09-19 08:25:00', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login'),
(565, 1, 'cp admin login', '2024-09-19 08:25:04', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login'),
(566, 1, 'cp admin logout', '2024-09-19 08:25:17', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login'),
(567, 1, 'cp admin login', '2024-09-19 08:25:20', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login'),
(568, 1, 'cp admin logout', '2024-09-19 09:26:20', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login'),
(569, 1, 'cp admin login', '2024-09-19 09:26:24', 'DESKTOP-PPKUPOE', '192.168.100.27', 'login');

-- --------------------------------------------------------

--
-- Table structure for table `user_company`
--

CREATE TABLE `user_company` (
  `ucid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `selected` varchar(50) NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL,
  `createby` varchar(20) NOT NULL,
  `updateby` varchar(20) NOT NULL,
  `assignby` varchar(20) NOT NULL,
  `isedit` tinyint(1) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `ulid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `loginid` varchar(20) DEFAULT NULL,
  `logindate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `islogin` tinyint(1) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`ulid`, `uid`, `remarks`, `loginid`, `logindate`, `device`, `ip`, `islogin`, `status`) VALUES
(0, 276, 'user login', 'loginid=Mjc2', '2022-06-14 02:42:05', 'dj', '192.168.2.103', 1, 'login'),
(3, 276, 'user login', 'loginid=Mjc2', '2022-06-01 11:28:27', 'dj', '192.168.8.102', 1, 'login'),
(4, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 11:28:49', 'dj', '192.168.8.102', 0, 'logout'),
(5, 277, 'user login', 'loginid=Mjc3', '2022-06-01 11:30:15', 'dj', '192.168.8.102', 1, 'login'),
(6, 277, 'user logout', 'loginid=Mjc3', '2022-06-01 11:31:05', 'dj', '192.168.8.102', 0, 'logout'),
(7, 276, 'user login', 'loginid=Mjc2', '2022-06-01 11:31:15', 'dj', '192.168.8.102', 1, 'login'),
(8, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 11:31:49', 'dj', '192.168.8.102', 0, 'logout'),
(9, 278, 'user login', 'loginid=Mjc4', '2022-06-01 11:33:58', 'dj', '192.168.8.102', 1, 'login'),
(10, 278, 'user logout', 'loginid=Mjc4', '2022-06-01 12:09:00', 'dj', '192.168.8.102', 0, 'logout'),
(11, 276, 'user login', 'loginid=Mjc2', '2022-06-01 12:12:57', 'dj', '192.168.8.102', 1, 'login'),
(12, 1, 'cp admin login', NULL, '2022-06-01 12:17:07', 'dj', '192.168.8.102', 1, 'login'),
(13, 1, 'cp admin logout', NULL, '2022-06-01 12:17:15', 'dj', '192.168.8.102', 0, 'logout'),
(14, 1, 'cp admin login', NULL, '2022-06-01 12:17:47', 'dj', '192.168.8.102', 1, 'login'),
(15, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 12:39:31', 'dj', '192.168.8.102', 0, 'logout'),
(16, 277, 'user login', 'loginid=Mjc3', '2022-06-01 12:40:12', 'dj', '192.168.8.102', 1, 'login'),
(17, 277, 'user logout', 'loginid=Mjc3', '2022-06-01 12:44:09', 'dj', '192.168.8.102', 0, 'logout'),
(18, 276, 'user login', 'loginid=Mjc2', '2022-06-01 12:44:20', 'dj', '192.168.8.102', 1, 'login'),
(19, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 12:53:13', 'dj', '192.168.8.102', 0, 'logout'),
(20, 277, 'user login', 'loginid=Mjc3', '2022-06-01 12:53:56', 'dj', '192.168.8.102', 1, 'login'),
(21, 277, 'user logout', 'loginid=Mjc3', '2022-06-01 12:54:39', 'dj', '192.168.8.102', 0, 'logout'),
(22, 278, 'user login', 'loginid=Mjc4', '2022-06-01 12:55:02', 'dj', '192.168.8.102', 1, 'login'),
(23, 278, 'user logout', 'loginid=Mjc4', '2022-06-01 12:56:06', 'dj', '192.168.8.102', 0, 'logout'),
(24, 277, 'user login', 'loginid=Mjc3', '2022-06-01 12:56:16', 'dj', '192.168.8.102', 1, 'login'),
(25, 277, 'user logout', 'loginid=Mjc3', '2022-06-01 12:57:23', 'dj', '192.168.8.102', 0, 'logout'),
(26, 276, 'user login', 'loginid=Mjc2', '2022-06-01 12:57:33', 'dj', '192.168.8.102', 1, 'login'),
(27, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 12:59:53', 'dj', '192.168.8.102', 0, 'logout'),
(28, 277, 'user login', 'loginid=Mjc3', '2022-06-01 01:00:16', 'dj', '192.168.8.102', 1, 'login'),
(29, 276, 'user login', 'loginid=Mjc2', '2022-06-01 01:46:51', 'dj', '192.168.8.102', 1, 'login'),
(30, 276, 'user login', 'loginid=Mjc2', '2022-06-01 04:13:48', 'dj', '192.168.8.102', 1, 'login'),
(31, 276, 'user login', 'loginid=Mjc2', '2022-06-01 05:59:22', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(32, 1, 'cp admin login', NULL, '2022-06-01 06:49:57', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(33, 276, 'user login', 'loginid=Mjc2', '2022-06-01 11:48:06', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(34, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 12:03:07', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(35, 276, 'user login', 'loginid=Mjc2', '2022-06-02 12:03:16', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(36, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 12:03:21', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(37, 277, 'user login', 'loginid=Mjc3', '2022-06-02 12:03:32', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(38, 277, 'user logout', 'loginid=Mjc3', '2022-06-02 12:03:40', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(39, 276, 'user login', 'loginid=Mjc2', '2022-06-02 12:03:48', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(40, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 01:32:45', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(41, 276, 'user login', 'loginid=Mjc2', '2022-06-02 05:45:16', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(42, 1, 'cp admin login', NULL, '2022-06-02 06:26:10', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(43, 276, 'user login', 'loginid=Mjc2', '2022-06-02 08:20:24', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(44, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 08:20:40', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(45, 276, 'user login', 'loginid=Mjc2', '2022-06-02 08:25:03', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(46, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 08:28:18', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(47, 276, 'user login', 'loginid=Mjc2', '2022-06-02 08:35:29', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(48, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 08:35:32', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(49, 276, 'user login', 'loginid=Mjc2', '2022-06-02 08:35:50', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(50, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 08:35:53', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(51, 1, 'cp admin logout', NULL, '2022-06-02 08:49:43', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(52, 1, 'cp admin login', NULL, '2022-06-02 08:53:14', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(53, 276, 'user login', 'loginid=Mjc2', '2022-06-02 08:55:29', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'login'),
(54, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 12:35:25', 'DESKTOP-SJ45L77', '192.168.88.10', 0, 'logout'),
(55, 276, 'user login', 'loginid=Mjc2', '2022-06-03 01:13:18', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(56, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 01:14:23', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(57, 277, 'user login', 'loginid=Mjc3', '2022-06-03 01:14:30', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(58, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 01:21:00', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(59, 277, 'user login', 'loginid=Mjc3', '2022-06-03 01:21:22', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(60, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 01:39:46', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(61, 277, 'user login', 'loginid=Mjc3', '2022-06-03 01:40:31', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(62, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 01:41:01', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(63, 277, 'user login', 'loginid=Mjc3', '2022-06-03 01:41:10', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(64, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 01:42:02', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(65, 278, 'user login', 'loginid=Mjc4', '2022-06-03 01:42:17', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(66, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 01:42:50', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(67, 1, 'cp admin login', NULL, '2022-06-03 01:46:03', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(68, 276, 'user login', 'loginid=Mjc2', '2022-06-03 02:32:34', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(69, 276, 'user login', 'loginid=Mjc2', '2022-06-03 03:16:56', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(70, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 03:20:26', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(71, 276, 'user login', 'loginid=Mjc2', '2022-06-03 03:20:51', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(72, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 03:20:57', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(73, 277, 'user login', 'loginid=Mjc3', '2022-06-03 03:21:41', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(74, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 03:24:00', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(75, 278, 'user login', 'loginid=Mjc4', '2022-06-03 09:27:13', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(76, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 09:29:27', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(77, 277, 'user login', 'loginid=Mjc3', '2022-06-03 02:50:46', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(78, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 02:56:47', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(79, 278, 'user login', 'loginid=Mjc4', '2022-06-03 02:57:00', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(80, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 02:58:14', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(81, 276, 'user login', 'loginid=Mjc2', '2022-06-03 02:58:40', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(82, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 03:06:27', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(83, 278, 'user login', 'loginid=Mjc4', '2022-06-03 03:06:50', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(84, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 03:07:49', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(85, 277, 'user login', 'loginid=Mjc3', '2022-06-03 03:08:14', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(86, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 03:11:55', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(87, 276, 'user login', 'loginid=Mjc2', '2022-06-03 03:12:09', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(88, 1, 'cp admin login', NULL, '2022-06-03 03:19:33', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(89, 276, 'user login', 'loginid=Mjc2', '2022-06-03 03:34:18', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(90, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 03:35:15', 'host.sofxol.com', '104.193.108.203', 0, 'logout'),
(91, 277, 'user login', 'loginid=Mjc3', '2022-06-03 03:35:27', 'host.sofxol.com', '104.193.108.203', 1, 'login'),
(92, 276, 'user login', 'loginid=Mjc2', '2022-06-03 05:34:36', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(93, 1, 'cp admin login', NULL, '2022-06-03 06:10:25', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(94, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 06:23:13', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(95, 277, 'user login', 'loginid=Mjc3', '2022-06-03 06:23:23', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(96, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 06:36:39', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(97, 276, 'user login', 'loginid=Mjc2', '2022-06-03 06:36:46', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(98, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 06:47:12', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(99, 277, 'user login', 'loginid=Mjc3', '2022-06-03 06:47:26', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(100, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 07:03:42', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(101, 278, 'user login', 'loginid=Mjc4', '2022-06-03 07:03:51', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(102, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 07:04:04', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(103, 276, 'user login', 'loginid=Mjc2', '2022-06-03 07:04:12', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(104, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 07:38:06', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(107, 276, 'user login', 'loginid=Mjc2', '2022-06-03 07:40:22', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(108, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 07:47:16', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(111, 278, 'user login', 'loginid=Mjc4', '2022-06-03 07:49:07', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(112, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 07:49:56', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(113, 277, 'user login', 'loginid=Mjc3', '2022-06-03 07:50:05', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(114, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 07:53:52', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(115, 278, 'user login', 'loginid=Mjc4', '2022-06-03 07:54:02', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(116, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 08:13:13', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(117, 280, 'user login', 'loginid=Mjgw', '2022-06-03 08:14:39', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(118, 280, 'user logout', 'loginid=Mjgw', '2022-06-03 08:19:00', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(119, 278, 'user login', 'loginid=Mjc4', '2022-06-03 08:19:42', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(120, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 08:22:32', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(121, 277, 'user login', 'loginid=Mjc3', '2022-06-03 08:24:06', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(122, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 08:26:54', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(123, 278, 'user login', 'loginid=Mjc4', '2022-06-03 08:27:14', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(124, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 08:27:30', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(125, 276, 'user login', 'loginid=Mjc2', '2022-06-03 08:27:40', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(126, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 08:29:33', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(127, 277, 'user login', 'loginid=Mjc3', '2022-06-03 08:29:42', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(128, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 09:26:13', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(129, 282, 'user login', 'loginid=Mjgy', '2022-06-03 09:32:47', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(130, 282, 'user logout', 'loginid=Mjgy', '2022-06-03 09:38:09', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(131, 277, 'user login', 'loginid=Mjc3', '2022-06-03 09:38:25', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(132, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 10:08:34', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(133, 282, 'user login', 'loginid=Mjgy', '2022-06-03 10:08:43', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(134, 282, 'user logout', 'loginid=Mjgy', '2022-06-03 10:09:24', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(135, 277, 'user login', 'loginid=Mjc3', '2022-06-03 10:09:34', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(136, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 10:35:45', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(137, 278, 'user login', 'loginid=Mjc4', '2022-06-03 10:35:59', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(138, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 10:37:45', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(139, 276, 'user login', 'loginid=Mjc2', '2022-06-03 10:37:53', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(140, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 10:51:57', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(141, 277, 'user login', 'loginid=Mjc3', '2022-06-03 10:52:05', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(142, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 10:54:09', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(143, 278, 'user login', 'loginid=Mjc4', '2022-06-03 10:54:17', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(144, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 11:05:50', 'DESKTOP-SJ45L77', '192.168.8.101', 0, 'logout'),
(145, 277, 'user login', 'loginid=Mjc3', '2022-06-03 11:10:17', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'login'),
(146, 276, 'user login', 'loginid=Mjc2', '2022-06-19 03:39:37', 'dj', '192.168.2.104', 1, 'login'),
(147, 276, 'user logout', 'loginid=Mjc2', '2022-06-19 03:39:49', 'dj', '192.168.2.104', 0, 'logout'),
(148, 276, 'user login', 'loginid=Mjc2', '2022-06-22 12:02:47', 'dj', '192.168.8.100', 1, 'login'),
(149, 276, 'user logout', 'loginid=Mjc2', '2022-06-22 12:53:37', 'dj', '192.168.8.100', 0, 'logout'),
(150, 276, 'user login', 'loginid=Mjc2', '2022-06-22 12:57:44', 'dj', '192.168.8.100', 1, 'login'),
(151, 276, 'user login', 'loginid=Mjc2', '2022-11-12 11:12:22', 'dj', '192.168.100.3', 1, 'login'),
(152, 276, 'user logout', 'loginid=Mjc2', '2022-11-12 11:25:01', 'dj', '192.168.100.3', 0, 'logout'),
(153, 277, 'user login', 'loginid=Mjc3', '2022-11-12 11:25:19', 'dj', '192.168.100.3', 1, 'login'),
(154, 276, 'user login', 'loginid=Mjc2', '2022-11-12 11:28:34', 'dj', '192.168.100.3', 1, 'login'),
(155, 276, 'user login', 'loginid=Mjc2', '2023-06-10 12:31:14', 'dj', '192.168.2.102', 1, 'login'),
(156, 276, 'user login', 'loginid=Mjc2', '2024-02-08 01:34:59', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'login'),
(157, 283, 'user login', 'loginid=Mjgz', '2024-02-08 01:38:09', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'login'),
(158, 283, 'user logout', 'loginid=Mjgz', '2024-02-08 01:42:32', 'DESKTOP-24L4L3E', '192.168.0.105', 0, 'logout'),
(159, 276, 'user login', 'loginid=Mjc2', '2024-02-08 01:42:40', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'login'),
(160, 276, 'user logout', 'loginid=Mjc2', '2024-02-08 01:45:37', 'DESKTOP-24L4L3E', '192.168.0.105', 0, 'logout'),
(161, 283, 'user login', 'loginid=Mjgz', '2024-02-08 01:46:16', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'login'),
(162, 283, 'user logout', 'loginid=Mjgz', '2024-02-08 01:55:06', 'DESKTOP-24L4L3E', '192.168.0.105', 0, 'logout'),
(163, 277, 'user login', 'loginid=Mjc3', '2024-02-08 01:55:21', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'login'),
(164, 277, 'user logout', 'loginid=Mjc3', '2024-02-08 01:56:49', 'DESKTOP-24L4L3E', '192.168.0.105', 0, 'logout'),
(165, 276, 'user login', 'loginid=Mjc2', '2024-02-08 01:56:53', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'login'),
(166, 276, 'user logout', 'loginid=Mjc2', '2024-02-08 01:57:23', 'DESKTOP-24L4L3E', '192.168.0.105', 0, 'logout'),
(167, 277, 'user login', 'loginid=Mjc3', '2024-02-08 01:57:53', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'login'),
(168, 276, 'user login', 'loginid=Mjc2', '2024-08-11 12:44:26', 'DESKTOP-24L4L3E', '192.168.2.104', 1, 'login'),
(169, 1, 'cp admin login', NULL, '2024-08-11 12:56:18', 'DESKTOP-24L4L3E', '192.168.2.104', 1, 'login'),
(170, 276, 'user logout', 'loginid=Mjc2', '2024-08-11 01:05:28', 'DESKTOP-24L4L3E', '192.168.2.104', 0, 'logout'),
(171, 277, 'user login', 'loginid=Mjc3', '2024-08-11 01:05:47', 'DESKTOP-24L4L3E', '192.168.2.104', 1, 'login'),
(172, 277, 'user logout', 'loginid=Mjc3', '2024-08-11 01:08:53', 'DESKTOP-24L4L3E', '192.168.2.104', 0, 'logout'),
(173, 276, 'user login', 'loginid=Mjc2', '2024-08-11 01:09:12', 'DESKTOP-24L4L3E', '192.168.2.104', 1, 'login'),
(174, 276, 'user login', 'loginid=Mjc2', '2024-08-14 09:28:17', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(175, 276, 'user login', 'loginid=Mjc2', '2024-08-15 09:59:58', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(176, 276, 'user login', 'loginid=Mjc2', '2024-08-16 09:06:36', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(177, 276, 'user login', 'loginid=Mjc2', '2024-08-16 09:06:37', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(178, 276, 'user login', 'loginid=Mjc2', '2024-08-16 10:23:29', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(179, 276, 'user login', 'loginid=Mjc2', '2024-08-16 12:25:17', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(180, 276, 'user login', 'loginid=Mjc2', '2024-08-16 03:09:49', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(181, 276, 'user login', 'loginid=Mjc2', '2024-08-16 05:19:46', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(182, 276, 'user login', 'loginid=Mjc2', '2024-08-16 11:38:09', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(183, 276, 'user login', 'loginid=Mjc2', '2024-08-16 11:38:10', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(184, 276, 'user login', 'loginid=Mjc2', '2024-08-17 09:58:23', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(185, 276, 'user login', 'loginid=Mjc2', '2024-08-17 05:10:33', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(186, 284, 'user login', 'loginid=Mjg0', '2024-08-17 05:44:17', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(187, 284, 'user login', 'loginid=Mjg0', '2024-08-17 05:48:33', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(188, 284, 'user login', 'loginid=Mjg0', '2024-08-17 06:14:25', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(189, 276, 'user login', 'loginid=Mjc2', '2024-08-17 06:17:47', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(190, 276, 'user login', 'loginid=Mjc2', '2024-08-17 09:12:00', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(191, 276, 'user login', 'loginid=Mjc2', '2024-08-18 12:31:08', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(192, 276, 'user login', 'loginid=Mjc2', '2024-08-18 02:43:00', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(193, 276, 'user login', 'loginid=Mjc2', '2024-08-18 10:09:58', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(194, 276, 'user login', 'loginid=Mjc2', '2024-08-20 09:21:58', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(195, 276, 'user login', 'loginid=Mjc2', '2024-08-25 01:43:03', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(196, 276, 'user login', 'loginid=Mjc2', '2024-08-25 07:15:46', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(197, 276, 'user login', 'loginid=Mjc2', '2024-08-26 04:16:07', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(198, 276, 'user login', 'loginid=Mjc2', '2024-08-26 04:25:01', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(199, 276, 'user login', 'loginid=Mjc2', '2024-08-27 10:31:07', 'd2.my-control-panel.com', '192.168.168.2', 1, 'login'),
(200, 276, 'user login', 'loginid=Mjc2', '2024-08-27 11:46:53', 'Kashan', '192.168.14.104', 1, 'login'),
(201, 276, 'user logout', 'loginid=Mjc2', '2024-08-27 04:27:20', 'Kashan', '192.168.14.104', 0, 'logout'),
(202, 284, 'user login', 'loginid=Mjg0', '2024-08-27 04:27:36', 'Kashan', '192.168.14.104', 1, 'login'),
(203, 284, 'user logout', 'loginid=Mjg0', '2024-08-27 04:27:52', 'Kashan', '192.168.14.104', 0, 'logout'),
(204, 277, 'user login', 'loginid=Mjc3', '2024-08-27 04:28:02', 'Kashan', '192.168.14.104', 1, 'login'),
(205, 277, 'user logout', 'loginid=Mjc3', '2024-08-27 04:30:37', 'Kashan', '192.168.14.104', 0, 'logout'),
(206, 276, 'user login', 'loginid=Mjc2', '2024-08-27 04:30:52', 'Kashan', '192.168.14.104', 1, 'login'),
(207, 276, 'user logout', 'loginid=Mjc2', '2024-08-27 04:44:08', 'Kashan', '192.168.14.104', 0, 'logout'),
(208, 276, 'user login', 'loginid=Mjc2', '2024-08-27 04:44:39', 'Kashan', '192.168.14.104', 1, 'login'),
(209, 277, 'user login', 'loginid=Mjc3', '2024-08-27 04:44:59', 'Kashan', '192.168.14.104', 1, 'login'),
(210, 276, 'user login', 'loginid=Mjc2', '2024-08-28 11:54:03', 'Kashan', '192.168.47.62', 1, 'login'),
(211, 277, 'user login', 'loginid=Mjc3', '2024-08-28 02:28:09', 'Kashan', '192.168.14.104', 1, 'login'),
(212, 1, 'cp admin login', NULL, '2024-08-28 04:50:29', 'Kashan', '192.168.14.104', 1, 'login'),
(213, 1, 'cp admin login', NULL, '2024-08-29 11:07:33', 'Kashan', '192.168.10.184', 1, 'login'),
(214, 276, 'user login', 'loginid=Mjc2', '2024-08-29 12:06:42', 'Kashan', '192.168.10.184', 1, 'login'),
(215, 1, 'cp admin login', NULL, '2024-08-30 10:36:34', 'Kashan', '192.168.2.124', 1, 'login'),
(216, 276, 'user login', 'loginid=Mjc2', '2024-08-30 10:38:35', 'Kashan', '192.168.2.124', 1, 'login'),
(217, 1, 'cp admin login', NULL, '2024-09-19 07:40:09', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'login'),
(218, 1, 'cp admin login', NULL, '2024-09-19 08:15:49', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'login'),
(219, 1, 'cp admin login', NULL, '2024-09-19 08:24:53', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'login'),
(220, 1, 'cp admin logout', NULL, '2024-09-19 08:25:00', 'DESKTOP-PPKUPOE', '192.168.100.27', 0, 'logout'),
(221, 1, 'cp admin login', NULL, '2024-09-19 08:25:04', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'login'),
(222, 1, 'cp admin logout', NULL, '2024-09-19 08:25:17', 'DESKTOP-PPKUPOE', '192.168.100.27', 0, 'logout'),
(223, 1, 'cp admin login', NULL, '2024-09-19 08:25:20', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'login'),
(224, 1, 'cp admin logout', NULL, '2024-09-19 09:26:20', 'DESKTOP-PPKUPOE', '192.168.100.27', 0, 'logout'),
(225, 1, 'cp admin login', NULL, '2024-09-19 09:26:24', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'login');

-- --------------------------------------------------------

--
-- Table structure for table `user_logout`
--

CREATE TABLE `user_logout` (
  `ulgid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `loginid` varchar(20) DEFAULT NULL,
  `logoutdate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `islogout` tinyint(1) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logout`
--

INSERT INTO `user_logout` (`ulgid`, `uid`, `remarks`, `loginid`, `logoutdate`, `device`, `ip`, `islogout`, `status`) VALUES
(2, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 11:28:49', 'dj', '192.168.8.102', 1, 'logout'),
(3, 277, 'user logout', 'loginid=Mjc3', '2022-06-01 11:31:05', 'dj', '192.168.8.102', 1, 'logout'),
(4, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 11:31:49', 'dj', '192.168.8.102', 1, 'logout'),
(5, 278, 'user logout', 'loginid=Mjc4', '2022-06-01 12:09:00', 'dj', '192.168.8.102', 1, 'logout'),
(6, 1, 'cp admin logout', NULL, '2022-06-01 12:17:15', 'dj', '192.168.8.102', 1, 'logout'),
(7, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 12:39:31', 'dj', '192.168.8.102', 1, 'logout'),
(8, 277, 'user logout', 'loginid=Mjc3', '2022-06-01 12:44:09', 'dj', '192.168.8.102', 1, 'logout'),
(9, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 12:53:13', 'dj', '192.168.8.102', 1, 'logout'),
(10, 277, 'user logout', 'loginid=Mjc3', '2022-06-01 12:54:39', 'dj', '192.168.8.102', 1, 'logout'),
(11, 278, 'user logout', 'loginid=Mjc4', '2022-06-01 12:56:06', 'dj', '192.168.8.102', 1, 'logout'),
(12, 277, 'user logout', 'loginid=Mjc3', '2022-06-01 12:57:23', 'dj', '192.168.8.102', 1, 'logout'),
(13, 276, 'user logout', 'loginid=Mjc2', '2022-06-01 12:59:53', 'dj', '192.168.8.102', 1, 'logout'),
(14, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 12:03:07', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(15, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 12:03:21', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(16, 277, 'user logout', 'loginid=Mjc3', '2022-06-02 12:03:40', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(17, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 01:32:45', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(18, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 08:20:40', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(19, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 08:28:18', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(20, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 08:35:32', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(21, 276, 'user logout', 'loginid=Mjc2', '2022-06-02 08:35:53', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(22, 1, 'cp admin logout', NULL, '2022-06-02 08:49:43', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(23, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 12:35:25', 'DESKTOP-SJ45L77', '192.168.88.10', 1, 'logout'),
(24, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 01:14:23', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(25, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 01:21:00', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(26, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 01:39:46', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(27, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 01:41:01', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(28, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 01:42:02', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(29, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 01:42:50', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(30, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 03:20:26', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(31, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 03:20:57', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(32, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 03:24:00', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(33, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 09:29:27', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(34, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 02:56:47', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(35, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 02:58:14', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(36, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 03:06:27', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(37, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 03:07:49', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(38, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 03:11:55', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(39, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 03:35:15', 'host.sofxol.com', '104.193.108.203', 1, 'logout'),
(40, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 06:23:13', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(41, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 06:36:39', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(42, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 06:47:12', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(43, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 07:03:42', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(44, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 07:04:04', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(45, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 07:38:06', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(47, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 07:47:16', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(49, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 07:49:56', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(50, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 07:53:52', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(51, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 08:13:13', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(52, 280, 'user logout', 'loginid=Mjgw', '2022-06-03 08:19:00', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(53, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 08:22:32', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(54, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 08:26:54', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(55, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 08:27:30', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(56, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 08:29:33', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(57, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 09:26:13', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(58, 282, 'user logout', 'loginid=Mjgy', '2022-06-03 09:38:09', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(59, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 10:08:34', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(60, 282, 'user logout', 'loginid=Mjgy', '2022-06-03 10:09:24', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(61, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 10:35:45', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(62, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 10:37:45', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(63, 276, 'user logout', 'loginid=Mjc2', '2022-06-03 10:51:57', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(64, 277, 'user logout', 'loginid=Mjc3', '2022-06-03 10:54:09', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(65, 278, 'user logout', 'loginid=Mjc4', '2022-06-03 11:05:50', 'DESKTOP-SJ45L77', '192.168.8.101', 1, 'logout'),
(66, 276, 'user logout', 'loginid=Mjc2', '2022-06-19 03:39:49', 'dj', '192.168.2.104', 1, 'logout'),
(67, 276, 'user logout', 'loginid=Mjc2', '2022-06-22 12:53:37', 'dj', '192.168.8.100', 1, 'logout'),
(68, 276, 'user logout', 'loginid=Mjc2', '2022-11-12 11:25:01', 'dj', '192.168.100.3', 1, 'logout'),
(69, 283, 'user logout', 'loginid=Mjgz', '2024-02-08 01:42:32', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'logout'),
(70, 276, 'user logout', 'loginid=Mjc2', '2024-02-08 01:45:37', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'logout'),
(71, 283, 'user logout', 'loginid=Mjgz', '2024-02-08 01:55:06', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'logout'),
(72, 277, 'user logout', 'loginid=Mjc3', '2024-02-08 01:56:49', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'logout'),
(73, 276, 'user logout', 'loginid=Mjc2', '2024-02-08 01:57:23', 'DESKTOP-24L4L3E', '192.168.0.105', 1, 'logout'),
(74, 276, 'user logout', 'loginid=Mjc2', '2024-08-11 01:05:28', 'DESKTOP-24L4L3E', '192.168.2.104', 1, 'logout'),
(75, 277, 'user logout', 'loginid=Mjc3', '2024-08-11 01:08:53', 'DESKTOP-24L4L3E', '192.168.2.104', 1, 'logout'),
(76, 276, 'user logout', 'loginid=Mjc2', '2024-08-27 04:27:20', 'Kashan', '192.168.14.104', 1, 'logout'),
(77, 284, 'user logout', 'loginid=Mjg0', '2024-08-27 04:27:52', 'Kashan', '192.168.14.104', 1, 'logout'),
(78, 277, 'user logout', 'loginid=Mjc3', '2024-08-27 04:30:37', 'Kashan', '192.168.14.104', 1, 'logout'),
(79, 276, 'user logout', 'loginid=Mjc2', '2024-08-27 04:44:08', 'Kashan', '192.168.14.104', 1, 'logout'),
(80, 1, 'cp admin logout', NULL, '2024-09-19 08:25:00', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'logout'),
(81, 1, 'cp admin logout', NULL, '2024-09-19 08:25:17', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'logout'),
(82, 1, 'cp admin logout', NULL, '2024-09-19 09:26:20', 'DESKTOP-PPKUPOE', '192.168.100.27', 1, 'logout');

-- --------------------------------------------------------

--
-- Table structure for table `user_signup`
--

CREATE TABLE `user_signup` (
  `usgid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `signupdate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `issignup` tinyint(1) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_signup`
--

INSERT INTO `user_signup` (`usgid`, `uid`, `remarks`, `signupdate`, `device`, `ip`, `issignup`, `status`) VALUES
(2, 276, 'user signup', '2022-06-01 11:28:27', 'dj', '192.168.8.102', NULL, 'new'),
(3, 277, 'user signup', '2022-06-01 11:30:15', 'dj', '192.168.8.102', NULL, 'new'),
(4, 278, 'user signup', '2022-06-01 11:33:58', 'dj', '192.168.8.102', NULL, 'new'),
(6, 280, 'user signup', '2022-06-03 08:14:39', 'DESKTOP-SJ45L77', '192.168.8.101', NULL, 'new'),
(7, 282, 'user signup', '2022-06-03 09:32:47', 'DESKTOP-SJ45L77', '192.168.8.101', NULL, 'new'),
(8, 283, 'user signup', '2024-02-08 01:38:09', 'DESKTOP-24L4L3E', '192.168.0.105', NULL, 'new'),
(9, 284, 'user signup', '2024-08-17 05:44:17', 'd2.my-control-panel.com', '192.168.168.2', NULL, 'new');

-- --------------------------------------------------------

--
-- Table structure for table `user_tier_level`
--

CREATE TABLE `user_tier_level` (
  `utlvid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `level` varchar(3) DEFAULT NULL,
  `tno` int(11) DEFAULT NULL,
  `lrange` varchar(50) DEFAULT NULL,
  `com` varchar(20) DEFAULT NULL,
  `pcom` double DEFAULT NULL,
  `unlockdate` datetime DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `islock` tinyint(1) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tier_level`
--

INSERT INTO `user_tier_level` (`utlvid`, `uid`, `tlvid`, `title`, `level`, `tno`, `lrange`, `com`, `pcom`, `unlockdate`, `createdate`, `islock`, `status`) VALUES
(53, 276, 1, 'Tier 1', 'LV1', 50, '$100-500', '5%', 0.1, '2022-06-01 12:18:24', '2022-06-01 09:18:23', 1, 'lock'),
(54, 276, 2, 'Tier 2', 'LV2', 55, '$500-1000', '8%', 0.14, NULL, '2022-06-01 09:18:23', 1, 'lock'),
(55, 276, 3, 'Tier 3', 'LV3', 60, '$1000-2000', '10%', 0.16, NULL, '2022-06-01 09:18:23', 1, 'lock'),
(56, 276, 4, 'Tier 4', 'LV4', 70, '$2000 or more', '12%', 0.17, NULL, '2022-06-01 09:18:23', 1, 'lock'),
(57, 277, 1, 'Tier 1', 'LV1', 50, '$100-500', '5%', 0.1, '2022-06-01 12:43:13', '2022-06-01 09:40:20', 0, 'unlock'),
(58, 277, 2, 'Tier 2', 'LV2', 55, '$500-1000', '8%', 0.14, NULL, '2022-06-01 09:40:20', 1, 'lock'),
(59, 277, 3, 'Tier 3', 'LV3', 60, '$1000-2000', '10%', 0.16, NULL, '2022-06-01 09:40:20', 1, 'lock'),
(60, 277, 4, 'Tier 4', 'LV4', 70, '$2000 or more', '12%', 0.17, NULL, '2022-06-01 09:40:20', 1, 'lock'),
(61, 278, 1, 'Tier 1', 'LV1', 50, '$100-500', '5%', 0.1, '2022-06-01 12:55:49', '2022-06-01 09:55:49', 0, 'unlock'),
(62, 278, 2, 'Tier 2', 'LV2', 55, '$500-1000', '8%', 0.14, NULL, '2022-06-01 09:55:49', 1, 'lock'),
(63, 278, 3, 'Tier 3', 'LV3', 60, '$1000-2000', '10%', 0.16, NULL, '2022-06-01 09:55:49', 1, 'lock'),
(64, 278, 4, 'Tier 4', 'LV4', 70, '$2000 or more', '12%', 0.17, NULL, '2022-06-01 09:55:49', 1, 'lock'),
(97, 280, 1, 'Tier 1', 'LV1', 50, '$100-500', '5%', 0.1, '2022-06-03 20:18:40', '2022-06-03 05:18:40', 0, 'unlock'),
(98, 280, 2, 'Tier 2', 'LV2', 55, '$500-1000', '8%', 0.14, NULL, '2022-06-03 05:18:40', 1, 'lock'),
(99, 280, 3, 'Tier 3', 'LV3', 60, '$1000-2000', '10%', 0.16, NULL, '2022-06-03 05:18:40', 1, 'lock'),
(100, 280, 4, 'Tier 4', 'LV4', 70, '$2000 or more', '12%', 0.17, NULL, '2022-06-03 05:18:40', 1, 'lock'),
(101, 283, 1, 'Tier 1', 'LV1', 50, '$100-500', '5%', 0.1, NULL, '2024-02-07 09:38:28', 1, 'lock'),
(102, 283, 2, 'Tier 2', 'LV2', 55, '$500-1000', '8%', 0.14, NULL, '2024-02-07 09:38:28', 1, 'lock'),
(103, 283, 3, 'Tier 3', 'LV3', 60, '$1000-2000', '10%', 0.16, NULL, '2024-02-07 09:38:28', 1, 'lock'),
(104, 283, 4, 'Tier 4', 'LV4', 70, '$2000 or more', '12%', 0.17, NULL, '2024-02-07 09:38:28', 1, 'lock');

-- --------------------------------------------------------

--
-- Table structure for table `user_verification`
--

CREATE TABLE `user_verification` (
  `vid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `cpid` int(11) DEFAULT NULL,
  `vcid` int(11) DEFAULT NULL,
  `verificationdate` datetime DEFAULT NULL,
  `isverified` tinyint(1) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_verification`
--

INSERT INTO `user_verification` (`vid`, `uid`, `cpid`, `vcid`, `verificationdate`, `isverified`, `status`) VALUES
(2, 276, 26, 26, '2022-06-01 11:28:27', 1, 'verified'),
(3, 277, 27, 27, '2022-06-01 11:30:15', 1, 'verified'),
(4, 278, 28, 28, '2022-06-01 11:33:58', 1, 'verified'),
(6, 280, 30, 30, '2022-06-03 08:14:39', 1, 'verified'),
(7, 282, 31, 31, '2022-06-03 09:32:47', 1, 'verified'),
(8, 283, 32, 32, '2024-02-08 01:38:09', 1, 'verified'),
(9, 284, 33, 33, '2024-08-17 05:44:17', 1, 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `verification_code`
--

CREATE TABLE `verification_code` (
  `vcid` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `vfcode` varchar(4) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verification_code`
--

INSERT INTO `verification_code` (`vcid`, `uid`, `vfcode`, `createdate`) VALUES
(26, 276, '7915', '2022-06-01 11:28:27'),
(27, 277, '2271', '2022-06-01 11:30:15'),
(28, 278, '6046', '2022-06-01 11:33:58'),
(30, 280, '1225', '2022-06-03 08:14:39'),
(31, 282, '9599', '2022-06-03 09:32:47'),
(32, 283, '5148', '2024-02-08 01:38:09'),
(33, 284, '0523', '2024-08-17 05:44:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `captcha_code`
--
ALTER TABLE `captcha_code`
  ADD PRIMARY KEY (`cpid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`ntfid`);

--
-- Indexes for table `password_history`
--
ALTER TABLE `password_history`
  ADD PRIMARY KEY (`phid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `tier_level`
--
ALTER TABLE `tier_level`
  ADD PRIMARY KEY (`tlvid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `roleid` (`roleid`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`acid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user_company`
--
ALTER TABLE `user_company`
  ADD PRIMARY KEY (`ucid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`ulid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user_logout`
--
ALTER TABLE `user_logout`
  ADD PRIMARY KEY (`ulgid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user_signup`
--
ALTER TABLE `user_signup`
  ADD PRIMARY KEY (`usgid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user_tier_level`
--
ALTER TABLE `user_tier_level`
  ADD PRIMARY KEY (`utlvid`),
  ADD KEY `tlvid` (`tlvid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user_verification`
--
ALTER TABLE `user_verification`
  ADD PRIMARY KEY (`vid`),
  ADD KEY `vfcid` (`vcid`),
  ADD KEY `cpid` (`cpid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `verification_code`
--
ALTER TABLE `verification_code`
  ADD PRIMARY KEY (`vcid`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `captcha_code`
--
ALTER TABLE `captcha_code`
  MODIFY `cpid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `ntfid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `password_history`
--
ALTER TABLE `password_history`
  MODIFY `phid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tier_level`
--
ALTER TABLE `tier_level`
  MODIFY `tlvid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `acid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;

--
-- AUTO_INCREMENT for table `user_company`
--
ALTER TABLE `user_company`
  MODIFY `ucid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `ulid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `user_logout`
--
ALTER TABLE `user_logout`
  MODIFY `ulgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `user_signup`
--
ALTER TABLE `user_signup`
  MODIFY `usgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_tier_level`
--
ALTER TABLE `user_tier_level`
  MODIFY `utlvid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `user_verification`
--
ALTER TABLE `user_verification`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `verification_code`
--
ALTER TABLE `verification_code`
  MODIFY `vcid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `captcha_code`
--
ALTER TABLE `captcha_code`
  ADD CONSTRAINT `captcha_code_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `captcha_code_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `password_history`
--
ALTER TABLE `password_history`
  ADD CONSTRAINT `password_history_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`);

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `user_company_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `user_company_ibfk_3` FOREIGN KEY (`cid`) REFERENCES `company` (`cid`);

--
-- Constraints for table `user_login`
--
ALTER TABLE `user_login`
  ADD CONSTRAINT `user_login_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `user_login_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `user_logout`
--
ALTER TABLE `user_logout`
  ADD CONSTRAINT `user_logout_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `user_logout_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `user_signup`
--
ALTER TABLE `user_signup`
  ADD CONSTRAINT `user_signup_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `user_signup_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `user_tier_level`
--
ALTER TABLE `user_tier_level`
  ADD CONSTRAINT `user_tier_level_ibfk_2` FOREIGN KEY (`tlvid`) REFERENCES `tier_level` (`tlvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_tier_level_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_verification`
--
ALTER TABLE `user_verification`
  ADD CONSTRAINT `user_verification_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `user_verification_ibfk_2` FOREIGN KEY (`vcid`) REFERENCES `verification_code` (`vcid`),
  ADD CONSTRAINT `user_verification_ibfk_3` FOREIGN KEY (`cpid`) REFERENCES `captcha_code` (`cpid`),
  ADD CONSTRAINT `user_verification_ibfk_4` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `verification_code`
--
ALTER TABLE `verification_code`
  ADD CONSTRAINT `verification_code_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `verification_code_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
