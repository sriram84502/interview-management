-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 05:05 AM
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
-- Database: `interview`
--

-- --------------------------------------------------------

--
-- Table structure for table `apply`
--

CREATE TABLE `apply` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
--

CREATE TABLE `candidate` (
  `ID` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `pan` varchar(20) NOT NULL DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`ID`, `name`, `email`, `password`, `role`, `pan`) VALUES
(67, 'admin', 'admin@gmail.com', '12345678', 2, '-');

-- --------------------------------------------------------

--
-- Table structure for table `candidate_allocation`
--

CREATE TABLE `candidate_allocation` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `teacher1` varchar(100) NOT NULL,
  `teacher2` varchar(100) NOT NULL,
  `teacher3` varchar(100) NOT NULL,
  `t1name` varchar(50) NOT NULL,
  `t2name` varchar(50) NOT NULL,
  `t3name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_info`
--

CREATE TABLE `candidate_info` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pan` varchar(20) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `age` int(11) NOT NULL,
  `branch` varchar(30) NOT NULL,
  `btech_college` varchar(50) NOT NULL,
  `btech_marks` int(11) NOT NULL,
  `btech_passedout` varchar(4) NOT NULL,
  `mtech_college` varchar(50) NOT NULL,
  `mtech_marks` int(11) NOT NULL,
  `mtech_passedout` varchar(4) NOT NULL,
  `phd_college` varchar(50) DEFAULT '-',
  `phd_marks` int(11) DEFAULT NULL,
  `phd_passedyear` varchar(4) DEFAULT NULL,
  `exp_teaching` varchar(100) NOT NULL,
  `exp_industry` varchar(100) NOT NULL,
  `category` varchar(11) NOT NULL,
  `place_of_stay` varchar(20) NOT NULL,
  `date` date NOT NULL DEFAULT '2023-12-15',
  `resume` varchar(300) NOT NULL,
  `image` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidate_marks`
--

CREATE TABLE `candidate_marks` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `m1` int(11) NOT NULL,
  `m2` int(11) NOT NULL,
  `m3` int(11) NOT NULL,
  `m4` int(11) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `total` int(11) NOT NULL,
  `branch` varchar(10) NOT NULL,
  `interviewer` varchar(100) NOT NULL,
  `pan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apply`
--
ALTER TABLE `apply`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `candidate_allocation`
--
ALTER TABLE `candidate_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidate_info`
--
ALTER TABLE `candidate_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `pan` (`pan`);

--
-- Indexes for table `candidate_marks`
--
ALTER TABLE `candidate_marks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apply`
--
ALTER TABLE `apply`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT for table `candidate_allocation`
--
ALTER TABLE `candidate_allocation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `candidate_info`
--
ALTER TABLE `candidate_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `candidate_marks`
--
ALTER TABLE `candidate_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
