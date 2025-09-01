-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2025 at 12:40 PM
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
-- Database: `scheduler`
--

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `ClassroomID` varchar(10) NOT NULL,
  `Building` varchar(50) DEFAULT NULL,
  `Capacity` int(11) NOT NULL,
  `MultimediaAvail` tinyint(1) DEFAULT 0,
  `AvailableSlots` varchar(255) DEFAULT 'TS1,TS2,TS3,TS4,TS5,TS6'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`ClassroomID`, `Building`, `Capacity`, `MultimediaAvail`, `AvailableSlots`) VALUES
('B1-F0-01', 'Block 1', 70, 0, 'TS4'),
('B1-F0-02', 'Block 1', 80, 0, 'TS4'),
('B1-F1-01', 'Block 1', 50, 1, 'TS1,TS4'),
('B1-F1-02', 'Block 1', 60, 0, 'TS4'),
('B2-F0-01', 'Block 2', 60, 0, 'TS4'),
('B2-F0-05', 'Block 2', 100, 1, 'TS4');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `CourseCode` varchar(10) NOT NULL,
  `CourseTitle` varchar(100) NOT NULL,
  `Enrollment` int(11) NOT NULL,
  `MultimediaReq` tinyint(1) DEFAULT 0,
  `InstructorAssigned` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`CourseCode`, `CourseTitle`, `Enrollment`, `MultimediaReq`, `InstructorAssigned`) VALUES
('CS201', 'Introduction to Programming', 85, 1, NULL),
('CS301', 'Data Structures', 65, 1, NULL),
('CS302', 'Digital Logic Design', 48, 0, NULL),
('CS304', 'Object Oriented Programming', 65, 1, NULL),
('CS401', 'Computer Architecture and Assembly Language Programming', 70, 1, NULL),
('CS601', 'Data Communication', 58, 1, NULL),
('CS604', 'Operating Systems', 75, 0, NULL),
('CS606', 'Compiler Construction', 66, 0, NULL),
('CS610', 'Computer Networks', 51, 0, NULL),
('CS701', 'Theory of Computation', 45, 0, NULL),
('CS702', 'Advanced Algorithms Analysis and Design', 48, 0, NULL),
('CS703', 'Advanced Operating System', 45, 0, NULL),
('CS704', 'Advanced Computer Architecture', 47, 0, NULL),
('MTH101', 'Calculus And Analytical Geometry', 55, 0, NULL),
('MTH201', 'Multivariable Calculus', 55, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `FacultyID` varchar(10) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Department` varchar(50) NOT NULL,
  `Designation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`FacultyID`, `Name`, `Department`, `Designation`) VALUES
('DCS23', 'Prof. Dr. Nadeem Sharjeel', 'Computer Science', 'Professor'),
('DCS24', 'Dr. Shamim Islam', 'Computer Science', 'Associate Professor'),
('DCS41', 'Dr. Qasim Rafiq', 'Computer Science', 'Assistant Professor'),
('DCS42', 'Ms. Afsana Maqbool', 'Computer Science', 'Assistant Professor'),
('DCS51', 'Mr. Shakeel Ahmad', 'Computer Science', 'Lecturer'),
('DCS52', 'Mr. Irfan Mehmood', 'Computer Science', 'Lecturer'),
('DCS53', 'Ms. Momina Khalid', 'Computer Science', 'Lecturer'),
('DM51', 'Mr. Zulfiqar Ahmad', 'Mathematics', 'Lecturer');

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `PrefID` int(11) NOT NULL,
  `FacultyID` varchar(10) NOT NULL,
  `CourseCode` varchar(10) NOT NULL,
  `Day` varchar(10) DEFAULT NULL,
  `TimeSlotID` varchar(5) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`PrefID`, `FacultyID`, `CourseCode`, `Day`, `TimeSlotID`, `CreatedAt`) VALUES
