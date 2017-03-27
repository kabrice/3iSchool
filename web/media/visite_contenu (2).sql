-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 25, 2017 at 03:08 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3iSchool`
--

-- --------------------------------------------------------

--
-- Table structure for table `visite_contenu`
--

CREATE TABLE `visite_contenu` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `contenu_id` int(11) DEFAULT NULL,
  `date_visite` datetime NOT NULL,
  `duree` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `visite_contenu`
--

INSERT INTO `visite_contenu` (`id`, `user_id`, `contenu_id`, `date_visite`, `duree`) VALUES
(1, 1, 1, '2017-01-08 07:23:20', 30),
(2, 1, 1, '2017-01-24 13:33:20', 24),
(3, 1, 1, '2017-01-19 03:28:43', 57),
(4, 2, 1, '2017-01-08 11:23:20', 12),
(5, 2, 1, '2017-01-18 11:23:22', 2),
(6, 1, 2, '2017-01-18 10:23:22', 67),
(7, 1, 2, '2017-01-12 10:23:22', 33),
(8, 2, 2, '2017-01-12 10:10:22', 100),
(18, 3, 1, '2017-02-22 17:26:00', 31.078733333331),
(19, 1, 1, '2017-02-22 19:00:00', 1.39355),
(20, 3, 1, '2017-02-23 03:26:00', 97.713683333333);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `visite_contenu`
--
ALTER TABLE `visite_contenu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_43C37519A76ED395` (`user_id`),
  ADD KEY `IDX_43C375193C1CC488` (`contenu_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `visite_contenu`
--
ALTER TABLE `visite_contenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `visite_contenu`
--
ALTER TABLE `visite_contenu`
  ADD CONSTRAINT `FK_43C375193C1CC488` FOREIGN KEY (`contenu_id`) REFERENCES `contenu` (`id`),
  ADD CONSTRAINT `FK_43C37519A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
