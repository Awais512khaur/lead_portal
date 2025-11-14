-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 03:08 PM
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
(12, 'lead2.csv', 6, 10, 0, '2025-11-13 10:41:25'),
(13, 'lead3.csv', 6, 3, 0, '2025-11-13 17:52:50');

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
(15, 'Hamza', 'hamza@gmail.com', 'Csr', '03312099410', '2025-11-14 13:37:43');

-- --------------------------------------------------------

--
-- Table structure for table `file_data`
--

CREATE TABLE `file_data` (
  `id` int(11) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) DEFAULT NULL,
  `client` varchar(255) DEFAULT NULL,
  `loan_officer` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zip` varchar(255) NOT NULL,
  `State` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Address2` varchar(255) DEFAULT NULL,
  `zip2` varchar(255) NOT NULL,
  `State2` varchar(255) DEFAULT NULL,
  `City2` varchar(255) DEFAULT NULL,
  `total_loan` varchar(255) DEFAULT NULL,
  `interest_rate` varchar(255) DEFAULT NULL,
  `rate_type` varchar(255) DEFAULT NULL,
  `Loan_type` varchar(255) DEFAULT NULL,
  `house_type` varchar(255) DEFAULT NULL,
  `property_usage` varchar(255) DEFAULT NULL,
  `interest2` varchar(255) NOT NULL,
  `rate_type2` varchar(255) NOT NULL,
  `credit_card_dept` varchar(255) NOT NULL,
  `late_payment` varchar(255) NOT NULL,
  `cashout` varchar(255) NOT NULL,
  `foreclosure` varchar(255) NOT NULL,
  `Bankrupcy` varchar(255) NOT NULL,
  `employement_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file_data`
--

