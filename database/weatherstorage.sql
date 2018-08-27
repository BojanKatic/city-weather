-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2018 at 03:18 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `weatherstorage`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int(11) NOT NULL,
  `log_departure_city` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_departure_dew_point` double NOT NULL,
  `log_departure_humidity` double NOT NULL,
  `log_departure_temperature` float NOT NULL,
  `log_departure_fog` double NOT NULL,
  `log_departure_low_cloud` double NOT NULL,
  `log_departure_medium_cloud` double NOT NULL,
  `log_departure_high_cloud` double NOT NULL,
  `log_destination_city` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_destination_dew_point` double NOT NULL,
  `log_destination_humidity` double NOT NULL,
  `log_destination_temperature` double NOT NULL,
  `log_destination_fog` double NOT NULL,
  `log_destination_low_cloud` double NOT NULL,
  `log_destination_medium_cloud` double NOT NULL,
  `log_destination_high_cloud` double NOT NULL,
  `log_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD UNIQUE KEY `log_id` (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
