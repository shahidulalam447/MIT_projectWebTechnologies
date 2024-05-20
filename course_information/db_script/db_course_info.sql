-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2024 at 11:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_course_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `cid` int(11) NOT NULL,
  `course_code` varchar(20) NOT NULL,
  `course_title` varchar(100) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `credit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`cid`, `course_code`, `course_title`, `teacher_id`, `credit`) VALUES
(501, 'ICT 0613-5121', 'Advanced Computer Programming & Algorithm', 1, 3),
(502, 'ICT 0612-5125', 'Database Architecture and Administration', 2, 3),
(503, 'ICT 0714-5123', 'Advanced Web Technology', 3, 3),
(504, 'ICT 0612-5133', 'Advanced Computer Networking & Internetworking', 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `course_summary`
--

CREATE TABLE `course_summary` (
  `csid` int(11) NOT NULL,
  `total_credit` int(11) NOT NULL,
  `course_length` varchar(20) NOT NULL,
  `total_semester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_summary`
--

INSERT INTO `course_summary` (`csid`, `total_credit`, `course_length`, `total_semester`) VALUES
(1001, 36, '1.5 years', 3);

-- --------------------------------------------------------

--
-- Table structure for table `faculties`
--

CREATE TABLE `faculties` (
  `fid` int(11) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `designation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculties`
--

INSERT INTO `faculties` (`fid`, `teacher_name`, `designation`) VALUES
(1, 'Prof M. Jahirul Islam', 'Director, IICT'),
(2, 'Dr. Ahsan Habib', 'Associate Professor, IICT'),
(3, 'Prof Md. Masum', 'Head Dept of CSE'),
(4, 'Prof Dr. M A Al Mumin', 'Professor Dept of CSE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `course_summary`
--
ALTER TABLE `course_summary`
  ADD PRIMARY KEY (`csid`);

--
-- Indexes for table `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`fid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `faculties` (`fid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
