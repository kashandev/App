/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.4.27-MariaDB : Database - pressearn
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`pressearn` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `pressearn`;

/*Table structure for table `balance` */

DROP TABLE IF EXISTS `balance`;

CREATE TABLE `balance` (
  `blid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `ibalance` double DEFAULT NULL,
  `obalance` double DEFAULT NULL,
  `rbalance` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `isapprove` tinyint(1) DEFAULT 0,
  `isclose` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`blid`),
  KEY `uid` (`uid`),
  CONSTRAINT `balance_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `balance` */

/*Table structure for table `balance_history` */

DROP TABLE IF EXISTS `balance_history`;

CREATE TABLE `balance_history` (
  `bhid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `blid` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`bhid`),
  KEY `uid` (`uid`),
  KEY `blid` (`blid`),
  CONSTRAINT `balance_history_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `balance_history_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `balance_history_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `balance_history_ibfk_4` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `balance_history_ibfk_5` FOREIGN KEY (`blid`) REFERENCES `balance` (`blid`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `balance_history` */

/*Table structure for table `block_history` */

DROP TABLE IF EXISTS `block_history`;

CREATE TABLE `block_history` (
  `bhid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`bhid`),
  KEY `uid` (`uid`),
  CONSTRAINT `block_history_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `block_history` */

insert  into `block_history`(`bhid`,`uid`,`createdate`,`createby`,`device`,`ip`,`status`) values 
(1,276,'2022-06-02 07:53:53','admin','DESKTOP-SJ45L77','192.168.88.10','restore'),
(2,278,'2022-06-02 08:34:43','admin','DESKTOP-SJ45L77','192.168.88.10','restore');

/*Table structure for table `captcha_code` */

DROP TABLE IF EXISTS `captcha_code`;

CREATE TABLE `captcha_code` (
  `cpid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cpcode` varchar(6) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  PRIMARY KEY (`cpid`),
  KEY `uid` (`uid`),
  CONSTRAINT `captcha_code_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `captcha_code_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `captcha_code` */

insert  into `captcha_code`(`cpid`,`uid`,`cpcode`,`createdate`) values 
(26,276,'7915','2022-06-01 11:28:27'),
(27,277,'2271','2022-06-01 11:30:15'),
(28,278,'6046','2022-06-01 11:33:58'),
(30,280,'1225','2022-06-03 08:14:39'),
(31,282,'9599','2022-06-03 09:32:47'),
(32,283,'5148','2024-02-08 01:38:09'),
(33,284,'0523','2024-08-17 05:44:17');

/*Table structure for table `commission` */

DROP TABLE IF EXISTS `commission`;

CREATE TABLE `commission` (
  `coid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `nod` int(11) DEFAULT NULL,
  `tc` double NOT NULL,
  `pc` double DEFAULT NULL,
  `ec` double DEFAULT NULL,
  `commdate` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`coid`),
  KEY `uid` (`uid`),
  KEY `tlvid` (`tlvid`),
  CONSTRAINT `commission_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commission_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commission_ibfk_3` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `commission` */

/*Table structure for table `commission_history` */

DROP TABLE IF EXISTS `commission_history`;

CREATE TABLE `commission_history` (
  `chid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `coid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `ono` varchar(20) DEFAULT NULL,
  `nod` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `tc` double DEFAULT NULL,
  `pc` double DEFAULT NULL,
  `ec` double DEFAULT NULL,
  `createdate` date DEFAULT NULL,
  `createtime` time DEFAULT NULL,
  `canceldate` datetime DEFAULT NULL,
  `iscancel` tinyint(1) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`chid`),
  KEY `coid` (`coid`),
  KEY `oid` (`oid`),
  KEY `uid` (`uid`),
  KEY `tlvid` (`tlvid`),
  CONSTRAINT `commission_history_ibfk_1` FOREIGN KEY (`coid`) REFERENCES `commission` (`coid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commission_history_ibfk_2` FOREIGN KEY (`oid`) REFERENCES `orders` (`oid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commission_history_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `commission_history_ibfk_4` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `commission_history` */

/*Table structure for table `company` */

DROP TABLE IF EXISTS `company`;

CREATE TABLE `company` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(20) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `updateby` varchar(20) DEFAULT NULL,
  `isedit` int(11) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `company` */

insert  into `company`(`cid`,`company`,`createdate`,`updatedate`,`createby`,`updateby`,`isedit`,`isdeleted`,`status`) values 
(1,'Binance','2022-04-20 21:07:44','2022-06-02 08:55:06','admin','admin',1,0,'created'),
(14,'fdssdffd','2022-05-07 06:38:18',NULL,'admin',NULL,0,0,'created'),
(15,'fdssdffd','2022-05-07 06:46:31','2022-05-08 01:44:56','admin','admin',1,0,'created'),
(16,'fsfs','2022-05-07 06:47:51',NULL,'admin',NULL,0,0,'created'),
(17,'ghfhfjhfg','2022-05-07 06:51:07',NULL,'admin',NULL,0,0,'created'),
(18,'thththtj','2022-05-07 06:51:31',NULL,'admin',NULL,0,0,'created'),
(19,'dfsdfsf','2022-05-07 06:52:04',NULL,'admin',NULL,0,0,'created'),
(20,'bdgbdgdvbd','2022-05-07 07:15:38',NULL,'admin',NULL,0,0,'created'),
(21,'bfggd','2022-05-07 07:30:20',NULL,'admin',NULL,0,0,'created'),
(22,'bgbfbfd','2022-05-07 07:30:49',NULL,'admin',NULL,0,0,'created'),
(23,'dvdvfd','2022-05-07 07:31:32',NULL,'admin',NULL,0,0,'created'),
(24,'dfgdgdf','2022-05-07 07:43:15',NULL,'admin',NULL,0,0,'created'),
(25,'mnbnngn','2022-05-07 07:48:40',NULL,'admin',NULL,0,0,'created'),
(26,'vdvdvvv','2022-05-07 07:49:49',NULL,'admin',NULL,0,0,'created'),
(27,'jgjjhf','2022-05-07 07:52:15',NULL,'admin',NULL,0,0,'created'),
(28,'new','2022-05-07 09:32:27','2022-05-08 12:38:46','admin','admin',1,0,'created'),
(29,'bfbfbfbf','2022-05-08 12:39:05',NULL,'admin',NULL,NULL,0,'created'),
(30,'bdfgbdv','2022-05-08 12:39:38',NULL,'admin',NULL,NULL,0,'created'),
(31,'Test','2024-08-29 12:10:01','2024-08-29 12:39:06','admin','admin',1,0,'created');

/*Table structure for table `delete_history` */

DROP TABLE IF EXISTS `delete_history`;

CREATE TABLE `delete_history` (
  `dhid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`dhid`),
  KEY `uid` (`uid`),
  CONSTRAINT `delete_history_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `delete_history` */

insert  into `delete_history`(`dhid`,`uid`,`createdate`,`createby`,`device`,`ip`,`status`) values 
(1,276,'2022-06-02 07:28:13','admin','DESKTOP-SJ45L77','192.168.88.10','deleted'),
(2,276,'2022-06-02 07:31:59','admin','DESKTOP-SJ45L77','192.168.88.10','deleted'),
(3,276,'2022-06-02 07:32:16','admin','DESKTOP-SJ45L77','192.168.88.10','deleted'),
(4,276,'2022-06-02 07:56:41','admin','DESKTOP-SJ45L77','192.168.88.10','deleted'),
(5,276,'2022-06-02 08:27:15','admin','DESKTOP-SJ45L77','192.168.88.10','deleted');

/*Table structure for table `deposite` */

DROP TABLE IF EXISTS `deposite`;

CREATE TABLE `deposite` (
  `dpid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `waid` int(11) DEFAULT NULL,
  `tpmid` int(11) DEFAULT NULL,
  `refcode` varchar(20) DEFAULT NULL,
  `recvadd` text DEFAULT NULL,
  `txid` text DEFAULT NULL,
  `utxid` text DEFAULT NULL,
  `txhash` text DEFAULT NULL,
  `txcrtf` text DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `depositdate` datetime DEFAULT NULL,
  `approvedate` datetime DEFAULT NULL,
  `rejectdate` datetime DEFAULT NULL,
  `depositby` varchar(20) DEFAULT 'null',
  `rejectby` varchar(20) DEFAULT 'null',
  `approveby` varchar(20) DEFAULT 'null',
  `isnew` tinyint(1) DEFAULT 1,
  `isdeposit` tinyint(1) DEFAULT 0,
  `isapprove` tinyint(1) DEFAULT 0,
  `isreject` tinyint(1) DEFAULT 0,
  `status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`dpid`),
  KEY `uid` (`uid`),
  KEY `deposite_ibfk_3` (`tpmid`),
  KEY `deposite_ibfk_2` (`waid`),
  CONSTRAINT `deposite_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `deposite_ibfk_2` FOREIGN KEY (`waid`) REFERENCES `wallet_address` (`waid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `deposite_ibfk_3` FOREIGN KEY (`tpmid`) REFERENCES `topup_method` (`tpmid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `deposite` */

insert  into `deposite`(`dpid`,`uid`,`waid`,`tpmid`,`refcode`,`recvadd`,`txid`,`utxid`,`txhash`,`txcrtf`,`deposit`,`depositdate`,`approvedate`,`rejectdate`,`depositby`,`rejectby`,`approveby`,`isnew`,`isdeposit`,`isapprove`,`isreject`,`status`) values 
(5,276,26,1,'0Q8xKZ','TXN-8B3C9A4E-27F5-4B6D-8E6D-73192EF5B4A2','TXN-8B3C9A4E-27F5-4B6D-8E6D-73192EF5B4A2','db8e1af0cb3aca1ae2d0018624204529',NULL,'img.jpg',30,'2024-08-30 11:39:29',NULL,'2024-08-30 11:40:58','user123','admin','null',1,0,0,1,'pending');

/*Table structure for table `deposite_wallet` */

DROP TABLE IF EXISTS `deposite_wallet`;

CREATE TABLE `deposite_wallet` (
  `dpwid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `waid` int(11) DEFAULT NULL,
  `tpmid` int(11) DEFAULT NULL,
  `dpid` int(11) DEFAULT NULL,
  `deposit` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `approvedate` datetime DEFAULT NULL,
  `rejectdate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `approveby` varchar(20) DEFAULT 'null',
  `rejectby` varchar(20) DEFAULT 'null',
  `status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`dpwid`),
  KEY `uid` (`uid`),
  KEY `waid` (`waid`),
  KEY `tpmid` (`tpmid`),
  KEY `dpid` (`dpid`),
  CONSTRAINT `deposite_wallet_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `deposite_wallet_ibfk_3` FOREIGN KEY (`waid`) REFERENCES `wallet_address` (`waid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `deposite_wallet_ibfk_4` FOREIGN KEY (`tpmid`) REFERENCES `topup_method` (`tpmid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `deposite_wallet_ibfk_5` FOREIGN KEY (`dpid`) REFERENCES `deposite` (`dpid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `deposite_wallet` */

insert  into `deposite_wallet`(`dpwid`,`uid`,`waid`,`tpmid`,`dpid`,`deposit`,`createdate`,`approvedate`,`rejectdate`,`createby`,`approveby`,`rejectby`,`status`) values 
(5,276,26,1,5,30,'2024-08-30 11:39:29',NULL,NULL,'user123','null','null','pending');

/*Table structure for table `event` */

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `isexpire` tinyint(1) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `event` */

insert  into `event`(`eid`,`startdate`,`enddate`,`type`,`isexpire`,`status`) values 
(47,'2022-06-01','2022-06-03','users',1,'disabled'),
(48,'2022-06-01','2022-06-03','supporters',1,'disabled'),
(49,'2022-06-01','2022-06-03','users',1,'disabled'),
(50,'2022-06-01','2022-06-03','supporters',1,'disabled'),
(51,'2022-06-01','2022-06-03','users',1,'disabled'),
(52,'2022-06-01','2022-06-03','supporters',1,'disabled'),
(55,'2022-06-03','2022-06-05','users',1,'disabled'),
(56,'2022-06-03','2022-06-05','supporters',1,'disabled'),
(57,'2022-06-03','2022-06-05','users',1,'disabled'),
(58,'2022-06-03','2022-06-05','supporters',1,'disabled'),
(59,'2024-02-08','2024-02-10','users',1,'disabled'),
(60,'2024-02-08','2024-02-10','supporters',1,'disabled'),
(64,'2024-08-16','2024-08-16','users',1,'disabled'),
(65,'2024-08-16','2024-08-16','users',1,'disabled'),
(66,'2024-08-16','2024-08-16','users',1,'disabled'),
(67,'2024-08-16','2024-08-16','users',1,'disabled'),
(68,'2024-08-16','2024-08-16','users',1,'disabled'),
(69,'2024-08-16','2024-08-16','users',1,'disabled'),
(70,'2024-08-16','2024-08-16','users',1,'disabled'),
(71,'2024-08-17','2024-08-17','users',1,'disabled'),
(72,'2024-08-17','2024-08-19','users',1,'disabled'),
(73,'2024-08-17','2024-08-19','supporters',1,'disabled'),
(74,'2024-08-19','2024-08-19','users',1,'disabled');

/*Table structure for table `no_of_orders` */

DROP TABLE IF EXISTS `no_of_orders`;

CREATE TABLE `no_of_orders` (
  `noid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `tno` int(11) DEFAULT NULL,
  `cno` int(11) DEFAULT NULL,
  `rno` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `iscomplete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`noid`),
  KEY `tlvid` (`tlvid`),
  KEY `uid` (`uid`),
  CONSTRAINT `no_of_orders_ibfk_1` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `no_of_orders_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `no_of_orders` */

/*Table structure for table `notification` */

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `ntfid` int(11) NOT NULL AUTO_INCREMENT,
  `notification` text DEFAULT NULL,
  `createdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ntfid`)
) ENGINE=InnoDB AUTO_INCREMENT=89 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `notification` */

insert  into `notification`(`ntfid`,`notification`,`createdate`) values 
(1,'test Eevent 1','2022-05-05 18:57:03'),
(2,'test Eevent 2','2022-05-05 19:01:24'),
(3,'test message','2022-05-05 19:30:09'),
(4,'test message','2022-05-05 19:31:09'),
(5,'test message','2022-05-05 19:32:09'),
(6,'test message','2022-05-05 19:33:09'),
(7,'test message','2022-05-05 19:34:09'),
(8,'test message','2022-05-05 19:35:09'),
(9,'test message','2022-05-05 19:36:09'),
(10,'test message','2022-05-05 19:37:09'),
(11,'test message','2022-05-05 19:38:09'),
(12,'test message','2022-05-05 19:39:09'),
(13,'test message','2022-05-05 19:40:09'),
(14,'test message','2022-05-05 19:41:09'),
(15,'test message','2022-05-05 19:42:09'),
(16,'test message','2022-05-05 19:43:09'),
(17,'test message','2022-05-05 19:44:09'),
(18,'test message','2022-05-05 19:45:09'),
(19,'test message','2022-05-05 19:46:09'),
(20,'test message','2022-05-05 19:47:09'),
(21,'test message','2022-05-05 19:48:09'),
(22,'test message','2022-05-05 19:49:09'),
(23,'test message','2022-05-05 19:50:09'),
(24,'test message','2022-05-05 19:51:09'),
(25,'test message','2022-05-05 19:52:09'),
(26,'test message','2022-05-05 19:53:09'),
(27,'test message','2022-05-05 19:54:09'),
(28,'test message','2022-05-05 19:55:09'),
(29,'test message','2022-05-05 19:56:09'),
(30,'test message','2022-05-05 19:57:09'),
(31,'test message','2022-05-05 19:58:09'),
(32,'test message','2022-05-05 19:59:09'),
(33,'test message','2022-05-05 20:00:09'),
(34,'test message','2022-05-05 20:01:09'),
(35,'test message','2022-05-05 20:02:09'),
(36,'test message','2022-05-05 20:03:09'),
(37,'test message','2022-05-05 20:04:09'),
(38,'test message','2022-05-05 20:05:09'),
(39,'test message','2022-05-05 20:06:09'),
(40,'test message','2022-05-05 20:07:09'),
(41,'test message','2022-05-05 20:08:09'),
(42,'test message','2022-05-05 20:09:09'),
(43,'test message','2022-05-05 20:10:09'),
(44,'test message','2022-05-05 20:11:09'),
(45,'test message','2022-05-05 20:12:09'),
(46,'test message','2022-05-05 20:13:09'),
(47,'test message','2022-05-05 20:14:09'),
(48,'test message','2022-05-05 20:15:09'),
(49,'test message','2022-05-05 20:16:09'),
(50,'test message','2022-05-05 20:17:09'),
(51,'test message','2022-05-05 20:18:09'),
(52,'test message','2022-05-05 20:19:09'),
(53,'test message','2022-05-05 20:20:09'),
(54,'test message','2022-05-05 20:21:09'),
(55,'test message','2022-05-05 20:22:09'),
(56,'test message','2022-05-05 20:23:09'),
(57,'test message','2022-05-05 20:24:09'),
(58,'test message','2022-05-05 20:25:09'),
(59,'test message','2022-05-05 20:26:09'),
(60,'test message','2022-05-05 20:27:09'),
(61,'test message','2022-05-05 20:28:09'),
(62,'test message','2022-05-05 20:29:09'),
(63,'test message','2022-05-05 20:30:09'),
(64,'test message','2022-05-05 20:31:09'),
(65,'test message','2022-05-05 20:32:09'),
(66,'test message','2022-05-05 20:33:09'),
(67,'test message','2022-05-05 20:34:09'),
(68,'test message','2022-05-05 20:35:09'),
(69,'test message','2022-05-05 20:36:09'),
(70,'test message','2022-05-05 20:37:09'),
(71,'test message','2022-05-05 20:38:09'),
(72,'test message','2022-05-05 20:39:09'),
(73,'test message','2022-05-05 20:40:09'),
(74,'test message','2022-05-05 20:41:09'),
(75,'test message','2022-05-05 20:42:09'),
(76,'test message','2022-05-05 20:43:09'),
(77,'test message','2022-05-05 20:44:09'),
(78,'test message','2022-05-05 20:45:09'),
(79,'test message','2022-05-05 20:46:09'),
(80,'test message','2022-05-05 20:47:09'),
(81,'test message','2022-05-05 20:48:09'),
(82,'test message','2022-05-05 20:49:09'),
(83,'test message','2022-05-05 20:50:09'),
(84,'test message','2022-05-05 20:51:09'),
(85,'test message','2022-05-05 20:52:09'),
(86,'test message','2022-05-05 20:53:09'),
(87,'test message','2022-05-05 20:54:09'),
(88,'test message','2022-05-05 20:55:09');

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `ono` varchar(20) DEFAULT NULL,
  `nod` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `orderdate` date DEFAULT NULL,
  `completedate` datetime DEFAULT NULL,
  `canceldate` datetime DEFAULT NULL,
  `ordertime` time DEFAULT NULL,
  `iscomplete` tinyint(1) DEFAULT NULL,
  `iscancel` tinyint(1) DEFAULT NULL,
  `isclose` tinyint(1) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`oid`),
  KEY `tlvid` (`tlvid`),
  KEY `uid` (`uid`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_ibfk_6` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orders` */

/*Table structure for table `orders_history` */

DROP TABLE IF EXISTS `orders_history`;

CREATE TABLE `orders_history` (
  `ohid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`ohid`),
  KEY `uid` (`uid`),
  KEY `tlvid` (`tlvid`),
  KEY `oid` (`oid`),
  CONSTRAINT `orders_history_ibfk_1` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_history_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_history_ibfk_3` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_history_ibfk_4` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_history_ibfk_5` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `orders_history_ibfk_6` FOREIGN KEY (`oid`) REFERENCES `orders` (`oid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `orders_history` */

/*Table structure for table `password_history` */

DROP TABLE IF EXISTS `password_history`;

CREATE TABLE `password_history` (
  `phid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`phid`),
  KEY `uid` (`uid`),
  CONSTRAINT `password_history_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `password_history` */

insert  into `password_history`(`phid`,`uid`,`type`,`password`,`createdate`,`createby`,`status`,`remarks`) values 
(3,276,'login','user123','2022-06-01 11:28:27','user123','created','login password created'),
(4,276,'transaction','4455','2022-06-01 11:28:27','user123','created','transaction password created'),
(5,277,'login','konain1','2022-06-01 11:30:15','konain','created','login password created'),
(6,277,'transaction','3322','2022-06-01 11:30:15','konain','created','transaction password created'),
(7,278,'login','ahsan12','2022-06-01 11:33:58','ahsan','created','login password created'),
(8,278,'transaction','2211','2022-06-01 11:33:58','ahsan','created','transaction password created'),
(11,280,'login','ahmed12','2022-06-03 08:14:39','ahmed','created','login password created'),
(12,280,'transaction','11','2022-06-03 08:14:39','ahmed','created','transaction password created'),
(13,282,'login','sajid12','2022-06-03 09:32:47','sajid','created','login password created'),
(14,282,'transaction','11','2022-06-03 09:32:47','sajid','created','transaction password created'),
(15,283,'login','kashan1','2024-02-08 01:38:09','kashan','created','login password created'),
(16,283,'transaction','1234','2024-02-08 01:38:09','kashan','created','transaction password created'),
(17,284,'login','New1234','2024-08-17 05:44:17','New','created','login password created'),
(18,284,'transaction','2233','2024-08-17 05:44:17','New','created','transaction password created');

/*Table structure for table `product_images` */

DROP TABLE IF EXISTS `product_images`;

CREATE TABLE `product_images` (
  `pimgid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `pname` text DEFAULT NULL,
  `pimg` text DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `completedate` datetime DEFAULT NULL,
  `canceldate` datetime DEFAULT NULL,
  `iscomplete` tinyint(1) DEFAULT NULL,
  `iscancel` tinyint(1) DEFAULT NULL,
  `isclose` tinyint(1) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`pimgid`),
  KEY `uid` (`uid`),
  KEY `oid` (`oid`),
  KEY `pid` (`pid`),
  KEY `product_images_ibfk_4` (`tlvid`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `product_images` */

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pname` text DEFAULT NULL,
  `pimg` text DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `iscancel` tinyint(1) DEFAULT NULL,
  `isclose` tinyint(1) DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `products` */

insert  into `products`(`pid`,`pname`,`pimg`,`createdate`,`iscancel`,`isclose`,`status`) values 
(1,'Alarm-clock','Alarm-clock.png','2022-05-20 16:37:35',0,0,'created'),
(2,'AMP','AMP.png','2022-05-20 16:37:35',0,0,'created'),
(3,'Wireless-Mouse','Wireless_Mouse.png','2022-05-20 16:37:35',0,0,'created'),
(4,'Blue-Watch','Blue-Watch.png','2022-05-20 16:37:35',0,0,'created'),
(5,'Biscuits','Biscuits.png','2022-05-20 16:37:35',0,0,'created'),
(6,'Kitkat','Kitkat.png','2022-05-20 16:37:35',0,0,'created'),
(7,'Tablet','Tablet.png','2022-05-20 16:37:35',0,0,'created'),
(8,'Apple-iPad','Apple_iPad.png','2022-05-20 16:37:35',0,0,'created'),
(9,'Black-Perfume','Black-Perfume.png','2022-05-20 16:37:35',0,0,'created'),
(10,'Black-Watch','Black-Watch.png','2022-05-20 16:37:35',0,0,'created'),
(11,'Coconut-Key-Lime','Coconut-Key-Lime.png','2022-05-20 16:37:35',0,0,'created'),
(12,'Cream','Cream.png','2022-05-20 16:37:35',0,0,'created'),
(13,'Charger','Charger.png','2022-05-20 16:37:35',0,0,'created'),
(14,'Laptop','Laptop.png','2022-05-20 16:37:35',0,0,'created'),
(15,'Power Bank','Power Bank.png','2022-05-20 16:37:35',0,0,'created'),
(16,'Bracelet','Bracelet.png','2022-05-20 16:37:35',0,0,'created'),
(17,'Drops','Drops.png','2022-05-20 16:37:35',0,0,'created'),
(18,'Face-serum-liquid','Face-serum-liquid.png','2022-05-20 16:37:35',0,0,'created'),
(19,'Fanccyy-Glass','Fanccyy-Glass.png','2022-05-20 16:37:35',0,0,'created'),
(20,'Glasses','Glasses.png','2022-05-20 16:37:35',0,0,'created'),
(21,'Led Torch','Led Torch.png','2022-05-20 16:37:35',0,0,'created'),
(22,'hand-cream','hand-cream.png','2022-05-20 16:37:35',0,0,'created'),
(23,'hands-begs','hands-begs.png','2022-05-20 16:37:35',0,0,'created'),
(24,'hand-wash','hand-wash.png','2022-05-20 16:37:35',0,0,'created'),
(25,'Headphones','Headphones.png','2022-05-20 16:37:35',0,0,'created'),
(26,'Wireless Headphone','Wireless Headphone.png','2022-05-20 16:37:35',0,0,'created'),
(27,'Juices','Juices.png','2022-05-20 16:37:35',0,0,'created'),
(28,'Key-chain','Key-chain.png','2022-05-20 16:37:35',0,0,'created'),
(29,'knife-stand','knife-stand.png','2022-05-20 16:37:35',0,0,'created'),
(30,'Lipstick','Lipstick.png','2022-05-20 16:37:35',0,0,'created'),
(31,'Lipstick-yellow','Lipstick-yellow.png','2022-05-20 16:37:35',0,0,'created'),
(32,'Lotion','Lotion.png','2022-05-20 16:37:35',0,0,'created'),
(33,'Mind-Perfume','Mind-Perfume.png','2022-05-20 16:37:35',0,0,'created'),
(34,'Perfume','Perfume.png','2022-05-20 16:37:35',0,0,'created'),
(35,'Phone','Phone.png','2022-05-20 16:37:35',0,0,'created'),
(36,'Sports T-shirt','Sports T-shirt.png','2022-05-20 16:37:35',0,0,'created'),
(37,'red-Lipstick','red-Lipstick.png','2022-05-20 16:37:35',0,0,'created'),
(38,'Chair','Chair.png','2022-05-20 16:37:35',0,0,'created'),
(39,'Dell-Led-Monitor','Dell_Led_Monitor.png','2022-05-20 16:37:35',0,0,'created'),
(40,'Shoes','Shoes.png','2022-05-20 16:37:35',0,0,'created'),
(41,'Stylish-Begs','Stylish-Begs.png','2022-05-20 16:37:35',0,0,'created'),
(42,'Stylish-Glasses','Stylish-Glasses.png','2022-05-20 16:37:35',0,0,'created'),
(43,'tenor-sexophone','tenor-sexophone.png','2022-05-20 16:37:35',0,0,'created'),
(44,'earpiece','earpiece.png','2022-05-20 16:37:35',0,0,'created'),
(45,'Torch','Torch.png','2022-05-20 16:37:35',0,0,'created'),
(46,'Toys','Toys.png','2022-05-20 16:37:35',0,0,'created'),
(47,'Xbox-One','Xbox-One.png','2022-05-20 16:37:35',0,0,'created'),
(48,'Mini-Portable-Bluetooth-Speaker','Mini_Portable_Bluetooth_Speaker_1.png','2022-05-20 16:37:35',0,0,'created'),
(49,'Wifi_Dongle','Wifi_Dongle.png','2022-05-20 16:37:35',0,0,'created'),
(50,'Led Torch','Led Torch.png','2022-05-20 16:37:35',0,0,'created'),
(51,'Alarm-clock','Alarm-clock.png','2022-05-20 16:37:35',0,0,'created'),
(52,'AMP','AMP.png','2022-05-20 16:37:35',0,0,'created'),
(53,'Wireless-Mouse','Wireless_Mouse.png','2022-05-20 16:37:35',0,0,'created'),
(54,'Blue-Watch','Blue-Watch.png','2022-05-20 16:37:35',0,0,'created'),
(55,'Biscuits','Biscuits.png','2022-05-20 16:37:35',0,0,'created'),
(56,'Kitkat','Kitkat.png','2022-05-20 16:37:35',0,0,'created'),
(57,'Tablet','Tablet.png','2022-05-20 16:37:35',0,0,'created'),
(58,'Apple-iPad','Apple_iPad.png','2022-05-20 16:37:35',0,0,'created'),
(59,'Black-Perfume','Black-Perfume.png','2022-05-20 16:37:35',0,0,'created'),
(60,'Black-Watch','Black-Watch.png','2022-05-20 16:37:35',0,0,'created'),
(61,'Coconut-Key-Lime','Coconut-Key-Lime.png','2022-05-20 16:37:35',0,0,'created'),
(62,'Cream','Cream.png','2022-05-20 16:37:35',0,0,'created'),
(63,'Cream','Cream.png','2022-05-20 16:37:35',0,0,'created'),
(64,'Charger','Charger.png','2022-05-20 16:37:35',0,0,'created'),
(65,'Laptop','Laptop.png','2022-05-20 16:37:35',0,0,'created'),
(66,'Power Bank','Power Bank.png','2022-05-20 16:37:35',0,0,'created'),
(67,'Bracelet','Bracelet.png','2022-05-20 16:37:35',0,0,'created'),
(68,'Drops','Drops.png','2022-05-20 16:37:35',0,0,'created'),
(69,'Face-serum-liquid','Face-serum-liquid.png','2022-05-20 16:37:35',0,0,'created'),
(70,'Fanccyy-Glass','Fanccyy-Glass.png','2022-05-20 16:37:35',0,0,'created'),
(71,'Glasses','Glasses.png','2022-05-20 16:37:35',0,0,'created'),
(72,'Led Torch','Led Torch.png','2022-05-20 16:37:35',0,0,'created'),
(73,'hand-cream','hand-cream.png','2022-05-20 16:37:35',0,0,'created'),
(74,'hands-begs','hands-begs.png','2022-05-20 16:37:35',0,0,'created'),
(75,'hand-wash','hand-wash.png','2022-05-20 16:37:35',0,0,'created'),
(76,'Headphones','Headphones.png','2022-05-20 16:37:35',0,0,'created'),
(77,'Sports T-shirt','Sports T-shirt.png','2022-05-20 16:37:35',0,0,'created'),
(78,'red-Lipstick','red-Lipstick.png','2022-05-20 16:37:35',0,0,'created'),
(79,'Chair','Chair.png','2022-05-20 16:37:35',0,0,'created'),
(80,'Dell-Led-Monitor','Dell_Led_Monitor.png','2022-05-20 16:37:35',0,0,'created'),
(81,'Shoes','Shoes.png','2022-05-20 16:37:35',0,0,'created'),
(82,'Stylish-Begs','Stylish-Begs.png','2022-05-20 16:37:35',0,0,'created'),
(83,'Stylish-Glasses','Stylish-Glasses.png','2022-05-20 16:37:35',0,0,'created'),
(84,'tenor-sexophone','tenor-sexophone.png','2022-05-20 16:37:35',0,0,'created'),
(85,'earpiece','earpiece.png','2022-05-20 16:37:35',0,0,'created'),
(86,'Torch','Torch.png','2022-05-20 16:37:35',0,0,'created'),
(87,'Toys','Toys.png','2022-05-20 16:37:35',0,0,'created'),
(88,'Xbox-One','Xbox-One.png','2022-05-20 16:37:35',0,0,'created'),
(89,'Mini-Portable-Bluetooth-Speaker','Mini_Portable_Bluetooth_Speaker_1.png','2022-05-20 16:37:35',0,0,'created'),
(90,'Wifi_Dongle','Wifi_Dongle.png','2022-05-20 16:37:35',0,0,'created'),
(91,'Led Torch','Led Torch.png','2022-05-20 16:37:35',0,0,'created'),
(92,'Lipstick-yellow','Lipstick-yellow.png','2022-05-20 16:37:35',0,0,'created'),
(93,'Lotion','Lotion.png','2022-05-20 16:37:35',0,0,'created'),
(94,'Perfume','Perfume.png','2022-05-20 16:37:35',0,0,'created'),
(95,'Phone','Phone.png','2022-05-20 16:37:35',0,0,'created'),
(96,'Tablet','Tablet.png','2022-05-20 16:37:35',0,0,'created'),
(97,'Black-Perfume','Black-Perfume.png','2022-05-20 16:37:35',0,0,'created'),
(98,'Cream','Cream.png','2022-05-20 16:37:35',0,0,'created'),
(99,'Charger','Charger.png','2022-05-20 16:37:35',0,0,'created');

/*Table structure for table `restore_history` */

DROP TABLE IF EXISTS `restore_history`;

CREATE TABLE `restore_history` (
  `rhid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`rhid`),
  KEY `uid` (`uid`),
  CONSTRAINT `restore_history_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `restore_history` */

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `roles` */

insert  into `roles`(`roleid`,`role`) values 
(1,'cp admin'),
(2,'admin'),
(3,'agent'),
(4,'user');

/*Table structure for table `supporters` */

DROP TABLE IF EXISTS `supporters`;

CREATE TABLE `supporters` (
  `supid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `sname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `encpass` text DEFAULT NULL,
  `decpass` text DEFAULT NULL,
  `simgname` varchar(20) DEFAULT NULL,
  `simgguid` text DEFAULT NULL,
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
  `isrestore` tinyint(1) DEFAULT NULL,
  `isnew` tinyint(1) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`supid`),
  KEY `uid` (`uid`),
  CONSTRAINT `supporters_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `supporters` */

insert  into `supporters`(`supid`,`uid`,`sname`,`email`,`encpass`,`decpass`,`simgname`,`simgguid`,`ccode`,`ctitle`,`mobile`,`country`,`refcode`,`createdate`,`updatedate`,`deletedate`,`blacklistdate`,`restoredate`,`createby`,`updateby`,`deleteby`,`blockby`,`restoreby`,`isedit`,`isdeleted`,`isblock`,`isrestore`,`isnew`,`ip`,`status`,`remarks`) values 
(2,276,'user123',NULL,'6ad14ba9986e3615423dfca256d04e3f','user123','default image','use.png','92','pk','+923101136367','Pakistan (‫پاکستان‬‎)','ddagm8','2022-06-01 11:28:27',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,NULL,'new',NULL),
(3,277,'konain',NULL,'d3985fd48d53d7a9f24b0b84d0a0a288','konain1','default image','use.png','92','pk','+923404445433','Pakistan (‫پاکستان‬‎)','0Q8xKZ','2022-06-01 11:30:15',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,NULL,'new',NULL),
(4,278,'ahsan',NULL,'241138a9ffd584b5b228a8b02bef0671','ahsan12','default image','use.png','90','tr','+905012345678','Turkey (Türkiye)','VkrcR3','2022-06-01 11:33:58',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,NULL,'new',NULL),
(6,280,'ahmed',NULL,'3ab66a6d1c52730432b5bd38a366c148','ahmed12','default image','grab.png','92','pk','+923122442124','Pakistan (‫پاکستان‬‎)','2uOdGc','2022-06-03 08:14:39',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,NULL,'new',NULL),
(7,282,'sajid',NULL,'4b19837ef331661676b1c2b5c49a5fbb','sajid12','default image','grab.png','92','pk','+923172228544','Pakistan (‫پاکستان‬‎)','VkrcR3','2022-06-03 09:32:47',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,NULL,'new',NULL),
(8,283,'kashan',NULL,'58244e65b503ac6210ef50c62da3b938','kashan1','default image','grab.png','','','','','0Q8xKZ','2024-02-08 01:38:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,NULL,'new',NULL),
(9,284,'New',NULL,'7b8b1db5ae3bc0f6eba1b3426485d45d','New1234','default image','grab.png','92','pk','+923310237751','Pakistan (??????????)','0Q8xKZ','2024-08-17 05:44:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,0,NULL,'new',NULL);

/*Table structure for table `team_deposit` */

DROP TABLE IF EXISTS `team_deposit`;

CREATE TABLE `team_deposit` (
  `tmdid` int(11) NOT NULL AUTO_INCREMENT,
  `tmid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `invcid` int(11) DEFAULT NULL,
  `dpid` int(11) DEFAULT NULL,
  `refcode` varchar(20) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'deposit',
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`tmdid`),
  KEY `tmid` (`tmid`),
  KEY `uid` (`uid`),
  KEY `dpid` (`dpid`),
  KEY `invcid` (`invcid`),
  CONSTRAINT `team_deposit_ibfk_1` FOREIGN KEY (`tmid`) REFERENCES `teams` (`tmid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `team_deposit_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `team_deposit_ibfk_3` FOREIGN KEY (`dpid`) REFERENCES `deposite` (`dpid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `team_deposit_ibfk_4` FOREIGN KEY (`invcid`) REFERENCES `user_invitation_code` (`invcid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `team_deposit` */

/*Table structure for table `team_withdrawal` */

DROP TABLE IF EXISTS `team_withdrawal`;

CREATE TABLE `team_withdrawal` (
  `tmwid` int(11) NOT NULL AUTO_INCREMENT,
  `tmid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `invcid` int(11) DEFAULT NULL,
  `wtid` int(11) DEFAULT NULL,
  `refcode` varchar(20) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'withdrawal',
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`tmwid`),
  KEY `tmid` (`tmid`),
  KEY `uid` (`uid`),
  KEY `wtid` (`wtid`),
  KEY `invcid` (`invcid`),
  CONSTRAINT `team_withdrawal_ibfk_1` FOREIGN KEY (`tmid`) REFERENCES `teams` (`tmid`),
  CONSTRAINT `team_withdrawal_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `team_withdrawal_ibfk_3` FOREIGN KEY (`wtid`) REFERENCES `withdrawal` (`wtid`),
  CONSTRAINT `team_withdrawal_ibfk_4` FOREIGN KEY (`invcid`) REFERENCES `user_invitation_code` (`invcid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `team_withdrawal` */

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `tmid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `refid` int(11) DEFAULT NULL,
  `retid` int(11) DEFAULT NULL,
  `ulvidf` int(11) DEFAULT NULL,
  `ulvidt` int(11) DEFAULT NULL,
  `refcode` varchar(6) DEFAULT NULL,
  `retcode` varchar(6) DEFAULT NULL,
  `levelfrom` int(11) DEFAULT NULL,
  `levelto` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`tmid`),
  KEY `uid` (`uid`),
  KEY `invcid` (`refid`),
  KEY `retid` (`retid`),
  KEY `ulvidf` (`ulvidf`),
  KEY `ulvidt` (`ulvidt`),
  CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `teams_ibfk_2` FOREIGN KEY (`refid`) REFERENCES `user_invitation_code` (`invcid`),
  CONSTRAINT `teams_ibfk_3` FOREIGN KEY (`refid`) REFERENCES `user_invitation_code` (`invcid`),
  CONSTRAINT `teams_ibfk_4` FOREIGN KEY (`retid`) REFERENCES `user_invitation_code` (`invcid`),
  CONSTRAINT `teams_ibfk_5` FOREIGN KEY (`ulvidf`) REFERENCES `user_level` (`ulvid`),
  CONSTRAINT `teams_ibfk_6` FOREIGN KEY (`ulvidt`) REFERENCES `user_level` (`ulvid`),
  CONSTRAINT `teams_ibfk_7` FOREIGN KEY (`ulvidf`) REFERENCES `user_level` (`ulvid`),
  CONSTRAINT `teams_ibfk_8` FOREIGN KEY (`ulvidt`) REFERENCES `user_level` (`ulvid`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `teams` */

insert  into `teams`(`tmid`,`uid`,`refid`,`retid`,`ulvidf`,`ulvidt`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`,`status`,`remarks`) values 
(49,277,223,224,1,1,'0Q8xKZ','VkrcR3',1,1,'2022-06-01 11:30:15','created','team created'),
(50,278,224,225,1,2,'0Q8xKZ','2uOdGc',1,2,'2022-06-01 11:33:58','created','team created'),
(51,278,224,225,1,2,'VkrcR3','2uOdGc',2,1,'2022-06-01 11:33:58','created','team created'),
(54,280,225,227,2,2,'VkrcR3','BNIpV9',2,2,'2022-06-03 08:14:39','created','team created'),
(55,280,225,227,1,3,'2uOdGc','BNIpV9',3,1,'2022-06-03 08:14:39','created','team created'),
(57,282,224,228,1,3,'0Q8xKZ','WC7qdE',1,3,'2022-06-03 09:32:47','created','team created'),
(58,282,224,228,1,3,'VkrcR3','WC7qdE',2,1,'2022-06-03 09:32:47','created','team created'),
(59,283,223,229,1,1,'0Q8xKZ','8Fbq1n',1,1,'2024-02-08 01:38:09','created','team created'),
(60,284,223,230,1,1,'0Q8xKZ','XLTbZI',1,1,'2024-08-17 05:44:17','created','team created');

/*Table structure for table `tier_level` */

DROP TABLE IF EXISTS `tier_level`;

CREATE TABLE `tier_level` (
  `tlvid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `level` varchar(3) DEFAULT NULL,
  `tno` int(11) DEFAULT NULL,
  `lrange` varchar(50) DEFAULT NULL,
  `com` varchar(20) DEFAULT NULL,
  `pcom` double DEFAULT NULL,
  `unlockdate` datetime DEFAULT NULL,
  `islock` tinyint(1) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`tlvid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tier_level` */

insert  into `tier_level`(`tlvid`,`title`,`level`,`tno`,`lrange`,`com`,`pcom`,`unlockdate`,`islock`,`status`) values 
(1,'Tier 1','LV1',50,'$100-500','5%',0.1,'2022-05-17 20:10:39',0,'unlock'),
(2,'Tier 2','LV2',55,'$500-1000','8%',0.14,'2022-05-17 20:17:18',1,'lock'),
(3,'Tier 3','LV3',60,'$1000-2000','10%',0.16,'2022-05-17 20:13:50',1,'lock'),
(4,'Tier 4','LV4',70,'$2000 or more','12%',0.17,NULL,1,'lock');

/*Table structure for table `topup_method` */

DROP TABLE IF EXISTS `topup_method`;

CREATE TABLE `topup_method` (
  `tpmid` int(11) NOT NULL AUTO_INCREMENT,
  `tpmethod` varchar(20) DEFAULT NULL,
  `tpchannel` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`tpmid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `topup_method` */

insert  into `topup_method`(`tpmid`,`tpmethod`,`tpchannel`) values 
(1,'USDT TRC-20','USDT');

/*Table structure for table `total_commission` */

DROP TABLE IF EXISTS `total_commission`;

CREATE TABLE `total_commission` (
  `tcomid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `refcode` varchar(6) DEFAULT NULL,
  `tc` double DEFAULT NULL,
  `nc` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `iscancel` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`tcomid`),
  KEY `uid` (`uid`),
  KEY `tlvid` (`tlvid`),
  CONSTRAINT `total_commission_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `total_commission_ibfk_2` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `total_commission` */

/*Table structure for table `transaction` */

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tpmid` int(11) DEFAULT NULL,
  `dpid` int(11) DEFAULT NULL,
  `wtid` int(11) DEFAULT NULL,
  `wlid` int(11) DEFAULT NULL,
  `transaction` double DEFAULT NULL,
  `transactiondate` datetime DEFAULT NULL,
  `istransaction` tinyint(1) DEFAULT 0,
  `status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`tid`),
  KEY `wlid` (`wlid`),
  KEY `tpid` (`tpmid`),
  KEY `uid` (`uid`),
  KEY `dpid` (`dpid`),
  KEY `wtid` (`wtid`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaction` */

insert  into `transaction`(`tid`,`uid`,`tpmid`,`dpid`,`wtid`,`wlid`,`transaction`,`transactiondate`,`istransaction`,`status`) values 
(49,276,1,5,NULL,49,30,'2024-08-30 11:39:29',0,'pending');

/*Table structure for table `transaction_activity` */

DROP TABLE IF EXISTS `transaction_activity`;

CREATE TABLE `transaction_activity` (
  `taid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tid` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `activitydate` datetime DEFAULT NULL,
  PRIMARY KEY (`taid`),
  KEY `tid` (`tid`),
  KEY `uid` (`uid`),
  CONSTRAINT `transaction_activity_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `transaction` (`tid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaction_activity_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `transaction_activity` */

insert  into `transaction_activity`(`taid`,`uid`,`tid`,`remarks`,`activitydate`) values 
(19,276,49,'user deposit','2024-08-30 11:39:29');

/*Table structure for table `user_activity` */

DROP TABLE IF EXISTS `user_activity`;

CREATE TABLE `user_activity` (
  `acid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `activitydate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`acid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_activity_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=561 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_activity` */

insert  into `user_activity`(`acid`,`uid`,`remarks`,`activitydate`,`device`,`ip`,`status`) values 
(0,276,'user login','2022-06-14 02:42:05','dj','192.168.2.103','login'),
(8,276,'user signup','2022-06-01 11:28:27','dj','192.168.8.102','signup'),
(9,276,'user login','2022-06-01 11:28:27','dj','192.168.8.102','login'),
(10,276,'user logout','2022-06-01 11:28:49','dj','192.168.8.102','login'),
(11,277,'user signup','2022-06-01 11:30:15','dj','192.168.8.102','signup'),
(12,277,'user login','2022-06-01 11:30:15','dj','192.168.8.102','login'),
(13,277,'user logout','2022-06-01 11:31:05','dj','192.168.8.102','login'),
(14,276,'user login','2022-06-01 11:31:15','dj','192.168.8.102','login'),
(15,276,'user logout','2022-06-01 11:31:49','dj','192.168.8.102','login'),
(16,278,'user signup','2022-06-01 11:33:58','dj','192.168.8.102','signup'),
(17,278,'user login','2022-06-01 11:33:58','dj','192.168.8.102','login'),
(18,278,'user logout','2022-06-01 12:09:00','dj','192.168.8.102','login'),
(19,276,'user login','2022-06-01 12:12:57','dj','192.168.8.102','login'),
(20,276,'user deposit','2022-06-01 12:16:38','dj','192.168.8.102','deposit'),
(21,1,'cp admin login','2022-06-01 12:17:07','dj','192.168.8.102','login'),
(22,1,'cp admin logout','2022-06-01 12:17:15','dj','192.168.8.102','login'),
(23,1,'cp admin login','2022-06-01 12:17:47','dj','192.168.8.102','login'),
(24,1,'approve deposit','2022-06-01 12:18:15','dj','192.168.8.102','approve'),
(25,276,'user tier level','2022-06-01 09:18:23','dj','192.168.8.102','created'),
(26,276,'user tier level','2022-06-01 09:18:23','dj','192.168.8.102','created'),
(27,276,'user tier level','2022-06-01 09:18:23','dj','192.168.8.102','created'),
(28,276,'user tier level','2022-06-01 09:18:23','dj','192.168.8.102','created'),
(29,276,'user no of order','2022-06-01 12:18:26','dj','192.168.8.102','created'),
(30,276,'user order','2022-06-01 12:38:33','dj','192.168.8.102','created'),
(31,276,'user order confirm','2022-06-01 12:38:50','dj','192.168.8.102','created'),
(32,276,'other commission','2022-06-01 12:38:51','dj','192.168.8.102','created'),
(33,276,'user logout','2022-06-01 12:39:31','dj','192.168.8.102','login'),
(34,277,'user login','2022-06-01 12:40:12','dj','192.168.8.102','login'),
(35,277,'user tier level','2022-06-01 09:40:20','dj','192.168.8.102','created'),
(36,277,'user tier level','2022-06-01 09:40:20','dj','192.168.8.102','created'),
(37,277,'user tier level','2022-06-01 09:40:20','dj','192.168.8.102','created'),
(38,277,'user tier level','2022-06-01 09:40:20','dj','192.168.8.102','created'),
(39,277,'user deposit','2022-06-01 12:40:48','dj','192.168.8.102','deposit'),
(40,1,'approve deposit','2022-06-01 12:41:54','dj','192.168.8.102','approve'),
(41,277,'user no of order','2022-06-01 12:43:16','dj','192.168.8.102','created'),
(42,277,'user order','2022-06-01 12:43:27','dj','192.168.8.102','created'),
(43,277,'user order confirm','2022-06-01 12:43:40','dj','192.168.8.102','created'),
(44,277,'other commission','2022-06-01 12:43:41','dj','192.168.8.102','created'),
(45,277,'user logout','2022-06-01 12:44:09','dj','192.168.8.102','login'),
(46,276,'user login','2022-06-01 12:44:20','dj','192.168.8.102','login'),
(47,276,'user logout','2022-06-01 12:53:13','dj','192.168.8.102','login'),
(48,277,'user login','2022-06-01 12:53:56','dj','192.168.8.102','login'),
(49,277,'user logout','2022-06-01 12:54:39','dj','192.168.8.102','login'),
(50,278,'user login','2022-06-01 12:55:02','dj','192.168.8.102','login'),
(51,278,'user deposit','2022-06-01 12:55:22','dj','192.168.8.102','deposit'),
(52,1,'approve deposit','2022-06-01 12:55:41','dj','192.168.8.102','approve'),
(53,278,'user tier level','2022-06-01 09:55:49','dj','192.168.8.102','created'),
(54,278,'user tier level','2022-06-01 09:55:49','dj','192.168.8.102','created'),
(55,278,'user tier level','2022-06-01 09:55:49','dj','192.168.8.102','created'),
(56,278,'user tier level','2022-06-01 09:55:49','dj','192.168.8.102','created'),
(57,278,'user no of order','2022-06-01 12:55:50','dj','192.168.8.102','created'),
(58,278,'user order','2022-06-01 12:55:52','dj','192.168.8.102','created'),
(59,278,'user order confirm','2022-06-01 12:55:59','dj','192.168.8.102','created'),
(60,278,'other commission','2022-06-01 12:56:00','dj','192.168.8.102','created'),
(61,278,'user logout','2022-06-01 12:56:06','dj','192.168.8.102','login'),
(62,277,'user login','2022-06-01 12:56:16','dj','192.168.8.102','login'),
(63,277,'user logout','2022-06-01 12:57:23','dj','192.168.8.102','login'),
(64,276,'user login','2022-06-01 12:57:33','dj','192.168.8.102','login'),
(65,276,'user logout','2022-06-01 12:59:53','dj','192.168.8.102','login'),
(66,277,'user login','2022-06-01 01:00:16','dj','192.168.8.102','login'),
(67,276,'user login','2022-06-01 01:46:51','dj','192.168.8.102','login'),
(68,276,'user order','2022-06-01 03:28:08','dj','192.168.8.102','created'),
(69,276,'user order confirm','2022-06-01 03:28:15','dj','192.168.8.102','created'),
(70,276,'other commission','2022-06-01 03:28:16','dj','192.168.8.102','created'),
(71,276,'user login','2022-06-01 04:13:48','dj','192.168.8.102','login'),
(72,276,'user login','2022-06-01 05:59:22','DESKTOP-SJ45L77','192.168.88.10','login'),
(73,276,'user deposit','2022-06-01 06:49:19','DESKTOP-SJ45L77','192.168.88.10','deposit'),
(74,1,'cp admin login','2022-06-01 06:49:57','DESKTOP-SJ45L77','192.168.88.10','login'),
(75,1,'approve deposit','2022-06-01 06:50:06','DESKTOP-SJ45L77','192.168.88.10','approve'),
(76,276,'user order','2022-06-01 06:50:25','DESKTOP-SJ45L77','192.168.88.10','created'),
(77,276,'user order confirm','2022-06-01 06:50:36','DESKTOP-SJ45L77','192.168.88.10','created'),
(78,276,'other commission','2022-06-01 06:50:37','DESKTOP-SJ45L77','192.168.88.10','created'),
(79,276,'user login','2022-06-01 11:48:06','DESKTOP-SJ45L77','192.168.88.10','login'),
(80,276,'user logout','2022-06-02 12:03:07','DESKTOP-SJ45L77','192.168.88.10','login'),
(81,276,'user login','2022-06-02 12:03:16','DESKTOP-SJ45L77','192.168.88.10','login'),
(82,276,'user logout','2022-06-02 12:03:21','DESKTOP-SJ45L77','192.168.88.10','login'),
(83,277,'user login','2022-06-02 12:03:32','DESKTOP-SJ45L77','192.168.88.10','login'),
(84,277,'user logout','2022-06-02 12:03:40','DESKTOP-SJ45L77','192.168.88.10','login'),
(85,276,'user login','2022-06-02 12:03:48','DESKTOP-SJ45L77','192.168.88.10','login'),
(86,276,'user update profile image','2022-06-02 12:49:31','DESKTOP-SJ45L77','192.168.88.10','update'),
(87,276,'user update profile image','2022-06-02 12:50:10','DESKTOP-SJ45L77','192.168.88.10','update'),
(88,276,'user update profile image','2022-06-02 12:54:29','DESKTOP-SJ45L77','192.168.88.10','update'),
(89,276,'user update profile image','2022-06-02 01:03:21','DESKTOP-SJ45L77','192.168.88.10','update'),
(90,276,'user update profile image','2022-06-02 01:03:33','DESKTOP-SJ45L77','192.168.88.10','update'),
(91,276,'user update profile image','2022-06-02 01:03:45','DESKTOP-SJ45L77','192.168.88.10','update'),
(92,276,'user update profile image','2022-06-02 01:04:46','DESKTOP-SJ45L77','192.168.88.10','update'),
(93,276,'user update profile image','2022-06-02 01:05:02','DESKTOP-SJ45L77','192.168.88.10','update'),
(94,276,'user update profile image','2022-06-02 01:05:17','DESKTOP-SJ45L77','192.168.88.10','update'),
(95,276,'user update profile image','2022-06-02 01:05:31','DESKTOP-SJ45L77','192.168.88.10','update'),
(96,276,'user update profile image','2022-06-02 01:05:46','DESKTOP-SJ45L77','192.168.88.10','update'),
(97,276,'user update profile image','2022-06-02 01:05:58','DESKTOP-SJ45L77','192.168.88.10','update'),
(98,276,'user update profile image','2022-06-02 01:06:05','DESKTOP-SJ45L77','192.168.88.10','update'),
(99,276,'user update profile image','2022-06-02 01:06:31','DESKTOP-SJ45L77','192.168.88.10','update'),
(100,276,'user update profile image','2022-06-02 01:06:45','DESKTOP-SJ45L77','192.168.88.10','update'),
(101,276,'user update profile image','2022-06-02 01:07:07','DESKTOP-SJ45L77','192.168.88.10','update'),
(102,276,'user update profile image','2022-06-02 01:07:28','DESKTOP-SJ45L77','192.168.88.10','update'),
(103,276,'user update profile image','2022-06-02 01:11:05','DESKTOP-SJ45L77','192.168.88.10','update'),
(104,276,'user update profile image','2022-06-02 01:13:28','DESKTOP-SJ45L77','192.168.88.10','update'),
(105,276,'user update profile image','2022-06-02 01:13:40','DESKTOP-SJ45L77','192.168.88.10','update'),
(106,276,'user update profile image','2022-06-02 01:31:38','DESKTOP-SJ45L77','192.168.88.10','update'),
(107,276,'user update profile image','2022-06-02 01:31:44','DESKTOP-SJ45L77','192.168.88.10','update'),
(108,276,'user logout','2022-06-02 01:32:45','DESKTOP-SJ45L77','192.168.88.10','login'),
(109,276,'user login','2022-06-02 05:45:16','DESKTOP-SJ45L77','192.168.88.10','login'),
(110,276,'user update profile image','2022-06-02 05:59:34','DESKTOP-SJ45L77','192.168.88.10','update'),
(111,276,'user update profile image','2022-06-02 05:59:48','DESKTOP-SJ45L77','192.168.88.10','update'),
(112,276,'user update profile image','2022-06-02 06:00:22','DESKTOP-SJ45L77','192.168.88.10','update'),
(113,276,'user update profile image','2022-06-02 06:00:56','DESKTOP-SJ45L77','192.168.88.10','update'),
(114,276,'user update profile image','2022-06-02 06:01:02','DESKTOP-SJ45L77','192.168.88.10','update'),
(115,276,'user update profile image','2022-06-02 06:01:16','DESKTOP-SJ45L77','192.168.88.10','update'),
(116,276,'user update profile image','2022-06-02 06:12:59','DESKTOP-SJ45L77','192.168.88.10','update'),
(117,1,'cp admin login','2022-06-02 06:26:10','DESKTOP-SJ45L77','192.168.88.10','login'),
(118,1,'delete user','2022-06-02 07:28:13','DESKTOP-SJ45L77','192.168.88.10','delete'),
(119,1,'restore user','2022-06-02 07:29:38','DESKTOP-SJ45L77','192.168.88.10','restore'),
(120,1,'delete user','2022-06-02 07:31:59','DESKTOP-SJ45L77','192.168.88.10','delete'),
(121,1,'restore user','2022-06-02 07:32:05','DESKTOP-SJ45L77','192.168.88.10','restore'),
(122,1,'delete user','2022-06-02 07:32:16','DESKTOP-SJ45L77','192.168.88.10','delete'),
(123,1,'restore user','2022-06-02 07:32:28','DESKTOP-SJ45L77','192.168.88.10','restore'),
(124,1,'block user','2022-06-02 07:45:34','DESKTOP-SJ45L77','192.168.88.10','block'),
(125,1,'restore block user','2022-06-02 07:45:43','DESKTOP-SJ45L77','192.168.88.10','restore'),
(126,1,'block user','2022-06-02 07:53:53','DESKTOP-SJ45L77','192.168.88.10','block'),
(127,1,'restore block user','2022-06-02 07:56:19','DESKTOP-SJ45L77','192.168.88.10','restore'),
(128,1,'delete user','2022-06-02 07:56:41','DESKTOP-SJ45L77','192.168.88.10','delete'),
(157,276,'user login','2022-06-02 08:20:24','DESKTOP-SJ45L77','192.168.88.10','login'),
(158,276,'user logout','2022-06-02 08:20:40','DESKTOP-SJ45L77','192.168.88.10','login'),
(159,276,'user login','2022-06-02 08:25:03','DESKTOP-SJ45L77','192.168.88.10','login'),
(160,276,'user update profile image','2022-06-02 08:26:32','DESKTOP-SJ45L77','192.168.88.10','update'),
(161,1,'delete user','2022-06-02 08:27:15','DESKTOP-SJ45L77','192.168.88.10','delete'),
(162,276,'user logout','2022-06-02 08:28:18','DESKTOP-SJ45L77','192.168.88.10','login'),
(163,1,'restore user','2022-06-02 08:28:33','DESKTOP-SJ45L77','192.168.88.10','restore'),
(164,1,'block user','2022-06-02 08:34:43','DESKTOP-SJ45L77','192.168.88.10','block'),
(165,276,'user login','2022-06-02 08:35:29','DESKTOP-SJ45L77','192.168.88.10','login'),
(166,276,'user logout','2022-06-02 08:35:32','DESKTOP-SJ45L77','192.168.88.10','login'),
(167,276,'user login','2022-06-02 08:35:50','DESKTOP-SJ45L77','192.168.88.10','login'),
(168,276,'user logout','2022-06-02 08:35:53','DESKTOP-SJ45L77','192.168.88.10','login'),
(169,1,'restore block user','2022-06-02 08:36:27','DESKTOP-SJ45L77','192.168.88.10','restore'),
(170,1,'cp admin logout','2022-06-02 08:49:43','DESKTOP-SJ45L77','192.168.88.10','login'),
(171,1,'cp admin login','2022-06-02 08:53:14','DESKTOP-SJ45L77','192.168.88.10','login'),
(172,1,'update wallet address','2022-06-02 08:55:06','DESKTOP-SJ45L77','192.168.88.10','approve'),
(173,276,'user login','2022-06-02 08:55:29','DESKTOP-SJ45L77','192.168.88.10','login'),
(174,276,'user logout','2022-06-03 12:35:25','DESKTOP-SJ45L77','192.168.88.10','login'),
(175,276,'user login','2022-06-03 01:13:18','host.sofxol.com','104.193.108.203','login'),
(176,276,'user logout','2022-06-03 01:14:23','host.sofxol.com','104.193.108.203','login'),
(177,277,'user login','2022-06-03 01:14:30','host.sofxol.com','104.193.108.203','login'),
(178,277,'user logout','2022-06-03 01:21:00','host.sofxol.com','104.193.108.203','login'),
(179,277,'user login','2022-06-03 01:21:22','host.sofxol.com','104.193.108.203','login'),
(180,277,'user logout','2022-06-03 01:39:46','host.sofxol.com','104.193.108.203','login'),
(181,277,'user login','2022-06-03 01:40:31','host.sofxol.com','104.193.108.203','login'),
(182,277,'user logout','2022-06-03 01:41:01','host.sofxol.com','104.193.108.203','login'),
(183,277,'user login','2022-06-03 01:41:10','host.sofxol.com','104.193.108.203','login'),
(184,277,'user update profile image','2022-06-03 01:41:24','host.sofxol.com','104.193.108.203','update'),
(185,277,'user logout','2022-06-03 01:42:02','host.sofxol.com','104.193.108.203','login'),
(186,278,'user login','2022-06-03 01:42:17','host.sofxol.com','104.193.108.203','login'),
(187,278,'user logout','2022-06-03 01:42:50','host.sofxol.com','104.193.108.203','login'),
(188,1,'cp admin login','2022-06-03 01:46:03','host.sofxol.com','104.193.108.203','login'),
(189,276,'user login','2022-06-03 02:32:34','host.sofxol.com','104.193.108.203','login'),
(190,276,'user login','2022-06-03 03:16:56','host.sofxol.com','104.193.108.203','login'),
(191,276,'user logout','2022-06-03 03:20:26','host.sofxol.com','104.193.108.203','login'),
(192,276,'user login','2022-06-03 03:20:51','host.sofxol.com','104.193.108.203','login'),
(193,276,'user logout','2022-06-03 03:20:57','host.sofxol.com','104.193.108.203','login'),
(194,277,'user login','2022-06-03 03:21:41','host.sofxol.com','104.193.108.203','login'),
(195,277,'user logout','2022-06-03 03:24:00','host.sofxol.com','104.193.108.203','login'),
(196,278,'user login','2022-06-03 09:27:13','host.sofxol.com','104.193.108.203','login'),
(197,278,'user order','2022-06-03 09:28:23','host.sofxol.com','104.193.108.203','created'),
(198,278,'user order confirm','2022-06-03 09:28:32','host.sofxol.com','104.193.108.203','created'),
(199,278,'user logout','2022-06-03 09:29:27','host.sofxol.com','104.193.108.203','login'),
(200,277,'user login','2022-06-03 02:50:46','host.sofxol.com','104.193.108.203','login'),
(201,277,'user logout','2022-06-03 02:56:47','host.sofxol.com','104.193.108.203','login'),
(202,278,'user login','2022-06-03 02:57:00','host.sofxol.com','104.193.108.203','login'),
(203,278,'user logout','2022-06-03 02:58:14','host.sofxol.com','104.193.108.203','login'),
(204,276,'user login','2022-06-03 02:58:40','host.sofxol.com','104.193.108.203','login'),
(205,276,'user logout','2022-06-03 03:06:27','host.sofxol.com','104.193.108.203','login'),
(206,278,'user login','2022-06-03 03:06:50','host.sofxol.com','104.193.108.203','login'),
(207,278,'user logout','2022-06-03 03:07:49','host.sofxol.com','104.193.108.203','login'),
(208,277,'user login','2022-06-03 03:08:14','host.sofxol.com','104.193.108.203','login'),
(209,277,'user logout','2022-06-03 03:11:55','host.sofxol.com','104.193.108.203','login'),
(210,276,'user login','2022-06-03 03:12:09','host.sofxol.com','104.193.108.203','login'),
(211,1,'cp admin login','2022-06-03 03:19:33','host.sofxol.com','104.193.108.203','login'),
(212,276,'user login','2022-06-03 03:34:18','host.sofxol.com','104.193.108.203','login'),
(213,276,'user logout','2022-06-03 03:35:15','host.sofxol.com','104.193.108.203','login'),
(214,277,'user login','2022-06-03 03:35:27','host.sofxol.com','104.193.108.203','login'),
(215,276,'user login','2022-06-03 05:34:36','DESKTOP-SJ45L77','192.168.8.101','login'),
(216,1,'cp admin login','2022-06-03 06:10:25','DESKTOP-SJ45L77','192.168.8.101','login'),
(217,276,'user logout','2022-06-03 06:23:13','DESKTOP-SJ45L77','192.168.8.101','login'),
(218,277,'user login','2022-06-03 06:23:23','DESKTOP-SJ45L77','192.168.8.101','login'),
(219,277,'user logout','2022-06-03 06:36:39','DESKTOP-SJ45L77','192.168.8.101','login'),
(220,276,'user login','2022-06-03 06:36:46','DESKTOP-SJ45L77','192.168.8.101','login'),
(221,276,'user logout','2022-06-03 06:47:12','DESKTOP-SJ45L77','192.168.8.101','login'),
(222,277,'user login','2022-06-03 06:47:26','DESKTOP-SJ45L77','192.168.8.101','login'),
(223,277,'user logout','2022-06-03 07:03:42','DESKTOP-SJ45L77','192.168.8.101','login'),
(249,278,'user logout','2022-06-03 08:13:13','DESKTOP-SJ45L77','192.168.8.101','login'),
(250,280,'user signup','2022-06-03 08:14:39','DESKTOP-SJ45L77','192.168.8.101','signup'),
(251,280,'user login','2022-06-03 08:14:39','DESKTOP-SJ45L77','192.168.8.101','login'),
(252,280,'user deposit','2022-06-03 08:18:02','DESKTOP-SJ45L77','192.168.8.101','deposit'),
(253,1,'approve deposit','2022-06-03 08:18:11','DESKTOP-SJ45L77','192.168.8.101','approve'),
(254,280,'user tier level','2022-06-03 05:18:40','DESKTOP-SJ45L77','192.168.8.101','created'),
(255,280,'user tier level','2022-06-03 05:18:40','DESKTOP-SJ45L77','192.168.8.101','created'),
(256,280,'user tier level','2022-06-03 05:18:40','DESKTOP-SJ45L77','192.168.8.101','created'),
(257,280,'user tier level','2022-06-03 05:18:40','DESKTOP-SJ45L77','192.168.8.101','created'),
(258,280,'user no of order','2022-06-03 08:18:41','DESKTOP-SJ45L77','192.168.8.101','created'),
(259,280,'user order','2022-06-03 08:18:42','DESKTOP-SJ45L77','192.168.8.101','created'),
(260,280,'user order confirm','2022-06-03 08:18:53','DESKTOP-SJ45L77','192.168.8.101','created'),
(261,280,'user logout','2022-06-03 08:19:00','DESKTOP-SJ45L77','192.168.8.101','login'),
(262,278,'user login','2022-06-03 08:19:42','DESKTOP-SJ45L77','192.168.8.101','login'),
(263,278,'user logout','2022-06-03 08:22:32','DESKTOP-SJ45L77','192.168.8.101','login'),
(264,277,'user login','2022-06-03 08:24:06','DESKTOP-SJ45L77','192.168.8.101','login'),
(265,277,'user logout','2022-06-03 08:26:54','DESKTOP-SJ45L77','192.168.8.101','login'),
(266,278,'user login','2022-06-03 08:27:14','DESKTOP-SJ45L77','192.168.8.101','login'),
(267,278,'user logout','2022-06-03 08:27:30','DESKTOP-SJ45L77','192.168.8.101','login'),
(268,276,'user login','2022-06-03 08:27:40','DESKTOP-SJ45L77','192.168.8.101','login'),
(269,276,'user logout','2022-06-03 08:29:33','DESKTOP-SJ45L77','192.168.8.101','login'),
(270,277,'user login','2022-06-03 08:29:42','DESKTOP-SJ45L77','192.168.8.101','login'),
(271,277,'user logout','2022-06-03 09:26:13','DESKTOP-SJ45L77','192.168.8.101','login'),
(272,282,'user signup','2022-06-03 09:32:47','DESKTOP-SJ45L77','192.168.8.101','signup'),
(273,282,'user login','2022-06-03 09:32:47','DESKTOP-SJ45L77','192.168.8.101','login'),
(274,282,'user logout','2022-06-03 09:38:09','DESKTOP-SJ45L77','192.168.8.101','login'),
(275,277,'user login','2022-06-03 09:38:25','DESKTOP-SJ45L77','192.168.8.101','login'),
(276,277,'user logout','2022-06-03 10:08:34','DESKTOP-SJ45L77','192.168.8.101','login'),
(277,282,'user login','2022-06-03 10:08:43','DESKTOP-SJ45L77','192.168.8.101','login'),
(278,282,'user deposit','2022-06-03 10:09:06','DESKTOP-SJ45L77','192.168.8.101','deposit'),
(279,1,'approve deposit','2022-06-03 10:09:16','DESKTOP-SJ45L77','192.168.8.101','approve'),
(280,282,'user logout','2022-06-03 10:09:24','DESKTOP-SJ45L77','192.168.8.101','login'),
(281,277,'user login','2022-06-03 10:09:34','DESKTOP-SJ45L77','192.168.8.101','login'),
(282,277,'user logout','2022-06-03 10:35:45','DESKTOP-SJ45L77','192.168.8.101','login'),
(283,278,'user login','2022-06-03 10:35:59','DESKTOP-SJ45L77','192.168.8.101','login'),
(284,278,'user logout','2022-06-03 10:37:45','DESKTOP-SJ45L77','192.168.8.101','login'),
(285,276,'user login','2022-06-03 10:37:53','DESKTOP-SJ45L77','192.168.8.101','login'),
(286,276,'user logout','2022-06-03 10:51:57','DESKTOP-SJ45L77','192.168.8.101','login'),
(287,277,'user login','2022-06-03 10:52:05','DESKTOP-SJ45L77','192.168.8.101','login'),
(288,277,'user logout','2022-06-03 10:54:09','DESKTOP-SJ45L77','192.168.8.101','login'),
(289,278,'user login','2022-06-03 10:54:17','DESKTOP-SJ45L77','192.168.8.101','login'),
(290,278,'user logout','2022-06-03 11:05:50','DESKTOP-SJ45L77','192.168.8.101','login'),
(291,277,'user login','2022-06-03 11:10:17','DESKTOP-SJ45L77','192.168.8.101','login'),
(292,276,'user login','2022-06-19 03:39:37','dj','192.168.2.104','login'),
(293,276,'user logout','2022-06-19 03:39:49','dj','192.168.2.104','login'),
(294,276,'user login','2022-06-22 12:02:47','dj','192.168.8.100','login'),
(295,276,'user logout','2022-06-22 12:53:37','dj','192.168.8.100','login'),
(296,276,'user login','2022-06-22 12:57:44','dj','192.168.8.100','login'),
(297,276,'user deposit','2022-06-22 01:00:20','dj','192.168.8.100','deposit'),
(298,276,'user login','2022-11-12 11:12:22','dj','192.168.100.3','login'),
(299,276,'user order','2022-11-12 11:13:52','dj','192.168.100.3','created'),
(300,276,'user order confirm','2022-11-12 11:14:05','dj','192.168.100.3','created'),
(301,276,'user order','2022-11-12 11:14:26','dj','192.168.100.3','created'),
(302,276,'user order confirm','2022-11-12 11:14:38','dj','192.168.100.3','created'),
(303,276,'user order','2022-11-12 11:14:48','dj','192.168.100.3','created'),
(304,276,'user order confirm','2022-11-12 11:15:03','dj','192.168.100.3','created'),
(305,276,'user logout','2022-11-12 11:25:01','dj','192.168.100.3','login'),
(306,277,'user login','2022-11-12 11:25:19','dj','192.168.100.3','login'),
(307,277,'user order','2022-11-12 11:27:19','dj','192.168.100.3','created'),
(308,277,'user order confirm','2022-11-12 11:27:28','dj','192.168.100.3','created'),
(309,276,'user login','2022-11-12 11:28:34','dj','192.168.100.3','login'),
(310,277,'user order','2022-11-12 11:30:52','dj','192.168.100.3','created'),
(311,277,'user order confirm','2022-11-12 11:31:04','dj','192.168.100.3','created'),
(312,276,'user login','2023-06-10 12:31:14','dj','192.168.2.102','login'),
(313,276,'user login','2024-02-08 01:34:59','DESKTOP-24L4L3E','192.168.0.105','login'),
(314,283,'user signup','2024-02-08 01:38:09','DESKTOP-24L4L3E','192.168.0.105','signup'),
(315,283,'user login','2024-02-08 01:38:09','DESKTOP-24L4L3E','192.168.0.105','login'),
(316,283,'user tier level','2024-02-07 09:38:28','DESKTOP-24L4L3E','192.168.0.105','created'),
(317,283,'user tier level','2024-02-07 09:38:28','DESKTOP-24L4L3E','192.168.0.105','created'),
(318,283,'user tier level','2024-02-07 09:38:28','DESKTOP-24L4L3E','192.168.0.105','created'),
(319,283,'user tier level','2024-02-07 09:38:28','DESKTOP-24L4L3E','192.168.0.105','created'),
(320,283,'user deposit','2024-02-08 01:39:52','DESKTOP-24L4L3E','192.168.0.105','deposit'),
(321,283,'user deposit','2024-02-08 01:40:44','DESKTOP-24L4L3E','192.168.0.105','deposit'),
(322,283,'user deposit','2024-02-08 01:41:49','DESKTOP-24L4L3E','192.168.0.105','deposit'),
(323,283,'user logout','2024-02-08 01:42:32','DESKTOP-24L4L3E','192.168.0.105','login'),
(324,276,'user login','2024-02-08 01:42:40','DESKTOP-24L4L3E','192.168.0.105','login'),
(325,276,'user order','2024-02-08 01:44:39','DESKTOP-24L4L3E','192.168.0.105','created'),
(326,276,'user order confirm','2024-02-08 01:44:49','DESKTOP-24L4L3E','192.168.0.105','created'),
(327,276,'user order','2024-02-08 01:44:59','DESKTOP-24L4L3E','192.168.0.105','created'),
(328,276,'user order confirm','2024-02-08 01:45:09','DESKTOP-24L4L3E','192.168.0.105','created'),
(329,276,'user logout','2024-02-08 01:45:37','DESKTOP-24L4L3E','192.168.0.105','login'),
(330,283,'user login','2024-02-08 01:46:16','DESKTOP-24L4L3E','192.168.0.105','login'),
(331,283,'user deposit','2024-02-08 01:46:34','DESKTOP-24L4L3E','192.168.0.105','deposit'),
(332,283,'user deposit','2024-02-08 01:53:52','DESKTOP-24L4L3E','192.168.0.105','deposit'),
(333,283,'user logout','2024-02-08 01:55:06','DESKTOP-24L4L3E','192.168.0.105','login'),
(334,277,'user login','2024-02-08 01:55:21','DESKTOP-24L4L3E','192.168.0.105','login'),
(335,277,'user deposit','2024-02-08 01:55:51','DESKTOP-24L4L3E','192.168.0.105','deposit'),
(336,277,'user order','2024-02-08 01:56:27','DESKTOP-24L4L3E','192.168.0.105','created'),
(337,277,'user order confirm','2024-02-08 01:56:35','DESKTOP-24L4L3E','192.168.0.105','created'),
(338,277,'user logout','2024-02-08 01:56:49','DESKTOP-24L4L3E','192.168.0.105','login'),
(339,276,'user login','2024-02-08 01:56:53','DESKTOP-24L4L3E','192.168.0.105','login'),
(340,276,'user logout','2024-02-08 01:57:23','DESKTOP-24L4L3E','192.168.0.105','login'),
(341,277,'user login','2024-02-08 01:57:53','DESKTOP-24L4L3E','192.168.0.105','login'),
(342,276,'user login','2024-08-11 12:44:26','DESKTOP-24L4L3E','192.168.2.104','login'),
(343,276,'user deposit','2024-08-11 12:51:03','DESKTOP-24L4L3E','192.168.2.104','deposit'),
(344,276,'user deposit','2024-08-11 12:51:30','DESKTOP-24L4L3E','192.168.2.104','deposit'),
(345,1,'cp admin login','2024-08-11 12:56:18','DESKTOP-24L4L3E','192.168.2.104','login'),
(346,1,'approve deposit','2024-08-11 12:56:43','DESKTOP-24L4L3E','192.168.2.104','approve'),
(347,1,'approve deposit','2024-08-11 12:59:04','DESKTOP-24L4L3E','192.168.2.104','approve'),
(348,276,'user no of order','2024-08-11 12:59:19','DESKTOP-24L4L3E','192.168.2.104','created'),
(349,276,'user order','2024-08-11 12:59:22','DESKTOP-24L4L3E','192.168.2.104','created'),
(350,276,'user order confirm','2024-08-11 12:59:30','DESKTOP-24L4L3E','192.168.2.104','created'),
(351,276,'user order','2024-08-11 12:59:41','DESKTOP-24L4L3E','192.168.2.104','created'),
(352,276,'user order confirm','2024-08-11 12:59:49','DESKTOP-24L4L3E','192.168.2.104','created'),
(353,276,'user order','2024-08-11 01:00:48','DESKTOP-24L4L3E','192.168.2.104','created'),
(354,276,'user order confirm','2024-08-11 01:00:56','DESKTOP-24L4L3E','192.168.2.104','created'),
(355,276,'user order','2024-08-11 01:01:02','DESKTOP-24L4L3E','192.168.2.104','created'),
(356,276,'user order confirm','2024-08-11 01:01:09','DESKTOP-24L4L3E','192.168.2.104','created'),
(357,276,'user order','2024-08-11 01:01:12','DESKTOP-24L4L3E','192.168.2.104','created'),
(358,276,'user order confirm','2024-08-11 01:01:20','DESKTOP-24L4L3E','192.168.2.104','created'),
(359,276,'user logout','2024-08-11 01:05:28','DESKTOP-24L4L3E','192.168.2.104','login'),
(360,277,'user login','2024-08-11 01:05:47','DESKTOP-24L4L3E','192.168.2.104','login'),
(361,277,'user deposit','2024-08-11 01:06:09','DESKTOP-24L4L3E','192.168.2.104','deposit'),
(362,277,'user deposit','2024-08-11 01:06:40','DESKTOP-24L4L3E','192.168.2.104','deposit'),
(363,1,'approve deposit','2024-08-11 01:07:01','DESKTOP-24L4L3E','192.168.2.104','approve'),
(364,1,'approve deposit','2024-08-11 01:07:01','DESKTOP-24L4L3E','192.168.2.104','approve'),
(365,277,'user no of order','2024-08-11 01:07:28','DESKTOP-24L4L3E','192.168.2.104','created'),
(366,277,'user order','2024-08-11 01:07:35','DESKTOP-24L4L3E','192.168.2.104','created'),
(367,277,'user order confirm','2024-08-11 01:07:43','DESKTOP-24L4L3E','192.168.2.104','created'),
(368,277,'user order','2024-08-11 01:07:48','DESKTOP-24L4L3E','192.168.2.104','created'),
(369,277,'user order confirm','2024-08-11 01:07:55','DESKTOP-24L4L3E','192.168.2.104','created'),
(370,277,'user order','2024-08-11 01:07:59','DESKTOP-24L4L3E','192.168.2.104','created'),
(371,277,'user order confirm','2024-08-11 01:08:07','DESKTOP-24L4L3E','192.168.2.104','created'),
(372,277,'user order','2024-08-11 01:08:11','DESKTOP-24L4L3E','192.168.2.104','created'),
(373,277,'user order confirm','2024-08-11 01:08:20','DESKTOP-24L4L3E','192.168.2.104','created'),
(374,277,'user order','2024-08-11 01:08:22','DESKTOP-24L4L3E','192.168.2.104','created'),
(375,277,'user order confirm','2024-08-11 01:08:31','DESKTOP-24L4L3E','192.168.2.104','created'),
(376,277,'user logout','2024-08-11 01:08:53','DESKTOP-24L4L3E','192.168.2.104','login'),
(377,276,'user login','2024-08-11 01:09:12','DESKTOP-24L4L3E','192.168.2.104','login'),
(378,276,'user login','2024-08-14 09:28:17','d2.my-control-panel.com','192.168.168.2','login'),
(379,276,'user login','2024-08-15 09:59:58','d2.my-control-panel.com','192.168.168.2','login'),
(380,276,'user login','2024-08-16 09:06:36','d2.my-control-panel.com','192.168.168.2','login'),
(381,276,'user login','2024-08-16 09:06:37','d2.my-control-panel.com','192.168.168.2','login'),
(382,276,'user login','2024-08-16 10:23:29','d2.my-control-panel.com','192.168.168.2','login'),
(383,276,'user login','2024-08-16 12:25:17','d2.my-control-panel.com','192.168.168.2','login'),
(384,276,'user login','2024-08-16 03:09:49','d2.my-control-panel.com','192.168.168.2','login'),
(385,276,'user login','2024-08-16 05:19:46','d2.my-control-panel.com','192.168.168.2','login'),
(386,276,'user login','2024-08-16 11:38:09','d2.my-control-panel.com','192.168.168.2','login'),
(387,276,'user login','2024-08-16 11:38:10','d2.my-control-panel.com','192.168.168.2','login'),
(388,276,'user login','2024-08-17 09:58:23','d2.my-control-panel.com','192.168.168.2','login'),
(389,276,'user login','2024-08-17 05:10:33','d2.my-control-panel.com','192.168.168.2','login'),
(390,276,'user order','2024-08-17 05:11:21','d2.my-control-panel.com','192.168.168.2','created'),
(391,276,'user order confirm','2024-08-17 05:11:27','d2.my-control-panel.com','192.168.168.2','created'),
(392,276,'user order','2024-08-17 05:17:09','d2.my-control-panel.com','192.168.168.2','created'),
(393,276,'user order confirm','2024-08-17 05:17:19','d2.my-control-panel.com','192.168.168.2','created'),
(394,276,'user order','2024-08-17 05:17:30','d2.my-control-panel.com','192.168.168.2','created'),
(395,276,'user order confirm','2024-08-17 05:17:41','d2.my-control-panel.com','192.168.168.2','created'),
(396,276,'user order','2024-08-17 05:17:52','d2.my-control-panel.com','192.168.168.2','created'),
(397,276,'user order confirm','2024-08-17 05:18:03','d2.my-control-panel.com','192.168.168.2','created'),
(398,276,'user order','2024-08-17 05:22:41','d2.my-control-panel.com','192.168.168.2','created'),
(399,276,'user order confirm','2024-08-17 05:22:52','d2.my-control-panel.com','192.168.168.2','created'),
(400,284,'user signup','2024-08-17 05:44:17','d2.my-control-panel.com','192.168.168.2','signup'),
(401,284,'user login','2024-08-17 05:44:17','d2.my-control-panel.com','192.168.168.2','login'),
(402,284,'user login','2024-08-17 05:48:33','d2.my-control-panel.com','192.168.168.2','login'),
(403,284,'user login','2024-08-17 06:14:25','d2.my-control-panel.com','192.168.168.2','login'),
(404,276,'user login','2024-08-17 06:17:47','d2.my-control-panel.com','192.168.168.2','login'),
(405,276,'user login','2024-08-17 09:12:00','d2.my-control-panel.com','192.168.168.2','login'),
(406,276,'user login','2024-08-18 12:31:08','d2.my-control-panel.com','192.168.168.2','login'),
(407,276,'user order','2024-08-18 01:14:15','d2.my-control-panel.com','192.168.168.2','created'),
(408,276,'user order confirm','2024-08-18 01:14:25','d2.my-control-panel.com','192.168.168.2','created'),
(409,276,'user login','2024-08-18 02:43:00','d2.my-control-panel.com','192.168.168.2','login'),
(410,276,'user login','2024-08-18 10:09:58','d2.my-control-panel.com','192.168.168.2','login'),
(411,276,'user login','2024-08-20 09:21:58','d2.my-control-panel.com','192.168.168.2','login'),
(412,276,'user order','2024-08-20 09:22:58','d2.my-control-panel.com','192.168.168.2','created'),
(413,276,'user login','2024-08-25 01:43:03','d2.my-control-panel.com','192.168.168.2','login'),
(414,276,'user login','2024-08-25 07:15:46','d2.my-control-panel.com','192.168.168.2','login'),
(415,276,'user login','2024-08-26 04:16:07','d2.my-control-panel.com','192.168.168.2','login'),
(416,276,'user login','2024-08-26 04:25:01','d2.my-control-panel.com','192.168.168.2','login'),
(417,276,'user login','2024-08-27 10:31:07','d2.my-control-panel.com','192.168.168.2','login'),
(418,276,'user login','2024-08-27 11:46:53','Kashan','192.168.14.104','login'),
(419,276,'user order','2024-08-27 12:00:58','Kashan','192.168.14.104','created'),
(420,276,'user order confirm','2024-08-27 12:01:10','Kashan','192.168.14.104','created'),
(421,276,'user no of order','2024-08-27 12:03:37','Kashan','192.168.14.104','created'),
(422,276,'user order','2024-08-27 12:03:39','Kashan','192.168.14.104','created'),
(423,276,'user order confirm','2024-08-27 12:03:47','Kashan','192.168.14.104','created'),
(424,276,'user no of order','2024-08-27 12:06:34','Kashan','192.168.14.104','created'),
(425,276,'user order','2024-08-27 12:06:38','Kashan','192.168.14.104','created'),
(426,276,'user order confirm','2024-08-27 12:06:52','Kashan','192.168.14.104','created'),
(427,276,'user no of order','2024-08-27 12:19:21','Kashan','192.168.14.104','created'),
(428,276,'user no of order','2024-08-27 12:20:23','Kashan','192.168.14.104','created'),
(429,276,'user no of order','2024-08-27 12:21:58','Kashan','192.168.14.104','created'),
(430,276,'user no of order','2024-08-27 12:24:14','Kashan','192.168.14.104','created'),
(431,276,'user no of order','2024-08-27 12:24:54','Kashan','192.168.14.104','created'),
(432,276,'user order','2024-08-27 01:02:36','Kashan','192.168.14.104','created'),
(433,276,'user order confirm','2024-08-27 01:02:44','Kashan','192.168.14.104','created'),
(434,276,'user order','2024-08-27 01:02:52','Kashan','192.168.14.104','created'),
(435,276,'user order confirm','2024-08-27 01:03:00','Kashan','192.168.14.104','created'),
(436,276,'user order','2024-08-27 01:05:22','Kashan','192.168.14.104','created'),
(437,276,'user order','2024-08-27 01:06:23','Kashan','192.168.14.104','created'),
(438,276,'user order confirm','2024-08-27 01:06:30','Kashan','192.168.14.104','created'),
(439,276,'user order','2024-08-27 01:06:36','Kashan','192.168.14.104','created'),
(440,276,'user order confirm','2024-08-27 01:06:43','Kashan','192.168.14.104','created'),
(441,276,'user order','2024-08-27 01:07:43','Kashan','192.168.14.104','created'),
(442,276,'user order confirm','2024-08-27 01:07:50','Kashan','192.168.14.104','created'),
(443,276,'user order','2024-08-27 01:07:55','Kashan','192.168.14.104','created'),
(444,276,'user order cancel','2024-08-27 01:08:03','Kashan','192.168.14.104','created'),
(445,276,'user order','2024-08-27 03:00:58','Kashan','192.168.14.104','created'),
(446,276,'user order confirm','2024-08-27 03:01:11','Kashan','192.168.14.104','created'),
(447,276,'user order','2024-08-27 03:04:35','Kashan','192.168.14.104','created'),
(448,276,'user order','2024-08-27 03:14:02','Kashan','192.168.14.104','created'),
(449,276,'user order','2024-08-27 03:14:44','Kashan','192.168.14.104','created'),
(450,276,'user order','2024-08-27 03:20:22','Kashan','192.168.14.104','created'),
(451,276,'user order','2024-08-27 03:22:32','Kashan','192.168.14.104','created'),
(452,276,'user order','2024-08-27 03:24:30','Kashan','192.168.14.104','created'),
(453,276,'user order','2024-08-27 03:26:11','Kashan','192.168.14.104','created'),
(454,276,'user order','2024-08-27 03:28:50','Kashan','192.168.14.104','created'),
(455,276,'user order confirm','2024-08-27 03:29:05','Kashan','192.168.14.104','created'),
(456,276,'user order','2024-08-27 03:29:12','Kashan','192.168.14.104','created'),
(457,276,'user order confirm','2024-08-27 03:29:20','Kashan','192.168.14.104','created'),
(458,276,'user order','2024-08-27 03:29:22','Kashan','192.168.14.104','created'),
(459,276,'user order confirm','2024-08-27 03:29:37','Kashan','192.168.14.104','created'),
(460,276,'user order','2024-08-27 03:30:10','Kashan','192.168.14.104','created'),
(461,276,'user order confirm','2024-08-27 03:30:18','Kashan','192.168.14.104','created'),
(462,276,'user order','2024-08-27 03:31:47','Kashan','192.168.14.104','created'),
(463,276,'user order confirm','2024-08-27 03:31:55','Kashan','192.168.14.104','created'),
(464,276,'user order','2024-08-27 03:31:56','Kashan','192.168.14.104','created'),
(465,276,'user order confirm','2024-08-27 03:32:09','Kashan','192.168.14.104','created'),
(466,276,'user order','2024-08-27 03:32:10','Kashan','192.168.14.104','created'),
(467,276,'user order confirm','2024-08-27 03:32:22','Kashan','192.168.14.104','created'),
(468,276,'user order','2024-08-27 03:32:24','Kashan','192.168.14.104','created'),
(469,276,'user order confirm','2024-08-27 03:32:31','Kashan','192.168.14.104','created'),
(470,276,'user order','2024-08-27 03:32:33','Kashan','192.168.14.104','created'),
(471,276,'user order cancel','2024-08-27 03:32:50','Kashan','192.168.14.104','created'),
(472,276,'user order','2024-08-27 03:33:02','Kashan','192.168.14.104','created'),
(473,276,'user order confirm','2024-08-27 03:33:23','Kashan','192.168.14.104','created'),
(474,276,'user order','2024-08-27 03:33:41','Kashan','192.168.14.104','created'),
(475,276,'user order confirm','2024-08-27 03:33:53','Kashan','192.168.14.104','created'),
(476,276,'user order','2024-08-27 03:34:13','Kashan','192.168.14.104','created'),
(477,276,'user order confirm','2024-08-27 03:34:29','Kashan','192.168.14.104','created'),
(478,276,'user order','2024-08-27 03:34:42','Kashan','192.168.14.104','created'),
(479,276,'user order confirm','2024-08-27 03:34:53','Kashan','192.168.14.104','created'),
(480,276,'user logout','2024-08-27 04:27:20','Kashan','192.168.14.104','login'),
(481,284,'user login','2024-08-27 04:27:36','Kashan','192.168.14.104','login'),
(482,284,'user logout','2024-08-27 04:27:52','Kashan','192.168.14.104','login'),
(483,277,'user login','2024-08-27 04:28:02','Kashan','192.168.14.104','login'),
(484,277,'user no of order','2024-08-27 04:29:30','Kashan','192.168.14.104','created'),
(485,277,'user order','2024-08-27 04:29:34','Kashan','192.168.14.104','created'),
(486,277,'user order confirm','2024-08-27 04:29:42','Kashan','192.168.14.104','created'),
(487,277,'user order','2024-08-27 04:30:21','Kashan','192.168.14.104','created'),
(488,277,'user order confirm','2024-08-27 04:30:29','Kashan','192.168.14.104','created'),
(489,277,'user logout','2024-08-27 04:30:37','Kashan','192.168.14.104','login'),
(490,276,'user login','2024-08-27 04:30:52','Kashan','192.168.14.104','login'),
(491,276,'user logout','2024-08-27 04:44:08','Kashan','192.168.14.104','login'),
(492,276,'user login','2024-08-27 04:44:39','Kashan','192.168.14.104','login'),
(493,277,'user login','2024-08-27 04:44:59','Kashan','192.168.14.104','login'),
(494,277,'user order','2024-08-27 04:45:19','Kashan','192.168.14.104','created'),
(495,277,'user order confirm','2024-08-27 04:45:50','Kashan','192.168.14.104','created'),
(496,277,'user order','2024-08-27 04:53:43','Kashan','192.168.14.104','created'),
(497,277,'user order confirm','2024-08-27 04:53:51','Kashan','192.168.14.104','created'),
(498,277,'user order','2024-08-27 05:13:02','Kashan','192.168.14.104','created'),
(499,277,'user order confirm','2024-08-27 05:13:17','Kashan','192.168.14.104','created'),
(500,277,'user order','2024-08-27 05:14:27','Kashan','192.168.14.104','created'),
(501,277,'user order confirm','2024-08-27 05:14:35','Kashan','192.168.14.104','created'),
(502,277,'user order','2024-08-27 05:14:41','Kashan','192.168.14.104','created'),
(503,277,'user order confirm','2024-08-27 05:14:48','Kashan','192.168.14.104','created'),
(504,276,'user login','2024-08-28 11:54:03','Kashan','192.168.47.62','login'),
(505,277,'user login','2024-08-28 02:28:09','Kashan','192.168.14.104','login'),
(506,277,'user order','2024-08-28 02:29:33','Kashan','192.168.14.104','created'),
(507,277,'user order confirm','2024-08-28 02:29:48','Kashan','192.168.14.104','created'),
(508,277,'user order','2024-08-28 02:29:54','Kashan','192.168.14.104','created'),
(509,277,'user order confirm','2024-08-28 02:30:05','Kashan','192.168.14.104','created'),
(510,277,'user order','2024-08-28 02:30:14','Kashan','192.168.14.104','created'),
(511,277,'user order confirm','2024-08-28 02:30:22','Kashan','192.168.14.104','created'),
(512,277,'user order','2024-08-28 02:56:36','Kashan','192.168.14.104','created'),
(513,277,'user order confirm','2024-08-28 02:56:45','Kashan','192.168.14.104','created'),
(514,277,'user order','2024-08-28 02:57:15','Kashan','192.168.14.104','created'),
(515,277,'user order confirm','2024-08-28 02:57:22','Kashan','192.168.14.104','created'),
(516,277,'user order','2024-08-28 02:57:26','Kashan','192.168.14.104','created'),
(517,277,'user order confirm','2024-08-28 02:57:33','Kashan','192.168.14.104','created'),
(518,277,'user order','2024-08-28 02:57:42','Kashan','192.168.14.104','created'),
(519,277,'user order confirm','2024-08-28 02:57:51','Kashan','192.168.14.104','created'),
(520,277,'user order','2024-08-28 02:57:55','Kashan','192.168.14.104','created'),
(521,277,'user order confirm','2024-08-28 02:58:06','Kashan','192.168.14.104','created'),
(522,277,'user order','2024-08-28 02:58:09','Kashan','192.168.14.104','created'),
(523,277,'user order confirm','2024-08-28 02:58:17','Kashan','192.168.14.104','created'),
(524,277,'user order','2024-08-28 02:58:21','Kashan','192.168.14.104','created'),
(525,277,'user order confirm','2024-08-28 02:58:28','Kashan','192.168.14.104','created'),
(526,277,'user order','2024-08-28 02:59:06','Kashan','192.168.14.104','created'),
(527,277,'user order confirm','2024-08-28 02:59:16','Kashan','192.168.14.104','created'),
(528,277,'user order','2024-08-28 02:59:21','Kashan','192.168.14.104','created'),
(529,277,'user order confirm','2024-08-28 02:59:28','Kashan','192.168.14.104','created'),
(530,277,'user order','2024-08-28 02:59:32','Kashan','192.168.14.104','created'),
(531,277,'user order confirm','2024-08-28 02:59:41','Kashan','192.168.14.104','created'),
(532,277,'user order','2024-08-28 03:00:46','Kashan','192.168.14.104','created'),
(533,277,'user order confirm','2024-08-28 03:00:55','Kashan','192.168.14.104','created'),
(534,277,'user order','2024-08-28 03:01:19','Kashan','192.168.14.104','created'),
(535,277,'user order confirm','2024-08-28 03:01:26','Kashan','192.168.14.104','created'),
(536,277,'user order','2024-08-28 03:17:21','Kashan','192.168.14.104','created'),
(537,277,'user order confirm','2024-08-28 03:17:28','Kashan','192.168.14.104','created'),
(538,277,'user order','2024-08-28 03:17:45','Kashan','192.168.14.104','created'),
(539,277,'user order confirm','2024-08-28 03:17:53','Kashan','192.168.14.104','created'),
(540,277,'user order','2024-08-28 03:17:56','Kashan','192.168.14.104','created'),
(541,277,'user order confirm','2024-08-28 03:18:04','Kashan','192.168.14.104','created'),
(542,277,'user order','2024-08-28 03:18:09','Kashan','192.168.14.104','created'),
(543,277,'user order confirm','2024-08-28 03:18:17','Kashan','192.168.14.104','created'),
(544,277,'user order','2024-08-28 03:18:20','Kashan','192.168.14.104','created'),
(545,277,'user order confirm','2024-08-28 03:18:27','Kashan','192.168.14.104','created'),
(546,276,'user order','2024-08-28 04:13:24','Kashan','192.168.14.104','created'),
(547,276,'user order confirm','2024-08-28 04:13:32','Kashan','192.168.14.104','created'),
(548,1,'cp admin login','2024-08-28 04:50:29','Kashan','192.168.14.104','login'),
(549,1,'cp admin login','2024-08-29 11:07:33','Kashan','192.168.10.184','login'),
(550,276,'user login','2024-08-29 12:06:42','Kashan','192.168.10.184','login'),
(551,276,'user no of order','2024-08-29 12:06:50','Kashan','192.168.10.184','created'),
(552,1,'add wallet address','2024-08-29 12:10:01','Kashan','192.168.10.184','created'),
(553,1,'update wallet address','2024-08-29 12:12:04','Kashan','192.168.10.184','approve'),
(554,1,'update wallet address','2024-08-29 12:17:22','Kashan','192.168.10.184','approve'),
(555,1,'update wallet address','2024-08-29 12:22:57','Kashan','192.168.10.184','approve'),
(556,1,'update wallet address','2024-08-29 12:23:21','Kashan','192.168.10.184','approve'),
(557,1,'update wallet address','2024-08-29 12:39:06','Kashan','192.168.10.184','active'),
(558,1,'cp admin login','2024-08-30 10:36:34','Kashan','192.168.2.124','login'),
(559,276,'user login','2024-08-30 10:38:35','Kashan','192.168.2.124','login'),
(560,276,'user deposit','2024-08-30 11:39:29','Kashan','192.168.2.124','deposit');

/*Table structure for table `user_assign_level` */

DROP TABLE IF EXISTS `user_assign_level`;

CREATE TABLE `user_assign_level` (
  `uslvid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `ulvid` int(11) NOT NULL,
  `refid` int(11) DEFAULT NULL,
  `retid` int(11) DEFAULT NULL,
  `refcode` varchar(6) DEFAULT NULL,
  `retcode` varchar(6) DEFAULT NULL,
  `levelfrom` int(11) DEFAULT NULL,
  `levelto` int(11) NOT NULL,
  `createdate` datetime DEFAULT NULL,
  PRIMARY KEY (`uslvid`),
  KEY `uid` (`uid`),
  KEY `refid` (`refid`),
  KEY `ulvid` (`ulvid`),
  KEY `retid` (`retid`),
  CONSTRAINT `user_assign_level_ibfk_1` FOREIGN KEY (`refid`) REFERENCES `user_invitation_code` (`invcid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_assign_level_ibfk_2` FOREIGN KEY (`ulvid`) REFERENCES `user_level` (`ulvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_assign_level_ibfk_3` FOREIGN KEY (`retid`) REFERENCES `user_invitation_code` (`invcid`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_assign_level` */

insert  into `user_assign_level`(`uslvid`,`uid`,`ulvid`,`refid`,`retid`,`refcode`,`retcode`,`levelfrom`,`levelto`,`createdate`) values 
(1,277,1,223,224,'0Q8xKZ','VkrcR3',1,1,'2022-06-01 11:30:15'),
(2,278,2,224,225,'0Q8xKZ','2uOdGc',1,2,'2022-06-01 11:33:58'),
(3,278,2,224,225,'VkrcR3','2uOdGc',2,1,'2022-06-01 11:33:58'),
(6,280,2,225,227,'VkrcR3','BNIpV9',2,2,'2022-06-03 08:14:39'),
(7,280,3,225,227,'2uOdGc','BNIpV9',3,1,'2022-06-03 08:14:39'),
(8,282,3,224,228,'0Q8xKZ','WC7qdE',1,3,'2022-06-03 09:32:47'),
(9,282,3,224,228,'VkrcR3','WC7qdE',2,1,'2022-06-03 09:32:47'),
(10,283,1,223,229,'0Q8xKZ','8Fbq1n',1,1,'2024-02-08 01:38:09'),
(11,284,1,223,230,'0Q8xKZ','XLTbZI',1,1,'2024-08-17 05:44:17');

/*Table structure for table `user_attempt_invitation_code` */

DROP TABLE IF EXISTS `user_attempt_invitation_code`;

CREATE TABLE `user_attempt_invitation_code` (
  `atinvcid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `invcid` int(11) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  `used` int(11) DEFAULT NULL,
  `remain` int(11) DEFAULT NULL,
  `attemptdate` datetime DEFAULT NULL,
  `isused` tinyint(1) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`atinvcid`),
  KEY `invcid` (`invcid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_attempt_invitation_code_ibfk_1` FOREIGN KEY (`invcid`) REFERENCES `user_invitation_code` (`invcid`),
  CONSTRAINT `user_attempt_invitation_code_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_attempt_invitation_code` */

insert  into `user_attempt_invitation_code`(`atinvcid`,`uid`,`invcid`,`limit`,`used`,`remain`,`attemptdate`,`isused`,`status`) values 
(3,277,223,NULL,NULL,NULL,'2022-06-01 11:30:15',1,'attempted'),
(4,278,224,NULL,NULL,NULL,'2022-06-01 11:33:58',1,'attempted'),
(6,280,225,NULL,NULL,NULL,'2022-06-03 08:14:39',1,'attempted'),
(7,282,224,NULL,NULL,NULL,'2022-06-03 09:32:47',1,'attempted'),
(8,283,223,NULL,NULL,NULL,'2024-02-08 01:38:09',1,'attempted'),
(9,284,223,NULL,NULL,NULL,'2024-08-17 05:44:17',1,'attempted');

/*Table structure for table `user_attempt_passcode` */

DROP TABLE IF EXISTS `user_attempt_passcode`;

CREATE TABLE `user_attempt_passcode` (
  `atpid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tpid` int(11) DEFAULT NULL,
  `attemptdate` datetime DEFAULT NULL,
  `isattempt` tinyint(4) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`atpid`),
  KEY `uid` (`uid`),
  KEY `tpid` (`tpid`),
  CONSTRAINT `user_attempt_passcode_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `user_attempt_passcode_ibfk_2` FOREIGN KEY (`tpid`) REFERENCES `user_transaction_passcode` (`tpid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_attempt_passcode` */

/*Table structure for table `user_commission` */

DROP TABLE IF EXISTS `user_commission`;

CREATE TABLE `user_commission` (
  `ucid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tlvid` int(11) DEFAULT NULL,
  `invcid` int(11) DEFAULT NULL,
  `refcode` varchar(6) DEFAULT NULL,
  `nod` int(11) DEFAULT NULL,
  `tc` double DEFAULT NULL,
  `pc` double DEFAULT NULL,
  `ucomm` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `iscancel` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ucid`),
  KEY `uid` (`uid`),
  KEY `invcid` (`invcid`),
  KEY `user_commission_ibfk_2` (`tlvid`),
  CONSTRAINT `user_commission_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_commission_ibfk_2` FOREIGN KEY (`tlvid`) REFERENCES `user_tier_level` (`utlvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_commission_ibfk_4` FOREIGN KEY (`invcid`) REFERENCES `user_invitation_code` (`invcid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_commission` */

insert  into `user_commission`(`ucid`,`uid`,`tlvid`,`invcid`,`refcode`,`nod`,`tc`,`pc`,`ucomm`,`createdate`,`iscancel`) values 
(26,276,53,223,'0Q8xKZ',1,0.1,0.001,0.1,'2024-08-27 03:29:05',0),
(27,276,53,223,'0Q8xKZ',2,0.1,0.001,0.2,'2024-08-27 03:29:20',0),
(28,276,53,223,'0Q8xKZ',3,0.1,0.001,0.3,'2024-08-27 03:29:37',0),
(29,276,53,223,'0Q8xKZ',4,0.1,0.001,0.4,'2024-08-27 03:30:18',0),
(30,276,53,223,'0Q8xKZ',5,0.1,0.001,0.5,'2024-08-27 03:31:55',0),
(31,276,53,223,'0Q8xKZ',6,0.1,0.001,0.6,'2024-08-27 03:32:09',0),
(32,276,53,223,'0Q8xKZ',7,0.1,0.001,0.7,'2024-08-27 03:32:22',0),
(33,276,53,223,'0Q8xKZ',8,0.1,0.001,0.8,'2024-08-27 03:32:31',0),
(34,276,53,223,'0Q8xKZ',9,0.1,0.001,0.9,'2024-08-27 03:33:23',0),
(35,276,53,223,'0Q8xKZ',10,0.1,0.001,1,'2024-08-27 03:33:53',0),
(36,276,53,223,'0Q8xKZ',11,0.1,0.001,1.1,'2024-08-27 03:34:29',0),
(37,276,53,223,'0Q8xKZ',12,0.1,0.001,1.2,'2024-08-27 03:34:53',0),
(38,277,57,224,'VkrcR3',1,0.1,0.001,0.1,'2024-08-27 04:29:42',0),
(39,277,57,224,'VkrcR3',2,0.1,0.001,0.2,'2024-08-27 04:30:29',0),
(40,277,57,224,'VkrcR3',3,0.1,0.001,0.3,'2024-08-27 04:45:50',0),
(41,277,57,224,'VkrcR3',4,0.1,0.001,0.4,'2024-08-27 04:53:51',0),
(42,277,57,224,'VkrcR3',5,0.1,0.001,0.5,'2024-08-27 05:13:17',0),
(43,277,57,224,'VkrcR3',6,0.1,0.001,0.6,'2024-08-27 05:14:35',0),
(44,277,57,224,'VkrcR3',7,0.1,0.001,0.7,'2024-08-27 05:14:48',0),
(45,277,57,224,'VkrcR3',8,0.1,0.001,0.1,'2024-08-28 02:29:48',0),
(46,277,57,224,'VkrcR3',9,0.1,0.001,0.2,'2024-08-28 02:30:05',0),
(47,277,57,224,'VkrcR3',10,0.1,0.001,0.3,'2024-08-28 02:30:22',0),
(48,277,57,224,'VkrcR3',11,0.1,0.001,0.4,'2024-08-28 02:56:45',0),
(49,277,57,224,'VkrcR3',12,0.1,0.001,0.5,'2024-08-28 02:57:22',0),
(50,277,57,224,'VkrcR3',13,0.1,0.001,0.6,'2024-08-28 02:57:33',0),
(51,277,57,224,'VkrcR3',14,0.1,0.001,0.7,'2024-08-28 02:57:51',0),
(52,277,57,224,'VkrcR3',15,0.1,0.001,0.8,'2024-08-28 02:58:06',0),
(53,277,57,224,'VkrcR3',16,0.1,0.001,0.9,'2024-08-28 02:58:17',0),
(54,277,57,224,'VkrcR3',17,0.1,0.001,1,'2024-08-28 02:58:28',0),
(55,277,57,224,'VkrcR3',18,0.1,0.001,1.1,'2024-08-28 02:59:16',0),
(56,277,57,224,'VkrcR3',19,0.1,0.001,1.2,'2024-08-28 02:59:28',0),
(57,277,57,224,'VkrcR3',20,0.1,0.001,1.3,'2024-08-28 02:59:41',0),
(58,277,57,224,'VkrcR3',21,0.1,0.001,1.4,'2024-08-28 03:00:55',0),
(59,277,57,224,'VkrcR3',22,0.1,0.001,1.5,'2024-08-28 03:01:26',0),
(60,277,57,224,'VkrcR3',23,0.1,0.001,1.6,'2024-08-28 03:17:28',0),
(61,277,57,224,'VkrcR3',24,0.1,0.001,1.7,'2024-08-28 03:17:53',0),
(62,277,57,224,'VkrcR3',25,0.1,0.001,1.8,'2024-08-28 03:18:04',0),
(63,277,57,224,'VkrcR3',26,0.1,0.001,1.9,'2024-08-28 03:18:17',0),
(64,277,57,224,'VkrcR3',27,0.1,0.001,2,'2024-08-28 03:18:27',0),
(65,276,53,223,'0Q8xKZ',13,0.1,0.001,0.1,'2024-08-28 04:13:32',0);

/*Table structure for table `user_company` */

DROP TABLE IF EXISTS `user_company`;

CREATE TABLE `user_company` (
  `ucid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `selected` varchar(50) NOT NULL,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL,
  `createby` varchar(20) NOT NULL,
  `updateby` varchar(20) NOT NULL,
  `assignby` varchar(20) NOT NULL,
  `isedit` tinyint(1) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ucid`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  CONSTRAINT `user_company_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `user_company_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `user_company_ibfk_3` FOREIGN KEY (`cid`) REFERENCES `company` (`cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_company` */

/*Table structure for table `user_invitation_code` */

DROP TABLE IF EXISTS `user_invitation_code`;

CREATE TABLE `user_invitation_code` (
  `invcid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `invcode` varchar(6) DEFAULT NULL,
  `tlimit` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`invcid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_invitation_code_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_invitation_code` */

insert  into `user_invitation_code`(`invcid`,`uid`,`invcode`,`tlimit`,`level`,`createdate`,`status`) values 
(1,NULL,'ddagm8',NULL,NULL,'2022-04-15 20:08:42','default'),
(223,276,'0Q8xKZ',NULL,1,'2022-06-01 11:28:27','new'),
(224,277,'VkrcR3',NULL,2,'2022-06-01 11:30:15','new'),
(225,278,'2uOdGc',NULL,3,'2022-06-01 11:33:58','new'),
(227,280,'BNIpV9',NULL,1,'2022-06-03 08:14:39','new'),
(228,282,'WC7qdE',NULL,1,'2022-06-03 09:32:47','new'),
(229,283,'8Fbq1n',NULL,1,'2024-02-08 01:38:09','new'),
(230,284,'XLTbZI',NULL,1,'2024-08-17 05:44:17','new');

/*Table structure for table `user_invitation_code_activity` */

DROP TABLE IF EXISTS `user_invitation_code_activity`;

CREATE TABLE `user_invitation_code_activity` (
  `invcacid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `invcid` int(11) DEFAULT NULL,
  `limit` int(11) DEFAULT NULL,
  `activitydate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`invcacid`),
  KEY `uid` (`uid`),
  KEY `invcid` (`invcid`),
  CONSTRAINT `user_invitation_code_activity_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `user_invitation_code_activity_ibfk_2` FOREIGN KEY (`invcid`) REFERENCES `user_invitation_code` (`invcid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_invitation_code_activity` */

insert  into `user_invitation_code_activity`(`invcacid`,`uid`,`invcid`,`limit`,`activitydate`,`device`,`ip`,`status`) values 
(3,277,223,NULL,'2022-06-01 11:30:15','dj','192.168.8.102','attempted'),
(4,278,224,NULL,'2022-06-01 11:33:58','dj','192.168.8.102','attempted'),
(6,280,225,NULL,'2022-06-03 08:14:39','DESKTOP-SJ45L77','192.168.8.101','attempted'),
(7,282,224,NULL,'2022-06-03 09:32:47','DESKTOP-SJ45L77','192.168.8.101','attempted'),
(8,283,223,NULL,'2024-02-08 01:38:09','DESKTOP-24L4L3E','192.168.0.105','attempted'),
(9,284,223,NULL,'2024-08-17 05:44:17','d2.my-control-panel.com','192.168.168.2','attempted');

/*Table structure for table `user_level` */

DROP TABLE IF EXISTS `user_level`;

CREATE TABLE `user_level` (
  `ulvid` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  PRIMARY KEY (`ulvid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_level` */

insert  into `user_level`(`ulvid`,`level`,`createdate`) values 
(1,1,'2022-05-25 17:27:33'),
(2,2,'2022-05-25 17:27:33'),
(3,3,'2022-05-25 17:27:33');

/*Table structure for table `user_login` */

DROP TABLE IF EXISTS `user_login`;

CREATE TABLE `user_login` (
  `ulid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `loginid` varchar(20) DEFAULT NULL,
  `logindate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `islogin` tinyint(1) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`ulid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_login_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `user_login_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_login` */

insert  into `user_login`(`ulid`,`uid`,`remarks`,`loginid`,`logindate`,`device`,`ip`,`islogin`,`status`) values 
(0,276,'user login','loginid=Mjc2','2022-06-14 02:42:05','dj','192.168.2.103',1,'login'),
(3,276,'user login','loginid=Mjc2','2022-06-01 11:28:27','dj','192.168.8.102',1,'login'),
(4,276,'user logout','loginid=Mjc2','2022-06-01 11:28:49','dj','192.168.8.102',0,'logout'),
(5,277,'user login','loginid=Mjc3','2022-06-01 11:30:15','dj','192.168.8.102',1,'login'),
(6,277,'user logout','loginid=Mjc3','2022-06-01 11:31:05','dj','192.168.8.102',0,'logout'),
(7,276,'user login','loginid=Mjc2','2022-06-01 11:31:15','dj','192.168.8.102',1,'login'),
(8,276,'user logout','loginid=Mjc2','2022-06-01 11:31:49','dj','192.168.8.102',0,'logout'),
(9,278,'user login','loginid=Mjc4','2022-06-01 11:33:58','dj','192.168.8.102',1,'login'),
(10,278,'user logout','loginid=Mjc4','2022-06-01 12:09:00','dj','192.168.8.102',0,'logout'),
(11,276,'user login','loginid=Mjc2','2022-06-01 12:12:57','dj','192.168.8.102',1,'login'),
(12,1,'cp admin login',NULL,'2022-06-01 12:17:07','dj','192.168.8.102',1,'login'),
(13,1,'cp admin logout',NULL,'2022-06-01 12:17:15','dj','192.168.8.102',0,'logout'),
(14,1,'cp admin login',NULL,'2022-06-01 12:17:47','dj','192.168.8.102',1,'login'),
(15,276,'user logout','loginid=Mjc2','2022-06-01 12:39:31','dj','192.168.8.102',0,'logout'),
(16,277,'user login','loginid=Mjc3','2022-06-01 12:40:12','dj','192.168.8.102',1,'login'),
(17,277,'user logout','loginid=Mjc3','2022-06-01 12:44:09','dj','192.168.8.102',0,'logout'),
(18,276,'user login','loginid=Mjc2','2022-06-01 12:44:20','dj','192.168.8.102',1,'login'),
(19,276,'user logout','loginid=Mjc2','2022-06-01 12:53:13','dj','192.168.8.102',0,'logout'),
(20,277,'user login','loginid=Mjc3','2022-06-01 12:53:56','dj','192.168.8.102',1,'login'),
(21,277,'user logout','loginid=Mjc3','2022-06-01 12:54:39','dj','192.168.8.102',0,'logout'),
(22,278,'user login','loginid=Mjc4','2022-06-01 12:55:02','dj','192.168.8.102',1,'login'),
(23,278,'user logout','loginid=Mjc4','2022-06-01 12:56:06','dj','192.168.8.102',0,'logout'),
(24,277,'user login','loginid=Mjc3','2022-06-01 12:56:16','dj','192.168.8.102',1,'login'),
(25,277,'user logout','loginid=Mjc3','2022-06-01 12:57:23','dj','192.168.8.102',0,'logout'),
(26,276,'user login','loginid=Mjc2','2022-06-01 12:57:33','dj','192.168.8.102',1,'login'),
(27,276,'user logout','loginid=Mjc2','2022-06-01 12:59:53','dj','192.168.8.102',0,'logout'),
(28,277,'user login','loginid=Mjc3','2022-06-01 01:00:16','dj','192.168.8.102',1,'login'),
(29,276,'user login','loginid=Mjc2','2022-06-01 01:46:51','dj','192.168.8.102',1,'login'),
(30,276,'user login','loginid=Mjc2','2022-06-01 04:13:48','dj','192.168.8.102',1,'login'),
(31,276,'user login','loginid=Mjc2','2022-06-01 05:59:22','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(32,1,'cp admin login',NULL,'2022-06-01 06:49:57','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(33,276,'user login','loginid=Mjc2','2022-06-01 11:48:06','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(34,276,'user logout','loginid=Mjc2','2022-06-02 12:03:07','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(35,276,'user login','loginid=Mjc2','2022-06-02 12:03:16','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(36,276,'user logout','loginid=Mjc2','2022-06-02 12:03:21','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(37,277,'user login','loginid=Mjc3','2022-06-02 12:03:32','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(38,277,'user logout','loginid=Mjc3','2022-06-02 12:03:40','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(39,276,'user login','loginid=Mjc2','2022-06-02 12:03:48','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(40,276,'user logout','loginid=Mjc2','2022-06-02 01:32:45','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(41,276,'user login','loginid=Mjc2','2022-06-02 05:45:16','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(42,1,'cp admin login',NULL,'2022-06-02 06:26:10','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(43,276,'user login','loginid=Mjc2','2022-06-02 08:20:24','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(44,276,'user logout','loginid=Mjc2','2022-06-02 08:20:40','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(45,276,'user login','loginid=Mjc2','2022-06-02 08:25:03','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(46,276,'user logout','loginid=Mjc2','2022-06-02 08:28:18','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(47,276,'user login','loginid=Mjc2','2022-06-02 08:35:29','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(48,276,'user logout','loginid=Mjc2','2022-06-02 08:35:32','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(49,276,'user login','loginid=Mjc2','2022-06-02 08:35:50','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(50,276,'user logout','loginid=Mjc2','2022-06-02 08:35:53','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(51,1,'cp admin logout',NULL,'2022-06-02 08:49:43','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(52,1,'cp admin login',NULL,'2022-06-02 08:53:14','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(53,276,'user login','loginid=Mjc2','2022-06-02 08:55:29','DESKTOP-SJ45L77','192.168.88.10',1,'login'),
(54,276,'user logout','loginid=Mjc2','2022-06-03 12:35:25','DESKTOP-SJ45L77','192.168.88.10',0,'logout'),
(55,276,'user login','loginid=Mjc2','2022-06-03 01:13:18','host.sofxol.com','104.193.108.203',1,'login'),
(56,276,'user logout','loginid=Mjc2','2022-06-03 01:14:23','host.sofxol.com','104.193.108.203',0,'logout'),
(57,277,'user login','loginid=Mjc3','2022-06-03 01:14:30','host.sofxol.com','104.193.108.203',1,'login'),
(58,277,'user logout','loginid=Mjc3','2022-06-03 01:21:00','host.sofxol.com','104.193.108.203',0,'logout'),
(59,277,'user login','loginid=Mjc3','2022-06-03 01:21:22','host.sofxol.com','104.193.108.203',1,'login'),
(60,277,'user logout','loginid=Mjc3','2022-06-03 01:39:46','host.sofxol.com','104.193.108.203',0,'logout'),
(61,277,'user login','loginid=Mjc3','2022-06-03 01:40:31','host.sofxol.com','104.193.108.203',1,'login'),
(62,277,'user logout','loginid=Mjc3','2022-06-03 01:41:01','host.sofxol.com','104.193.108.203',0,'logout'),
(63,277,'user login','loginid=Mjc3','2022-06-03 01:41:10','host.sofxol.com','104.193.108.203',1,'login'),
(64,277,'user logout','loginid=Mjc3','2022-06-03 01:42:02','host.sofxol.com','104.193.108.203',0,'logout'),
(65,278,'user login','loginid=Mjc4','2022-06-03 01:42:17','host.sofxol.com','104.193.108.203',1,'login'),
(66,278,'user logout','loginid=Mjc4','2022-06-03 01:42:50','host.sofxol.com','104.193.108.203',0,'logout'),
(67,1,'cp admin login',NULL,'2022-06-03 01:46:03','host.sofxol.com','104.193.108.203',1,'login'),
(68,276,'user login','loginid=Mjc2','2022-06-03 02:32:34','host.sofxol.com','104.193.108.203',1,'login'),
(69,276,'user login','loginid=Mjc2','2022-06-03 03:16:56','host.sofxol.com','104.193.108.203',1,'login'),
(70,276,'user logout','loginid=Mjc2','2022-06-03 03:20:26','host.sofxol.com','104.193.108.203',0,'logout'),
(71,276,'user login','loginid=Mjc2','2022-06-03 03:20:51','host.sofxol.com','104.193.108.203',1,'login'),
(72,276,'user logout','loginid=Mjc2','2022-06-03 03:20:57','host.sofxol.com','104.193.108.203',0,'logout'),
(73,277,'user login','loginid=Mjc3','2022-06-03 03:21:41','host.sofxol.com','104.193.108.203',1,'login'),
(74,277,'user logout','loginid=Mjc3','2022-06-03 03:24:00','host.sofxol.com','104.193.108.203',0,'logout'),
(75,278,'user login','loginid=Mjc4','2022-06-03 09:27:13','host.sofxol.com','104.193.108.203',1,'login'),
(76,278,'user logout','loginid=Mjc4','2022-06-03 09:29:27','host.sofxol.com','104.193.108.203',0,'logout'),
(77,277,'user login','loginid=Mjc3','2022-06-03 02:50:46','host.sofxol.com','104.193.108.203',1,'login'),
(78,277,'user logout','loginid=Mjc3','2022-06-03 02:56:47','host.sofxol.com','104.193.108.203',0,'logout'),
(79,278,'user login','loginid=Mjc4','2022-06-03 02:57:00','host.sofxol.com','104.193.108.203',1,'login'),
(80,278,'user logout','loginid=Mjc4','2022-06-03 02:58:14','host.sofxol.com','104.193.108.203',0,'logout'),
(81,276,'user login','loginid=Mjc2','2022-06-03 02:58:40','host.sofxol.com','104.193.108.203',1,'login'),
(82,276,'user logout','loginid=Mjc2','2022-06-03 03:06:27','host.sofxol.com','104.193.108.203',0,'logout'),
(83,278,'user login','loginid=Mjc4','2022-06-03 03:06:50','host.sofxol.com','104.193.108.203',1,'login'),
(84,278,'user logout','loginid=Mjc4','2022-06-03 03:07:49','host.sofxol.com','104.193.108.203',0,'logout'),
(85,277,'user login','loginid=Mjc3','2022-06-03 03:08:14','host.sofxol.com','104.193.108.203',1,'login'),
(86,277,'user logout','loginid=Mjc3','2022-06-03 03:11:55','host.sofxol.com','104.193.108.203',0,'logout'),
(87,276,'user login','loginid=Mjc2','2022-06-03 03:12:09','host.sofxol.com','104.193.108.203',1,'login'),
(88,1,'cp admin login',NULL,'2022-06-03 03:19:33','host.sofxol.com','104.193.108.203',1,'login'),
(89,276,'user login','loginid=Mjc2','2022-06-03 03:34:18','host.sofxol.com','104.193.108.203',1,'login'),
(90,276,'user logout','loginid=Mjc2','2022-06-03 03:35:15','host.sofxol.com','104.193.108.203',0,'logout'),
(91,277,'user login','loginid=Mjc3','2022-06-03 03:35:27','host.sofxol.com','104.193.108.203',1,'login'),
(92,276,'user login','loginid=Mjc2','2022-06-03 05:34:36','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(93,1,'cp admin login',NULL,'2022-06-03 06:10:25','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(94,276,'user logout','loginid=Mjc2','2022-06-03 06:23:13','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(95,277,'user login','loginid=Mjc3','2022-06-03 06:23:23','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(96,277,'user logout','loginid=Mjc3','2022-06-03 06:36:39','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(97,276,'user login','loginid=Mjc2','2022-06-03 06:36:46','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(98,276,'user logout','loginid=Mjc2','2022-06-03 06:47:12','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(99,277,'user login','loginid=Mjc3','2022-06-03 06:47:26','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(100,277,'user logout','loginid=Mjc3','2022-06-03 07:03:42','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(101,278,'user login','loginid=Mjc4','2022-06-03 07:03:51','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(102,278,'user logout','loginid=Mjc4','2022-06-03 07:04:04','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(103,276,'user login','loginid=Mjc2','2022-06-03 07:04:12','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(104,276,'user logout','loginid=Mjc2','2022-06-03 07:38:06','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(107,276,'user login','loginid=Mjc2','2022-06-03 07:40:22','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(108,276,'user logout','loginid=Mjc2','2022-06-03 07:47:16','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(111,278,'user login','loginid=Mjc4','2022-06-03 07:49:07','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(112,278,'user logout','loginid=Mjc4','2022-06-03 07:49:56','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(113,277,'user login','loginid=Mjc3','2022-06-03 07:50:05','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(114,277,'user logout','loginid=Mjc3','2022-06-03 07:53:52','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(115,278,'user login','loginid=Mjc4','2022-06-03 07:54:02','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(116,278,'user logout','loginid=Mjc4','2022-06-03 08:13:13','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(117,280,'user login','loginid=Mjgw','2022-06-03 08:14:39','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(118,280,'user logout','loginid=Mjgw','2022-06-03 08:19:00','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(119,278,'user login','loginid=Mjc4','2022-06-03 08:19:42','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(120,278,'user logout','loginid=Mjc4','2022-06-03 08:22:32','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(121,277,'user login','loginid=Mjc3','2022-06-03 08:24:06','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(122,277,'user logout','loginid=Mjc3','2022-06-03 08:26:54','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(123,278,'user login','loginid=Mjc4','2022-06-03 08:27:14','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(124,278,'user logout','loginid=Mjc4','2022-06-03 08:27:30','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(125,276,'user login','loginid=Mjc2','2022-06-03 08:27:40','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(126,276,'user logout','loginid=Mjc2','2022-06-03 08:29:33','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(127,277,'user login','loginid=Mjc3','2022-06-03 08:29:42','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(128,277,'user logout','loginid=Mjc3','2022-06-03 09:26:13','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(129,282,'user login','loginid=Mjgy','2022-06-03 09:32:47','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(130,282,'user logout','loginid=Mjgy','2022-06-03 09:38:09','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(131,277,'user login','loginid=Mjc3','2022-06-03 09:38:25','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(132,277,'user logout','loginid=Mjc3','2022-06-03 10:08:34','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(133,282,'user login','loginid=Mjgy','2022-06-03 10:08:43','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(134,282,'user logout','loginid=Mjgy','2022-06-03 10:09:24','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(135,277,'user login','loginid=Mjc3','2022-06-03 10:09:34','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(136,277,'user logout','loginid=Mjc3','2022-06-03 10:35:45','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(137,278,'user login','loginid=Mjc4','2022-06-03 10:35:59','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(138,278,'user logout','loginid=Mjc4','2022-06-03 10:37:45','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(139,276,'user login','loginid=Mjc2','2022-06-03 10:37:53','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(140,276,'user logout','loginid=Mjc2','2022-06-03 10:51:57','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(141,277,'user login','loginid=Mjc3','2022-06-03 10:52:05','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(142,277,'user logout','loginid=Mjc3','2022-06-03 10:54:09','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(143,278,'user login','loginid=Mjc4','2022-06-03 10:54:17','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(144,278,'user logout','loginid=Mjc4','2022-06-03 11:05:50','DESKTOP-SJ45L77','192.168.8.101',0,'logout'),
(145,277,'user login','loginid=Mjc3','2022-06-03 11:10:17','DESKTOP-SJ45L77','192.168.8.101',1,'login'),
(146,276,'user login','loginid=Mjc2','2022-06-19 03:39:37','dj','192.168.2.104',1,'login'),
(147,276,'user logout','loginid=Mjc2','2022-06-19 03:39:49','dj','192.168.2.104',0,'logout'),
(148,276,'user login','loginid=Mjc2','2022-06-22 12:02:47','dj','192.168.8.100',1,'login'),
(149,276,'user logout','loginid=Mjc2','2022-06-22 12:53:37','dj','192.168.8.100',0,'logout'),
(150,276,'user login','loginid=Mjc2','2022-06-22 12:57:44','dj','192.168.8.100',1,'login'),
(151,276,'user login','loginid=Mjc2','2022-11-12 11:12:22','dj','192.168.100.3',1,'login'),
(152,276,'user logout','loginid=Mjc2','2022-11-12 11:25:01','dj','192.168.100.3',0,'logout'),
(153,277,'user login','loginid=Mjc3','2022-11-12 11:25:19','dj','192.168.100.3',1,'login'),
(154,276,'user login','loginid=Mjc2','2022-11-12 11:28:34','dj','192.168.100.3',1,'login'),
(155,276,'user login','loginid=Mjc2','2023-06-10 12:31:14','dj','192.168.2.102',1,'login'),
(156,276,'user login','loginid=Mjc2','2024-02-08 01:34:59','DESKTOP-24L4L3E','192.168.0.105',1,'login'),
(157,283,'user login','loginid=Mjgz','2024-02-08 01:38:09','DESKTOP-24L4L3E','192.168.0.105',1,'login'),
(158,283,'user logout','loginid=Mjgz','2024-02-08 01:42:32','DESKTOP-24L4L3E','192.168.0.105',0,'logout'),
(159,276,'user login','loginid=Mjc2','2024-02-08 01:42:40','DESKTOP-24L4L3E','192.168.0.105',1,'login'),
(160,276,'user logout','loginid=Mjc2','2024-02-08 01:45:37','DESKTOP-24L4L3E','192.168.0.105',0,'logout'),
(161,283,'user login','loginid=Mjgz','2024-02-08 01:46:16','DESKTOP-24L4L3E','192.168.0.105',1,'login'),
(162,283,'user logout','loginid=Mjgz','2024-02-08 01:55:06','DESKTOP-24L4L3E','192.168.0.105',0,'logout'),
(163,277,'user login','loginid=Mjc3','2024-02-08 01:55:21','DESKTOP-24L4L3E','192.168.0.105',1,'login'),
(164,277,'user logout','loginid=Mjc3','2024-02-08 01:56:49','DESKTOP-24L4L3E','192.168.0.105',0,'logout'),
(165,276,'user login','loginid=Mjc2','2024-02-08 01:56:53','DESKTOP-24L4L3E','192.168.0.105',1,'login'),
(166,276,'user logout','loginid=Mjc2','2024-02-08 01:57:23','DESKTOP-24L4L3E','192.168.0.105',0,'logout'),
(167,277,'user login','loginid=Mjc3','2024-02-08 01:57:53','DESKTOP-24L4L3E','192.168.0.105',1,'login'),
(168,276,'user login','loginid=Mjc2','2024-08-11 12:44:26','DESKTOP-24L4L3E','192.168.2.104',1,'login'),
(169,1,'cp admin login',NULL,'2024-08-11 12:56:18','DESKTOP-24L4L3E','192.168.2.104',1,'login'),
(170,276,'user logout','loginid=Mjc2','2024-08-11 01:05:28','DESKTOP-24L4L3E','192.168.2.104',0,'logout'),
(171,277,'user login','loginid=Mjc3','2024-08-11 01:05:47','DESKTOP-24L4L3E','192.168.2.104',1,'login'),
(172,277,'user logout','loginid=Mjc3','2024-08-11 01:08:53','DESKTOP-24L4L3E','192.168.2.104',0,'logout'),
(173,276,'user login','loginid=Mjc2','2024-08-11 01:09:12','DESKTOP-24L4L3E','192.168.2.104',1,'login'),
(174,276,'user login','loginid=Mjc2','2024-08-14 09:28:17','d2.my-control-panel.com','192.168.168.2',1,'login'),
(175,276,'user login','loginid=Mjc2','2024-08-15 09:59:58','d2.my-control-panel.com','192.168.168.2',1,'login'),
(176,276,'user login','loginid=Mjc2','2024-08-16 09:06:36','d2.my-control-panel.com','192.168.168.2',1,'login'),
(177,276,'user login','loginid=Mjc2','2024-08-16 09:06:37','d2.my-control-panel.com','192.168.168.2',1,'login'),
(178,276,'user login','loginid=Mjc2','2024-08-16 10:23:29','d2.my-control-panel.com','192.168.168.2',1,'login'),
(179,276,'user login','loginid=Mjc2','2024-08-16 12:25:17','d2.my-control-panel.com','192.168.168.2',1,'login'),
(180,276,'user login','loginid=Mjc2','2024-08-16 03:09:49','d2.my-control-panel.com','192.168.168.2',1,'login'),
(181,276,'user login','loginid=Mjc2','2024-08-16 05:19:46','d2.my-control-panel.com','192.168.168.2',1,'login'),
(182,276,'user login','loginid=Mjc2','2024-08-16 11:38:09','d2.my-control-panel.com','192.168.168.2',1,'login'),
(183,276,'user login','loginid=Mjc2','2024-08-16 11:38:10','d2.my-control-panel.com','192.168.168.2',1,'login'),
(184,276,'user login','loginid=Mjc2','2024-08-17 09:58:23','d2.my-control-panel.com','192.168.168.2',1,'login'),
(185,276,'user login','loginid=Mjc2','2024-08-17 05:10:33','d2.my-control-panel.com','192.168.168.2',1,'login'),
(186,284,'user login','loginid=Mjg0','2024-08-17 05:44:17','d2.my-control-panel.com','192.168.168.2',1,'login'),
(187,284,'user login','loginid=Mjg0','2024-08-17 05:48:33','d2.my-control-panel.com','192.168.168.2',1,'login'),
(188,284,'user login','loginid=Mjg0','2024-08-17 06:14:25','d2.my-control-panel.com','192.168.168.2',1,'login'),
(189,276,'user login','loginid=Mjc2','2024-08-17 06:17:47','d2.my-control-panel.com','192.168.168.2',1,'login'),
(190,276,'user login','loginid=Mjc2','2024-08-17 09:12:00','d2.my-control-panel.com','192.168.168.2',1,'login'),
(191,276,'user login','loginid=Mjc2','2024-08-18 12:31:08','d2.my-control-panel.com','192.168.168.2',1,'login'),
(192,276,'user login','loginid=Mjc2','2024-08-18 02:43:00','d2.my-control-panel.com','192.168.168.2',1,'login'),
(193,276,'user login','loginid=Mjc2','2024-08-18 10:09:58','d2.my-control-panel.com','192.168.168.2',1,'login'),
(194,276,'user login','loginid=Mjc2','2024-08-20 09:21:58','d2.my-control-panel.com','192.168.168.2',1,'login'),
(195,276,'user login','loginid=Mjc2','2024-08-25 01:43:03','d2.my-control-panel.com','192.168.168.2',1,'login'),
(196,276,'user login','loginid=Mjc2','2024-08-25 07:15:46','d2.my-control-panel.com','192.168.168.2',1,'login'),
(197,276,'user login','loginid=Mjc2','2024-08-26 04:16:07','d2.my-control-panel.com','192.168.168.2',1,'login'),
(198,276,'user login','loginid=Mjc2','2024-08-26 04:25:01','d2.my-control-panel.com','192.168.168.2',1,'login'),
(199,276,'user login','loginid=Mjc2','2024-08-27 10:31:07','d2.my-control-panel.com','192.168.168.2',1,'login'),
(200,276,'user login','loginid=Mjc2','2024-08-27 11:46:53','Kashan','192.168.14.104',1,'login'),
(201,276,'user logout','loginid=Mjc2','2024-08-27 04:27:20','Kashan','192.168.14.104',0,'logout'),
(202,284,'user login','loginid=Mjg0','2024-08-27 04:27:36','Kashan','192.168.14.104',1,'login'),
(203,284,'user logout','loginid=Mjg0','2024-08-27 04:27:52','Kashan','192.168.14.104',0,'logout'),
(204,277,'user login','loginid=Mjc3','2024-08-27 04:28:02','Kashan','192.168.14.104',1,'login'),
(205,277,'user logout','loginid=Mjc3','2024-08-27 04:30:37','Kashan','192.168.14.104',0,'logout'),
(206,276,'user login','loginid=Mjc2','2024-08-27 04:30:52','Kashan','192.168.14.104',1,'login'),
(207,276,'user logout','loginid=Mjc2','2024-08-27 04:44:08','Kashan','192.168.14.104',0,'logout'),
(208,276,'user login','loginid=Mjc2','2024-08-27 04:44:39','Kashan','192.168.14.104',1,'login'),
(209,277,'user login','loginid=Mjc3','2024-08-27 04:44:59','Kashan','192.168.14.104',1,'login'),
(210,276,'user login','loginid=Mjc2','2024-08-28 11:54:03','Kashan','192.168.47.62',1,'login'),
(211,277,'user login','loginid=Mjc3','2024-08-28 02:28:09','Kashan','192.168.14.104',1,'login'),
(212,1,'cp admin login',NULL,'2024-08-28 04:50:29','Kashan','192.168.14.104',1,'login'),
(213,1,'cp admin login',NULL,'2024-08-29 11:07:33','Kashan','192.168.10.184',1,'login'),
(214,276,'user login','loginid=Mjc2','2024-08-29 12:06:42','Kashan','192.168.10.184',1,'login'),
(215,1,'cp admin login',NULL,'2024-08-30 10:36:34','Kashan','192.168.2.124',1,'login'),
(216,276,'user login','loginid=Mjc2','2024-08-30 10:38:35','Kashan','192.168.2.124',1,'login');

/*Table structure for table `user_logout` */

DROP TABLE IF EXISTS `user_logout`;

CREATE TABLE `user_logout` (
  `ulgid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `loginid` varchar(20) DEFAULT NULL,
  `logoutdate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `islogout` tinyint(1) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`ulgid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_logout_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `user_logout_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_logout` */

insert  into `user_logout`(`ulgid`,`uid`,`remarks`,`loginid`,`logoutdate`,`device`,`ip`,`islogout`,`status`) values 
(2,276,'user logout','loginid=Mjc2','2022-06-01 11:28:49','dj','192.168.8.102',1,'logout'),
(3,277,'user logout','loginid=Mjc3','2022-06-01 11:31:05','dj','192.168.8.102',1,'logout'),
(4,276,'user logout','loginid=Mjc2','2022-06-01 11:31:49','dj','192.168.8.102',1,'logout'),
(5,278,'user logout','loginid=Mjc4','2022-06-01 12:09:00','dj','192.168.8.102',1,'logout'),
(6,1,'cp admin logout',NULL,'2022-06-01 12:17:15','dj','192.168.8.102',1,'logout'),
(7,276,'user logout','loginid=Mjc2','2022-06-01 12:39:31','dj','192.168.8.102',1,'logout'),
(8,277,'user logout','loginid=Mjc3','2022-06-01 12:44:09','dj','192.168.8.102',1,'logout'),
(9,276,'user logout','loginid=Mjc2','2022-06-01 12:53:13','dj','192.168.8.102',1,'logout'),
(10,277,'user logout','loginid=Mjc3','2022-06-01 12:54:39','dj','192.168.8.102',1,'logout'),
(11,278,'user logout','loginid=Mjc4','2022-06-01 12:56:06','dj','192.168.8.102',1,'logout'),
(12,277,'user logout','loginid=Mjc3','2022-06-01 12:57:23','dj','192.168.8.102',1,'logout'),
(13,276,'user logout','loginid=Mjc2','2022-06-01 12:59:53','dj','192.168.8.102',1,'logout'),
(14,276,'user logout','loginid=Mjc2','2022-06-02 12:03:07','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(15,276,'user logout','loginid=Mjc2','2022-06-02 12:03:21','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(16,277,'user logout','loginid=Mjc3','2022-06-02 12:03:40','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(17,276,'user logout','loginid=Mjc2','2022-06-02 01:32:45','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(18,276,'user logout','loginid=Mjc2','2022-06-02 08:20:40','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(19,276,'user logout','loginid=Mjc2','2022-06-02 08:28:18','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(20,276,'user logout','loginid=Mjc2','2022-06-02 08:35:32','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(21,276,'user logout','loginid=Mjc2','2022-06-02 08:35:53','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(22,1,'cp admin logout',NULL,'2022-06-02 08:49:43','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(23,276,'user logout','loginid=Mjc2','2022-06-03 12:35:25','DESKTOP-SJ45L77','192.168.88.10',1,'logout'),
(24,276,'user logout','loginid=Mjc2','2022-06-03 01:14:23','host.sofxol.com','104.193.108.203',1,'logout'),
(25,277,'user logout','loginid=Mjc3','2022-06-03 01:21:00','host.sofxol.com','104.193.108.203',1,'logout'),
(26,277,'user logout','loginid=Mjc3','2022-06-03 01:39:46','host.sofxol.com','104.193.108.203',1,'logout'),
(27,277,'user logout','loginid=Mjc3','2022-06-03 01:41:01','host.sofxol.com','104.193.108.203',1,'logout'),
(28,277,'user logout','loginid=Mjc3','2022-06-03 01:42:02','host.sofxol.com','104.193.108.203',1,'logout'),
(29,278,'user logout','loginid=Mjc4','2022-06-03 01:42:50','host.sofxol.com','104.193.108.203',1,'logout'),
(30,276,'user logout','loginid=Mjc2','2022-06-03 03:20:26','host.sofxol.com','104.193.108.203',1,'logout'),
(31,276,'user logout','loginid=Mjc2','2022-06-03 03:20:57','host.sofxol.com','104.193.108.203',1,'logout'),
(32,277,'user logout','loginid=Mjc3','2022-06-03 03:24:00','host.sofxol.com','104.193.108.203',1,'logout'),
(33,278,'user logout','loginid=Mjc4','2022-06-03 09:29:27','host.sofxol.com','104.193.108.203',1,'logout'),
(34,277,'user logout','loginid=Mjc3','2022-06-03 02:56:47','host.sofxol.com','104.193.108.203',1,'logout'),
(35,278,'user logout','loginid=Mjc4','2022-06-03 02:58:14','host.sofxol.com','104.193.108.203',1,'logout'),
(36,276,'user logout','loginid=Mjc2','2022-06-03 03:06:27','host.sofxol.com','104.193.108.203',1,'logout'),
(37,278,'user logout','loginid=Mjc4','2022-06-03 03:07:49','host.sofxol.com','104.193.108.203',1,'logout'),
(38,277,'user logout','loginid=Mjc3','2022-06-03 03:11:55','host.sofxol.com','104.193.108.203',1,'logout'),
(39,276,'user logout','loginid=Mjc2','2022-06-03 03:35:15','host.sofxol.com','104.193.108.203',1,'logout'),
(40,276,'user logout','loginid=Mjc2','2022-06-03 06:23:13','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(41,277,'user logout','loginid=Mjc3','2022-06-03 06:36:39','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(42,276,'user logout','loginid=Mjc2','2022-06-03 06:47:12','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(43,277,'user logout','loginid=Mjc3','2022-06-03 07:03:42','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(44,278,'user logout','loginid=Mjc4','2022-06-03 07:04:04','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(45,276,'user logout','loginid=Mjc2','2022-06-03 07:38:06','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(47,276,'user logout','loginid=Mjc2','2022-06-03 07:47:16','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(49,278,'user logout','loginid=Mjc4','2022-06-03 07:49:56','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(50,277,'user logout','loginid=Mjc3','2022-06-03 07:53:52','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(51,278,'user logout','loginid=Mjc4','2022-06-03 08:13:13','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(52,280,'user logout','loginid=Mjgw','2022-06-03 08:19:00','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(53,278,'user logout','loginid=Mjc4','2022-06-03 08:22:32','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(54,277,'user logout','loginid=Mjc3','2022-06-03 08:26:54','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(55,278,'user logout','loginid=Mjc4','2022-06-03 08:27:30','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(56,276,'user logout','loginid=Mjc2','2022-06-03 08:29:33','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(57,277,'user logout','loginid=Mjc3','2022-06-03 09:26:13','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(58,282,'user logout','loginid=Mjgy','2022-06-03 09:38:09','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(59,277,'user logout','loginid=Mjc3','2022-06-03 10:08:34','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(60,282,'user logout','loginid=Mjgy','2022-06-03 10:09:24','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(61,277,'user logout','loginid=Mjc3','2022-06-03 10:35:45','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(62,278,'user logout','loginid=Mjc4','2022-06-03 10:37:45','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(63,276,'user logout','loginid=Mjc2','2022-06-03 10:51:57','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(64,277,'user logout','loginid=Mjc3','2022-06-03 10:54:09','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(65,278,'user logout','loginid=Mjc4','2022-06-03 11:05:50','DESKTOP-SJ45L77','192.168.8.101',1,'logout'),
(66,276,'user logout','loginid=Mjc2','2022-06-19 03:39:49','dj','192.168.2.104',1,'logout'),
(67,276,'user logout','loginid=Mjc2','2022-06-22 12:53:37','dj','192.168.8.100',1,'logout'),
(68,276,'user logout','loginid=Mjc2','2022-11-12 11:25:01','dj','192.168.100.3',1,'logout'),
(69,283,'user logout','loginid=Mjgz','2024-02-08 01:42:32','DESKTOP-24L4L3E','192.168.0.105',1,'logout'),
(70,276,'user logout','loginid=Mjc2','2024-02-08 01:45:37','DESKTOP-24L4L3E','192.168.0.105',1,'logout'),
(71,283,'user logout','loginid=Mjgz','2024-02-08 01:55:06','DESKTOP-24L4L3E','192.168.0.105',1,'logout'),
(72,277,'user logout','loginid=Mjc3','2024-02-08 01:56:49','DESKTOP-24L4L3E','192.168.0.105',1,'logout'),
(73,276,'user logout','loginid=Mjc2','2024-02-08 01:57:23','DESKTOP-24L4L3E','192.168.0.105',1,'logout'),
(74,276,'user logout','loginid=Mjc2','2024-08-11 01:05:28','DESKTOP-24L4L3E','192.168.2.104',1,'logout'),
(75,277,'user logout','loginid=Mjc3','2024-08-11 01:08:53','DESKTOP-24L4L3E','192.168.2.104',1,'logout'),
(76,276,'user logout','loginid=Mjc2','2024-08-27 04:27:20','Kashan','192.168.14.104',1,'logout'),
(77,284,'user logout','loginid=Mjg0','2024-08-27 04:27:52','Kashan','192.168.14.104',1,'logout'),
(78,277,'user logout','loginid=Mjc3','2024-08-27 04:30:37','Kashan','192.168.14.104',1,'logout'),
(79,276,'user logout','loginid=Mjc2','2024-08-27 04:44:08','Kashan','192.168.14.104',1,'logout');

/*Table structure for table `user_signup` */

DROP TABLE IF EXISTS `user_signup`;

CREATE TABLE `user_signup` (
  `usgid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `remarks` varchar(20) DEFAULT NULL,
  `signupdate` datetime DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `ip` text DEFAULT NULL,
  `issignup` tinyint(1) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`usgid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_signup_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `user_signup_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_signup` */

insert  into `user_signup`(`usgid`,`uid`,`remarks`,`signupdate`,`device`,`ip`,`issignup`,`status`) values 
(2,276,'user signup','2022-06-01 11:28:27','dj','192.168.8.102',NULL,'new'),
(3,277,'user signup','2022-06-01 11:30:15','dj','192.168.8.102',NULL,'new'),
(4,278,'user signup','2022-06-01 11:33:58','dj','192.168.8.102',NULL,'new'),
(6,280,'user signup','2022-06-03 08:14:39','DESKTOP-SJ45L77','192.168.8.101',NULL,'new'),
(7,282,'user signup','2022-06-03 09:32:47','DESKTOP-SJ45L77','192.168.8.101',NULL,'new'),
(8,283,'user signup','2024-02-08 01:38:09','DESKTOP-24L4L3E','192.168.0.105',NULL,'new'),
(9,284,'user signup','2024-08-17 05:44:17','d2.my-control-panel.com','192.168.168.2',NULL,'new');

/*Table structure for table `user_tier_level` */

DROP TABLE IF EXISTS `user_tier_level`;

CREATE TABLE `user_tier_level` (
  `utlvid` int(11) NOT NULL AUTO_INCREMENT,
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
  `status` varchar(6) DEFAULT NULL,
  PRIMARY KEY (`utlvid`),
  KEY `tlvid` (`tlvid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_tier_level_ibfk_2` FOREIGN KEY (`tlvid`) REFERENCES `tier_level` (`tlvid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_tier_level_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_tier_level` */

insert  into `user_tier_level`(`utlvid`,`uid`,`tlvid`,`title`,`level`,`tno`,`lrange`,`com`,`pcom`,`unlockdate`,`createdate`,`islock`,`status`) values 
(53,276,1,'Tier 1','LV1',50,'$100-500','5%',0.1,'2022-06-01 12:18:24','2022-06-01 09:18:23',1,'lock'),
(54,276,2,'Tier 2','LV2',55,'$500-1000','8%',0.14,NULL,'2022-06-01 09:18:23',1,'lock'),
(55,276,3,'Tier 3','LV3',60,'$1000-2000','10%',0.16,NULL,'2022-06-01 09:18:23',1,'lock'),
(56,276,4,'Tier 4','LV4',70,'$2000 or more','12%',0.17,NULL,'2022-06-01 09:18:23',1,'lock'),
(57,277,1,'Tier 1','LV1',50,'$100-500','5%',0.1,'2022-06-01 12:43:13','2022-06-01 09:40:20',0,'unlock'),
(58,277,2,'Tier 2','LV2',55,'$500-1000','8%',0.14,NULL,'2022-06-01 09:40:20',1,'lock'),
(59,277,3,'Tier 3','LV3',60,'$1000-2000','10%',0.16,NULL,'2022-06-01 09:40:20',1,'lock'),
(60,277,4,'Tier 4','LV4',70,'$2000 or more','12%',0.17,NULL,'2022-06-01 09:40:20',1,'lock'),
(61,278,1,'Tier 1','LV1',50,'$100-500','5%',0.1,'2022-06-01 12:55:49','2022-06-01 09:55:49',0,'unlock'),
(62,278,2,'Tier 2','LV2',55,'$500-1000','8%',0.14,NULL,'2022-06-01 09:55:49',1,'lock'),
(63,278,3,'Tier 3','LV3',60,'$1000-2000','10%',0.16,NULL,'2022-06-01 09:55:49',1,'lock'),
(64,278,4,'Tier 4','LV4',70,'$2000 or more','12%',0.17,NULL,'2022-06-01 09:55:49',1,'lock'),
(97,280,1,'Tier 1','LV1',50,'$100-500','5%',0.1,'2022-06-03 20:18:40','2022-06-03 05:18:40',0,'unlock'),
(98,280,2,'Tier 2','LV2',55,'$500-1000','8%',0.14,NULL,'2022-06-03 05:18:40',1,'lock'),
(99,280,3,'Tier 3','LV3',60,'$1000-2000','10%',0.16,NULL,'2022-06-03 05:18:40',1,'lock'),
(100,280,4,'Tier 4','LV4',70,'$2000 or more','12%',0.17,NULL,'2022-06-03 05:18:40',1,'lock'),
(101,283,1,'Tier 1','LV1',50,'$100-500','5%',0.1,NULL,'2024-02-07 09:38:28',1,'lock'),
(102,283,2,'Tier 2','LV2',55,'$500-1000','8%',0.14,NULL,'2024-02-07 09:38:28',1,'lock'),
(103,283,3,'Tier 3','LV3',60,'$1000-2000','10%',0.16,NULL,'2024-02-07 09:38:28',1,'lock'),
(104,283,4,'Tier 4','LV4',70,'$2000 or more','12%',0.17,NULL,'2024-02-07 09:38:28',1,'lock');

/*Table structure for table `user_transaction_passcode` */

DROP TABLE IF EXISTS `user_transaction_passcode`;

CREATE TABLE `user_transaction_passcode` (
  `tpid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `passcode` varchar(4) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `updateby` varchar(20) DEFAULT NULL,
  `isedit` tinyint(1) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`tpid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_transaction_passcode_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_transaction_passcode_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_transaction_passcode` */

insert  into `user_transaction_passcode`(`tpid`,`uid`,`passcode`,`createdate`,`updatedate`,`createby`,`updateby`,`isedit`,`status`) values 
(26,276,'4455','2022-06-01 11:28:27',NULL,NULL,NULL,NULL,NULL),
(27,277,'3322','2022-06-01 11:30:15',NULL,NULL,NULL,NULL,NULL),
(28,278,'2211','2022-06-01 11:33:58',NULL,NULL,NULL,NULL,NULL),
(30,280,'11','2022-06-03 08:14:39',NULL,NULL,NULL,NULL,NULL),
(31,282,'11','2022-06-03 09:32:47',NULL,NULL,NULL,NULL,NULL),
(32,283,'1234','2024-02-08 01:38:09',NULL,NULL,NULL,NULL,NULL),
(33,284,'2233','2024-08-17 05:44:17',NULL,NULL,NULL,NULL,NULL);

/*Table structure for table `user_verification` */

DROP TABLE IF EXISTS `user_verification`;

CREATE TABLE `user_verification` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cpid` int(11) DEFAULT NULL,
  `vcid` int(11) DEFAULT NULL,
  `verificationdate` datetime DEFAULT NULL,
  `isverified` tinyint(1) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`vid`),
  KEY `vfcid` (`vcid`),
  KEY `cpid` (`cpid`),
  KEY `uid` (`uid`),
  CONSTRAINT `user_verification_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `user_verification_ibfk_2` FOREIGN KEY (`vcid`) REFERENCES `verification_code` (`vcid`),
  CONSTRAINT `user_verification_ibfk_3` FOREIGN KEY (`cpid`) REFERENCES `captcha_code` (`cpid`),
  CONSTRAINT `user_verification_ibfk_4` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_verification` */

insert  into `user_verification`(`vid`,`uid`,`cpid`,`vcid`,`verificationdate`,`isverified`,`status`) values 
(2,276,26,26,'2022-06-01 11:28:27',1,'verified'),
(3,277,27,27,'2022-06-01 11:30:15',1,'verified'),
(4,278,28,28,'2022-06-01 11:33:58',1,'verified'),
(6,280,30,30,'2022-06-03 08:14:39',1,'verified'),
(7,282,31,31,'2022-06-03 09:32:47',1,'verified'),
(8,283,32,32,'2024-02-08 01:38:09',1,'verified'),
(9,284,33,33,'2024-08-17 05:44:17',1,'verified');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
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
  `remarks` text DEFAULT NULL,
  PRIMARY KEY (`userid`),
  KEY `roleid` (`roleid`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`roleid`) REFERENCES `roles` (`roleid`)
) ENGINE=InnoDB AUTO_INCREMENT=285 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`userid`,`roleid`,`uname`,`email`,`encpass`,`decpass`,`uimgname`,`uimgguid`,`ccode`,`ctitle`,`mobile`,`country`,`refcode`,`createdate`,`updatedate`,`deletedate`,`blacklistdate`,`restoredate`,`createby`,`updateby`,`deleteby`,`blockby`,`restoreby`,`isedit`,`isdeleted`,`isblock`,`istop`,`isrestore`,`isnew`,`ip`,`status`,`remarks`) values 
(1,1,'admin','kashandeveloper@gmail.com','e6e061838856bf47e1de730719fb2609','admin@123','default image\n','profile_40x40.png',NULL,NULL,'03101136367',NULL,NULL,'2022-04-15 18:37:45',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,NULL,NULL,NULL,NULL),
(276,4,'user123',NULL,'6ad14ba9986e3615423dfca256d04e3f','user123','profile image','messi.jpg','92','pk','+923101136367','Pakistan (‫پاکستان‬‎)','ddagm8','2022-06-01 11:28:27','2022-06-02 08:26:32','2022-06-02 08:27:15','2022-06-02 07:53:53','2022-06-02 08:28:33',NULL,'user123','admin','admin','admin',NULL,0,0,NULL,1,0,NULL,'new',NULL),
(277,4,'konain',NULL,'d3985fd48d53d7a9f24b0b84d0a0a288','konain1','profile image','messi.jpg','92','pk','+923404445433','Pakistan (‫پاکستان‬‎)','0Q8xKZ','2022-06-01 11:30:15','2022-06-03 01:41:24',NULL,NULL,NULL,NULL,'konain',NULL,NULL,NULL,NULL,0,0,NULL,NULL,0,NULL,'new',NULL),
(278,4,'ahsan',NULL,'241138a9ffd584b5b228a8b02bef0671','ahsan12','default image','grab.png','90','tr','+905012345678','Turkey (Türkiye)','VkrcR3','2022-06-01 11:33:58',NULL,'2022-06-02 06:30:39','2022-06-02 08:34:43','2022-06-02 08:36:27',NULL,NULL,NULL,'admin','admin',NULL,0,0,NULL,1,0,NULL,'new',NULL),
(280,4,'ahmed',NULL,'3ab66a6d1c52730432b5bd38a366c148','ahmed12','default image','grab.png','92','pk','+923122442124','Pakistan (‫پاکستان‬‎)','2uOdGc','2022-06-03 08:14:39',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,0,NULL,'new',NULL),
(282,4,'sajid',NULL,'4b19837ef331661676b1c2b5c49a5fbb','sajid12','default image','grab.png','92','pk','+923172228544','Pakistan (‫پاکستان‬‎)','VkrcR3','2022-06-03 09:32:47',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,0,NULL,'new',NULL),
(283,4,'kashan',NULL,'58244e65b503ac6210ef50c62da3b938','kashan1','default image','grab.png','','','','','0Q8xKZ','2024-02-08 01:38:09',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,0,NULL,'new',NULL),
(284,4,'New',NULL,'7b8b1db5ae3bc0f6eba1b3426485d45d','New1234','default image','grab.png','92','pk','+923310237751','Pakistan (??????????)','0Q8xKZ','2024-08-17 05:44:17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,0,NULL,'new',NULL);

/*Table structure for table `verification_code` */

DROP TABLE IF EXISTS `verification_code`;

CREATE TABLE `verification_code` (
  `vcid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `vfcode` varchar(4) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  PRIMARY KEY (`vcid`),
  KEY `uid` (`uid`),
  CONSTRAINT `verification_code_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `verification_code_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `verification_code` */

insert  into `verification_code`(`vcid`,`uid`,`vfcode`,`createdate`) values 
(26,276,'7915','2022-06-01 11:28:27'),
(27,277,'2271','2022-06-01 11:30:15'),
(28,278,'6046','2022-06-01 11:33:58'),
(30,280,'1225','2022-06-03 08:14:39'),
(31,282,'9599','2022-06-03 09:32:47'),
(32,283,'5148','2024-02-08 01:38:09'),
(33,284,'0523','2024-08-17 05:44:17');

/*Table structure for table `wallet` */

DROP TABLE IF EXISTS `wallet`;

CREATE TABLE `wallet` (
  `wlid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `waid` int(11) DEFAULT NULL,
  `tpmid` int(11) DEFAULT NULL,
  `dpid` int(11) DEFAULT NULL,
  `wtid` int(11) DEFAULT NULL,
  `txid` text DEFAULT NULL,
  `utxid` text DEFAULT NULL,
  `wallet` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `approvedate` datetime DEFAULT NULL,
  `disapprovedate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `approveby` varchar(20) DEFAULT 'null',
  `disapproveby` varchar(20) DEFAULT 'null',
  `iswallet` tinyint(1) DEFAULT 0,
  `isapprove` tinyint(1) DEFAULT 0,
  `status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`wlid`),
  KEY `waid` (`waid`),
  KEY `uid` (`uid`),
  KEY `tpmid` (`tpmid`),
  KEY `dpid` (`dpid`),
  KEY `wtid` (`wtid`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `wallet` */

insert  into `wallet`(`wlid`,`uid`,`waid`,`tpmid`,`dpid`,`wtid`,`txid`,`utxid`,`wallet`,`createdate`,`approvedate`,`disapprovedate`,`createby`,`approveby`,`disapproveby`,`iswallet`,`isapprove`,`status`) values 
(49,276,26,1,5,NULL,'TXN-8B3C9A4E-27F5-4B6D-8E6D-73192EF5B4A2','db8e1af0cb3aca1ae2d0018624204529',30,'2024-08-30 11:39:29',NULL,NULL,'user123','null','null',0,0,'pending');

/*Table structure for table `wallet_address` */

DROP TABLE IF EXISTS `wallet_address`;

CREATE TABLE `wallet_address` (
  `waid` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `name` text DEFAULT NULL,
  `waddress` text DEFAULT NULL,
  `sortorder` varchar(20) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `deletedate` datetime DEFAULT NULL,
  `restoredate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `updateby` varchar(20) DEFAULT 'null',
  `deleteby` varchar(20) DEFAULT 'null',
  `restoreby` varchar(20) DEFAULT 'null',
  `isactive` tinyint(1) DEFAULT 0,
  `isdeleted` tinyint(1) DEFAULT 0,
  `isedit` tinyint(1) DEFAULT 0,
  `isrestore` tinyint(1) DEFAULT 0,
  `status` varchar(20) DEFAULT 'inactive',
  PRIMARY KEY (`waid`),
  KEY `cid` (`cid`),
  CONSTRAINT `wallet_address_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `company` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `wallet_address` */

insert  into `wallet_address`(`waid`,`cid`,`name`,`waddress`,`sortorder`,`createdate`,`updatedate`,`deletedate`,`restoredate`,`createby`,`updateby`,`deleteby`,`restoreby`,`isactive`,`isdeleted`,`isedit`,`isrestore`,`status`) values 
(26,31,'Test Transaction','TXN-8B3C9A4E-27F5-4B6D-8E6D-73192EF5B4A2','1','2024-08-29 12:10:01','2024-08-29 12:39:06',NULL,NULL,'admin','admin',NULL,NULL,1,0,1,0,'active');

/*Table structure for table `wallet_address_history` */

DROP TABLE IF EXISTS `wallet_address_history`;

CREATE TABLE `wallet_address_history` (
  `wahid` int(11) NOT NULL AUTO_INCREMENT,
  `waid` int(11) DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL,
  `deletedate` datetime DEFAULT NULL,
  `restoredate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `updateby` varchar(20) DEFAULT NULL,
  `deleteby` varchar(20) DEFAULT NULL,
  `restoreby` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`wahid`),
  KEY `waid` (`waid`),
  CONSTRAINT `wallet_address_history_ibfk_1` FOREIGN KEY (`waid`) REFERENCES `wallet_address` (`waid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

/*Data for the table `wallet_address_history` */

insert  into `wallet_address_history`(`wahid`,`waid`,`createdate`,`updatedate`,`deletedate`,`restoredate`,`createby`,`updateby`,`deleteby`,`restoreby`,`status`) values 
(37,26,'2024-08-29 12:10:01',NULL,NULL,NULL,'admin',NULL,NULL,NULL,'created'),
(38,26,NULL,'2024-08-29 12:12:04',NULL,NULL,NULL,'admin',NULL,NULL,'updated'),
(39,26,NULL,'2024-08-29 12:17:22',NULL,NULL,NULL,'admin',NULL,NULL,'updated'),
(40,26,NULL,'2024-08-29 12:22:57',NULL,NULL,NULL,'admin',NULL,NULL,'updated'),
(41,26,NULL,'2024-08-29 12:23:21',NULL,NULL,NULL,'admin',NULL,NULL,'updated'),
(42,26,NULL,'2024-08-29 12:39:06',NULL,NULL,NULL,'admin',NULL,NULL,'updated');

/*Table structure for table `withdrawal` */

DROP TABLE IF EXISTS `withdrawal`;

CREATE TABLE `withdrawal` (
  `wtid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `waid` int(11) DEFAULT NULL,
  `tpmid` int(11) DEFAULT NULL,
  `refcode` varchar(20) DEFAULT NULL,
  `txid` text DEFAULT NULL,
  `utxid` text DEFAULT NULL,
  `realname` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `withdrawal` double DEFAULT NULL,
  `withdrawaldate` datetime DEFAULT NULL,
  `approvedate` datetime DEFAULT NULL,
  `rejectdate` datetime DEFAULT NULL,
  `withdrawalby` varchar(20) DEFAULT 'null',
  `approveby` varchar(20) DEFAULT 'null',
  `rejectby` varchar(20) DEFAULT 'null',
  `isnew` tinyint(1) DEFAULT 1,
  `iswithdrawal` tinyint(1) DEFAULT 0,
  `isapprove` tinyint(1) DEFAULT 0,
  `isreject` tinyint(1) DEFAULT 0,
  `status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`wtid`),
  KEY `uid` (`uid`),
  KEY `withdrawal_ibfk_5` (`tpmid`),
  KEY `withdrawal_ibfk_4` (`waid`),
  CONSTRAINT `withdrawal_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `withdrawal_ibfk_2` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `withdrawal_ibfk_3` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`),
  CONSTRAINT `withdrawal_ibfk_4` FOREIGN KEY (`waid`) REFERENCES `wallet_address` (`waid`),
  CONSTRAINT `withdrawal_ibfk_5` FOREIGN KEY (`tpmid`) REFERENCES `topup_method` (`tpmid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `withdrawal` */

/*Table structure for table `withdrawal_wallet` */

DROP TABLE IF EXISTS `withdrawal_wallet`;

CREATE TABLE `withdrawal_wallet` (
  `wtwid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `waid` int(11) DEFAULT NULL,
  `tpmid` int(11) DEFAULT NULL,
  `wtid` int(11) DEFAULT NULL,
  `withdrawal` double DEFAULT NULL,
  `createdate` datetime DEFAULT NULL,
  `approvedate` datetime DEFAULT NULL,
  `rejectdate` datetime DEFAULT NULL,
  `createby` varchar(20) DEFAULT NULL,
  `approveby` varchar(20) DEFAULT 'null',
  `rejectby` varchar(20) DEFAULT 'null',
  `status` varchar(20) DEFAULT 'pending',
  PRIMARY KEY (`wtwid`),
  KEY `uid` (`uid`),
  KEY `waid` (`waid`),
  KEY `tpmid` (`tpmid`),
  CONSTRAINT `withdrawal_wallet_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `withdrawal_wallet_ibfk_3` FOREIGN KEY (`waid`) REFERENCES `wallet_address` (`waid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `withdrawal_wallet_ibfk_4` FOREIGN KEY (`tpmid`) REFERENCES `topup_method` (`tpmid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `withdrawal_wallet` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
