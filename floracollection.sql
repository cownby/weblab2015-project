-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2015 at 02:55 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `floracollection`
--

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL,
  `lat` decimal(10,5) DEFAULT NULL,
  `lon` decimal(10,5) DEFAULT NULL,
  `locationNotes` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `lat`, `lon`, `locationNotes`) VALUES
(1, NULL, NULL, 'Rocky Mtn National Park'),
(2, '41.00000', '-105.00000', NULL),
(3, '41.00000', '-105.00000', NULL),
(4, '41.00000', '-105.00000', 'waverly'),
(5, '41.00000', '-105.00000', NULL),
(6, '40.73131', '-105.08469', 'poudre canyon');

-- --------------------------------------------------------

--
-- Table structure for table `observations`
--

CREATE TABLE IF NOT EXISTS `observations` (
  `id` int(11) NOT NULL,
  `observationDate` datetime NOT NULL,
  `notes` varchar(200) DEFAULT NULL,
  `plantId` int(11) NOT NULL,
  `locationId` int(11) DEFAULT NULL,
  `weatherId` int(11) DEFAULT NULL,
  `soilTypeId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `observations`
--

INSERT INTO `observations` (`id`, `observationDate`, `notes`, `plantId`, `locationId`, `weatherId`, `soilTypeId`, `userId`) VALUES
(8, '2015-12-06 00:00:00', NULL, 32, 3, 27, 4, 1),
(9, '2015-12-06 00:00:00', NULL, 33, 4, 28, 3, 1),
(10, '2015-12-06 00:00:00', NULL, 34, 5, 29, 2, 1),
(11, '2015-12-06 00:00:00', 'Moose was eating it.', 35, 6, 30, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `plants`
--

CREATE TABLE IF NOT EXISTS `plants` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `plants`
--

INSERT INTO `plants` (`id`, `name`) VALUES
(3, 'columbine'),
(4, 'toadflax'),
(32, 'dandilion'),
(33, 'beanstalk'),
(35, 'clover');

-- --------------------------------------------------------

--
-- Table structure for table `soiltypes`
--

CREATE TABLE IF NOT EXISTS `soiltypes` (
  `id` int(11) NOT NULL,
  `soil` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `soiltypes`
--

INSERT INTO `soiltypes` (`id`, `soil`) VALUES
(1, 'sand'),
(2, 'silt'),
(3, 'clay'),
(4, 'loam'),
(5, 'peat'),
(6, 'gravel'),
(7, 'rocky');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(45) DEFAULT NULL,
  `lastName` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `pass` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `roleStr` varchar(20) NOT NULL DEFAULT 'submitter',
  `role` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `pass`, `name`, `roleStr`, `role`) VALUES
(1, 'guest', 'anonymous', NULL, '', 'guest', 'submitter', 0),
(2, 'admin', 'admin', NULL, 'admin', 'admin', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `weather`
--

CREATE TABLE IF NOT EXISTS `weather` (
  `id` int(11) NOT NULL,
  `tempF` float DEFAULT NULL,
  `windMPH` float DEFAULT NULL,
  `weatherNotes` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `weather`
--

INSERT INTO `weather` (`id`, `tempF`, `windMPH`, `weatherNotes`) VALUES
(19, 25.23, NULL, NULL),
(20, 25.23, NULL, NULL),
(21, 25.23, NULL, NULL),
(22, 23.43, NULL, NULL),
(23, 23.43, NULL, NULL),
(24, 23.43, NULL, NULL),
(25, 23.43, NULL, NULL),
(26, 23.43, NULL, NULL),
(27, 23.43, NULL, NULL),
(28, 28, NULL, NULL),
(29, 23.43, NULL, NULL),
(30, 43.27, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `observations`
--
ALTER TABLE `observations`
  ADD UNIQUE KEY `observation` (`id`),
  ADD KEY `plantId` (`plantId`);

--
-- Indexes for table `plants`
--
ALTER TABLE `plants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `soiltypes`
--
ALTER TABLE `soiltypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- Indexes for table `weather`
--
ALTER TABLE `weather`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `observations`
--
ALTER TABLE `observations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `plants`
--
ALTER TABLE `plants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `soiltypes`
--
ALTER TABLE `soiltypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `weather`
--
ALTER TABLE `weather`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
