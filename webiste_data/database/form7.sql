-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 17, 2024 at 10:22 AM
-- Server version: 10.6.19-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qurascxb_seo`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl`
--

CREATE TABLE `tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `webur` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `sel` varchar(50) NOT NULL,
  `msg` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl`
--

INSERT INTO `tbl` (`id`, `name`, `webur`, `email`, `phone`, `sel`, `msg`, `date`) VALUES
(1, 'Moiz Ahmed', '', 'moizsheikh646@gmail.com', '3213239633', '', '', '2024-05-10 03:05:05'),
(2, 'Moiz Ahmed', 'google.com', 'moizsheikh646@gmail.com', '3213239633', '', '', '2024-05-10 03:08:11'),
(3, 'Moiz Ahmed', 'google.com', 'moizsheikh646@gmail.com', '3213239633', '£1,001-£2,000', 'some text', '2024-05-10 03:11:12'),
(4, 'Moiz Ahmed', 'google.com', 'moizsheikh646@gmail.com', '3213239633', '£3,001-£4,000', 'some text', '2024-05-10 03:13:01'),
(5, 'kashan', 'abc.com', 'abc@yahoo.com', '3213239633', '£1,001-£2,000', 'some text', '2024-05-10 03:25:49'),
(6, 'Muhammad Hassaan Raza', 'quranteacher.us', 'teacherquran02@gmail.com', '7868693680', '£300-£499', 'I want to buy your services.', '2024-05-10 11:51:15'),
(7, 'contact', 'quranclasses.uk', 'teacherquran02@gmail.com', '7868693680', '£2,001-£3,000', 'I want to buy your services cotact.php', '2024-05-10 11:52:39'),
(8, 'Muhammad Hassaan Raza', 'quranteacher.us', 'teacherquran02@gmail.com', '7868693680', '£4,001-£5,000', 'London', '2024-05-10 11:55:56'),
(9, 'Moiz Ahmed', '', 'moizsheikh646@gmail.com', '3213239633', '£3,001-£4,000', 'Checked thank you page', '2024-05-11 03:07:35'),
(10, 'Moiz Ahmed', 'google.com', 'moizsheikh646@gmail.com', '3213239633', '£2,001-£3,000', 'some text', '2024-05-11 03:14:41'),
(11, 'Muhammad Hassaan Raza', 'quranteacher.us', 'teacherquran02@gmail.com', '7868693680', '£3,001-£4,000', 'London page', '2024-05-11 03:17:59'),
(12, 'Joseph Brown', 'https://primeseolead.online/', 'Joseph.browntech@gmail.com', '9654426180', '£1,001-£2,000', '\"Hello SEO experts,\r\n\r\nWe have provision to generate high quality\r\nSEO,PPC and Web design leads and ', '2024-07-04 06:57:38'),
(13, 'Raul Smith', 'https://bankllist.us', 'raul.smith@bankllist.us', '2013445788', '£2,001-£3,000', 'I have a reputed personal finance website, I run advertisements on it. The issue is whenever somebod', '2024-08-15 07:07:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl`
--
ALTER TABLE `tbl`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl`
--
ALTER TABLE `tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
