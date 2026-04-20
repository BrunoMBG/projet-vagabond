-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : lun. 20 avr. 2026 à 07:21
-- Version du serveur : 8.4.8
-- Version de PHP : 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vagabond`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id_commentaire` int NOT NULL,
  `commentaire` text NOT NULL,
  `date_commentaire` datetime DEFAULT NULL,
  `id_recit` int NOT NULL,
  `id_utilisateur` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `destinations`
--

CREATE TABLE `destinations` (
  `id_destination` int NOT NULL,
  `nom_destination` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `destinations`
--

INSERT INTO `destinations` (`id_destination`, `nom_destination`) VALUES
(1, 'Afrique'),
(2, 'Amérique du Nord'),
(3, 'Amérique du Sud'),
(4, 'Antarctique'),
(5, 'Asie'),
(6, 'Europe'),
(7, 'Océanie');

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

CREATE TABLE `favoris` (
  `id_utilisateur` int NOT NULL,
  `id_recit` int NOT NULL,
  `date_ajout` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recits`
--

CREATE TABLE `recits` (
  `id_recit` int NOT NULL,
  `titre` varchar(50) NOT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `contenu` text NOT NULL,
  `image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_destination` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `date_creation` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recits`
--

INSERT INTO `recits` (`id_recit`, `titre`, `ville`, `contenu`, `image`, `id_destination`, `id_utilisateur`, `date_creation`) VALUES
(1, 'Mon voyage à Tokyo', 'Tokyo', 'L’année dernière, je suis allé à Tokyo tout seul. C’était la première fois que je voyageais seul et j’étais à la fois un peu nerveux et très excité.\r\n\r\nQuand je suis arrivé, j’ai été impressionné par la taille de la ville et par les nombreux immeubles et lumières. Le premier endroit que j’ai visité était la célèbre Tokyo Tower. Je suis monté en haut pour admirer la vue sur toute la ville. C’était vraiment magnifique.\r\n\r\nEnsuite, je suis allé voir le célèbre carrefour de Shibuya Crossing. Il y avait énormément de personnes qui traversaient la rue en même temps. J’ai trouvé cette expérience très impressionnante.\r\n\r\nJ’ai aussi visité le temple Sensō-ji. L’endroit était calme et très beau, et j’ai pris beaucoup de photos.\r\n\r\nPendant mon voyage, j’ai goûté des plats japonais comme les sushi et les ramen dans de petits restaurants. La nourriture était délicieuse.\r\n\r\nCe voyage en solo à Tokyo était une expérience incroyable pour moi. J’ai découvert une culture différente et j’ai appris beaucoup de choses pendant ce séjour. Je garderai toujours de très bons souvenirs de cette aventure.', 'art_69dde255e9d1d.webp', 5, 1, '2026-04-13 09:20:28'),
(2, 'Mon voyage à Paris', 'Paris', 'Mon voyage à Paris a commencé par un vol tôt le matin avec ma famille. C’était la première fois que je visitais cette ville et j’étais très heureux.\r\n\r\nQuand nous sommes arrivés, j’ai tout de suite été impressionné par la beauté de la ville. Le premier endroit que j’ai visité était la Tour Eiffel. Je suis monté en haut et j’ai vu toute la ville. La vue était magnifique.\r\n\r\nEnsuite, j’ai marché près de la Seine et j’ai pris beaucoup de photos. J’ai aussi visité le célèbre musée Musée du Louvre où j’ai vu la peinture très connue, la Mona Lisa.\r\n\r\nJ’ai aussi goûté des croissants et des crêpes dans un petit café. La nourriture était délicieuse. Les gens étaient gentils et l’ambiance était agréable.\r\n\r\nCe voyage à Paris était une expérience incroyable pour moi. Je garderai toujours de très beaux souvenirs de cette ville.', 'art_69dde2486111f.webp', 6, 1, '2026-04-13 09:22:02'),
(3, 'Mon voyage à Toronto', 'Toronto', 'Il y a quelque temps, j’ai eu l’occasion de voyager seul à Toronto. J’étais très enthousiaste à l’idée de découvrir cette grande ville canadienne et de vivre une nouvelle aventure.\r\n\r\nQuand je suis arrivé, j’ai été impressionné par les grands immeubles et l’ambiance dynamique de la ville. Le premier endroit que j’ai visité était la célèbre CN Tower. Je suis monté au sommet et j’ai admiré la vue sur toute la ville et sur le lac. C’était vraiment spectaculaire.\r\n\r\nEnsuite, je me suis promené près du Lake Ontario. L’endroit était très calme et agréable. J’ai pris plusieurs photos et j’ai profité du magnifique paysage.\r\n\r\nJ’ai aussi exploré différents quartiers de la ville et j’ai découvert des restaurants où j’ai goûté de nouveaux plats. Les habitants étaient très accueillants et l’atmosphère de la ville était très agréable.\r\n\r\nCe voyage à Toronto a été une expérience inoubliable pour moi. J’ai découvert une ville moderne et intéressante, et je garderai toujours de très beaux souvenirs de cette aventure.', 'art_69dde23e5d4fb.webp', 2, 1, '2026-04-13 09:24:14'),
(4, 'Mon voyage à Marrakech', 'Marrakech', 'Récemment, j’ai décidé de partir seul à Marrakech pour découvrir la culture et les couleurs de cette ville marocaine. J’étais très curieux de voir ses marchés, ses monuments et ses ruelles animées.\r\n\r\nDès mon arrivée, j’ai été frappé par la chaleur des gens et la beauté des bâtiments traditionnels. Mon premier arrêt a été la célèbre Jemaa el-Fna. C’était un lieu très animé, avec des musiciens, des marchands et des spectacles. L’ambiance était incroyable !\r\n\r\nEnsuite, j’ai exploré les magnifiques jardins de Jardin Majorelle. Les couleurs et les plantes étaient splendides, et l’endroit était très paisible. J’ai pris beaucoup de photos pour me souvenir de chaque détail.\r\n\r\nPendant mon séjour, j’ai goûté des plats typiques comme le tagine et le couscous dans de petits restaurants locaux. La nourriture était délicieuse et très différente de ce que je connaissais.\r\n\r\nCe voyage à Marrakech a été une expérience unique pour moi. J’ai découvert une culture riche et fascinante, et j’ai ramené avec moi des souvenirs inoubliables de cette ville colorée.', 'art_69e1f89aa55db.webp', 1, 1, '2026-04-13 09:24:49');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `libelle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id_role`, `libelle`) VALUES
(1, 'Administrateur'),
(2, 'Redacteur'),
(3, 'Membre');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `token_expiration` datetime DEFAULT NULL,
  `id_role` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `password`, `token`, `token_expiration`, `id_role`) VALUES
