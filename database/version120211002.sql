-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: localhost    Database: customcrm
-- ------------------------------------------------------
-- Server version	5.7.31

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bfl_agent_input`
--

DROP TABLE IF EXISTS `bfl_agent_input`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bfl_agent_input` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bfl_agent_input`
--

LOCK TABLES `bfl_agent_input` WRITE;
/*!40000 ALTER TABLE `bfl_agent_input` DISABLE KEYS */;
INSERT INTO `bfl_agent_input` VALUES (1,'Non technical agent','DELHI','asdsdsda','3','2021-09-17 08:19:13',NULL),(2,'Non technical agenteeeeee','UP','ffddffdff','3','2021-09-17 08:19:13',NULL),(3,'asdasdads','Punjab','asdasdasdads','2','2021-09-17 08:19:13',NULL);
/*!40000 ALTER TABLE `bfl_agent_input` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bfl_test`
--

DROP TABLE IF EXISTS `bfl_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bfl_test` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bfl_test`
--

LOCK TABLES `bfl_test` WRITE;
/*!40000 ALTER TABLE `bfl_test` DISABLE KEYS */;
/*!40000 ALTER TABLE `bfl_test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bfl_testnew`
--

DROP TABLE IF EXISTS `bfl_testnew`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bfl_testnew` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bfl_testnew`
--

LOCK TABLES `bfl_testnew` WRITE;
/*!40000 ALTER TABLE `bfl_testnew` DISABLE KEYS */;
INSERT INTO `bfl_testnew` VALUES (1,'test','2021-09-14','3','2021-09-14 08:19:13','2021-09-14 08:19:13');
/*!40000 ALTER TABLE `bfl_testnew` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_field_options`
--

DROP TABLE IF EXISTS `crm_field_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crm_field_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_filed_id` int(11) DEFAULT NULL,
  `options` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_field_options`
--

LOCK TABLES `crm_field_options` WRITE;
/*!40000 ALTER TABLE `crm_field_options` DISABLE KEYS */;
INSERT INTO `crm_field_options` VALUES (15,2,'UP','2021-09-17 11:17:57','2021-09-17 11:17:57','1',NULL),(3,5,'delhi','2021-09-04 12:24:35','2021-09-04 12:24:35','1',NULL),(4,5,'Rajesthan','2021-09-04 12:24:35','2021-09-04 12:24:35','1',NULL),(5,6,'c100','2021-09-04 12:25:01','2021-09-04 12:25:01','1',NULL),(6,6,'c121','2021-09-04 12:25:01','2021-09-04 12:25:01','1',NULL),(14,2,'Punjab','2021-09-17 11:17:57','2021-09-17 11:17:57','1',NULL),(13,2,'DELHI','2021-09-17 11:17:57','2021-09-17 11:17:57','1',NULL),(16,2,'raj','2021-09-17 11:17:57','2021-09-17 11:17:57','1',NULL),(20,15,'DELHI','2021-09-18 04:44:37','2021-09-18 04:44:37','1',NULL),(19,15,'Punjab','2021-09-18 04:44:37','2021-09-18 04:44:37','1',NULL),(21,15,'UP','2021-09-18 04:44:37','2021-09-18 04:44:37','1',NULL),(22,17,'Noida','2021-09-18 04:48:55','2021-09-18 04:48:55','1',NULL),(23,17,'mumbai','2021-09-18 04:48:55','2021-09-18 04:48:55','1',NULL),(24,17,'vadodra','2021-09-18 04:48:55','2021-09-18 04:48:55','1',NULL),(25,20,'Noida','2021-09-28 11:20:13','2021-09-28 11:20:13','1',NULL),(26,20,'Punjab','2021-09-28 11:20:13','2021-09-28 11:20:13','1',NULL),(27,20,'DELHI','2021-09-28 11:20:13','2021-09-28 11:20:13','1',NULL),(28,21,'male','2021-09-28 11:20:27','2021-09-28 11:20:27','1',NULL),(29,21,'female','2021-09-28 11:20:27','2021-09-28 11:20:27','1',NULL),(30,22,'Noida','2021-09-28 11:20:48','2021-09-28 11:20:48','1',NULL),(31,22,'c100','2021-09-28 11:20:48','2021-09-28 11:20:48','1',NULL),(32,22,'mango','2021-09-28 11:20:48','2021-09-28 11:20:48','1',NULL);
/*!40000 ALTER TABLE `crm_field_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_fields`
--

DROP TABLE IF EXISTS `crm_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crm_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_form_id` int(11) DEFAULT NULL,
  `field_type` varchar(100) DEFAULT NULL,
  `field_name` varchar(100) DEFAULT NULL,
  `length` varchar(45) DEFAULT NULL,
  `label_name` varchar(100) DEFAULT NULL,
  `is_numaric` varchar(100) DEFAULT NULL,
  `is_required` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_fields`
--

