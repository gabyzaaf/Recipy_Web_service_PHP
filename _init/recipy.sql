-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: mysql
-- Generation Time: Jun 08, 2016 at 01:16 PM
-- Server version: 5.7.12
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipy`
--

-- --------------------------------------------------------

--
-- Table structure for table `Commenter`
--

CREATE TABLE `Commenter` (
  `id` int(11) NOT NULL,
  `heure_saisie` datetime DEFAULT NULL,
  `fidUtilisateur` int(11) NOT NULL,
  `fidRecette` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Favoris`
--

CREATE TABLE `Favoris` (
  `id` int(11) NOT NULL,
  `fidUtilisateur` int(11) NOT NULL,
  `fidRecette` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `noter`
--

CREATE TABLE `noter` (
  `id` int(11) NOT NULL,
  `score` float DEFAULT '0',
  `fidUtilisateur` int(11) NOT NULL,
  `fidRecette` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Recette`
--

CREATE TABLE `Recette` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `image_lien` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) DEFAULT '1',
  `partage` tinyint(1) DEFAULT '0',
  `fid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Recette`
--

INSERT INTO `Recette` (`id`, `title`, `contenu`, `image_lien`, `visible`, `partage`, `fid`) VALUES
(1, 'gateau', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mi velit, quis lacinia diam porttitor ut. Praesent nec nulla sit amet metus accumsan ullamcorper. Aenean iaculis turpis at congue malesuada. Donec ac auctor ex. Quisque maximus massa id justo pellentesque finibus eget et dui. Pellentesque est libero, sollicitudin non convallis in, condimentum in lectus. Nulla dictum, ipsum ut luctus volutpat, diam orci mattis mauris, quis blandit risus lacus non dolor. Aenean et enim vitae quam faucibus dignissim et vitae libero. Nullam eget leo neque. Cras sed orci vel enim rhoncus cursus.', 'http://lorempixel.com/400/200/food/', 1, 1, 1),
(2, 'pates', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mi velit, quis lacinia diam porttitor ut. Praesent nec nulla sit amet metus accumsan ullamcorper. Aenean iaculis turpis at congue malesuada. Donec ac auctor ex. Quisque maximus massa id justo pellentesque finibus eget et dui. Pellentesque est libero, sollicitudin non convallis in, condimentum in lectus. Nulla dictum, ipsum ut luctus volutpat, diam orci mattis mauris, quis blandit risus lacus non dolor. Aenean et enim vitae quam faucibus dignissim et vitae libero. Nullam eget leo neque. Cras sed orci vel enim rhoncus cursus.', 'http://lorempixel.com/400/200/food/', 1, 0, 1),
(3, 'gateau', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed gravida mi velit, quis lacinia diam porttitor ut. Praesent nec nulla sit amet metus accumsan ullamcorper. Aenean iaculis turpis at congue malesuada. Donec ac auctor ex. Quisque maximus massa id justo pellentesque finibus eget et dui. Pellentesque est libero, sollicitudin non convallis in, condimentum in lectus. Nulla dictum, ipsum ut luctus volutpat, diam orci mattis mauris, quis blandit risus lacus non dolor. Aenean et enim vitae quam faucibus dignissim et vitae libero. Nullam eget leo neque. Cras sed orci vel enim rhoncus cursus.', 'http://lorempixel.com/400/200/food/', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `id` int(11) NOT NULL,
  `idAutre` bigint(20) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT '0',
  `actif` tinyint(1) DEFAULT '1',
  `logins` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `naissance` date DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `compte` varchar(100) DEFAULT 'autre',
  `Token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id`, `idAutre`, `nom`, `prenom`, `admin`, `actif`, `logins`, `email`, `naissance`, `pwd`, `compte`, `Token`) VALUES
(1, NULL, 'doe', 'John', 1, 1, 'admin', 'admin@admin.fr', '2001-05-17', '21232f297a57a5a743894a0e4a801fc3', 'autre', 'dd94709528bb1c83d08f3088d4043f4742891f4f'),
(2, NULL, NULL, NULL, 0, 1, 'test@test.fr', NULL, NULL, '098f6bcd4621d373cade4e832627b4f6', 'autre', NULL),
(3, NULL, NULL, NULL, 0, 1, 'ad@ad.ad', NULL, NULL, '523af537946b79c4f8369ed39ba78605', 'autre', NULL),
(4, NULL, NULL, NULL, 0, 1, 'et@et.et', NULL, NULL, '4de1b7a4dc53e4a84c25ffb7cdb580ee', 'autre', 'da39a3ee5e6b4b0d3255bfef95601890afd80709'),
(5, NULL, 'Perruchot', 'test', 0, 1, 'Bob', 'sola-discount@live.fr', '2089-10-10', '9f9d51bc70ef21ca5c14f307980a29d8', 'autre', '0eec9036c33be73f7ee585aad653e358b9de6841'),
(6, NULL, 'ail', 'ism', 0, 1, 'ismail', 'ismaol@gmail.com', '2016-05-27', 'f3b32717d5322d7ba7c505c230785468', 'autre', 'bd6374fa0dc37939f7dcc28ae2f37e6a50cc12d9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Commenter`
--
ALTER TABLE `Commenter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fidUtilisateur` (`fidUtilisateur`),
  ADD KEY `fidRecette` (`fidRecette`);

--
-- Indexes for table `Favoris`
--
ALTER TABLE `Favoris`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fidUtilisateur` (`fidUtilisateur`),
  ADD KEY `fidRecette` (`fidRecette`);

--
-- Indexes for table `noter`
--
ALTER TABLE `noter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fidUtilisateur` (`fidUtilisateur`),
  ADD KEY `fidRecette` (`fidRecette`);

--
-- Indexes for table `Recette`
--
ALTER TABLE `Recette`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fid` (`fid`);

--
-- Indexes for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Commenter`
--
ALTER TABLE `Commenter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Favoris`
--
ALTER TABLE `Favoris`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `noter`
--
ALTER TABLE `noter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Recette`
--
ALTER TABLE `Recette`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Commenter`
--
ALTER TABLE `Commenter`
  ADD CONSTRAINT `Commenter_ibfk_1` FOREIGN KEY (`fidUtilisateur`) REFERENCES `Utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Commenter_ibfk_2` FOREIGN KEY (`fidRecette`) REFERENCES `Recette` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Favoris`
--
ALTER TABLE `Favoris`
  ADD CONSTRAINT `Favoris_ibfk_1` FOREIGN KEY (`fidUtilisateur`) REFERENCES `Utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Favoris_ibfk_2` FOREIGN KEY (`fidRecette`) REFERENCES `Recette` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `noter`
--
ALTER TABLE `noter`
  ADD CONSTRAINT `noter_ibfk_1` FOREIGN KEY (`fidUtilisateur`) REFERENCES `Utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `noter_ibfk_2` FOREIGN KEY (`fidRecette`) REFERENCES `Recette` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Recette`
--
ALTER TABLE `Recette`
  ADD CONSTRAINT `Recette_ibfk_1` FOREIGN KEY (`fid`) REFERENCES `Utilisateur` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
