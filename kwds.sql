-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 07, 2012 at 01:06 PM
-- Server version: 5.1.63
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database for KWDS
--

-- --------------------------------------------------------

--
-- Table structure for table `aerobic`
--

CREATE TABLE IF NOT EXISTS `aerobic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `aerobic`
--

INSERT INTO `aerobic` (`id`, `name`) VALUES
(1, '(n/a)'),
(2, 'None'),
(3, 'Low'),
(4, 'Average'),
(5, 'High');

-- --------------------------------------------------------

--
-- Table structure for table `attraction`
--

CREATE TABLE IF NOT EXISTS `attraction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(100) NOT NULL,
  `kwds_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `limit` varchar(20) NOT NULL,
  `fee` varchar(20) NOT NULL,
  `topic_id` int(11) NOT NULL,
  `era_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `kwds_id` int(11) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `aerobic_id` int(11) NOT NULL,
  `difficulty_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `day` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=522 ;

--
-- Table structure for table `coteacher`
--

CREATE TABLE IF NOT EXISTS `coteacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `difficulty`
--

CREATE TABLE IF NOT EXISTS `difficulty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `difficulty`
--

INSERT INTO `difficulty` (`id`, `name`) VALUES
(1, '(none)'),
(2, 'Beginner'),
(3, 'Intermediate'),
(4, 'Advanced');

-- --------------------------------------------------------

--
-- Table structure for table `era`
--

CREATE TABLE IF NOT EXISTS `era` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `era`
--

INSERT INTO `era` (`id`, `name`) VALUES
(1, '(n/a)'),
(2, 'Pre 1400'),
(3, '1400-1500'),
(4, '1500-1600'),
(5, '1600-1700'),
(6, '1700-1800'),
(7, 'Modern');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kwds_id` int(11) NOT NULL,
  `question` tinytext NOT NULL,
  `answer` text NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE IF NOT EXISTS `fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kwds_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `description` text NOT NULL,
  `fee_type_id` int(11) NOT NULL,
  `prereg` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

-- --------------------------------------------------------

--
-- Table structure for table `fee_type`
--

CREATE TABLE IF NOT EXISTS `fee_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `fee_type`
--

INSERT INTO `fee_type` (`id`, `name`) VALUES
(1, 'Site Fee'),
(2, 'Non-Member Surcharge'),
(3, 'Proceedings'),
(4, 'Lodging'),
(5, 'Parking'),
(6, 'Food'),
(7, 'Tour'),
(8, 'Other'),
(9, 'Transportation');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `kingdom_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`id`, `name`, `url`, `kingdom_id`) VALUES
(1, '(n/a) West', 'http://www.westkingdom.org/', 1),
(2, '(n/a) East', 'http://www.eastkingdom.org/', 2),
(3, '(n/a) Middle', 'http://www.midrealm.org/', 3),
(4, '(n/a) Atenveldt', 'http://www.atenveldt.org/', 4),
(5, '(n/a) Meridies', 'http://www.meridies.org/index.php', 5),
(6, '(n/a) Caid', 'http://www.sca-caid.org/', 6),
(7, '(n/a) Ansteorra', 'http://ansteorra.org/', 7),
(8, '(n/a) Atlantia', 'http://www.atlantia.sca.org/', 8),
(9, '(n/a) An Tir', 'http://antir.sca.org/', 9),
(10, '(n/a) Calontir', 'http://calontir.org/', 10),
(11, '(n/a) Trimaris', 'http://www.trimaris.org/', 11),
(12, '(n/a) Outlands', 'http://www.outlands.org/', 12),
(13, '(n/a) Drachenwald', 'http://www.drachenwald.sca.org/index_new.php', 13),
(14, '(n/a) Artemesia', 'http://www.artemisia.sca.org/', 14),
(15, '(n/a) Aethelmaerc', 'http://www.aethelmearc.org/', 15),
(16, '(n/a) Ealdormere', 'http://www.ealdormere.ca/', 16),
(17, '(n/a) Lochac', 'http://lochac.sca.org/lochac/', 17),
(18, '(n/a) Northshield', 'http://www.northshield.org/', 18),
(19, '(n/a) Gleann Abhann', 'http://www.kingdomofgleannabhann.org/', 19),
(21, '(n/a)', 'http://sca.org/', 20);

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE IF NOT EXISTS `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`id`, `name`) VALUES
(1, 'Event Steward (Autocrat)'),
(2, 'Co-autocrat'),
(3, 'Registrations'),
(4, 'Volunteer Coordinator'),
(5, 'Lodging Coordinator'),
(6, 'European Dance Class Coordinator'),
(7, 'Middle Eastern Dance Class Coordinator'),
(8, 'Music Class Coordinator'),
(9, 'Class Scheduler'),
(10, 'Musician Coordinator'),
(11, 'Merchant Coordinator'),
(12, 'Troll'),
(13, 'Proceedings'),
(14, 'Newcomer Assisstance'),
(15, 'Publicity'),
(16, 'Web Maintenance'),
(17, 'Feast Steward');

