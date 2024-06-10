-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 11 juin 2024 à 00:19
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zoo_arcadia`
--

-- --------------------------------------------------------

--
-- Structure de la table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `race` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `habitat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `animals`
--

INSERT INTO `animals` (`id`, `name`, `race`, `picture`, `habitat`) VALUES
(1, 'Twiga', 'Giraffa camelopardalis giraffa', 'assets/main/habitats/animaux/girafe.png', 'savane'),
(2, 'Kibo', 'Loxodonta africana', 'assets/main/habitats/animaux/elephant.png', 'savane'),
(3, 'Leo', 'Panthera leo leo', 'assets/main/habitats/animaux/lion.png', 'savane'),
(4, 'Gator', 'Alligator mississippiensis', 'assets/main/habitats/animaux/alligator.png', 'marais'),
(5, 'Flora', 'Phoenicopterus roseus', 'assets/main/habitats/animaux/flamant_rose.png', 'marais'),
(6, 'Billy', 'Bubalus bubalis', 'assets/main/habitats/animaux/buffle.png', 'marais'),
(7, 'Koko', 'Phascolarctus cinereus', 'assets/main/habitats/animaux/koala.png', 'jungle'),
(8, 'Goliath', 'Gorilla beringei', 'assets/main/habitats/animaux/gorille.png', 'jungle'),
(9, 'Talia', 'Panthera tigris tigris', 'assets/main/habitats/animaux/tigre.png', 'jungle');

-- --------------------------------------------------------

--
-- Structure de la table `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `food` varchar(255) NOT NULL,
  `food_weight` int(11) NOT NULL,
  `passage` date NOT NULL,
  `detail` text DEFAULT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `habitats`
--

CREATE TABLE `habitats` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `habitats`
--

INSERT INTO `habitats` (`id`, `name`, `description`, `picture`, `comment`) VALUES
(1, 'savane', 'Bienvenue dans notre habitat savane, où vous pouvez admirer la majesté des lions, la grandeur des girafes, et la puissance des éléphants, recréant l éblouissante biodiversité de la savane africaine.', 'assets/main/habitats/habitats/savane.png', ''),
(2, 'marais', 'Bienvenue dans notre habitat marais, un écosystème unique où vous pourrez observer la puissance des alligators, la grâce des flamants roses et la robustesse des buffles dans leur environnement naturel.', 'assets/main/habitats/habitats/marais.png', ''),
(3, 'jungle', 'Plongez au cœur de notre habitat jungle, où vous pourrez admirer la majesté des gorilles, la douceur des koalas, et la puissance des tigres, dans un environnement luxuriant et exotique recréant fidèlement leur habitat naturel.', 'assets/main/habitats/habitats/jungle.png', '');

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `passage` date NOT NULL,
  `comment` text NOT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `validate` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `label`, `user_id`) VALUES
(1, 'Administrateur', 1),
(2, 'Employé', 2),
(3, 'Vétérinaire', 3);

-- --------------------------------------------------------

--
-- Structure de la table `schedule`
--

CREATE TABLE `schedule` (
  `day` varchar(255) NOT NULL,
  `hour` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `schedule`
--

INSERT INTO `schedule` (`day`, `hour`) VALUES
('Du lundi au dimanche de', '10h à 18h');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `picture`) VALUES
(1, 'Restauration', 'Notre zoo vous propose trois délicieux restaurants pour satisfaire toutes vos envies culinaires.\r\nAu Savanna Grill, dégustez des spécialités africaines authentiques en admirant la vue sur notre habitat savane.\r\nLe Jungle Café vous invite à découvrir des saveurs exotiques tout en étant entouré de la végétation luxuriante de notre habitat jungle.\r\nPour une pause rafraîchissante, rendez-vous au Swamp Bistro, où vous pourrez savourer des plats inspirés des marais, avec une vue imprenable sur nos flamants roses et nos alligators.\r\nChaque restaurant offre une expérience gastronomique unique, en parfaite harmonie avec l\atmosphère naturelle de nos habitats.', 'assets/main/services/restaurant.png'),
(2, 'Visite guidée', 'Profitez de notre service exclusif de visite guidée gratuite des habitats pour découvrir les merveilles de notre zoo.\r\nNos guides experts, véritables passionés d\animaux, vous accompagneront à travers les différents environnements, offrant des anecdotes fascinantes et des informations enrichissantes sur les lions majestueux de la savane, les koalas adorables de la jungle, et bien plus encore.\r\nCette expérience immersive vous permettra d\apprécier pleinement la diversité de notre faune et de comprendre l\importance de la conservation des espèces, qui est un des principaux objectifs de note parc.\r\nNe manquez pas cette opportunité unique d\enrichir votre visite avec des connaissances précieuses et des souvenirs inoubliables.', 'assets/main/services/visite_guidée.png'),
(3, 'Tour du Zoo en petit train', 'Découvrez le zoo de manière confortable et accessible à tous grâce à notre petit train spécialement conçu et equipé pour accueillir les personnes à mobilité réduite (PMR) afin de garantir une plein expérience pour tout le monde.\r\nCe service pratique vous permet de parcourir l\ensemble du parc sans effort, en profitant des commentaires instructifs et amusants de notre guide.\r\nMontez à bord et laissez-vous transporter à travers nos habitats variés, en observant les majestueux paysages de la savane, les luxuriantes forêts tropicales, et les mystérieux marais.\r\nLe tour en petit train est une manière idéale pour tous nos visiteurs, y compris les familles et les personnes âgées, de vivre une expérience enrichissante et relaxante au cœur de notre zoo.', 'assets/main/services/Petit_train.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.fr', 'admin'),
(2, 'employee@employee.fr', 'employee'),
(3, 'vet@vet.fr', 'vet');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `habitat` (`habitat`);

--
-- Index pour la table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `habitats`
--
ALTER TABLE `habitats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `NAME` (`name`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `habitats`
--
ALTER TABLE `habitats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `animals_ibfk_1` FOREIGN KEY (`habitat`) REFERENCES `habitats` (`name`);

--
-- Contraintes pour la table `foods`
--
ALTER TABLE `foods`
  ADD CONSTRAINT `foods_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`);

--
-- Contraintes pour la table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`);

--
-- Contraintes pour la table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