INSERT INTO `file_data` (`id`, `contact_number`, `first_name`, `last_name`, `phone`, `phone2`, `client`, `loan_officer`, `Address`, `Zip`, `State`, `City`, `Address2`, `zip2`, `State2`, `City2`, `total_loan`, `interest_rate`, `rate_type`, `Loan_type`, `house_type`, `property_usage`, `interest2`, `rate_type2`, `credit_card_dept`, `late_payment`, `cashout`, `foreclosure`, `Bankrupcy`, `employement_status`, `created_at`) VALUES
(46, '03004561234', 'John', ' Smith', '2147483647', '123456', 'Mortgage', 'Officer A', '123 Main Street', '', 'Punjab', 'Lahore', '123 Main Street', '', 'Punjab', 'Rwalpindi', '2500000', '8.5', 'Fixed', 'Refinance', 'Single Family', 'Primary Residence', '', '', '', '', '', '', '', 'Full-time', '2025-11-13 18:41:25'),
(47, '03007895612', ' Smith', 'Khan', '03007895612', '123456789', 'DAA', 'Officer B', '45 Garden Avenue', '', 'Sindh', 'Karachi', '123 Main Street', '', 'Punjab', 'Rwalpindi', '3500000', '7.9', 'Adjustable', 'Purchase', 'Condo', 'Investment', '', '', '', '', '', '', '', 'Self-employed', '2025-11-13 18:41:25'),
(48, '03006784561', 'Ali', 'Raza', '03006784561', '123456789', 'D1A', 'Officer C', '67 Canal Road', '', 'KPK', 'Peshawar', '123 Main Street', '', 'Punjab', 'Rwalpindi', '1800000', '9.2', 'Fixed', 'Home Equity', 'Townhouse', 'Primary Residence', '', '', '', '', '', '', '', 'Part-time', '2025-11-13 18:41:25'),
(49, '03003457891', 'Ayesha', 'Malik', '03003457891', '123456789', 'Mortgage', 'Officer D', '89 Shahrah-e-Faisal', '', 'Sindh', 'Karachi', '89 Shahrah-e-Faisal', '', 'Sindh', 'Karachi', '4200000', '10.1', 'Adjustable', 'Refinance', 'Single Family', 'VACATION HOME', '', '', '', '', '', '', '', 'Full-time', '2025-11-13 18:41:25'),
(50, '03007651238', 'David', 'Jones', '03007651238', '123456789', 'DAA', 'Officer E', '22 Gulberg Road', '', 'Punjab', 'Lahore', '89 Shahrah-e-Faisal', '', 'Sindh', 'Karachi', '2750000', '8.3', 'Fixed', 'Purchase', 'Condo', 'Primary Residence', '', '', '', '', '', '', '', 'Full-time', '2025-11-13 18:41:25'),
(51, '03009873456', 'Fatima', 'Noor', '03009873456', '123456789', 'D1A', 'Officer F', '56 University Road', '', 'Balochistan', 'Quetta', '89 Shahrah-e-Faisal', '', 'Sindh', 'Karachi', '3100000', '7.5', 'Fixed', 'Refinance', 'Single Family', 'Investment', '', '', '', '', '', '', '', 'Self-employed', '2025-11-13 18:41:25'),
(52, '03008974523', 'Micheal', 'Lee', '03008974523', '123456789', 'Mortgage', 'Officer G', '34 Liberty Market', '', 'ICT', 'Islamabad', '89 Shahrah-e-Faisal', '', 'Sindh', 'Karachi', '6000000', '9.7', 'Adjustable', 'Purchase', 'Townhouse', 'Primary Residence', '', '', '', '', '', '', '', 'Full-time', '2025-11-13 18:41:25'),
(53, '03005551234', 'Komal', 'Abbas', '03005551234', '123456789', 'DAA', 'Officer H', '76 Canal Bank', '', 'Punjab', 'Lahore', '89 Shahrah-e-Faisal', '', 'Sindh', 'Karachi', '2300000', '8.1', 'Fixed', 'Home Equity', 'Condo', 'Investment', '', '', '', '', '', '', '', 'Part-time', '2025-11-13 18:41:25'),
(54, '03002227890', 'Rizwan', 'Ali', '03002227890', '123456789', 'D1A', 'Officer I', '90 Clifton Block 5', '', 'Sindh', 'Karachi', '89 Shahrah-e-Faisal', '', 'Sindh', 'Karachi', '3900000', '9', 'Adjustable', 'Refinance', 'Single Family', 'Primary Residence', '', '', '', '', '', '', '', 'Full-time', '2025-11-13 18:41:25'),
(55, '03007778888', 'Emily', 'Davis', '03007778888', '123456789', 'Mortgage', 'Officer J', '12 I-8 Markaz', '', 'ICT', 'Islamabad', '89 Shahrah-e-Faisal', '', 'Sindh', 'Karachi', '4800000', '8.9', 'Fixed', 'Purchase', 'Condo', 'Primary Residence', '', '', '', '', '', '', '', 'Self-employed', '2025-11-13 18:41:25'),
(56, '1234567890', 'John', 'Doe', '5551112222', '5553334444', 'ClientA', 'Officer1', '123 Main St', '10001', 'NY', 'New York', '456 Elm St', '10002', 'NY', 'Brooklyn', '250000', '5.5', 'Fixed', 'Home Loan', 'Detached', 'Residential', '6', '0', '1000', '0', '5000', '0', '0', 'Employed', '2025-11-14 01:52:50'),
(57, '2345678901', 'Jane', 'Smith', '5552223333', '5554445555', 'ClientB', 'Officer2', '789 Oak St', '90001', 'CA', 'Los Angeles', '101 Pine St', '90002', 'CA', 'San Diego', '150000', '4.8', 'Fixed', 'Personal Loan', 'Condo', 'Residential', '5', '0', '2000', '100', '0', '0', '0', 'Self-Employed', '2025-11-14 01:52:50'),
(58, '3456789012', 'Mark', 'Johnson', '5553334444', '5555556666', 'ClientC', 'Officer3', '321 Maple Ave', '60601', 'IL', 'Chicago', '654 Cedar Ave', '60602', 'IL', 'Evanston', '300000', '6.2', 'Variable', 'Mortgage', 'Townhouse', 'Residential', '6.5', '0', '1500', '50', '10000', '0', '0', 'Employed', '2025-11-14 01:52:50');

-- --------------------------------------------------------

--
-- Table structure for table `lead_data`
--

