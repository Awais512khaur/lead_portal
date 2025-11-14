-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 08:27 PM
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
-- Database: `lead_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `csr_team`
--

CREATE TABLE `csr_team` (
  `id` int(11) NOT NULL,
  `csr_id` int(11) NOT NULL,
  `team_lead_id` int(11) NOT NULL,
  `assigned_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `csr_team`
--

INSERT INTO `csr_team` (`id`, `csr_id`, `team_lead_id`, `assigned_at`) VALUES
(1, 8, 9, '2025-11-11 15:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `csv_upload_log`
--

CREATE TABLE `csv_upload_log` (
  `id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `inserted_rows` int(11) NOT NULL DEFAULT 0,
  `skipped_rows` int(11) NOT NULL DEFAULT 0,
  `uploaded_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `csv_upload_log`
--

INSERT INTO `csv_upload_log` (`id`, `file_name`, `uploaded_by`, `inserted_rows`, `skipped_rows`, `uploaded_at`) VALUES
(1, 'lead1.csv', 6, 4, 0, '2025-11-11 15:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `employee_data`
--

CREATE TABLE `employee_data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_data`
--

INSERT INTO `employee_data` (`id`, `name`, `email`, `designation`, `phone`, `created_at`) VALUES
(2, 'Admin ', 'admin@gmail.com', 'Administrator', '', '2025-11-06 14:59:17'),
(4, 'Manager', 'manager@gmail.com', 'Manager', '123', '2025-11-06 18:57:44'),
(6, 'CSR', 'csr@gmail.com', 'CSR', '345', '2025-11-06 19:06:14'),
(7, 'Team', 'team@gmail.com', 'Teamlead', '567', '2025-11-06 19:51:28'),
(8, 'CSR1', 'csr1@gmail.com', 'CSR', '567', '2025-11-07 18:45:37'),
(9, 'CSR2', 'csr2@gmail.com', 'CSR', NULL, '2025-11-07 22:19:28'),
(11, 'CSR3', 'csr3@gmail.com', 'CSR', NULL, '2025-11-07 22:26:31'),
(12, 'CSR4', 'csr4@gmail.com', 'CSR', '3312099410', '2025-11-07 22:29:53'),
(13, 'CSR2', 'csr2@gmail.com', 'CSR', '3312099410', '2025-11-11 17:55:26');

-- --------------------------------------------------------

--
-- Table structure for table `file_data`
--

CREATE TABLE `file_data` (
  `id` int(11) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_data`
--

INSERT INTO `file_data` (`id`, `contact_number`, `name`, `client`, `created_at`) VALUES
(1, '9876543210', 'John Doe', 'ABC Finance', '2025-11-07 18:18:12'),
(2, '8765432109', 'Jane Smith', 'XYZ Bank', '2025-11-07 18:18:12'),
(3, '7654321098', 'Robert Brown', 'Quick Loans', '2025-11-07 18:18:12'),
(4, '6543210987', 'Emily Davis', 'FinTrust', '2025-11-07 18:18:12'),
(5, '5432109876', 'Michael Johnson', 'LoanCorp', '2025-11-07 18:18:12'),
(14, '+923001234567', 'Ali Khan', 'ABC Corp', '2025-11-11 17:46:09'),
(15, '+923112345678', 'Sara Ahmed', 'XYZ Ltd', '2025-11-11 17:46:09'),
(16, '+923212345678', 'Omar Farooq', 'GlobalTech', '2025-11-11 17:46:09'),
(17, '+923322345678', 'Nadia Hussain', 'NextGen', '2025-11-11 17:46:09'),
(18, '+923312099410', 'Ali Khan', 'ABC Corp', '2025-11-11 23:58:28'),
(19, '+92332099410', 'Sara Ahmed', 'XYZ Ltd', '2025-11-11 23:58:28'),
(20, '+923332099410', 'Omar Farooq', 'GlobalTech', '2025-11-11 23:58:28'),
(21, '+923342099410', 'Nadia Hussain', 'NextGen', '2025-11-11 23:58:28');

-- --------------------------------------------------------

--
-- Table structure for table `lead_data`
--

CREATE TABLE `lead_data` (
  `id` int(11) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `loan_officer` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `total_loan` int(255) DEFAULT NULL,
  `interest_rate` int(255) DEFAULT NULL,
  `rate_type` varchar(255) DEFAULT NULL,
  `loan_type` varchar(255) DEFAULT NULL,
  `house_type` varchar(255) DEFAULT NULL,
  `property_usage` varchar(255) DEFAULT NULL,
  `employement_status` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `submitted_by` int(11) DEFAULT NULL,
  `sale_date` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_date` date GENERATED ALWAYS AS (cast(`created_at` as date)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_data`
--

INSERT INTO `lead_data` (`id`, `contact_number`, `name`, `client`, `loan_officer`, `Address`, `State`, `City`, `total_loan`, `interest_rate`, `rate_type`, `loan_type`, `house_type`, `property_usage`, `employement_status`, `comments`, `submitted_by`, `sale_date`, `created_at`) VALUES
(7, '9876543210', 'John Doe', 'ABC Finance', 'Awais', 'Rawalpindi', 'punjab', 'Rawalpindi', 34, 3, '1', '3', '1', '1', '2', 'fgdgfddfgfgdgd', 8, '2025-11-12 17:54:05', '2025-11-12 17:54:05'),
(8, '6543210987', 'Emily Davis', 'FinTrust', 'Awais', 'Rawalpindi', 'punjab', 'Rawalpindi', 300, 300, 'Varibale', 'Mortgage', 'Joint', 'Secondary Usage', 'Un Employed', 'Done', 8, '2025-11-12 17:57:22', '2025-11-12 17:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `lead_disposition`
--

CREATE TABLE `lead_disposition` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `disposition` varchar(255) DEFAULT 'Transfer',
  `csr_id` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_disposition`
--

INSERT INTO `lead_disposition` (`id`, `lead_id`, `disposition`, `csr_id`, `notes`, `created_at`) VALUES
(6, 7, 'Transfer', 8, NULL, '2025-11-12 17:54:05'),
(7, 8, 'Transfer', 8, NULL, '2025-11-12 17:57:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `access_level` tinyint(4) NOT NULL DEFAULT 4,
  `is_blocked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `employee_id`, `access_level`, `is_blocked`, `created_at`) VALUES
(5, 'Admin', 'pass123', 2, 1, 0, '2025-11-06 15:04:02'),
(6, 'Manager', 'pass123', 4, 2, 0, '2025-11-06 18:58:32'),
(8, 'CSR', 'pass123', 6, 4, 0, '2025-11-06 19:06:43'),
(9, 'Team', 'pass123', 7, 3, 0, '2025-11-06 19:52:02'),
(10, 'CSR1', 'pass123', 8, 4, 0, '2025-11-07 18:46:08'),
(13, 'CSR3', 'pass123', 11, 4, 0, '2025-11-07 22:26:31'),
(14, 'CSR4', 'pass123', 12, 4, 0, '2025-11-07 22:29:53'),
(15, 'CSR2', 'pass123', 13, 4, 0, '2025-11-11 17:55:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `csr_team`
--
ALTER TABLE `csr_team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `csr_id` (`csr_id`),
  ADD KEY `team_lead_id` (`team_lead_id`);

--
-- Indexes for table `csv_upload_log`
--
ALTER TABLE `csv_upload_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_data`
--
ALTER TABLE `employee_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `file_data`
--
ALTER TABLE `file_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `contact_number` (`contact_number`);

--
-- Indexes for table `lead_data`
--
ALTER TABLE `lead_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_contact_created` (`contact_number`,`created_date`);

--
-- Indexes for table `lead_disposition`
--
ALTER TABLE `lead_disposition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `disposition` (`disposition`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `csr_team`
--
ALTER TABLE `csr_team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `csv_upload_log`
--
ALTER TABLE `csv_upload_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employee_data`
--
ALTER TABLE `employee_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `file_data`
--
ALTER TABLE `file_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `lead_data`
--
ALTER TABLE `lead_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lead_disposition`
--
ALTER TABLE `lead_disposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `csr_team`
--
ALTER TABLE `csr_team`
  ADD CONSTRAINT `csr_team_ibfk_1` FOREIGN KEY (`csr_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `csr_team_ibfk_2` FOREIGN KEY (`team_lead_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lead_disposition`
--
ALTER TABLE `lead_disposition`
  ADD CONSTRAINT `lead_disposition_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `lead_data` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employee_data` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
