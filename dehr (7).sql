-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2024 at 04:34 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dehr`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appID` int(11) NOT NULL,
  `patientID` int(11) NOT NULL,
  `apponum` int(3) DEFAULT NULL,
  `scheduleid` int(11) NOT NULL,
  `dateTime` date DEFAULT NULL,
  `doctorID` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `medicalPlan` varchar(255) NOT NULL,
  `treatment` varchar(255) NOT NULL,
  `recordDate` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appID`, `patientID`, `apponum`, `scheduleid`, `dateTime`, `doctorID`, `description`, `medicalPlan`, `treatment`, `recordDate`) VALUES
(217, 3, 1, 0, '0000-00-00', 1, 'Patient tolerated the session well with stable vital signs throughout. Mild hypotension corrected with saline bolus. No complications reported.', ' 3 times a week', 'Hemodialysis', NULL),
(260, 1, 243, 42, '2024-06-27', 0, '', '', '', NULL),
(265, 3, 1, 0, '0000-00-00', 1, 'Patient tolerated the session well with stable vital signs throughout. Mild hypotension corrected with saline bolus. No complications reported.', 'haemodialysis', 'duration 4 hours', NULL),
(248, 29, 246, 0, '0000-00-00', 2, 'Patient exhibited stable blood pressure throughout the session. No adverse reactions observed. Scheduled for next session as planned.', 'Medication: Angiotensin II Receptor Blockers, Iron supplements', 'Hemodialysis', NULL),
(225, 3, 1, 0, '0000-00-00', 1, 'Patient tolerated the session well with stable vital signs throughout. Mild hypotension corrected with saline bolus. No complications reported.', 'haemodialysis', '2 timer per week ', NULL),
(263, 30, 262, 0, '0000-00-00', 1, 'patient having difficulties to breath', 'dialysis', '2 times per week', NULL),
(264, 30, 263, 43, '2024-06-27', 0, '', '', '', NULL),
(239, 3, 238, 40, '2024-06-27', 0, '', '', '', NULL),
(245, 31, 246, 0, '0000-00-00', 2, 'Dialysis process went smoothly. Patient reported good overall health and appetite. Effluent appeared normal.\r\n\r\n', 'Diet: Low-phosphorus, fluid restriction', 'Continuous Cycling Peritoneal Dialysis (CCPD)', NULL),
(246, 2, 44, 0, '0000-00-00', 2, 'Patient exhibited stable blood pressure throughout the session. No adverse reactions observed. Scheduled for next session as planned.\r\n\r\n', 'Diet: Low-protein', 'Duration: 4 hours', NULL),
(241, 3, 240, 40, '2024-06-27', 0, '', '', '', NULL),
(243, 1, 243, 0, '0000-00-00', 2, 'Session completed without complications. Patient experienced mild fatigue post-treatment, advised on hydration and rest.', 'Medication: ACE inhibitors, Phosphate binders', 'Dialyzer Used: F2008', NULL),
(253, 29, 246, 0, '0000-00-00', 2, 'Patient exhibited stable blood pressure throughout the session. No adverse reactions observed. Scheduled for next session as planned.', 'Frequency: 3 times a week', 'Type: Hemodialysis', NULL),
(261, 3, 1, 0, '0000-00-00', 1, 'Patient tolerated the session well with stable vital signs throughout. Mild hypotension corrected with saline bolus. No complications reported.', 'haemodialysis', 'duration: 4 hours', NULL),
(259, 2, 246, 42, '2024-06-27', 0, '', '', '', NULL),
(255, 29, 248, 42, '2024-06-27', 0, '', '', '', NULL),
(258, 31, 245, 42, '2024-06-27', 0, '', '', '', NULL),
(262, 3, 261, 43, '2024-06-27', 0, '', '', '', NULL),
(266, 3, 265, 43, '2024-06-27', 0, '', '', '', NULL),
(267, 3, 1, 0, '0000-00-00', 1, 'Patient tolerated the session well with stable vital signs throughout. Mild hypotension corrected with saline bolus. No complications reported.', 'haemodialysis', 'duration 4 hours', NULL),
(268, 3, 267, 45, '2024-06-28', 0, '', '', '', NULL),
(269, 3, 267, 45, '2024-06-28', 0, '', '', '', NULL),
(270, 3, 1, 0, '0000-00-00', 1, 'Patient tolerated the session well with stable vital signs throughout. Mild hypotension corrected with saline bolus. No complications reported.', 'haemodialysis', 'two times per week', NULL),
(271, 3, 270, 46, '2024-07-05', 0, '', '', '', NULL),
(272, 3, 1, 0, '0000-00-00', 1, 'Patient tolerated the session well with stable vital signs throughout. Mild hypotension corrected with saline bolus. No complications reported.', '', '', NULL),
(273, 3, 1, 0, '0000-00-00', 1, 'Patient tolerated the session well with stable vital signs throughout. Mild hypotension corrected with saline bolus. No complications reported.', '', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contactID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `yourmessage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contactID`, `name`, `email`, `phone`, `subject`, `yourmessage`) VALUES
(1, 'ali', 'ali@gmail.com', '01987654032', 'test', 'i want to test test'),
(2, 'ali', 'ali@gmail.com', '01987654032', 'test', 'i want to test test');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctorID` int(11) NOT NULL,
  `demail` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `dpassword` varchar(255) DEFAULT NULL,
  `dnic` varchar(15) DEFAULT NULL,
  `noPhone` varchar(15) DEFAULT NULL,
  `role` int(2) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `tittle` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctorID`, `demail`, `fname`, `dpassword`, `dnic`, `noPhone`, `role`, `lname`, `tittle`) VALUES
(1, 'amira@gmail.com', 'Amira', '123', '990807080987', '012345678', 1, '', ''),
(2, 'dahlia@gmail.com', 'Dahlia', '123', '020930110336', '01156990087', 1, 'Quris Pri', 'Doctor');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patientID` int(11) NOT NULL,
  `pemail` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `ppassword` varchar(255) DEFAULT NULL,
  `paddress` varchar(255) DEFAULT NULL,
  `pnic` varchar(15) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `noPhone` varchar(15) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `age` int(11) NOT NULL,
  `complications` varchar(255) NOT NULL,
  `representative` varchar(50) NOT NULL,
  `relations` varchar(50) NOT NULL,
  `repNoPhone` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`patientID`, `pemail`, `fullname`, `ppassword`, `paddress`, `pnic`, `dob`, `noPhone`, `gender`, `age`, `complications`, `representative`, `relations`, `repNoPhone`) VALUES
