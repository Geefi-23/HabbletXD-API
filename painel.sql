-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: hpanel
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `hp_cargos`
--

DROP TABLE IF EXISTS `hp_cargos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hp_cargos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hp_cargos`
--

LOCK TABLES `hp_cargos` WRITE;
/*!40000 ALTER TABLE `hp_cargos` DISABLE KEYS */;
INSERT INTO `hp_cargos` VALUES (1,'WebMaster'),(3,'Diretor Geral'),(28,'Desenvolvedor');
/*!40000 ALTER TABLE `hp_cargos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hp_cargos_permissions`
--

DROP TABLE IF EXISTS `hp_cargos_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hp_cargos_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cargo` int NOT NULL,
  `permission` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cargo` (`cargo`),
  KEY `permission` (`permission`),
  CONSTRAINT `hp_cargos_permissions_ibfk_1` FOREIGN KEY (`cargo`) REFERENCES `hp_cargos` (`id`),
  CONSTRAINT `hp_cargos_permissions_ibfk_2` FOREIGN KEY (`permission`) REFERENCES `hp_permissions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hp_cargos_permissions`
--

LOCK TABLES `hp_cargos_permissions` WRITE;
/*!40000 ALTER TABLE `hp_cargos_permissions` DISABLE KEYS */;
INSERT INTO `hp_cargos_permissions` VALUES (1,3,1),(20,1,3),(22,3,5),(23,1,4),(25,1,5),(27,1,6),(30,1,7),(33,1,8),(35,1,9),(36,1,10),(37,3,6),(38,3,10),(39,3,8),(40,3,4),(41,3,3),(42,3,2),(43,3,9),(44,3,7),(53,28,1),(54,28,2),(55,28,3),(56,28,4),(57,28,6),(58,28,5),(59,28,7),(60,28,8),(61,28,9),(62,28,10),(63,1,2),(64,1,1);
/*!40000 ALTER TABLE `hp_cargos_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hp_compras`
--

DROP TABLE IF EXISTS `hp_compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hp_compras` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_compravel` int NOT NULL,
  `nome_compravel` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `discord_usuario` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hp_compras`
--

LOCK TABLES `hp_compras` WRITE;
/*!40000 ALTER TABLE `hp_compras` DISABLE KEYS */;
INSERT INTO `hp_compras` VALUES (1,4,'teste de compras','','#geefifds'),(2,4,'teste de compras','',''),(3,4,'teste de compras','','freddie#0001'),(4,4,'teste de compras','','freddie#0001');
/*!40000 ALTER TABLE `hp_compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hp_permissions`
--

DROP TABLE IF EXISTS `hp_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hp_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hp_permissions`
--

LOCK TABLES `hp_permissions` WRITE;
/*!40000 ALTER TABLE `hp_permissions` DISABLE KEYS */;
INSERT INTO `hp_permissions` VALUES (1,'GERENCIAR NOTICIAS'),(2,'GERENCIAR MEMBROS'),(3,'GERENCIAR CARGOS'),(4,'GERENCIAR PERMISSOES'),(5,'GERENCIAR EVENTOS'),(6,'MARCAR HORARIOS'),(7,'GERENCIAR HORARIOS'),(8,'GERENCIAR COMPRAVEIS'),(9,'GERENCIAR VALORES'),(10,'GERENCIAR HABBLETXD HOME');
/*!40000 ALTER TABLE `hp_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hp_radio_horarios`
--

DROP TABLE IF EXISTS `hp_radio_horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hp_radio_horarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comeca` time NOT NULL,
  `termina` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hp_radio_horarios`
--

LOCK TABLES `hp_radio_horarios` WRITE;
/*!40000 ALTER TABLE `hp_radio_horarios` DISABLE KEYS */;
INSERT INTO `hp_radio_horarios` VALUES (1,'00:00:00','01:00:00'),(2,'01:00:00','02:00:00'),(3,'02:00:00','03:00:00'),(4,'03:00:00','04:00:00'),(5,'04:00:00','05:00:00'),(6,'05:00:00','06:00:00'),(7,'06:00:00','07:00:00'),(8,'07:00:00','08:00:00'),(9,'08:00:00','09:00:00'),(10,'09:00:00','10:00:00'),(11,'10:00:00','11:00:00'),(12,'11:00:00','12:00:00'),(13,'12:00:00','13:00:00'),(14,'13:00:00','14:00:00'),(15,'14:00:00','15:00:00'),(16,'15:00:00','16:00:00'),(17,'16:00:00','17:00:00'),(18,'17:00:00','18:00:00'),(19,'18:00:00','19:00:00'),(20,'19:00:00','20:00:00'),(21,'20:00:00','21:00:00'),(22,'21:00:00','22:00:00'),(23,'22:00:00','23:00:00'),(24,'23:00:00','00:00:00');
/*!40000 ALTER TABLE `hp_radio_horarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hp_radio_horarios_marcados`
--

DROP TABLE IF EXISTS `hp_radio_horarios_marcados`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hp_radio_horarios_marcados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL DEFAULT '',
  `horario` int NOT NULL,
  `dia` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`),
  KEY `fk_horario` (`horario`),
  CONSTRAINT `fk_horario` FOREIGN KEY (`horario`) REFERENCES `hp_radio_horarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hp_radio_horarios_marcados`
--

LOCK TABLES `hp_radio_horarios_marcados` WRITE;
/*!40000 ALTER TABLE `hp_radio_horarios_marcados` DISABLE KEYS */;
INSERT INTO `hp_radio_horarios_marcados` VALUES (22,'Geefi',16,'2022-07-08'),(23,'Geefi',7,'2022-07-08'),(24,'Geefi',8,'2022-07-08'),(25,'Geefi',9,'2022-07-08');
/*!40000 ALTER TABLE `hp_radio_horarios_marcados` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hp_users`
--

DROP TABLE IF EXISTS `hp_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hp_users` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `senha` varchar(40) DEFAULT NULL,
  `cargo` int NOT NULL,
  `ultimo_login` int DEFAULT NULL,
  `ultimo_ip` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `discord` varchar(255) DEFAULT NULL,
  `ativo` enum('sim','nao') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cargo` (`cargo`),
  CONSTRAINT `fk_cargo` FOREIGN KEY (`cargo`) REFERENCES `hp_cargos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hp_users`
--

LOCK TABLES `hp_users` WRITE;
/*!40000 ALTER TABLE `hp_users` DISABLE KEYS */;
INSERT INTO `hp_users` VALUES (13,'Indio','b6c4ecfe0c87245ee209c9d1a09',28,1657222547,'170.246.187.217','','','','','sim'),(28,'Geefi','c3949ba59abbe56e057f20f883e',28,1657310916,'170.246.187.24',NULL,'geefi','@LilPombo','469135204313989131','sim'),(29,'Faretta','69255d0f4c480e8a6d20645c06e',1,1657310143,'177.157.181.26',NULL,'','https://twitter.com/habfreddie','freddie#0001','sim'),(31,'IngridWillians','7dbf0fa09e8969978317dca12e8',1,NULL,NULL,NULL,NULL,NULL,NULL,'sim'),(32,'Lordh','aff661c3198a716686b83d11975',1,NULL,NULL,NULL,NULL,NULL,NULL,'sim'),(33,'Izis','aff661c3198a716686b83d11975',1,NULL,NULL,NULL,NULL,NULL,NULL,'sim'),(34,'Ale','aff661c3198a716686b83d11975',3,1657228108,'201.71.169.127',NULL,'','alebletbr','!Ale#6909','sim');
/*!40000 ALTER TABLE `hp_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-08 20:54:14
