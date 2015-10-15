/*
SQLyog Enterprise - MySQL GUI v8.05 
MySQL - 5.6.26 : Database - anggaran
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`anggaran` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `anggaran`;

/*Table structure for table `account` */

DROP TABLE IF EXISTS `account`;

CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_account_create` (`created_by`),
  KEY `FK_account_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `account` */

/*Table structure for table `activity` */

DROP TABLE IF EXISTS `activity`;

CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `satker_code` varchar(256) NOT NULL,
  `code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_activity_created` (`created_by`),
  KEY `FK_activity_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `activity` */

/*Table structure for table `budget` */

DROP TABLE IF EXISTS `budget`;

CREATE TABLE `budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) DEFAULT NULL,
  `dipa_id` int(11) NOT NULL,
  `budget_year` year(4) DEFAULT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) DEFAULT NULL,
  `suboutput_code` varchar(256) DEFAULT NULL,
  `component_code` varchar(256) DEFAULT NULL,
  `subcomponent_code` varchar(256) DEFAULT NULL,
  `account_code` varchar(256) DEFAULT NULL,
  `total_budget_limit` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_budget` (`budget_year`),
  KEY `FK_budget_create` (`created_by`),
  KEY `FK_budget_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `budget` */

/*Table structure for table `budget_temp` */

DROP TABLE IF EXISTS `budget_temp`;

