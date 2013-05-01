-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(8) NOT NULL AUTO_INCREMENT,
  `blog_title` varchar(60) NOT NULL,
  `blog_url_title` varchar(60) NOT NULL,
  `blog_cat` int(8) NOT NULL,
  `blog_date` varchar(25) NOT NULL,
  `blog_entry` longtext NOT NULL,
  `blog_img_library` int(14) NOT NULL,
  `blog_hide` int(2) NOT NULL,
  `author_id` int(8) NOT NULL,
  PRIMARY KEY (`blog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `cat_id` int(8) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(255) NOT NULL,
  `cat_url_title` varchar(255) NOT NULL,
  `cat_parent` int(8) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------