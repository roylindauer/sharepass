
CREATE TABLE `linkdata` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `key` char(13) NOT NULL DEFAULT '',
  `data` text,
  `created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expires` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;