CREATE TABLE `budget_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) DEFAULT NULL,
  `dipa_id` int(11) NOT NULL COMMENT 'DIPA',
  `budget_year` year(4) DEFAULT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) DEFAULT NULL,
  `suboutput_code` varchar(256) DEFAULT NULL,
  `component_code` varchar(256) DEFAULT NULL,
  `subcomponent_code` varchar(256) DEFAULT NULL,
  `account_code` varchar(256) DEFAULT NULL,
  `total_budget_limit` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_budget` (`budget_year`),
  KEY `FK_budget_create` (`created_by`),
  KEY `FK_budget_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `budget_temp` */

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province_code` varchar(256) NOT NULL,
  `code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_city_create` (`created_by`),
  KEY `FK_city_update` (`updated_by`),
  KEY `FK_city_prov_code` (`province_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `city` */

/*Table structure for table `component` */

DROP TABLE IF EXISTS `component`;

CREATE TABLE `component` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) DEFAULT NULL,
  `suboutput_code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_output_create` (`created_by`),
  KEY `FK_output` (`updated_by`),
  KEY `FK_output_activity` (`suboutput_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `component` */

/*Table structure for table `component_error` */

DROP TABLE IF EXISTS `component_error`;

CREATE TABLE `component_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) DEFAULT NULL,
  `suboutput_code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_output_create` (`created_by`),
  KEY `FK_output` (`updated_by`),
  KEY `FK_output_activity` (`suboutput_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `component_error` */

/*Table structure for table `dipa` */

DROP TABLE IF EXISTS `dipa`;

CREATE TABLE `dipa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `budget_year` year(4) NOT NULL COMMENT 'Tahun Anggaran',
  `dipa_number` varchar(256) NOT NULL,
  `dipa_date` date DEFAULT NULL,
  `type` enum('DIPA','POK') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_anggaran_create` (`created_by`),
  KEY `FK_anggaran_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `dipa` */

/*Table structure for table `error_dipa` */

DROP TABLE IF EXISTS `error_dipa`;

CREATE TABLE `error_dipa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL COMMENT 'Kode Grup Error',
  `budget_year` year(4) DEFAULT NULL COMMENT 'Tahun Anggaran',
  `satker_code` varchar(256) DEFAULT NULL COMMENT 'Kode Satker',
  `activity_code` varchar(256) DEFAULT NULL COMMENT 'Kode Kegiatan',
  `output_code` varchar(256) DEFAULT NULL COMMENT 'Kode Output',
  `suboutput_code` varchar(256) DEFAULT NULL COMMENT 'Kode Suboutput',
  `component_code` varchar(256) DEFAULT NULL COMMENT 'Kode Komponen',
  `subcomponent_code` varchar(256) DEFAULT NULL COMMENT 'Kode Subkomponen',
  `account_code` varchar(256) DEFAULT NULL COMMENT 'Kode Akun',
  `total_budget_limit` double DEFAULT NULL COMMENT 'Total Anggaran',
  `description` text COMMENT 'Keterangan Error',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `error_dipa` */

/*Table structure for table `error_dipa_completeness` */

DROP TABLE IF EXISTS `error_dipa_completeness`;

CREATE TABLE `error_dipa_completeness` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `code` varchar(256) NOT NULL COMMENT 'Kode Subkomponen',
  `description` text NOT NULL COMMENT 'Keterangan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `error_dipa_completeness` */

/*Table structure for table `error_realization` */

DROP TABLE IF EXISTS `error_realization`;

CREATE TABLE `error_realization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `packageAccount_code` varchar(256) DEFAULT NULL,
  `package_code` varchar(256) DEFAULT NULL,
  `up_ls` enum('UP','LS') DEFAULT NULL COMMENT 'UP/LS',
  `spm_number` varchar(256) DEFAULT NULL,
  `spm_date` date DEFAULT NULL,
  `total_spm` double DEFAULT NULL,
  `ppn` double DEFAULT NULL,
  `pph` double DEFAULT NULL,
  `receiver` enum('Bendahara','Penyedia Jasa') DEFAULT NULL,
  `nrk` varchar(256) DEFAULT NULL COMMENT 'Nomor Register Kontrak',
  `nrs` varchar(256) DEFAULT NULL COMMENT 'Nomor Register Suplier',
  `description` text NOT NULL COMMENT 'Keterangan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `error_realization` */

insert  into `error_realization`(`id`,`packageAccount_code`,`package_code`,`up_ls`,`spm_number`,`spm_date`,`total_spm`,`ppn`,`pph`,`receiver`,`nrk`,`nrs`,`description`) values (1,'622280.2439.011.003.011.A.521211','622280.2439.011.003.011.A','UP','','0000-00-00',10000,NULL,NULL,NULL,NULL,NULL,'Terjadi pagu minus pada akun paket 622280.2439.011.003.011.A.521211');

/*Table structure for table `financial_data` */

DROP TABLE IF EXISTS `financial_data`;

CREATE TABLE `financial_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `spm_type_code` varchar(256) NOT NULL,
  `payment_type_code` varchar(256) NOT NULL,
  `payment_method_code` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `financial_data` */

/*Table structure for table `group` */

DROP TABLE IF EXISTS `group`;

CREATE TABLE `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `group` */

insert  into `group`(`id`,`name`) values (1,'super-admin'),(2,'administrator'),(3,'eksekutif'),(4,'operator');

/*Table structure for table `group_auth` */

DROP TABLE IF EXISTS `group_auth`;

CREATE TABLE `group_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `className` varchar(256) NOT NULL,
  `action` varchar(256) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_group_auth_group` (`group_id`),
  CONSTRAINT `group_auth_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

/*Data for the table `group_auth` */

insert  into `group_auth`(`id`,`className`,`action`,`group_id`) values (1,'activity','index,create,view,update,delete,admin,editable,import',1),(2,'package','index,create,view,update,delete,admin,editable',1),(3,'post','index,create,view,update,delete,admin,editable',1),(4,'comment','index,create,view,update,delete,admin,editable',1),(5,'payment-method','index,create,view,update,delete,admin,editable',1),(6,'satker','index,create,view,update,delete,admin,editable,import',1),(7,'account','index,create,view,update,delete,admin,editable,import',1),(8,'output','index,create,view,update,delete,admin,editable,import',1),(9,'payment-type','index,create,view,update,delete,admin,editable',1),(10,'ppk','index,create,view,update,delete',1),(11,'spm-type','index,create,view,update,delete,admin,editable',1),(12,'suboutput','index,create,view,update,delete,admin,editable,import',1),(13,'component','index,create,view,update,delete,admin,editable,import',1),(14,'subcomponent','index,create,view,update,delete,admin,editable,import',1),(15,'dipa','index,create,view,update,delete,admin,editable,import',1),(16,'budget','index,create,view,update,delete,admin,editable,import',1),(17,'budget-year','index,create,view,update,delete,admin,editable,import',1),(18,'up','index,create,view,update,delete,admin,editable',1),(19,'realization','index,create,view,update,delete,admin,editable',1),(20,'nrs','index,create,view,update,delete,admin,editable',1),(21,'nrk','index,create,view,update,delete,admin,editable',1),(22,'province','index,create,view,update,delete,admin,editable,import',1),(23,'city','index,create,view,update,delete,admin,editable,import',1),(24,'nrk-detail','index,create,view,update,delete,admin',1),(25,'up-detail','index,create,view,update,delete,admin',1),(26,'up','index,create,view,update,delete,admin',2),(27,'nrs','index,create,view,update,delete,admin',2),(28,'nrk','index,create,view,update,delete,admin',2),(29,'package','index,create,view,update,delete,admin',2),(30,'realization','index,create,view,update,delete,admin',2),(31,'dashboard','mainChart,logout,satkerChart,activityChart,outputChart,suboutputChart,componentChart,subcomponentChart,ppkChart,ppkActivityChart,accountChart',1),(32,'dashboard','mainChart,logout,satkerChart,activityChart,outputChart,suboutputChart,logout,satkerChart,activityChart,outputChart,suboutputChart,componentChart,subcomponentChart,ppkChart,ppkActivityChart,accountChart',2),(33,'dashboard','mainChart,logout,satkerChart,activityChart,outputChart,suboutputChart,logout,satkerChart,activityChart,outputChart,suboutputChart,componentChart,subcomponentChart,ppkChart,ppkActivityChart,accountChart',3),(34,'user','profile,update,updatePassword,updateAuth,admin,create,delete',1),(35,'user','profile,update,updatePassword, updateAuth,delete,admin,create',2),(36,'user','profile,update,updatePassword',3),(37,'user','profile,update,updatePassword,updateAuth,admin,create,delete',4),(38,'activity','index,create,view,update,delete,admin,editable,import',4),(39,'package','index,create,view,update,delete,admin,editable,import',4),(40,'payment-method','index,create,view,update,delete,admin,editable,import',4),(41,'payment-type','index,create,view,update,delete,admin,editable,import',4),(42,'satker','index,create,view,update,delete,admin,editable,import',4),(43,'account','index,create,view,update,delete,admin,editable,import',4),(44,'output','index,create,view,update,delete,admin,editable,import',4),(45,'suboutput','index,create,view,update,delete,admin,editable,import',4),(46,'nrs','index,create,view,update,delete,admin,editable,import',4),(47,'nrk','index,create,view,update,delete,admin,editable,import',4),(48,'component','index,create,view,update,delete,admin,editable,import',4),(49,'subcomponent','index,create,view,update,delete,admin,editable,import',4),(50,'ppk','index,create,view,update,delete,admin,editable,import',4),(51,'spm-type','index,create,view,update,delete,admin,editable,import',4),(52,'dipa','index,create,view,update,delete,admin,editable,import',4),(53,'budget','index,create,view,update,delete,admin,editable,import',4),(54,'up','index,create,view,update,delete,admin,editable,import',4),(55,'realization','index,create,view,update,delete,admin,editable,import',4),(56,'nrk-detail','index,create,view,update,delete,admin,editable,import',4),(57,'up-detail','index,create,view,update,delete,admin,editable,import',4),(58,'province','index,create,view,update,delete,admin,editable,import',4),(59,'city','index,create,view,update,delete,admin,editable,import',4),(60,'dashboard','mainChart,logout,satkerChart,activityChart,outputChart,suboutputChart,logout,satkerChart,activityChart,outputChart,suboutputChart,componentChart,subcomponentChart,ppkChart,ppkActivityChart,accountChart',4),(61,'package-account','index,create,view,update,delete,admin',4),(62,'package-account','index,create,view,update,delete,admin',3),(63,'package-account','index,create,view,update,delete,admin',2),(64,'package-account','index,create,view,update,delete,admin',1);

/*Table structure for table `migration` */

DROP TABLE IF EXISTS `migration`;

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `migration` */

/*Table structure for table `nrk` */

DROP TABLE IF EXISTS `nrk`;

CREATE TABLE `nrk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nrk` varchar(256) NOT NULL,
  `contract_number` varchar(256) NOT NULL,
  `contract_date` date DEFAULT NULL,
  `limit` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_nrk_created` (`created_by`),
  KEY `FK_nrk_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `nrk` */

/*Table structure for table `nrk_detail` */

DROP TABLE IF EXISTS `nrk_detail`;

CREATE TABLE `nrk_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nrk_register` varchar(256) DEFAULT NULL,
  `nrk_contract_number` varchar(256) DEFAULT NULL,
  `termin` enum('1','2','3','4','5','6','7','8','9','10','11','12') DEFAULT NULL,
  `limit_per_termin` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_nrk_detail_created` (`created_by`),
  KEY `FK_nrk_detail_updated` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `nrk_detail` */

/*Table structure for table `nrs` */

DROP TABLE IF EXISTS `nrs`;

CREATE TABLE `nrs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nrs` varchar(256) NOT NULL,
  `supplier_name` varchar(256) NOT NULL,
  `npwp` varchar(256) DEFAULT NULL,
  `bank_name` varchar(256) DEFAULT NULL,
  `bank_account_number` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `nrs` */

/*Table structure for table `output` */

DROP TABLE IF EXISTS `output`;

CREATE TABLE `output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_output_create` (`created_by`),
  KEY `FK_output` (`updated_by`),
  KEY `FK_output_activity` (`activity_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;

/*Data for the table `output` */

/*Table structure for table `package` */

DROP TABLE IF EXISTS `package`;

CREATE TABLE `package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) DEFAULT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) DEFAULT NULL,
  `suboutput_code` varchar(256) DEFAULT NULL,
  `component_code` varchar(256) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `province_code` varchar(256) DEFAULT NULL,
  `city_code` varchar(256) DEFAULT NULL,
  `ppk_code` varchar(256) DEFAULT NULL,
  `limit` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_package_create` (`created_by`),
  KEY `FK_package_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `package` */

/*Table structure for table `package_account` */

DROP TABLE IF EXISTS `package_account`;

CREATE TABLE `package_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) DEFAULT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) DEFAULT NULL,
  `suboutput_code` varchar(256) DEFAULT NULL,
  `component_code` varchar(256) DEFAULT NULL,
  `package_code` varchar(256) DEFAULT NULL,
  `account_code` varchar(256) DEFAULT NULL,
  `province_code` varchar(256) DEFAULT NULL,
  `city_code` varchar(256) DEFAULT NULL,
  `ppk_code` varchar(256) DEFAULT NULL,
  `limit` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_package_create` (`created_by`),
  KEY `FK_package_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `package_account` */

