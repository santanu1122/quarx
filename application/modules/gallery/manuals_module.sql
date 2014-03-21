-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
    `gallery_id` int(8) NOT NULL AUTO_INCREMENT,
    `gallery_name` varchar(60) NOT NULL,
    `gallery_product_code` varchar(160) NOT NULL,
    `gallery_serial_number` varchar(160) NOT NULL,
    `gallery_url_name` varchar(60) NOT NULL,
    `gallery_date` varchar(25) NOT NULL,
    `gallery_entry` longtext NOT NULL,
    `gallery_img` varchar(255) NOT NULL,
    `gallery_hide` int(2) NOT NULL,
    PRIMARY KEY (`gallery_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `manual files`
--

CREATE TABLE `manual_file` (
    `manual_file_id` int(8) NOT NULL AUTO_INCREMENT,
    `manual_file_name` varchar(255) NOT NULL,
    `manual_file_location` varchar(255) NOT NULL,
    `manual_file_owner` int(8) NOT NULL,
    PRIMARY KEY (`manual_file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;