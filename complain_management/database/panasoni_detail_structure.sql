/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.5.5-10.4.21-MariaDB : Database - panasonic_detail
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `branch_stock_transfer` */

DROP TABLE IF EXISTS `branch_stock_transfer`;

CREATE TABLE `branch_stock_transfer` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `branch_stock_transfer_id` char(40) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `total_qty` decimal(17,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`branch_stock_transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `branch_stock_transfer_detail` */

DROP TABLE IF EXISTS `branch_stock_transfer_detail`;

CREATE TABLE `branch_stock_transfer_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `branch_stock_transfer_id` char(40) NOT NULL,
  `branch_stock_transfer_detail_id` char(40) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `to_company_branch_id` int(11) DEFAULT NULL,
  `warehouse_id` int(40) DEFAULT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `unit_id` int(40) NOT NULL,
  `stock_qty` decimal(17,4) DEFAULT 0.0000,
  `qty` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cog_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cog_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_cog_rate` decimal(17,4) DEFAULT 0.0000,
  `base_cog_amount` decimal(20,4) DEFAULT 0.0000,
  `rate` decimal(17,4) DEFAULT 0.0000,
  `amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`branch_stock_transfer_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `const_document_type` */

DROP TABLE IF EXISTS `const_document_type`;

CREATE TABLE `const_document_type` (
  `document_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(255) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `zero_padding` tinyint(4) DEFAULT 4,
  `reset_on_fiscal_year` enum('Yes','No') DEFAULT 'Yes',
  `table_name` varchar(32) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `primary_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`document_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

/*Table structure for table `const_gl_type` */

DROP TABLE IF EXISTS `const_gl_type`;

CREATE TABLE `const_gl_type` (
  `gl_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`gl_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `const_partner_type` */

DROP TABLE IF EXISTS `const_partner_type`;

CREATE TABLE `const_partner_type` (
  `partner_type_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`partner_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Table structure for table `core_audit` */

DROP TABLE IF EXISTS `core_audit`;

CREATE TABLE `core_audit` (
  `audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `batch_identity` char(40) DEFAULT NULL,
  `document` varchar(255) NOT NULL,
  `transaction_type` char(6) NOT NULL,
  `transaction_table` varchar(255) NOT NULL,
  `transaction_id` char(40) NOT NULL,
  `document_identity` varchar(255) DEFAULT NULL,
  `query` text DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`audit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_audit_detail` */

DROP TABLE IF EXISTS `core_audit_detail`;

CREATE TABLE `core_audit_detail` (
  `audit_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `audit_id` int(11) NOT NULL,
  `field` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`audit_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_company_branch_document_prefix` */

DROP TABLE IF EXISTS `core_company_branch_document_prefix`;

CREATE TABLE `core_company_branch_document_prefix` (
  `company_branch_document_prefix_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `zero_padding` tinyint(4) DEFAULT NULL,
  `reset_on_fiscal_year` enum('Yes','No','Manual') DEFAULT NULL,
  `table_name` varchar(32) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `primary_key` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`company_branch_document_prefix_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_currency` */

DROP TABLE IF EXISTS `core_currency`;

CREATE TABLE `core_currency` (
  `currency_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `currency_code` char(3) NOT NULL,
  `name` varchar(32) NOT NULL DEFAULT '',
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` float(15,8) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`currency_id`),
  UNIQUE KEY `currency_code` (`currency_code`,`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Table structure for table `core_currency_rate` */

DROP TABLE IF EXISTS `core_currency_rate`;

CREATE TABLE `core_currency_rate` (
  `company_id` int(11) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_rate_id` char(40) NOT NULL,
  `date` date NOT NULL,
  `rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  PRIMARY KEY (`currency_rate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_customer` */

DROP TABLE IF EXISTS `core_customer`;

CREATE TABLE `core_customer` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `partner_category_id` int(11) NOT NULL,
  `customer_id` char(40) NOT NULL,
  `name` varchar(255) NOT NULL,
  `customer_code` bigint(40) DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gst_no` varchar(255) NOT NULL,
  `ntn_no` varchar(255) NOT NULL,
  `day_limit` int(11) NOT NULL DEFAULT 0,
  `amount_limit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `document_currency_id` char(40) NOT NULL,
  `cash_account_id` char(40) NOT NULL,
  `outstanding_account_id` char(40) NOT NULL,
  `advance_account_id` char(40) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1;

/*Table structure for table `core_document` */

DROP TABLE IF EXISTS `core_document`;

CREATE TABLE `core_document` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_id` char(40) NOT NULL,
  `document_identity` varchar(255) DEFAULT NULL,
  `document_date` date DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `primary_key_field` varchar(255) DEFAULT NULL,
  `primary_key_value` char(40) DEFAULT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `document_amount` decimal(17,4) DEFAULT 0.0000,
  `conversion_rate` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `base_amount` decimal(17,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `manual_ref_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`document_id`),
  UNIQUE KEY `idx` (`company_id`,`document_identity`),
  KEY `company_id` (`company_id`),
  KEY `company_branch_id` (`company_branch_id`),
  KEY `fiscal_year_id` (`fiscal_year_id`),
  KEY `partner_type_id` (`partner_type_id`),
  KEY `partner_id` (`partner_id`),
  KEY `document_type_id` (`document_type_id`),
  KEY `document_id` (`document_id`),
  KEY `document_identity` (`document_identity`),
  KEY `document_date` (`document_date`),
  KEY `is_post` (`is_post`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_language` */

DROP TABLE IF EXISTS `core_language`;

CREATE TABLE `core_language` (
  `language_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL,
  `directory` varchar(32) NOT NULL DEFAULT '',
  `filename` varchar(64) NOT NULL DEFAULT '',
  `sort_order` int(3) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`language_id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `core_ledger` */

DROP TABLE IF EXISTS `core_ledger`;

CREATE TABLE `core_ledger` (
  `ledger_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(40) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` tinyint(4) NOT NULL,
  `document_id` char(40) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_detail_id` char(40) NOT NULL,
  `document_date` date NOT NULL,
  `sort_order` tinyint(4) NOT NULL DEFAULT 0,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `ref_document_type_id` tinyint(4) DEFAULT 0,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `document_debit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `document_credit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` char(40) NOT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `debit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `credit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `product_id` char(40) NOT NULL,
  `qty` decimal(17,2) NOT NULL DEFAULT 0.00,
  `document_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `cheque_no` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `dc_no` text DEFAULT NULL,
  `customer_unit_id` varchar(255) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`ledger_id`),
  KEY `company_id` (`company_id`),
  KEY `company_branch_id` (`company_branch_id`),
  KEY `fiscal_year_id` (`fiscal_year_id`),
  KEY `document_type_id` (`document_type_id`),
  KEY `document_id` (`document_id`),
  KEY `document_identity` (`document_identity`),
  KEY `partner_type_id` (`partner_type_id`),
  KEY `partner_id` (`partner_id`),
  KEY `document_date` (`document_date`),
  KEY `ref_document_type_id` (`ref_document_type_id`),
  KEY `ref_document_identity` (`ref_document_identity`),
  KEY `coa_id` (`coa_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `core_log` */

DROP TABLE IF EXISTS `core_log`;

CREATE TABLE `core_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `document` varchar(255) DEFAULT NULL,
  `transaction_type` char(6) DEFAULT NULL,
  `document_no` varchar(255) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `primary_key` varchar(255) DEFAULT NULL,
  `primary_value` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_partner` */

DROP TABLE IF EXISTS `core_partner`;

CREATE TABLE `core_partner` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_type` varchar(255) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `partner_category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `gst_no` varchar(255) NOT NULL,
  `ntn_no` varchar(255) NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `day_limit` int(11) NOT NULL,
  `amount_limit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cash_account_id` char(40) NOT NULL,
  `outstanding_account_id` char(40) NOT NULL,
  `advance_account_id` char(40) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`partner_id`),
  KEY `partner_type_id` (`partner_type_id`),
  KEY `partner_id` (`partner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1;

/*Table structure for table `core_partner_category` */

DROP TABLE IF EXISTS `core_partner_category`;

CREATE TABLE `core_partner_category` (
  `partner_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`partner_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Table structure for table `core_salesman` */

DROP TABLE IF EXISTS `core_salesman`;

CREATE TABLE `core_salesman` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `partner_category_id` int(11) NOT NULL DEFAULT 0,
  `salesman_id` char(40) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) NOT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`salesman_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_setting` */

DROP TABLE IF EXISTS `core_setting`;

CREATE TABLE `core_setting` (
  `setting_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_stock_ledger` */

DROP TABLE IF EXISTS `core_stock_ledger`;

CREATE TABLE `core_stock_ledger` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_id` char(40) NOT NULL,
  `document_identity` varchar(255) DEFAULT NULL,
  `document_date` date DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `document_detail_id` char(40) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `document_unit_id` int(11) DEFAULT NULL,
  `document_qty` decimal(17,2) DEFAULT 0.00,
  `unit_conversion` decimal(11,2) DEFAULT 0.00,
  `base_unit_id` int(11) DEFAULT NULL,
  `base_qty` decimal(17,2) DEFAULT 0.00,
  `document_currency_id` int(11) DEFAULT NULL,
  `document_rate` decimal(17,2) DEFAULT 0.00,
  `document_amount` decimal(20,4) DEFAULT 0.0000,
  `currency_conversion` decimal(17,2) DEFAULT 0.00,
  `base_currency_id` int(11) DEFAULT NULL,
  `base_rate` decimal(17,2) DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `remarks` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`company_id`,`company_branch_id`,`fiscal_year_id`,`document_type_id`,`document_id`,`document_detail_id`,`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_supplier` */

DROP TABLE IF EXISTS `core_supplier`;

CREATE TABLE `core_supplier` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `partner_category_id` int(11) NOT NULL DEFAULT 0,
  `supplier_id` char(40) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `gst_no` varchar(255) NOT NULL,
  `ntn_no` varchar(255) NOT NULL,
  `day_limit` int(11) NOT NULL DEFAULT 0,
  `amount_limit` decimal(11,2) NOT NULL DEFAULT 0.00,
  `document_currency_id` int(11) DEFAULT NULL,
  `cash_account_id` char(40) NOT NULL,
  `outstanding_account_id` char(40) NOT NULL,
  `advance_account_id` char(40) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) NOT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `core_terms` */

DROP TABLE IF EXISTS `core_terms`;

CREATE TABLE `core_terms` (
  `company_id` char(40) DEFAULT NULL,
  `company_branch_id` char(40) DEFAULT NULL,
  `term_id` int(11) NOT NULL,
  `term` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gl0_coa_level1` */

DROP TABLE IF EXISTS `gl0_coa_level1`;

CREATE TABLE `gl0_coa_level1` (
  `coa_level1_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT 0,
  `gl_type_id` int(11) DEFAULT NULL,
  `level1_code` char(3) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`coa_level1_id`),
  UNIQUE KEY `level1_code` (`level1_code`,`coa_level1_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gl0_coa_level2` */

DROP TABLE IF EXISTS `gl0_coa_level2`;

CREATE TABLE `gl0_coa_level2` (
  `coa_level2_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `coa_level1_id` char(40) DEFAULT NULL,
  `level2_code` char(3) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`coa_level2_id`),
  UNIQUE KEY `uniq` (`coa_level1_id`,`level2_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gl0_coa_level3` */

DROP TABLE IF EXISTS `gl0_coa_level3`;

CREATE TABLE `gl0_coa_level3` (
  `coa_level3_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `coa_level2_id` char(40) DEFAULT NULL,
  `coa_level1_id` char(40) DEFAULT NULL,
  `level3_code` varchar(3) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`coa_level3_id`),
  UNIQUE KEY `uniq` (`coa_level2_id`,`coa_level1_id`,`level3_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gla_advance_payment` */

DROP TABLE IF EXISTS `gla_advance_payment`;

CREATE TABLE `gla_advance_payment` (
  `advance_payment_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(25) NOT NULL,
  `account_type` enum('BK','CA') DEFAULT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type_id` tinyint(4) NOT NULL,
  `partner_id` char(40) NOT NULL,
  `base_currency_id` char(40) NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `conversion_rate` decimal(9,4) NOT NULL DEFAULT 0.0000,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `remarks` text NOT NULL,
  `amount` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `wht_account_id` char(40) DEFAULT NULL,
  `wht_tax_amount` decimal(11,4) DEFAULT 0.0000,
  `base_amount` decimal(11,4) DEFAULT 0.0000,
  `base_wht_tax_amount` decimal(11,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `posted_by_id` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`advance_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gla_advance_payment_detail` */

DROP TABLE IF EXISTS `gla_advance_payment_detail`;

CREATE TABLE `gla_advance_payment_detail` (
  `advance_payment_detail_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `advance_payment_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  PRIMARY KEY (`advance_payment_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gla_advance_receipt` */

DROP TABLE IF EXISTS `gla_advance_receipt`;

CREATE TABLE `gla_advance_receipt` (
  `advance_receipt_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(25) NOT NULL,
  `account_type` enum('BK','CA') DEFAULT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type_id` tinyint(4) NOT NULL,
  `partner_id` char(40) NOT NULL,
  `base_currency_id` char(40) NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `conversion_rate` decimal(9,4) NOT NULL DEFAULT 0.0000,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(20) DEFAULT NULL,
  `remarks` text NOT NULL,
  `amount` decimal(11,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(11,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `posted_by_id` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`advance_receipt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gli_credit_invoice` */

DROP TABLE IF EXISTS `gli_credit_invoice`;

CREATE TABLE `gli_credit_invoice` (
  `credit_invoice_id` char(40) NOT NULL,
  `company_id` char(40) NOT NULL,
  `company_branch_id` char(40) NOT NULL,
  `fiscal_year_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(12) DEFAULT NULL,
  `document_no` int(11) NOT NULL,
  `document_identity` varchar(16) NOT NULL,
  `document_date` date NOT NULL,
  `manual_ref_no` varchar(255) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `discount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`credit_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gli_credit_invoice_detail` */

DROP TABLE IF EXISTS `gli_credit_invoice_detail`;

CREATE TABLE `gli_credit_invoice_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `credit_invoice_id` char(40) DEFAULT NULL,
  `credit_invoice_detail_id` char(40) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `amount` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) DEFAULT 0.0000,
  `base_amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`credit_invoice_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gli_debit_invoice` */

DROP TABLE IF EXISTS `gli_debit_invoice`;

CREATE TABLE `gli_debit_invoice` (
  `debit_invoice_id` char(40) NOT NULL,
  `company_id` char(40) NOT NULL,
  `company_branch_id` char(40) NOT NULL,
  `fiscal_year_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(16) DEFAULT NULL,
  `document_no` int(11) NOT NULL,
  `document_identity` varchar(32) NOT NULL,
  `document_date` date NOT NULL,
  `sale_tax_invoice` enum('Yes','No') NOT NULL DEFAULT 'No',
  `manual_ref_no` varchar(255) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `tax_account_id` char(38) DEFAULT NULL,
  `tax_percent` decimal(17,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(38) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(38) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` char(38) DEFAULT NULL,
  PRIMARY KEY (`debit_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `gli_debit_invoice_detail` */

DROP TABLE IF EXISTS `gli_debit_invoice_detail`;

CREATE TABLE `gli_debit_invoice_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `debit_invoice_id` char(40) DEFAULT NULL,
  `debit_invoice_detail_id` char(40) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`debit_invoice_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_bank_payment` */

DROP TABLE IF EXISTS `glt_bank_payment`;

CREATE TABLE `glt_bank_payment` (
  `bank_payment_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type_id` tinyint(4) NOT NULL,
  `partner_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_wht_amount` decimal(17,4) DEFAULT 0.0000,
  `total_other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `total_net_amount` decimal(17,4) DEFAULT 0.0000,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_total_amount` decimal(17,4) DEFAULT 0.0000,
  `base_total_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_net_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(40) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`bank_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_bank_payment_detail` */

DROP TABLE IF EXISTS `glt_bank_payment_detail`;

CREATE TABLE `glt_bank_payment_detail` (
  `bank_payment_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `bank_payment_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(32) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `document_amount` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `wht_percent` decimal(17,4) DEFAULT 0.0000,
  `wht_amount` decimal(17,4) DEFAULT 0.0000,
  `other_tax_percent` decimal(17,4) DEFAULT 0.0000,
  `other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `net_amount` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `base_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_net_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  PRIMARY KEY (`bank_payment_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_bank_receipt` */

DROP TABLE IF EXISTS `glt_bank_receipt`;

CREATE TABLE `glt_bank_receipt` (
  `bank_receipt_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type_id` tinyint(4) NOT NULL,
  `partner_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `wht_tax_per` decimal(17,4) DEFAULT 0.0000,
  `total_wht_amount` decimal(17,4) DEFAULT 0.0000,
  `ot_tax_per` decimal(17,4) DEFAULT 0.0000,
  `total_other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `total_net_amount` decimal(17,4) DEFAULT 0.0000,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_total_amount` decimal(17,4) DEFAULT 0.0000,
  `base_total_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_net_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(40) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `partner_category_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`bank_receipt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_bank_receipt_detail` */

DROP TABLE IF EXISTS `glt_bank_receipt_detail`;

CREATE TABLE `glt_bank_receipt_detail` (
  `bank_receipt_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `bank_receipt_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(32) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `document_amount` decimal(20,4) DEFAULT 0.0000,
  `balance_amount` decimal(17,4) DEFAULT 0.0000,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `bank_amount` decimal(17,4) DEFAULT 0.0000,
  `wht_percent` decimal(17,4) DEFAULT 0.0000,
  `wht_amount` decimal(17,4) DEFAULT 0.0000,
  `other_tax_percent` decimal(17,4) DEFAULT 0.0000,
  `other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `net_amount` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `base_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_net_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  `bank_name` varchar(255) DEFAULT '0.0000',
  PRIMARY KEY (`bank_receipt_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_bank_reconciliation` */

DROP TABLE IF EXISTS `glt_bank_reconciliation`;

CREATE TABLE `glt_bank_reconciliation` (
  `bank_reconciliation_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `coa_level3_id` varchar(40) DEFAULT NULL,
  `closing_balance` decimal(11,2) DEFAULT 0.00,
  `total_debit` decimal(17,4) DEFAULT 0.0000,
  `total_credit` decimal(17,4) DEFAULT 0.0000,
  `total_balance` decimal(17,4) DEFAULT 0.0000,
  `remarks` varchar(255) DEFAULT NULL,
  `is_post` tinyint(4) DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  PRIMARY KEY (`bank_reconciliation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_bank_reconciliation_detail` */

DROP TABLE IF EXISTS `glt_bank_reconciliation_detail`;

CREATE TABLE `glt_bank_reconciliation_detail` (
  `bank_reconciliation_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `bank_reconciliation_id` char(40) NOT NULL,
  `coa_level3_id` varchar(40) NOT NULL,
  `sort_order` tinyint(4) NOT NULL DEFAULT 0,
  `ref_document_id` varchar(40) DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `document_identity` varchar(255) DEFAULT NULL,
  `document_date` date DEFAULT NULL,
  `cheque_no` varchar(50) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `debit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `credit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `balance` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `clearing_date` date DEFAULT NULL,
  `qty` decimal(17,4) DEFAULT 0.0000,
  `document_amount` decimal(17,4) DEFAULT 0.0000,
  `amount` decimal(17,4) DEFAULT 0.0000,
  `clearance` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`bank_reconciliation_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_cash_book` */

DROP TABLE IF EXISTS `glt_cash_book`;

CREATE TABLE `glt_cash_book` (
  `cash_book_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(40) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cash_book_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_cash_book_detail` */

DROP TABLE IF EXISTS `glt_cash_book_detail`;

CREATE TABLE `glt_cash_book_detail` (
  `cash_book_detail_id` char(40) NOT NULL,
  `cash_book_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `partner_name` varchar(255) DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `dc_no` text DEFAULT NULL,
  `document_amount` decimal(20,4) DEFAULT 0.0000,
  `balance_amount` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  PRIMARY KEY (`cash_book_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_cash_payment` */

DROP TABLE IF EXISTS `glt_cash_payment`;

CREATE TABLE `glt_cash_payment` (
  `cash_payment_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type_id` tinyint(4) NOT NULL,
  `partner_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_wht_amount` decimal(17,4) DEFAULT 0.0000,
  `total_other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `total_net_amount` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_total_amount` decimal(17,4) DEFAULT 0.0000,
  `base_total_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_net_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(40) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`cash_payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_cash_payment_detail` */

DROP TABLE IF EXISTS `glt_cash_payment_detail`;

CREATE TABLE `glt_cash_payment_detail` (
  `cash_payment_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `cash_payment_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `document_amount` decimal(20,4) DEFAULT 0.0000,
  `document_currency_id` int(11) DEFAULT NULL,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `wht_percent` decimal(17,4) DEFAULT 0.0000,
  `wht_amount` decimal(17,4) DEFAULT 0.0000,
  `other_tax_percent` decimal(17,4) DEFAULT 0.0000,
  `other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `net_amount` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `base_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_net_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  PRIMARY KEY (`cash_payment_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_cash_receipt` */

DROP TABLE IF EXISTS `glt_cash_receipt`;

CREATE TABLE `glt_cash_receipt` (
  `cash_receipt_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type_id` tinyint(4) NOT NULL,
  `partner_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_wht_amount` decimal(17,4) DEFAULT 0.0000,
  `total_other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `total_net_amount` decimal(17,4) DEFAULT 0.0000,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_total_amount` decimal(17,4) DEFAULT 0.0000,
  `base_total_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_net_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(40) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cash_receipt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_cash_receipt_detail` */

DROP TABLE IF EXISTS `glt_cash_receipt_detail`;

CREATE TABLE `glt_cash_receipt_detail` (
  `cash_receipt_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `cash_receipt_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(32) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `document_amount` decimal(20,4) DEFAULT 0.0000,
  `document_currency_id` int(11) DEFAULT NULL,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `wht_percent` decimal(17,4) DEFAULT 0.0000,
  `wht_amount` decimal(17,4) DEFAULT 0.0000,
  `other_tax_percent` decimal(17,4) DEFAULT 0.0000,
  `other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `net_amount` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `base_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_net_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  PRIMARY KEY (`cash_receipt_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_fund_transfer` */

DROP TABLE IF EXISTS `glt_fund_transfer`;

CREATE TABLE `glt_fund_transfer` (
  `fund_transfer_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type_id` tinyint(4) NOT NULL,
  `partner_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_wht_amount` decimal(17,4) DEFAULT 0.0000,
  `total_other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `total_net_amount` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_total_amount` decimal(17,4) DEFAULT 0.0000,
  `base_total_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_total_net_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(40) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  `instrument_date` date DEFAULT NULL,
  `instrument_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`fund_transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_fund_transfer_detail` */

DROP TABLE IF EXISTS `glt_fund_transfer_detail`;

CREATE TABLE `glt_fund_transfer_detail` (
  `fund_transfer_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `fund_transfer_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `document_amount` decimal(20,4) DEFAULT 0.0000,
  `document_currency_id` int(11) DEFAULT NULL,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `wht_percent` decimal(17,4) DEFAULT 0.0000,
  `wht_amount` decimal(17,4) DEFAULT 0.0000,
  `other_tax_percent` decimal(17,4) DEFAULT 0.0000,
  `other_tax_amount` decimal(17,4) DEFAULT 0.0000,
  `net_amount` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `base_wht_amount` decimal(20,4) DEFAULT 0.0000,
  `base_other_tax_amount` decimal(20,4) DEFAULT 0.0000,
  `base_net_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  PRIMARY KEY (`fund_transfer_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_journal_voucher` */

DROP TABLE IF EXISTS `glt_journal_voucher`;

CREATE TABLE `glt_journal_voucher` (
  `journal_voucher_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `document_debit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `document_credit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` char(40) DEFAULT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_debit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_credit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`journal_voucher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_journal_voucher_detail` */

DROP TABLE IF EXISTS `glt_journal_voucher_detail`;

CREATE TABLE `glt_journal_voucher_detail` (
  `journal_voucher_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `journal_voucher_id` char(40) NOT NULL,
  `sort_order` tinyint(4) DEFAULT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `document_debit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `document_credit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_debit` decimal(20,4) DEFAULT 0.0000,
  `base_credit` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`journal_voucher_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_payment` */

DROP TABLE IF EXISTS `glt_payment`;

CREATE TABLE `glt_payment` (
  `payment_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `voucher_no` varchar(255) NOT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type` varchar(255) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `remarks` text NOT NULL,
  `documrnt_currency_id` int(11) DEFAULT NULL,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_payment_detail` */

DROP TABLE IF EXISTS `glt_payment_detail`;

CREATE TABLE `glt_payment_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `payment_id` char(40) NOT NULL,
  `payment_detail_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `document_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) DEFAULT 0.0000,
  `base_amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`payment_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_receipt` */

DROP TABLE IF EXISTS `glt_receipt`;

CREATE TABLE `glt_receipt` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `receipt_id` char(40) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `voucher_no` varchar(255) NOT NULL,
  `transaction_type` enum('Cash','Credit') DEFAULT NULL,
  `transaction_account_id` char(40) NOT NULL,
  `partner_type` varchar(255) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`receipt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `glt_receipt_detail` */

DROP TABLE IF EXISTS `glt_receipt_detail`;

CREATE TABLE `glt_receipt_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `receipt_id` char(40) NOT NULL,
  `receipt_detail_id` char(40) NOT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `coa_id` char(40) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `cheque_date` date DEFAULT NULL,
  `cheque_no` varchar(16) DEFAULT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT NULL,
  `base_amount` decimal(20,4) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`receipt_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `glt_transfer_settlement` */

DROP TABLE IF EXISTS `glt_transfer_settlement`;

CREATE TABLE `glt_transfer_settlement` (
  `transfer_settlement_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` char(40) DEFAULT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  `to_branch_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`transfer_settlement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `in0_make` */

DROP TABLE IF EXISTS `in0_make`;

CREATE TABLE `in0_make` (
  `make_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` char(40) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`make_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `in0_model` */

DROP TABLE IF EXISTS `in0_model`;

CREATE TABLE `in0_model` (
  `model_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` char(40) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `in0_product` */

DROP TABLE IF EXISTS `in0_product`;

CREATE TABLE `in0_product` (
  `company_id` int(11) DEFAULT NULL,
  `product_id` char(40) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) DEFAULT NULL,
  `product_code` varchar(255) NOT NULL,
  `serial_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `make_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `reorder_quantity` int(11) NOT NULL DEFAULT 0,
  `cost_price` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `sale_price` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cogs_account_id` char(40) NOT NULL,
  `inventory_account_id` char(40) NOT NULL,
  `revenue_account_id` char(40) NOT NULL,
  `adjustment_account_id` char(40) NOT NULL,
  `sale_profit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `wholesale_price` decimal(17,4) DEFAULT 0.0000,
  `minimum_price` decimal(17,4) DEFAULT 0.0000,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `in0_product12` */

DROP TABLE IF EXISTS `in0_product12`;

CREATE TABLE `in0_product12` (
  `company_id` int(11) DEFAULT NULL,
  `product_id` char(40) NOT NULL,
  `product_category_id` int(11) NOT NULL,
  `product_sub_category_id` int(11) DEFAULT NULL,
  `product_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `manufacture_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `make_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `reorder_quantity` int(11) NOT NULL DEFAULT 0,
  `cost_price` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `sale_price` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cogs_account_id` char(40) NOT NULL,
  `inventory_account_id` char(40) NOT NULL,
  `revenue_account_id` char(40) NOT NULL,
  `adjustment_account_id` char(40) NOT NULL,
  `sale_profit` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `status` enum('Active','Inactive') NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `in0_product_branch_rate` */

DROP TABLE IF EXISTS `in0_product_branch_rate`;

CREATE TABLE `in0_product_branch_rate` (
  `company_id` int(11) NOT NULL DEFAULT 0,
  `branch_id` int(11) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `rate` decimal(11,2) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `ref_c_id` int(11) DEFAULT NULL,
  `ref_p_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `in0_product_category` */

DROP TABLE IF EXISTS `in0_product_category`;

CREATE TABLE `in0_product_category` (
  `company_id` int(11) NOT NULL DEFAULT 0,
  `product_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

/*Table structure for table `in0_product_customer_rate` */

DROP TABLE IF EXISTS `in0_product_customer_rate`;

CREATE TABLE `in0_product_customer_rate` (
  `company_id` int(11) NOT NULL DEFAULT 0,
  `customer_id` char(40) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `rate` decimal(11,2) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `ref_c_id` int(11) DEFAULT NULL,
  `ref_p_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `in0_product_package` */

DROP TABLE IF EXISTS `in0_product_package`;

CREATE TABLE `in0_product_package` (
  `company_id` int(11) DEFAULT NULL,
  `product_package_id` char(40) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `conversion_rate` float DEFAULT NULL,
  `cost_price` decimal(11,2) DEFAULT 0.00,
  `sale_price` decimal(11,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`product_package_id`),
  UNIQUE KEY `unique_id` (`product_id`,`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `in0_product_price` */

DROP TABLE IF EXISTS `in0_product_price`;

CREATE TABLE `in0_product_price` (
  `company_id` int(11) DEFAULT NULL,
  `product_price_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` char(40) DEFAULT NULL,
  `unit_id` int(3) DEFAULT NULL,
  `qty` decimal(11,2) DEFAULT 0.00,
  `sale_price` decimal(11,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`product_price_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `in0_product_sub_category` */

DROP TABLE IF EXISTS `in0_product_sub_category`;

CREATE TABLE `in0_product_sub_category` (
  `company_id` int(11) NOT NULL DEFAULT 0,
  `product_sub_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_sub_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

/*Table structure for table `in0_unit` */

DROP TABLE IF EXISTS `in0_unit`;

CREATE TABLE `in0_unit` (
  `company_id` int(11) NOT NULL DEFAULT 0,
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

/*Table structure for table `in0_warehouse` */

DROP TABLE IF EXISTS `in0_warehouse`;

CREATE TABLE `in0_warehouse` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` int(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

/*Table structure for table `ina_consumption` */

DROP TABLE IF EXISTS `ina_consumption`;

CREATE TABLE `ina_consumption` (
  `inventory_consumption_id` char(40) NOT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` char(40) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(16) NOT NULL,
  `department_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `terms` varchar(255) DEFAULT NULL,
  `document_currency_id` char(40) NOT NULL,
  `base_currency_id` char(40) NOT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`inventory_consumption_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_consumption_detail` */

DROP TABLE IF EXISTS `ina_consumption_detail`;

CREATE TABLE `ina_consumption_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `inventory_consumption_id` char(40) NOT NULL,
  `inventory_consumption_detail_id` char(40) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`inventory_consumption_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_opening_stock` */

DROP TABLE IF EXISTS `ina_opening_stock`;

CREATE TABLE `ina_opening_stock` (
  `opening_stock_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_identity` varchar(255) DEFAULT NULL,
  `document_date` date NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `remarks` varchar(255) NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `net_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) DEFAULT 0.0000,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` char(40) NOT NULL,
  PRIMARY KEY (`opening_stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_opening_stock_detail` */

DROP TABLE IF EXISTS `ina_opening_stock_detail`;

CREATE TABLE `ina_opening_stock_detail` (
  `opening_stock_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `opening_stock_id` char(40) NOT NULL,
  `sort_order` tinyint(4) NOT NULL DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `qty` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `document_currency_id` int(11) DEFAULT NULL,
  `rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) DEFAULT NULL,
  `base_amount` decimal(17,4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`opening_stock_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_stock_adjustment` */

DROP TABLE IF EXISTS `ina_stock_adjustment`;

CREATE TABLE `ina_stock_adjustment` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `stock_adjustment_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` char(40) NOT NULL,
  `total_qty` decimal(17,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_currency_id` int(11) NOT NULL,
  `base_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stock_adjustment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_stock_adjustment_detail` */

DROP TABLE IF EXISTS `ina_stock_adjustment_detail`;

CREATE TABLE `ina_stock_adjustment_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `stock_adjustment_id` char(40) NOT NULL,
  `stock_adjustment_detail_id` char(40) NOT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `stock_qty` decimal(11,2) DEFAULT 0.00,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_rate` decimal(17,4) DEFAULT 0.0000,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`stock_adjustment_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_stock_in` */

DROP TABLE IF EXISTS `ina_stock_in`;

CREATE TABLE `ina_stock_in` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `stock_in_id` char(40) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `total_qty` decimal(17,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stock_in_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_stock_in_detail` */

DROP TABLE IF EXISTS `ina_stock_in_detail`;

CREATE TABLE `ina_stock_in_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `stock_in_id` char(40) NOT NULL,
  `stock_in_detail_id` char(40) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `unit_id` int(40) NOT NULL,
  `stock_qty` decimal(17,4) DEFAULT 0.0000,
  `qty` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cog_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cog_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_cog_rate` decimal(17,4) DEFAULT 0.0000,
  `base_cog_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stock_in_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_stock_out` */

DROP TABLE IF EXISTS `ina_stock_out`;

CREATE TABLE `ina_stock_out` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `stock_out_id` char(40) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `total_qty` decimal(17,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stock_out_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_stock_out_detail` */

DROP TABLE IF EXISTS `ina_stock_out_detail`;

CREATE TABLE `ina_stock_out_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `stock_out_id` char(40) NOT NULL,
  `stock_out_detail_id` char(40) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `unit_id` int(40) NOT NULL,
  `stock_qty` decimal(17,4) DEFAULT 0.0000,
  `qty` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cog_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cog_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_cog_rate` decimal(17,4) DEFAULT 0.0000,
  `base_cog_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`stock_out_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_stock_transfer` */

DROP TABLE IF EXISTS `ina_stock_transfer`;

CREATE TABLE `ina_stock_transfer` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `stock_transfer_id` char(40) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `total_qty` decimal(17,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `to_branch_id` int(11) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `billty_date` date DEFAULT NULL,
  `billty_no` varchar(50) DEFAULT NULL,
  `billty_remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`stock_transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ina_stock_transfer_detail` */

DROP TABLE IF EXISTS `ina_stock_transfer_detail`;

CREATE TABLE `ina_stock_transfer_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `stock_transfer_id` char(40) NOT NULL,
  `stock_transfer_detail_id` char(40) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `to_company_branch_id` int(11) DEFAULT NULL,
  `warehouse_id` int(40) DEFAULT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `unit_id` int(40) NOT NULL,
  `stock_qty` decimal(17,4) DEFAULT 0.0000,
  `qty` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cog_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `cog_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_cog_rate` decimal(17,4) DEFAULT 0.0000,
  `base_cog_amount` decimal(20,4) DEFAULT 0.0000,
  `rate` decimal(17,4) DEFAULT 0.0000,
  `amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`stock_transfer_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `inp_goods_received` */

DROP TABLE IF EXISTS `inp_goods_received`;

CREATE TABLE `inp_goods_received` (
  `goods_received_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `ref_document_type_id` int(11) NOT NULL,
  `ref_document_identity` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(40) NOT NULL,
  `net_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(40) NOT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) DEFAULT 0.0000,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`goods_received_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `inp_goods_received_detail` */

DROP TABLE IF EXISTS `inp_goods_received_detail`;

CREATE TABLE `inp_goods_received_detail` (
  `goods_received_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `goods_received_id` char(40) NOT NULL,
  `ref_document_id` varchar(40) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_code` varchar(255) NOT NULL,
  `product_id` char(40) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`goods_received_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `inp_purchase_invoice` */

DROP TABLE IF EXISTS `inp_purchase_invoice`;

CREATE TABLE `inp_purchase_invoice` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `purchase_invoice_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date NOT NULL,
  `batch_no` varchar(16) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `manual_ref_no` varchar(10) NOT NULL,
  `builty_no` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `remarks2` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `item_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_tax` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_other_expence` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_total` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cash_paid` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `balance_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `base_cash_received` decimal(20,4) DEFAULT 0.0000,
  `base_balance_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`purchase_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `inp_purchase_invoice_detail` */

DROP TABLE IF EXISTS `inp_purchase_invoice_detail`;

CREATE TABLE `inp_purchase_invoice_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `purchase_invoice_id` char(40) NOT NULL,
  `purchase_invoice_detail_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) NOT NULL,
  `ref_document_identity` varchar(255) NOT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `discount_percent` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `discount_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `gross_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `other_expence` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `tax_percent` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `tax_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_total` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`purchase_invoice_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `inp_purchase_order` */

DROP TABLE IF EXISTS `inp_purchase_order`;

CREATE TABLE `inp_purchase_order` (
  `purchase_order_id` char(40) NOT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` char(40) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `batch_no` varchar(16) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `remarks` text NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `terms` varchar(255) DEFAULT NULL,
  `document_currency_id` char(40) NOT NULL,
  `base_currency_id` char(40) NOT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`purchase_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `inp_purchase_order_detail` */

DROP TABLE IF EXISTS `inp_purchase_order_detail`;

CREATE TABLE `inp_purchase_order_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `purchase_order_id` char(40) NOT NULL,
  `purchase_order_detail_id` char(40) NOT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `product_service` tinyint(4) NOT NULL,
  `expiry_date` date NOT NULL,
  `document_currency_id` varchar(40) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`purchase_order_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `inp_purchase_requisition` */

DROP TABLE IF EXISTS `inp_purchase_requisition`;

CREATE TABLE `inp_purchase_requisition` (
  `purchase_requisition_id` char(40) NOT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` char(40) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `batch_no` varchar(16) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `remarks` text NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `terms` varchar(255) DEFAULT NULL,
  `total_qty` decimal(11,2) DEFAULT 0.00,
  `document_currency_id` char(40) NOT NULL,
  `base_currency_id` char(40) NOT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`purchase_requisition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `inp_purchase_requisition_detail` */

DROP TABLE IF EXISTS `inp_purchase_requisition_detail`;

CREATE TABLE `inp_purchase_requisition_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `purchase_requisition_id` char(40) NOT NULL,
  `purchase_requisition_detail_id` char(40) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `product_service` tinyint(4) NOT NULL,
  `expiry_date` date NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`purchase_requisition_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `inp_purchase_return` */

DROP TABLE IF EXISTS `inp_purchase_return`;

CREATE TABLE `inp_purchase_return` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `purchase_return_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `remarks` text NOT NULL,
  `remarks2` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `item_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_tax` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_other_expence` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_total` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `deduction_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cash_received` decimal(20,4) DEFAULT 0.0000,
  `balance_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_cash_received` decimal(20,4) DEFAULT 0.0000,
  `base_balanace_amount` decimal(20,4) DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`purchase_return_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `inp_purchase_return_detail` */

DROP TABLE IF EXISTS `inp_purchase_return_detail`;

CREATE TABLE `inp_purchase_return_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `purchase_return_id` char(40) NOT NULL,
  `purchase_return_detail_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `ref_document_type_id` int(11) NOT NULL,
  `ref_document_identity` varchar(255) NOT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `warehouse_id` int(40) NOT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `unit_id` int(40) NOT NULL,
  `purchase_qty` decimal(11,2) DEFAULT 0.00,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `discount_percent` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `discount_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `gross_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `other_expence` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `tax_percent` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `tax_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_total` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`purchase_return_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_delivery_challan` */

DROP TABLE IF EXISTS `ins_delivery_challan`;

CREATE TABLE `ins_delivery_challan` (
  `delivery_challan_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `ref_document_type_id` int(11) NOT NULL,
  `ref_document_identity` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `document_currency_id` int(40) NOT NULL,
  `total_qty` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(40) NOT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) DEFAULT 0.0000,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `customer_unit_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `challan_type` enum('GST','Non GST') DEFAULT 'GST',
  `status` varchar(50) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`delivery_challan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_delivery_challan_detail` */

DROP TABLE IF EXISTS `ins_delivery_challan_detail`;

CREATE TABLE `ins_delivery_challan_detail` (
  `delivery_challan_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `delivery_challan_id` char(40) NOT NULL,
  `ref_document_id` varchar(40) DEFAULT NULL,
  `ref_document_identity` varchar(40) DEFAULT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `stock_qty` decimal(11,2) DEFAULT 0.00,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `document_currency_id` int(11) DEFAULT NULL,
  `rate` decimal(11,2) DEFAULT NULL,
  `cog_rate` decimal(17,4) DEFAULT 0.0000,
  `cog_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) DEFAULT 0.0000,
  `base_cog_rate` decimal(17,4) DEFAULT 0.0000,
  `base_cog_amount` decimal(17,4) DEFAULT 0.0000,
  `tax_percent` decimal(17,4) DEFAULT 0.0000,
  `tax_amount` decimal(17,4) DEFAULT 0.0000,
  `net_amount` decimal(17,4) DEFAULT 0.0000,
  `created_by_id` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `unit_master` varchar(255) DEFAULT NULL,
  `p_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`delivery_challan_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_delivery_challan_detail12` */

DROP TABLE IF EXISTS `ins_delivery_challan_detail12`;

CREATE TABLE `ins_delivery_challan_detail12` (
  `delivery_challan_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `delivery_challan_id` char(40) NOT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `stock_qty` decimal(11,2) DEFAULT 0.00,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `document_currency_id` int(11) DEFAULT NULL,
  `cog_rate` decimal(17,4) DEFAULT 0.0000,
  `cog_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(17,4) DEFAULT 0.0000,
  `base_cog_rate` decimal(17,4) DEFAULT 0.0000,
  `base_cog_amount` decimal(17,4) DEFAULT 0.0000,
  `tax_percent` decimal(17,4) DEFAULT 0.0000,
  `tax_amount` decimal(17,4) DEFAULT 0.0000,
  `net_amount` decimal(17,4) DEFAULT 0.0000,
  `created_by_id` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `unit_master` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`delivery_challan_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_job_order` */

DROP TABLE IF EXISTS `ins_job_order`;

CREATE TABLE `ins_job_order` (
  `job_order_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_contact` varchar(255) DEFAULT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `repair_status` char(40) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_id` char(40) DEFAULT NULL,
  `product_model` char(40) DEFAULT NULL,
  `product_serial_no` char(40) DEFAULT NULL,
  `warranty_status` char(40) DEFAULT NULL,
  `warranty_type` varchar(255) DEFAULT NULL,
  `service_charges` decimal(20,4) DEFAULT 0.0000,
  `warranty_card_no` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `repair_receive_date` date DEFAULT NULL,
  `repair_complete_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `fault_description` varchar(255) DEFAULT NULL,
  `symptom` varchar(255) DEFAULT NULL,
  `repair_remarks` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_by` varchar(64) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` varchar(64) DEFAULT NULL,
  `modified_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`job_order_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_job_order_estimate` */

DROP TABLE IF EXISTS `ins_job_order_estimate`;

CREATE TABLE `ins_job_order_estimate` (
  `job_order_estimate_id` char(40) NOT NULL,
  `job_order_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_by` varchar(64) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` varchar(64) DEFAULT NULL,
  `modified_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`job_order_estimate_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `ins_job_order_estimate_detail` */

DROP TABLE IF EXISTS `ins_job_order_estimate_detail`;

CREATE TABLE `ins_job_order_estimate_detail` (
  `job_order_estimate_detail_id` char(40) NOT NULL,
  `job_order_estimate_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `product_code` varchar(64) DEFAULT NULL,
  `part_name` varchar(64) DEFAULT NULL,
  `product_id` varchar(64) DEFAULT NULL,
  `product_type` varchar(64) DEFAULT NULL,
  `quantity` decimal(20,4) DEFAULT 0.0000,
  `rate` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_by` varchar(64) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` varchar(64) DEFAULT NULL,
  `modified_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`job_order_estimate_detail_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `ins_pos_invoice` */

DROP TABLE IF EXISTS `ins_pos_invoice`;

CREATE TABLE `ins_pos_invoice` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `pos_invoice_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `partner_type_id` varchar(255) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `salesman_id` varchar(40) DEFAULT NULL,
  `warehouse_id` varchar(40) DEFAULT NULL,
  `remarks` text NOT NULL,
  `remarks2` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `item_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_tax` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_total` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cash_received` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `balance_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `contact_no` varchar(13) DEFAULT NULL,
  `customer` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`pos_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `ins_pos_invoice_detail` */

DROP TABLE IF EXISTS `ins_pos_invoice_detail`;

CREATE TABLE `ins_pos_invoice_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `pos_invoice_id` char(40) DEFAULT NULL,
  `pos_invoice_detail_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `warehouse_id` int(11) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `product_code` varchar(16) DEFAULT NULL,
  `document_curency_id` int(11) DEFAULT NULL,
  `unit_id` char(40) DEFAULT NULL,
  `qty` decimal(11,2) DEFAULT 0.00,
  `rate` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(20,4) DEFAULT 0.0000,
  `discount_percent` decimal(20,4) DEFAULT 0.0000,
  `discount_amount` decimal(20,4) DEFAULT 0.0000,
  `gross_amount` decimal(20,4) DEFAULT 0.0000,
  `other_expence` decimal(20,4) DEFAULT 0.0000,
  `tax_percent` decimal(20,4) DEFAULT 0.0000,
  `tax_amount` decimal(20,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_total` decimal(20,4) DEFAULT 0.0000,
  `remarks` text DEFAULT NULL,
  `cog_rate` decimal(17,4) DEFAULT 0.0000,
  `cog_amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`pos_invoice_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_product_issuance` */

DROP TABLE IF EXISTS `ins_product_issuance`;

CREATE TABLE `ins_product_issuance` (
  `product_issuance_id` char(40) NOT NULL,
  `job_order_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date DEFAULT NULL,
  `total_amount` decimal(20,4) DEFAULT 0.0000,
  `total_quantity` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_by` varchar(64) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` varchar(64) DEFAULT NULL,
  `modified_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`product_issuance_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `ins_product_issuance_detail` */

DROP TABLE IF EXISTS `ins_product_issuance_detail`;

CREATE TABLE `ins_product_issuance_detail` (
  `product_issuance_detail_id` char(40) NOT NULL,
  `product_issuance_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `product_code` varchar(64) DEFAULT NULL,
  `product_id` varchar(64) DEFAULT NULL,
  `part_name` varchar(64) DEFAULT NULL,
  `product_type` varchar(64) DEFAULT NULL,
  `quantity` decimal(20,4) DEFAULT 0.0000,
  `rate` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_by` varchar(64) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by` varchar(64) DEFAULT NULL,
  `modified_by_id` char(40) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_issuance_detail_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `ins_quotation` */

DROP TABLE IF EXISTS `ins_quotation`;

CREATE TABLE `ins_quotation` (
  `quotation_id` char(40) NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `document_date` date NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `customer_ref_no` varchar(255) DEFAULT NULL,
  `customer_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `ref_no` varchar(255) DEFAULT NULL,
  `attn` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `term_id` text DEFAULT NULL,
  `total_quantity` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `item_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `item_tax` decimal(17,4) DEFAULT 0.0000,
  `item_total` decimal(10,0) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  `term_desc` text DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`quotation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_quotation_detail` */

DROP TABLE IF EXISTS `ins_quotation_detail`;

CREATE TABLE `ins_quotation_detail` (
  `quotation_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `quotation_id` char(40) NOT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `delivery` varchar(255) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(17,4) DEFAULT 0.0000,
  `amount` decimal(17,4) DEFAULT 0.0000,
  `tax_percent` decimal(20,4) DEFAULT 0.0000,
  `tax_amount` decimal(17,4) DEFAULT 0.0000,
  `net_amount` decimal(20,4) DEFAULT 0.0000,
  `created_by_id` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`quotation_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_sale_inquiry` */

DROP TABLE IF EXISTS `ins_sale_inquiry`;

CREATE TABLE `ins_sale_inquiry` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `sale_inquiry_id` char(40) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `voucher_date` date NOT NULL,
  `voucher_no` varchar(255) NOT NULL,
  `partner_type` varchar(255) DEFAULT NULL,
  `partner_id` char(40) DEFAULT NULL,
  `document_currency_id` int(11) NOT NULL,
  `address` varchar(30) DEFAULT NULL,
  `ref_document_no` varchar(11) DEFAULT NULL,
  `remarks` text NOT NULL,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `created_by_id` int(11) NOT NULL,
  PRIMARY KEY (`sale_inquiry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_sale_inquiry_detail` */

DROP TABLE IF EXISTS `ins_sale_inquiry_detail`;

CREATE TABLE `ins_sale_inquiry_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `sale_inquiry_id` char(40) NOT NULL,
  `sale_inquiry_detail_id` char(40) NOT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `warehouse_id` int(40) NOT NULL,
  `unit_id` int(40) NOT NULL,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sale_inquiry_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_sale_invoice` */

DROP TABLE IF EXISTS `ins_sale_invoice`;

CREATE TABLE `ins_sale_invoice` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `sale_invoice_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `partner_type_id` varchar(255) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `ref_invoice_no` varchar(32) NOT NULL,
  `billty_date` char(10) NOT NULL,
  `billty_no` varchar(32) NOT NULL,
  `manual_ref_no` varchar(11) DEFAULT NULL,
  `remarks` text NOT NULL,
  `remarks2` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `item_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_tax` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_other_expence` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_total` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cartage` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cash_received` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `balance_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `dc_no` varchar(255) DEFAULT NULL,
  `ref_document_id` text DEFAULT NULL,
  `customer_unit_id` char(40) DEFAULT NULL,
  `billty_remarks` varchar(255) DEFAULT NULL,
  `customer_remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sale_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `ins_sale_invoice_detail` */

DROP TABLE IF EXISTS `ins_sale_invoice_detail`;

CREATE TABLE `ins_sale_invoice_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `sale_invoice_id` char(40) DEFAULT NULL,
  `sale_invoice_detail_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `batch_no` varchar(16) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `product_code` varchar(16) DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT 0,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `documrnt_curency_id` int(11) DEFAULT NULL,
  `unit_id` char(40) DEFAULT NULL,
  `qty` decimal(11,2) DEFAULT 0.00,
  `rate` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(20,4) DEFAULT 0.0000,
  `discount_percent` decimal(20,4) DEFAULT 0.0000,
  `discount_amount` decimal(20,4) DEFAULT 0.0000,
  `gross_amount` decimal(20,4) DEFAULT 0.0000,
  `other_expence` decimal(20,4) DEFAULT 0.0000,
  `tax_percent` decimal(20,4) DEFAULT 0.0000,
  `tax_amount` decimal(20,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_total` decimal(20,4) DEFAULT 0.0000,
  `remarks` text DEFAULT NULL,
  `cog_rate` decimal(17,4) DEFAULT 0.0000,
  `cog_amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`sale_invoice_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_sale_order` */

DROP TABLE IF EXISTS `ins_sale_order`;

CREATE TABLE `ins_sale_order` (
  `sale_order_id` char(40) NOT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` char(40) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `salesman_id` char(40) NOT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `remarks` text NOT NULL,
  `manual_ref_no` varchar(255) DEFAULT NULL,
  `terms` varchar(255) DEFAULT NULL,
  `document_currency_id` char(40) NOT NULL,
  `base_currency_id` char(40) NOT NULL,
  `conversion_rate` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `total_quantity` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `item_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `item_total` decimal(17,4) DEFAULT 0.0000,
  `item_tax` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `base_amount` decimal(17,4) NOT NULL DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `customer_unit_id` char(40) DEFAULT NULL,
  `partner_category_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`sale_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `ins_sale_order_detail` */

DROP TABLE IF EXISTS `ins_sale_order_detail`;

CREATE TABLE `ins_sale_order_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `sale_order_id` char(40) NOT NULL,
  `sale_order_detail_id` char(40) NOT NULL,
  `ref_document_type_id` int(11) DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(16) NOT NULL,
  `product_service` tinyint(4) NOT NULL,
  `expiry_date` date NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `qty` decimal(11,2) NOT NULL DEFAULT 0.00,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `tax_percent` decimal(17,4) DEFAULT 0.0000,
  `tax_amount` decimal(20,4) DEFAULT 0.0000,
  `net_amount` decimal(20,4) DEFAULT 0.0000,
  `base_net_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sale_order_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_sale_return` */

DROP TABLE IF EXISTS `ins_sale_return`;

CREATE TABLE `ins_sale_return` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `sale_return_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `customer_unit_id` varchar(40) DEFAULT NULL,
  `partner_type_id` varchar(255) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `ref_invoice_no` varchar(32) NOT NULL,
  `billty_date` char(10) NOT NULL,
  `billty_no` varchar(32) NOT NULL,
  `manual_ref_no` varchar(11) DEFAULT NULL,
  `remarks` text NOT NULL,
  `remarks2` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `item_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_tax` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_other_expence` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_total` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cartage_charges` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `deduction_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cash_returned` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `balance_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `project_id` char(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`sale_return_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `ins_sale_return_detail` */

DROP TABLE IF EXISTS `ins_sale_return_detail`;

CREATE TABLE `ins_sale_return_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `sale_return_id` char(40) DEFAULT NULL,
  `sale_return_detail_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `batch_no` varchar(16) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `product_code` varchar(16) DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT 0,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `documrnt_curency_id` int(11) DEFAULT NULL,
  `unit_id` char(40) DEFAULT NULL,
  `qty` decimal(11,2) DEFAULT 0.00,
  `rate` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(20,4) DEFAULT 0.0000,
  `discount_percent` decimal(20,4) DEFAULT 0.0000,
  `discount_amount` decimal(20,4) DEFAULT 0.0000,
  `gross_amount` decimal(20,4) DEFAULT 0.0000,
  `other_expence` decimal(20,4) DEFAULT 0.0000,
  `tax_percent` decimal(20,4) DEFAULT 0.0000,
  `tax_amount` decimal(20,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_total` decimal(20,4) DEFAULT 0.0000,
  `remarks` text DEFAULT NULL,
  `cog_rate` decimal(17,4) DEFAULT 0.0000,
  `cog_amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`sale_return_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `ins_sale_tax_invoice` */

DROP TABLE IF EXISTS `ins_sale_tax_invoice`;

CREATE TABLE `ins_sale_tax_invoice` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `sale_tax_no` varchar(11) DEFAULT NULL,
  `sale_tax_invoice_id` char(40) NOT NULL,
  `sale_type` varchar(40) DEFAULT NULL,
  `invoice_type` varchar(40) DEFAULT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `partner_type_id` varchar(255) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `ref_invoice_no` varchar(32) NOT NULL,
  `billty_date` char(10) NOT NULL,
  `billty_no` varchar(32) NOT NULL,
  `manual_ref_no` varchar(11) DEFAULT NULL,
  `remarks` text NOT NULL,
  `remarks2` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `item_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_tax` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_other_expence` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_total` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cartage` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `discount_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cash_received` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `balance_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `po_date` date DEFAULT NULL,
  `po_no` varchar(255) DEFAULT NULL,
  `dc_no` varchar(255) DEFAULT NULL,
  `ref_document_id` text DEFAULT NULL,
  `customer_unit_id` char(40) DEFAULT NULL,
  `customer_remarks` varchar(255) DEFAULT NULL,
  `allow_out_of_stock` int(11) DEFAULT NULL,
  `project_id` varchar(40) DEFAULT NULL,
  `sub_project_id` char(40) DEFAULT NULL,
  `job_cart_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`sale_tax_invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `ins_sale_tax_invoice_detail` */

DROP TABLE IF EXISTS `ins_sale_tax_invoice_detail`;

CREATE TABLE `ins_sale_tax_invoice_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `sale_tax_invoice_id` char(40) DEFAULT NULL,
  `sale_tax_invoice_detail_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `batch_no` varchar(16) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `product_code` varchar(16) DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `documrnt_curency_id` int(11) DEFAULT NULL,
  `unit_id` char(40) DEFAULT NULL,
  `qty` decimal(11,2) DEFAULT 0.00,
  `rate` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(20,4) DEFAULT 0.0000,
  `discount_percent` decimal(20,4) DEFAULT 0.0000,
  `discount_amount` decimal(20,4) DEFAULT 0.0000,
  `gross_amount` decimal(20,4) DEFAULT 0.0000,
  `other_expence` decimal(20,4) DEFAULT 0.0000,
  `tax_percent` decimal(20,4) DEFAULT 0.0000,
  `tax_amount` decimal(20,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_total` decimal(20,4) DEFAULT 0.0000,
  `remarks` text DEFAULT NULL,
  `cog_rate` decimal(17,4) DEFAULT 0.0000,
  `cog_amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`sale_tax_invoice_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `login_history` */

DROP TABLE IF EXISTS `login_history`;

CREATE TABLE `login_history` (
  `login_history_id` char(38) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `login_name` varchar(255) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`login_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `prd_bom` */

DROP TABLE IF EXISTS `prd_bom`;

CREATE TABLE `prd_bom` (
  `bom_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_identity` varchar(255) DEFAULT NULL,
  `document_date` date DEFAULT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `unit_id` char(40) DEFAULT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`bom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `prd_bom_detail` */

DROP TABLE IF EXISTS `prd_bom_detail`;

CREATE TABLE `prd_bom_detail` (
  `bom_detail_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `bom_id` char(40) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `unit_id` char(40) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`bom_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `prd_production` */

DROP TABLE IF EXISTS `prd_production`;

CREATE TABLE `prd_production` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `production_id` char(40) NOT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_prefix` varchar(255) DEFAULT NULL,
  `document_no` int(11) DEFAULT NULL,
  `document_identity` varchar(255) DEFAULT NULL,
  `document_date` date DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `expected_quantity` decimal(11,2) NOT NULL DEFAULT 0.00,
  `actual_quantity` decimal(11,2) DEFAULT 0.00,
  `document_currency_id` int(11) DEFAULT NULL,
  `rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `remarks` text NOT NULL,
  `viscosity` decimal(17,4) DEFAULT 0.0000,
  `gel_time` decimal(17,4) DEFAULT 0.0000,
  `coure_time` decimal(17,4) DEFAULT 0.0000,
  `t_max` decimal(17,4) DEFAULT 0.0000,
  `stablizer` decimal(17,4) DEFAULT 0.0000,
  `water` decimal(17,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_rate` decimal(11,2) DEFAULT 0.00,
  `base_amount` decimal(20,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `is_post` tinyint(4) NOT NULL DEFAULT 0,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`production_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `prd_production_detail` */

DROP TABLE IF EXISTS `prd_production_detail`;

CREATE TABLE `prd_production_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `production_id` char(40) NOT NULL,
  `production_detail_id` char(40) NOT NULL,
  `sort_order` int(11) DEFAULT 0,
  `warehouse_id` int(11) DEFAULT NULL,
  `product_id` char(40) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `document_currency_id` int(11) DEFAULT NULL,
  `unit_id` char(40) NOT NULL,
  `unit_quantity` decimal(11,2) DEFAULT 0.00,
  `expected_quantity` decimal(11,2) NOT NULL DEFAULT 0.00,
  `actual_quantity` decimal(11,2) NOT NULL DEFAULT 0.00,
  `cog_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `cog_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_cog_rate` decimal(11,2) DEFAULT 0.00,
  `base_cog_amount` decimal(11,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`production_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `prd_production_expense` */

DROP TABLE IF EXISTS `prd_production_expense`;

CREATE TABLE `prd_production_expense` (
  `company_id` int(11) DEFAULT NULL,
  `production_expense_id` char(40) NOT NULL,
  `expense_name` varchar(255) DEFAULT NULL,
  `coa_id` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`production_expense_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `project` */

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `project_id` char(40) NOT NULL,
  `code` char(40) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`project_id`),
  UNIQUE KEY `UNQUE` (`code`,`name`,`company_id`,`company_branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `sale_discount_policy` */

DROP TABLE IF EXISTS `sale_discount_policy`;

CREATE TABLE `sale_discount_policy` (
  `sale_discount_policy_id` char(38) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `partner_type_id` int(11) DEFAULT NULL,
  `partner_id` char(38) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sale_discount_policy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `sale_discount_policy_detail` */

DROP TABLE IF EXISTS `sale_discount_policy_detail`;

CREATE TABLE `sale_discount_policy_detail` (
  `sale_discount_policy_detail_id` char(38) NOT NULL,
  `sale_discount_policy_id` char(38) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `product_id` char(38) DEFAULT NULL,
  `discount_percent` decimal(11,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  `modified_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sale_discount_policy_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `sale_pos` */

DROP TABLE IF EXISTS `sale_pos`;

CREATE TABLE `sale_pos` (
  `company_id` int(11) NOT NULL,
  `company_branch_id` int(11) NOT NULL,
  `fiscal_year_id` int(11) NOT NULL,
  `sale_pos_id` char(40) NOT NULL,
  `document_type_id` int(11) NOT NULL,
  `document_prefix` varchar(255) NOT NULL,
  `document_no` int(11) NOT NULL,
  `document_date` date NOT NULL,
  `document_identity` varchar(255) NOT NULL,
  `partner_type_id` varchar(255) DEFAULT NULL,
  `partner_id` char(40) NOT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `ref_invoice_no` varchar(32) NOT NULL,
  `billty_date` char(10) NOT NULL,
  `billty_no` varchar(32) NOT NULL,
  `manual_ref_no` varchar(11) DEFAULT NULL,
  `remarks` text NOT NULL,
  `remarks2` text NOT NULL,
  `document_currency_id` int(11) NOT NULL,
  `item_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_tax` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_other_expence` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `item_total` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cartage_charges` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `return_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `discount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `cash_received` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `balance_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `base_currency_id` int(11) NOT NULL,
  `conversion_rate` decimal(11,2) NOT NULL DEFAULT 0.00,
  `base_net_amount` decimal(20,4) NOT NULL DEFAULT 0.0000,
  `is_post` tinyint(4) DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `post_by_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sale_pos_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Table structure for table `sale_pos_detail` */

DROP TABLE IF EXISTS `sale_pos_detail`;

CREATE TABLE `sale_pos_detail` (
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `sale_pos_id` char(40) DEFAULT NULL,
  `sale_pos_detail_id` char(40) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `batch_no` varchar(16) DEFAULT NULL,
  `warehouse_id` int(11) NOT NULL,
  `product_id` char(40) DEFAULT NULL,
  `product_code` varchar(16) DEFAULT NULL,
  `ref_document_type_id` int(11) DEFAULT 0,
  `ref_document_identity` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `documrnt_curency_id` int(11) DEFAULT NULL,
  `unit_id` char(40) DEFAULT NULL,
  `qty` decimal(11,2) DEFAULT 0.00,
  `rate` decimal(20,4) DEFAULT 0.0000,
  `amount` decimal(20,4) DEFAULT 0.0000,
  `discount_percent` decimal(20,4) DEFAULT 0.0000,
  `discount_amount` decimal(20,4) DEFAULT 0.0000,
  `gross_amount` decimal(20,4) DEFAULT 0.0000,
  `other_expence` decimal(20,4) DEFAULT 0.0000,
  `tax_percent` decimal(20,4) DEFAULT 0.0000,
  `tax_amount` decimal(20,4) DEFAULT 0.0000,
  `total_amount` decimal(20,4) DEFAULT 0.0000,
  `base_currency_id` int(11) DEFAULT NULL,
  `conversion_rate` decimal(11,2) DEFAULT 0.00,
  `base_total` decimal(20,4) DEFAULT 0.0000,
  `remarks` text DEFAULT NULL,
  `cog_rate` decimal(17,4) DEFAULT 0.0000,
  `cog_amount` decimal(17,4) DEFAULT 0.0000,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` char(40) DEFAULT NULL,
  PRIMARY KEY (`sale_pos_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `sub_project` */

DROP TABLE IF EXISTS `sub_project`;

CREATE TABLE `sub_project` (
  `sub_project_id` char(40) NOT NULL,
  `project_id` char(40) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`sub_project_id`),
  UNIQUE KEY `UNIQUE` (`project_id`,`name`,`company_id`,`company_branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tool_reminder` */

DROP TABLE IF EXISTS `tool_reminder`;

CREATE TABLE `tool_reminder` (
  `reminder_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `event_title` varchar(255) DEFAULT NULL,
  `event_date_time` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `remind_before_type` enum('Minute','Hour','Day','Week','Month') DEFAULT NULL,
  `remind_before_no` int(11) DEFAULT NULL,
  `repeat_type` enum('Once','Day','Week','Month','Year') DEFAULT NULL,
  `repeat_no` int(11) DEFAULT NULL,
  `next_reminder` datetime DEFAULT NULL,
  `total_reminder` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`reminder_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `tool_reminder_email` */

DROP TABLE IF EXISTS `tool_reminder_email`;

CREATE TABLE `tool_reminder_email` (
  `reminder_email_id` char(40) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_branch_id` int(11) DEFAULT NULL,
  `fiscal_year_id` int(11) DEFAULT NULL,
  `reminder_id` char(40) DEFAULT NULL,
  `email_as` enum('To','CC') DEFAULT NULL,
  `receiver_name` varchar(255) DEFAULT NULL,
  `receiver_email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`reminder_email_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
