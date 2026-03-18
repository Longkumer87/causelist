-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2026 at 03:29 AM
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
-- Database: `causelist_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `causelist`
--

CREATE TABLE `causelist` (
  `id` int(11) NOT NULL,
  `cause_date` date NOT NULL,
  `case_no` varchar(128) NOT NULL,
  `parties` text NOT NULL,
  `counsel` varchar(128) NOT NULL,
  `remark` varchar(128) NOT NULL,
  `next_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `causelist`
--

INSERT INTO `causelist` (`id`, `cause_date`, `case_no`, `parties`, `counsel`, `remark`, `next_date`) VALUES
(1, '2026-03-17', 'prc 1/2024', 'ddfsdff', 'ewrerer', 'sdfvsdfdfdsf', '0000-00-00'),
(2, '2026-03-17', 'prc 2/2024', 'tt444', 'uiui567ytry', 'fgfgertertgert', '0000-00-00'),
(3, '0000-00-00', 'sca', 'likkah', 'bneur', '4ijthlk', '0000-00-00'),
(4, '2026-03-18', 'sca 7/2025', 'gfgrreop', 'tytytyhg', 'htrhyttrt', '0000-00-00'),
(5, '2026-03-18', 'sca 20/2026', 'rtretrtyuyuy', 'nght', '5ytytryty', '0000-00-00'),
(6, '0000-00-00', '', '', '', '', '0000-00-00'),
(7, '2026-03-19', '', '', '', '', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `causelist`
--
ALTER TABLE `causelist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `causelist`
--
ALTER TABLE `causelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
