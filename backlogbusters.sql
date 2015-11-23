-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2015 at 09:01 PM
-- Server version: 5.5.44-0+deb8u1
-- PHP Version: 5.6.14-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `backlogbusters`
--
CREATE DATABASE IF NOT EXISTS `backlogbusters` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `backlogbusters`;

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
`gameID` int(11) NOT NULL,
  `gameName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `totalTTB` float NOT NULL,
  `TTBEntries` int(11) NOT NULL,
  `totalSession` float NOT NULL,
  `sessionEntries` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=404731 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gametimes`
--

CREATE TABLE IF NOT EXISTS `gametimes` (
  `UserID` int(11) NOT NULL,
  `day` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `startTime` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `GameID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usergamerelations`
--

CREATE TABLE IF NOT EXISTS `usergamerelations` (
  `UserID` int(11) NOT NULL,
  `GameID` int(11) NOT NULL,
  `timePlayed` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`userID` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `games`
--
ALTER TABLE `games`
 ADD PRIMARY KEY (`gameID`), ADD KEY `GameID` (`gameID`), ADD KEY `GameName` (`gameName`);

--
-- Indexes for table `gametimes`
--
ALTER TABLE `gametimes`
 ADD KEY `UserID` (`UserID`), ADD KEY `GameID` (`GameID`);

--
-- Indexes for table `usergamerelations`
--
ALTER TABLE `usergamerelations`
 ADD KEY `UserID` (`UserID`), ADD KEY `GameID` (`GameID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`userID`), ADD KEY `UserID` (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
MODIFY `gameID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=404731;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `gametimes`
--
ALTER TABLE `gametimes`
ADD CONSTRAINT `calendar2games` FOREIGN KEY (`GameID`) REFERENCES `games` (`gameID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `calendar2user` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usergamerelations`
--
ALTER TABLE `usergamerelations`
ADD CONSTRAINT `games2usergame` FOREIGN KEY (`UserID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `usergamerelations_ibfk_1` FOREIGN KEY (`GameID`) REFERENCES `games` (`gameID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