/*Table structure for table `payment_method` */

DROP TABLE IF EXISTS `payment_method`;

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_payment_method` (`created_by`),
  KEY `FK_payment_method_update` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `payment_method` */

insert  into `payment_method`(`id`,`code`,`name`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (1,'1','Cek Bank','2015-08-25 14:07:57',1,'2015-08-25 14:07:57',1),(2,'2','Giro Bank','2015-08-25 14:08:04',1,'2015-08-25 14:08:04',1),(3,'3','Cek Pos','2015-08-25 14:08:12',1,'2015-08-25 14:08:12',1),(4,'4','Giro Pos','2015-08-25 14:08:18',1,'2015-08-25 14:08:18',1),(5,'5','Nihil','2015-08-25 14:08:26',1,'2015-08-25 14:08:26',1);

/*Table structure for table `payment_type` */

DROP TABLE IF EXISTS `payment_type`;

CREATE TABLE `payment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_payment_type_created` (`created_by`),
  KEY `FK_payment_type_updated` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `payment_type` */

/*Table structure for table `ppk` */

DROP TABLE IF EXISTS `ppk`;

CREATE TABLE `ppk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `ppk_name` varchar(256) NOT NULL,
  `official_name` varchar(256) NOT NULL,
  `official_nip` varchar(18) NOT NULL COMMENT 'NIP PPK',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_ppk_created` (`created_by`),
  KEY `FK_ppk_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `ppk` */

