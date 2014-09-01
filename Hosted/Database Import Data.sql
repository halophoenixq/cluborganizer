-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 15, 2014 at 04:08 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `a6277591_test`
--
CREATE DATABASE IF NOT EXISTS `a6277591_test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `a6277591_test`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `ADMIN` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `USERNAME` text COLLATE utf8_unicode_ci NOT NULL,
  `PASSWORD` text COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `ADMIN` (`ID`, `USERNAME`, `PASSWORD`) VALUES
(1, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99');

-- --------------------------------------------------------

--
-- Table structure for table `charge`
--

CREATE TABLE IF NOT EXISTS `CHARGE` (
  `CHARGE_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `CHARGE_TYPE_ID` int(20) unsigned NOT NULL,
  `CHARGE_CAT_ID` int(20) unsigned NOT NULL,
  `EVENT_ID` int(20) unsigned NOT NULL,
  `AMOUNT` double NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CHARGE_ID`),
  KEY `CHARGE_TYPE_ID` (`CHARGE_TYPE_ID`),
  KEY `CHARGE_CAT_ID` (`CHARGE_CAT_ID`),
  KEY `EVENT_ID` (`EVENT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `charge_category`
--

CREATE TABLE IF NOT EXISTS `CHARGE_CATEGORY` (
  `CHARGE_CAT_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CHARGE_CAT_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `charge_type`
--

CREATE TABLE IF NOT EXISTS `CHARGE_TYPE` (
  `CHARGE_TYPE_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CHARGE_TYPE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE IF NOT EXISTS `CLASS` (
  `CLASS_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CLASS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `class`
--

INSERT INTO `CLASS` (`CLASS_ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'Trainee', 'New members who have yet to complete basic requirements'),
(2, '2nd Class', 'Intermediate members who have moderate security knowledge and can participate in more projects'),
(3, '1st Class', 'Experienced members with specializations in specific topics and can lead projects');

-- --------------------------------------------------------

--
-- Table structure for table `class_require`
--

CREATE TABLE IF NOT EXISTS `CLASS_REQUIRE` (
  `CLASS_REQUIRE_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `CLASS_ID` int(20) unsigned NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CLASS_REQUIRE_ID`),
  KEY `CLASS_ID` (`CLASS_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `class_require_event`
--

CREATE TABLE IF NOT EXISTS `CLASS_REQUIRE_EVENT` (
  `CLASS_REQUIRE_ID` int(20) unsigned NOT NULL,
  `EVENT_TYPE_ID` int(20) unsigned NOT NULL,
  `AMOUNT` int(11) NOT NULL,
  KEY `CLASS_REQUIRE_ID` (`CLASS_REQUIRE_ID`),
  KEY `EVENT_TYPE_ID` (`EVENT_TYPE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `class_standing`
--

CREATE TABLE IF NOT EXISTS `CLASS_STANDING` (
  `CLASS_STAND_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` text COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`CLASS_STAND_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `class_standing`
--

INSERT INTO `CLASS_STANDING` (`CLASS_STAND_ID`, `NAME`, `DESCRIPTION`) VALUES
(5, 'Freshman', 'Usually a first year with 0-32 units.'),
(6, 'Sophomore', 'Usually a second year with 32-64 units.'),
(7, 'Junior', 'Usually a third year with 64-96 units.'),
(8, 'Senior', 'Usually a fourth year with 96-128 units.'),
(9, 'Other', 'Exceptions such as 5th years, graduate students, or non-students.');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `EVENT` (
  `EVENT_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `EVENT_TYPE_ID` int(20) unsigned NOT NULL,
  `LOCATION` text COLLATE utf8_unicode_ci NOT NULL,
  `NAME` text COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8_unicode_ci NOT NULL,
  `START_DATE` date NOT NULL,
  `END_DATE` date NOT NULL,
  `START_TIME` time NOT NULL,
  `END_TIME` time NOT NULL,
  PRIMARY KEY (`EVENT_ID`),
  KEY `EVENT_TYPE_ID` (`EVENT_TYPE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `event`
--

INSERT INTO `EVENT` (`EVENT_ID`, `EVENT_TYPE_ID`, `LOCATION`, `NAME`, `DESCRIPTION`, `START_DATE`, `END_DATE`, `START_TIME`, `END_TIME`) VALUES
(5, 1, 'SLH 102', 'Old GM 6', 'GM 6 will be deviate from the cyber world and focus on physical security. Toby will explain the intricacies of different locks as well as ways to bypass the need for keys.\n\nWe will have a limited amount of locks, handcuffs, and tools afterwards for practice!', '2014-03-24', '0000-00-00', '19:00:00', '21:00:00'),
(6, 3, 'OHE 406', 'CTF Hackathon Sp14', 'Get ready for our first ever CTF Competition! Test your creativity and skills in tackling puzzles, problems, and "secure" environments!', '2014-04-30', '0000-00-00', '13:00:00', '16:00:00'),
(8, 1, 'SLH 102', 'Old GM 1', 'Interested in learning how to break into insecure machines, open locks for those times when you''re locked out of your room, and modify websites?\n\nAPT is USC''s newly established security club! We will be having our first meeting next Monday, Feb 3rd at 7-9 PM in SLH 102.\n\nBe sure to come out to learn the basics of security concepts, what our club has planned, and how to interact with USC''s environment in a unique way ;] No experience required!', '2014-02-03', '0000-00-00', '19:00:00', '21:00:00'),
(9, 1, 'SLH 102', 'Old GM 2', 'In this next meeting, we''ll be covering some basics of Linux, so make sure you bring your laptops (remember to charge them if possible). In addition, we will be displaying some...interesting things to do with reddit, so don''t miss out!\n\nWe''ll also begin planning and discussing projects for each committee, which are currently System, Web Apps, and Physical. Please come with a general sense of which committee you would like to join (not fixed in one committee)', '2014-02-10', '0000-00-00', '19:00:00', '21:00:00'),
(10, 1, 'SLH 102', 'Old GM 3', 'We will be covering basic networking concepts and focus on exploring different reconnaissance/exploit techniques with group activities.\n\nIn addition, we will be introducing two project groups regarding website testing and USB scripting. If you''re interested in joining, please come for more information!', '2014-02-24', '0000-00-00', '19:00:00', '21:00:00'),
(11, 1, 'SLH 102', 'Old GM 4', 'Our 4th GM will be on basic concepts of Cryptography and Password Cracking. We will combine our knowledge of exploits in order to retrieve and interpret some information!\n\nAlso, we will provide information about our upcoming CTF Competition in April!\n', '2014-03-03', '0000-00-00', '19:00:00', '19:00:00'),
(12, 1, 'SLH 102', 'Old GM 5', 'GM 5 will feature an interactive presentation displaying the creativity involved in social engineering.\\r\\n\\r\\nAfterwards, we will proceed to quickly introduce website security and explore some issues to look for.', '2014-03-10', '0000-00-00', '19:00:00', '21:00:00'),
(13, 1, 'SLH 102', 'GM 1 - Advanced Persistent Threat (APT)', 'Interested in learning how to break into insecure machines, open locks for those times when you''re locked out of your room, and modify websites?\n\nAPT is USC''s newly established security club! We will be having our first meeting next Monday, Feb 3rd at 7-9 PM in SLH 102.\n\nBe sure to come out to learn the basics of security concepts, what our club has planned, and how to interact with USC''s environment in a unique way ;] No experience required!', '2014-04-30', '0000-00-00', '21:00:00', '23:00:00'),
(14, 1, 'SLH102', 'GM 2 - Exploring Linux', 'In this next meeting, we''ll be covering some basics of Linux, so make sure you bring your laptops (remember to charge them if possible). In addition, we will be displaying some...interesting things to do with reddit, so don''t miss out!\n\nWe''ll also begin planning and discussing projects for each committee, which are currently System, Web Apps, and Physical. Please come with a general sense of which committee you would like to join (not fixed in one committee)', '2014-05-05', '0000-00-00', '19:00:00', '21:00:00'),
(15, 1, 'SLH 102', 'GM 3 - Network Reconnaissance', 'We will be covering basic networking concepts and focus on exploring different reconnaissance/exploit techniques with group activities.\n\nIn addition, we will be introducing two project groups regarding website testing and USB scripting. If you''re interested in joining, please come for more information!', '2014-05-07', '0000-00-00', '18:00:00', '19:00:00'),
(16, 1, 'SLH 102', 'GM 4 - Cryptography and Password Cracking', 'Our 4th GM will be on basic concepts of Cryptography and Password Cracking. We will combine our knowledge of exploits in order to retrieve and interpret some information!\n\nAlso, we will provide information about our upcoming CTF Competition in April!\n', '2014-05-09', '0000-00-00', '01:00:00', '02:00:00'),
(17, 1, 'SLH 102', 'GM 5 - Social Hacking and Website Security', 'GM 5 will feature an interactive presentation displaying the creativity involved in social engineering.\\r\\n\\r\\nAfterwards, we will proceed to quickly introduce website security and explore some issues to look for.', '2014-05-13', '0000-00-00', '02:00:00', '03:00:00'),
(18, 1, 'SLH 102', 'GM 6 - Physical Security and Lock Picking', 'GM 6 will be deviate from the cyber world and focus on physical security. Toby will explain the intricacies of different locks as well as ways to bypass the need for keys.\n\nWe will have a limited amount of locks, handcuffs, and tools afterwards for practice!', '2014-05-21', '0000-00-00', '03:00:00', '04:00:00'),
(19, 1, 'SLH 102', 'GM 7 - CTF Preparation', 'Our 7th GM will be a practice CTF where we will explore some of the techniques for approaching an environment and finding vulnerabilities. Please have Kali Linux ready before the meeting.', '2014-05-28', '0000-00-00', '19:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE IF NOT EXISTS `EVENT_TYPE` (
  `EVENT_TYPE_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`EVENT_TYPE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `event_type`
--

INSERT INTO `EVENT_TYPE` (`EVENT_TYPE_ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'General Meetings', ''),
(2, 'Professional', ''),
(3, 'Competition', '');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE IF NOT EXISTS `EXPENSE` (
  `CHARGE_ID` int(20) unsigned NOT NULL,
  `MEMBER_ID` int(20) unsigned NOT NULL,
  `PAID` tinyint(1) NOT NULL,
  KEY `MEMBER_ID` (`MEMBER_ID`),
  KEY `CHARGE_ID` (`CHARGE_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE IF NOT EXISTS `MAJOR` (
  `MAJOR_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MAJOR_ID`),
  UNIQUE KEY `MAJOR_ID` (`MAJOR_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=121 ;

--
-- Dumping data for table `major`
--

INSERT INTO `MAJOR` (`MAJOR_ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'Accounting', ''),
(2, 'Architectural Studies', ''),
(3, 'Architecture', ''),
(4, 'Landscape Architecture', ''),
(5, 'Fine Arts', ''),
(6, 'Art', ''),
(7, 'Business Administration', ''),
(8, 'Business Administration (Cinematic Arts)', ''),
(9, 'Business Administration (International Relations)', ''),
(10, 'Business Administration (World Program)', ''),
(11, 'Computer Science/Business Administration', ''),
(12, 'Animation and Digital Arts', ''),
(13, 'Cinematic Arts, Critical Studies', ''),
(14, 'Cinematic Arts, Film and Television Production', ''),
(15, 'Interactive Media and Games', ''),
(16, 'Media Arts and Practice', ''),
(17, 'Writing for Screen and Television', ''),
(18, 'Broadcast and Digital Journalism', ''),
(19, 'Communication', ''),
(20, 'Print and Digital Journalism', ''),
(21, 'Public Relations', ''),
(22, 'Dental Hygiene', ''),
(23, 'Theatre', ''),
(24, 'Theatre (Acting)', ''),
(25, 'Theatre (Design)', ''),
(26, 'Theatre (Sound Design)', ''),
(27, 'Theatre (Stage Management)', ''),
(28, 'Theatre (Technical Direction)', ''),
(29, 'Visual and Performing Arts Studies', ''),
(30, 'Aerospace Engineering', ''),
(31, 'Mechanical Engineering', ''),
(32, 'Astronautical Engineering', ''),
(33, 'Biomedical Engineering', ''),
(34, 'Chemical Engineering', ''),
(35, 'Applied Mechanics', ''),
(36, 'Civil Engineering', ''),
(37, 'Computer Science', ''),
(38, 'Computer Science (Games)', ''),
(39, 'Physics/Computer Science', ''),
(40, 'Computer Engineering and Computer Science', ''),
(41, 'Electrical Engineering', ''),
(42, 'Industrial and Systems Engineering', ''),
(43, 'Human Development and Aging', ''),
(44, 'Lifespan Health', ''),
(45, 'American Studies and Ethnicity', ''),
(46, 'American Studies and Ethnicity (African American Studies)', ''),
(47, 'American Studies and Ethnicity (Asian American Studies)', ''),
(48, 'American Studies and Ethnicity (Chicano/Latino Studies)', ''),
(49, 'Anthropology', ''),
(50, 'Anthropology (Visual Anthropology)', ''),
(51, 'Global Studies', ''),
(52, 'Art History', ''),
(53, 'Biochemistry', ''),
(54, 'Biological Sciences', ''),
(55, 'Computational Neuroscience', ''),
(56, 'Human Biology', ''),
(57, 'Chemistry', ''),
(58, 'Chemistry (Chemical Biology)', ''),
(59, 'Chemistry (Chemical Nanoscience)', ''),
(60, 'Chemistry (Research)', ''),
(61, 'Classics', ''),
(62, 'Comparative Literature', ''),
(63, 'Earth Sciences', ''),
(64, 'Geological Sciences', ''),
(65, 'Physical Sciences', ''),
(66, 'East Asian Area Studies', ''),
(67, 'East Asian Languages and Cultures', ''),
(68, 'Linguistics/East Asian Languages and Cultures', ''),
(69, 'Economics', ''),
(70, 'Economics/Mathematics', ''),
(71, 'Political Economy', ''),
(72, 'English', ''),
(73, 'Narrative Studies', ''),
(74, 'Environmental Science and Health', ''),
(75, 'Environmental Studies', ''),
(76, 'French', ''),
(77, 'Italian', ''),
(78, 'Gender Studies', ''),
(79, 'Health and Humanity', ''),
(80, 'History', ''),
(81, 'History and Social Science Education', ''),
(82, 'Law, History and Culture', ''),
(83, 'Interdisciplinary Studies', ''),
(84, 'International Relations', ''),
(85, 'International Relations (Global Business) ', ''),
(86, 'International Relations and the Global Economy', ''),
(87, 'Human Performance', ''),
(88, 'Linguistics', ''),
(89, 'Linguistics/Philosophy', ''),
(90, 'Linguistics/Psychology', ''),
(91, 'Mathematics', ''),
(92, 'Applied and Computational Mathematics', ''),
(93, 'Middle East Studies', ''),
(94, 'Neuroscience', ''),
(95, 'Philosophy', ''),
(96, 'Philosophy, Politics and Law', ''),
(97, 'Astronomy', ''),
(98, 'Biophysics', ''),
(99, 'Physical Sciences', ''),
(100, 'Physics', ''),
(101, 'Political Science', ''),
(102, 'Cognitive Science', ''),
(103, 'Psychology', ''),
(104, 'Interdisciplinary Archaeology', ''),
(105, 'Religion', ''),
(106, 'Russian', ''),
(107, 'Social Sciences', ''),
(108, 'Sociology', ''),
(109, 'Spanish', ''),
(110, 'GeoDesign', ''),
(111, 'Global Health', ''),
(112, 'Health Promotion and Disease Prevention Studies', ''),
(113, 'Choral Music', ''),
(114, 'Composition', ''),
(115, 'Jazz Studies', ''),
(116, 'Music', ''),
(117, 'Music Industry', ''),
(118, 'Performance', ''),
(119, 'Occupational Therapy', ''),
(120, 'Policy, Planning and Development', '');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `MEMBER` (
  `MEMBER_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `MAJOR_ID` int(20) NOT NULL,
  `CLASS_ID` int(20) unsigned NOT NULL,
  `RANK_ID` int(20) unsigned NOT NULL,
  `CLASS_STAND_ID` int(20) unsigned NOT NULL,
  `USERNAME` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `PASSWORD` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FIRST_NAME` text COLLATE utf8_unicode_ci NOT NULL,
  `LAST_NAME` text COLLATE utf8_unicode_ci NOT NULL,
  `PHONE` text COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` text COLLATE utf8_unicode_ci NOT NULL,
  `GRAD_YEAR` year(4) NOT NULL,
  `JOIN_DATE` date NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `COMMENTS` longtext COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `MEMBER_ID` (`MEMBER_ID`),
  UNIQUE KEY `USERNAME` (`USERNAME`),
  KEY `CLASS_ID` (`CLASS_ID`),
  KEY `RANK_ID` (`RANK_ID`),
  KEY `CLASS_STAND_ID` (`CLASS_STAND_ID`),
  KEY `MAJOR_ID` (`MAJOR_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `member`
--

INSERT INTO `MEMBER` (`MEMBER_ID`, `MAJOR_ID`, `CLASS_ID`, `RANK_ID`, `CLASS_STAND_ID`, `USERNAME`, `PASSWORD`, `FIRST_NAME`, `LAST_NAME`, `PHONE`, `EMAIL`, `GRAD_YEAR`, `JOIN_DATE`, `ACTIVE`, `COMMENTS`) VALUES
(1, 34, 3, 5, 7, 'qhsu', '5f4dcc3b5aa765d61d8327deb882cf99', 'Quentin', 'Hsu', '4085977224', 'qhsu@usc.edu', 2015, '2014-03-29', 1, ''),
(2, 95, 2, 3, 6, 'jonasgua', '5f4dcc3b5aa765d61d8327deb882cf99', 'Jonas', 'Guan', '323423412', 'jonasgua@usc.edu', 2016, '2014-03-27', 1, ''),
(3, 37, 3, 4, 7, 'plee', '5f4dcc3b5aa765d61d8327deb882cf99', 'Philip', 'Lee', '2307407128', 'plee@usc.edu', 2015, '2014-03-30', 1, ''),
(4, 7, 3, 5, 6, 'tlian', '5f4dcc3b5aa765d61d8327deb882cf99', 'Thomas', 'Lian', '3048234729', 'tlian@usc.edu', 2015, '2014-03-30', 1, ''),
(5, 1, 1, 1, 5, 'ryue', '5f4dcc3b5aa765d61d8327deb882cf99', 'Russell', 'Yue', '2083791730', 'ryue@usc.edu', 2017, '2014-03-30', 1, ''),
(6, 103, 1, 1, 8, 'jdoe', '5f4dcc3b5aa765d61d8327deb882cf99', 'John', 'Doe', '4928372938', 'jdoe@gmail.com', 2014, '2014-03-30', 1, ''),
(7, 80, 2, 4, 7, 'ykim', '5f4dcc3b5aa765d61d8327deb882cf99', 'Yuna', 'Kim', '2341871247', 'ykim@gmail.com', 2014, '2014-03-30', 1, ''),
(8, 91, 1, 2, 9, 'tyoshinoya', '5f4dcc3b5aa765d61d8327deb882cf99', 'Tomoko', 'Aiyshuya', '3482015839', 'tpain@usc.edu', 2015, '2014-03-30', 1, ''),
(9, 1, 1, 1, 9, 'kiddo', '5f4dcc3b5aa765d61d8327deb882cf99', 'Bob', 'Kiddoo', '3928423894', 'kiddo@usc.edu', 2011, '2014-03-31', 1, ''),
(10, 69, 1, 1, 8, 'jchen', '5f4dcc3b5aa765d61d8327deb882cf99', 'John', 'Chen', '8645639552', 'jchen@usc.edu', 2014, '2014-04-06', 1, ''),
(11, 1, 1, 1, 5, 'ddayto', '5f4dcc3b5aa765d61d8327deb882cf99', 'Danielle', 'Dayto', '3082349234', 'dayto@usc.edu', 2017, '2014-04-06', 1, ''),
(12, 1, 1, 1, 7, 'newb', '5f4dcc3b5aa765d61d8327deb882cf99', 'Josh', 'Yeh', '2349234188', 'jyeh@usc.edu', 2015, '2014-04-06', 1, ''),
(13, 10, 1, 1, 6, 'jlin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Jim', 'Lin', '2341098719', 'jlin@gmail.com', 2016, '2014-04-06', 1, ''),
(14, 1, 1, 1, 8, 'rtan', '5f4dcc3b5aa765d61d8327deb882cf99', 'Robert', 'Tan', '2347083862', 'rtan@yahoo.com', 2014, '2014-04-14', 1, ''),
(15, 1, 1, 1, 7, 'ckim', '5f4dcc3b5aa765d61d8327deb882cf99', 'Chris', 'Kim', '4238764392', 'ckim@gmail.com', 2015, '2014-04-14', 1, ''),
(17, 7, 1, 1, 6, 'slin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Sarah', 'Lin', '7465236482', 'slin@usc.edu', 2016, '2014-04-14', 1, ''),
(18, 103, 1, 1, 8, 'rzhong', '5f4dcc3b5aa765d61d8327deb882cf99', 'Rachael', 'Zhong', '473629841', 'rzhong@usc.edu', 2014, '2014-04-14', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `member_major`
--

CREATE TABLE IF NOT EXISTS `MEMBER_MAJOR` (
  `MEMBER_ID` int(20) unsigned NOT NULL,
  `MAJOR_ID` int(20) unsigned NOT NULL,
  KEY `MEMBER_ID` (`MEMBER_ID`),
  KEY `MAJOR_ID` (`MAJOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `member_minor`
--

CREATE TABLE IF NOT EXISTS `MEMBER_MINOR` (
  `MEMBER_ID` int(20) unsigned NOT NULL,
  `MINOR_ID` int(20) unsigned NOT NULL,
  KEY `MEMBER_ID` (`MEMBER_ID`),
  KEY `MINOR_ID` (`MINOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `minor`
--

CREATE TABLE IF NOT EXISTS `MINOR` (
  `MINOR_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MINOR_ID`),
  UNIQUE KEY `MINOR_ID` (`MINOR_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE IF NOT EXISTS `PHOTO` (
  `PHOTO_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `PHOTO_TYPE_ID` int(20) unsigned NOT NULL,
  `EVENT_ID` int(20) unsigned NOT NULL,
  `PATH` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NAME` text COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`PHOTO_ID`),
  KEY `EVENT_ID` (`EVENT_ID`),
  KEY `PHOTO_TYPE_ID` (`PHOTO_TYPE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=18 ;

--
-- Dumping data for table `photo`
--

INSERT INTO `PHOTO` (`PHOTO_ID`, `PHOTO_TYPE_ID`, `EVENT_ID`, `PATH`, `TIMESTAMP`, `NAME`, `DESCRIPTION`) VALUES
(13, 1, 6, 'images/6/Coverpage.png', '2014-04-15 03:05:09', 'CTF Cover', ''),
(14, 1, 14, 'images/14/linux.jpg', '2014-04-15 03:05:22', 'Linux Cover', ''),
(15, 1, 15, 'images/15/ethernet.jpg', '2014-04-15 03:06:12', 'Network Cover', ''),
(16, 1, 16, 'images/16/Cryptography.jpg', '2014-04-15 03:06:41', 'Crypt Cover', ''),
(17, 1, 17, 'images/17/Swirl.jpg', '2014-04-15 03:07:08', 'Social Cover', '');

-- --------------------------------------------------------

--
-- Table structure for table `photo_type`
--

CREATE TABLE IF NOT EXISTS `PHOTO_TYPE` (
  `PHOTO_TYPE_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`PHOTO_TYPE_ID`),
  KEY `PHOTO_TYPE_ID` (`PHOTO_TYPE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `photo_type`
--

INSERT INTO `PHOTO_TYPE` (`PHOTO_TYPE_ID`, `NAME`, `DESCRIPTION`) VALUES
(1, 'Cover Photo', 'Main photo for the event. Appears on the front page of website.'),
(2, 'Promotional', 'Promotional material such as banners and flyers. Usually associated with pre-event pictures.'),
(3, 'Normal', 'Photos of the event during the event. Can be uploaded post-event.');

-- --------------------------------------------------------

--
-- Table structure for table `prospective`
--

CREATE TABLE IF NOT EXISTS `PROSPECTIVE` (
  `MEMBER_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `ACTIVE` tinyint(1) NOT NULL,
  `MAJOR_ID` int(11) NOT NULL,
  `CLASS_STAND_ID` int(20) unsigned NOT NULL,
  `FIRST_NAME` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `LAST_NAME` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `PHONE` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `GRAD_YEAR` year(4) NOT NULL,
  `SIGNTIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `COMMENTS` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MEMBER_ID`),
  KEY `CLASS_ID` (`CLASS_STAND_ID`),
  KEY `CLASS_STAND_ID` (`CLASS_STAND_ID`),
  KEY `MAJOR_ID` (`MAJOR_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `prospective`
--

INSERT INTO `PROSPECTIVE` (`MEMBER_ID`, `ACTIVE`, `MAJOR_ID`, `CLASS_STAND_ID`, `FIRST_NAME`, `LAST_NAME`, `PHONE`, `EMAIL`, `GRAD_YEAR`, `SIGNTIME`, `COMMENTS`) VALUES
(1, 0, 1, 6, 'Jim', 'Lin', '2341098719', 'jlin@gmail.com', 2016, '2014-04-15 03:49:41', ''),
(2, 1, 1, 8, 'Long', 'Gone', '7239648261', 'lgone@gamil.com', 2014, '2014-04-15 03:49:45', ''),
(3, 1, 4, 7, 'Ralph', 'Lin', '2439271863', 'rlin@usc.edu', 2015, '2014-04-15 03:49:48', ''),
(4, 0, 16, 8, 'Robert', 'Tan', '2347083862', 'rtan@yahoo.com', 2014, '2014-04-15 03:49:54', ''),
(6, 1, 62, 5, 'Ian', 'Low', '2487983729', 'ilow@gmail.com', 2017, '2014-04-15 03:49:59', ''),
(7, 1, 1, 7, 'Jake', 'Liu', '8472936281', 'jliu@usc.edu', 2015, '2014-04-15 04:05:35', '');

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE IF NOT EXISTS `RANK` (
  `RANK_ID` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `NAME` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `DESCRIPTION` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`RANK_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `rank`
--

INSERT INTO `RANK` (`RANK_ID`, `NAME`, `DESCRIPTION`) VALUES
(1, '1 Star', 'Lowest Ranking'),
(2, '2 Star', 'Below Average Ranking'),
(3, '3 Star', 'Average Ranking'),
(4, '4 Star', 'Above Average Ranking'),
(5, '5 Star', 'Highest Ranking');

-- --------------------------------------------------------

--
-- Table structure for table `signin`
--

CREATE TABLE IF NOT EXISTS `SIGNIN` (
  `ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `EVENT_ID` int(20) unsigned NOT NULL,
  `MEMBER_ID` int(20) unsigned NOT NULL,
  `SIGNIN_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `signin`
--

INSERT INTO `SIGNIN` (`ID`, `EVENT_ID`, `MEMBER_ID`, `SIGNIN_TIME`) VALUES
(1, 19, 5, '2014-03-31 02:32:41');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE IF NOT EXISTS `SIGNUP` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `EVENT_ID` int(20) unsigned NOT NULL,
  `MEMBER_ID` int(20) unsigned NOT NULL,
  `SIGNUP_TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `KEY` (`ID`),
  KEY `EVENT_ID` (`EVENT_ID`),
  KEY `MEMBER_ID` (`MEMBER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=52 ;

--
-- Dumping data for table `signup`
--

INSERT INTO `SIGNUP` (`ID`, `EVENT_ID`, `MEMBER_ID`, `SIGNUP_TIME`) VALUES
(1, 19, 5, '2014-03-30 07:00:00'),
(4, 6, 5, '2014-04-12 06:26:22'),
(5, 6, 1, '2014-04-12 07:03:06'),
(6, 9, 1, '2014-04-12 09:01:11'),
(7, 12, 1, '2014-04-12 09:01:11'),
(8, 8, 1, '2014-04-12 09:01:11'),
(9, 17, 1, '2014-04-12 09:01:11'),
(10, 18, 1, '2014-04-12 09:01:11'),
(11, 11, 2, '2014-04-12 09:01:11'),
(12, 16, 2, '2014-04-12 09:01:11'),
(13, 15, 2, '2014-04-12 09:01:11'),
(14, 18, 2, '2014-04-12 09:01:11'),
(15, 8, 3, '2014-04-12 09:01:11'),
(16, 15, 3, '2014-04-12 09:01:11'),
(17, 16, 3, '2014-04-12 09:01:11'),
(18, 19, 3, '2014-04-12 09:01:11'),
(19, 14, 4, '2014-04-12 09:01:11'),
(20, 11, 4, '2014-04-12 09:01:11'),
(21, 17, 4, '2014-04-12 09:01:11'),
(22, 18, 4, '2014-04-12 09:02:09'),
(23, 16, 4, '2014-04-12 09:02:13'),
(24, 13, 4, '2014-04-12 09:02:16'),
(25, 15, 4, '2014-04-12 09:02:19'),
(26, 19, 6, '2014-04-12 09:02:55'),
(27, 18, 6, '2014-04-12 09:02:56'),
(28, 17, 6, '2014-04-12 09:02:57'),
(29, 16, 6, '2014-04-12 09:02:59'),
(30, 15, 6, '2014-04-12 09:03:00'),
(31, 14, 6, '2014-04-12 09:03:01'),
(32, 19, 7, '2014-04-12 09:03:17'),
(33, 18, 7, '2014-04-12 09:03:18'),
(34, 17, 7, '2014-04-12 09:03:19'),
(35, 16, 7, '2014-04-12 09:03:20'),
(36, 15, 7, '2014-04-12 09:03:21'),
(37, 13, 7, '2014-04-12 09:03:23'),
(38, 19, 9, '2014-04-12 09:03:46'),
(39, 17, 9, '2014-04-12 09:03:49'),
(40, 18, 9, '2014-04-12 09:03:54'),
(41, 16, 9, '2014-04-12 09:04:06'),
(42, 15, 9, '2014-04-12 09:04:39'),
(43, 14, 9, '2014-04-12 09:04:42'),
(44, 13, 9, '2014-04-12 09:04:44'),
(45, 19, 11, '2014-04-12 09:05:00'),
(46, 18, 11, '2014-04-12 09:05:01'),
(47, 17, 11, '2014-04-12 09:05:03'),
(48, 16, 11, '2014-04-12 09:05:04'),
(49, 15, 11, '2014-04-12 09:05:05'),
(50, 6, 11, '2014-04-12 09:05:08'),
(51, 19, 1, '2014-04-13 00:43:23');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `charge`
--
ALTER TABLE `CHARGE`
  ADD CONSTRAINT `charge_ibfk_1` FOREIGN KEY (`CHARGE_TYPE_ID`) REFERENCES `CHARGE_TYPE` (`CHARGE_TYPE_ID`),
  ADD CONSTRAINT `charge_ibfk_2` FOREIGN KEY (`CHARGE_CAT_ID`) REFERENCES `CHARGE_CATEGORY` (`CHARGE_CAT_ID`),
  ADD CONSTRAINT `charge_ibfk_3` FOREIGN KEY (`EVENT_ID`) REFERENCES `EVENT` (`EVENT_ID`);

--
-- Constraints for table `class_require`
--
ALTER TABLE `CLASS_REQUIRE`
  ADD CONSTRAINT `class_require_ibfk_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `CLASS` (`CLASS_ID`);

--
-- Constraints for table `class_require_event`
--
ALTER TABLE `CLASS_REQUIRE_EVENT`
  ADD CONSTRAINT `class_require_event_ibfk_1` FOREIGN KEY (`CLASS_REQUIRE_ID`) REFERENCES `CLASS_REQUIRE` (`CLASS_REQUIRE_ID`);

--
-- Constraints for table `event`
--
ALTER TABLE `EVENT`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`EVENT_TYPE_ID`) REFERENCES `EVENT_TYPE` (`EVENT_TYPE_ID`);

--
-- Constraints for table `expense`
--
ALTER TABLE `EXPENSE`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`CHARGE_ID`) REFERENCES `CHARGE` (`CHARGE_ID`),
  ADD CONSTRAINT `expense_ibfk_2` FOREIGN KEY (`MEMBER_ID`) REFERENCES `MEMBER` (`MEMBER_ID`);

--
-- Constraints for table `member`
--
ALTER TABLE `MEMBER`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`CLASS_ID`) REFERENCES `CLASS` (`CLASS_ID`),
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`RANK_ID`) REFERENCES `RANK` (`RANK_ID`),
  ADD CONSTRAINT `member_ibfk_3` FOREIGN KEY (`CLASS_STAND_ID`) REFERENCES `CLASS_STANDING` (`CLASS_STAND_ID`);

--
-- Constraints for table `member_major`
--
ALTER TABLE `MEMBER_MAJOR`
  ADD CONSTRAINT `member_major_ibfk_1` FOREIGN KEY (`MEMBER_ID`) REFERENCES `MEMBER` (`MEMBER_ID`),
  ADD CONSTRAINT `member_major_ibfk_2` FOREIGN KEY (`MAJOR_ID`) REFERENCES `MAJOR` (`MAJOR_ID`);

--
-- Constraints for table `member_minor`
--
ALTER TABLE `MEMBER_MINOR`
  ADD CONSTRAINT `member_minor_ibfk_1` FOREIGN KEY (`MEMBER_ID`) REFERENCES `MEMBER` (`MEMBER_ID`),
  ADD CONSTRAINT `member_minor_ibfk_2` FOREIGN KEY (`MINOR_ID`) REFERENCES `MINOR` (`MINOR_ID`);

--
-- Constraints for table `photo`
--
ALTER TABLE `PHOTO`
  ADD CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`EVENT_ID`) REFERENCES `EVENT` (`EVENT_ID`),
  ADD CONSTRAINT `photo_ibfk_2` FOREIGN KEY (`PHOTO_TYPE_ID`) REFERENCES `PHOTO_TYPE` (`PHOTO_TYPE_ID`);

--
-- Constraints for table `prospective`
--
ALTER TABLE `PROSPECTIVE`
  ADD CONSTRAINT `prospective_ibfk_3` FOREIGN KEY (`CLASS_STAND_ID`) REFERENCES `CLASS_STANDING` (`CLASS_STAND_ID`);

--
-- Constraints for table `signup`
--
ALTER TABLE `SIGNUP`
  ADD CONSTRAINT `signup_ibfk_1` FOREIGN KEY (`EVENT_ID`) REFERENCES `EVENT` (`EVENT_ID`),
  ADD CONSTRAINT `signup_ibfk_2` FOREIGN KEY (`MEMBER_ID`) REFERENCES `MEMBER` (`MEMBER_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
