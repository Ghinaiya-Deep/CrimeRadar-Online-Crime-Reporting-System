-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2025 at 01:24 PM
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
-- Database: `crime_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`username`, `password`) VALUES
('Admin', 'Admin@2025');

-- --------------------------------------------------------

--
-- Table structure for table `chargesheet`
--

CREATE TABLE `chargesheet` (
  `chargesheet_id` varchar(20) NOT NULL,
  `crime_id` int(11) NOT NULL,
  `police_station_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `crime_type` varchar(20) NOT NULL,
  `description` varchar(300) NOT NULL,
  `ipc_sections` varchar(255) DEFAULT NULL,
  `investigating_officer` varchar(255) DEFAULT NULL,
  `accused` varchar(255) DEFAULT NULL,
  `witnesses` varchar(255) DEFAULT NULL,
  `court_name` varchar(50) NOT NULL DEFAULT 'Nashik District Court',
  `date_of_chargesheet` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('Pending','Under Investigation','Solved','') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chargesheet`
--

INSERT INTO `chargesheet` (`chargesheet_id`, `crime_id`, `police_station_id`, `name`, `email`, `mobile`, `crime_type`, `description`, `ipc_sections`, `investigating_officer`, `accused`, `witnesses`, `court_name`, `date_of_chargesheet`, `status`) VALUES
('CS-72365', 72365, 1, 'Ghinaiya Deep Amulbhai', 'nsk', '6352442624', 'Theft', 'ABCDFDFHF', 'Section 813', 'PS Deep', 'Aditya', 'Sameer', 'Nashik District Court', '2025-02-21 11:56:31', 'Solved');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_withdrawals`
--

CREATE TABLE `complaint_withdrawals` (
  `id` int(11) NOT NULL,
  `crime_id` int(11) NOT NULL,
  `police_station_id` int(11) NOT NULL,
  `reason` text NOT NULL,
  `status` enum('Pending','Rejected','Not Rejected') DEFAULT 'Pending',
  `request_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint_withdrawals`
--

INSERT INTO `complaint_withdrawals` (`id`, `crime_id`, `police_station_id`, `reason`, `status`, `request_date`) VALUES
(99822, 45937, 1, 'Fake News', 'Rejected', '2025-02-22 16:22:19');

-- --------------------------------------------------------

--
-- Table structure for table `crime_reports`
--

CREATE TABLE `crime_reports` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address` varchar(150) NOT NULL,
  `crime_type` varchar(20) NOT NULL,
  `police_station_id` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `evidence` varchar(255) DEFAULT NULL,
  `date_of_report` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crime_reports`
--

INSERT INTO `crime_reports` (`id`, `name`, `email`, `mobile`, `address`, `crime_type`, `police_station_id`, `description`, `evidence`, `date_of_report`, `status`) VALUES
(26629, 'Ghinaiya Deep Amulbhai', 'deep.c617.app@gmail.com', '6352442624', '', 'Assault', 1, 'fddf', 'Certificate for Ghinaiya Deep Amulbhai for _Feedback of Brilliant Compu..._.pdf', '2025-03-02 17:47:22', 'Unsolved'),
(60597, 'aaa', 'as@gmail.com', '0342141234', 'nsk', 'Assault', 13, 'sfdsghfm', 'Shp.jpg', '2025-02-23 12:41:15', 'Unsolved'),
(72365, 'Ghinaiya Deep Amulbhai', 'deep.c617.app@gmail.com', '6352442624', 'nsk', 'Theft', 1, 'dfdf', '5.1.pdf', '2025-02-26 18:03:15', 'Solved');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `police_station_id` int(11) NOT NULL,
  `feedback` varchar(200) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `name`, `email`, `police_station_id`, `feedback`, `rating`) VALUES
(3, 'Ghinaiya Deep Amulbhai', 'deep.c617.app@gmail.com', 2, 'Great Service but slow process', 4);

-- --------------------------------------------------------

--
-- Table structure for table `fir`
--

