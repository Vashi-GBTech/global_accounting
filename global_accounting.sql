-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2021 at 06:25 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `global_accounting`
--

-- --------------------------------------------------------

--
-- Table structure for table `branch_master`
--

CREATE TABLE `branch_master` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `create_on` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `tb_patient` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT 1,
  `tb_lab_patient` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company_master`
--

CREATE TABLE `company_master` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `create_on` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `patient_medicine_table` varchar(255) DEFAULT NULL,
  `hospital_room_table` varchar(255) DEFAULT NULL,
  `hospital_bed_table` varchar(255) DEFAULT NULL,
  `patient_bed_history_table` varchar(255) DEFAULT NULL,
  `patient_medicine_history_table` varchar(255) DEFAULT NULL,
  `billing_transaction` varchar(255) DEFAULT NULL,
  `prescription_master_table` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users_master`
--

CREATE TABLE `users_master` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `create_on` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT 1,
  `user_type` int(11) DEFAULT 1,
  `default_access` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_master`
--

INSERT INTO `users_master` (`id`, `name`, `user_name`, `password`, `status`, `create_on`, `create_by`, `company_id`, `branch_id`, `user_type`, `default_access`) VALUES
(1, 'admin', 'admin', '123', 1, NULL, NULL, 0, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch_master`
--
ALTER TABLE `branch_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `company_master`
--
ALTER TABLE `company_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users_master`
--
ALTER TABLE `users_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `branch_id` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch_master`
--
ALTER TABLE `branch_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_master`
--
ALTER TABLE `company_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_master`
--
ALTER TABLE `users_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
