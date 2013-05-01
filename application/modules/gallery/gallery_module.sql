-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(8) NOT NULL AUTO_INCREMENT,
  `gallery_title` varchar(60) NOT NULL,
  `gallery_url_title` varchar(60) NOT NULL,
  `gallery_cat` int(8) NOT NULL,
  `gallery_date` varchar(25) NOT NULL,
  `gallery_entry` longtext NOT NULL,
  `gallery_img_library` int(14) NOT NULL,
  `gallery_hide` int(2) NOT NULL,
  `author_id` int(8) NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_categories`
--

CREATE TABLE `gallery_categories` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) NOT NULL,
  `cat_url_title` varchar(255) NOT NULL,
  `cat_parent` int(8) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------