(14, 'DCS23', 'CS401', 'Tuesday', 'TS3', '2025-08-22 03:14:17'),
(15, 'DCS23', 'CS401', 'Tuesday', 'TS5', '2025-08-22 03:14:27'),
(16, 'DCS23', 'CS701', 'Tuesday', 'TS3', '2025-08-22 03:15:13'),
(17, 'DCS23', 'CS701', 'Tuesday', 'TS5', '2025-08-22 03:15:26'),
(18, 'DCS23', 'CS704', 'Tuesday', 'TS3', '2025-08-22 03:15:40'),
(19, 'DCS23', 'CS704', 'Tuesday', 'TS5', '2025-08-22 03:15:55'),
(20, 'DCS23', 'CS401', 'Thursday', 'TS3', '2025-08-22 03:16:05'),
(21, 'DCS23', 'CS401', 'Thursday', 'TS5', '2025-08-22 03:16:59'),
(22, 'DCS23', 'CS701', 'Thursday', 'TS3', '2025-08-22 03:17:44'),
(23, 'DCS23', 'CS701', 'Thursday', 'TS5', '2025-08-22 03:17:53'),
(24, 'DCS23', 'CS704', 'Thursday', 'TS3', '2025-08-22 03:18:00'),
(25, 'DCS23', 'CS704', 'Thursday', 'TS5', '2025-08-22 03:18:13'),
(26, 'DCS24', 'CS601', 'Monday', 'TS1', '2025-08-22 03:27:24'),
(27, 'DCS24', 'CS601', 'Monday', 'TS2', '2025-08-22 03:27:37'),
(28, 'DCS24', 'CS601', 'Monday', 'TS3', '2025-08-22 03:27:48'),
(29, 'DCS24', 'CS601', 'Monday', 'TS4', '2025-08-22 03:27:57'),
(30, 'DCS24', 'CS601', 'Monday', 'TS5', '2025-08-22 03:28:22'),
(31, 'DCS24', 'CS601', 'Monday', 'TS6', '2025-08-22 03:28:30'),
(32, 'DCS24', 'CS610', 'Monday', 'TS1', '2025-08-22 03:28:47'),
(33, 'DCS24', 'CS610', 'Monday', 'TS2', '2025-08-22 03:28:54'),
(34, 'DCS24', 'CS610', 'Monday', 'TS3', '2025-08-22 03:29:11'),
(35, 'DCS24', 'CS610', 'Monday', 'TS4', '2025-08-22 03:29:22'),
(36, 'DCS24', 'CS610', 'Monday', 'TS5', '2025-08-22 03:29:31'),
(37, 'DCS24', 'CS610', 'Monday', 'TS6', '2025-08-22 03:29:45'),
(38, 'DCS24', 'CS601', 'Tuesday', 'TS1', '2025-08-22 03:30:48'),
(39, 'DCS24', 'CS601', 'Tuesday', 'TS2', '2025-08-22 03:30:56'),
(40, 'DCS24', 'CS601', 'Tuesday', 'TS3', '2025-08-22 03:31:03'),
(41, 'DCS24', 'CS601', 'Tuesday', 'TS4', '2025-08-22 03:31:11'),
(42, 'DCS24', 'CS601', 'Tuesday', 'TS5', '2025-08-22 03:31:22'),
(43, 'DCS24', 'CS601', 'Tuesday', 'TS6', '2025-08-22 03:31:37'),
(44, 'DCS24', 'CS610', 'Tuesday', 'TS1', '2025-08-22 03:31:44'),
(45, 'DCS24', 'CS610', 'Tuesday', 'TS2', '2025-08-22 03:31:53'),
(46, 'DCS24', 'CS610', 'Tuesday', 'TS3', '2025-08-22 03:32:06'),
(47, 'DCS24', 'CS610', 'Tuesday', 'TS4', '2025-08-22 03:32:18'),
(48, 'DCS24', 'CS610', 'Tuesday', 'TS5', '2025-08-22 03:39:23'),
(49, 'DCS24', 'CS610', 'Tuesday', 'TS6', '2025-08-22 03:39:38'),
(101, 'DCS51', 'CS201', 'Monday', 'TS1', '2025-08-22 03:52:15'),
(102, 'DCS51', 'CS201', 'Monday', 'TS2', '2025-08-22 03:52:15'),
(103, 'DCS51', 'CS201', 'Monday', 'TS3', '2025-08-22 03:52:15'),
(104, 'DCS51', 'CS201', 'Monday', 'TS4', '2025-08-22 03:52:15'),
(105, 'DCS51', 'CS201', 'Monday', 'TS5', '2025-08-22 03:52:15'),
(106, 'DCS51', 'CS201', 'Monday', 'TS6', '2025-08-22 03:52:15'),
(108, 'DCS51', 'CS201', 'Tuesday', 'TS6', '2025-08-22 03:53:26'),
(109, 'DCS51', 'CS201', 'Wednesday', 'TS6', '2025-08-22 03:53:26'),
(110, 'DCS51', 'CS201', 'Thursday', 'TS6', '2025-08-22 03:53:26'),
(111, 'DCS51', 'CS201', 'Friday', 'TS6', '2025-08-22 03:53:26'),
(112, 'DCS51', 'CS301', 'Monday', 'TS1', '2025-08-22 04:07:29'),
(113, 'DCS51', 'CS301', 'Monday', 'TS2', '2025-08-22 04:07:29'),
(114, 'DCS51', 'CS301', 'Monday', 'TS3', '2025-08-22 04:07:29'),
(115, 'DCS51', 'CS301', 'Monday', 'TS4', '2025-08-22 04:07:29'),
(116, 'DCS51', 'CS301', 'Monday', 'TS5', '2025-08-22 04:07:29'),
(117, 'DCS51', 'CS301', 'Monday', 'TS6', '2025-08-22 04:07:29'),
(118, 'DCS51', 'CS604', 'Monday', 'TS1', '2025-08-22 04:07:48'),
(119, 'DCS51', 'CS604', 'Monday', 'TS2', '2025-08-22 04:07:48'),
(120, 'DCS51', 'CS604', 'Monday', 'TS3', '2025-08-22 04:07:48'),
(121, 'DCS51', 'CS604', 'Monday', 'TS4', '2025-08-22 04:07:48'),
(122, 'DCS51', 'CS604', 'Monday', 'TS5', '2025-08-22 04:07:48'),
(123, 'DCS51', 'CS604', 'Monday', 'TS6', '2025-08-22 04:07:48'),
(125, 'DCS51', 'CS703', 'Monday', 'TS1', '2025-08-22 04:10:08'),
(126, 'DCS51', 'CS703', 'Monday', 'TS2', '2025-08-22 04:10:08'),
(127, 'DCS51', 'CS703', 'Monday', 'TS3', '2025-08-22 04:10:08'),
(128, 'DCS51', 'CS703', 'Monday', 'TS4', '2025-08-22 04:10:08'),
(129, 'DCS51', 'CS703', 'Monday', 'TS5', '2025-08-22 04:10:08'),
(130, 'DCS51', 'CS703', 'Monday', 'TS6', '2025-08-22 04:10:08'),
(132, 'DCS51', 'CS301', 'Tuesday', 'TS6', '2025-08-22 04:10:45'),
(133, 'DCS51', 'CS301', 'Wednesday', 'TS6', '2025-08-22 04:10:45'),
(134, 'DCS51', 'CS301', 'Thursday', 'TS6', '2025-08-22 04:10:45'),
(135, 'DCS51', 'CS301', 'Friday', 'TS6', '2025-08-22 04:10:45'),
(137, 'DCS51', 'CS604', 'Tuesday', 'TS6', '2025-08-22 04:11:46'),
(138, 'DCS51', 'CS604', 'Wednesday', 'TS6', '2025-08-22 04:11:46'),
(139, 'DCS51', 'CS604', 'Thursday', 'TS6', '2025-08-22 04:11:46'),
(140, 'DCS51', 'CS604', 'Friday', 'TS6', '2025-08-22 04:11:46'),
(142, 'DCS51', 'CS703', 'Tuesday', 'TS6', '2025-08-22 04:13:04'),
(143, 'DCS51', 'CS703', 'Wednesday', 'TS6', '2025-08-22 04:13:04'),
(144, 'DCS51', 'CS703', 'Thursday', 'TS6', '2025-08-22 04:13:04'),
(145, 'DCS51', 'CS703', 'Friday', 'TS6', '2025-08-22 04:13:04'),
(146, 'DCS42', 'CS201', 'Monday', 'TS2', '2025-08-22 04:14:10'),
(147, 'DCS42', 'CS201', 'Tuesday', 'TS2', '2025-08-22 04:14:10'),
(148, 'DCS42', 'CS201', 'Wednesday', 'TS2', '2025-08-22 04:14:10'),
(149, 'DCS42', 'CS201', 'Thursday', 'TS2', '2025-08-22 04:14:10'),
(150, 'DCS42', 'CS201', 'Friday', 'TS2', '2025-08-22 04:14:10'),
(151, 'DCS42', 'CS401', 'Monday', 'TS2', '2025-08-22 04:14:22'),
(152, 'DCS42', 'CS401', 'Tuesday', 'TS2', '2025-08-22 04:14:22'),
(153, 'DCS42', 'CS401', 'Wednesday', 'TS2', '2025-08-22 04:14:22'),
(154, 'DCS42', 'CS401', 'Thursday', 'TS2', '2025-08-22 04:14:22'),
(155, 'DCS42', 'CS401', 'Friday', 'TS2', '2025-08-22 04:14:22'),
(156, 'DCS42', 'CS606', 'Monday', 'TS2', '2025-08-22 04:14:44'),
(157, 'DCS42', 'CS606', 'Tuesday', 'TS2', '2025-08-22 04:14:44'),
(158, 'DCS42', 'CS606', 'Wednesday', 'TS2', '2025-08-22 04:14:44'),
(159, 'DCS42', 'CS606', 'Thursday', 'TS2', '2025-08-22 04:14:44'),
(160, 'DCS42', 'CS606', 'Friday', 'TS2', '2025-08-22 04:14:44'),
(161, 'DCS42', 'CS701', 'Monday', 'TS2', '2025-08-22 04:16:10'),
(162, 'DCS42', 'CS701', 'Tuesday', 'TS2', '2025-08-22 04:16:10'),
(163, 'DCS42', 'CS701', 'Wednesday', 'TS2', '2025-08-22 04:16:10'),
(164, 'DCS42', 'CS701', 'Thursday', 'TS2', '2025-08-22 04:16:10'),
(165, 'DCS42', 'CS701', 'Friday', 'TS2', '2025-08-22 04:16:10'),
(166, 'DCS52', 'CS201', 'Monday', 'TS1', '2025-08-22 04:18:03'),
(167, 'DCS52', 'CS201', 'Monday', 'TS2', '2025-08-22 04:18:30'),
(168, 'DCS52', 'CS201', 'Monday', 'TS3', '2025-08-22 04:18:36'),
(169, 'DCS52', 'CS301', 'Monday', 'TS1', '2025-08-22 04:18:54'),
(170, 'DCS52', 'CS301', 'Monday', 'TS2', '2025-08-22 04:20:06'),
(171, 'DCS52', 'CS301', 'Monday', 'TS3', '2025-08-22 04:20:14'),
(172, 'DCS52', 'CS304', 'Monday', 'TS1', '2025-08-22 04:20:29'),
(173, 'DCS52', 'CS304', 'Monday', 'TS2', '2025-08-22 04:20:38'),
(174, 'DCS52', 'CS304', 'Monday', 'TS3', '2025-08-22 04:20:56'),
(175, 'DCS52', 'CS201', 'Tuesday', 'TS1', '2025-08-22 04:21:18'),
(176, 'DCS52', 'CS201', 'Tuesday', 'TS2', '2025-08-22 04:21:25'),
(177, 'DCS52', 'CS201', 'Tuesday', 'TS3', '2025-08-22 04:21:30'),
(178, 'DCS52', 'CS301', 'Tuesday', 'TS1', '2025-08-22 04:21:40'),
(179, 'DCS52', 'CS301', 'Tuesday', 'TS2', '2025-08-22 04:21:48'),
(180, 'DCS52', 'CS301', 'Tuesday', 'TS3', '2025-08-22 04:24:11'),
(181, 'DCS52', 'CS304', 'Tuesday', 'TS1', '2025-08-22 04:25:20'),
(182, 'DCS52', 'CS304', 'Tuesday', 'TS2', '2025-08-22 04:25:28'),
(183, 'DCS52', 'CS304', 'Tuesday', 'TS3', '2025-08-22 04:25:35'),
(184, 'DCS52', 'CS201', 'Wednesday', 'TS1', '2025-08-22 04:26:15'),
(185, 'DCS52', 'CS201', 'Wednesday', 'TS2', '2025-08-22 04:26:19'),
(186, 'DCS52', 'CS201', 'Wednesday', 'TS3', '2025-08-22 04:26:23'),
(187, 'DCS52', 'CS301', 'Wednesday', 'TS1', '2025-08-22 04:26:32'),
(188, 'DCS52', 'CS301', 'Wednesday', 'TS2', '2025-08-22 04:26:45'),
(189, 'DCS52', 'CS301', 'Wednesday', 'TS3', '2025-08-22 04:26:55'),
(190, 'DCS52', 'CS304', 'Wednesday', 'TS1', '2025-08-22 04:27:16'),
(191, 'DCS52', 'CS304', 'Wednesday', 'TS2', '2025-08-22 04:27:24'),
(192, 'DCS52', 'CS304', 'Wednesday', 'TS3', '2025-08-22 04:27:30'),
(193, 'DM51', 'MTH101', 'Monday', 'TS5', '2025-08-22 04:28:09'),
(194, 'DM51', 'MTH101', 'Tuesday', 'TS5', '2025-08-22 04:28:09'),
(195, 'DM51', 'MTH101', 'Wednesday', 'TS5', '2025-08-22 04:28:09'),
(196, 'DM51', 'MTH101', 'Thursday', 'TS5', '2025-08-22 04:28:09'),
(197, 'DM51', 'MTH101', 'Friday', 'TS5', '2025-08-22 04:28:09'),
(198, 'DM51', 'MTH201', 'Monday', 'TS5', '2025-08-22 04:28:30'),
(199, 'DM51', 'MTH201', 'Tuesday', 'TS5', '2025-08-22 04:28:30'),
(200, 'DM51', 'MTH201', 'Wednesday', 'TS5', '2025-08-22 04:28:30'),
(201, 'DM51', 'MTH201', 'Thursday', 'TS5', '2025-08-22 04:28:30'),
(202, 'DM51', 'MTH201', 'Friday', 'TS5', '2025-08-22 04:28:30');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `ScheduleID` int(11) NOT NULL,
  `CourseCode` varchar(10) NOT NULL,
  `FacultyID` varchar(10) NOT NULL,
  `ClassroomID` varchar(10) NOT NULL,
  `Day` varchar(10) NOT NULL,
  `TimeSlotID` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`ScheduleID`, `CourseCode`, `FacultyID`, `ClassroomID`, `Day`, `TimeSlotID`) VALUES
