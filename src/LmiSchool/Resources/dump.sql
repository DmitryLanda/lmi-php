CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL UNIQUE,
  `title` varchar(255) NOT NULL UNIQUE,
  `tags` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 ;

ALTER TABLE `documents` ADD COLUMN `id` int(11);
UPDATE `documents` SET `id` = `doc_id`;
ALTER TABLE `documents` CHANGE `id` `id` INT( 11 ) NOT NULL;
