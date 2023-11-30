-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: VEHICULOS
-- ------------------------------------------------------
-- Server version	8.0.32

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
-- Table structure for table `ADMINISTRADOR`
--

DROP TABLE IF EXISTS `ADMINISTRADOR`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ADMINISTRADOR` (
  `PK_ID_ADMINISTRADOR` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `EMAIL` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `PASSWORD` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`PK_ID_ADMINISTRADOR`),
  UNIQUE KEY `ADMINISTRADOR_UN` (`EMAIL`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ADMINISTRADOR`
--

LOCK TABLES `ADMINISTRADOR` WRITE;
/*!40000 ALTER TABLE `ADMINISTRADOR` DISABLE KEYS */;
INSERT INTO `ADMINISTRADOR` VALUES (1,'Ivan','ivan@test.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4'),(2,'Pepe','pepe@test.com','fe2592b42a727e977f055947385b709cc82b16b9a87f88c6abf3900d65d0cdc3');
/*!40000 ALTER TABLE `ADMINISTRADOR` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EMPLEADO`
--

DROP TABLE IF EXISTS `EMPLEADO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `EMPLEADO` (
  `PK_ID_EMPLEADO` int NOT NULL AUTO_INCREMENT,
  `IDENTIFICADOR` varchar(6) COLLATE utf8mb4_general_ci NOT NULL,
  `NOMBRE` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `APELLIDOS` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `FECHA_NACIMIENTO` date DEFAULT NULL,
  PRIMARY KEY (`PK_ID_EMPLEADO`),
  UNIQUE KEY `EMPLEADO_UN` (`IDENTIFICADOR`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EMPLEADO`
--

LOCK TABLES `EMPLEADO` WRITE;
/*!40000 ALTER TABLE `EMPLEADO` DISABLE KEYS */;
INSERT INTO `EMPLEADO` VALUES (1,'3423BF','Daniel','Puente Barajas','2002-06-11'),(2,'fdsljk','Irene','Puente Barajas','2005-03-25'),(3,'X4vyW0','Antonio','Puente Martinez','1968-05-15'),(4,'alRcin','Marta','Barajas Santos','1970-06-25'),(6,'9p4z3o','Mateo','Barajas Santos','2023-11-16'),(7,'9QfsL6','Antonio','Puente Gonzalez','1945-01-19'),(8,'xGIJ0V','Felisa','Santos Mahamud','1936-06-02'),(9,'6WSyNz','Ivan','Cagide',NULL);
/*!40000 ALTER TABLE `EMPLEADO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ESTADO`
--

DROP TABLE IF EXISTS `ESTADO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ESTADO` (
  `PK_ID_ESTADO` int NOT NULL AUTO_INCREMENT,
  `ESTADO` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`PK_ID_ESTADO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ESTADO`
--

LOCK TABLES `ESTADO` WRITE;
/*!40000 ALTER TABLE `ESTADO` DISABLE KEYS */;
INSERT INTO `ESTADO` VALUES (1,'Pte. de Aceptar'),(2,'Aceptada'),(3,'Denegada');
/*!40000 ALTER TABLE `ESTADO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `FOTO`
--

DROP TABLE IF EXISTS `FOTO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `FOTO` (
  `PK_ID_FOTO` int NOT NULL AUTO_INCREMENT,
  `FK_ID_VEHICULO` int NOT NULL,
  `ORIGINAL` varchar(100) NOT NULL,
  `RENOMBRADO` varchar(100) NOT NULL,
  PRIMARY KEY (`PK_ID_FOTO`),
  KEY `FOTO_VEHICULO_PK_ID_VEHICULO_fk` (`FK_ID_VEHICULO`),
  CONSTRAINT `FOTO_VEHICULO_PK_ID_VEHICULO_fk` FOREIGN KEY (`FK_ID_VEHICULO`) REFERENCES `VEHICULO` (`PK_ID_VEHICULO`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `FOTO`
--

LOCK TABLES `FOTO` WRITE;
/*!40000 ALTER TABLE `FOTO` DISABLE KEYS */;
INSERT INTO `FOTO` VALUES (1,1,'bmw_x-series_xm_modelcard_50.png.asset.1681276548689.png','vehiculo_5672HSL.png'),(2,2,'IMG_20231113_180024.jpg','vehiculo_8114GLM.jpg');
/*!40000 ALTER TABLE `FOTO` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RESERVA`
--

DROP TABLE IF EXISTS `RESERVA`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `RESERVA` (
  `PK_ID_RESERVA` int NOT NULL AUTO_INCREMENT,
  `FK_ID_VEHICULO` int NOT NULL,
  `DESDE` datetime NOT NULL,
  `HASTA` datetime NOT NULL,
  `FK_ID_EMPLEADO` int NOT NULL,
  `FK_ESTADO` int NOT NULL,
  PRIMARY KEY (`PK_ID_RESERVA`),
  KEY `VEHICULO_FK` (`FK_ID_VEHICULO`),
  KEY `EMPLEADO_FK` (`FK_ID_EMPLEADO`),
  KEY `ESTADO_FK` (`FK_ESTADO`),
  CONSTRAINT `EMPLEADO_FK` FOREIGN KEY (`FK_ID_EMPLEADO`) REFERENCES `EMPLEADO` (`PK_ID_EMPLEADO`),
  CONSTRAINT `ESTADO_FK` FOREIGN KEY (`FK_ESTADO`) REFERENCES `ESTADO` (`PK_ID_ESTADO`),
  CONSTRAINT `VEHICULO_FK` FOREIGN KEY (`FK_ID_VEHICULO`) REFERENCES `VEHICULO` (`PK_ID_VEHICULO`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RESERVA`
--

LOCK TABLES `RESERVA` WRITE;
/*!40000 ALTER TABLE `RESERVA` DISABLE KEYS */;
INSERT INTO `RESERVA` VALUES (1,1,'2023-11-21 00:00:00','2023-11-21 23:59:59',1,3),(2,2,'2023-11-25 00:00:00','2023-11-25 23:59:59',2,1),(10,3,'2023-11-26 01:54:00','2023-11-27 01:54:00',1,2),(11,1,'2023-11-05 01:56:00','2023-11-06 01:56:00',2,1),(12,2,'2023-11-08 00:52:00','2023-11-12 00:52:00',6,2),(13,8,'2023-11-28 19:58:00','2023-11-30 19:58:00',1,1);
/*!40000 ALTER TABLE `RESERVA` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `VEHICULO`
--

DROP TABLE IF EXISTS `VEHICULO`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `VEHICULO` (
  `PK_ID_VEHICULO` int NOT NULL AUTO_INCREMENT,
  `MATRICULA` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `MARCA` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `MODELO` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `UBICACION` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`PK_ID_VEHICULO`),
  UNIQUE KEY `VEHICULO_UN` (`MATRICULA`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `VEHICULO`
--

LOCK TABLES `VEHICULO` WRITE;
/*!40000 ALTER TABLE `VEHICULO` DISABLE KEYS */;
INSERT INTO `VEHICULO` VALUES (1,'5672HSL','BMW','Series 3','Marqués de Larios 6, 2C'),(2,'8114GLM','SEAT','Ibiza','Ronda de los Cuarteles 48'),(3,'8115GRF','SEAT','Ibiza 2','Ronda de los Cuarteles 49'),(8,'4321ABC','Renault','Modelo 1','Nieuwe Schoolstraat 56, Delft'),(9,'3422GLM','Mercedes','Modelo 8','Poeta Prudencio 8, Logroño');
/*!40000 ALTER TABLE `VEHICULO` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-30 20:20:03