(1, 'suraya@gmail.com', 'Suraya', '123', 'Selangor', '0000000000', '2000-01-01', '0120000000', '', 0, '', '', '', ''),
(2, 'aina@gmail.com', 'Aina', '123', 'Selangor', '0110000000', '2022-06-03', '0700000000', '', 0, '', '', '', ''),
(3, 'nurinbatrisyia02@gmail.com', 'Nurin', '123', 'perak', '020930110336', '2016-04-05', '01324567543', 'female', 23, '1', '1', '1', '1'),
(5, 'diana@gmail.com', 'Diana', '123', 'taman Melati', '980709760987', '2024-04-16', '0198765432', '', 0, '', '', '', ''),
(29, 'fatin@gmail.com', 'Fatin', '123', 'kg angkasa', '890706080987', '1989-07-06', '0198765432', '', 0, '', '', '', ''),
(30, 'alia@gmail.com', 'alia', '123', 'kg melati', '080706080987', '2024-04-10', '0198765432', '', 0, '', '', '', ''),
(10, 'amin@gmail.com', 'amin', '123', 'taman amin', '215362548523', '2024-04-16', '0152365489', '', 0, '', '', '', ''),
(31, 'rin@gmail.com', 'Rin', '123', 'taman mawar', '020603115364', '2024-06-11', '0123154625', '', 0, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `scheduleid` int(11) NOT NULL,
  `doctorID` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `scheduledate` date DEFAULT NULL,
  `scheduletime` time DEFAULT NULL,
  `nop` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`scheduleid`, `doctorID`, `title`, `scheduledate`, `scheduletime`, `nop`) VALUES
(46, 1, 'Amira Session 8', '2024-07-05', '09:00:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `sfname` varchar(50) DEFAULT NULL,
  `slname` varchar(50) DEFAULT NULL,
  `semail` varchar(100) DEFAULT NULL,
  `spass` varchar(255) DEFAULT NULL,
  `snoPhone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `sfname`, `slname`, `semail`, `spass`, `snoPhone`) VALUES
(1, 'Fatin', 'Afiqah', 'afiqah@gmail.com', 'nurin', '01123432423'),
(3, 'mmmm', 'mmmm', 'mmmm@gmail.com', '123', '0123698547');

-- --------------------------------------------------------

--
-- Table structure for table `webuser`
--

CREATE TABLE `webuser` (
  `email` varchar(255) NOT NULL,
  `usertype` char(1) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `webuser`
--

INSERT INTO `webuser` (`email`, `usertype`, `password`) VALUES
('admin@gmail.com', 'a', NULL),
('amira@gmail.com', 'd', '123'),
('suraya@gmail.com', 'p', '123'),
('nurinbatrisyia02@gmail.com', 'p', '123'),
('try@gmail.com', 'p', NULL),
('dnj@gmail.com', 'p', NULL),
('helo@gmail.com', 'p', NULL),
('tryagain@gmail.com', 'p', NULL),
('next@gmail.com', 'p', NULL),
('apo@gmail.com', 'p', NULL),
('first@gmail.com', 'p', NULL),
('second@gmail.com', 'p', NULL),
('third@gmail.com', 'p', NULL),
('fourth@gmail.com', 'p', NULL),
('fatin@gmail.com', 'p', NULL),
('alia@gmail.com', 'p', NULL),
('dahlia@gmail.com', 'd', '123'),
('afiqah@gmail.com', 's', 'nurin'),
('rin@gmail.com', 'p', NULL),
('quris@gmail.com', 'd', NULL),
('pri@gmail.com', 'd', NULL),
('patie@gmail.com', 'p', NULL),
('gg@gmail.com', 'p', NULL),
('tttt@gmail.com', 'p', NULL),
('nn@gmail.com', 'd', NULL),
('mmmm@gmail.com', 's', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`appID`),
  ADD UNIQUE KEY `appID` (`appID`),
  ADD KEY `fk_patientID` (`patientID`),
  ADD KEY `fk_doctorID` (`doctorID`),
  ADD KEY `fk_scheduleid` (`scheduleid`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contactID`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctorID`),
  ADD KEY `specialties` (`role`),
  ADD KEY `doctorID` (`doctorID`),
  ADD KEY `doctorID_2` (`doctorID`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patientID`),
  ADD KEY `patientID` (`patientID`),
  ADD KEY `patientID_2` (`patientID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`scheduleid`),
  ADD KEY `docid` (`doctorID`),
  ADD KEY `doctorID` (`doctorID`),
  ADD KEY `doctorID_2` (`doctorID`),
  ADD KEY `doctorID_3` (`doctorID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD KEY `staffID` (`staffID`);

--
-- Indexes for table `webuser`
--
ALTER TABLE `webuser`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `appID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=274;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `scheduleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
