-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- ------------------------------------------------------
-- Server version 5.6.35-log
--
-- Table structure for table `DEVICES`
--

DROP TABLE IF EXISTS `DEVICES`;
CREATE TABLE `DEVICES` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `date_time` int(11) NOT NULL,
  `appliance` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Table structure for table `DEVICE_HISTORY`
--

DROP TABLE IF EXISTS `DEVICE_HISTORY`;
CREATE TABLE `DEVICE_HISTORY` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `state` int(1) NOT NULL,
  `date_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;

--
-- Table structure for table `GUARDIAN_CONTACT_DETAILS`
--

DROP TABLE IF EXISTS `GUARDIAN_CONTACT_DETAILS`;
CREATE TABLE `GUARDIAN_CONTACT_DETAILS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `phone` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Table structure for table `LOGIN_DETAILS`
--

DROP TABLE IF EXISTS `LOGIN_DETAILS`;
CREATE TABLE `LOGIN_DETAILS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` char(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Table structure for table `USERS`
--

DROP TABLE IF EXISTS `USERS`;
CREATE TABLE `USERS` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `dob` int(11) NOT NULL,
  `house_no_name` varchar(25) NOT NULL,
  `street` varchar(25) NOT NULL,
  `town_city` varchar(25) NOT NULL,
  `postcode` char(7) NOT NULL,
  `phone` char(12) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dump completed on 2017-03-28 23:08:14
