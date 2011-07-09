-- MySQL dump 10.13  Distrib 5.1.49, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: vis
-- ------------------------------------------------------
-- Server version	5.1.49-1ubuntu8

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
-- Table structure for table `CreditDetail`
--

DROP TABLE IF EXISTS `CreditDetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CreditDetail` (
  `creditDetailId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fullName` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '',
  `address` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `phoneNo` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`creditDetailId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CreditDetail`
--

LOCK TABLES `CreditDetail` WRITE;
/*!40000 ALTER TABLE `CreditDetail` DISABLE KEYS */;
INSERT INTO `CreditDetail` VALUES (1,'erick','erick','129838'),(3,'','',''),(4,'Erick Masanque','Port-Area','11203-12912-12'),(5,'asdas','asdsad','122'),(6,'asdas','asdsad','122'),(7,'','',''),(8,'','','');
/*!40000 ALTER TABLE `CreditDetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CreditPayment`
--

DROP TABLE IF EXISTS `CreditPayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CreditPayment` (
  `creditPaymentId` int(11) NOT NULL AUTO_INCREMENT,
  `creditDetailId` int(11) NOT NULL,
  `salesTransactionId` int(11) NOT NULL,
  `datePaid` datetime NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`creditPaymentId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CreditPayment`
--

LOCK TABLES `CreditPayment` WRITE;
/*!40000 ALTER TABLE `CreditPayment` DISABLE KEYS */;
/*!40000 ALTER TABLE `CreditPayment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DailyExpenseTransaction`
--

DROP TABLE IF EXISTS `DailyExpenseTransaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DailyExpenseTransaction` (
  `dailyExpenseTransacationId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  PRIMARY KEY (`dailyExpenseTransacationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `DailyExpenseTransaction`
--

LOCK TABLES `DailyExpenseTransaction` WRITE;
/*!40000 ALTER TABLE `DailyExpenseTransaction` DISABLE KEYS */;
/*!40000 ALTER TABLE `DailyExpenseTransaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Expense`
--

DROP TABLE IF EXISTS `Expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Expense` (
  `expenseId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dailyExpenseTransactionId` int(10) unsigned DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(18,4) DEFAULT NULL,
  `disburser` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`expenseId`),
  KEY `dailyExpenseTransactionId` (`dailyExpenseTransactionId`),
  CONSTRAINT `Expense_ibfk_1` FOREIGN KEY (`dailyExpenseTransactionId`) REFERENCES `DailyExpenseTransaction` (`dailyExpenseTransacationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Expense`
--

LOCK TABLES `Expense` WRITE;
/*!40000 ALTER TABLE `Expense` DISABLE KEYS */;
/*!40000 ALTER TABLE `Expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `InventoryItemExpense`
--

DROP TABLE IF EXISTS `InventoryItemExpense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `InventoryItemExpense` (
  `inventoryItemExpenseId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dailyExpenseTransactionId` int(10) unsigned DEFAULT NULL,
  `itemDetailId` int(10) unsigned DEFAULT NULL,
  `unitPrice` decimal(18,4) NOT NULL,
  `qty` int(11) NOT NULL,
  `disburser` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`inventoryItemExpenseId`),
  KEY `dailyExpenseTransactionId` (`dailyExpenseTransactionId`),
  KEY `itemDetailId` (`itemDetailId`),
  CONSTRAINT `InventoryItemExpense_ibfk_1` FOREIGN KEY (`dailyExpenseTransactionId`) REFERENCES `DailyExpenseTransaction` (`dailyExpenseTransacationId`),
  CONSTRAINT `InventoryItemExpense_ibfk_2` FOREIGN KEY (`itemDetailId`) REFERENCES `ItemDetail` (`itemDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `InventoryItemExpense`
--

LOCK TABLES `InventoryItemExpense` WRITE;
/*!40000 ALTER TABLE `InventoryItemExpense` DISABLE KEYS */;
/*!40000 ALTER TABLE `InventoryItemExpense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Item`
--

DROP TABLE IF EXISTS `Item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Item` (
  `itemId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `itemDetailId` int(10) unsigned NOT NULL,
  `storeId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`itemId`),
  KEY `itemDetailId` (`itemDetailId`),
  KEY `storeId` (`storeId`),
  CONSTRAINT `Item_ibfk_1` FOREIGN KEY (`itemDetailId`) REFERENCES `ItemDetail` (`itemDetailId`),
  CONSTRAINT `Item_ibfk_2` FOREIGN KEY (`storeId`) REFERENCES `Store` (`storeId`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Item`
--

LOCK TABLES `Item` WRITE;
/*!40000 ALTER TABLE `Item` DISABLE KEYS */;
INSERT INTO `Item` VALUES (1,1,1),(2,1,1),(3,1,1),(4,1,1),(5,1,1),(6,2,1),(7,2,1),(8,2,1),(9,1,1),(11,3,1),(12,3,1),(13,3,1),(14,1,1),(15,1,1),(16,1,1),(17,1,1),(18,1,1);
/*!40000 ALTER TABLE `Item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ItemDetail`
--

DROP TABLE IF EXISTS `ItemDetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ItemDetail` (
  `itemDetailId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productCode` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `itemTypeId` int(10) unsigned DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_bin NOT NULL,
  `unit` varchar(10) COLLATE utf8_bin NOT NULL,
  `buyingPrice` decimal(18,4) NOT NULL,
  `isUsed` tinyint(1) NOT NULL,
  `sellingPrice` decimal(18,4) NOT NULL,
  `supplierId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`itemDetailId`),
  KEY `itemTypeId` (`itemTypeId`),
  KEY `supplierId` (`supplierId`),
  CONSTRAINT `ItemDetail_ibfk_1` FOREIGN KEY (`itemTypeId`) REFERENCES `ItemType` (`itemTypeId`),
  CONSTRAINT `ItemDetail_ibfk_2` FOREIGN KEY (`itemTypeId`) REFERENCES `ItemType` (`itemTypeId`),
  CONSTRAINT `ItemDetail_ibfk_3` FOREIGN KEY (`supplierId`) REFERENCES `Supplier` (`supplierId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ItemDetail`
--

LOCK TABLES `ItemDetail` WRITE;
/*!40000 ALTER TABLE `ItemDetail` DISABLE KEYS */;
INSERT INTO `ItemDetail` VALUES (1,'ADP01',1,'Bosskit Adaptor Toyota T2','pcs','280.0000',0,'300.0000',NULL),(2,'ADP02',1,'Bosskit Adaptor Toyota T16','pcs','280.0000',0,'300.0000',NULL),(3,NULL,2,'Tree Frog Jasmine Cherry','pcs','46.0000',0,'100.0000',NULL),(5,'sampleCode',1,'Keyboard','dozen','100.0000',1,'200.0000',NULL);
/*!40000 ALTER TABLE `ItemDetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ItemType`
--

DROP TABLE IF EXISTS `ItemType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ItemType` (
  `itemTypeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`itemTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ItemType`
--

LOCK TABLES `ItemType` WRITE;
/*!40000 ALTER TABLE `ItemType` DISABLE KEYS */;
INSERT INTO `ItemType` VALUES (1,'Adaptor Wheel'),(2,'Air Freshener');
/*!40000 ALTER TABLE `ItemType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sales`
--

DROP TABLE IF EXISTS `Sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sales` (
  `salesId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `salesTransactionId` int(10) unsigned NOT NULL,
  `itemDetailId` int(10) unsigned NOT NULL,
  `unitPrice` decimal(18,4) unsigned NOT NULL,
  `qty` int(10) unsigned NOT NULL,
  `discount` int(10) unsigned DEFAULT NULL,
  `storeId` int(10) unsigned NOT NULL,
  `isVAT` tinyint(1) NOT NULL,
  PRIMARY KEY (`salesId`),
  KEY `salesTransactionId` (`salesTransactionId`),
  KEY `itemDetailId` (`itemDetailId`),
  KEY `storeId` (`storeId`),
  CONSTRAINT `Sales_ibfk_1` FOREIGN KEY (`salesTransactionId`) REFERENCES `SalesTransaction` (`salesTransactionID`),
  CONSTRAINT `Sales_ibfk_2` FOREIGN KEY (`itemDetailId`) REFERENCES `ItemDetail` (`itemDetailId`),
  CONSTRAINT `Sales_ibfk_3` FOREIGN KEY (`storeId`) REFERENCES `Store` (`storeId`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sales`
--

LOCK TABLES `Sales` WRITE;
/*!40000 ALTER TABLE `Sales` DISABLE KEYS */;
INSERT INTO `Sales` VALUES (5,1,1,'0.0000',0,20,1,0),(6,1,1,'1.0000',1,20,1,0),(7,1,1,'1.0000',1,20,1,0),(9,1,2,'1.0000',1,20,1,0),(12,1,1,'1.0000',1,50,1,0),(13,1,2,'1.0000',1,50,1,0),(14,1,2,'1.0000',1,50,1,1),(15,1,2,'1.0000',1,50,1,1),(16,1,2,'1.0000',1,50,1,1),(17,1,2,'1.0000',1,50,1,1),(18,1,1,'1.0000',1,20,1,0),(19,14,3,'1.0000',1,50,1,1),(20,15,3,'1.0000',1,50,1,1),(21,16,3,'1.0000',1,50,1,1),(22,18,1,'1.0000',1,1,1,1),(23,19,2,'2.0000',2,2,2,1),(24,24,1,'1.0000',1,1,2,0),(25,25,1,'1.0000',1,1,2,0),(26,26,1,'1.0000',1,1,2,0),(27,28,2,'2.0000',2,2,2,0),(28,29,2,'2.0000',2,2,2,0),(29,30,2,'2.0000',2,2,2,0),(30,1,1,'1.0000',1,20,1,0),(31,53,1,'300.0000',1,3,1,0),(32,53,2,'300.0000',2,2,1,1),(33,53,3,'100.0000',3,1,1,1),(34,54,2,'300.0000',12,12,1,0),(35,55,2,'300.0000',12,12,1,0),(36,56,2,'300.0000',12,12,1,0),(37,57,1,'300.0000',2,0,1,0),(38,58,2,'300.0000',12,0,1,1),(39,59,2,'300.0000',12,0,1,1),(40,60,2,'300.0000',12,0,1,1),(41,62,2,'300.0000',12,0,1,1),(42,63,2,'300.0000',12,0,1,1),(43,64,2,'300.0000',12,0,1,1),(44,65,2,'300.0000',12,0,1,1),(45,66,2,'300.0000',12,0,1,1),(46,67,2,'300.0000',2,0,1,0),(47,68,2,'300.0000',2,0,1,0),(48,71,2,'300.0000',2,0,1,0),(49,72,1,'300.0000',12,0,1,0),(50,73,1,'300.0000',12,0,1,0),(51,74,2,'300.0000',12,0,1,0),(52,75,1,'300.0000',1,0,1,0),(53,76,2,'300.0000',12,0,1,0),(54,77,1,'300.0000',12,0,1,0),(55,77,2,'300.0000',1,0,1,1),(56,78,1,'300.0000',4,0,1,0),(57,78,2,'300.0000',2,0,1,0),(58,79,1,'300.0000',6,0,1,0),(59,79,2,'300.0000',3,0,1,0),(60,79,3,'100.0000',2,0,1,0),(61,79,1,'300.0000',3,0,1,0),(62,80,1,'300.0000',2,0,1,0),(63,81,1,'300.0000',1,0,1,0),(64,82,1,'300.0000',6,0,1,0),(65,83,1,'300.0000',2,0,1,0),(66,83,2,'300.0000',1,0,1,0),(67,83,3,'100.0000',1,0,1,0),(68,84,1,'300.0000',2,0,1,0),(69,84,2,'300.0000',111,0,1,0),(70,84,3,'100.0000',1,0,1,0),(71,85,1,'300.0000',2,200,1,0),(72,86,1,'300.0000',2,100,1,0),(73,87,1,'300.0000',3,200,1,0),(74,88,2,'300.0000',2,0,1,0),(75,89,3,'100.0000',2,0,1,0),(76,90,2,'300.0000',1,0,1,0);
/*!40000 ALTER TABLE `Sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SalesTransaction`
--

DROP TABLE IF EXISTS `SalesTransaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SalesTransaction` (
  `salesTransactionID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `userId` int(10) unsigned NOT NULL,
  `creditDetailId` int(10) unsigned DEFAULT NULL,
  `totalPrice` decimal(18,4) DEFAULT NULL,
  `isFullyPaid` tinyint(1) NOT NULL,
  PRIMARY KEY (`salesTransactionID`),
  KEY `userId` (`userId`),
  CONSTRAINT `SalesTransaction_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SalesTransaction`
--

LOCK TABLES `SalesTransaction` WRITE;
/*!40000 ALTER TABLE `SalesTransaction` DISABLE KEYS */;
INSERT INTO `SalesTransaction` VALUES (1,'0000-00-00 00:00:00',1,NULL,NULL,1),(2,'2011-06-26 00:00:00',1,NULL,NULL,1),(3,'1970-01-01 08:00:00',1,NULL,NULL,1),(4,'1970-01-01 08:00:00',1,NULL,NULL,1),(5,'1970-01-01 08:00:00',1,NULL,NULL,1),(6,'1970-01-01 08:00:00',1,NULL,NULL,1),(7,'1970-01-01 08:00:00',1,NULL,NULL,1),(8,'1970-01-01 08:00:00',1,NULL,NULL,1),(9,'1970-01-01 08:00:00',1,NULL,NULL,1),(10,'1970-01-01 08:00:00',1,NULL,NULL,1),(11,'1970-01-01 08:00:00',1,NULL,NULL,1),(12,'1970-01-01 08:00:00',1,NULL,NULL,1),(13,'2011-06-26 21:58:21',1,NULL,NULL,1),(14,'2011-06-26 22:00:43',1,NULL,NULL,1),(15,'2011-06-27 22:36:28',1,NULL,NULL,1),(16,'2011-06-27 22:36:48',1,NULL,NULL,1),(17,'2011-06-27 22:38:42',1,NULL,'100.0000',1),(18,'2011-06-27 22:39:27',1,NULL,NULL,1),(19,'2011-06-28 07:20:22',1,NULL,NULL,1),(20,'2011-06-28 07:22:49',1,NULL,NULL,1),(21,'2011-06-28 07:23:34',1,NULL,'5200.0000',1),(22,'2011-06-28 07:30:43',1,NULL,'5200.0000',1),(23,'2011-07-02 15:21:31',1,NULL,'0.0000',1),(24,'2011-07-02 17:53:31',1,NULL,'0.0000',1),(25,'2011-07-02 17:53:57',1,NULL,'3600.0000',1),(26,'2011-07-02 17:55:08',1,NULL,'4800.0000',1),(27,'2011-07-02 17:56:45',1,NULL,'3600.0000',1),(28,'2011-07-02 19:55:56',1,NULL,'3600.0000',1),(29,'2011-07-02 19:56:11',1,NULL,'3500.0000',1),(30,'2011-07-02 19:57:57',1,NULL,'0.0000',1),(31,'2011-07-02 20:02:52',1,NULL,'0.0000',1),(32,'2011-07-02 20:03:07',1,NULL,'0.0000',1),(33,'2011-07-02 20:03:17',1,NULL,'0.0000',1),(34,'2011-07-02 20:11:14',1,NULL,'0.0000',1),(35,'2011-07-02 20:52:54',1,NULL,'0.0000',1),(36,'2011-07-02 20:54:06',1,NULL,'0.0000',1),(37,'2011-07-02 20:54:30',1,NULL,'0.0000',1),(38,'2011-07-02 21:07:22',1,NULL,'3600.0000',1),(39,'2011-07-02 21:11:01',1,NULL,'0.0000',1),(40,'2011-07-02 21:11:42',1,NULL,'0.0000',1),(41,'2011-07-02 21:11:48',1,NULL,'3600.0000',1),(42,'2011-07-02 21:12:39',1,NULL,'0.0000',1),(43,'2011-07-02 21:13:49',1,NULL,'0.0000',1),(44,'2011-07-02 21:16:01',1,NULL,'3600.0000',1),(45,'2011-07-03 11:15:41',1,NULL,'0.0000',1),(46,'2011-07-03 11:15:53',1,NULL,'0.0000',1),(47,'2011-07-03 12:00:22',1,NULL,'3600.0000',1),(48,'2011-07-03 12:01:49',1,NULL,NULL,1),(49,'2011-07-03 12:02:50',1,NULL,NULL,1),(50,'2011-07-03 12:03:39',1,NULL,NULL,1),(51,'2011-07-03 12:04:38',1,NULL,NULL,1),(52,'2011-07-03 12:35:33',1,NULL,'297.0000',1),(53,'2011-07-03 12:36:54',1,NULL,'1194.0000',1),(54,'2011-07-03 13:09:39',1,NULL,'3588.0000',1),(55,'2011-07-03 13:11:23',1,NULL,'3588.0000',1),(56,'2011-07-03 13:11:48',1,NULL,'3588.0000',1),(57,'2011-07-03 15:38:33',1,6,'600.0000',0),(58,'2011-07-03 15:39:12',1,7,'3600.0000',0),(59,'2011-07-03 15:39:28',1,8,'3600.0000',0),(60,'2011-07-03 15:40:10',1,NULL,'3600.0000',1),(62,'2011-07-03 15:41:54',1,NULL,'3600.0000',1),(63,'2011-07-03 15:42:00',1,NULL,'3600.0000',1),(64,'2011-07-03 15:42:02',1,NULL,'3600.0000',1),(65,'2011-07-03 15:42:03',1,NULL,'3600.0000',1),(66,'2011-07-03 16:07:30',1,NULL,'3600.0000',1),(67,'2011-07-03 16:07:45',1,NULL,'600.0000',1),(68,'2011-07-03 17:13:22',1,NULL,'600.0000',1),(69,'2011-07-03 17:15:49',1,NULL,NULL,1),(70,'2011-07-03 17:16:01',1,NULL,NULL,1),(71,'2011-07-03 17:17:15',1,NULL,'600.0000',1),(72,'2011-07-03 18:41:04',1,NULL,'3600.0000',1),(73,'2011-07-03 20:53:36',1,NULL,'3600.0000',1),(74,'2011-07-03 20:53:49',1,NULL,'3600.0000',1),(75,'2011-07-03 20:54:26',1,NULL,'300.0000',1),(76,'2011-07-07 20:36:46',1,NULL,'3600.0000',1),(77,'2011-07-07 20:37:25',1,NULL,'3900.0000',1),(78,'2011-07-09 05:16:12',1,NULL,'1800.0000',1),(79,'2011-07-09 05:17:28',1,NULL,'3800.0000',1),(80,'2011-07-09 05:18:42',1,NULL,'900.0000',1),(81,'2011-07-09 05:23:52',1,NULL,'33900.0000',1),(82,'2011-07-09 05:25:20',1,NULL,'1800.0000',1),(83,'2011-07-09 05:26:20',1,NULL,'1000.0000',1),(84,'2011-07-09 05:27:10',1,NULL,'34000.0000',1),(85,'2011-07-09 22:10:15',1,NULL,'400.0000',1),(86,'2011-07-09 22:10:30',1,NULL,'500.0000',1),(87,'2011-07-09 22:10:47',1,NULL,'700.0000',1),(88,'2011-07-10 00:26:16',1,NULL,'600.0000',1),(89,'2011-07-10 00:27:45',1,NULL,'200.0000',1),(90,'2011-07-10 00:29:34',1,NULL,'300.0000',1);
/*!40000 ALTER TABLE `SalesTransaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Store`
--

DROP TABLE IF EXISTS `Store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Store` (
  `storeId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `location` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`storeId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Store`
--

LOCK TABLES `Store` WRITE;
/*!40000 ALTER TABLE `Store` DISABLE KEYS */;
INSERT INTO `Store` VALUES (1,'Main','QC'),(2,'Branch','QC');
/*!40000 ALTER TABLE `Store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Supplier`
--

DROP TABLE IF EXISTS `Supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Supplier` (
  `supplierId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `discount` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`supplierId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Supplier`
--

LOCK TABLES `Supplier` WRITE;
/*!40000 ALTER TABLE `Supplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `Supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL,
  `firstName` varchar(30) COLLATE utf8_bin NOT NULL,
  `lastName` varchar(30) COLLATE utf8_bin NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'erick','erick','erick','masanque',1),(2,'mark','mark','mark','mark',1);
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-07-10  0:30:50
