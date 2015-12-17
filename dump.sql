-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: homework1
-- ------------------------------------------------------
-- Server version	5.5.44-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(255) NOT NULL,
  `lastname`   VARCHAR(255) NOT NULL,
  `email`      VARCHAR(255) NOT NULL,
  `password`   VARCHAR(255) NOT NULL,
  `created_at` INT(11)      NOT NULL,
  `updated_at` INT(11)      NOT NULL,
  `active`     TINYINT(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_uindex` (`email`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
  (1, 'Alexandr', 'Skrylev', 'me@alskr.ru', '$2y$10$TdliK2nGpWwblhsY8TebqO0/sIbeSjKXVpKXmvF6kh9MklYYpAX9W', 1450127353,
   1450127353, 1),
  (2, 'admin', 'admin', 'admin@admin.admin', '$2y$10$ezqFx75n0T/WR/258U3tquAakgFgSfSv.sVEhf/1s2oeJsn6za.8.', 1450358327,
   1450358327, 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `title`       VARCHAR(255) NOT NULL,
  `description` TEXT         NOT NULL,
  `link`        VARCHAR(255) NOT NULL,
  `created_at`  INT(11)      NOT NULL,
  `updated_at`  INT(11)      NOT NULL,
  `active`      TINYINT(1)   NOT NULL DEFAULT '1',
  `image`       VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARSET = utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
INSERT INTO `works` VALUES
  (1, 'a-industry.ru', 'Корпоративный и в тоже время продающий сайт строительной компании a-industry.', '#', 1450117170,
   1450117170, 1, '/img/works/work-1.jpg'),
  (2, 'a-industry.ru', 'Корпоративный и в тоже время продающий сайт строительной компании a-industry.', '#', 1450117170,
   1450117170, 1, '/img/works/work-1.jpg'),
  (3, 'a-industry.ru', 'Корпоративный и в тоже время продающий сайт строительной компании a-industry.', '#', 1450117170,
   1450117170, 1, '/img/works/work-1.jpg'),
  (4, 'a-industry.ru', 'Корпоративный и в тоже время продающий сайт строительной компании a-industry.', '#', 1450117170,
   1450117170, 1, '/img/works/work-1.jpg'),
  (5, 'a-industry.ru', 'Корпоративный и в тоже время продающий сайт строительной компании a-industry.', '#', 1450117170,
   1450117170, 1, '/img/works/work-1.jpg');
/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2015-12-17 16:20:15
