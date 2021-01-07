-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : jeu. 12 nov. 2020 à 07:27
-- Version du serveur :  8.0.22
-- Version de PHP : 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `atelier`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id_commentaire` int NOT NULL,
  `id_photo` int NOT NULL,
  `id_user` int NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `id_photo`, `id_user`, `content`, `date`) VALUES
(1, 6, 2, 'C''est pas un peu cher ?', '2020-11-10'),
(2, 6, 3, 'Non a peine', '2020-11-10'),
(3, 6, 2, 'C''est pas un peu cher ?', '2020-11-10'),
(4, 6, 3, 'Non a peine', '2020-11-10'),
(5, 6, 2, 'C''est pas un peu cher ?', '2020-11-10'),
(6, 6, 3, 'Non a peine', '2020-11-10'),
(7, 6, 2, 'C''est pas un peu cher ?', '2020-11-10'),
(8, 6, 3, 'Non a peine', '2020-11-10'),
(9, 6, 2, 'C''est pas un peu cher ?', '2020-11-10'),
(10, 6, 3, 'Non a peine', '2020-11-10'),
(11, 6, 2, 'C''est pas un peu cher ?', '2020-11-10'),
(12, 6, 3, 'Non a peine', '2020-11-10'),
(13, 6, 2, 'C''est pas un peu cher ?', '2020-11-10'),
(14, 6, 3, 'Non a peine', '2020-11-10'),
(15, 6, 2, 'C''est pas un peu cher ?', '2020-11-10'),
(16, 6, 3, 'Non a peine', '2020-11-10');

-- --------------------------------------------------------

--
-- Structure de la table `galerie`
--

CREATE TABLE `galerie` (
  `id_galerie` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `type` int NOT NULL,
  `motscles` varchar(250) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `galerie`
--

INSERT INTO `galerie` (`id_galerie`, `nom`, `description`, `type`, `motscles`, `date`) VALUES
(1, 'Photos de vacances', 'Vacances 2020', 1, 'été; montagne plage', '2020-11-10'),
(3, 'Idées liste mariage', 'Idées', 0, 'mariage', '2020-11-10'),
(5, 'Series', 'Netflix', 0, 'Séries', '2020-11-10');

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `id_group` int NOT NULL,
  `nom_group` varchar(20) DEFAULT NULL,
  `id_admin` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`id_group`, `nom_group`, `id_admin`) VALUES
(1, 'Cousins', 1),
(2, 'Travail', 1);

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id_photo` int NOT NULL,
  `id_galerie` int NOT NULL,
  `titre` varchar(100) NOT NULL,
  `imageUrl` varchar(255) NOT NULL,
  `motsCles` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id_photo`, `id_galerie`, `titre`, `imageUrl`, `motsCles`, `date`) VALUES
(1, 1, 'Mont Blanc', 'https://www.terdav.com/Content/img/Produits/produit/FRA/345048.ori.jpg', 'mont-blanc sommet', '2020-11-10'),
(2, 1, 'Camping', 'https://www.camping-lelagon-argeles.com/wp-content/uploads/2019/02/dji_0034-copie-2000x923.jpg', 'tente', '2020-11-10'),
(3, 1, 'Rando', 'https://wildbirdscollective.com/wp-content/uploads/2018/10/randonnee-grenoble-famille-plateau-des-lacs-32.jpg', 'marche alpes', '2020-11-10'),
(4, 3, 'Alliance', 'https://cdn.gemperles.com/media/catalog/product/cache/image/2b47332c722624867330ff90201a51e4/a/d/add009-c3.jpg', 'bague alliance', '2020-11-10'),
(5, 3, 'salle', 'https://media.abcsalles.com/images/1/salles/1440x960/9712/salle-colonne-52.jpg', 'salle', '2020-11-10'),
(6, 3, 'Voiture', 'https://images.caradisiac.com/images/1/4/2/8/181428/S0-ventes-de-voitures-en-europe-peugeot-souffre-volkswagen-loin-devant-toyota-cartonne-620190.jpg', 'auto', '2020-11-10'),
(7, 3, 'Service', 'https://i.pinimg.com/originals/c0/fa/5b/c0fa5b49d362d446945ff43a5d92a5be.jpg', 'porcelaine', '2020-11-10'),
(9, 5, 'Friends', 'https://blog.comic-con-paris.com/wp-content/uploads/2019/11/friends-series-compressor.jpg', '', '2020-11-10'),
(10, 5, 'Stranger Things', 'https://img.phonandroid.com/2020/08/stranger-things-3.jpg', '', '2020-11-10'),
(11, 5, 'The Big Bang Theory', 'https://images.bfmtv.com/j86c26kFMQXMu-87GzpTZpbbliA=/4x3:1252x705/1248x0/images/-186047.jpg', '', '2020-11-10'),
(12, 5, 'The Walking Dead', 'https://img.20mn.fr/5im5zzC4SEuZPvf-1mdVyw/830x532_saison-8-the-walking-dead-debarque-dimanche-soir-amc.jpg', '', '2020-11-10'),
(13, 5, 'Friends', 'https://blog.comic-con-paris.com/wp-content/uploads/2019/11/friends-series-compressor.jpg', '', '2020-11-10'),
(14, 5, 'Stranger Things', 'https://img.phonandroid.com/2020/08/stranger-things-3.jpg', '', '2020-11-10'),
(15, 5, 'The Big Bang Theory', 'https://images.bfmtv.com/j86c26kFMQXMu-87GzpTZpbbliA=/4x3:1252x705/1248x0/images/-186047.jpg', '', '2020-11-10'),
(16, 5, 'The Walking Dead', 'https://img.20mn.fr/5im5zzC4SEuZPvf-1mdVyw/830x532_saison-8-the-walking-dead-debarque-dimanche-soir-amc.jpg', '', '2020-11-10'),
(17, 5, 'Friends', 'https://blog.comic-con-paris.com/wp-content/uploads/2019/11/friends-series-compressor.jpg', '', '2020-11-10'),
(18, 5, 'Stranger Things', 'https://img.phonandroid.com/2020/08/stranger-things-3.jpg', '', '2020-11-10'),
(19, 5, 'The Big Bang Theory', 'https://images.bfmtv.com/j86c26kFMQXMu-87GzpTZpbbliA=/4x3:1252x705/1248x0/images/-186047.jpg', '', '2020-11-10'),
(20, 5, 'The Walking Dead', 'https://img.20mn.fr/5im5zzC4SEuZPvf-1mdVyw/830x532_saison-8-the-walking-dead-debarque-dimanche-soir-amc.jpg', '', '2020-11-10'),
(21, 5, 'Friends', 'https://blog.comic-con-paris.com/wp-content/uploads/2019/11/friends-series-compressor.jpg', '', '2020-11-10'),
(22, 5, 'Stranger Things', 'https://img.phonandroid.com/2020/08/stranger-things-3.jpg', '', '2020-11-10'),
(23, 5, 'The Big Bang Theory', 'https://images.bfmtv.com/j86c26kFMQXMu-87GzpTZpbbliA=/4x3:1252x705/1248x0/images/-186047.jpg', '', '2020-11-10'),
(24, 5, 'The Walking Dead', 'https://img.20mn.fr/5im5zzC4SEuZPvf-1mdVyw/830x532_saison-8-the-walking-dead-debarque-dimanche-soir-amc.jpg', '', '2020-11-10'),
(25, 5, 'Friends', 'https://blog.comic-con-paris.com/wp-content/uploads/2019/11/friends-series-compressor.jpg', '', '2020-11-10'),
(26, 5, 'Stranger Things', 'https://img.phonandroid.com/2020/08/stranger-things-3.jpg', '', '2020-11-10'),
(27, 5, 'The Big Bang Theory', 'https://images.bfmtv.com/j86c26kFMQXMu-87GzpTZpbbliA=/4x3:1252x705/1248x0/images/-186047.jpg', '', '2020-11-10'),
(28, 5, 'The Walking Dead', 'https://img.20mn.fr/5im5zzC4SEuZPvf-1mdVyw/830x532_saison-8-the-walking-dead-debarque-dimanche-soir-amc.jpg', '', '2020-11-10'),
(29, 5, 'Friends', 'https://blog.comic-con-paris.com/wp-content/uploads/2019/11/friends-series-compressor.jpg', '', '2020-11-10'),
(30, 5, 'Stranger Things', 'https://img.phonandroid.com/2020/08/stranger-things-3.jpg', '', '2020-11-10'),
(31, 5, 'The Big Bang Theory', 'https://images.bfmtv.com/j86c26kFMQXMu-87GzpTZpbbliA=/4x3:1252x705/1248x0/images/-186047.jpg', '', '2020-11-10'),
(32, 5, 'The Walking Dead', 'https://img.20mn.fr/5im5zzC4SEuZPvf-1mdVyw/830x532_saison-8-the-walking-dead-debarque-dimanche-soir-amc.jpg', '', '2020-11-10'),
(33, 5, 'Friends', 'https://blog.comic-con-paris.com/wp-content/uploads/2019/11/friends-series-compressor.jpg', '', '2020-11-10'),
(34, 5, 'Stranger Things', 'https://img.phonandroid.com/2020/08/stranger-things-3.jpg', '', '2020-11-10'),
(35, 5, 'The Big Bang Theory', 'https://images.bfmtv.com/j86c26kFMQXMu-87GzpTZpbbliA=/4x3:1252x705/1248x0/images/-186047.jpg', '', '2020-11-10'),
(36, 5, 'The Walking Dead', 'https://img.20mn.fr/5im5zzC4SEuZPvf-1mdVyw/830x532_saison-8-the-walking-dead-debarque-dimanche-soir-amc.jpg', '', '2020-11-10'),
(37, 5, 'Friends', 'https://blog.comic-con-paris.com/wp-content/uploads/2019/11/friends-series-compressor.jpg', '', '2020-11-10'),
(38, 5, 'Stranger Things', 'https://img.phonandroid.com/2020/08/stranger-things-3.jpg', '', '2020-11-10'),
(39, 5, 'The Big Bang Theory', 'https://images.bfmtv.com/j86c26kFMQXMu-87GzpTZpbbliA=/4x3:1252x705/1248x0/images/-186047.jpg', '', '2020-11-10'),
(40, 5, 'The Walking Dead', 'https://img.20mn.fr/5im5zzC4SEuZPvf-1mdVyw/830x532_saison-8-the-walking-dead-debarque-dimanche-soir-amc.jpg', '', '2020-11-10');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `email`, `password`) VALUES
(1, 'User 01', 'user01@etu.univ-lorraine.fr', '$2y$10$223tqPiuPXfyRjQz1w2qSeQhMBqt9wyboGjeHCM6GT8LdYJAkypVK'),
(2, 'User 02', 'user02@etu.univ-lorraine.fr', '$2y$10$laMPOzqG8aVRpuJ.i2npJeffDIG.AeBmgc0GZX0NML2ZrrgThy5gi'),
(3, 'Manu Patron', 'manupatron@gouv.fr', '$2y$10$6xzBEOZn.YlBQLGzKBBofepbCbbMVqlEIclqDO/tEcQ4Ojvrd0bFu');

-- --------------------------------------------------------

--
-- Structure de la table `user_2_galerie`
--

CREATE TABLE `user_2_galerie` (
  `id_user` int NOT NULL,
  `id_galerie` int NOT NULL,
  `acces` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_2_galerie`