-- --------------------------------------------------------

--
-- Table structure for table `kingdom`
--

CREATE TABLE IF NOT EXISTS `kingdom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `arms` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `kingdom`
--

INSERT INTO `kingdom` (`id`, `name`, `url`, `arms`) VALUES
(1, 'West', 'http://www.westkingdom.org/', 'West.gif'),
(2, 'East', 'http://www.eastkingdom.org/', 'East.gif'),
(3, 'Middle', 'http://www.midrealm.org/', 'Middle.gif'),
(4, 'Atenveldt', 'http://www.atenveldt.org/', 'Atenveldt.gif'),
(5, 'Meridies', 'http://www.meridies.org/index.php', 'Meridies.gif'),
(6, 'Caid', 'http://www.sca-caid.org/', 'Caid.gif'),
(7, 'Ansteorra', 'http://ansteorra.org/', 'Ansteorra.gif'),
(8, 'Atlantia', 'http://www.atlantia.sca.org/', 'Atlantia.gif'),
(9, 'An Tir', 'http://antir.sca.org/', 'AnTir.gif'),
(10, 'Calontir', 'http://calontir.org/', 'Calontir.gif'),
(11, 'Trimaris', 'http://www.trimaris.org/', 'Trimaris.gif'),
(12, 'Outlands', 'http://www.outlands.org/', 'Outlands.gif'),
(13, 'Drachenwald', 'http://www.drachenwald.sca.org/index_new.php', 'Drachenwald.gif'),
(14, 'Artemisia', 'http://www.artemisia.sca.org/', 'Atemisia.gif'),
(15, 'Aethelmaerc', 'http://www.aethelmearc.org/', 'Aethelmearch.gif'),
(16, 'Ealdormere', 'http://www.ealdormere.ca/', 'Ealdormere.gif'),
(17, 'Lochac', 'http://lochac.sca.org/lochac/', 'Lochac.gif'),
(18, 'Northshield', 'http://www.northshield.org/', 'Northshield.gif'),
(19, 'Gleann Abhann', 'http://www.kingdomofgleannabhann.org/', 'GleannAbhann.gif'),
(20, '(n/a)', 'http://sca.org/', 'SCA.gif');

-- --------------------------------------------------------

--
-- Table structure for table `kwds`
--

CREATE TABLE IF NOT EXISTS `kwds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner` varchar(100) NOT NULL,
  `name` varchar(75) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `group_id` int(11) NOT NULL,
  `kingdom_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `class_date` timestamp NULL DEFAULT NULL,
  `start_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `theme` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `directions` text NOT NULL,
  `parking` text NOT NULL,
  `proceedings` text NOT NULL,
  `registration` text NOT NULL,
  `merchants` text NOT NULL,
  `food` text NOT NULL,
  `lodging` text NOT NULL,
  `attractions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `password`
--

CREATE TABLE IF NOT EXISTS `password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `prefix`
--

CREATE TABLE IF NOT EXISTS `prefix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `prefix`
--

INSERT INTO `prefix` (`id`, `name`) VALUES
(1, ''),
(2, 'Mr.'),
(3, 'Mrs.'),
(4, 'Ms.'),
(5, 'Dr.');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `kwds_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `building` varchar(30) NOT NULL,
  `size` varchar(30) NOT NULL,
  `kwds_id` int(11) NOT NULL,
  `note` text NOT NULL,
  `floor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE IF NOT EXISTS `seminar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `day` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(1, 'Approved'),
(2, 'Proposed'),
(3, 'Tentative'),
(4, 'Open for Bids');

-- --------------------------------------------------------

--
-- Table structure for table `title`
--

CREATE TABLE IF NOT EXISTS `title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `title`
--

INSERT INTO `title` (`id`, `name`) VALUES
(1, ''),
(2, 'Lady'),
(3, 'Lord'),
(4, 'King'),
(5, 'Queen'),
(6, 'Baronness'),
(7, 'Baron'),
(8, 'THL'),
(9, 'Master'),
(10, 'Mistress'),
(11, 'Count'),
(12, 'Countess'),
(13, 'Viscount'),
(14, 'Viscountess'),
(15, 'Sir'),
(16, 'Duke'),
(17, 'Duchess');

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, '(none)'),
(2, 'European Dance'),
(3, 'Middle Eastern'),
(4, 'Music'),
(5, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `update`
--

CREATE TABLE IF NOT EXISTS `update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `prefix_id` int(11) NOT NULL,
  `first` varchar(30) DEFAULT NULL,
  `last` varchar(30) DEFAULT NULL,
  `nickname` varchar(30) DEFAULT NULL,
  `title_id` int(11) NOT NULL,
  `sca_first` varchar(30) DEFAULT NULL,
  `sca_last` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `about` text,
  `picture` varchar(100) DEFAULT NULL,
  `arms` varchar(100) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `zip` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=201 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
