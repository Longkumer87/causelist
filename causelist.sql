-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2026 at 05:35 PM
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
-- Database: `causelist`
--

-- --------------------------------------------------------

--
-- Table structure for table `causelist_db`
--

CREATE TABLE `causelist_db` (
  `id` int(11) NOT NULL,
  `cause_date` date NOT NULL,
  `case_no` varchar(128) NOT NULL,
  `parties` text NOT NULL,
  `counsel` varchar(128) NOT NULL,
  `remark` varchar(128) NOT NULL,
  `next_date` date DEFAULT NULL,
  `court_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `causelist_db`
--

INSERT INTO `causelist_db` (`id`, `cause_date`, `case_no`, `parties`, `counsel`, `remark`, `next_date`, `court_name`) VALUES
(1, '2026-03-25', 'prc 1/2025', 'Maong\r\nvs Awe', 'Nina', 'Hearing', NULL, 'PRINCIPAL DISTRICT & SESSIONS JUDGE'),
(2, '2026-03-25', 'sca 70/2026', 'Kevin \r\nvs Chuba', 'Awele', 'Notice', NULL, 'PRINCIPAL DISTRICT & SESSIONS JUDGE');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `court_name` varchar(50) NOT NULL,
  `published_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `court_name`, `published_on`) VALUES
(1, 'pdsjk', 'pdsjk@123', 'PRINCIPAL DISTRICT & SESSIONS JUDGE', '2026-03-24'),
(2, 'cjmk', 'cjmk@123', 'CHIEF JUDICIAL MAGISTRATE', '2026-03-24'),
(3, 'jmfck', 'jmfck@123', 'JUDICIAL MAGISTRATE FIRST CLASS', '2026-03-24'),
(4, 'fmck', 'fmck@123', 'PRINCIPAL JUDGE FAMILY COURT', '2026-03-24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `causelist_db`
--
ALTER TABLE `causelist_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `causelist_db`
--
ALTER TABLE `causelist_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
