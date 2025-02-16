-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : dim. 16 fév. 2025 à 17:27
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ListeCourse`
--

-- --------------------------------------------------------

--
-- Structure de la table `liste`
--

CREATE TABLE `liste` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `items` json NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `liste`
--

INSERT INTO `liste` (`id`, `name`, `items`, `created_at`) VALUES
(12, 'Courses du lundi', '[{\"name\": \"Pommes\", \"quantity\": 4}, {\"name\": \"Lait\", \"quantity\": 2}, {\"name\": \"Pain\", \"quantity\": 1}]', '2025-02-16 17:26:29'),
(13, 'Courses du mardi', '[{\"name\": \"Tomates\", \"quantity\": 5}, {\"name\": \"Fromage\", \"quantity\": 2}, {\"name\": \"Poulet\", \"quantity\": 1}, {\"name\": \"Eau\", \"quantity\": 6}]', '2025-02-16 17:26:29'),
(14, 'Courses du mercredi', '[{\"name\": \"Bananes\", \"quantity\": 6}, {\"name\": \"Beurre\", \"quantity\": 1}, {\"name\": \"Jus d\'orange\", \"quantity\": 2}, {\"name\": \"Œufs\", \"quantity\": 12}]', '2025-02-16 17:26:29'),
(15, 'Courses du jeudi', '[{\"name\": \"Yaourt\", \"quantity\": 4}, {\"name\": \"Céréales\", \"quantity\": 1}, {\"name\": \"Riz\", \"quantity\": 3}]', '2025-02-16 17:26:29'),
(16, 'Courses du vendredi', '[{\"name\": \"Carottes\", \"quantity\": 3}, {\"name\": \"Pâtes\", \"quantity\": 2}, {\"name\": \"Viande hachée\", \"quantity\": 1}, {\"name\": \"Légumes surgelés\", \"quantity\": 4}]', '2025-02-16 17:26:29'),
(17, 'Courses du samedi', '[{\"name\": \"Chocolat\", \"quantity\": 2}, {\"name\": \"Café\", \"quantity\": 1}, {\"name\": \"Laitue\", \"quantity\": 2}, {\"name\": \"Poisson\", \"quantity\": 1}, {\"name\": \"Poivrons\", \"quantity\": 3}]', '2025-02-16 17:26:29'),
(18, 'Courses du dimanche', '[{\"name\": \"Courgettes\", \"quantity\": 3}, {\"name\": \"Yaourt nature\", \"quantity\": 5}, {\"name\": \"Pain complet\", \"quantity\": 1}, {\"name\": \"Huile d\'olive\", \"quantity\": 1}]', '2025-02-16 17:26:29'),
(19, 'Courses spéciales barbecue', '[{\"name\": \"Saucisses\", \"quantity\": 6}, {\"name\": \"Oignons\", \"quantity\": 2}, {\"name\": \"Farine\", \"quantity\": 1}, {\"name\": \"Lentilles\", \"quantity\": 3}, {\"name\": \"Confiture\", \"quantity\": 2}]', '2025-02-16 17:26:29'),
(20, 'Courses pour la semaine', '[{\"name\": \"Pommes de terre\", \"quantity\": 7}, {\"name\": \"Sel\", \"quantity\": 1}, {\"name\": \"Sucre\", \"quantity\": 2}, {\"name\": \"Champignons\", \"quantity\": 3}, {\"name\": \"Vin rouge\", \"quantity\": 1}]', '2025-02-16 17:26:29'),
(21, 'Courses pour le mois', '[{\"name\": \"Bananes\", \"quantity\": 4}, {\"name\": \"Miel\", \"quantity\": 1}, {\"name\": \"Crème fraîche\", \"quantity\": 2}, {\"name\": \"Thé vert\", \"quantity\": 1}]', '2025-02-16 17:26:29');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `liste`
--
ALTER TABLE `liste`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `liste`
--
ALTER TABLE `liste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
