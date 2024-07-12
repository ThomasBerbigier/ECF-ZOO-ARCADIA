-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 12 juil. 2024 à 18:51
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
  `food` varchar(255) NOT NULL,
  `food_weight` int(11) NOT NULL,
  `date` date NOT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `foods`
--

INSERT INTO `foods` (`id`, `food`, `food_weight`, `date`, `animal_id`) VALUES
(1, 'Acacia', 10, '2024-06-19', 1),
(2, 'Feuilles', 250, '2024-06-19', 2),
(3, 'Viande', 10, '2024-06-19', 3),
(4, 'Poisson', 2, '2024-06-19', 4),
(5, 'Crevettes', 1, '2024-06-19', 5),
(6, 'Herbes', 10, '2024-06-19', 6),
(7, 'Eukalyptus', 1, '2024-06-19', 7),
(8, 'Herbes', 14, '2024-06-19', 8),
(9, 'Viande', 8, '2024-06-19', 9),
(10, 'Acacia', 10, '2024-06-20', 1),
(11, 'Viande', 9, '2024-06-20', 3),
(12, 'Herbes', 300, '2024-06-20', 2),
(13, 'Poisson', 2, '2024-06-20', 4),
(14, 'Crevettes', 1, '2024-06-20', 5),
(15, 'Herbes', 10, '2024-06-20', 6),
(16, 'Eukalyptus', 8, '2024-06-20', 7),
(17, 'Herbes', 15, '2024-06-20', 8),
(18, 'Viande', 10, '2024-06-20', 9),
(19, 'Acacia', 13, '2024-06-21', 1);

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
(1, 'savane', 'Bienvenue dans notre habitat savane, où vous pouvez admirer la majesté des lions, la grandeur des girafes, et la puissance des éléphants, recréant l\'éblouissante biodiversité de la savane africaine.', 'assets/main/habitats/habitats/savane.png', 'Bien que les points d\'eau soient bien conçus, il est crucial de maintenir une surveillance régulière de la qualité de l\'eau pour prévenir la prolifération d\'algues et de bactéries. Une filtration adéquate est nécessaire, surtout pendant les périodes chaud'),
(2, 'marais', 'Bienvenue dans notre habitat marais, un écosystème unique où vous pourrez observer la puissance des alligators, la grâce des flamants roses et la robustesse des buffles dans leur environnement naturel.', 'assets/main/habitats/habitats/marais.png', 'Assurer que toutes les zones de l\'habitat sont accessibles pour les soins vétérinaires et la maintenance. Des passerelles sécurisées pour le personnel sont nécessaires pour éviter tout risque de blessure.'),
(3, 'jungle', 'Plongez au cœur de notre habitat jungle, où vous pourrez admirer la majesté des gorilles, la douceur des koalas, et la puissance des tigres, dans un environnement luxuriant et exotique recréant fidèlement leur habitat naturel.', 'assets/main/habitats/habitats/jungle.png', 'Manque de végétation luxuriante, des cachettes et de branches pour simuler un environnement forestier plus proche de la réalité');

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `food` varchar(255) NOT NULL,
  `food_weight` int(11) NOT NULL,
  `passage` date NOT NULL,
  `detail` text DEFAULT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reports`
--

INSERT INTO `reports` (`id`, `state`, `food`, `food_weight`, `passage`, `detail`, `animal_id`) VALUES
(1, 'Stressé', 'Acacia', 10, '2024-06-19', 'Parasitisme (puces, tiques, etc)', 1),
(2, 'En bonne santé', 'Viande', 10, '2024-06-19', 'EN pleine forme', 3),
(3, 'En bonne santé', 'Feuilles', 250, '2024-06-19', '', 2),
(4, 'Mauvais', 'Herbes', 10, '2024-06-19', 'Vomissements, perte de poils\r\nBesoin de tests supplémentaires (analyses de sang, radiographies, etc.)', 6),
(5, 'En bonne santé', 'Poisson', 2, '2024-06-19', '', 4),
(6, 'En bonne santé', 'Crevettes', 1, '2024-06-19', '', 5),
(7, 'En bonne santé', 'Eukalyptus', 10, '2024-06-19', 'En surpoids', 7),
(8, 'Anormal', 'Herbes', 14, '2024-06-19', 'Fièvre, désorientation', 8),
(9, 'En bonne santé', 'Viande', 8, '2024-06-19', 'Saine', 9),
(10, 'En bonne santé', 'Acacia', 10, '2024-06-20', '', 1),
(11, 'En bonne santé', 'Viande', 9, '2024-06-20', '', 3),
(12, 'En bonne santé', 'Feuilles', 300, '2024-06-20', '', 2),
(13, 'En bonne santé', 'Poisson', 2, '2024-06-20', '', 4),
(15, 'Mauvais', 'Herbes', 10, '2024-06-20', 'Tests effectués, en attente des résultats', 6),
(17, 'Anormal', 'Herbes', 15, '2024-06-20', 'Légère amélioration de son état, à surveiller', 8),
(18, 'En bonne santé', 'Viande', 10, '2024-06-20', '', 9),
(19, 'En bonne santé', 'Eukalyptus', 8, '2024-06-20', 'Réduction de la quantité afin de lui faire perdre du poids', 7),
(20, 'En bonne santé', 'Crevettes', 1, '2024-06-20', '', 5),
(21, 'En bonne santé', 'Acacia', 13, '2024-06-21', 'Bon &eacute;tat g&eacute;n&eacute;ral', 1);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `validate` tinyint(1) NOT NULL COMMENT '0=  attente validation,\r\n1 = validé,\r\n2 = invalidé.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `comment`, `validate`) VALUES
(16, 'Marie Dupont', '\"Nous avons passé une super journée au zoo ! Les habitats des animaux sont spacieux et bien entretenus, ce qui est très rassurant. Mes enfants ont adoré observer les lions et les éléphants, et nous avons particulièrement apprécié le spectacle des oiseaux. Le personnel était très accueillant et informatif. La propreté du parc et la qualité des installations étaient impressionnantes. Nous reviendrons certainement pour une prochaine visite !\"', 1),
(17, ' Jean Dufour', '\"J\'ai passé une journée inoubliable au zoo avec ma famille ! Les enclos sont bien entretenus et les animaux semblent en bonne santé. Les enfants ont adoré la section des gorilles. Le personnel était amical et informatif. Nous avons également apprécié les panneaux éducatifs qui fournissent beaucoup d\'informations intéressantes sur les animaux. Dans l\'ensemble, une expérience merveilleuse que je recommande vivement !\"', 1),
(18, 'Antoine Morteyrol', '\"J\'ai passé une journée fantastique au zoo avec ma famille ! Les habitats des animaux sont bien entretenus et les animaux semblent heureux et bien soignés. Mes enfants ont adoré le spectacle des lions, en particulier Leo qui est vraiment impressionnant. Nous avons également apprécié les diverses activités éducatives proposées pour les enfants, comme le coin des explorateurs et les ateliers de sensibilisation à la conservation.\"\n\n', 1),
(19, 'test', 'test', 2),
(20, 'zeagzg', 'egaeraga', 2);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `type`) VALUES
(1, 'administrateur'),
(2, 'employe'),
(3, 'veterinaire');

-- --------------------------------------------------------

--
-- Structure de la table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `hour` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `schedule`
--

INSERT INTO `schedule` (`id`, `day`, `hour`) VALUES
(1, 'Du lundi au dimanche de', '10h &agrave; 18h');

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
(1, 'Restauration', 'Notre zoo vous propose trois d&eacute;licieux restaurants pour satisfaire toutes vos envies culinaires. Au Savanna Grill, d&eacute;gustez des sp&eacute;cialit&eacute;s africaines authentiques en admirant la vue sur notre habitat savane. Le Jungle Caf&eacute; vous invite &agrave; d&eacute;couvrir des saveurs exotiques tout en &eacute;tant entour&eacute; de la v&eacute;g&eacute;tation luxuriante de notre habitat jungle. Pour une pause rafra&icirc;chissante, rendez-vous au Swamp Bistro, o&ugrave; vous pourrez savourer des plats inspir&eacute;s des marais, avec une vue imprenable sur nos flamants roses et nos alligators. Chaque restaurant offre une exp&eacute;rience gastronomique unique, en parfaite harmonie avec l\\atmosph&egrave;re naturelle de nos habitats.', 'assets/main/services/restaurant.png'),
(37, 'Visite guidée', 'Profitez de notre service exclusif de visite guidée gratuite des habitats pour découvrir les merveilles de notre zoo.\nNos guides experts, véritables passionés d\'animaux, vous accompagneront à travers les différents environnements, offrant des anecdotes fascinantes et des informations enrichissantes sur les lions majestueux de la savane, les koalas adorables de la jungle, et bien plus encore.\nCette expérience immersive vous permettra d\'apprécier pleinement la diversité de notre faune et de comprendre l\'importance de la conservation des espèces, qui est un des principaux objectifs de note parc.\nNe manquez pas cette opportunité unique d\'enrichir votre visite avec des connaissances précieuses et des souvenirs inoubliables.', 'assets/main/services/visiteguide.png'),
(38, 'Tour du Zoo en petit train', 'Découvrez le zoo de manière confortable et accessible à tous grâce à notre petit train spécialement conçu et équipé pour accueillir les personnes à mobilité réduite (PMR) afin de garantir une plein expérience pour tout le monde.\nCe service pratique vous permet de parcourir l\'ensemble du parc sans effort, en profitant des commentaires instructifs et amusants de notre guide.\nMontez à bord et laissez-vous transporter à travers nos habitats variés, en observant les majestueux paysages de la savane, les luxuriantes forêts tropicales, et les mystérieux marais.\nLe tour en petit train est une manière idéale pour tous nos visiteurs, y compris les familles et les personnes âgées, de vivre une expérience enrichissante et relaxante au cœur de notre zoo.', 'assets/main/services/Petittrain.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role_id`) VALUES
(1, 'admin@arcadia.fr', '$2y$10$5PyxN9PEGSCRBhR2SKRto.lcK9bUs1GR3heL7DH94vkifI07jXqJi', 1),
(19, 'veterinaire@arcadia.fr', '$2y$10$sc2tOowJzuM1ZnY2gr/HVuDAqYX.pwPsCeroJAQdYMc5SgeSkGw9K', 3),
(20, 'employe@arcadia.fr', '$2y$10$Ai.xEJKllp2mtucFjklC5.Gp2ouTvq/S77V7pKYNmxzRS9yT7HPGe', 2);

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
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `habitats`
--
ALTER TABLE `habitats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
