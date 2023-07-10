-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 juil. 2023 à 13:01
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `employeproject`
--
CREATE DATABASE IF NOT EXISTS `employeproject` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `employeproject`;

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `idDepartement` int(11) NOT NULL,
  `nomDepartement` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`idDepartement`, `nomDepartement`) VALUES
(1, 'Informatiques'),
(2, 'Ressources Humaines'),
(5, 'Armements');

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

CREATE TABLE `employe` (
  `idEmploye` int(11) NOT NULL,
  `nomEmploye` varchar(50) NOT NULL,
  `prenomEmploye` varchar(50) DEFAULT NULL,
  `adresseEmploye` varchar(50) NOT NULL,
  `sexeEmploye` varchar(2) NOT NULL,
  `numeroEmploye` varchar(13) NOT NULL,
  `dateDEmbauche` date NOT NULL,
  `departEmploye` int(11) DEFAULT NULL,
  `photoEmploye` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `darkMode` varchar(3) NOT NULL DEFAULT 'off',
  `typeCompte` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`idEmploye`, `nomEmploye`, `prenomEmploye`, `adresseEmploye`, `sexeEmploye`, `numeroEmploye`, `dateDEmbauche`, `departEmploye`, `photoEmploye`, `username`, `password`, `darkMode`, `typeCompte`) VALUES
