-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2017 at 11:02 PM
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
(4, 'Home', 'teacher', 'fa fa-home', 4, 'teacher'),
(5, 'Analyze Items', NULL, 'fa fa-cogs', 5, 'teacher'),
(6, 'View Users', 'admin/viewusers', NULL, 2, 'admin'),
(7, 'Add User', 'admin/adduser', NULL, 2, 'admin'),
(8, 'Your Profile', 'admin/profile', NULL, 2, 'admin'),
(9, 'School Data', 'admin/schooldata', NULL, 3, 'admin'),
(10, 'School\'s Classes', 'admin/schoolclasses', NULL, 3, 'admin'),
(11, 'New Analyze', 'teacher/newanalyze', NULL, 5, 'teacher'),
(12, 'List of Analyze', 'teacher/analyzes', NULL, 5, 'teacher');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sidebar`
--
ALTER TABLE `ci_sidebar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ci_sidebar`
--
ALTER TABLE `ci_sidebar`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
