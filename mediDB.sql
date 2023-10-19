-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 19, 2023 at 08:47 PM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mediDB`
--

-- --------------------------------------------------------

--
-- Table structure for table `mediTable`
--

CREATE TABLE `mediTable` (
  `id` int(10) NOT NULL,
  `medicines` varchar(100) NOT NULL,
  `side_effects` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mediTable`
--

INSERT INTO `mediTable` (`id`, `medicines`, `side_effects`) VALUES
(11, 'Aspirin', 'Upset stomach, heartburn, gastrointestinal irritation, bleeding'),
(12, 'Ibuprofen', 'Upset stomach, heartburn, nausea, stomach pain, headache'),
(13, 'Acetaminophen', 'Rare when taken as directed; high doses can lead to liver damage'),
(14, 'Lisinopril', 'Dizziness, cough, low blood pressure'),
(15, 'Atorvastatin', 'Muscle pain or weakness, headache, digestive issues'),
(16, 'Amoxicillin', 'Diarrhea, nausea, vomiting, rash, yeast infection (in some cases)'),
(17, 'Omeprazole', 'Headache, nausea, diarrhea, abdominal pain'),
(18, 'Sertraline', 'Nausea, diarrhea, insomnia, sexual side effects, dizziness');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, 'jude.stepheninnovations@gmail.com', 'd75fca0e12b6c671e7f6d4df0cf59e4e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mediTable`
--
ALTER TABLE `mediTable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mediTable`
--
ALTER TABLE `mediTable`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
