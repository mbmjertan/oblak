# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: poslovniOblak
# Generation Time: 2017-01-02 00:08:39 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table {{OBLAK_DB_PREFIX}}_bills
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_bills`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_bills` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billNumber` int(11) DEFAULT NULL,
  `businessAreaNumber` int(11) DEFAULT NULL,
  `deviceNumber` int(11) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `paymentDeadlineDate` date DEFAULT NULL,
  `expirationDate` date DEFAULT NULL,
  `buyerID` int(11) DEFAULT NULL,
  `buyerName` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyerAddress` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyerOIB` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `paymentType` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `operatorID` int(11) DEFAULT NULL,
  `callNumber` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `IBAN` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billProviderName` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billProviderOIB` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billProviderEmail` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billProviderAddress` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billProviderWeb` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billProviderPhone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billProviderMail` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billFootnotes` text COLLATE utf8mb4_unicode_ci,
  `billStatus` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billStatusDate` date DEFAULT NULL,
  `billLink` int(11) DEFAULT NULL,
  `logoFileRevisionID` int(11) DEFAULT NULL,
  `pdfExportFileID` int(11) DEFAULT NULL,
  `linkFileID` int(11) DEFAULT NULL,
  `buyerEmail` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `buyerPhone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billDiscountPercentage` int(11) DEFAULT NULL,
  `billDiscountAmount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table {{OBLAK_DB_PREFIX}}_billsItems
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_billsItems`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_billsItems` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `billID` int(11) DEFAULT NULL,
  `billOrderCoef` decimal(15,15) DEFAULT NULL,
  `itemDescription` text COLLATE utf8mb4_unicode_ci,
  `itemUnit` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `itemQuantity` decimal(30,15) DEFAULT NULL,
  `itemPrice` int(11) DEFAULT NULL,
  `itemDiscountPercentage` int(11) DEFAULT NULL,
  `itemDiscountAmount` int(11) DEFAULT NULL,
  `itemEquals` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table {{OBLAK_DB_PREFIX}}_files
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_files`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mimetype` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `size` int(100) DEFAULT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filePath` varchar(280) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fileContent` longtext COLLATE utf8mb4_unicode_ci,
  `revisionID` int(11) DEFAULT NULL,
  `storageType` int(4) DEFAULT NULL,
  `fileReference` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `{{OBLAK_DB_PREFIX}}_files` WRITE;
/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_files` DISABLE KEYS */;

INSERT INTO `{{OBLAK_DB_PREFIX}}_files` (`id`, `type`, `mimetype`, `parent`, `size`, `name`, `filePath`, `fileContent`, `revisionID`, `storageType`, `fileReference`)
VALUES
  (0,'folder','',-1,0,'Korijenski direktorij','',NULL,89,0,NULL),
  (1,'folder',NULL,0,NULL,'Tvrtka (dijeljena mapa)',NULL,NULL,85,NULL,NULL),
  (2,'folder',NULL,0,NULL,'{{adminName}} {{adminSurname}}',NULL,NULL,85,NULL,NULL);



  /*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_files` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table {{OBLAK_DB_PREFIX}}_fileShares
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_fileShares`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_fileShares` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fileID` int(11) DEFAULT NULL,
  `fileShareType` int(11) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `userGrant` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publicAccessLink` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grantExpiryTimestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `{{OBLAK_DB_PREFIX}}_fileShares` WRITE;
