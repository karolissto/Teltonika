-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 30, 2019 at 12:56 AM
-- Server version: 5.7.28-0ubuntu0.18.04.4
-- PHP Version: 7.2.24-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teltonika`
--

-- --------------------------------------------------------

--
-- Table structure for table `Miestas`
--

CREATE TABLE `Miestas` (
  `id` int(10) NOT NULL,
  `pavadinimas` varchar(225) NOT NULL,
  `plotas` int(10) NOT NULL,
  `gyventojai` int(10) NOT NULL,
  `pasto_kodas` int(10) NOT NULL,
  `sukurtas` date NOT NULL,
  `salis_fk` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Miestas`
--

INSERT INTO `Miestas` (`id`, `pavadinimas`, `plotas`, `gyventojai`, `pasto_kodas`, `sukurtas`, `salis_fk`) VALUES
(3, 'Vilnius', 421, 800000, 15112, '2019-12-05', 1),
(4, 'Kaunas', 421, 800000, 15112, '2019-12-25', 1),
(5, 'Palanga', 421, 800000, 15112, '2019-12-05', 1),
(6, 'Tokijas', 421, 800000, 15112, '2019-12-05', 14),
(7, 'Osaka', 421, 800000, 15112, '2019-12-05', 14),
(8, 'Torontas', 421, 800000, 15112, '2019-12-05', 13),
(9, 'Niujorkas', 421, 800000, 15112, '2019-12-05', 7),
(10, 'Majamis', 421, 800000, 15112, '2019-12-05', 7),
(11, 'Lasvegasas', 421, 800000, 15112, '2019-12-05', 7),
(12, 'Minesota', 421, 800000, 15112, '2019-12-05', 7),
(13, 'Barselona', 421, 800000, 15112, '2019-12-05', 15),
(14, 'Berlinas', 421, 800000, 15112, '2019-12-05', 5),
(15, 'Krokuva', 421, 800000, 15112, '2019-12-05', 4);

-- --------------------------------------------------------

--
-- Table structure for table `Salis`
--

CREATE TABLE `Salis` (
  `id` int(10) NOT NULL,
  `pavadinimas` varchar(225) NOT NULL,
  `plotas` int(10) NOT NULL,
  `gyventojai` int(10) NOT NULL,
  `tel_kodas` int(10) NOT NULL,
  `sukurtas` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Salis`
--

INSERT INTO `Salis` (`id`, `pavadinimas`, `plotas`, `gyventojai`, `tel_kodas`, `sukurtas`) VALUES
(1, 'Lietuva', 54612, 2700000, 370, '2019-12-10'),
(2, 'Latvija', 35001, 1500000, 371, '2019-12-23'),
(3, 'Estija', 15232, 2000000, 372, '2019-12-27'),
(4, 'Lenkija', 454612, 27000000, 452, '2019-12-01'),
(5, 'Vokietija', 54612, 2700000, 355, '2019-10-10'),
(6, 'Danija', 5423322, 85200000, 453, '2019-12-10'),
(7, 'JAV', 54612, 27842310, 752, '2019-12-17'),
(8, 'Kinija', 54612, 457625000, 154, '2019-11-21'),
(9, 'Suomija', 54612, 4236000, 865, '2019-12-04'),
(10, 'Norvegija', 54612, 275253540, 432, '2019-12-28'),
(11, 'Islandija', 54612, 272520, 458, '2019-12-14'),
(12, 'Australija', 54612, 27076000, 954, '2019-10-13'),
(13, 'Kanada', 54612, 282767000, 995, '2019-09-09'),
(14, 'Japonija', 54612, 3543000, 775, '2019-11-10'),
(15, 'Ispanija', 54612, 34486000, 735, '2019-12-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Miestas`
--
ALTER TABLE `Miestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salis_fk` (`salis_fk`);

--
-- Indexes for table `Salis`
--
ALTER TABLE `Salis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Miestas`
--
ALTER TABLE `Miestas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `Salis`
--
ALTER TABLE `Salis`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Miestas`
--
ALTER TABLE `Miestas`
  ADD CONSTRAINT `Miestas_ibfk_1` FOREIGN KEY (`salis_fk`) REFERENCES `Salis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
