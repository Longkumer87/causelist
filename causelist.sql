-- phpMyAdmin SQL Dump
-- version 5.2.2deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 01, 2026 at 08:06 AM
-- Server version: 11.8.3-MariaDB-1build1 from Ubuntu
-- PHP Version: 8.4.11

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
-- Table structure for table `case_type`
--

CREATE TABLE `case_type` (
  `case_id` int(10) UNSIGNED NOT NULL,
  `type_name` varchar(512) NOT NULL,
  `type_name_short` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `case_type`
--

INSERT INTO `case_type` (`case_id`, `type_name`, `type_name_short`) VALUES
(1, 'PRC', ''),
(2, 'C B I case', ''),
(3, 'Sessions ( Spl.)', ''),
(4, 'Recovery Suit', ''),
(5, 'Special childrens court(J.J Act.)', ''),
(6, 'NIA cases', ''),
(7, 'Workmen compensation Act.', ''),
(8, 'Misappropriation', ''),
(9, 'Excise Act', ''),
(10, 'Guardianship Case', ''),
(11, 'Cases Under Section 125 Cr P C', ''),
(12, 'Muslim Women Protection Divorce', ''),
(13, 'Special Wild Life Protec. Act', ''),
(14, 'N G C/ R P F/ Post', ''),
(15, 'Immoral traffic(P) Act.', ''),
(16, 'L A Reference Case', ''),
(17, 'Other criminal cases', ''),
(18, 'Misc.(Crl)', ''),
(19, 'Title Suit ( Arbitration )', ''),
(20, 'Defamation suit', ''),
(21, 'Misc. civil appeal', ''),
(22, 'Revocation Case', ''),
(23, 'Misc. Appeal', ''),
(24, 'Civil Appeal', ''),
(25, 'Misc. Arbitration', ''),
(26, 'Succesion Case', ''),
(27, 'Weights & Measurement Act', ''),
(28, 'Money Execution', ''),
(29, 'Title Suit (d)', ''),
(30, 'Title Suit', ''),
(31, 'Other civil cases', ''),
(32, 'Complaint Case', ''),
(33, 'Injunction Applications', ''),
(34, 'POCSO cases', ''),
(35, 'M A C T ( Death Case', ''),
(36, 'Section 41 Of Juvenile Justice', ''),
(37, 'Assam Forest Regulation', ''),
(38, 'Special Case(Essential Commodity Act)', ''),
(39, 'Probate Title Suit', ''),
(40, 'Execution Case', ''),
(41, 'Bail 438', ''),
(42, 'Bribery', ''),
(43, 'Appointment Of Guardian', ''),
(44, 'Crl. Misc Appeal', ''),
(45, 'Money Appeal', ''),
(46, 'Memo No.', ''),
(47, 'Succession Certificate', ''),
(48, 'Assam Shop & Establishment', ''),
(49, 'Labour Cases', ''),
(50, 'Suit U/S 92 of C P C', ''),
(51, 'Food Adulteration', ''),
(52, 'Money Suit', ''),
(53, 'Copyright Act', ''),
(54, 'G R Case', ''),
(55, 'Wakf Matter', ''),
(56, 'I.A(C)', ''),
(57, 'R F A', ''),
(58, 'M A C T ( Injury Case )', ''),
(59, 'Case Under Section 138 N.i. Act', ''),
(60, 'Misc. ( Motor Accident Case )', ''),
(61, 'Title Execution', ''),
(62, 'Misc. Succession', ''),
(63, 'Title Appeal', ''),
(64, 'Probate Case', ''),
(65, 'Others', ''),
(66, 'Employees P F Act', ''),
(67, 'M A C T ( Property Damage Case )', ''),
(68, 'Prevention of Corruption Act', ''),
(69, 'Summary Suit', ''),
(70, 'Drugs & Cosmetic Act', ''),
(71, 'Industrial Cases', ''),
(72, 'Election Petition', ''),
(73, 'Matrimonial Suit', ''),
(74, 'Immoral Traffic ( P ) Act', ''),
(75, 'Misc. Case ( Domestic Violence)', ''),
(76, 'Criminal Miscellaneous', ''),
(77, 'Misc. (j) Case', ''),
(78, 'Misc. Adoption Case', ''),
(79, 'Special Case ( Prevention of Corruption Act))', ''),
(80, 'Arbitration Matter', ''),
(81, 'M L P Case', ''),
(82, 'N I Act', ''),
(83, 'Claims U / S 166 M V Act', ''),
(84, 'Misc. case(Domastic violance)', ''),
(85, 'G C Certificate Case', ''),
(86, 'MV Act.(MAC cases)', ''),
(87, 'Declaratory Suit', ''),
(88, 'Public Gambling Act', ''),
(89, 'Arbitration case', ''),
(90, 'Bail 437CRPC', ''),
(91, 'I.A.(Crl.)', ''),
(92, 'Dowry Prohibition Act', ''),
(93, 'Other consumer case', ''),
(94, 'Civil review', ''),
(95, 'Title Suit (r)', ''),
(96, 'Guardians & Wards Acts', ''),
(97, 'Letter Of Administration', ''),
(98, 'Disproportionate Assets', ''),
(99, 'Police Act', ''),
(100, 'Essential Commodities Act', ''),
(101, 'Special Case ( Electricity)', ''),
(102, 'Money Suit Summary', ''),
(103, 'Bail 439', ''),
(104, 'L. A. Misc.', ''),
(105, 'Criminal Revision', ''),
(106, 'Motor Vehicle Act', ''),
(107, 'Criminal Appeal', ''),
(108, 'Complaint Case ( C R)', ''),
(109, 'Misc.(C)', ''),
(110, 'Sessions Case', ''),
(111, 'N D P S Act', ''),
(112, 'Special N I A Case', ''),
(113, 'civil suit', '');

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
  `court_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `causelist_db`
--

INSERT INTO `causelist_db` (`id`, `cause_date`, `case_no`, `parties`, `counsel`, `remark`, `next_date`, `court_id`) VALUES
(1, '2026-04-01', 'prc 1/2025', 'Maong\r\nvs Awe', 'Nina', 'Notice', NULL, 1),
(2, '2026-04-01', 'prc 1/2020', 'Molo\r\nvs Huide', 'Awele', 'Hearing', NULL, 1),
(3, '2026-04-01', 'Cases Under Section 125 Cr P C', 'One\r\nvs Two', 'Three', 'Hearing', NULL, 2);

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
  `court_id` int(10) UNSIGNED DEFAULT NULL
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
-- Indexes for table `case_type`
--
ALTER TABLE `case_type`
  ADD PRIMARY KEY (`case_id`);

--
-- Indexes for table `causelist_db`
--
ALTER TABLE `causelist_db`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cause_court` (`court_id`);

--
-- Indexes for table `court`
--
ALTER TABLE `court`
  ADD PRIMARY KEY (`court_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_court` (`court_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `case_type`
--
ALTER TABLE `case_type`
  MODIFY `case_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `causelist_db`
--
ALTER TABLE `causelist_db`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `causelist_db`
--
ALTER TABLE `causelist_db`
  ADD CONSTRAINT `fk_cause_court` FOREIGN KEY (`court_id`) REFERENCES `court` (`court_id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_court` FOREIGN KEY (`court_id`) REFERENCES `court` (`court_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
