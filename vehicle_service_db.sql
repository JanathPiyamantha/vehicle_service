-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2025 at 04:17 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vehicle_service_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `category` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `status`, `date_created`) VALUES
(5, '2 Wheeler Vehicle', 1, '2024-05-16 08:44:02'),
(7, '4 Wheeler Vehicle', 1, '2024-06-26 14:33:29'),
(8, '6 Wheeler Vehicle', 1, '2024-06-26 14:34:04'),
(10, '3 Wheeler Vehicle', 1, '2024-07-06 11:10:38'),
(11, '10 Wheeler Vehicles', 0, '2024-10-31 00:58:19');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `order_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_contact` varchar(255) NOT NULL,
  `mechanicname` varchar(100) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `vehicle_name` varchar(50) NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `delivery_time` time DEFAULT NULL,
  `parts_total` int(50) NOT NULL,
  `service_total` int(50) NOT NULL,
  `discount` int(20) NOT NULL,
  `grand_total` int(100) NOT NULL,
  `paid` int(100) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`order_id`, `order_date`, `owner_name`, `owner_contact`, `mechanicname`, `vehicle_type`, `vehicle_name`, `delivery_date`, `delivery_time`, `parts_total`, `service_total`, `discount`, `grand_total`, `paid`, `payment_status`, `order_status`) VALUES
(4, '2024-07-06', 'Nimal Gunarathna', '0778831187', 'Sandaru', 'Car', 'Civic', '2024-07-21', '11:23:10', 100, 150, 25, 220, 220, 2, 2),
(5, '2024-07-03', 'Sudarshan', '0987654321', 'Sandaru', 'Car', 'Cherry qq', '2024-07-22', '10:30:40', 1000, 1000, 200, 1800, 1800, 2, 2),
(12, '2024-07-22', 'Shantha', '0778841187', 'Sandaru', 'Car', 'Prado', '2024-07-24', '00:19:19', 500, 500, 20, 980, 980, 2, 2),
(13, '2024-07-24', 'Janath Piyumantha', '3452717611', 'Sandaru', 'SUV', 'Vezel', '2024-07-31', '19:23:09', 500, 1000, 30, 1470, 1470, 2, 2),
(15, '2024-08-02', 'Deshan Bandara Kumara', '0765462772', 'Anura Kumara', 'Truck', 'Isuzu Cargo', '2024-08-03', '19:23:09', 600, 400, 100, 900, 900, 2, 2),
(16, '2024-10-31', 'Nimal Jayasooriya', '0774346090', 'Anura Kumara', 'SUV', 'Vezel', '2024-10-31', '19:23:09', 1000, 500, 100, 1400, 1400, 2, 2),
(17, '2024-10-31', 'Janath Piyamantha', '0769055788', 'Kamal Nishantha', 'SUV', 'CHR', '2024-10-31', '19:23:20', 500, 500, 90, 910, 910, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `mechanics_list`
--

CREATE TABLE `mechanics_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(50) NOT NULL,
  `nic` text NOT NULL,
  `email` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mechanics_list`
--

INSERT INTO `mechanics_list` (`id`, `name`, `contact`, `nic`, `email`, `status`, `date_created`) VALUES
(5, 'Nimal Shantha Bandara', '0780966780', '098675657V', 'shantha@gmail.com', 1, '2024-04-20 08:51:32'),
(8, 'Sadun Weerasinghe', '0768855444', '99159947770', 'sadun20@gmail.com', 1, '2024-07-21 20:23:15'),
(9, 'Anura Kumara Premathilaka', '0756453621', '453637386V', 'anura6@gmail.com', 0, '2024-07-24 09:32:35'),
(10, 'Mudiyanselage Kamal Premadasa', '0773828922', '991771077V', 'kamal24@gmail.com', 1, '2024-07-24 12:42:36'),
(12, 'Dilshan Tharaka Kumarasiri', '0798098457', '6789026371V', 'dilshan23@gmail.com', 1, '2024-08-02 12:57:40'),
(13, 'Kamal Nishantha', '0756789221', '993451077V', 'jp@gmail.com', 1, '2024-10-31 00:42:41');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` text NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `rate` int(100) NOT NULL,
  `created_at` datetime(6) DEFAULT current_timestamp(6),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_image`, `quantity`, `rate`, `created_at`, `updated_at`, `status`) VALUES
