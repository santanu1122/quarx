/**
 * Quarx
 *
 * A modular application framework built on CodeIgniter
 *
 * @package     Quarx
 * @author      Matt Lantz
 * @copyright   Copyright (c) 2013 Matt Lantz
 * @license     http://ottacon.co/quarx/license.html
 * @link        http://ottacon.co/quarx
 * @since       Version 1.0
 * 
 */

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `quarx_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
    `admin_opts` int(8) NOT NULL AUTO_INCREMENT,
    `option_title` varchar(50) NOT NULL,
    `db_uname` varchar(50) NOT NULL,
    `db_password` varchar(50) NOT NULL,
    `db_name` varchar(50) NOT NULL,
    PRIMARY KEY (`admin_opts`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_opts`, `option_title`, `db_uname`, `db_password`, `db_name`) VALUES
(1, 'simple accounts', '', '', ''),
(3, 'standard access', '', '', ''),
(5, '0.3.0', '', '', ''),
(2, '', 'username', 'password', 'dbname');

-- --------------------------------------------------------

--
-- Table structure for table `img`
--

CREATE TABLE IF NOT EXISTS `img` (
    `img_id` int(8) NOT NULL AUTO_INCREMENT,
    `img_location` varchar(250) NOT NULL,
    `img_thumb_location` varchar(250) NOT NULL,
    `category_type` varchar(40) NOT NULL,
    `img_collection` varchar(255) NOT NULL,
    `favorite` int(2) NOT NULL DEFAULT '0',
    `img_alt_tag` varchar(255) NOT NULL,
    `img_title_tag` varchar(255) NOT NULL,
    PRIMARY KEY (`img_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `img_collections`
--

CREATE TABLE IF NOT EXISTS `img_collections` (
    `collection_id` int(14) NOT NULL AUTO_INCREMENT,
    `collection_name` varchar(255) NOT NULL,
    PRIMARY KEY (`collection_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(8) NOT NULL AUTO_INCREMENT,
    `user_name` varchar(160) NOT NULL,
    `user_pass` varchar(160) NOT NULL,
    `user_email` varchar(160) NOT NULL,
    `permission` int(2) NOT NULL,
    `owner` int(8) NOT NULL,
    `status` varchar(40) NOT NULL,
    `full_name` varchar(255) NOT NULL,
    `img` varchar(255) NOT NULL DEFAULT 'default.jpg',
    `location` varchar(255) NOT NULL,
    `lat` decimal(9,6) NOT NULL,
    `lng` decimal(9,6) NOT NULL,
    `user_state` varchar(40) NOT NULL,
    `address` varchar(250) NOT NULL,
    `city` varchar(250) NOT NULL,
    `state` varchar(250) NOT NULL,
    `country` varchar(250) NOT NULL,
    `phone` varchar(250) NOT NULL,
    `fax` varchar(250) NOT NULL,
    `website` varchar(250) NOT NULL,
    `company` varchar(250) NOT NULL,
    `last_login` date NOT NULL,
    `login_counter` int(10) NOT NULL,
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `permission`, `owner`, `status`, `full_name`, `img`, `location`, `lat`, `lng`, `user_state`, `address`, `city`, `state`, `country`, `phone`, `fax`, `website`, `company`, `last_login`, `login_counter`) VALUES
(1, 'master', 'fc613b4dfd6736a7bd268c8a0e74ed0d1c04a959f59dd74ef2874983fd443fc9', 'masteruser@somewhere.com', 1, 0, 'authorized', 'Master User', 'default.jpg', 'somewhere', 0.000000, 0.000000, 'enabled', '', '', '', '', '', '', '', '', '2013-01-01', 0);