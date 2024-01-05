-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2021 at 06:17 AM
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
-- Table structure for table `branch_account_setup`
--

CREATE TABLE `branch_account_setup` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `parent_account_number` varchar(255) DEFAULT NULL,
  `parent_details` varchar(45) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch_account_setup`
--

INSERT INTO `branch_account_setup` (`id`, `branch_id`, `account_number`, `detail`, `parent_account_number`, `parent_details`, `created_by`, `created_on`) VALUES
(1, NULL, '1234', 'abc', '2054', 'Expense Account', 3, '2021-12-08 10:37:36'),
(2, NULL, '3435', 'abc', '5485', 'Salary Account', 3, '2021-12-08 10:37:36'),
(3, NULL, '545656', 'abc', '2054', 'Expense Account', 3, '2021-12-08 10:37:36');

-- --------------------------------------------------------

--
-- Table structure for table `branch_master`
--

CREATE TABLE `branch_master` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `create_on` datetime DEFAULT current_timestamp(),
  `create_by` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT 1,
  `country` varchar(45) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `branch_Userid` varchar(45) DEFAULT NULL,
  `percentage` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `branch_master`
--

INSERT INTO `branch_master` (`id`, `name`, `status`, `create_on`, `create_by`, `company_id`, `country`, `currency`, `type`, `branch_Userid`, `percentage`) VALUES
(3, 'Branch1', 1, '2021-12-07 15:59:09', 1, 2, 'India', 'INR', 'parent', 'ABC56', '21');

-- --------------------------------------------------------

--
-- Table structure for table `company_master`
--

CREATE TABLE `company_master` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `create_on` datetime DEFAULT current_timestamp(),
  `create_by` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_master`
--

INSERT INTO `company_master` (`id`, `name`, `status`, `create_on`, `create_by`, `type`, `email_id`) VALUES
(2, 'Bhiwadi1', 1, '2021-12-07 13:53:35', NULL, 'asset', 'test@gbtech.in');

-- --------------------------------------------------------

--
-- Table structure for table `currency_conversion_master`
--

CREATE TABLE `currency_conversion_master` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `quarter` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `currency` varchar(45) DEFAULT NULL,
  `rate` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `currency_conversion_master`
--

