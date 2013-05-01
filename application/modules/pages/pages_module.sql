--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(8) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(60) NOT NULL,
  `page_url_title` varchar(60) NOT NULL,
  `page_parent` int(8) NOT NULL,
  `page_entry` longtext NOT NULL,
  `page_img_library` int(14) NOT NULL,
  `page_hide` int(2) NOT NULL,
  `author_id` int(8) NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------