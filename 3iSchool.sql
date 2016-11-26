-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2016 at 02:40 PM
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
-- Table structure for table `annee`
--

CREATE TABLE `annee` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `annee`
--

INSERT INTO `annee` (`id`, `libelle`) VALUES
(1, '2016'),
(2, '2017'),
(3, '2018');

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_tokens`
--

INSERT INTO `auth_tokens` (`id`, `user_id`, `value`, `created_at`) VALUES
(1, 1, 'azerty', '2016-11-23 00:00:00'),
(2, 1, '0+cIZ7+tZK+yGmIg4u15hTGutwAsl5XSYwr6RiTl85gx2oO1A5pOOMdCkB4b0I7dOBw=', '2016-11-24 06:30:43');

-- --------------------------------------------------------

--
-- Table structure for table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `reponse_id` int(11) DEFAULT NULL,
  `libelle` longtext COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL,
  `date_publication` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `depth` int(11) NOT NULL,
  `nombre_like` int(11) NOT NULL,
  `report` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `commentaire`
--

INSERT INTO `commentaire` (`id`, `reponse_id`, `libelle`, `parent_id`, `date_publication`, `depth`, `nombre_like`, `report`) VALUES
(1, 1, 'todo commentaire', 1, '2016-11-09 09:18:19', 3, 12, 0),
(2, 1, 'todo commentaire 2', 0, '2016-11-09 09:18:19', 12, 1, 1),
(3, 1, 'test update', 1, '2016-11-20 03:23:40', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `conteneur`
--

CREATE TABLE `conteneur` (
  `id` int(11) NOT NULL,
  `annee_id` int(11) DEFAULT NULL,
  `groupe_id` int(11) DEFAULT NULL,
  `niveau_id` int(11) DEFAULT NULL,
  `contenu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `conteneur`
--

INSERT INTO `conteneur` (`id`, `annee_id`, `groupe_id`, `niveau_id`, `contenu_id`) VALUES
(1, 3, 2, 3, 1),
(2, 3, 2, 3, 2),
(3, 3, 2, 3, 4),
(4, 3, 2, 3, 5),
(5, 3, 2, 3, 6),
(6, 3, 2, 3, 7),
(7, 3, 2, 3, 8),
(8, 3, 2, 3, 9),
(9, 3, 2, 3, 10),
(10, 3, 2, 3, 11),
(11, 3, 2, 3, 12),
(12, 3, 2, 3, 13),
(13, 3, 2, 3, 14),
(14, 3, 2, 3, 15),
(15, 3, 2, 3, 16),
(16, 3, 2, 3, 17),
(17, 3, 2, 3, 18),
(18, 3, 2, 3, 19),
(19, 3, 2, 3, 20),
(20, 3, 2, 3, 21),
(21, 3, 2, 3, 22),
(22, 3, 2, 3, 23),
(23, 3, 2, 3, 24),
(24, 3, 2, 3, 25),
(25, 3, 2, 3, 26),
(26, 3, 2, 3, 27),
(27, 3, 2, 3, 28),
(28, 3, 2, 3, 29),
(29, 3, 2, 3, 30);

-- --------------------------------------------------------

--
-- Table structure for table `contenu`
--

