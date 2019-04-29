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

insert  into `document_custom_permission`(`fin_id`,`fin_document_id`,`fst_mode`,`fin_user_department_id`,`fbl_view`,`fbl_print`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (7,32,'USER',1,1,0,'A','2019-04-20 01:51:08',1,NULL,NULL),(8,32,'DEPARTMENT',1,1,1,'A','2019-04-20 01:51:08',1,NULL,NULL),(11,34,'USER',1,1,0,'A','2019-04-20 02:01:10',1,NULL,NULL),(12,34,'DEPARTMENT',1,1,1,'A','2019-04-20 02:01:10',1,NULL,NULL),(29,44,'USER',1,1,0,'A','2019-04-20 02:29:39',1,NULL,NULL),(30,44,'DEPARTMENT',1,1,1,'A','2019-04-20 02:29:39',1,NULL,NULL),(31,45,'USER',1,1,1,'A','2019-04-24 13:18:28',1,NULL,NULL),(32,45,'DEPARTMENT',1,1,1,'A','2019-04-24 13:18:28',1,NULL,NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=latin1 COMMENT='suatu dokumen bisa berupa kumpulan dari dokumen2 lainnya';

/*Data for the table `document_details` */

insert  into `document_details`(`fin_id`,`fin_document_id`,`fin_document_item_id`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (37,31,1,'A','2019-04-20 01:50:44',1,NULL,NULL),(38,31,2,'A','2019-04-20 01:50:44',1,NULL,NULL),(39,31,3,'A','2019-04-20 01:50:44',1,NULL,NULL),(40,32,1,'A','2019-04-20 01:51:08',1,NULL,NULL),(41,32,2,'A','2019-04-20 01:51:08',1,NULL,NULL),(42,32,3,'A','2019-04-20 01:51:08',1,NULL,NULL),(46,34,1,'A','2019-04-20 02:01:10',1,NULL,NULL),(47,34,2,'A','2019-04-20 02:01:10',1,NULL,NULL),(48,34,3,'A','2019-04-20 02:01:10',1,NULL,NULL),(76,44,1,'A','2019-04-20 02:29:39',1,NULL,NULL),(77,44,2,'A','2019-04-20 02:29:39',1,NULL,NULL),(78,44,3,'A','2019-04-20 02:29:39',1,NULL,NULL),(79,45,1,'A','2019-04-24 13:18:28',1,NULL,NULL),(80,45,2,'A','2019-04-24 13:18:28',1,NULL,NULL);

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

/*Data for the table `document_file_histories` */

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

/*Data for the table `document_files` */

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `document_flow_control` */

insert  into `document_flow_control`(`fin_id`,`fin_document_id`,`fin_seq_no`,`fin_user_id`,`fst_control_status`,`fst_memo`,`fdt_approved_datetime`,`fin_version`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,34,1,1,'NA',NULL,NULL,0,'A','2019-04-20 02:01:10',1,NULL,NULL),(2,34,1,3,'NA',NULL,NULL,0,'A','2019-04-20 02:01:10',1,NULL,NULL),(3,44,1,1,'NA',NULL,NULL,0,'A','2019-04-20 02:29:39',1,NULL,NULL),(4,44,1,3,'NA',NULL,NULL,0,'A','2019-04-20 02:29:39',1,NULL,NULL),(10,45,1,1,'RA',NULL,NULL,0,'A','2019-04-24 13:18:28',1,NULL,NULL);

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

insert  into `documents`(`fin_document_id`,`fst_name`,`fst_source`,`fst_created_via`,`fin_confidential_lvl`,`fst_view_scope`,`fst_print_scope`,`fbl_flow_control`,`fin_flow_control_schema`,`fst_search_marks`,`fst_memo`,`fdt_published_date`,`fbl_flow_completed`,`fin_version`,`fst_real_file_name`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'KTP','INT','MANUAL',5,'PRV','PRV',0,NULL,'KTP','KTP','2019-04-15',0,0,'','A','2019-04-15 16:49:51',1,'0000-00-00 00:00:00',0),(2,'NPWP','INT','MANUAL',5,'PRV','PRV',0,NULL,'NPWP','NPWP','2019-04-15',0,0,'','A','2019-04-15 16:49:51',1,'0000-00-00 00:00:00',0),(3,'SIUP','INT','MANUAL',5,'PRV','PRV',0,NULL,'SIUP','SIUP','2019-04-15',0,0,'','A','2019-04-15 16:49:51',1,'0000-00-00 00:00:00',0),(26,'Tetsing Document','EXT','MANUAL',3,'CST','PRV',1,NULL,'','Lorem ipsum dolor sit amet, consectetur adipiscing elit. \r\nNulla tincidunt aliquet lacus at vehicula. Etiam a sollicitudin nunc, at efficitur dolor. Mauris rutrum augue tincidunt consequat viverra. Pellentesque lacinia lacus eget est vulputate, id imperdiet massa porta. Vivamus vestibulum viverra sem. Fusce tristique ipsum pharetra est suscipit, sit amet auctor ipsum tempus. Mauris lobortis mi vitae tellus vulputate aliquet.','2019-04-19',0,0,'get_file.pdf','A','2019-04-19 14:43:19',1,'0000-00-00 00:00:00',0),(31,'test2','INT','MANUAL',1,'CST','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 01:50:44',1,'0000-00-00 00:00:00',0),(32,'test2','INT','MANUAL',1,'CST','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 01:51:08',1,'0000-00-00 00:00:00',0),(34,'test2','INT','MANUAL',1,'CST','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 02:01:10',1,'0000-00-00 00:00:00',0),(44,'test2','INT','MANUAL',1,'CST','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 02:29:39',1,'0000-00-00 00:00:00',0),(45,'test2','INT','MANUAL',3,'PRV','PRV',1,NULL,'asdasd','asdasdasd','2019-04-20',0,0,'Ebook VOL 4 (1) (2).pdf','A','2019-04-20 02:46:38',3,'2019-04-24 13:18:28',1);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `menus` */

insert  into `menus`(`fin_id`,`fin_order`,`fst_menu_name`,`fst_caption`,`fst_icon`,`fst_type`,`fst_link`,`fin_parent_id`,`fbl_active`) values (1,1,'master','Master','','HEADER',NULL,0,1),(2,2,'dashboard','Dashboard','<i class=\"fa fa-dashboard\"></i>','TREEVIEW','welcome/advanced_element',0,1),(3,3,'department','Department','<i class=\"fa fa-dashboard\"></i>','TREEVIEW','department',0,1),(4,4,'group','Groups','<i class=\"fa fa-circle-o\"></i>','TREEVIEW','welcome/general_element',0,1),(5,5,'user','User','<i class=\"fa fa-edit\"></i>','TREEVIEW','user',0,1),(6,1,'user_user','Users','<i class=\"fa fa-files-o\"></i>','TREEVIEW','user',4,1),(7,2,'user_group','Groups','<i class=\"fa fa-edit\"></i>','TREEVIEW','master_groups',4,1),(8,6,'document','Documents','','HEADER',NULL,0,1),(9,7,'list_document','List Document','<i class=\"fa fa-circle-o\"></i>','TREEVIEW','document/add',0,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `user_group` */

insert  into `user_group`(`fin_id`,`fin_user_id`,`fin_group_id`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,1,2,'A','2019-04-24 13:02:47',0,'0000-00-00 00:00:00',0),(2,2,3,'A','2019-04-24 13:03:02',1,'0000-00-00 00:00:00',0);

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

insert  into `users`(`fin_user_id`,`fst_username`,`fst_password`,`fst_fullname`,`fst_gender`,`fdt_birthdate`,`fst_birthplace`,`fst_address`,`fst_phone`,`fst_email`,`fin_department_id`,`fin_group_id`,`fbl_admin`,`fst_active`,`fdt_insert_datetime`,`fin_insert_id`,`fdt_update_datetime`,`fin_update_id`) values (1,'devibong@yahoo.com','06a6077b0cfcb0f4890fb5f2543c43be','Devi Bastian','M','0000-00-00','',NULL,NULL,NULL,1,2,0,'A','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0),(3,'Donna@yahoo.com','06a6077b0cfcb0f4890fb5f2543c43be','Donna Natalisa','M','0000-00-00','',NULL,NULL,NULL,1,3,0,'A','0000-00-00 00:00:00',1,'0000-00-00 00:00:00',0);

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

/*Data for the table `view_print_token` */

insert  into `view_print_token`(`fin_id`,`fin_document_id`,`fst_token`,`fst_session_id`,`fst_active`,`fin_insert_id`,`fdt_insert_datetime`,`fin_update_id`,`fdt_update_datetime`) values (6,45,'Kk7t0OFsKnw2a8h3Ev5Gbs7MjTm6mcpMxqrDI1DhX4RqJQl30dzEcYanAHBzCr9X','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:27:20',NULL,NULL),(7,45,'BzE1cMtzbNMBUHxp0O42s9unFN3kaTKjPv58W6R7ITJItZvZsmhXSAQewD3gEr1g','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:28:04',NULL,NULL),(8,45,'hQhfXVq8NNCSQjftMqKla2610kOP6O4mATiGSW9TpxzC2JiXKIY1FscG5styAygz','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:29:07',NULL,NULL),(9,45,'0ZJ51VNFLPpAxpeCuniF72YIrcg6CmfyrwA2sU3mJ4ThZMz5dMutX9wkhR1NVlI8','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:29:47',NULL,NULL),(10,45,'M5Gh7BttpDwPjAD4SIYmrlXeVksq8iQ0oKAFnpbO0g1yCmPZRH3lzWub9BcLLEZH','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:35:44',NULL,NULL),(11,45,'kMlsy9Yi24SrdHhsq0yLoaCO0Snqud4LM9YrZT5KeWUb3EbGcVWNBUiwotl21pev','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:39:03',NULL,NULL),(12,45,'qfp9ErZV4o7yR4c6vsTtRJ9wAxGpIlvzQMCAyXSbWNO5jBjaqOGzK1KMTb3WCxha','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:39:11',NULL,NULL),(13,45,'R97hnBHAbtkduzQpk3wGlXWWKx1az2s754yXwyHSv6RLuZ8OLqDmVxdTC0DTBfCl','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:40:10',NULL,NULL),(14,45,'DvLBeTnNxHYpNwyfCof6Z911UbAb3vzOmAEV8ud7YgRrDKGkZmTMF0sQQVjI4jRt','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:40:58',NULL,NULL),(15,45,'tFnJXUwQJ2N7GbkcCk3MqxpF0dER6ujyYqIADfiBhpZbr2r7O4m3KH5l0UtzV9Sy','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:41:07',NULL,NULL),(16,45,'t24wLhiX6pnLfBBRk8PQqdECGTF19oFvPszmc5KojU7zkYM3Seab8yS3iIT7C2Xa','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:55:10',NULL,NULL),(17,45,'hvF5P6vHekIaq0g2oR5M8nppJEuAZqH1Gm9XsLSKNjbNw9XTlAoIcQMOfU2QO4Ek','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:58:10',NULL,NULL),(18,45,'taQ3n9pWlfJXuShFjgMdGpByvPoI7axbxLZeY2iS4lEj8zADHIQsqgmeRTy7rOVJ','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:58:33',NULL,NULL),(19,45,'43xAv4x15mNVZRq0Kr1gmNUGEoJUlHbDcCz7du8knItLhAHwit6cQOnfSjS2WPdJ','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 11:59:53',NULL,NULL),(20,45,'zaXHwbV2WmluIGtT5dQJyODvQj0BKsTEHmSNj8KnuNZtlWUU7qPJhc6fyix3B6Ad','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:00:52',NULL,NULL),(21,45,'7SftrFTRi8BPc23EG4j9gZDlqcovlVdJe2HVAaKu3L6LCEQykpboM6ZqSiKN1h9N','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:03:14',NULL,NULL),(22,45,'jsP40oYKbHF6tFUrkBnyzJRuArDsI63VZ8E7O1SCwmi9WbE5gILDpo10mQJGfekl','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:04:09',NULL,NULL),(23,45,'NPmEv60IeJIhNiwyjc2x7ZB0sOnAYvW3TyROtL74qMXropD2dhEaUkslHfJ9goug','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:04:55',NULL,NULL),(24,45,'duMCzTEFF8xLyR3JdDnCw1V7a0LijTvGoq2sXZcQYby9eqAtUSJ205jnelH3riaX','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:09:37',NULL,NULL),(25,45,'AHe7RbQ8hrfkauLU1ldSmgzBilCtxcVkHTUQpTduzvya4WsYXpjJnA3M76bhqZ0I','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:15:58',NULL,NULL),(26,45,'UhvnZ4sJT2iKfs1jdt3CWYk9OH6A7OlpwwNFtQrfCInPeE19g7yBHm2AjIdiMXYJ','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:17:35',NULL,NULL),(27,45,'n7Q7fmDrGwUN0kI3jb0uiWqiH5VPCrkTYoASOEJ9xesZ8ZsqovadlK1XlRHXj3BV','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:18:47',NULL,NULL),(28,45,'Fpk6mA2N37XrvOZWXffuEyiyGjddEKwexPlWNIGCsVLZ4M1S8UM5BSqjxKAtuHR6','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:20:05',NULL,NULL),(29,45,'apZPmzZ7NyRXbs7Y9xQCh4kwlSFHdU2n6D256Kp8u0rRTBjlrfNLDJEo5h1CGsOQ','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:22:43',NULL,NULL),(30,45,'rNf8R6tDsOSAPPxUwGb92dkby17zprJlGmuC1wMDOzWNWqfIH0ijQQ2EoJKYYXle','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:23:14',NULL,NULL),(31,45,'CdHSoqs4WDtv1cRswW66GVHBlflgnmGKatNVhCXL3OIFOAfLmrUJ0eczDxkork1x','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:24:07',NULL,NULL),(32,45,'cBDzRA1tKpbdDKEujv537IzVnHlT4sZFYMW9GHbuL2l1kw4gwLNexIoCvxeos6gP','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:24:32',NULL,NULL),(33,45,'TUQSGYtWr0dWi1IG9wcOebu9CHBAHfaxc7s6S7mbj55ymwPljJ1sIB2QPNaFvy8R','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:25:02',NULL,NULL),(34,45,'GZ8okitLVKNT8SMV1iazwyQPXa4zOmIFJRD5xA9QnZtknueBJ4IsbPYXHCbD01Ey','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:25:14',NULL,NULL),(35,45,'qVyCUhaJ14dRgE9bQEeYwKMFq76aWKhUb3McodABNe0iBAiGG8z9vV42T2vYj8HF','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:27:32',NULL,NULL),(36,45,'JYRyo4s4Fl37GKvo72PlaLSVTNegtnGS6AH1ws3y95x0uFqQXEzBWciRMjqjIKzD','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:27:36',NULL,NULL),(37,45,'iWEHD94JkrnYacS8zx9RMlLhrmwqPZjDCu6s1B0NuGOgAjenfLYsvtyb2FtXdmQ7','55cerbr39kj93m25ciunp6h41uct8ftm','A',1,'2019-04-25 12:30:56',NULL,NULL),(38,45,'k8KPuDAVMykozLHtRJqPH6TdYZp5SXJbshUQUojO7uYIrSRhW3vDr8NEeNZEQznp','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:10:45',NULL,NULL),(39,45,'FcA1LSrpnTqXsWKRYZvsjOQR0ImakDEFVKPx4joEc3tLuU7xbyzCG9zhlkmZvty2','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:21:47',NULL,NULL),(40,45,'LxgrgdkWdJOksjyAxIVDwOzMcLmV9zw10HY9uC8flCJEoUhQvtbfs166Z5EPj2pR','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:22:04',NULL,NULL),(41,45,'NPdOt0V37MsQSlmejIAaU3orNReTpW8yHaSHbyuivhPjQt1DfmK5gd8BD1k5BGfO','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:22:21',NULL,NULL),(42,45,'IpqWvNJANEbgB4AcvoT6DQqTkUXlBs4GEzgFQxwoy0cs5dma3nj21JCXYtZLi79e','ns4tt77r6js2epda2bcngu3mdm2qj7e6','A',1,'2019-04-26 01:22:47',NULL,NULL),(43,45,'Pz1CKoEMIBjEFXveByU7R7K9LdOilYok3eYnbpNgTsSNhwcJaWZTvVVzHGr8qhRk','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:23:19',NULL,NULL),(44,45,'4v1UJCIxyXEkkYTPKy0O125qgrRhAfSVZLBwIC5KtpGNEVSmtjmFbQHn66ZdGzWa','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:24:50',NULL,NULL),(45,45,'ZiG7ApBupwGCeNdaWSz0h1b8AfOrMx1S4iYKQBfqORlgwtn3XMkonLbsa5tjjsh4','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:26:16',NULL,NULL),(46,45,'tyY62JNOCXCM395ALvWTEUqt4NKRZh1M0EuaPHn6fFG8nVHSjae728ifBW1skx3J','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:27:53',NULL,NULL),(47,45,'0QEBmGXEBnyAX2yWxjG8kPMJ5L3Fa1rzQut1x7DbpsOCTbY34SounwNFZ7HmSRVw','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:28:38',NULL,NULL),(48,45,'s3DkgYeAHqU19OeS6uZXiVAnIxpLbVRyiwlcTYtNyjMcwX9zJ2hmrTgl58vKCQB0','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:30:07',NULL,NULL),(49,45,'teW5cXMVIrpYC3bRadrgmixL9xoGEPs9X4N3TtFFkjGjM1nK8EHZZaflhK0QSck6','ns4tt77r6js2epda2bcngu3mdm2qj7e6','D',1,'2019-04-26 01:30:21',NULL,NULL),(50,45,'wRQScoGFO4bTuxZq7CJH5Oev9SUIG8rp4PXnUmiyRmJY9aAW2qLLwDVMy1EMugNk','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:04:02',NULL,NULL),(51,45,'NroYqvPTtUeEABOTDVQcp5CjiH20BPXGZMVuh2afhfWd6rFkHwLY59u4gzCROn1U','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:04:50',NULL,NULL),(52,45,'MUktSivA8If4bCsAZONuq3EVGfXlFnI1yFa7LQtppZiluNemRjQWPMTP2TCD0Vo6','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:05:30',NULL,NULL),(53,45,'UhlSBipZdk0TvOADhEdMViZjqnmLYOF5tcrl3RmfTksJU7nV83uqBzYN4DxvgH5e','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:05:39',NULL,NULL),(54,45,'FMzY2zlCk3m7S9vZsSBWa4P86U9yxxdnIZXIGfKB4iwutEmyLD87hJHO2NlQ6YnJ','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:07:14',NULL,NULL),(55,45,'9NuZ80V9sNOvmAWC3gLTEPoAFDgJVqHXYkjr70PDemheFh4G5dofdtzjb7QpTJ2v','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:08:42',NULL,NULL),(56,45,'xiZSQKFnP29fDZNXhhQyIUvmEtje3dK0k8EacAVlI1z7LpGbBXRj8s7J9L21Cdey','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:09:00',NULL,NULL),(57,45,'hUi95JmF0lBsr5QilA3cf4uEo0TXavnLV3cORNxPqW1Sd2AxEwR4quGMGK9QXH6P','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:11:18',NULL,NULL),(58,45,'R9MtjGB5vTz0uLN54q9kp2yHsMmnKUKH1qljwI84Jpkad7bgrxOxoFrGfy60VIiz','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:11:34',NULL,NULL),(59,45,'cXagx1lawJA9VuWEvOshUDZT3Cqzc8ADfFlLPB7Ot8UBd2L5WqNkmRp4o4PInIyb','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:13:15',NULL,NULL),(60,45,'V5tOXM7ibZuQPGExqyI8ec3lJWpcApANfCPKbdz4oEadLjZskjIFUDmswaWym1kV','0rt3bc479490ojuffitpq0ng0m0bage9','D',1,'2019-04-26 07:18:36',NULL,NULL);

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
