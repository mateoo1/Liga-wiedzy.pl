-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2020 at 09:17 PM
-- Server version: 5.6.40
-- PHP Version: 5.6.38

SET SQL_MODE = "";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_db`
--
CREATE DATABASE IF NOT EXISTS `test_db` DEFAULT CHARACTER SET latin2 COLLATE latin2_general_ci;
USE `test_db`;

-- --------------------------------------------------------

--
-- Table structure for table `bany`
--

DROP TABLE IF EXISTS `bany`;
CREATE TABLE `bany` (
  `adres` varchar(50) COLLATE utf8_polish_ci 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

DROP TABLE IF EXISTS `board`;
CREATE TABLE `board` (
  `id` int(11) ,
  `name` varchar(255) COLLATE utf8_polish_ci ,
  `comment` text COLLATE utf8_polish_ci ,
  `date` datetime  DEFAULT CURRENT_TIMESTAMP,
  `aid` varchar(50) COLLATE utf8_polish_ci ,
  `ip` varchar(40) COLLATE utf8_polish_ci 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `league`
--

DROP TABLE IF EXISTS `league`;
CREATE TABLE `league` (
  `nr` int(11) ,
  `player_name` varchar(255) COLLATE utf8_polish_ci ,
  `player_location` varchar(255) COLLATE utf8_polish_ci ,
  `points` int(11) ,
  `attempts` int(255) ,
  `date_data` datetime  DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `pass` varchar(50) COLLATE utf8_polish_ci ,
  `ans` text COLLATE utf8_polish_ci ,
  `passed_questions` text COLLATE utf8_polish_ci ,
  `reset` int(255) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `id` int(11) ,
  `question` text COLLATE utf8_polish_ci ,
  `answer` text COLLATE utf8_polish_ci ,
  `answer2` text COLLATE utf8_polish_ci ,
  `calls` int(11) ,
  `mistake` int(255) ,
  `answers` longtext COLLATE utf8_polish_ci ,
  `aux` int(8) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


INSERT INTO `questions` (`id`, `question`, `answer`, `answer2`, `calls`, `mistake`, `answers`, `aux`) VALUES
(1, 'Jak nazywa się mocny trunek pochodzący z Japonii?', 'sake', '', 0, 0, '', 64401),
(2, 'Hej tam gdzieś z czarnej wody wsiada na koń ułan młody, czule żegna się z dziewczyną, jeszcze czulej z ….?', 'Ukrainą', '', 0, 0, '', 36987),
(3, 'W co uderzamy kijem podczas gry w bilard?', 'W bile', 'bile', 0, 0, '', 54245),
(4, 'Ile wynosi 2+2?', 4, 4, 0, 0, '', 54245);

-- --------------------------------------------------------

--
-- Table structure for table `traffic`
--

DROP TABLE IF EXISTS `traffic`;
CREATE TABLE `traffic` (
  `id` int(11) ,
  `ip` varchar(50) CHARACTER SET latin2 ,
  `visits` int(255) ,
  `time` datetime  DEFAULT CURRENT_TIMESTAMP,
  `browser` text COLLATE utf8_polish_ci ,
  `forms` varchar(100) COLLATE utf8_polish_ci 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `league`
--
ALTER TABLE `league`
  ADD PRIMARY KEY (`nr`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `traffic`
--
ALTER TABLE `traffic`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `board`
--
ALTER TABLE `board`
  MODIFY `id` int(11)  AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `league`
--
ALTER TABLE `league`
  MODIFY `nr` int(11)  AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `traffic`
--
ALTER TABLE `traffic`
  MODIFY `id` int(11)  AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
