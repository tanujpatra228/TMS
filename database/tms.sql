-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 17, 2019 at 11:19 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE IF NOT EXISTS `tbl_admin` (
  `adminId` int(5) NOT NULL AUTO_INCREMENT,
  `tutionId` varchar(10) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` bigint(12) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`adminId`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  KEY `tutionId` (`tutionId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`adminId`, `tutionId`, `fname`, `lname`, `address`, `email`, `phone`, `pwd`) VALUES
(1, 'T0000001', 'Rima', 'Sing', 'Sagar Darshan appt, Nr. New Evergreen Bakery, Navsari Bazar, Surat', 'singrima786@gmail.com', 9898140619, 'rimasing789'),
(4, 'T509368', 'Tanuj', 'Patra', '', 'tanujpatra228@gmail.com', 7043056077, '$2y$10$82/CsKTD9HiIGQaEhRVMLuJewlBE6op0B1iGrUeBphpoOIkYkv5He'),
(6, 'T9101003', 'Pragnesh', 'Gajjar', NULL, 'pg6505@gmail.com', 9265173472, '$2y$10$g28WdtMuuUqg/WOEbZ9z/epRrm7diYIfwJbfcCtcaqgVhkldvtGKK'),
(12, 'T9324742', 'Tanuj', 'Patra', '305, Sarita apartment, Vesu', 'tanujpatra2019@gmail.com', 9879168917, '$2y$10$Rt2Hnzi6kn7AXIzvtt0xwuXLvma2.KDjvLmKMoF5drkX/BYOnnrmi');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendence`
--

DROP TABLE IF EXISTS `tbl_attendence`;
CREATE TABLE IF NOT EXISTS `tbl_attendence` (
  `attendenceId` int(11) NOT NULL AUTO_INCREMENT,
  `tutionId` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `Id` varchar(20) NOT NULL COMMENT 'ID of student or staff',
  `attendence` int(1) NOT NULL DEFAULT '1',
  `type` varchar(15) NOT NULL COMMENT 'Student / Staff',
  PRIMARY KEY (`attendenceId`),
  KEY `tutionId` (`tutionId`),
  KEY `Id` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_attendence`
--

