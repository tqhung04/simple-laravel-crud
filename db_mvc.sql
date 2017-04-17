-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2017 at 02:11 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_mvc`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) NOT NULL,
  `name` varchar(225) NOT NULL COMMENT 'name of category',
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Apple', 0, '2017-03-06 14:34:33', '2017-03-06 14:34:33'),
(2, 'Sony', 0, '2017-03-06 15:00:51', '2017-03-06 15:00:51'),
(3, 'LG', 0, '2017-03-06 15:00:51', '2017-03-06 15:00:51'),
(4, 'Panasonic', 0, '2017-03-06 15:01:12', '2017-03-06 15:01:12'),
(5, 'Toshiba', 0, '2017-03-06 15:01:12', '2017-03-06 15:01:12');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `name` varchar(225) NOT NULL COMMENT 'name of product',
  `price` float NOT NULL COMMENT 'price of product',
  `description` text COMMENT 'description of product',
  `image` varchar(225) DEFAULT NULL COMMENT 'link image of product',
  `categories_id` int(10) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `categories_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Iphone 5', 1000000, NULL, 'Iphone 5.jpg', 0, 0, '2017-03-06 15:03:43', '2017-04-13 05:03:37'),
(2, 'Iphone 6', 12000000, 'Iphone 6\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm.', NULL, 1, 1, '2017-03-06 15:03:43', '2017-04-13 05:01:53'),
(3, 'Tivi Sony 19\'5', 8000000, 'Tivi Sony 19\'5 inch\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm.', NULL, 2, 1, '2017-03-06 15:05:59', '2017-04-13 05:01:53'),
(4, 'Tivi Sony 21\'5', 15000000, 'Tivi Sony 21\'5 inch\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm.', NULL, 2, 1, '2017-03-06 15:05:59', '2017-04-13 05:01:53'),
(5, 'Điện thoại LG Gold', 5000000, 'Điện thoại LG Gold\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm.', NULL, 3, 1, '2017-03-06 15:07:35', '2017-04-13 05:01:53'),
(6, 'Điện thoại LG Sliver', 6000000, 'Điện thoại LG Gold\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm.', NULL, 3, 1, '2017-03-06 15:07:35', '2017-04-13 05:01:53'),
(7, 'Điều hòa Panasonic 01', 18000000, 'Điều hòa Panasonic 01\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm.', NULL, 4, 1, '2017-03-06 15:09:19', '2017-04-13 05:01:53'),
(8, 'Điều hòa Panasonic 02', 20000000, 'Điều hòa Panasonic 01\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm.', NULL, 4, 1, '2017-03-06 15:09:19', '2017-04-13 05:01:53'),
(9, 'Tủ lạnh Toshiba 01', 15000000, 'Tủ lạnh Toshiba 01\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm', NULL, 5, 1, '2017-03-06 15:10:36', '2017-04-13 05:01:53'),
(10, 'Tủ lạnh Toshiba 02', 15000000, 'Tủ lạnh Toshiba 02\r\nThiết kế bền, đẹp.\r\nBảo hành 1 năm', NULL, 5, 1, '2017-03-06 15:10:36', '2017-04-13 05:01:53'),
(11, ':name', 0, ':description', ':image', 0, 0, '2017-03-08 11:53:11', '2017-03-08 11:53:11'),
(12, 'Demo 1', 10000, 'This is demo 1 product', '/assets/upload/Demo 1.png', 0, 0, '2017-03-08 11:54:53', '2017-03-08 11:54:53'),
(13, 'Demo 4', 123, '', '', 4, 0, '2017-03-08 12:15:47', '2017-03-08 16:21:06'),
(14, 'Demo 2', 123456, '', '/assets/upload/Demo 2.png', 1, 0, '2017-03-08 12:16:21', '2017-03-08 16:20:09'),
(15, 'Demo 3', 12003, '', '/assets/upload/Demo 3.png', 2, 0, '2017-03-08 15:34:51', '2017-03-08 15:34:51'),
(16, 'Item1', 123, NULL, 'Item1.jpg', 2, 0, '2017-04-13 04:16:31', '2017-04-13 04:40:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `username` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `avatar` text,
  `status` tinyint(4) NOT NULL,
  `remember_token` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$yvPq4/ADcfN6UWbIaQPale9GLNF0X71p32QqDVOUyUWEPEBzfdyMK', 'admin.jpg', 1, 'rAaLFmHSzleZxxBgT8eTf3drCCEWRD7CPZo2h5CLNSz0nzdAhJJosM1Mqa3r', '2017-03-06 14:55:22', '2017-04-13 04:55:48'),
(3, 'guest', 'guest@gmail.com', '1234', NULL, 0, NULL, '2017-03-06 14:56:04', '2017-04-13 05:00:21'),
(4, 'hungtq', 'hungtq@gmail.com', '1234', NULL, 0, NULL, '2017-03-06 14:56:55', '2017-04-12 20:01:53'),
(5, 'sonhh', 'sonhh@gmail.com', '$2y$10$FLSROIQdUaY1gY6qVSgAi.hieSH8Rw75e7fojH/SNldym.b2b4.9O', 'sonhh123467.jpg', 1, NULL, '2017-03-06 14:57:57', '2017-04-13 02:30:25'),
(6, 'namnt', 'namnt@gmail.com', '1234', 'namnt.jpg', 1, NULL, '2017-03-06 14:58:12', '2017-04-13 02:30:25'),
(7, 'thucnk', 'thucnk@gmail.com', '1234', NULL, 0, NULL, '2017-03-06 14:59:15', '2017-03-06 14:59:15'),
(8, 'hello', 'hello@gmail.com', '12345678', '', 0, NULL, '2017-04-11 23:23:53', '2017-04-13 07:15:19'),
(9, 'user1', 'user1@gmail.com', '1234', NULL, 0, NULL, '2017-04-11 23:35:27', '2017-04-11 23:35:27'),
(10, 'user2', 'user2@gmail.com', '12345678', '1491989360.jpg', 0, NULL, '2017-04-12 02:29:20', '2017-04-13 00:11:26'),
(13, 'admin123', 'admi123n@gmail.com', '12345678', 'admin123.jpg', 0, NULL, '2017-04-12 04:03:27', '2017-04-13 04:46:34'),
(15, 'user3', 'user3@gmail.com', '12345678', 'user3.jpg', 1, NULL, '2017-04-12 04:33:01', '2017-04-12 04:46:58'),
(16, 'user4', 'user4@gmail.com', '12345678', 'user4.jpg', 1, NULL, '2017-04-12 04:34:19', '2017-04-12 04:34:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
