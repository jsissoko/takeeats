
CREATE TABLE users ( 

  id_users INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL ,
  lastname VARCHAR(50) NOT NULL ,
  firstname VARCHAR(50) NOT NULL ,
  email VARCHAR(55) UNIQUE NOT NULL ,
  pwd VARCHAR(80) NOT NULL,
  admnin TINYINT(1) NOT NULL DEFAULT 0); 

CREATE TABLE restaurant ( 

  id_restaurant INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  name VARCHAR(50) NOT NULL ,
  country VARCHAR(100) NOT NULL ,
  street_number VARCHAR(50) NOT NULL,
  street_name VARCHAR (50) NOT NULL,
  postal_code INT(11) NOT NULL,
  description TEXT NOT NULL ,
  phone VARCHAR(20) NOT NULL,
  number_of_place INT(11) NOT NULL); 


CREATE TABLE reservation ( 

  id_reservation INT(11) AUTO_INCREMENT  PRIMARY KEY NOT NULL ,
  id_users INT (11) NOT NULL,
  id_restaurant INT (11) NOT NULL,
  date_reservation DATETIME NOT NULL ,
  number_of_People INT (11) NOT NULL,
  name_reservation VARCHAR(30) NOT NULL,
  FOREIGN KEY (id_users) REFERENCES users(id_users) ON DELETE CASCADE, 
  FOREIGN KEY (id_restaurant) REFERENCES restaurant(id_restaurant)ON DELETE CASCADE); 

 

CREATE TABLE comment ( 

  id_comment INT(11) AUTO_INCREMENT PRIMARY KEY NOT NULL ,
  id_users INT (11) NOT NULL ,
  id_restaurant INT (11) NOT NULL ,
  content TEXT NOT NULL ,
  date_comment DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  FOREIGN KEY (id_users) REFERENCES users(id_users) ON DELETE CASCADE , 
  FOREIGN KEY (id_restaurant) REFERENCES restaurant(id_restaurant)ON DELETE CASCADE ); 

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 05 sep. 2023 à 10:34
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `takeeats`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id_comment` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_restaurant` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_comment` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id_comment`, `id_users`, `id_restaurant`, `content`, `date_comment`) VALUES
(47, 1, 1, 'J\'ai été agréablement surpris par la variété de plats proposés. Le cadre était également charmant.', '2023-08-20 17:48:42'),
(48, 4, 2, 'Malheureusement, mon expérience n\'a pas été à la hauteur des attentes. La nourriture était fade et le service lent.', '2023-08-20 17:48:42'),
(51, 4, 2, 'Un endroit parfait pour les amateurs de fruits de mer ! Les crevettes étaient fraîches et savoureuses.', '2023-08-20 17:48:42'),
(52, 1, 30, 'Le brunch du dimanche était décevant. Les plats étaient froids et le choix était limité. Espérons que ce n\'était qu\'une mauvaise journée.', '2023-08-20 17:48:42'),
(237, 5, 36, 'nl', '2023-08-29 21:42:48'),
(240, 5, 36, 'Le service était impeccable, le personnel était attentionné et connaissait parfaitement le menu. J\'ai opté pour le menu dégustation, et chaque plat était une révélation de saveurs. Le chef a clairement un don pour combiner des ingrédients inattendus de manière créative.', '2023-09-04 10:38:46');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `id_restaurant` int(11) NOT NULL,
  `date_reservation` datetime NOT NULL,
  `number_of_People` int(11) NOT NULL,
  `name_reservation` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `id_users`, `id_restaurant`, `date_reservation`, `number_of_People`, `name_reservation`) VALUES
(29, 1, 2, '2023-10-10 00:00:00', 31, 'sisspoko'),
(33, 1, 2, '2023-10-10 00:00:00', 2, 'carre'),
(45, 1, 1, '2023-10-10 00:00:00', 2, 'Lola'),
(69, 1, 31, '2023-08-31 13:45:00', 2, 'abc'),
(70, 5, 33, '2023-09-06 20:00:00', 6, 'malo'),
(71, 5, 2, '2023-09-20 14:56:00', 5, 'anniversaire de');

-- --------------------------------------------------------

--
-- Structure de la table `restaurant`
--

