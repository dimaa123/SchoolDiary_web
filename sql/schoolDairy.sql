-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 25, 2017 at 11:58 AM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `schoolDairy`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `sender` varchar(55) NOT NULL,
  `receiver` varchar(55) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `sender_flag` int(11) NOT NULL,
  `receiver_flag` int(11) NOT NULL,
  `created_at` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `sender`, `receiver`, `msg`, `sender_flag`, `receiver_flag`, `created_at`) VALUES
(14, 'a', 'b', 'he', 1, 1, 1484829261),
(15, 'b', 'a', 'your', 1, 1, 1484829310),
(16, 'a', 'b', 'your', 1, 1, 1484829423),
(17, 'a', 'b', 'rf', 1, 1, 1484830093),
(18, 'b', 'a', 'gg', 1, 1, 1484830150),
(19, 'a', 'b', 'ff', 1, 1, 1484830260),
(20, 'a', 'b', 'okay', 1, 1, 1484830703);

-- --------------------------------------------------------

--
-- Table structure for table `groupMembers`
--

CREATE TABLE `groupMembers` (
  `id` int(11) NOT NULL,
  `groupID` varchar(55) NOT NULL,
  `email` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groupMembers`
--

INSERT INTO `groupMembers` (`id`, `groupID`, `email`) VALUES
(1, '1485247402', 'a@gmail.com'),
(2, '1485247402', 'b@gmail.com'),
(3, '1485247402', 'c@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `email`, `name`, `password`) VALUES
(1, 'a@gmail.com', 'A', '123'),
(2, 'b@gmail.com', 'B', '123'),
(3, 'c@gmail.com', 'C', '123');

-- --------------------------------------------------------

--
-- Table structure for table `parentsGroup`
--

CREATE TABLE `parentsGroup` (
  `id` int(11) NOT NULL,
  `groupName` varchar(55) NOT NULL,
  `groupID` varchar(55) NOT NULL,
  `groupOwner` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parentsGroup`
--

INSERT INTO `parentsGroup` (`id`, `groupName`, `groupID`, `groupOwner`) VALUES
(1, 'demo', '1485247402', 'x@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `recentChats`
--

CREATE TABLE `recentChats` (
  `id` int(11) NOT NULL,
  `teacher` varchar(55) NOT NULL,
  `parents` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recentChats`
--

INSERT INTO `recentChats` (`id`, `teacher`, `parents`) VALUES
(1, 'x@gmail.com', 'a@gmail.com'),
(2, 'x@gmail.com', 'b@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `email` varchar(55) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `email`, `name`, `password`) VALUES
(1, 'x@gmail.com', 'X', '123'),
(2, 'y@gmail.com', 'Y', '123'),
(3, 'z@gmail.com', 'Z', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groupMembers`
--
ALTER TABLE `groupMembers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parentsGroup`
--
ALTER TABLE `parentsGroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recentChats`
--
ALTER TABLE `recentChats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `groupMembers`
--
ALTER TABLE `groupMembers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `parentsGroup`
--
ALTER TABLE `parentsGroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `recentChats`
--
ALTER TABLE `recentChats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
