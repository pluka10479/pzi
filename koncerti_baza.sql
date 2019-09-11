-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2019 at 02:28 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koncerti_baza`
--

-- --------------------------------------------------------

--
-- Table structure for table `glazba`
--

CREATE TABLE `glazba` (
  `id_glazba` int(20) NOT NULL,
  `naziv_glazbe` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `glazba`
--

INSERT INTO `glazba` (`id_glazba`, `naziv_glazbe`) VALUES
(1, 'Pop'),
(2, 'Rock'),
(3, 'Klasika'),
(5, 'Festivali'),
(6, 'Hip-Hop');

-- --------------------------------------------------------

--
-- Table structure for table `gradovi`
--

CREATE TABLE `gradovi` (
  `id_grada` int(20) NOT NULL,
  `ime_grada` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gradovi`
--

INSERT INTO `gradovi` (`id_grada`, `ime_grada`) VALUES
(1, 'Mostar'),
(2, 'Zagreb'),
(3, 'Sarajevo'),
(5, 'Pula'),
(6, 'Osijek');

-- --------------------------------------------------------

--
-- Table structure for table `izvodjac`
--

CREATE TABLE `izvodjac` (
  `id_izvodjaca` int(20) NOT NULL,
  `id_glazba` int(20) DEFAULT NULL,
  `ime_izvodjaca` varchar(45) NOT NULL,
  `opis` varchar(100) DEFAULT NULL,
  `fotografija` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `izvodjac`
--

INSERT INTO `izvodjac` (`id_izvodjaca`, `id_glazba`, `ime_izvodjaca`, `opis`, `fotografija`) VALUES
(1, 3, '2 CELLOS', '', NULL),
(2, 2, 'Bijelo Dugme', NULL, NULL),
(3, 6, 'Dubioza Kolektiv', NULL, NULL),
(4, 6, 'Elemental', NULL, NULL),
(6, 2, 'Hladno pivo', NULL, NULL),
(12, 1, 'S.A.R.S.', NULL, NULL),
(13, 5, 'Mostar Summer Fest', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `koncerti`
--

CREATE TABLE `koncerti` (
  `id_koncerta` int(20) NOT NULL,
  `id_grada` int(20) DEFAULT NULL,
  `id_izvodjaca` int(20) DEFAULT NULL,
  `naziv_koncerta` varchar(45) NOT NULL,
  `datum_koncerta` date NOT NULL,
  `dvorana_stadion` varchar(45) DEFAULT NULL,
  `opis` varchar(100) DEFAULT NULL,
  `fotografija` varchar(45) DEFAULT NULL,
  `cijena` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `koncerti`
--

INSERT INTO `koncerti` (`id_koncerta`, `id_grada`, `id_izvodjaca`, `naziv_koncerta`, `datum_koncerta`, `dvorana_stadion`, `opis`, `fotografija`, `cijena`) VALUES
(2, 6, 3, 'Dubioza Kolektiv', '2019-06-14', 'DvoriÅ¡te Vege', '', 'dubiozakolektiv.jpg', 'Karta: 10KM'),
(9, 3, 6, 'Hladno pivo', '2019-04-26', '', '', 'hladnopivo.jpg', 'Karta: 15KM'),
(12, 6, 4, 'Elemental', '2018-12-21', 'DVORISTE DR ROJAC', '', 'elemental.jpg', 'Karta: 20KM'),
(15, 5, 1, 'Ponovo', '2019-09-15', 'Arena', '', '2Cellos_Pula.jpg', ''),
(16, 3, 2, '', '2019-09-15', 'Dvorana', '', 'bijelodugme.jpg', '15'),
(17, 2, 12, 'Novi', '2019-07-21', 'Zenit', '', 'sars.jpg', 'Karta: 15KM'),
(26, 1, 13, 'Mostar Summer Fest', '2019-06-21', 'Rodoc', '', 'mo.jpg', 'Karta: 10KM');

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE `korisnici` (
  `id_korisnici` int(20) NOT NULL,
  `korisnicko_ime` varchar(20) NOT NULL,
  `lozinka` varchar(20) NOT NULL,
  `ime` varchar(20) DEFAULT NULL,
  `prezime` varchar(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `spol` varchar(10) DEFAULT NULL,
  `razina` enum('admin','korisnik') NOT NULL DEFAULT 'korisnik'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id_korisnici`, `korisnicko_ime`, `lozinka`, `ime`, `prezime`, `email`, `spol`, `razina`) VALUES
(1, 'luka', 'luka', 'Administrator', 'Administrator', 'luka@gmail.com', 'muski', 'admin'),
(2, 'tina', 'tina', 'tina', 't', 'tina@gmail.com', 'Zenski', 'admin'),
(4, 'test', 'test', 't2', 't1', 'test@gmail.com', 'muski', 'korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE `rezervacija` (
  `id_rezervacije` int(20) NOT NULL,
  `id_korisnici` int(20) DEFAULT NULL,
  `id_koncerta` int(20) DEFAULT NULL,
  `tip` enum('VIP','Tribina','Parter','') NOT NULL,
  `datum_rezervacije` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rezervacija`
--

INSERT INTO `rezervacija` (`id_rezervacije`, `id_korisnici`, `id_koncerta`, `tip`, `datum_rezervacije`) VALUES
(5, 4, 17, 'Tribina', '2019-09-11 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `glazba`
--
ALTER TABLE `glazba`
  ADD PRIMARY KEY (`id_glazba`);

--
-- Indexes for table `gradovi`
--
ALTER TABLE `gradovi`
  ADD PRIMARY KEY (`id_grada`);

--
-- Indexes for table `izvodjac`
--
ALTER TABLE `izvodjac`
  ADD PRIMARY KEY (`id_izvodjaca`),
  ADD KEY `fk_glazba` (`id_glazba`);

--
-- Indexes for table `koncerti`
--
ALTER TABLE `koncerti`
  ADD PRIMARY KEY (`id_koncerta`),
  ADD KEY `fk_gradovi` (`id_grada`),
  ADD KEY `fk_izvodjac` (`id_izvodjaca`);

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id_korisnici`);

--
-- Indexes for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD PRIMARY KEY (`id_rezervacije`),
  ADD KEY `fk_korisnici` (`id_korisnici`),
  ADD KEY `fk_koncerti` (`id_koncerta`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `glazba`
--
ALTER TABLE `glazba`
  MODIFY `id_glazba` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gradovi`
--
ALTER TABLE `gradovi`
  MODIFY `id_grada` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `izvodjac`
--
ALTER TABLE `izvodjac`
  MODIFY `id_izvodjaca` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `koncerti`
--
ALTER TABLE `koncerti`
  MODIFY `id_koncerta` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id_korisnici` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rezervacija`
--
ALTER TABLE `rezervacija`
  MODIFY `id_rezervacije` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `izvodjac`
--
ALTER TABLE `izvodjac`
  ADD CONSTRAINT `fk_glazba` FOREIGN KEY (`id_glazba`) REFERENCES `glazba` (`id_glazba`);

--
-- Constraints for table `koncerti`
--
ALTER TABLE `koncerti`
  ADD CONSTRAINT `fk_gradovi` FOREIGN KEY (`id_grada`) REFERENCES `gradovi` (`id_grada`),
  ADD CONSTRAINT `fk_izvodjac` FOREIGN KEY (`id_izvodjaca`) REFERENCES `izvodjac` (`id_izvodjaca`);

--
-- Constraints for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD CONSTRAINT `fk_koncerti` FOREIGN KEY (`id_koncerta`) REFERENCES `koncerti` (`id_koncerta`),
  ADD CONSTRAINT `fk_korisnici` FOREIGN KEY (`id_korisnici`) REFERENCES `korisnici` (`id_korisnici`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