CREATE TABLE `restaurant` (
  `id_restaurant` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `street_number` varchar(50) NOT NULL,
  `street_name` varchar(50) NOT NULL,
  `postal_code` int(11) NOT NULL,
  `description` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `number_of_place` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `restaurant`
--

INSERT INTO `restaurant` (`id_restaurant`, `name`, `country`, `street_number`, `street_name`, `postal_code`, `description`, `phone`, `number_of_place`) VALUES
(1, 'FlavorQuest', 'France', '21', 'lyon', 45000, 'Bienvenue chez FlavorQuest, l\'ultime guide pour les amateurs de saveurs exquises. Plongez dans un voyage culinaire extraordinaire où chaque repas est une aventure en soi. Découvrez une sélection diversifiée de restaurants, des adresses intimes aux destinations prisées, et réservez en toute simplicité pour une expérience gastronomique inoubliable.', '0769952212', 12),
(2, 'Savoreats', 'France', '12', 'bonnor', 33000, '\r\nBienvenue à SavorEats, votre complice gourmand pour des expériences culinaires exceptionnelles. Plongez dans un monde de délices où chaque bouchée raconte une histoire unique. Explorez notre sélection exclusive de restaurants, des joyaux cachés aux établissements de renom, et réservez en toute simplicité pour un festin inoubliable.', '0139393833', 23),
(30, 'Foodsavy', 'France', '91', ' Montmartre', 75002, 'Découvrez FoodSavvy, une plateforme gastronomique conçue pour les épicuriens modernes. Avec FoodSavvy, plongez dans un monde de délices culinaires et de découvertes gustatives. Explorez une sélection soigneusement choisie de restaurants, des recoins cachés aux établissements renommés, et réservez facilement votre table pour une expérience savoureuse sans tracas.', '0639278982', 78),
(31, 'Le foodcoin', 'France', '21', 'Polna', 13000, 'Notre passion pour le goût authentique se reflète dans chaque aspect de FoodSavvy. Parcourez des menus alléchants, des photos appétissantes et des avis de vrais amateurs de cuisine. Que vous recherchiez une soirée romantique, un déjeuner d\'affaires ou une sortie entre amis, FoodSavvy vous met en relation avec les meilleures options qui correspondent à vos préférences.', '077373999', 123),
(33, 'Foodtram', 'France', '8 ', 'truck', 75009, ' Bienvenue chez FoodTram, le voyage gustatif sur rails. Montez à bord pour une expérience culinaire unique qui vous emmène à travers une variété de saveurs et de cultures. Explorez notre sélection de stands culinaires ambulants, où chaque plat est un arrêt inoubliable sur votre trajet gastronomique.  Chez FoodTram, nous croyons que les meilleures découvertes se font en mouvement. Découvrez des plats créatifs, des recettes traditionnelles et des mets fusion qui vous transportent aux quatre coins du monde. Laissez-vous inspirer par les récits de nos voyageurs culinaires et partagez vos propres aventures gourmandes.', '076995000', 34),
(36, 'Epicurien exquis', 'France', '8', 'Martre', 75001, 'Le Restaurant Épicurien Exquis est bien plus qu\'un simple établissement de restauration. C\'est un monde où l\'art culinaire rencontre une ambiance raffinée pour créer une expérience mémorable à chaque instant. Notre philosophie repose sur l\'idée que chaque plat est une toile vierge, prête à être ornée de saveurs inattendues et de combinaisons audacieuses.  Une Exploration Gastronomique Unique : Notre chef talentueux, véritable maestro de la cuisine, puise dans les richesses de la gastronomie contemporaine pour créer des plats qui transcendent les frontières culinaires traditionnelles. Chaque plat est une expression artistique qui raconte une histoire de créativité et de passion.', '0769951223', 40);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_users` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(55) NOT NULL,
  `pwd` varchar(80) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_users`, `lastname`, `firstname`, `email`, `pwd`, `admin`) VALUES
(1, 'Raypa', 'Andy', 'un@deux.fr', '$2y$10$eRJyhBsQ3aw.yIH6WavHzuLa5XBqJMFvmLS8lcnVR0yzHqAWyrl5q', 1),
(4, 'Sissoko', 'Jeanké', 'Jeanke11@outlook.fr', '$2y$10$lMfvv2fpbryzcpQBmAv.z.w7FA9erkWcRHbpJNR72T47MxoKtukJq', 0),
(5, 'Lancien', 'Gayson', 'lalu@lalu.fr', '$2y$10$tlryPr9RF22NCjRyKHds5u9GtdcRWD0uXWaPKDB52paFgvwVQMsvS', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_restaurant` (`id_restaurant`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_users` (`id_users`),
  ADD KEY `id_restaurant` (`id_restaurant`);

--
-- Index pour la table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`id_restaurant`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_users`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT pour la table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `id_restaurant` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurant` (`id_restaurant`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_users`) REFERENCES `users` (`id_users`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`id_restaurant`) REFERENCES `restaurant` (`id_restaurant`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
