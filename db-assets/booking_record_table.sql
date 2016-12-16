-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2016 at 02:07 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking_record_table`
--

CREATE TABLE `booking_record_table` (
  `booking_id` int(11) NOT NULL,
  `date_created` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `num_days` int(11) NOT NULL,
  `num_desk_hours` int(11) NOT NULL,
  `num_room_hours` int(11) NOT NULL,
  `start_datetime` text COLLATE utf8_unicode_ci NOT NULL,
  `end_datetime` text COLLATE utf8_unicode_ci NOT NULL,
  `location_id` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `booking_record_table`
--

INSERT INTO `booking_record_table` (`booking_id`, `date_created`, `user_id`, `num_days`, `num_desk_hours`, `num_room_hours`, `start_datetime`, `end_datetime`, `location_id`) VALUES
(105, '20161216', 1, 1, 0, 0, '2016-12-18 08:30:00', '2016-12-18 18:00:00', 'desk_4'),
(106, '20161216', 1, 1, 0, 0, '2016-12-17 08:30:00', '2016-12-17 18:00:00', 'desk_4'),
(107, '20161216', 1, 1, 0, 0, '2016-12-18 08:30:00', '2016-12-18 18:00:00', 'desk_2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_record_table`
--
ALTER TABLE `booking_record_table`
  ADD PRIMARY KEY (`booking_id`),
  ADD UNIQUE KEY `booking_id` (`booking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_record_table`
--
ALTER TABLE `booking_record_table`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
