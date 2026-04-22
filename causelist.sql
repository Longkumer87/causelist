-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2026 at 04:30 AM
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
-- Table structure for table `case_type`
--

CREATE TABLE `case_type` (
  `case_id` int(10) UNSIGNED NOT NULL,
  `type_name` varchar(512) NOT NULL,
  `type_name_short` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `edited_no` int(11) DEFAULT 0,
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

INSERT INTO `causelist_db` (`id`, `edited_no`, `cause_date`, `case_no`, `parties`, `counsel`, `remark`, `next_date`, `court_id`) VALUES
(1, 0, '2026-04-14', 'Test1 /2023', 'test2\r\nvrs Test 5', 'Test3 and test 6', 'Test4 on ', NULL, 1),
(2, 0, '2026-04-14', 'Test1 /2023', 'test2\r\nvrs Test 5', 'Test3 and test 6', 'Test4 on ', NULL, 1),
(3, 0, '2026-04-14', 'Test1 /2023', 'test2\r\nvrs Test 5', 'Test3 and test 6', 'Test4 on ', NULL, 1),
(4, 0, '2026-04-14', 'Test1 /2023', 'test2\r\nvrs Test 5', 'Test3 and test 6', 'Test4 on ', NULL, 1),
(5, 0, '2026-04-14', 'Test1 /2023', 'test2\r\nvrs Test 5', 'Test3 and test 6', 'Test4 on ', NULL, 1),
(6, 0, '2026-04-14', 'Test1 /2023', 'test2\r\nvrs Test 5', 'Test3 and test 6', 'Test4 on ', NULL, 1),
(7, 0, '2026-04-14', 'Test 1/2024', 'Testing One \r\nVrs Testing Two', 'Testing three', 'Testing four', NULL, 2),
(8, 0, '2026-04-14', 'Test 2/2024', 'Testing One \r\nVrs Testing Two\r\nTesting five', 'Testing three\r\nTesting 6', 'Testing Seven', NULL, 2),
(9, 0, '2026-04-14', 'Test 3/2025', 'Testing One \r\nVrs Testing Two\r\nTesting five', '', 'Testing Eight', NULL, 2),
(10, 0, '2026-04-14', 'Test 4/2026', 'Testing One \r\nVrs Testing Two\r\nTesting Ning', '', '', NULL, 2),
(11, 0, '2026-04-14', 'Test5 /2026', 'Testing One \r\nVrs Testing Two', 'Testing three\r\nTesting 6', 'Testing Eight', '2026-04-15', 2),
(12, 0, '2026-04-14', 'Test 6/2024', 'Testing One \r\nVrs Testing Two', 'Testing three\r\nTesting 6', 'Testing Eight', NULL, 2),
(13, 0, '2026-04-14', 'Test7/2023', 'Testing One \r\nVrs Testing Two', 'Testing three\r\nTesting 6', 'Testing Eight', NULL, 2),
(14, 0, '2026-04-14', 'Test8/2022', 'Testing One \r\nVrs Testing Two\r\nTesting five', 'Testing One \r\nVrs Testing Two\r\nTesting five', '', NULL, 2),
(15, 0, '2026-04-14', 'Test 9/2022', 'Testing One \r\nVrs Testing Two', 'Testing One \r\nVrs Testing Two', 'Testing Nano', NULL, 2),
(16, 0, '2026-04-14', 'Test10/2022', 'Testing One \r\nVrs Testing Two', 'Testing One \r\nVrs Testing Two', 'Testing Deca', NULL, 2),
(17, 0, '2026-04-16', 'Test1/2025', 'Testing One \r\nVrs Testing Two', 'Testing Three', 'Testing Four', NULL, 3),
(18, 0, '2026-04-16', 'Test2/2025', 'Testing One \r\nVrs Testing Two', 'Testing Three', 'Testing Four', NULL, 3),
(19, 0, '2026-04-16', 'Test1/2025', 'Test One\r\nVrs Test Two', 'Test Three\r\nTest Four\r\nTest Five\r\nTest Six', 'Test Seven', NULL, 2),
(20, 0, '2026-04-16', 'Test1/2025', 'Testing One\r\nVrs Testing Two', 'Testing Three\r\nTesting Four\r\nTesting 5', 'Testing 6', NULL, 1),
(21, 0, '2026-04-16', 'Test1/2025', 'Testing One\r\nVrs Testing Two', 'Testing Three\r\nTesting Four', 'Testing 6', NULL, 1),
(22, 0, '2026-04-16', 'Test1/2025', 'Testing One\r\nVrs Testing Two', 'Testing Three\r\nTesting Four', '', NULL, 1),
(23, 0, '2026-04-16', 'Test1/2025', 'Testing One\r\nVrs Testing Two', '', 'Testing 6', NULL, 1),
(24, 0, '2026-04-16', 'Test1/2025', 'Testing One\r\nVrs Testing Two', 'Testing Three\r\nTesting Four', 'Testing 6', NULL, 1),
(25, 0, '2026-04-16', 'Test1/2025', 'Testing One\r\nVrs Testing Two', 'Testing Three\r\nTesting Four', 'Testing 6', NULL, 1),
(26, 0, '2026-04-16', 'Test1/2025', 'Testing One\r\nVrs Testing Two', 'Testing Three\r\nTesting Four', 'Testing 6', '2026-04-17', 1),
(27, 0, '2026-04-16', 'Test1/2025', 'Testing One\r\nVrs Testing Two', 'Testing Three\r\nTesting Four', 'Testing 6', NULL, 1),
(28, 0, '2026-04-18', 'Test1', 'Test2', 'Test3', 'Test4', NULL, 1),
(29, 0, '2026-04-17', 'Test1', 'Test2', 'Test3', 'Test4', NULL, 3),
(30, 0, '2026-04-17', 'Test1', 'Test2', 'Test3', 'Test4', NULL, 3),
(31, 0, '2026-04-17', 'Test1', '', 'Test3', '', NULL, 3),
(32, 0, '2026-04-17', 'Test1', 'Test2', 'Test3', 'Test4', NULL, 3),
(33, 0, '2026-04-18', 'Testin 1', 'Terting 2', 'Testing 3', 'Testing 4', NULL, 3),
(34, 0, '2026-04-18', 'Testing 1', 'Testing3', 'Test4', 'Testing 5', NULL, 3),
(35, 0, '2026-04-18', 'Testing 1', 'Testing 3', 'Testing 5', 'Test6', NULL, 3),
(36, 0, '2026-04-18', 'Testing 1', 'Testing5', 'Testing7', 'Testing9', NULL, 3),
(37, 0, '2026-04-18', 'Testing1', 'Testing 2', 'Testing 56', 'Testing10', NULL, 3),
(38, 0, '2026-04-18', 'dfsdfsdfsdf', '', 'gfgfdggfdg', '', NULL, 3),
(39, 0, '2026-04-18', 'Test 1', 'Tewst2', 'Terd3', 'sdfwet', NULL, 3),
(40, 0, '2026-04-18', 'dfdsfwedf', 'eefewf', 'dsfdsaewewtfr', 'assxdff', NULL, 1),
(41, 0, '2026-04-18', 'Test1', 'Test2', 'Test3', 'Test3', NULL, 1),
(42, 0, '2026-04-18', 'dfdsfwedf', 'eefewf', 'dsfdsaewewtfr', 'assxdff', NULL, 1),
(43, 0, '2026-04-18', 'testing', '', '', '', NULL, 1),
(44, 0, '2026-04-18', 'SCA 93/2026 ', 'Smti. Rita Pradhan\r\nVrs Smti. Diksha Nag', 'Adv. Nichu Vupru ', 'Notice', NULL, 2),
(45, 0, '2026-04-18', 'SCA 54/2026', 'Smti. Mentsoe Sale\r\nVrs Smti. Khrietuonuo Sale', 'Adv. Vizotuo', 'Succession\r\nCertificate', NULL, 2),
(46, 0, '2026-04-18', 'SCA 55/2026', 'Smti. Mhasikhono\r\nVrs Shri. Ati Bei-o', 'Adv. Vizotuo', 'Succession\r\nCertificate\r\n', NULL, 2),
(47, 0, '2026-04-18', 'I.A 15/2026 in C/W\r\nSCA 53/2026\r\n', 'Shri. Ruduotso-u Theunuo\r\nVrs Shri Thejangulie\r\nTheunuo', 'Adv. Rovimeno', 'Succession\r\nCertificate\r\n', NULL, 2),
(48, 0, '2026-04-18', 'Spl Case 02/2026', 'State Vrs Rahina', '', 'Production', NULL, 2),
(49, 0, '2026-04-18', 'Spl case 04/2026', 'State Vrs Khibu Tep and\r\nKegwasing ', '', 'Production\r\n', NULL, 2),
(50, 0, '2026-04-18', 'Spl case 05/2026', 'State Vrs Senchulo Tep', '', 'Production', NULL, 2),
(51, 0, '2026-04-18', 'MAC 2/2024', 'Mr. Matong & Ors\r\nVrs Dipankar Gogoi\r\n', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue', NULL, 2),
(52, 0, '2026-04-18', 'MAC 3/2023', 'Tsukjenka Ao\r\nVrs Dipankar', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue\r\n', NULL, 2),
(53, 0, '2026-04-18', 'MAC 1/2024', 'Vizotonuo\r\nVrs Dipankar', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue\r\n', NULL, 2),
(54, 0, '2026-04-18', 'MAC 3/2024', 'Abem\r\nVrs Dipankar', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue', NULL, 2),
(55, 0, '2026-04-18', 'MAC 2/2023 ', 'Moajungla\r\nVrs Dipankar', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue\r\n', NULL, 2),
(56, 0, '2026-04-18', 'Test1', 'Test2', 'Test3', 'Test3', NULL, 1),
(57, 0, '2026-04-19', 'SCA 93/2026', 'Smti. Rita Pradhan\r\nVrs Smti. Diksha Nagi', ' Adv. Nichu Vupru', 'Notice', NULL, 1),
(58, 0, '2026-04-19', 'SCA 54/2026', 'Smti. Mentsoe Sale\r\nVrs Smti. Khrietuonuo Sale', 'Adv. Vizotuo', 'Succession\r\nCertificate', NULL, 1),
(59, 0, '2026-04-19', 'SCA 55/2026', 'Smti. Mhasikhono\r\nVrs Shri. Ati Bei-o', 'Adv. Vizotuo', 'Succession\r\nCertificate', NULL, 1),
(60, 0, '2026-04-19', ' I.A 15/2026 in C/W\r\nSCA 53/2026', 'Shri. Ruduotso-u Theunuo\r\nVrs Shri Thejangulie\r\nTheunuo', 'Adv. Rovimeno', ' Succession\r\nCertificate', NULL, 1),
(61, 0, '2026-04-19', ' Spl Case 02/2026', 'State Vrs Rahina', '', 'Production', NULL, 1),
(62, 0, '2026-04-19', 'Spl case 04/2026', 'State Vrs Khibu Tep and\r\nKegwasing', '', ' Production', NULL, 1),
(63, 0, '2026-04-19', 'Spl case 05/2026', 'State Vrs Senchulo Tep', '', 'Production', NULL, 1),
(64, 0, '2026-04-19', 'MAC 2/2024', ' Mr. Matong & Ors\r\nVrs Dipankar Gogoi', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue', NULL, 1),
(65, 0, '2026-04-19', 'MAC 3/2023', ' Tsukjenka Ao\r\nVrs Dipankar', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue', NULL, 1),
(66, 0, '2026-04-19', 'MAC 1/2024', 'Vizotonuo\r\nVrs Dipankar', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue', NULL, 1),
(67, 0, '2026-04-19', ' MAC 3/2024', 'Abem\r\nVrs Dipankar', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue', NULL, 1),
(68, 0, '2026-04-19', 'MAC 2/2023', ' Moajungla\r\nVrs Dipankar', 'Adv. Z. Kulnu\r\nAdv. Yangerwati\r\nAdv. Sentiyanger', 'Submission of\r\nsuggested issue', NULL, 1),
(69, 0, '2026-04-19', ' MAC 4/2023', 'Tongpankola\r\nVrs Jemti Ao', 'Adv. Alex\r\nAdv. Moatemsu', 'Evidence', NULL, 1),
(70, 0, '2026-04-19', 'MAC 5/2023', ' Tongpangkokla\r\nVrs Jemti Ao', 'Adv. Alex\r\nAdv. Moatemsu', 'Evidence', NULL, 1),
(71, 0, '2026-04-19', 'MAC 6/2023', ' Sapongtangla\r\nVrs Jemti Ao', 'Adv. Alex\r\nAdv. Moatemsu', ' Evidence', NULL, 1),
(72, 0, '2026-04-19', ' Spl case 7/2022', 'State Vrs Daili', ' Adv. Alemwapang', 'Evidence', NULL, 1),
(73, 0, '2026-04-19', 'G.R 34/2022', ' State Vrs Altaf Hussain &\r\nMd. Uddin', ' Adv. Khriekhethonuo', 'Hearing on I.A 31\r\nand 32/2026', NULL, 1),
(74, 0, '2026-04-19', ' G.R 64/2019', 'State Vrs Hasan Ahmed', 'Adv. Nancy', ' F/ Argument', NULL, 1),
(75, 0, '2026-04-19', 'Test1', 'Test1', 'Test1', 'Test1', NULL, 2),
(76, 0, '2026-04-19', 'Test2', 'Test2', 'Test2', 'Test2', NULL, 2),
(77, 2, '2026-04-21', 'test1', 'Test1', 'Test1', 'Test1', NULL, 3),
(78, 3, '2026-04-21', 'Test2', 'Test2', 'Test2', 'Test2', NULL, 3),
(79, 5, '2026-04-21', 'Test1', 'Test2', 'Test3', 'Test4', NULL, 3),
(81, 6, '2026-04-21', 'test1 new', 'Test2 new', 'test1 new', 'Test new', NULL, 3),
(82, 7, '2026-04-21', 'new1', 'new2', 'new3', 'new4', NULL, 3),
(83, 8, '2026-04-21', 'new 5', 'new 5', 'new 7', 'new 8', NULL, 3),
(84, 9, '2026-04-21', 'new 9', 'new 10', 'new11', 'new 12', NULL, 3),
(85, 11, '2026-04-21', 'Test 1 above', '', '', '', NULL, 3),
(86, 12, '2026-04-21', 'Test 1 below', '', '', '', NULL, 3),
(87, 1, '2026-04-21', 'new now above should be 1', 'new now above should be 1', 'new now aboveshould be 1', 'new now above should be 1', NULL, 3),
(88, 4, '2026-04-21', 'new now below should be 4', 'new now above  should be 4', 'new now above  should be 4', 'new now above  should be 4', NULL, 3),
(89, 10, '2026-04-21', '10 test', 'number 10', 'number10', '10 number', NULL, 3),
(90, 13, '2026-04-21', 'test13', '', '', '', NULL, 3),
(91, 14, '2026-04-21', 'test14', '', '', '', NULL, 3),
(92, 15, '2026-04-21', 'test15', '', '', '', NULL, 3),
(93, 16, '2026-04-21', 'test16', '', '', '', NULL, 3),
(94, 17, '2026-04-21', 'test17', '', '', '', NULL, 3),
(95, 18, '2026-04-21', 'test18', '', '', '', NULL, 3),
(96, 19, '2026-04-21', 'test19', '', '', '', NULL, 3),
(97, 20, '2026-04-21', 'test20', '', '', '', NULL, 3),
(98, 21, '2026-04-21', 'test21', '', '', '', NULL, 3),
(99, 22, '2026-04-21', 'test22', '', '', '', NULL, 3),
(100, 23, '2026-04-21', 'test23', '', '', '', NULL, 3),
(101, 24, '2026-04-21', 'test24', '', '', '', NULL, 3),
(102, 25, '2026-04-21', 'test25', '', '', '', NULL, 3),
(103, 26, '2026-04-21', 'test26', '', '', '', NULL, 3),
(104, 27, '2026-04-21', 'test 27', '', '', '', NULL, 3),
(105, 28, '2026-04-21', 'test 28', '', '', '', NULL, 3),
(106, 29, '2026-04-21', 'test 29', '', '', '', NULL, 3),
(107, 30, '2026-04-21', 'test30', '', '', '', NULL, 3),
(108, 31, '2026-04-21', 'test31', '', '', '', NULL, 3),
(109, 32, '2026-04-21', 'test32', '', '', '', NULL, 3),
(110, 33, '2026-04-21', 'test33', '', '', '', NULL, 3),
(111, 34, '2026-04-21', 'test34', '', '', '', NULL, 3),
(112, 36, '2026-04-21', 'test35b', '', '', '', NULL, 3),
(113, 37, '2026-04-21', 'tedst36', '', '', '', NULL, 3),
(114, 35, '2026-04-21', 'test35a', '', '', '', NULL, 3),
(115, 38, '2026-04-21', 'test 38', '', '', '', NULL, 3),
(116, 39, '2026-04-21', 'test 39', '', '', '', NULL, 3),
(117, 40, '2026-04-21', 'test40', '', '', '', NULL, 3);

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
(5, 'ftsck', 'ftsck#123', 'FAST TRACK SPECIAL COURT', '2026-03-31 14:05:11', 5);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

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
