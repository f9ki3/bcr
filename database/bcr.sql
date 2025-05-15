-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2025 at 07:42 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bcr`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin1`
--

CREATE TABLE `admin1` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin1`
--

INSERT INTO `admin1` (`id`, `username`, `password`, `name`, `email`, `role`, `created_at`, `profile_pic`) VALUES
(1, 'admin', '$2y$10$PsGQesECHJXPahdX.rT25uIChFGrVSfQ.WmeXyGa8lkOHx/2fzUEO', 'Giselle Esparrag', 'esparragogiselle0@gmail.com', 'System Administrator', '2025-01-09 09:24:11', '../assets/uploads/mylogo.php');

-- --------------------------------------------------------

--
-- Table structure for table `blotter_reports`
--

CREATE TABLE `blotter_reports` (
  `id` int(11) NOT NULL,
  `reporter_name` varchar(255) NOT NULL,
  `contact_num` varchar(11) NOT NULL,
  `reported_person` varchar(255) NOT NULL,
  `incident_date` date NOT NULL,
  `incident_details` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blotter_reports`
--

INSERT INTO `blotter_reports` (`id`, `reporter_name`, `contact_num`, `reported_person`, `incident_date`, `incident_details`, `location`, `image_path`, `status`, `created_at`, `user_id`) VALUES
(41, 'Mel rose Norca', '2147483647', 'Joys Nicole', '2025-05-13', 'Sinabunotan', 'Phs 10 pkg 7 Bagong Silang barangay 176-f North Caloocan', '3.jpg', 'Pending', '2025-05-13 15:21:31', 43),
(42, 'test', '09120912091', 'tets', '2025-05-15', 'tetsas', 'testsa', '95ec8377986af26c98a564b8cbf60fda.jpg', 'pending', '2025-05-15 02:22:41', 1),
(43, 'Fyke', '09120912091', 'Arnold', '2025-05-15', 'Nabugbug', 'barangay 147-f', '12c544661d47b91f61e8286ea2ff9b15.png', 'to release', '2025-05-15 03:10:02', 1);

-- --------------------------------------------------------

--
-- Table structure for table `certificate_requests`
--

CREATE TABLE `certificate_requests` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `age` int(3) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `civil_status` varchar(50) DEFAULT NULL,
  `religion` varchar(100) DEFAULT NULL,
  `purpose` text DEFAULT NULL,
  `certificate_type` varchar(100) DEFAULT NULL,
  `proof_of_identity` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `others` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `certificate_requests`
--

