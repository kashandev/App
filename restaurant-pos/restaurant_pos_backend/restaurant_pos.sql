/*
SQLyog Community v13.2.0 (64 bit)
MySQL - 10.4.24-MariaDB : Database - restaurant_pos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`restaurant_pos` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `restaurant_pos`;

/*Table structure for table `login_session` */

DROP TABLE IF EXISTS `login_session`;

CREATE TABLE `login_session` (
  `session_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `session_start` time DEFAULT NULL,
  `session_end` time DEFAULT NULL,
  `status` enum('Start','End') DEFAULT 'Start',
  PRIMARY KEY (`session_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `session_user_id_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `restaurant_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `login_session` */

insert  into `login_session`(`session_id`,`user_id`,`user_type`,`user_name`,`session_start`,`session_end`,`status`) values 
(1,1,'admin','kashan','00:28:08','21:28:08','Start'),
(2,1,'admin','kashan','00:54:57','21:54:57','Start'),
(3,1,'admin','kashan','01:13:10','22:13:10','Start'),
(4,1,'admin','kashan','01:18:49','22:18:49','Start'),
(5,1,'admin','kashan','01:21:29','22:21:29','Start'),
(6,1,'admin','kashan','01:24:33','22:24:33','Start'),
(7,1,'admin','kashan','01:37:00','22:37:00','Start'),
(8,1,'admin','kashan','01:40:51','22:40:51','Start'),
(9,1,'admin','kashan','01:41:28','22:41:28','Start'),
(10,1,'admin','kashan','01:41:44','22:41:44','Start'),
(11,1,'admin','kashan','01:42:11','22:42:11','Start'),
(12,1,'admin','kashan','01:42:43','22:42:43','Start'),
(13,1,'admin','kashan','01:43:44','22:43:44','Start'),
(14,1,'admin','kashan','01:54:11','22:54:11','Start'),
(15,1,'admin','kashan','02:05:20','23:05:20','Start'),
(16,1,'admin','kashan','18:35:27','15:35:27','Start'),
(17,1,'admin','kashan','18:35:37','15:35:37','Start');

/*Table structure for table `restaurant_activity_logs` */

DROP TABLE IF EXISTS `restaurant_activity_logs`;

CREATE TABLE `restaurant_activity_logs` (
  `activity_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `activity` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`activity_log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_activity_logs` */

/*Table structure for table `restaurant_assign_table` */

DROP TABLE IF EXISTS `restaurant_assign_table`;

CREATE TABLE `restaurant_assign_table` (
  `assing_table_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `table_no` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `status` enum('Assigned','Not Assigned') DEFAULT 'Not Assigned',
  PRIMARY KEY (`assing_table_id`),
  KEY `staff_id` (`staff_id`),
  KEY `table_id` (`table_id`),
  CONSTRAINT `restaurant_assign_table_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `restaurant_staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `restaurant_assign_table_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `restaurant_table` (`table_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_assign_table` */

/*Table structure for table `restaurant_checkout` */

DROP TABLE IF EXISTS `restaurant_checkout`;

CREATE TABLE `restaurant_checkout` (
  `checkout_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `total_discount` decimal(5,2) DEFAULT 0.00,
  `total_net_amount` decimal(10,2) DEFAULT 0.00,
  `checkout_date` datetime NOT NULL DEFAULT current_timestamp(),
  `checkout_by` varchar(255) DEFAULT NULL,
  `checkout_status` enum('Open','Completed','Cancelled') DEFAULT 'Open',
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending',
  PRIMARY KEY (`checkout_id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `restaurant_checkout_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `restaurant_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_checkout` */

/*Table structure for table `restaurant_checkout_items` */

DROP TABLE IF EXISTS `restaurant_checkout_items`;

CREATE TABLE `restaurant_checkout_items` (
  `checkout_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `checkout_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `qty` decimal(10,2) DEFAULT 0.00,
  `rate` decimal(10,2) DEFAULT 0.00,
  `amount` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(5,2) DEFAULT 0.00,
  `net_amount` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`checkout_item_id`),
  KEY `checkout_id` (`checkout_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `restaurant_checkout_items_ibfk_1` FOREIGN KEY (`checkout_id`) REFERENCES `restaurant_checkout` (`checkout_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `restaurant_checkout_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `restaurant_item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_checkout_items` */

/*Table structure for table `restaurant_item` */

DROP TABLE IF EXISTS `restaurant_item`;

CREATE TABLE `restaurant_item` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `item_name` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `qty` decimal(10,2) DEFAULT 0.00,
  `rate` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(5,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`item_id`),
  KEY `category_id` (`category_id`),
  KEY `sub_category_id` (`sub_category_id`),
  KEY `restaurant_item_ibfk_3` (`unit_id`),
  CONSTRAINT `restaurant_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `restaurant_item_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `restaurant_item_ibfk_2` FOREIGN KEY (`sub_category_id`) REFERENCES `restaurant_item_sub_category` (`sub_category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `restaurant_item_ibfk_3` FOREIGN KEY (`unit_id`) REFERENCES `restaurant_item_unit` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_item` */

/*Table structure for table `restaurant_item_category` */

DROP TABLE IF EXISTS `restaurant_item_category`;

CREATE TABLE `restaurant_item_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) DEFAULT 0,
  `category_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_item_category` */

/*Table structure for table `restaurant_item_sub_category` */

DROP TABLE IF EXISTS `restaurant_item_sub_category`;

CREATE TABLE `restaurant_item_sub_category` (
  `sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `sub_category_name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`sub_category_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `restaurant_item_sub_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `restaurant_item_category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_item_sub_category` */

/*Table structure for table `restaurant_item_unit` */

DROP TABLE IF EXISTS `restaurant_item_unit`;

CREATE TABLE `restaurant_item_unit` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) DEFAULT 0,
  `unit` varchar(6) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_item_unit` */

/*Table structure for table `restaurant_login_activity` */

DROP TABLE IF EXISTS `restaurant_login_activity`;

CREATE TABLE `restaurant_login_activity` (
  `login_activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_by` varchar(255) DEFAULT NULL,
  `login_at` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(255) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`login_activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_login_activity` */

insert  into `restaurant_login_activity`(`login_activity_id`,`login_by`,`login_at`,`ip`,`device_name`,`status`) values 
(1,'kashan','2023-12-03 00:28:08','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(2,'kashan','2023-12-03 00:54:57','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(3,'kashan','2023-12-03 01:13:10','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(4,'kashan','2023-12-03 01:18:49','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(5,'kashan','2023-12-03 01:21:29','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(6,'kashan','2023-12-03 01:24:33','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(7,'kashan','2023-12-03 01:37:00','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(8,'kashan','2023-12-03 01:40:52','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(9,'kashan','2023-12-03 01:41:28','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(10,'kashan','2023-12-03 01:41:44','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(11,'kashan','2023-12-03 01:42:11','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(12,'kashan','2023-12-03 01:42:43','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(13,'kashan','2023-12-03 01:43:44','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(14,'kashan','2023-12-03 01:54:12','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login'),
(15,'kashan','2023-12-03 02:05:20','127.0.0.1','PostmanRuntime/7.35.0','Login'),
(16,'kashan','2023-12-03 18:35:27','127.0.0.1','PostmanRuntime/7.35.0','Login'),
(17,'kashan','2023-12-03 18:35:37','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Safari/537.36','Login');

/*Table structure for table `restaurant_logout_activity` */

DROP TABLE IF EXISTS `restaurant_logout_activity`;

CREATE TABLE `restaurant_logout_activity` (
  `logout_activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_by` varchar(255) DEFAULT NULL,
  `logout_at` datetime NOT NULL DEFAULT current_timestamp(),
  `ip` varchar(255) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`logout_activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_logout_activity` */

/*Table structure for table `restaurant_order` */

DROP TABLE IF EXISTS `restaurant_order`;

CREATE TABLE `restaurant_order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) DEFAULT 0,
  `order_no` varchar(255) NOT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `order_date` date NOT NULL DEFAULT curdate(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Confimed','Cancelled') DEFAULT 'Pending',
  PRIMARY KEY (`order_id`),
  KEY `staff_id` (`staff_id`),
  KEY `table_id` (`table_id`),
  CONSTRAINT `restaurant_order_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `restaurant_staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `restaurant_order_ibfk_2` FOREIGN KEY (`table_id`) REFERENCES `restaurant_table` (`table_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_order` */

/*Table structure for table `restaurant_order_items` */

DROP TABLE IF EXISTS `restaurant_order_items`;

CREATE TABLE `restaurant_order_items` (
  `order_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_description` text DEFAULT NULL,
  `unit` varchar(255) NOT NULL,
  `qty` decimal(10,2) DEFAULT 0.00,
  `rate` decimal(10,2) DEFAULT 0.00,
  `amount` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(5,2) DEFAULT 0.00,
  `net_amount` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`order_item_id`),
  KEY `order_id` (`order_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `restaurant_order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `restaurant_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `restaurant_order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `restaurant_item` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_order_items` */

/*Table structure for table `restaurant_staff` */

DROP TABLE IF EXISTS `restaurant_staff`;

CREATE TABLE `restaurant_staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) DEFAULT 0,
  `staff_type` varchar(255) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `cnic` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_staff` */

/*Table structure for table `restaurant_table` */

DROP TABLE IF EXISTS `restaurant_table`;

CREATE TABLE `restaurant_table` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `table_no` varchar(255) NOT NULL,
  `no_of_chairs` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`table_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `restaurant_table_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `restaurant_staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_table` */

/*Table structure for table `restaurant_user` */

DROP TABLE IF EXISTS `restaurant_user`;

CREATE TABLE `restaurant_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_order` int(11) DEFAULT 0,
  `user_type` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  `login_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varbinary(64) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Data for the table `restaurant_user` */

insert  into `restaurant_user`(`user_id`,`sort_order`,`user_type`,`user_name`,`login_name`,`email`,`password_hash`,`created_at`,`updated_at`,`status`) values 
(1,0,'admin','kashan','admin123','kashandeveloper@gmail.com','$2y$10$8kpJMTW4LtrFQ1Fz.4hPt.rjZnH1D5XWBHmlJF7mkgrZZ1W4/ASei','2023-10-29 04:06:57','2023-12-02 18:36:29','Active');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