(1, 'CS201', 'DCS42', 'B2-F0-05', 'Monday', 'TS2'),
(2, 'CS201', 'DCS51', 'B2-F0-05', 'Friday', 'TS6'),
(3, 'CS201', 'DCS52', 'B2-F0-05', 'Tuesday', 'TS1'),
(4, 'CS201', 'DCS52', 'B2-F0-05', 'Wednesday', 'TS3'),
(5, 'CS301', 'DCS51', 'B1-F0-01', 'Monday', 'TS6'),
(6, 'CS301', 'DCS51', 'B1-F0-02', 'Friday', 'TS6'),
(7, 'CS301', 'DCS52', 'B1-F0-01', 'Tuesday', 'TS1'),
(8, 'CS301', 'DCS52', 'B1-F0-02', 'Wednesday', 'TS1'),
(9, 'CS304', 'DCS52', 'B1-F0-01', 'Monday', 'TS2'),
(10, 'CS304', 'DCS52', 'B1-F0-02', 'Tuesday', 'TS2'),
(11, 'CS304', 'DCS52', 'B1-F0-01', 'Wednesday', 'TS3'),
(12, 'CS401', 'DCS23', 'B1-F0-02', 'Tuesday', 'TS3'),
(13, 'CS401', 'DCS23', 'B1-F0-01', 'Thursday', 'TS5'),
(14, 'CS601', 'DCS24', 'B1-F1-02', 'Monday', 'TS1'),
(15, 'CS601', 'DCS24', 'B2-F0-01', 'Tuesday', 'TS1'),
(16, 'CS604', 'DCS51', 'B1-F0-02', 'Monday', 'TS5'),
(17, 'CS610', 'DCS24', 'B1-F1-02', 'Monday', 'TS2'),
(18, 'CS610', 'DCS24', 'B2-F0-01', 'Tuesday', 'TS2'),
(19, 'CS701', 'DCS23', 'B1-F1-01', 'Tuesday', 'TS3'),
(20, 'CS701', 'DCS23', 'B1-F1-02', 'Thursday', 'TS3'),
(21, 'CS701', 'DCS42', 'B1-F1-01', 'Friday', 'TS2'),
(22, 'CS703', 'DCS51', 'B1-F1-01', 'Monday', 'TS6'),
(23, 'CS703', 'DCS51', 'B1-F1-02', 'Friday', 'TS6'),
(24, 'CS703', 'DCS51', 'B2-F0-01', 'Thursday', 'TS6'),
(25, 'CS704', 'DCS23', 'B2-F0-01', 'Tuesday', 'TS3'),
(26, 'CS704', 'DCS23', 'B1-F1-01', 'Thursday', 'TS5'),
(27, 'MTH101', 'DM51', 'B1-F1-02', 'Friday', 'TS5'),
(28, 'MTH101', 'DM51', 'B2-F0-01', 'Thursday', 'TS5'),
(29, 'MTH101', 'DM51', 'B2-F0-05', 'Wednesday', 'TS5');

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `TimeSlotID` varchar(5) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `IsBreak` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`TimeSlotID`, `StartTime`, `EndTime`, `IsBreak`) VALUES
('TS1', '08:00:00', '09:30:00', 0),
('TS2', '09:30:00', '11:00:00', 0),
('TS3', '11:00:00', '12:30:00', 0),
('TS4', '12:30:00', '13:30:00', 1),
('TS5', '13:30:00', '15:00:00', 0),
('TS6', '15:00:00', '16:30:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`ClassroomID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`CourseCode`),
  ADD KEY `InstructorAssigned` (`InstructorAssigned`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`FacultyID`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`PrefID`),
  ADD KEY `FacultyID` (`FacultyID`),
  ADD KEY `CourseCode` (`CourseCode`),
  ADD KEY `TimeSlotID` (`TimeSlotID`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`ScheduleID`),
  ADD KEY `CourseCode` (`CourseCode`),
  ADD KEY `FacultyID` (`FacultyID`),
  ADD KEY `ClassroomID` (`ClassroomID`),
  ADD KEY `TimeSlotID` (`TimeSlotID`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`TimeSlotID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `preferences`
--
ALTER TABLE `preferences`
  MODIFY `PrefID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `ScheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`InstructorAssigned`) REFERENCES `faculty` (`FacultyID`);

--
-- Constraints for table `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `preferences_ibfk_1` FOREIGN KEY (`FacultyID`) REFERENCES `faculty` (`FacultyID`),
  ADD CONSTRAINT `preferences_ibfk_2` FOREIGN KEY (`CourseCode`) REFERENCES `courses` (`CourseCode`),
  ADD CONSTRAINT `preferences_ibfk_3` FOREIGN KEY (`TimeSlotID`) REFERENCES `timeslots` (`TimeSlotID`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`CourseCode`) REFERENCES `courses` (`CourseCode`),
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`FacultyID`) REFERENCES `faculty` (`FacultyID`),
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`ClassroomID`) REFERENCES `classrooms` (`ClassroomID`),
  ADD CONSTRAINT `schedule_ibfk_4` FOREIGN KEY (`TimeSlotID`) REFERENCES `timeslots` (`TimeSlotID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
