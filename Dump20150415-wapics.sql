-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: savepic
-- ------------------------------------------------------
-- Server version	5.5.38-log

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
-- Table structure for table `auth_users`
--

DROP TABLE IF EXISTS `auth_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_users` (
  `id_auth` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `source_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id_auth`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `auth_users_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_users`
--

LOCK TABLES `auth_users` WRITE;
/*!40000 ALTER TABLE `auth_users` DISABLE KEYS */;
INSERT INTO `auth_users` VALUES (1,5,'twitter','714036504');
/*!40000 ALTER TABLE `auth_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `views` int(11) unsigned NOT NULL,
  `likes` int(11) unsigned NOT NULL,
  `created` int(11) unsigned NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_images_1_idx` (`id_user`),
  CONSTRAINT `fk_images_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (22,'',NULL,'u-XLJHfl9DaqfuRIFwOkBxZ2CvvUquqB.png','Yii.png',10,1,1428184847,NULL),(23,'',NULL,'K05noMcEt2VQjcOdusl0RH6geHBqJgbc.jpg','4to_ne_prowaut_muzh4inu.jpg',1,1,1428185590,NULL),(24,'',NULL,'z4_Eeje3Jtx-oZLp0_P8mS-WgByG_8lL.jpg','V7NgW6rres0 (1).jpg',1,1,1428188515,NULL),(25,'',NULL,'B1yCrOrZj9KH61ao8lcNdQ-vwUQOcxMZ.jpg','mid_94708_4616.jpg',0,0,1428232058,NULL),(26,'',NULL,'G1vAe_0Y9YlsA5cxl1OfX3Gy5SZB9HOi.png','Yii.png',0,0,1428232066,NULL),(27,'',NULL,'lcpLOBcGPVXou2V5v7MTLPJmLrM_yOpb.jpg','V7NgW6rres0 (1).jpg',0,0,1428232073,NULL),(28,'',NULL,'rA6ZNRTy8nOI1f96IqKimqIJe99w0wby.jpg','4to_ne_prowaut_muzh4inu.jpg',1,0,1428232081,NULL),(29,'',NULL,'LTNJx0ZVOhYofHCVJbqmFSVswYVUDDEB.png','Yii.png',1,0,1428232088,NULL),(30,'',NULL,'DZOydUrkhqPQs95d6A77D2F95rfS00O6.png','Yii.png',0,0,1428232180,NULL),(31,'',NULL,'fuKe4bQqlEwWX1HzV1n_xGcKQnAzkyFK.png','Yii.png',0,0,1428232188,NULL),(32,'',NULL,'h8eBJzoBlHDbD-zwZmW3b9ccGi2isRbx.jpg','V7NgW6rres0 (1).jpg',0,0,1428235485,NULL),(33,'',NULL,'V7Ez8lTAnDdO1t3qecrqleoJsdhuodPZ.png','Yii.png',1,0,1428522559,NULL),(34,'',NULL,'QOZ2UTlWm1VNcjKjNegwTAnxUt1Yluak.png','Yii.png',1,0,1428529141,NULL),(35,'',NULL,'Q-VFetymYaAuv0xSLCjNkiXZiwkCQqpz.jpg','navi.jpg',1,1,1428608558,NULL),(36,'',NULL,'sNawdooJhHbIumXGukaJwzRM8Sade7N2.jpg','V7NgW6rres0.jpg',0,0,1428613759,4),(37,'',NULL,'12RSsKTLZEBwtATM-m_gcO8yqAvX0KqQ.jpg','navi.jpg',1,0,1428613784,4),(38,'',NULL,'1iNp9jHStmJfl2Gw6voll9aS-vnCQZAd.jpg','navi.jpg',0,0,1428615474,4),(39,'',NULL,'ZuQMXWAk7SDAGmrXK33MtigrGaDwfYIo.jpg','V7NgW6rres0.jpg',1,0,1428615831,5),(40,'',NULL,'a46savdRfJ6KD_V4Y9-TsM7kPgrS9PT7.jpg','navi.jpg',1,0,1428616329,NULL);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `auth_key` varchar(32) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(45) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test',NULL,NULL,NULL,'test@email.com','',NULL,NULL),(2,'test2','eVi9GM8YfZWaZD0MX-fJUv23U7J36WZu','$2y$13$j4XO8j1CMcZZB6uLkJkJauQaeZYeHxmGJVYWYZA8EinhyPVCtkRDG','DaIRkgYWNugfh7h7pXP1JoVWii4gO_YL_1428612772','test2@email.com','1',1428612772,1428612772),(3,'test3','fCL_xWAITYBBCGrM0DG0WrduYE0MhWkv','$2y$13$LNdsGgWeObJxKohb8XG9yegS/g/kwMDcI6q74O/JdGG5SOZ.80676','xQHVehcTDYonhLo1-cL2W7_gtYLRBzI4_1428613381','','',1428613381,1428613381),(4,'test4','HZQSQub1xzEOV6mfbaHLfDrewW8geOQL','$2y$13$clHaQh/KkUGMHZb5B5K8leKrhLyC66ufnre.9fPGwAbFgWPRZxpx6','4xoD07vZhgZq1G1FirK0Lh677bOMAN-q_1428613448','','1',1428613448,1428613448),(5,'twitter','gztzCgOUtCM-Sg9v6jLqBm21qQdS8lfY','$2y$13$nBrxVi/SquQPM/HCYVJ5fuCQFR72H5dAayViDonEwaGZuv7b/swIu','YuMAwB-oFHczazY54Q2LB0tQsJ1YbL2t_1428615707',NULL,'1',1428615708,1428615708);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-15  1:18:58