INSERT INTO `currency_conversion_master` (`id`, `branch_id`, `quarter`, `year`, `country`, `currency`, `rate`, `created_on`, `created_by`, `status`) VALUES
(9, 3, 2, 2022, '2', 'USD', '543', '2021-12-07 18:01:54', '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `excelsheet_master_data`
--

CREATE TABLE `excelsheet_master_data` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` varchar(45) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `year` text DEFAULT NULL,
  `quarter` text DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `approve_status` int(11) DEFAULT 0,
  `template_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `main_account_setup_master`
--

CREATE TABLE `main_account_setup_master` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `main_gl_number` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_by` varchar(45) DEFAULT NULL,
  `created_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_account_setup_master`
--

INSERT INTO `main_account_setup_master` (`id`, `company_id`, `main_gl_number`, `name`, `created_by`, `created_on`) VALUES
(1, 2, '1234', 'TEST', NULL, '2021-12-07 18:11:24'),
(2, 2, '5485', 'Salary Account', NULL, '2021-12-07 19:17:45'),
(3, 2, '2054', 'Expense Account', NULL, '2021-12-07 19:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `table_template_7`
--

CREATE TABLE `table_template_7` (
  `id` int(10) NOT NULL,
  `table_template_7_col_1` text DEFAULT NULL,
  `table_template_7_col_2` text DEFAULT NULL,
  `table_template_7_col_3` text DEFAULT NULL,
  `table_template_7_col_4` text DEFAULT NULL,
  `branch_id` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `year` text DEFAULT NULL,
  `quarter` text DEFAULT NULL,
  `user_id` text DEFAULT NULL,
  `created_by` text DEFAULT NULL,
  `created_date` text DEFAULT NULL,
  `sheet_master_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `table_template_8`
--

CREATE TABLE `table_template_8` (
  `id` int(10) NOT NULL,
  `table_template_8_col_1` text DEFAULT NULL,
  `table_template_8_col_2` text DEFAULT NULL,
  `branch_id` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `year` text DEFAULT NULL,
  `quarter` text DEFAULT NULL,
  `user_id` text DEFAULT NULL,
  `created_by` text DEFAULT NULL,
  `created_date` text DEFAULT NULL,
  `sheet_master_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `table_template_9`
--

CREATE TABLE `table_template_9` (
  `id` int(10) NOT NULL,
  `table_template_9_col_1` text DEFAULT NULL,
  `table_template_9_col_2` text DEFAULT NULL,
  `table_template_9_col_3` text DEFAULT NULL,
  `branch_id` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `year` text DEFAULT NULL,
  `quarter` text DEFAULT NULL,
  `user_id` text DEFAULT NULL,
  `created_by` text DEFAULT NULL,
  `created_date` text DEFAULT NULL,
  `sheet_master_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `table_template_10`
--

CREATE TABLE `table_template_10` (
  `id` int(10) NOT NULL,
  `table_template_10_col_1` text DEFAULT NULL,
  `branch_id` text DEFAULT NULL,
  `company_id` text DEFAULT NULL,
  `year` text DEFAULT NULL,
  `quarter` text DEFAULT NULL,
  `user_id` text DEFAULT NULL,
  `created_by` text DEFAULT NULL,
  `created_date` text DEFAULT NULL,
  `sheet_master_id` int(10) DEFAULT NULL,
  `table_template_10_col_2` text DEFAULT NULL,
  `table_template_10_col_3` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `template_branch_mapping`
--

CREATE TABLE `template_branch_mapping` (
  `id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `template_id` int(10) NOT NULL,
  `status` int(10) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_date` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_date` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `template_column_mapping`
--

CREATE TABLE `template_column_mapping` (
  `id` int(10) NOT NULL,
  `template_id` int(10) NOT NULL,
  `attribute_name` varchar(100) NOT NULL,
  `attribute_type` varchar(100) NOT NULL,
  `attribute_query` varchar(100) NOT NULL,
  `column_name` varchar(100) NOT NULL,
  `sequence` int(10) NOT NULL,
  `table_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template_column_mapping`
--

INSERT INTO `template_column_mapping` (`id`, `template_id`, `attribute_name`, `attribute_type`, `attribute_query`, `column_name`, `sequence`, `table_name`) VALUES
(16, 7, 'Account No', 'numeric', '', 'table_template_7_col_1', 1, 'table_Balance Sheet'),
(17, 7, 'Name', 'text', '', 'table_template_7_col_2', 2, 'table_Balance Sheet'),
(18, 7, 'Amount', 'numeric', '', 'table_template_7_col_3', 3, 'table_Balance Sheet'),
(19, 7, 'Date', 'date', '', 'table_template_7_col_4', 4, 'table_Balance Sheet'),
(20, 8, 'Name', 'text', '', 'table_template_8_col_1', 1, 'table_Electricity Ledgers'),
(21, 8, 'Amount', 'numeric', '', 'table_template_8_col_2', 2, 'table_Electricity Ledgers'),
(22, 9, 'Account No', 'numeric', '', 'table_template_9_col_1', 1, 'table_balance_sheet'),
(23, 9, 'Name', 'text', '', 'table_template_9_col_2', 2, 'table_balance_sheet'),
(24, 9, 'Amount', 'numeric', '', 'table_template_9_col_3', 3, 'table_balance_sheet'),
(25, 10, 'Account No', 'numeric', '', 'table_template_10_col_1', 1, 'table_template_10'),
(26, 10, 'Name', 'text', '', 'table_template_10_col_2', 2, 'table_template_10'),
(27, 10, 'Amount', 'numeric', '', 'table_template_10_col_3', 3, 'table_template_10');

-- --------------------------------------------------------

--
-- Table structure for table `template_master`
--

CREATE TABLE `template_master` (
  `id` int(10) NOT NULL,
  `template_name` varchar(100) NOT NULL,
  `Template_table_name` varchar(100) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_date` varchar(100) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `updated_date` varchar(100) NOT NULL,
  `status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `template_master`
--

INSERT INTO `template_master` (`id`, `template_name`, `Template_table_name`, `branch_id`, `created_by`, `created_date`, `updated_by`, `updated_date`, `status`) VALUES
(7, 'Balance Sheet', 'table_template_7', 1, 1, '2021-12-07 15:16:14', 0, '', 1),
(8, 'Electricity Ledgers', 'table_template_8', 1, 1, '2021-12-07 15:17:44', 0, '', 1),
(9, 'balance_sheet', 'table_template_9', 0, 1, '2021-12-07 15:29:52', 0, '', 1),
(10, 'balance_sheet', 'table_template_10', 0, 1, '2021-12-07 15:30:59', 0, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `upload_financial_data`
--

CREATE TABLE `upload_financial_data` (
  `id` int(10) NOT NULL,
  `gl_ac` int(100) NOT NULL,
  `debit` int(100) NOT NULL,
  `credit` int(100) NOT NULL,
  `detail` text NOT NULL,
  `branch_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_on` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `upload_intra_company_transfer`
--

CREATE TABLE `upload_intra_company_transfer` (
  `id` int(10) NOT NULL,
  `branch_company_id` int(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `amount` int(100) NOT NULL,
  `branch_id` int(10) NOT NULL,
  `company_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `created_by` int(10) NOT NULL,
  `created_on` varchar(100) NOT NULL
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
(1, 'admin', 'admin', '123', 1, NULL, NULL, 0, 1, 1, 1),
(3, 'Bhiwadi', 'test@gbtech.in', '123', 1, NULL, NULL, 2, 1, 2, 1),
(4, 'pooja', 'pooja@gbtech.in', '123', 1, NULL, NULL, 2, 1, 3, 1),
(6, 'Bharat', 'bharat@gmail.com', '123', 1, NULL, NULL, 2, 3, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch_account_setup`
--
ALTER TABLE `branch_account_setup`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `currency_conversion_master`
--
ALTER TABLE `currency_conversion_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `excelsheet_master_data`
--
ALTER TABLE `excelsheet_master_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_account_setup_master`
--
ALTER TABLE `main_account_setup_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_template_7`
--
ALTER TABLE `table_template_7`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_template_8`
--
ALTER TABLE `table_template_8`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_template_9`
--
ALTER TABLE `table_template_9`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `table_template_10`
--
ALTER TABLE `table_template_10`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_branch_mapping`
--
ALTER TABLE `template_branch_mapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_column_mapping`
--
ALTER TABLE `template_column_mapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `template_master`
--
ALTER TABLE `template_master`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_financial_data`
--
ALTER TABLE `upload_financial_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_intra_company_transfer`
--
ALTER TABLE `upload_intra_company_transfer`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `branch_account_setup`
--
ALTER TABLE `branch_account_setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `branch_master`
--
ALTER TABLE `branch_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_master`
--
ALTER TABLE `company_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `currency_conversion_master`
--
ALTER TABLE `currency_conversion_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `excelsheet_master_data`
--
ALTER TABLE `excelsheet_master_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `main_account_setup_master`
--
ALTER TABLE `main_account_setup_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `template_branch_mapping`
--
ALTER TABLE `template_branch_mapping`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template_column_mapping`
--
ALTER TABLE `template_column_mapping`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `template_master`
--
ALTER TABLE `template_master`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `upload_financial_data`
--
ALTER TABLE `upload_financial_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upload_intra_company_transfer`
--
ALTER TABLE `upload_intra_company_transfer`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_master`
--
ALTER TABLE `users_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
