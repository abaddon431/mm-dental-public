-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 07, 2022 at 07:08 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `role`, `email`) VALUES
(16, 'admin123', '$2y$10$dxJStfFFUalXI6ACoss26OgTOPcd.8YSib1Skc/6XspJTI7laL0xa', '1', 'default'),
(23, 'assistant01', '$2y$10$OML0PwIwu/bNeL27rYmUDOdBSIPZsI5lJtbPwADKEE/gjtXGmtvCW', '3', 'default');

-- --------------------------------------------------------

--
-- Table structure for table `ap_requests`
--

CREATE TABLE `ap_requests` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_recieved` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 6
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

CREATE TABLE `category_tbl` (
  `id` int(11) NOT NULL,
  `procedure_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_tbl`
--

INSERT INTO `category_tbl` (`id`, `procedure_id`, `category_name`, `category_code`) VALUES
(1, 1, 'Dentin', 'dn'),
(2, 1, 'Enamel', 'en'),
(5, 2, 'Crown', 'cr'),
(6, 2, 'Root', 'rt'),
(7, 3, 'Abrasion', 'ab'),
(8, 3, 'Erosion', 'er'),
(9, 4, 'Gray', 'gray'),
(10, 4, 'Red', 'red'),
(11, 4, 'Yellow', 'yellow'),
(12, 5, 'Yes', 'yes'),
(13, 5, 'No', 'no'),
(14, 6, 'Yes', 'yes'),
(15, 6, 'No', 'no'),
(16, 7, 'Composite', ''),
(17, 7, 'Ceramic', ''),
(18, 7, 'Amalgam', ''),
(19, 7, 'Gold', ''),
(20, 7, 'Non-Precious Metal', ''),
(21, 7, 'Temporary', ''),
(22, 8, 'Composite', ''),
(23, 8, 'Ceramic', ''),
(24, 8, 'Gold', ''),
(25, 8, 'Non-Precious Metal', ''),
(26, 9, 'Composite', ''),
(27, 9, 'Ceramic', ''),
(28, 9, 'Gold', ''),
(29, 9, 'Non-Precious Material', ''),
(30, 10, 'Composite', ''),
(31, 10, 'Ceramic', ''),
(32, 10, 'Gold', ''),
(33, 10, 'Non-Precious Material', ''),
(34, 11, 'Composite', ''),
(35, 11, 'Ceramic', ''),
(36, 11, 'Gold', ''),
(37, 11, 'Non-Precious Material', ''),
(38, 12, 'Composite', ''),
(39, 12, 'Ceramic', ''),
(40, 12, 'Gold', ''),
(41, 12, 'Non-Precious Material', '');

-- --------------------------------------------------------

--
-- Table structure for table `custom_branchtbl`
--

CREATE TABLE `custom_branchtbl` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `custom_branchtbl`
--

INSERT INTO `custom_branchtbl` (`id`, `branch_name`) VALUES
(1, 'orthodontics'),
(2, 'pediatrics'),
(3, 'periodontics'),
(4, 'prosthodontics'),
(5, 'endodontics');

-- --------------------------------------------------------

--
-- Table structure for table `custom_proctbl`
--

CREATE TABLE `custom_proctbl` (
  `id` int(11) NOT NULL,
  `proc_name` varchar(255) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `total_operated` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `custom_proctbl`
--

INSERT INTO `custom_proctbl` (`id`, `proc_name`, `branch_id`, `total_operated`) VALUES
(17, 'awit', 1, 0),
(18, 'Tooth Extraction', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_event` datetime NOT NULL,
  `end_event` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 11
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--
-- --------------------------------------------------------

--
-- Table structure for table `images_tbl`
--

CREATE TABLE `images_tbl` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `title` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `images_tbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `method_tbl`
--

CREATE TABLE `method_tbl` (
  `id` int(11) NOT NULL,
  `method_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `method_tbl`
--

INSERT INTO `method_tbl` (`id`, `method_name`) VALUES
(1, 'Pathology'),
(2, 'Restoration');

-- --------------------------------------------------------

--
-- Table structure for table `patients_schedule`
--

