CREATE TABLE IF NOT EXISTS `mptt` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `parent` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
