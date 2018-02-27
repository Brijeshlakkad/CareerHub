-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2018 at 09:55 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mini_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `ID` int(100) NOT NULL,
  `Name` varchar(15) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Phone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`ID`, `Name`, `Email`, `Password`, `Phone`) VALUES
(41, 'gaurav', 'gauravpanseriya0042@gmail.com', 'Gaurav0042', '9173943166'),
(44, 'Brijesh', 'lakkadb@gmail.com', '123456bB', '7046167267'),
(47, 'Brijesh', 'lakkadbrijesh@gmail.com', '123456bB', '7046167267'),
(3, 'Nimesh', 'nimeshvaghasiya@gmail.com', '123456nN', '7573883936'),
(23, 'Raj', 'r@gmail.com', '123456rR', '9638134301'),
(40, 'Vinit', 'vinitdabhi6626@gmail.com', '123456vV', '1234560789');

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `ID` int(100) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Email` varchar(35) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Bname` varchar(20) NOT NULL,
  `Bemail` varchar(35) NOT NULL,
  `Phone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`Email`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`Email`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
