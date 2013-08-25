-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2013 at 03:04 PM
-- Server version: 5.5.31
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `supporters`
--
CREATE DATABASE IF NOT EXISTS `supporters` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `supporters`;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('b0991be2c81471402698b8f524ede263', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:23.0) Gecko/20100101 Firefox/23.0', 1377435715, 'a:2:{s:7:"user_id";s:1:"9";s:9:"logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `supporters`
--

CREATE TABLE IF NOT EXISTS `supporters` (
  `supporter_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `town` text NOT NULL,
  `state` text NOT NULL,
  `postcode` varchar(12) NOT NULL,
  `country` text NOT NULL,
  `phone` text NOT NULL,
  `email` text NOT NULL,
  PRIMARY KEY (`supporter_id`),
  KEY `last_name` (`last_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `supporters`
--

INSERT INTO `supporters` (`supporter_id`, `first_name`, `last_name`, `address1`, `address2`, `town`, `state`, `postcode`, `country`, `phone`, `email`) VALUES
(1, 'Michael', 'Marner', '2 Oxford Crescent', '', 'Modbury', 'SA', '5092', 'Australia', '0438984432', 'michael@20papercups.net');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `supporter_id` int(11) NOT NULL,
  `expiration_date` int(11) NOT NULL,
  `type` enum('sub','sub_concession','member','member_concession') NOT NULL,
  PRIMARY KEY (`transaction_id`),
  KEY `user_id` (`user_id`,`supporter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `salt` text NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `salt`) VALUES
(9, 'mmarner', 'fabc0238113b58bf64e40d2dca707cbb184902a9d9da100d204417f33df6f5e0', 'i9eJ/6lzTh6xt86WoF5TktvBqe8jVicF0sLv3SlKM/OAagXmjrKSagnPfy4oXMODPSDEnC5tAxc8B0hQQAg8HA==');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
