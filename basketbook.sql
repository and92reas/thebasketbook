-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2014 at 09:39 PM
-- Server version: 5.5.36
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `basketbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_events`
--

CREATE TABLE IF NOT EXISTS `admin_events` (
  `memberID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`,`eventID`),
  KEY `eventID` (`eventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_events`
--

INSERT INTO `admin_events` (`memberID`, `eventID`) VALUES
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_players`
--

CREATE TABLE IF NOT EXISTS `admin_players` (
  `memberID` int(11) NOT NULL,
  `playerID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`,`playerID`),
  KEY `playerID` (`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_players`
--

INSERT INTO `admin_players` (`memberID`, `playerID`) VALUES
(12, 20),
(12, 21),
(12, 22),
(12, 23),
(12, 25),
(12, 26),
(12, 27),
(12, 28),
(12, 29),
(12, 30),
(12, 31),
(12, 32),
(12, 33),
(12, 34),
(12, 35),
(12, 36),
(12, 37),
(12, 38),
(12, 39),
(12, 40),
(12, 41);

-- --------------------------------------------------------

--
-- Table structure for table `admin_teams`
--

CREATE TABLE IF NOT EXISTS `admin_teams` (
  `memberID` int(11) NOT NULL,
  `teamID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`,`teamID`),
  KEY `teamID` (`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_teams`
--

INSERT INTO `admin_teams` (`memberID`, `teamID`) VALUES
(12, 23),
(12, 24),
(12, 25),
(12, 26),
(12, 27);

-- --------------------------------------------------------

--
-- Table structure for table `admin_tournaments`
--

CREATE TABLE IF NOT EXISTS `admin_tournaments` (
  `memberID` int(11) NOT NULL,
  `tournamentID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`,`tournamentID`),
  KEY `tournamentID` (`tournamentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_tournaments`
--

INSERT INTO `admin_tournaments` (`memberID`, `tournamentID`) VALUES
(12, 128),
(12, 129),
(12, 130),
(12, 131),
(12, 132);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eventID` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `date` varchar(10) DEFAULT NULL,
  `area` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`eventID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eventID`, `description`, `date`, `area`) VALUES
(1, 'kopi tin pita', 'unknown', 'Agio Stefanos');

-- --------------------------------------------------------

--
-- Table structure for table `events_notifications`
--

