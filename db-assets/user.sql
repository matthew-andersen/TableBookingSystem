-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2016 at 02:08 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inq_dashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `num_days` int(11) NOT NULL,
  `num_desk_hours` int(11) NOT NULL,
  `num_room_hours` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `name`, `email`, `password`, `num_days`, `num_desk_hours`, `num_room_hours`) VALUES
(1, 'ddoncila', 'Draga', 'ddoncila@gmail.com', '123456', 8, 8, 30),
(2, 'bobberton', 'Bob', 'bobberton@gmail.com', 'abcd', 0, 10, 4),
(3, 'doe', 'Jane', 'janedoe@gmail.com', '123', 0, 10, 4),
(4, 'johnnie', 'Johnnie', 'johnnie@gmail.com', '123456', 0, 10, 4),
(5, 'james', 'johnnie', 'a@b.c', '123', 0, 10, 4),
(6, 'johnnob', 'johnno', 'a@b.com', '123456', 0, 10, 4),
(7, 'jamie', 'James', 'jamie@jones.com', 'ready', 0, 10, 4),
(8, 'gordon', 'Gordon', 'gordon@gordon.com', 'gordon', 0, 10, 4),
(9, 'bean', 'bean', 'bean@bean.bean', 'bean', 0, 6, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
