-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 02:46 PM
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
-- Database: `mpow`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `classcode` varchar(64) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `section` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `classcode`, `instructor_id`, `section`) VALUES
(1, 'CLOUD 123', 1, 'BSIT 101'),
(2, 'CLOUD 123', 1, 'BSIT 102'),
(3, 'CLOUD 123', 1, 'BSIT 103'),
(4, 'INFO 223', 1, 'BSIT 203'),
(5, 'HISTORY 123', 2, 'BSIT 103'),
(6, 'BEAUTY 101', 4, 'BSIT 103'),
(7, 'ARTS 123', 3, 'BSIT 103'),
(14, 'NSTP', 1, 'BSIT 103'),
(15, 'HELLO 123', 1, 'BSIT 103'),
(16, 'DELULU 103', 1, 'BSIT 103');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE `instructors` (
  `instructor_id` int(11) NOT NULL,
  `instructor_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `instructor_name`) VALUES
(1, 'Jacob Santino'),
(2, 'Alice Guo'),
(3, 'Kim Namjoon'),
(4, 'Seth Salazar');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `schedule_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `classstatus` enum('May pasok','Walang pasok') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_id`, `class_id`, `day`, `start_time`, `end_time`, `classstatus`) VALUES
(1, 3, 'Monday', '09:00:00', '11:00:00', 'Walang pasok'),
(2, 2, 'Monday', '11:00:00', '12:30:00', 'May pasok'),
(3, 4, 'Monday', '14:00:00', '17:00:00', 'May pasok'),
(4, 3, 'Tuesday', '10:00:00', '11:00:00', 'Walang pasok'),
(5, 6, 'Tuesday', '13:00:00', '14:30:00', 'May pasok'),
(6, 7, 'Tuesday', '09:00:00', '10:00:00', 'May pasok'),
(17, 14, 'Saturday', '09:30:00', '11:00:00', 'May pasok'),
(18, 15, 'Friday', '15:00:00', '18:00:00', 'May pasok'),
(19, 16, 'Thursday', '08:30:00', '11:00:00', 'May pasok');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `accountType` enum('student','teacher') NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `accountType`, `lastname`, `firstname`, `username`, `password`) VALUES
(1, 'student', 'Vergara', 'Claricel', 'clvrgr', 'claricelganda'),
(2, 'teacher', 'Smith', 'John', 'smithsons', 'smith123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `instructors`
--
ALTER TABLE `instructors`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `instructors`
--
ALTER TABLE `instructors`
  MODIFY `instructor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
