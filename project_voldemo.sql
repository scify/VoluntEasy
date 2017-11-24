-- MySQL dump 10.13  Distrib 5.5.58, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: project_voldemo
-- ------------------------------------------------------
-- Server version	5.5.58-0ubuntu0.14.04.1

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
-- Table structure for table `action_rating_attributes`
--

DROP TABLE IF EXISTS `action_rating_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_rating_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_rating_attributes`
--

LOCK TABLES `action_rating_attributes` WRITE;
/*!40000 ALTER TABLE `action_rating_attributes` DISABLE KEYS */;
INSERT INTO `action_rating_attributes` VALUES (1,'clearRole','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'knewRoleDuties','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'cooperationWithActionManager','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'cooperationWithVolunteers','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'interestingAction','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'autonomy','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'developedSkills','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'satisfied','0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,'contribution','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `action_rating_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_rating_scores`
--

DROP TABLE IF EXISTS `action_rating_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_rating_scores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `score` int(11) NOT NULL,
  `attribute_id` int(10) unsigned NOT NULL,
  `action_score_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `action_rating_scores_attribute_id_foreign` (`attribute_id`),
  KEY `action_rating_scores_action_score_id_foreign` (`action_score_id`),
  CONSTRAINT `action_rating_scores_action_score_id_foreign` FOREIGN KEY (`action_score_id`) REFERENCES `action_scores` (`id`),
  CONSTRAINT `action_rating_scores_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `action_rating_attributes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_rating_scores`
--

LOCK TABLES `action_rating_scores` WRITE;
/*!40000 ALTER TABLE `action_rating_scores` DISABLE KEYS */;
/*!40000 ALTER TABLE `action_rating_scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_ratings`
--

DROP TABLE IF EXISTS `action_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rated` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL,
  `action_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `action_ratings_user_id_foreign` (`user_id`),
  KEY `action_ratings_action_id_foreign` (`action_id`),
  CONSTRAINT `action_ratings_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `action_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_ratings`
--

LOCK TABLES `action_ratings` WRITE;
/*!40000 ALTER TABLE `action_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `action_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `action_scores`
--

DROP TABLE IF EXISTS `action_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `action_scores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rated` tinyint(1) NOT NULL DEFAULT '0',
  `action_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `action_scores_action_id_foreign` (`action_id`),
  CONSTRAINT `action_scores_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `action_scores`
--

LOCK TABLES `action_scores` WRITE;
/*!40000 ALTER TABLE `action_scores` DISABLE KEYS */;
/*!40000 ALTER TABLE `action_scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actions`
--

DROP TABLE IF EXISTS `actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `volunteer_sum` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `actions_unit_id_foreign` (`unit_id`),
  CONSTRAINT `actions_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions`
--

LOCK TABLES `actions` WRITE;
/*!40000 ALTER TABLE `actions` DISABLE KEYS */;
INSERT INTO `actions` VALUES (1,'DarkCyan','Et tempora sit quia est dolorum. Ducimus libero nemo eos officiis deserunt similique excepturi voluptas. Aperiam alias quisquam non facilis reprehenderit ea sed. Et porro mollitia impedit sed.','','','','1990-06-04','2003-05-22','2016-05-19 13:40:25','2016-05-20 13:11:17','2016-05-20 13:11:17',6,''),(2,'LightSeaGreen','Et aut fugiat delectus qui. Eveniet eum voluptatibus maxime eaque qui aut minima. Iure distinctio eius est non. Ea velit accusantium est et. Iste quia velit voluptatem ut qui quasi.',NULL,NULL,NULL,'1973-03-14','1995-01-11','2016-05-19 13:40:25','2016-05-20 13:02:13','2016-05-20 13:02:13',11,''),(3,'Collect food supplies for refugees','Collect food for refugees','','John Doe','123-456-789','2016-05-31','2016-07-31','2016-05-19 13:40:25','2016-06-15 11:47:33',NULL,8,''),(4,'DarkGoldenRod','Iusto veritatis nihil ut est enim est ut. Cumque dolorem eum odio ipsum voluptatum non possimus.',NULL,NULL,NULL,'1970-06-11','1978-09-06','2016-05-19 13:40:25','2016-05-20 13:02:53','2016-05-20 13:02:53',6,''),(5,'LightCoral','Aliquid odio debitis recusandae recusandae laborum numquam. Asperiores explicabo ad quisquam numquam vel tenetur atque. Quos sit repudiandae nesciunt error laboriosam tenetur quis est.',NULL,NULL,NULL,'1999-11-14','2010-09-06','2016-05-19 13:40:25','2016-05-20 13:02:23','2016-05-20 13:02:23',11,''),(6,'Collect clothes for refugees','','','','','2016-05-28','2016-05-29','2016-05-25 11:14:49','2016-05-25 11:14:49',NULL,9,''),(7,'Συμμετοχή στο Athens Science Festival','Ενημέρωση κοινού, περίπτερο SciFY, παρουσίαση  SciFY','','','','2016-07-11','2016-08-31','2016-07-06 10:09:06','2016-08-15 00:06:39','2016-08-15 00:06:39',7,''),(8,'asdasdasd','asdasd','','','','2016-09-30','2016-10-09','2016-09-01 10:57:51','2016-09-01 10:57:51',NULL,16,''),(9,'bajaar','','','','','2017-01-19','2017-04-30','2017-01-19 12:14:25','2017-01-19 12:14:25',NULL,19,'');
/*!40000 ALTER TABLE `actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actions_users`
--

DROP TABLE IF EXISTS `actions_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions_users` (
  `user_id` int(10) unsigned NOT NULL,
  `action_id` int(10) unsigned NOT NULL,
  KEY `actions_users_user_id_foreign` (`user_id`),
  KEY `actions_users_action_id_foreign` (`action_id`),
  CONSTRAINT `actions_users_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `actions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions_users`
--

LOCK TABLES `actions_users` WRITE;
/*!40000 ALTER TABLE `actions_users` DISABLE KEYS */;
INSERT INTO `actions_users` VALUES (3,3);
/*!40000 ALTER TABLE `actions_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actions_volunteers`
--

DROP TABLE IF EXISTS `actions_volunteers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions_volunteers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(10) unsigned NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `actions_volunteers_action_id_foreign` (`action_id`),
  KEY `actions_volunteers_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `actions_volunteers_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `actions_volunteers_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions_volunteers`
--

LOCK TABLES `actions_volunteers` WRITE;
/*!40000 ALTER TABLE `actions_volunteers` DISABLE KEYS */;
INSERT INTO `actions_volunteers` VALUES (6,3,10),(7,3,1);
/*!40000 ALTER TABLE `actions_volunteers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availability_days`
--

DROP TABLE IF EXISTS `availability_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availability_days` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `day` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `availability_days_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `availability_days_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability_days`
--

LOCK TABLES `availability_days` WRITE;
/*!40000 ALTER TABLE `availability_days` DISABLE KEYS */;
INSERT INTO `availability_days` VALUES (1,'monday','morning',16,'2016-06-23 10:59:55','2016-06-23 10:59:55'),(6,'wednesday','evening',24,'2017-01-26 20:14:01','2017-01-26 20:14:01'),(7,'friday','evening',24,'2017-01-26 20:14:01','2017-01-26 20:14:01'),(8,'saturday','morning',24,'2017-01-26 20:14:01','2017-01-26 20:14:01'),(9,'saturday','afternoon',24,'2017-01-26 20:14:01','2017-01-26 20:14:01');
/*!40000 ALTER TABLE `availability_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availability_freqs`
--

DROP TABLE IF EXISTS `availability_freqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availability_freqs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability_freqs`
--

LOCK TABLES `availability_freqs` WRITE;
/*!40000 ALTER TABLE `availability_freqs` DISABLE KEYS */;
INSERT INTO `availability_freqs` VALUES (1,'everyDay','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'perWeek','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'perFortnight','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'perMonth','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `availability_freqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `availability_time`
--

DROP TABLE IF EXISTS `availability_time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `availability_time` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `availability_time`
--

LOCK TABLES `availability_time` WRITE;
/*!40000 ALTER TABLE `availability_time` DISABLE KEYS */;
INSERT INTO `availability_time` VALUES (1,'morning'),(2,'afternoon'),(3,'evening');
/*!40000 ALTER TABLE `availability_time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collaboration_types`
--

DROP TABLE IF EXISTS `collaboration_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collaboration_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaboration_types`
--

LOCK TABLES `collaboration_types` WRITE;
/*!40000 ALTER TABLE `collaboration_types` DISABLE KEYS */;
INSERT INTO `collaboration_types` VALUES (1,'npo','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'public','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'private','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'etc','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `collaboration_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collaborations`
--

DROP TABLE IF EXISTS `collaborations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collaborations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `collaborations_type_id_foreign` (`type_id`),
  CONSTRAINT `collaborations_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `collaboration_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaborations`
--

LOCK TABLES `collaborations` WRITE;
/*!40000 ALTER TABLE `collaborations` DISABLE KEYS */;
INSERT INTO `collaborations` VALUES (1,'Feed the People NGO','We are collaborating on the Refugees Issue','','','2016-06-01','2016-12-01',1,'2016-06-23 11:33:08','2016-06-23 11:33:08',NULL);
/*!40000 ALTER TABLE `collaborations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collaborations_executives`
--

DROP TABLE IF EXISTS `collaborations_executives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collaborations_executives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collaboration_id` int(10) unsigned NOT NULL,
  `executive_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `collaborations_executives_collaboration_id_foreign` (`collaboration_id`),
  KEY `collaborations_executives_executive_id_foreign` (`executive_id`),
  CONSTRAINT `collaborations_executives_collaboration_id_foreign` FOREIGN KEY (`collaboration_id`) REFERENCES `collaborations` (`id`),
  CONSTRAINT `collaborations_executives_executive_id_foreign` FOREIGN KEY (`executive_id`) REFERENCES `executives` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaborations_executives`
--

LOCK TABLES `collaborations_executives` WRITE;
/*!40000 ALTER TABLE `collaborations_executives` DISABLE KEYS */;
INSERT INTO `collaborations_executives` VALUES (1,1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `collaborations_executives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collaborations_files`
--

DROP TABLE IF EXISTS `collaborations_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collaborations_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `collaboration_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `collaborations_files_collaboration_id_foreign` (`collaboration_id`),
  CONSTRAINT `collaborations_files_collaboration_id_foreign` FOREIGN KEY (`collaboration_id`) REFERENCES `collaborations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaborations_files`
--

LOCK TABLES `collaborations_files` WRITE;
/*!40000 ALTER TABLE `collaborations_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `collaborations_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comm_method`
--

DROP TABLE IF EXISTS `comm_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comm_method` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comm_method`
--

LOCK TABLES `comm_method` WRITE;
/*!40000 ALTER TABLE `comm_method` DISABLE KEYS */;
INSERT INTO `comm_method` VALUES (1,'email'),(2,'homeTel'),(3,'workTel'),(4,'cellTel');
/*!40000 ALTER TABLE `comm_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cta_volunteers`
--

DROP TABLE IF EXISTS `cta_volunteers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cta_volunteers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isVolunteer` tinyint(1) NOT NULL DEFAULT '0',
  `public_action_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cta_volunteers_public_action_id_foreign` (`public_action_id`),
  CONSTRAINT `cta_volunteers_public_action_id_foreign` FOREIGN KEY (`public_action_id`) REFERENCES `public_actions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cta_volunteers`
--

LOCK TABLES `cta_volunteers` WRITE;
/*!40000 ALTER TABLE `cta_volunteers` DISABLE KEYS */;
/*!40000 ALTER TABLE `cta_volunteers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cta_volunteers_platform_volunteers`
--

DROP TABLE IF EXISTS `cta_volunteers_platform_volunteers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cta_volunteers_platform_volunteers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cta_volunteers_id` int(10) unsigned NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cta_volunteers_platform_volunteers_cta_volunteers_id_foreign` (`cta_volunteers_id`),
  KEY `cta_volunteers_platform_volunteers_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `cta_volunteers_platform_volunteers_cta_volunteers_id_foreign` FOREIGN KEY (`cta_volunteers_id`) REFERENCES `cta_volunteers` (`id`),
  CONSTRAINT `cta_volunteers_platform_volunteers_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cta_volunteers_platform_volunteers`
--

LOCK TABLES `cta_volunteers_platform_volunteers` WRITE;
/*!40000 ALTER TABLE `cta_volunteers_platform_volunteers` DISABLE KEYS */;
/*!40000 ALTER TABLE `cta_volunteers_platform_volunteers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cta_volunteers_subtask_dates`
--

DROP TABLE IF EXISTS `cta_volunteers_subtask_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cta_volunteers_subtask_dates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cta_volunteers_id` int(10) unsigned NOT NULL,
  `subtask_shifts_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cta_volunteers_subtask_dates_cta_volunteers_id_foreign` (`cta_volunteers_id`),
  KEY `cta_volunteers_subtask_dates_subtask_shifts_id_foreign` (`subtask_shifts_id`),
  CONSTRAINT `cta_volunteers_subtask_dates_cta_volunteers_id_foreign` FOREIGN KEY (`cta_volunteers_id`) REFERENCES `cta_volunteers` (`id`),
  CONSTRAINT `cta_volunteers_subtask_dates_subtask_shifts_id_foreign` FOREIGN KEY (`subtask_shifts_id`) REFERENCES `subtask_shifts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cta_volunteers_subtask_dates`
--

LOCK TABLES `cta_volunteers_subtask_dates` WRITE;
/*!40000 ALTER TABLE `cta_volunteers_subtask_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `cta_volunteers_subtask_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cta_volunteers_task_dates`
--

DROP TABLE IF EXISTS `cta_volunteers_task_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cta_volunteers_task_dates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cta_volunteers_id` int(10) unsigned NOT NULL,
  `task_shifts_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `cta_volunteers_task_dates_cta_volunteers_id_foreign` (`cta_volunteers_id`),
  KEY `cta_volunteers_task_dates_task_shifts_id_foreign` (`task_shifts_id`),
  CONSTRAINT `cta_volunteers_task_dates_cta_volunteers_id_foreign` FOREIGN KEY (`cta_volunteers_id`) REFERENCES `cta_volunteers` (`id`),
  CONSTRAINT `cta_volunteers_task_dates_task_shifts_id_foreign` FOREIGN KEY (`task_shifts_id`) REFERENCES `task_shifts` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cta_volunteers_task_dates`
--

LOCK TABLES `cta_volunteers_task_dates` WRITE;
/*!40000 ALTER TABLE `cta_volunteers_task_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `cta_volunteers_task_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `driver_license_types`
--

DROP TABLE IF EXISTS `driver_license_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `driver_license_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `driver_license_types`
--

LOCK TABLES `driver_license_types` WRITE;
/*!40000 ALTER TABLE `driver_license_types` DISABLE KEYS */;
INSERT INTO `driver_license_types` VALUES (1,'yes','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'no','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `driver_license_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `education_levels`
--

DROP TABLE IF EXISTS `education_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `education_levels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `education_levels`
--

LOCK TABLES `education_levels` WRITE;
/*!40000 ALTER TABLE `education_levels` DISABLE KEYS */;
INSERT INTO `education_levels` VALUES (1,'secondary'),(2,'higher'),(3,'masters');
/*!40000 ALTER TABLE `education_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `executives`
--

DROP TABLE IF EXISTS `executives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `executives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `executives`
--

LOCK TABLES `executives` WRITE;
/*!40000 ALTER TABLE `executives` DISABLE KEYS */;
INSERT INTO `executives` VALUES (1,'Tom','Burton','','','2016-06-23 11:33:08','2016-06-23 11:33:08',NULL);
/*!40000 ALTER TABLE `executives` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genders`
--

DROP TABLE IF EXISTS `genders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genders`
--

LOCK TABLES `genders` WRITE;
/*!40000 ALTER TABLE `genders` DISABLE KEYS */;
INSERT INTO `genders` VALUES (1,'man'),(2,'woman');
/*!40000 ALTER TABLE `genders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `how_you_learned`
--

DROP TABLE IF EXISTS `how_you_learned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `how_you_learned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `how_you_learned`
--

LOCK TABLES `how_you_learned` WRITE;
/*!40000 ALTER TABLE `how_you_learned` DISABLE KEYS */;
INSERT INTO `how_you_learned` VALUES (1,'website','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'ad','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'newsletter','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'friend','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'otherNPO','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'article','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'etc','','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `how_you_learned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `how_you_learned2`
--

DROP TABLE IF EXISTS `how_you_learned2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `how_you_learned2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `how_you_learned2`
--

LOCK TABLES `how_you_learned2` WRITE;
/*!40000 ALTER TABLE `how_you_learned2` DISABLE KEYS */;
INSERT INTO `how_you_learned2` VALUES (1,'orgSite','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'webSocial','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'throughFriends','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'orgActions','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'thoughVolunteerActions','','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'etc','','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `how_you_learned2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `identification_types`
--

DROP TABLE IF EXISTS `identification_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `identification_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `identification_types`
--

LOCK TABLES `identification_types` WRITE;
/*!40000 ALTER TABLE `identification_types` DISABLE KEYS */;
INSERT INTO `identification_types` VALUES (1,'id'),(2,'passport'),(3,'resPermit');
/*!40000 ALTER TABLE `identification_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interest_categories`
--

DROP TABLE IF EXISTS `interest_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interest_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interest_categories`
--

LOCK TABLES `interest_categories` WRITE;
/*!40000 ALTER TABLE `interest_categories` DISABLE KEYS */;
INSERT INTO `interest_categories` VALUES (1,'generalInterests','2016-05-19 13:38:32','2016-05-19 13:38:32');
/*!40000 ALTER TABLE `interest_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interests`
--

DROP TABLE IF EXISTS `interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `interests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `interests_category_id_foreign` (`category_id`),
  CONSTRAINT `interests_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `interest_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interests`
--

LOCK TABLES `interests` WRITE;
/*!40000 ALTER TABLE `interests` DISABLE KEYS */;
INSERT INTO `interests` VALUES (1,'graphics',1,'2016-05-19 13:38:32','2016-05-19 13:38:32'),(2,'research',1,'2016-05-19 13:38:32','2016-05-19 13:38:32'),(3,'communicationSocialMedia',1,'2016-05-19 13:38:32','2016-05-19 13:38:32'),(4,'translations',1,'2016-05-19 13:38:32','2016-05-19 13:38:32'),(5,'customLegalSupport',1,'2016-05-19 13:38:32','2016-05-19 13:38:32'),(6,'eventOrg',1,'2016-05-19 13:38:32','2016-05-19 13:38:32'),(7,'otherInterests',1,'2016-05-19 13:38:33','2016-05-19 13:38:33');
/*!40000 ALTER TABLE `interests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language_levels`
--

DROP TABLE IF EXISTS `language_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language_levels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language_levels`
--

LOCK TABLES `language_levels` WRITE;
/*!40000 ALTER TABLE `language_levels` DISABLE KEYS */;
INSERT INTO `language_levels` VALUES (1,'basic'),(2,'good'),(3,'veryGood'),(4,'native');
/*!40000 ALTER TABLE `language_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'greek'),(2,'english'),(3,'french'),(4,'spanish'),(5,'german');
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marital_statuses`
--

DROP TABLE IF EXISTS `marital_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marital_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marital_statuses`
--

LOCK TABLES `marital_statuses` WRITE;
/*!40000 ALTER TABLE `marital_statuses` DISABLE KEYS */;
INSERT INTO `marital_statuses` VALUES (1,'notMarried'),(2,'married'),(3,'widowed'),(4,'divorsed');
/*!40000 ALTER TABLE `marital_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1),('2015_05_20_104557_create_units_table',1),('2015_05_20_111301_create_volunteer_table',1),('2015_05_20_120655_create_training_courses',1),('2015_06_17_082620_add_actions_to_units_relation',1),('2015_07_07_170212_create_notifications_table',1),('2015_07_28_114740_create_rating_table',1),('2015_08_03_131803_create_volunteers_units_excludes_table',1),('2015_08_17_135640_create_blacklisted_table',1),('2015_08_24_133825_create_jobs_table',1),('2015_08_26_090707_create_files_table',1),('2015_08_27_090256_volunteer_status_duration',1),('2015_10_14_110934_volunteer_addons',1),('2015_10_29_103611_create_collaborations_table',1),('2015_10_29_103625_create_executives_table',1),('2015_11_02_101910_create_action_ratings',1),('2015_11_25_084001_alter_actions_add_volunteer_number',1),('2016_01_12_095352_create_roles_table',1),('2016_01_18_100812_create_tasks_table',1),('2016_02_10_101615_create_volunteering_work_interests_table',1),('2016_02_10_112300_create_volunteer_extras_table',1),('2016_02_18_133312_create_subtasks_shifts_table',1),('2016_02_19_144127_create_subtask_checklist_table',1),('2016_02_25_082458_create_public_cta_page_table',1),('2016_02_26_114043_create_cta_volunteers_table',1),('2016_03_08_105757_create_shift_history_tables',1),('2016_03_10_140143_add_contract_date_volunteers_table',1),('2016_03_24_094957_create_opa_volunteer_ratings_table',1),('2016_04_21_113021_add_users_shifts_to_tasks_subtasks',1),('2016_04_25_120800_add_image_to_volunteers',1),('2016_04_26_080413_add_task_checklist_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_actions`
--

DROP TABLE IF EXISTS `module_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_actions`
--

LOCK TABLES `module_actions` WRITE;
/*!40000 ALTER TABLE `module_actions` DISABLE KEYS */;
INSERT INTO `module_actions` VALUES (1,'create','2016-05-19 13:38:27','2016-05-19 13:38:27'),(2,'delete','2016-05-19 13:38:27','2016-05-19 13:38:27'),(3,'read','2016-05-19 13:38:27','2016-05-19 13:38:27'),(4,'update','2016-05-19 13:38:27','2016-05-19 13:38:27');
/*!40000 ALTER TABLE `module_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'action','2016-05-19 13:38:26','2016-05-19 13:38:26'),(2,'collaboration','2016-05-19 13:38:26','2016-05-19 13:38:26'),(3,'unit','2016-05-19 13:38:26','2016-05-19 13:38:26'),(4,'user','2016-05-19 13:38:26','2016-05-19 13:38:26'),(5,'volunteer','2016-05-19 13:38:27','2016-05-19 13:38:27');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `type_id` int(11) NOT NULL,
  `reference1_id` int(11) NOT NULL,
  `reference2_id` int(11) DEFAULT NULL,
  `status` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `msg` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_index` (`user_id`),
  KEY `notifications_type_id_index` (`type_id`),
  KEY `notifications_reference1_id_index` (`reference1_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,2,1,2,19,'inactive','You are Unit Manager polyiatreio athens.','/users/one/2','2017-01-19 12:10:38','2017-01-19 12:13:52');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opa_interpersonal_skills`
--

DROP TABLE IF EXISTS `opa_interpersonal_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opa_interpersonal_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opa_interpersonal_skills`
--

LOCK TABLES `opa_interpersonal_skills` WRITE;
/*!40000 ALTER TABLE `opa_interpersonal_skills` DISABLE KEYS */;
INSERT INTO `opa_interpersonal_skills` VALUES (1,'writtenOralComm','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'persuasion','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'empathy','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'coopAbility','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `opa_interpersonal_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opa_labor_skills`
--

DROP TABLE IF EXISTS `opa_labor_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opa_labor_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opa_labor_skills`
--

LOCK TABLES `opa_labor_skills` WRITE;
/*!40000 ALTER TABLE `opa_labor_skills` DISABLE KEYS */;
INSERT INTO `opa_labor_skills` VALUES (1,'troubleshooting','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'criticalThinking','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'projectImpl','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'capacityPlanning','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'orderliness','0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,'procrastinationLack','0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,'credibility','0000-00-00 00:00:00','0000-00-00 00:00:00'),(8,'consistency','0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,'patience','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `opa_labor_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `public_actions`
--

DROP TABLE IF EXISTS `public_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `public_actions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `map_url` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `executive_name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `executive_email` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `executive_phone` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `public_url` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT '0',
  `action_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `public_actions_action_id_foreign` (`action_id`),
  CONSTRAINT `public_actions_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_actions`
--

LOCK TABLES `public_actions` WRITE;
/*!40000 ALTER TABLE `public_actions` DISABLE KEYS */;
INSERT INTO `public_actions` VALUES (1,'ghfh','fff','http://','','','','1-DarkCyan',1,1,'2016-05-20 13:11:17','2016-05-20 10:23:48','2016-05-20 13:11:17'),(2,'Collect food for refugees','amfiktionos 17','http://','','','','3-Collect food supplies for refugees',1,3,NULL,'2016-05-20 13:29:21','2016-05-20 13:29:21');
/*!40000 ALTER TABLE `public_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `public_actions_subtasks`
--

DROP TABLE IF EXISTS `public_actions_subtasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `public_actions_subtasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `public_actions_id` int(10) unsigned NOT NULL,
  `subtask_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `public_actions_subtasks_public_actions_id_foreign` (`public_actions_id`),
  KEY `public_actions_subtasks_subtask_id_foreign` (`subtask_id`),
  CONSTRAINT `public_actions_subtasks_public_actions_id_foreign` FOREIGN KEY (`public_actions_id`) REFERENCES `public_actions` (`id`),
  CONSTRAINT `public_actions_subtasks_subtask_id_foreign` FOREIGN KEY (`subtask_id`) REFERENCES `subtasks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_actions_subtasks`
--

LOCK TABLES `public_actions_subtasks` WRITE;
/*!40000 ALTER TABLE `public_actions_subtasks` DISABLE KEYS */;
INSERT INTO `public_actions_subtasks` VALUES (1,'',1,2,'2016-05-20 13:11:17','2016-05-20 10:24:03','2016-05-20 13:11:17'),(2,'',1,3,'2016-05-20 13:11:17','2016-05-20 10:24:03','2016-05-20 13:11:17'),(3,'',1,1,'2016-05-20 13:11:17','2016-05-20 10:24:03','2016-05-20 13:11:17'),(4,'',2,4,NULL,'2016-05-26 08:36:38','2016-05-26 08:36:38'),(5,'',2,5,NULL,'2016-05-26 08:36:38','2016-05-26 08:36:38'),(6,'',2,6,NULL,'2016-05-26 08:36:38','2016-05-26 08:36:38'),(7,'',2,7,NULL,'2016-05-26 08:36:38','2016-05-26 08:36:38');
/*!40000 ALTER TABLE `public_actions_subtasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rating_attributes`
--

DROP TABLE IF EXISTS `rating_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rating_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rating_attributes`
--

LOCK TABLES `rating_attributes` WRITE;
/*!40000 ALTER TABLE `rating_attributes` DISABLE KEYS */;
INSERT INTO `rating_attributes` VALUES (1,'consistency','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'teamwork','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'diligence','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'willingness','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'effectiveness','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `rating_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ratings`
--

DROP TABLE IF EXISTS `ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rating` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rating_attribute_id` int(10) unsigned NOT NULL,
  `volunteer_action_rating_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `ratings_rating_attribute_id_foreign` (`rating_attribute_id`),
  KEY `ratings_volunteer_action_rating_id_foreign` (`volunteer_action_rating_id`),
  CONSTRAINT `ratings_rating_attribute_id_foreign` FOREIGN KEY (`rating_attribute_id`) REFERENCES `rating_attributes` (`id`),
  CONSTRAINT `ratings_volunteer_action_rating_id_foreign` FOREIGN KEY (`volunteer_action_rating_id`) REFERENCES `volunteer_action_ratings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ratings`
--

LOCK TABLES `ratings` WRITE;
/*!40000 ALTER TABLE `ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2016-05-19 13:38:26','2016-05-19 13:38:26'),(2,'unit_manager','2016-05-19 13:38:26','2016-05-19 13:38:26'),(3,'action_manager','2016-05-19 13:38:26','2016-05-19 13:38:26');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles_permissions`
--

DROP TABLE IF EXISTS `roles_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_permissions` (
  `role_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `action_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `roles_permissions_role_id_foreign` (`role_id`),
  KEY `roles_permissions_module_id_foreign` (`module_id`),
  KEY `roles_permissions_action_id_foreign` (`action_id`),
  CONSTRAINT `roles_permissions_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `module_actions` (`id`),
  CONSTRAINT `roles_permissions_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  CONSTRAINT `roles_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_permissions`
--

LOCK TABLES `roles_permissions` WRITE;
/*!40000 ALTER TABLE `roles_permissions` DISABLE KEYS */;
INSERT INTO `roles_permissions` VALUES (1,1,1,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,1,2,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,1,3,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,1,4,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,2,1,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,2,2,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,2,3,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,2,4,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,3,1,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,3,2,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,3,3,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,3,4,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,4,1,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,4,2,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,4,3,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,4,4,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,5,1,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,5,2,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,5,3,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(1,5,4,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(2,1,1,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(2,1,2,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(2,1,3,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(2,1,4,'2016-05-19 13:38:27','2016-05-19 13:38:27'),(2,2,1,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,2,2,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,2,3,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,2,4,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,3,1,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,3,2,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,3,3,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,3,4,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,4,1,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,4,2,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,4,3,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,4,4,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,5,1,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,5,2,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,5,3,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(2,5,4,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(3,1,3,'2016-05-19 13:38:28','2016-05-19 13:38:28'),(3,4,3,'2016-05-19 13:38:28','2016-05-19 13:38:28');
/*!40000 ALTER TABLE `roles_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `step_statuses`
--

DROP TABLE IF EXISTS `step_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `step_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `step_statuses`
--

LOCK TABLES `step_statuses` WRITE;
/*!40000 ALTER TABLE `step_statuses` DISABLE KEYS */;
INSERT INTO `step_statuses` VALUES (1,'Complete'),(2,'Incomplete');
/*!40000 ALTER TABLE `step_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `steps`
--

DROP TABLE IF EXISTS `steps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `steps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `unit_id` int(10) unsigned NOT NULL,
  `description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `step_order` smallint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `steps_unit_id_foreign` (`unit_id`),
  CONSTRAINT `steps_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `steps`
--

LOCK TABLES `steps` WRITE;
/*!40000 ALTER TABLE `steps` DISABLE KEYS */;
INSERT INTO `steps` VALUES (1,1,'communicationStep',NULL,'Communication',1,'2016-05-19 13:38:28','2016-05-19 13:38:28',NULL),(2,1,'interviewStep',NULL,'Interview',2,'2016-05-19 13:38:28','2016-05-19 13:38:28',NULL),(3,1,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:38:28','2016-05-19 13:38:28',NULL),(4,2,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(5,2,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(6,2,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(7,3,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(8,3,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(9,3,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(10,4,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(11,4,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(12,4,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL),(13,5,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:24','2016-08-15 00:06:00','2016-08-15 00:06:00'),(14,5,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:24','2016-08-15 00:06:00','2016-08-15 00:06:00'),(15,5,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:24','2016-08-15 00:06:00','2016-08-15 00:06:00'),(16,6,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:24','2016-05-20 13:15:09','2016-05-20 13:15:09'),(17,6,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:24','2016-05-20 13:15:09','2016-05-20 13:15:09'),(18,6,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:24','2016-05-20 13:15:09','2016-05-20 13:15:09'),(19,7,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(20,7,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(21,7,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(22,8,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(23,8,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(24,8,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(25,9,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(26,9,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(27,9,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:25','2016-05-19 13:40:25',NULL),(28,10,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:25','2016-05-20 13:14:51','2016-05-20 13:14:51'),(29,10,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:25','2016-05-20 13:14:51','2016-05-20 13:14:51'),(30,10,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:25','2016-05-20 13:14:51','2016-05-20 13:14:51'),(31,11,'communicationStep',NULL,'Communication',1,'2016-05-19 13:40:25','2016-05-20 13:05:45','2016-05-20 13:05:45'),(32,11,'interviewStep',NULL,'Interview',2,'2016-05-19 13:40:25','2016-05-20 13:05:45','2016-05-20 13:05:45'),(33,11,'assignmentStep',NULL,'Assignment',3,'2016-05-19 13:40:25','2016-05-20 13:05:45','2016-05-20 13:05:45'),(34,12,'communicationStep',NULL,'Communication',1,'2016-05-20 12:32:37','2016-05-20 12:32:37',NULL),(35,12,'interviewStep',NULL,'Interview',2,'2016-05-20 12:32:37','2016-05-20 12:32:37',NULL),(36,12,'assignmentStep',NULL,'Assignment',3,'2016-05-20 12:32:37','2016-05-20 12:32:37',NULL),(37,13,'communicationStep',NULL,'Communication',1,'2016-05-20 12:36:58','2016-08-15 00:05:21','2016-08-15 00:05:21'),(38,13,'interviewStep',NULL,'Interview',2,'2016-05-20 12:36:58','2016-08-15 00:05:21','2016-08-15 00:05:21'),(39,13,'assignmentStep',NULL,'Assignment',3,'2016-05-20 12:36:58','2016-08-15 00:05:21','2016-08-15 00:05:21'),(40,14,'communicationStep',NULL,'Communication',1,'2016-05-20 13:06:45','2016-05-20 13:06:45',NULL),(41,14,'interviewStep',NULL,'Interview',2,'2016-05-20 13:06:45','2016-05-20 13:06:45',NULL),(42,14,'assignmentStep',NULL,'Assignment',3,'2016-05-20 13:06:45','2016-05-20 13:06:45',NULL),(43,15,'communicationStep',NULL,'Communication',1,'2016-05-20 13:07:11','2016-05-20 13:07:11',NULL),(44,15,'interviewStep',NULL,'Interview',2,'2016-05-20 13:07:11','2016-05-20 13:07:11',NULL),(45,15,'assignmentStep',NULL,'Assignment',3,'2016-05-20 13:07:11','2016-05-20 13:07:11',NULL),(46,16,'communicationStep',NULL,'Communication',1,'2016-05-20 13:14:28','2016-05-20 13:14:28',NULL),(47,16,'interviewStep',NULL,'Interview',2,'2016-05-20 13:14:28','2016-05-20 13:14:28',NULL),(48,16,'assignmentStep',NULL,'Assignment',3,'2016-05-20 13:14:28','2016-05-20 13:14:28',NULL),(49,17,'communicationStep',NULL,'Communication',1,'2016-06-21 10:56:43','2016-06-21 10:56:43',NULL),(50,17,'interviewStep',NULL,'Interview',2,'2016-06-21 10:56:43','2016-06-21 10:56:43',NULL),(51,17,'assignmentStep',NULL,'Assignment',3,'2016-06-21 10:56:43','2016-06-21 10:56:43',NULL),(52,18,'communicationStep',NULL,'Communication',1,'2016-06-23 10:42:42','2016-06-23 10:42:42',NULL),(53,18,'interviewStep',NULL,'Interview',2,'2016-06-23 10:42:42','2016-06-23 10:42:42',NULL),(54,18,'assignmentStep',NULL,'Assignment',3,'2016-06-23 10:42:42','2016-06-23 10:42:42',NULL),(55,19,'communicationStep',NULL,'Communication',1,'2017-01-19 12:10:38','2017-01-19 12:10:38',NULL),(56,19,'interviewStep',NULL,'Interview',2,'2017-01-19 12:10:39','2017-01-19 12:10:39',NULL),(57,19,'assignmentStep',NULL,'Assignment',3,'2017-01-19 12:10:39','2017-01-19 12:10:39',NULL);
/*!40000 ALTER TABLE `steps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subtask_checklists`
--

DROP TABLE IF EXISTS `subtask_checklists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subtask_checklists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comments` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `isComplete` tinyint(1) NOT NULL DEFAULT '0',
  `subtask_id` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `subtask_checklists_subtask_id_foreign` (`subtask_id`),
  KEY `subtask_checklists_created_by_foreign` (`created_by`),
  KEY `subtask_checklists_updated_by_foreign` (`updated_by`),
  CONSTRAINT `subtask_checklists_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `subtask_checklists_subtask_id_foreign` FOREIGN KEY (`subtask_id`) REFERENCES `subtasks` (`id`),
  CONSTRAINT `subtask_checklists_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subtask_checklists`
--

LOCK TABLES `subtask_checklists` WRITE;
/*!40000 ALTER TABLE `subtask_checklists` DISABLE KEYS */;
/*!40000 ALTER TABLE `subtask_checklists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subtask_shifts`
--

DROP TABLE IF EXISTS `subtask_shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subtask_shifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `from_hour` time DEFAULT NULL,
  `to_hour` time DEFAULT NULL,
  `comments` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `volunteer_sum` int(11) DEFAULT NULL,
  `subtask_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `subtask_shifts_subtask_id_foreign` (`subtask_id`),
  CONSTRAINT `subtask_shifts_subtask_id_foreign` FOREIGN KEY (`subtask_id`) REFERENCES `subtasks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subtask_shifts`
--

LOCK TABLES `subtask_shifts` WRITE;
/*!40000 ALTER TABLE `subtask_shifts` DISABLE KEYS */;
INSERT INTO `subtask_shifts` VALUES (1,'2016-05-27',NULL,'12:00:00','21:00:00','04/06/1990 - 22/05/2003',2,1,'2016-05-20 13:11:17','2016-05-19 14:47:45','2016-05-20 13:11:17'),(2,'2016-05-22',NULL,'08:00:00','21:00:00','power supply tasks',4,2,'2016-05-20 13:11:17','2016-05-19 15:05:23','2016-05-20 13:11:17'),(3,'2016-05-22',NULL,'12:00:00','00:00:00','internet connection',2,3,'2016-05-20 13:11:17','2016-05-19 15:13:46','2016-05-20 13:11:17'),(4,'2016-07-31',NULL,'23:00:00','01:00:00','truck driving',2,4,NULL,'2016-05-23 11:53:16','2016-06-15 11:49:07'),(5,'2016-05-31',NULL,'23:00:00','02:00:00','muscle job',8,5,NULL,'2016-05-23 11:57:07','2016-06-15 11:52:42');
/*!40000 ALTER TABLE `subtask_shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subtasks`
--

DROP TABLE IF EXISTS `subtasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subtasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT '2',
  `due_date` date DEFAULT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `action_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `subtasks_task_id_foreign` (`task_id`),
  KEY `subtasks_status_id_foreign` (`status_id`),
  KEY `subtasks_action_id_foreign` (`action_id`),
  CONSTRAINT `subtasks_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `subtasks_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `task_statuses` (`id`),
  CONSTRAINT `subtasks_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subtasks`
--

LOCK TABLES `subtasks` WRITE;
/*!40000 ALTER TABLE `subtasks` DISABLE KEYS */;
INSERT INTO `subtasks` VALUES (1,'secretariat','General Info',2,'2003-05-22',1,2,1,'2016-05-20 13:11:17','2016-05-19 14:36:41','2016-05-20 13:11:17'),(2,'Technican','provide necessary power supply where needed, solve technical issues',2,'2003-05-22',1,1,1,'2016-05-20 13:11:17','2016-05-19 14:39:48','2016-05-20 13:11:17'),(3,'IT','provide internet connection, solve internet issues',2,'2003-05-22',1,1,1,'2016-05-20 13:11:17','2016-05-19 14:40:32','2016-05-20 13:11:17'),(4,'Truck transportation','',2,'2016-07-31',4,1,3,NULL,'2016-05-23 11:38:32','2016-07-04 11:05:14'),(5,'Warehouse-Storage','Move the goods to the warehouse/storage with the truck and store them',2,'2016-05-31',4,3,3,NULL,'2016-05-23 11:40:55','2016-07-04 11:05:24'),(6,'Secretary- Info','',1,'2016-05-31',3,2,3,NULL,'2016-05-23 11:43:22','2016-05-27 11:25:18'),(7,'Organizational tasks','Organize the flow of the event, coordinate groups of people to get the job done',4,'2016-05-31',3,3,3,NULL,'2016-05-23 11:45:17','2016-05-26 08:54:18'),(8,'Ask for donations','',2,NULL,5,1,6,NULL,'2016-05-27 11:37:37','2016-05-27 11:37:48'),(9,'Φυλλάδια','',1,'2016-07-20',6,1,7,'2016-08-15 00:06:39','2016-07-06 10:34:41','2016-08-15 00:06:39'),(10,'Παρουσίαση project','',4,'2016-07-30',6,1,7,'2016-08-15 00:06:39','2016-07-06 10:39:34','2016-08-15 00:06:39'),(11,'Σχεδίαση γραφικών για παρουσίαση','',3,'2016-07-16',7,2,7,'2016-08-15 00:06:39','2016-07-06 10:55:10','2016-08-15 00:06:39');
/*!40000 ALTER TABLE `subtasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subtasks_users`
--

DROP TABLE IF EXISTS `subtasks_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subtasks_users` (
  `user_id` int(10) unsigned NOT NULL,
  `subtask_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `subtasks_users_user_id_foreign` (`user_id`),
  KEY `subtasks_users_subtask_id_foreign` (`subtask_id`),
  CONSTRAINT `subtasks_users_subtask_id_foreign` FOREIGN KEY (`subtask_id`) REFERENCES `subtasks` (`id`),
  CONSTRAINT `subtasks_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subtasks_users`
--

LOCK TABLES `subtasks_users` WRITE;
/*!40000 ALTER TABLE `subtasks_users` DISABLE KEYS */;
INSERT INTO `subtasks_users` VALUES (2,8,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `subtasks_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subtasks_volunteers`
--

DROP TABLE IF EXISTS `subtasks_volunteers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subtasks_volunteers` (
  `volunteer_id` int(10) unsigned NOT NULL,
  `subtask_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `subtasks_volunteers_volunteer_id_foreign` (`volunteer_id`),
  KEY `subtasks_volunteers_subtask_id_foreign` (`subtask_id`),
  CONSTRAINT `subtasks_volunteers_subtask_id_foreign` FOREIGN KEY (`subtask_id`) REFERENCES `subtasks` (`id`),
  CONSTRAINT `subtasks_volunteers_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subtasks_volunteers`
--

LOCK TABLES `subtasks_volunteers` WRITE;
/*!40000 ALTER TABLE `subtasks_volunteers` DISABLE KEYS */;
INSERT INTO `subtasks_volunteers` VALUES (11,4,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,5,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,6,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,7,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,9,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,10,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,11,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `subtasks_volunteers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_checklists`
--

DROP TABLE IF EXISTS `task_checklists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_checklists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comments` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `isComplete` tinyint(1) NOT NULL DEFAULT '0',
  `task_id` int(10) unsigned NOT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `task_checklists_task_id_foreign` (`task_id`),
  KEY `task_checklists_created_by_foreign` (`created_by`),
  KEY `task_checklists_updated_by_foreign` (`updated_by`),
  CONSTRAINT `task_checklists_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `task_checklists_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `task_checklists_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_checklists`
--

LOCK TABLES `task_checklists` WRITE;
/*!40000 ALTER TABLE `task_checklists` DISABLE KEYS */;
INSERT INTO `task_checklists` VALUES (1,'Bring bags',0,2,2,2,NULL,'2016-05-24 15:10:22','2016-05-24 15:10:22'),(2,'Test',0,3,2,2,NULL,'2016-05-25 10:55:24','2016-05-25 10:55:24'),(3,'Ετοιμασία Παρουσίασης',0,7,2,2,NULL,'2016-07-06 10:45:14','2016-07-06 10:45:14');
/*!40000 ALTER TABLE `task_checklists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_shifts`
--

DROP TABLE IF EXISTS `task_shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_shifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `from_hour` time DEFAULT NULL,
  `to_hour` time DEFAULT NULL,
  `comments` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `volunteer_sum` int(11) DEFAULT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `task_shifts_task_id_foreign` (`task_id`),
  CONSTRAINT `task_shifts_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_shifts`
--

LOCK TABLES `task_shifts` WRITE;
/*!40000 ALTER TABLE `task_shifts` DISABLE KEYS */;
INSERT INTO `task_shifts` VALUES (1,'2016-06-30',NULL,'12:00:00','21:00:00','04/06/1990 - 22/05/2003',4,1,NULL,'2016-05-19 14:55:05','2016-05-20 10:45:48'),(2,'2016-07-31',NULL,'21:00:00','00:00:00','transportation',50,4,NULL,'2016-05-20 13:46:31','2016-06-15 11:50:28'),(3,'2016-07-31',NULL,'18:00:00','21:00:00','Incoming Stock Storage',10,2,NULL,'2016-05-20 13:47:49','2016-06-15 11:50:06'),(4,'2016-07-31',NULL,'10:00:00','14:00:00','Secretariat-info',2,3,NULL,'2016-05-20 13:48:34','2016-06-15 11:51:00'),(5,'2016-07-31',NULL,'14:00:00','18:00:00','Secretariat-info',2,3,NULL,'2016-05-20 13:49:23','2016-06-15 11:51:18'),(6,'2016-07-31',NULL,'18:00:00','21:00:00','Secretariat-info',1,3,NULL,'2016-05-20 13:50:21','2016-06-15 11:51:35'),(7,'2016-07-20',NULL,'10:00:00','14:00:00','Κενό',2,6,'2016-07-06 10:27:01','2016-07-06 10:25:24','2016-07-06 10:27:01'),(8,'2016-07-20',NULL,'10:00:00','14:00:00','Κενό',2,6,'2016-07-06 10:27:08','2016-07-06 10:25:28','2016-07-06 10:27:08'),(9,'2016-07-20',NULL,'10:00:00','14:00:00','Περιπτερο SciFY',1,6,NULL,'2016-07-06 10:30:35','2016-07-06 10:31:26'),(10,'2016-07-20',NULL,'14:00:00','18:00:00','Περίπτερο SciFY',2,6,NULL,'2016-07-06 10:32:24','2016-07-06 10:33:00'),(11,'2016-07-17',NULL,'10:00:00','12:00:00','Μεταφορα/εγκατασταση προτζεκτορα',2,7,NULL,'2016-07-06 10:43:57','2016-07-06 10:44:34'),(12,'2016-07-18',NULL,'10:30:00','11:30:00','Υποδοχή',1,7,NULL,'2016-07-06 10:53:58','2016-07-06 10:53:58');
/*!40000 ALTER TABLE `task_shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_statuses`
--

DROP TABLE IF EXISTS `task_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_statuses`
--

LOCK TABLES `task_statuses` WRITE;
/*!40000 ALTER TABLE `task_statuses` DISABLE KEYS */;
INSERT INTO `task_statuses` VALUES (1,'To Do'),(2,'Doing'),(3,'Done');
/*!40000 ALTER TABLE `task_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isComplete` tinyint(1) NOT NULL DEFAULT '0',
  `priority` int(11) NOT NULL DEFAULT '2',
  `due_date` date DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL DEFAULT '1',
  `action_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `tasks_status_id_foreign` (`status_id`),
  KEY `tasks_action_id_foreign` (`action_id`),
  CONSTRAINT `tasks_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `tasks_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `task_statuses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,'Book bazaar','buy and sell books',0,2,'2003-05-22',1,1,'2016-05-20 13:11:17','2016-05-19 14:32:43','2016-05-20 13:11:17'),(2,'Food Collection','Collect and distribute the incoming goods, in the temporary warehouse-storage for the event',0,4,'2016-07-31',1,3,NULL,'2016-05-20 13:35:11','2016-06-15 11:48:13'),(3,'Secretariat-info','Welcome, provide information, organize event issues',0,2,'2016-07-31',1,3,NULL,'2016-05-20 13:36:44','2016-06-15 11:51:52'),(4,'Food Transportation','transport the goods after the event and store them accordingly for future distribution',0,1,'2016-07-31',1,3,NULL,'2016-05-20 13:38:44','2016-06-15 11:48:39'),(5,'Clothes collection','',0,3,NULL,1,6,NULL,'2016-05-25 11:16:32','2016-05-27 11:36:07'),(6,'Γραμματειακή υποστήριξη','',0,3,'2016-07-31',1,7,'2016-08-15 00:06:39','2016-07-06 10:21:08','2016-08-15 00:06:39'),(7,'Παρουσίαση SciFY','',0,1,'2016-07-25',1,7,'2016-08-15 00:06:39','2016-07-06 10:41:17','2016-08-15 00:06:39');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks_users`
--

DROP TABLE IF EXISTS `tasks_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks_users` (
  `user_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `tasks_users_user_id_foreign` (`user_id`),
  KEY `tasks_users_task_id_foreign` (`task_id`),
  CONSTRAINT `tasks_users_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `tasks_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks_users`
--

LOCK TABLES `tasks_users` WRITE;
/*!40000 ALTER TABLE `tasks_users` DISABLE KEYS */;
INSERT INTO `tasks_users` VALUES (2,4,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tasks_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks_volunteers`
--

DROP TABLE IF EXISTS `tasks_volunteers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks_volunteers` (
  `volunteer_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `tasks_volunteers_volunteer_id_foreign` (`volunteer_id`),
  KEY `tasks_volunteers_task_id_foreign` (`task_id`),
  CONSTRAINT `tasks_volunteers_task_id_foreign` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
  CONSTRAINT `tasks_volunteers_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks_volunteers`
--

LOCK TABLES `tasks_volunteers` WRITE;
/*!40000 ALTER TABLE `tasks_volunteers` DISABLE KEYS */;
INSERT INTO `tasks_volunteers` VALUES (8,2,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(9,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(21,6,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(22,7,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tasks_volunteers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `comments` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `level` smallint(6) DEFAULT NULL,
  `parent_unit_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `units_parent_unit_id_foreign` (`parent_unit_id`),
  CONSTRAINT `units_parent_unit_id_foreign` FOREIGN KEY (`parent_unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'Root','Root unit',NULL,NULL,'2016-05-19 13:38:28','2016-05-19 13:38:28',NULL),(2,'Programs Director','Incidunt dicta eum est eum ea. Quibusdam sequi voluptatum odio esse sunt nostrum. Voluptas sunt aspernatur voluptas similique sequi itaque vitae. Et porro aliquam est.',0,1,'2016-05-19 13:40:24','2016-05-20 12:33:37',NULL),(3,'Communications Director','Quisquam odit a dolor omnis optio. Velit in enim qui consequatur corporis dicta nam error. Culpa error inventore aut sed placeat magni.',0,1,'2016-05-19 13:40:24','2016-05-20 12:58:25',NULL),(4,'Food Distribution Department','Error ut et eos eaque reprehenderit facilis repudiandae cum. Sit voluptate natus qui non quisquam. Porro tempora aut ea quos tenetur natus. Eligendi suscipit rem ut accusantium sapiente nesciunt qui. Debitis voluptatem et in ab non qui sit.',0,2,'2016-05-19 13:40:24','2016-05-20 12:34:35',NULL),(5,'Press Office','Sed quia suscipit ut sequi eius vero consectetur. Ipsa est velit aliquid amet at quas et. Corporis veniam dolores sit. Natus minus quae tempore autem.',0,3,'2016-05-19 13:40:24','2016-08-15 00:06:00','2016-08-15 00:06:00'),(6,'Wunsch-Donnelly','Nemo veniam sapiente voluptatem exercitationem amet et impedit. Nostrum assumenda fugiat neque rerum. Neque odit reiciendis deleniti odit rerum fuga.',NULL,5,'2016-05-19 13:40:24','2016-05-20 13:15:09','2016-05-20 13:15:09'),(7,'Social Media','Consequuntur maiores cupiditate id voluptatem consequatur consequatur. Assumenda necessitatibus quos omnis minus aliquam culpa. Cumque placeat veniam incidunt mollitia in quam voluptatum reiciendis.',0,3,'2016-05-19 13:40:24','2016-05-20 12:59:26',NULL),(8,'Food Warehouse-Storage Management','Tempore est necessitatibus laboriosam explicabo et error reiciendis. Quis ut qui corrupti in adipisci magnam. Ratione porro hic reprehenderit facilis sint at vero. Tempore ut temporibus eius quod laboriosam ut ut.',0,4,'2016-05-19 13:40:25','2016-05-20 12:42:01',NULL),(9,'Clothes Distribution Department','Et animi ullam rerum ea. Ad neque optio temporibus nam. Error sequi laboriosam est qui culpa incidunt est. Et est dolore reprehenderit.',0,2,'2016-05-19 13:40:25','2016-05-20 12:35:18',NULL),(10,'Medhurst, Okuneva and Quigley','Aliquid quae laborum autem qui doloremque iusto possimus. Nihil consequatur reprehenderit incidunt dignissimos provident dolorem necessitatibus iusto. Animi harum et nulla est quis at.',NULL,7,'2016-05-19 13:40:25','2016-05-20 13:14:51','2016-05-20 13:14:51'),(11,'Sanford, Rempel and Harris','Sunt quidem itaque inventore est sunt voluptatem quis quis. Corporis beatae earum odit cumque et fuga aut. Ratione facilis delectus possimus totam dolor. Expedita porro rerum ut quisquam.',NULL,10,'2016-05-19 13:40:25','2016-05-20 13:05:45','2016-05-20 13:05:45'),(12,'HR','HUMAN RESOURSES',0,1,'2016-05-20 12:32:37','2016-05-20 12:32:37',NULL),(13,'Providing Shelter Department','',0,2,'2016-05-20 12:36:58','2016-08-15 00:05:21','2016-08-15 00:05:21'),(14,'IT','',0,1,'2016-05-20 13:06:45','2016-05-20 13:06:45',NULL),(15,'Technical Support','',0,14,'2016-05-20 13:07:11','2016-05-20 13:07:11',NULL),(16,'Software Development','',0,14,'2016-05-20 13:14:28','2016-05-20 13:14:28',NULL),(17,'Ενδονοσοκομειακά Προγράμματα','Υπεύθυνη Εθελοντών',0,1,'2016-06-21 10:56:43','2016-06-21 10:58:21',NULL),(18,'Volunteers Management Department','Assigns projects to volunteers',0,12,'2016-06-23 10:42:41','2016-06-23 10:43:13',NULL),(19,'polyiatreio athens','',0,17,'2017-01-19 12:10:38','2017-01-19 12:10:38',NULL);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units_users`
--

DROP TABLE IF EXISTS `units_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units_users` (
  `user_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  KEY `units_users_user_id_foreign` (`user_id`),
  KEY `units_users_unit_id_foreign` (`unit_id`),
  CONSTRAINT `units_users_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `units_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units_users`
--

LOCK TABLES `units_users` WRITE;
/*!40000 ALTER TABLE `units_users` DISABLE KEYS */;
INSERT INTO `units_users` VALUES (1,1),(2,1),(2,19);
/*!40000 ALTER TABLE `units_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units_volunteers`
--

DROP TABLE IF EXISTS `units_volunteers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units_volunteers` (
  `volunteer_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  KEY `units_volunteers_volunteer_id_foreign` (`volunteer_id`),
  KEY `units_volunteers_unit_id_foreign` (`unit_id`),
  CONSTRAINT `units_volunteers_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  CONSTRAINT `units_volunteers_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units_volunteers`
--

LOCK TABLES `units_volunteers` WRITE;
/*!40000 ALTER TABLE `units_volunteers` DISABLE KEYS */;
/*!40000 ALTER TABLE `units_volunteers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `level` smallint(6) DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `addr` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin',NULL,'test@scify.org','$2y$10$dDKDgQynqeM/hjQXWvViN.WS69YS2hfU2UZ1OmRBSYbroJxnusnG6',NULL,'','Αμφικτύονος 17, Θησείο, 11851, Αθήνα','2114004192','FuMUed5SyWtJxduRQlfeFeDl7bgQnWy3K9XCGqtfoNZNkgHaJl2IsuTGjbYg',NULL,'2016-05-19 13:38:28','2016-11-02 14:53:30'),(2,'demo','demo','demo@scify.org','$2y$10$oeIKQ0X8iYh/NfgnoHpjeumdClmCitaQQFa6wWB9lCNnuSTWqwInC',NULL,'','demo','demo','lt1eEudkYHu30hJvDskxbp8nwrFVYkxaaoUBilV2O92IJAIpL4acx5iukTim',NULL,'2016-05-19 13:38:29','2017-11-23 10:00:00'),(3,'Bill','Blanks','bblanks@blanks.com','$2y$10$9qxedCt7.Fyshh5LCd6pguSbf756uoP5U8xVNHS6O/n7G9R1lY0XC',NULL,'','','691234567',NULL,NULL,'2016-06-23 11:37:08','2016-06-23 11:37:08');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_roles` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `users_roles_user_id_foreign` (`user_id`),
  KEY `users_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `users_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  CONSTRAINT `users_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_roles`
--

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;
INSERT INTO `users_roles` VALUES (1,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,3,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_action_history`
--

DROP TABLE IF EXISTS `volunteer_action_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_action_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `created` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_action_history_action_id_foreign` (`action_id`),
  KEY `volunteer_action_history_user_id_foreign` (`user_id`),
  KEY `volunteer_action_history_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `volunteer_action_history_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `volunteer_action_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `volunteer_action_history_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_action_history`
--

LOCK TABLES `volunteer_action_history` WRITE;
/*!40000 ALTER TABLE `volunteer_action_history` DISABLE KEYS */;
INSERT INTO `volunteer_action_history` VALUES (1,3,2,8,'2016-05-23','2016-05-23 11:28:11','2016-05-23 11:28:11'),(2,3,2,11,'2016-05-23','2016-05-23 11:36:39','2016-05-23 11:36:39'),(3,3,2,9,'2016-05-23','2016-05-23 11:55:21','2016-05-23 11:55:21'),(4,3,2,6,'2016-05-23','2016-05-23 11:55:21','2016-05-23 11:55:21'),(5,3,2,4,'2016-05-23','2016-05-23 11:55:21','2016-05-23 11:55:21'),(6,3,2,10,'2016-05-23','2016-05-23 11:55:58','2016-05-23 11:55:58'),(7,3,2,1,'2016-05-23','2016-05-23 11:57:36','2016-05-23 11:57:36'),(8,3,2,7,'2016-05-23','2016-05-23 12:03:40','2016-05-23 12:03:40'),(9,3,2,6,'2016-05-23','2016-05-23 12:10:44','2016-05-23 12:10:44'),(10,7,2,22,'2016-07-06','2016-07-06 10:31:27','2016-07-06 10:31:27'),(11,7,2,21,'2016-07-06','2016-07-06 10:44:35','2016-07-06 10:44:35');
/*!40000 ALTER TABLE `volunteer_action_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_action_ratings`
--

DROP TABLE IF EXISTS `volunteer_action_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_action_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comments` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `minutes` int(11) DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `action_rating_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_action_ratings_user_id_foreign` (`user_id`),
  KEY `volunteer_action_ratings_action_rating_id_foreign` (`action_rating_id`),
  KEY `volunteer_action_ratings_volunteer_id_index` (`volunteer_id`),
  CONSTRAINT `volunteer_action_ratings_action_rating_id_foreign` FOREIGN KEY (`action_rating_id`) REFERENCES `action_ratings` (`id`),
  CONSTRAINT `volunteer_action_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `volunteer_action_ratings_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_action_ratings`
--

LOCK TABLES `volunteer_action_ratings` WRITE;
/*!40000 ALTER TABLE `volunteer_action_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_action_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_availability_times`
--

DROP TABLE IF EXISTS `volunteer_availability_times`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_availability_times` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` int(10) unsigned NOT NULL,
  `availability_time_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_availability_times_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_availability_times_availability_time_id_foreign` (`availability_time_id`),
  CONSTRAINT `volunteer_availability_times_availability_time_id_foreign` FOREIGN KEY (`availability_time_id`) REFERENCES `availability_time` (`id`),
  CONSTRAINT `volunteer_availability_times_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_availability_times`
--

LOCK TABLES `volunteer_availability_times` WRITE;
/*!40000 ALTER TABLE `volunteer_availability_times` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_availability_times` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_blacklisted`
--

DROP TABLE IF EXISTS `volunteer_blacklisted`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_blacklisted` (
  `volunteer_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `volunteer_blacklisted_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `volunteer_blacklisted_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_blacklisted`
--

LOCK TABLES `volunteer_blacklisted` WRITE;
/*!40000 ALTER TABLE `volunteer_blacklisted` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_blacklisted` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_extras`
--

DROP TABLE IF EXISTS `volunteer_extras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_extras` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `knows_word` tinyint(1) DEFAULT '0',
  `knows_excel` tinyint(1) DEFAULT '0',
  `knows_powerpoint` tinyint(1) DEFAULT '0',
  `has_previous_volunteer_experience` tinyint(1) DEFAULT '0',
  `has_previous_work_experience` tinyint(1) DEFAULT '0',
  `volunteering_work_extra` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_department` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_extras_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `volunteer_extras_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_extras`
--

LOCK TABLES `volunteer_extras` WRITE;
/*!40000 ALTER TABLE `volunteer_extras` DISABLE KEYS */;
INSERT INTO `volunteer_extras` VALUES (1,NULL,NULL,NULL,0,0,NULL,'',11,NULL,'2016-05-23 11:32:01','2016-05-23 11:32:01'),(2,NULL,NULL,NULL,0,0,NULL,'',12,NULL,'2016-05-27 11:17:40','2016-05-27 11:17:40'),(3,NULL,NULL,NULL,0,0,NULL,'',13,NULL,'2016-05-27 13:13:49','2016-06-23 10:48:07'),(4,NULL,NULL,NULL,0,0,NULL,'',14,NULL,'2016-05-31 10:46:32','2016-05-31 10:46:32'),(5,NULL,NULL,NULL,0,0,NULL,'',15,NULL,'2016-06-02 12:26:55','2016-06-02 12:26:55'),(6,NULL,NULL,NULL,0,0,NULL,'',16,NULL,'2016-06-23 10:59:01','2016-06-23 10:59:55'),(7,NULL,NULL,NULL,0,0,NULL,'',17,NULL,'2016-06-23 11:20:53','2016-06-23 11:20:53'),(8,NULL,NULL,NULL,0,0,NULL,'',18,NULL,'2016-06-23 13:20:26','2016-06-23 13:20:26'),(9,NULL,NULL,NULL,0,0,NULL,'',19,NULL,'2016-06-27 11:27:06','2016-06-27 11:27:06'),(10,NULL,NULL,NULL,0,0,NULL,'',20,NULL,'2016-06-27 12:38:41','2016-06-27 12:38:41'),(11,NULL,NULL,NULL,0,0,NULL,'',21,NULL,'2016-06-29 11:14:43','2016-06-29 11:14:43'),(12,NULL,NULL,NULL,0,0,NULL,'',2,NULL,'2016-07-01 21:33:32','2016-07-01 21:33:32'),(13,NULL,NULL,NULL,0,0,NULL,'',22,NULL,'2016-07-04 10:57:24','2016-07-04 10:57:24'),(14,NULL,NULL,NULL,0,0,NULL,'',23,NULL,'2017-01-19 12:22:55','2017-04-26 10:43:25'),(15,1,1,NULL,1,1,NULL,'Zusätzlich zu meinen Recherchefähigkeiten, bin ich handwerklich begabt und will bei diversen Installationen und bei dem Aufbau von Projekten tätig sein.',24,NULL,'2017-01-24 09:58:20','2017-01-26 20:14:01');
/*!40000 ALTER TABLE `volunteer_extras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_files`
--

DROP TABLE IF EXISTS `volunteer_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_files_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `volunteer_files_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_files`
--

LOCK TABLES `volunteer_files` WRITE;
/*!40000 ALTER TABLE `volunteer_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_interests`
--

DROP TABLE IF EXISTS `volunteer_interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_interests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` int(10) unsigned NOT NULL,
  `interest_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_interests_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_interests_interest_id_foreign` (`interest_id`),
  CONSTRAINT `volunteer_interests_interest_id_foreign` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`id`),
  CONSTRAINT `volunteer_interests_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_interests`
--

LOCK TABLES `volunteer_interests` WRITE;
/*!40000 ALTER TABLE `volunteer_interests` DISABLE KEYS */;
INSERT INTO `volunteer_interests` VALUES (1,16,2),(2,16,6),(3,16,7),(4,24,1),(5,24,2),(6,24,4),(7,24,5),(8,24,6);
/*!40000 ALTER TABLE `volunteer_interests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_languages`
--

DROP TABLE IF EXISTS `volunteer_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_languages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `volunteer_id` int(10) unsigned NOT NULL,
  `language_id` int(10) unsigned NOT NULL,
  `language_level_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_languages_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_languages_language_id_foreign` (`language_id`),
  KEY `volunteer_languages_language_level_id_foreign` (`language_level_id`),
  CONSTRAINT `volunteer_languages_language_id_foreign` FOREIGN KEY (`language_id`) REFERENCES `languages` (`id`),
  CONSTRAINT `volunteer_languages_language_level_id_foreign` FOREIGN KEY (`language_level_id`) REFERENCES `language_levels` (`id`),
  CONSTRAINT `volunteer_languages_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_languages`
--

LOCK TABLES `volunteer_languages` WRITE;
/*!40000 ALTER TABLE `volunteer_languages` DISABLE KEYS */;
INSERT INTO `volunteer_languages` VALUES (4,'2016-06-23 10:59:55','2016-06-23 10:59:55',16,1,4),(5,'2016-06-23 10:59:55','2016-06-23 10:59:55',16,2,3),(6,'2016-06-23 10:59:55','2016-06-23 10:59:55',16,4,1),(16,'2017-01-26 20:14:01','2017-01-26 20:14:01',24,2,3),(17,'2017-01-26 20:14:01','2017-01-26 20:14:01',24,3,2),(18,'2017-01-26 20:14:01','2017-01-26 20:14:01',24,5,4),(19,'2017-04-26 10:43:24','2017-04-26 10:43:24',23,1,3),(20,'2017-04-26 10:43:24','2017-04-26 10:43:24',23,2,1),(21,'2017-04-26 10:43:24','2017-04-26 10:43:24',23,3,3),(22,'2017-04-26 10:43:24','2017-04-26 10:43:24',23,4,4),(23,'2017-04-26 10:43:24','2017-04-26 10:43:24',23,5,1);
/*!40000 ALTER TABLE `volunteer_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_opa_interpersonal_skills`
--

DROP TABLE IF EXISTS `volunteer_opa_interpersonal_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_opa_interpersonal_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `needsImprovement` int(11) DEFAULT NULL,
  `intp_skill_id` int(10) unsigned NOT NULL,
  `opa_rating_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_opa_interpersonal_skills_intp_skill_id_foreign` (`intp_skill_id`),
  KEY `volunteer_opa_interpersonal_skills_opa_rating_id_foreign` (`opa_rating_id`),
  CONSTRAINT `volunteer_opa_interpersonal_skills_intp_skill_id_foreign` FOREIGN KEY (`intp_skill_id`) REFERENCES `opa_interpersonal_skills` (`id`),
  CONSTRAINT `volunteer_opa_interpersonal_skills_opa_rating_id_foreign` FOREIGN KEY (`opa_rating_id`) REFERENCES `volunteer_opa_ratings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_opa_interpersonal_skills`
--

LOCK TABLES `volunteer_opa_interpersonal_skills` WRITE;
/*!40000 ALTER TABLE `volunteer_opa_interpersonal_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_opa_interpersonal_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_opa_labor_skills`
--

DROP TABLE IF EXISTS `volunteer_opa_labor_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_opa_labor_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `needsImprovement` int(11) DEFAULT NULL,
  `labor_skill_id` int(10) unsigned NOT NULL,
  `opa_rating_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_opa_labor_skills_labor_skill_id_foreign` (`labor_skill_id`),
  KEY `volunteer_opa_labor_skills_opa_rating_id_foreign` (`opa_rating_id`),
  CONSTRAINT `volunteer_opa_labor_skills_labor_skill_id_foreign` FOREIGN KEY (`labor_skill_id`) REFERENCES `opa_labor_skills` (`id`),
  CONSTRAINT `volunteer_opa_labor_skills_opa_rating_id_foreign` FOREIGN KEY (`opa_rating_id`) REFERENCES `volunteer_opa_ratings` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_opa_labor_skills`
--

LOCK TABLES `volunteer_opa_labor_skills` WRITE;
/*!40000 ALTER TABLE `volunteer_opa_labor_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_opa_labor_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_opa_ratings`
--

DROP TABLE IF EXISTS `volunteer_opa_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_opa_ratings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `actionDescription` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `problemsOccured` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fieldsToImprove` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `training` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `objectives` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `support` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `generalComments` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `action_id` int(10) unsigned NOT NULL,
  `action_rating_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_opa_ratings_user_id_foreign` (`user_id`),
  KEY `volunteer_opa_ratings_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_opa_ratings_action_id_foreign` (`action_id`),
  KEY `volunteer_opa_ratings_action_rating_id_foreign` (`action_rating_id`),
  CONSTRAINT `volunteer_opa_ratings_action_id_foreign` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  CONSTRAINT `volunteer_opa_ratings_action_rating_id_foreign` FOREIGN KEY (`action_rating_id`) REFERENCES `action_ratings` (`id`),
  CONSTRAINT `volunteer_opa_ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `volunteer_opa_ratings_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_opa_ratings`
--

LOCK TABLES `volunteer_opa_ratings` WRITE;
/*!40000 ALTER TABLE `volunteer_opa_ratings` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_opa_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_status_duration`
--

DROP TABLE IF EXISTS `volunteer_status_duration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_status_duration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_status_duration_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_status_duration_status_id_foreign` (`status_id`),
  CONSTRAINT `volunteer_status_duration_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `volunteer_statuses` (`id`),
  CONSTRAINT `volunteer_status_duration_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_status_duration`
--

LOCK TABLES `volunteer_status_duration` WRITE;
/*!40000 ALTER TABLE `volunteer_status_duration` DISABLE KEYS */;
INSERT INTO `volunteer_status_duration` VALUES (1,'2016-05-27','2016-05-31','',9,4,'2016-05-27 11:25:57','2016-05-27 11:26:11','2016-05-27 11:26:11');
/*!40000 ALTER TABLE `volunteer_status_duration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_statuses`
--

DROP TABLE IF EXISTS `volunteer_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_statuses`
--

LOCK TABLES `volunteer_statuses` WRITE;
/*!40000 ALTER TABLE `volunteer_statuses` DISABLE KEYS */;
INSERT INTO `volunteer_statuses` VALUES (1,'Pending'),(2,'Available'),(3,'Active'),(4,'Not available'),(5,'Blacklisted');
/*!40000 ALTER TABLE `volunteer_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_step_history`
--

DROP TABLE IF EXISTS `volunteer_step_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_step_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `step_id` int(10) unsigned NOT NULL,
  `previous_step_status_id` int(10) unsigned NOT NULL,
  `new_step_status_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_step_history_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_step_history_step_id_foreign` (`step_id`),
  KEY `volunteer_step_history_previous_step_status_id_foreign` (`previous_step_status_id`),
  KEY `volunteer_step_history_new_step_status_id_foreign` (`new_step_status_id`),
  CONSTRAINT `volunteer_step_history_new_step_status_id_foreign` FOREIGN KEY (`new_step_status_id`) REFERENCES `step_statuses` (`id`),
  CONSTRAINT `volunteer_step_history_previous_step_status_id_foreign` FOREIGN KEY (`previous_step_status_id`) REFERENCES `step_statuses` (`id`),
  CONSTRAINT `volunteer_step_history_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`),
  CONSTRAINT `volunteer_step_history_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_step_history`
--

LOCK TABLES `volunteer_step_history` WRITE;
/*!40000 ALTER TABLE `volunteer_step_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteer_step_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_step_status`
--

DROP TABLE IF EXISTS `volunteer_step_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_step_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comments` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assignedTo` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `step_id` int(10) unsigned NOT NULL,
  `step_status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_step_status_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_step_status_step_id_foreign` (`step_id`),
  KEY `volunteer_step_status_step_status_id_foreign` (`step_status_id`),
  CONSTRAINT `volunteer_step_status_step_id_foreign` FOREIGN KEY (`step_id`) REFERENCES `steps` (`id`),
  CONSTRAINT `volunteer_step_status_step_status_id_foreign` FOREIGN KEY (`step_status_id`) REFERENCES `step_statuses` (`id`),
  CONSTRAINT `volunteer_step_status_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_step_status`
--

LOCK TABLES `volunteer_step_status` WRITE;
/*!40000 ALTER TABLE `volunteer_step_status` DISABLE KEYS */;
INSERT INTO `volunteer_step_status` VALUES (1,NULL,'Ενδονοσοκομειακά Προγράμματα','unit',9,1,1,'2016-05-20 14:03:20','2017-01-19 12:25:33',NULL),(2,NULL,'Food Distribution Department','unit',9,2,1,'2016-05-20 14:03:20','2016-06-23 13:23:42',NULL),(3,NULL,'Social Media','unit',9,3,1,'2016-05-20 14:03:20','2016-07-06 10:22:42',NULL),(4,NULL,'Food Distribution Department','unit',9,4,1,'2016-05-20 14:03:53','2016-05-26 08:46:44',NULL),(5,NULL,'','',9,5,1,'2016-05-20 14:03:53','2016-05-20 14:23:31',NULL),(6,NULL,NULL,NULL,9,6,2,'2016-05-20 14:03:53','2016-05-20 14:03:53',NULL),(7,NULL,'','',9,10,1,'2016-05-20 14:23:48','2016-05-20 14:24:08',NULL),(8,NULL,'','',9,11,1,'2016-05-20 14:23:48','2016-05-20 14:24:14',NULL),(9,NULL,NULL,NULL,9,12,2,'2016-05-20 14:23:48','2016-05-20 14:23:48',NULL),(10,NULL,'','',9,22,1,'2016-05-20 14:24:25','2016-05-20 14:24:34',NULL),(11,NULL,'','',9,23,1,'2016-05-20 14:24:25','2016-05-20 14:24:40',NULL),(12,NULL,'HR','unit',9,24,1,'2016-05-20 14:24:25','2016-06-23 10:54:09',NULL),(13,NULL,'','',6,1,1,'2016-05-23 11:01:24','2016-05-23 11:01:34',NULL),(14,NULL,'','',6,2,1,'2016-05-23 11:01:24','2016-05-23 11:01:40',NULL),(15,NULL,NULL,NULL,6,3,2,'2016-05-23 11:01:24','2016-05-23 11:01:24',NULL),(16,NULL,'','',6,4,1,'2016-05-23 11:01:46','2016-05-23 11:02:04',NULL),(17,NULL,'','',6,5,1,'2016-05-23 11:01:46','2016-05-23 11:02:09',NULL),(18,NULL,NULL,NULL,6,6,2,'2016-05-23 11:01:46','2016-05-23 11:01:46',NULL),(19,NULL,'','',6,10,1,'2016-05-23 11:02:20','2016-05-23 11:02:39',NULL),(20,NULL,'','',6,11,1,'2016-05-23 11:02:20','2016-05-23 11:02:44',NULL),(21,NULL,NULL,NULL,6,12,2,'2016-05-23 11:02:20','2016-05-23 11:02:20',NULL),(22,NULL,'','',6,22,1,'2016-05-23 11:02:54','2016-05-23 11:03:05',NULL),(23,NULL,'','',6,23,1,'2016-05-23 11:02:54','2016-05-23 11:03:11',NULL),(24,NULL,'Food Warehouse-Storage Management','unit',6,24,1,'2016-05-23 11:02:54','2016-05-23 11:03:18',NULL),(25,NULL,'','',7,1,1,'2016-05-23 11:03:32','2016-05-23 11:03:39',NULL),(26,NULL,'','',7,2,1,'2016-05-23 11:03:32','2016-05-23 11:03:45',NULL),(27,NULL,NULL,NULL,7,3,2,'2016-05-23 11:03:32','2016-05-23 11:03:32',NULL),(28,NULL,'','',7,4,1,'2016-05-23 11:03:53','2016-05-23 11:03:59',NULL),(29,NULL,'','',7,5,1,'2016-05-23 11:03:54','2016-05-23 11:04:05',NULL),(30,NULL,NULL,NULL,7,6,2,'2016-05-23 11:03:54','2016-05-23 11:03:54',NULL),(31,NULL,'','',7,10,1,'2016-05-23 11:04:13','2016-05-23 11:04:20',NULL),(32,NULL,'','',7,11,1,'2016-05-23 11:04:13','2016-05-23 11:04:26',NULL),(33,NULL,NULL,NULL,7,12,2,'2016-05-23 11:04:13','2016-05-23 11:04:13',NULL),(34,NULL,'','',7,22,1,'2016-05-23 11:04:33','2016-05-23 11:04:38',NULL),(35,NULL,'','',7,23,1,'2016-05-23 11:04:33','2016-05-23 11:04:44',NULL),(36,NULL,'Food Warehouse-Storage Management','unit',7,24,1,'2016-05-23 11:04:33','2016-05-23 11:04:51',NULL),(37,NULL,'','',10,1,1,'2016-05-23 11:05:00','2016-05-23 11:05:06',NULL),(38,NULL,'','',10,2,1,'2016-05-23 11:05:00','2016-05-23 11:05:21',NULL),(39,NULL,NULL,NULL,10,3,2,'2016-05-23 11:05:00','2016-05-23 11:05:00',NULL),(40,NULL,'','',10,4,1,'2016-05-23 11:05:27','2016-05-23 11:05:33',NULL),(41,NULL,'','',10,5,1,'2016-05-23 11:05:28','2016-05-23 11:05:41',NULL),(42,NULL,NULL,NULL,10,6,2,'2016-05-23 11:05:28','2016-05-23 11:05:28',NULL),(43,NULL,'','',10,10,1,'2016-05-23 11:05:48','2016-05-23 11:05:58',NULL),(44,NULL,'','',10,11,1,'2016-05-23 11:05:49','2016-05-23 11:06:04',NULL),(45,NULL,NULL,NULL,10,12,2,'2016-05-23 11:05:49','2016-05-23 11:05:49',NULL),(46,NULL,'','',10,22,1,'2016-05-23 11:06:12','2016-05-23 11:06:18',NULL),(47,NULL,'','',10,23,1,'2016-05-23 11:06:12','2016-05-23 11:06:25',NULL),(48,NULL,'Food Warehouse-Storage Management','unit',10,24,1,'2016-05-23 11:06:12','2016-05-23 11:06:32',NULL),(49,NULL,'','',4,1,1,'2016-05-23 11:06:41','2016-05-23 11:06:49',NULL),(50,NULL,'','',4,2,1,'2016-05-23 11:06:41','2016-05-23 11:06:56',NULL),(51,NULL,NULL,NULL,4,3,2,'2016-05-23 11:06:41','2016-05-23 11:06:41',NULL),(52,NULL,'','',4,4,1,'2016-05-23 11:16:06','2016-05-23 11:16:13',NULL),(53,NULL,'','',4,5,1,'2016-05-23 11:16:06','2016-05-23 11:16:19',NULL),(54,NULL,NULL,NULL,4,6,2,'2016-05-23 11:16:06','2016-05-23 11:16:06',NULL),(55,NULL,'','',4,10,1,'2016-05-23 11:16:26','2016-05-23 11:16:35',NULL),(56,NULL,'','',4,11,1,'2016-05-23 11:16:26','2016-05-23 11:16:42',NULL),(57,NULL,NULL,NULL,4,12,2,'2016-05-23 11:16:26','2016-05-23 11:16:26',NULL),(58,NULL,'','',4,22,1,'2016-05-23 11:16:48','2016-05-23 11:16:57',NULL),(59,NULL,'','',4,23,1,'2016-05-23 11:16:48','2016-05-23 11:17:03',NULL),(60,NULL,'Food Warehouse-Storage Management','unit',4,24,1,'2016-05-23 11:16:48','2016-05-23 11:17:11',NULL),(61,NULL,'','',1,1,1,'2016-05-23 11:17:37','2016-05-23 11:21:37',NULL),(62,NULL,'','',1,2,1,'2016-05-23 11:17:37','2016-05-23 11:21:44',NULL),(63,NULL,NULL,NULL,1,3,2,'2016-05-23 11:17:37','2016-05-23 11:17:37',NULL),(64,NULL,'','',1,4,1,'2016-05-23 11:21:50','2016-05-23 11:22:24',NULL),(65,NULL,'','',1,5,1,'2016-05-23 11:21:50','2016-05-23 11:22:30',NULL),(66,NULL,NULL,NULL,1,6,2,'2016-05-23 11:21:50','2016-05-23 11:21:50',NULL),(67,NULL,'','',1,10,1,'2016-05-23 11:22:38','2016-05-23 11:22:45',NULL),(68,NULL,'','',1,11,1,'2016-05-23 11:22:38','2016-05-23 11:22:51',NULL),(69,NULL,NULL,NULL,1,12,2,'2016-05-23 11:22:39','2016-05-23 11:22:39',NULL),(70,NULL,'','',1,22,1,'2016-05-23 11:22:58','2016-05-23 11:23:04',NULL),(71,NULL,'','',1,23,1,'2016-05-23 11:22:58','2016-05-23 11:23:10',NULL),(72,NULL,'Food Warehouse-Storage Management','unit',1,24,1,'2016-05-23 11:22:58','2016-05-23 11:23:24',NULL),(73,NULL,'','',8,1,1,'2016-05-23 11:23:37','2016-05-23 11:23:44',NULL),(74,NULL,'','',8,2,1,'2016-05-23 11:23:37','2016-05-23 11:23:50',NULL),(75,NULL,NULL,NULL,8,3,2,'2016-05-23 11:23:37','2016-05-23 11:23:37',NULL),(76,NULL,'','',8,4,1,'2016-05-23 11:23:57','2016-05-23 11:24:09',NULL),(77,NULL,'','',8,5,1,'2016-05-23 11:23:57','2016-05-23 11:24:16',NULL),(78,NULL,NULL,NULL,8,6,2,'2016-05-23 11:23:57','2016-05-23 11:23:57',NULL),(79,NULL,'','',8,10,1,'2016-05-23 11:24:24','2016-05-23 11:24:36',NULL),(80,NULL,'','',8,11,1,'2016-05-23 11:24:24','2016-05-23 11:24:46',NULL),(81,NULL,NULL,NULL,8,12,2,'2016-05-23 11:24:24','2016-05-23 11:24:24',NULL),(82,NULL,'','',8,22,1,'2016-05-23 11:26:31','2016-05-23 11:27:25',NULL),(83,NULL,'','',8,23,1,'2016-05-23 11:26:31','2016-05-23 11:27:33',NULL),(84,NULL,'Food Warehouse-Storage Management','unit',8,24,1,'2016-05-23 11:26:31','2016-05-23 11:27:48',NULL),(85,NULL,'','',11,1,1,'2016-05-23 11:32:14','2016-05-23 11:32:20',NULL),(86,NULL,'','',11,2,1,'2016-05-23 11:32:14','2016-05-23 11:34:57',NULL),(87,NULL,NULL,NULL,11,3,2,'2016-05-23 11:32:14','2016-05-23 11:32:14',NULL),(88,NULL,'','',11,4,1,'2016-05-23 11:35:07','2016-05-23 11:35:16',NULL),(89,NULL,'','',11,5,1,'2016-05-23 11:35:07','2016-05-23 11:35:22',NULL),(90,NULL,NULL,NULL,11,6,2,'2016-05-23 11:35:07','2016-05-23 11:35:07',NULL),(91,NULL,'','',11,10,1,'2016-05-23 11:35:30','2016-05-23 11:35:36',NULL),(92,NULL,'','',11,11,1,'2016-05-23 11:35:30','2016-05-23 11:35:42',NULL),(93,NULL,NULL,NULL,11,12,2,'2016-05-23 11:35:30','2016-05-23 11:35:30',NULL),(94,NULL,'','',11,22,1,'2016-05-23 11:35:49','2016-05-23 11:35:55',NULL),(95,NULL,'','',11,23,1,'2016-05-23 11:35:49','2016-05-23 11:36:21',NULL),(96,NULL,'Food Warehouse-Storage Management','unit',11,24,1,'2016-05-23 11:35:49','2016-05-23 11:36:30',NULL),(97,NULL,'','',3,1,1,'2016-05-25 11:16:58','2016-05-25 11:17:12',NULL),(98,NULL,'','',3,2,1,'2016-05-25 11:16:58','2016-05-25 11:17:18',NULL),(99,NULL,NULL,NULL,3,3,2,'2016-05-25 11:16:58','2016-05-25 11:16:58',NULL),(100,NULL,'','',3,4,1,'2016-05-25 11:17:43','2016-05-25 11:17:56',NULL),(101,NULL,'','',3,5,1,'2016-05-25 11:17:43','2016-05-25 11:18:02',NULL),(102,NULL,NULL,NULL,3,6,2,'2016-05-25 11:17:43','2016-05-25 11:17:43',NULL),(103,NULL,'','',3,10,1,'2016-05-26 08:44:35','2016-05-26 08:44:48',NULL),(104,NULL,'','',3,11,1,'2016-05-26 08:44:35','2016-05-26 08:44:54',NULL),(105,NULL,NULL,NULL,3,12,2,'2016-05-26 08:44:35','2016-05-26 08:44:35',NULL),(106,NULL,'','',12,1,1,'2016-05-27 11:18:07','2016-05-27 11:18:21',NULL),(107,NULL,'Μια χαρά η Μαρία','',12,2,1,'2016-05-27 11:18:07','2016-05-27 11:18:46',NULL),(108,NULL,NULL,NULL,12,3,2,'2016-05-27 11:18:07','2016-05-27 11:18:07',NULL),(109,NULL,NULL,NULL,12,34,2,'2016-05-27 11:19:10','2016-05-27 11:19:10',NULL),(110,NULL,NULL,NULL,12,35,2,'2016-05-27 11:19:10','2016-05-27 11:19:10',NULL),(111,NULL,NULL,NULL,12,36,2,'2016-05-27 11:19:10','2016-05-27 11:19:10',NULL),(112,NULL,'rdv','',13,1,1,'2016-05-27 13:14:47','2016-05-27 13:15:48',NULL),(113,NULL,'','',13,2,1,'2016-05-27 13:14:47','2016-05-27 13:16:22',NULL),(114,NULL,NULL,NULL,13,3,2,'2016-05-27 13:14:47','2016-05-27 13:14:47',NULL),(115,NULL,'','',13,34,1,'2016-05-27 13:16:35','2016-06-23 10:48:26',NULL),(116,NULL,'','',13,35,1,'2016-05-27 13:16:35','2016-06-23 10:54:01',NULL),(117,NULL,NULL,NULL,13,36,2,'2016-05-27 13:16:35','2016-05-27 13:16:35',NULL),(118,NULL,'','',14,1,1,'2016-05-31 10:47:41','2016-05-31 10:48:43',NULL),(119,NULL,'','',14,2,1,'2016-05-31 10:47:41','2016-05-31 10:49:43',NULL),(120,NULL,NULL,NULL,14,3,2,'2016-05-31 10:47:41','2016-05-31 10:47:41',NULL),(121,NULL,'dgadfadga','',15,1,1,'2016-06-02 12:29:37','2016-06-02 12:30:25',NULL),(122,NULL,'ok','',15,2,1,'2016-06-02 12:29:37','2016-06-02 12:31:28',NULL),(123,NULL,NULL,NULL,15,3,2,'2016-06-02 12:29:37','2016-06-02 12:29:37',NULL),(124,NULL,NULL,NULL,15,34,2,'2016-06-02 12:31:45','2016-06-02 12:31:45',NULL),(125,NULL,NULL,NULL,15,35,2,'2016-06-02 12:31:45','2016-06-02 12:31:45',NULL),(126,NULL,NULL,NULL,15,36,2,'2016-06-02 12:31:46','2016-06-02 12:31:46',NULL),(127,NULL,NULL,NULL,13,7,2,'2016-06-23 10:49:15','2016-06-23 10:49:15',NULL),(128,NULL,NULL,NULL,13,8,2,'2016-06-23 10:49:15','2016-06-23 10:49:15',NULL),(129,NULL,NULL,NULL,13,9,2,'2016-06-23 10:49:15','2016-06-23 10:49:15',NULL),(130,NULL,'rant ','',17,1,1,'2016-06-23 11:21:39','2016-06-23 11:22:16',NULL),(131,NULL,'super','',17,2,1,'2016-06-23 11:21:39','2016-06-23 11:22:37',NULL),(132,NULL,NULL,NULL,17,3,2,'2016-06-23 11:21:39','2016-06-23 11:21:39',NULL),(133,NULL,NULL,NULL,17,40,2,'2016-06-23 11:23:02','2016-06-23 11:23:02',NULL),(134,NULL,NULL,NULL,17,41,2,'2016-06-23 11:23:02','2016-06-23 11:23:02',NULL),(135,NULL,NULL,NULL,17,42,2,'2016-06-23 11:23:02','2016-06-23 11:23:02',NULL),(136,NULL,'','',18,1,1,'2016-06-23 13:21:18','2016-06-23 13:21:59',NULL),(137,NULL,'','',18,2,1,'2016-06-23 13:21:18','2016-06-23 13:22:30',NULL),(138,NULL,NULL,NULL,18,3,2,'2016-06-23 13:21:18','2016-06-23 13:21:18',NULL),(139,NULL,'','',18,4,1,'2016-06-23 13:23:09','2016-06-23 13:23:26',NULL),(140,NULL,'','',18,5,1,'2016-06-23 13:23:09','2016-06-23 13:23:32',NULL),(141,NULL,NULL,NULL,18,6,2,'2016-06-23 13:23:09','2016-06-23 13:23:09',NULL),(142,NULL,NULL,NULL,18,10,2,'2016-06-23 13:23:42','2016-06-23 13:23:42',NULL),(143,NULL,NULL,NULL,18,11,2,'2016-06-23 13:23:42','2016-06-23 13:23:42',NULL),(144,NULL,NULL,NULL,18,12,2,'2016-06-23 13:23:42','2016-06-23 13:23:42',NULL),(145,NULL,'','',19,1,1,'2016-06-27 11:29:44','2016-06-27 11:31:42',NULL),(146,NULL,'','',19,2,1,'2016-06-27 11:29:44','2016-06-27 11:32:29',NULL),(147,NULL,NULL,NULL,19,3,2,'2016-06-27 11:29:44','2016-06-27 11:29:44',NULL),(148,NULL,NULL,NULL,19,49,2,'2016-06-27 11:32:34','2016-06-27 11:32:34',NULL),(149,NULL,NULL,NULL,19,50,2,'2016-06-27 11:32:34','2016-06-27 11:32:34',NULL),(150,NULL,NULL,NULL,19,51,2,'2016-06-27 11:32:34','2016-06-27 11:32:34',NULL),(151,NULL,NULL,NULL,19,40,2,'2016-06-27 11:35:42','2016-06-27 11:35:42',NULL),(152,NULL,NULL,NULL,19,41,2,'2016-06-27 11:35:42','2016-06-27 11:35:42',NULL),(153,NULL,NULL,NULL,19,42,2,'2016-06-27 11:35:42','2016-06-27 11:35:42',NULL),(154,NULL,'Μίλησα','',20,1,1,'2016-06-27 12:39:39','2016-06-27 12:40:42',NULL),(155,NULL,'','',20,2,1,'2016-06-27 12:39:39','2016-06-27 12:41:08',NULL),(156,NULL,NULL,NULL,20,3,2,'2016-06-27 12:39:39','2016-06-27 12:39:39',NULL),(157,NULL,NULL,NULL,20,34,2,'2016-06-27 12:41:45','2016-06-27 12:41:45',NULL),(158,NULL,NULL,NULL,20,35,2,'2016-06-27 12:41:45','2016-06-27 12:41:45',NULL),(159,NULL,NULL,NULL,20,36,2,'2016-06-27 12:41:45','2016-06-27 12:41:45',NULL),(160,NULL,'','',21,1,1,'2016-06-29 11:15:35','2016-06-29 11:16:18',NULL),(161,NULL,'','',21,2,1,'2016-06-29 11:15:35','2016-06-29 11:16:40',NULL),(162,NULL,NULL,NULL,21,3,2,'2016-06-29 11:15:35','2016-06-29 11:15:35',NULL),(163,NULL,'','',21,7,1,'2016-06-29 11:16:55','2016-07-06 10:22:34',NULL),(164,NULL,'','',21,8,1,'2016-06-29 11:16:55','2016-07-06 10:22:37',NULL),(165,NULL,NULL,NULL,21,9,2,'2016-06-29 11:16:55','2016-06-29 11:16:55',NULL),(166,NULL,'kjh','',22,1,1,'2016-07-04 10:59:28','2016-07-04 11:01:22',NULL),(167,NULL,'good','',22,2,1,'2016-07-04 10:59:28','2016-07-04 11:02:01',NULL),(168,NULL,NULL,NULL,22,3,2,'2016-07-04 10:59:28','2016-07-04 10:59:28',NULL),(169,NULL,'','',22,7,1,'2016-07-04 11:02:47','2016-07-06 10:22:54',NULL),(170,NULL,'','',22,8,1,'2016-07-04 11:02:47','2016-07-06 10:22:58',NULL),(171,NULL,NULL,NULL,22,9,2,'2016-07-04 11:02:47','2016-07-04 11:02:47',NULL),(172,NULL,'','',5,1,1,'2016-07-06 10:21:33','2016-07-06 10:21:37',NULL),(173,NULL,'','',5,2,1,'2016-07-06 10:21:33','2016-07-06 10:21:41',NULL),(174,NULL,NULL,NULL,5,3,2,'2016-07-06 10:21:33','2016-07-06 10:21:33',NULL),(175,NULL,NULL,NULL,5,7,2,'2016-07-06 10:22:09','2016-07-06 10:22:09',NULL),(176,NULL,NULL,NULL,5,8,2,'2016-07-06 10:22:09','2016-07-06 10:22:09',NULL),(177,NULL,NULL,NULL,5,9,2,'2016-07-06 10:22:09','2016-07-06 10:22:09',NULL),(178,NULL,NULL,NULL,21,19,2,'2016-07-06 10:22:43','2016-07-06 10:22:43',NULL),(179,NULL,NULL,NULL,21,20,2,'2016-07-06 10:22:43','2016-07-06 10:22:43',NULL),(180,NULL,NULL,NULL,21,21,2,'2016-07-06 10:22:43','2016-07-06 10:22:43',NULL),(181,NULL,NULL,NULL,22,19,2,'2016-07-06 10:23:03','2016-07-06 10:23:03',NULL),(182,NULL,NULL,NULL,22,20,2,'2016-07-06 10:23:03','2016-07-06 10:23:03',NULL),(183,NULL,NULL,NULL,22,21,2,'2016-07-06 10:23:03','2016-07-06 10:23:03',NULL),(184,NULL,NULL,NULL,2,1,2,'2016-08-10 13:13:18','2016-08-10 13:13:18',NULL),(185,NULL,NULL,NULL,2,2,2,'2016-08-10 13:13:18','2016-08-10 13:13:18',NULL),(186,NULL,NULL,NULL,2,3,2,'2016-08-10 13:13:18','2016-08-10 13:13:18',NULL),(187,NULL,NULL,NULL,16,1,2,'2016-08-31 12:22:04','2016-08-31 12:22:04',NULL),(188,NULL,NULL,NULL,16,2,2,'2016-08-31 12:22:04','2016-08-31 12:22:04',NULL),(189,NULL,NULL,NULL,16,3,2,'2016-08-31 12:22:04','2016-08-31 12:22:04',NULL),(190,NULL,'gubhubhuibh','',23,1,1,'2017-01-19 12:24:35','2017-01-19 12:25:03',NULL),(191,NULL,'jonjononompmk','',23,2,1,'2017-01-19 12:24:35','2017-01-19 12:25:17',NULL),(192,NULL,NULL,NULL,23,3,2,'2017-01-19 12:24:35','2017-01-19 12:24:35',NULL),(193,NULL,NULL,NULL,23,49,2,'2017-01-19 12:25:33','2017-01-19 12:25:33',NULL),(194,NULL,NULL,NULL,23,50,2,'2017-01-19 12:25:33','2017-01-19 12:25:33',NULL),(195,NULL,NULL,NULL,23,51,2,'2017-01-19 12:25:33','2017-01-19 12:25:33',NULL),(196,NULL,NULL,NULL,24,1,2,'2017-02-13 08:30:37','2017-02-13 08:30:37',NULL),(197,NULL,NULL,NULL,24,2,2,'2017-02-13 08:30:37','2017-02-13 08:30:37',NULL),(198,NULL,NULL,NULL,24,3,2,'2017-02-13 08:30:37','2017-02-13 08:30:37',NULL);
/*!40000 ALTER TABLE `volunteer_step_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_subtask_shift_history`
--

DROP TABLE IF EXISTS `volunteer_subtask_shift_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_subtask_shift_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` int(10) unsigned NOT NULL,
  `shift_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_subtask_shift_history_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_subtask_shift_history_shift_id_foreign` (`shift_id`),
  CONSTRAINT `volunteer_subtask_shift_history_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `subtask_shifts` (`id`),
  CONSTRAINT `volunteer_subtask_shift_history_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_subtask_shift_history`
--

LOCK TABLES `volunteer_subtask_shift_history` WRITE;
/*!40000 ALTER TABLE `volunteer_subtask_shift_history` DISABLE KEYS */;
INSERT INTO `volunteer_subtask_shift_history` VALUES (1,10,4,'2016-05-23 11:55:58','2016-05-23 11:55:58'),(2,6,5,'2016-05-23 11:57:36','2016-05-23 11:57:36'),(3,10,5,'2016-05-23 11:57:36','2016-05-23 11:57:36'),(4,1,5,'2016-05-23 11:57:36','2016-05-23 11:57:36'),(5,8,5,'2016-05-23 11:57:37','2016-05-23 11:57:37');
/*!40000 ALTER TABLE `volunteer_subtask_shift_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_subtask_shifts`
--

DROP TABLE IF EXISTS `volunteer_subtask_shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_subtask_shifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtask_shifts_id` int(10) unsigned NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_subtask_shifts_subtask_shifts_id_foreign` (`subtask_shifts_id`),
  KEY `volunteer_subtask_shifts_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `volunteer_subtask_shifts_subtask_shifts_id_foreign` FOREIGN KEY (`subtask_shifts_id`) REFERENCES `subtask_shifts` (`id`),
  CONSTRAINT `volunteer_subtask_shifts_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_subtask_shifts`
--

LOCK TABLES `volunteer_subtask_shifts` WRITE;
/*!40000 ALTER TABLE `volunteer_subtask_shifts` DISABLE KEYS */;
INSERT INTO `volunteer_subtask_shifts` VALUES (1,NULL,4,10,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,NULL,5,6,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,NULL,5,10,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,NULL,5,1,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,NULL,5,8,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `volunteer_subtask_shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_task_shift_history`
--

DROP TABLE IF EXISTS `volunteer_task_shift_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_task_shift_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` int(10) unsigned NOT NULL,
  `shift_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_task_shift_history_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_task_shift_history_shift_id_foreign` (`shift_id`),
  CONSTRAINT `volunteer_task_shift_history_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `task_shifts` (`id`),
  CONSTRAINT `volunteer_task_shift_history_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_task_shift_history`
--

LOCK TABLES `volunteer_task_shift_history` WRITE;
/*!40000 ALTER TABLE `volunteer_task_shift_history` DISABLE KEYS */;
INSERT INTO `volunteer_task_shift_history` VALUES (1,9,3,'2016-05-23 11:55:21','2016-05-23 11:55:21'),(2,6,3,'2016-05-23 11:55:21','2016-05-23 11:55:21'),(3,4,3,'2016-05-23 11:55:21','2016-05-23 11:55:21'),(4,8,3,'2016-05-23 11:55:21','2016-05-23 11:55:21'),(5,9,4,'2016-05-23 11:58:08','2016-05-23 11:58:08'),(6,11,4,'2016-05-23 11:58:33','2016-05-23 11:58:33'),(7,6,4,'2016-05-23 11:58:51','2016-05-23 11:58:51'),(8,7,4,'2016-05-23 12:03:40','2016-05-23 12:03:40'),(9,6,2,'2016-05-23 12:10:44','2016-05-23 12:10:44'),(10,22,9,'2016-07-06 10:31:26','2016-07-06 10:31:26'),(11,21,11,'2016-07-06 10:44:34','2016-07-06 10:44:34');
/*!40000 ALTER TABLE `volunteer_task_shift_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_task_shifts`
--

DROP TABLE IF EXISTS `volunteer_task_shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_task_shifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `task_shift_id` int(10) unsigned NOT NULL,
  `volunteer_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_task_shifts_task_shift_id_foreign` (`task_shift_id`),
  KEY `volunteer_task_shifts_volunteer_id_foreign` (`volunteer_id`),
  CONSTRAINT `volunteer_task_shifts_task_shift_id_foreign` FOREIGN KEY (`task_shift_id`) REFERENCES `task_shifts` (`id`),
  CONSTRAINT `volunteer_task_shifts_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_task_shifts`
--

LOCK TABLES `volunteer_task_shifts` WRITE;
/*!40000 ALTER TABLE `volunteer_task_shifts` DISABLE KEYS */;
INSERT INTO `volunteer_task_shifts` VALUES (10,NULL,9,22,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(11,NULL,11,21,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `volunteer_task_shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_unit_history`
--

DROP TABLE IF EXISTS `volunteer_unit_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_unit_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_unit_history_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_unit_history_unit_id_foreign` (`unit_id`),
  KEY `volunteer_unit_history_user_id_foreign` (`user_id`),
  CONSTRAINT `volunteer_unit_history_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `volunteer_unit_history_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `volunteer_unit_history_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_unit_history`
--

LOCK TABLES `volunteer_unit_history` WRITE;
/*!40000 ALTER TABLE `volunteer_unit_history` DISABLE KEYS */;
INSERT INTO `volunteer_unit_history` VALUES (1,9,1,2,'2016-05-20','2016-05-20 14:03:20','2016-05-20 14:03:20'),(2,9,2,2,'2016-05-20','2016-05-20 14:03:53','2016-05-20 14:03:53'),(3,9,1,2,'2016-05-20','2016-05-20 14:04:10','2016-05-20 14:04:10'),(4,9,4,2,'2016-05-20','2016-05-20 14:23:48','2016-05-20 14:23:48'),(5,9,8,2,'2016-05-20','2016-05-20 14:24:25','2016-05-20 14:24:25'),(6,6,1,2,'2016-05-23','2016-05-23 11:01:24','2016-05-23 11:01:24'),(7,6,2,2,'2016-05-23','2016-05-23 11:01:46','2016-05-23 11:01:46'),(8,6,4,2,'2016-05-23','2016-05-23 11:02:20','2016-05-23 11:02:20'),(9,6,8,2,'2016-05-23','2016-05-23 11:02:54','2016-05-23 11:02:54'),(10,7,1,2,'2016-05-23','2016-05-23 11:03:32','2016-05-23 11:03:32'),(11,7,2,2,'2016-05-23','2016-05-23 11:03:54','2016-05-23 11:03:54'),(12,7,4,2,'2016-05-23','2016-05-23 11:04:13','2016-05-23 11:04:13'),(13,7,8,2,'2016-05-23','2016-05-23 11:04:33','2016-05-23 11:04:33'),(14,10,1,2,'2016-05-23','2016-05-23 11:05:00','2016-05-23 11:05:00'),(15,10,2,2,'2016-05-23','2016-05-23 11:05:28','2016-05-23 11:05:28'),(16,10,4,2,'2016-05-23','2016-05-23 11:05:49','2016-05-23 11:05:49'),(17,10,8,2,'2016-05-23','2016-05-23 11:06:12','2016-05-23 11:06:12'),(18,4,1,2,'2016-05-23','2016-05-23 11:06:41','2016-05-23 11:06:41'),(19,4,2,2,'2016-05-23','2016-05-23 11:16:06','2016-05-23 11:16:06'),(20,4,4,2,'2016-05-23','2016-05-23 11:16:26','2016-05-23 11:16:26'),(21,4,8,2,'2016-05-23','2016-05-23 11:16:49','2016-05-23 11:16:49'),(22,1,1,2,'2016-05-23','2016-05-23 11:17:37','2016-05-23 11:17:37'),(23,1,2,2,'2016-05-23','2016-05-23 11:21:50','2016-05-23 11:21:50'),(24,1,4,2,'2016-05-23','2016-05-23 11:22:39','2016-05-23 11:22:39'),(25,1,8,2,'2016-05-23','2016-05-23 11:22:58','2016-05-23 11:22:58'),(26,8,1,2,'2016-05-23','2016-05-23 11:23:37','2016-05-23 11:23:37'),(27,8,2,2,'2016-05-23','2016-05-23 11:23:57','2016-05-23 11:23:57'),(28,8,4,2,'2016-05-23','2016-05-23 11:24:24','2016-05-23 11:24:24'),(29,8,8,2,'2016-05-23','2016-05-23 11:26:31','2016-05-23 11:26:31'),(30,11,1,2,'2016-05-23','2016-05-23 11:32:14','2016-05-23 11:32:14'),(31,11,2,2,'2016-05-23','2016-05-23 11:35:07','2016-05-23 11:35:07'),(32,11,4,2,'2016-05-23','2016-05-23 11:35:30','2016-05-23 11:35:30'),(33,11,8,2,'2016-05-23','2016-05-23 11:35:49','2016-05-23 11:35:49'),(34,3,1,2,'2016-05-25','2016-05-25 11:16:58','2016-05-25 11:16:58'),(35,3,2,2,'2016-05-25','2016-05-25 11:17:43','2016-05-25 11:17:43'),(36,3,1,2,'2016-05-26','2016-05-26 06:55:53','2016-05-26 06:55:53'),(37,3,2,2,'2016-05-26','2016-05-26 08:44:26','2016-05-26 08:44:26'),(38,3,4,2,'2016-05-26','2016-05-26 08:44:35','2016-05-26 08:44:35'),(39,3,1,2,'2016-05-26','2016-05-26 08:50:54','2016-05-26 08:50:54'),(40,3,2,2,'2016-05-26','2016-05-26 08:51:06','2016-05-26 08:51:06'),(41,12,1,2,'2016-05-27','2016-05-27 11:18:07','2016-05-27 11:18:07'),(42,12,12,2,'2016-05-27','2016-05-27 11:19:10','2016-05-27 11:19:10'),(43,13,1,2,'2016-05-27','2016-05-27 13:14:48','2016-05-27 13:14:48'),(44,13,12,2,'2016-05-27','2016-05-27 13:16:35','2016-05-27 13:16:35'),(45,14,1,2,'2016-05-31','2016-05-31 10:47:41','2016-05-31 10:47:41'),(46,15,1,2,'2016-06-02','2016-06-02 12:29:37','2016-06-02 12:29:37'),(47,15,12,2,'2016-06-02','2016-06-02 12:31:46','2016-06-02 12:31:46'),(48,13,3,2,'2016-06-23','2016-06-23 10:49:15','2016-06-23 10:49:15'),(49,17,1,2,'2016-06-23','2016-06-23 11:21:39','2016-06-23 11:21:39'),(50,17,1,2,'2016-06-23','2016-06-23 11:21:41','2016-06-23 11:21:41'),(51,17,14,2,'2016-06-23','2016-06-23 11:23:02','2016-06-23 11:23:02'),(52,18,1,2,'2016-06-23','2016-06-23 13:21:18','2016-06-23 13:21:18'),(53,18,2,2,'2016-06-23','2016-06-23 13:23:09','2016-06-23 13:23:09'),(54,18,4,2,'2016-06-23','2016-06-23 13:23:42','2016-06-23 13:23:42'),(55,19,1,2,'2016-06-27','2016-06-27 11:29:44','2016-06-27 11:29:44'),(56,19,1,2,'2016-06-27','2016-06-27 11:30:03','2016-06-27 11:30:03'),(57,19,17,2,'2016-06-27','2016-06-27 11:32:34','2016-06-27 11:32:34'),(58,20,1,2,'2016-06-27','2016-06-27 12:39:39','2016-06-27 12:39:39'),(59,20,1,2,'2016-06-27','2016-06-27 12:39:39','2016-06-27 12:39:39'),(60,20,12,2,'2016-06-27','2016-06-27 12:41:45','2016-06-27 12:41:45'),(61,21,1,2,'2016-06-29','2016-06-29 11:15:35','2016-06-29 11:15:35'),(62,21,1,2,'2016-06-29','2016-06-29 11:15:38','2016-06-29 11:15:38'),(63,21,3,2,'2016-06-29','2016-06-29 11:16:55','2016-06-29 11:16:55'),(64,22,1,2,'2016-07-04','2016-07-04 10:59:28','2016-07-04 10:59:28'),(65,22,3,2,'2016-07-04','2016-07-04 11:02:47','2016-07-04 11:02:47'),(66,5,1,2,'2016-07-06','2016-07-06 10:21:33','2016-07-06 10:21:33'),(67,5,3,2,'2016-07-06','2016-07-06 10:22:09','2016-07-06 10:22:09'),(68,21,7,2,'2016-07-06','2016-07-06 10:22:43','2016-07-06 10:22:43'),(69,22,7,2,'2016-07-06','2016-07-06 10:23:03','2016-07-06 10:23:03'),(70,2,1,2,'2016-08-10','2016-08-10 13:13:18','2016-08-10 13:13:18'),(71,16,1,2,'2016-08-31','2016-08-31 12:22:04','2016-08-31 12:22:04'),(72,23,1,2,'2017-01-19','2017-01-19 12:24:35','2017-01-19 12:24:35'),(73,23,17,2,'2017-01-19','2017-01-19 12:25:33','2017-01-19 12:25:33'),(74,24,1,2,'2017-02-13','2017-02-13 08:30:37','2017-02-13 08:30:37');
/*!40000 ALTER TABLE `volunteer_unit_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_unit_status`
--

DROP TABLE IF EXISTS `volunteer_unit_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_unit_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `volunteer_status_id` int(10) unsigned NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `volunteer_unit_status_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_unit_status_unit_id_foreign` (`unit_id`),
  KEY `volunteer_unit_status_volunteer_status_id_foreign` (`volunteer_status_id`),
  CONSTRAINT `volunteer_unit_status_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `volunteer_unit_status_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`),
  CONSTRAINT `volunteer_unit_status_volunteer_status_id_foreign` FOREIGN KEY (`volunteer_status_id`) REFERENCES `volunteer_statuses` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_unit_status`
--

LOCK TABLES `volunteer_unit_status` WRITE;
/*!40000 ALTER TABLE `volunteer_unit_status` DISABLE KEYS */;
INSERT INTO `volunteer_unit_status` VALUES (1,9,1,1,'2016-05-20 14:03:53','2016-05-20 14:03:20','2016-05-20 14:03:53'),(2,9,2,1,'2016-05-20 14:23:48','2016-05-20 14:03:53','2016-05-20 14:23:48'),(3,9,1,1,NULL,'2016-05-20 14:04:10','2016-05-20 14:04:10'),(4,9,4,1,'2016-05-20 14:24:25','2016-05-20 14:23:48','2016-05-20 14:24:25'),(5,9,8,1,'2016-05-20 14:24:52','2016-05-20 14:24:25','2016-05-20 14:24:52'),(6,9,8,2,'2016-05-23 11:55:21','2016-05-20 14:24:52','2016-05-23 11:55:21'),(7,6,1,1,'2016-05-23 11:01:46','2016-05-23 11:01:24','2016-05-23 11:01:46'),(8,6,2,1,'2016-05-23 11:02:20','2016-05-23 11:01:46','2016-05-23 11:02:20'),(9,6,4,1,'2016-05-23 11:02:54','2016-05-23 11:02:20','2016-05-23 11:02:54'),(10,6,8,1,'2016-05-23 11:03:18','2016-05-23 11:02:54','2016-05-23 11:03:18'),(11,6,8,2,'2016-05-23 11:55:21','2016-05-23 11:03:18','2016-05-23 11:55:21'),(12,7,1,1,'2016-05-23 11:03:54','2016-05-23 11:03:32','2016-05-23 11:03:54'),(13,7,2,1,'2016-05-23 11:04:13','2016-05-23 11:03:54','2016-05-23 11:04:13'),(14,7,4,1,'2016-05-23 11:04:33','2016-05-23 11:04:13','2016-05-23 11:04:33'),(15,7,8,1,'2016-05-23 11:04:51','2016-05-23 11:04:33','2016-05-23 11:04:51'),(16,7,8,2,'2016-05-23 12:03:40','2016-05-23 11:04:51','2016-05-23 12:03:40'),(17,10,1,1,'2016-05-23 11:05:28','2016-05-23 11:05:00','2016-05-23 11:05:28'),(18,10,2,1,'2016-05-23 11:05:49','2016-05-23 11:05:28','2016-05-23 11:05:49'),(19,10,4,1,'2016-05-23 11:06:12','2016-05-23 11:05:49','2016-05-23 11:06:12'),(20,10,8,1,'2016-05-23 11:06:32','2016-05-23 11:06:12','2016-05-23 11:06:32'),(21,10,8,2,'2016-05-23 11:55:58','2016-05-23 11:06:32','2016-05-23 11:55:58'),(22,4,1,1,'2016-05-23 11:16:06','2016-05-23 11:06:41','2016-05-23 11:16:06'),(23,4,2,1,'2016-05-23 11:16:26','2016-05-23 11:16:06','2016-05-23 11:16:26'),(24,4,4,1,'2016-05-23 11:16:48','2016-05-23 11:16:26','2016-05-23 11:16:48'),(25,4,8,1,'2016-05-23 11:17:12','2016-05-23 11:16:48','2016-05-23 11:17:12'),(26,4,8,2,'2016-05-23 11:55:21','2016-05-23 11:17:12','2016-05-23 11:55:21'),(27,1,1,1,'2016-05-23 11:21:50','2016-05-23 11:17:37','2016-05-23 11:21:50'),(28,1,2,1,'2016-05-23 11:22:39','2016-05-23 11:21:50','2016-05-23 11:22:39'),(29,1,4,1,'2016-05-23 11:22:58','2016-05-23 11:22:39','2016-05-23 11:22:58'),(30,1,8,1,'2016-05-23 11:23:24','2016-05-23 11:22:58','2016-05-23 11:23:24'),(31,1,8,2,'2016-05-23 11:57:36','2016-05-23 11:23:24','2016-05-23 11:57:36'),(32,8,1,1,'2016-05-23 11:23:57','2016-05-23 11:23:37','2016-05-23 11:23:57'),(33,8,2,1,'2016-05-23 11:24:24','2016-05-23 11:23:57','2016-05-23 11:24:24'),(34,8,4,1,'2016-05-23 11:26:31','2016-05-23 11:24:24','2016-05-23 11:26:31'),(35,8,8,1,'2016-05-23 11:27:48','2016-05-23 11:26:31','2016-05-23 11:27:48'),(36,8,8,2,'2016-05-23 11:28:11','2016-05-23 11:27:49','2016-05-23 11:28:11'),(37,8,8,3,'2016-06-15 11:50:07','2016-05-23 11:28:11','2016-06-15 11:50:07'),(38,11,1,1,'2016-05-23 11:35:07','2016-05-23 11:32:14','2016-05-23 11:35:07'),(39,11,2,1,'2016-05-23 11:35:30','2016-05-23 11:35:07','2016-05-23 11:35:30'),(40,11,4,1,'2016-05-23 11:35:49','2016-05-23 11:35:30','2016-05-23 11:35:49'),(41,11,8,1,'2016-05-23 11:36:30','2016-05-23 11:35:49','2016-05-23 11:36:30'),(42,11,8,2,'2016-05-23 11:36:39','2016-05-23 11:36:30','2016-05-23 11:36:39'),(43,11,8,3,'2016-05-23 11:58:51','2016-05-23 11:36:39','2016-05-23 11:58:51'),(44,9,8,3,'2016-05-23 11:58:32','2016-05-23 11:55:21','2016-05-23 11:58:32'),(45,6,8,3,'2016-05-23 12:03:40','2016-05-23 11:55:21','2016-05-23 12:03:40'),(46,4,8,3,'2016-06-15 11:50:07','2016-05-23 11:55:21','2016-06-15 11:50:07'),(47,10,8,3,NULL,'2016-05-23 11:55:58','2016-05-23 11:55:58'),(48,1,8,3,NULL,'2016-05-23 11:57:36','2016-05-23 11:57:36'),(49,9,8,2,'2016-06-15 11:50:07','2016-05-23 11:58:33','2016-06-15 11:50:07'),(50,11,8,2,NULL,'2016-05-23 11:58:51','2016-05-23 11:58:51'),(51,6,8,2,'2016-05-23 12:10:44','2016-05-23 12:03:40','2016-05-23 12:10:44'),(52,7,8,3,'2016-06-15 11:51:00','2016-05-23 12:03:40','2016-06-15 11:51:00'),(53,6,8,3,'2016-06-15 11:50:07','2016-05-23 12:10:44','2016-06-15 11:50:07'),(54,3,1,1,'2016-05-25 11:17:43','2016-05-25 11:16:58','2016-05-25 11:17:43'),(57,3,1,1,'2016-05-26 08:44:25','2016-05-26 06:55:53','2016-05-26 08:44:25'),(58,3,2,1,'2016-05-26 08:44:35','2016-05-26 08:44:25','2016-05-26 08:44:35'),(61,3,1,1,'2016-05-26 08:51:06','2016-05-26 08:50:54','2016-05-26 08:51:06'),(62,3,2,1,'2016-05-26 08:53:38','2016-05-26 08:51:06','2016-05-26 08:53:38'),(63,3,2,2,NULL,'2016-05-26 08:53:39','2016-05-26 08:53:39'),(64,12,1,1,'2016-05-27 11:19:10','2016-05-27 11:18:07','2016-05-27 11:19:10'),(65,12,12,1,NULL,'2016-05-27 11:19:10','2016-05-27 11:19:10'),(66,13,1,1,'2016-05-27 13:16:35','2016-05-27 13:14:48','2016-05-27 13:16:35'),(67,13,12,1,'2016-06-23 10:54:09','2016-05-27 13:16:35','2016-06-23 10:54:09'),(68,14,1,1,NULL,'2016-05-31 10:47:41','2016-05-31 10:47:41'),(69,15,1,1,'2016-06-02 12:31:46','2016-06-02 12:29:37','2016-06-02 12:31:46'),(70,15,12,1,NULL,'2016-06-02 12:31:46','2016-06-02 12:31:46'),(71,9,8,2,NULL,'2016-06-15 11:50:07','2016-06-15 11:50:07'),(72,6,8,2,'2016-06-15 11:50:28','2016-06-15 11:50:07','2016-06-15 11:50:28'),(73,4,8,2,NULL,'2016-06-15 11:50:07','2016-06-15 11:50:07'),(74,8,8,2,NULL,'2016-06-15 11:50:07','2016-06-15 11:50:07'),(75,6,8,2,NULL,'2016-06-15 11:50:28','2016-06-15 11:50:28'),(76,7,8,2,NULL,'2016-06-15 11:51:00','2016-06-15 11:51:00'),(78,13,12,2,NULL,'2016-06-23 10:54:09','2016-06-23 10:54:09'),(79,17,1,1,'2016-06-23 11:21:41','2016-06-23 11:21:39','2016-06-23 11:21:41'),(80,17,1,1,'2016-06-23 11:23:02','2016-06-23 11:21:41','2016-06-23 11:23:02'),(81,17,14,1,NULL,'2016-06-23 11:23:02','2016-06-23 11:23:02'),(82,18,1,1,'2016-06-23 13:23:09','2016-06-23 13:21:18','2016-06-23 13:23:09'),(83,18,2,1,'2016-06-23 13:23:42','2016-06-23 13:23:09','2016-06-23 13:23:42'),(84,18,4,1,NULL,'2016-06-23 13:23:42','2016-06-23 13:23:42'),(85,19,1,1,'2016-06-27 11:30:03','2016-06-27 11:29:44','2016-06-27 11:30:03'),(86,19,1,1,'2016-06-27 11:32:34','2016-06-27 11:30:03','2016-06-27 11:32:34'),(87,19,17,1,NULL,'2016-06-27 11:32:34','2016-06-27 11:32:34'),(88,20,1,1,'2016-06-27 12:39:39','2016-06-27 12:39:39','2016-06-27 12:39:39'),(89,20,1,1,'2016-06-27 12:41:45','2016-06-27 12:39:39','2016-06-27 12:41:45'),(90,20,12,1,NULL,'2016-06-27 12:41:45','2016-06-27 12:41:45'),(91,21,1,1,'2016-06-29 11:15:38','2016-06-29 11:15:35','2016-06-29 11:15:38'),(92,21,1,1,'2016-06-29 11:16:55','2016-06-29 11:15:38','2016-06-29 11:16:55'),(93,21,3,1,'2016-07-06 10:22:43','2016-06-29 11:16:55','2016-07-06 10:22:43'),(94,22,1,1,'2016-07-04 11:02:47','2016-07-04 10:59:28','2016-07-04 11:02:47'),(95,22,3,1,'2016-07-06 10:23:03','2016-07-04 11:02:47','2016-07-06 10:23:03'),(96,5,1,1,'2016-07-06 10:22:09','2016-07-06 10:21:33','2016-07-06 10:22:09'),(97,5,3,1,NULL,'2016-07-06 10:22:09','2016-07-06 10:22:09'),(98,21,7,1,'2016-07-06 10:44:34','2016-07-06 10:22:43','2016-07-06 10:44:34'),(99,22,7,1,'2016-07-06 10:31:27','2016-07-06 10:23:03','2016-07-06 10:31:27'),(100,22,7,3,'2016-08-15 00:06:39','2016-07-06 10:31:27','2016-08-15 00:06:39'),(101,21,7,3,'2016-08-15 00:06:39','2016-07-06 10:44:34','2016-08-15 00:06:39'),(102,2,1,1,NULL,'2016-08-10 13:13:18','2016-08-10 13:13:18'),(103,22,7,2,NULL,'2016-08-15 00:06:39','2016-08-15 00:06:39'),(104,21,7,2,NULL,'2016-08-15 00:06:39','2016-08-15 00:06:39'),(105,16,1,1,NULL,'2016-08-31 12:22:04','2016-08-31 12:22:04'),(106,23,1,1,'2017-01-19 12:25:33','2017-01-19 12:24:35','2017-01-19 12:25:33'),(107,23,17,1,NULL,'2017-01-19 12:25:33','2017-01-19 12:25:33'),(108,24,1,1,NULL,'2017-02-13 08:30:37','2017-02-13 08:30:37');
/*!40000 ALTER TABLE `volunteer_unit_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteer_volunteering_departments`
--

DROP TABLE IF EXISTS `volunteer_volunteering_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteer_volunteering_departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `volunteer_id` int(10) unsigned NOT NULL,
  `department_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `volunteer_volunteering_departments_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteer_volunteering_departments_department_id_foreign` (`department_id`),
  CONSTRAINT `volunteer_volunteering_departments_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `volunteering_departments` (`id`),
  CONSTRAINT `volunteer_volunteering_departments_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteer_volunteering_departments`
--

LOCK TABLES `volunteer_volunteering_departments` WRITE;
/*!40000 ALTER TABLE `volunteer_volunteering_departments` DISABLE KEYS */;
INSERT INTO `volunteer_volunteering_departments` VALUES (1,24,1),(2,24,2),(3,24,4),(4,24,5);
/*!40000 ALTER TABLE `volunteer_volunteering_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteering_departments`
--

DROP TABLE IF EXISTS `volunteering_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteering_departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteering_departments`
--

LOCK TABLES `volunteering_departments` WRITE;
/*!40000 ALTER TABLE `volunteering_departments` DISABLE KEYS */;
INSERT INTO `volunteering_departments` VALUES (1,'legalSupport','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,'studiesResearch','0000-00-00 00:00:00','0000-00-00 00:00:00'),(3,'consumerEducation','0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,'administrativeSupport','0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,'communication','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `volunteering_departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteers`
--

DROP TABLE IF EXISTS `volunteers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fathers_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `identification_num` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `children` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_box` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `afm` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participation_reason` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participation_previous` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `participation_actions` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_tel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_tel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cell_tel` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra_lang` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `work_description` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `specialty` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `additional_skills` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `computer_usage_comments` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `live_in_curr_country` tinyint(1) DEFAULT NULL,
  `computer_usage` tinyint(1) DEFAULT NULL,
  `comments` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `gender_id` int(10) unsigned DEFAULT NULL,
  `education_level_id` int(10) unsigned DEFAULT NULL,
  `comm_method_id` int(10) unsigned DEFAULT NULL,
  `identification_type_id` int(10) unsigned DEFAULT NULL,
  `marital_status_id` int(10) unsigned DEFAULT NULL,
  `driver_license_type_id` int(10) unsigned DEFAULT NULL,
  `availability_freqs_id` int(10) unsigned DEFAULT NULL,
  `work_status_id` int(10) unsigned DEFAULT NULL,
  `blacklisted` tinyint(1) NOT NULL DEFAULT '0',
  `not_available` tinyint(1) NOT NULL DEFAULT '0',
  `how_you_learned_id` int(10) unsigned DEFAULT NULL,
  `how_you_learned2_id` int(10) unsigned DEFAULT NULL,
  `contract_date` date DEFAULT NULL,
  `image_name` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `volunteers_email_unique` (`email`),
  KEY `volunteers_gender_id_foreign` (`gender_id`),
  KEY `volunteers_education_level_id_foreign` (`education_level_id`),
  KEY `volunteers_comm_method_id_foreign` (`comm_method_id`),
  KEY `volunteers_identification_type_id_foreign` (`identification_type_id`),
  KEY `volunteers_marital_status_id_foreign` (`marital_status_id`),
  KEY `volunteers_driver_license_type_id_foreign` (`driver_license_type_id`),
  KEY `volunteers_availability_freqs_id_foreign` (`availability_freqs_id`),
  KEY `volunteers_work_status_id_foreign` (`work_status_id`),
  KEY `volunteers_how_you_learned_id_foreign` (`how_you_learned_id`),
  KEY `volunteers_how_you_learned2_id_foreign` (`how_you_learned2_id`),
  CONSTRAINT `volunteers_availability_freqs_id_foreign` FOREIGN KEY (`availability_freqs_id`) REFERENCES `availability_freqs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_comm_method_id_foreign` FOREIGN KEY (`comm_method_id`) REFERENCES `comm_method` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_driver_license_type_id_foreign` FOREIGN KEY (`driver_license_type_id`) REFERENCES `driver_license_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_education_level_id_foreign` FOREIGN KEY (`education_level_id`) REFERENCES `education_levels` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_gender_id_foreign` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_how_you_learned2_id_foreign` FOREIGN KEY (`how_you_learned2_id`) REFERENCES `how_you_learned2` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_how_you_learned_id_foreign` FOREIGN KEY (`how_you_learned_id`) REFERENCES `how_you_learned` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_identification_type_id_foreign` FOREIGN KEY (`identification_type_id`) REFERENCES `identification_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_marital_status_id_foreign` FOREIGN KEY (`marital_status_id`) REFERENCES `marital_statuses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `volunteers_work_status_id_foreign` FOREIGN KEY (`work_status_id`) REFERENCES `work_statuses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteers`
--

LOCK TABLES `volunteers` WRITE;
/*!40000 ALTER TABLE `volunteers` DISABLE KEYS */;
INSERT INTO `volunteers` VALUES (1,'Manley','Bernier','Judah',NULL,'2001-02-26',NULL,'8041 Alayna Canyon Apt. 280\nNew Jacquesmouth, LA 19217','East Dessieville','Κύπρος',NULL,NULL,'Accusamus sed delectus magnam eligendi a perspiciatis voluptatem. Molestias iste aut est asperiores. Dolore eos et a et voluptatibus. Aut voluptatem nesciunt quaerat. Dicta assumenda eveniet consequatur velit.','Repudiandae minus iusto mollitia consequatur quam voluptatem laudantium. Quasi maxime in quo assumenda qui quisquam ea. Omnis vero adipisci in molestias mollitia dolores ut laudantium. Distinctio harum sunt odio.','Qui et enim consectetur ea eius pariatur. Eum magni in ex non autem atque. Officia ut molestiae minima consequatur dolorem. Commodi impedit et quidem dolor doloribus.','(505)363-5804x89924','201.879.3287x628','1-117-021-1948',NULL,'Riley.Cartwright@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:23','2016-05-19 13:40:23',NULL,2,3,NULL,2,2,1,1,4,0,0,NULL,NULL,NULL,NULL),(2,'Theresa','Veum','Sven','','1968-07-19','0','29090 Osbaldo UnderpassNorth Sage, AZ 13303-1242','Carolehaven','Κύπρος','','','Sint sit quas eos voluptas occaecati. Dolores iusto officiis sunt molestias et recusandae. Consequuntur sunt commodi veritatis eos.','Quo qui maiores illum eaque deleniti qui quis. Eos odit dignissimos qui.','Laboriosam non sunt eaque dolorem qui qui. Et eaque ex quaerat quo enim quas.','685-733-5862','859-569-6377x83746','(326)976-9068','','qFranecki@example.com','','','','','','',1,0,'','2016-05-19 13:40:23','2016-07-01 21:33:32',NULL,1,1,1,2,2,2,2,3,0,0,NULL,NULL,NULL,NULL),(3,'Octavia','Collier','Carmelo',NULL,'1956-01-10',NULL,'39513 Andreanne Fall Apt. 217\nRaynortown, CT 22553-8755','Maidabury','Κύπρος',NULL,NULL,'Dolore facere eius expedita qui voluptas nesciunt nihil. Molestias consequatur quod esse beatae. Fugiat sunt esse nihil fugit quam quis atque. Ut eligendi et eum maxime.','Ea est aspernatur omnis quia placeat. Sed natus id id tempora doloribus asperiores. Nihil sequi enim sit.','Et doloremque iure optio quod aut laboriosam at voluptate. Qui ullam doloribus voluptas ut facere voluptatem. Quia sequi asperiores non est est. Ut vel sit officiis explicabo laudantium aliquam labore. Magni qui aut hic rerum ducimus est.','(987)565-5292x7650','772.537.0014x7382','119-937-0044',NULL,'ySchroeder@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:23','2016-05-19 13:40:23',NULL,1,3,NULL,3,1,2,3,4,0,0,NULL,NULL,NULL,NULL),(4,'Kyla','Smitham','Giuseppe',NULL,'1971-01-27',NULL,'8774 Klein Trail Apt. 895\nSouth Tristonport, OR 08858','Hassanmouth','Κύπρος',NULL,NULL,'Exercitationem deserunt voluptas enim molestiae qui repellat. Commodi laboriosam soluta pariatur nemo ullam. Itaque enim recusandae nesciunt. Quis consequatur at voluptas provident debitis doloribus.','Nihil provident sit rem omnis aut id. Non quidem illum officiis aut sed nesciunt ratione. Praesentium commodi aliquam rerum laudantium architecto. Libero ut et ut nostrum adipisci ex sunt.','Fuga mollitia corrupti id pariatur ipsum. Itaque alias laboriosam animi rerum cum. Natus in quia quia deleniti iure non.','115.078.8535','+65(9)2123560569','00090240410',NULL,'Brook43@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL,2,3,NULL,1,1,2,3,4,0,0,NULL,NULL,NULL,NULL),(5,'Novella','Nikolaus','Harmon',NULL,'1968-05-27',NULL,'3638 Jacobi Mountains\nDarehaven, TN 47312','South Nikolas','Κύπρος',NULL,NULL,'Quis aut recusandae et qui. Laudantium quas autem molestiae esse non iure. Possimus at et dolores voluptatem sint quis. Reprehenderit reprehenderit beatae et eius.','Libero amet consequatur esse ut magni. Earum sequi facere aliquam.','Nesciunt nam aut deleniti voluptatibus facilis qui. Nemo sit possimus et mollitia. Eum nulla atque dolores est ea id velit. Deserunt nemo nobis est maiores facere et et.','+42(1)0705589349','666-380-4190','(048)546-3453',NULL,'Spencer.Cleora@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL,2,2,NULL,3,1,1,1,4,0,0,NULL,NULL,NULL,NULL),(6,'Arno','Weissnat','Lenny',NULL,'1971-02-15',NULL,'157 Rocio Meadow\nEast Catherineside, KS 53780-9688','North Maurinebury','Κύπρος',NULL,NULL,'Fugit labore iure adipisci dicta. Praesentium necessitatibus magnam velit. Eligendi unde qui maiores itaque praesentium commodi ut temporibus.','Assumenda est repudiandae ipsa dolores nihil debitis et. Fuga laboriosam perspiciatis cupiditate quia eos dignissimos ea adipisci. Consequatur vero harum omnis voluptatem ut possimus. Vel debitis consequatur enim est mollitia qui iste porro.','Laboriosam quod quam illo consequuntur sit ab et iure. Dolorem nam porro odio aut beatae voluptas. Earum aperiam architecto consequuntur perferendis velit sed. Dolores sed nulla dolor omnis impedit.','1-959-675-6756x0861','06950373171','+03(5)4953129378',NULL,'cSteuber@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL,2,1,NULL,3,3,1,2,2,0,0,NULL,NULL,NULL,NULL),(7,'Deron','Gutmann','Bertram',NULL,'1948-01-17',NULL,'78443 Rutherford Islands\nArnoldburgh, SC 83745-5792','Dionmouth','Κύπρος',NULL,NULL,'Aut natus adipisci possimus recusandae quo iusto. Voluptas ex aut doloribus recusandae voluptatibus. Animi ea exercitationem voluptas itaque odio molestiae ut. Vel quis est odit blanditiis aut eveniet.','Explicabo repellat sed sapiente minus quae reprehenderit. Ipsam voluptatem praesentium dolore et doloribus. Blanditiis sit corrupti voluptas odit iste est reprehenderit.','Quis perspiciatis non aut sunt aut aut omnis omnis. Est nostrum perferendis rem natus. Non ut deleniti quia nobis.','(773)112-4243','685-356-6865','+37(5)2629436106',NULL,'fMcKenzie@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL,2,1,NULL,1,1,1,3,1,0,0,NULL,NULL,NULL,NULL),(8,'Marisol','Quigley','Tyson',NULL,'1976-04-01',NULL,'424 Amiya Park\nNew Jon, MI 38662','Lake Aniya','Κύπρος',NULL,NULL,'Eligendi illo qui qui et optio. Rerum incidunt eum perferendis rerum sed rerum qui nemo. Rerum ipsum numquam illum ut rerum beatae nam.','Repellendus aut non libero omnis adipisci. Exercitationem vitae et quis velit. Eius ratione qui laudantium maiores quo at. Quia assumenda sit quae nobis ea molestiae excepturi.','Facilis repudiandae dolorum quibusdam dolor omnis. Error qui explicabo est veritatis ipsum. Inventore quis vitae suscipit ut asperiores ipsa iusto. Et quam accusantium cumque eos.','+85(3)8594635103','292-020-5482x32054','1-014-063-5733',NULL,'Crona.Norene@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL,1,1,NULL,1,2,1,2,1,0,0,NULL,NULL,NULL,NULL),(9,'Adaline','Hintz','Dillon',NULL,'1976-03-02',NULL,'65913 Layla Ranch\nGulgowskichester, MT 94404-7152','Lake Laurenmouth','Κύπρος',NULL,NULL,'Iusto et a atque vitae dolorem. Distinctio occaecati molestiae consectetur aut. Cupiditate veritatis amet odio qui. Sequi fugit necessitatibus pariatur unde dicta est iure.','Incidunt sint magni sit eligendi est. Sed dolor voluptas atque quasi. Temporibus necessitatibus laudantium expedita perspiciatis dolor. Iste doloremque provident quibusdam.','Quo ut praesentium alias est. Dolorem sapiente et maiores quis accusantium provident. Expedita voluptatem sit delectus autem eius quia ducimus nesciunt.','741-820-7071x58407','1-703-588-1783x36453','890.872.2181x134',NULL,'mGusikowski@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:24','2016-05-27 11:26:11',NULL,2,1,NULL,3,1,2,1,4,0,0,NULL,NULL,NULL,NULL),(10,'Jarrett','Zemlak','Clyde',NULL,'1960-05-18',NULL,'308 Phoebe Falls Suite 934\nWest Bernadetteside, DC 41270','West Darrylhaven','Κύπρος',NULL,NULL,'Harum temporibus accusamus cumque sit sint adipisci reprehenderit nisi. Voluptatem at earum nostrum tempora ut maxime. Odit molestias nulla dolor culpa. Commodi consequatur aperiam vitae molestias.','Officia sed officia autem culpa optio quia amet. Et minus possimus in ipsam voluptas est voluptate. Dolor doloremque aliquid est in ipsum.','Nobis velit quam unde dolorum. Libero sit qui consequatur sint. Quaerat excepturi quia incidunt eaque sapiente et enim.','1-854-098-8844x067','1-667-232-4211','(576)618-9391',NULL,'Douglas.Weldon@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2016-05-19 13:40:24','2016-05-19 13:40:24',NULL,1,1,NULL,1,4,2,2,2,0,0,NULL,NULL,NULL,NULL),(11,'ROSALIND','CAPULET','ENOBARBUS','','1990-10-01','0','','Fulvia','','','',NULL,NULL,'','','','1234567890','','123@gmail.com','','','','','','',1,0,'','2016-05-23 11:32:01','2016-05-23 11:32:01',NULL,1,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(12,'Μαρία','Δημητρίου','','','2016-01-06','0','','Αθήνα','','','',NULL,NULL,'','','','123456789','','test@mail.com','','','','','','',1,0,'','2016-05-27 11:17:40','2016-05-27 11:17:40',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(13,'Maria','Koulentianou','','',NULL,'0','','Athens','','','',NULL,NULL,'','','','123456','','mariakoul@hotmail.com','','','','','','',1,0,'','2016-05-27 13:13:49','2016-05-27 13:13:49',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(14,'margie','kali','','','1992-02-25','0','','Athens','','','',NULL,NULL,'','','','55645481584','','kikaki-dim@hotmail.com','','','','','','',1,0,'','2016-05-31 10:46:32','2016-05-31 10:46:32',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(15,'Marisa ','Antonopoulou','','','2016-06-24','0','','Αθήνα','','','',NULL,NULL,'','','','123456','','marisa.marisa@gmail.com','','','','','','',1,0,'','2016-06-02 12:26:55','2016-06-02 12:26:55',NULL,2,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(16,'Αντωνία ','Μάνου','','','1986-05-12','0','Ελπίδος 14','Αθήνα','Ελλάδα','','',NULL,NULL,'','','','6978045375','','ant.manou@hotmail.com','','','Finance','','','',1,0,'','2016-06-23 10:59:01','2016-06-23 10:59:55',NULL,2,3,4,NULL,1,2,2,NULL,0,0,NULL,NULL,NULL,NULL),(17,'Ζωή','Μαυρίκου','','','1990-05-13','0','','ΑΘήνα','','','',NULL,NULL,'','','','697532698','','zoi.ma@gmail.com','','','','','','',1,0,'','2016-06-23 11:20:53','2016-06-23 11:20:53',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(18,'MpaMparis','Andreas','','','1982-02-06','0','','florina','','','',NULL,NULL,'','','','6942440891','','epontiki@arcturos.gr','','','','','','',1,0,'','2016-06-23 13:20:26','2016-06-23 13:20:26',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(19,'ΑΝΤΩΝΙΑ','ΒΑΛΣΑΜΑΚΗ','','','2016-09-20','0','','ΠΕΙΡΑΙΑΣ','','','',NULL,NULL,'','','','6947967040','','toniavalsam@hotmail.com','','','','','','',1,0,'','2016-06-27 11:27:06','2016-06-27 11:27:06',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(20,'Kostas','Makrijiannakis','','','2000-06-27','0','','Athens','','','',NULL,NULL,'','2109631441','','6936620102','','asd@right.gr','','','','','','',1,0,'','2016-06-27 12:38:41','2016-06-27 12:38:41',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(21,'Evina','Sotiropoulou','','','2016-06-29','0','22 Stournari','Athens','Ελλάδα','','',NULL,NULL,'','','','697412346','','socialmedia@mazigiatopaidi.gr','','','','','','',1,0,'','2016-06-29 11:14:43','2016-06-29 11:14:43',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(22,'kaiti','kox','petros','','2016-07-04','0','','athens','','','',NULL,NULL,'','1425562521','','116+616.3','','demo@scify.org','','','','','','',1,0,'','2016-07-04 10:57:24','2016-07-04 10:57:24',NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(23,'Angeliki','Mavrikou','','','1965-07-21','7','','Athens','','','',NULL,NULL,'','','','6987441225588','','angeliki@mpolsdfj.com','Arabic','','','','','',1,0,'','2017-01-19 12:22:55','2017-04-26 10:43:24',NULL,2,3,1,NULL,NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL),(24,'Theresa','Petersen','','','1987-02-27','0','Kreuzbergstraße 57','Berlin','','10965','',NULL,NULL,'Train of Hope Wien, Flüchtlingscamp vor der Votivkirche Wien, Basketballtraining mit einer jungen Gruppe afghanischer Geflüchteter auf öffentlichen Plätzen in Wien.','030 11223344','','0155 23456789','','t.petersen@ten.xmg','Arabic: B1','Anwältin mit Spezialisierung auf Völkerrecht, Völkerstrafrecht, European Court of Human Rights','Jura','HU','Meine Stärken liegen in der Recherche, der kritischen Auseinandersetzung der Hintergründen und der Praxis der EZA, dem transdisziplinären Arbeiten um so auch handlungsrelevantes Wissen zu generieren, Themen die globale und innergesellschaftliche Ungleichheit betreffen, Fundiertes Wissen zu Regionen: Europa, Westbalkan, Südostasien, Venezuela.','Photoshop, Wordpress, Linux',0,0,'','2017-01-24 09:58:20','2017-01-24 10:59:36',NULL,1,2,1,NULL,NULL,1,2,NULL,0,0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `volunteers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `volunteers_units_excludes`
--

DROP TABLE IF EXISTS `volunteers_units_excludes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `volunteers_units_excludes` (
  `volunteer_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  KEY `volunteers_units_excludes_volunteer_id_foreign` (`volunteer_id`),
  KEY `volunteers_units_excludes_unit_id_foreign` (`unit_id`),
  CONSTRAINT `volunteers_units_excludes_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `volunteers_units_excludes_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `volunteers_units_excludes`
--

LOCK TABLES `volunteers_units_excludes` WRITE;
/*!40000 ALTER TABLE `volunteers_units_excludes` DISABLE KEYS */;
/*!40000 ALTER TABLE `volunteers_units_excludes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_statuses`
--

DROP TABLE IF EXISTS `work_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `work_statuses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_statuses`
--

LOCK TABLES `work_statuses` WRITE;
/*!40000 ALTER TABLE `work_statuses` DISABLE KEYS */;
INSERT INTO `work_statuses` VALUES (1,'student'),(2,'worker'),(3,'unemployed'),(4,'retired');
/*!40000 ALTER TABLE `work_statuses` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-24  9:19:38