(10, 'Dot 4 Brake Oil (100ml)', '', '50', 225, '2024-06-26 14:16:57.525480', '2024-06-26 13:45:20', 0),
(11, 'Honda Civic - Front Brake Caliper', '', '28', 345, '2024-06-26 14:20:26.421338', '2024-06-26 13:43:32', 1),
(12, 'Dot 3 Brake Oil (350ml)', '', '50', 500, '2024-06-26 19:11:33.597528', '2024-07-06 05:31:09', 1),
(14, 'Battery Acid', '', '15L', 35, '2024-07-24 09:35:48.466751', '2024-10-30 19:18:36', 1);

-- --------------------------------------------------------

--
-- Table structure for table `request_meta`
--

CREATE TABLE `request_meta` (
  `request_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_meta`
--

INSERT INTO `request_meta` (`request_id`, `meta_field`, `meta_value`) VALUES
(15, 'nic', '987056434V'),
(15, 'contact', '0778831187'),
(15, 'address', 'Ambagaspitiya'),
(15, 'vehicle_name', 'Civic'),
(15, 'vehicle_registration_number', 'CBN-6654'),
(15, 'vehicle_model', 'Passenger Car'),
(15, 'kilometers_traveled', '457900'),
(15, 'service_id', '5,12,11'),
(15, 'pickup_address', ''),
(16, 'nic', '436864748V'),
(16, 'contact', '0987654313'),
(16, 'address', 'Kandy'),
(16, 'vehicle_name', 'CHR'),
(16, 'vehicle_registration_number', 'CCC-6789'),
(16, 'vehicle_model', 'SUV'),
(16, 'kilometers_traveled', '7000'),
(16, 'service_id', '5'),
(16, 'pickup_address', ''),
(24, 'nic', '098675657V'),
(24, 'contact', '0778841187'),
(24, 'address', 'Anuradhapura'),
(24, 'vehicle_name', 'Prado'),
(24, 'vehicle_registration_number', 'CER-9980'),
(24, 'vehicle_model', 'MotorBike'),
(24, 'kilometers_traveled', '500000'),
(24, 'service_id', '8,9'),
(24, 'pickup_address', ''),
(37, 'nic', '9917710444V'),
(37, 'contact', '0987654321'),
(37, 'address', 'dsds'),
(37, 'vehicle_name', 'CHR'),
(37, 'vehicle_registration_number', 'CCB-4434'),
(37, 'vehicle_model', 'Mini Lorry'),
(37, 'kilometers_traveled', '343'),
(37, 'service_id', '6'),
(37, 'pickup_address', ''),
(41, 'nic', '90652323231'),
(41, 'contact', '0776478382'),
(41, 'address', 'Thihariya'),
(41, 'vehicle_name', 'Toyota Liteace'),
(41, 'vehicle_registration_number', 'PR-5678'),
(41, 'vehicle_model', 'Mini Lorry'),
(41, 'kilometers_traveled', '23560'),
(41, 'service_id', '7,8'),
(41, 'pickup_address', '');

-- --------------------------------------------------------

--
-- Table structure for table `service_list`
--

CREATE TABLE `service_list` (
  `id` int(30) NOT NULL,
  `service` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_list`
--

INSERT INTO `service_list` (`id`, `service`, `description`, `status`, `date_created`) VALUES
(5, 'Oil Change', '&lt;p&gt;Regular oil changes at Ruwan Auto Service help keep your engine running smoothly by lubricating moving parts and preventing premature wear and tear.&lt;br&gt;&lt;/p&gt;', 1, '2024-05-16 08:42:07'),
(6, 'Tire Replacement', '&lt;p&gt;Ruwan Auto Service offers expert tire replacement services to ensure your vehicle maintains optimal traction, safety, and fuel efficiency on the road.&lt;br&gt;&lt;/p&gt;', 1, '2024-05-16 08:52:53'),
(7, 'Brake Inspection and Repair', 'Ruwan Auto Service conducts thorough brake inspections and repairs to ensure your vehicle stops safely and reliably when you need it most.', 1, '2024-06-26 14:39:14'),
(8, 'Engine Tune-Up', '&lt;p&gt;Engine tune-ups at Ruwan Auto Service optimize performance, fuel efficiency, and reliability by inspecting and adjusting critical engine components.&lt;br&gt;&lt;/p&gt;', 1, '2024-06-26 14:40:02'),
(9, 'Suspension and Steering Repair', '&lt;p&gt;Ruwan Auto Service provides expert suspension and steering repairs to ensure a smooth ride, precise handling, and vehicle stability on all road surfaces.&lt;br&gt;&lt;/p&gt;', 1, '2024-06-26 14:41:17'),
(10, 'Vehicle Washing', '&lt;p&gt;Give your vehicle a fresh look with thorough exterior washing at Ruwan Auto Service, removing dirt, grime, and debris.&lt;br&gt;&lt;/p&gt;', 1, '2024-06-26 14:42:30'),
(11, 'Vehicle Waxing', '&lt;p&gt;Protect your vehicle&#039;s paint and enhance its shine with professional waxing services that provide a glossy finish and added protection.&lt;br&gt;&lt;/p&gt;', 0, '2024-06-26 14:44:21'),
(12, 'Transmission Service', '&lt;p&gt;Ensure smooth gear shifts and extend transmission life with comprehensive fluid changes and inspections.&lt;br&gt;&lt;/p&gt;', 1, '2024-06-26 14:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(30) NOT NULL,
  `owner_name` text NOT NULL,
  `email` text NOT NULL,
  `category_id` int(30) NOT NULL,
  `service_type` text NOT NULL,
  `mechanic_id` int(30) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `owner_name`, `email`, `category_id`, `service_type`, `mechanic_id`, `status`, `date_created`) VALUES
(15, 'Nimal Gunarathna', 'abcde@gmail.com', 7, 'Drop Off', 9, 1, '2024-07-06 10:46:21'),
(16, 'Hasintha Sandaru', 'por@gmail.com', 5, 'Drop Off', 8, 0, '2024-07-07 01:51:15'),
(24, 'Shantha', 'nimal@gmail.com', 5, 'Drop Off', 9, 3, '2024-07-22 11:41:45'),
(37, 'Sunimal', 'sunimal@gmail.com', 7, 'Drop Off', 5, 1, '2024-07-30 19:17:57'),
(41, 'Thilina Kasun Arachchi', 'thilina34@gmail.com', 8, 'Drop Off', 9, 1, '2024-02-02 13:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'RUWAN AUTO SERVICE'),
(6, 'short_name', 'RAS'),
(11, 'logo', 'uploads/1711522260_WhatsApp Image 2023-11-21 at 11.09.43_b3a236a3.jpg'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1711522260_IMG_20231126_235157.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1624240500_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-06-21 09:55:07'),
(6, 'Nimsha', 'Sanduni', 'nimsha', 'cd74fae0a3adf459f73bbf187607ccea', 'uploads/1719406200_i.nstacars___utm_source=ig_share_sheet&igshid=fbr7d8hppcuz___.jpg', NULL, 2, '2021-09-30 16:34:02', '2024-06-26 18:20:03'),
(7, 'Janath', 'Piyamantha ', 'nimal', '81dc9bdb52d04dc20036dbd8313ed055', 'uploads/1719406140_i.nstacars___utm_source=ig_share_sheet&igshid=4i7eu91jd5m4___.jpg', NULL, 1, '2024-05-16 08:53:55', '2024-06-26 18:21:15'),
(8, 'Jayathu', 'Kamal', 'jayathu', '81dc9bdb52d04dc20036dbd8313ed055', 'uploads/1719406140_i.nstacars___utm_source=ig_share_sheet&igshid=16ymvgsmdsqgw___.jpg', NULL, 2, '2024-05-16 09:08:42', '2024-10-31 00:59:57'),
(9, 'Kamal', 'Munasinghe', 'kamal', '827ccb0eea8a706c4c34a16891f84e7b', 'uploads/1722583140_andrew-pons-50263-unsplash.jpg', NULL, 2, '2024-06-30 23:12:46', '2024-08-02 12:49:23'),
(10, 'Yohan', 'Nimasha', 'yohan', '827ccb0eea8a706c4c34a16891f84e7b', 'uploads/1722583140_adam-birkett-456231-unsplash.jpg', NULL, 2, '2024-07-06 11:13:52', '2024-08-02 12:49:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `mechanics_list`
--
ALTER TABLE `mechanics_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `request_meta`
--
ALTER TABLE `request_meta`
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `service_list`
--
ALTER TABLE `service_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category_id`),
  ADD KEY `mechanic` (`mechanic_id`) USING BTREE;

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `mechanics_list`
--
ALTER TABLE `mechanics_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `service_list`
--
ALTER TABLE `service_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `request_meta`
--
ALTER TABLE `request_meta`
  ADD CONSTRAINT `request_meta_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `service_requests` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
