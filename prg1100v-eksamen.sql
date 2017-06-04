-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 05, 2017 at 12:06 AM
-- Server version: 10.0.29-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.0.18-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prg1100v-eksamen`
--

-- --------------------------------------------------------

--
-- Table structure for table `behandler`
--

CREATE TABLE `behandler` (
  `brukernavn` varchar(20) NOT NULL,
  `behandlernavn` varchar(50) NOT NULL,
  `yrkesgruppe` varchar(50) NOT NULL,
  `bildenr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bilde`
--

CREATE TABLE `bilde` (
  `bildenr` int(11) NOT NULL,
  `opplastingsdato` date NOT NULL,
  `filnavn` varchar(255) NOT NULL,
  `beskrivelse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bruker`
--

CREATE TABLE `bruker` (
  `brukernavn` varchar(20) NOT NULL,
  `passord` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bruker`
--

INSERT INTO `bruker` (`brukernavn`, `passord`) VALUES
('admin', '$2y$10$cothFHVZTzb76dB3Jjkc0OOQcUm83.L6Cvd6pA/hrwCIDGIcRvfa.');

-- --------------------------------------------------------

--
-- Table structure for table `pasient`
--

CREATE TABLE `pasient` (
  `personnr` int(11) NOT NULL,
  `navn` varchar(50) NOT NULL,
  `passord` varchar(255) NOT NULL,
  `fastlege` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `timebestilling`
--

CREATE TABLE `timebestilling` (
  `brukernavn` varchar(20) NOT NULL,
  `dato` date NOT NULL,
  `tidspunkt` time NOT NULL,
  `personnr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `timeinndeling`
--

CREATE TABLE `timeinndeling` (
  `brukernavn` varchar(20) NOT NULL,
  `ukedag` varchar(10) NOT NULL,
  `tidspunkt` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yrkesgruppe`
--

CREATE TABLE `yrkesgruppe` (
  `yrkesgruppe` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `behandler`
--
ALTER TABLE `behandler`
  ADD PRIMARY KEY (`brukernavn`),
  ADD KEY `yrkesgruppe` (`yrkesgruppe`),
  ADD KEY `bildenr` (`bildenr`);

--
-- Indexes for table `bilde`
--
ALTER TABLE `bilde`
  ADD PRIMARY KEY (`bildenr`);

--
-- Indexes for table `bruker`
--
ALTER TABLE `bruker`
  ADD PRIMARY KEY (`brukernavn`);

--
-- Indexes for table `pasient`
--
ALTER TABLE `pasient`
  ADD PRIMARY KEY (`personnr`),
  ADD KEY `fastlege` (`fastlege`);

--
-- Indexes for table `timebestilling`
--
ALTER TABLE `timebestilling`
  ADD PRIMARY KEY (`brukernavn`,`dato`,`tidspunkt`),
  ADD KEY `personnr` (`personnr`);

--
-- Indexes for table `timeinndeling`
--
ALTER TABLE `timeinndeling`
  ADD PRIMARY KEY (`brukernavn`,`ukedag`,`tidspunkt`);

--
-- Indexes for table `yrkesgruppe`
--
ALTER TABLE `yrkesgruppe`
  ADD PRIMARY KEY (`yrkesgruppe`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bilde`
--
ALTER TABLE `bilde`
  MODIFY `bildenr` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `behandler`
--
ALTER TABLE `behandler`
  ADD CONSTRAINT `behandler_ibfk_1` FOREIGN KEY (`yrkesgruppe`) REFERENCES `yrkesgruppe` (`yrkesgruppe`),
  ADD CONSTRAINT `behandler_ibfk_2` FOREIGN KEY (`bildenr`) REFERENCES `bilde` (`bildenr`);

--
-- Constraints for table `pasient`
--
ALTER TABLE `pasient`
  ADD CONSTRAINT `pasient_ibfk_1` FOREIGN KEY (`fastlege`) REFERENCES `behandler` (`brukernavn`);

--
-- Constraints for table `timebestilling`
--
ALTER TABLE `timebestilling`
  ADD CONSTRAINT `timebestilling_ibfk_1` FOREIGN KEY (`brukernavn`) REFERENCES `behandler` (`brukernavn`),
  ADD CONSTRAINT `timebestilling_ibfk_2` FOREIGN KEY (`personnr`) REFERENCES `pasient` (`personnr`);

--
-- Constraints for table `timeinndeling`
--
ALTER TABLE `timeinndeling`
  ADD CONSTRAINT `timeinndeling_ibfk_1` FOREIGN KEY (`brukernavn`) REFERENCES `behandler` (`brukernavn`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
