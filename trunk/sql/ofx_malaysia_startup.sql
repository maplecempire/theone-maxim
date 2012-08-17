-- MySQL dump 10.13  Distrib 5.1.41, for Win32 (ia32)
--
-- Host: localhost    Database: ofx_malaysia
-- ------------------------------------------------------
-- Server version	5.1.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_setting`
--

DROP TABLE IF EXISTS `app_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_parameter` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8_unicode_ci NOT NULL,
  `setting_remark` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_setting`
--

LOCK TABLES `app_setting` WRITE;
/*!40000 ALTER TABLE `app_setting` DISABLE KEYS */;
INSERT INTO `app_setting` VALUES (1,'MT4_HANDLING_FEE','0','mt4 handling fee (percentage)',0,'2012-03-05 00:00:00',0,'2012-06-20 20:46:37'),(2,'SERVER_MAINTAIN','0','0 = can login\n1 = cannot login',0,'2012-03-05 00:00:00',0,'2012-03-05 00:00:00'),(3,'SYSTEM_CURRENCY','MYR','SYSTEM CURRENCY',0,'2012-05-31 17:41:01',0,'2012-05-31 17:41:04'),(4,'USD_TO_MYR','1','convertion rate usd to myr',0,'2012-06-01 05:50:06',0,'2012-06-21 03:55:18'),(5,'MT4_HANDLING_FEE_USD','60','mt4 handling fee (USD)',0,'2012-06-01 06:12:00',0,'2012-06-01 06:12:00'),(6,'BANK_NAME','WESTERN BANK','BANK NAME',0,'2012-06-01 06:12:02',0,'2012-06-23 15:40:00'),(7,'BANK_SWIFT_CODE','SWIFT12345','BANK SWIFT CODE',0,'2012-06-01 06:12:02',0,'2012-06-23 15:40:00'),(8,'BANK_ACCOUNT_HOLDER','OFX GLOBAL MALAYSIA','BANK ACCOUNT HOLDER',0,'2012-06-01 06:12:02',0,'2012-06-23 15:40:00'),(9,'BANK_ACCOUNT_NUMBER','112233445566','BANK ACCOUNT NUMBER',0,'2012-06-01 06:12:02',0,'2012-06-01 06:12:05'),(10,'CITY_OF_BANK','AUCKLAND','CITY OF BANK',0,'2012-06-01 06:12:02',0,'2012-06-23 15:40:00'),(11,'COUNTRY_OF_BANK','NEW ZEALAND','COUNTRY OF BANK',0,'2012-06-01 06:12:02',0,'2012-06-23 15:40:00');
/*!40000 ALTER TABLE `app_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_user`
--

DROP TABLE IF EXISTS `app_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `keep_password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `userpassword` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `keep_password2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `userpassword2` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `last_login_datetime` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_user`
--

LOCK TABLES `app_user` WRITE;
/*!40000 ALTER TABLE `app_user` DISABLE KEYS */;
INSERT INTO `app_user` VALUES (1,'8888','admin123','123456','admin123','admin123','ADMIN','ACTIVE',NULL,0,'2012-03-04 17:37:32',0,'2012-03-27 06:29:06'),(2,'forexadmin','admin123','admin123','admin123','admin123','ADMIN','ACTIVE',NULL,0,'2012-03-04 17:37:32',0,'2012-03-27 06:24:10'),(3,'fxm1','123456','123456','test','test','DISTRIBUTOR','ACTIVE','2012-07-03 01:49:02',0,'2012-03-04 17:37:32',0,'2012-07-03 01:49:02');
/*!40000 ALTER TABLE `app_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_user_access`
--

DROP TABLE IF EXISTS `app_user_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_user_access` (
  `access_code` varchar(50) CHARACTER SET latin1 NOT NULL,
  `parent_id` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `menu_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `menu_label` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `is_menu` varchar(1) CHARACTER SET latin1 NOT NULL,
  `is_auth_needed` varchar(1) CHARACTER SET latin1 NOT NULL,
  `tree_level` int(11) DEFAULT NULL,
  `tree_seq` int(11) DEFAULT NULL,
  `tree_structure` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `status_code` varchar(10) CHARACTER SET latin1 DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`access_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_user_access`
--

LOCK TABLES `app_user_access` WRITE;
/*!40000 ALTER TABLE `app_user_access` DISABLE KEYS */;
INSERT INTO `app_user_access` VALUES ('AL_CHANGE_PASSWORD','MOD_ADMIN','admin/changePassword','Change Password','Y','Y',2,1030,'MOD_ADMIN|AL_CHANGE_PASSWORD','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_DIST_LIST','MOD_MARKETING','marketing/distList','Distributor List','Y','Y',2,2010,'MOD_MARKETING|AL_DIST_LIST','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_EPOINT_PURCHASE','MOD_FINANCE','finance/cpsPriceSetting','e-Point Purchase','Y','Y',2,3010,'MOD_FINANCE|AL_EPOINT_PURCHASE','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_FILE_UPLOAD','MOD_MARKETING','marketing/fxGuideUpload','FX Guide Upload','Y','Y',2,2030,'MOD_FINANCE|AL_FILE_UPLOAD','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_IB_LIST','MOD_MARKETING','marketing/distList','Super IB List','Y','Y',2,2011,'MOD_MARKETING|AL_IB_LIST','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_MT4_WITHDRAWAL','MOD_FINANCE','finance/goldRedemption','MT4 Withdrawal','Y','Y',2,3050,'MOD_FINANCE|AL_MT4_WITHDRAWAL','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_PACKAGE','MOD_ADMIN','admin/packageList','Package','Y','Y',2,1050,'MOD_ADMIN|AL_PACKAGE','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_PACKAGE_PURCHASE','MOD_FINANCE','finance/ecashAdjustment','Package Purchase','Y','Y',2,3009,'MOD_FINANCE|AL_PACKAGE_PURCHASE','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_PACKAGE_UPGRADE','MOD_FINANCE','finance/ecashAdjustment','Package Upgrade','Y','Y',2,3020,'MOD_FINANCE|AL_PACKAGE_UPGRADE','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_PIPS_BONUS','MOD_FINANCE','finance/ecashAdjustment','Pips Bonus','Y','Y',2,3041,'MOD_FINANCE|AL_PIPS_BONUS','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_PIPS_CALCULATOR','MOD_MARKETING','finance/pipsCalculator','Pips Calculator','Y','Y',2,2040,'MOD_MARKETING|AL_PIPS_CALCULATOR','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_REFERRAL_BONUS','MOD_FINANCE','finance/ecashAdjustment','Referral Bonus','Y','Y',2,3040,'MOD_FINANCE|AL_REFERRAL_BONUS','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_RELOAD_MT4_FUND','MOD_FINANCE','finance/ecashAdjustment','Reload MT4 Fund','Y','Y',2,3030,'MOD_FINANCE|AL_RELOAD_MT4_FUND','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_SETTING','MOD_ADMIN','admin/applicationSetting','Application Setting','Y','Y',2,1040,'MOD_ADMIN|AL_SETTING','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_SPONSOR_TREE','MOD_MARKETING','marketing/sponsorTree','Sponsor Tree','Y','Y',2,2020,'MOD_MARKETING|AL_SPONSOR_TREE','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_USER_LIST','MOD_ADMIN','admin/userList','User List','Y','Y',2,1010,'MOD_ADMIN|AL_USER_LIST','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('AL_USER_ROLE','MOD_ADMIN','admin/userRole','User Role','Y','Y',2,1020,'MOD_ADMIN|AL_USER_ROLE','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('MOD_ADMIN',NULL,'','Admin','Y','Y',1,1000,'MOD_ADMIN','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('MOD_FINANCE',NULL,'','Finance','Y','Y',1,3000,'MOD_FINANCE','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40'),('MOD_MARKETING',NULL,'','Marketing','Y','Y',1,2000,'MOD_MARKETING','ACTIVE','2011-10-19 20:55:40','2011-10-19 20:55:40');
/*!40000 ALTER TABLE `app_user_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_user_in_role`
--

DROP TABLE IF EXISTS `app_user_in_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_user_in_role` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_user_in_role`
--

LOCK TABLES `app_user_in_role` WRITE;
/*!40000 ALTER TABLE `app_user_in_role` DISABLE KEYS */;
INSERT INTO `app_user_in_role` VALUES (1,-1,1,'2011-10-20 00:00:00','2011-10-20 00:00:00'),(2,-2,2,'2011-10-20 00:00:00','2011-10-20 00:00:00');
/*!40000 ALTER TABLE `app_user_in_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_user_role`
--

DROP TABLE IF EXISTS `app_user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_user_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_code` varchar(20) CHARACTER SET latin1 NOT NULL,
  `role_desc` varchar(50) CHARACTER SET latin1 NOT NULL,
  `status_code` varchar(10) CHARACTER SET latin1 NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_user_role`
--

LOCK TABLES `app_user_role` WRITE;
/*!40000 ALTER TABLE `app_user_role` DISABLE KEYS */;
INSERT INTO `app_user_role` VALUES (1,'finance','finance role','active',-1,'2011-10-19 00:00:00','2011-10-19 00:00:00'),(2,'admin','admin role','active',-1,'2011-10-19 00:00:00','2011-10-19 00:00:00'),(3,'test','test role','active',-1,'2011-10-19 23:02:20','2011-10-19 23:02:20');
/*!40000 ALTER TABLE `app_user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_user_role_access`
--

DROP TABLE IF EXISTS `app_user_role_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_user_role_access` (
  `role_access_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_code` varchar(50) CHARACTER SET latin1 NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`role_access_id`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_user_role_access`
--

LOCK TABLES `app_user_role_access` WRITE;
/*!40000 ALTER TABLE `app_user_role_access` DISABLE KEYS */;
INSERT INTO `app_user_role_access` VALUES (28,'MOD_ADMIN',3,'2011-10-19 23:33:53','2011-10-19 23:33:53'),(29,'AL_USER_LIST',3,'2011-10-19 23:33:53','2011-10-19 23:33:53'),(143,'MOD_FINANCE',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(144,'AL_ADVANCE_EPOINT',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(145,'AL_ADVANCE_ECASH',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(146,'AL_EPOINT_TRANSACTION',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(147,'AL_ECASH_TRANSACTION',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(148,'AL_MONTHLY_BONUS',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(149,'AL_DAILY_BONUS',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(150,'AL_MONTHLY_SALES',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(151,'AL_DAILY_SALES',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(152,'AL_ECASH_WITHDRAWAL',1,'2012-03-27 07:52:40','2012-03-27 07:52:40'),(208,'MOD_ADMIN',2,'2012-06-28 22:41:13','2012-06-28 22:41:13'),(209,'AL_USER_LIST',2,'2012-06-28 22:41:13','2012-06-28 22:41:13'),(210,'AL_USER_ROLE',2,'2012-06-28 22:41:13','2012-06-28 22:41:13'),(211,'AL_CHANGE_PASSWORD',2,'2012-06-28 22:41:13','2012-06-28 22:41:13'),(212,'AL_SETTING',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(213,'AL_PACKAGE',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(214,'MOD_MARKETING',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(215,'AL_DIST_LIST',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(216,'AL_IB_LIST',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(217,'AL_SPONSOR_TREE',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(218,'AL_FILE_UPLOAD',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(219,'AL_PIPS_CALCULATOR',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(220,'MOD_FINANCE',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(221,'AL_PACKAGE_PURCHASE',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(222,'AL_EPOINT_PURCHASE',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(223,'AL_PACKAGE_UPGRADE',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(224,'AL_RELOAD_MT4_FUND',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(225,'AL_REFERRAL_BONUS',2,'2012-06-28 22:41:14','2012-06-28 22:41:14'),(226,'AL_MT4_WITHDRAWAL',2,'2012-06-28 22:41:14','2012-06-28 22:41:14');
/*!40000 ALTER TABLE `app_user_role_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_account`
--

DROP TABLE IF EXISTS `mlm_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_account` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `account_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_account`
--

LOCK TABLES `mlm_account` WRITE;
/*!40000 ALTER TABLE `mlm_account` DISABLE KEYS */;
INSERT INTO `mlm_account` VALUES (1,0,'EPOINT','300000.00',0,'2012-07-03 09:48:51',0,'2012-07-03 09:48:51'),(2,1,'ECASH','0.00',0,'2012-07-03 01:49:03',0,'2012-07-03 01:49:03'),(3,1,'EPOINT','0.00',0,'2012-07-03 01:49:03',0,'2012-07-03 01:49:03');
/*!40000 ALTER TABLE `mlm_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_account_ledger`
--

DROP TABLE IF EXISTS `mlm_account_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_account_ledger` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `account_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `credit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `debit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_account_ledger`
--

LOCK TABLES `mlm_account_ledger` WRITE;
/*!40000 ALTER TABLE `mlm_account_ledger` DISABLE KEYS */;
INSERT INTO `mlm_account_ledger` VALUES (1,0,'EPOINT','ADVANCE','300000.00','0.00','300000.00',NULL,0,'2012-07-03 00:00:00',0,'2012-07-03 00:00:00');
/*!40000 ALTER TABLE `mlm_account_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_admin`
--

DROP TABLE IF EXISTS `mlm_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `admin_role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_admin`
--

LOCK TABLES `mlm_admin` WRITE;
/*!40000 ALTER TABLE `mlm_admin` DISABLE KEYS */;
INSERT INTO `mlm_admin` VALUES (1,'8888',1,'ACTIVE','SUPERADMIN',0,'2012-03-04 17:37:32',0,'2012-03-04 17:37:32'),(2,'forexadmin',2,'active','admin',0,'2012-03-04 17:37:32',1,'2012-03-27 06:24:46');
/*!40000 ALTER TABLE `mlm_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_announcement`
--

DROP TABLE IF EXISTS `mlm_announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_announcement` (
  `announcement_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title_cn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content_cn` longtext COLLATE utf8_unicode_ci NOT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`announcement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_announcement`
--

LOCK TABLES `mlm_announcement` WRITE;
/*!40000 ALTER TABLE `mlm_announcement` DISABLE KEYS */;
INSERT INTO `mlm_announcement` VALUES (1,'Welcome to FXMartket2You!','Welcome to FXMartket2You!','Welcome to FXMartket2You!','Welcome to FXMartket2You!','ACTIVE',1,'2012-04-18 00:00:00',1,'2012-04-18 00:00:00');
/*!40000 ALTER TABLE `mlm_announcement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_daily_bonus_log`
--

DROP TABLE IF EXISTS `mlm_daily_bonus_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_daily_bonus_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `access_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `bonus_type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `bonus_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_daily_bonus_log`
--

LOCK TABLES `mlm_daily_bonus_log` WRITE;
/*!40000 ALTER TABLE `mlm_daily_bonus_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_daily_bonus_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_dist_commission`
--

DROP TABLE IF EXISTS `mlm_dist_commission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_dist_commission` (
  `commission_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `commission_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`commission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_dist_commission`
--

LOCK TABLES `mlm_dist_commission` WRITE;
/*!40000 ALTER TABLE `mlm_dist_commission` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_dist_commission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_dist_commission_ledger`
--

DROP TABLE IF EXISTS `mlm_dist_commission_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_dist_commission_ledger` (
  `commission_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `commission_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `month_traded` int(11) DEFAULT NULL,
  `credit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `debit` decimal(12,2) NOT NULL DEFAULT '0.00',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pips_downline_username` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `pips_mt4_id` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `pips_rebate` decimal(12,2) DEFAULT NULL,
  `pips_level` int(11) DEFAULT NULL,
  `pips_lots_traded` decimal(12,2) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `status_code` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`commission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_dist_commission_ledger`
--

LOCK TABLES `mlm_dist_commission_ledger` WRITE;
/*!40000 ALTER TABLE `mlm_dist_commission_ledger` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_dist_commission_ledger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_dist_epoint_purchase`
--

DROP TABLE IF EXISTS `mlm_dist_epoint_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_dist_epoint_purchase` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `transaction_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `image_src` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_reference` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approve_reject_datetime` datetime DEFAULT NULL,
  `approved_by_userid` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_dist_epoint_purchase`
--

LOCK TABLES `mlm_dist_epoint_purchase` WRITE;
/*!40000 ALTER TABLE `mlm_dist_epoint_purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_dist_epoint_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_dist_package_purchase`
--

DROP TABLE IF EXISTS `mlm_dist_package_purchase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_dist_package_purchase` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `rank_id` int(11) DEFAULT NULL,
  `rank_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `transaction_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `image_src` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approve_reject_datetime` datetime DEFAULT NULL,
  `approved_by_userid` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_dist_package_purchase`
--

LOCK TABLES `mlm_dist_package_purchase` WRITE;
/*!40000 ALTER TABLE `mlm_dist_package_purchase` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_dist_package_purchase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_distributor`
--

DROP TABLE IF EXISTS `mlm_distributor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_distributor` (
  `distributor_id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `mt4_user_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mt4_password` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mt4_id` int(11) DEFAULT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ic` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postcode` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alternate_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `bank_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_acc_no` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_holder_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bank_swift_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `visa_debit_card` varchar(18) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tree_level` int(4) DEFAULT NULL,
  `tree_structure` text COLLATE utf8_unicode_ci,
  `ib_rank_id` int(11) DEFAULT NULL,
  `ib_rank_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `init_rank_id` int(11) DEFAULT NULL,
  `init_rank_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `upline_dist_id` int(11) DEFAULT NULL,
  `upline_dist_code` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rank_id` int(11) DEFAULT NULL,
  `rank_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active_datetime` datetime DEFAULT NULL,
  `activated_by` int(11) DEFAULT NULL,
  `leverage` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `spread` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deposit_currency` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deposit_amount` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sign_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sign_date` datetime DEFAULT NULL,
  `term_condition` int(1) DEFAULT '0',
  `ib_commission` decimal(12,2) NOT NULL DEFAULT '0.00',
  `is_ib` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  `package_purchase_flag` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`distributor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_distributor`
--

LOCK TABLES `mlm_distributor` WRITE;
/*!40000 ALTER TABLE `mlm_distributor` DISABLE KEYS */;
INSERT INTO `mlm_distributor` VALUES (1,'fxm1',3,'mt4',NULL,0,'ACTIVE','fxm1','fxm1','','','',NULL,NULL,NULL,'','r9jason@gmail.com',NULL,'1234567890','','2012-03-04','bank name','11223654789','bank holder name','swift','1111111111111111',1,'|fxm1|',4,'Master ID 4',5,'Diamond',0,NULL,5,'Diamond','2012-06-01 05:01:39',1,NULL,NULL,NULL,NULL,NULL,NULL,1,'0.20','1',0,'2012-03-04 17:37:32',3,'2012-06-25 04:18:28','Y');
/*!40000 ALTER TABLE `mlm_distributor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_ecash_withdraw`
--

DROP TABLE IF EXISTS `mlm_ecash_withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_ecash_withdraw` (
  `withdraw_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `deduct` decimal(12,2) NOT NULL DEFAULT '0.00',
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approve_reject_datetime` datetime DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`withdraw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_ecash_withdraw`
--

LOCK TABLES `mlm_ecash_withdraw` WRITE;
/*!40000 ALTER TABLE `mlm_ecash_withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_ecash_withdraw` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_file_download`
--

DROP TABLE IF EXISTS `mlm_file_download`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_file_download` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_src` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_file_download`
--

LOCK TABLES `mlm_file_download` WRITE;
/*!40000 ALTER TABLE `mlm_file_download` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_file_download` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_ib_package`
--

DROP TABLE IF EXISTS `mlm_ib_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_ib_package` (
  `ib_package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `commission` decimal(12,2) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`ib_package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_ib_package`
--

LOCK TABLES `mlm_ib_package` WRITE;
/*!40000 ALTER TABLE `mlm_ib_package` DISABLE KEYS */;
INSERT INTO `mlm_ib_package` VALUES (1,'Master ID 1','12.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08'),(2,'Master ID 2','15.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08'),(3,'Master ID 3','18.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08'),(4,'Master ID 4','20.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08');
/*!40000 ALTER TABLE `mlm_ib_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_mt4_account`
--

DROP TABLE IF EXISTS `mlm_mt4_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_mt4_account` (
  `mt4_id` int(11) NOT NULL AUTO_INCREMENT,
  `distributor_id` int(11) DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  `mt_user_name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `investor_password` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `normal_password` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `serial_no` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`mt4_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_mt4_account`
--

LOCK TABLES `mlm_mt4_account` WRITE;
/*!40000 ALTER TABLE `mlm_mt4_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_mt4_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_mt4_demo_request`
--

DROP TABLE IF EXISTS `mlm_mt4_demo_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_mt4_demo_request` (
  `request_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_mt4_demo_request`
--

LOCK TABLES `mlm_mt4_demo_request` WRITE;
/*!40000 ALTER TABLE `mlm_mt4_demo_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_mt4_demo_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_mt4_reload_fund`
--

DROP TABLE IF EXISTS `mlm_mt4_reload_fund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_mt4_reload_fund` (
  `reload_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `mt4_user_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approve_reject_datetime` datetime DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`reload_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_mt4_reload_fund`
--

LOCK TABLES `mlm_mt4_reload_fund` WRITE;
/*!40000 ALTER TABLE `mlm_mt4_reload_fund` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_mt4_reload_fund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_mt4_withdraw`
--

DROP TABLE IF EXISTS `mlm_mt4_withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_mt4_withdraw` (
  `withdraw_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `mt4_user_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `amount_requested` decimal(12,2) NOT NULL DEFAULT '0.00',
  `handling_fee` decimal(12,2) DEFAULT NULL,
  `grand_amount` decimal(12,2) DEFAULT NULL,
  `currency_code` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_type` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `approve_reject_datetime` datetime DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`withdraw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_mt4_withdraw`
--

LOCK TABLES `mlm_mt4_withdraw` WRITE;
/*!40000 ALTER TABLE `mlm_mt4_withdraw` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_mt4_withdraw` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_package`
--

DROP TABLE IF EXISTS `mlm_package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `commission` decimal(12,2) DEFAULT NULL,
  `pips` decimal(12,2) DEFAULT NULL,
  `generation` decimal(12,2) DEFAULT NULL,
  `pips2` decimal(12,2) DEFAULT NULL,
  `generation2` decimal(12,2) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_package`
--

LOCK TABLES `mlm_package` WRITE;
/*!40000 ALTER TABLE `mlm_package` DISABLE KEYS */;
INSERT INTO `mlm_package` VALUES (1,'Basic','5000.00','5.00','2.00','3.00','0.00','0.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08'),(2,'Silver','10000.00','6.00','2.00','4.00','0.00','0.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08'),(3,'Gold','15000.00','8.00','2.00','5.00','0.00','0.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08'),(4,'Platinium','30000.00','10.00','2.00','5.00','1.00','3.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08'),(5,'Diamond','50000.00','12.00','2.00','5.00','1.00','5.00',0,'2012-04-13 13:48:08',0,'2012-04-13 13:48:08');
/*!40000 ALTER TABLE `mlm_package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_package_upgrade_history`
--

DROP TABLE IF EXISTS `mlm_package_upgrade_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_package_upgrade_history` (
  `upgrade_id` int(11) NOT NULL AUTO_INCREMENT,
  `dist_id` int(11) NOT NULL,
  `transaction_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status_code` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`upgrade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_package_upgrade_history`
--

LOCK TABLES `mlm_package_upgrade_history` WRITE;
/*!40000 ALTER TABLE `mlm_package_upgrade_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_package_upgrade_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mlm_pip_csv`
--

DROP TABLE IF EXISTS `mlm_pip_csv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mlm_pip_csv` (
  `pip_id` int(11) NOT NULL AUTO_INCREMENT,
  `month_traded` int(11) DEFAULT NULL,
  `year_traded` int(4) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `pips_string` text COLLATE utf8_unicode_ci,
  `login_id` int(11) DEFAULT NULL,
  `login_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deposit` decimal(12,2) DEFAULT NULL,
  `withdraw` decimal(12,2) DEFAULT NULL,
  `in_out` decimal(12,2) DEFAULT NULL,
  `credit` decimal(12,2) DEFAULT NULL,
  `volume` decimal(12,2) DEFAULT NULL,
  `commission` decimal(12,2) DEFAULT NULL,
  `taxes` decimal(12,2) DEFAULT NULL,
  `agent` decimal(12,2) DEFAULT NULL,
  `storage` decimal(12,2) DEFAULT NULL,
  `profit` decimal(12,2) DEFAULT NULL,
  `last_balance` decimal(12,2) DEFAULT NULL,
  `status_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`pip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mlm_pip_csv`
--

LOCK TABLES `mlm_pip_csv` WRITE;
/*!40000 ALTER TABLE `mlm_pip_csv` DISABLE KEYS */;
/*!40000 ALTER TABLE `mlm_pip_csv` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-07-03 10:16:57
