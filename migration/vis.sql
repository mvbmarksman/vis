-- MySQL dump 10.13  Distrib 5.1.58, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: vis
-- ------------------------------------------------------
-- Server version	5.1.58-1ubuntu1

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
-- Table structure for table `CreditPayment`
--

DROP TABLE IF EXISTS `CreditPayment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CreditPayment` (
  `creditPaymentId` BIGINT NOT NULL AUTO_INCREMENT,
  `customerId` BIGINT NOT NULL,
  `salesTransactionId` BIGINT NOT NULL,
  `datePaid` datetime DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`creditPaymentId`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CreditPayment`
--

LOCK TABLES `CreditPayment` WRITE;
/*!40000 ALTER TABLE `CreditPayment` DISABLE KEYS */;
INSERT INTO `CreditPayment` VALUES (1,6,6,'2011-07-27 00:23:57','50'),(2,8,2,'2011-08-13 14:30:29','50'),(3,20,13,'2011-08-14 00:45:31','0'),(4,19,2,'2011-08-14 01:52:20','300'),(5,10,3,'2011-08-14 02:09:29','192'),(6,6,1,'2011-08-14 02:13:19','600'),(7,6,1,'2011-08-14 02:14:34','600'),(8,6,2,'2011-08-14 02:25:52','5000'),(9,6,4,'2011-08-14 03:14:07','830'),(10,10,8,'2011-08-14 12:42:51','9000'),(11,10,9,'2011-08-14 12:43:19','50'),(12,2,1,'2011-08-14 12:46:12','650'),(13,6,7,'2011-08-14 13:24:16','10550'),(14,6,9,'2011-08-14 13:28:09','300'),(15,6,11,'2011-08-14 13:31:14','150'),(16,6,12,'2011-08-14 13:31:32','300'),(17,6,13,'2011-08-14 13:36:16','400'),(18,6,14,'2011-08-14 13:37:27','400'),(19,1,16,'2011-08-14 13:50:39','300'),(20,6,17,'2011-08-14 13:51:01','300'),(21,6,18,'2011-08-14 13:53:02','800'),(22,6,19,'2011-08-14 13:56:04','6250'),(23,6,21,'2011-08-14 14:15:10','0'),(24,22,25,'2011-09-07 12:51:04','200'),(25,6,26,'2011-09-08 16:17:13','100');
/*!40000 ALTER TABLE `CreditPayment` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trig_credit_payment_insert BEFORE INSERT ON `CreditPayment`
    FOR EACH ROW SET NEW.datePaid = NOW() */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Customer`
--

DROP TABLE IF EXISTS `Customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Customer` (
  `customerId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) COLLATE utf8_bin NOT NULL,
  `address` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `phoneNo` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`customerId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Customer`
--

LOCK TABLES `Customer` WRITE;
/*!40000 ALTER TABLE `Customer` DISABLE KEYS */;
INSERT INTO `Customer` VALUES (1,'lolol','a','1'),(2,'marko','tests','12345'),(3,'marks','test','1234'),(4,'ma','',''),(5,'aaa','aaa','1234'),(6,'mark basmayor','cubao','1'),(7,'mark','cubao','1234'),(8,'mark','cubao','09272310583'),(9,'pedro','asdfsdf','09272310583'),(10,'test','testtest','12346'),(11,'marko','tests','12345'),(12,'marko','tests','12345'),(13,'marko','tests','12345'),(14,'marko','tests','12345'),(15,'marko','tests','12345'),(16,'marko','tests','12345'),(17,'marko','tests','12345'),(18,'marko','test','1234'),(19,'geezel torres','antipolo','12345'),(20,'geezel torres','antipolo','12345'),(23,'Erick Masanque','pasig City','123-456-789'),(25,'Erick Masanque','pasig City','123-456-789'),(26,'Erick Masanque','pasig City','123-456-789'),(27,'Erick Masanque','pasig City','123-456-789'),(28,'Erick Masanque','pasig City','123-456-789'),(29,'Erick Masanque','pasig City','123-456-789'),(30,'Erick Masanque','pasig City','123-456-789');
/*!40000 ALTER TABLE `Customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `DailyExpenseTransaction`
--

DROP TABLE IF EXISTS `DailyExpenseTransaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `DailyExpenseTransaction` (
  `dailyExpenseTransacationId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
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
  `expenseId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
  `dailyExpenseTransactionId` BIGINT unsigned DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `price` decimal(18,4) DEFAULT NULL,
  `disburser` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`expenseId`),
  KEY `dailyExpenseTransactionId` (`dailyExpenseTransactionId`)
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
  `inventoryItemExpenseId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
  `dailyExpenseTransactionId` BIGINT unsigned DEFAULT NULL,
  `itemDetailId` BIGINT unsigned DEFAULT NULL,
  `unitPrice` decimal(18,4) NOT NULL,
  `qty` BIGINT NOT NULL,
  `isCredit` tinyint(4) NOT NULL DEFAULT '0',
  `isFullyPaid` tinyint(1) NOT NULL DEFAULT '1',
  `supplierId` BIGINT unsigned DEFAULT NULL,
  `discount` decimal(10,4) DEFAULT NULL,
  PRIMARY KEY (`inventoryItemExpenseId`),
  KEY `dailyExpenseTransactionId` (`dailyExpenseTransactionId`),
  KEY `itemDetailId` (`itemDetailId`)
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
  `itemId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemDetailId` bigint(20) unsigned NOT NULL,
  `isUsed` tinyint(4) NOT NULL DEFAULT '0',
  `buyingPrice` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `supplierId` bigint(20) unsigned NOT NULL,
  `storeId` BIGINT unsigned NOT NULL,
  `dateAdded` datetime DEFAULT NULL,
  PRIMARY KEY (`itemId`),
  KEY `itemDetailId` (`itemDetailId`),
  KEY `storeId` (`storeId`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Item`
--

LOCK TABLES `Item` WRITE;
/*!40000 ALTER TABLE `Item` DISABLE KEYS */;
INSERT INTO `Item` VALUES (1,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(2,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(3,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(4,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(5,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(6,2,0,'0.0000',0,1,'2011-10-30 21:04:59'),(7,2,0,'0.0000',0,1,'2011-10-30 21:04:59'),(8,2,0,'0.0000',0,1,'2011-10-30 21:04:59'),(9,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(11,3,0,'0.0000',0,1,'2011-10-30 21:04:59'),(12,3,0,'0.0000',0,1,'2011-10-30 21:04:59'),(13,3,0,'0.0000',0,1,'2011-10-30 21:04:59'),(14,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(15,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(16,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(17,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(18,1,0,'0.0000',0,1,'2011-10-30 21:04:59'),(19,9,0,'0.0000',0,1,'2011-10-30 21:04:59');
/*!40000 ALTER TABLE `Item` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trig_item_insert BEFORE INSERT ON `Item`
    FOR EACH ROW SET NEW.dateAdded = IFNULL(NEW.dateAdded, NOW()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ItemDetail`
--

DROP TABLE IF EXISTS `ItemDetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ItemDetail` (
  `itemDetailId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
  `productCode` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `itemTypeId` BIGINT unsigned DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_bin NOT NULL,
  `unit` varchar(10) COLLATE utf8_bin NOT NULL,
  `buyingPrice` decimal(18,4) NOT NULL,
  `isUsed` tinyint(1) NOT NULL COMMENT 'client needs to determine if item is brand new or used',
  `supplierId` BIGINT unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL COMMENT 'if 0, no need to alert user that there is no more stock',
  PRIMARY KEY (`itemDetailId`),
  KEY `itemTypeId` (`itemTypeId`),
  KEY `supplierId` (`supplierId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ItemDetail`
--

LOCK TABLES `ItemDetail` WRITE;
/*!40000 ALTER TABLE `ItemDetail` DISABLE KEYS */;
INSERT INTO `ItemDetail` VALUES (1,'ADP01',1,'Bosskit Adaptor Toyota T2','pcs','100.0000',0,2,1),(2,'ADP02',1,'Bosskit Adaptor Toyota T16','pcs','280.0000',1,1,1),(3,NULL,2,'Tree Frog Jasmine Cherry','pcs','46.0000',0,2,1),(5,'sampleCode',1,'Keyboard','dozen','100.0000',1,2,1),(8,'qwew',1,'sdfsd','asd','123.0000',0,1,1),(9,'AF00',1,'Air Freshener','pcs','100.0000',0,NULL,1);
/*!40000 ALTER TABLE `ItemDetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ItemType`
--

DROP TABLE IF EXISTS `ItemType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ItemType` (
  `itemTypeId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`itemTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ItemType`
--

LOCK TABLES `ItemType` WRITE;
/*!40000 ALTER TABLE `ItemType` DISABLE KEYS */;
INSERT INTO `ItemType` VALUES (1,'Adaptor Wheel'),(2,'Air Freshener'),(4,'asdasd');
/*!40000 ALTER TABLE `ItemType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sales`
--

DROP TABLE IF EXISTS `Sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sales` (
  `salesId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
  `salesTransactionId` BIGINT unsigned NOT NULL,
  `itemDetailId` BIGINT unsigned NOT NULL,
  `sellingPrice` decimal(18,4) unsigned NOT NULL,
  `qty` BIGINT unsigned NOT NULL,
  `discount` BIGINT unsigned DEFAULT NULL,
  `storeId` BIGINT unsigned NOT NULL,
  `subTotal` decimal(18,4) DEFAULT NULL,
  `vatable` decimal(18,4) DEFAULT NULL,
  `vat` decimal(18,4) DEFAULT NULL,
  PRIMARY KEY (`salesId`),
  KEY `salesTransactionId` (`salesTransactionId`),
  KEY `itemDetailId` (`itemDetailId`),
  KEY `storeId` (`storeId`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sales`
--

LOCK TABLES `Sales` WRITE;
/*!40000 ALTER TABLE `Sales` DISABLE KEYS */;
INSERT INTO `Sales` VALUES (1,1,1,'100.0000',5,0,1,'500.0000','446.4286','53.5714'),(2,1,5,'200.0000',1,50,1,'150.0000',NULL,NULL),(3,2,1,'100.0000',1,0,1,'100.0000',NULL,NULL),(4,3,1,'100.0000',1,0,1,'100.0000',NULL,NULL),(5,4,1,'100.0000',1,0,1,'100.0000',NULL,NULL),(6,7,1,'100.0000',101,50,1,'10050.0000','8973.2143','1076.7857'),(7,7,1,'100.0000',5,0,1,'500.0000',NULL,NULL),(8,9,1,'100.0000',3,0,1,'300.0000','267.8571','32.1429'),(9,10,1,'100.0000',1,0,1,'100.0000',NULL,NULL),(10,10,5,'100.0000',1,0,1,'100.0000',NULL,NULL),(11,11,1,'100.0000',2,50,1,'150.0000','133.9286','16.0714'),(12,12,1,'100.0000',2,0,1,'200.0000',NULL,NULL),(13,12,1,'100.0000',1,0,1,'100.0000',NULL,NULL),(14,13,1,'100.0000',3,0,1,'300.0000',NULL,NULL),(15,13,5,'100.0000',1,0,1,'100.0000',NULL,NULL),(16,14,1,'100.0000',2,0,1,'200.0000',NULL,NULL),(17,14,5,'100.0000',1,0,1,'100.0000',NULL,NULL),(18,14,1,'100.0000',1,0,1,'100.0000',NULL,NULL),(19,16,1,'100.0000',2,0,1,'200.0000',NULL,NULL),(20,16,5,'100.0000',1,0,1,'100.0000',NULL,NULL),(21,17,1,'100.0000',3,0,1,'300.0000',NULL,NULL),(22,18,1,'100.0000',4,50,1,'350.0000','312.5000','37.5000'),(23,18,5,'100.0000',1,0,1,'100.0000',NULL,NULL),(24,18,1,'100.0000',2,50,1,'150.0000',NULL,NULL),(25,18,1,'200.0000',1,0,1,'200.0000',NULL,NULL),(26,19,1,'100.0000',4,100,1,'300.0000','267.8571','32.1429'),(27,19,1,'100.0000',1,50,1,'50.0000',NULL,NULL),(28,19,5,'100.0000',55,0,1,'5500.0000','4910.7143','589.2857'),(29,19,1,'200.0000',2,0,1,'400.0000','357.1429','42.8571'),(30,20,1,'10000.0000',1,0,1,'10000.0000',NULL,NULL),(31,20,5,'100.0000',2,0,1,'200.0000',NULL,NULL),(32,21,1,'100.0000',10,0,1,'1000.0000',NULL,NULL),(33,21,3,'46.0000',12,0,1,'552.0000',NULL,NULL),(34,22,1,'100.0000',12,0,1,'1755.0000',NULL,NULL),(35,22,1,'100.0000',24,555,1,'1845.0000','1647.3214','197.6786'),(36,22,1,'200.0000',12,0,1,'2400.0000',NULL,NULL),(37,23,1,'100.0000',2,0,1,'200.0000','178.5714','21.4286'),(38,24,1,'100.0000',12,0,1,'1200.0000',NULL,NULL),(39,24,1,'100.0000',2,0,1,'200.0000','178.5714','21.4286'),(40,24,1,'200.0000',12,500,1,'1900.0000',NULL,NULL),(41,24,1,'300.0000',12,2000,1,'1600.0000','1428.5714','171.4286'),(42,24,1,'200.0000',12,0,1,'2400.0000','2142.8571','257.1429'),(43,25,1,'200.0000',2,0,1,'400.0000','357.1429','42.8571'),(44,26,2,'300.0000',12,0,1,'3600.0000',NULL,NULL);
/*!40000 ALTER TABLE `Sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SalesTransaction`
--

DROP TABLE IF EXISTS `SalesTransaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SalesTransaction` (
  `salesTransactionId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `userId` BIGINT unsigned NOT NULL,
  `customerId` BIGINT unsigned DEFAULT NULL,
  `totalPrice` decimal(18,4) DEFAULT NULL,
  `totalVatable` decimal(18,4) DEFAULT NULL,
  `totalVat` decimal(18,4) DEFAULT NULL,
  `totalAmountPaid` decimal(18,4) DEFAULT NULL,
  `isFullyPaid` tinyint(1) DEFAULT NULL,
  `isCredit` tinyint(1) DEFAULT NULL,
  `creditTerm` BIGINT DEFAULT NULL,
  PRIMARY KEY (`salesTransactionId`) USING BTREE,
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SalesTransaction`
--

LOCK TABLES `SalesTransaction` WRITE;
/*!40000 ALTER TABLE `SalesTransaction` DISABLE KEYS */;
INSERT INTO `SalesTransaction` VALUES (1,'2011-10-30 20:55:03',1,2,'300.0000','446.4286','53.5714','650.0000',0,1,30),(2,'2011-10-30 20:55:03',1,2,'100.0000','0.0000','0.0000','100.0000',1,0,NULL),(3,'2011-10-30 20:55:03',1,6,'100.0000','0.0000','0.0000','100.0000',1,0,NULL),(4,'2011-10-30 20:55:03',1,10,'100.0000','0.0000','0.0000','100.0000',1,0,NULL),(5,'2011-10-30 20:55:03',1,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'2011-10-30 20:55:03',1,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'2011-10-30 20:55:03',1,6,'200.0000','8973.2143','1076.7857','10550.0000',0,1,30),(8,'2011-10-30 20:55:03',1,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'2011-10-30 20:55:03',1,6,'100.0000','267.8571','32.1429','300.0000',0,1,30),(10,'2011-10-30 20:55:03',1,6,'200.0000','0.0000','0.0000','200.0000',1,0,NULL),(11,'2011-10-30 20:55:03',1,6,'100.0000','133.9286','16.0714','150.0000',0,1,30),(12,'2011-10-30 20:55:03',1,6,'200.0000','0.0000','0.0000','300.0000',0,1,30),(13,'2011-10-30 20:55:03',1,6,'200.0000','0.0000','0.0000','400.0000',0,1,30),(14,'2011-10-30 20:55:03',1,6,'300.0000','0.0000','0.0000','400.0000',0,1,30),(15,'2011-10-30 20:55:03',1,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'2011-10-30 20:55:03',1,1,'200.0000','0.0000','0.0000','300.0000',0,1,30),(17,'2011-10-30 20:55:03',1,6,'100.0000','0.0000','0.0000','300.0000',0,1,30),(18,'2011-10-30 20:55:03',1,6,'500.0000','312.5000','37.5000','800.0000',0,1,30),(19,'2011-10-30 20:55:03',1,6,'500.0000','5535.7143','664.2857','6250.0000',0,1,30),(20,'2011-10-30 20:55:03',1,6,'10200.0000','0.0000','0.0000','10200.0000',1,0,NULL),(21,'2011-08-14 14:15:10',1,6,'1552.0000','0.0000','0.0000','0.0000',0,1,30),(22,'2011-08-14 14:17:17',1,6,'6000.0000','1647.3214','197.6786','6000.0000',1,0,NULL),(23,'2011-08-14 14:45:15',1,6,'200.0000','178.5714','21.4286','200.0000',1,0,NULL),(24,'2011-10-16 00:00:00',1,6,'7300.0000','3750.0000','450.0000','7300.0000',1,0,NULL),(25,'2011-09-07 12:51:04',1,22,'400.0000','357.1429','42.8571','200.0000',0,1,60),(26,'2011-09-08 16:17:13',1,6,'3600.0000','0.0000','0.0000','100.0000',0,1,30);
/*!40000 ALTER TABLE `SalesTransaction` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trig_sales_transaction_insert BEFORE INSERT ON `SalesTransaction`
    FOR EACH ROW SET NEW.date = NOW() */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Store`
--

DROP TABLE IF EXISTS `Store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Store` (
  `storeId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
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
  `supplierId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`supplierId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Supplier`
--

LOCK TABLES `Supplier` WRITE;
/*!40000 ALTER TABLE `Supplier` DISABLE KEYS */;
INSERT INTO `Supplier` VALUES (1,'Toyota','1000 pesos'),(2,'Mitsubishi','10%');
/*!40000 ALTER TABLE `Supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `userId` BIGINT unsigned NOT NULL AUTO_INCREMENT,
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

-- Dump completed on 2011-10-30 21:18:54
