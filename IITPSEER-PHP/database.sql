SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `EntryExit` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `EntryExit`;


DROP TABLE IF EXISTS `Admin`;
CREATE TABLE IF NOT EXISTS `Admin` (
  `adminID` varchar(10) NOT NULL,
  `adminName` varchar(100) DEFAULT NULL,
  `paswd` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`adminID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Building`;
CREATE TABLE IF NOT EXISTS `Building` (
  `No` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `People`;
CREATE TABLE IF NOT EXISTS `People` (
  `ID` varchar(8) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `Branch` varchar(25) DEFAULT NULL,
  `PhoneNo` varchar(10) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `Register`;
CREATE TABLE IF NOT EXISTS `Register` (
  `EntryID` int(11) NOT NULL AUTO_INCREMENT,
  `ID` varchar(8) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `BuildingNo` int(11) DEFAULT NULL,
  `EntryTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ExitTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`EntryID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;