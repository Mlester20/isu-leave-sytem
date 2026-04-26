-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2026 at 05:07 PM
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
-- Database: `isu_leave_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `activites_log`
--

CREATE TABLE `activites_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `action` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `reference_table` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activites_log`
--

INSERT INTO `activites_log` (`id`, `user_id`, `role`, `action`, `module`, `reference_id`, `reference_table`, `description`, `ip_address`, `status`, `created_at`) VALUES
(1, 1, 'admin', 'LOGIN', 'AUTH', NULL, NULL, '0', '::1', 1, '2026-04-24 07:23:30'),
(2, 2, 'non_teaching', 'LOGIN', 'AUTH', NULL, NULL, '0', '::1', 1, '2026-04-24 07:24:03'),
(3, 1, 'admin', 'LOGIN', 'AUTH', NULL, NULL, '0', '::1', 1, '2026-04-24 07:26:39'),
(4, 1, 'admin', 'LOGIN', 'AUTH', NULL, NULL, '0', '::1', 1, '2026-04-24 07:26:49'),
(5, 3, 'teaching', 'LOGIN', 'AUTH', NULL, NULL, '0', '::1', 1, '2026-04-24 07:27:42'),
(6, 1, 'admin', 'LOGIN', 'AUTH', NULL, NULL, '0', '::1', 1, '2026-04-24 07:33:26'),
(7, 1, 'admin', 'DELETE', 'USERS', 6, NULL, '0', '::1', 1, '2026-04-24 07:37:12'),
(8, 1, 'admin', 'CREATE', 'USERS', NULL, NULL, '0', '::1', 1, '2026-04-24 07:37:57'),
(9, 1, 'admin', 'DELETE', 'USERS', 7, NULL, '0', '::1', 1, '2026-04-24 07:38:11'),
(10, 1, 'admin', 'LOGIN', 'AUTH', NULL, NULL, '0', '::1', 1, '2026-04-25 13:38:20'),
(11, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 13:57:15'),
(12, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 13:58:12'),
(13, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 14:00:35'),
(14, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 14:01:00'),
(15, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 14:01:59'),
(16, 1, 'admin', 'LOGIN', 'AUTH', NULL, NULL, '0', '::1', 1, '2026-04-25 14:28:20'),
(17, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 14:28:46'),
(18, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 14:29:18'),
(19, 1, 'admin', 'UPDATE', 'DEPARTMENT', 1, NULL, '0', '::1', 1, '2026-04-25 14:33:58'),
(20, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 14:39:50'),
(21, 1, 'admin', 'UPDATE', 'DEPARTMENT', 1, NULL, '0', '::1', 1, '2026-04-25 14:40:18'),
(22, 1, 'admin', 'DELETE', 'DEPARTMENT', 2, NULL, '0', '::1', 1, '2026-04-25 14:40:21'),
(23, 1, 'admin', 'UPDATE', 'DEPARTMENT', 1, NULL, '0', '::1', 1, '2026-04-25 14:42:43'),
(24, 1, 'admin', 'UPDATE', 'DEPARTMENT', 1, NULL, '0', '::1', 1, '2026-04-25 14:43:07'),
(25, 1, 'admin', 'DELETE', 'DEPARTMENT', 1, NULL, '0', '::1', 1, '2026-04-25 14:45:37'),
(26, 1, 'admin', 'CREATE', 'DEPARTMENT', NULL, NULL, '0', '::1', 1, '2026-04-25 14:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `created_at`, `updated_at`) VALUES
(3, 'Registar', '2026-04-25 14:45:43', '2026-04-25 14:45:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(50) DEFAULT NULL,
  `full_name` varchar(250) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `vacation_leave` int(11) DEFAULT NULL,
  `sick_leave` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_no`, `full_name`, `email`, `password`, `role`, `department_id`, `vacation_leave`, `sick_leave`, `created_at`, `updated_at`) VALUES
(1, 'ADM - 001', 'HRMO administrator', 'admin@isu.local', '$2y$10$YN67HL/Fx13U15rTSKBKM.dfAjCgfg1HhxOHnzR.fSaBzJjLQjsLq', 'admin', 3, 15, 15, '2026-04-25 14:49:10', '2026-04-22 16:00:00'),
(2, 'NT - 001', 'Non Teaching Personel Demo', 'nonteaching@isu.local', '$2y$10$dt4Vk/XabNjxOKgu6/Tn1.cutDwcAZOdKKGp3nELfhk5wr5P31zae', 'non_teaching', 3, 15, 15, '2026-04-25 14:49:10', '2026-04-22 16:00:00'),
(3, 'TCH - 001', 'Teaching Personel Demo', 'teaching@isu.local', '$2y$10$vUCtO6oqLUyS/NLjtACsYOCJo9u8ox8Pq.hwWmLmWRH1N1ExhGo1G', 'teaching', 3, 15, 15, '2026-04-25 14:49:10', '2026-04-25 14:49:10'),
(4, 'Head - 001', 'Campus Head', 'head@isu.local', '$2y$10$Zf5YSsa.L/sJfVj7IuvkPOA7lXS67sZzth0/FL0Hbp1wC80NpQV9.', 'head', 3, 15, 15, '2026-04-25 14:49:10', '2026-04-25 14:49:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activites_log`
--
ALTER TABLE `activites_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_logs_user` (`user_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_department` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activites_log`
--
ALTER TABLE `activites_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activites_log`
--
ALTER TABLE `activites_log`
  ADD CONSTRAINT `fk_user_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
