--
-- Table structure for table `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `inbox_id` int(14) NOT NULL AUTO_INCREMENT,
  `inbox_user_id` int(14) NOT NULL,
  `inbox_from` int(14) NOT NULL,
  `inbox_title` varchar(255) NOT NULL,
  `inbox_message` text NOT NULL,
  `inbox_viewed` varchar(40) NOT NULL DEFAULT 'no',
  `inbox_send` varchar(255) NOT NULL,
  PRIMARY KEY (`inbox_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------