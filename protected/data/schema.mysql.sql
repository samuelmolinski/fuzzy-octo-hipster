
--
-- Table structure for table `ni_combinationdrawn`
--

CREATE TABLE IF NOT EXISTS `ni_lf_combinationdrawn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `combination` varchar(30) NOT NULL,
  `date` varchar(10) NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


--
-- Table structure for table `ni_combinationset`
--

CREATE TABLE IF NOT EXISTS `ni_lf_combinationset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `combinations` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

--
-- Table structure for table `ni_enginesettings`
--

CREATE TABLE IF NOT EXISTS `ni_lf_enginesettings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL COMMENT 'user given name',
  `users` text NOT NULL COMMENT 'serialize',
  `numOfCombs` int(11) NOT NULL COMMENT 'total number of Combs to generate',
  `amountPerGroup` int(11) NOT NULL COMMENT 'how many Combs per page/group',
  `ruleOrder` text NOT NULL COMMENT 'serialize',
  `ranges1a1` text NOT NULL COMMENT 'serialize',
  `group2_2` text NOT NULL COMMENT 'serialize',
  `permitted1a8` text NOT NULL COMMENT 'serialize',
  `rule_2_2_2_limit` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

--
-- Table structure for table `ni_systemoptions`
--

CREATE TABLE IF NOT EXISTS `ni_lf_systemoptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `value` text NOT NULL,
  `autoload` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
