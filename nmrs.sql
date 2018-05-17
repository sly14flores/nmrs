-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 17, 2018 at 11:29 AM
-- Server version: 5.7.11
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nmrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `update_log` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `system_log` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `first_name`, `last_name`, `username`, `password`, `update_log`, `system_log`) VALUES
(1, 'Admin', '', 'admin', 'admin', '2018-04-08 20:11:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reg_jobseekers`
--

CREATE TABLE `reg_jobseekers` (
  `SeekerID` int(11) NOT NULL,
  `FirstName` varchar(128) DEFAULT NULL,
  `MiddleName` varchar(128) DEFAULT NULL,
  `LastName` varchar(128) DEFAULT NULL,
  `OccupationalSkill` varchar(250) DEFAULT NULL,
  `Occ_Code` varchar(250) DEFAULT NULL,
  `Sex` varchar(8) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `CivilStat` varchar(16) DEFAULT NULL,
  `EducAttain` varchar(250) DEFAULT NULL,
  `YearsofWorkExp` varchar(250) DEFAULT NULL,
  `PhoneNo` varchar(64) DEFAULT NULL,
  `Licence` varchar(250) DEFAULT NULL,
  `DateRegistered` datetime DEFAULT NULL,
  `JobPlacement` varchar(255) DEFAULT NULL,
  `Job` varchar(255) DEFAULT NULL,
  `School` varchar(255) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `YearGraduated` int(11) DEFAULT NULL,
  `EmailAddress` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Height` float DEFAULT NULL,
  `Weight` float DEFAULT NULL,
  `emp_stat` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reg_jobseekers`
--
ALTER TABLE `reg_jobseekers`
  ADD PRIMARY KEY (`SeekerID`),
  ADD KEY `DATE_REG` (`DateRegistered`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `reg_jobseekers`
--
ALTER TABLE `reg_jobseekers`
  MODIFY `SeekerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
