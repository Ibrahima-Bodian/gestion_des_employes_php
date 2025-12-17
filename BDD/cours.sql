-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 17 déc. 2025 à 15:38
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
-- Base de données : `cours`
--

-- --------------------------------------------------------

--
-- Structure de la table `dept`
--

CREATE TABLE `dept` (
  `numdept` int(11) NOT NULL,
  `deptnom` varchar(25) NOT NULL,
  `ville` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `dept`
--

INSERT INTO `dept` (`numdept`, `deptnom`, `ville`) VALUES
(1, 'vente', 'Blois'),
(2, 'production ', 'Tours'),
(3, 'livraison', 'Contres'),
(4, 'administration', 'Amboise');

-- --------------------------------------------------------

--
-- Structure de la table `emp`
--

CREATE TABLE `emp` (
  `numemp` int(11) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `emploi` varchar(25) NOT NULL,
  `embauche` date DEFAULT NULL,
  `salaire` int(11) DEFAULT NULL,
  `prime` int(11) DEFAULT NULL,
  `numdept` int(11) NOT NULL,
  `chef` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `emp`
--

INSERT INTO `emp` (`numemp`, `nom`, `emploi`, `embauche`, `salaire`, `prime`, `numdept`, `chef`) VALUES
(1, 'Dupont', 'commercial', '2014-01-01', 2300, 500, 1, 4),
(2, 'Dupuis', 'commercial', '2016-11-03', 1800, 200, 1, 1),
(3, 'Leroux', 'directeur', '2016-11-03', 1800, 200, 1, 4),
(4, 'Martin', 'président', '2016-11-03', 3500, 2000, 2, NULL),
(5, 'Titi', 'informaticien', '2016-11-03', 2200, NULL, 1, 1),
(6, 'Toto', 'informaticien', '2014-11-03', 2450, NULL, 4, 1),
(7, 'Riri', 'secrétaire', '2013-11-03', 1600, 100, 2, 3),
(8, 'Fifi', 'secrétaire', '2013-10-15', 1450, 100, 4, 3),
(9, 'Pim', 'ouvrier', '2015-01-03', 1500, 100, 2, 3),
(10, 'Pam', 'ouvrier', '2015-02-01', 1600, 100, 2, 3),
(11, 'Poum', 'ouvrier', '2013-09-03', 1650, 100, 2, 3),
(12, 'Loulou', 'secrétaire', '2013-09-03', 1650, NULL, 4, 4),
(13, 'Max', 'comptable', '2013-09-03', 1650, NULL, 4, 4),
(14, 'Petit', 'comptable', '2013-09-03', 1650, NULL, 4, 4),
(15, 'Morel', 'comptable', '2016-09-03', 1550, NULL, 1, 3),
(16, 'djo', 'prod', '2025-12-15', 4000, 200, 2, 6),
(19, 'Ibra', 'pro', '2025-12-17', 2700, 250, 3, 16);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`numdept`);

--
-- Index pour la table `emp`
--
ALTER TABLE `emp`
  ADD PRIMARY KEY (`numemp`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dept`
--
ALTER TABLE `dept`
  MODIFY `numdept` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `emp`
--
ALTER TABLE `emp`
  MODIFY `numemp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
