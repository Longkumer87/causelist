-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 04:59 PM
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
  `court_name` varchar(50) NOT NULL,
  `court_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `causelist_db`
--

INSERT INTO `causelist_db` (`id`, `cause_date`, `case_no`, `parties`, `counsel`, `remark`, `next_date`, `court_name`, `court_id`) VALUES
(1, '2026-04-01', 'prc 1/2025', 'Maong\r\nvs Awe', 'Nina', 'Notice', NULL, '', 1),
(2, '2026-04-01', 'prc 1/2020', 'Molo\r\nvs Huide', 'Awele', 'Hearing', NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `court`
--

CREATE TABLE `court` (
  `court_id` int(10) UNSIGNED NOT NULL,
  `court_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `court`
--

INSERT INTO `court` (`court_id`, `court_name`) VALUES
(1, 'PRINCIPAL DISTRICT & SESSIONS JUDGE'),
(2, 'CHIEF JUDICIAL MAGISTRATE'),
(3, 'JUDICIAL MAGISTRATE FIRST CLASS'),
(4, 'FAMILY COURT'),
(5, 'FAST TRACK SPECIAL COURT  ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `court_name` varchar(50) NOT NULL,
  `published_on` datetime NOT NULL DEFAULT current_timestamp(),
  `court_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `court_name`, `published_on`, `court_id`) VALUES
(1, 'pdsjk', 'pdsjk#123', 'PRINCIPAL DISTRICT & SESSIONS JUDGE', '2026-03-31 14:01:21', 1),
(2, 'cjmk', 'cjmk#123', 'CHIEF JUDICIAL MAGISTRATE', '2026-03-31 14:02:50', 2),
(3, 'jmfck', 'jmfck#123', 'JUDICIAL MAGISTRATE FIRST CLASS', '2026-03-31 14:04:09', 3),
(4, 'fmck', 'fmck#123', 'FAMILY COURT', '2026-03-31 14:04:09', 4),
(5, 'ftsck', 'ftsck', 'FAST TRACK SPECIAL COURT', '2026-03-31 14:05:11', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `causelist_db`
--
ALTER TABLE `causelist_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`court_id`);

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
-- AUTO_INCREMENT for table `court`
--
ALTER TABLE `court`
  MODIFY `court_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
