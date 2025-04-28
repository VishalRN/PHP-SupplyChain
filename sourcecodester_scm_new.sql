-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2025 at 06:34 PM
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
-- Database: `sourcecodester_scm_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Admin', 'Admin123');

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `area_id` int(11) NOT NULL,
  `area_name` varchar(50) NOT NULL,
  `area_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `area_name`, `area_code`) VALUES
(1, 'Whitefield ', '560066'),
(2, 'Majestic', '560023'),
(3, 'Yeshwanthpur', '560022'),
(4, 'Chickpet', '560053'),
(5, 'Jayanagar', '560011'),
(6, 'Malleshwaram', '560003'),
(7, 'Lalbagh', '560004'),
(8, 'Nagasandra', '560073'),
(9, 'Kengeri', '560060'),
(10, 'Indiranagar', '560038');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(25) NOT NULL,
  `cat_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_details`) VALUES
(1, 'Fast Food', ''),
(2, 'Bread Buns', ''),
(3, 'Cakes', ''),
(4, 'Deserts', ''),
(5, 'Sandwiches', ''),
(6, 'Cookies & Biscuits', ''),
(7, 'Bakery Beverages', ''),
(8, 'Gluten-Free & Vegan Bakes', ''),
(9, 'Savory Bakes & Snacks', ''),
(10, 'Frozen & Pre-Baked Goods', '');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE `distributor` (
  `dist_id` int(11) NOT NULL,
  `dist_name` varchar(25) NOT NULL,
  `dist_email` varchar(50) DEFAULT NULL,
  `dist_phone` varchar(10) NOT NULL,
  `dist_phone2` varchar(10) NOT NULL,
  `dist_address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`dist_id`, `dist_name`, `dist_email`, `dist_phone`, `dist_phone2`, `dist_address`) VALUES
(1, 'Nishant', 'nishant@gmail.com', '8980769792', '9098765432', 'Alpha Mall, Vastrapur, Ahmedabad'),
(2, 'Rahul', 'rahul@gmail.com', '9099432197', '7214567890', 'Gota, S.G. Highway, Ahmedabad'),
(3, 'Pavan', 'pavan@gmail.com', '7878025437', '6354128976', 'Modhera Stadium, Ahmedabad'),
(4, 'Divya', 'divya@gmail.com', '9012376544', '8431196299', 'Navrangpura, Ahmedabad'),
(5, 'Haniket', 'haniket@gmail.com', '8980745372', '8887765432', 'CTM, Ahmedabad'),
(6, 'Sanjay', 'sanjay@gmail.com', '8980745372', '9876543210', 'Gomti Nagar Extension, Lucknow'),
(7, 'Harish', 'harish@gmail.com', '8980745372', '9123456789', 'Gandhi Path, Jaipur'),
(8, 'Harsh', 'harsh@gmail.com', '8980745372', '8000012345', 'Near Iskcon Temple, Ahmedabad');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `dist_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_amount` decimal(10,3) NOT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `order_id`, `retailer_id`, `dist_id`, `date`, `total_amount`, `comments`) VALUES
(1, 1, 4, 1, '2025-04-02', 2710.000, ''),
(2, 2, 3, 2, '2025-04-02', 3500.000, ''),
(3, 3, 2, 3, '2025-04-02', 4200.000, ''),
(4, 4, 1, 4, '2025-04-02', 3800.000, ''),
(5, 6, 4, 2, '2025-04-02', 2270.000, ''),
(6, 5, 4, 5, '2025-04-02', 3520.000, ''),
(7, 7, 4, 1, '2025-04-02', 2575.000, ''),
(8, 8, 4, 4, '2025-04-02', 4090.000, ''),
(9, 9, 1, 8, '2025-04-02', 3430.000, ''),
(10, 10, 2, 1, '2025-04-03', 2810.000, '');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `invoice_items_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`invoice_items_id`, `invoice_id`, `product_id`, `quantity`) VALUES
(1, 1, 4, 20),
(2, 1, 5, 5),
(3, 1, 7, 10),
(4, 1, 9, 10),
(5, 1, 12, 6),
(6, 1, 14, 5),
(7, 2, 1, 20),
(8, 2, 2, 15),
(9, 2, 5, 10),
(10, 2, 8, 5),
(11, 2, 10, 8),
(12, 2, 11, 10),
(13, 2, 13, 2),
(14, 2, 15, 3),
(15, 3, 1, 2),
(16, 3, 2, 4),
(17, 3, 3, 3),
(18, 3, 4, 8),
(19, 3, 5, 10),
(20, 3, 6, 12),
(21, 3, 8, 4),
(22, 3, 11, 10),
(23, 3, 13, 3),
(24, 3, 14, 5),
(25, 3, 15, 6),
(26, 4, 2, 12),
(27, 4, 4, 30),
(28, 4, 8, 4),
(29, 4, 11, 20),
(30, 4, 14, 8),
(31, 4, 1, 8),
(32, 4, 9, 8),
(33, 4, 10, 8),
(34, 4, 22, 8),
(35, 4, 7, 8),
(36, 2, 21, 5),
(37, 1, 24, 10),
(38, 1, 11, 6),
(39, 1, 25, 5),
(40, 1, 18, 10),
(41, 1, 22, 5),
(42, 1, 2, 10),
(43, 1, 3, 6),
(44, 2, 24, 10),
(45, 2, 19, 2),
(46, 2, 9, 10),
(47, 3, 10, 8),
(48, 3, 18, 10),
(49, 3, 20, 3),
(50, 4, 21, 4),
(51, 4, 25, 12),
(52, 4, 12, 8),
(53, 5, 1, 2),
(54, 5, 2, 2),
(55, 5, 3, 2),
(56, 5, 13, 2),
(57, 5, 14, 2),
(58, 5, 15, 2),
(59, 5, 16, 2),
(60, 5, 17, 2),
(61, 5, 18, 5),
(62, 5, 19, 2),
(63, 5, 20, 2),
(64, 5, 21, 2),
(65, 5, 22, 2),
(66, 5, 23, 2),
(67, 5, 24, 2),
(68, 5, 25, 2),
(69, 6, 1, 2),
(70, 6, 2, 6),
(71, 6, 3, 4),
(72, 6, 4, 5),
(73, 6, 5, 4),
(74, 6, 6, 2),
(75, 6, 7, 2),
(76, 6, 8, 2),
(77, 6, 9, 2),
(78, 6, 10, 4),
(79, 6, 11, 2),
(80, 6, 12, 2),
(81, 6, 13, 2),
(82, 6, 14, 2),
(83, 6, 15, 2),
(84, 6, 16, 2),
(85, 6, 17, 2),
(86, 7, 1, 2),
(87, 7, 2, 2),
(88, 7, 3, 2),
(89, 7, 4, 2),
(90, 7, 5, 4),
(91, 7, 6, 5),
(92, 7, 8, 5),
(93, 7, 9, 2),
(94, 7, 10, 2),
(95, 7, 11, 2),
(96, 7, 17, 2),
(97, 7, 19, 2),
(98, 7, 20, 2),
(99, 7, 21, 7),
(100, 7, 22, 3),
(101, 7, 23, 2),
(102, 7, 25, 2),
(103, 8, 8, 2),
(104, 8, 9, 2),
(105, 8, 10, 4),
(106, 8, 11, 5),
(107, 8, 12, 2),
(108, 8, 13, 2),
(109, 8, 14, 7),
(110, 8, 15, 2),
(111, 8, 16, 2),
(112, 8, 17, 2),
(113, 8, 18, 5),
(114, 8, 19, 6),
(115, 8, 20, 2),
(116, 8, 21, 6),
(117, 8, 22, 2),
(118, 8, 23, 1),
(119, 8, 24, 2),
(120, 8, 25, 2),
(121, 9, 1, 2),
(122, 9, 2, 6),
(123, 9, 3, 4),
(124, 9, 4, 2),
(125, 9, 5, 4),
(126, 9, 6, 2),
(127, 9, 7, 2),
(128, 9, 8, 2),
(129, 9, 9, 2),
(130, 9, 10, 2),
(131, 9, 11, 2),
(132, 9, 12, 2),
(133, 9, 13, 2),
(134, 9, 14, 2),
(135, 9, 15, 2),
(136, 9, 16, 2),
(137, 9, 17, 2),
(138, 10, 1, 2),
(139, 10, 2, 2),
(140, 10, 3, 2),
(141, 10, 4, 2),
(142, 10, 5, 4),
(143, 10, 6, 2),
(144, 10, 7, 2),
(145, 10, 8, 2),
(146, 10, 9, 2),
(147, 10, 10, 2),
(148, 10, 11, 2),
(149, 10, 12, 2),
(150, 10, 13, 2),
(151, 10, 14, 2),
(152, 10, 15, 2),
(153, 10, 16, 2),
(154, 10, 17, 2);

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE `manufacturer` (
  `man_id` int(11) NOT NULL,
  `man_name` varchar(25) NOT NULL,
  `man_email` varchar(50) DEFAULT NULL,
  `man_phone` varchar(10) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`man_id`, `man_name`, `man_email`, `man_phone`, `username`, `password`) VALUES
