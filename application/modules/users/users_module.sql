--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `atomic_users` (
  `user_id` int(14) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_bio` text NOT NULL,
  `user_status` varchar(40) NOT NULL DEFAULT 'disabled',
  `last_login` date NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------