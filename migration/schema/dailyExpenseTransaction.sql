DROP TABLE IF EXISTS `DailyExpenseTransaction`;

CREATE TABLE `DailyExpenseTransaction` (
  `dailyExpenseTransacationId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` DATETIME NOT NULL ,
  PRIMARY KEY (`dailyExpenseTransacationId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