/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_fileShares` DISABLE KEYS */;

INSERT INTO `{{OBLAK_DB_PREFIX}}_fileShares` (`id`, `fileID`, `fileShareType`, `userID`, `userGrant`, `publicAccessLink`, `grantExpiryTimestamp`)
VALUES
  (1,1,4,1,NULL,NULL,NULL),
  (2,2,4,1,NULL,NULL,NULL);

/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_fileShares` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table {{OBLAK_DB_PREFIX}}_filesOldRevisions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_filesOldRevisions`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_filesOldRevisions` (
  `revisionID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fileID` int(11) DEFAULT NULL,
  `filePath` varchar(280) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fileContent` longtext COLLATE utf8mb4_unicode_ci,
  `isCurrentRevision` tinyint(1) DEFAULT NULL,
  `revisionAuthor` int(11) DEFAULT NULL,
  `revisionTime` int(11) DEFAULT NULL,
  `revisionSession` int(11) DEFAULT NULL,
  PRIMARY KEY (`revisionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


# Dump of table {{OBLAK_DB_PREFIX}}_logs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_logs`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_logs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `objectType` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `objectID` int(11) DEFAULT NULL,
  `logMessage` varchar(620) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table {{OBLAK_DB_PREFIX}}_notifications
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_notifications`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_notifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `toUser` int(11) DEFAULT NULL,
  `fromUser` int(11) DEFAULT NULL,
  `fromSystem` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `actedUpon` tinyint(1) DEFAULT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `readTimestamp` int(11) DEFAULT NULL,
  `contextualNodeType` varchar(140) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contextualNodeID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table {{OBLAK_DB_PREFIX}}_people
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_people`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_people` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastName` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guessedSpelling` varchar(360) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `{{OBLAK_DB_PREFIX}}_people` VALUES (1, '{{adminName}}', '{{adminSurname}}', '{{adminName}} {{adminSurname}}');

# Dump of table {{OBLAK_DB_PREFIX}}_peopleCategories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_peopleCategories`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_peopleCategories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table {{OBLAK_DB_PREFIX}}_peopleGroups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_peopleGroups`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_peopleGroups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `{{OBLAK_DB_PREFIX}}_peopleGroups` WRITE;
/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_peopleGroups` DISABLE KEYS */;

INSERT INTO `{{OBLAK_DB_PREFIX}}_peopleGroups` (`id`, `name`, `parent`)
VALUES
  (1,'Zaposlenici',0);

/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_peopleGroups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table {{OBLAK_DB_PREFIX}}_peopleGroupSettings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_peopleGroupSettings`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_peopleGroupSettings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canBeOverwrittenByPersonSettings` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table {{OBLAK_DB_PREFIX}}_peopleGroupsRights
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_peopleGroupsRights`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_peopleGroupsRights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rightName` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rightValue` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table {{OBLAK_DB_PREFIX}}_peopleMetadata
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_peopleMetadata`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_peopleMetadata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `personID` int(11) DEFAULT NULL,
  `attributeName` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributeValue` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `{{OBLAK_DB_PREFIX}}_peopleMetadata` WRITE;
/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_peopleMetadata` DISABLE KEYS */;

INSERT INTO `{{OBLAK_DB_PREFIX}}_peopleMetadata` (`id`, `personID`, `attributeName`, `attributeValue`)
VALUES
  (1,1,'groupMembership','1'),
  (5,1,'walkthroughsEnabled','1'),
  (6,1,'filesWalkthroughEnabled','1'),
  (7,1,'billsWalkthroughEnabled','1'),
  (8,1,'newsWalkthroughEnabled','1'),
  (9,1,'peopleWalkthroughEnabled','1');

/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_peopleMetadata` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table {{OBLAK_DB_PREFIX}}_peopleMetametadata
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_peopleMetametadata`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_peopleMetametadata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `attributeName` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributeType` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `definedBy` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attributeHumanReadableName` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `{{OBLAK_DB_PREFIX}}_peopleMetametadata` WRITE;
/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_peopleMetametadata` DISABLE KEYS */;

INSERT INTO `{{OBLAK_DB_PREFIX}}_peopleMetametadata` (`id`, `attributeName`, `attributeType`, `definedBy`, `attributeHumanReadableName`)
VALUES
  (1,'email','varchar','system','Email'),
  (2,'mobile','phone','system','Mobitel'),
  (3,'address','text','system','Adresa'),
  (4,'phone','phone','system','Telefon'),
  (5,'company','text','system','Tvrtka'),
  (6,'birthday','date','system','Rođendan');

/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_peopleMetametadata` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table {{OBLAK_DB_PREFIX}}_peoplePersonSettings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_peoplePersonSettings`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_peoplePersonSettings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table {{OBLAK_DB_PREFIX}}_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_sessions`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_sessions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(11) DEFAULT NULL,
  `ip` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `useragent` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  `csrf` varchar(390) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookieid` varchar(390) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
# Dump of table {{OBLAK_DB_PREFIX}}_siteSettings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_siteSettings`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_siteSettings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canBeOverwrittenByGroupSettings` tinyint(1) DEFAULT '0',
  `canBeOverwittenByPersonSettings` tinyint(1) DEFAULT '0',
  `isTemplateSetting` tinyint(1) DEFAULT '0',
  `isProtectedSetting` tinyint(1) DEFAULT '0',
  `isSecretSetting` tinyint(1) DEFAULT '0',
  `encrypted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `{{OBLAK_DB_PREFIX}}_siteSettings` WRITE;
/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_siteSettings` DISABLE KEYS */;

INSERT INTO `{{OBLAK_DB_PREFIX}}_siteSettings` (`id`, `name`, `value`, `canBeOverwrittenByGroupSettings`, `canBeOverwittenByPersonSettings`, `isTemplateSetting`, `isProtectedSetting`, `isSecretSetting`, `encrypted`)
VALUES
  (6,'businessCountry','HR',0,0,0,0,0,0),
  (7,'appLanguage','HR',0,0,0,0,0,0),
  (8,'startBillsFromNumber/racun/2017','1',0,0,0,0,0,0),
  (9,'businessVATRateType','NoVAT',0,0,0,0,0,0),
  (12,'businessCallNumberTemplate','GGGGMMDD-BPU',0,0,0,0,0,0),
  (13,'billDefaultBusinessAreaNumber/2017','1',0,0,0,0,0,0),
  (14,'billDefaultDeviceNumber','1',0,0,0,0,0,0),
  (15,'billFootnotes','Unesite podnožje računa.',0,0,0,0,0,0),
  (19,'basicConfigSet','1',0,0,0,0,0,0),
  (20,'billTableLayout','normal',0,0,0,0,0,0),
  (21,'businessName','{{name}}',0,0,0,0,0,0),
  (22,'businessType','{{type}}',0,0,0,0,0,0),
  (23,'businessMainAddress','{{BMA}}',0,0,0,0,0,0),
  (24,'businessMainPostcode','{{BMP}}',0,0,0,0,0,0),
  (25,'businessMainCity','{{BMC}}',0,0,0,0,0,0),
  (26,'businessWeb','{{BW}}',0,0,0,0,0,0),
  (27,'businessPhone','{{BP}}',0,0,0,0,0,0),
  (28,'businessMail','{{BM}}',0,0,0,0,0,0),
  (29,'businessMainIBAN','{{IBAN}}',0,0,0,0,0,0);






/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_siteSettings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table {{OBLAK_DB_PREFIX}}_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_users`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `{{OBLAK_DB_PREFIX}}_users` VALUES(null, '{{primaryContactEmail}}', '{{adminUsername}}', '{{adminPassword}}', 1);


DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_resets`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_resets` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `expon` int(11) DEFAULT NULL,
  `used` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



DROP TABLE IF EXISTS `{{OBLAK_DB_PREFIX}}_posts`;

CREATE TABLE `{{OBLAK_DB_PREFIX}}_posts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `parent` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `{{OBLAK_DB_PREFIX}}_posts` WRITE;
/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_posts` DISABLE KEYS */;

INSERT INTO `{{OBLAK_DB_PREFIX}}_posts` (`id`, `author`, `time`, `body`, `parent`, `likes`)
VALUES
  (1,1,{{OBLAK_GENTIME}},'Dobro došli u Poslovni oblak! Ovo je automatski generiran status od strane sustava.',0,0);

/*!40000 ALTER TABLE `{{OBLAK_DB_PREFIX}}_posts` ENABLE KEYS */;
UNLOCK TABLES;


INSERT INTO `instances` VALUES(null,'{{name}}', '{{OBLAK_DB_PREFIX}}', 0, null, '{{primaryContactEmail}}', '{{primaryContactPhoneNumber}}','{{OBLAK_DB_PREFIX}}', null, null);

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
