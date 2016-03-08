-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 07, 2016 at 10:13 PM
-- Server version: 5.5.42
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `frontRowLMS`
--

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `moduleID` varchar(8) NOT NULL,
  `moduleName` text NOT NULL,
  `moduleDescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`moduleID`, `moduleName`, `moduleDescription`) VALUES
('CI4100', 'Programming 1', 'Programming Module for Level 1 Students'),
('CI4200', 'IT Toolbox', 'IT Toolbox Module for Level 1 Computing Students'),
('CI4300', 'Business Analysis and Solution Design', 'Business Analysis and Solution Design is a module for Level 4 Computing Students'),
('CI4400', 'System Environments', 'System Environments is a Level 4 module for Computing students'),
('CI5100', 'Programming 2', 'Programming 2 is a Level 5 Module for Computing Students'),
('CI5220', 'Networking and Operating Systems', 'Networking and Operating Systems is a Level 5 Module for Computing Students'),
('CI5310', 'Database and UML Modelling', 'Database and UML Modelling is a Level 5 Module for Computing Students'),
('CI5410', 'Projects and their Management', 'Projects and their Management is a Level 5 Module for Computing Students');

-- --------------------------------------------------------

--
-- Table structure for table `modulePage`
--

CREATE TABLE `modulePage` (
  `pageID` int(7) NOT NULL,
  `moduleID` varchar(8) NOT NULL,
  `pageName` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modulePage`
--

INSERT INTO `modulePage` (`pageID`, `moduleID`, `pageName`) VALUES
(1, 'CI4200', 'Announcements'),
(2, 'CI4200', 'Module Info'),
(3, 'CI4200', 'Lecture Slides'),
(4, 'CI5100', 'Announcements'),
(5, 'CI5100', 'Module Infomation'),
(6, 'CI5100', 'Lectures'),
(7, 'CI5100', 'Workshops'),
(8, 'CI5220', 'Announcements'),
(9, 'CI5220', 'Module Guide and Info'),
(10, 'CI5220', 'TB1 Lectures'),
(11, 'CI5220', 'TB2 Lectures'),
(12, 'CI5220', 'Coursework'),
(13, 'CI5310', 'Announcements'),
(14, 'CI5310', 'Module Information'),
(15, 'CI5310', 'TB1 Lectures'),
(16, 'CI5310', 'TB1 Workshops'),
(17, 'CI5310', 'TB2 Lectures'),
(18, 'CI5310', 'TB2 Workshops'),
(19, 'CI5410', 'Announcements'),
(20, 'CI5410', 'Module Info'),
(21, 'CI5410', 'Lectures'),
(22, 'CI5410', 'Coursework');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `kNumber` varchar(10) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `fName` text NOT NULL,
  `lName` text NOT NULL,
  `kMail` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`kNumber`, `pwd`, `fName`, `lName`, `kMail`) VALUES
('k1234567', '$2y$10$7r5h.hBc8it9SSRQZYtWneBOBZKs.nHUx8UwO0g722IGhjtRMHpbu', 'Joe', 'Bloggs', 'k1234567@kingston.ac.uk'),
('k1419876', '$2y$10$MG1Vj2zum9hy285dKIC5GuGJKS6dIxOPWBeJuAaVMVYHze.CslF52', 'First Year', 'Student', 'k1419876@kingston.ac.uk'),
('k1460846', '$2y$10$5c2CKF27QMHEqyPNNpMmCOQnG2fLE5ItT93zW217NQEOvQoGHwJBK', 'Josh', 'String', 'k1460846@kingston.ac.uk');

-- --------------------------------------------------------

--
-- Table structure for table `userModule`
--

CREATE TABLE `userModule` (
  `kNumber` varchar(10) NOT NULL,
  `moduleID` varchar(8) NOT NULL,
  `permission` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userModule`
--

INSERT INTO `userModule` (`kNumber`, `moduleID`, `permission`) VALUES
('k1419876', 'CI4100', 0),
('k1419876', 'CI4200', 0),
('k1419876', 'CI4300', 0),
('k1419876', 'CI4400', 0),
('k1460846', 'CI4200', 1),
('k1460846', 'CI5100', 0),
('k1460846', 'CI5220', 0),
('k1460846', 'CI5310', 0),
('k1460846', 'CI5410', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`moduleID`);

--
-- Indexes for table `modulePage`
--
ALTER TABLE `modulePage`
  ADD PRIMARY KEY (`pageID`),
  ADD KEY `moduleID` (`moduleID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`kNumber`),
  ADD UNIQUE KEY `kMail` (`kMail`);

--
-- Indexes for table `userModule`
--
ALTER TABLE `userModule`
  ADD PRIMARY KEY (`kNumber`,`moduleID`),
  ADD KEY `kNumber` (`kNumber`),
  ADD KEY `moduleID` (`moduleID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `modulePage`
--
ALTER TABLE `modulePage`
  MODIFY `pageID` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `modulePage`
--
ALTER TABLE `modulePage`
  ADD CONSTRAINT `modulepage_ibfk_1` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`);

--
-- Constraints for table `userModule`
--
ALTER TABLE `userModule`
  ADD CONSTRAINT `usermodule_ibfk_2` FOREIGN KEY (`moduleID`) REFERENCES `module` (`moduleID`),
  ADD CONSTRAINT `usermodule_ibfk_1` FOREIGN KEY (`kNumber`) REFERENCES `user` (`kNumber`);