CREATE TABLE `contenu` (
  `id` int(11) NOT NULL,
  `rubrique_id` int(11) DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `information` text COLLATE utf8_unicode_ci NOT NULL,
  `date_publication` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_like` int(11) NOT NULL,
  `nombre_vue_total` int(11) NOT NULL,
  `contenu_root` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_root` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `contenu`
--

INSERT INTO `contenu` (`id`, `rubrique_id`, `titre`, `information`, `date_publication`, `nombre_like`, `nombre_vue_total`, `contenu_root`, `image_root`) VALUES
(1, 1, 'todo titre', 'todo info', '2016-11-08 07:23:20', 0, 1, 'todo contenu_root', 'todo image_root'),
(2, 3, 'todo 2', 'todo info', '2016-11-24 13:33:20', 0, 1, 'todo contenu_root', 'todo image_root'),
(3, NULL, 'todo Perso', 'todo Info', '2016-11-19 03:28:43', 0, 1, 'root perso', 'image perso'),
(4, 3, 'titre3', 'information3', '2016-11-24 08:21:21', 0, 1, 'contenu_root3', 'image_root3'),
(5, 4, 'titre4', 'information4', '2016-11-23 05:29:23', 4, 1, 'contenu_root4', 'image_root4'),
(6, 5, 'titre5', 'information5', '2016-11-24 11:49:00', 12, 1, 'contenu_root5', 'image_root5'),
(7, 1, 'titre 6', 'information 6', '2016-11-26 00:41:16', 0, 29, 'contenu_root 6', 'image_root 6'),
(8, 3, 'titre 7', 'information 7', '2016-11-26 00:41:16', 0, 51, 'contenu_root 7', 'image_root 7'),
(9, 5, 'titre 8', 'information 8', '2016-11-26 00:41:16', 0, 13, 'contenu_root 8', 'image_root 8'),
(10, 6, 'titre 9', 'information 9', '2016-11-26 00:41:16', 0, 5, 'contenu_root 9', 'image_root 9'),
(11, 4, 'titre 10', 'information 10', '2016-11-26 00:41:16', 0, 22, 'contenu_root 10', 'image_root 10'),
(12, 1, 'titre 11', 'information 11', '2016-11-26 00:41:16', 0, 32, 'contenu_root 11', 'image_root 11'),
(13, 1, 'titre 12', 'information 12', '2016-11-26 00:41:16', 0, 44, 'contenu_root 12', 'image_root 12'),
(14, 4, 'titre 13', 'information 13', '2016-11-26 00:41:16', 0, 4, 'contenu_root 13', 'image_root 13'),
(15, 4, 'titre 14', 'information 14', '2016-11-26 00:41:16', 0, 31, 'contenu_root 14', 'image_root 14'),
(16, 5, 'titre 15', 'information 15', '2016-11-26 00:41:16', 0, 21, 'contenu_root 15', 'image_root 15'),
(17, 6, 'titre 16', 'information 16', '2016-11-26 00:41:16', 0, 18, 'contenu_root 16', 'image_root 16'),
(18, 6, 'titre 17', 'information 17', '2016-11-26 00:41:16', 0, 42, 'contenu_root 17', 'image_root 17'),
(19, 4, 'titre 18', 'information 18', '2016-11-26 00:41:16', 0, 32, 'contenu_root 18', 'image_root 18'),
(20, 1, 'titre 19', 'information 19', '2016-11-26 00:41:16', 0, 28, 'contenu_root 19', 'image_root 19'),
(21, 3, 'titre 20', 'information 20', '2016-11-26 00:41:16', 0, 31, 'contenu_root 20', 'image_root 20'),
(22, 5, 'titre 21', 'information 21', '2016-11-26 00:41:16', 0, 35, 'contenu_root 21', 'image_root 21'),
(23, 3, 'titre 22', 'information 22', '2016-11-26 00:41:16', 0, 10, 'contenu_root 22', 'image_root 22'),
(24, 4, 'titre 23', 'information 23', '2016-11-26 00:41:16', 0, 26, 'contenu_root 23', 'image_root 23'),
(25, 3, 'titre 24', 'information 24', '2016-11-26 00:41:16', 0, 1, 'contenu_root 24', 'image_root 24'),
(26, 5, 'titre 25', 'information 25', '2016-11-26 00:41:16', 0, 1, 'contenu_root 25', 'image_root 25'),
(27, 3, 'titre 26', 'information 26', '2016-11-26 00:41:16', 0, 1, 'contenu_root 26', 'image_root 26'),
(28, 1, 'titre 27', 'information 27', '2016-11-26 00:41:16', 0, 1, 'contenu_root 27', 'image_root 27'),
(29, 3, 'titre 28', 'information 28', '2016-11-26 00:41:16', 0, 1, 'contenu_root 28', 'image_root 28'),
(30, 6, 'titre 29', 'information 29', '2016-11-26 00:41:16', 0, 1, 'contenu_root 29', 'image_root 29');

-- --------------------------------------------------------

--
-- Table structure for table `groupe`
--

CREATE TABLE `groupe` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groupe`
--

INSERT INTO `groupe` (`id`, `libelle`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5'),
(6, '6');

-- --------------------------------------------------------

--
-- Table structure for table `groupe_rubrique`
--

CREATE TABLE `groupe_rubrique` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groupe_rubrique`
--

INSERT INTO `groupe_rubrique` (`id`, `libelle`) VALUES
(3, 'Administration'),
(2, 'Divers'),
(1, 'Matière'),
(4, 'Profs');

-- --------------------------------------------------------

--
-- Table structure for table `niveau`
--

CREATE TABLE `niveau` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `niveau`
--

INSERT INTO `niveau` (`id`, `libelle`) VALUES
(1, '3iL-I1'),
(2, '3iL-I2'),
(3, '3iL-I3'),
(4, '3iL-I3+'),
(5, '3iL-Prepa1'),
(6, '3iL-Prepa2'),
(7, 'CS2I-Bachelor1'),
(8, 'CS2I-Master1'),
(9, 'CS2I-Master2'),
(10, 'CS2I-Master2+'),
(11, 'ISFOGEP-AGAP'),
(12, 'ISFOGEP-RGRH'),
(13, 'Personnel 3iL');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `contenu_id` int(11) DEFAULT NULL,
  `type_question_id` int(11) DEFAULT NULL,
  `libelle` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_publication` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_like` int(11) NOT NULL,
  `nombre_dislike` int(11) NOT NULL,
  `page` int(11) DEFAULT NULL,
  `ligne` int(11) DEFAULT NULL,
  `image_root` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `report` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `contenu_id`, `type_question_id`, `libelle`, `description`, `date_publication`, `nombre_like`, `nombre_dislike`, `page`, `ligne`, `image_root`, `report`) VALUES
