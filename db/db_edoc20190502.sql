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
  `fbl_center` tinyint(1) DEFAULT NULL,
  `fst_active` enum('A','S','D') NOT NULL,
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `branch` */

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

/*Data for the table `document_custom_permission` */

insert  into `document_custom_permission`(`fin_id`,`fin_document_id`,`fst_mode`,`fin_branch_id`,`fin_user_department_id`,`fbl_view`,`fbl_print`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (7,32,'USER',NULL,1,1,0,'A','2019-04-20 01:51:08',1,NULL,NULL),(8,32,'DEPARTMENT',NULL,1,1,1,'A','2019-04-20 01:51:08',1,NULL,NULL),(11,34,'USER',NULL,1,1,0,'A','2019-04-20 02:01:10',1,NULL,NULL),(12,34,'DEPARTMENT',NULL,1,1,1,'A','2019-04-20 02:01:10',1,NULL,NULL),(29,44,'USER',NULL,1,1,0,'A','2019-04-20 02:29:39',1,NULL,NULL),(30,44,'DEPARTMENT',NULL,1,1,1,'A','2019-04-20 02:29:39',1,NULL,NULL),(31,45,'USER',NULL,1,1,1,'A','2019-04-24 13:18:28',1,NULL,NULL),(32,45,'DEPARTMENT',NULL,1,1,1,'A','2019-04-24 13:18:28',1,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1 COMMENT='suatu dokumen bisa berupa kumpulan dari dokumen2 lainnya';

/*Data for the table `document_details` */

insert  into `document_details`(`fin_id`,`fin_document_id`,`fin_document_item_id`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (37,31,1,'A','2019-04-20 01:50:44',1,NULL,NULL),(38,31,2,'A','2019-04-20 01:50:44',1,NULL,NULL),(39,31,3,'A','2019-04-20 01:50:44',1,NULL,NULL),(40,32,1,'A','2019-04-20 01:51:08',1,NULL,NULL),(41,32,2,'A','2019-04-20 01:51:08',1,NULL,NULL),(42,32,3,'A','2019-04-20 01:51:08',1,NULL,NULL),(46,34,1,'A','2019-04-20 02:01:10',1,NULL,NULL),(47,34,2,'A','2019-04-20 02:01:10',1,NULL,NULL),(48,34,3,'A','2019-04-20 02:01:10',1,NULL,NULL),(76,44,1,'A','2019-04-20 02:29:39',1,NULL,NULL),(77,44,2,'A','2019-04-20 02:29:39',1,NULL,NULL),(78,44,3,'A','2019-04-20 02:29:39',1,NULL,NULL),(79,45,1,'A','2019-04-24 13:18:28',1,NULL,NULL),(80,45,2,'A','2019-04-24 13:18:28',1,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `document_flow_control` */

insert  into `document_flow_control`(`fin_id`,`fin_document_id`,`fin_seq_no`,`fin_user_id`,`fst_control_status`,`fst_memo`,`fdt_approved_datetime`,`fin_version`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,34,1,1,'NA',NULL,NULL,0,'A','2019-04-20 02:01:10',1,NULL,NULL),(2,34,1,3,'NA',NULL,NULL,0,'A','2019-04-20 02:01:10',1,NULL,NULL),(3,44,1,1,'NA',NULL,NULL,0,'A','2019-04-20 02:29:39',1,NULL,NULL),(4,44,1,3,'NA',NULL,NULL,0,'A','2019-04-20 02:29:39',1,NULL,NULL),(10,45,1,1,'AP','TESSSSSTT','2019-05-02 00:05:07',0,'A','2019-04-24 13:18:28',1,'2019-05-02 00:05:07',1);

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
  `fst_active` enum('A','S','D') NOT NULL COMMENT 'A->Active;S->Suspend;D->Deleted',
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_insert_id` int(10) NOT NULL,
  `fdt_update_datetime` datetime NOT NULL,
  `fin_update_id` int(10) NOT NULL,
  PRIMARY KEY (`fin_document_id`),
  UNIQUE KEY `fin_id` (`fin_document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

/*Data for the table `documents` */

insert  into `documents`(`fin_document_id`,`fst_name`,`fst_source`,`fst_created_via`,`fin_confidential_lvl`,`fst_view_scope`,`fst_print_scope`,`fbl_flow_control`,`fin_flow_control_schema`,`fst_search_marks`,`fst_memo`,`fdt_published_date`,`fbl_flow_completed`,`fin_version`,`fst_real_file_name`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'KTP','INT','MANUAL',5,'PRV','PRV',0,NULL,'KTP','KTP','2019-04-15',1,0,'','A','2019-04-15 16:49:51',1,'0000-00-00 00:00:00',0),(2,'NPWP','INT','MANUAL',5,'PRV','PRV',0,NULL,'NPWP','NPWP','2019-04-15',1,0,'','A','2019-04-15 16:49:51',3,'0000-00-00 00:00:00',0),(3,'SIUP','INT','MANUAL',5,'PRV','PRV',0,NULL,'SIUP','SIUP','2019-04-15',1,0,'','A','2019-04-15 16:49:51',1,'0000-00-00 00:00:00',0),(26,'Tetsing Document','EXT','MANUAL',3,'CST','PRV',1,NULL,'','Lorem ipsum dolor sit amet, consectetur adipiscing elit. \r\nNulla tincidunt aliquet lacus at vehicula. Etiam a sollicitudin nunc, at efficitur dolor. Mauris rutrum augue tincidunt consequat viverra. Pellentesque lacinia lacus eget est vulputate, id imperdiet massa porta. Vivamus vestibulum viverra sem. Fusce tristique ipsum pharetra est suscipit, sit amet auctor ipsum tempus. Mauris lobortis mi vitae tellus vulputate aliquet.','2019-04-19',0,0,'get_file.pdf','A','2019-04-19 14:43:19',3,'0000-00-00 00:00:00',0),(31,'test2','INT','MANUAL',1,'CST','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 01:50:44',1,'0000-00-00 00:00:00',0),(32,'test2','INT','MANUAL',1,'CST','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 01:51:08',3,'0000-00-00 00:00:00',0),(34,'test2','INT','MANUAL',1,'CST','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 02:01:10',1,'0000-00-00 00:00:00',0),(44,'test2','INT','MANUAL',1,'CST','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 02:29:39',1,'0000-00-00 00:00:00',0),(45,'test2','INT','MANUAL',3,'PRV','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',1,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 02:46:38',3,'2019-04-24 13:18:28',1);

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

insert  into `menus`(`fin_id`,`fin_order`,`fst_menu_name`,`fst_caption`,`fst_icon`,`fst_type`,`fst_link`,`fin_parent_id`,`fbl_active`) values (1,1,'master','Master','','HEADER',NULL,0,1),(2,2,'dashboard','Dashboard','<i class=\"fa fa-dashboard\"></i>','TREEVIEW','welcome/advanced_element',0,1),(3,3,'department','Department','<i class=\"fa fa-dashboard\"></i>','TREEVIEW','department',0,1),(4,4,'group','Groups','<i class=\"fa fa-circle-o\"></i>','TREEVIEW','welcome/general_element',0,1),(5,5,'user','User','<i class=\"fa fa-edit\"></i>','TREEVIEW','user',0,1),(6,1,'user_user','Users','<i class=\"fa fa-files-o\"></i>','TREEVIEW','user',4,1),(7,2,'user_group','Groups','<i class=\"fa fa-edit\"></i>','TREEVIEW','master_groups',4,1),(8,6,'document','Documents','','HEADER',NULL,0,1),(9,7,'list_document','List Document','<i class=\"fa fa-circle-o\"></i>','TREEVIEW','document',0,1),(10,8,'search_document','Search','<i class=\"fa fa-search\"></i>','TREEVIEW','document/search_list',0,1);

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

insert  into `users`(`fin_user_id`,`fst_username`,`fst_password`,`fst_fullname`,`fst_gender`,`fdt_birthdate`,`fst_birthplace`,`fst_address`,`fst_phone`,`fst_email`,`fin_branch_id`,`fin_department_id`,`fin_group_id`,`fbl_admin`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'devibong@yahoo.com','06a6077b0cfcb0f4890fb5f2543c43be','Devi Bastian','M','0000-00-00','',NULL,NULL,NULL,0,1,2,0,'A','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0),(3,'Donna@yahoo.com','06a6077b0cfcb0f4890fb5f2543c43be','Donna Natalisa','M','0000-00-00','',NULL,NULL,NULL,0,1,3,0,'A','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0);

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
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=latin1;

/*Data for the table `view_print_token` */

insert  into `view_print_token`(`fin_id`,`fin_document_id`,`fst_token`,`fst_session_id`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (6,45,'Kk7t0OFsKnw2a8h3Ev5Gbs7MjTm6mcpMxqrDI1DhX4RqJQl30dzEcYanAHBzCr9X','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:27:20',NULL,NULL),(7,45,'BzE1cMtzbNMBUHxp0O42s9unFN3kaTKjPv58W6R7ITJItZvZsmhXSAQewD3gEr1g','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:28:04',NULL,NULL),(8,45,'hQhfXVq8NNCSQjftMqKla2610kOP6O4mATiGSW9TpxzC2JiXKIY1FscG5styAygz','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:29:07',NULL,NULL),(9,45,'0ZJ51VNFLPpAxpeCuniF72YIrcg6CmfyrwA2sU3mJ4ThZMz5dMutX9wkhR1NVlI8','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:29:47',NULL,NULL),(10,45,'M5Gh7BttpDwPjAD4SIYmrlXeVksq8iQ0oKAFnpbO0g1yCmPZRH3lzWub9BcLLEZH','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:35:44',NULL,NULL),(11,45,'kMlsy9Yi24SrdHhsq0yLoaCO0Snqud4LM9YrZT5KeWUb3EbGcVWNBUiwotl21pev','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:39:03',NULL,NULL),(12,45,'qfp9ErZV4o7yR4c6vsTtRJ9wAxGpIlvzQMCAyXSbWNO5jBjaqOGzK1KMTb3WCxha','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:39:11',NULL,NULL),(13,45,'R97hnBHAbtkduzQpk3wGlXWWKx1az2s754yXwyHSv6RLuZ8OLqDmVxdTC0DTBfCl','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:40:10',NULL,NULL),(14,45,'DvLBeTnNxHYpNwyfCof6Z911UbAb3vzOmAEV8ud7YgRrDKGkZmTMF0sQQVjI4jRt','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:40:58',NULL,NULL),(15,45,'tFnJXUwQJ2N7GbkcCk3MqxpF0dER6ujyYqIADfiBhpZbr2r7O4m3KH5l0UtzV9Sy','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:41:07',NULL,NULL),(16,45,'t24wLhiX6pnLfBBRk8PQqdECGTF19oFvPszmc5KojU7zkYM3Seab8yS3iIT7C2Xa','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:55:10',NULL,NULL),(17,45,'hvF5P6vHekIaq0g2oR5M8nppJEuAZqH1Gm9XsLSKNjbNw9XTlAoIcQMOfU2QO4Ek','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:58:10',NULL,NULL),(18,45,'taQ3n9pWlfJXuShFjgMdGpByvPoI7axbxLZeY2iS4lEj8zADHIQsqgmeRTy7rOVJ','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:58:33',NULL,NULL),(19,45,'43xAv4x15mNVZRq0Kr1gmNUGEoJUlHbDcCz7du8knItLhAHwit6cQOnfSjS2WPdJ','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:59:53',NULL,NULL),(20,45,'zaXHwbV2WmluIGtT5dQJyODvQj0BKsTEHmSNj8KnuNZtlWUU7qPJhc6fyix3B6Ad','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:00:52',NULL,NULL),(21,45,'7SftrFTRi8BPc23EG4j9gZDlqcovlVdJe2HVAaKu3L6LCEQykpboM6ZqSiKN1h9N','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:03:14',NULL,NULL),(22,45,'jsP40oYKbHF6tFUrkBnyzJRuArDsI63VZ8E7O1SCwmi9WbE5gILDpo10mQJGfekl','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:04:09',NULL,NULL),(23,45,'NPmEv60IeJIhNiwyjc2x7ZB0sOnAYvW3TyROtL74qMXropD2dhEaUkslHfJ9goug','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:04:55',NULL,NULL),(24,45,'duMCzTEFF8xLyR3JdDnCw1V7a0LijTvGoq2sXZcQYby9eqAtUSJ205jnelH3riaX','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:09:37',NULL,NULL),(25,45,'AHe7RbQ8hrfkauLU1ldSmgzBilCtxcVkHTUQpTduzvya4WsYXpjJnA3M76bhqZ0I','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:15:58',NULL,NULL),(26,45,'UhvnZ4sJT2iKfs1jdt3CWYk9OH6A7OlpwwNFtQrfCInPeE19g7yBHm2AjIdiMXYJ','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:17:35',NULL,NULL),(27,45,'n7Q7fmDrGwUN0kI3jb0uiWqiH5VPCrkTYoASOEJ9xesZ8ZsqovadlK1XlRHXj3BV','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:18:47',NULL,NULL),(28,45,'Fpk6mA2N37XrvOZWXffuEyiyGjddEKwexPlWNIGCsVLZ4M1S8UM5BSqjxKAtuHR6','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:20:05',NULL,NULL),(29,45,'apZPmzZ7NyRXbs7Y9xQCh4kwlSFHdU2n6D256Kp8u0rRTBjlrfNLDJEo5h1CGsOQ','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:22:43',NULL,NULL),(30,45,'rNf8R6tDsOSAPPxUwGb92dkby17zprJlGmuC1wMDOzWNWqfIH0ijQQ2EoJKYYXle','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:23:14',NULL,NULL),(31,45,'CdHSoqs4WDtv1cRswW66GVHBlflgnmGKatNVhCXL3OIFOAfLmrUJ0eczDxkork1x','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:24:07',NULL,NULL),(32,45,'cBDzRA1tKpbdDKEujv537IzVnHlT4sZFYMW9GHbuL2l1kw4gwLNexIoCvxeos6gP','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:24:32',NULL,NULL),(33,45,'TUQSGYtWr0dWi1IG9wcOebu9CHBAHfaxc7s6S7mbj55ymwPljJ1sIB2QPNaFvy8R','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:25:02',NULL,NULL),(34,45,'GZ8okitLVKNT8SMV1iazwyQPXa4zOmIFJRD5xA9QnZtknueBJ4IsbPYXHCbD01Ey','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:25:14',NULL,NULL),(35,45,'qVyCUhaJ14dRgE9bQEeYwKMFq76aWKhUb3McodABNe0iBAiGG8z9vV42T2vYj8HF','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:27:32',NULL,NULL),(36,45,'JYRyo4s4Fl37GKvo72PlaLSVTNegtnGS6AH1ws3y95x0uFqQXEzBWciRMjqjIKzD','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:27:36',NULL,NULL),(37,45,'iWEHD94JkrnYacS8zx9RMlLhrmwqPZjDCu6s1B0NuGOgAjenfLYsvtyb2FtXdmQ7','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:30:56',NULL,NULL),(38,45,'k8KPuDAVMykozLHtRJqPH6TdYZp5SXJbshUQUojO7uYIrSRhW3vDr8NEeNZEQznp','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:10:45',NULL,NULL),(39,45,'FcA1LSrpnTqXsWKRYZvsjOQR0ImakDEFVKPx4joEc3tLuU7xbyzCG9zhlkmZvty2','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:21:47',NULL,NULL),(40,45,'LxgrgdkWdJOksjyAxIVDwOzMcLmV9zw10HY9uC8flCJEoUhQvtbfs166Z5EPj2pR','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:22:04',NULL,NULL),(41,45,'NPdOt0V37MsQSlmejIAaU3orNReTpW8yHaSHbyuivhPjQt1DfmK5gd8BD1k5BGfO','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:22:21',NULL,NULL),(42,45,'IpqWvNJANEbgB4AcvoT6DQqTkUXlBs4GEzgFQxwoy0cs5dma3nj21JCXYtZLi79e','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:22:47',NULL,NULL),(43,45,'Pz1CKoEMIBjEFXveByU7R7K9LdOilYok3eYnbpNgTsSNhwcJaWZTvVVzHGr8qhRk','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:23:19',NULL,NULL),(44,45,'4v1UJCIxyXEkkYTPKy0O125qgrRhAfSVZLBwIC5KtpGNEVSmtjmFbQHn66ZdGzWa','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:24:50',NULL,NULL),(45,45,'ZiG7ApBupwGCeNdaWSz0h1b8AfOrMx1S4iYKQBfqORlgwtn3XMkonLbsa5tjjsh4','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:26:16',NULL,NULL),(46,45,'tyY62JNOCXCM395ALvWTEUqt4NKRZh1M0EuaPHn6fFG8nVHSjae728ifBW1skx3J','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:27:53',NULL,NULL),(47,45,'0QEBmGXEBnyAX2yWxjG8kPMJ5L3Fa1rzQut1x7DbpsOCTbY34SounwNFZ7HmSRVw','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:28:38',NULL,NULL),(48,45,'s3DkgYeAHqU19OeS6uZXiVAnIxpLbVRyiwlcTYtNyjMcwX9zJ2hmrTgl58vKCQB0','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:30:07',NULL,NULL),(49,45,'teW5cXMVIrpYC3bRadrgmixL9xoGEPs9X4N3TtFFkjGjM1nK8EHZZaflhK0QSck6','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:30:21',NULL,NULL),(50,45,'wRQScoGFO4bTuxZq7CJH5Oev9SUIG8rp4PXnUmiyRmJY9aAW2qLLwDVMy1EMugNk','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:04:02',NULL,NULL),(51,45,'NroYqvPTtUeEABOTDVQcp5CjiH20BPXGZMVuh2afhfWd6rFkHwLY59u4gzCROn1U','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:04:50',NULL,NULL),(52,45,'MUktSivA8If4bCsAZONuq3EVGfXlFnI1yFa7LQtppZiluNemRjQWPMTP2TCD0Vo6','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:05:30',NULL,NULL),(53,45,'UhlSBipZdk0TvOADhEdMViZjqnmLYOF5tcrl3RmfTksJU7nV83uqBzYN4DxvgH5e','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:05:39',NULL,NULL),(54,45,'FMzY2zlCk3m7S9vZsSBWa4P86U9yxxdnIZXIGfKB4iwutEmyLD87hJHO2NlQ6YnJ','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:07:14',NULL,NULL),(55,45,'9NuZ80V9sNOvmAWC3gLTEPoAFDgJVqHXYkjr70PDemheFh4G5dofdtzjb7QpTJ2v','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:08:42',NULL,NULL),(56,45,'xiZSQKFnP29fDZNXhhQyIUvmEtje3dK0k8EacAVlI1z7LpGbBXRj8s7J9L21Cdey','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:09:00',NULL,NULL),(57,45,'hUi95JmF0lBsr5QilA3cf4uEo0TXavnLV3cORNxPqW1Sd2AxEwR4quGMGK9QXH6P','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:11:18',NULL,NULL),(58,45,'R9MtjGB5vTz0uLN54q9kp2yHsMmnKUKH1qljwI84Jpkad7bgrxOxoFrGfy60VIiz','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:11:34',NULL,NULL),(59,45,'cXagx1lawJA9VuWEvOshUDZT3Cqzc8ADfFlLPB7Ot8UBd2L5WqNkmRp4o4PInIyb','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:13:15',NULL,NULL),(60,45,'V5tOXM7ibZuQPGExqyI8ec3lJWpcApANfCPKbdz4oEadLjZskjIFUDmswaWym1kV','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:18:36',NULL,NULL),(61,45,'RoGnySmPhYcEFFcqMuWi3QOUvC5aDAa08pJj6nRHhTrAlK7qp8bo1B7G45Nif0lP','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:19:49',NULL,NULL),(62,45,'a6lIt09RmhfqqWwJPLzIlO74ceGxU52HZX1VT9k1t86LSuOvQodjkQC7oNnmM3Kg','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:20:57',NULL,NULL),(63,45,'XLXw7WlafJdDpifmKVrFu1APsdzk4nCm0IZGtu5gpNUJHEKG852LZ1AYeqsx90Vn','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:20:59',NULL,NULL),(64,45,'mZbCvH09VR46q7gU58YSlxurPCed4VHuLl96hOEcUPp3wnXEGkB0vGiBmZW82OIq','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:21:30',NULL,NULL),(65,45,'8dExsz2vHVZfdNKM6ShFoTgWXPPbearO2wRNqQ3LF7i4hCmpubMJBo9y15SviE5Z','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:21:54',NULL,NULL),(66,45,'tTXC4sQHtwLAOevO5u2gRxUSBoKxLCFi6aZwN061fWz4D5VPpkmDvnia2TYJyYe8','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:21:56',NULL,NULL),(67,45,'M8z5rIz1mYymxxwBHnDKUj8sPXS4cCe6jQqWqZ9LegAiaB7F9Z0YpuFJlpAbnO6b','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:22:29',NULL,NULL),(68,45,'La897QzK0qkbnBJ8WXsPjB4uu6IgaceYpXM3cmFh1MrwRzNFvRprJgHxOby1iDi4','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:22:50',NULL,NULL),(69,45,'u2FrdnFMNlgXjfzvzGX6Ie1iw7A1OysWG6S85JNYT2x0R474pe08UbEKUhVKphm9','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:23:39',NULL,NULL),(70,45,'vjjcX9eT75wcRx4IWp7ad2qrYophT4bDGP6zGALuQtKH8HVtCfBOiv2MUqY9NynE','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:23:58',NULL,NULL),(71,45,'WWZV91d7jkOQYMiEDZIzcHeGxFtUYmhfNXG2U9CKreRblB0rJ4Pvt5HAyugbVImJ','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:47:39',NULL,NULL),(72,45,'QzRnEpfmzLtXMJh3bieGNOMYgB5VWdk9Ud0JXnkUhFDKLqT8lRfVCEr6vY1BHPoq','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:47:41',NULL,NULL),(73,45,'2oz8RWCU6P0CZLqWVKhxH0tEBdyHYfwckUKXvJkOd1MYiT5EAneusDnIpQJe7lDZ','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:47:42',NULL,NULL),(74,45,'1pCB3bRWjKaGv285MUazoMYun4QdnJ4v9FKrVlEN1hCmmHTxE079SlYGSU52i3bL','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:47:42',NULL,NULL),(75,45,'D0LWKbGoNCs3ZdA6fOJYeJMPV4vSntczxUWjAXbg36Ei7V79g0pcH2Lmf4rMXrY9','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:47:42',NULL,NULL),(76,45,'bFCDdrWw4lLQ4Nx1BMsVdNjRYXwa6qEDy1mquno5EMkKLZalUIKeG7i0myfjh58S','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:47:43',NULL,NULL),(77,45,'vnHaL2lUyw9FzHQkpBRBtXmkfMJTeRcAKYSiq01suXIjDhxbLTfSjdmE6br7noiA','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:47:43',NULL,NULL),(78,45,'TtNoqs0qmu2rczG4pZ375Ugzo2uyRa9veOBNnCVfKFOYAQKSXwSPgE69DDdbnRip','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:47:43',NULL,NULL),(79,45,'S4vDWAIVQ7rKOpTP1gi4QAFSIU26oeRPVUHBaFlB72sac8qXmzwvdJLr9LYC3mOD','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:51:25',NULL,NULL),(80,45,'sbAHMbQUuEp4W1D08h98JrwXGoxhCtPn6FAiPfrLekw72zTN70EoFVNTV5v1akna','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 14:52:39',NULL,NULL),(81,45,'UEbGLNXYtB5J1xjn7FTOhuyk31zBGrmDsbz7C8xASUiK59osIyZSQMfcliOLA2Qe','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:54:23',NULL,NULL),(82,45,'IdrWFCcpU6yjadfPDBJpuZTSwqH9oXitfNTJV0s5nlArGRuY2MiXcK1G6ebto8YB','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 14:54:50',NULL,NULL),(83,45,'OswzHPTL8ggvUpKwVymDiZkmvGXrPxMnQ9Wn5qfNeUA4GVM633bSIrdJbfEBquB9','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 15:02:25',NULL,NULL),(84,45,'tTGwcbM60UQ7g3PFLUNZxvWfLbB4onYhuGp6OK2s8CjRrRqqQAtkShFVViY7BXgP','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 15:03:44',NULL,NULL),(85,45,'uXm3gVAQaiNS5XoULjl62f7JGBZv8VhF94QPdmBzCMD1eW2tgwT9G7yqUNFEstyi','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 15:04:20',NULL,NULL),(86,45,'eXRyT9glQCxl7GrGgEr1QASdozvMhRdHBWPLBHIpwJq2V1Vnubzn7Ouj3ahLSjk6','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 15:05:11',NULL,NULL),(87,45,'3lirFUcXvpMJrma9GWH6gyIC9hYtR4z5x3NkKDLwQbvTB80G21s7nuDo0RpT1O4e','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 15:05:27',NULL,NULL),(88,45,'J3jbiSM1WNc2sIDRqtona2Y1zwL4CkgPE5ZvrIAxqyF8m9hXYkEwOr6eBzZlWVpQ','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:08:16',NULL,NULL),(89,45,'mijE6gH7ElMJYP1s4ZeNPSWsZdDR5rOTYTVh6OkuzfXtBehWKbjuaKDnza33UqC1','dtmptnrnroc5gk1om0afs69k353qj81b','A',1,'2019-04-30 15:13:48',NULL,NULL),(90,45,'7emZd2jZJg8oUEJC6glQjdewDqF4sRynMmb6u0ArfiOFBQkr79WAcGsNxU834T2f','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:14:05',NULL,NULL),(91,45,'je5HgqM0WnQCY7V3ePbmlaKRzO4G7gxFKL1xTkTI5WsidCkrYZvSmwh4EojDMvGU','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:14:22',NULL,NULL),(92,45,'2KSM9EPW7vKYy1xrwVOBehdmBqLR4lvTNr7w2p6XFiiGo1RhfM8asCHc5kbFU6ku','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:14:39',NULL,NULL),(93,45,'0SqniCjmCzeDUNWLHkcy2GT58JoEGwF9DpT9sYBhrnKo4MvfcXJqvdaQure51B3d','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:17:57',NULL,NULL),(94,45,'SZ06zyjwu1rGp3uvTxXOKBnFOrIHathk5sqeIdfZc31YxS584oDWEA9bJ6FLf9bK','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:21:53',NULL,NULL),(95,45,'DBepQNMyfk3vw4M0y26xCuEqFWOOdSiLUmDFnmYWAZ1kEpIxgNaXiI3asH7TjVRB','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:22:12',NULL,NULL),(96,45,'lzlGZEafxSyDtTnHj5Pq6jXkFJWZYY3w86CqoS1PtNKTzQ1XU8Rs4y29uBFmfndB','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:23:34',NULL,NULL),(97,44,'xFxFiR7TN526uLCG81JnMVKUAflCywW7zqp6pk3WEb3d8vMAtYDrZcOYhBesSqkX','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:23:39',NULL,NULL),(98,34,'e8zzFgN0onaW6v6KJS14nL9BlQ9mfFNeHIDj1AIYBl5UO2tkE30MThGaqPsd8j54','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:23:44',NULL,NULL),(99,45,'AfQVgTUIFYhdcxDcxRPaOv2roDjSHefEX1PnzRwy5tT54NF2qCskJu1a9UrOgeHo','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 15:53:35',NULL,NULL),(100,31,'HDjZQEYyYx4EP5u10KvxlBLOncb5AX3ewrpCR1ZNgU0TN3BztbsnqWM8m9mGfjg8','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 16:08:00',NULL,NULL),(101,32,'IpnJZsrf2jZqK4PyExWRji5aTqlznbWYMUmNsf2r9DyakKN1dLtQEoC6JOmF0Y7S','dtmptnrnroc5gk1om0afs69k353qj81b','D',1,'2019-04-30 16:08:05',NULL,NULL),(102,32,'oB4VWqXvc5mQIEDPk97VC4vifoAuG9mjux7zfKe3lBsOWLGe2ntxZp2HqFUzwR6L','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:02:34',NULL,NULL),(103,32,'C3HUcEoWivlJiFJT00R6Bp4twagSpLIknka93F69oMOzP12CRXSQgrU5VHBV7P7b','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:03:28',NULL,NULL),(104,32,'F8y1gT2ZHdYIipPX6nKehKAvCL0ZrJmN98hRsAVB7E9oGUlV36DzgkfpwC5NaW4I','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:03:58',NULL,NULL),(105,32,'hpJI9jNGQcigr8ePd83ShufRyZ5kOSxseGgcpqlWnC0Y4aKzEMAvBX29vyQnVqB6','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:04:16',NULL,NULL),(106,32,'0xulyvPWi5kqp3IXMi8LffSbS2LvIUVPQD7rbCyFe6gK4uQYgw9TT5E8aRtmAhBq','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:05:52',NULL,NULL),(107,32,'bViF6n3pRmvEgk2o24KLwW7zINSYj5PlAEOmdhrcyTJyvVgprTGXWZ6uzFYoMBqJ','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:06:09',NULL,NULL),(108,3,'nS46IhkEldnH1jl6Kq0OOiCWTieVcFXQ99ftaDLWMr5oRyMsxB3XdJQAtwZUKzGp','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:06:40',NULL,NULL),(109,45,'AHMNTuUBW3ysNPFXO9mJZtg4jUfXmC5qOwxRYAwlyPp624Io0cKScnldvfbgCT1K','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:06:46',NULL,NULL),(110,45,'goOWp0VtoTSlh17Mys1uFd5pHaef89T4urbAExBQwGWX42l6vEJOgn3PzDbLKB0k','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:08:54',NULL,NULL),(111,45,'OXud4nbpK2MIprXPkwxVSFYjsLHloY7gvQknQ8lNLumIiSaDtdaGUZVNBfB98WyC','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:09:01',NULL,NULL),(112,45,'ih6aQr9YfyUAXJTIkW7otTK7XC1Edhj3HcNSkUPd6ZGYsVC9gojL4yLciuM0AubN','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:09:40',NULL,NULL),(113,45,'wGJQZT9SuImMh82Ac5j27GLUxWg4f7fKoaDlgCXNRNr4EinVteQFPHOLVZz1aqyC','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:10:53',NULL,NULL),(114,45,'3HXddpwtlhstMZoUv0zPin9y8Ejrfc3cRQGgkSIg1JZxTuEfYXwDb7aboMx7uH8D','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:11:41',NULL,NULL),(115,45,'c7ANPKinHfn460NJFst0krzb3F5VcSEZISpBVjg5OUIdmz3UTjeu6hquvWvHs97t','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:13:05',NULL,NULL),(116,45,'ph84HdKdzbWU2GocXjBnl69OFeJiCuyfuivkREzYVwSynBEQrxwKZ2g9vD0XtfSF','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:13:08',NULL,NULL),(117,45,'OGribAg3IrzFJIu57Bv9CkF001i7YsNDzBaS8T5ShvyWp4OdWsyJwg1NbhfUocEQ','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:13:53',NULL,NULL),(118,45,'YxKIHwzmBCf2blh1W70Ld5SSsTGCUkQgjhmVsP3MJN8VkQDy7ic19PZtAT4lpFUE','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:14:23',NULL,NULL),(119,45,'4uuarjzEhkAhaWmq3o5I98YBU06rgiDGsAfXbHcL5PmdQZHtwRGSef0lw2BnNR4U','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:15:36',NULL,NULL),(120,45,'Go2S41rdpXNz9HDJ4v3yRgqPseQ0mlR8tBhwFMnjZYAOhEueuICtQKTUGo0x8vVL','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:15:44',NULL,NULL),(121,45,'lJSsVtzaXY6ICEFfEybx27xkU5leHSnGLXmBbWjcGj7CPmN121qNkzYAsDg6ohQg','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:21:24',NULL,NULL),(122,45,'CZfZqjV6Jx9AlJO1X2MiBVC3s7cwEr5p1TUoWbN5TgAyEU8e4IfYSa7d9gnset64','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:21:41',NULL,NULL),(123,45,'eWwVVxZjFgAXSEiYzAQ221Jkv5KGlUH94OdesOozMc3a5n7UhSJpkFClLRI0gYM7','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:23:23',NULL,NULL),(124,45,'ljfQo9UYMyLh1ib13VqE0gLFdTwDRiqv9csa4eQPKuDXGtuJzkVHo5Ws0CgE76N8','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:25:18',NULL,NULL),(125,45,'eC1EmM8fqJ0lPzT3XB9QBikpNw6Z8aVWGnbdDgcLe5n34XMwKjs5c0vu4PsWrtiY','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:26:23',NULL,NULL),(126,45,'pZCnMTXqcnBu5WIT2WGoeKplbvxb4iMrH7jfYF6zm8UJhVgeAdwIj59Vqv8c3ask','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:26:36',NULL,NULL),(127,45,'8jdv25GJ7kFC85rxV1IPlCwALRkNRnvSiGZWFyOHhurnKO9boLW1SqK76fIfQqxV','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:27:03',NULL,NULL),(128,45,'tCIIM0mW7kQAhrdag21cbhowxJaJowX8YZbsNt9He1q7TmvqfH6TySBilOxUQi9D','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:28:02',NULL,NULL),(129,45,'CnH62jDOmStqtATCxF1VKqGsJwny3di5D9NOe4pf8FhdXayb4lpRUP1raWlXv7xe','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:28:35',NULL,NULL),(130,45,'Ed2D7wveyVQkNegUJjIOzXfZC3d0R14AW8ion6ynSzH2Vphf8l5tNYrZFRqm7btx','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:29:34',NULL,NULL),(131,45,'B3y66h4oNJ0al1atnQsjs8pv257NoFe3rDMrec0YDXVIwmyXzRnqCivTHEO8Lxfu','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:30:09',NULL,NULL),(132,45,'JePUrAX9VMWnYHoet2WFd1vvTOrtyuahlhSzjb23qYludCbp01AnV3a5kGxNwx4c','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:30:16',NULL,NULL),(133,45,'JvFqgMW6jBpjIkw3QZ2chfgG1JWAPL1oUOEbsUnSHks04irOBz8maNMX5SzIu42f','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:30:40',NULL,NULL),(134,45,'wYSdOmFcS5hq4K8XU4eyxblM36VBut6ZGiOqoKDY71UcuPHz2IgpaR7LFLTtCkMs','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:32:13',NULL,NULL),(135,32,'mWbm611tpazKVsdQhwdXDCwZry5cSgh7cyY2DvYNVxH9XUMGEinklEJRtGkzL89U','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:32:52',NULL,NULL),(136,32,'me3kv9cEN14jZAciQKo6FFbTmGzzVXl2UwLjvCIoWILqi8hN8Pru0RrUHJpD3GOp','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:34:23',NULL,NULL),(137,32,'rCjkutMmLrzF2YsVTeouQwbGOkKmMdZzf1vR3WeULcBxYI99tgHJcARw4lnNyE3q','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:34:42',NULL,NULL),(138,32,'qxk1LNC3ye7HwieD22bglt69QEMALDOghW49pYBqFOIsG04Ul7wQdUaTIcoKJoyn','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 19:35:17',NULL,NULL),(139,1,'84VGofIB7BLi8Pe3l0nKxzJqCd7E6QHgAGPZ4H23ey5VmnvDsoTaqbh259O9kkCU','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 21:11:36',NULL,NULL),(140,1,'HxmuVpZyfXDMP5nrsvFpAVoqKeBPW2Ytz9EsdUMiJ61wHRevjJGSk98N0gjwRxSI','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 21:15:45',NULL,NULL),(141,1,'0jaYRB72u9wPmi5KZUytQYDroglIGTADojds14J2zUC6HWcbG3M1rli6uv0pCVbp','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 21:16:19',NULL,NULL),(142,1,'Zd4cWJv82pw0KqSNGpYbat0MYUnGfHiDSe9s357MlCBzer4hCmkQbyIRjK6gkaOE','9oa8m94q7evqub9mrt98tf3ru07d1kan','D',1,'2019-04-30 21:20:29',NULL,NULL),(143,45,'oOVGu15h15CACtiRIX03kFInHoHBw2gWvUNqrTs7ZJndmWYSzOu6FNx4YAExBbtK','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 08:43:10',NULL,NULL),(144,45,'TWCmGyKmcAdbY5HRgSJo8z9QEB0ckFlZVAsdgbwO31NDpRXlOWCZ9vhoNPrIjf66','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 08:46:46',NULL,NULL),(145,45,'n89n2aIjTDpi6WptrmGAtXdcsxFHoPqI3z2RLLhkMEkBlrcBjdNClTUhmNySODX0','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 08:48:14',NULL,NULL),(146,0,'Z3vTZooyPWXdrM9EzrBstCnfpquUJRuBGG12wNjmyhEWKjeOQlPVd4vI0gLMOiTb','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:48:50',NULL,NULL),(147,0,'CuYoYv1mVAflyEyOpDTfr43z6x5q2brSQ4XdBHjJWh8jw9JiGUtev0hgFmE2cQKX','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:49:44',NULL,NULL),(148,0,'XFBxzYVm0fh94S1tu8HkjiBoNJpoc8Q9azXjI2s2gprb13PLTfG5sDEmRJPcWWVS','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:50:25',NULL,NULL),(149,0,'Q6PVEMkzb4OFlWptKxmg2hXoyUGIUNfh5kZLGP5cfBFjvQAvBOI9w0T3aJ8HnydD','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:51:21',NULL,NULL),(150,0,'JhCpyZO6TfPEQ054bR1M9bzHU8oGVqt2YCdrBiuwn5w32eL7ZyBKXUJdcioNu4rR','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:51:31',NULL,NULL),(151,0,'KpZ0I4jg7ishNDfE2YBu1xVZNzRrASehbMqXuyTFKwk7C4XJGTPDW0Hw8n5llWgV','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:52:23',NULL,NULL),(152,0,'NCanc2wVqYKm40rswOtkmU7vJqQWjt3oaGPZbHP1IHUDyjXpfTeTEAuO5FM4xAFz','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:52:34',NULL,NULL),(153,0,'8WvQFkAKy8WM0pJQ7CYOn53pOUhdTVwSceRVtKGamXx6Sji46lYFgILDy9UIz9Z7','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:53:16',NULL,NULL),(154,0,'DhV6mnPEReSIlLspbJzZheZoBCPXOsgyrkdqBFoqRn0JKvMYG9FIa1fvN253CcLV','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:54:56',NULL,NULL),(155,0,'HpytPc3nXgBpNGwb5osEtCJSdKRWexQAZ2wqlMNQuU7ziZJV2D7qa9VsyDETxbze','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:56:18',NULL,NULL),(156,0,'13lAhDN2tqFcjH6YCyGh0wsoefivBNAC5pIPgkzx9EQ2740BgebS4uEjKZXGTyda','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 08:59:00',NULL,NULL),(157,0,'i8fh00xHYQi41FTtC65mgOwyEKqvG8cYGJJrDA7flR7WVZpsdCSnutA1hwN2QB5M','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:00:46',NULL,NULL),(158,0,'VF9DuY72lfv0wa7cHjrHZ8PKt3kJbnneIMbhVU6IC5vjsEBiyygtOwSZkMDzKz6u','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:03:24',NULL,NULL),(159,0,'29efpt3rAWxsK0PChOuORymaQnyGjwFnJG8NcPYb9Ae6kvU7vdLgbDzxZoM810Hg','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:04:07',NULL,NULL),(160,0,'1pUcVK4klkO50yeqRYDaThACGtqywGSD6nmBmrPN3Ew6o0z1uLTL2MWjiClZRbge','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:10:47',NULL,NULL),(161,0,'R6wESNVGZFDOvCCyfuLeRU40g8QBz5jwAfvtl5SEOKTHstk143916l0iXU8oPVPx','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:11:49',NULL,NULL),(162,0,'SW6zLJyPXUTqwAyv0WdGga5Ek3rYC228JO4mK9Qx1lmVCfDKlVMcuH7D0snAGviF','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:12:34',NULL,NULL),(163,0,'WZJycEud2QSitKjnAwBHF35mNluB2zAXeOD4Q8PtYOEvaNc71TWJVToj4k9KUyow','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:14:33',NULL,NULL),(164,0,'5qAFbrJyEK67DNII9aZ1Mi0SxHmdOTvFdPW8Vhl6oCotwjj4lifcJAfgVX3LxBTt','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:15:42',NULL,NULL),(165,0,'l6TQjjfJ8m5DEc2kA4FcxQrlBNRweM8qvRiLVfE0OWPu7XhwGanbgM0SuUsgaTzZ','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 09:29:05',NULL,NULL),(166,45,'kZkeNNuBLtYpwirveKZErMIY3PGAX1y29UcDSzmtQ3B7oDSdb96hij2wC1TPWJq8','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 09:30:29',NULL,NULL),(167,45,'LPL4T1yzrQopkNK9pYbHCoawabeiU70g4sEBjZSRyx63Qq26uV5Xl2hmcmOVnAs3','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 09:37:27',NULL,NULL),(168,45,'z7MxY2atbHZDWrIKHKcBoySUwELvFjXwJulg6TTfUBXmQa3EdZ4QpAk2z1OWFsAV','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 09:41:49',NULL,NULL),(169,45,'VzpJsyGo4EMgtZDEWiPreXTBLlJU6rhFAC6ZObdayu7f2jVinS8MxBD9vvwmpYNo','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 09:49:08',NULL,NULL),(170,45,'mnwAWGjJZbOeMCrKBqYERgl4Tkj5CKtShh9q1zz2LlGRFayIgU1o7sy4WJAteNYX','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 09:49:34',NULL,NULL),(171,45,'Qp6veblZcKIdgK9mUnfQzcaL2NMC8WH4tF7Gz8JYeOD2hNB3Vi5Z7A5l0MtoBJLx','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 09:49:49',NULL,NULL),(172,45,'u3pedHosNzAQr1jYcT9qhtkw3zY7OinmuvDs5KAWa5Pn4XyXUx9SEmWlplgJ1ZhI','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 09:50:16',NULL,NULL),(173,45,'HtzBDp1xMaVq3u2hDmlL7Kb1OUUQCFXIo7JcwENYPs35gxT4OJvC6etQkWrkKGgB','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 09:50:26',NULL,NULL),(174,45,'OgcTl1Uxvz4jECI9R51a7PnzqFjQ8AX4hoWUf0IOFES5mLDKtPHmMe6gJ7kphy3n','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 10:02:57',NULL,NULL),(175,45,'ALxalOpHh5ST0Mr4NQx2dGCHoe6CAXBrqbK1muEk3Z2iIXm8aJWgT60vDSG1n8Qg','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 10:03:56',NULL,NULL),(176,45,'awGCXjmEatU1TJe240ifno3M5IrGFhxsuPS9KeL6nIbRBHWEqNDCFp8ADU07d5fd','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 10:06:09',NULL,NULL),(177,45,'wQ13y8NnGA4qc9aUmDOvlHtToeBg0ztbRWifMmV6PnLJXY6yh45FlXCiQTGZIhrj','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 10:57:20',NULL,NULL),(178,45,'YQphjIR1miPHlNVVrvCRSyyz5w9zxODJiWfvJKtFwa8b9QdL2BefoX0gmeUbZPX7','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 10:57:22',NULL,NULL),(179,45,'SzOY8kDtqIj9ho4gZofTe6D0Wyq1yGN1VLTnQERuwCEfvPxG33cOreNmFUnspB8K','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 10:59:59',NULL,NULL),(180,45,'MFLySZCafBwoYlbLMqDTuRmJrNjyD2TBveu5KPJt79Sg6ZEhzlftjv4H36VsnIXA','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:10:28',NULL,NULL),(181,1,'OCgch83yXjen8VoPatNvjRBGr5bG1aLxKoPNusfuRe0z442d3VCTTc1s2AxikqQw','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:10:30',NULL,NULL),(182,2,'2Ilh0s5OVJHEZS7kwnkGQRM6gReloEUIFpCNWs4xgfCKxev3aLqojXaY1VPcbf24','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:10:44',NULL,NULL),(183,45,'8CwhmAFl6964qZWY5BGbc0f0Szd1oPknEPwn4VEZm7ugriY2HCTOpeLkIlLKfXDQ','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:17:35',NULL,NULL),(184,45,'ef7wnIz24ZyaoOMYHBg4lJByVvmvYOc8QAsFSdHWCCn9gJqfhtXRWENkLsTtqT1A','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:17:35',NULL,NULL),(185,45,'jzLnYh9Kh7u4Ukvaf5nu89IUqittpgLFZrCWes6kR6GA0qBdjPM4Ebe0N78FyciQ','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:18:35',NULL,NULL),(186,45,'Ov1B4e1x5SC0DihXZgLg8QbWSq4sDnVjEaqICPdywK72uJTrcniom7b8FK6eAofB','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:18:35',NULL,NULL),(187,45,'1FnZM92LjjDmozrfXANUflREmgaSEv8eculOXyOIb060HvYcRMZCTpFWtqws5Y6s','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:20:43',NULL,NULL),(188,45,'O0urbL3pQ5UHJJ1FfzDGPVYNObRBUd5diI0l6YLjrm6k2jc9ey8EZPGsCFHWvtwn','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:20:43',NULL,NULL),(189,45,'G4y5kMl6z0UIH8cmp2MkqtWxDEDNsQa5Wwmvjr7e3K24SFzZJORntFb9cag39HfX','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:20:59',NULL,NULL),(190,45,'uNJPmuSr3Ugi4jGYbvqz66hzOvXwhlYBWy91Q5mHRZQKaXxTc7Z4nksl0CbVMdLi','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:20:59',NULL,NULL),(191,45,'wSJNk6xgcZvHT30hecKKaBLEAfCSVphjVB8eRilqtEaq87sbId7Wsu6nro1fzRwD','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:22:32',NULL,NULL),(192,45,'lt5IZFDKM4TWChjbwPNyg2QOYLmDepuGhX1zkz69qMKEbsGcnn0JrUVf7Wp8lQdB','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:22:32',NULL,NULL),(193,45,'6fGuUEEQHhz3ApsUmDJStKxRPcPZa1d61K2NMAkpB98bfbBwvQIqekesWWhwiVN4','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:24:18',NULL,NULL),(194,45,'7ac6Wf72HZJgKyiqXOmV3vaRQQy8rGWTKCHwAoILthUnBlBPUpeX3Tcvr05NCSmY','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:24:18',NULL,NULL),(195,45,'xlwrOVEvW7JNRabatLh2fsyfXnrWcCydDPz1Fze5CiBcm0u99JgkA8KtjKNGvuHF','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:26:54',NULL,NULL),(196,45,'COPNO7LZuMDrl9iBmKn3RYPJg4bBVGGI7QJLVh86xSEc00tDwv5Iocmy2vfqsKfZ','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:26:54',NULL,NULL),(197,45,'VaeZ0mli04XFQ7jCr1O24pkG38Idh6nVDZsBEusoyWRqPgkC3yxYHvtzzdw62Ybt','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:29:54',NULL,NULL),(198,45,'rFkl3eqNx30CpPJlcsEZExtrDsQVAyG7mmhoNOWgh1BRX1WyHei2tG94oAwbjIwd','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:29:54',NULL,NULL),(199,45,'VJ62zbrBEwC7TNEwZeix1xnXHgXZhUWq1PAcakfdYcytm3Y9hqAV79ovQlIS8Wme','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:33:43',NULL,NULL),(200,45,'iUOeZ5DErWqis1CMyVHxgb2xzcMYuP5GOftR8TFX2V8wJAUdq3moDIhr6HZGYnkL','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:33:43',NULL,NULL),(201,45,'ocioWe07aXdMvBZmP2g8gJn5w09JyGd6VEc35ihv3OCpfkk4tLYnPWhbTBuNOxXt','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:40:47',NULL,NULL),(202,45,'yeZSXN9A3T6wi1pArOeKFsjO4IQqtHcM8U0CP2qklBgy4VGfMZP3bicRFHJh0jBw','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:40:47',NULL,NULL),(203,45,'sG0farwWaz9jv3qLMJBk82PbbO6IEBRAzcQygituqRhZ1TKpxwNmHPhS8C9kDZo7','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:42:52',NULL,NULL),(204,45,'Vr2bBSkO9AwZ7JNKCCRelEZtYanWdWPuI86sTpT7SHwbxQlGzo4hgpRAV98i0tF0','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:42:53',NULL,NULL),(205,45,'w3sDHFtpq09JrMD82Ypk6mVvyeUZUynVjbSuIRH8TzoWxJclKAiX5IEiNMthnkm3','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:44:05',NULL,NULL),(206,45,'IG9G7BRQZqo1l49J5psF3PogVpTn5JcOSlb2HNA8KiCtFDgkybCWNeVL86Skwjnj','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:44:05',NULL,NULL),(207,45,'dtfsuJwgZR7E02poXeLPN5hXYUMfkqZWvvtcH4aBGFLNHWQi1x3TDueodq5ABjIm','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:44:43',NULL,NULL),(208,45,'l7FjnJe4rx6RMIy6GRdgHvbB91Vjit1fmHKQNYsMXwox2LkUPphDtSmWyC7n8pPJ','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:44:44',NULL,NULL),(209,45,'NxtwH2q3PDoaWrrVV4mTSKto9A0R7Bau7qb0UvDijsWceI9Mg5NhTG1CGKAXjdfy','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:45:05',NULL,NULL),(210,45,'Ia1MrAaJDED3lUf6SuqyMnt5bHbLLEXCeF3yIpljRZ7tU18H52e9RVuFcj7ASTNp','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:45:05',NULL,NULL),(211,45,'sdnpgihKtQ02lNY8Xvf4YiEugyATRGjBcTRU9NImPoCZOOW6SFJxrX5rI9c7bQwx','6rd5tnld9cm6o3830fj2814pt2vlm7te','A',1,'2019-05-01 11:45:16',NULL,NULL),(212,45,'0V8My0YCqHpf2dUzDQXOAgGtVZbhL9194l6O3K5YRPdjXaNojUbMxcLuQJWcsDrR','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:45:16',NULL,NULL),(213,45,'MQFyoiK0tJDzYCeUi7A2IpYHSx95XGJ1N0lusyLcWRPuKMvRqOjSXVnTBGI4ZzP6','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:45:46',NULL,NULL),(214,1,'WhKQe5yQUVxRRiJS5ZZOVsr4ulhCw10EzMNxWAg6HPoOuiIK8T9bfpvwDGcaSfJb','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:46:01',NULL,NULL),(215,1,'m0VOl4ePnWxb37PDEEAGSDqvjsvZ2KzdHRgXCaeWlxcQbpFIrUpozihH5YcYNjk2','6rd5tnld9cm6o3830fj2814pt2vlm7te','D',1,'2019-05-01 11:46:04',NULL,NULL),(216,3,'gWFAzNmIw3DTiNxdbntlS8gurGzj8yEo0hqO0peWZvDPyMsdcIV45Y9m2aVGan2F','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 19:58:05',NULL,NULL),(217,1,'mndsFQrB5Fs4ANSSy83y6rHbVCLw8BtfG5fRei4jgLcYAxZmn6ict7qE7U9GD2wv','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:04:37',NULL,NULL),(218,45,'DGB9xwJ2fKda5rWr6Y0iVW9wNvN7blPAhMz4c0EfDXEZCFh1mFUSo3QOs1poCtyn','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:06:56',NULL,NULL),(219,45,'6m7xpg3MuTyEzzr4ccZT9P8dImABwoNQP4aHstr8IbWDyxlUfakAeBSo0CMXtCQZ','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:06:56',NULL,NULL),(220,45,'NQJYxMVIFSJERWesu36yHtPmmaKa2ZUwqbFBTD5vSUeQkTGMdOzcDgARtGPC1n8B','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:09:15',NULL,NULL),(221,45,'HwVnfC6QBvAT7UefvNqLMQYdGZ26PklSEVcN09ORau8nDpFmFSXt5DoIsC479GIa','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:09:15',NULL,NULL),(222,45,'gQHGncSiq0V9XuXBbefWZKjY80gTrDstaI6nzqR43xmRlL5SehAE84j2r5FdpfOE','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:10:12',NULL,NULL),(223,45,'KboFFxWBtszrUu4fji7GfEdz70n2M4nMyKOpLglUkoCeNeVYv3tm6CiJ2AIE5H5J','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:10:12',NULL,NULL),(224,45,'Sppah3EeFO1qQSXdLr4qW3rMbEHCzDgoaI0kcUHcPXvn2On5DJRkz6lbTxgAeBWj','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:10:59',NULL,NULL),(225,45,'EP2pONLyBXudnBkIS9gYsfnRpG0abKHMzNxbtADZKcZTeSLwq4zEWeq83fDhaiV5','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:10:59',NULL,NULL),(226,45,'Gbu3IOxvS0w4QIsTeWb1uAGAwNFv9HqBnpzBzls071yEj3mFrUcMhKYVkUX2Y9jf','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:12:39',NULL,NULL),(227,45,'Sx2CzuhmsDcjoElOSCh1wFjfIKnDVqMspt1U0y8nYiP9MgbWTc20atQNew9lbufE','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:12:39',NULL,NULL),(228,45,'KPGJit63s019qQpLolSj9WUQSkNYxTuh8vRMYusafK6kX1D8lG5bIjERoCrpPZHf','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:13:04',NULL,NULL),(229,45,'xaxjIDFQCeoNGYgOLCDH8y3ldghN5jkWpMU81fczEKG7r6VmpluVw0PKvbZEeirZ','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:13:05',NULL,NULL),(230,45,'HXIyYtpkCZ2V44hUkeFAIH9YaqLhSio5XKv8gOdRlPVNBsZKAGxGrO6neQblu0S6','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:13:47',NULL,NULL),(231,45,'AT1E2VCPeUVuT96rZbZyt74OaSJRozPCJ8wsz9woKGWIf2viMyq45xSM3c5gqubU','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:13:47',NULL,NULL),(232,45,'OqxxMK5nOI104pWkKuyTwzGmzVHeCfc76UhSf29sdtQkodE09eFcvVtvnoAJYTXj','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:14:55',NULL,NULL),(233,45,'G8Fksw5c7YBD9xHTd6bDphSfELuqrgrCZcBKLJAgYieoFNCUWOjV3MbSxVmaT3o8','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:14:55',NULL,NULL),(234,45,'kUvMfoBxsDAYTe3tSO1EEa2qpQhPMGr4Zom189gA3KwF56Na7kYuiWbq7w0Xvyyi','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:15:14',NULL,NULL),(235,45,'HZWZ3Xw1MK2rChNWVetS8yTsuA0Pgc7zm0UDD3nqVRB9YEIXY5mJAyhxd1blKjdt','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:15:15',NULL,NULL),(236,45,'IyZieGhksOcSG4Jt7q0z1DB86d1AMHRnNEfLWrhWbFHObfVlUag8nacLF6t25Kvp','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:21:33',NULL,NULL),(237,45,'uzLwj56j8ESniDBL3ZbYdSGgKeqzlPaiTOUFDGpTd2h7bmug70mJv8w1vfAqZ2yx','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:21:33',NULL,NULL),(238,45,'6GY8G3yl9HoVsC4gqIE5ejDjXPukRvzVmTb4ed8nNMXxNoig9C2bKLYcw0yh7B1S','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:21:55',NULL,NULL),(239,45,'hR5voNJt5S32zQZTpVfeXT0aOjlwExk43mz8Uc6ZAwndPNnPD2u46H9ySdlj8o0c','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:21:55',NULL,NULL),(240,45,'PR8foYimHVjB5XTNcSG6dMu41MbU0LhOCFHpr7otubYfgPTqrSJm681ky7tGx9w2','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:22:51',NULL,NULL),(241,45,'7gBj8TpQBIOcfXaLpEz0VyP9RSFAexhFhji5t7bGZviOsfn3391W2rMoKxXmS5kq','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:22:51',NULL,NULL),(242,45,'C6nQOfADWSZDLNROdclEm9kX0KGEeXvjIRI9tfJ4bo3rGgBxFHPWnFxNKV2imq6v','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:24:18',NULL,NULL),(243,45,'JHZUJYM39qOb4oXlud0t1xpvrl2I7ug785IhHmhri9jVFsvZWXBzCGPPinn46tGk','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:24:18',NULL,NULL),(244,45,'SkzdVJHtUAzO1Qoqgn74FIbWchPb0BwK9rohJPXxwdN2GN27yqZRve438giAEEQs','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:25:23',NULL,NULL),(245,45,'DwSQSHPgesupGBHRIXYbVv2TKUFX9RmcvmoO1AlfKxN8hpGdfaq0uYxaElzyk5hP','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:25:23',NULL,NULL),(246,45,'vqQHZ3XPhKNWSAJydFnlM211usAzk55RS4B7sa8eVt8eaP6RmJoFxk4zL36BLZfi','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:26:24',NULL,NULL),(247,45,'qkj75Bq9IGJndotviVzCJK2mcSESxbez465dtw8YQu3PeQ0r3yl8WRTL1sfFgX0m','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:26:24',NULL,NULL),(248,45,'84HYviomdOn2T84bqZLE0XLlUEezsvgGPFAyje1Zkcrgwp79JAqIYQCKu5rRyPS5','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:26:43',NULL,NULL),(249,45,'0RCdu9IHSuSKxF4hCVaqIgowGYBNcvbDVPTWfEpjGgK19Jz7p7zl2QRfX1bOkUk4','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:26:43',NULL,NULL),(250,45,'9NTntAGUY3W57PlKyXlaL2V3HyAN0KCkwWztczS4Dp7CMrfahEQinHOpuFZ0BirM','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:27:57',NULL,NULL),(251,45,'zm7lIzcXvXrnuBL1TYpKCoCWiJrQ2EqSeHVa235jBVaZfpi5438cA7UGMSJymdbu','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:27:57',NULL,NULL),(252,45,'8wQeKpabHtAYXVsnnuld9Opc1HVfXC33y6JEIO7rYqGxdu8GMm649ozWhNgDBZvw','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:28:29',NULL,NULL),(253,45,'sc4k5jsdn3GlFPMOoPaJ87ElDpivo5VTeeBTWCAvt2w9Ig2kNAB8c7YHtbKZC94X','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:28:29',NULL,NULL),(254,45,'fVw96LeYJwJPrmAypxr5CN8bQ4PuVxERXcE51ebhhfdjmGoigHzzR7i6BsUnkMD1','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:28:59',NULL,NULL),(255,45,'lDy2weghNs7ysZjreLoNKQJ7WC9vapBqpudCWE0UOunhO8VDRYgBHi31A625VEXc','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:28:59',NULL,NULL),(256,45,'6gaSjoAQv5hqQj0nzOi1fbKYZTEmMrdR9sFdv5GyBaHlcP048xZV3LNrX2kIYuRq','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:29:51',NULL,NULL),(257,45,'Zo9wuTzHvK7306kgtQEbFYnRoqrNXUG2g54LcOk1rXPvbTaHtBZisiPVJjRLuYl6','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:29:51',NULL,NULL),(258,45,'kSEQW0CcKyipvfMUIu7kJG0oYwLdBboiDPHbjdOqzqe6N4a6n9PZhmTlpAF3QcfW','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:30:44',NULL,NULL),(259,45,'0Zkw408gHKgT7xCBNfNhFsJhAURrXqsmbeHSJtAn6LOtBop3Dv4aDi9VMbZcxy2Q','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:30:44',NULL,NULL),(260,45,'tUP87fuGLO820lYCRhx3dbCNcjDFifwgIcp7Sbh6BZnvkoYMLE9ykHsrm1R5X9QN','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:31:06',NULL,NULL),(261,45,'tG17Xfc5YlyOT6u8XEWJp2PleKU0kxhoMZu6zgN4jib1pLRkNmMSgjH5FamL2FAT','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:31:07',NULL,NULL),(262,45,'glHZCHxB6QDI3Tunr1qYfhFfDXKKUTaX5ukIy1w0EjvGj0R727LEyA9cS2pBYJbm','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:31:38',NULL,NULL),(263,45,'19V4CM4P6UYIXw3kHTWL1AUlEZx92d8pJspggQDDjeiqFwyxhRzEuBHWCS7XaLIn','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:31:38',NULL,NULL),(264,45,'7vtz0QwKCepoi0UrVLvu3Ra6iX2VGzFbs15PMgfNj6JAIFbxQA4cEld2uYy9ynqr','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:31:51',NULL,NULL),(265,45,'4uPlO86eAVViXo89JYrNRo6tjxMdSG5nqEz4P2wcJuC3a5UySGXhRT3gfdHLKplm','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:31:51',NULL,NULL),(266,45,'IQWVMB9UCI7RYsjHCjwwHnF75dDlfZNimJ24zuxokRGZexJcpvTlt30EaXu3sy6d','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:31:57',NULL,NULL),(267,45,'IdlL8UMsiOoV9Kmwk054uR3PUKnCbOSMY3AtzTvyEZNBswPbJE2zk6unBLfp7GRF','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:31:57',NULL,NULL),(268,45,'UeO8pzTxInYclaRjp3FDP7ZB4M7cvKgJhB6XTuC0rqQR5Ui6CdNALDqh8WasftQu','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:35:05',NULL,NULL),(269,45,'ZoU0QRm8dCRIaOtpKwu7xYFcrwvnkzkXfyDdI6poiKO21UHZMLv4Tq0gse246NzT','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:35:05',NULL,NULL),(270,45,'xvhmhKJ9AZz2gVLis4K7aqHzldVOlN5mWRc8TGCnRt9v10pbpfMHT7PXtWODCnYQ','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:36:41',NULL,NULL),(271,45,'rhurSVdFkBlcA8MfeE3QTdjnjHekBX297JmX30vIJCxKNu7y1DtT6NFWI5oVMbAi','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:36:42',NULL,NULL),(272,45,'8k7OieX0WU7ECsn26uwPmqhlkSvZYJaYGcfdKQRTh4EyVixAWgzy3HDFGHnNOjtd','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:37:49',NULL,NULL),(273,45,'zLRYL3SrrgeJJxccukXNknKja2WCsziw55PDaAdn1joXb7yp9gQO3hlDH0qG0MK8','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:37:49',NULL,NULL),(274,45,'AuivkYWSJfwE1eO7auShfzQBp4qh306W8TYsqMo8ED5z6HXRbNlNvitRLFxKroJr','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:38:54',NULL,NULL),(275,45,'nZFvH4DtGiGJRcSCo6NrlmEaaVL1Ojk0u8QxHp4QcAK3xeT3oisgIqg6KvF8zby2','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:38:55',NULL,NULL),(276,1,'80S1imlUqqh3WR4pr3IbbOfnGcjdT6U6uJgnQc71KZANy5sBLSePpljPRVQEosMw','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:39:52',NULL,NULL),(277,45,'6igoGxFKrR0ED9VnSWgQdWwNZ4uJ1u7VtsUMPape5i5HrXOqfek8q3ATZpL4c1Df','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 20:39:59',NULL,NULL),(278,45,'SbOl7pzc6nRQMUJuEAVncKd0B2Gfi3SOilkdWIHuFzjFsNvEL0UgkZvepDPCN9hr','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 20:39:59',NULL,NULL),(279,45,'QGuo6AMumCyEplajIJw1qve34frQUb0SGFOYWcf1P5ssg8tdjK7yIhgnTvoLVBS2','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:02:44',NULL,NULL),(280,45,'PiOJ3odRwaFOwGyphv91NXb5cX9MQYVsgTLJ8sgkmEeup2SIjyt4BF2njZmiU7eb','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:02:53',NULL,NULL),(281,45,'eycsgegBH4TfI2INh2Jw5OMmCadAYi5tZjSWDF7jCoJRPUzbbELZt9XKr6nBVium','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:03:37',NULL,NULL),(282,45,'bplrjF9uu2MkzvrL4E6COKH3hNVfDm8GRWALPt5SxlvoSFAYMdy17InBzIec3xks','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:03:43',NULL,NULL),(283,45,'5x7LTetzI2yrNO5EWsxTD1VGdLu0NIpeJXCS4hB2qvsdAPrbnzYV80KMa4hCmE9U','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:04:54',NULL,NULL),(284,45,'p1KWzjhVK4bFl6Q2tGPte9DkPyvmTvuO4iiwxwfDIRSZganXJ7ExF0B23bH9NHV7','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:06:38',NULL,NULL),(285,45,'j7bNYMKBGhwCeuA4qUTLwdUF4H2ygvZIVtQp96JimeoBzIpmPSKaZi9Dl20rX0Pc','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:06:38',NULL,NULL),(286,45,'Dag7Sr4jzVJiK7es8sBhTiuw9mNGRIW5vQ6clRbZntYahVpSqD4g0txOoOYMPxk8','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:06:59',NULL,NULL),(287,45,'y9LfzEIcd8w5QJupGsCC7cZNAhYx4k6Wm2env3jtKjX2w3LDBdiHDeFaPuRGq0Pr','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:06:59',NULL,NULL),(288,45,'EHxDdgl01WpOYTvaPN34Dbevg4J3zzSnaCciAnlZy2GbjUc2Wuy8LkFHNOZojfx6','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:08:25',NULL,NULL),(289,45,'4PGnuZzZrSV3vKdSN7Ovgc7e8yygAY3kj6LfCDoROBfBjP1NWzCAkK6beFIsQMER','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:08:26',NULL,NULL),(290,45,'6ce4bqO1prUs1boKki3fTjzWm35rDyVSUfh6uAJxMOvLkaw0AGsC8lNFQ2qZFcJu','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:09:57',NULL,NULL),(291,45,'mekv2NGIhjdzM2TnKHI4EnZCFZ7QcUHsXBtU8VyjilYphvOsoOA6maPxRL3wWCF0','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:09:57',NULL,NULL),(292,45,'Y1P4wpKW7Q9viH5RxnWlzSMRUBJ5EAT2yskdjNFwCQx1D6EAqh38i43cuPtcnohB','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:10:50',NULL,NULL),(293,45,'W1Hmeq3gQ0DC9t67UIGil4N51ZNwJyXIrVhnGSh25iBsHPS4AMfjpdxcVAgQnU8E','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:10:50',NULL,NULL),(294,45,'M6tCWybjF7y3z0lTdpZ8QivnPGwvNbJI2PspNqLxc5wAzAodxIrSe1kBjUurt7Og','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:11:37',NULL,NULL),(295,45,'lrhZS58XkNDimIwJ1JsxmAS7ONeqkMWuCf8ijXFAjodYtOcB1fRDd02gxYyPts3e','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:11:37',NULL,NULL),(296,45,'KJt2S5NhEMLRqldCOnTkQgz4nyVolUyI7wju39s01H4Zifw1reAcDNcGgD8Oxuxq','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:44:20',NULL,NULL),(297,45,'75KcnowsnVSlJrojpAcZmXXAVCQRbhafNzdOiq46JQm4kaZzYG6Eu90Ip8UOyMg7','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:44:20',NULL,NULL),(298,45,'xZz0cdupfgwKObzLXVCTYKrJAdV5ZEr2kPy97EnRteoQ1WY8lBgomM9yplnht6e0','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:46:51',NULL,NULL),(299,45,'mUgKTm53vbG2gWipcc79uBEDwNnhN1oB0hyr4f2LIwdjeiCMYkEXxuIP3beAazvn','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:46:51',NULL,NULL),(300,45,'f04OGLOu9XVFUEF7BlHY1v0G8aq1xNkhVtsXWc5sbeY5LkiRaDbPxrvdrKQhlCdw','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:47:05',NULL,NULL),(301,45,'Gd7xRTKAMcP92nX8O2Wl6CbmoFjLRI4CrktxdAkHQYLMB31w1iqBJu6IgUEqOzse','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:47:05',NULL,NULL),(302,45,'eijJpCmQHotrDgDY1f4UzxCWwQBKUyXphSnjocE4SLHkuTmr5AaRIY8unV3gvtVT','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:51:59',NULL,NULL),(303,45,'Ej47bfpMvRKkLT4Y9O1ulrW0JIV68QVyqwAncsDxB5FHj8vWhG3TBZsdpPK7qdXe','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:51:59',NULL,NULL),(304,45,'uqOoJtuJtZZPHHVcU6Gm9Ar0wPEhOFaVKEUvjx80pXmCTjNwy5QKisIvf4igbc7r','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:53:26',NULL,NULL),(305,45,'0q9zjX7PeW1gxDdAJawNfwsuQqp8M2DR5OpBHTEjMhK6QZ4duf2sbF9HYVWcgaUn','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:53:26',NULL,NULL),(306,45,'7e9zKyrPTyxsjUavauQDHXeihCkbBtZoGqYUAwg1BwN1nxiqmRsnkcgP25MW6J0H','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:54:18',NULL,NULL),(307,45,'ihwTaHVDpSlbkJ0Edz5AUxP7eqhWAmQfNr7R2GE9yRaTQ8OeW4sFK8vm9ZqgsBV0','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:54:18',NULL,NULL),(308,45,'fJAHKzwQc23gusbP0X3GVucZkypoS04AXOOeRFrEqy8Ev6xJLiaYGqTMahQRmpB1','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:56:34',NULL,NULL),(309,45,'kid2YgTWVbLWQOGB5p6CNxFIjHOZSSC6FeZprgzn5dbtmkwDIMULhm8AeTxJff7G','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:56:34',NULL,NULL),(310,45,'r1McohQwR38abXRTF7KjS3W94kzGnfqiKAmGIJzLLvpYEXUpN1sY5lZmVHITdSrs','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:58:19',NULL,NULL),(311,45,'gqRrpenxwN3cXpiNDLWL7vm6DZlaAEzOTB9ZhKH2dgKF5C1korItPXjCQf7z8T2y','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:58:19',NULL,NULL),(312,45,'jwJWvBiVAcmKx1UPbEetdgld9ALKQsqqPLGtmohD6Das3Rv72YMpr250Jo8XUVEa','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 21:58:34',NULL,NULL),(313,45,'qSXsB6aQZzT4K4Puef3HQ8dEcsi9lM5VCgFMCRt5PO2jrKAlURyq1nkam7mG3vWA','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 21:58:34',NULL,NULL),(314,45,'S845UUY0vqYjTxh8zpTKMoGWiJefQHR9CO4hPPtNbI7iouySAfapAZGOr6RkNE3v','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 22:03:46',NULL,NULL),(315,45,'ekjcmg9UZybE0myQ3iERMYw6Hk9TOLVwxZGY5huAdxb1atgGsofpidcSL8qUjQvT','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 22:03:46',NULL,NULL),(316,45,'i83C94XAzfB0vP1SIvTYgQGqTorQDmeNaVu53J6d4L72WuqAsmO2MP01fDE6ZJ5C','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 22:06:41',NULL,NULL),(317,45,'HzxbPYrWmDDQKlv9fsonxVr6cAumwYNUnRJTQT0loMw74A7KWSq5i5N2i288fGa6','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 22:06:41',NULL,NULL),(318,45,'wIwM1xnYndzo2yv3AfA6cse5MSpaoICTmCRqOVu8Hfr1Z72W58SpZ0lzDQGtDvbH','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 22:41:30',NULL,NULL),(319,45,'ymYmcVbd5pVweIKMg1SJ4FDpRBGvRuaXaUQcC0kXOqBZ0sgh3tEZ2uCDTHGFU2NQ','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 22:41:30',NULL,NULL),(320,45,'zWqT1yvuQgo9ITLNAjtBBwGiMRPVh6NaLR1KUfJov0rpXI3ykAZFn4blqu4xYOOE','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 22:44:02',NULL,NULL),(321,45,'haPb26KOmo1ApRNvSIe64BPFq2E094x5lgVLmTfUZ873cc1QGjMoaCnCrBzjldfh','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 22:44:02',NULL,NULL),(322,45,'x2WBQdMfg4aPyfKa8rh5Equ01pdFgDmR4oNz5t29E3hZiILGeAXAJOsSLwHjseFM','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 22:44:43',NULL,NULL),(323,45,'Mqia9fRrwZB3PuOpvo7T4F8eTtGPocC1DH5fbmUn9VIF6xjJl2vXYDHdySNAr10B','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 22:44:43',NULL,NULL),(324,45,'6jhzgHZqtXNPkapJ0YI8M3wFdWycbDilVZ7vuwfBEvAiGLDXQEPNCcO4yKL49nFf','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 22:48:28',NULL,NULL),(325,45,'WhDkV5AtKObVpIJxLHBZxX6r87gRqQCgbTHP4i6NGecL43zflv5MPevwjs0mKCUB','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 22:48:28',NULL,NULL),(326,45,'8wODoqWkxOMnJ6JpaUfXE0rKGbjolnA5vS5lRAxjPf6m2ZRtsHhwQIXDY1CseFbi','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-01 23:58:27',NULL,NULL),(327,45,'fPNuoDfY7BbiiT3gYcHkSgO3eJRO02kIUqj1mZQFcL5EmsWxvMJutq6A2QH5n8Xs','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-01 23:58:27',NULL,NULL),(328,45,'shjvNqwpdQeR1fk4WdeMZynPVM4725100rUbm3hVHzQbBvyCtrRaTIsoTWXDGEXa','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-02 00:02:46',NULL,NULL),(329,45,'iwWDKSHveYrPpLcLlV0ZInAaNyUoFsxqMuHJ7g2QicRTR90d1AzyGKtl6j4Czk3E','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-02 00:02:46',NULL,NULL),(330,45,'u7DJmJ5kr68fvMWdHIxcXKbeWGBaM8zs2Ahd0ZaqSIT5wou0hfOmXFlBL1RxFPit','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-02 00:04:40',NULL,NULL),(331,45,'f9zYjFoPcEUSlZMliCzr90nomqSngsNuXvQXgrtHbw3AaV2vijJJPNu3OwfeM0mT','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-02 00:04:40',NULL,NULL),(332,45,'OePCXDABozwHi5NocPBTI4UCRG5Y6uzLjUXtJlVcf2qdhOKWpHFFWjQLZ7we7v9v','0m78t8k950091186s4tbv3qhos7du3r8','A',1,'2019-05-02 00:05:46',NULL,NULL),(333,45,'C6vbD5IBdLl7TrtwuH3hAWTLshaGwvVYq1RXrE0mp4NeEUJaHtsQGu9ZdxxgceNy','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-02 00:05:46',NULL,NULL),(334,45,'gaHS5cdYNRD0ZS2FQ4O3Hb1zJtmkJv3dfcgZCMxeBTVGhWYnosuCFlsGhX6xoTyj','0m78t8k950091186s4tbv3qhos7du3r8','D',1,'2019-05-02 00:06:03',NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
