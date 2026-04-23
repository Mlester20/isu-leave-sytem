-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 09:22 AM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_no` varchar(50) DEFAULT NULL,
  `full_name` varchar(250) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `vacation_leave` int(11) DEFAULT NULL,
  `sick_leave` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_no`, `full_name`, `email`, `password`, `role`, `department`, `vacation_leave`, `sick_leave`, `created_at`, `updated_at`) VALUES
(1, 'ADM - 001', 'HRMO administrator', 'admin@isu.local', '$2y$10$YN67HL/Fx13U15rTSKBKM.dfAjCgfg1HhxOHnzR.fSaBzJjLQjsLq', 'admin', 'HRMO', 15, 15, NULL, NULL),
(2, 'NT - 001', 'Non Teaching Personel Demo', 'nonteaching@isu.local', '$2y$10$dt4Vk/XabNjxOKgu6/Tn1.cutDwcAZOdKKGp3nELfhk5wr5P31zae', 'non_teaching', 'registrar', 15, 15, NULL, NULL),
(3, 'TCH - 001', 'Teaching Personel Demo', 'teaching@isu.local', '$2y$10$vUCtO6oqLUyS/NLjtACsYOCJo9u8ox8Pq.hwWmLmWRH1N1ExhGo1G', 'teaching', 'IICT', 15, 15, NULL, NULL),
(4, 'Head - 001', 'Campus Head', 'head@isu.local', '$2y$10$Zf5YSsa.L/sJfVj7IuvkPOA7lXS67sZzth0/FL0Hbp1wC80NpQV9.', 'head', 'Head', 15, 15, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
