-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 03, 2024 at 11:46 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `broodjesbar_Robin_V2`
--

-- --------------------------------------------------------

--
-- Table structure for table `bestellingen`
--

CREATE TABLE `bestellingen` (
  `bestelId` int(6) NOT NULL,
  `broodjeId` int(6) DEFAULT NULL,
  `klantId` int(6) DEFAULT NULL,
  `tijd` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bestellingen`
--

INSERT INTO `bestellingen` (`bestelId`, `broodjeId`, `klantId`, `tijd`) VALUES
(1, 1, 1, '2024-12-04 09:25:00'),
(2, 8, NULL, '2024-12-06 14:02:00'),
(3, 3, 1, '2024-12-04 14:25:00'),
(4, 5, 2, '2024-12-05 14:27:00'),
(5, 8, 3, '2024-12-05 14:30:00'),
(6, 4, 4, '2024-12-06 14:32:00'),
(7, 11, 5, '2024-12-05 14:58:00'),
(8, 11, 6, '2024-12-05 07:38:00'),
(9, 2, 7, '2024-12-03 07:44:00'),
(10, 1, 8, '2024-12-03 08:22:00'),
(11, 5, 2, '2024-12-06 09:03:00'),
(12, 2, 9, '2024-12-06 09:11:00'),
(13, 3, 2, '2024-12-06 11:40:00'),
(14, 5, 10, '2024-12-03 15:41:00');

-- --------------------------------------------------------

--
-- Table structure for table `broodjes`
--

CREATE TABLE `broodjes` (
  `broodjeId` int(11) NOT NULL,
  `broodje` varchar(50) NOT NULL,
  `omschrijving` varchar(500) NOT NULL,
  `prijs` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `broodjes`
--

INSERT INTO `broodjes` (`broodjeId`, `broodje`, `omschrijving`, `prijs`) VALUES
(1, 'Kaas', 'Broodje met jonge kaas', 1.90),
(2, 'Ham', 'Broodje met natuurham', 1.90),
(3, 'Kaas en ham', 'Broodje met kaas en ham', 2.10),
(4, 'Fitness kip', 'kip natuur, yoghurtdressing, perzik, tuinkers, tomaat en komkommer', 3.50),
(5, 'Broodje Sombrero', 'kip natuur, andalousesaus, rode paprika, maïs, sla, komkommer, tomaat, ei en ui ', 3.70),
(6, 'Broodje americain-tartaar', 'americain, tartaarsaus, ui, komkommer, ei en tuinkers ', 3.50),
(7, 'Broodje Indian kip', 'kip natuur, ananas, tuinkers, komkommer en curry dressing', 4.00),
(8, 'Grieks broodje', 'feta, tuinkers, komkommer, tomaat en olijventapenade', 3.90),
(9, 'Tonijntino', 'tonijn pikant, ui, augurk, martinosaus en (tabasco)', 2.60),
(10, 'Wrap exotisch', 'kip natuur, cocktailsaus, sla, tomaat, komkommer, ei en ananas', 3.70),
(11, 'Wrap kip/spek', 'Kip natuur, spek, BBQ saus, sla, tomaat en komkommer', 4.00);

-- --------------------------------------------------------

--
-- Table structure for table `klanten`
--

CREATE TABLE `klanten` (
  `klantId` int(6) NOT NULL,
  `voornaam` varchar(50) NOT NULL,
  `achternaam` varchar(150) NOT NULL,
  `emailadres` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `klanten`
--

INSERT INTO `klanten` (`klantId`, `voornaam`, `achternaam`, `emailadres`) VALUES
(1, 'Test', 'User', 'test.user@example.com'),
(2, 'Robin', 'Pannemans', 'robin.pannemans@email.com'),
(3, 'Zorba', 'De Griek', 'zorba_de_griek@gmail.com'),
(4, 'Fienemien', 'Huysentruyt', 'fien@fienemail.com'),
(5, 'Wimpie', 'D', 'wd@hotmail.com'),
(6, 'Nico', 'Pannemans', 'nicopan@gmail.com'),
(7, 'Test', 'q', 'twd@hotmail.com'),
(8, 'test', 'vier', 'test_vier@gmail.com'),
(9, 'j', 'q', 'jq@mail.com'),
(10, 'Jier', 'Jaak', 'JierenJaak@jagersborg.be');

-- --------------------------------------------------------

--
-- Table structure for table `statussen`
--

CREATE TABLE `statussen` (
  `bestelId` int(6) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `statussen`
--

INSERT INTO `statussen` (`bestelId`, `status`) VALUES
(1, 'Afgehaald'),
(2, 'Besteld'),
(3, 'Afgehaald'),
(4, 'Gemaakt'),
(5, 'Gemaakt'),
(6, 'Afgehaald'),
(7, 'Afgehaald'),
(8, 'Gemaakt'),
(9, 'Afgehaald'),
(10, 'Besteld'),
(11, 'Afgehaald'),
(12, 'Afgehaald'),
(13, 'Afgehaald'),
(14, 'Besteld');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD PRIMARY KEY (`bestelId`),
  ADD KEY `broodjeId` (`broodjeId`),
  ADD KEY `klantId` (`klantId`);

--
-- Indexes for table `broodjes`
--
ALTER TABLE `broodjes`
  ADD PRIMARY KEY (`broodjeId`);

--
-- Indexes for table `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`klantId`);

--
-- Indexes for table `statussen`
--
ALTER TABLE `statussen`
  ADD PRIMARY KEY (`bestelId`),
  ADD KEY `bestelId` (`bestelId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bestellingen`
--
ALTER TABLE `bestellingen`
  MODIFY `bestelId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `broodjes`
--
ALTER TABLE `broodjes`
  MODIFY `broodjeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `klanten`
--
ALTER TABLE `klanten`
  MODIFY `klantId` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bestellingen`
--
ALTER TABLE `bestellingen`
  ADD CONSTRAINT `bestellingen_ibfk_1` FOREIGN KEY (`broodjeId`) REFERENCES `broodjes` (`broodjeId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `bestellingen_ibfk_2` FOREIGN KEY (`klantId`) REFERENCES `klanten` (`klantId`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `statussen`
--
ALTER TABLE `statussen`
  ADD CONSTRAINT `statussen_ibfk_1` FOREIGN KEY (`bestelId`) REFERENCES `bestellingen` (`bestelId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