(1, 'Administrateur', NULL, 'Administrateur', 'A', '777', '0000-00-00', NULL, 'null', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'off', 'admin'),
(2, 'TSANGASOA', 'Falinirina Adriano', 'Lot 778 p/lle 13/43', 'M', '0314657985', '2023-07-07', 1, 'user-profile.png', 'ftsangasoa', 'd4650290461e5a33907f019c76959eff1fe2197397f092aa20ab8294a79f8cb6', 'on', 'user'),
(3, 'RAKOTO', 'Rasoa', 'Tanamakoa Nord', 'F', '0345678945', '2023-07-07', 2, 'user-profile-woman.png', 'rrakoto', 'be6debb3564eae8b0b46edd9e535665b15d97135657b6e74e432acb1a7e52f70', 'off', 'user'),
(5, 'FakoS', 'Maloto', 'Ambodiatafana', 'M', '0347662358', '2023-07-13', 5, 'user-profile.png', 'mfakos', '698882a6758efd8216780ef385bb570eadcd33094d37c38d6818a7090227f5ce', 'off', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `presence`
--

CREATE TABLE `presence` (
  `idPresence` int(11) NOT NULL,
  `jourPresence` date NOT NULL,
  `employePresence` int(11) NOT NULL,
  `heureEntree` varchar(10) DEFAULT NULL,
  `heureSortie` varchar(10) DEFAULT NULL,
  `retardMinute` int(11) DEFAULT NULL,
  `avanceMinute` int(11) DEFAULT NULL,
  `travailMinute` int(11) DEFAULT NULL,
  `absent` varchar(3) NOT NULL DEFAULT 'non',
  `matin` varchar(3) NOT NULL DEFAULT 'oui'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `presence`
--

INSERT INTO `presence` (`idPresence`, `jourPresence`, `employePresence`, `heureEntree`, `heureSortie`, `retardMinute`, `avanceMinute`, `travailMinute`, `absent`, `matin`) VALUES
(1, '2023-07-01', 2, '07:35', '12:36', 0, 0, 301, 'non', 'oui'),
(2, '2023-07-03', 2, '07:37', '12:37', 0, 0, 300, 'non', 'oui'),
(3, '2023-07-03', 2, '14:37', '18:38', 37, 0, 241, 'non', 'non'),
(4, '2023-07-04', 2, '07:38', '11:38', 0, 22, 240, 'non', 'oui'),
(5, '2023-07-04', 2, '13:38', '18:38', 0, 0, 300, 'non', 'non'),
(6, '2023-07-05', 2, '07:38', '11:38', 0, 22, 240, 'non', 'oui'),
(7, '2023-07-05', 2, '14:38', '18:38', 38, 0, 240, 'non', 'non'),
(8, '2023-07-08', 2, '08:01', '12:00', 1, 0, 239, 'non', 'oui'),
(9, '2023-07-08', 3, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(10, '2023-07-08', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(11, '2023-07-07', 2, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(12, '2023-07-07', 3, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(13, '2023-07-07', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(14, '2023-07-10', 2, '07:12', '12:00', 0, 0, 288, 'non', 'oui'),
(15, '2023-07-10', 3, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(16, '2023-07-10', 2, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(17, '2023-07-10', 3, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(18, '2023-07-10', 5, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(19, '2023-07-10', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(20, '2023-07-03', 3, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(21, '2023-07-03', 3, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(22, '2023-07-03', 5, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(23, '2023-07-03', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(24, '2023-07-01', 3, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(25, '2023-07-01', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(26, '2023-07-04', 3, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(27, '2023-07-04', 3, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(28, '2023-07-04', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(29, '2023-07-04', 5, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(30, '2023-07-05', 3, '08:00', '11:45', 0, 15, 225, 'non', 'oui'),
(31, '2023-07-05', 3, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(32, '2023-07-05', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(33, '2023-07-05', 5, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(34, '2023-07-07', 2, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(35, '2023-07-06', 2, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(36, '2023-07-06', 3, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(37, '2023-07-06', 3, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(38, '2023-07-07', 3, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(39, '2023-07-06', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(40, '2023-07-06', 2, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(41, '2023-07-07', 5, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(42, '2023-07-06', 5, NULL, NULL, NULL, NULL, NULL, 'oui', 'non'),
(43, '2023-07-11', 2, '09:13', '12:22', 14, 0, 248, 'non', 'oui'),
(44, '2023-06-30', 2, '07:35', '12:15', 0, 0, 280, 'non', 'oui'),
(45, '2023-06-30', 3, '14:15', '18:30', 15, 0, 255, 'non', 'non'),
(46, '2023-06-30', 3, NULL, NULL, NULL, NULL, NULL, 'oui', 'oui'),
(47, '2023-06-30', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(48, '2023-06-30', 5, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(49, '2023-06-30', 2, '14:00', '18:00', 0, 0, 240, 'non', 'non'),
(50, '2023-07-12', 2, '07:22', '11:22', 0, 38, 240, 'non', 'oui'),
(51, '2023-07-12', 2, '13:23', '18:00', 0, 0, 277, 'non', 'non'),
(52, '2023-07-12', 3, NULL, NULL, NULL, NULL, NULL, 'oui', 'oui'),
(53, '2023-07-12', 5, '08:00', '12:00', 0, 0, 240, 'non', 'oui'),
(54, '2023-07-12', 3, NULL, NULL, NULL, NULL, NULL, 'oui', 'non'),
(55, '2023-07-12', 5, NULL, NULL, NULL, NULL, NULL, 'oui', 'non'),
(56, '2023-07-13', 2, '14:29', '17:44', 29, 16, 195, 'non', 'non'),
(57, '2023-07-14', 2, '07:51', '11:52', 0, 8, 241, 'non', 'oui'),
(58, '2023-07-14', 2, '13:55', '18:55', 0, 0, 300, 'non', 'non'),
(59, '2023-07-15', 2, '07:56', '12:56', 0, 0, 300, 'non', 'oui');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`idDepartement`);

--
-- Index pour la table `employe`
--
ALTER TABLE `employe`
  ADD PRIMARY KEY (`idEmploye`),
  ADD UNIQUE KEY `departEmploye` (`departEmploye`);

--
-- Index pour la table `presence`
--
ALTER TABLE `presence`
  ADD PRIMARY KEY (`idPresence`),
  ADD KEY `employePresence` (`employePresence`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `idDepartement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `employe`
--
ALTER TABLE `employe`
  MODIFY `idEmploye` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `presence`
--
ALTER TABLE `presence`
  MODIFY `idPresence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `employe_ibfk_1` FOREIGN KEY (`departEmploye`) REFERENCES `departement` (`idDepartement`);

--
-- Contraintes pour la table `presence`
--
ALTER TABLE `presence`
  ADD CONSTRAINT `presence_ibfk_1` FOREIGN KEY (`employePresence`) REFERENCES `employe` (`idEmploye`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
