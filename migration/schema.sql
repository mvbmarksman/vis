-- MySQL dump 10.13  Distrib 5.1.54, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: vis
-- ------------------------------------------------------
-- Server version	5.1.54-1ubuntu4

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CreditDetail`
--

LOCK TABLES `CreditDetail` WRITE;
/*!40000 ALTER TABLE `CreditDetail` DISABLE KEYS */;
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
  `datePaid` datetime DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sales`
--

LOCK TABLES `Sales` WRITE;
/*!40000 ALTER TABLE `Sales` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SalesTransaction`
--

LOCK TABLES `SalesTransaction` WRITE;
/*!40000 ALTER TABLE `SalesTransaction` DISABLE KEYS */;
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

-- Dump completed on 2011-07-10 18:01:21
