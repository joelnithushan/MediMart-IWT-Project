-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2024 at 03:24 AM
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
-- Database: `medimart_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CID` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileNo` varchar(10) NOT NULL,
  `address1` varchar(500) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `newAddress` varchar(500) NOT NULL,
  `itemsAndQuantity` varchar(1000) NOT NULL,
  `Ordered-date-and-Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CID`, `uname`, `email`, `mobileNo`, `address1`, `payment`, `newAddress`, `itemsAndQuantity`, `Ordered-date-and-Time`) VALUES
(7, 'Ravikumar', 'ravistocky@gmail.com', '0769434133', 'No.16 Gurunagar, Jaffna.', 'Card Payment', '', 'alendronate tablet - Fosamax Qty = 1 / llopurinol tablet - Zyloprim Qty = 1 / Panadol 240 Tablets - One Box - Panadol Qty = 2 / ', '2024-10-14 09:59:50'),
(8, 'Anton RajKumar', 'antonraj@gmail.com', '0768452154', 'rajbakery,pandatharippu', 'Card Payment', '', 'nystatin tablet - Nystatin tablet Qty = 2 / alendronate tablet - Fosamax Qty = 1 / amiodarone table - Cordarone Qty = 1 / AND UA-1020 - Upper Arm Blood Pressure Monitor Qty = 1 / Blood Pressure Meter Bulb - Sphygmomanometer Qty = 1 / Axe universal oil (56ml) - AXE Qty = 3 / ', '2024-10-14 14:00:17'),
(9, 'Gugan Kageepan', 'kanna@gmail.com', '0774185263', 'chavakachcheri', 'Card Payment', '', 'Axe universal oil (56ml) - AXE Qty = 1 / Imsyser - Imsyser Internal Microbial Stabiliser Qty = 1 / Garlichol black seed oil (30s) - Baraka Qty = 1 / methylphenidate tablet - Ritalin Qty = 2 / ', '2024-10-14 17:53:09'),
(10, 'Sritharan Sinthujan', 'sinthujaninfo@gmail.com', '0759463251', '377 vaddakkachchi', 'Cash On Delivery', '', 'AND UA-651 - Upper Arm Blood Pressure Monitor Qty = 1 / ', '2024-10-15 23:51:52');

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `cmtID` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileNo` int(10) NOT NULL,
  `userIdeas` varchar(1000) NOT NULL,
  `comment-date-and-Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`cmtID`, `uname`, `email`, `mobileNo`, `userIdeas`, `comment-date-and-Time`) VALUES
(8, 'Kageepan', 'kanna@gmail.com', 0, 'when you deliver my order?', '2024-10-14 18:00:14'),
(9, 'DIltan A', 'diltan@gmail.com', 752136984, 'How I track my order?', '2024-10-14 18:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemID` int(11) NOT NULL,
  `genericName` varchar(100) NOT NULL,
  `brandName` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  `itemPrice` float NOT NULL,
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0,
  `itemImage` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `genericName`, `brandName`, `code`, `itemPrice`, `isDeleted`, `itemImage`, `type`) VALUES
