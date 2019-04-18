/*
SQLyog Ultimate v10.42 
MySQL - 5.5.5-10.1.37-MariaDB : Database - db_edoc
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
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

insert  into `config`(`fin_id`,`fst_key`,`fst_value`,`fst_notes`,`fbl_active`) values (1,'document_folder','d:\\edoc_storage\\',NULL,1),(2,'document_max_size','200','maximal doc size (kilobyte)',1);

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

/*Data for the table `document_custom_permission` */

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

/*Data for the table `document_details` */

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

/*Data for the table `document_flow_control` */

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `document_histories` */

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
  `fin_version` int(3) DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  PRIMARY KEY (`fin_document_id`),
  UNIQUE KEY `fin_id` (`fin_document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `documents` */

insert  into `documents`(`fin_document_id`,`fst_name`,`fst_source`,`fst_created_via`,`fin_confidential_lvl`,`fst_view_scope`,`fst_print_scope`,`fbl_flow_control`,`fin_flow_control_schema`,`fst_search_marks`,`fst_memo`,`fdt_published_date`,`fbl_flow_completed`,`fin_version`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'KTP','INTERNAL','MANUAL',5,'PRV','PRV',0,NULL,'KTP','KTP','2019-04-15',0,0,'A','2019-04-15 16:49:51',1,'0000-00-00 00:00:00',0),(2,'NPWP','INTERNAL','MANUAL',5,'PRV','PRV',0,NULL,'NPWP','NPWP','2019-04-15',0,0,'A','2019-04-15 16:49:51',1,'0000-00-00 00:00:00',0),(3,'SIUP','INTERNAL','MANUAL',5,'PRV','PRV',0,NULL,'SIUP','SIUP','2019-04-15',0,0,'A','2019-04-15 16:49:51',1,'0000-00-00 00:00:00',0);

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

/*Data for the table `flow_control_schema_header` */

insert  into `flow_control_schema_header`(`fin_flow_control_schema_id`,`fin_user_id`,`fst_name`,`fst_memo`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,1,'Flow Penjualan',NULL,'A','2019-04-15 15:53:54',1,'0000-00-00 00:00:00',0),(2,1,'Flow Pengumuman',NULL,'A','2019-04-15 15:54:21',1,'0000-00-00 00:00:00',0);

/*Table structure for table `flow_control_schema_items` */

DROP TABLE IF EXISTS `flow_control_schema_items`;

CREATE TABLE `flow_control_schema_items` (
  `fin_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fin_flow_control_schema_id` bigint(20) NOT NULL,
  `fin_user_id` bigint(20) DEFAULT NULL,
  `fin_seq_no` int(2) DEFAULT NULL,
  `fst_active` enum('ACTIVE','SUSPEND','DELETED') NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `flow_control_schema_items` */

insert  into `flow_control_schema_items`(`fin_id`,`fin_flow_control_schema_id`,`fin_user_id`,`fin_seq_no`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,1,1,1,'ACTIVE','2019-04-15 15:54:47',1,'0000-00-00 00:00:00',0);

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

/*Data for the table `master_groups` */

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `menus` */

insert  into `menus`(`fin_id`,`fin_order`,`fst_menu_name`,`fst_caption`,`fst_icon`,`fst_type`,`fst_link`,`fin_parent_id`,`fbl_active`) values (1,1,'master','Master','','HEADER',NULL,0,1),(2,2,'dashboard','Dashboard','<i class=\"fa fa-dashboard\"></i>','TREEVIEW','welcome/advanced_element',0,1),(3,3,'department','Department','<i class=\"fa fa-dashboard\"></i>','TREEVIEW','department',0,1),(4,4,'group','Groups','<i class=\"fa fa-circle-o\"></i>','TREEVIEW','welcome/general_element',0,1),(5,5,'user','User','<i class=\"fa fa-edit\"></i>','TREEVIEW','user',0,1),(6,1,'user_user','Users','<i class=\"fa fa-files-o\"></i>','TREEVIEW','user',4,1),(7,2,'user_group','Groups','<i class=\"fa fa-edit\"></i>','TREEVIEW','master_groups',4,1),(8,6,'document','Documents','','HEADER',NULL,0,1),(9,7,'list_document','List Document','<i class=\"fa fa-circle-o\"></i>','TREEVIEW','document/add',0,1);

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

/*Data for the table `user_group` */

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
  `fin_department_id` bigint(20) NOT NULL,
  `fbl_admin` tinyint(1) NOT NULL DEFAULT '0',
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  UNIQUE KEY `fin_id` (`fin_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`fin_user_id`,`fst_username`,`fst_password`,`fst_fullname`,`fst_gender`,`fdt_birthdate`,`fst_birthplace`,`fst_address`,`fst_phone`,`fst_email`,`fin_department_id`,`fbl_admin`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'devibong@yahoo.com','06a6077b0cfcb0f4890fb5f2543c43be','Devi Bastian','M','0000-00-00','',NULL,NULL,NULL,0,0,'A','0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0),(3,'Donna@yahoo.com','06a6077b0cfcb0f4890fb5f2543c43be','Donna Natalisa','M','0000-00-00','',NULL,NULL,NULL,0,0,'A','0000-00-00 00:00:00',0,'0000-00-00 00:00:00',0);

/*Table structure for table `zdeleted_document_file_histories` */

DROP TABLE IF EXISTS `zdeleted_document_file_histories`;

CREATE TABLE `zdeleted_document_file_histories` (
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

/*Data for the table `zdeleted_document_file_histories` */

/*Table structure for table `zdeleted_document_files` */

DROP TABLE IF EXISTS `zdeleted_document_files`;

CREATE TABLE `zdeleted_document_files` (
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

/*Data for the table `zdeleted_document_files` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