CREATE TABLE `lead_data` (
  `id` int(11) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `phone2` varchar(255) NOT NULL,
  `client` varchar(255) DEFAULT NULL,
  `loan_officer` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Zip` varchar(255) NOT NULL,
  `State` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `Address2` varchar(255) DEFAULT NULL,
  `Zip2` varchar(255) NOT NULL,
  `State2` varchar(255) DEFAULT NULL,
  `City2` varchar(255) DEFAULT NULL,
  `total_loan` varchar(255) DEFAULT NULL,
  `interest_rate` varchar(255) DEFAULT NULL,
  `rate_type` varchar(255) DEFAULT NULL,
  `loan_type` varchar(255) DEFAULT NULL,
  `house_type` varchar(255) DEFAULT NULL,
  `property_usage` varchar(255) DEFAULT NULL,
  `interest2` varchar(255) NOT NULL,
  `rate_type2` varchar(255) NOT NULL,
  `credit_card_dept` varchar(255) NOT NULL,
  `late_payment` varchar(255) NOT NULL,
  `cashout` varchar(255) NOT NULL,
  `foreclosure` varchar(255) NOT NULL,
  `Bankrupcy` varchar(255) NOT NULL,
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

INSERT INTO `lead_data` (`id`, `contact_number`, `first_name`, `last_name`, `phone`, `phone2`, `client`, `loan_officer`, `Address`, `Zip`, `State`, `City`, `Address2`, `Zip2`, `State2`, `City2`, `total_loan`, `interest_rate`, `rate_type`, `loan_type`, `house_type`, `property_usage`, `interest2`, `rate_type2`, `credit_card_dept`, `late_payment`, `cashout`, `foreclosure`, `Bankrupcy`, `employement_status`, `comments`, `submitted_by`, `sale_date`, `created_at`) VALUES
(18, '03004561234', 'John', ' Smith', '2147483647', '', 'Mortgage', 'Officer A', '123 Main Street', '', 'Punjab', 'Karachi', '123 Main Street', '', 'Punjab', 'Karachi', '2500000', '9', 'Fixed', 'Refinance', 'Single', 'Primary Usage', '', '', '', '', '', '', '', 'Employed', '', 8, '2025-11-13 23:40:50', '2025-11-13 23:40:50'),
(19, '03007895612', 'Smith', 'Khan', '03007895612', '123456789', 'DAA', 'Officer B', '45 Garden Avenue', '', 'Sindh', 'Karachi', '123 Main Street', '', 'Punjab', '0', '3500000', '8', 'Adjustable', 'Purchase', 'Single', 'Primary Usage', '', '', '', '', '', '', '', 'Employed', 'Done', 8, '2025-11-14 00:13:53', '2025-11-14 00:13:53'),
(20, '3456789012', 'Mark', 'Johnson', '5553334444', '5555556666', 'ClientC', 'Officer3', '321 Maple Ave', '60601', 'IL', 'Chicago', '654 Cedar Ave', '60602', 'IL', 'Evanston', '300000', '6.2', 'Variable', 'Mortgage', 'Townhouse', 'Residential', '6.5', '0', '1500', '50', '10000', '0', '0', 'Employed', '', 8, '2025-11-14 13:18:40', '2025-11-14 13:18:40'),
(21, '2345678901', 'Jane', 'Smith', '5552223333', '5554445555', 'ClientB', 'Officer2', '789 Oak St', '90001', 'CA', 'Los Angeles', '101 Pine St', '90002', 'CA', 'San Diego', '150000', '4.8', 'Fixed', 'Personal Loan', 'Condo', 'Residential', '5', '0', '2000', '100', '0', '0', '0', 'Self-Employed', '', 8, '2025-11-14 13:20:44', '2025-11-14 13:20:44'),
(22, '03312099410', 'Muhmmad', 'Awais', '03312099410', '03312099410', 'Mortgage', 'Awais', 'street 5', '43381', 'CA', 'Khaur city', NULL, '', NULL, NULL, '5600', '56', 'Variable', 'Debt', 'ffsdfsf', '3434', '', '', '', '', '', '', '', 'employeed', 'done', 5, '2025-05-14 02:00:00', '2025-11-14 14:02:58');

-- --------------------------------------------------------

--
-- Table structure for table `lead_disposition`
--

CREATE TABLE `lead_disposition` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `disposition` varchar(255) DEFAULT 'Transfer',
  `csr_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lead_disposition`
--

INSERT INTO `lead_disposition` (`id`, `lead_id`, `disposition`, `csr_id`, `created_at`) VALUES
(15, 18, 'DNC', 8, '2025-11-13 23:40:50'),
(16, 19, 'Live Transfer', 8, '2025-11-14 00:13:53'),
(17, 20, 'Live Transfer', 8, '2025-11-14 13:18:41'),
(18, 21, 'Live Transfer', 8, '2025-11-14 13:20:44');

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
(5, 'Admin', '$2y$10$A5X1CVMbXdWum18HbDeWvOObAAJyErPISHf0cBn/4QokWh2DKi1ja', 2, 1, 0, '2025-11-06 15:04:02'),
(6, 'Manager', '$2y$10$A5X1CVMbXdWum18HbDeWvOObAAJyErPISHf0cBn/4QokWh2DKi1ja', 4, 2, 0, '2025-11-06 18:58:32'),
(8, 'CSR', '$2y$10$A5X1CVMbXdWum18HbDeWvOObAAJyErPISHf0cBn/4QokWh2DKi1ja', 6, 4, 0, '2025-11-06 19:06:43'),
(9, 'Team', '$2y$10$A5X1CVMbXdWum18HbDeWvOObAAJyErPISHf0cBn/4QokWh2DKi1ja', 7, 3, 0, '2025-11-06 19:52:02'),
(17, 'hamza', '$2y$10$ZrZR6B4qd9QN6DblgEshHOV.rOLuquzvNG8I0EDGQT6T.3EfR09Yi', 15, 4, 0, '2025-11-14 13:37:44');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `csv_upload_log`
--
ALTER TABLE `csv_upload_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employee_data`
--
ALTER TABLE `employee_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `file_data`
--
ALTER TABLE `file_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `lead_data`
--
ALTER TABLE `lead_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `lead_disposition`
--
ALTER TABLE `lead_disposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
