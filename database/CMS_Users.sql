# Dump of table CMS_Users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CMS_Users`;

CREATE TABLE `CMS_Users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) DEFAULT 'undefined',
  `password` varchar(255) DEFAULT 'nopassword',
  `passwordtype` varchar(255) DEFAULT 'undefined',
  `email` varchar(255) DEFAULT 'undefined',
  `language` varchar(255) DEFAULT 'undefined',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
