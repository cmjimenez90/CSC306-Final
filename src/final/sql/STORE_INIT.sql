-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Dec 15, 2019 at 06:26 PM
-- Server version: 8.0.18
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `STORE`
--

-- --------------------------------------------------------

--
-- Table structure for table `STORE_CUSTOMER`
--

CREATE TABLE `STORE_CUSTOMER` (
  `CUSTOMER_ID` int(11) NOT NULL,
  `CUSTOMER_FIRSTNAME` varchar(50) NOT NULL,
  `CUSTOMER_LASTNAME` varchar(50) NOT NULL,
  `CUSTOMER_EMAIL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `CUSTOMER_ADDRESS` varchar(255) NOT NULL,
  `CUSTOMER_CITY` varchar(255) NOT NULL,
  `CUSTOMER_STATE` varchar(10) NOT NULL,
  `CUSTOMER_ZIP` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `STORE_ORDER`
--

CREATE TABLE `STORE_ORDER` (
  `ORDER_ID` int(11) NOT NULL,
  `ORDER_DATE` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ORDER_CUSTOMER` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `STORE_ORDERITEMS`
--

CREATE TABLE `STORE_ORDERITEMS` (
  `ORDER_ID` int(11) NOT NULL,
  `ITEM_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `STORE_PRODUCT`
--

CREATE TABLE `STORE_PRODUCT` (
  `PRODUCT_ID` int(11) NOT NULL,
  `PRODUCT_NAME` varchar(255) NOT NULL,
  `PRODUCT_DESC` text,
  `PRODUCT_COST` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `STORE_PRODUCT`
--

INSERT INTO `STORE_PRODUCT` (`PRODUCT_ID`, `PRODUCT_NAME`, `PRODUCT_DESC`, `PRODUCT_COST`) VALUES
(1, 'Gloomhaven', 'Players will take on the role of a wandering adventurer with their own special set of skills and their own reasons for traveling to this dark corner of the world. Players must work together out of necessity to clear out menacing dungeons and forgotten ruins. In the process, they will enhance their abilities with experience and loot, discover new locations to explore and plunder, and expand an ever-branching story fueled by the decisions they make.', 100.00),
(2, 'Catan', 'Players try to be the dominant force on the island of Catan by building settlements, cities, and roads. ', 35.75),
(3, 'Star Wars Rebellion', 'In Rebellion, you control the entire Galactic Empire or the fledgling Rebel Alliance. You must command starships, account for troop movements, and rally systems to your cause. ', 86.99),
(4, 'Cthulhu: Death May Die', 'The ritual cannot be stopped, but the cultists’ plans might still be! The cultists have been painstakingly preparing for this moment for quite some time. An elder God, a being adrift in a different dimension, has reached out into their minds, giving them the knowledge necessary to awaken it, and bring it into our own world, unleashing its hellish powers on the unsuspecting populace. The investigators found out about it too late. The final ritual has begun. But with a little luck, The God might just be vulnerable for a moment after being summoned. ', 80.95),
(5, 'Terraforming Mars', 'In the 2400s, mankind begins to terraform the planet Mars. Giant corporations, sponsored by the World Government on Earth, initiate huge projects to raise the temperature, the oxygen level, and the ocean coverage until the environment is habitable. ', 45.99);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `STORE_CUSTOMER`
--
ALTER TABLE `STORE_CUSTOMER`
  ADD PRIMARY KEY (`CUSTOMER_ID`),
  ADD UNIQUE KEY `email` (`CUSTOMER_EMAIL`);

--
-- Indexes for table `STORE_ORDER`
--
ALTER TABLE `STORE_ORDER`
  ADD PRIMARY KEY (`ORDER_ID`),
  ADD KEY `ORDER_CUSTOMER` (`ORDER_CUSTOMER`);

--
-- Indexes for table `STORE_ORDERITEMS`
--
ALTER TABLE `STORE_ORDERITEMS`
  ADD PRIMARY KEY (`ORDER_ID`,`ITEM_ID`),
  ADD KEY `ITEM_ID` (`ITEM_ID`);

--
-- Indexes for table `STORE_PRODUCT`
--
ALTER TABLE `STORE_PRODUCT`
  ADD PRIMARY KEY (`PRODUCT_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `STORE_CUSTOMER`
--
ALTER TABLE `STORE_CUSTOMER`
  MODIFY `CUSTOMER_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `STORE_ORDER`
--
ALTER TABLE `STORE_ORDER`
  MODIFY `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `STORE_PRODUCT`
--
ALTER TABLE `STORE_PRODUCT`
  MODIFY `PRODUCT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `STORE_ORDER`
--
ALTER TABLE `STORE_ORDER`
  ADD CONSTRAINT `STORE_ORDER_ibfk_1` FOREIGN KEY (`ORDER_CUSTOMER`) REFERENCES `STORE_CUSTOMER` (`CUSTOMER_ID`);

--
-- Constraints for table `STORE_ORDERITEMS`
--
ALTER TABLE `STORE_ORDERITEMS`
  ADD CONSTRAINT `STORE_ORDERITEMS_ibfk_1` FOREIGN KEY (`ORDER_ID`) REFERENCES `STORE_ORDER` (`ORDER_ID`),
  ADD CONSTRAINT `STORE_ORDERITEMS_ibfk_2` FOREIGN KEY (`ITEM_ID`) REFERENCES `STORE_PRODUCT` (`PRODUCT_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
