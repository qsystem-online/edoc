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

/*Data for the table `access_token` */

/*Table structure for table `branch` */

DROP TABLE IF EXISTS `branch`;

CREATE TABLE `branch` (
  `fin_branch_id` int(5) NOT NULL AUTO_INCREMENT,
  `fst_branch_name` varchar(100) DEFAULT NULL,
  `fst_branch_address` text,
  `fst_branch_phone` varchar(20) DEFAULT NULL,
  `fst_notes` text,
  `fbl_central` tinyint(1) DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL,
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `branch` */

insert  into `branch`(`fin_branch_id`,`fst_branch_name`,`fst_branch_address`,`fst_branch_phone`,`fst_notes`,`fbl_central`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (1,'Jakarta',NULL,NULL,NULL,1,'A',1,'2019-05-02 20:36:13',NULL,NULL),(2,'Surabaya',NULL,NULL,NULL,0,'A',1,'2019-05-02 20:37:41',NULL,NULL);

/*Table structure for table `config` */

DROP TABLE IF EXISTS `config`;

CREATE TABLE `config` (
  `fin_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fst_key` varchar(256) DEFAULT NULL,
  `fst_value` varchar(256) DEFAULT NULL,
  `fst_notes` text,
  `fbl_active` tinyint(1) DEFAULT NULL,
  KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `config` */

insert  into `config`(`fin_id`,`fst_key`,`fst_value`,`fst_notes`,`fbl_active`) values (1,'document_folder','d:\\edoc_storage\\',NULL,1),(2,'document_max_size','102400','maximal doc size (kilobyte)',1);

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

/*Data for the table `departments` */

insert  into `departments`(`fin_department_id`,`fst_department_name`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'Finance','A','2019-04-18 08:23:34',1,'0000-00-00 00:00:00',0),(2,'Sales','A','2019-04-18 08:23:51',1,'0000-00-00 00:00:00',0),(3,'HRD','A','2019-04-18 08:25:33',1,'0000-00-00 00:00:00',0);

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

/*Data for the table `document_access_histories` */

/*Table structure for table `document_custom_permission` */

DROP TABLE IF EXISTS `document_custom_permission`;

CREATE TABLE `document_custom_permission` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fst_mode` enum('USER','DEPARTMENT') DEFAULT NULL,
  `fin_branch_id` int(5) DEFAULT NULL COMMENT '0 is all branch',
  `fin_user_department_id` int(11) NOT NULL,
  `fbl_view` tinyint(1) NOT NULL DEFAULT '0',
  `fbl_print` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `document_custom_permission` */

/*Table structure for table `document_details` */

DROP TABLE IF EXISTS `document_details`;

CREATE TABLE `document_details` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fin_document_item_id` bigint(20) NOT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='suatu dokumen bisa berupa kumpulan dari dokumen2 lainnya';

/*Data for the table `document_details` */

/*Table structure for table `document_flow_control` */

DROP TABLE IF EXISTS `document_flow_control`;

CREATE TABLE `document_flow_control` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fin_seq_no` int(2) NOT NULL DEFAULT '1',
  `fin_user_id` bigint(20) NOT NULL,
  `fst_control_status` enum('NA','RA','NR','AP','RJ') NOT NULL DEFAULT 'NA' COMMENT 'NA->Need Approval;RA->Ready to Approve;NR->Need Revision;AP->Approved;RJ->Reject',
  `fst_memo` text,
  `fdt_approved_datetime` datetime DEFAULT NULL,
  `fin_version` int(3) NOT NULL,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `document_flow_control` */

insert  into `document_flow_control`(`fin_id`,`fin_document_id`,`fin_seq_no`,`fin_user_id`,`fst_control_status`,`fst_memo`,`fdt_approved_datetime`,`fin_version`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,1,1,1,'AP','Approved by devi ','2019-05-04 10:46:15',0,'A','2019-05-04 10:45:42',1,'2019-05-04 10:46:15',1),(2,1,2,3,'NR','Di Revisi Dulu dong','2019-05-04 10:47:02',0,'A','2019-05-04 10:45:42',1,'2019-05-04 10:47:02',3),(3,1,2,3,'RJ','Kerennn top','2019-05-04 11:36:57',3,'A','2019-05-04 10:58:04',1,'2019-05-04 11:36:57',3),(4,2,1,1,'AP','OK Approved','2019-05-04 18:48:32',0,'A','2019-05-04 18:47:52',1,'2019-05-04 18:48:32',1),(5,2,2,3,'NR','Revisi File PDF','2019-05-04 18:49:03',0,'A','2019-05-04 18:47:52',1,'2019-05-04 18:49:03',3),(6,2,2,3,'AP','Mantabb Approved','2019-05-04 18:50:47',1,'A','2019-05-04 18:50:06',1,'2019-05-04 18:50:47',3);

/*Table structure for table `document_histories` */

DROP TABLE IF EXISTS `document_histories`;

CREATE TABLE `document_histories` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) NOT NULL,
  `fst_memo` text,
  `fin_version` int(2) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `document_histories` */

insert  into `document_histories`(`fin_id`,`fin_document_id`,`fst_memo`,`fin_version`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,2,'testing 2',0,'A','2019-05-04 18:50:06',1,NULL,NULL);

/*Table structure for table `documents` */

DROP TABLE IF EXISTS `documents`;

CREATE TABLE `documents` (
  `fin_document_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fst_name` varchar(256) NOT NULL,
  `fst_source` enum('INT','EXT') NOT NULL DEFAULT 'INT',
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
  `fin_version` int(3) DEFAULT '0',
  `fst_real_file_name` varchar(256) NOT NULL,
  `fst_active` enum('A','S','D','R') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  PRIMARY KEY (`fin_document_id`),
  UNIQUE KEY `fin_id` (`fin_document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `documents` */

insert  into `documents`(`fin_document_id`,`fst_name`,`fst_source`,`fst_created_via`,`fin_confidential_lvl`,`fst_view_scope`,`fst_print_scope`,`fbl_flow_control`,`fin_flow_control_schema`,`fst_search_marks`,`fst_memo`,`fdt_published_date`,`fbl_flow_completed`,`fin_version`,`fst_real_file_name`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'test doc 1','INT','MANUAL',3,'PRV','PRV',1,NULL,'test 1','tes 1','2019-05-04',0,3,'test.pdf','R','2019-05-04 10:45:42',1,'2019-05-04 11:36:57',3),(2,'Test Document 2','INT','MANUAL',0,'PRV','PRV',1,NULL,'test 2','Revisi 1','2019-05-04',1,1,'Ebook VOL 2 (1) (2).pdf','A','2019-05-04 18:47:52',1,'2019-05-04 18:50:47',3);

/*Table structure for table `flow_control_schema_header` */

DROP TABLE IF EXISTS `flow_control_schema_header`;

CREATE TABLE `flow_control_schema_header` (
  `fin_flow_control_schema_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fst_name` varchar(256) DEFAULT NULL,
  `fst_memo` text,
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_flow_control_schema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `flow_control_schema_header` */

insert  into `flow_control_schema_header`(`fin_flow_control_schema_id`,`fst_name`,`fst_memo`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'Flow Penjualan',NULL,'A','2019-04-15 15:53:54',1,'0000-00-00 00:00:00',0),(2,'Flow Pengumuman',NULL,'A','2019-04-15 15:54:21',1,'0000-00-00 00:00:00',0);

/*Table structure for table `flow_control_schema_items` */

DROP TABLE IF EXISTS `flow_control_schema_items`;

CREATE TABLE `flow_control_schema_items` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_flow_control_schema_id` bigint(20) NOT NULL,
  `fin_user_id` bigint(20) DEFAULT NULL,
  `fin_seq_no` int(2) DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `flow_control_schema_items` */

insert  into `flow_control_schema_items`(`fin_id`,`fin_flow_control_schema_id`,`fin_user_id`,`fin_seq_no`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,1,1,1,'A','2019-04-15 15:54:47',1,'0000-00-00 00:00:00',0);

/*Table structure for table `master_groups` */

DROP TABLE IF EXISTS `master_groups`;

CREATE TABLE `master_groups` (
  `fin_group_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fst_group_name` varchar(256) NOT NULL,
  `fin_level` enum('0','1','2','3','4','5') NOT NULL COMMENT '0=Top management, 1=Upper management, 2=Middle management, 3=Supervisors, 4=Line workers, 5=public',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  `fin_update_id` int(10) DEFAULT NULL,
  UNIQUE KEY `fin_id` (`fin_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `master_groups` */

insert  into `master_groups`(`fin_group_id`,`fst_group_name`,`fin_level`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'Presiden Director','1','A','2019-04-24 12:59:47',1,NULL,NULL),(2,'General Manager','2','A','2019-04-24 13:00:17',1,NULL,NULL),(3,'Supervisor','3','A','2019-04-24 13:00:35',1,NULL,NULL),(4,'Staff','4','A','2019-04-24 13:01:09',1,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `menus` */

insert  into `menus`(`fin_id`,`fin_order`,`fst_menu_name`,`fst_caption`,`fst_icon`,`fst_type`,`fst_link`,`fin_parent_id`,`fbl_active`) values (1,1,'master','Master','','HEADER',NULL,0,1),(2,2,'dashboard','Dashboard','<i class=\"fa fa-dashboard\"></i>','TREEVIEW','dashboard',0,1),(3,3,'department','Department','<i class=\"fa fa-dashboard\"></i>','TREEVIEW','department',0,1),(4,4,'group','Groups','<i class=\"fa fa-circle-o\"></i>','TREEVIEW','welcome/general_element',0,1),(5,5,'user','User','<i class=\"fa fa-edit\"></i>','TREEVIEW','user',0,1),(6,1,'user_user','Users','<i class=\"fa fa-files-o\"></i>','TREEVIEW','user',4,1),(7,2,'user_group','Groups','<i class=\"fa fa-edit\"></i>','TREEVIEW','master_groups',4,1),(8,6,'document','Documents','','HEADER',NULL,0,1),(9,7,'list_document','List Document','<i class=\"fa fa-circle-o\"></i>','TREEVIEW','document',0,1),(10,8,'search_document','Search','<i class=\"fa fa-search\"></i>','TREEVIEW','document/search_list',0,1);

/*Table structure for table `permission_token` */

DROP TABLE IF EXISTS `permission_token`;

CREATE TABLE `permission_token` (
  `fin_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fst_token` varchar(256) DEFAULT NULL,
  `fin_user_id` bigint(20) DEFAULT NULL,
  `fbl_active` tinyint(1) DEFAULT NULL,
  KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `permission_token` */

insert  into `permission_token`(`fin_id`,`fst_token`,`fin_user_id`,`fbl_active`) values (1,'123456',1,1);

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

/*Data for the table `reference_document_list` */

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
  `fin_branch_id` int(5) NOT NULL,
  `fin_department_id` bigint(20) NOT NULL,
  `fin_group_id` bigint(20) DEFAULT NULL,
  `fbl_admin` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`fin_user_id`,`fst_username`,`fst_password`,`fst_fullname`,`fst_gender`,`fdt_birthdate`,`fst_birthplace`,`fst_address`,`fst_phone`,`fst_email`,`fin_branch_id`,`fin_department_id`,`fin_group_id`,`fbl_admin`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'devibong@yahoo.com','06a6077b0cfcb0f4890fb5f2543c43be','Devi Bastian','M','0000-00-00','',NULL,NULL,NULL,1,1,2,0,'A','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0),(3,'Donna@yahoo.com','06a6077b0cfcb0f4890fb5f2543c43be','Donna Natalisa','M','0000-00-00','',NULL,NULL,NULL,2,1,3,0,'A','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0);

/*Table structure for table `view_print_token` */

DROP TABLE IF EXISTS `view_print_token`;

CREATE TABLE `view_print_token` (
  `fin_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fin_document_id` bigint(20) DEFAULT NULL,
  `fst_token` varchar(256) DEFAULT NULL,
  `fst_session_id` varchar(256) DEFAULT NULL,
  `fst_active` enum('A','S','D') DEFAULT NULL,
  `fin_insert_id` bigint(20) DEFAULT NULL,
  `fdt_insert_datetime` datetime DEFAULT NULL,
  `fin_update_id` bigint(20) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

/*Data for the table `view_print_token` */

insert  into `view_print_token`(`fin_id`,`fin_document_id`,`fst_token`,`fst_session_id`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (1,1,'MlJSNGbz03yZFAE7Tw3d58jZxvrHXYUGfitwDydS4KnO4fMgFBq8oQK6UAhRCDno','voip4tpdfo8qj70di7bo4ugpib1paq9c','D',1,'2019-05-04 10:38:02',NULL,NULL),(2,1,'s8U342Q8kynwNqvlAboDWmPvd0eQfGOBprr4ig1ux1WRMR0GFhzHTi2HNyPxkBEu','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:38:08',NULL,NULL),(3,1,'8TtYUwOzXUtBPdZfC3RmWyp6WbKgSz4lV5Z50eSkRC6v4Qh8IjnMsiLQBuTa3gFc','voip4tpdfo8qj70di7bo4ugpib1paq9c','D',1,'2019-05-04 10:38:17',NULL,NULL),(4,1,'YL8jyxSgrwNdU1Ht9KEZa5Xs76QUa6M3OJ1czkRb2GlCt4VqSdlM7OoJTWwjKDnT','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:38:30',NULL,NULL),(5,1,'yIHLsB9NoHOXjG41a3pNm7C5YxEpDdnhqWO8M8unQ1WrFCcV0zmgoVbzaUJwf2fq','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:38:39',NULL,NULL),(6,1,'NQO9SCiKaieZ8vUPptW4nEokUm9LHFysx8qdY5fcpmuVIhlgYB7T6v7D2lQRXwLc','voip4tpdfo8qj70di7bo4ugpib1paq9c','D',1,'2019-05-04 10:38:44',NULL,NULL),(7,1,'ZRUXdzFLyMk32Rjyev8PEWeV8St69q5dhx0YaN1Ks7KTmmEBjnktsVffPW0u1Yvp','voip4tpdfo8qj70di7bo4ugpib1paq9c','D',1,'2019-05-04 10:41:31',NULL,NULL),(8,1,'IwUeXdck3Do1AxrYF0ObqhZaizKFDWCNnR9BmQPKMc0iLQjlJ78A2tdxrmCHz2H6','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:42:02',NULL,NULL),(9,1,'FsgVN2GzhIyduAamchKk1TNZ1Cc00nJxXoE7e5avQef8ibPixdquUjMPCormVL3p','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:45:50',NULL,NULL),(10,1,'91kfr72k3bKYVvJ4WXmVMQjOUHGfj8zpb1yIdxsd3RABAlCNthLwqnPsGEy2MQFa','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:46:04',NULL,NULL),(11,1,'Q5rAv9YyV0HRIFi3YZaWsoNS2Cb7GXdKz4pGL5vcqKoxhmOUNTIlrjV14gJgn6hl','voip4tpdfo8qj70di7bo4ugpib1paq9c','D',1,'2019-05-04 10:46:04',NULL,NULL),(12,1,'bIizHKRctoShed739uVi6BNEcCm5zsqRtarwyLPlEDG4PJnZX0aFBpQ18O2GhyLl','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:46:27',NULL,NULL),(13,1,'olM8Xt1qKy49J3YNv5D9l1IFqC5QLpcDF7gsdWCHG7rEHfA2IkxWUzZjBm3RfBSQ','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 10:46:52',NULL,NULL),(14,1,'1yNzAwYCRsexM7coQxiT4EQOOpFkBfNlJjisTCn9UhdrqWI9hKSZXz2Logv5DUe3','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 10:46:52',NULL,NULL),(15,1,'Dzxf3UZSHDKLNz0aW6sR865cMynOiEIAP2skmBg0kwAv7j5yV1oua4wuMTjELhSO','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:47:19',NULL,NULL),(16,1,'2hKDmDO6IPZozkQMTk4mYVisHFX5nzYOeJK4GfS7wfc67WtHle9q10bCRQxIj0nV','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:56:50',NULL,NULL),(17,1,'Ey6y1h9Dou65XWmLp8bsSAMEJZAGcgqadsDVPcqYmvNnjaYBw4I1vx3KrgI5FUNC','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 10:58:07',NULL,NULL),(18,1,'Sv9B3CVBrK2YAtsydsuWwk12LJQn57m50XDNEbqC8jcJbEGXRoQFAZHOzuPgDGSm','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 10:59:47',NULL,NULL),(19,1,'JEajH6k8pJmEFeNsqFMvDZHrhqQ1YI9sLY1itdCBGfkgo2GTzAWn0lcnKMOSrxxd','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 10:59:47',NULL,NULL),(20,1,'11wunDsaae2U49CpLyEQznriK4jRMFuyltWscfV8SWgbQI8qXFHcY6H5Xm3NDtZe','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 11:04:21',NULL,NULL),(21,1,'MBZvDOCiWVz69UjSsHgP5IPQp02gsxo6hyafLU5ehibxM3LKXGulzEp7JcKOGutb','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 11:04:21',NULL,NULL),(22,1,'meXTTeKyhUGZRcWNLW8Yd7tVsk1ffuwFZBJPrcxxdREPlrIzsANYuO0638gQhOH9','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 11:06:07',NULL,NULL),(23,1,'fXFQh2GomFd3clCbtsQ6vNA6xsj2IRij10SeK9y4gGUBAPNOEbID0JV5LzBKcRSW','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 11:06:07',NULL,NULL),(24,1,'cKKbiEkmbp7woar0O4tqAGQZiFDSzcaqLdA83NVRj9Sv5tegylCwnLPPHhjhf5xV','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 11:15:14',NULL,NULL),(25,1,'7AZt5QqUjmSbMLOTWENs91le6oHa0yXr6eQbDNALHw4KRtKMPg5nIzs87uEWkYhC','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 11:15:15',NULL,NULL),(26,1,'HQJC7fPANdxELC6qTO6vc2UIDSRglJX5eh1snLUWvmrZ07qwFaSjTowMEs9XWoKu','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 11:16:50',NULL,NULL),(27,1,'hPchXfJrAUeFL9QwStTJ1LE714iMKzIbulkp4GVyfo2sUdrPFXlmc6qt8S5WgyRZ','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 11:16:50',NULL,NULL),(28,1,'1klQ0FcRtlzHV74mjRrbh59k78KbyFutVKNvXxLnO5sBSrJh6SC22dN8Tf36EjnH','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 11:21:09',NULL,NULL),(29,1,'cf58Hl4preeHNnEE3fMK5wsik1tdh9Vgn6OPziuUIArXzkTQGoQuwyx2SLIl2XvB','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 11:21:09',NULL,NULL),(30,1,'I0hYOT5KZwGXHiCE8EgVm2MkziLpmbRb7tnDe1jgQR3NUKuYsPyjSNtxXFBCaVlu','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 11:23:21',NULL,NULL),(31,1,'2A9HjbPtpg4vtLm5RfYwldSbygsV2YIqc6BvrkhT0e3NOSEauywoMkMQFzKh38dr','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 11:23:21',NULL,NULL),(32,1,'l6ieJrowT5GVfLqz9dFFKNHXUejIBamvLbcYagWsdKSEjxvNJACryYoAQtmTt1On','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 11:36:03',NULL,NULL),(33,1,'tJkZb5Nu6o2OFgRDHMnlAmfbwjT48VsOpsjrvUL6QDXxi0CrEdTc78vhVfQW2KaS','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 11:36:03',NULL,NULL),(34,1,'FDLxKYIdokzVWctEdKVBxTn4UsCrGF1AQ0hSqC3vn0pelHb8PbXRHjAOZySki5EI','v05o77g2s7a0fkr2ii7otp0irbkecsm7','A',3,'2019-05-04 11:36:53',NULL,NULL),(35,1,'YgWb6F4HrzpFP9RGjqCK1fcEU4NyJquvNScl0Sp8iAu39CPwkshJmgTL2ZBXto1y','v05o77g2s7a0fkr2ii7otp0irbkecsm7','D',3,'2019-05-04 11:36:53',NULL,NULL),(36,1,'h92BkEDWeFe0COncAw7VfUCxta6MP4O1qi7yVRxsGis6jqvruSaPZm3yzmh1GEId','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 11:39:07',NULL,NULL),(37,1,'cA9ReQOY9ZVyk7xwvsEL0lx0UMgKniMRHG27LvDNT2aWUC638CjYDhXpobHEVm3p','voip4tpdfo8qj70di7bo4ugpib1paq9c','A',1,'2019-05-04 11:40:09',NULL,NULL),(38,2,'DBvJsqqOGHr54ue8wYxMniSlETZoNG32K5VRU6OjKMpQuNePx1gCadstwJE8tLml','6l3gupf559rltdg5ojipdevgnher42hk','A',1,'2019-05-04 18:48:21',NULL,NULL),(39,2,'d8J62HDnO4K1I0QZFw3OXyqbzv0noEQM9kAeLJoCfkNL1rIa2rcGqTNtKZg7BBAU','6l3gupf559rltdg5ojipdevgnher42hk','D',1,'2019-05-04 18:48:21',NULL,NULL),(40,2,'dCY3HmoRrEsEHOdc5SNaZgZqxFPhA7yoT8VvXFf9zWrIlsz4kc5kviwxlG020MLf','6djl63las6s6lpta2n3v0stojkkp63hp','A',3,'2019-05-04 18:48:50',NULL,NULL),(41,2,'hOoK76fXZeJv930CGlIPunWcarAaIkReMCqtzFdo2FY1Dpg8wX5ursxPLRBfcptx','6l3gupf559rltdg5ojipdevgnher42hk','A',1,'2019-05-04 18:49:32',NULL,NULL),(42,2,'sQMSvbdkIezKaFcCm7FV80IO1J6UizfoR3Jd7Zo2CG9let34PyLvnpkPUNYWprt4','6l3gupf559rltdg5ojipdevgnher42hk','A',1,'2019-05-04 18:50:08',NULL,NULL),(43,2,'lqu0fOWy495Q5GKwakbnjpNdtJNmKqxYogkYr6mTLePX9g1chuvpbvD4CZWAlCic','6djl63las6s6lpta2n3v0stojkkp63hp','A',3,'2019-05-04 18:50:36',NULL,NULL),(44,2,'rMIw75D27Nyf2IrSvjSPtv4FZaiQGuK1TfhLTsukosRAxcQ6qdGl0ZJR8JB36NDm','6l3gupf559rltdg5ojipdevgnher42hk','D',1,'2019-05-04 18:53:30',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