LOCK TABLES `crm_fields` WRITE;
/*!40000 ALTER TABLE `crm_fields` DISABLE KEYS */;
INSERT INTO `crm_fields` VALUES (1,1,'text','name','100','Name','no','yes','2021-09-04 12:16:40',1,'2021-09-04 12:16:40',NULL),(2,1,'drop_down','state','100','State','no','yes','2021-09-04 12:16:40',1,'2021-09-04 12:16:40',NULL),(3,1,'text_area','remarks','255','Remarks','no','yes','2021-09-04 12:16:40',1,'2021-09-04 12:16:40',NULL),(4,2,'text','name','12','Name','no','yes','2021-09-04 12:23:14',1,'2021-09-04 12:23:14',NULL),(5,2,'drop_down','state','12','State','no','yes','2021-09-04 12:23:14',1,'2021-09-04 12:23:14',NULL),(6,2,'check_box','area','12','Area','no','no','2021-09-04 12:23:14',1,'2021-09-04 12:23:14',NULL),(12,5,'text_area','remarks','','Remarks','no','no','2021-09-17 11:19:31',1,'2021-09-17 11:19:31',NULL),(11,5,'text','name','','Name','no','no','2021-09-17 11:19:31',1,'2021-09-17 11:19:31',NULL),(9,4,'text','name','','Name','no','no','2021-09-14 08:14:52',1,'2021-09-14 08:14:52',NULL),(10,4,'date_picker','dob','','DOB','no','no','2021-09-14 08:14:52',1,'2021-09-14 08:14:52',NULL),(13,6,'text','name','','Name','no','yes','2021-09-17 12:55:36',1,'2021-09-17 12:55:36',NULL),(14,6,'text_area','re','','remarks','no','yes','2021-09-17 12:55:36',1,'2021-09-17 12:55:36',NULL),(15,6,'drop_down','state','','State','no','yes','2021-09-17 12:55:36',1,'2021-09-17 12:55:36',NULL),(16,7,'text','name','','Name','no','yes','2021-09-18 04:47:56',1,'2021-09-18 04:47:56',NULL),(17,7,'drop_down','location','','Location','no','yes','2021-09-18 04:47:56',1,'2021-09-18 04:47:56',NULL),(18,8,'text','name','255','Name','no','yes','2021-09-28 11:01:45',1,'2021-09-28 11:01:45',NULL),(19,9,'text','name','123','Name','no','yes','2021-09-28 11:19:25',1,'2021-09-28 11:19:25',NULL),(20,9,'drop_down','state','123','State','no','yes','2021-09-28 11:19:25',1,'2021-09-28 11:19:25',NULL),(21,9,'radio_button','gender','123','Gender','no','yes','2021-09-28 11:19:25',1,'2021-09-28 11:19:25',NULL),(22,9,'check_box','location','123','Location','no','yes','2021-09-28 11:19:25',1,'2021-09-28 11:19:25',NULL),(23,9,'date_picker','dob','123','DOB','no','yes','2021-09-28 11:19:25',1,'2021-09-28 11:19:25',NULL);
/*!40000 ALTER TABLE `crm_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_forms`
--

DROP TABLE IF EXISTS `crm_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crm_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_id` varchar(45) DEFAULT NULL,
  `form_name` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_forms`
--

LOCK TABLES `crm_forms` WRITE;
/*!40000 ALTER TABLE `crm_forms` DISABLE KEYS */;
INSERT INTO `crm_forms` VALUES (1,'1','bfl_agent_input','2021-09-04 12:16:40','1','2021-09-04 12:16:40',NULL),(2,'1','bfl_test','2021-09-04 12:23:14','1','2021-09-04 12:23:14',NULL),(5,'3','voltas_reminder','2021-09-17 11:19:31','1','2021-09-17 11:19:31',NULL),(4,'1','bfl_testnew','2021-09-14 08:14:52','1','2021-09-14 08:14:52',NULL),(6,'4','ems_inter','2021-09-17 12:55:36','1','2021-09-17 12:55:36',NULL),(7,'4','ems_covid','2021-09-18 04:47:56','1','2021-09-18 04:47:56',NULL),(9,'4','ems_newtest','2021-09-28 11:19:25','1','2021-09-28 11:19:25',NULL);
/*!40000 ALTER TABLE `crm_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_masters`
--

DROP TABLE IF EXISTS `crm_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `crm_masters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_name` varchar(45) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `updated_by` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `crm_name_UNIQUE` (`crm_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_masters`
--

LOCK TABLES `crm_masters` WRITE;
/*!40000 ALTER TABLE `crm_masters` DISABLE KEYS */;
INSERT INTO `crm_masters` VALUES (1,'BFL','1','1','2021-09-02 03:53:33','2021-09-02 03:59:00'),(3,'VOLTAS','1','1','2021-09-09 09:45:04',NULL),(4,'EMS','1',NULL,'2021-09-17 12:54:26','2021-09-17 12:54:26');
/*!40000 ALTER TABLE `crm_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ems_covid`
--

DROP TABLE IF EXISTS `ems_covid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ems_covid` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ems_covid`
--

LOCK TABLES `ems_covid` WRITE;
/*!40000 ALTER TABLE `ems_covid` DISABLE KEYS */;
INSERT INTO `ems_covid` VALUES (1,'Non technical agent','Noida','2','2021-09-18 04:49:13','2021-09-18 04:49:13');
/*!40000 ALTER TABLE `ems_covid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ems_inter`
--

DROP TABLE IF EXISTS `ems_inter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ems_inter` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `re` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ems_inter`
--

LOCK TABLES `ems_inter` WRITE;
/*!40000 ALTER TABLE `ems_inter` DISABLE KEYS */;
INSERT INTO `ems_inter` VALUES (1,'Non technical agent','asdasdasda','Punjab','2','2021-09-17 12:56:51','2021-09-17 12:56:51'),(2,'asds','asdasdas','UP','2','2021-09-18 04:45:27','2021-09-18 04:45:27');
/*!40000 ALTER TABLE `ems_inter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ems_newtest`
--

DROP TABLE IF EXISTS `ems_newtest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ems_newtest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(123) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(123) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(123) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(123) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dob` varchar(123) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ems_newtest`
--

LOCK TABLES `ems_newtest` WRITE;
/*!40000 ALTER TABLE `ems_newtest` DISABLE KEYS */;
INSERT INTO `ems_newtest` VALUES (1,'ADMIN','Noida','male','Noida,c100,mango','2021-09-01','5','2021-09-28 12:29:21','2021-09-28 12:29:21'),(2,'ADMIN','Noida','male','Noida','2021-09-29','5','2021-09-29 04:33:04','2021-09-29 04:33:04'),(3,'ADMIN','Noida','male','c100,mango','2021-09-29','5','2021-09-29 06:57:15','2021-09-29 06:57:15');
/*!40000 ALTER TABLE `ems_newtest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_crm`
--

DROP TABLE IF EXISTS `user_crm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_crm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `crm_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_crm`
--

LOCK TABLES `user_crm` WRITE;
/*!40000 ALTER TABLE `user_crm` DISABLE KEYS */;
INSERT INTO `user_crm` VALUES (5,3,1,'2021-09-09 11:13:01','2021-09-09 11:13:01'),(11,2,3,'2021-09-17 12:56:23','2021-09-17 12:56:23'),(10,2,1,'2021-09-17 12:56:23','2021-09-17 12:56:23'),(12,2,4,'2021-09-17 12:56:23','2021-09-17 12:56:23'),(13,5,4,'2021-09-28 11:21:31','2021-09-28 11:21:31');
/*!40000 ALTER TABLE `user_crm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `emp_id` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_type` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Surya Pratap','surya.singh@cogenteservices.com',NULL,'ce012030221','super_admin','$2y$10$hLlhycvqco8VyVhDbBGisuLYVuMEr/vZOj3D9nMUIqjUBMjKPvEFq',NULL,'2021-08-29 23:14:49','1','2021-09-18 06:43:55','1'),(2,'Vishal','vishal.verma@cogenteservices.com',NULL,'ce012030222','agent','$2y$10$nCr4nFHS0qksCm9CMdzuXuZv3KSIwOHciUaqKGHzG2f8lhpJz/LTa',NULL,'2021-08-30 00:45:38','4','2021-09-09 11:34:42','1'),(3,'ashutosh','ashutosh@gmail.com',NULL,'ce012030223','agent','$2y$10$hLlhycvqco8VyVhDbBGisuLYVuMEr/vZOj3D9nMUIqjUBMjKPvEFq',NULL,'2021-09-09 11:22:24','4','2021-09-09 11:34:11','1'),(4,'ADMIN','admin@admin.com',NULL,'admin@admin.com','admin','$2y$10$ySTleSq7FfMPpQhsdI3HaukvMLtm2KeEc9BdyA7OUnxiX8sGpL1li',NULL,'2021-09-18 06:50:48','1','2021-09-18 11:31:30','1'),(5,'admin agent','adminagent@gmail.com',NULL,'emp005','agent','$2y$10$E92I2G138YZvVoW07bmwPeYRxTNdFK8amEJyrMAchfoXj1Ubxs.5y',NULL,'2021-09-18 07:17:47','4','2021-09-28 10:35:34','1');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voltas_reminder`
--

DROP TABLE IF EXISTS `voltas_reminder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voltas_reminder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voltas_reminder`
--

LOCK TABLES `voltas_reminder` WRITE;
/*!40000 ALTER TABLE `voltas_reminder` DISABLE KEYS */;
INSERT INTO `voltas_reminder` VALUES (1,'dasdasd','asdasdad','2','2021-09-17 11:19:55','2021-09-17 11:19:55');
/*!40000 ALTER TABLE `voltas_reminder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'customcrm'
--

--
-- Dumping routines for database 'customcrm'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-10-02 10:34:04