INSERT INTO `tbl_attendence` (`attendenceId`, `tutionId`, `date`, `Id`, `attendence`, `type`) VALUES
(2, 'T0000001', '2019-03-31', 'T0000001#1#2', 1, 'student'),
(3, 'T0000001', '2019-03-31', 'T0000001#2#1', 1, 'student'),
(5, 'T0000001', '2019-03-31', 'T0000001#3#1', 1, 'student'),
(6, 'T0000001', '2019-03-31', 'T0000001#4#1', 1, 'student'),
(7, 'T0000001', '2019-03-31', 'T0000001#4#2', 1, 'student'),
(8, 'T0000001', '2019-03-31', 'T0000001#4#3', 1, 'student'),
(9, 'T0000001', '2019-04-01', 'T0000001#2#1', 1, 'student'),
(10, 'T0000001', '2019-04-01', 'T0000001#2#2', 1, 'student'),
(11, 'T0000001', '2019-04-01', 'T0000001#4#1', 1, 'student'),
(12, 'T0000001', '2019-04-01', 'T0000001#4#2', 1, 'student'),
(17, 'T0000001', '2019-04-01', 'T0000001#1#S:1', 1, 'staff'),
(18, 'T0000001', '2019-04-01', 'T0000001#2#S:2', 1, 'staff'),
(19, 'T0000001', '2019-04-01', 'T0000001#3#S:1', 1, 'staff'),
(20, 'T0000001', '2019-04-01', 'T0000001#4#S:1', 1, 'staff'),
(21, 'T0000001', '2019-04-02', 'T0000001#1#2', 1, 'student'),
(22, 'T0000001', '2019-04-02', 'T0000001#3#1', 1, 'student'),
(23, 'T0000001', '2019-04-02', 'T0000001#4#1', 1, 'student'),
(24, 'T0000001', '2019-04-02', 'T0000001#4#2', 1, 'student'),
(25, 'T0000001', '2019-04-02', 'T0000001#4#3', 1, 'student'),
(26, 'T0000001', '2019-04-05', 'T0000001#1#1', 1, 'student'),
(27, 'T0000001', '2019-04-05', 'T0000001#1#2', 1, 'student'),
(28, 'T0000001', '2019-04-05', 'T0000001#2#1', 1, 'student'),
(29, 'T0000001', '2019-04-05', 'T0000001#2#2', 1, 'student'),
(30, 'T0000001', '2019-04-05', 'T0000001#3#1', 1, 'student'),
(31, 'T0000001', '2019-04-05', 'T0000001#4#1', 1, 'student'),
(32, 'T0000001', '2019-04-05', 'T0000001#4#2', 1, 'student'),
(33, 'T0000001', '2019-04-05', 'T0000001#4#3', 1, 'student'),
(34, 'T0000001', '2019-04-08', 'T0000001#1#1', 1, 'student'),
(35, 'T0000001', '2019-04-08', 'T0000001#1#2', 1, 'student'),
(36, 'T0000001', '2019-04-08', 'T0000001#2#1', 1, 'student'),
(37, 'T0000001', '2019-04-08', 'T0000001#2#2', 1, 'student'),
(38, 'T0000001', '2019-04-08', 'T0000001#3#1', 1, 'student'),
(39, 'T0000001', '2019-04-08', 'T0000001#4#1', 1, 'student'),
(40, 'T0000001', '2019-04-08', 'T0000001#4#2', 1, 'student'),
(41, 'T0000001', '2019-04-08', 'T0000001#4#3', 1, 'student'),
(42, 'T0000001', '2019-04-08', 'T0000001#1#S:1', 1, 'staff'),
(43, 'T0000001', '2019-04-08', 'T0000001#2#S:1', 1, 'staff'),
(44, 'T0000001', '2019-04-08', 'T0000001#2#S:2', 1, 'staff'),
(45, 'T0000001', '2019-04-08', 'T0000001#3#S:1', 1, 'staff'),
(46, 'T0000001', '2019-04-08', 'T0000001#3#S:2', 1, 'staff'),
(47, 'T0000001', '2019-04-08', 'T0000001#4#S:1', 1, 'staff'),
(48, 'T0000001', '2019-04-08', 'T0000001#4#S:2', 1, 'staff'),
(49, 'T9324742', '2019-04-08', 'T9324742#1#1', 1, 'student'),
(50, 'T9324742', '2019-04-08', 'T9324742#1#2', 1, 'student'),
(51, 'T9324742', '2019-04-08', 'T9324742#2#3', 1, 'student'),
(52, 'T9324742', '2019-04-08', 'T9324742#3#1', 1, 'student'),
(53, 'T9324742', '2019-04-08', 'T9324742#3#2', 1, 'student'),
(54, 'T9324742', '2019-04-08', 'T9324742#3#3', 1, 'student'),
(55, 'T9324742', '2019-04-08', 'T9324742#4#1', 1, 'student'),
(56, 'T9324742', '2019-04-08', 'T9324742#1#S:1', 1, 'staff'),
(57, 'T9324742', '2019-04-08', 'T9324742#2#S:1', 1, 'staff'),
(58, 'T9324742', '2019-04-08', 'T9324742#1#S:1', 1, 'staff'),
(60, 'T9324742', '2019-04-08', 'T9324742#1#S:1', 1, 'staff'),
(62, 'T9324742', '2019-04-14', 'T9324742#1#1', 1, 'student'),
(63, 'T9324742', '2019-04-09', 'T9324742#2#1', 1, 'student'),
(64, 'T9324742', '2019-04-09', 'T9324742#3#2', 1, 'student'),
(65, 'T9324742', '2019-04-09', 'T9324742#3#3', 1, 'student'),
(66, 'T9324742', '2019-04-09', 'T9324742#4#1', 1, 'student'),
(67, 'T9324742', '2019-04-09', 'T9324742#4#2', 1, 'student'),
(68, 'T9324742', '2019-04-09', 'T9324742#1#1', 1, 'student'),
(69, 'T9324742', '2019-04-09', 'T9324742#2#1', 1, 'student'),
(70, 'T9324742', '2019-04-09', 'T9324742#3#2', 1, 'student'),
(71, 'T9324742', '2019-04-09', 'T9324742#3#3', 1, 'student'),
(72, 'T9324742', '2019-04-09', 'T9324742#4#1', 1, 'student'),
(73, 'T9324742', '2019-04-09', 'T9324742#4#2', 1, 'student'),
(74, 'T9324742', '2019-04-09', 'T9324742#1#1', 1, 'student'),
(75, 'T9324742', '2019-04-09', 'T9324742#2#1', 1, 'student'),
(76, 'T9324742', '2019-04-09', 'T9324742#3#2', 1, 'student'),
(77, 'T9324742', '2019-04-09', 'T9324742#3#3', 1, 'student'),
(78, 'T9324742', '2019-04-09', 'T9324742#4#1', 1, 'student'),
(79, 'T9324742', '2019-04-09', 'T9324742#4#2', 1, 'student'),
(80, 'T9324742', '2019-04-09', 'T9324742#2#2', 1, 'student'),
(81, 'T9324742', '2019-04-09', 'T9324742#2#3', 1, 'student'),
(82, 'T9324742', '2019-04-09', 'T9324742#3#1', 1, 'student'),
(83, 'T9324742', '2019-04-09', 'T9324742#3#3', 1, 'student'),
(84, 'T9324742', '2019-04-09', 'T9324742#4#1', 1, 'student'),
(85, 'T9324742', '2019-04-09', 'T9324742#4#2', 1, 'student'),
(86, 'T9324742', '2019-04-09', 'T9324742#5#1', 1, 'student'),
(87, 'T9324742', '2019-04-09', 'T9324742#1#S:1', 1, 'staff'),
(88, 'T9324742', '2019-04-09', 'T9324742#2#S:1', 1, 'staff'),
(89, 'T9324742', '2019-04-09', 'T9324742#2#3', 1, 'student'),
(90, 'T9324742', '2019-04-09', 'T9324742#3#2', 1, 'student'),
(91, 'T9324742', '2019-04-09', 'T9324742#3#3', 1, 'student'),
(92, 'T9324742', '2019-04-09', 'T9324742#4#2', 1, 'student'),
(93, 'T9324742', '2019-04-09', 'T9324742#5#1', 1, 'student'),
(94, 'T9324742', '2019-04-12', 'T9324742#1#S:1', 1, 'staff'),
(95, 'T9324742', '2019-04-12', 'T9324742#1#S:2', 1, 'staff'),
(96, 'T9324742', '2019-04-12', 'T9324742#2#S:1', 1, 'staff'),
(97, 'T9324742', '2019-04-12', 'T9324742#3#S:1', 1, 'staff'),
(98, 'T9324742', '2019-04-12', 'T9324742#1#S:1', 1, 'staff'),
(99, 'T9324742', '2019-04-12', 'T9324742#1#S:2', 1, 'staff'),
(100, 'T9324742', '2019-04-12', 'T9324742#2#S:1', 1, 'staff'),
(101, 'T9324742', '2019-04-12', 'T9324742#3#S:1', 1, 'staff'),
(102, 'T9324742', '2019-04-12', '', 1, 'staff'),
(103, 'T9324742', '2019-04-12', '', 1, 'staff'),
(104, 'T9324742', '2019-04-12', '', 1, 'staff'),
(105, 'T9324742', '2019-04-12', '', 1, 'staff'),
(106, 'T9324742', '2019-03-14', 'T9324742#1#1', 1, 'student'),
(107, 'T9324742', '2019-04-14', 'T9324742#1#2', 1, 'student'),
(108, 'T9324742', '2019-04-14', 'T9324742#2#1', 1, 'student'),
(109, 'T9324742', '2019-04-14', 'T9324742#4#1', 1, 'student'),
(110, 'T9324742', '2019-04-14', 'T9324742#4#2', 1, 'student'),
(112, 'T9324742', '2019-04-14', 'T9324742#2#S:1', 1, 'staff'),
(113, 'T9324742', '2019-04-14', '', 1, 'staff'),
(114, 'T9324742', '2019-04-14', 'T9324742#1#S:1', 1, 'staff'),
(115, 'T9324742', '2019-04-16', 'T9324742#1#1', 1, 'student'),
(116, 'T9324742', '2019-04-16', 'T9324742#1#2', 1, 'student'),
(117, 'T9324742', '2019-04-16', 'T9324742#2#1', 1, 'student'),
(118, 'T9324742', '2019-04-16', 'T9324742#2#2', 1, 'student'),
(119, 'T9324742', '2019-04-16', 'T9324742#2#3', 1, 'student'),
(120, 'T9324742', '2019-04-16', 'T9324742#3#1', 1, 'student'),
(121, 'T9324742', '2019-04-16', 'T9324742#3#2', 1, 'student'),
(122, 'T9324742', '2019-04-16', 'T9324742#3#3', 1, 'student'),
(123, 'T9324742', '2019-04-16', 'T9324742#4#1', 1, 'student'),
(124, 'T9324742', '2019-04-16', 'T9324742#4#2', 1, 'student'),
(125, 'T9324742', '2019-04-16', 'T9324742#5#1', 1, 'student'),
(126, 'T9324742', '2019-04-16', 'T9324742#1#S:1', 1, 'staff'),
(127, 'T9324742', '2019-04-16', 'T9324742#1#S:2', 1, 'staff'),
(128, 'T9324742', '2019-04-16', 'T9324742#2#S:1', 1, 'staff'),
(129, 'T9324742', '2019-04-16', 'T9324742#2#S:2', 1, 'staff'),
(130, 'T9324742', '2019-04-16', 'T9324742#3#S:1', 1, 'staff'),
(131, 'T9324742', '2019-04-15', 'T9324742#1#S:1', 1, 'staff'),
(132, 'T9324742', '2019-04-13', 'T9324742#1#S:1', 1, 'staff'),
(133, 'T9324742', '2019-04-11', 'T9324742#1#S:1', 1, 'staff'),
(135, 'T9324742', '2019-04-10', 'T9324742#1#S:1', 1, 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

DROP TABLE IF EXISTS `tbl_branch`;
CREATE TABLE IF NOT EXISTS `tbl_branch` (
  `branchId` varchar(25) NOT NULL COMMENT 'tutionId#[1,2,3...]',
  `tutionId` varchar(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `phone` bigint(11) NOT NULL,
  PRIMARY KEY (`branchId`),
  KEY `tutionId` (`tutionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_branch`
--

INSERT INTO `tbl_branch` (`branchId`, `tutionId`, `address`, `state`, `city`, `phone`) VALUES
('T0000001#1', 'T0000001', 'Navsari Bazar', 'Gujarat', 'Surat', 9898140619),
('T0000001#2', 'T0000001', 'Parle Point', 'Gujarat', 'Surat', 7043056077),
('T0000001#3', 'T0000001', 'Adajan', 'Gujarat', 'Surat', 9265353025),
('T0000001#4', 'T0000001', ' Vesu', 'Gujarat', 'Surat', 9898255423),
('T509368#1', 'T509368', 'City Light', '284', 'Surat', 7043056077),
('T509368#2', 'T509368', 'vesu', '86', 'Surat', 7600343118),
('T6509491#1', 'T6509491', 'Vesu', '284', 'Sunav', 9873214560),
('T9101003#1', 'T9101003', 'Ambika Niketan', '100', 'Samalkha', 9723146723),
('T9324742#1', 'T9324742', 'U-1, Star Arcade', 'Gujarat', 'Surat', 7043056077),
('T9324742#2', 'T9324742', 'U-1, Corner Point', 'Gujarat', 'Surat', 9898140618),
('T9324742#3', 'T9324742', ' 305, Surbhi House', 'Maharashtra', 'Mumbai', 9874000501),
('T9324742#4', 'T9324742', 'L-9, Rajhans Olympia', 'West Bengal', 'Kolkata', 7256898462),
('T9324742#5', 'T9324742', 'E2, Swastik ', 'Rajasthan', 'Ajabpura', 7043056078);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_course`
--

DROP TABLE IF EXISTS `tbl_course`;
CREATE TABLE IF NOT EXISTS `tbl_course` (
  `id` int(2) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`short_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_course`
--

INSERT INTO `tbl_course` (`id`, `short_name`, `name`) VALUES
(1, 'jkg', 'Jr. Kg.'),
(2, 'skg', 'Sr. Kg.'),
(3, '1', 'STD 1'),
(4, '2', 'STD 2'),
(5, '3', 'STD 3'),
(6, '4', 'STD 4'),
(7, '5', 'STD 5'),
(8, '6', 'STD 6'),
(9, '7', 'STD 7'),
(10, '8', 'STD 8'),
(11, '9', 'STD 9'),
(12, '10', 'STD 10'),
(13, '11com', 'STD 11 (Comm.)'),
(14, '12com', 'STD 12 (Comm.)'),
(15, '11sci', 'STD 11 (Sci.)'),
(16, '12sci', 'STD 12 (Sci.)');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense`
--

DROP TABLE IF EXISTS `tbl_expense`;
CREATE TABLE IF NOT EXISTS `tbl_expense` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tutionId` varchar(10) NOT NULL,
  `branchId` varchar(15) NOT NULL,
  `expense` varchar(50) NOT NULL,
  `amt` int(7) NOT NULL,
  `date` date DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_expense`
--

INSERT INTO `tbl_expense` (`id`, `tutionId`, `branchId`, `expense`, `amt`, `date`, `remark`) VALUES
(1, 'T0000001', 'T0000001#1', 'stationary', 120, '2019-04-14', 'Brought 2 Marker Pen'),
(2, 'T0000001', 'T0000001#2', 'Advertisement', 10000, NULL, 'Banner printing'),
(3, 'T0000001', 'T0000001#1', 'Stationary', 50, NULL, ''),
(4, 'T0000001', 'T0000001#2', 'Utility Bill', 1500, NULL, 'Eletric bill'),
(5, 'T0000001', 'T0000001#3', 'Rent', 5000, NULL, 'Paid shop rent'),
(9, 'T9324742', 'T9324742#1', 'Stationary', 150, NULL, 'Purchased Pens'),
(10, 'T9324742', 'T9324742#2', 'Advertisement', 5000, '2019-03-31', 'Banner Printing'),
(11, 'T9324742', 'T9324742#3', 'Stationary', 1500, '2019-04-02', 'New White Board'),
(12, 'T9324742', 'T9324742#2', 'Stationary', 70, '2019-04-11', 'Marker Ink'),
(13, 'T9324742', 'T9324742#5', 'Furnishing', 3500, '2019-04-08', 'Purchase Benches'),
(14, 'T9324742', 'T9324742#1', 'Stationary', 50, '2019-04-05', 'Pens'),
(15, 'T9324742', 'T9324742#2', 'Testing', 5050, '2019-03-14', 'Testing123'),
(16, 'T9324742', 'T9324742#3', 'Testing2', 1010, '2019-04-14', 'testing123'),
(17, 'T9324742', 'T9324742#2', 'Traveling expense', 100, '2019-04-16', 'Went to schools for promotion');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_fees`
--

DROP TABLE IF EXISTS `tbl_fees`;
CREATE TABLE IF NOT EXISTS `tbl_fees` (
  `Id` int(7) NOT NULL AUTO_INCREMENT,
  `tutionId` varchar(20) NOT NULL,
  `studentId` varchar(15) NOT NULL,
  `branchId` varchar(15) NOT NULL,
  `amt` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `studentId` (`studentId`),
  KEY `branchId` (`branchId`),
  KEY `tutionId` (`tutionId`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_fees`
--

INSERT INTO `tbl_fees` (`Id`, `tutionId`, `studentId`, `branchId`, `amt`, `date`) VALUES
(1, 'T9324742', 'T9324742#1#1', 'T9324742#1', '500.00', '2019-03-11'),
(2, 'T9324742', 'T9324742#1#2', 'T9324742#1', '500.00', '2019-03-11'),
(3, 'T9324742', 'T9324742#1#1', 'T9324742#1', '500.00', '2019-03-11'),
(4, 'T9324742', 'T9324742#1#1', 'T9324742#1', '500.00', '2019-03-11'),
(5, 'T9324742', 'T9324742#2#1', 'T9324742#2', '2000.00', '2019-04-12'),
(6, 'T9324742', 'T9324742#1#1', 'T9324742#1', '2000.00', '2019-04-13'),
(7, 'T9324742', 'T9324742#3#2', 'T9324742#3', '3000.00', '2019-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_marks`
--

DROP TABLE IF EXISTS `tbl_marks`;
CREATE TABLE IF NOT EXISTS `tbl_marks` (
  `marksId` int(10) NOT NULL AUTO_INCREMENT,
  `studentId` varchar(20) DEFAULT NULL,
  `date` date NOT NULL,
  `eng1` int(5) DEFAULT NULL,
  `gramer` int(5) DEFAULT NULL,
  `maths` int(5) DEFAULT NULL,
  `sci` int(5) DEFAULT NULL,
  `ss` int(5) DEFAULT NULL,
  `env` int(5) DEFAULT NULL,
  `gk` int(5) DEFAULT NULL,
  `hindi` int(5) DEFAULT NULL,
  `sanskrit` int(5) DEFAULT NULL,
  `computer` int(5) DEFAULT NULL,
  `eco` int(5) DEFAULT NULL,
  `oc` int(5) DEFAULT NULL,
  `ac` int(5) DEFAULT NULL,
  `guj` int(5) DEFAULT NULL,
  `bio` int(11) DEFAULT NULL,
  PRIMARY KEY (`marksId`),
  KEY `studentId` (`studentId`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_marks`
--

INSERT INTO `tbl_marks` (`marksId`, `studentId`, `date`, `eng1`, `gramer`, `maths`, `sci`, `ss`, `env`, `gk`, `hindi`, `sanskrit`, `computer`, `eco`, `oc`, `ac`, `guj`, `bio`) VALUES
(1, 'T0000001#1#1', '2019-03-31', 70, 55, 65, 55, 60, 62, 45, 50, 52, 75, NULL, NULL, 25, NULL, NULL),
(7, 'T0000001#1#2 	', '2019-03-31', 63, 45, 35, 61, 42, 55, 31, 50, 49, 47, NULL, NULL, NULL, 52, NULL),
(8, 'T0000001#2#1 	', '2019-04-06', 54, 66, 42, 40, 33, 40, 61, 54, NULL, 46, NULL, NULL, NULL, 47, NULL),
(9, 'T0000001#2#2', '2019-04-07', 60, 50, 43, 47, 49, 52, 41, 50, NULL, 66, NULL, NULL, NULL, 37, NULL),
(10, 'T0000001#3#1 	', '2019-04-08', 63, 56, 41, 43, 53, 60, 51, 56, NULL, 41, NULL, NULL, NULL, 43, NULL),
(11, 'T0000001#3#2 	', '2019-04-06', 70, 46, 52, 61, 33, 44, 65, 60, NULL, 65, NULL, NULL, NULL, 67, NULL),
(12, 'T0000001#4#1 	', '2019-04-08', 51, 73, 49, 77, 56, 60, 63, 74, NULL, 61, NULL, NULL, NULL, 37, NULL),
(13, 'T9324742#1#1', '2019-04-05', 52, 25, 84, 42, 53, 71, 43, 70, NULL, 73, NULL, NULL, NULL, 43, NULL),
(23, 'T9324742#1#1', '2019-04-06', 76, 43, 56, 47, 58, 51, 34, 76, 48, 94, 85, 76, 74, 81, 4),
(24, 'T9324742#1#1', '2019-04-07', NULL, 72, 43, 45, 74, 64, 71, 61, 43, 21, 81, 75, 61, 34, 67),
(25, 'T9324742#1#1', '2019-04-08', 76, 43, 56, 47, 58, 51, 34, 76, 48, 94, 85, 76, 74, 81, 4),
(26, 'T9324742#1#1', '2019-04-10', NULL, 72, 43, 45, 74, 64, 71, 61, 43, 21, 81, 75, 61, 34, 67);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notice`
--

DROP TABLE IF EXISTS `tbl_notice`;
CREATE TABLE IF NOT EXISTS `tbl_notice` (
  `noticeId` int(10) NOT NULL AUTO_INCREMENT,
  `tutionId` varchar(20) NOT NULL,
  `notice_head` varchar(50) DEFAULT NULL,
  `notice_body` varchar(500) NOT NULL,
  `receipient` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(10) NOT NULL,
  PRIMARY KEY (`noticeId`),
  KEY `tutionId` (`tutionId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_notice`
--

INSERT INTO `tbl_notice` (`noticeId`, `tutionId`, `notice_head`, `notice_body`, `receipient`, `date`, `time`) VALUES
(1, 'T0000001', 'Notice1', 'Notice1 body', 'student', '2019-03-05', '20:9:29'),
(2, 'T0000001', 'time table for unit test', 'on 10th april there will test of subject ss unit 1 to 5', 'student', '2019-03-08', '10:37:14'),
(3, 'T0000001', 'time table for unit test', 'on 10th april there will test of subject sciunit 1 to 5', 'student', '2019-03-08', '10:37:38'),
(4, 'T0000001', 'time table for unit test', 'on 10th april there will test of subject sci unit 1 to 5', 'student', '2019-03-08', '10:38:4'),
(10, 'T9324742', 'Final exam Preparation', 'Exam of all subjects will be conducted from 15-April-2019 <br/>\r\n15-April - Eng, <br/>\r\n16-April - Grammar,  <br/>\r\n17-April - Sci,  <br/>\r\n18-April - SS,  <br/>\r\n19-April - Hindi,  <br/>\r\n20-April - Maths,  <br/>\r\n21-April - Guj,  <br/>\r\n22-April - Sanskrit & Computer', 'student', '2019-03-09', '11:27:5'),
(11, 'T9324742', 'Notice For Exam', 'Exam is scheduled at 16th of this month', 'student', '2019-03-10', '13:32:21'),
(12, 'T9324742', 'Notice For Exam', '<pre>\r\nExam is scheduled at 16th of this month\r\n</pre>', 'student', '2019-03-10', '13:37:16'),
(13, 'T9324742', 'Notice For Exam', '<pre>\r\nExam is scheduled at 16th of this \r\n<strong>month</strong>\r\n</pre>', 'student', '2019-03-10', '13:37:44');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salary`
--

DROP TABLE IF EXISTS `tbl_salary`;
CREATE TABLE IF NOT EXISTS `tbl_salary` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `tutionId` varchar(15) NOT NULL,
  `staffId` varchar(20) NOT NULL,
  `branchId` varchar(20) NOT NULL,
  `amt` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `staffId` (`staffId`,`branchId`),
  KEY `tutionId` (`tutionId`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_salary`
--

INSERT INTO `tbl_salary` (`Id`, `tutionId`, `staffId`, `branchId`, `amt`, `date`) VALUES
(8, 'T9324742', 'T9324742#1#S:1', 'T9324742#1', '500.00', '2019-03-11'),
(9, 'T9324742', 'T9324742#1#S:1', 'T9324742#1', '600.00', '2019-03-11'),
(10, 'T9324742', 'T9324742#2#S:1', 'T9324742#2', '500.00', '2019-03-11'),
(11, 'T9324742', 'T9324742#3#S:1', 'T9324742#3', '500.00', '2019-03-11'),
(12, 'T9324742', 'T9324742#1#S:2', 'T9324742#1', '1000.00', '2019-03-12'),
(13, 'T9324742', 'T9324742#1#S:2', 'T9324742#1', '1200.00', '2019-04-12'),
(14, 'T9324742', 'T9324742#1#S:1', 'T9324742#1', '2000.00', '2019-04-12'),
(15, 'T9324742', 'T9324742#3#S:1', 'T9324742#3', '1500.00', '2019-04-16'),
(16, 'T9324742', 'T9324742#3#S:1', 'T9324742#3', '1500.00', '2019-04-16'),
(32, 'T9324742', 'T9324742#2#S:1', 'T9324742#2', '10000.00', '2019-04-16'),
(33, 'T9324742', 'T9324742#2#S:2', 'T9324742#2', '1000.00', '2019-04-16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

DROP TABLE IF EXISTS `tbl_staff`;
CREATE TABLE IF NOT EXISTS `tbl_staff` (
  `tutionId` varchar(10) NOT NULL,
  `branchId` varchar(10) NOT NULL,
  `staffId` varchar(15) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `middleName` varchar(50) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `qualification` varchar(100) DEFAULT NULL,
  `totalSalary` decimal(10,2) NOT NULL,
  `paidSalary` decimal(10,2) NOT NULL,
  `doj` date NOT NULL,
  `exp` int(2) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'Normal' COMMENT 'N-normal, H-head',
  PRIMARY KEY (`staffId`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `email` (`email`),
  KEY `branchId` (`branchId`),
  KEY `tutionId` (`tutionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`tutionId`, `branchId`, `staffId`, `photo`, `name`, `middleName`, `sex`, `phone`, `email`, `password`, `qualification`, `totalSalary`, `paidSalary`, `doj`, `exp`, `address`, `state`, `city`, `type`) VALUES
('T0000001', 'T0000001#1', 'T0000001#1#S:1', 'T0000001_1_S1.jpg', 'Rima Sing', 'H.', 'female', 9898140619, 'singrima@gmail.com', '987654321', '', '2000.00', '1000.00', '2011-05-02', 8, 'Sagar Darshan soc.', '284', 'Surat', 'Head'),
('T0000001', 'T0000001#2', 'T0000001#2#S:1', 'T0000001_2_S1.jpg', 'Tanuj ', 'G.', 'male', 7043056076, 'tanuj@gmail.com', '$2y$10$mbLvKp2vAX6j4YMg3mHiNOLDuaZiMx/0ZhOKJaxVU0JBosBXxQq7i', '', '2000.00', '1000.00', '2019-02-22', NULL, NULL, '284', 'Surat', 'Normal'),
('T0000001', 'T0000001#2', 'T0000001#2#S:2', NULL, 'Wally West', 'Joe', 'male', 9898989898, 'kidflash@gmail.com', '$2y$10$735srFK2S3SLsFade41TbOhWdGQZ6GWOJVLIF37BvALnf2EIunnri', '', '1000.00', '1000.00', '2019-02-25', NULL, NULL, NULL, NULL, 'Normal'),
('T0000001', 'T0000001#3', 'T0000001#3#S:1', 'T0000001_3_S1.jpg', 'Cisco Remon', '', 'male', 2233445566, 'vibe@gmail.com', '$2y$10$735srFK2S3SLsFade41TbOhWdGQZ6GWOJVLIF37BvALnf2EIunnri', 'Hacker', '30000.00', '1000.00', '2019-02-26', NULL, 'Star Labs', '100', 'Dera', 'Normal'),
('T0000001', 'T0000001#3', 'T0000001#3#S:2', NULL, 'Pragnesh Gajjar', 'Bharat', 'male', 7984752198, 'pg@gmail.com', '$2y$10$oWH1Np0PexR5bxcmBa4fmemGA5pRr6WXhu/inAiseq2zQYsKrJ9ta', 'BCA, M.ScIT', '15000.00', '1000.00', '2019-02-26', NULL, NULL, NULL, NULL, 'Normal'),
('T0000001', 'T0000001#4', 'T0000001#4#S:1', NULL, 'Nora Allen', 'Barry', 'female', 4444444444, 'nora@gmail.com', '$2y$10$8ejYU3TzyDhgfuQkct9IE.8x1aIHnuqpZpMGHfaqVq6n.xHuEKQ5e', 'CCPD', '40000.00', '1000.00', '2019-02-24', NULL, NULL, NULL, NULL, 'Normal'),
('T0000001', 'T0000001#4', 'T0000001#4#S:2', NULL, 'Akshay Mahajan', '', 'male', 9870052609, 'ak@gmail.com', '$2y$10$oWH1Np0PexR5bxcmBa4fmemGA5pRr6WXhu/inAiseq2zQYsKrJ9ta', 'B.sc', '14000.00', '1000.00', '2019-02-26', NULL, NULL, NULL, NULL, 'Normal'),
('T9324742', 'T9324742#1', 'T9324742#1#S:1', 'T9324742_1_S1.jpg', 'Rima Sing', 'Hiru', 'female', 9265353025, 'singrima789@gmail.com', '$2y$10$nPg5HYSYxPvhxrKs/RLcEudXDhhApSFcgEOkmOrC9s69WuvwB3NFO', 'BCA', '2000.00', '1000.00', '2019-03-09', NULL, 'Navsari Bazar', '284', 'Surat', 'Head'),
('T9324742', 'T9324742#1', 'T9324742#1#S:2', 'T9324742_1_S2.jpg', 'Harsh Patel', 'Dinesh', 'male', 9874513487, 'harshpatel99@gmail.com', '', NULL, '1500.00', '1000.00', '2019-04-11', NULL, NULL, NULL, NULL, 'Normal'),
('T9324742', 'T9324742#2', 'T9324742#2#S:1', 'T9324742_2_S1.jpg', 'Tanuj Patra', 'Gautam', 'male', 7043056077, 'tanujpatra228@gmail.com', '$2y$10$3QkzpWWEzdnTs.4F2o4hZuAhMrgWYzWNh34UTvurPqoUcefYvpR6e', 'BCA,MCA', '2000.00', '1000.00', '2019-03-08', NULL, 'Ambika Niketan, Parle Point', '100', 'Dera', 'Head'),
('T9324742', 'T9324742#2', 'T9324742#2#S:2', NULL, 'Pragnesh Gajjar', 'Bharat Bhai', 'male', 9743165248, 'pragneshgajjar6505@gmail.com', '$2y$10$uh.zZTMYn8H2US3KqHeJ4OPXkHtfKZl5FoKzQqvBNNzCKoLmog52.', 'BCA,MscIT', '10000.00', '1000.00', '2019-03-02', NULL, NULL, NULL, NULL, 'Normal'),
('T9324742', 'T9324742#3', 'T9324742#3#S:1', NULL, 'Rohan Gavali', 'Dinesh', 'male', 9874574164, 'rohangavali168@gmail.com', '$2y$10$Ru6IwLL2BvexKlDiE4KfF.umJorU1hDImTXit14Af1yu4NE2IccxS', 'BCA', '1500.00', '1000.00', '2019-03-08', NULL, NULL, NULL, NULL, 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

DROP TABLE IF EXISTS `tbl_student`;
CREATE TABLE IF NOT EXISTS `tbl_student` (
  `tutionId` varchar(10) NOT NULL,
  `branchId` varchar(10) NOT NULL,
  `studentId` varchar(15) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `fatherName` varchar(50) NOT NULL,
  `motherName` varchar(50) DEFAULT NULL,
  `sex` varchar(6) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` bigint(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `std` varchar(10) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `totalFees` decimal(10,2) NOT NULL,
  `paidFees` decimal(10,2) NOT NULL,
  PRIMARY KEY (`studentId`),
  KEY `tutionId` (`tutionId`,`branchId`),
  KEY `branchId` (`branchId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`tutionId`, `branchId`, `studentId`, `photo`, `name`, `fatherName`, `motherName`, `sex`, `dob`, `phone`, `email`, `password`, `std`, `address`, `state`, `city`, `totalFees`, `paidFees`) VALUES
('T0000001', 'T0000001#1', 'T0000001#1#1', 'T0000001_1_1.jpg', 'Ankita Das', '', '', 'female', '2019-03-06', 9898410619, 'ankita@gmail.com', '$2y$10$zuR9LXyORgEr605EjDagkOQBP4J5xuJdTqmCj7QCEc1r27l7crbhi', '7', '', '284', 'Surat', '17000.00', '0.00'),
('T0000001', 'T0000001#1', 'T0000001#1#2', NULL, 'Srijan', '', NULL, 'male', NULL, 8888888888, 'srijan@gmail.com', '123456789', '5', NULL, NULL, NULL, '10000.00', '8000.00'),
('T0000001', 'T0000001#2', 'T0000001#2#1', NULL, 'Rajiv', '', NULL, 'male', NULL, 1111111111, 'rajiv@gmail.com', '123456789', 'skg', NULL, NULL, NULL, '5000.00', '3000.00'),
('T0000001', 'T0000001#2', 'T0000001#2#2', NULL, 'Mampi', '', NULL, 'female', NULL, 2222222222, 'mampi@gmail.com', '123456789', 'skg', NULL, NULL, NULL, '5000.00', '2500.00'),
('T0000001', 'T0000001#3', 'T0000001#3#1', NULL, 'Shakshi', '', NULL, 'female', NULL, 2222222222, 'shakshi@gmail.com', '123456789', 'jkg', NULL, NULL, NULL, '5000.00', '2500.00'),
('T0000001', 'T0000001#4', 'T0000001#4#1', NULL, 'Adarsh Yadav', 'H.', NULL, 'male', NULL, 3333333333, 'adarsh@gmail.com', '$2y$10$W591on1MLoapGuYadbEG9.CeITGZyiLP5/9cEDkhslzoWFcSsmmHm', '5', NULL, NULL, NULL, '17000.00', '0.00'),
('T0000001', 'T0000001#4', 'T0000001#4#2', NULL, 'Berry Allen', 'Bob', NULL, 'male', NULL, 9876543210, 'sam@gmail.com', '$2y$10$GxGk1i9AlK.XNC2nE11yJuHes6/Bd8IsDDGz7G2l1CMSVAOESS9em', 'jkg', NULL, NULL, NULL, '5000.00', '0.00'),
('T0000001', 'T0000001#4', 'T0000001#4#3', NULL, 'Eris West', 'Joe', NULL, 'female', NULL, 4444444444, 'eris@gmail.com', '$2y$10$GxGk1i9AlK.XNC2nE11yJuHes6/Bd8IsDDGz7G2l1CMSVAOESS9em', 'jkg', NULL, NULL, NULL, '5000.00', '0.00'),
('T9324742', 'T9324742#1', 'T9324742#1#1', 'T9324742_1_1.jpg', 'Ankita Patel', 'Bipin Patel', '', 'female', '2019-03-01', 9876253146, 'ankitapatel2005@gmail.com', '$2y$10$9f0i9kvZi88dbcFdgo10zOqHiAOKyKK4Asv0SUm2E3Di3fGRNsjQK', '7', 'Navsari Bazar', '284', 'Surat', '10000.00', '4000.00'),
('T9324742', 'T9324742#1', 'T9324742#1#2', NULL, 'Srijan Shah', 'Amit Shah', NULL, 'male', '2018-03-07', 9487621548, 'amitshah1989@gmail.com', '$2y$10$9f0i9kvZi88dbcFdgo10zOqHiAOKyKK4Asv0SUm2E3Di3fGRNsjQK', '7', NULL, NULL, NULL, '10000.00', '0.00'),
('T9324742', 'T9324742#2', 'T9324742#2#1', NULL, 'Argha Das', 'Biplob Das', NULL, 'male', '2019-03-02', 9587458126, 'arghadas2015@gmail.com', '$2y$10$e.dunzPO7/Devmk9nNiHDei7p1tvlbh1sqmM7pvVm1Z5fZ.fPK2v.', '7', NULL, NULL, NULL, '10000.00', '0.00'),
('T9324742', 'T9324742#2', 'T9324742#2#2', NULL, 'Krishna Bharucha', 'Dharam Bharucha', NULL, 'male', '2019-03-05', 9748134577, 'krishna1997@gmail.com', '$2y$10$OKFaow7poFIB08XDdSSnKu1wzdlYy7U84RzEnMoqEm6ppF2q5CCYO', '8', NULL, NULL, NULL, '12000.00', '0.00'),
('T9324742', 'T9324742#2', 'T9324742#2#3', NULL, 'Veene Jain', 'Nayeem Jain', NULL, 'male', '2019-03-06', 7748124695, 'jainveene04@gmail.com', '$2y$10$OKFaow7poFIB08XDdSSnKu1wzdlYy7U84RzEnMoqEm6ppF2q5CCYO', '8', NULL, NULL, NULL, '12000.00', '0.00'),
('T9324742', 'T9324742#3', 'T9324742#3#1', NULL, 'Krishna Bharucha', 'Nilesh Bharucha', NULL, 'male', '2019-02-25', 9745713467, 'krishna22@gmail.com', '$2y$10$xuEWppqi7f99zhuIRkb4TOe371i7JOBI29EUKc0FltV0aeOFskhA6', '8', NULL, NULL, NULL, '12000.00', '0.00'),
('T9324742', 'T9324742#3', 'T9324742#3#2', NULL, 'Jay Mahatama', 'Dinesh Mahatama', NULL, 'male', '2019-02-28', 9457812455, 'Jay2005@gmail.com', '$2y$10$xuEWppqi7f99zhuIRkb4TOe371i7JOBI29EUKc0FltV0aeOFskhA6', '8', NULL, NULL, NULL, '12000.00', '0.00'),
('T9324742', 'T9324742#3', 'T9324742#3#3', NULL, 'Veene Jain', 'Naiyan Jain', NULL, 'female', '2019-03-01', 9854731254, 'veeni2343@gmail.com', '$2y$10$J7n59V9tXnhdnehoJ4GY2uKjSSvzpIK.XjtmDsCerHrIX/VpbNb4m', '9', NULL, NULL, NULL, '14000.00', '0.00'),
('T9324742', 'T9324742#4', 'T9324742#4#1', NULL, 'Pragnesh Gajjar', 'Bharat Gajjar', NULL, 'male', '2019-03-01', 9847581457, 'pragnesh6505@outlook.com', '$2y$10$NsC5m3znOvFgX23rltSyM..fVUjGZ/Ikt4Y6NxjgB5J8AAn/mSSw6', '10', NULL, NULL, NULL, '16000.00', '0.00'),
('T9324742', 'T9324742#4', 'T9324742#4#2', NULL, 'Riya Duya', 'Nilesh Duya', NULL, 'female', '2019-03-02', 9245781647, 'duyariya22@gmail.com', '$2y$10$b4E.CTwS7pFHULHiPS9NjOlq7.hbtHk3OWJKxzZ.lOogMB4LVQ4Bi', '10', NULL, NULL, NULL, '16000.00', '0.00'),
('T9324742', 'T9324742#5', 'T9324742#5#1', 'T9324742_5_1.21', 'Rohan Gavali', 'Dharmesh', '', 'male', '2006-03-01', 9546875216, 'rohangavali168@gmail.com', '$2y$10$CkXySxIMgbylEkAFsx5h5.MMpWsucyBovUWNTHKyuXgrmnSNB8gB2', '10', '', '284', 'Dabhoi', '20000.00', '2000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tution`
--

DROP TABLE IF EXISTS `tbl_tution`;
CREATE TABLE IF NOT EXISTS `tbl_tution` (
  `tutionId` varchar(10) NOT NULL COMMENT 'T[7 digit random number]',
  `name` varchar(255) NOT NULL,
  `tag_line` varchar(300) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `logo` longblob,
  `email` varchar(255) DEFAULT NULL,
  `phone` bigint(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `course` varchar(255) NOT NULL COMMENT 'subjects saperated by ":"',
  PRIMARY KEY (`tutionId`),
  UNIQUE KEY `email` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tution`
--

INSERT INTO `tbl_tution` (`tutionId`, `name`, `tag_line`, `address`, `state`, `city`, `logo`, `email`, `phone`, `url`, `course`) VALUES
('T0000001', 'Prime Tutions', '', 'E-2, Swastik apartment nr. Ambika Niketan, Parle Point', 'gujarat', 'surat', 0x54303030303030312e706e67, 'primetutions@gmail.com', 9898140619, 'www.primetutions.com', 'jkg:skg:1:2:3:4:5:6:7:8'),
('T509368', 'Bright Side', 'To the Bright Side', 'City Light', '284', 'Surat', 0x543530393336382e706e67, 'bright@gmail.com', 7043056077, 'www.bright.com', 'jkg:skg:1:2:3:4:5:6:7:8:9:10:11com:12com:11sci:12sci'),
('T6509491', 'Tutorial Point', '', 'Vesu', '284', 'Sunav', NULL, 'tutorialpoint@gmail.com', 9873214560, 'www.tutorialpoint.com', 'jkg:skg:1:2:3:4:5:6:7:8:9:10:11com:12com:11sci'),
('T9101003', 'Study night', '', 'Ambika Niketan', '100', 'Samalkha', NULL, 'studynight@gmail.com', 9723146723, 'www.studynight.com', '11com:12com'),
('T9324742', 'Star Track', 'Start your Journy with Star track!', 'U-1, Star Arcade, Vesu', '284', 'Surat', 0x54393332343734322e706e67, 'startracks22@gmail.com', 9879168917, 'www.startracks.com', '7:8:9:10');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD CONSTRAINT `tbl_admin_ibfk_1` FOREIGN KEY (`tutionId`) REFERENCES `tbl_tution` (`tutionId`);

--
-- Constraints for table `tbl_branch`
--
ALTER TABLE `tbl_branch`
  ADD CONSTRAINT `tbl_branch_ibfk_1` FOREIGN KEY (`tutionId`) REFERENCES `tbl_tution` (`tutionId`);

--
-- Constraints for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD CONSTRAINT `tbl_staff_ibfk_1` FOREIGN KEY (`branchId`) REFERENCES `tbl_branch` (`branchId`),
  ADD CONSTRAINT `tbl_staff_ibfk_2` FOREIGN KEY (`tutionId`) REFERENCES `tbl_tution` (`tutionId`);

--
-- Constraints for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD CONSTRAINT `tbl_student_ibfk_1` FOREIGN KEY (`branchId`) REFERENCES `tbl_branch` (`branchId`),
  ADD CONSTRAINT `tbl_student_ibfk_2` FOREIGN KEY (`tutionId`) REFERENCES `tbl_tution` (`tutionId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
