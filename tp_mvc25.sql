-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2025 at 02:55 PM
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
-- Database: `tp_mvc25`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `credit` int(11) NOT NULL,
  `lecturer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `credit`, `lecturer_id`) VALUES
(11, 'Introduction to Programming', 3, 1),
(12, 'Object-Oriented Programming', 4, 2),
(13, 'Database Systems', 3, 3),
(14, 'Algorithms & Data Structures', 4, 4),
(15, 'Web Programming', 3, 5),
(16, 'Mobile Development', 3, 6),
(17, 'Software Engineering', 4, 7),
(18, 'Computer Networks', 3, 8),
(19, 'Operating Systems', 4, 9),
(20, 'Artificial Intelligence', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `building` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `building`) VALUES
(1, 'Computer Science', 'FPMIPA'),
(2, 'Information Systems', 'FPIPS'),
(3, 'Software Engineering', 'FPTK'),
(4, 'Data Science', 'FPMIPA'),
(5, 'Artificial Intelligence', 'FPMIPA'),
(6, 'Cyber Security', 'FPTK'),
(7, 'Network Engineering', 'FPIPS'),
(8, 'Business Informatics', 'FPEB'),
(9, 'Computer Engineering', 'FPTK'),
(10, 'Digital Forensics', 'FPTK');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nidn` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `join_date` date NOT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `name`, `nidn`, `phone`, `join_date`, `department_id`) VALUES
(1, 'Dimas Pratama', '1234567890', '081234567890', '2020-01-15', 1),
(2, 'Siti Nurhaliza', '2234567891', '082145678901', '2021-03-20', 2),
(3, 'Ahmad Fauzan', '3234567892', '083156789012', '2019-07-10', 1),
(4, 'Nadia Khairunnisa', '4234567893', '084167890123', '2022-08-05', 3),
(5, 'Budi Santoso', '5234567894', '085178901234', '2020-11-30', 2),
(6, 'Rina Maharani', '6234567895', '086189012345', '2018-04-12', 4),
(7, 'Rizky Ramadhan', '7234567896', '087190123456', '2017-06-21', 3),
(8, 'Melati Kusuma', '8234567897', '088201234567', '2023-02-18', 5),
(9, 'Yusuf Hidayat', '9234567898', '089212345678', '2021-09-27', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lecturer_id` (`lecturer_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`);

--
-- Constraints for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD CONSTRAINT `lecturers_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
