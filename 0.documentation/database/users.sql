-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2022 at 01:39 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ramsme`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `mobile_no` varchar(11) NOT NULL,
  `name_value` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `avenue` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `mobile_no`, `name_value`, `password`, `created_at`, `avenue`, `street`, `email`) VALUES
(7, '08033927733', 'jacob', '$2y$10$UT7V1Fa4I/qRJXz7Oj6.peflLKyP8bMRIqxNdv3oU0SeMRxsc6MZ.', '2021-07-17 23:17:11', 'plot56', 'plot56', 'y@u.n'),
(8, '08035997996', 'Josephine Yetu', '$2y$10$HIn4pDS/1T455XFfxcfNeedchQod7eL.jr.g/kImo1F56HCnc5UBC', '2021-07-18 13:40:48', 'Second', 'Plot 61B', 'm@y.com'),
(9, '08033333333', 'Emmanuel', '$2y$10$FJ/nkX.A5MgdnU76nFQQjOLCwzwi2ay4fEh.lHVlj03L5amYu0ZB2', '2021-07-18 13:37:11', 'abuja', 'kano', 'y@u.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`mobile_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
