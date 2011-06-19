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
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