(1, 'Vagabond', 'Bruno', 'admin@test.fr', '$2y$10$frgZbCPbINaMdz671FZ05errHlU6AT3hYZ/ImRA14LPvZVApDe6Yi', NULL, NULL, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id_commentaire`),
  ADD KEY `id_recit` (`id_recit`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `destinations`
--
ALTER TABLE `destinations`
  ADD PRIMARY KEY (`id_destination`);

--
-- Index pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD PRIMARY KEY (`id_utilisateur`,`id_recit`),
  ADD KEY `id_recit` (`id_recit`);

--
-- Index pour la table `recits`
--
ALTER TABLE `recits`
  ADD PRIMARY KEY (`id_recit`),
  ADD KEY `id_destination` (`id_destination`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id_commentaire` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `destinations`
--
ALTER TABLE `destinations`
  MODIFY `id_destination` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `recits`
--
ALTER TABLE `recits`
  MODIFY `id_recit` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_recit`) REFERENCES `recits` (`id_recit`),
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `favoris_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `favoris_ibfk_2` FOREIGN KEY (`id_recit`) REFERENCES `recits` (`id_recit`);

--
-- Contraintes pour la table `recits`
--
ALTER TABLE `recits`
  ADD CONSTRAINT `recits_ibfk_1` FOREIGN KEY (`id_destination`) REFERENCES `destinations` (`id_destination`),
  ADD CONSTRAINT `recits_ibfk_2` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
