-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2026 at 06:51 AM
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
-- Database: `okbima`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone_no` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `age` int(3) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `blood_group` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `email`, `password`, `name`, `phone_no`, `address`, `age`, `nationality`, `blood_group`) VALUES
(1, 'abc@gmail.com', '$2y$10$0I4EojXbXTZzXYoF1lH/DOcVPOpQjf6Sv5LDxyn9zApyfVRmXrBO6', 'tanmay', '8529637412', 'qwerty qwertyu erty', 25, 'indian', 'B+'),
(2, 'rahul@example.com', '$2y$10$GLZxBf1dxfjJWHaPqbddMe2tH6TA8SLwStXDhQdNOLcFmBznaz7Bq', 'Rahul Sharma', '9876543210', 'New Delhi, India', 21, 'Indian', 'B+'),
(3, 'rahul@example.com', '$2y$10$LdoSjBH5pKt8I8m3lidgEOzPW.k44e3P586Rq6bVjhHRIlL9FQS9O', 'Rahul Sharma', '9876543210', 'New Delhi, India', 21, 'Indian', 'B+'),
(4, 'rahul@example.com', '$2y$10$Gqo9PwuetLblFOsmZC2S2.J8yAhFMYjtqJjVN6q2Bi1KtZyMmwtsy', 'Rohit Sharma', '9856543210', 'New Delhi, India', 21, 'Indian', 'B+'),
(5, 'rahul@example.com', '$2y$10$ktX8uPFMSU91gbWsTGg0WubzxYptAh7TZxk.8XAIhFdwTZtDGq1mm', 'Rohit Sharma', '9856543210', 'New Delhi, India', 21, 'Indian', 'B+');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