(1, 'Alendronate tablet', 'Fosamax', 'med01', 3200, 0, 'img1.jpg', 'medicine'),
(2, 'Acyclovir capsule', 'Zovirax', 'med02', 350, 0, 'img1.jpg', 'medicine'),
(3, 'Llopurinol tablet', 'Zyloprim', 'med03', 260, 0, 'img3.jpeg', 'medicine'),
(4, 'Amiodarone table', 'Cordarone', 'med04', 1887, 0, 'img4.jpg', 'medicine'),
(5, 'Clonidine HCL tablets', 'Catapres', 'med05', 175, 0, 'img5.jpg', 'medicine'),
(6, 'Clopidogrel bisulfate tablets', 'Plavix', 'med06', 102, 0, 'img6.jpg', 'medicine'),
(7, 'Decitabine', 'Dacogen', 'med07', 500, 0, 'img7.jpg', 'medicine'),
(8, 'Letrozole', 'Femara', 'med08', 900, 0, 'img8.jpg', 'medicine'),
(9, 'Methylphenidate tablet', 'Ritalin', 'med09', 500, 0, 'img9.jpg', 'medicine'),
(10, 'Nystatin tablet', 'Nystatin tablet', 'med10', 600, 0, 'img10.jpg', 'medicine'),
(11, 'AND UA-651', 'Upper Arm Blood Pressure Monitor', 'medDiv01', 13500, 0, 'img15.jpeg', 'medical devices'),
(12, 'AND UM-102', 'Mercury-Free Sphygmomanometer', 'medD02', 26000, 0, 'img17.jpg', 'medical devices'),
(13, 'AND UA-1020', 'Upper Arm Blood Pressure Monitor', 'medD03', 20000, 0, 'img19.jpg', 'medical devices'),
(14, 'AND UM-201', 'Blood Pressure Monitor', 'medD04', 28000, 0, 'img20.jpg', 'medical devices'),
(15, 'Bionime GM700', 'Glucometer (Lifetime Warranty)', 'medD05', 3500, 0, 'img21.jpeg', 'medical devices'),
(16, 'Medismart Sapphire', 'Blood Glucose Test Strips-25', 'medD06', 2000, 0, 'img22.jpg', 'medical devices'),
(18, 'Blood Pressure Meter Bulb', 'Sphygmomanometer', 'medD09', 1590, 0, 'img25.jpg', 'medical devices'),
(20, 'Aloe Vera', 'Aloe Vera Esi Gel 200ml Argan', 'medTR01', 500, 0, 'img30.jpg', 'traditional remedies'),
(21, 'HERBAL DRAUGHT', 'African Ginger Tea 25g', 'medTR02', 300, 0, 'img31.jpg', 'traditional remedies'),
(22, 'Lennons', 'Lennons Gal Tablets', 'medTR03', 500, 0, 'img32.jpg', 'traditional remedies'),
(23, 'Lmsyser', 'Imsyser Internal Microbial Stabiliser', 'medTR04', 1500, 0, 'img33.jpg', 'traditional remedies'),
(24, 'Tablets USP 500000 units', 'nystatin', 'med11', 600, 0, 'img10.jpg', 'medicine'),
(25, 'Femara', 'Letrozole', 'med12', 748.79, 0, 'img8.jpg', 'medicine'),
(26, 'Portable', 'Urinal Male', 'medD11', 699, 0, 'img26.jpeg', 'medical devices'),
(27, 'Stethoscope', 'Dual Rhythm Stethoscope', 'medD13', 4950, 0, 'img24.jpg', 'medical devices'),
(29, 'BiPAP Machine', 'BIPAP', 'medD002', 360000, 0, 'imgmed1.jpg', 'medical devices'),
(30, 'Silicon catheter 20G', 'catheter', 'medD003', 1300, 0, 'imgmed2.jpg', 'medical devices'),
(31, 'Softa Care Urine Bag', '400cc Urine Bag ', 'medD005', 1350, 0, 'imgmed3.jpg', 'medical devices'),
(32, 'Osupen(50g)', 'Link natural', 'medTR001', 110, 0, 'osupan_1000x1000.jpg', 'traditional remedies'),
(33, 'Axe universal oil (56ml)', 'AXE', 'medTR002', 120, 0, 'axe.jpg', 'traditional remedies'),
(34, 'cystone tablets (100s)', 'Himalaya', 'medTR003', 5300, 0, 'himalaya-cystone-tablets.jpg', 'traditional remedies'),
(35, 'Garlichol black seed oil (30s)', 'Baraka', 'medTR004', 3200, 0, 'dsc_0541-1_copy_1.jpg', 'traditional remedies'),
(36, 'Panadol 240 Tablets - One Box', 'Panadol', 'med13', 1290, 0, 'panadol.png', 'medicine');

-- --------------------------------------------------------

--
-- Table structure for table `mmuser`
--