CREATE TABLE `patients_schedule` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients_schedule`
--

-- --------------------------------------------------------

--
-- Table structure for table `patients_tbl`
--

CREATE TABLE `patients_tbl` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL DEFAULT 'none',
  `birthdate` date NOT NULL DEFAULT current_timestamp(),
  `age` int(3) NOT NULL DEFAULT 0,
  `sex` varchar(1) NOT NULL DEFAULT 'X',
  `civil_status` varchar(255) NOT NULL DEFAULT 'n/a',
  `occupation` varchar(255) NOT NULL DEFAULT 'n/a',
  `religion` varchar(255) NOT NULL DEFAULT 'n/a',
  `contactno` varchar(20) NOT NULL DEFAULT 'none',
  `email` varchar(50) NOT NULL DEFAULT 'none',
  `notes` varchar(255) NOT NULL DEFAULT 'none',
  `allergies` varchar(255) NOT NULL DEFAULT 'none',
  `date_added` date NOT NULL DEFAULT current_timestamp(),
  `date_edited` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients_tbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `precords_tbl`
--

CREATE TABLE `precords_tbl` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `teeth_id` int(11) NOT NULL,
  `missing` int(11) NOT NULL DEFAULT 0,
  `operated` int(11) NOT NULL DEFAULT 0,
  `operation_code` varchar(50) NOT NULL DEFAULT '0-0-0',
  `operation_desc` varchar(255) DEFAULT NULL,
  `is_group` int(11) DEFAULT 0,
  `teeth_group` varchar(255) NOT NULL DEFAULT '0',
  `note` varchar(255) DEFAULT NULL,
  `date_performed` date NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 3,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `procedure_tbl`
--

CREATE TABLE `procedure_tbl` (
  `id` int(11) NOT NULL,
  `procedure_name` varchar(50) NOT NULL,
  `procedure_code` varchar(10) NOT NULL,
  `method_id` int(11) NOT NULL,
  `total_operated` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `procedure_tbl`
--

INSERT INTO `procedure_tbl` (`id`, `procedure_name`, `procedure_code`, `method_id`, `total_operated`) VALUES
(1, 'Decay', 'dc', 1, 0),
(2, 'Fracture', 'fc', 1, 0),
(3, 'Tooth Wear', 'tw', 1, 0),
(4, 'Discoloration', 'dc', 1, 0),
(5, 'Apical', 'ap', 1, 0),
(6, 'Development Disorder', 'dd', 1, 0),
(7, 'Filling', 'fl', 2, 0),
(8, 'Inlay', 'in', 2, 0),
(9, 'Onlay', 'on', 2, 0),
(10, 'Veneer', 've', 2, 0),
(11, 'Partial Crown', 'pc', 2, 0),
(12, 'Crown', 'cr', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ptreatment_tbl`
--

CREATE TABLE `ptreatment_tbl` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date_performed` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ptreatment_tbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `pwd_reset`
--

CREATE TABLE `pwd_reset` (
  `resetId` int(11) NOT NULL,
  `resetEmail` text NOT NULL,
  `resetSelector` text NOT NULL,
  `resetToken` longtext NOT NULL,
  `resetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `roles_tbl`
--