/*Table structure for table `province` */

DROP TABLE IF EXISTS `province`;

CREATE TABLE `province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_province_create` (`created_by`),
  KEY `FK_province_update` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `province` */

/*Table structure for table `realization` */

DROP TABLE IF EXISTS `realization`;

CREATE TABLE `realization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `packageAccount_code` varchar(256) DEFAULT NULL,
  `package_code` varchar(256) DEFAULT NULL,
  `up_ls` enum('UP','LS') DEFAULT NULL COMMENT 'UP/LS',
  `spm_number` varchar(256) DEFAULT NULL,
  `spm_date` date DEFAULT NULL,
  `total_spm` double DEFAULT NULL,
  `ppn` double DEFAULT NULL,
  `pph` double DEFAULT NULL,
  `receiver` enum('Bendahara','Penyedia Jasa') DEFAULT NULL,
  `nrk` varchar(256) DEFAULT NULL COMMENT 'Nomor Register Kontrak',
  `nrs` varchar(256) DEFAULT NULL COMMENT 'Nomor Register Suplier',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `realization` */

/*Table structure for table `satker` */

DROP TABLE IF EXISTS `satker`;

CREATE TABLE `satker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_output_create` (`created_by`),
  KEY `FK_output` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `satker` */

/*Table structure for table `spm_type` */

DROP TABLE IF EXISTS `spm_type`;

CREATE TABLE `spm_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_spm_type_created` (`created_by`),
  KEY `FK_spm_type_updated` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `spm_type` */

/*Table structure for table `subcomponent` */

DROP TABLE IF EXISTS `subcomponent`;

CREATE TABLE `subcomponent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) DEFAULT NULL,
  `suboutput_code` varchar(256) DEFAULT NULL,
  `component_code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_output_create` (`created_by`),
  KEY `FK_output` (`updated_by`),
  KEY `FK_output_activity` (`component_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `subcomponent` */

/*Table structure for table `subcomponent_error` */

DROP TABLE IF EXISTS `subcomponent_error`;

CREATE TABLE `subcomponent_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) DEFAULT NULL,
  `suboutput_code` varchar(256) DEFAULT NULL,
  `component_code` varchar(256) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_output_create` (`created_by`),
  KEY `FK_output` (`updated_by`),
  KEY `FK_output_activity` (`component_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `subcomponent_error` */

