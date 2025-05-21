-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 06:19 AM
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
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `activity`, `timestamp`) VALUES
(1, 'Added product: cuns (Qty: 30)', '2025-05-18 15:14:39'),
(2, 'Updated product: cuns', '2025-05-18 15:46:32'),
(3, 'Updated product: cuns', '2025-05-18 16:05:06'),
(4, 'Updated product: cuns', '2025-05-18 16:13:14'),
(5, 'Updated product: cuns', '2025-05-18 16:35:38'),
(6, 'Deleted product: cuns', '2025-05-18 16:36:01'),
(7, 'Added product: tanginahmen (Qty: 49)', '2025-05-18 16:38:30'),
(8, 'Updated product: tanginahmen', '2025-05-18 16:38:42'),
(9, 'Added product: cunan (Qty: 500)', '2025-05-18 17:12:26'),
(10, 'Added product: ashley (Qty: 40)', '2025-05-18 17:12:46'),
(11, 'Added product: ashley (Qty: 40)', '2025-05-18 17:12:53'),
(12, 'Updated product: ashley', '2025-05-18 17:23:10'),
(13, 'Updated product: ashley', '2025-05-18 17:41:12'),
(14, 'Deleted product: cunan', '2025-05-18 18:24:29'),
(15, 'Deleted product: fetty wap', '2025-05-18 18:24:32'),
(16, 'Added product: runa (Qty: 90)', '2025-05-18 18:56:17'),
(17, 'Deleted product: tanginahmen', '2025-05-18 18:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `pdescript` text NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `pdescript`, `product_quantity`) VALUES
(5, 'ashley', 10000.00, 'manyaman', 40),
(6, 'ashley', 10000.00, 'manyaman', 9),
(7, 'runa', 100.00, 'msarapa', 90);

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_history`
--

CREATE TABLE `product_stock_history` (
  `id` int(11) NOT NULL,
  `stock_date` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_stock_history`
--

INSERT INTO `product_stock_history` (`id`, `stock_date`, `product_id`, `product_quantity`) VALUES
(4, '2025-05-18', 5, 40),
(5, '2025-05-18', 6, 321321);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `pword` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `uname`, `pword`, `role`) VALUES
(2, 'cuns', 'cuns', '$2y$10$mOHgRp2N3QFUl8GiH1AA8enhRgcYi1t.rXTJLok4Rwvcq19ehRAM2', 'user'),
(3, 'runa', 'runa', '$2y$10$k5tjcv6GeaL5zTiHVwp.BeNOEJ1ZiNFJZ2JsbGXjcG8GOyMo2Bpde', 'user'),
(4, 'burat', 'burat', '$2y$10$wvKdkQPirnarXDdDKTKITu4EcYF1aQ8c7JWc.vHhN2pXjTDOh9NGW', 'user'),
(5, 'rona', 'ron', '$2y$10$ZNtWfQmTTcXOEx61x.VgmuTMchHUpZluoWk7j2sPpObzYRGIaFEHm', 'user'),
(6, 'poco x6 pro', 'poco x6 pro', '$2y$10$YhJQ44O8e6FXBV.8oqwkTe5dJxFpqjFRPVbliogD.KVujuc3bh96G', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_stock_history`
--
ALTER TABLE `product_stock_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_stock` (`stock_date`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_stock_history`
--
ALTER TABLE `product_stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_stock_history`
--
ALTER TABLE `product_stock_history`
  ADD CONSTRAINT `product_stock_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
