-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2023 at 05:18 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
--

CREATE TABLE `allowed_views` (
  `emp_code` varchar(15) DEFAULT NULL,
  `view_name` text DEFAULT NULL,
  `is_allowed` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allowed_views`
--

INSERT INTO `allowed_views` (`emp_code`, `view_name`, `is_allowed`) VALUES
('E-2', 'Staff ', 1),
('E-2', 'Invoice', 1),
('E-2', 'Ward', 1),
('E-2', 'Designation', 1);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `contactinfo` varchar(13) NOT NULL,
  `cnic` varchar(15) NOT NULL,
  `appointment_date` varchar(15) NOT NULL,
  `appointment_time` varchar(12) NOT NULL,
  `stats` tinyint(4) NOT NULL,
  `consult_to` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `name`, `age`, `contactinfo`, `cnic`, `appointment_date`, `appointment_time`, `stats`, `consult_to`) VALUES
(1, 'DANISH KHAN', 40, '0321-2538745', '41302-9202762-5', '2023-01-24', '09:42', 2, 'E-3');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `description`, `created_at`, `created_by`, `updated_by`, `updated_at`) VALUES
(1, 'Medical Department', '', NULL, NULL, NULL, NULL),
(2, 'IT Department', '', NULL, NULL, NULL, NULL),
(3, 'Surgical Department', '', NULL, NULL, NULL, NULL),
(4, 'Administration', 'Administration', NULL, NULL, NULL, NULL),
(5, 'ANSTHESIA', '', '2023-01-28 17:37:01', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `name`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'MEDICAL OFFICER', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(2, 'DOCTOR', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(3, 'SPECIALIST', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(4, 'WARD BOY', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(5, 'RECEPTIONIST', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(6, 'MANAGER', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(7, 'DEPUTY DIRECTOR', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(8, 'ACCOUNTANT', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(9, 'CLERK', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(10, 'PEON', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(11, 'SECURITY GUARD', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(12, 'NURSE', '', NULL, '2023-01-17 20:42:00', NULL, NULL),
(13, 'SUPER ADMIN', '', NULL, '2023-01-17 20:42:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `emp_code` varchar(12) DEFAULT NULL,
  `specialization` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `name`, `emp_code`, `specialization`) VALUES
(1, 'Rehman Janweri', 'E-3 ', 'Dermatologist');

-- --------------------------------------------------------

--
-- Table structure for table `dosage`
--

CREATE TABLE `dosage` (
  `id` int(11) NOT NULL,
  `mrno` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` tinyint(4) NOT NULL,
  `created_at` varchar(20) NOT NULL,
  `created_by` text DEFAULT NULL,
  `is_issued` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosage`
--

INSERT INTO `dosage` (`id`, `mrno`, `name`, `age`, `created_at`, `created_by`, `is_issued`) VALUES
(1, 'MR-1', 'Majnu', 20, '2023-01-16 03:24:09', NULL, 1),
(2, 'MR-5', 'Juniad', 20, '2023-01-16 21:32:01', NULL, 1),
(3, 'MR-5', 'Juniad', 20, '2023-01-17 08:26:20', NULL, 1),
(4, 'MR-2', 'Zafar Khan', 32, '2023-01-22 18:14:44', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dosage_master`
--

CREATE TABLE `dosage_master` (
  `dosage_id` int(11) DEFAULT NULL,
  `item` varchar(100) NOT NULL,
  `dosage` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosage_master`
--

INSERT INTO `dosage_master` (`dosage_id`, `item`, `dosage`) VALUES
(4, 'Brufen', 2),
(4, 'Panadol', 4);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_master`
--

CREATE TABLE `invoice_master` (
  `invoice_id` varchar(15) DEFAULT NULL,
  `item` varchar(50) DEFAULT NULL,
  `quantity` tinyint(4) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_master`
--

INSERT INTO `invoice_master` (`invoice_id`, `item`, `quantity`, `price`, `total`) VALUES
('INV-1', 'Surgery', 1, 50000, 50000),
('INV-1', '6 Days Rent Fee', 6, 550, 3300),
('INV-1', 'MED/Brufen', 2, 100, 200),
('INV-1', 'MED/Panadol', 4, 25, 100);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `strength` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `generic` text NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `strength`, `description`, `generic`, `created_by`, `created_at`, `updated_by`, `updated_at`, `unit_price`) VALUES
(1, 'Brufen', '50mg', '', 'Syrup', NULL, '2023-01-17 19:18:18', NULL, NULL, 100),
(2, 'Panadol', '5mm', '', 'Medical', NULL, '2023-01-22 17:21:48', NULL, NULL, 25),
(3, 'Surcos', '10mg', 'This is a Syrup For Cough..', 'Syrup', NULL, NULL, NULL, NULL, 120);

-- --------------------------------------------------------

--
-- Table structure for table `lab_test`
--

CREATE TABLE `lab_test` (
  `mrno` varchar(12) NOT NULL,
  `name` text DEFAULT NULL,
  `lab_test` mediumtext DEFAULT NULL,
  `results` varchar(100) DEFAULT NULL,
  `doctor_code` varchar(12) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lab_test`
--

INSERT INTO `lab_test` (`mrno`, `name`, `lab_test`, `results`, `doctor_code`, `created_at`, `id`) VALUES
('MR-1', 'Cullen Nieves', 'HOMOCYSTEINE', '63d62dc92ffbc.pdf', 'E-3', '2023-01-29 08:26:49', 1),
('MR-1', 'Cullen Nieves', 'ULTRASOUND', '63d62dc93eb2d.pdf', 'E-3', '2023-01-29 08:26:49', 2),
('MR-3', 'Saba Khan', 'TESTOSTERONE', '63d62dc94138c.pdf', 'E-3', '2023-01-29 08:26:49', 3),
('MR-3', 'Saba Khan', 'HOMOCYSTEINE', NULL, 'E-3', '2023-01-23 01:59:22', 4),
('MR-3', 'Saba Khan', 'ULTRASOUND', NULL, 'E-3', '2023-01-23 01:59:22', 5);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `contactinfo` varchar(11) DEFAULT NULL,
  `cnic` varchar(13) DEFAULT NULL,
  `mrno` varchar(15) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `consult_to` varchar(21) DEFAULT NULL,
  `flag` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `name`, `age`, `contactinfo`, `cnic`, `mrno`, `gender`, `created_by`, `created_at`, `updated_by`, `updated_at`, `consult_to`, `flag`) VALUES
(1, 'Cullen Nieves', 54, '2978574', '8876587', 'MR-1', 'Male', 'E-4', NULL, NULL, '2023-01-22 09:50:25', 'E-3 ', 1),
(2, 'Zafar Khan', 32, '03122716259', '413029201275', 'MR-2', 'Male', 'E-1', NULL, NULL, '2023-01-22 17:13:58', 'E-3 ', 1),
(3, 'Saba Khan', 28, '', '4130292827543', 'MR-3', 'Female', 'E-1', NULL, NULL, '2023-01-23 02:07:48', 'E-3 ', 1),
(4, 'Shoshana Freeman', 15, '94', '10', 'MR-4', 'Female', 'E-1', NULL, NULL, '2023-01-29 08:32:45', '', 1),
(5, 'Saima Khan', 25, '03127265277', '4130292018264', 'MR-5', 'Female', 'E-1', NULL, NULL, '2023-01-24 06:29:45', 'E-3 ', 0),
(6,'Test Patient Name',40,'03127265218','4130292826109','MR-6','Male','E-1',NULL,NULL,'2023-01-24 08:00:45','E-3',0);

-- --------------------------------------------------------

--
-- Table structure for table `patient_invoice`
--

CREATE TABLE `patient_invoice` (
  `id` int(11) NOT NULL,
  `mrno` varchar(15) NOT NULL,
  `total_bill` int(11) DEFAULT NULL,
  `amount_recieving` int(11) DEFAULT NULL,
  `payment_type` tinyint(4) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `invoice_id` varchar(15) DEFAULT NULL,
  `amount_remaining` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_invoice`
--

INSERT INTO `patient_invoice` (`id`, `mrno`, `total_bill`, `amount_recieving`, `payment_type`, `invoice_date`, `invoice_id`, `amount_remaining`) VALUES
(1, 'MR-2', 53600, 53600, 2, '2023-01-22', 'INV-1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient_outcome`
--

CREATE TABLE `patient_outcome` (
  `mrno` varchar(15) NOT NULL,
  `outcome` varchar(100) NOT NULL,
  `outcome_date` date NOT NULL,
  `final_notes` varchar(150) DEFAULT NULL,
  `others` varchar(150) DEFAULT NULL,
  `submit_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `submit_by` varchar(15) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `updated_by` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_outcome`
--

INSERT INTO `patient_outcome` (`mrno`, `outcome`, `outcome_date`, `final_notes`, `others`, `submit_at`, `submit_by`, `name`, `updated_by`) VALUES
('MR-2', 'Sent Back to Ward', '2023-01-21', '', NULL, '2023-01-22 17:15:14', 'E-1', 'Zafar Khan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_recieving`
--

CREATE TABLE `patient_recieving` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `attendant_name` varchar(100) NOT NULL,
  `attendant_contactinfo` varchar(12) NOT NULL,
  `attendant_cnic` varchar(15) NOT NULL,
  `ward` varchar(50) DEFAULT NULL,
  `is_admitted` tinyint(4) DEFAULT NULL,
  `mrno` varchar(15) NOT NULL,
  `bedno` mediumint(9) DEFAULT NULL,
  `_date` date DEFAULT NULL,
  `submit_by` varchar(15) DEFAULT NULL,
  `update_by` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_recieving`
--

INSERT INTO `patient_recieving` (`id`, `name`, `age`, `gender`, `attendant_name`, `attendant_contactinfo`, `attendant_cnic`, `ward`, `is_admitted`, `mrno`, `bedno`, `_date`, `submit_by`, `update_by`) VALUES
(1, 'Zafar Khan', 32, 'Male', 'Shahmeer Shaikh', '0312-8272544', '41302-9201295-3', 'MEDICAL', 1, 'MR-2', 20, NULL, 'E-1', NULL),
(2, 'Shoshana Freeman', 15, 'Male', 'Mr. Griffin Updated', '0328-2726253', '41302-9282726-4', 'CARDIO', 1, 'MR-4', 6, NULL, 'E-1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `mrno` varchar(15) NOT NULL,
  `item` text DEFAULT NULL,
  `med_time` varchar(6) DEFAULT NULL,
  `days` tinyint(4) DEFAULT NULL,
  `doctor` varchar(13) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`mrno`, `item`, `med_time`, `days`, `doctor`, `created_at`) VALUES
('MR-1', 'Brufen', '2-2-2', 5, 'E-3', '2023-01-22 09:50:25'),
('MR-1', 'Panadol', '1-3-0', 3, 'E-3', '2023-01-22 09:50:25'),
('MR-3', 'Panadol', '2-2-1', 3, 'E-3', '2023-01-23 02:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `emp_code` varchar(12) NOT NULL,
  `starting_time` varchar(12) NOT NULL,
  `ending_time` varchar(12) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`emp_code`, `starting_time`, `ending_time`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
('E-1', '12:00', '18:00', NULL, NULL, NULL, NULL),
('E-3', '20:00', '03:00', NULL, NULL, NULL, NULL),
('E-4', '12:00', '20:00', NULL, NULL, NULL, NULL),
('E-8', '16:00', '00:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(55) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `fname` varchar(55) DEFAULT NULL,
  `email` varchar(55) NOT NULL,
  `address` mediumtext DEFAULT NULL,
  `contactinfo` varchar(12) NOT NULL,
  `cnic` varchar(15) NOT NULL,
  `emp_code` varchar(12) DEFAULT NULL,
  `stats` tinyint(4) DEFAULT NULL,
  `pasword` text DEFAULT NULL,
  `gender` varchar(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `age`, `fname`, `email`, `address`, `contactinfo`, `cnic`, `emp_code`, `stats`, `pasword`, `gender`, `created_at`, `created_by`, `updated_by`, `updated_at`) VALUES
(1, 'Muhammad Bilal Khan', 22, 'Asif', 'bilakhan22@gmail.com', 'This is a Permenant Address..', '03163075030', '4130292918753', 'E-1', 1, 'bilal1234', 'Male', '2023-01-17 11:07:32', 'E-1', NULL, '2023-01-17 11:07:49'),
(2, 'Raza Jaffri', 23, 'Rajat Jaffri', 'raza@mail.com', 'This is my current address', '03127187266', '4130292019285', 'E-2', 1, 'raza1234', 'Male', NULL, NULL, NULL, '2023-01-23 20:24:15'),
(3, 'Rehman Janweri', 23, 'Muneer Janweri', 'rehman@gmail.com', 'Al - Rahim Shopping Center Flat No:39 Phase II Near Tilak Chari Saddar HYD', '03122726155', '4130292012985', 'E-3', 1, 'Pa$$w0rd!', 'Male', NULL, NULL, NULL, '2023-01-17 18:57:34'),
(4, 'Ali', 24, 'Zulfiqar', 'zulfiqar23@gmail.com', 'Al - Rahim Shopping Center Flat No:39 Phase II Near Tilak Chari Saddar HYD', '03129012855', '4130210297563', 'E-4', 1, 'abc12345', 'Male', NULL, NULL, NULL, '2023-01-21 06:01:25'),
(5, 'Zubair Shaikh', 24, 'Anwar Shaikh', 'zubari223@gmail.com', 'Al - Rahim Shopping Center Flat No:39 Phase II Near Tilak Chari Saddar HYD', '03121029188', '4130291087153', 'E-5', 1, NULL, 'Male', NULL, NULL, NULL, '2023-01-17 11:24:17'),
(6, 'Baneen', 18, 'Ali', 'baneet2@gmail.com', 'Al - Rahim Shopping Center Flat No:39 Phase II Near Tilak Chari Saddar HYD', '03128751399', '4130291087512', 'E-6', 1, NULL, 'Female', NULL, NULL, NULL, '2023-01-17 11:29:24'),
(7, 'Junaid Khan', 21, 'Shabir Khan', 'junaid13@gmail.com', 'Al - Rahim Shopping Center Flat No:39 Phase II Near Tilak Chari Saddar HYD', '03128177726', '4130292018275', 'E-7', 1, NULL, 'Male', NULL, NULL, NULL, '2023-01-17 11:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `staff_roles`
--

CREATE TABLE `staff_roles` (
  `emp_code` varchar(12) NOT NULL,
  `department` text DEFAULT NULL,
  `designation` text DEFAULT NULL,
  `ward` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_roles`
--

INSERT INTO `staff_roles` (`emp_code`, `department`, `designation`, `ward`) VALUES
('E-1', 'IT', 'SUPER ADMIN', 'CARDIO'),
('E-2', 'Medical', 'Medical', 'MEDICAL'),
('E-3', 'Medical', 'Doctor', 'MEDICAL'),
('E-4', 'Medical', 'MEDICAL', 'SURGICAL'),
('E-5', 'Surgical', 'Doctor', 'SURGICAL'),
('E-6', 'Medical', 'Doctor', 'MEDICAL'),
('E-7', 'IT', 'Clerk', 'MEDICAL'),
('E-8', 'ANSTHESIA', 'SPECIALIST', 'CARDIO');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`id`, `name`, `description`) VALUES
(1, 'ECG', ''),
(2, 'ULTRASOUND', ''),
(3, 'HEMOGLOBIN A1C', ''),
(4, 'HOMOCYSTEINE', ''),
(5, 'TESTOSTERONE ', ''),
(6, 'MRI', ''),
(7, 'PET SCANS', ''),
(8, 'PATHOLOGY TEST:', ''),
(9, 'X-RAY', '');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `id` int(11) NOT NULL,
  `view_name` varchar(100) DEFAULT NULL,
  `redirect_to` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`id`, `view_name`, `redirect_to`) VALUES
(1, 'Patients', 'ListPatients.php'),
(2, 'Patient Recieving', 'PatientRecieving.php'),
(3, 'Patient Outcome', 'PatientOutcome.php'),
(4, 'Designation', 'ListDesignations.php'),
(5, 'Items', 'ListItems.php'),
(6, 'Department', 'ListDepartments.php'),
(7, 'Staff ', 'ListStaffs.php'),
(8, 'Invoice', 'InvoiceList.php'),
(9, 'Lab Test', 'lab_test.php'),
(10, 'Ward', 'ListWards.php');

-- --------------------------------------------------------

--
-- Table structure for table `ward`
--

CREATE TABLE `ward` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `department` text DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `bednos` mediumint(9) NOT NULL,
  `one_day_rent` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ward`
--

INSERT INTO `ward` (`id`, `name`, `description`, `department`, `updated_by`, `updated_at`, `created_by`, `created_at`, `bednos`, `one_day_rent`) VALUES
(1, 'MEDICAL', '', 'MEDICAL DEPARTMENT', NULL, '2023-01-22 10:23:06', NULL, NULL, 20, 550),
(2, 'SURGICAL', 'UPDATED DETAILS OF SURGICAL WARD...', 'MEDICAL DEPARTMENT', NULL, '2023-01-22 10:22:55', NULL, NULL, 25, 800),
(3, 'CARDIO', '', 'MEDICAL DEPARTMENT', NULL, NULL, NULL, NULL, 1200, 750);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_code` (`emp_code`);

--
-- Indexes for table `dosage`
--
ALTER TABLE `dosage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dosage_master`
--
ALTER TABLE `dosage_master`
  ADD KEY `dosage_id` (`dosage_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lab_test`
--
ALTER TABLE `lab_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mrno` (`mrno`);

--
-- Indexes for table `patient_invoice`
--
ALTER TABLE `patient_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patient_outcome`
--
ALTER TABLE `patient_outcome`
  ADD UNIQUE KEY `mrno` (`mrno`);

--
-- Indexes for table `patient_recieving`
--
ALTER TABLE `patient_recieving`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD UNIQUE KEY `emp_code` (`emp_code`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contactinfo` (`contactinfo`),
  ADD UNIQUE KEY `cnic` (`cnic`),
  ADD UNIQUE KEY `emp_code` (`emp_code`);

--
-- Indexes for table `staff_roles`
--
ALTER TABLE `staff_roles`
  ADD UNIQUE KEY `emp_code` (`emp_code`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ward`
--
ALTER TABLE `ward`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dosage`
--
ALTER TABLE `dosage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `lab_test`
--
ALTER TABLE `lab_test`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient_invoice`
--
ALTER TABLE `patient_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_recieving`
--
ALTER TABLE `patient_recieving`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `views`
--
ALTER TABLE `views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ward`
--
ALTER TABLE `ward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosage_master`
--
ALTER TABLE `dosage_master`
  ADD CONSTRAINT `dosage_master_ibfk_1` FOREIGN KEY (`dosage_id`) REFERENCES `dosage` (`id`);
COMMIT;