CREATE TABLE IF NOT EXISTS `events_notifications` (
  `notificationID` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` int(11) NOT NULL,
  `topic` tinyint(4) NOT NULL,
  `time_stamp` int(11) NOT NULL,
  PRIMARY KEY (`notificationID`),
  KEY `eventID` (`eventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `events_players`
--

CREATE TABLE IF NOT EXISTS `events_players` (
  `eventID` int(11) NOT NULL,
  `playerID` int(11) NOT NULL,
  PRIMARY KEY (`eventID`,`playerID`),
  KEY `playerID` (`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events_players`
--

INSERT INTO `events_players` (`eventID`, `playerID`) VALUES
(1, 31);

-- --------------------------------------------------------

--
-- Table structure for table `events_teams`
--

CREATE TABLE IF NOT EXISTS `events_teams` (
  `eventID` int(11) NOT NULL,
  `teamID` int(11) NOT NULL,
  PRIMARY KEY (`eventID`,`teamID`),
  KEY `teamID` (`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `followed_events`
--

CREATE TABLE IF NOT EXISTS `followed_events` (
  `memberID` int(11) NOT NULL,
  `eventID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`,`eventID`),
  KEY `eventID` (`eventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followed_events`
--

INSERT INTO `followed_events` (`memberID`, `eventID`) VALUES
(12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `followed_players`
--

CREATE TABLE IF NOT EXISTS `followed_players` (
  `memberID` int(11) NOT NULL,
  `playerID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`,`playerID`),
  KEY `playerID` (`playerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followed_players`
--

INSERT INTO `followed_players` (`memberID`, `playerID`) VALUES
(12, 20),
(12, 21),
(12, 22),
(12, 23),
(12, 25),
(12, 26),
(12, 27),
(12, 28),
(12, 29),
(12, 30),
(12, 31),
(12, 32),
(12, 33),
(12, 34),
(12, 35),
(12, 36),
(12, 37),
(12, 38),
(12, 39),
(12, 41);

-- --------------------------------------------------------

--
-- Table structure for table `followed_teams`
--

CREATE TABLE IF NOT EXISTS `followed_teams` (
  `memberID` int(11) NOT NULL,
  `teamID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`,`teamID`),
  KEY `followed_teams_ibfk_2` (`teamID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followed_teams`
--

INSERT INTO `followed_teams` (`memberID`, `teamID`) VALUES
(12, 23),
(12, 25),
(12, 26),
(12, 27);

-- --------------------------------------------------------

--
-- Table structure for table `followed_tournaments`
--

CREATE TABLE IF NOT EXISTS `followed_tournaments` (
  `memberID` int(11) NOT NULL,
  `tournamentID` int(11) NOT NULL,
  PRIMARY KEY (`memberID`,`tournamentID`),
  KEY `tournamentID` (`tournamentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `followed_tournaments`
--

INSERT INTO `followed_tournaments` (`memberID`, `tournamentID`) VALUES
(12, 128),
(12, 129),
(12, 130),
(12, 131),
(12, 132);

-- --------------------------------------------------------

--
-- Table structure for table `logged_members`
--

CREATE TABLE IF NOT EXISTS `logged_members` (
  `log_memberID` int(11) NOT NULL AUTO_INCREMENT,
  `memberID` int(11) NOT NULL,
  `sessionID` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`log_memberID`),
  KEY `memberID` (`memberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `logged_members`
--

INSERT INTO `logged_members` (`log_memberID`, `memberID`, `sessionID`, `hash`, `expiration`) VALUES
(7, 12, '6ps11rdlqr0fv7ttl78acf1n53', 'c60f309e08a76f22256e0d8fe89471db371bda3f391c0b0af0bd927e51f186bd77f423e836818c449b76cd039d6bc673655cc0fc0c824bef0ab117954173c763', 1410275492);

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `matchID` int(11) NOT NULL AUTO_INCREMENT,
  `court` varchar(60) DEFAULT NULL,
  `home_team` int(11) NOT NULL,
  `guest_team` int(11) NOT NULL,
  `home_points` tinyint(4) DEFAULT NULL,
  `guest_points` tinyint(4) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `tournamentID` int(11) NOT NULL,
  `round` tinyint(4) NOT NULL,
  `row` tinyint(4) NOT NULL,
  PRIMARY KEY (`matchID`),
  KEY `home_team` (`home_team`,`guest_team`,`tournamentID`),
  KEY `guest_team` (`guest_team`),
  KEY `tournamentID` (`tournamentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=195 ;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`matchID`, `court`, `home_team`, `guest_team`, `home_points`, `guest_points`, `date`, `tournamentID`, `round`, `row`) VALUES
(155, NULL, 24, 25, 55, 62, NULL, 128, 1, 1),
(156, NULL, 27, 25, 66, 69, NULL, 128, 1, 2),
(157, NULL, 26, 25, 55, 66, NULL, 128, 2, 1),
(158, NULL, 24, 25, 55, 46, NULL, 129, 1, 1),
(159, NULL, 25, 27, 66, 69, NULL, 129, 1, 2),
(160, NULL, 25, 24, 55, 66, NULL, 129, 2, 1),
(161, NULL, 27, 26, 44, 33, NULL, 129, 2, 2),
(162, NULL, 24, 27, 55, 43, NULL, 129, 3, 1),
(163, NULL, 26, 25, 45, 55, NULL, 129, 3, 2),
(164, NULL, 26, 24, 56, 44, NULL, 129, 4, 1),
(165, NULL, 27, 25, NULL, NULL, NULL, 129, 4, 2),
(166, NULL, 24, 25, NULL, NULL, NULL, 129, 5, 1),
(167, NULL, 26, 27, NULL, NULL, NULL, 129, 5, 2),
(168, NULL, 27, 24, NULL, NULL, NULL, 129, 6, 1),
(169, NULL, 25, 26, NULL, NULL, NULL, 129, 6, 2),
(170, NULL, 24, 25, 66, 55, NULL, 130, 1, 1),
(171, NULL, 24, 25, 22, 33, NULL, 131, 1, 1),
(172, NULL, 26, 27, NULL, NULL, NULL, 131, 1, 2),
(173, NULL, 26, 24, NULL, NULL, NULL, 131, 2, 1),
(174, NULL, 27, 25, NULL, NULL, NULL, 131, 2, 2),
(175, NULL, 24, 27, NULL, NULL, NULL, 131, 3, 1),
(176, NULL, 25, 26, NULL, NULL, NULL, 131, 3, 2),
(177, NULL, 25, 24, NULL, NULL, NULL, 131, 4, 1),
(178, NULL, 27, 26, NULL, NULL, NULL, 131, 4, 2),
(179, NULL, 24, 26, NULL, NULL, NULL, 131, 5, 1),
(180, NULL, 25, 27, NULL, NULL, NULL, 131, 5, 2),
(181, NULL, 27, 24, NULL, NULL, NULL, 131, 6, 1),
(182, NULL, 26, 25, NULL, NULL, NULL, 131, 6, 2),
(183, NULL, 24, 26, NULL, NULL, NULL, 132, 1, 1),
(184, NULL, 25, 27, NULL, NULL, NULL, 132, 1, 2),
(185, NULL, 25, 24, NULL, NULL, NULL, 132, 2, 1),
(186, NULL, 27, 26, NULL, NULL, NULL, 132, 2, 2),
(187, NULL, 24, 27, NULL, NULL, NULL, 132, 3, 1),
(188, NULL, 26, 25, NULL, NULL, NULL, 132, 3, 2),
(189, NULL, 26, 24, NULL, NULL, NULL, 132, 4, 1),
(190, NULL, 27, 25, NULL, NULL, NULL, 132, 4, 2),
(191, NULL, 24, 25, NULL, NULL, NULL, 132, 5, 1),
(192, NULL, 26, 27, NULL, NULL, NULL, 132, 5, 2),
(193, NULL, 27, 24, NULL, NULL, NULL, 132, 6, 1),
(194, NULL, 25, 26, NULL, NULL, NULL, 132, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `memberID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mail` varchar(40) DEFAULT NULL,
  `fav_player` varchar(40) DEFAULT NULL,
  `fav_team` varchar(40) DEFAULT NULL,
  `fav_position` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`memberID`, `name`, `password`, `mail`, `fav_player`, `fav_team`, `fav_position`) VALUES
(12, 'admin', '7be5f3083856b6727cca02fa6287f809ffbbbe0b4cd238a641c232d7073c03e99ed7c58345ead89b389e4eee541288631650c318418e7607f58812beb640daf1', 'admin@admin', 'papaloukas', 'olympiakos', 'play maker'),
(13, 'member3', 'f53cfa0af0ac2fdacbd8481c2808cc3db978fd2f0a336edff93effc398db9167275be8f1595b48354ca2b08103dd2f0ea51207b460b397e4770bf6a196012758', 'aaa', 'spanoulissss', 'olympiakossss', 'power forwardddd');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `messageID` int(11) NOT NULL AUTO_INCREMENT,
  `matchID` int(11) NOT NULL,
  `topic` varchar(100) DEFAULT NULL,
  `content` text NOT NULL,
  `time_stamp` int(11) NOT NULL,
  `memberID` int(11) NOT NULL,
  PRIMARY KEY (`messageID`),
  KEY `matchID` (`matchID`),
  KEY `memberID` (`memberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`messageID`, `matchID`, `topic`, `content`, `time_stamp`, `memberID`) VALUES
(1, 155, 'PPP', ' ppp', 1401978930, 12),
(2, 158, '', ' Fucking wrong', 1403725337, 12),
(3, 163, 'Test', ' Soritooooos', 1405796830, 12);

-- --------------------------------------------------------

--
-- Table structure for table `past_teams`
--

CREATE TABLE IF NOT EXISTS `past_teams` (
  `playerID` int(11) NOT NULL,
  `team_name` varchar(50) NOT NULL,
  PRIMARY KEY (`playerID`,`team_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `past_teams`
--

INSERT INTO `past_teams` (`playerID`, `team_name`) VALUES
(25, 'Apollon Patras'),
(25, 'Malaga'),
(26, 'Peristeri'),
(27, 'Houston Rockets'),
(27, 'Panathinaikos'),
(28, 'Panathinaikos'),
(28, 'Panionios'),
(29, 'Aris Saloniki '),
(29, 'Maroussi'),
(30, 'Iraklis Salonica'),
(31, 'Dinamo Moscow'),
(32, 'Fenerbahce'),
(34, 'Zalgiris Kaunas'),
(39, 'Panathinaikos');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `playerID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `present_team` int(11) NOT NULL,
  `position` varchar(40) DEFAULT NULL,
  `birthdate` varchar(10) DEFAULT NULL,
  `loaned_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`playerID`),
  KEY `present_team` (`present_team`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`playerID`, `name`, `present_team`, `position`, `birthdate`, `loaned_by`) VALUES
(20, 'e', 1, 'unknown', 'unknown', 'none'),
(21, 'f', 1, 'unknown', 'unknown', 'none'),
(22, 'h', 1, 'unknown', 'unknown', 'none'),
(23, 'g', 1, 'unknown', 'unknown', 'none'),
(25, 'Giorgos Printezis', 24, 'Power Forward', 'unknown', 'none'),
(26, 'Vaggelis Mantzaris', 24, 'Play Maker', 'unknown', 'none'),
(27, 'Vasilis Spanoulis', 24, 'Guard', 'unknown', 'none'),
(28, 'Stratos Perperoglou', 24, 'Small Forward', 'unknown', 'none'),
(29, 'Kostas Sloukas', 24, 'Play Maker', 'unknown', 'none'),
(30, 'Dimitris Diamantidis', 25, 'Play Maker', 'unknown', 'none'),
(31, 'Antonis Fotsis', 25, 'Power Forward', 'unknown', 'none'),
(32, 'James Gist', 25, 'Power Forward', 'unknown', 'none'),
(33, 'Lasme', 25, 'Center', 'unknown', 'none'),
(34, 'Jonas Maciulis', 25, 'Power Forward', 'unknown', 'none'),
(35, 'Gkikas', 27, 'Play Maker', 'unknown', 'none'),
(36, 'Vezenkov', 27, 'Power Forward', 'unknown', 'none'),
(37, 'Bochoridis', 27, 'Play Maker', 'unknown', 'none'),
(38, 'JJ Cooper', 26, 'Play Maker', 'unknown', 'none'),
(39, 'Giannis Bogris', 26, 'Center', 'unknown', 'none'),
(40, 'Margaritis', 26, 'Power Forward', 'unknown', 'none'),
(41, 'Kostas Charalabidis', 26, 'Guard', 'unknown', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `players_matches`
--

CREATE TABLE IF NOT EXISTS `players_matches` (
  `playerID` int(11) NOT NULL,
  `matchID` int(11) NOT NULL,
  `points` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`playerID`,`matchID`),
  KEY `matchID` (`matchID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `players_matches`
--

INSERT INTO `players_matches` (`playerID`, `matchID`, `points`) VALUES
(26, 155, 21),
(26, 158, 12),
(27, 160, 11),
(27, 162, 22),
(27, 164, 11),
(28, 160, 22),
(28, 162, 11),
(28, 164, 11),
(29, 160, 5),
(29, 162, 21),
(29, 164, 11),
(30, 156, 23),
(30, 159, 23),
(31, 157, 11),
(31, 159, 12),
(32, 160, 12),
(32, 163, 11),
(33, 160, 11),
(33, 163, 13),
(34, 163, 22),
(35, 156, 22),
(35, 159, 33),
(36, 162, 11),
(37, 161, 11),
(37, 162, 21),
(38, 155, 22),
(38, 157, 21),
(38, 158, 22),
(39, 161, 11),
(39, 163, 12),
(39, 164, 11),
(40, 161, 11),
(40, 163, 11),
(40, 164, 21),
(41, 161, 11),
(41, 163, 13),
(41, 164, 11);

-- --------------------------------------------------------

--
-- Table structure for table `players_notifications`
--

CREATE TABLE IF NOT EXISTS `players_notifications` (
  `notificationID` int(11) NOT NULL AUTO_INCREMENT,
  `playerID` int(11) NOT NULL,
  `topic` tinyint(4) NOT NULL,
  `time_stamp` int(11) NOT NULL,
  PRIMARY KEY (`notificationID`),
  KEY `playerID` (`playerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `players_notifications`
--

INSERT INTO `players_notifications` (`notificationID`, `playerID`, `topic`, `time_stamp`) VALUES
(24, 40, 1, 1410275060),
(25, 39, 1, 1410275060),
(26, 41, 1, 1410275060),
(27, 29, 1, 1410275060),
(28, 28, 1, 1410275060),
(29, 27, 1, 1410275060);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `teamID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `area` varchar(100) DEFAULT NULL,
  `court` varchar(80) DEFAULT NULL,
  `foundation_year` varchar(4) DEFAULT NULL,
  `coach` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`teamID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`teamID`, `name`, `area`, `court`, `foundation_year`, `coach`) VALUES
(1, 'unknown', 'unknown', 'unknown', '????', 'unknown'),
(23, 'Patissia BC', 'unknown', 'unknown', '????', 'unknown'),
(24, 'Olympiacos', 'Peiraeus', 'SEF', '1924', 'Mpartzokas'),
(25, 'Panathinaikos', 'Athens', 'OAKA', '1924', 'Alvertis'),
(26, 'PAOK', 'Saloniki', 'Pylaia', '????', 'Markopoulos'),
(27, 'Aris Saloniki', 'Saloniki', 'Alexandreio', '????', 'unknown');

-- --------------------------------------------------------

--
-- Table structure for table `teams_notifications`
--

CREATE TABLE IF NOT EXISTS `teams_notifications` (
  `notificationID` int(11) NOT NULL AUTO_INCREMENT,
  `teamID` int(11) NOT NULL,
  `topic` tinyint(4) NOT NULL,
  `time_stamp` int(11) NOT NULL,
  PRIMARY KEY (`notificationID`),
  KEY `teamID` (`teamID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `teams_notifications`
--

INSERT INTO `teams_notifications` (`notificationID`, `teamID`, `topic`, `time_stamp`) VALUES
(23, 26, 1, 1410275060),
(24, 24, 1, 1410275060);

-- --------------------------------------------------------

--
-- Table structure for table `teams_successes`
--

CREATE TABLE IF NOT EXISTS `teams_successes` (
  `teamID` int(11) NOT NULL,
  `success` varchar(100) NOT NULL,
  PRIMARY KEY (`teamID`,`success`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams_successes`
--

INSERT INTO `teams_successes` (`teamID`, `success`) VALUES
(24, 'Euroleague'),
(24, 'Greek Championship'),
(25, 'Euroleague'),
(25, 'Greek Cjampionship'),
(26, 'Greek Championship'),
(27, 'Greek Championship'),
(27, 'ULEB Cup');

-- --------------------------------------------------------

--
-- Table structure for table `teams_tournaments`
--

CREATE TABLE IF NOT EXISTS `teams_tournaments` (
  `teamID` int(11) NOT NULL,
  `tournamentID` int(11) NOT NULL,
  `points_for` smallint(6) NOT NULL DEFAULT '0',
  `points_against` smallint(6) NOT NULL DEFAULT '0',
  `league_points` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`teamID`,`tournamentID`),
  KEY `tournamentID` (`tournamentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teams_tournaments`
--

INSERT INTO `teams_tournaments` (`teamID`, `tournamentID`, `points_for`, `points_against`, `league_points`) VALUES
(24, 128, 55, 62, 0),
(24, 129, 220, 200, 7),
(24, 130, 66, 55, 0),
(24, 131, 22, 33, 1),
(24, 132, 0, 0, 0),
(25, 128, 135, 121, 0),
(25, 129, 176, 180, 4),
(25, 130, 55, 66, 0),
(25, 131, 33, 22, 2),
(25, 132, 0, 0, 0),
(26, 128, 117, 121, 0),
(26, 129, 180, 198, 5),
(26, 131, 0, 0, 0),
(26, 132, 0, 0, 0),
(27, 128, 66, 69, 0),
(27, 129, 156, 154, 5),
(27, 131, 0, 0, 0),
(27, 132, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE IF NOT EXISTS `tournaments` (
  `tournamentID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(300) NOT NULL,
  `start_date` varchar(10) DEFAULT NULL,
  `end_date` varchar(10) DEFAULT NULL,
  `type` tinyint(1) NOT NULL,
  PRIMARY KEY (`tournamentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=133 ;

--
-- Dumping data for table `tournaments`
--

INSERT INTO `tournaments` (`tournamentID`, `title`, `start_date`, `end_date`, `type`) VALUES
(128, 'mini Cup', 'unknown', 'unknown', 0),
(129, 'aaa', 'unknown', 'unknown', 1),
(130, 'derby', 'unknown', 'unknown', 0),
(131, 'aaa2', 'unknown', 'unknown', 1),
(132, 'ppp', 'unknown', 'unknown', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tournaments_notifications`
--

CREATE TABLE IF NOT EXISTS `tournaments_notifications` (
  `notificationID` int(11) NOT NULL AUTO_INCREMENT,
  `tournamentID` int(11) NOT NULL,
  `topic` tinyint(4) NOT NULL,
  `time_stamp` int(11) NOT NULL,
  PRIMARY KEY (`notificationID`),
  KEY `tournamentID` (`tournamentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tournaments_notifications`
--

INSERT INTO `tournaments_notifications` (`notificationID`, `tournamentID`, `topic`, `time_stamp`) VALUES
(8, 129, 1, 1410275060);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_events`
--
ALTER TABLE `admin_events`
  ADD CONSTRAINT `admin_events_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_events_ibfk_2` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE;

--
-- Constraints for table `admin_players`
--
ALTER TABLE `admin_players`
  ADD CONSTRAINT `admin_players_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_players_ibfk_2` FOREIGN KEY (`playerID`) REFERENCES `players` (`playerID`) ON UPDATE CASCADE;

--
-- Constraints for table `admin_teams`
--
ALTER TABLE `admin_teams`
  ADD CONSTRAINT `admin_teams_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_teams_ibfk_2` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE;

--
-- Constraints for table `admin_tournaments`
--
ALTER TABLE `admin_tournaments`
  ADD CONSTRAINT `admin_tournaments_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `admin_tournaments_ibfk_2` FOREIGN KEY (`tournamentID`) REFERENCES `tournaments` (`tournamentID`) ON UPDATE CASCADE;

--
-- Constraints for table `events_notifications`
--
ALTER TABLE `events_notifications`
  ADD CONSTRAINT `events_notifications_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE;

--
-- Constraints for table `events_players`
--
ALTER TABLE `events_players`
  ADD CONSTRAINT `events_players_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `events_players_ibfk_2` FOREIGN KEY (`playerID`) REFERENCES `players` (`playerID`) ON UPDATE CASCADE;

--
-- Constraints for table `events_teams`
--
ALTER TABLE `events_teams`
  ADD CONSTRAINT `events_teams_ibfk_1` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `events_teams_ibfk_2` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE;

--
-- Constraints for table `followed_events`
--
ALTER TABLE `followed_events`
  ADD CONSTRAINT `followed_events_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `followed_events_ibfk_2` FOREIGN KEY (`eventID`) REFERENCES `events` (`eventID`) ON UPDATE CASCADE;

--
-- Constraints for table `followed_players`
--
ALTER TABLE `followed_players`
  ADD CONSTRAINT `followed_players_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `followed_players_ibfk_2` FOREIGN KEY (`playerID`) REFERENCES `players` (`playerID`) ON UPDATE CASCADE;

--
-- Constraints for table `followed_teams`
--
ALTER TABLE `followed_teams`
  ADD CONSTRAINT `followed_teams_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `followed_teams_ibfk_2` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE;

--
-- Constraints for table `followed_tournaments`
--
ALTER TABLE `followed_tournaments`
  ADD CONSTRAINT `followed_tournaments_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `followed_tournaments_ibfk_2` FOREIGN KEY (`tournamentID`) REFERENCES `tournaments` (`tournamentID`) ON UPDATE CASCADE;

--
-- Constraints for table `logged_members`
--
ALTER TABLE `logged_members`
  ADD CONSTRAINT `logged_members_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE;

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`home_team`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`guest_team`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `matches_ibfk_3` FOREIGN KEY (`tournamentID`) REFERENCES `tournaments` (`tournamentID`) ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`matchID`) REFERENCES `matches` (`matchID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`memberID`) REFERENCES `members` (`memberID`) ON UPDATE CASCADE;

--
-- Constraints for table `past_teams`
--
ALTER TABLE `past_teams`
  ADD CONSTRAINT `past_teams_ibfk_1` FOREIGN KEY (`playerID`) REFERENCES `players` (`playerID`) ON UPDATE CASCADE;

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`present_team`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE;

--
-- Constraints for table `players_matches`
--
ALTER TABLE `players_matches`
  ADD CONSTRAINT `players_matches_ibfk_1` FOREIGN KEY (`playerID`) REFERENCES `players` (`playerID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `players_matches_ibfk_2` FOREIGN KEY (`matchID`) REFERENCES `matches` (`matchID`) ON UPDATE CASCADE;

--
-- Constraints for table `players_notifications`
--
ALTER TABLE `players_notifications`
  ADD CONSTRAINT `players_notifications_ibfk_1` FOREIGN KEY (`playerID`) REFERENCES `players` (`playerID`) ON UPDATE CASCADE;

--
-- Constraints for table `teams_notifications`
--
ALTER TABLE `teams_notifications`
  ADD CONSTRAINT `teams_notifications_ibfk_1` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE;

--
-- Constraints for table `teams_tournaments`
--
ALTER TABLE `teams_tournaments`
  ADD CONSTRAINT `teams_tournaments_ibfk_1` FOREIGN KEY (`teamID`) REFERENCES `teams` (`teamID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `teams_tournaments_ibfk_2` FOREIGN KEY (`tournamentID`) REFERENCES `tournaments` (`tournamentID`) ON UPDATE CASCADE;

--
-- Constraints for table `tournaments_notifications`
--
ALTER TABLE `tournaments_notifications`
  ADD CONSTRAINT `tournaments_notifications_ibfk_1` FOREIGN KEY (`tournamentID`) REFERENCES `tournaments` (`tournamentID`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
