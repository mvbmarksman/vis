DROP DATABASE vis;
CREATE DATABASE vis;
USE vis;

DROP TABLE IF EXISTS `Credit`;
CREATE TABLE `Credit` (
  `creditId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullName` VARCHAR(100) NOT NULL,
  `address` VARCHAR(200),
  `phoneNo` VARCHAR(20),
  `amountPaid` DECIMAL(18,4),
  PRIMARY KEY (`creditId`)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `ExpenseTransaction`;
CREATE TABLE `ExpenseTransaction` (
  `expenseTransacationId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL ,
  PRIMARY KEY (`expenseTransacationId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `Expense`;
CREATE TABLE `Expense` (
  `expenseId` INTEGER UNSIGNED NULL AUTO_INCREMENT,
  `expenseTransactionId` INT UNSIGNED,
  `description` VARCHAR(100),
  `price` DECIMAL(18,4),
  `disburser` VARCHAR(30),
  PRIMARY KEY (`expenseId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `InventoryItemExpense`;
CREATE TABLE `InventoryItemExpense` (
  `inventoryItemExpenseId` INT UNSIGNED AUTO_INCREMENT,
  `expenseTransactionId` INT UNSIGNED,
  `itemDetailId` INT UNSIGNED,
  `unitPrice` DECIMAL(18,4) NOT NULL,
  `qty` INTEGER NOT NULL,
  `disburser` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`inventoryItemExpenseId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `ItemDetail`;
CREATE TABLE `ItemDetail` (
  `itemDetailId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `productCode` VARCHAR(50) NULL,
  `itemTypeId` INT UNSIGNED NULL,
  `description` VARCHAR(100) NOT NULL,
  `unit` VARCHAR(10) NOT NULL,
  `buyingPrice` DECIMAL(18,4) NOT NULL,
  `isUsed` BOOLEAN NOT NULL,
  `sellingPrice` DECIMAL(18,4) NOT NULL,
  `supplierId` INT UNSIGNED NULL,
  PRIMARY KEY (`itemDetailId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `Item`;
CREATE TABLE `Item` (
  `itemId` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `itemDetailId` INT UNSIGNED NOT NULL ,
  `storeId` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `ItemType`;
CREATE TABLE `ItemType` (
  `itemTypeId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`itemTypeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `Sales`;
CREATE TABLE `Sales` (
  `salesId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `salesTransactionId` INT UNSIGNED NOT NULL ,
  `itemDetailId` INT UNSIGNED NOT NULL,
  `unitPrice` INT UNSIGNED NOT NULL ,
  `qty` INT UNSIGNED NOT NULL,
  `discount` INT UNSIGNED NULL,
  `storeId` INT UNSIGNED NOT NULL ,
  `isVAT` BOOLEAN NOT NULL ,
  PRIMARY KEY (`salesId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `SalesTransaction`;
CREATE TABLE `SalesTransaction` (
  `salesTransactionID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATETIME,
  `userId` INT UNSIGNED NOT NULL,
  `creditId` INT UNSIGNED NULL DEFAULT NULL,
  `totalPrice` DECIMAL(18,4),
  `isFullyPaid` Boolean NOT NULL,
  PRIMARY KEY (`salesTransactionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `Store`;
CREATE TABLE `Store` (
  `storeId` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(50) NOT NULL ,
  `location` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`storeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `Supplier`;
CREATE TABLE `Supplier` (
  `supplierId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `discount` VARCHAR(30) DEFAULT NULL,
  PRIMARY KEY (`supplierId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
  `userId` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `firstName` VARCHAR(30) NOT NULL,
  `lastName` VARCHAR(30) NOT NULL,
  `isAdmin` BOOLEAN NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Foreign Keys
-- ---

ALTER TABLE `ItemDetail` ADD FOREIGN KEY (itemTypeId) REFERENCES `ItemType` (`itemTypeId`);
ALTER TABLE `ItemDetail` ADD FOREIGN KEY (itemTypeId) REFERENCES `ItemType` (`itemTypeId`);
ALTER TABLE `ItemDetail` ADD FOREIGN KEY (supplierId) REFERENCES `Supplier` (`supplierId`);
ALTER TABLE `Item` ADD FOREIGN KEY (itemDetailId) REFERENCES `ItemDetail` (`itemDetailId`);
ALTER TABLE `Item` ADD FOREIGN KEY (storeId) REFERENCES `Store` (`storeId`);
ALTER TABLE `Sales` ADD FOREIGN KEY (salesTransactionId) REFERENCES `SalesTransaction` (`salesTransactionID`);
ALTER TABLE `Sales` ADD FOREIGN KEY (itemDetailId) REFERENCES `ItemDetail` (`itemDetailId`);
ALTER TABLE `Sales` ADD FOREIGN KEY (storeId) REFERENCES `Store` (`storeId`);
ALTER TABLE `SalesTransaction` ADD FOREIGN KEY (userId) REFERENCES `User` (`userId`);
ALTER TABLE `SalesTransaction` ADD FOREIGN KEY (creditId) REFERENCES `Credit` (`creditId`);
ALTER TABLE `InventoryItemExpense` ADD FOREIGN KEY (expenseTransactionId) REFERENCES `ExpenseTransaction` (`expenseTransacationId`);
ALTER TABLE `InventoryItemExpense` ADD FOREIGN KEY (itemDetailId) REFERENCES `ItemDetail` (`itemDetailId`);
ALTER TABLE `Expense` ADD FOREIGN KEY (expenseTransactionId) REFERENCES `ExpenseTransaction` (`expenseTransacationId`);