(1, 'Amit', 'amit@gmail.com', '9890234510', 'Amit', 'Amit123'),
(2, 'Dev', 'dev@gmail.com', '8980956231', 'Dev', 'Dev123'),
(3, 'Yash', 'yash@gmail.com', '9934672300', 'Yash', 'Yash123'),
(4, 'Ravi', 'ravi@gmail.com', '9807634905', 'Ravi', 'Ravi123'),
(5, 'Anu', 'anu@gmail.com', '9876565421', 'Anu', 'Anu123'),
(6, 'Arjun', 'arjun@gmail.com', '9876543210', 'Arjun', 'Arjun123'),
(7, 'Manish', 'manish@gmail.com', '9321456780', 'Manish', 'Manish123');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `total_amount` decimal(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `date`, `retailer_id`, `approved`, `status`, `total_amount`) VALUES
(1, '2025-04-02', 4, 1, 1, 2710.000),
(2, '2025-04-02', 3, 1, 1, 3500.000),
(3, '2025-04-02', 2, 1, 1, 4200.000),
(4, '2025-04-02', 1, 1, 1, 3800.000),
(5, '2025-04-02', 4, 1, 1, 3520.000),
(6, '2025-04-02', 4, 1, 1, 2270.000),
(7, '2025-04-02', 4, 1, 1, 2575.000),
(8, '2025-04-02', 4, 1, 1, 4090.000),
(9, '2025-04-02', 1, 1, 1, 3430.000),
(10, '2025-04-03', 2, 1, 1, 2810.000),
(11, '2025-04-03', 2, 1, 0, 3190.000),
(12, '2025-04-03', 2, 0, 0, 2710.000),
(13, '2025-04-03', 2, 0, 0, 2855.000);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_items_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_items_id`, `order_id`, `pro_id`, `quantity`) VALUES
(1, 1, 4, 20),
(2, 1, 5, 5),
(3, 1, 7, 10),
(4, 1, 9, 10),
(5, 1, 12, 6),
(6, 1, 14, 5),
(7, 2, 1, 20),
(8, 2, 2, 15),
(9, 2, 5, 10),
(10, 2, 8, 5),
(11, 2, 10, 8),
(12, 2, 11, 10),
(13, 2, 13, 2),
(14, 2, 15, 3),
(15, 3, 1, 2),
(16, 3, 2, 4),
(17, 3, 3, 3),
(18, 3, 4, 8),
(19, 3, 5, 10),
(20, 3, 6, 12),
(21, 3, 8, 4),
(22, 3, 11, 10),
(23, 3, 13, 3),
(24, 3, 14, 5),
(25, 3, 15, 6),
(26, 4, 2, 12),
(27, 4, 4, 30),
(28, 4, 8, 4),
(29, 4, 11, 20),
(30, 4, 14, 8),
(31, 4, 1, 8),
(32, 4, 9, 8),
(33, 4, 10, 8),
(34, 4, 22, 8),
(35, 4, 7, 8),
(36, 2, 21, 5),
(37, 1, 24, 10),
(38, 1, 11, 6),
(39, 1, 25, 5),
(40, 1, 18, 10),
(41, 1, 22, 5),
(42, 1, 2, 10),
(43, 1, 3, 6),
(44, 2, 24, 10),
(45, 2, 19, 2),
(46, 2, 9, 10),
(47, 3, 10, 8),
(48, 3, 18, 10),
(49, 3, 20, 3),
(50, 4, 21, 4),
(51, 4, 25, 12),
(52, 4, 12, 8),
(53, 5, 1, 2),
(54, 5, 2, 6),
(55, 5, 3, 4),
(56, 5, 4, 5),
(57, 5, 5, 4),
(58, 5, 6, 2),
(59, 5, 7, 2),
(60, 5, 8, 2),
(61, 5, 9, 2),
(62, 5, 10, 4),
(63, 5, 11, 2),
(64, 5, 12, 2),
(65, 5, 13, 2),
(66, 5, 14, 2),
(67, 5, 15, 2),
(68, 5, 16, 2),
(69, 5, 17, 2),
(70, 6, 1, 2),
(71, 6, 2, 2),
(72, 6, 3, 2),
(73, 6, 13, 2),
(74, 6, 14, 2),
(75, 6, 15, 2),
(76, 6, 16, 2),
(77, 6, 17, 2),
(78, 6, 18, 5),
(79, 6, 19, 2),
(80, 6, 20, 2),
(81, 6, 21, 2),
(82, 6, 22, 2),
(83, 6, 23, 2),
(84, 6, 24, 2),
(85, 6, 25, 2),
(86, 7, 1, 2),
(87, 7, 2, 2),
(88, 7, 3, 2),
(89, 7, 4, 2),
(90, 7, 5, 4),
(91, 7, 6, 5),
(92, 7, 8, 5),
(93, 7, 9, 2),
(94, 7, 10, 2),
(95, 7, 11, 2),
(96, 7, 17, 2),
(97, 7, 19, 2),
(98, 7, 20, 2),
(99, 7, 21, 7),
(100, 7, 22, 3),
(101, 7, 23, 2),
(102, 7, 25, 2),
(103, 8, 8, 2),
(104, 8, 9, 2),
(105, 8, 10, 4),
(106, 8, 11, 5),
(107, 8, 12, 2),
(108, 8, 13, 2),
(109, 8, 14, 7),
(110, 8, 15, 2),
(111, 8, 16, 2),
(112, 8, 17, 2),
(113, 8, 18, 5),
(114, 8, 19, 6),
(115, 8, 20, 2),
(116, 8, 21, 6),
(117, 8, 22, 2),
(118, 8, 23, 1),
(119, 8, 24, 2),
(120, 8, 25, 2),
(121, 9, 1, 2),
(122, 9, 2, 6),
(123, 9, 3, 4),
(124, 9, 4, 2),
(125, 9, 5, 4),
(126, 9, 6, 2),
(127, 9, 7, 2),
(128, 9, 8, 2),
(129, 9, 9, 2),
(130, 9, 10, 2),
(131, 9, 11, 2),
(132, 9, 12, 2),
(133, 9, 13, 2),
(134, 9, 14, 2),
(135, 9, 15, 2),
(136, 9, 16, 2),
(137, 9, 17, 2),
(138, 10, 1, 2),
(139, 10, 2, 2),
(140, 10, 3, 2),
(141, 10, 4, 2),
(142, 10, 5, 4),
(143, 10, 6, 2),
(144, 10, 7, 2),
(145, 10, 8, 2),
(146, 10, 9, 2),
(147, 10, 10, 2),
(148, 10, 11, 2),
(149, 10, 12, 2),
(150, 10, 13, 2),
(151, 10, 14, 2),
(152, 10, 15, 2),
(153, 10, 16, 2),
(154, 10, 17, 2),
(155, 11, 9, 2),
(156, 11, 10, 2),
(157, 11, 11, 2),
(158, 11, 12, 2),
(159, 11, 13, 2),
(160, 11, 14, 2),
(161, 11, 15, 2),
(162, 11, 16, 2),
(163, 11, 17, 2),
(164, 11, 18, 5),
(165, 11, 19, 2),
(166, 11, 20, 2),
(167, 11, 21, 2),
(168, 11, 22, 2),
(169, 11, 23, 2),
(170, 11, 24, 8),
(171, 11, 25, 2),
(172, 12, 4, 2),
(173, 12, 5, 4),
(174, 12, 10, 2),
(175, 12, 11, 2),
(176, 12, 12, 2),
(177, 12, 13, 2),
(178, 12, 14, 2),
(179, 12, 15, 2),
(180, 12, 16, 2),
(181, 12, 17, 2),
(182, 12, 18, 5),
(183, 12, 19, 2),
(184, 12, 20, 2),
(185, 12, 21, 2),
(186, 12, 22, 2),
(187, 12, 23, 2),
(188, 12, 24, 2),
(189, 12, 25, 2),
(190, 13, 1, 2),
(191, 13, 2, 2),
(192, 13, 3, 2),
(193, 13, 4, 2),
(194, 13, 5, 4),
(195, 13, 6, 5),
(196, 13, 7, 2),
(197, 13, 8, 2),
(198, 13, 9, 2),
(199, 13, 10, 2),
(200, 13, 11, 2),
(201, 13, 12, 2),
(202, 13, 13, 2),
(203, 13, 14, 2),
(204, 13, 15, 2),
(205, 13, 16, 2),
(206, 13, 17, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(25) NOT NULL,
  `pro_desc` text DEFAULT NULL,
  `pro_price` decimal(10,3) NOT NULL,
  `unit` int(11) NOT NULL,
  `pro_cat` int(11) NOT NULL,
  `quantity` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pro_id`, `pro_name`, `pro_desc`, `pro_price`, `unit`, `pro_cat`, `quantity`) VALUES