/*Table structure for table `suboutput` */

DROP TABLE IF EXISTS `suboutput`;

CREATE TABLE `suboutput` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_output_create` (`created_by`),
  KEY `FK_output` (`updated_by`),
  KEY `FK_output_activity` (`output_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `suboutput` */

/*Table structure for table `suboutput_error` */

DROP TABLE IF EXISTS `suboutput_error`;

CREATE TABLE `suboutput_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) NOT NULL,
  `satker_code` varchar(256) DEFAULT NULL,
  `activity_code` varchar(256) DEFAULT NULL,
  `output_code` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `FK_output_create` (`created_by`),
  KEY `FK_output` (`updated_by`),
  KEY `FK_output_activity` (`output_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `suboutput_error` */

/*Table structure for table `up` */

DROP TABLE IF EXISTS `up`;

CREATE TABLE `up` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number_of_letter` varchar(256) NOT NULL,
  `date_of_letter` date NOT NULL,
  `total_up` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_up_created` (`created_by`),
  KEY `FK_up_updated` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `up` */

/*Table structure for table `up_detail` */

DROP TABLE IF EXISTS `up_detail`;

CREATE TABLE `up_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `up_number_of_letter` varchar(256) DEFAULT NULL,
  `package_code` varchar(256) DEFAULT NULL,
  `limit` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_up_detail_created` (`created_by`),
  KEY `FK_up_detail_updated` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `up_detail` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_group` (`group_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id`,`username`,`password`,`last_login_time`,`group_id`) values (1,'Admin','21232f297a57a5a743894a0e4a801fc3',NULL,1),(3,'Pablo','21232f297a57a5a743894a0e4a801fc3',NULL,2),(4,'Operator','21232f297a57a5a743894a0e4a801fc3',NULL,4),(5,'Ppk','21232f297a57a5a743894a0e4a801fc3',NULL,3);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
