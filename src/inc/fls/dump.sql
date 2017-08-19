# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: nshd
# Generation Time: 2015-10-23 20:34:53 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;


# Dump of table nb_ads
# ------------------------------------------------------------

CREATE TABLE `nb_ads` (
  `id`         INT(11)            NOT NULL AUTO_INCREMENT,
  `url`        VARCHAR(140)
               CHARACTER SET utf8 NOT NULL,
  `picture`    INT(11)            NOT NULL,
  `text`       VARCHAR(280)
               CHARACTER SET utf8 NOT NULL,
  `advertiser` VARCHAR(140)
               CHARACTER SET utf8 NOT NULL,
  `dispFrom`   INT(11)            NOT NULL,
  `dispUntil`  INT(11)            NOT NULL,
  `area`       VARCHAR(140)
               CHARACTER SET utf8 NOT NULL,
  `addedBy`    INT(11)            NOT NULL,
  `addedAt`    INT(11)            NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_slovenian_ci;


# Dump of table nb_categories
# ------------------------------------------------------------

CREATE TABLE `nb_categories` (
  `id`        INT(11)            NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(140)
              CHARACTER SET utf8 NOT NULL,
  `showinnav` TINYINT(1)         NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_slovenian_ci;


# Dump of table nb_comments
# ------------------------------------------------------------

CREATE TABLE `nb_comments` (
  `id`          INT(11)            NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(140)
                CHARACTER SET utf8 NOT NULL,
  `parentPost`  INT(11)            NOT NULL,
  `parentReply` INT(11)            NOT NULL,
  `status`      INT(11)            NOT NULL,
  `distinguish` INT(11)            NOT NULL,
  `time`        INT(11)            NOT NULL,
  `email`       VARCHAR(140)
                CHARACTER SET utf8 NOT NULL,
  `content`     LONGTEXT
                CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_slovenian_ci;


# Dump of table nb_forums
# ------------------------------------------------------------

CREATE TABLE `nb_forums` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`        VARCHAR(140)              DEFAULT NULL,
  `description` VARCHAR(140)              DEFAULT NULL,
  `parentforum` INT(11)                   DEFAULT NULL,
  `cansee`      VARCHAR(140)              DEFAULT NULL,
  `canpost`     VARCHAR(140)              DEFAULT NULL,
  `canmod`      VARCHAR(140)              DEFAULT '',
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Dump of table nb_ipdb
# ------------------------------------------------------------

CREATE TABLE `nb_ipdb` (
  `id`      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip`      VARCHAR(140)              DEFAULT NULL,
  `isp`     VARCHAR(140)              DEFAULT NULL,
  `city`    VARCHAR(140)              DEFAULT NULL,
  `country` VARCHAR(140)              DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Dump of table nb_pages
# ------------------------------------------------------------

CREATE TABLE `nb_pages` (
  `id`           INT(11)                   NOT NULL AUTO_INCREMENT,
  `type`         VARCHAR(30)
                 CHARACTER SET utf8        NOT NULL,
  `showinnav`    TINYINT(1)                NOT NULL,
  `postpassword` VARCHAR(390)
                 CHARACTER SET utf8        NOT NULL,
  `salt`         VARCHAR(390)
                 CHARACTER SET utf8        NOT NULL,
  `status`       INT(11)                   NOT NULL,
  `time`         INT(11)                   NOT NULL,
  `tags`         VARCHAR(512)
                 CHARACTER SET utf8        NOT NULL,
  `category`     INT(11)                   NOT NULL,
  `parent`       INT(11)                   NOT NULL,
  `title`        VARCHAR(280)
                 CHARACTER SET utf8        NOT NULL,
  `body`         LONGTEXT
                 COLLATE utf8_slovenian_ci NOT NULL,
  `author`       INT(11)                   NOT NULL,
  `summary`      LONGTEXT
                 CHARACTER SET utf8        NOT NULL,
  `sources`      LONGTEXT
                 CHARACTER SET utf8        NOT NULL,
  `mainimg`      VARCHAR(140)
                 COLLATE utf8_slovenian_ci NOT NULL DEFAULT '',
  `slug`         VARCHAR(390)
                 COLLATE utf8_slovenian_ci          DEFAULT NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `body` (`body`),
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `summary` (`summary`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_slovenian_ci;


# Dump of table nb_photos
# ------------------------------------------------------------

CREATE TABLE `nb_photos` (
  `id`          INT(11)                   NOT NULL AUTO_INCREMENT,
  `photo`       VARCHAR(140)
                COLLATE utf8_slovenian_ci NOT NULL DEFAULT '',
  `author`      VARCHAR(140)
                CHARACTER SET utf8        NOT NULL,
  `uploader`    INT(11)                   NOT NULL,
  `time`        INT(11)                   NOT NULL,
  `description` LONGTEXT
                COLLATE utf8_slovenian_ci,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_slovenian_ci;


# Dump of table nb_places
# ------------------------------------------------------------

CREATE TABLE `nb_places` (
  `id`          INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `project`     INT(11)                   DEFAULT NULL,
  `name`        VARCHAR(140)
                COLLATE utf8_unicode_ci   DEFAULT NULL,
  `description` LONGTEXT
                COLLATE utf8_unicode_ci,
  `address`     VARCHAR(140)
                COLLATE utf8_unicode_ci   DEFAULT NULL,
  `imageUrl`    VARCHAR(140)
                COLLATE utf8_unicode_ci   DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;


# Dump of table nb_projects
# ------------------------------------------------------------

CREATE TABLE `nb_projects` (
  `id`   INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(140)
         COLLATE utf8_unicode_ci   DEFAULT NULL,
  `type` INT(11)                   DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;


# Dump of table nb_securitylogs
# ------------------------------------------------------------

CREATE TABLE `nb_securitylogs` (
  `id`      INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `action`  VARCHAR(140)
            COLLATE utf8_unicode_ci   DEFAULT NULL,
  `subject` INT(11)                   DEFAULT NULL,
  `object`  INT(11)                   DEFAULT NULL,
  `time`    INT(11)                   DEFAULT NULL,
  `ip`      VARCHAR(140)
            COLLATE utf8_unicode_ci   DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;


# Dump of table nb_sessions
# ------------------------------------------------------------

CREATE TABLE `nb_sessions` (
  `id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user`      INT(11)                   DEFAULT NULL,
  `ip`        VARCHAR(180)              DEFAULT NULL,
  `useragent` VARCHAR(180)              DEFAULT NULL,
  `time`      INT(11)                   DEFAULT NULL,
  `expires`   INT(11)                   DEFAULT NULL,
  `csrf`      VARCHAR(390)              DEFAULT NULL,
  `cookieid`  VARCHAR(390)              DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Dump of table nb_settings
# ------------------------------------------------------------

CREATE TABLE `nb_settings` (
  `id`     INT(11)      NOT NULL AUTO_INCREMENT,
  `engine` VARCHAR(140) NOT NULL,
  `setkey` VARCHAR(140) NOT NULL,
  `value`  VARCHAR(2048) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;

LOCK TABLES `nb_settings` WRITE;
/*!40000 ALTER TABLE `nb_settings` DISABLE KEYS */;

INSERT INTO `nb_settings` (`id`, `engine`, `setkey`, `value`)
VALUES
  (1, 'core', 'adminPanelPermissionHomepage', '2'),
  (2, 'core', 'adminPanelPermissionSettingsManager', '10'),
  (8, 'pluginManager', 'analytics:Enabled', '1'),
  (12, 'pluginManager', 'nativeComments:Enabled', '0'),
  (13, 'core', 'adminPanelPermissionChangeSetting', '10'),
  (18, 'core', 'adminPanelPermissionUserListViewer', '10'),
  (19, 'core', 'adminPanelPermissionManageNonselfUser', '10'),
  (20, 'core', 'adminPanelPermissionUpdatePage', '3'),
  (21, 'core', 'adminPanelPermissionAddPage', '2'),
  (22, 'core', 'adminPanelDeletePage', '5'),
  (23, 'core', 'adminPanelManageNonselfUser', '10'),
  (28, 'generators', 'postsPerPage', '10'),
  (30, 'core', 'publicRegistrationEnabled', '1'),
  (33, 'pluginManager', 'pluginManager:Enabled', '1'), 
  (34, 'design', 'logoLink', ''), 
  (35, 'design', 'headerContent', ''), 
  (36, 'design', 'footerContent', ''), 
  (37, 'core', 'disablePublicAPI', '0'); 



/*!40000 ALTER TABLE `nb_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table nb_threads
# ------------------------------------------------------------

CREATE TABLE `nb_threads` (
  `id`        INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`     VARCHAR(140)              DEFAULT NULL,
  `firstpost` INT(11)                   DEFAULT NULL,
  `sticky`    SMALLINT(1)               DEFAULT NULL,
  `locked`    SMALLINT(1)               DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Dump of table nb_users
# ------------------------------------------------------------

CREATE TABLE `nb_users` (
  `id`          INT(11)      NOT NULL AUTO_INCREMENT,
  `email`       VARCHAR(140) NOT NULL,
  `password`    VARCHAR(390) NOT NULL,
  `salt`        VARCHAR(390) NOT NULL,
  `name`        VARCHAR(140) NOT NULL,
  `level`       INT(11)      NOT NULL,
  `lastpassres` INT(11)      NOT NULL,
  `banned`      TINYINT(1)   NOT NULL,
  `opentime`    INT(11)      NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


# Dump of table nb_visits
# ------------------------------------------------------------

CREATE TABLE `nb_visits` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(11) DEFAULT NULL,
  `ip` varchar(140) DEFAULT NULL,
  `useragent` varchar(140) DEFAULT NULL,
  `ns_sid` varchar(140) DEFAULT NULL,
  `deliveryTime` varchar(70) DEFAULT NULL,
  `script` varchar(280) DEFAULT NULL,
  `method` varchar(140) DEFAULT NULL,
  `uri` varchar(280) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table nb_resets
# ------------------------------------------------------------

CREATE TABLE `nb_resets` (
  `id`            INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user`          INT(11)                   DEFAULT NULL,
  `passwordToken` VARCHAR(280)
                  COLLATE utf8_unicode_ci   DEFAULT NULL,
  `ip`            VARCHAR(140)
                  COLLATE utf8_unicode_ci   DEFAULT NULL,
  `time`          INT(11)                   DEFAULT NULL,
  `used`          INT(11)                   DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;


/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
