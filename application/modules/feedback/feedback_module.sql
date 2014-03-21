--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
    `fb_id` int(14) NOT NULL AUTO_INCREMENT,
    `fb_client_first_name` varchar(255) NOT NULL,
    `fb_client_last_name` varchar(255) NOT NULL,
    `fb_client_location` varchar(255) NOT NULL,
    `fb_client_email` varchar(255) NOT NULL,
    `fb_key` varchar(255) NOT NULL,
    `fb_services` varchar(255) NOT NULL,
    `fb_sales_rep` varchar(255) NOT NULL,
    `fb_status` varchar(100) NOT NULL,
    `fb_date` varchar(100) NOT NULL,
    PRIMARY KEY (`fb_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_rating`
--

CREATE TABLE IF NOT EXISTS `feedback_rating` (
    `fbr_id` int(14) NOT NULL AUTO_INCREMENT,
    `fbr_title` text NOT NULL,
    `fbr_location` varchar(255) NOT NULL,
    `fbr_feedback_id` int(14) NOT NULL,
    `fbr_professionalism` int(1) NOT NULL,
    `fbr_speed` int(1) NOT NULL,
    `fbr_cleanliness` int(1) NOT NULL,
    `fbr_workmanship` int(1) NOT NULL,
    `fbr_experience` int(1) NOT NULL,
    `fbr_cost_value` int(1) NOT NULL,
    `fbr_sales_rep_rating` int(1) NOT NULL,
    `fbr_sales_rep_comments` varchar(255) NOT NULL,
    `fbr_foreman_rating` int(1) NOT NULL,
    `fbr_foreman_comments` varchar(255) NOT NULL,
    `fbr_recommend` varchar(6) NOT NULL,
    `fbr_comments` text NOT NULL,
    PRIMARY KEY (`fbr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `feedback_foreman`
--

CREATE TABLE IF NOT EXISTS `feedback_foremen` (
    `fm_id` int(14) NOT NULL AUTO_INCREMENT,
    `feedback_id` varchar(255) NOT NULL,
    `fm_name` varchar(255) NOT NULL,
    `fm_rating` varchar (255) NOT NULL,
    `fm_comments` varchar(255) NOT NULL,
    PRIMARY KEY (`fm_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;