(1, 'Multigrain Bread', '', 30.000, 2, 2, 90),
(2, 'Cheesecakes', '', 150.000, 2, 3, 82),
(3, 'Cupcakes', '', 10.000, 2, 3, 86),
(4, 'Chocolate Chip Cookies', '', 10.000, 2, 6, 89),
(5, 'Croissants', '', 50.000, 2, 2, 84),
(6, 'Puffs', '', 15.000, 2, 1, 89),
(7, 'Blueberry Muffins', '', 80.000, 2, 4, 94),
(8, 'Chocolate Doughnuts', '', 40.000, 2, 4, 87),
(9, 'Khari Biscuits', '', 200.000, 2, 6, 88),
(10, 'Rusk', '', 30.000, 2, 6, 84),
(11, 'Garlic Knots', '', 120.000, 2, 1, 85),
(12, 'Sugar-Free Cakes', '', 150.000, 2, 3, 90),
(13, 'Hot Chocolate', '', 250.000, 2, 7, 88),
(14, 'Flavored Milkshakes', '', 70.000, 2, 7, 83),
(15, 'Brownies', '', 50.000, 2, 4, 88),
(16, 'Black Forest Cake', '', 50.000, 2, 3, 88),
(17, 'Butter Cookies', '', 50.000, 2, 6, 86),
(18, 'Bagels', '', 50.000, 2, 9, 85),
(19, 'Vegan Pastries', '', 50.000, 2, 8, 88),
(20, 'Cheeseburger', '', 50.000, 2, 1, 92),
(21, 'Margherita Pizza', '', 50.000, 2, 1, 83),
(22, 'Naan', '', 50.000, 2, 2, 91),
(23, 'Pita Bread', '', 50.000, 2, 2, 93),
(24, 'Green Tea', '', 50.000, 2, 7, 88),
(25, 'Espresso', '', 50.000, 2, 7, 92);

