-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mer. 06 déc. 2017 à 11:39
-- Version du serveur :  5.6.34-log
-- Version de PHP :  7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mydil`
--

-- --------------------------------------------------------

--
-- Structure de la table `accounts`
--

CREATE TABLE `accounts` (
  `email` text,
  `password` text,
  `granted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `accounts`
--

INSERT INTO `accounts` (`email`, `password`, `granted`) VALUES
('admin', '$2y$10$MQu4yRTH7lffYQI6xK8esO.P1B0aruxbVKU.QWGzmmSFiiwSPNTCC', 1);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categorie` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `categorie`) VALUES
(1, 'Device'),
(2, 'Image'),
(3, 'IoT'),
(4, 'Mobilité'),
(5, 'PC'),
(6, 'Système embarqué');

-- --------------------------------------------------------

--
-- Structure de la table `demandes`
--

CREATE TABLE `demandes` (
  `id` int(11) NOT NULL,
  `email` text,
  `materiel` text,
  `date_fin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `emprunts_actifs`
--

CREATE TABLE `emprunts_actifs` (
  `id` int(11) NOT NULL,
  `email` text,
  `material` text,
  `date_fin` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `email` text,
  `token` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`email`, `token`) VALUES
('admin', '5a27cb5e1fa78');

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `materiel` text,
  `id_sub` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `materiel`, `id_sub`, `amount`) VALUES
(1, 'Leap Motion', 1, 1),
(2, 'Kinect XBOX', 1, 1),
(3, 'Kinect PC', 1, 1),
(4, 'Wacom Intuos S', 2, 1),
(5, 'Projecteur Epson', 3, 1),
(6, 'HoloLens', 4, 1),
(7, 'Occulus Rift', 4, 1),
(8, 'Creative webcam', 5, 1),
(9, 'Canon EOS 700D', 6, 1),
(10, 'Theta', 7, 1),
(11, 'Philips Hue', 8, 1),
(12, 'AR Drone Parrot', 9, 1),
(13, 'FitBit', 10, 1),
(14, 'Samsung Gear', 11, 1),
(15, 'Iphone 4S', 12, 1),
(16, 'HTC Surround', 12, 1),
(17, 'Lumia 435', 12, 1),
(18, 'Asus VivoTab', 13, 1),
(19, 'Intel NUC', 14, 1),
(20, 'Samsung Laptop', 15, 1),
(21, 'Raspberry Camera 2', 16, 1),
(22, 'Texas Instrument Launchpad', 17, 1),
(23, 'ST Nucleo F103RB', 17, 1),
(24, 'Raspberry Pi Model', 17, 1),
(25, 'Raspberry Pi 2', 17, 1),
(26, 'Raspberry Pi 3', 17, 1),
(27, 'POB', 18, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `sub_categorie` text NOT NULL,
  `id_cat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `sub_categorie`, `id_cat`) VALUES
(1, 'Autre', 1),
(2, 'Tablette Graphique', 1),
(3, 'Vidéoprojecteur', 1),
(4, 'VR', 1),
(5, 'Webcam', 1),
(6, 'Appareil Photo', 2),
(7, 'Caméra', 2),
(8, 'Ampoule', 3),
(9, 'Drone', 3),
(10, 'Bracelet', 4),
(11, 'Montre', 4),
(12, 'Smartphone', 4),
(13, 'Tablette hybride', 4),
(14, 'Barebone', 5),
(15, 'PC portable', 5),
(16, 'Capteur', 6),
(17, 'Module', 6),
(18, 'Robot', 6);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `demandes`
--
ALTER TABLE `demandes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `emprunts_actifs`
--
ALTER TABLE `emprunts_actifs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `demandes`
--
ALTER TABLE `demandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `emprunts_actifs`
--
ALTER TABLE `emprunts_actifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
