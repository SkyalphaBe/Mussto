-- phpMyAdmin SQL Dump
-- version 4.9.10
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 18 jan. 2023 à 09:30
-- Version du serveur : 10.5.15-MariaDB-0+deb11u1
-- Version de PHP : 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mussto`
--

--
-- Déchargement des données de la table `ADMIN`
--

INSERT INTO `ADMIN` (`LOGINADMIN`, `PASSWORD_HASH`) VALUES
('admin.admin', '$2y$10$W0S9YoxmDCgqD1lJSFLzqeCE7Q.c8U/jr35sYVJE4H9WAMMQhzumW'),
('François', '$2y$10$kG1HtTwL2TgwkXX5FUXsvOO58kJ0gh1fwWPKdADBzkjy5btarNcj6');

--
-- Déchargement des données de la table `AFFECTER`
--

INSERT INTO `AFFECTER` (`LOGINETU`, `INTITULEGROUPE`, `ANNEEGROUPE`) VALUES
('adrien', 'G1S3', '2022'),
('Alberino', 'G2S3', '2022'),
('aled', 'G1S3', '2022'),
('louis', 'G1S3', '2022'),
('valentin', 'G1S3', '2022');

--
-- Déchargement des données de la table `DEVOIR`
--

INSERT INTO `DEVOIR` (`REFMODULE`, `IDDEVOIR`, `DESCDEVOIR`, `CONTENUDEVOIR`, `COEF`, `DATEDEVOIR`, `SALLE`) VALUES
('UE1-1', 5, 'bonjourerg', 'DS Final', 2, '2023-01-02', 'S11'),
('UE3-1', 24, '', 'Dans 1 semaine', 1, '2023-01-10', '028'),
('UE1-1', 29, '', 'les console.log', 1, '2023-01-06', '028'),
('UE2-1', 30, '', 'Listening', 1, '2022-12-01', '028'),
('UE2-1', 31, '', 'raspebrry pi', 1, '2023-01-13', '028'),
('UE1-1', 32, '', 'yo les gars', 1, '2023-01-11', 'S21'),
('UE3-1', 33, '', 'le vpn', 1, '2023-01-05', 'S26'),
('UE1-1', 35, 'rnejrg', 'DS 2', 1, '2023-01-08', '028'),
('UE1-1', 36, 'zefzef', 'zef', 1, '2023-01-18', '028'),
('UE3-2', 37, 'zefzf', 'test', 1, '2023-01-17', '028');

--
-- Déchargement des données de la table `ENSEIGNER`
--

INSERT INTO `ENSEIGNER` (`LOGINPROF`, `REFMODULE`) VALUES
('a.joubert', 'UE3-2'),
('baron', 'UE1-1'),
('baron', 'UE3-1'),
('bensligoat', 'UE1-1'),
('bensligoat', 'UE3-1'),
('bessac', 'UE2-1'),
('test', 'UE1-1'),
('test', 'UE4-1');

--
-- Déchargement des données de la table `ETUDIANT`
--

INSERT INTO `ETUDIANT` (`LOGINETU`, `PASSWORD_HASH`, `PRENOMETU`, `NOMETU`) VALUES
('adrien', '$2y$10$CRkRCWPv8TVDl/0nCaxq3ujcSyLPtKkv/dqqM/VdEE6fjKD97zXiK', 'Adrien', 'Begassat'),
('Alberino', '$2y$10$wv4Ue6KyrVIiXdysdi/jDeMyMr1P4LdU08da.2SUgyVKWrq5FUCAu', 'Albert', 'VAILLON'),
('aled', '$2y$10$DsHUIwsnZWEtMClJuJeh.eWyltVc0YzWtdD3dR9dfZXdCuzRxylx.', 'Alexis', 'LAVIEILLE'),
('balthazad', '$2y$10$vYfEWKV8WJJi1.LZtE/QwOqmue09oNvrKiDvJ3PpSI7EpcMsLRVqe', 'balthazard', 'muhlstein'),
('louis', '$2y$10$FrCPZHM/y9NAma87BywcgOKacQWurB0an3Rf35M.sEa09T7lFXI/q', 'Louis', 'LACHEREZ'),
('valentin', '$2y$10$/Npyl.psB9ITcq8V6BCkPOx5bved1b2CVKUnWi94mvQ6f4CdMGbIO', 'Valentin', 'SEGALLA');

--
-- Déchargement des données de la table `EVALUER`
--

INSERT INTO `EVALUER` (`INTITULEGROUPE`, `IDDEVOIR`) VALUES
('G1S3', 5),
('G1S3', 24),
('G1S3', 29),
('G1S3', 30),
('G1S3', 31),
('G1S3', 32),
('G1S3', 33),
('G1S3', 35),
('G1S3', 36),
('G1S3', 37),
('G2S3', 5),
('G2S3', 35),
('G3S1', 33);

--
-- Déchargement des données de la table `GROUPE`
--

INSERT INTO `GROUPE` (`INTITULEGROUPE`, `ANNEEGROUPE`) VALUES
('G1S3', '2022'),
('G1S4', '2023'),
('G2S3', '2022'),
('G3S1', '2022');

--
-- Déchargement des données de la table `MODULE`
--

INSERT INTO `MODULE` (`REFMODULE`, `NOMMODULE`, `DESCRIPTIONMODULE`) VALUES
('UE1-1', 'JavaScript', 'Appendre les bases du langage \"JS\" dans le cadre de TP encadrés'),
('UE2-1', 'Anglais', 'Communication en anglais technique pour afin d\'être capable de communiquer  dans le monde professionnel a l\'international'),
('UE3-1', 'Réseau', 'Cringe'),
('UE3-2', 'Cryptographie', 'Apprendre à utiliser des propriétés mathématiques pour crypter un message'),
('UE4-1', 'PHP', 'programation en PHP'),
('UE5-1', 'Management', 'intoduction au management des SI');

--
-- Déchargement des données de la table `NOTER`
--

INSERT INTO `NOTER` (`LOGINETU`, `IDDEVOIR`, `NOTE`, `DATE_ENVOIE`, `COMMENTAIRE`) VALUES
('adrien', 5, 12, '2023-01-09', 'mouais'),
('adrien', 29, 16, '2023-01-09', 'bien joue'),
('adrien', 33, 10.2, '2023-01-09', 'ezfe'),
('adrien', 35, 16, '2023-01-09', NULL),
('louis', 1, 13, '2022-12-15', 'un peu naze'),
('louis', 5, 14.2, '2023-01-04', NULL),
('louis', 29, 12, '2023-01-10', NULL),
('louis', 30, 16.85, '2023-01-06', 'c\'est bien frrot'),
('valentin', 1, 10, '2022-12-16', 'errezef'),
('valentin', 5, 18, '2023-01-09', NULL);

--
-- Déchargement des données de la table `ORGANISER_DEVOIR`
--

INSERT INTO `ORGANISER_DEVOIR` (`loginprof`, `iddevoir`) VALUES
('a.joubert', 37),
('baron', 5),
('baron', 24),
('baron', 29),
('baron', 33),
('baron', 35),
('baron', 36),
('bensligoat', 5),
('bensligoat', 32),
('bensligoat', 35),
('bessac', 30),
('bessac', 31);

--
-- Déchargement des données de la table `PARTICIPER`
--

INSERT INTO `PARTICIPER` (`INTITULEGROUPE`, `ANNEEGROUPE`, `REFMODULE`) VALUES
('G1S3', '2022', 'UE1-1'),
('G1S3', '2022', 'UE2-1'),
('G1S3', '2022', 'UE3-1'),
('G1S3', '2022', 'UE3-2'),
('G2S3', '2022', 'UE1-1'),
('G2S3', '2022', 'UE3-2'),
('G3S1', '2022', 'UE1-1'),
('G3S1', '2022', 'UE3-1');

--
-- Déchargement des données de la table `PROFESSEUR`
--

INSERT INTO `PROFESSEUR` (`LOGINPROF`, `PASSWORD_HASH`, `PRENOMPROF`, `NOMEPROF`) VALUES
('a.joubert', '$2y$10$etvSPOyHIzsXB8/j.GXBeuzW87dpW8uPNWe5dXf6IKgEWEmsFncz2', 'Aude', 'JOUBERT'),
('baron', '$2y$10$YIdzJNB89qKj33A/jBhSAeEmsgOD7Hb3M/C6i8AGwJjUfz.AutWBe', 'Ariane', 'Baron'),
('bensligoat', '$2y$10$3dAT9bapzrcLP/Md0LsmUeU6F9o9sSpblW.pG5I/ey28vIcDgZNha', 'djamal', 'benslimane'),
('bessac', '$2y$10$FM6TtoNmoYFI07/zyS1Gku.QkfeAhG85pcK5jgxzBgvWIIQ97fHzm', 'Mariette', 'BESSAC'),
('test', '\'eitirjf,ker,fip\"\'g,refdz', 'Abdelhadi', 'BELFADEL');

--
-- Déchargement des données de la table `RECEVOIR`
--

INSERT INTO `RECEVOIR` (`IDSONDAGE`, `INTITULEGROUPE`) VALUES
(20, 'G1S3'),
(22, 'G1S3');

--
-- Déchargement des données de la table `REPONDRE`
--

INSERT INTO `REPONDRE` (`LOGINETU`, `IDSONDAGE`, `CONTENUREPONSE`, `DATEREPONSE`) VALUES
('adrien', 20, '{\"Pique nique\":\"Non\",\"Proposez d\'autres id\\u00e9es\":\"ba non\"}', '2023-01-09'),
('adrien', 22, '{\"kohfozjebnf\":\"erg\",\"zefzf\":\"efzf\"}', '2023-01-10');

--
-- Déchargement des données de la table `SALLE`
--

INSERT INTO `SALLE` (`id`) VALUES
('028'),
('S11'),
('S15'),
('S21'),
('S26');

--
-- Déchargement des données de la table `SONDAGE`
--

INSERT INTO `SONDAGE` (`IDSONDAGE`, `REFMODULE`, `LOGINPROF`, `TITLESONDAGE`, `CONTENUSONDAGE`, `AFFICHER`, `DATESONDAGE`) VALUES
(20, 'UE3-1', 'baron', 'On fait quoi ce mardi', '[{\"question\":\"Pique nique\",\"type\":\"choice\",\"choices\":[\"Oui\",\"Non\"]},{\"question\":\"Proposez d\'autres id\\u00e9es\",\"type\":\"free\"}]', 1, '2023-01-08'),
(22, 'UE1-1', 'baron', 'fbd', '[{\"question\":\"kohfozjebnf\",\"type\":\"free\"},{\"question\":\"zefzf\",\"type\":\"choice\",\"choices\":[\"efzf\",\"zef\",\"fz\",\"fze\"]}]', 1, '2023-01-09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
