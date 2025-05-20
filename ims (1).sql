-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 07:00 PM
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
(1, 'Updated product: grapes', '2025-05-20 23:50:19'),
(2, 'Added product: RHEA (Qty: 1)', '2025-05-20 23:50:46'),
(3, 'Added product: JM (Qty: 10000)', '2025-05-20 23:51:39'),
(4, 'Updated product: grapes', '2025-05-20 23:52:02'),
(5, 'Updated product: RHEA', '2025-05-20 23:52:11'),
(6, 'Added product: APPLE (Qty: 10)', '2025-05-20 23:52:42'),
(7, 'Added product: ORANGE (Qty: 5)', '2025-05-20 23:53:00'),
(8, 'Added product: ATIS (Qty: 20)', '2025-05-20 23:53:14'),
(9, 'Updated product: ORANGE', '2025-05-20 23:55:01'),
(10, 'Updated product: APPLE', '2025-05-20 23:55:07'),
(11, 'Updated product: JM', '2025-05-20 23:55:13'),
(12, 'Updated product: JM', '2025-05-20 23:55:33'),
(13, 'Updated product: JM', '2025-05-21 00:04:04'),
(14, 'Updated product: RHEA', '2025-05-21 00:04:09'),
(15, 'Updated product: JM', '2025-05-21 00:04:15'),
(16, 'Updated product: RHEA', '2025-05-21 00:08:26'),
(17, 'Updated product: grapes', '2025-05-21 00:08:41');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `pdescript` text NOT NULL,
  `product_quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `pdescript`, `product_quantity`) VALUES
(1, 'grapes', 123.00, '123', 500),
(2, 'RHEA', 111.00, 'MASARAP', 200),
(3, 'JM', 222.00, '8', 8),
(4, 'APPLE', 10.00, '123124', 9),
(5, 'ORANGE', 12.00, 'SWFSAF', 9),
(6, 'ATIS', 213.00, 'FDZFS', 20);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `pword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `uname`, `pword`) VALUES
(1, 'Christian Manarang Cunan', 'cuns', '$2y$10$crAWRtXAygReKTYqATbvi.V1bBkNKxSwLUps1pVr3Hru77RFfBk.e'),
(2, 'dabu', 'dabu', '$2y$10$qvDvj8tcMsBasGFibZmgk.xdXhyM5u3Co0aEdci3ltx1yloEMIOcy'),
(3, 'rhea', 'rhea', '$2y$10$UM7JGeS5AnJWQzUSCaySGu0AWa4/irs0ySdW65vlXOrCTWqBhWliu');

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL DEFAULT current_timestamp()
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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD CONSTRAINT `user_logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
