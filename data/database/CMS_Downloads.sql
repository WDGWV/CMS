# Dump of table CMS_Downloads
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CMS_Downloads`;

CREATE TABLE `CMS_Downloads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `downloads` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