-- --------------------------------------------------------

--
-- Table structure for table `retailer`
--

CREATE TABLE `retailer` (
  `retailer_id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `address` varchar(200) NOT NULL,
  `area_id` int(11) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `retailer`
--

INSERT INTO `retailer` (`retailer_id`, `username`, `password`, `address`, `area_id`, `phone`, `email`) VALUES
(1, 'Surya', 'Surya123', 'Near Vejalpur Police Station, Vejalpur, Ahmedabad', 5, '7865340091', 'surya@gmail.com'),
(2, 'Priya', 'Priya123', 'A4 Ali Abad Appt, Kajal Park Soci, Sarkhej Road, Ahmedabad', 1, '9978454323', 'priya@gmail.com'),
(3, 'Kavya', 'Kavya123', 'Opp. Shivalik Complex, Vastrapur, Ahmedabad', 2, '9898906523', 'kavya@gmail.com'),
(4, 'Nishit', 'Nishit123', 'B/H Kakariya Lake, Maninagar, Ahmedabad', 3, '8980941941', 'nishit@gmail.com'),
(5, 'Rajesh', 'Rajesh123', 'C4-Pushpak Complex, New Ranip, Ahmedabad', 4, '7898902365', 'rajesh@gmail.com'),
(6, 'Rohan', 'Rohan123', '45, Shanti Nagar, Andheri East, Mumbai', 6, '7012345678', 'rohan@gmail.com'),
(7, 'Karthik', 'Karthik123', 'B-12, Green Park, New Delhi', 7, '9988011223', 'karthik@gmail.com'),
(8, 'Aniket', 'Aniket123', 'Flat No. 502, Sai Residency, Gachibowli', 8, '8456723109', 'aniket@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(20) NOT NULL,
  `unit_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit_name`, `unit_details`) VALUES
(1, 'KG', 'Kilo Gram'),
(2, 'PCS', 'Pieces'),
(3, 'LTR', 'Litre'),
(4, 'G', 'Gram'),
(5, 'LB', 'Pound'),
(6, 'OZ', 'Ounce'),
(7, 'ML', 'Milliliters');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`dist_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `retailer_id` (`retailer_id`),
  ADD KEY `dist_id` (`dist_id`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`invoice_items_id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`man_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `retailer_id` (`retailer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_items_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `pro_id` (`pro_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pro_id`),
  ADD KEY `unit` (`unit`),
  ADD KEY `pro_cat` (`pro_cat`);

--
-- Indexes for table `retailer`
--
ALTER TABLE `retailer`
  ADD PRIMARY KEY (`retailer_id`),
  ADD KEY `area_id` (`area_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `distributor`
--
ALTER TABLE `distributor`
  MODIFY `dist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `invoice_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `man_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `retailer`
--
ALTER TABLE `retailer`
  MODIFY `retailer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`dist_id`) REFERENCES `distributor` (`dist_id`) ON UPDATE CASCADE;

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`pro_id`) ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`retailer_id`) REFERENCES `retailer` (`retailer_id`) ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`pro_id`) REFERENCES `products` (`pro_id`) ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`pro_cat`) REFERENCES `categories` (`cat_id`) ON UPDATE CASCADE;

--
-- Constraints for table `retailer`
--
ALTER TABLE `retailer`
  ADD CONSTRAINT `retailer_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `area` (`area_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