CREATE TABLE `roles_tbl` (
  `id` int(11) NOT NULL,
  `role_desc` varchar(20) NOT NULL DEFAULT 'admin',
  `clinic_prof_view` int(11) NOT NULL DEFAULT 1,
  `clinic_prof_edit` int(11) NOT NULL DEFAULT 1,
  `clinic_med_view` int(11) NOT NULL DEFAULT 1,
  `clinic_med_edit` int(11) NOT NULL DEFAULT 1,
  `clinic_proc_view` int(11) NOT NULL DEFAULT 1,
  `clinic_proc_edit` int(11) NOT NULL DEFAULT 1,
  `patient_rec_view` int(11) NOT NULL DEFAULT 1,
  `patient_rec_edit` int(11) NOT NULL DEFAULT 1,
  `sched_cal_view` int(11) NOT NULL DEFAULT 1,
  `sched_cal_edit` int(11) NOT NULL DEFAULT 1,
  `app_req_view` int(11) NOT NULL DEFAULT 1,
  `app_req_edit` int(11) NOT NULL DEFAULT 1,
  `user_manage_view` int(11) NOT NULL DEFAULT 1,
  `user_manage_edit` int(11) NOT NULL DEFAULT 1,
  `settings_view` int(11) NOT NULL DEFAULT 1,
  `settings_edit` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles_tbl`
--

INSERT INTO `roles_tbl` (`id`, `role_desc`, `clinic_prof_view`, `clinic_prof_edit`, `clinic_med_view`, `clinic_med_edit`, `clinic_proc_view`, `clinic_proc_edit`, `patient_rec_view`, `patient_rec_edit`, `sched_cal_view`, `sched_cal_edit`, `app_req_view`, `app_req_edit`, `user_manage_view`, `user_manage_edit`, `settings_view`, `settings_edit`) VALUES
(1, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'dentist', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 0),
(3, 'assistant', 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `services_tbl`
--

CREATE TABLE `services_tbl` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services_tbl`
--

INSERT INTO `services_tbl` (`id`, `description`, `code`) VALUES
(1, 'Oral Prophylaxis', 'OP'),
(2, 'Extraction', 'EX'),
(3, 'Tooth Filling', 'TF');

-- --------------------------------------------------------

--
-- Table structure for table `status_tbl`
--

CREATE TABLE `status_tbl` (
  `id` int(11) NOT NULL,
  `status_desc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status_tbl`
--

INSERT INTO `status_tbl` (`id`, `status_desc`) VALUES
(1, 'monitor'),
(2, 'treat'),
(3, 'saved'),
(4, 'active'),
(5, 'inactive'),
(6, 'pending'),
(7, 'accepted'),
(8, 'rejected'),
(9, 'success'),
(10, 'failed'),
(11, 'scheduled'),
(12, 'noshow'),
(13, 'done');

-- --------------------------------------------------------

--
-- Table structure for table `sub_tbl`
--

CREATE TABLE `sub_tbl` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_name` varchar(50) NOT NULL,
  `sub_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_tbl`
--

INSERT INTO `sub_tbl` (`id`, `category_id`, `sub_name`, `sub_code`) VALUES
(1, 1, 'Caviation', 'cv'),
(2, 1, 'No Caviations', 'ncv'),
(3, 2, 'Caviation', 'cv'),
(4, 2, 'No Caviations', 'ncv'),
(5, 5, 'Vertical', 'vert'),
(6, 5, 'Horizontal', 'hori'),
(7, 6, 'Vertical', 'vert'),
(8, 6, 'Horizontal', 'hori'),
(9, 7, 'Buccal', 'bc'),
(10, 7, 'Palatal', 'pt'),
(11, 8, 'Buccal', 'bc'),
(12, 8, 'Palatal', 'pt');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ap_requests`
--
ALTER TABLE `ap_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `procedure_id` (`procedure_id`);

--
-- Indexes for table `custom_branchtbl`
--
ALTER TABLE `custom_branchtbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `custom_proctbl`
--
ALTER TABLE `custom_proctbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `images_tbl`
--
ALTER TABLE `images_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `method_tbl`
--
ALTER TABLE `method_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients_schedule`
--
ALTER TABLE `patients_schedule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `patients_tbl`
--
ALTER TABLE `patients_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `precords_tbl`
--
ALTER TABLE `precords_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `status` (`status`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `procedure_tbl`
--
ALTER TABLE `procedure_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `method_id` (`method_id`);

--
-- Indexes for table `ptreatment_tbl`
--
ALTER TABLE `ptreatment_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pwd_reset`
--
ALTER TABLE `pwd_reset`
  ADD PRIMARY KEY (`resetId`);

--
-- Indexes for table `roles_tbl`
--
ALTER TABLE `roles_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `services_tbl`
--
ALTER TABLE `services_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `status_tbl`
--
ALTER TABLE `status_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_tbl`
--
ALTER TABLE `sub_tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ap_requests`
--
ALTER TABLE `ap_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `custom_branchtbl`
--
ALTER TABLE `custom_branchtbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `custom_proctbl`
--
ALTER TABLE `custom_proctbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=452;

--
-- AUTO_INCREMENT for table `images_tbl`
--
ALTER TABLE `images_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `method_tbl`
--
ALTER TABLE `method_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patients_schedule`
--
ALTER TABLE `patients_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `patients_tbl`
--
ALTER TABLE `patients_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `precords_tbl`
--
ALTER TABLE `precords_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `procedure_tbl`
--
ALTER TABLE `procedure_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `ptreatment_tbl`
--
ALTER TABLE `ptreatment_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pwd_reset`
--
ALTER TABLE `pwd_reset`
  MODIFY `resetId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `roles_tbl`
--
ALTER TABLE `roles_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services_tbl`
--
ALTER TABLE `services_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_tbl`
--
ALTER TABLE `status_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sub_tbl`
--
ALTER TABLE `sub_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ap_requests`
--
ALTER TABLE `ap_requests`
  ADD CONSTRAINT `ap_requests_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status_tbl` (`id`);

--
-- Constraints for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD CONSTRAINT `category_tbl_ibfk_1` FOREIGN KEY (`procedure_id`) REFERENCES `procedure_tbl` (`id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status_tbl` (`id`);

--
-- Constraints for table `patients_tbl`
--
ALTER TABLE `patients_tbl`
  ADD CONSTRAINT `patients_tbl_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status_tbl` (`id`);

--
-- Constraints for table `precords_tbl`
--
ALTER TABLE `precords_tbl`
  ADD CONSTRAINT `precords_tbl_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients_tbl` (`id`),
  ADD CONSTRAINT `precords_tbl_ibfk_2` FOREIGN KEY (`status`) REFERENCES `status_tbl` (`id`);

--
-- Constraints for table `procedure_tbl`
--
ALTER TABLE `procedure_tbl`
  ADD CONSTRAINT `procedure_tbl_ibfk_1` FOREIGN KEY (`method_id`) REFERENCES `method_tbl` (`id`);

--
-- Constraints for table `sub_tbl`
--
ALTER TABLE `sub_tbl`
  ADD CONSTRAINT `sub_tbl_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_tbl` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