INSERT INTO `certificate_requests` (`id`, `fullname`, `address`, `contact`, `email`, `birthdate`, `birthplace`, `age`, `gender`, `civil_status`, `religion`, `purpose`, `certificate_type`, `proof_of_identity`, `status`, `request_date`, `user_id`, `others`) VALUES
(113, 'Mel Rose Norca', 'phs 10 bkg 3 Barangay 176-F Caloocan City', '2147483647', 'norcamelrose@gmail.com', '2000-12-25', 'Caloocan', 24, 'Female', 'Single', 'Catholic', 'School Requirement', 'Certificate of Indigency', 'uploads/1747149411_681ede63eb6f5.png', 'To Release', '2025-05-13 10:16:51', 43, ''),
(114, 'Mel Rose Norca', 'phs 10 bkg 3 Barangay 176-F Caloocan City', '2147483647', 'norcamelrose@gmail.com', '2000-12-25', 'Caloocan', 24, 'Female', 'Single', 'Catholic', 'SSS Requirement', 'Certificate of Residency', 'uploads/1747149820_istockphoto-165646486-612x612.jpg', 'To Release', '2025-05-13 10:23:40', 43, ''),
(115, 'Mel Rose Norca', 'phs 10 bkg 3 Barangay 176-F Caloocan City', '2147483647', 'norcamelrose@gmail.com', '2000-12-25', 'Caloocan', 24, 'Female', 'Single', 'Catholic', 'Sa trabaho', 'Barangay Clearance', 'uploads/1747149904_istockphoto-165646486-612x612.jpg', 'To Release', '2025-05-13 10:25:04', 43, ''),
(117, 'Mel Rose Norca', 'phs 10 bkg 3 Barangay 176-F Caloocan City', '2147483647', 'norcamelrose@gmail.com', '2000-12-25', 'Caloocan', 25, 'Female', 'Single', 'Catholic', 'Bank Requirement', 'Barangay Clearance', 'uploads/1747150398_Screenshot (2).png', 'Rejected', '2025-05-13 10:33:18', 43, ''),
(119, 'test', 'test', '09120912091', 'floterina@gmail.com', '2025-05-01', 'test', 12, 'Male', 'Single', 'test', 'School Requirement', 'Barangay Clearance', 'afc19658d486d0d30bee65758d61568f.jpg', 'To Release', '2025-05-15 01:32:39', 1, NULL),
(120, 'test', 'bulacan', '0912091209', 'floterina@gmail.com', '2009-02-03', 'bulacan', 12, 'Female', 'Single', 'asqs', 'School Requirement', 'Barangay Clearance', 'a210c44a840cac31711d6e4ccd5ba4db.png', 'rejected', '2025-05-15 03:11:27', 1, NULL),
(121, 'test', 'tet', '09120912091', 'floterina@gmail.com', '2025-05-08', 'test', 12, 'Female', 'Single', 'test', 'School Requirement', 'Barangay Clearance', 'fb2a7ce9a05ee611ad2b3287008cae41.jpg', 'pending', '2025-05-15 03:41:35', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `acc_id` int(6) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_history`
--

CREATE TABLE `password_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `old_password` varchar(255) NOT NULL,
  `new_password` varchar(255) NOT NULL,
  `changed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expires_at`) VALUES
(1, 'esparragogiselle0@gmail.com', 'aab99b8cf6b0c908d8a283eb6aaf52dc39892aefc88f87d51ce677c61b681de1', '2025-05-10 11:25:04'),
(2, 'esparragogiselle0@gmail.com', '070bf18b1882d89b415f3274bc403acce2ae2dde8d29d36e885931a49c6e12dd', '2025-05-10 11:28:34'),
(3, 'esparragogiselle0@gmail.com', 'd9cc9a88f173afc9817bb7b991487b58594d7a86abc2b2553f71e208d777497b', '2025-05-10 11:30:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) UNSIGNED NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `contact_num` varchar(15) DEFAULT NULL,
  `profile_image` varchar(255) NOT NULL DEFAULT 'default.png',
  `otp` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`User_ID`, `fullname`, `username`, `email`, `password`, `address`, `contact_num`, `profile_image`, `otp`, `created_at`, `updated_at`) VALUES
(1, 'Fyke Lleva', 'f9ki3', 'floterina@gmail.com', '$2y$10$PP7LW6jvqjbRDWQNZsxpx.uzlM1KcQkXBUfr43F.QERLEgjLPUZHq', 'Barangay 176-F', '09120912091', 'profile_68252ccb529820.60682313.jpg', 320294, '2025-05-13 21:02:18', '2025-05-15 03:58:52'),
(2, 'Gissle Masipag', 'Gissle', 'rickandmorty0224@gmail.com', '$2y$10$.qYETO.a1jpIc5D88hOycuSBmfKd8kkFb1HBIVq/v9mCxSHAiu5Ny', 'Barangay 176-F', '09120912097', 'profile_68252acab45d43.83415802.jpg', 316065, '2025-05-14 02:43:07', '2025-05-14 23:44:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin1`
--
ALTER TABLE `admin1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blotter_reports`
--
ALTER TABLE `blotter_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_blotter_user` (`user_id`);

--
-- Indexes for table `certificate_requests`
--
ALTER TABLE `certificate_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_history`
--
ALTER TABLE `password_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin1`
--
ALTER TABLE `admin1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blotter_reports`
--
ALTER TABLE `blotter_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `certificate_requests`
--
ALTER TABLE `certificate_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_history`
--
ALTER TABLE `password_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
