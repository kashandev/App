-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 17, 2024 at 10:09 AM
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
-- Database: `qurascxb_quranteacheruk`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl`
--

CREATE TABLE `tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `msg` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl`
--

INSERT INTO `tbl` (`id`, `name`, `email`, `phone`, `country`, `msg`, `date`) VALUES
(1, 'pages', '1234567892', 'raheemsiddqui2002@gmail.com', 'pakistabn', 'adfafsd', '2023-03-22 02:56:09'),
(2, 'raheem siddiquo', '1234567892', 'raheemsiddiqui2002@gmail.com', 'pakistabn', 'fasdfa', '2023-03-22 02:58:41'),
(3, 'alabama', '1234567892', 'raheemsiddiqui2002@gmail.com', 'pakistabn', 'dfasdfas', '2023-03-22 03:08:39'),
(4, 'alabama', '1234567892', 'raheemsiddiqui2002@gmail.com', 'pakistabn', 'fafa', '2023-03-24 01:35:56'),
(5, 'Raheem Siddiqui', '0318260467', 'raheemsiddiqui2002@gmail.com', 'sdsd', 'lkj', '2023-03-24 15:42:36'),
(6, 'alabama', '1234567892', 'raheemsiddiqui2002@gmail.com', 'pakistabn', 'sdd', '2023-03-25 00:37:16'),
(7, 'Moiz Ahmed', '0321323963', 'moizsheikh646@gmail.com', 'Pakistan', 'checked', '2023-03-25 04:20:07'),
(8, 'moiz ahmed', '1234567890', 'moizsheikh646@gmail.com', 'pakistan', 'cheked', '2023-03-25 04:38:56'),
(9, 'contact.php', '3032868853', 'contact@gmail.com', 'Pakistan', 'salam checking for contact page ', '2023-03-27 06:02:25'),
(10, 'home', '3032868853', 'home.php@gmail.com', 'Pakistan', 'home page checking ', '2023-03-27 06:04:19'),
(11, 'Raheem Siddiqui', '03182604676666666666', 'raheemsiddiqui2002@gmail.com', 'sdsd', 'dsfsd', '2023-03-29 11:31:06'),
(12, 'Moiz', '03182604679', 'Moiz@gmail.com', 'sdsd', 'fadfsfa', '2023-03-29 13:52:20'),
(13, 'Raheem Siddiqui', '0318260467988', 'moizsheikh646@gmail.com', 'every', 'adf ddfdfa', '2023-03-29 14:37:10'),
(14, 'Hassaan Raza', '0303286885325255', 'Khassaan54@gmail.com', 'Pakistan', 'home pagen', '2023-03-30 06:17:40'),
(15, 'Hassaan Raza', '0303286885325252', 'Khassaan54@gmail.com', 'Pakistan', 'contact', '2023-03-30 06:18:01'),
(16, 'Hassaan Raza', '03032868853', 'Khassaan54gmail.com', 'Pakistan', 'salam', '2023-03-30 06:19:54'),
(17, 'home ', '1234563522', 'home@gmail.com', 'pakista ', 'salam home page ', '2023-03-30 13:40:46'),
(18, 'contact.php', '12345674525855888', 'contact@gmail.com', 'pakistan', 'salam contact.php ', '2023-03-30 13:41:30'),
(19, 'moiz', '12334655', 'moiz@gmail.com', 'pakistabn', 'fadsfa', '2023-03-31 00:57:13'),
(20, 'london', '1122336622552', 'london@gmail.com', 'pakistan', 'london ', '2023-03-31 06:30:00'),
(21, 'pages', '1234567892', 'moiz@gmail.com', 'pakistabn', 'fadf', '2023-04-01 02:23:27'),
(22, 'fee.html', '1234567892', 'moiz@gmail.com', 'pakistabn', 'asdfgg', '2023-04-01 02:31:52'),
(23, 'alabama', '1234567892', 'moiz@gmail.com', 'pakistabn', 'adfasd', '2023-04-01 04:31:04'),
(24, 'moiz', '03182604679', 'moizsheikh646@gmail.com', 'sdsd', 'fdsfa', '2023-04-06 14:57:04'),
(25, 'qBEqEPItLG', '85135712493', 'callvisvetlana@list.ru', '', 'ÐŸÐ¾Ð¼Ð½Ð¸ Ð¾ Ñ‚Ð¾Ð¼, Ñ‡Ñ‚Ð¾ Ñ‚Ñ‹ Ð²ÑÐµ Ð¼Ð¾Ð¶ÐµÑˆÑŒ, Ð½Ðµ Ð¾ÑÑ‚Ð°Ð½Ð°Ð²Ð»Ð¸Ð²Ð°Ð¹ÑÑ https://sen', '2023-04-11 04:32:17'),
(26, 'jtQUYlzFkq', '81931482353', 'callvisvetlana@list.ru', '', 'ÐŸÐ¾Ð¼Ð½Ð¸ Ð¾ Ñ‚Ð¾Ð¼, Ñ‡Ñ‚Ð¾ Ñ‚Ñ‹ Ð²ÑÐµ Ð¼Ð¾Ð¶ÐµÑˆÑŒ, Ð½Ðµ Ð¾ÑÑ‚Ð°Ð½Ð°Ð²Ð»Ð¸Ð²Ð°Ð¹ÑÑ https://sen', '2023-04-18 17:14:35'),
(27, 'FDxaoZwNhX', '84594388398', 'callvisvetlana@list.ru', '', 'ÐŸÐ¾Ð¼Ð½Ð¸ Ð¾ Ñ‚Ð¾Ð¼, Ñ‡Ñ‚Ð¾ Ñ‚Ñ‹ Ð²ÑÐµ Ð¼Ð¾Ð¶ÐµÑˆÑŒ, Ð½Ðµ Ð¾ÑÑ‚Ð°Ð½Ð°Ð²Ð»Ð¸Ð²Ð°Ð¹ÑÑ https://sen', '2023-04-27 19:13:11'),
(28, 'nSqoRaVUkX', '85367193124', 'callvisvetlana@list.ru', '', 'ÐŸÐ¾Ð¼Ð½Ð¸ Ð¾ Ñ‚Ð¾Ð¼, Ñ‡Ñ‚Ð¾ Ñ‚Ñ‹ Ð²ÑÐµ Ð¼Ð¾Ð¶ÐµÑˆÑŒ, Ð½Ðµ Ð¾ÑÑ‚Ð°Ð½Ð°Ð²Ð»Ð¸Ð²Ð°Ð¹ÑÑ https://sen', '2023-05-01 20:44:42'),
(29, 'cDYFBLWgBh', '85928267429', 'callvisvetlana@list.ru', '', 'ÐŸÐ¾Ð¼Ð½Ð¸ Ð¾ Ñ‚Ð¾Ð¼, Ñ‡Ñ‚Ð¾ Ñ‚Ñ‹ Ð²ÑÐµ Ð¼Ð¾Ð¶ÐµÑˆÑŒ, Ð½Ðµ Ð¾ÑÑ‚Ð°Ð½Ð°Ð²Ð»Ð¸Ð²Ð°Ð¹ÑÑ https://sen', '2023-05-06 00:57:01'),
(30, 'QuitoGoduh', '87388892291', 'kk.ash.h.u.rr.l.e.y@gmail.com', 'Turkey', 'ÐšÑƒÐ¿Ð¸Ñ‚ÑŒ ÐšÑ€Ñ‹Ð¼ÑÐºÑƒÑŽ ÐºÐ¾ÑÐ¼ÐµÑ‚Ð¸ÐºÑƒ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ñƒ Ð½Ð°Ñ Ð²Ñ‹ Ð½Ð°Ð¹Ð´ÐµÑ‚Ðµ Ð±Ñ‹Ñ', '2023-05-07 11:44:53'),
(31, 'SonyaRes', '84261462351', 'woodthighgire1988@gmail.com', 'Guam', ' \r\nHere Meet my pussy here https://love2me.page.link/UkMX', '2023-05-11 10:48:43'),
(32, 'ZzyaakoviGoduh', '89139874873', 'zzaybemftKr@bobbor.store', 'Angola', 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ ÐŸÐÐ” Ñ‚Ñ€ÑƒÐ±Ñƒ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ñƒ Ð½Ð°Ñ Ð²Ñ‹ Ð½Ð°Ð¹Ð´ÐµÑ‚Ðµ Ð±Ñ‹ÑÑ‚Ñ€ÑƒÑŽ Ð´Ð¾Ñ', '2023-06-01 18:01:51'),
(33, 'KyancGoduh', '84724756251', 'ndkdiquriKr@bobbor.store', 'Malaysia', 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð´ÐµÑ‚ÑÐºÑƒÑŽ Ð¾Ð´ÐµÐ¶Ð´Ñƒ Ð¾Ð¿Ñ‚Ð¾Ð¼ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð² Ð½Ð°ÑˆÐµÐ¼ Ð¸Ð½Ñ‚ÐµÑ€Ð½ÐµÑ', '2023-06-11 13:17:22'),
(34, 'NteGoduh', '86692179746', 'eksfduqmyKr@bobbor.store', 'Hungary', 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ ÑÑ‚Ð¾Ð¼Ð°Ñ‚Ð¾Ð»Ð¾Ð³Ð¸Ñ‡ÐµÑÐºÑƒÑŽ Ñ‚ÐµÑ…Ð½Ð¸ÐºÑƒ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð² Ð½Ð°ÑˆÐµÐ¼ Ð¼Ð°', '2023-06-13 22:11:04'),
(35, 'Bradleymew', '82924388127', 'udemin101@gmail.com', 'Greenland', 'ÐÐ° ÑÐµÐ³Ð¾Ð´Ð½Ñ ÑÑƒÑ‰ÐµÑÑ‚Ð²ÑƒÑŽÑ‚: \r\n- Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð½Ñ‹Ðµ ÑƒÑÑ‚Ñ€Ð¾Ð¹ÑÑ‚Ð²Ð° Ð² Ð¾ÑÐ', '2023-07-01 05:25:35'),
(36, 'AndrewLouth', '81952463388', 'iunskiygipertonik@gmail.com', 'United States', 'Piroxicam buy, discount! without prescription. \r\nAcarbose buy, discount! without prescription. \r\nRop', '2023-07-10 04:30:45'),
(37, 'TiceGoduh', '84253529284', 'pgfxsjcieKr@bobbor.store', 'Gibraltar', 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð¾Ð´ÐµÐ¶Ð´Ñƒ Ð´Ð»Ñ Ð´ÐµÑ‚ÐµÐ¹ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð² Ð½Ð°ÑˆÐµÐ¼ Ð¸Ð½Ñ‚ÐµÑ€Ð½ÐµÑ‚-Ð¼Ð°Ð³', '2023-07-10 11:23:27'),
(38, 'JessicaThedo', '87861443588', 'artemsaed73@gmail.com', 'Belarus', 'Online Quran teacher in UK \r\n \r\nÐŸÑ€Ð¸Ð²ÐµÑ‚.  ÐžÑ‡ÐµÐ½ÑŒ Ð¸Ð½Ñ‚ÐµÑ€ÐµÑÐ½Ð¾, Ð½Ð¾: \r\nAdmin, Ð¿Ñ€Ð¾Ñ', '2023-07-30 07:30:32'),
(39, 'TonalGoduh', '83415816988', 'fhzcxdqrwKr@bobbor.store', 'Nigeria', 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ ÑŽÐ²ÐµÐ»Ð¸Ñ€Ð½Ñ‹Ðµ ÑƒÐºÑ€Ð°ÑˆÐµÐ½Ð¸Ñ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð² Ð½Ð°ÑˆÐµÐ¼ ÑÐ°Ð»Ð¾Ð½Ðµ Ð²Ñ', '2023-08-08 18:10:38'),
(40, 'ZitalaGoduh', '87252874449', 'ycqvhphmrKr@bobbor.store', 'Portugal', 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð¼ÐµÑ‚Ð°Ð»Ð»Ð¾Ñ‡ÐµÑ€ÐµÐ¿Ð¸Ñ†Ñƒ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð² Ð½Ð°ÑˆÐµÐ¼ Ð¼Ð°Ð³Ð°Ð·Ð¸Ð½Ðµ Ð²Ñ‹ Ð', '2023-09-01 06:16:45'),
(41, 'XonardeneGoduh', '87787293978', 'szjswlugbKr@bobbor.store', 'Paraguay', 'ÐšÑƒÐ¿Ð¸Ñ‚ÑŒ ÑÐ¿Ð¾Ñ€Ñ‚Ñ‚Ð¾Ð²Ð°Ñ€Ñ‹ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð² Ð½Ð°ÑˆÐµÐ¼ Ð¼Ð°Ð³Ð°Ð·Ð¸Ð½Ðµ Ð²Ñ‹ Ð½Ð°Ð¹Ð´ÐµÑ‚Ð', '2023-09-17 04:12:19'),
(42, 'DellysaGoduh', '83195716738', 'qpuccalqiKr@bobbor.store', 'Denmark', 'ÐšÑƒÐ¿Ð¸Ñ‚ÑŒ ÑÐ¿Ð¾Ñ€Ñ‚Ð¸Ð½Ð²ÐµÐ½Ñ‚Ð°Ñ€ÑŒ - Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð² Ð½Ð°ÑˆÐµÐ¼ Ð¼Ð°Ð³Ð°Ð·Ð¸Ð½Ðµ Ð²Ñ‹ Ð½Ð°Ð¹Ð', '2023-09-27 14:06:04'),
(43, 'RotabandPed', '88424821978', 'dimaneo2023@gmail.com', 'Ð‘ÐµÐ»Ð°Ñ€ÑƒÑÑŒ', 'Ð­Ñ‚Ð¾Ñ‚ ÑÑ‚Ñ€Ð¾Ð¹Ð¼Ð°Ñ‚ÐµÑ€Ð¸Ð°Ð» Ð»ÐµÐ³ÐºÐ¾ Ñ‚Ñ€Ð°Ð½ÑÐ¿Ð¾Ñ€Ñ‚Ð¸Ñ€ÑƒÐµÑ‚ÑÑ Ð² Ð³ÐµÑ€Ð¼ÐµÑ‚Ð¸Ñ‡Ð', '2023-10-02 04:13:45'),
(44, 'James Ransom', '6256315083', 'dennis.ransom61@hotmail.com', 'Great Britain', 'Hi there,\r\nMonthly Seo Services - Professional/ Affordable Seo Services\r\nHire the leading seo market', '2023-10-06 03:02:03'),
(45, 'EddieJurgy', '85129655363', 'baidenpsih@rambler.ru', 'Ethiopia', ' \r\nAdmin Excellent post, very informative. \r\nÐšÑ€Ð°ÐºÐµÐ½ - Ð¾Ñ„Ð¸Ñ†Ð¸Ð°Ð»ÑŒÐ½Ñ‹Ð¹ ÑÐ°Ð¹Ñ‚ ÑÐ°Ð¼Ð¾', '2023-10-06 13:01:36'),
(46, 'WalterKah', '82149216122', 'yasen.krasen.13+97439@mail.ru', 'France', 'Nguheidjiwfefhei ijiwdwjurFEJDKWIJFEIF Ð°Ð¾ÑƒÑˆÐ²Ñ†ÑˆÑƒÑ€Ð³Ð°Ñ€ÑƒÑˆ Ð¨ÐžÐ Ð“ÐŸÐ“ÐžÐ¨Ð Ð“Ð ÐŸÐ“ÐžÐ“Ð ', '2023-10-26 21:45:37'),
(47, 'WalterAtmob', '86198585181', 'kikaytandy@gmail.com', 'United States', 'Guaranteed income from email newsletters over $30,000 per month http://marketing-46216234.propertyyb', '2023-10-30 08:33:18'),
(48, 'RussellNaW', '87399438959', 'dthomas@yahoo.com.au', 'New Zealand', 'Achieve Financial Success with Earnings from $30,000 Per Day http://marketing-10225293.yowatashiworl', '2023-11-02 00:24:04'),
(49, 'DonaldGunty', '86263813659', 'janeven.longva@gmail.com', 'Denmark', 'YOU EARNED $45,412.94. WITHDRAW MONEY URGENTLY http://cashwave-705638.bnblaunch.com/office', '2023-11-05 05:39:08'),
(50, 'PeterDiulk', '82589524611', 'r.molenroper07@gmail.com', 'United Kingdom', 'IMPORTANT MESSAGE! Your earnings were $45,639.73. You need to withdraw your earnings within 24 hours', '2023-11-07 02:29:20'),
(51, 'KendallIodiz', '89695877649', 'jarediwinski93@outlook.com', 'United Kingdom', 'The $100,000 Elevator: Rise to Wealthy Heights with Passive Income https://www.google.com.bn/pagead/', '2023-11-10 03:22:04'),
(52, 'James Frizzell', '7129309423', 'ronald.frizzell6@gmail.com', 'Iceland', 'Hi there!\r\nTop Rated SEO Agency. Personalized Service from Dedicated Account Team. ROI Driven. Relat', '2023-11-10 12:31:59'),
(53, 'Marlongew', '84999981367', 'janie@janiehughes.wanadoo.co.uk', 'Spain', 'Prosperity Awaits: The Profitable Mining Pool Advantage http://best-mining-pool.learntechnology.xyz/', '2023-11-22 05:55:53'),
(54, 'WilmerKag', '85754882462', 'brianbell83@gmail.com', 'Sweden', 'Investing for Everyone: Earnings from $9000 per Day Simplified https://marketplacebest888.sell.app/p', '2023-11-23 04:17:01'),
(55, 'Jamesdoppy', '87267539351', 'jordance2k6@icloud.com', 'United Kingdom', 'MEET A BEAUTIFUL GIRL FOR SEX RIGHT NOW http://sex-online-6843.situs-mega4d.com/online-425', '2023-11-23 21:52:18'),
(56, 'Jimmy Hamm', '9530747222', 'hamm.christopher@googlemail.com', 'Netherlands', 'Advantages of hiring a Developer:\r\n\r\nSpecialized Expertise\r\nTailored Customization and Control\r\nTime', '2023-12-08 09:34:16'),
(57, 'RamonBag', '86714573994', 'alecjohnson1010@yahoo.com', 'Australia', 'THE $3 PER MINUTE BLUEPRINT: AUTOPILOT INCOME FOR A BRIGHTER FUTURE https://vae.me/J7N1?2723 \r\n \r\n \r', '2023-12-15 04:04:47'),
(58, 'SupportBtcMomte', '83573181156', 'akarak843@gmail.com', 'Burkina Faso', 'From the time of registration 364 days ago, your devices were connected to the platform through IP a', '2023-12-18 00:15:16'),
(59, 'Ishaan Sharma', '1234567890', 'ishaandeveloper.web@gmail.com', 'USA', 'Hi team onlinequranteacher.uk,\r\n\r\nI am SEO/Digital Marketing Consultant and I work with 30+experienc', '2023-12-21 07:00:15'),
(60, 'Lucy Johnson', '1234567890', 'lucyjohnson.web@gmail.com', 'USA', 'Hello,\r\n\r\nI trust this message finds you well!\r\n\r\nWould you be interested in Design or Re-design you', '2023-12-24 02:58:42'),
(61, 'Petermat', '86583223923', 'letihle_bianchi@hotmail.com', 'Singapore', 'BEAUTIFUL WOMEN LOOKING FOR QUICK SEX ONLY ON THIS SITE https://allfamous.org/go?u=https%3A%2F%2Fvk.', '2023-12-24 06:26:03'),
(62, 'JamesCIc', '82227889714', 'liam.charles1996@gmail.com', 'Czech Republic', 'UNLEASHING THE POWER OF PASSIVE INCOME: MINING YOUR WAY TO $50,000 ANNUALLY http://www.thoitiet.net/', '2023-12-25 03:52:44'),
(63, 'Vevor', '80098656777', 'vevor@hotmail.com', 'Russia', 'https://bit.ly/3NvpST9 VEVOR, as a leading and emerging company in the manufacturer and exporting bu', '2023-12-28 12:51:01'),
(64, 'BitcoinSystem', '8008943572529', 'bitcoinsystem@hotmail.com', 'Russia', 'http://go.vemaqaov.com/0m3k Het enige wat u hoeft te doen is uw software nu GRATIS aan te schaffen.', '2023-12-29 17:02:25'),
(65, 'SupportBtcMomte', '86742677759', 'jonassaintg@gmail.com', 'Burkina Faso', 'During this one-year period, you have been enrolled our automatic cloud Bitcoin mining.  \r\n \r\n While', '2023-12-30 01:51:09'),
(66, 'BestFarmLouth', '81875316552', 'iunskiygipertonik@gmail.com', 'United States', 'TruePills, No prescription needed, Buy pills without restrictions. Money Back Guaranteed 30-day refu', '2023-12-31 01:00:37'),
(67, 'Hassaan Raza', '03032868853', 'Khassaan54@gmail.com', 'Pakistan', 'sasasas', '2024-01-04 01:27:02'),
(68, 'Mickey Jenson', '4713572041', 'jenson.jovita@msn.com', 'Netherlands', '\r\nWhy choose Our ongoing monthly SEO services?\r\n\r\nSEO is a great addition to your digital marketing ', '2024-01-05 10:03:54'),
(69, 'Walterboync', '82183825664', 'seeimonfire@live.com', 'Netherlands', 'CRYPTO HYPE: A 300,000,000% SURGE ENVISAGED FOR THIS MEME TOKEN http://withdrawrocket-3447.storypixe', '2024-01-08 04:52:59'),
(70, 'David#protector3-plus[Bxydyjehuriyzeke,2,5]', '86541599789', 'protector3plus@master-vskrytiya-zamkov.store', 'Cyprus', 'Ð¿ÐµÐ¿Ñ‚Ð¸Ð´Ñ‹ protector 3 plus \r\n<a href=https://google.li/url?q=http://protector3-plus.ru>http://g', '2024-01-12 02:35:32'),
(71, 'Thomaswex', '85487381365', 'matthewallison62@gmail.com', 'Zambia', 'VERY BEAUTIFUL GIRLS WANT SEX ONLY ON THIS DATING SITE https://1borsa.com/6lqpb \r\n \r\n \r\n \r\n \r\n \r\n \r\n', '2024-01-21 22:39:03'),
(72, 'Hassaan Raza', 'Khassaan54@gmail.com', '03032868853', 'Pakistan', 'xasasa', '2024-01-24 05:13:09'),
(73, 'hassaan', 'hassaan@gmail.com', '5528282828', 'pakistan', 'sasasa', '2024-01-24 05:41:56'),
(74, 'hassaan', 'hassaan@gmail.com', '5528282828', 'pakistan', 'checking contact.php', '2024-01-24 06:00:56'),
(75, 'home page ', 'home@gmail.com', '03032868853', 'Pakistan', 'home page checking ', '2024-01-24 06:18:01'),
(76, 'contact php ', 'contack.php@gmail.com', '03032868853', 'Pakistan', 'contact php checking', '2024-01-24 06:19:45'),
(77, 'Jaimseamb', 'jab1smold@hotmail.com', '87154269374', 'Paraguay', 'Hello! We are sending you a promotional code to participate in our joint crypto traiding project \r\nW', '2024-03-01 15:00:45'),
(78, 'Robertvet', 'maski8smold@mail.com', '85893691894', 'Indonesia', 'Good afternoon! We give you a promo code - ZBXM777 \r\nActivate it in your personal account after regi', '2024-04-29 10:29:07'),
(79, 'LindaMot', 'darreldumolo5271@icloud.com', '85358994291', 'Zimbabwe', 'Discover https://Accstores.com, the ultimate destination for seamless web accessibility solutions. W', '2024-05-22 12:11:20'),
(80, 'Kak_saSr', 'huxbktozoSr@xruma.store', '83764868444', 'Russia', '??? ????????? ???? ???????? ? ???????. \r\n????????? ????????? <a href=http://smclinic.ru/>http://smcl', '2024-05-30 15:24:48'),
(81, 'Kak_cxMn', 'agbytpvemMn@xruma.com', '85543126973', 'Russia', '?????? ??????? ???????? ????????? ?? ????????. \r\n????????? ?? ????? <a href=http://plastica.onclinic', '2024-05-30 15:24:55'),
(82, 'Lechenie_vaOn', 'fqzohdridOn@rapmail.store', '82255496886', 'Russia', ' \r\n \r\n\"??? ?????????? ??????? ??????? ?? ????????\". \"??????? ??????? ? ???????? ????? ???????? ?????', '2024-07-19 05:11:09'),
(83, 'RotbanLok', 'info@fishkaremonta.ru', '86465484432', 'China', 'Hello. \r\n???? ????????????? ????? ???????????????? ? ??????????? ???????. ????? ?????????? ????? ???', '2024-08-22 05:30:45');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
