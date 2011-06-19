DROP TABLE IF EXISTS `User`;

CREATE TABLE `User` (
  `userId` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(50) NOT NULL,
  `firstName` VARCHAR(30) NOT NULL,
  `lastName` VARCHAR(30) NOT NULL,
  `isAdmin` BOOLEAN NOT NULL,
  PRIMARY KEY (`userId`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
