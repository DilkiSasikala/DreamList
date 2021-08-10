-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2021 at 10:02 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cw_wishlist`
--

-- --------------------------------------------------------

--
-- Table structure for table `priority`
--

CREATE TABLE `priority` (
  `id` int(11) NOT NULL,
  `priority_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `priority`
--

INSERT INTO `priority` (`id`, `priority_type`) VALUES
(1, 'Must Have'),
(2, 'Nice to Have'),
(3, 'If You Can');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `wishlist_name` varchar(255) NOT NULL,
  `wishlist_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `full_name`, `wishlist_name`, `wishlist_description`) VALUES
(13, 'DSasi', '$2y$10$k3quNVnvBDeZnZojAMoNtu/Kw4iRALNqZNLyZlrAMeG9XI3mWaRYC', 'Dilki Sasikala', 'wishlist', 'this is my list'),
(14, 'admin', '$2y$10$lzgmQXR27C7lJxh5XXEk7e4mkzeEmt8orrOubX7R7S9fGAAAc/9CG', 'dilki', 'khgh', 'jjk');

-- --------------------------------------------------------

--
-- Table structure for table `wish_category`
--

CREATE TABLE `wish_category` (
  `id` int(11) NOT NULL,
  `category_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wish_category`
--

INSERT INTO `wish_category` (`id`, `category_type`) VALUES
(1, 'Birthday'),
(2, 'Christmas'),
(3, 'Wedding'),
(4, 'Moving House'),
(5, 'Baby shower');

-- --------------------------------------------------------

--
-- Table structure for table `wish_list`
--

CREATE TABLE `wish_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wish_category_id` int(11) NOT NULL,
  `priority_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_url` varchar(1024) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wish_list`
--

INSERT INTO `wish_list` (`id`, `user_id`, `wish_category_id`, `priority_id`, `item_name`, `item_url`, `price`) VALUES
(112, 13, 3, 1, 'something', 'https://www.ebay.com/p/19036901575?iid=254430512912&var=554510021537', '67.00'),
(113, 14, 3, 3, 'add', 'fdfsd', '324342.00'),
(114, 14, 3, 2, 'qweqwrew', 'ewrwerwe', '234322.00'),
(115, 14, 3, 3, 'add', 'wewewew', '32423342.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wish_category`
--
ALTER TABLE `wish_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wish_list`
--
ALTER TABLE `wish_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `priority_id` (`priority_id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `wish_category_id` (`wish_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `priority`
--
ALTER TABLE `priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `wish_category`
--
ALTER TABLE `wish_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wish_list`
--
ALTER TABLE `wish_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wish_list`
--
ALTER TABLE `wish_list`
  ADD CONSTRAINT `wish_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `wish_list_ibfk_2` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`id`),
  ADD CONSTRAINT `wish_list_ibfk_4` FOREIGN KEY (`wish_category_id`) REFERENCES `wish_category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
