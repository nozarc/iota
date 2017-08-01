-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2017 at 11:00 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codeigniter`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_classes`
--

CREATE TABLE `ci_classes` (
  `class_id` int(5) NOT NULL,
  `classname` varchar(20) DEFAULT NULL,
  `classinfo` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_classes`
--

INSERT INTO `ci_classes` (`class_id`, `classname`, `classinfo`) VALUES
(1, 'X IPS 1', NULL),
(2, 'X IPS 2', NULL),
(3, 'X IPS 3', NULL),
(4, 'X IPS 4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_log`
--

CREATE TABLE `ci_log` (
  `id` int(5) NOT NULL,
  `angka1` int(5) DEFAULT NULL,
  `angka2` int(5) DEFAULT NULL,
  `hasil` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_people`
--

CREATE TABLE `ci_people` (
  `uid` int(5) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `identity_number` varchar(50) DEFAULT NULL,
  `address` text,
  `gender` enum('m','f') DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `userphoto` text,
  `email` varchar(30) DEFAULT NULL,
  `class` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_people`
--

INSERT INTO `ci_people` (`uid`, `name`, `identity_number`, `address`, `gender`, `phone`, `userphoto`, `email`, `class`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 'http://localhost/mywebsite/codeigniter3/template/images/1_photo.jpg', NULL, NULL),
(2, 'rey', '', '', 'm', '', 'http://localhost/mywebsite/codeigniter3/template/images/defaultphoto.png', '', 1),
(3, 'lisa', '', '', 'f', '', 'http://localhost/mywebsite/codeigniter3/template/images/defaultphoto.png', '', NULL),
(4, 'yuzu', '', '', 'f', '', 'http://localhost/mywebsite/codeigniter3/template/images/defaultphoto.png', '', 1),
(5, 'yazaki', '', '', 'm', '', 'http://localhost/mywebsite/codeigniter3/template/images/defaultphoto.png', '', 1),
(6, 'Kepsek ', '', '', 'm', '', 'http://localhost/mywebsite/codeigniter3/template/images/defaultphoto.png', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ci_schooldata`
--

CREATE TABLE `ci_schooldata` (
  `id` int(2) NOT NULL,
  `keyword` varchar(30) DEFAULT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_schooldata`
--

INSERT INTO `ci_schooldata` (`id`, `keyword`, `value`) VALUES
(1, 'schoolname', 'MAN 1 Jember'),
(2, 'schooladdress', 'jl imam bonjol'),
(3, 'schoolemail', 'man1jember@yahoo.com'),
(4, 'schoolphone', '0331000011'),
(5, 'schoolwebsite', 'www.man1jember.sch.id'),
(6, 'schoollogo', 'http://localhost/mywebsite/codeigniter3/template//images/school_logo.png');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sidebar`
--

CREATE TABLE `ci_sidebar` (
  `id` int(5) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `href` text,
  `class` text,
  `parent` int(5) DEFAULT NULL,
  `owner` enum('admin','headmaster','teacher','officer','student') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sidebar`
--

INSERT INTO `ci_sidebar` (`id`, `name`, `href`, `class`, `parent`, `owner`) VALUES
(1, 'Home', 'admin', 'fa fa-home', 1, 'admin'),
(2, 'Users', NULL, 'fa fa-users', 2, 'admin'),
(3, 'School Data', NULL, 'fa fa-university', 3, 'admin'),
(7, 'View Users', 'admin/viewusers', NULL, 2, 'admin'),
(8, 'Add User', 'admin/adduser', NULL, 2, 'admin'),
(9, 'Your Profile', 'admin/profile', NULL, 2, 'admin'),
(10, 'School Data', 'admin/schooldata', NULL, 3, 'admin'),
(11, 'School\'s classes', 'admin/schoolclasses', NULL, 3, 'admin'),
(13, 'Home', 'teacher', 'fa fa-home', 13, 'teacher'),
(14, 'Analyze Items', NULL, 'fa fa-cogs', 14, 'teacher'),
(15, 'New Analyze', 'teacher/newanalyze', NULL, 14, 'teacher'),
(16, 'List of Analyzes', 'teacher/analyzes', NULL, 14, 'teacher');

-- --------------------------------------------------------

--
-- Table structure for table `ci_user`
--

CREATE TABLE `ci_user` (
  `uid` int(5) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `level` enum('admin','headmaster','teacher','officer','student') DEFAULT NULL,
  `status` enum('active','nonactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_user`
--

INSERT INTO `ci_user` (`uid`, `username`, `password`, `level`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'active'),
(2, 'guru', '77e69c137812518e359196bb2f5e9bb9', 'teacher', 'active'),
(3, 'guru2', '440a21bd2b3a7c686cf3238883dd34e9', 'teacher', 'active'),
(4, 'siswa', 'bcd724d15cde8c47650fda962968f102', 'student', 'active'),
(5, 'siswa2', '331633a246a4e1ceefc9539a71fcd124', 'student', 'active'),
(6, 'kepsek', '8561863b55faf85b9ad67c52b3b851ac', 'headmaster', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_classes`
--
ALTER TABLE `ci_classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `ci_log`
--
ALTER TABLE `ci_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_people`
--
ALTER TABLE `ci_people`
  ADD KEY `uid` (`uid`),
  ADD KEY `class` (`class`);

--
-- Indexes for table `ci_schooldata`
--
ALTER TABLE `ci_schooldata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sidebar`
--
ALTER TABLE `ci_sidebar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_user`
--
ALTER TABLE `ci_user`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_classes`
--
ALTER TABLE `ci_classes`
  MODIFY `class_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ci_log`
--
ALTER TABLE `ci_log`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ci_schooldata`
--
ALTER TABLE `ci_schooldata`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ci_sidebar`
--
ALTER TABLE `ci_sidebar`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `ci_user`
--
ALTER TABLE `ci_user`
  MODIFY `uid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ci_people`
--
ALTER TABLE `ci_people`
  ADD CONSTRAINT `ci_people_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ci_user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ci_people_ibfk_2` FOREIGN KEY (`class`) REFERENCES `ci_classes` (`class_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
