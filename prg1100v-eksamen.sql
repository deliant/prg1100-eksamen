-- phpMyAdmin SQL Dump
-- version 4.6.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 11, 2017 at 08:27 PM
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
  `yrkesgruppenr` int(11) NOT NULL,
  `bildenr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `behandler`
--

INSERT INTO `behandler` (`brukernavn`, `behandlernavn`, `yrkesgruppenr`, `bildenr`) VALUES
('bjarne b', 'bjarne bjarnesen', 1, 4),
('mn', 'marius norheim', 1, 1);

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

--
-- Dumping data for table `bilde`
--

INSERT INTO `bilde` (`bildenr`, `opplastingsdato`, `filnavn`, `beskrivelse`) VALUES
(1, '2017-06-05', 'moneeey.jpeg', 'bilde av marius'),
(4, '2017-06-11', 'poweroflove.jpg', 'testbilde');

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
('admin', '$2y$10$w7RRf8k1ShawPHBjXGUfaeccmBC7Pvf.zxwGXh8VqR2KygE0osLuq'),
('bjarne b', '$2y$10$ME5loW3Zn8C7JRrA70HaoOrI1vWFwFqZtJy6UuF5DrOVzMQzxVJEu');

-- --------------------------------------------------------

--
-- Table structure for table `pasient`
--

CREATE TABLE `pasient` (
  `personnr` bigint(11) NOT NULL,
  `pasientnavn` varchar(50) NOT NULL,
  `passord` varchar(255) DEFAULT NULL,
  `brukernavn` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pasient`
--

INSERT INTO `pasient` (`personnr`, `pasientnavn`, `passord`, `brukernavn`) VALUES
(30075512345, 'arne bjarne', NULL, 'mn');

-- --------------------------------------------------------

--
-- Table structure for table `timebestilling`
--

CREATE TABLE `timebestilling` (
  `timebestillingnr` int(11) NOT NULL,
  `dato` date NOT NULL,
  `tidspunkt` varchar(12) NOT NULL,
  `brukernavn` varchar(20) NOT NULL,
  `personnr` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `timebestilling`
--

INSERT INTO `timebestilling` (`timebestillingnr`, `dato`, `tidspunkt`, `brukernavn`, `personnr`) VALUES
(2, '2017-06-12', '08:00-08:15', 'mn', 30075512345),
(3, '2017-06-12', '08:30-08:45', 'mn', 30075512345);

-- --------------------------------------------------------

--
-- Table structure for table `timeinndeling`
--

CREATE TABLE `timeinndeling` (
  `timeinndelingnr` int(11) NOT NULL,
  `brukernavn` varchar(20) NOT NULL,
  `ukedag` varchar(20) NOT NULL,
  `tidspunkt` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `timeinndeling`
--

INSERT INTO `timeinndeling` (`timeinndelingnr`, `brukernavn`, `ukedag`, `tidspunkt`) VALUES
(1, 'mn', 'Mandag', '08:00-08:15'),
(2, 'mn', 'Mandag', '08:15-08:30'),
(3, 'mn', 'Mandag', '08:30-08:45'),
(4, 'mn', 'Mandag', '08:45-09:00');

-- --------------------------------------------------------

--
-- Table structure for table `yrkesgruppe`
--

CREATE TABLE `yrkesgruppe` (
  `yrkesgruppenr` int(11) NOT NULL,
  `yrkesgruppenavn` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yrkesgruppe`
--

INSERT INTO `yrkesgruppe` (`yrkesgruppenr`, `yrkesgruppenavn`) VALUES
(1, 'Lege'),
(2, 'Psykolog');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `behandler`
--
ALTER TABLE `behandler`
  ADD PRIMARY KEY (`brukernavn`),
  ADD KEY `bildenr` (`bildenr`),
  ADD KEY `yrkesgruppenr` (`yrkesgruppenr`);

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
  ADD KEY `brukernavn` (`brukernavn`);

--
-- Indexes for table `timebestilling`
--
ALTER TABLE `timebestilling`
  ADD PRIMARY KEY (`timebestillingnr`),
  ADD KEY `brukernavn` (`brukernavn`),
  ADD KEY `personnr` (`personnr`);

--
-- Indexes for table `timeinndeling`
--
ALTER TABLE `timeinndeling`
  ADD PRIMARY KEY (`timeinndelingnr`),
  ADD KEY `brukernavn` (`brukernavn`);

--
-- Indexes for table `yrkesgruppe`
--
ALTER TABLE `yrkesgruppe`
  ADD PRIMARY KEY (`yrkesgruppenr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bilde`
--
ALTER TABLE `bilde`
  MODIFY `bildenr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `timebestilling`
--
ALTER TABLE `timebestilling`
  MODIFY `timebestillingnr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `timeinndeling`
--
ALTER TABLE `timeinndeling`
  MODIFY `timeinndelingnr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `yrkesgruppe`
--
ALTER TABLE `yrkesgruppe`
  MODIFY `yrkesgruppenr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `behandler`
--
ALTER TABLE `behandler`
  ADD CONSTRAINT `behandler_ibfk_1` FOREIGN KEY (`yrkesgruppenr`) REFERENCES `yrkesgruppe` (`yrkesgruppenr`),
  ADD CONSTRAINT `behandler_ibfk_2` FOREIGN KEY (`bildenr`) REFERENCES `bilde` (`bildenr`);

--
-- Constraints for table `pasient`
--
ALTER TABLE `pasient`
  ADD CONSTRAINT `pasient_ibfk_1` FOREIGN KEY (`brukernavn`) REFERENCES `behandler` (`brukernavn`);

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
