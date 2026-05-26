-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2026 at 11:41 AM
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
-- Database: `smart_inventory_db_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `bill_no` varchar(50) DEFAULT NULL,
  `gst` decimal(10,2) NOT NULL DEFAULT 0.00,
  `gst_amount` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `customer_name`, `product_name`, `quantity`, `price`, `total`, `invoice_date`, `bill_no`, `gst`, `gst_amount`) VALUES
(9, 'hemant ajmera', 'keyboard', 2, 500.00, 1000.00, '2026-05-16 12:54:25', NULL, 0.00, 0.00),
(12, 'shyam', 'ipad', 1, 10000.00, 10000.00, '2026-05-17 06:11:28', NULL, 0.00, 0.00),
(14, 'kalu', 'djkdij', 5, 100.00, 500.00, '2026-05-17 06:24:13', '', 0.00, 0.00),
(15, 'kalu', 'djkdij', 5, 100.00, 500.00, '2026-05-17 06:24:13', '', 0.00, 0.00),
(16, 'kalu', 'djkdij', 5, 100.00, 500.00, '2026-05-17 06:29:52', '', 0.00, 0.00),
(17, 'kalu', 'ice cream', 5, 100.00, 500.00, '2026-05-17 06:29:52', '', 0.00, 0.00),
(18, 'kalu', 'ice cream', 5, 100.00, 500.00, '2026-05-17 06:29:52', '', 0.00, 0.00),
(19, 'kalu', 'rapoo mouse', 1, 450.00, 450.00, '2026-05-17 06:34:59', 'INV1778999699', 0.00, 0.00),
(20, 'kalu', 'rapoo mouse', 1, 450.00, 450.00, '2026-05-17 06:34:59', 'INV1778999699', 0.00, 0.00),
(21, 'shyam', 'djkdij', 5, 100.00, 500.00, '2026-05-17 06:44:40', 'INV1779000280', 0.00, 0.00),
(22, 'shyam', 'djkdij', 5, 100.00, 500.00, '2026-05-17 06:44:40', 'INV1779000280', 0.00, 0.00),
(23, '', 'keyboard', 5, 500.00, 2500.00, '2026-05-17 06:55:53', 'INV1779000953', 0.00, 0.00),
(24, '', 'rapoo mouse', 2, 450.00, 900.00, '2026-05-17 06:55:53', 'INV1779000953', 0.00, 0.00),
(25, '', 'djkdij', 8, 100.00, 800.00, '2026-05-17 06:58:37', 'INV1779001117', 0.00, 0.00),
(26, '', 'ice cream', 3, 100.00, 300.00, '2026-05-17 06:58:37', 'INV1779001117', 0.00, 0.00),
(27, '', 'djkdij', 2, 100.00, 200.00, '2026-05-17 07:03:46', 'INV1779001426', 0.00, 0.00),
(28, '', 'keyboard', 3, 500.00, 1500.00, '2026-05-17 07:07:04', 'INV1779001624', 0.00, 0.00),
(29, 'hemant ajmera', 'keyboard', 1, 500.00, 500.00, '2026-05-17 07:12:49', 'INV1779001969', 0.00, 0.00),
(30, 'hemant', 'keyboard', 30, 200.00, 6000.00, '2026-05-18 10:29:12', 'INV1779100152', 0.00, 0.00),
(31, 'hemant', 'keyboard', 6, 200.00, 1200.00, '2026-05-18 10:31:05', 'INV1779100265', 0.00, 0.00),
(32, 'hemant', 'rapoo mouse', 5, 450.00, 2250.00, '2026-05-18 10:31:05', 'INV1779100265', 0.00, 0.00),
(33, 'hemant', 'keyboard', 10, 200.00, 2000.00, '2026-05-18 17:32:27', 'INV1779125547', 0.00, 0.00),
(34, 'hemant', 'phone', 2, 12000.00, 24000.00, '2026-05-18 17:36:47', 'INV1779125807', 0.00, 0.00),
(35, 'hemant', 'hadphone', 40, 4000.00, 160000.00, '2026-05-19 05:08:25', 'INV1779167305', 0.00, 0.00),
(36, 'hemant', 'hadphone', 1, 4000.00, 4000.00, '2026-05-19 17:03:22', 'INV1779210202', 0.00, 0.00),
(37, 'hemant', 'phone', 2, 12000.00, 24000.00, '2026-05-19 17:03:22', 'INV1779210202', 0.00, 0.00),
(38, 'hemant', 'keyboard', 2, 200.00, 400.00, '2026-05-20 14:04:03', 'INV1779285843', 0.00, 0.00),
(39, 'hemant', 'phone', 5, 12000.00, 60000.00, '2026-05-20 14:05:10', 'INV1779285910', 0.00, 0.00),
(40, 'hemant', 'hadphone', 5, 3540.00, 17700.00, '2026-05-20 16:44:35', 'INV1779295475', 0.00, 0.00),
(41, 'hemant', 'hadphone', 6, 5900.00, 35400.00, '2026-05-20 16:46:00', 'INV1779295560', 0.00, 0.00),
(42, 'hemant', 'hadphone', 1, 5900.00, 5900.00, '2026-05-20 16:54:57', 'INV1779296097', 0.00, 0.00),
(43, 'hemant', 'hadphone', 1, 5900.00, 5900.00, '2026-05-20 16:59:24', 'INV1779296364', 0.00, 0.00),
(44, 'hemant', 'hadphone', 1, 5900.00, 5900.00, '2026-05-20 17:03:34', 'INV1779296614', 0.00, 0.00),
(45, 'mohit', 'hadphone', 1, 5900.00, 5900.00, '2026-05-20 17:17:26', 'INV1779297446', 0.00, 0.00),
(46, 'mohit', 'hadphone', 4, 5900.00, 23600.00, '2026-05-20 17:19:12', 'INV1779297552', 0.00, 0.00),
(47, 'mohit', 'hadphone', 1, 5900.00, 5900.00, '2026-05-20 18:04:10', 'INV1779300250', 18.00, 900.00),
(48, 'mohit', 'TV', 2, 59000.00, 118000.00, '2026-05-20 18:06:47', 'INV1779300407', 18.00, 18000.00),
(49, 'mohit', 'TV', 5, 59000.00, 295000.00, '2026-05-20 18:34:11', 'INV1779302051', 18.00, 45000.00),
(50, 'mohit', 'Papsi', 5, 52.50, 262.50, '2026-05-20 18:46:19', 'INV1779302779', 5.00, 12.50),
(51, 'mohit', 'Papsi', 5, 52.50, 262.50, '2026-05-20 18:48:00', 'INV1779302880', 5.00, 12.50),
(52, 'mohit', 'hadphone', 5, 5900.00, 29500.00, '2026-05-20 18:59:23', 'INV1779303563', 18.00, 4500.00),
(53, 'mohit', 'TV', 2, 59000.00, 118000.00, '2026-05-20 18:59:23', 'INV1779303563', 18.00, 18000.00),
(54, 'mohit', 'Papsi', 5, 52.50, 262.50, '2026-05-20 18:59:23', 'INV1779303563', 5.00, 12.50),
(55, 'mohit', 'hadphone', 4, 5900.00, 23600.00, '2026-05-20 19:01:42', 'INV1779303702', 18.00, 3600.00),
(56, 'mohit', 'TV', 2, 59000.00, 118000.00, '2026-05-20 19:01:42', 'INV1779303702', 18.00, 18000.00),
(57, 'mohit', 'Papsi', 2, 52.50, 105.00, '2026-05-20 19:01:42', 'INV1779303702', 5.00, 5.00),
(58, 'mohit', 'TV', 1, 59000.00, 59000.00, '2026-05-21 04:12:08', 'INV1779336728', 18.00, 9000.00),
(59, 'gosuwami achar', 'TV', 2, 59000.00, 118000.00, '2026-05-21 05:07:26', 'INV1779340046', 18.00, 18000.00),
(60, 'gosuwami achar', 'Papsi', 5, 52.50, 262.50, '2026-05-21 06:02:23', 'INV1779343343', 5.00, 12.50),
(61, 'mohit', 'TV', 4, 50000.00, 236000.00, '2026-05-21 07:03:59', 'INV1779347039', 18.00, 36000.00),
(62, 'mohit', 'Papsi', 2, 50.00, 105.00, '2026-05-21 07:03:59', 'INV1779347039', 5.00, 5.00),
(63, 'mohit', 'hadphone', 5, 5000.00, 29500.00, '2026-05-21 07:03:59', 'INV1779347039', 18.00, 4500.00),
(64, 'hemant ajmera', 'TV', 1, 15000.00, 15000.00, '2026-05-22 04:56:03', 'INV1779425763', 18.00, 2288.14),
(65, 'shyam', 'TV', 1, 15000.00, 15000.00, '2026-05-22 05:22:30', 'INV1779427350', 18.00, 2288.14),
(66, 'mohit prajapati', 'TV', 1, 15000.00, 15000.00, '2026-05-22 05:24:39', 'INV1779427479', 18.00, 2288.14),
(67, 'ram', 'mouse', 10, 180.00, 1800.00, '2026-05-22 05:59:50', 'INV1779429590', 18.00, 274.58),
(68, 'mohit prajapati', 'TV', 1, 15000.00, 15000.00, '2026-05-22 06:13:32', 'INV1779430412', 18.00, 2288.14),
(69, 'kalu', 'TV', 1, 15000.00, 15000.00, '2026-05-22 06:15:35', 'INV1779430535', 18.00, 2288.14);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`id`, `invoice_id`, `product_id`, `quantity`, `price`, `total`) VALUES
(1, 2, 6, 2, 100.00, 200.00),
(2, 2, 6, 2, 100.00, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `barcode` varchar(100) DEFAULT NULL,
  `cost_price` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `gst` decimal(5,2) NOT NULL DEFAULT 18.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `category`, `quantity`, `image`, `barcode`, `cost_price`, `selling_price`, `gst`) VALUES
(15, 'hadphone', 'electronic', 51, '1779290730_85254-headset-airpods-apple-headphones-plus-iphone-earbuds.png', 'hadphone101010', 4000.00, 5000.00, 18.00),
(16, 'TV', 'electronic', 2, '1779300378_ChatGPT Image May 16, 2026, 12_18_14 PM.png', 't.v002', 11000.00, 15000.00, 18.00),
(17, 'Papsi', 'Cold Drink', 1, '1779302755_vecteezy_can-of-pepsi-isolated-on-transparent-background_52610767 (5).png', 'Pepsi00004', 45.00, 50.00, 5.00),
(18, 'mouse', 'electronic', 0, '1779428937_png-clipart-computer-mouse-logitech-gaming-mouse-g-pro-pelihiiri-scroll-wheel-computer-mouse-electronics-mouse.png', '12345', 100.00, 180.00, 18.00);

-- --------------------------------------------------------

--
-- Table structure for table `stock_in`
--

CREATE TABLE `stock_in` (
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_in`
--

INSERT INTO `stock_in` (`product_id`, `quantity`, `date_added`) VALUES
(3, 20, '2026-05-11 08:42:34'),
(3, 10, '2026-05-11 08:42:46'),
(3, 10, '2026-05-11 08:43:24'),
(7, 70, '2026-05-11 10:46:31'),
(7, 40, '2026-05-12 04:56:22'),
(6, 50, '2026-05-13 08:58:53'),
(6, 50, '2026-05-13 08:59:08'),
(6, 50, '2026-05-13 08:59:29'),
(6, 50, '2026-05-13 09:00:20'),
(10, 10, '2026-05-16 05:53:30'),
(7, 20, '2026-05-18 17:31:20'),
(12, 10, '2026-05-18 17:36:07'),
(14, 10, '2026-05-19 17:02:14'),
(15, 50, '2026-05-20 17:18:17'),
(15, 20, '2026-05-21 04:20:44'),
(16, 5, '2026-05-22 05:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `supplier_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_name`, `phone`, `address`) VALUES
(1, 'mohit ', '8992340123', 'data nagar'),
(2, 'hement', '000000000', 'jawar nagar');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `email`) VALUES
(1, 'admin', '12345', 'admin', 'Admin User', 'admin@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
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
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