CREATE TABLE `mmuser` (
  `mmUID` int(11) NOT NULL,
  `uName` varchar(100) NOT NULL,
  `eMailAddress` varchar(100) NOT NULL,
  `uMobileNo` int(10) NOT NULL,
  `uAddress` varchar(500) NOT NULL,
  `city` varchar(50) NOT NULL,
  `UPW` varchar(100) NOT NULL,
  `mmRole` varchar(50) NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mmuser`
--

INSERT INTO `mmuser` (`mmUID`, `uName`, `eMailAddress`, `uMobileNo`, `uAddress`, `city`, `UPW`, `mmRole`) VALUES
(1, 'Joel Nithushan', 'joelnithushan6@gmail.com', 769423167, 'Chittampalapuram,Atchuvely.', 'Atchuvely', 'Nithuqaz1234', 'Admin'),
(2, 'Kani Kanistan', 'kanistan10@gmailcom', 765313367, 'No.30 pannai road, changanai', 'Changanai', '12345678', 'Admin'),
(3, 'Sritharan Sinthujan', 'sinthujaninfo@gmail.com', 759463251, '377 vaddakkachchi', 'Kilinochchi', 'Sinthu1234', 'User'),
(4, 'Gugan Kageepan', 'kanna@gmail.com', 774185263, 'chavakachcheri', 'Chavakachcheri', '14725836', 'User'),
(5, 'Dillu Diltan', 'diltan@gmail.com', 758484152, 'thellipalai', 'Thellipalai', '1020304050', 'User'),
(6, 'Anton RajKumar', 'antonraj@gmail.com', 768452154, 'rajbakery,pandatharippu', 'Pandatharirppu', 'Anton2001', 'User'),
(7, 'Vaishnavi', 'vaishnavi@gmail.com', 779854126, 'No.204 nallur road,jaffna', 'Nallur', '78945612', 'User'),
(13, 'Ravikumar', 'ravistocky@gmail.com', 769434133, 'No.16 Gurunagar, Jaffna.', 'Jaffna', 'Ravi2002', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `SID` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dateAndTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`SID`, `email`, `dateAndTime`) VALUES
(3, 'sinthujaninfo@gmail.com', '2024-10-14 10:54:09'),
(4, 'kanna@gmail.com', '2024-10-14 17:51:57');

-- --------------------------------------------------------

--
-- Table structure for table `pupload`
--

CREATE TABLE `pupload` (
  `PID` int(11) NOT NULL,
  `uname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobileNo` varchar(10) NOT NULL,
  `address1` varchar(500) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `fullfillment` varchar(50) NOT NULL,
  `substitutes` varchar(50) NOT NULL,
  `days` int(11) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `refund` varchar(50) NOT NULL,
  `prescriptionTxt` varchar(1000) NOT NULL,
  `prescriptionFile` varchar(100) NOT NULL,
  `newAddress` varchar(1000) NOT NULL,
  `Ordered-date-and-Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pupload`
--

INSERT INTO `pupload` (`PID`, `uname`, `email`, `mobileNo`, `address1`, `frequency`, `fullfillment`, `substitutes`, `days`, `payment`, `refund`, `prescriptionTxt`, `prescriptionFile`, `newAddress`, `Ordered-date-and-Time`) VALUES
(8, 'Ravikumar', 'ravistocky@gmail.com', '0769434133', 'No.16 Gurunagar, Jaffna.', 'One Time', 'Full', 'Yes', 12, 'Card Payment', 'Cash', 'Paracetamol (500mg)\r\nDosage: 1 tablet every 6 hours\r\nDuration: 3 days', '', '', '2024-10-14 10:20:42'),
(9, 'Gugan Kageepan', 'kanna@gmail.com', '0774185263', 'chavakachcheri', 'One Time', 'Full', 'No', 5, 'Card Payment', 'Online Banking', 'nope', 'download (2).jpeg', '', '2024-10-14 17:50:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`cmtID`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemID`);

--
-- Indexes for table `mmuser`
--
ALTER TABLE `mmuser`
  ADD PRIMARY KEY (`mmUID`),
  ADD UNIQUE KEY `eMailAddress` (`eMailAddress`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `pupload`
--
ALTER TABLE `pupload`
  ADD PRIMARY KEY (`PID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `cmtID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `mmuser`
--
ALTER TABLE `mmuser`
  MODIFY `mmUID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pupload`
--
ALTER TABLE `pupload`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
