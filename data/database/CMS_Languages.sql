# Dump of table CMS_Languages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `CMS_Languages`;

CREATE TABLE `CMS_Languages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(255) DEFAULT NULL,
  `orginal` varchar(255) DEFAULT '',
  `text` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `CMS_Languages` WRITE;
/*!40000 ALTER TABLE `CMS_Languages` DISABLE KEYS */;

INSERT INTO `CMS_Languages` (`id`, `lang`, `orginal`, `text`)
VALUES
	(1,'nl','hello','Hallo'),
	(2,'en','hello','Hello'),
	(3,'de','hello','Hallo'),
	(4,'fr','hello','Bonjour'),
	(5,'nl','welcome','Welkom'),
	(6,'en','welcome','Welcome'),
	(7,'de','welcome','Willkommen'),
	(8,'fr','welcome','Accueil'),
	(9,'nl','by','bij'),
	(10,'en','by','by'),
	(11,'de','by','mit'),
	(12,'fr','by','avec');

/*!40000 ALTER TABLE `CMS_Languages` ENABLE KEYS */;
UNLOCK TABLES;
