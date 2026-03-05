-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2026 at 08:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eastern_oregon_pets_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `species` varchar(50) DEFAULT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `sex` varchar(6) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `intake_date` date NOT NULL,
  `location` varchar(50) DEFAULT NULL,
  `fur_color` varchar(25) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `health_status` varchar(75) DEFAULT NULL,
  `spayed_neutered` varchar(3) DEFAULT NULL,
  `vaccine_status` varchar(15) DEFAULT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `species`, `breed`, `sex`, `age`, `status`, `intake_date`, `location`, `fur_color`, `size`, `health_status`, `spayed_neutered`, `vaccine_status`, `image`) VALUES
(1, 'Merge Test', 'cat', 'Dobberman', 'male', 3, 'available', '2026-03-04', 'Elgin', 'black', 'small', 'healthy', 'yes', 'up_to_date', '1772689806_Screenshot 2026-01-22 133113.png'),
(2, 'Jennifer', 'cat', 'Dobberman', 'male', 2, 'adopted', '2026-03-04', 'Elgin', NULL, NULL, 'healthy', 'yes', 'up_to_date', '1772691312_Screenshot 2025-12-12 071526.png'),
(3, 'Jennifer', 'cat', 'Dobberman', 'female', 3, 'available', '2026-03-04', 'Elgin', 'black', NULL, 'healthy', 'no', 'up_to_date', '1772691764_Screenshot 2026-01-17 145515.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
