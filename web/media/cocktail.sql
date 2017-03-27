-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 16, 2017 at 12:54 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cocktail`
--

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ingredient`
--

INSERT INTO `ingredient` (`id`, `nom`, `description`) VALUES
(1, 'Cube', 'Aromatisé un met'),
(2, 'Huile rouge', 'Savouré un met'),
(3, 'Sel', 'Savourer un mêt');

-- --------------------------------------------------------

--
-- Table structure for table `recette`
--

CREATE TABLE `recette` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recette`
--

INSERT INTO `recette` (`id`, `user_id`, `nom`, `description`, `image`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 8, 'Taro', 'Sauce jaune, viande, tubercule', 'http://localhost:8000/img/taro.png', 1, '2017-01-15 20:15:47', '2017-01-15 20:15:47'),
(2, 8, 'Dolais', 'Sauce africaine à base de légumes', 'http://localhost:8000/img/dolais.png', 1, '2017-01-15 20:54:02', '2017-01-15 20:54:02');

-- --------------------------------------------------------

--
-- Table structure for table `recette_ingredient`
--

CREATE TABLE `recette_ingredient` (
  `recette_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recette_ingredient`
--

INSERT INTO `recette_ingredient` (`recette_id`, `ingredient_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'tongle', 'tonglem@3il.fr', ''),
(2, 'me', 'you', ''),
(3, 'fabiola', 'fabiola@3il.fr', ''),
(4, 'ezeez', 'eze@dsd.rfr', ''),
(6, 'edgar', 'edgar@3il.fr', '$2y$12$xsnUxkn/CuYnYQXCkzYW2umeLzG8GAg3lOMSHQtvWXL.KK2UXFjiS'),
(7, 'kamdem', 'kamdem@3il.fr', '$2y$12$m3ZXPTfxIpKDIvG.x3rU0.I9GGEZE7lwuiIX2AHB4AtYbVvBG7X76'),
(8, 'test', 'test@test.fr', '$2y$12$FAlFnNWQnvPk1AJIqupPneb9K2tXedFldgtJU5dB7BW3NcsaLfshG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recette`
--
ALTER TABLE `recette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_49BB6390A76ED395` (`user_id`);

--
-- Indexes for table `recette_ingredient`
--
ALTER TABLE `recette_ingredient`
  ADD PRIMARY KEY (`recette_id`,`ingredient_id`),
  ADD KEY `IDX_17C041A989312FE9` (`recette_id`),
  ADD KEY `IDX_17C041A9933FE08C` (`ingredient_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `recette`
--
ALTER TABLE `recette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `recette`
--
ALTER TABLE `recette`
  ADD CONSTRAINT `FK_49BB6390A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `recette_ingredient`
--
ALTER TABLE `recette_ingredient`
  ADD CONSTRAINT `FK_17C041A989312FE9` FOREIGN KEY (`recette_id`) REFERENCES `recette` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_17C041A9933FE08C` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
