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
  `creditPaymentId` bigint(20) NOT NULL AUTO_INCREMENT,
  `customerId` bigint(20) NOT NULL,
  `salesTransactionId` bigint(20) NOT NULL,
  `datePaid` datetime DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL,
  PRIMARY KEY (`creditPaymentId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CreditPayment`
--

LOCK TABLES `CreditPayment` WRITE;
/*!40000 ALTER TABLE `CreditPayment` DISABLE KEYS */;
INSERT INTO `CreditPayment` VALUES (1,6,6,'2011-07-27 00:23:57','50'),(2,8,2,'2011-08-13 14:30:29','50'),(3,20,13,'2011-08-14 00:45:31','0'),(4,19,2,'2011-08-14 01:52:20','300'),(5,10,3,'2011-08-14 02:09:29','192'),(6,6,1,'2011-08-14 02:13:19','600'),(7,6,1,'2011-08-14 02:14:34','600'),(8,6,2,'2011-08-14 02:25:52','5000'),(9,6,4,'2011-08-14 03:14:07','830'),(10,10,8,'2011-08-14 12:42:51','9000'),(11,10,9,'2011-08-14 12:43:19','50'),(12,2,1,'2011-08-14 12:46:12','650'),(13,6,7,'2011-08-14 13:24:16','10550'),(14,6,9,'2011-08-14 13:28:09','300'),(15,6,11,'2011-08-14 13:31:14','150'),(16,6,12,'2011-08-14 13:31:32','300'),(17,6,13,'2011-08-14 13:36:16','400'),(18,6,14,'2011-08-14 13:37:27','400'),(19,1,16,'2011-08-14 13:50:39','300'),(20,6,17,'2011-08-14 13:51:01','300'),(21,6,18,'2011-08-14 13:53:02','800'),(22,6,19,'2011-08-14 13:56:04','6250'),(23,6,21,'2011-08-14 14:15:10','0'),(24,22,25,'2011-09-07 12:51:04','200'),(25,6,26,'2011-09-08 16:17:13','100'),(26,41,37,'2011-11-03 19:31:40','0');
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
  `customerId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) COLLATE utf8_bin NOT NULL,
  `address` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `phoneNo` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`customerId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Customer`
--

LOCK TABLES `Customer` WRITE;
/*!40000 ALTER TABLE `Customer` DISABLE KEYS */;
INSERT INTO `Customer` VALUES (4,'mark basmayor','',''),(5,'mark basmayor','','');
/*!40000 ALTER TABLE `Customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Item`
--

DROP TABLE IF EXISTS `Item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Item` (
  `itemId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `productCode` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `description` varchar(50) COLLATE utf8_bin NOT NULL,
  `itemTypeId` bigint(20) unsigned NOT NULL,
  `isUsed` tinyint(4) NOT NULL DEFAULT '0',
  `latestBuyingPrice` decimal(18,4) DEFAULT '0.0000',
  `dateAdded` datetime DEFAULT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Item`
--

LOCK TABLES `Item` WRITE;
/*!40000 ALTER TABLE `Item` DISABLE KEYS */;
INSERT INTO `Item` VALUES (1,'GAFP','Glade Air Freshener Pine',2,0,'1.0000','2011-11-07 16:10:44',1);
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
-- Table structure for table `ItemExpense`
--

DROP TABLE IF EXISTS `ItemExpense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ItemExpense` (
  `itemExpenseId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `itemId` bigint(20) unsigned NOT NULL,
  `price` decimal(18,4) NOT NULL,
  `quantity` int(11) NOT NULL,
  `supplierId` bigint(20) unsigned DEFAULT NULL,
  `discount` decimal(18,4) DEFAULT NULL,
  `isCredit` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'not updated, historical record to determine if an expense was credited',
  `isFullyPaid` tinyint(1) DEFAULT NULL COMMENT 'set to 1 when credit payments have been made',
  `dateAdded` datetime DEFAULT NULL,
  `userId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`itemExpenseId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ItemExpense`
--

LOCK TABLES `ItemExpense` WRITE;
/*!40000 ALTER TABLE `ItemExpense` DISABLE KEYS */;
INSERT INTO `ItemExpense` VALUES (1,1,'100.0000',50,1,'0.0000',0,NULL,'2011-11-07 16:10:44',1),(2,1,'1.0000',1,NULL,'0.0000',0,NULL,'2011-11-07 20:41:42',1);
/*!40000 ALTER TABLE `ItemExpense` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trig_itemexpense_insert BEFORE INSERT ON `ItemExpense`
    FOR EACH ROW SET NEW.dateAdded = IFNULL(NEW.dateAdded, NOW()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ItemType`
--

DROP TABLE IF EXISTS `ItemType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ItemType` (
  `itemTypeId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`itemTypeId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ItemType`
--

LOCK TABLES `ItemType` WRITE;
/*!40000 ALTER TABLE `ItemType` DISABLE KEYS */;
INSERT INTO `ItemType` VALUES (1,'Adaptor Wheel'),(2,'Air Freshener'),(3,'Spoiler'),(4,'Tires'),(5,'Auto Cover'),(6,'Tint'),(7,'Speakers');
/*!40000 ALTER TABLE `ItemType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OtherExpense`
--

DROP TABLE IF EXISTS `OtherExpense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `OtherExpense` (
  `otherExpenseId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(50) NOT NULL,
  `price` decimal(18,4) NOT NULL,
  `payee` varchar(50) DEFAULT NULL,
  `isCredit` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'not updated, historical record used to determine if an expense was credited',
  `isFullyPaid` tinyint(4) NOT NULL COMMENT 'set to 1 when full payment has been made\n',
  `dateAdded` datetime DEFAULT NULL,
  `userId` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`otherExpenseId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OtherExpense`
--

LOCK TABLES `OtherExpense` WRITE;
/*!40000 ALTER TABLE `OtherExpense` DISABLE KEYS */;
/*!40000 ALTER TABLE `OtherExpense` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER trig_otherexpense_insert BEFORE INSERT ON `OtherExpense`
    FOR EACH ROW SET NEW.dateAdded = IFNULL(NEW.dateAdded, NOW()) */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Sales`
--

DROP TABLE IF EXISTS `Sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sales` (
  `salesId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `salesTransactionId` bigint(20) unsigned NOT NULL,
  `itemId` bigint(20) unsigned NOT NULL,
  `sellingPrice` decimal(18,4) unsigned NOT NULL,
  `qty` bigint(20) unsigned NOT NULL,
  `discount` bigint(20) unsigned DEFAULT NULL,
  `storeId` bigint(20) unsigned NOT NULL,
  `subTotal` decimal(18,4) DEFAULT NULL,
  `vatable` decimal(18,4) DEFAULT NULL,
  `vat` decimal(18,4) DEFAULT NULL,
  PRIMARY KEY (`salesId`),
  KEY `salesTransactionId` (`salesTransactionId`),
  KEY `itemDetailId` (`itemId`),
  KEY `storeId` (`storeId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sales`
--

LOCK TABLES `Sales` WRITE;
/*!40000 ALTER TABLE `Sales` DISABLE KEYS */;
INSERT INTO `Sales` VALUES (4,4,1,'100.0000',50,1,1,'4999.0000','4463.3929','535.6071'),(5,5,1,'1.0000',1,0,0,'1.0000',NULL,NULL);
/*!40000 ALTER TABLE `Sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `SalesTransaction`
--

DROP TABLE IF EXISTS `SalesTransaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `SalesTransaction` (
  `salesTransactionId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `userId` bigint(20) unsigned NOT NULL,
  `customerId` bigint(20) unsigned DEFAULT NULL,
  `totalPrice` decimal(18,4) DEFAULT NULL,
  `totalVatable` decimal(18,4) DEFAULT NULL,
  `totalVat` decimal(18,4) DEFAULT NULL,
  `totalAmountPaid` decimal(18,4) DEFAULT NULL,
  `isFullyPaid` tinyint(1) DEFAULT NULL COMMENT 'set to1 when credit payments total to the total amount',
  `isCredit` tinyint(1) DEFAULT NULL COMMENT 'not updated, historical record used to determine if an item was credited',
  `creditTerm` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`salesTransactionId`) USING BTREE,
  KEY `userId` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `SalesTransaction`
--

LOCK TABLES `SalesTransaction` WRITE;
/*!40000 ALTER TABLE `SalesTransaction` DISABLE KEYS */;
INSERT INTO `SalesTransaction` VALUES (4,'2011-11-07 16:11:42',1,4,'4999.0000','4463.3929','535.6071','4999.0000',1,0,NULL),(5,'2011-11-07 20:41:57',1,5,'1.0000','0.0000','0.0000','1.0000',1,0,NULL);
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
-- Table structure for table `Stock`
--

DROP TABLE IF EXISTS `Stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Stock` (
  `itemId` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Stock`
--

LOCK TABLES `Stock` WRITE;
/*!40000 ALTER TABLE `Stock` DISABLE KEYS */;
INSERT INTO `Stock` VALUES (1,0);
/*!40000 ALTER TABLE `Stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Supplier`
--

DROP TABLE IF EXISTS `Supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Supplier` (
  `supplierId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `address` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`supplierId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Supplier`
--

LOCK TABLES `Supplier` WRITE;
/*!40000 ALTER TABLE `Supplier` DISABLE KEYS */;
INSERT INTO `Supplier` VALUES (1,'Toyota Pasong Tamo','Pasong Tamo, Makati');
/*!40000 ALTER TABLE `Supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `userId` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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

-- Dump completed on 2011-11-07 20:42:19
