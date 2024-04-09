-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+jammy2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 07, 2024 at 10:17 AM
-- Server version: 8.0.36-0ubuntu0.22.04.1
-- PHP Version: 8.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `subjects`
--

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` bigint NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `day` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `room` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `subject_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `name`, `day`, `room`, `subject_type`) VALUES
(58, 'Developement of software applications', 'Mon\n', 'de300 (BA-FEI-FEI D-E)', 1),
(59, 'Web technologies 2', 'Tue\n', 'cd300 (BA-FEI-FEI C-D)', 1),
(60, 'Algebraic structures', 'Tue\n', 'bc300 (BA-FEI-FEI B-C)', 1),
(61, 'Web technologies 2', 'Wed\n', 'cd300 (BA-FEI-FEI C-D)', 1),
(62, 'Web technologies 2', 'Thu\n', 'c117a (BA-FEI-FEI C)', 2),
(63, 'Algebraic structures', 'Thu\n', 'c517 (BA-FEI-FEI C)', 2),
(64, 'Developement of software applications', 'Fri\n', 'cpu-i (BA-FEI-FEI D)', 2);

-- --------------------------------------------------------

--
-- Table structure for table `subject_type`
--

CREATE TABLE `subject_type` (
  `type_id` int NOT NULL,
  `type_name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_type`
--

INSERT INTO `subject_type` (`type_id`, `type_name`) VALUES
(1, 'prednaška'),
(2, 'cvičenie');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `SUBJECT_TYPE_FK` (`subject_type`);

--
-- Indexes for table `subject_type`
--
ALTER TABLE `subject_type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `subject_type`
--
ALTER TABLE `subject_type`
  MODIFY `type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `SUBJECT_TYPE_FK` FOREIGN KEY (`subject_type`) REFERENCES `subject_type` (`type_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

