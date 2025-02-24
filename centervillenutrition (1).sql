-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2025 at 07:02 PM
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
-- Database: `centervillenutrition`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(11) NOT NULL,
  `ItemList` varchar(10000) NOT NULL,
  `CostTotal` float NOT NULL,
  `ItemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `ItemList`, `CostTotal`, `ItemID`) VALUES
(19, '', 0, 0),
(33, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customization`
--

CREATE TABLE `customization` (
  `CustomizationID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Price` float NOT NULL,
  `Description` varchar(10000) NOT NULL,
  `InStock` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customization`
--

INSERT INTO `customization` (`CustomizationID`, `Name`, `Price`, `Description`, `InStock`) VALUES
(4, 'Collagen', 1.99, 'Collagen', 1),
(5, 'Immune Support', 1.99, '', 1),
(6, 'Fiber', 0.99, '', 1),
(7, 'Electrolytes', 0.99, '', 1),
(8, 'Vitamin C', 0.59, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `hours`
--

CREATE TABLE `hours` (
  `ID` int(11) NOT NULL,
  `Day` varchar(50) NOT NULL,
  `Open` int(11) NOT NULL,
  `Close` int(11) NOT NULL,
  `isOpen` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hours`
--

INSERT INTO `hours` (`ID`, `Day`, `Open`, `Close`, `isOpen`) VALUES
(0, 'Sunday', 8, 5, 0),
(1, 'Monday', 8, 12, 1),
(2, 'Tuesday', 8, 5, 1),
(3, 'Wednesday', 8, 5, 1),
(4, 'Thursday', 8, 5, 1),
(5, 'Friday', 8, 5, 1),
(6, 'Saturday', 10, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `ItemID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `Price` decimal(20,2) NOT NULL,
  `InStock` tinyint(1) NOT NULL DEFAULT 1,
  `type` varchar(10) NOT NULL,
  `ImagePath` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`ItemID`, `Name`, `Description`, `Price`, `InStock`, `type`, `ImagePath`) VALUES
(1, 'Green Apple', 'Green Apple', 9.50, 1, 'Tea', 'none'),
(2, 'Green Gusher', 'Green Apple & Strawberry', 9.50, 1, 'Tea', 'none'),
(3, 'Gummy Bear', 'Kiwi', 9.50, 1, 'Tea', 'none'),
(4, 'Hawaiian Paradise', 'Tropical & Coconut', 9.50, 1, 'Tea', 'none'),
(5, 'Hulk', 'Kiwi & Pineapple', 9.50, 1, 'Tea', 'none'),
(6, 'Mermaid', 'Blue Raspberry Lemonade', 9.50, 1, 'Tea', 'none'),
(7, 'Miami Vice', 'Orange & Strawberry', 9.50, 1, 'Tea', 'none'),
(8, 'Ocean Drive', 'Lime, Blue Razz & Watermelon', 9.50, 1, 'Tea', 'none'),
(9, 'Orange Creamsicle', 'Orange Creamsicle', 9.50, 1, 'Tea', 'none'),
(10, 'Paradise Sunset', 'Strawberry & Pineapple', 9.50, 1, 'Tea', 'none'),
(11, 'Pineapple Punch', 'Orange & Pineapple', 9.50, 1, 'Tea', 'none'),
(12, 'Pink Starburst', 'Pink Starburst Candy Flavor', 9.50, 1, 'Tea', 'none'),
(13, 'Sangria', 'Berries & Grape', 9.50, 1, 'Tea', 'none'),
(14, 'Skittles', 'Skittles Candy Flavor', 9.50, 1, 'Tea', 'none'),
(15, 'Strawberry Daiquiri', 'Red Strawberry', 9.50, 1, 'Tea', 'none'),
(16, 'Strawberry Margarita', 'Margarita & Strawberry', 9.50, 1, 'Tea', 'none'),
(17, 'Sweet Tart', 'Sweet Tart Candy Flavor', 9.50, 1, 'Tea', 'none'),
(18, 'Strawberry Peach', 'Strawberry & Peach', 9.50, 1, 'Tea', 'none'),
(19, 'Tahiti', 'Tropical & Pina Colada', 9.50, 1, 'Tea', 'none'),
(20, 'Tropical Sunrise', 'Watermelon & Orange', 9.50, 1, 'Tea', 'none'),
(21, 'Watermelon Jolly Rancher', 'Watermelon Jolly Rancher Flavor', 9.50, 1, 'Tea', 'none'),
(22, 'Banana Caramel', 'Sweet banana with rich caramel notes', 10.50, 1, 'Shake', 'none'),
(23, 'Apple Banana', 'Fruity blend of apple and banana', 10.50, 1, 'Shake', 'none'),
(24, 'Banana Bread', 'Tastes like freshly baked banana bread', 10.50, 1, 'Shake', 'none'),
(26, 'Banana Cream Pie', 'Smooth, creamy banana pie flavor', 10.50, 1, 'Shake', 'none'),
(27, 'Banana Split', 'Classic dessert-inspired banana shake', 10.50, 1, 'Shake', 'none'),
(28, 'Banana Foster', 'Caramelized banana with a hint of cinnamon', 10.50, 1, 'Shake', 'none'),
(29, 'Chunky Monkey', 'Banana, chocolate, and nutty flavors', 10.50, 1, 'Shake', 'none'),
(30, 'Mango Banana', 'Tropical mango with ripe banana', 10.50, 1, 'Shake', 'none'),
(31, 'Peanut Butter Banana', 'Creamy peanut butter and banana', 10.50, 1, 'Shake', 'none'),
(32, 'Buckeye Cappuccino', 'Cappuccino with chocolate and peanut butter', 10.50, 1, 'Shake', 'none'),
(33, 'Café Mocha', 'Coffee blended with chocolate', 10.50, 1, 'Shake', 'none'),
(34, 'Caramel Latte', 'Latte with a sweet caramel touch', 10.50, 1, 'Shake', 'none'),
(35, 'Chai Tea Latte', 'Spiced chai with creamy latte notes', 10.50, 1, 'Shake', 'none'),
(36, 'Apple Jacks', 'Sweet, apple-cinnamon cereal flavor', 10.50, 1, 'Shake', 'none'),
(37, 'Chips Ahoy', 'Cookie flavor with chocolate chip taste', 10.50, 1, 'Shake', 'none'),
(38, 'Peach Cobbler', 'Fruity peach with a hint of cinnamon', 10.50, 1, 'Shake', 'none'),
(39, 'Peanut Butter Cookie', 'Rich, creamy peanut butter cookie flavor', 10.50, 1, 'Shake', 'none'),
(40, 'Boaz Sunrise', 'Refreshing tropical sunrise blend', 10.50, 1, 'Shake', 'none'),
(41, 'Caribbean Colada', 'Classic Caribbean coconut and pineapple', 10.50, 1, 'Shake', 'none'),
(42, 'Hawaiian Island', 'Tropical island-inspired flavors', 10.50, 1, 'Shake', 'none'),
(43, 'Caramel Apple', 'Crisp apple with sweet caramel', 10.50, 1, 'Shake', 'none'),
(44, 'Caramel Blondie', 'Buttery caramel with vanilla notes', 10.50, 1, 'Shake', 'none'),
(45, 'The Golden Bear', 'Sweet and smooth, like honey caramel', 10.50, 1, 'Shake', 'none'),
(46, 'Fried Peach Pie', 'Warm peach with a hint of cinnamon', 10.50, 1, 'Shake', 'none'),
(47, 'Cocada', 'Rich coconut and caramel flavors', 10.50, 1, 'Shake', 'none'),
(48, 'Apple Pie', 'Spiced apple with a pie-like flavor', 10.50, 1, 'Shake', 'none'),
(49, 'Birthday Cake', 'Sweet, festive cake flavor', 10.50, 1, 'Shake', 'none'),
(50, 'Blueberry Muffin', 'Fresh blueberry with muffin notes', 10.50, 1, 'Shake', 'none'),
(51, 'Georgia Peach', 'Juicy, sweet Georgia peach', 10.50, 1, 'Shake', 'none'),
(52, 'Nutty Butter', 'Rich, creamy peanut flavor', 10.50, 1, 'Shake', 'none'),
(53, 'Cinnamon Toast Crunch', 'Cinnamon and cereal-inspired flavor', 10.50, 1, 'Shake', 'none'),
(54, 'Mint Chocolate', 'Refreshing mint with chocolate', 10.50, 1, 'Shake', 'none'),
(55, 'Orange Cream', 'Creamy orange, like a creamsicle', 10.50, 1, 'Shake', 'none'),
(56, 'Boaz Sunset', 'Sweet, tropical sunset blend', 10.50, 1, 'Shake', 'none'),
(57, 'Sun Mango Tango', 'Mango with a tropical twist', 10.50, 1, 'Shake', 'none'),
(58, 'Tropical Breeze', 'Cool, refreshing tropical flavor', 10.50, 1, 'Shake', 'none'),
(59, 'Dutch Chocolate', 'Deep, rich chocolate', 10.50, 1, 'Shake', 'none'),
(60, 'Chocolate Lovers', 'Chocolate overload for cocoa fans', 10.50, 1, 'Shake', 'none'),
(61, 'Peanut Butter Cup', 'Chocolate with peanut butter', 10.50, 1, 'Shake', 'none'),
(62, 'Snickers', 'Caramel, peanut, and chocolate blend', 10.50, 1, 'Shake', 'none'),
(63, 'Tootsie Roll', 'Classic chocolatey candy flavor', 10.50, 1, 'Shake', 'none'),
(64, 'Crunch Berry', 'Crisp, fruity berry cereal taste', 10.50, 1, 'Shake', 'none'),
(65, 'Strawberry', 'Simple, sweet strawberry', 10.50, 1, 'Shake', 'none'),
(66, 'Strawberry Banana', 'Strawberry and banana blend', 10.50, 1, 'Shake', 'none'),
(67, 'Very Berry', 'Mixed berry blend', 10.50, 1, 'Shake', 'none'),
(68, 'Banana Berry', 'Banana and berry fusion', 10.50, 1, 'Shake', 'none'),
(69, 'Strawberry Shortcake', 'Classic strawberry shortcake flavor', 10.50, 1, 'Shake', 'none'),
(70, 'Pineapple Martini', 'Pineapple with a tangy twist', 10.50, 1, 'Shake', 'none'),
(71, 'Berry Colada', 'Berry and coconut blend', 10.50, 1, 'Shake', 'none'),
(72, 'Orange Sherbert', 'Citrusy and creamy', 10.50, 1, 'Shake', 'none'),
(75, 'Strawberry Bliss', 'Strawberry Bliss', 10.50, 1, 'Shake', 'none'),
(78, 'Free Drink', 'Free Drink', -11.00, 0, 'neither', 'none'),
(80, 'Hampter', 'Hampter', 10.50, 1, 'Shake', 'none'),
(81, 'Brayden', 'What the heck', 10000.99, 1, 'Tea', './menuImages/Brayden.png'),
(82, 'Adam', 'Adam', 9999999999999999.99, 1, 'Tea', './menuImages/Adam.png'),
(91, 'Walter White', 'Charlie and Jesse', 9.50, 1, 'Shake', './menuImages/Walter_White.png'),
(93, 'Hamster', 'Hamster', 9.50, 1, 'Tea', './menuImages/Hamster.png'),
(94, 'Turbkey', 'lettuce', 9.50, 1, 'Tea', './menuImages/Turbkey.png'),
(96, 'Walmart Bathroom', 'toilet water flavor', 10.50, 1, 'Shake', './menuImages/Walmart_Bathroom.png');

-- --------------------------------------------------------

--
-- Table structure for table `punchcard`
--

CREATE TABLE `punchcard` (
  `CartID` int(11) NOT NULL,
  `CurrentPunches` int(11) NOT NULL,
  `UnrewardedCards` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `punchcard`
--

INSERT INTO `punchcard` (`CartID`, `CurrentPunches`, `UnrewardedCards`) VALUES
(19, 2, 12595),
(33, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `Email` varchar(200) NOT NULL,
  `PurchasedCart` varchar(1000) NOT NULL,
  `Cost` float NOT NULL,
  `Date` varchar(100) NOT NULL,
  `Free` float NOT NULL,
  `ReceiptOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`Email`, `PurchasedCart`, `Cost`, `Date`, `Free`, `ReceiptOrder`) VALUES
('Brayden', '#27,', 11.24, '12:58pm February 24, 2025', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `BuyOneGetOne` tinyint(1) NOT NULL,
  `BuyThree` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`BuyOneGetOne`, `BuyThree`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `Email` varchar(200) NOT NULL,
  `Pass` varchar(200) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `CartID` int(11) NOT NULL,
  `IsAdmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Email`, `Pass`, `FirstName`, `LastName`, `CartID`, `IsAdmin`) VALUES
('Brayden', '1ef02769e3cb6049cb6231a61224b7b9', 'Brayden', 'Brayden', 19, 1),
('Charlie@Charlie', 'ea2bfa79cd221f1e88a9bf39ea155cd8', 'Charlie', 'Charlie', 33, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`);

--
-- Indexes for table `customization`
--
ALTER TABLE `customization`
  ADD PRIMARY KEY (`CustomizationID`);

--
-- Indexes for table `hours`
--
ALTER TABLE `hours`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `punchcard`
--
ALTER TABLE `punchcard`
  ADD PRIMARY KEY (`CartID`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`ReceiptOrder`),
  ADD KEY `ReceiptOrder` (`ReceiptOrder`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`CartID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `customization`
--
ALTER TABLE `customization`
  MODIFY `CustomizationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `hours`
--
ALTER TABLE `hours`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `punchcard`
--
ALTER TABLE `punchcard`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `ReceiptOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `CartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `punchcard`
--
ALTER TABLE `punchcard`
  ADD CONSTRAINT `AAAA` FOREIGN KEY (`CartID`) REFERENCES `user` (`CartID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
