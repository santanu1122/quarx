-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `events` (
  `event_id` int(8) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(60) NOT NULL,
  `event_url_title` varchar(60) NOT NULL,
  `event_cat` int(8) NOT NULL,
  `event_start_date` date NOT NULL,
  `event_end_date` date NOT NULL,
  `event_entry` longtext NOT NULL,
  `event_img_library` int(14) NOT NULL,
  `event_hide` int(2) NOT NULL,
  `author_id` int(8) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_categories`
--

CREATE TABLE `event_categories` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) NOT NULL,
  `cat_url_title` varchar(255) NOT NULL,
  `cat_parent` int(8) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------