(1, 1, 1, 'todo libelle', 'todo description', '2016-11-16 22:52:56', 10, 6, 10, 22, 'todo image_root', 0),
(2, 1, 1, 'test', 'test', '2016-11-20 03:14:38', 2, 4, NULL, NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reponse`
--

CREATE TABLE `reponse` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `libelle` longtext COLLATE utf8_unicode_ci NOT NULL,
  `date_publication` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_like` int(11) NOT NULL,
  `report` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reponse`
--

INSERT INTO `reponse` (`id`, `question_id`, `libelle`, `date_publication`, `nombre_like`, `report`) VALUES
(1, 1, 'todo reponse', '2016-11-08 21:04:21', 3, 0),
(2, 1, 'test', '2016-11-19 22:14:19', 0, 0),
(3, 1, 'test update', '2016-11-20 03:17:42', 0, 0),
(4, 1, 'test', '2016-11-19 22:15:45', 0, 0),
(5, 1, 'test', '2016-11-19 22:17:11', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rubrique`
--

CREATE TABLE `rubrique` (
  `id` int(11) NOT NULL,
  `groupe_rubrique_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `imageRoot` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `presentation` longtext COLLATE utf8_unicode_ci NOT NULL,
  `importance` longtext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rubrique`
--

INSERT INTO `rubrique` (`id`, `groupe_rubrique_id`, `libelle`, `imageRoot`, `presentation`, `importance`) VALUES
(1, 1, 'Analyse Numérique', 'todo', 'todo', 'todo'),
(2, 1, 'Anglais', 'todo', 'todo', 'todo'),
(3, 1, 'AOO', 'todo', 'todo', 'todo'),
(4, 1, 'Gestion Prévisionnelle', 'todo', 'todo', 'todo'),
(5, 1, 'LV2', 'todo', 'todo', 'todo'),
(6, 1, 'Management de Projet', 'todo', 'todo', 'todo'),
(7, 1, 'Marketing - Ecoute Clients', 'todo', 'todo', 'todo');

-- --------------------------------------------------------

--
-- Table structure for table `sous_rubrique`
--

CREATE TABLE `sous_rubrique` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sous_rubrique`
--

INSERT INTO `sous_rubrique` (`id`, `libelle`) VALUES
(1, 'Cours'),
(4, 'DS'),
(5, 'EI'),
(2, 'TD'),
(3, 'TP');

-- --------------------------------------------------------

--
-- Table structure for table `sous_rubrique_rubrique`
--

CREATE TABLE `sous_rubrique_rubrique` (
  `sous_rubrique_id` int(11) NOT NULL,
  `rubrique_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sous_rubrique_rubrique`
--

INSERT INTO `sous_rubrique_rubrique` (`sous_rubrique_id`, `rubrique_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `type_question`
--

CREATE TABLE `type_question` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `type_question`
--

INSERT INTO `type_question` (`id`, `libelle`) VALUES
(1, 'Contenu'),
(2, 'Divers');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_bde` tinyint(1) NOT NULL,
  `is_personnel` tinyint(1) NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `nom`, `prenom`, `date_creation`, `is_bde`, `is_personnel`, `password`) VALUES
(1, 'kamdeme@3il.fr', 'KAMDEM', 'Edgar', '2016-11-16 22:36:03', 0, 0, '$2y$12$4ac8BvDANmZjWJbot2QbTOjNjTKMYx2Kj0n4OBpxrbLXDx1dOxnHu'),
(2, 'tonglem@3il.fr', 'TONGLE', 'Michael', '2016-11-16 22:36:03', 1, 0, ''),
(3, 'amblar@3il.fr', 'Amblard', 'Emmanuel', '2016-11-16 22:36:03', 0, 1, ''),
(4, 'ruchaud@3il.fr', 'RUCHAUD', 'William', '2016-11-25 02:13:29', 0, 1, ''),
(5, 'belabdelhi@3il.fr', 'BELABDELHI', 'Fethi', '2016-11-25 02:13:29', 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `user_commentaire`
--

CREATE TABLE `user_commentaire` (
  `user_id` int(11) NOT NULL,
  `commentaire_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_commentaire`
--

INSERT INTO `user_commentaire` (`user_id`, `commentaire_id`) VALUES
(1, 3),
(2, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_contenu`
--

CREATE TABLE `user_contenu` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `contenu_id` int(11) DEFAULT NULL,
  `nbre_vue` int(11) NOT NULL,
  `a_publie` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_contenu`
--

INSERT INTO `user_contenu` (`id`, `user_id`, `contenu_id`, `nbre_vue`, `a_publie`) VALUES
(1, 3, 1, 1, 1),
(2, 2, 2, 1, 1),
(3, 3, 3, 1, 1),
(4, 4, 4, 1, 1),
(5, 5, 6, 1, 1),
(6, 5, 5, 1, 1),
(7, 4, 7, 1, 1),
(8, 5, 8, 1, 1),
(9, 3, 9, 1, 1),
(10, 4, 10, 1, 1),
(11, 3, 11, 1, 1),
(12, 3, 12, 1, 1),
(13, 4, 13, 1, 1),
(14, 3, 14, 1, 1),
(15, 3, 15, 1, 1),
(16, 4, 16, 1, 1),
(17, 5, 17, 1, 1),
(18, 3, 18, 1, 1),
(19, 3, 19, 1, 1),
(20, 5, 20, 1, 1),
(21, 5, 21, 1, 1),
(22, 4, 22, 1, 1),
(23, 3, 23, 1, 1),
(24, 3, 24, 1, 1),
(25, 4, 25, 1, 1),
(26, 5, 26, 1, 1),
(27, 5, 27, 1, 1),
(28, 4, 28, 1, 1),
(29, 5, 29, 1, 1),
(30, 5, 30, 1, 1),
(67, 2, 7, 28, 0),
(68, 2, 8, 50, 0),
(69, 1, 9, 12, 0),
(70, 1, 10, 4, 0),
(71, 2, 11, 21, 0),
(72, 1, 12, 31, 0),
(73, 1, 13, 43, 0),
(74, 1, 14, 3, 0),
(75, 2, 15, 30, 0),
(76, 1, 16, 20, 0),
(77, 1, 17, 17, 0),
(78, 2, 18, 41, 0),
(79, 1, 19, 31, 0),
(80, 1, 20, 27, 0),
(81, 2, 21, 30, 0),
(82, 1, 22, 34, 0),
(83, 1, 23, 9, 0),
(84, 2, 24, 25, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_question`
--

CREATE TABLE `user_question` (
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_question`
--

INSERT INTO `user_question` (`user_id`, `question_id`) VALUES
(1, 2),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_reponse`
--

CREATE TABLE `user_reponse` (
  `user_id` int(11) NOT NULL,
  `reponse_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_reponse`
--

INSERT INTO `user_reponse` (`user_id`, `reponse_id`) VALUES
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `id` int(11) NOT NULL,
  `num_ref` int(11) NOT NULL,
  `ref` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valeur` int(11) NOT NULL,
  `date_vote` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annee`
--
ALTER TABLE `annee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_DE92C5CFA4D60759` (`libelle`);

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `auth_tokens_value_unique` (`value`),
  ADD KEY `IDX_8AF9B66CA76ED395` (`user_id`);

--
-- Indexes for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_67F068BCCF18BB82` (`reponse_id`);

--
-- Indexes for table `conteneur`
--
ALTER TABLE `conteneur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E9628FD2543EC5F0` (`annee_id`),
  ADD KEY `IDX_E9628FD27A45358C` (`groupe_id`),
  ADD KEY `IDX_E9628FD2B3E9C81` (`niveau_id`),
  ADD KEY `IDX_E9628FD23C1CC488` (`contenu_id`);

--
-- Indexes for table `contenu`
--
ALTER TABLE `contenu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_89C2003FFF7747B4` (`titre`),
  ADD KEY `IDX_89C2003F3BD38833` (`rubrique_id`);

--
-- Indexes for table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4B98C21A4D60759` (`libelle`);

--
-- Indexes for table `groupe_rubrique`
--
ALTER TABLE `groupe_rubrique`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1E06020CA4D60759` (`libelle`);

--
-- Indexes for table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_4BDFF36BA4D60759` (`libelle`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6F7494E3C1CC488` (`contenu_id`),
  ADD KEY `IDX_B6F7494E553E212E` (`type_question_id`);

--
-- Indexes for table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5FB6DEC71E27F6BF` (`question_id`);

--
-- Indexes for table `rubrique`
--
ALTER TABLE `rubrique`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8FA4097CA4D60759` (`libelle`),
  ADD KEY `IDX_8FA4097CB40EFBFD` (`groupe_rubrique_id`);

--
-- Indexes for table `sous_rubrique`
--
ALTER TABLE `sous_rubrique`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_87EA3D29A4D60759` (`libelle`);

--
-- Indexes for table `sous_rubrique_rubrique`
--
ALTER TABLE `sous_rubrique_rubrique`
  ADD PRIMARY KEY (`sous_rubrique_id`,`rubrique_id`),
  ADD KEY `IDX_359BE3717BEAFB00` (`sous_rubrique_id`),
  ADD KEY `IDX_359BE3713BD38833` (`rubrique_id`);

--
-- Indexes for table `type_question`
--
ALTER TABLE `type_question`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_7B086EB2A4D60759` (`libelle`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_commentaire`
--
ALTER TABLE `user_commentaire`
  ADD PRIMARY KEY (`user_id`,`commentaire_id`),
  ADD KEY `IDX_CEEBA129A76ED395` (`user_id`),
  ADD KEY `IDX_CEEBA129BA9CD190` (`commentaire_id`);

--
-- Indexes for table `user_contenu`
--
ALTER TABLE `user_contenu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D1CF1E35A76ED395` (`user_id`),
  ADD KEY `IDX_D1CF1E353C1CC488` (`contenu_id`);

--
-- Indexes for table `user_question`
--
ALTER TABLE `user_question`
  ADD PRIMARY KEY (`user_id`,`question_id`),
  ADD KEY `IDX_567AAD4EA76ED395` (`user_id`),
  ADD KEY `IDX_567AAD4E1E27F6BF` (`question_id`);

--
-- Indexes for table `user_reponse`
--
ALTER TABLE `user_reponse`
  ADD PRIMARY KEY (`user_id`,`reponse_id`),
  ADD KEY `IDX_7BBC0CDA76ED395` (`user_id`),
  ADD KEY `IDX_7BBC0CDCF18BB82` (`reponse_id`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annee`
--
ALTER TABLE `annee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `conteneur`
--
ALTER TABLE `conteneur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `contenu`
--
ALTER TABLE `contenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `groupe_rubrique`
--
ALTER TABLE `groupe_rubrique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `rubrique`
--
ALTER TABLE `rubrique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `sous_rubrique`
--
ALTER TABLE `sous_rubrique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `type_question`
--
ALTER TABLE `type_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_contenu`
--
ALTER TABLE `user_contenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `vote`
--
ALTER TABLE `vote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `FK_8AF9B66CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BCCF18BB82` FOREIGN KEY (`reponse_id`) REFERENCES `reponse` (`id`);

--
-- Constraints for table `conteneur`
--
ALTER TABLE `conteneur`
  ADD CONSTRAINT `FK_E9628FD23C1CC488` FOREIGN KEY (`contenu_id`) REFERENCES `contenu` (`id`),
  ADD CONSTRAINT `FK_E9628FD2543EC5F0` FOREIGN KEY (`annee_id`) REFERENCES `annee` (`id`),
  ADD CONSTRAINT `FK_E9628FD27A45358C` FOREIGN KEY (`groupe_id`) REFERENCES `groupe` (`id`),
  ADD CONSTRAINT `FK_E9628FD2B3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`);

--
-- Constraints for table `contenu`
--
ALTER TABLE `contenu`
  ADD CONSTRAINT `FK_89C2003F3BD38833` FOREIGN KEY (`rubrique_id`) REFERENCES `rubrique` (`id`);

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_B6F7494E3C1CC488` FOREIGN KEY (`contenu_id`) REFERENCES `contenu` (`id`),
  ADD CONSTRAINT `FK_B6F7494E553E212E` FOREIGN KEY (`type_question_id`) REFERENCES `type_question` (`id`);

--
-- Constraints for table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `FK_5FB6DEC71E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`);

--
-- Constraints for table `rubrique`
--
ALTER TABLE `rubrique`
  ADD CONSTRAINT `FK_8FA4097CB40EFBFD` FOREIGN KEY (`groupe_rubrique_id`) REFERENCES `groupe_rubrique` (`id`);

--
-- Constraints for table `sous_rubrique_rubrique`
--
ALTER TABLE `sous_rubrique_rubrique`
  ADD CONSTRAINT `FK_359BE3713BD38833` FOREIGN KEY (`rubrique_id`) REFERENCES `rubrique` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_359BE3717BEAFB00` FOREIGN KEY (`sous_rubrique_id`) REFERENCES `sous_rubrique` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_commentaire`
--
ALTER TABLE `user_commentaire`
  ADD CONSTRAINT `FK_CEEBA129A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CEEBA129BA9CD190` FOREIGN KEY (`commentaire_id`) REFERENCES `commentaire` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_contenu`
--
ALTER TABLE `user_contenu`
  ADD CONSTRAINT `FK_D1CF1E353C1CC488` FOREIGN KEY (`contenu_id`) REFERENCES `contenu` (`id`),
  ADD CONSTRAINT `FK_D1CF1E35A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user_question`
--
ALTER TABLE `user_question`
  ADD CONSTRAINT `FK_567AAD4E1E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_567AAD4EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_reponse`
--
ALTER TABLE `user_reponse`
  ADD CONSTRAINT `FK_7BBC0CDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_7BBC0CDCF18BB82` FOREIGN KEY (`reponse_id`) REFERENCES `reponse` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
