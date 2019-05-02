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

/*Table structure for table `branch` */

DROP TABLE IF EXISTS `branch`;

CREATE TABLE `branch` (
  `fin_branch_id` int(5) NOT NULL AUTO_INCREMENT,
  `fst_branch_name` varchar(100) DEFAULT NULL,
  `fst_branch_address` text,
  `fst_branch_phone` varchar(20) DEFAULT NULL,
  `fst_notes` text,
  `fst_active` enum('A','S','D') NOT NULL,
  `fin_insert_id` int(11) NOT NULL,
  `fdt_insert_datetime` datetime NOT NULL,
  `fin_update_id` int(11) DEFAULT NULL,
  `fdt_update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`fin_branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `branch` */

ALTER TABLE `db_edoc`.`users`   
  ADD COLUMN `fin_branch_id` INT(5) NOT NULL AFTER `fst_email`;


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
