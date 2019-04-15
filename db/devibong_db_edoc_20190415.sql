/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.1.35-MariaDB : Database - db_edoc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_edoc` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_edoc`;

/*Table structure for table `access_token` */

DROP TABLE IF EXISTS `access_token`;

CREATE TABLE `access_token` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_user_id` int(11) NOT NULL,
  `fst_reff_source_code` varchar(100) DEFAULT NULL,
  `fst_reff_no` varchar(256) DEFAULT NULL,
  `fst_token` varchar(256) NOT NULL,
  `fst_session_id` varchar(256) DEFAULT NULL,
  `fdt_expiration_datetime` datetime DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `departments` */

DROP TABLE IF EXISTS `departments`;

CREATE TABLE `departments` (
  `fin_department_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fst_department_name` varchar(100) NOT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `document_access_histories` */

DROP TABLE IF EXISTS `document_access_histories`;

CREATE TABLE `document_access_histories` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fin_user_id` int(11) NOT NULL,
  `fst_access_mode` enum('V','P') NOT NULL COMMENT 'V->View;P->Print',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `document_custom_permission` */

DROP TABLE IF EXISTS `document_custom_permission`;

CREATE TABLE `document_custom_permission` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fin_user_id` int(11) NOT NULL,
  `fbl_view` tinyint(1) NOT NULL DEFAULT '0',
  `fbl_print` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `document_details` */

DROP TABLE IF EXISTS `document_details`;

CREATE TABLE `document_details` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='suatu dokumen bisa berupa kumpulan dari dokumen2 lainnya';

/*Table structure for table `document_file_histories` */

DROP TABLE IF EXISTS `document_file_histories`;

CREATE TABLE `document_file_histories` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_file_id` bigint(20) NOT NULL,
  `fst_title` varchar(256) DEFAULT NULL,
  `fst_memo` text,
  `fin_version` int(2) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `document_files` */

DROP TABLE IF EXISTS `document_files`;

CREATE TABLE `document_files` (
  `fin_file_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fst_title` varchar(256) NOT NULL,
  `fst_memo` text,
  `fin_version` int(3) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `document_flow_control` */

DROP TABLE IF EXISTS `document_flow_control`;

CREATE TABLE `document_flow_control` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fin_seq_no` int(2) NOT NULL DEFAULT '1',
  `fin_user_id` bigint(20) NOT NULL,
  `fst_control_status` enum('NA','RA','NR','AP') NOT NULL DEFAULT 'NA' COMMENT 'NA->Need Approval;RA->Ready to Approve;NR->Need Revision;AP->Approved',
  `fst_memo` text,
  `fdt_approved_datetime` datetime DEFAULT NULL,
  `fin_version` int(3) NOT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `documents` */

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `fin_document_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fst_name` varchar(256) NOT NULL,
  `fst_source` enum('INTERNAL','EXTERNAL') NOT NULL DEFAULT 'INTERNAL',
  `fst_created_via` enum('MANUAL','API') NOT NULL DEFAULT 'MANUAL',
  `fin_confidential_lvl` int(2) NOT NULL DEFAULT '5' COMMENT '0=Top management, 1=Upper management, 2=Middle management, 3=Supervisors, 4=Line workers, 5=public',
  `fst_view_scope` enum('PRV','GBL','CST') DEFAULT 'PRV' COMMENT 'PRV->Private;GBL->Global;CST->CUSTOM',
  `fst_print_scope` enum('PRV','GBL','CST') NOT NULL DEFAULT 'PRV' COMMENT 'PRV->Private;GBL->Global;CST->CUSTOM',
  `fbl_flow_control` tinyint(1) NOT NULL DEFAULT '0',
  `fin_flow_control_schema` int(11) DEFAULT NULL,
  `fst_search_marks` varchar(256) DEFAULT NULL,
  `fst_memo` text,
  `fdt_published_date` date DEFAULT NULL,
  `fbl_flow_completed` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  PRIMARY KEY (`fin_document_id`),
  UNIQUE KEY `fin_id` (`fin_document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `flow_control_schema_header` */

DROP TABLE IF EXISTS `flow_control_schema_header`;

CREATE TABLE `flow_control_schema_header` (
  `fin_flow_control_schema_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_user_id` bigint(20) DEFAULT NULL,
  `fst_name` varchar(256) DEFAULT NULL,
  `fst_memo` text,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_flow_control_schema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Table structure for table `flow_control_schema_list` */

DROP TABLE IF EXISTS `flow_control_schema_list`;

CREATE TABLE `flow_control_schema_list` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_flow_control_schema_id` bigint(20) NOT NULL,
  `fin_user_id` bigint(20) DEFAULT NULL,
  `fin_seq_no` int(2) DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `master_groups` */

DROP TABLE IF EXISTS `master_groups`;

CREATE TABLE `master_groups` (
  `fin_group_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fst_group_name` varchar(256) NOT NULL,
  `fin_level` int(2) NOT NULL COMMENT '0=Top management, 1=Upper management, 2=Middle management, 3=Supervisors, 4=Line workers, 5=public',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `menus` */

DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_order` int(11) NOT NULL,
  `fst_menu_name` varchar(256) NOT NULL,
  `fst_caption` varchar(256) NOT NULL,
  `fst_icon` varchar(256) NOT NULL,
  `fst_type` enum('HEADER','TREEVIEW','','') NOT NULL DEFAULT 'HEADER',
  `fst_link` text,
  `fin_parent_id` int(11) NOT NULL,
  `fbl_active` tinyint(1) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Table structure for table `permission_token` */

DROP TABLE IF EXISTS `permission_token`;

CREATE TABLE `permission_token` (
  `fin_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fst_token` varchar(256) DEFAULT NULL,
  `fin_user_id` bigint(20) DEFAULT NULL,
  `fbl_active` tinyint(1) DEFAULT NULL,
  KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `reference_document_list` */

DROP TABLE IF EXISTS `reference_document_list`;

CREATE TABLE `reference_document_list` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fst_reff_source_code` varchar(100) DEFAULT NULL,
  `fst_reff_no` varchar(256) NOT NULL,
  `fin_document_id` bigint(20) NOT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user_group` */

DROP TABLE IF EXISTS `user_group`;

CREATE TABLE `user_group` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_user_id` int(10) NOT NULL,
  `fin_group_id` int(10) NOT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `fin_user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fst_username` varchar(50) NOT NULL,
  `fst_password` varchar(256) NOT NULL,
  `fst_fullname` varchar(256) NOT NULL,
  `fst_gender` enum('M','F') NOT NULL,
  `fdt_birthdate` date NOT NULL,
  `fst_birthplace` varchar(256) NOT NULL,
  `fst_address` text,
  `fst_phone` varchar(100) DEFAULT NULL,
  `fst_email` varchar(100) DEFAULT NULL,
  `fin_department_id` bigint(20) DEFAULT NULL,
  `fbl_admin` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
