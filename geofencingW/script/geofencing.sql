-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : ven. 19 fév. 2021 à 10:13
-- Version du serveur :  8.0.23
-- Version de PHP : 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `geofencing`
--

-- --------------------------------------------------------

--
-- Structure de la table `informations`
--

CREATE TABLE `informations` (
  `id_info` int NOT NULL,
  `id_zone` int NOT NULL,
  `type` varchar(255) NOT NULL,
  `contenu` varchar(9999) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `point`
--

CREATE TABLE `point` (
  `id_point` int NOT NULL,
  `id_zone` int NOT NULL,
  `x` float(12,10) NOT NULL,
  `y` float(12,10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `zone`
--

CREATE TABLE `zone` (
  `id_zone` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `informations`
--
ALTER TABLE `informations`
  ADD PRIMARY KEY (`id_info`),
  ADD KEY `FK_id_zoneInfo` (`id_zone`);

--
-- Index pour la table `point`
--
ALTER TABLE `point`
  ADD PRIMARY KEY (`id_point`),
  ADD KEY `FK_id_zone` (`id_zone`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `zone`
--
ALTER TABLE `zone`
  ADD PRIMARY KEY (`id_zone`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `informations`
--
ALTER TABLE `informations`
  MODIFY `id_info` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `point`
--
ALTER TABLE `point`
  MODIFY `id_point` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `zone`
--
ALTER TABLE `zone`
  MODIFY `id_zone` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `informations`
--
ALTER TABLE `informations`
  ADD CONSTRAINT `FK_id_zoneInfo` FOREIGN KEY (`id_zone`) REFERENCES `zone` (`id_zone`);

--
-- Contraintes pour la table `point`
--
ALTER TABLE `point`
  ADD CONSTRAINT `FK_id_zone` FOREIGN KEY (`id_zone`) REFERENCES `zone` (`id_zone`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