CREATE TABLE `fir` (
  `id` int(11) NOT NULL,
  `fir_no` varchar(20) NOT NULL,
  `crime_id` int(11) NOT NULL,
  `date_time_filing` datetime NOT NULL,
  `complainant_name` varchar(255) DEFAULT NULL,
  `complainant_address` varchar(255) DEFAULT NULL,
  `complainant_contact` varchar(255) DEFAULT NULL,
  `complainant_id_proof` varchar(255) DEFAULT NULL,
  `date_time_incident` datetime NOT NULL,
  `place_incident` text NOT NULL,
  `crime_type` varchar(100) NOT NULL,
  `accused_persons` text DEFAULT NULL,
  `witnesses` text DEFAULT NULL,
  `incident_description` varchar(255) DEFAULT NULL,
  `evidence` text DEFAULT NULL,
  `police_station` varchar(255) NOT NULL,
  `officer_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fir`
--

INSERT INTO `fir` (`id`, `fir_no`, `crime_id`, `date_time_filing`, `complainant_name`, `complainant_address`, `complainant_contact`, `complainant_id_proof`, `date_time_incident`, `place_incident`, `crime_type`, `accused_persons`, `witnesses`, `incident_description`, `evidence`, `police_station`, `officer_name`) VALUES
(20, '2025/001', 72365, '2025-02-21 17:26:21', 'Ghinaiya Deep Amulbhai', 'nsk', '6352442624', '123456788754', '2025-02-20 17:25:00', 'Nashik', 'Theft', 'Gaurav', 'Sameer', 'My Mobile is theft from one unknown person.', 'fgfgrg', '1', 'PSI Deep');

-- --------------------------------------------------------

--
-- Table structure for table `police`
--

CREATE TABLE `police` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `police_station_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `police`
--

INSERT INTO `police` (`id`, `username`, `password`, `police_station_id`) VALUES
(1, 'Adgaon', 'Adgaon@2025', 1),
(2, 'Ambad', 'Ambad@2025', 2),
(3, 'Bhadrakali', 'Bhadrakali@2025', 3),
(4, 'DeolaliCamp', 'DeolaliCamp@2025', 4),
(5, 'Gangapur', 'Gangapur@2025', 5),
(6, 'Indiranagar', 'Indiranagar@2025', 6),
(7, 'Mhasrul', 'Mhasrul@2025', 7),
(8, 'MumbaiNaka', 'MumbaiNaka@2025', 8),
(9, 'NashikRoad', 'NashikRoad@2025', 9),
(10, 'Panchvati', 'Panchvati@2025', 10),
(11, 'Sarkarwada', 'Sarkarwada@2025', 11),
(12, 'Satpur', 'Satpur@2025', 12),
(13, 'Upnagar', 'Upnagar@2025', 13);

-- --------------------------------------------------------

--
-- Table structure for table `police_officers`
--

CREATE TABLE `police_officers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rank` varchar(50) NOT NULL,
  `badge_number` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `station_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `police_officers`
--

INSERT INTO `police_officers` (`id`, `name`, `rank`, `badge_number`, `phone`, `station_id`) VALUES
(2, 'Ghinaiya Deep Amulbhai', 'Inspector', 'B12345', '8780791029', 1),
(3, 'Kalawadiya Gaurav Jitesh', 'Sub-Inspector', 'B54321', '1234567892', 1),
(4, 'Sonawane Sameer Shantaram', 'Assistant Sub-Inspector', 'B12342', '8523697412', 1),
(5, 'Patil Suresh Ramesh', 'Head Constable', 'B12354', '1254789632', 1);

-- --------------------------------------------------------

--
-- Table structure for table `police_stations`
--

CREATE TABLE `police_stations` (
  `id` int(11) NOT NULL,
  `station_name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `police_stations`
--

INSERT INTO `police_stations` (`id`, `station_name`, `location`) VALUES
(1, 'Adgaon', 'Adgaon Naka'),
(2, 'Ambad', 'Ambad Link Road'),
(3, 'Bhadrakali', 'Bhadrakali '),
(4, 'Deolali Camp', 'Deolali Camp'),
(5, 'Gangapur', 'Gangapur Road'),
(6, 'Indiranagar', 'Indiranagar'),
(7, 'Mhasrul', 'Mhasrul'),
(8, 'Mumbai Naka', 'Mumbai Naka'),
(9, 'Nashik Road', 'Nashik Road'),
(10, 'Panchvati', 'Panchvati'),
(11, 'Sarkarwada', 'Sarkarwada'),
(12, 'Satpur', 'Satpur'),
(13, 'Upnagar', 'Upnagar');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Age` int(11) NOT NULL,
  `Mobile` varchar(10) NOT NULL,
  `Password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Username`, `Email`, `Age`, `Mobile`, `Password`) VALUES
(11, 'deep40', 'deep.c617.app@gmail.com', 20, '6352442624', 'Deep@2025');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chargesheet`
--
ALTER TABLE `chargesheet`
  ADD PRIMARY KEY (`chargesheet_id`),
  ADD KEY `fk_crime_id` (`crime_id`),
  ADD KEY `fk_police_station_id` (`police_station_id`);

--
-- Indexes for table `complaint_withdrawals`
--
ALTER TABLE `complaint_withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `police_station_id` (`police_station_id`),
  ADD KEY `crime_id` (`crime_id`);

--
-- Indexes for table `crime_reports`
--
ALTER TABLE `crime_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `police_station_id` (`police_station_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `police_station_id` (`police_station_id`);

--
-- Indexes for table `fir`
--
ALTER TABLE `fir`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fir_no` (`fir_no`),
  ADD KEY `crime_id` (`crime_id`);

--
-- Indexes for table `police`
--
ALTER TABLE `police`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `police_station_id` (`police_station_id`);

--
-- Indexes for table `police_officers`
--
ALTER TABLE `police_officers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `badge_number` (`badge_number`),
  ADD KEY `station_id` (`station_id`);

--
-- Indexes for table `police_stations`
--
ALTER TABLE `police_stations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `station_name` (`station_name`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaint_withdrawals`
--
ALTER TABLE `complaint_withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99823;

--
-- AUTO_INCREMENT for table `crime_reports`
--
ALTER TABLE `crime_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72366;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `fir`
--
ALTER TABLE `fir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `police`
--
ALTER TABLE `police`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `police_officers`
--
ALTER TABLE `police_officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `police_stations`
--
ALTER TABLE `police_stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chargesheet`
--
ALTER TABLE `chargesheet`
  ADD CONSTRAINT `fk_crime_id` FOREIGN KEY (`crime_id`) REFERENCES `fir` (`crime_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_police_station_id` FOREIGN KEY (`police_station_id`) REFERENCES `police_stations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `crime_reports`
--
ALTER TABLE `crime_reports`
  ADD CONSTRAINT `crime_reports_ibfk_1` FOREIGN KEY (`police_station_id`) REFERENCES `police_stations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fir`
--
ALTER TABLE `fir`
  ADD CONSTRAINT `fir_ibfk_1` FOREIGN KEY (`crime_id`) REFERENCES `crime_reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `police`
--
ALTER TABLE `police`
  ADD CONSTRAINT `police_ibfk_1` FOREIGN KEY (`police_station_id`) REFERENCES `police_stations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `police_officers`
--
ALTER TABLE `police_officers`
  ADD CONSTRAINT `police_officers_ibfk_1` FOREIGN KEY (`station_id`) REFERENCES `police_stations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
