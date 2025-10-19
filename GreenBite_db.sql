-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2025 at 04:52 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `GreenBite_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$fKszNSjhYJ7CVDebGgeRyuL.j2RwLD/33bez3XteKXad4XkwfU5U6', '2025-06-17 09:33:16'),
(2, 'admin123', 'admin123@gmail.com', '$2y$10$ezUzxlt8DM3ahJaJpGJS0ecxssIwL5ULsfdkTGSP0LGt1KmpIrXm.', '2025-10-19 13:36:26');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `food_description` text NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `pickup_time` datetime NOT NULL,
  `address` text NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `expires_at` datetime NOT NULL,
  `food_image` varchar(255) DEFAULT NULL,
  `food_type` enum('Cooked','Packed','Raw') NOT NULL,
  `status` enum('pending','accepted','expired') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `receiver_name` varchar(255) DEFAULT NULL,
  `receiver_contact` varchar(20) DEFAULT NULL,
  `receiver_email` varchar(255) DEFAULT NULL,
  `receiver_address` text DEFAULT NULL,
  `receiver_reason` text DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `donor_id`, `food_description`, `quantity`, `pickup_time`, `address`, `contact_number`, `expires_at`, `food_image`, `food_type`, `status`, `created_at`, `receiver_name`, `receiver_contact`, `receiver_email`, `receiver_address`, `receiver_reason`, `receiver_id`) VALUES
(1, 1, 'roti', '10', '1900-01-19 00:00:00', 'pune', '1230456789', '2025-06-20 00:00:00', 'uploads/img1.jpg', 'Cooked', 'accepted', '2025-06-14 11:01:40', 'ava', '1234567890', 'ava@gmail.com', 'pune', 'tx', 2),
(2, 1, 'dal roti', '20', '2025-06-19 00:00:00', 'pune', '1234569870', '2025-06-20 00:43:00', 'uploads/1749899466_img1.jpg', 'Packed', 'accepted', '2025-06-14 11:11:06', 'Rahul ', '6655443322', 'rahul.singh@example.com', 'pune', 'food ', 8),
(3, 1, 'rise dal', '20', '2025-06-16 15:00:00', 'mumbai', '1234569870', '2025-06-16 20:00:00', 'uploads/1749899576_img2.jpg', 'Cooked', 'expired', '2025-06-14 11:12:56', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 'dal roti rice', '20', '2025-06-14 19:45:00', 'pune', '1234569870', '1900-01-20 11:41:27', 'uploads/1749899716_img2.jpg', 'Cooked', 'accepted', '2025-06-21 11:15:16', 'aa', '1203654789', 'a@c.com', 'pune', 'thank you', 2),
(5, 1, 'pulav', '20', '2025-10-19 01:58:00', 'pune', '8563214796', '2025-10-19 06:58:00', 'uploads/1760811970_img4.jpg', 'Packed', 'expired', '2025-10-18 18:26:10', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 3, 'Vegetable Biryani', '15', '2025-10-20 23:00:00', 'Mumbai', '9876543210', '2025-10-21 04:00:00', 'uploads/1760880640_img7.jpg', 'Cooked', 'accepted', '2025-10-19 13:30:40', 'Sneha ', '9090908080', 'sneha.iyer@example.com', 'Mumbai', 'thank you', 9),
(7, 4, 'Paneer Butter Masala with Naan', '10', '2025-10-21 19:01:00', 'Delhi', '9988776655', '2025-10-22 00:01:00', 'uploads/1760880713_img3.jpg', 'Packed', 'pending', '2025-10-19 13:31:53', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 5, 'Rice', '20', '2025-10-23 07:08:00', 'Ahmedabad', '8877665544', '2025-10-23 12:08:00', 'uploads/1760880825_img5.jpg', 'Raw', 'expired', '2025-10-19 13:33:45', NULL, NULL, NULL, NULL, NULL, NULL),
(9, 6, 'Fruits and Juice Packs', '50', '2025-10-25 06:05:00', 'Surat', '7766554433', '2025-10-25 11:05:00', 'uploads/1760880925_img4.jpg', 'Packed', 'accepted', '2025-10-19 13:35:25', 'Arjun ', '7788990011', 'arjun.das@example.com', 'Surat', 'good ', 10),
(10, 1, 'roti', '10', '2025-10-20 16:00:00', 'mumbai', '7766554433', '2025-10-20 21:00:00', 'uploads/1760882103_img6.jpg', 'Cooked', 'pending', '2025-10-19 13:55:03', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `submitted_at`) VALUES
(1, 'ava', 'eva@gmail.com', 'cc', 'thank you', '2025-06-13 12:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('donor','receiver') NOT NULL DEFAULT 'receiver',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `contact`, `address`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Eva', '1236547890', 'pune', 'eva@gmail.com', '$2y$10$WvCfK7F.FI0uBelZNMnqSe2U9ul4rvnrdWO1V9bN1xe8Xczem7hSe', 'donor', '2025-06-14 10:16:55'),
(2, 'ava', '3214569870', 'pune', 'ava@gmail.com', '$2y$10$FYYm1IPTqUnqVXV996SlM.ErtomPxZMp0dpsVmM5MIXzGBFrcqK/K', 'receiver', '2025-06-14 10:18:35'),
(3, 'Rohit Kumar', '9876543210', 'Mumbai', 'rohit.kumar@example.com', '$2y$10$THw8Rwk3JFva3nj97f3bSe/qvFedNiDraJYNQ8wxPIf0c40GHYFIi', 'donor', '2025-05-21 02:47:03'),
(4, 'Priya Sharma', '9988776655', 'Delhi', 'priya.sharma@example.com', '$2y$10$.0XvgaqPYNuFhZH6vi1i1eGOPZ8QtSge3MRM7Hln8hMfK//StAh1y', 'donor', '2025-06-02 14:12:11'),
(5, 'Aditya Mehta', '8877665544', 'Ahmedabad', 'aditya.mehta@example.com', '$2y$10$JT.Cm8DdsvSfOCelDlejOO4h0dKqgzYOMN81FLp5nxl7cxWE0NDf2', 'donor', '2025-07-09 07:35:29'),
(6, 'Nisha Patel', '7766554433', 'Surat', 'nisha.patel@example.com', '$2y$10$UpxpGopba5tqDlGuVOzwiuR0Ho.zTFoeUBviW6aWxELkuSEWHKdeu', 'donor', '2025-07-25 17:28:47'),
(7, 'Karan Verma', '7012345678', 'Jaipur', 'karan.verma@example.com', '$2y$10$2LzXh3eBtD4Lp80p6mFIF.IbRzMDWJikYfxUsJxmcHkVRd3obShha', 'donor', '2025-08-03 01:03:12'),
(8, 'Rahul Singh', '6655443322', 'Pune', 'rahul.singh@example.com', '$2y$10$j3YrEgJaG72vXodvdBrRUOpyrt2yX4Mq5Mz2PFLGF3N7mWZYgO4B2', 'receiver', '2025-05-30 04:20:00'),
(9, 'Sneha Iyer', '9090908080', 'Mumbai', 'sneha.iyer@example.com', '$2y$10$DEKKZ7sdPsNFmvYUCK22tu.anXS79qUoHXjqkrhY6mtcOl3nnOKNi', 'receiver', '2025-06-11 10:50:33'),
(10, 'Arjun Das', '7788990011', 'Surat', 'arjun.das@example.com', '$2y$10$u0cdH75s2Iw4e2ZtK/.p8.jveU8np8j4DsPj6Bqz1CbNLhQNiX6z6', 'receiver', '2025-06-29 15:44:05'),
(11, 'Meera Joshi', '9099888777', 'Hyderabad', 'meera.joshi@example.com', '$2y$10$TGH/X0ttpm/BXhJqZWeZm.5fIOr5xNbBtse/jzz9BKAttLVQ0zh3y', 'receiver', '2025-07-14 06:31:56'),
(12, 'Vikram Rao', '8122334455', 'Pune', 'vikram.rao@example.com', '$2y$10$Yt3A1exon4Do2RUWK8uomOJd8/aNLA/L6NtuhGPlYqcGzeQLa7vhm', 'receiver', '2025-08-17 23:17:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donor_id` (`donor_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`donor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_receiver` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