--

INSERT INTO `user_2_galerie` (`id_user`, `id_galerie`, `acces`) VALUES
(1, 1, 3),
(1, 5, 3),
(2, 5, 2),
(3, 1, 1),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `user_2_group`
--

CREATE TABLE `user_2_group` (
  `id_group` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user_2_group`
--

INSERT INTO `user_2_group` (`id_group`, `id_user`) VALUES
(1, 1),
(1, 3),
(2, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `FK_id_user2` (`id_user`),
  ADD KEY `FK_id_photo2` (`id_photo`);

--
-- Index pour la table `galerie`
--
ALTER TABLE `galerie`
  ADD PRIMARY KEY (`id_galerie`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`id_group`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `FK_id_galerie` (`id_galerie`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `user_2_galerie`
--
ALTER TABLE `user_2_galerie`
  ADD PRIMARY KEY (`id_user`,`id_galerie`),
  ADD KEY `FK_id_galerie1` (`id_galerie`);

--
-- Index pour la table `user_2_group`
--
ALTER TABLE `user_2_group`
  ADD PRIMARY KEY (`id_user`,`id_group`),
  ADD KEY `id_group` (`id_group`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id_commentaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `galerie`
--
ALTER TABLE `galerie`
  MODIFY `id_galerie` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `groupe`
--
ALTER TABLE `groupe`
  MODIFY `id_group` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_id_photo2` FOREIGN KEY (`id_photo`) REFERENCES `photos` (`id_photo`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_id_user2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD CONSTRAINT `groupe_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `FK_id_galerie` FOREIGN KEY (`id_galerie`) REFERENCES `galerie` (`id_galerie`);

--
-- Contraintes pour la table `user_2_galerie`
--
ALTER TABLE `user_2_galerie`
  ADD CONSTRAINT `FK_id_galerie1` FOREIGN KEY (`id_galerie`) REFERENCES `galerie` (`id_galerie`),
  ADD CONSTRAINT `FK_id_user1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Contraintes pour la table `user_2_group`
--
ALTER TABLE `user_2_group`
  ADD CONSTRAINT `user_2_group_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `user_2_group_ibfk_2` FOREIGN KEY (`id_group`) REFERENCES `groupe` (`id_group`),
  ADD CONSTRAINT `user_2_group_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
