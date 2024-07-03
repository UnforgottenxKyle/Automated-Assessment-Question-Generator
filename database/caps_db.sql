-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2024 at 08:52 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caps_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `choice_list`
--

CREATE TABLE `choice_list` (
  `question_id` int(11) NOT NULL,
  `choice` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `choice_list`
--

INSERT INTO `choice_list` (`question_id`, `choice`) VALUES
(1, 'Nullam eu dui scelerisque'),
(1, 'viverra nisi sit amet'),
(1, 'volutpat ipsum'),
(1, 'Aenean odio nunc'),
(2, 'Choice 1'),
(2, 'Choice 2'),
(2, 'Choice 2'),
(2, 'Choice 4'),
(2, 'Choice 5'),
(5, 'Choice 1'),
(5, 'Choice 2'),
(5, 'Choice 3'),
(6, 'Option 1'),
(6, 'Option 2'),
(6, 'Option 3'),
(7, 'Choice 101'),
(7, 'Choice 102'),
(7, 'Choice 103'),
(9, 'Option 101'),
(9, 'Option 102'),
(9, 'Option 103'),
(9, 'Option 104'),
(9, 'Option 105'),
(8, 'option 101'),
(8, 'option 102'),
(8, 'option 103'),
(8, 'option 104'),
(8, 'option 105'),
(13, 'eqweqwe');

-- --------------------------------------------------------

--
-- Table structure for table `class_list`
--

CREATE TABLE `class_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `class_list`
--

INSERT INTO `class_list` (`id`, `user_id`, `course_id`, `name`, `description`, `delete_flag`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, 3, 'BSIS 1A - Test101', 'Sample Class only', 0, 1, '2022-02-23 13:16:28', NULL),
(2, 1, 2, 'BSIT 1B - Test102', 'Sample Class for Test 102 Subject.', 0, 1, '2022-02-23 13:17:58', NULL),
(3, 1, 3, 'BSIS', 'Bachelor of Science in Information Systems', 1, 1, '2022-02-23 13:19:14', '2022-02-23 13:20:10'),
(4, 13, 5, 'bsit4a', 'quiz', 0, 1, '2023-12-28 18:08:03', NULL),
(5, 75, 6, 'bsit4a', 'qew', 0, 1, '2024-02-03 14:38:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_list`
--

CREATE TABLE `course_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_list`
--

INSERT INTO `course_list` (`id`, `user_id`, `name`, `description`, `delete_flag`, `status`, `date_created`, `date_updated`) VALUES
(2, 1, 'BSIT', 'Bachelor of Science in Information Technology', 1, 1, '2022-02-23 12:07:00', '2023-11-28 22:38:36'),
(3, 1, 'BSIS', 'Bachelor of Science in Information Systems', 1, 1, '2022-02-23 13:00:12', '2023-11-28 22:38:31'),
(4, 1, 'test', 'test', 1, 1, '2022-02-23 13:18:11', '2022-02-23 13:18:57'),
(5, 13, 'bsit4a', 'quiz', 0, 1, '2023-12-28 18:07:46', NULL),
(6, 75, 'bsit', '', 0, 1, '2024-02-03 14:37:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question_list`
--

CREATE TABLE `question_list` (
  `id` int(11) NOT NULL,
  `question_paper_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `mark` double NOT NULL DEFAULT 0,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = single answer, \r\n2= multi-answer,\r\n3 = text answer,\r\n4 = enumeration,\r\n5 = identification'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_list`
--

INSERT INTO `question_list` (`id`, `question_paper_id`, `question`, `mark`, `type`) VALUES
(1, 2, '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">Vestibulum non turpis dui. Aliquam rutrum semper neque id faucibus. Praesent et interdum tortor. Nulla tortor magna, tincidunt in elementum et, laoreet vitae mi. Curabitur ultrices sapien vitae fringilla scelerisque. Phasellus feugiat ac nisl quis aliquet. Nulla facilisi. Duis eget justo laoreet quam pretium varius.</span><br></p>', 5, 1),
(2, 2, '<p>Question 101</p>', 5, 2),
(3, 2, '<p><span style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">Nam in condimentum augue. Morbi efficitur facilisis dolor eu molestie. Suspendisse faucibus lorem et finibus ultricies. Maecenas feugiat ultrices metus, id pellentesque elit. Maecenas eros nunc, accumsan a augue ac, scelerisque ullamcorper dolor. Curabitur aliquet dapibus quam. Sed est ipsum, egestas vel odio vel, varius rutrum mauris. In tempor mi a eleifend imperdiet. Donec nec laoreet lectus, quis viverra neque. Donec a consectetur diam.</span><br></p>', 15, 3),
(5, 2, '<p>Question 102</p>', 1, 1),
(6, 2, '<p>Question 103</p>', 1, 1),
(7, 2, '<p>Multiple 102</p>', 5, 2),
(8, 2, '<p>Multiple 103</p>', 10, 2),
(9, 2, '<p>Multiple 103</p>', 10, 2),
(10, 2, '<p>Sample Question only</p>', 20, 3),
(11, 4, '', 0, 2),
(12, 4, '', 0, 2),
(13, 5, '<p>qweqweqw</p>', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `question_paper_list`
--

CREATE TABLE `question_paper_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_paper_list`
--

INSERT INTO `question_paper_list` (`id`, `user_id`, `class_id`, `title`, `description`, `delete_flag`, `status`, `date_created`, `date_updated`) VALUES
(1, 1, 1, 'Sample Exam 101', 'Nam in condimentum augue. Morbi efficitur facilisis dolor eu molestie. Suspendisse faucibus lorem et finibus ultricies. Maecenas feugiat ultrices metus, id pellentesque elit. Maecenas eros nunc, accumsan a augue ac, scelerisque ullamcorper dolor. Curabitur aliquet dapibus quam. Sed est ipsum, egestas vel odio vel, varius rutrum mauris. In tempor mi a eleifend imperdiet. Donec nec laoreet lectus, quis viverra neque. Donec a consectetur diam.', 0, 1, '2022-02-23 13:37:01', NULL),
(2, 1, 2, 'Sample Exam 2', 'Vestibulum non turpis dui. Aliquam rutrum semper neque id faucibus. Praesent et interdum tortor. Nulla tortor magna, tincidunt in elementum et, laoreet vitae mi. Curabitur ultrices sapien vitae fringilla scelerisque. Phasellus feugiat ac nisl quis aliquet. Nulla facilisi. Duis eget justo laoreet quam pretium varius.', 0, 1, '2022-02-23 13:42:57', NULL),
(3, 1, 1, 'test', 'test', 1, 0, '2022-02-23 13:55:24', '2022-02-23 13:55:27'),
(4, 13, 4, 'quiz no1', 'follow the ff', 0, 1, '2023-12-28 18:08:36', NULL),
(5, 75, 5, 'longquiiz', 'qwe', 0, 1, '2024-02-03 14:38:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `registered_user_list`
--

CREATE TABLE `registered_user_list` (
  `id` int(11) NOT NULL,
  `firstname` text NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` text NOT NULL,
  `gender` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `register_from` int(11) NOT NULL DEFAULT 0,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `contact` text NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `activation_code` varchar(255) DEFAULT NULL,
  `password_code` varchar(255) DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_user_list`
--

INSERT INTO `registered_user_list` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `dob`, `register_from`, `verified`, `contact`, `email`, `password`, `avatar`, `status`, `delete_flag`, `date_created`, `date_updated`, `activation_code`, `password_code`, `verified_at`) VALUES
(1, 'Claire', 'D', 'Blake', 'Female', '1997-10-14', 0, 1, '09456789123', 'cblake@sample.com', '4744ddea876b11dcb1d169fadf494418', 'uploads/rusers/1.jpg?v=1645586877', 1, 0, '2022-02-23 11:27:57', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(2, 'Mark', 'C', 'Cooper', 'Male', '1997-07-15', 0, 1, '0912456789', 'mcooper@sample.com', 'c7162ff89c647f444fcaa5c635dac8c3', 'uploads/rusers/2.png?v=1645586987', 1, 0, '2022-02-23 11:29:47', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(3, 'gio', 'ong', 'arrive', 'Male', '2023-11-01', 0, 1, '0999999999', 'gio@gmail.com', '4297f44b13955235245b2497399d7a93', '', 0, 0, '2023-11-28 11:46:04', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(11, 'grifin123', 'kyle123', 'asa123', 'Male', '2002-06-04', 0, 1, 'asdjklakshdfljkgf', 'kyle@yahoo.com', '123123123', '', 1, 0, '2023-11-28 20:42:47', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(12, 'gio1', 'ong1', 'arrive1', 'Male', '2023-11-02', 0, 1, '0999999999', 'gio1@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'uploads/rusers/12.png?v=1701180763', 1, 0, '2023-11-28 22:12:43', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(13, 'grifin', 'kyle', 'asa', 'Male', '2023-11-30', 0, 1, '0999999999', 'kyle1@yahoo.com', '$2y$10$YtZwdAlNo.Pl. MrihTb5Z.mX0afCxA3YpCa0xe4Vv5jkMoD6S2vm.', '', 1, 0, '2023-12-26 20:51:17', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(14, 'grifin', 'kyle', 'asa', 'Male', '2023-12-01', 0, 1, '0999999999', 'kyle2@yahoo.com', '$2y$10$UltU.gJqHXFmGkJOfFj1buvgBp7gO67AmGs9/CUdWqnEQiCrQEbn2', '', 1, 0, '2023-12-29 17:04:08', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(15, 'grifin', 'kyle', 'asa', 'Male', '2023-12-09', 0, 1, '0999999999', 'kyle3@yahoo.com', '202cb962ac59075b964b07152d234b70', '', 1, 0, '2023-12-29 17:11:49', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(16, 'grifin', 'kyle', 'asa', 'Male', '2023-11-04', 0, 1, '0999999999', 'kyle4@yahoo.com', '4297f44b13955235245b2497399d7a93', '', 1, 0, '2023-12-30 00:12:59', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(17, 'grifin', 'kyle', 'asa', 'Male', '2023-11-04', 0, 1, '0999999999', 'kyle5@yahoo.com', '4297f44b13955235245b2497399d7a93', '', 1, 0, '2023-12-30 00:15:56', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(18, 'grifin', 'kyle', 'asa', 'Male', '2023-12-14', 0, 1, '0999999999', 'kyle6@yahoo.com', '4297f44b13955235245b2497399d7a93', '', 1, 0, '2023-12-30 00:25:35', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(19, 'grifin', 'kyle', 'asa', 'Male', '2023-12-30', 0, 1, '7889', 'kyle7@yahoo.com', '4297f44b13955235245b2497399d7a93', '', 1, 0, '2023-12-30 00:51:33', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(20, 'kyle', 'ong', 'grifin', 'Male', '2002-06-04', 0, 1, '123123123123', 'kkk@gmail.com', '123123', '', 1, 0, '2024-01-03 17:43:29', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(21, 'grifin', 'kyle', 'asa', 'Male', '2002-06-04', 0, 1, '099999999999999', 'kyle10@yahoo.com', '123123', '', 1, 0, '2024-01-10 21:50:26', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(22, 'grifin', 'kyle', 'asa', 'Male', '2005-04-10', 0, 1, '123123123123123', 'kyle44@yahoo.com', '123123', '', 1, 0, '2024-01-10 22:56:49', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(23, 'grifin', 'kyle', 'asa', 'Male', '2004-03-05', 0, 1, '099999999999999', 'kyle444@yahoo.com', '123123', '', 1, 0, '2024-01-13 21:22:01', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(24, 'grifin', 'kyle', 'asa', 'Male', '2003-08-07', 0, 1, '099999999999999', 'kyle123@yahoo.com', '123', '', 1, 0, '2024-01-13 22:07:05', '2024-02-02 13:48:05', NULL, NULL, '2024-02-02 13:48:05'),
(75, 'Grfn', NULL, 'Kyle19', '', '1000-10-10', 1, 1, '', 'grifin4kyle@gmail.com', '8281c5e73d764569c7558177468f6de0', 'https://lh3.googleusercontent.com/a/ACg8ocKL15pchIOOh9IcHWk_H1AfAgKLxwXcK1SErOJ9y6RZGvc=s96-c', 1, 0, '2024-02-03 14:25:55', NULL, 'aa3234c6ceb424207dc2af74a979249e', NULL, NULL),
(76, 'GRIFIN KYLE', NULL, 'ASA', '', '1000-10-10', 1, 1, '', 'grifinkyle.asa@cvsu.edu.ph', '4297f44b13955235245b2497399d7a93', 'https://lh3.googleusercontent.com/a/ACg8ocIX1bgcb1JGjZ9l8CX1UmSfOVGx9zJBU_-NfigCEdTPpA=s96-c', 1, 0, '2024-02-03 14:35:24', '2024-02-03 14:37:17', '8832d9f773839813197f314a4b10201b', '', NULL),
(77, 'grifn', 'grifin', 'kyle', 'Male', '2000-12-12', 0, 0, '123123', 'grifin@gmail.com', '0d7ca6f92d867ebe2e17877ce4407f2a', NULL, 1, 0, '2024-02-03 20:12:37', NULL, '9844162dd9285a2acebe7810d3bd8f03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(11) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Automated Assessment Paper Generator'),
(6, 'short_name', 'CAPSTONE'),
(11, 'logo', 'uploads/logo-1707032671.png?v=1707032671'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1645577488.jpg?v=1645577488'),
(15, 'company_name', 'TechSoft Solutions'),
(16, 'company_tel_no', '+456 789 1234'),
(17, 'company_mobile', '+639 102 456 7896'),
(18, 'company_email', 'info@sample.com'),
(19, 'company_address', 'Block 23 Lot 6, 14th St., Here Subd., There City, Anywhere, 2306, Philippines'),
(20, 'company_description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum quam nulla, eu ultricies odio aliquet sit amet. Pellentesque ullamcorper magna vitae feugiat tempor. Phasellus efficitur, ligula non accumsan vulputate, felis lacus lobortis sem, commodo rutrum elit ligula vitae dolor. Cras tristique turpis nunc, vel porttitor ligula maximus ac. Quisque a vehicula felis. Aenean condimentum lectus et purus vulputate egestas. Duis quis scelerisque orci. Sed urna ligula, cursus quis turpis vitae, porta rhoncus arcu. Suspendisse gravida vulputate laoreet.'),
(21, 'company_name', 'TechSoft Solutions'),
(22, 'company_tel_no', '+456 789 1234'),
(23, 'company_mobile', '+639 102 456 7896'),
(24, 'company_email', 'info@sample.com'),
(25, 'company_address', 'Block 23 Lot 6, 14th St., Here Subd., There City, Anywhere, 2306, Philippines'),
(26, 'company_description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum quam nulla, eu ultricies odio aliquet sit amet. Pellentesque ullamcorper magna vitae feugiat tempor. Phasellus efficitur, ligula non accumsan vulputate, felis lacus lobortis sem, commodo rutrum elit ligula vitae dolor. Cras tristique turpis nunc, vel porttitor ligula maximus ac. Quisque a vehicula felis. Aenean condimentum lectus et purus vulputate egestas. Duis quis scelerisque orci. Sed urna ligula, cursus quis turpis vitae, porta rhoncus arcu. Suspendisse gravida vulputate laoreet.'),
(27, 'company_name', 'TechSoft Solutions'),
(28, 'company_tel_no', '+456 789 1234'),
(29, 'company_mobile', '+639 102 456 7896'),
(30, 'company_email', 'info@sample.com'),
(31, 'company_address', 'Block 23 Lot 6, 14th St., Here Subd., There City, Anywhere, 2306, Philippines'),
(32, 'company_description', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur fermentum quam nulla, eu ultricies odio aliquet sit amet. Pellentesque ullamcorper magna vitae feugiat tempor. Phasellus efficitur, ligula non accumsan vulputate, felis lacus lobortis sem, commodo rutrum elit ligula vitae dolor. Cras tristique turpis nunc, vel porttitor ligula maximus ac. Quisque a vehicula felis. Aenean condimentum lectus et purus vulputate egestas. Duis quis scelerisque orci. Sed urna ligula, cursus quis turpis vitae, porta rhoncus arcu. Suspendisse gravida vulputate laoreet.'),
(33, 'company_name', '1'),
(34, 'company_tel_no', '1'),
(35, 'company_mobile', '1'),
(36, 'company_email', '1@gmail.com'),
(37, 'company_address', '1'),
(38, 'company_description', '1'),
(39, 'company_name', 'BSIT4A'),
(40, 'company_tel_no', '1'),
(41, 'company_mobile', '1'),
(42, 'company_email', '1@gmail.com'),
(43, 'company_address', '1'),
(44, 'company_description', '1'),
(45, 'company_name', 'BSIT 4A'),
(46, 'company_tel_no', '1'),
(47, 'company_mobile', '1'),
(48, 'company_email', '1@gmail.com'),
(49, 'company_address', '1'),
(50, 'company_description', '1'),
(51, 'company_name', 'BSIT-4A'),
(52, 'company_tel_no', '1'),
(53, 'company_mobile', '1'),
(54, 'company_email', '1@gmail.com'),
(55, 'company_address', '1'),
(56, 'company_description', '1'),
(57, 'company_name', 'BSIT-4A4'),
(58, 'company_tel_no', '14'),
(59, 'company_mobile', '14'),
(60, 'company_email', '14@gmail.com'),
(61, 'company_address', '14'),
(62, 'company_description', '14'),
(63, 'company_name', 'BSIT-5a'),
(64, 'company_tel_no', '5'),
(65, 'company_mobile', '5'),
(66, 'company_email', '5@gmail.com'),
(67, 'company_address', '5'),
(68, 'company_description', '5'),
(69, 'company_name', 'BSIT-55a'),
(70, 'company_tel_no', '55'),
(71, 'company_mobile', '55'),
(72, 'company_email', '55@gmail.com'),
(73, 'company_address', '55'),
(74, 'company_description', '55'),
(75, 'company_name', '123'),
(76, 'company_tel_no', '123'),
(77, 'company_mobile', '123'),
(78, 'company_email', '123@gmail.com'),
(79, 'company_address', '23'),
(80, 'company_description', '123'),
(81, 'company_name', '123'),
(82, 'company_tel_no', '123'),
(83, 'company_mobile', '123'),
(84, 'company_email', '123@gmail.com'),
(85, 'company_address', '23'),
(86, 'company_description', '123'),
(87, 'company_name', '12323123123'),
(88, 'company_tel_no', '1231231'),
(89, 'company_mobile', '1233123'),
(90, 'company_email', '12123123@gmail.com'),
(91, 'company_address', '123123'),
(92, 'company_description', '123123'),
(93, 'company_name', '12323123123123'),
(94, 'company_tel_no', '1231231'),
(95, 'company_mobile', '1233123'),
(96, 'company_email', '12123123@gmail.com'),
(97, 'company_address', '123123'),
(98, 'company_description', '123123'),
(99, 'company_name', '123'),
(100, 'company_tel_no', '123'),
(101, 'company_mobile', '123'),
(102, 'company_email', '12323@gmail.com'),
(103, 'company_address', '123123'),
(104, 'company_description', '123123123'),
(105, 'company_name', 'BSIT'),
(106, 'company_tel_no', '4A'),
(107, 'company_mobile', '4A'),
(108, 'company_email', 'BSIT4A@gmail.com'),
(109, 'company_address', 'CVSU'),
(110, 'company_description', 'CAPSTONE');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatars/1.png?v=1645064505', NULL, 1, '2021-01-20 14:02:37', '2022-02-17 10:21:45'),
(5, 'John', 'Smith', 'jsmith', '1254737c076cf867dc53d60a0364f38e', 'uploads/avatars/5.png?v=1645514943', NULL, 2, '2022-02-22 15:29:03', '2022-02-22 15:34:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `choice_list`
--
ALTER TABLE `choice_list`
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `class_list`
--
ALTER TABLE `class_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_list`
--
ALTER TABLE `course_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `question_list`
--
ALTER TABLE `question_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_paper_id` (`question_paper_id`);

--
-- Indexes for table `question_paper_list`
--
ALTER TABLE `question_paper_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`class_id`);

--
-- Indexes for table `registered_user_list`
--
ALTER TABLE `registered_user_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_list`
--
ALTER TABLE `class_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `course_list`
--
ALTER TABLE `course_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `question_list`
--
ALTER TABLE `question_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `question_paper_list`
--
ALTER TABLE `question_paper_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registered_user_list`
--
ALTER TABLE `registered_user_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `choice_list`
--
ALTER TABLE `choice_list`
  ADD CONSTRAINT `choice_question_id_FK` FOREIGN KEY (`question_id`) REFERENCES `question_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `class_list`
--
ALTER TABLE `class_list`
  ADD CONSTRAINT `class_course_id_FK` FOREIGN KEY (`course_id`) REFERENCES `course_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `class_user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `registered_user_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `course_list`
--
ALTER TABLE `course_list`
  ADD CONSTRAINT `course_user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `registered_user_list` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `question_paper_list`
--
ALTER TABLE `question_paper_list`
  ADD CONSTRAINT `qp_class_id_FK` FOREIGN KEY (`class_id`) REFERENCES `class_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `qp_user_id FK` FOREIGN KEY (`user_id`) REFERENCES `registered_user_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
