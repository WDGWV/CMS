# Dump of table CMS_Pages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CMS_Pages`;

CREATE TABLE `CMS_Pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `content` text,
  `version` text,
  `status` enum('au','re','fi','la') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
