SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `criee`
--

-- Supprime la base de données si elle existe déjà
DROP DATABASE IF EXISTS criee;

-- Créer la base de données
CREATE DATABASE criee;

-- On se place dessus
USE criee;

-- --------------------------------------------------------

--
-- Structure de la table `acheteur`
--

CREATE TABLE `acheteur` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `numRue` int(10) NOT NULL,
  `voie` varchar(255) NOT NULL,
  `cp` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `pbq3kv7aDaR6sBdEC2Xm5plI1nwSg347` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `acheteur`
--

INSERT INTO `acheteur` (`id`, `nom`, `prenom`, `login`, `pwd`, `numRue`, `voie`, `cp`, `ville`, `pbq3kv7aDaR6sBdEC2Xm5plI1nwSg347`) VALUES
(1, 'DOE', 'John', 'john@doe.com', '$2y$10$71lfUu.3SK9/t.cpucu5Fe.4Dn0HNnjDGo0FgGWE53oXdRJ4zFj7e', 4, 'rue Schoch', '67000', 'Strasbourg', '$2y$10$5b6AqqRuLq0YtGOfVrLdguWtOiXC6LHNLpKFLc0aLx/rRDXBkYrIK');

-- --------------------------------------------------------

--
-- Structure de la table `bac`
--

CREATE TABLE `bac` (
  `id` char(1) NOT NULL,
  `tare` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `bac`
--

INSERT INTO `bac` (`id`, `tare`) VALUES
('B', '2.50'),
('F', '4.00');

-- --------------------------------------------------------

--
-- Structure de la table `bateau`
--

CREATE TABLE `bateau` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(32) DEFAULT NULL,
  `immatriculation` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `bateau`
--

INSERT INTO `bateau` (`id`, `nom`, `immatriculation`) VALUES
(1, 'Altair', 'Ad 895511'),
(2, 'Macareux', 'Ad 584873'),
(3, 'Avel Ar Mor', 'Ad 584930'),
(4, 'Plujadur', 'Ad 627846'),
(5, 'Gwaien', 'Ad 730414'),
(6, 'L Estran', 'Ad 815532'),
(7, 'Le Petit Corse', 'Ad 584826'),
(8, 'Le Vorlen', 'Ad 614221'),
(9, 'Les Copains d Abord', 'Ad 584846'),
(10, 'Tu Pe Du', 'Ad 584871'),
(11, 'Korrigan', 'Ad 895472'),
(12, 'Ar Guevel', 'Ad 895479'),
(13, 'Broceliande', 'Ad 895519'),
(14, 'L Aventurier', 'Ad 584865'),
(15, 'L Oceanide', 'Ad 741312'),
(16, 'L Arche d alliance', 'Ad 584830'),
(17, 'Sirocco', 'Ad 715792'),
(18, 'Ondine', 'Ad 584772'),
(19, 'Chimere', 'Ad 895516');

-- --------------------------------------------------------

--
-- Structure de la table `espece`
--

CREATE TABLE `espece` (
  `id` int(10) UNSIGNED NOT NULL,
  `nom` varchar(32) DEFAULT NULL,
  `nomScientifique` varchar(32) DEFAULT NULL,
  `nomCourt` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `espece`
--

INSERT INTO `espece` (`id`, `nom`, `nomScientifique`, `nomCourt`) VALUES
(31020, 'Turbot', 'Psetta maxima', 'TURBO'),
(31030, 'Barbue', 'Scophthalmus rhombus', 'BARBU'),
(31150, 'Plie ou carrelet', 'Pleuronectes Platessa', 'PLIE'),
(32020, 'Merlu', 'Merluccius bilinearis', 'MERLU'),
(32050, 'Cabillaud', 'Gadus Morhua Morhue', 'CABIL'),
(32130, 'Lieu Jaune de Ligne', 'Pollachius pollachius', 'LJAUL'),
(32140, 'Lieu Noir', 'Lophius Virens', 'LNOI'),
(32230, 'Lingue franche', 'Molva Molva', 'LINGU'),
(33020, 'Congre commun', 'Conger conger', 'CONGR'),
(33080, 'Saint Pierre', 'Zeus Faber', 'STPIE'),
(33090, 'Bar de Chalut', 'Dicentrarchus Labrax', 'BARCH'),
(33091, 'Bar de Ligne', 'Dicentrarchus Labrax', 'BARLI'),
(33110, 'Mérou ou cernier', 'Polyprion Americanus', 'CERNI'),
(33120, 'Mérou noir', 'Epinephelus Guaza', 'MEROU'),
(33410, 'Rouget Barbet', 'Mullus SPP', 'ROUGT'),
(33450, 'Dorade royale chalut', 'Sparus Aurata', 'DORAC'),
(33451, 'Dorade royale ligne', 'Sparus Aurata', 'DORAL'),
(33480, 'Dorade rose', 'Pagellus bogaraveo', 'DORAD'),
(33490, 'Pageot Acarne', 'Pagellus Acarne', 'PAGEO'),
(33500, 'Pageot Commun', 'Pagellus Arythrinus', 'PAGEC'),
(33580, 'Vieille', 'LabrusBergylta', 'VIEIL'),
(33730, 'Grondin gris', 'Eutrigla Gurnadus', 'GRONG'),
(33740, 'Grondin rouge', 'Aspitrigla Cuculus', 'GRONR'),
(33760, 'Baudroie', 'Lophius Piscatorus', 'BAUDR'),
(33761, 'Baudroie Maigre', 'Lophius Piscicatorius', 'BAUDM'),
(33790, 'Grondin Camard', 'Trigloporus Lastoviza', 'GRONC'),
(33800, 'Grondin Perlon', 'Trigla Lucerna', 'GRONP'),
(34150, 'Mulet', 'Mugil SPP', 'MULET'),
(35040, 'Sardine atlantique', 'Sardina Pilchardus', 'SARDI'),
(37050, 'Maquereau', 'Scomber Scombrus', 'MAQUE'),
(38150, 'Raie douce', 'Raja Montagui', 'RAIE'),
(38160, 'Raie Pastenague commune', 'Dasyatis Pastinaca', 'RAIEP'),
(42020, 'Crabe tourteau de casier', 'Cancer Pagurus', 'CRABS'),
(42021, 'Crabe tourteau de chalut', 'Cancer Pagurus', 'CRABL'),
(42040, 'Araignée de mer casier', 'Maja squinado', 'ARAIS'),
(42041, 'Araignée de mer chalut', 'Maja squinado', 'ARAIL'),
(43010, 'Homard', 'Hammarus gammorus', 'HOMAR'),
(43030, 'Langouste rouge', 'Palinurus elephas', 'LANGR'),
(44010, 'Langoustine', 'Nephrops norvegicus', 'LANGT'),
(57010, 'Seiche', 'Sepia SPP', 'SEICH'),
(57020, 'Calmar', 'Loligo SPP', 'CALAM'),
(57050, 'Poulpe', 'Octopus SPP', 'POULP');

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

CREATE TABLE `etat` (
  `code` char(1) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `etat`
--

INSERT INTO `etat` (`code`, `libelle`) VALUES
('E', 'En cours'),
('P', 'Pas encore commencé'),
('T', 'Terminée');

-- --------------------------------------------------------

--
-- Structure de la table `lot`
--

CREATE TABLE `lot` (
  `idDatePeche` date NOT NULL,
  `idBateau` int(10) UNSIGNED NOT NULL,
  `id` decimal(3,0) UNSIGNED NOT NULL,
  `idEspece` int(10) UNSIGNED NOT NULL,
  `idTaille` decimal(2,0) NOT NULL,
  `idPresentation` char(3) NOT NULL,
  `idQualite` char(1) NOT NULL,
  `idBac` char(1) NOT NULL,
  `poidsBrutLot` decimal(6,2) DEFAULT NULL,
  `dateDebutEnchere` datetime DEFAULT NULL,
  `dateFinEnchere` datetime DEFAULT NULL,
  `prixPlancher` decimal(6,2) DEFAULT NULL,
  `prixDepart` decimal(6,2) DEFAULT NULL,
  `codeEtat` char(1) DEFAULT NULL,
  `idAcheteur` int(10) UNSIGNED DEFAULT NULL,
  `idFacture` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `lot`
--

INSERT INTO `lot` (`idDatePeche`, `idBateau`, `id`, `idEspece`, `idTaille`, `idPresentation`, `idQualite`, `idBac`, `poidsBrutLot`, `dateDebutEnchere`, `dateFinEnchere`, `prixPlancher`, `prixDepart`, `codeEtat`, `idAcheteur`, `idFacture`) VALUES
('2008-07-18', 11, '1', 32130, '40', 'VID', 'E', 'B', '8.40', '2023-05-09 10:55:12', '2023-05-31 18:31:42', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-18', 11, '2', 32130, '40', 'VID', 'E', 'B', '9.10', '2023-05-10 19:49:55', '2023-05-11 10:00:17', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-18', 11, '3', 32130, '40', 'VID', 'E', 'B', '8.40', '2023-05-09 14:31:39', '2023-05-12 18:37:25', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-18', 11, '4', 32130, '20', 'VID', 'E', 'F', '15.10', '2023-05-10 01:32:08', '2023-05-31 18:31:26', '8.50', '8.50', NULL, NULL, NULL),
('2008-07-18', 11, '5', 32130, '30', 'VID', 'E', 'F', '10.40', '2023-05-09 18:25:43', '2023-05-12 20:43:20', '14.30', '13.30', NULL, NULL, NULL),
('2008-07-20', 11, '1', 32130, '40', 'VID', 'E', 'B', '8.40', '2023-05-10 00:19:31', '2023-05-12 11:27:33', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-20', 11, '2', 32130, '40', 'VID', 'E', 'B', '9.10', '2023-05-09 08:19:14', '2023-05-12 07:13:29', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-20', 11, '3', 32130, '40', 'VID', 'E', 'B', '8.40', '2023-05-10 11:09:46', '2023-05-12 10:08:20', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-20', 11, '4', 32130, '25', 'VID', 'A', 'F', '15.10', '2023-05-09 17:12:24', '2023-05-12 07:37:00', '16.50', '15.50', NULL, NULL, NULL),
('2008-07-20', 11, '5', 32130, '30', 'VID', 'E', 'F', '10.40', '2023-05-09 10:27:46', '2023-05-11 05:27:53', '16.30', '15.30', NULL, NULL, NULL),
('2008-07-21', 11, '1', 32130, '40', 'VID', 'E', 'B', '8.40', '2023-05-10 19:56:05', '2023-06-01 04:19:40', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-21', 11, '2', 32130, '40', 'VID', 'E', 'B', '9.10', '2023-05-09 20:35:37', '2023-05-11 21:07:46', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-21', 11, '3', 32130, '40', 'VID', 'E', 'B', '8.40', '2023-05-10 19:52:00', '2023-05-11 11:56:40', '6.00', '6.00', NULL, NULL, NULL),
('2008-07-21', 11, '4', 32130, '20', 'VID', 'E', 'F', '15.10', '2023-05-10 00:07:21', '2023-05-12 12:46:47', '16.50', '15.50', NULL, NULL, NULL),
('2008-07-21', 11, '5', 32130, '30', 'VID', 'E', 'F', '10.40', '2023-05-09 15:31:49', '2023-05-11 15:18:44', '14.30', '14.30', NULL, NULL, NULL),
('2008-07-23', 11, '1', 32130, '20', 'VID', 'E', 'F', '19.20', '2023-05-10 05:58:14', '2023-05-11 07:54:58', '4.80', '4.50', NULL, NULL, NULL),
('2008-07-23', 11, '2', 32130, '40', 'VID', 'E', 'F', '19.20', '2023-05-10 21:40:10', '2023-05-11 12:35:53', '5.50', '5.00', NULL, NULL, NULL),
('2008-07-24', 1, '1', 32230, '25', 'VID', 'E', 'B', '20.00', '2023-05-09 21:58:57', '2023-05-12 00:07:05', '8.50', '8.00', NULL, NULL, NULL),
('2008-07-24', 1, '2', 32230, '30', 'VID', 'E', 'B', '20.00', '2023-05-09 06:38:33', '2023-05-11 08:51:32', '14.00', '13.00', NULL, NULL, NULL),
('2008-07-24', 1, '3', 32230, '40', 'VID', 'E', 'F', '18.00', '2023-05-10 00:21:59', '2023-05-12 23:15:20', '8.00', '7.50', NULL, NULL, NULL),
('2008-07-24', 1, '4', 33580, '25', 'VID', 'E', 'F', '14.00', '2023-05-09 19:10:42', '2023-05-11 02:07:31', '16.50', '16.00', NULL, NULL, NULL),
('2008-07-24', 11, '1', 32130, '70', 'VID', 'E', 'B', '13.00', '2023-05-09 01:05:27', '2023-05-12 23:04:43', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-24', 11, '2', 33091, '10', 'ENT', 'A', 'F', '8.00', '2023-05-10 16:07:16', '2023-05-11 11:22:10', '14.00', '13.00', NULL, NULL, NULL),
('2008-07-24', 11, '3', 33091, '30', 'ENT', 'E', 'F', '21.00', '2023-05-10 08:29:00', '2023-05-12 08:18:31', '8.50', '8.30', NULL, NULL, NULL),
('2008-07-24', 11, '4', 33091, '35', 'ENT', 'E', 'B', '12.00', '2023-05-09 16:05:34', '2023-05-12 07:32:16', '7.50', '7.00', NULL, NULL, NULL),
('2008-07-24', 11, '5', 33580, '20', 'VID', 'E', 'B', '8.00', '2023-05-09 13:24:39', '2023-05-11 20:26:29', '14.00', '13.50', NULL, NULL, NULL),
('2008-07-25', 1, '1', 33091, '10', 'ENT', 'A', 'F', '10.80', '2023-05-09 13:58:26', '2023-05-11 08:32:45', '7.00', '6.00', NULL, NULL, NULL),
('2008-07-25', 1, '2', 33580, '20', 'VID', 'E', 'B', '9.60', '2023-05-09 00:48:26', '2023-05-12 02:23:56', '9.00', '8.00', NULL, NULL, NULL),
('2008-07-25', 1, '3', 33091, '15', 'ENT', 'B', 'B', '8.00', '2023-05-10 09:34:23', '2023-05-12 16:40:05', '14.00', '13.00', NULL, NULL, NULL),
('2008-07-25', 3, '1', 33091, '30', 'ENT', 'B', 'F', '19.00', '2023-05-09 06:37:16', '2023-05-11 07:06:05', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-25', 3, '2', 33091, '30', 'ENT', 'B', 'F', '19.00', '2023-05-09 15:38:38', '2023-05-11 08:54:54', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-25', 7, '1', 32230, '25', 'VID', 'E', 'F', '14.50', '2023-06-01 02:38:36', '2023-06-03 04:28:20', '16.00', '15.00', NULL, NULL, NULL),
('2008-07-25', 7, '2', 32230, '35', 'VID', 'E', 'F', '17.50', '2023-05-09 06:25:49', '2023-05-11 03:44:07', '15.00', '14.00', NULL, NULL, NULL),
('2008-07-25', 11, '1', 33580, '40', 'VID', 'E', 'F', '18.50', '2023-05-10 23:23:09', '2023-05-12 09:43:22', '8.00', '7.00', NULL, NULL, NULL),
('2008-07-30', 1, '1', 33091, '10', 'ENT', 'A', 'F', '10.80', '2023-05-10 02:27:25', '2023-05-12 07:06:57', '7.00', '6.00', NULL, NULL, NULL),
('2008-07-30', 1, '2', 33080, '20', 'VID', 'E', 'B', '9.60', '2023-05-10 04:12:31', '2023-06-01 14:30:42', '9.00', '8.00', NULL, NULL, NULL),
('2008-07-30', 1, '3', 33091, '15', 'ENT', 'B', 'B', '8.00', '2023-05-09 09:50:59', '2023-05-11 02:09:49', '14.00', '13.00', NULL, NULL, NULL),
('2008-07-30', 1, '4', 33110, '10', 'ENT', 'A', 'F', '10.80', '2023-05-10 05:16:08', '2023-05-12 19:51:13', '7.00', '6.00', NULL, NULL, NULL),
('2008-07-30', 1, '5', 33080, '20', 'VID', 'E', 'B', '9.60', '2023-05-10 11:27:39', '2023-05-12 21:44:39', '9.00', '8.00', NULL, NULL, NULL),
('2008-07-30', 1, '6', 33110, '15', 'ENT', 'B', 'B', '8.00', '2023-05-10 02:20:18', '2023-05-12 18:27:30', '14.00', '13.00', NULL, NULL, NULL),
('2008-07-30', 1, '7', 33451, '10', 'ENT', 'A', 'F', '10.80', '2023-05-10 13:16:38', '2023-05-11 11:00:39', '7.00', '6.00', NULL, NULL, NULL),
('2008-07-30', 1, '8', 33080, '20', 'VID', 'E', 'B', '9.60', '2023-05-10 15:13:21', '2023-05-11 19:04:47', '9.00', '8.00', NULL, NULL, NULL),
('2008-07-30', 1, '9', 33451, '15', 'ENT', 'B', 'B', '8.00', '2023-05-10 01:43:53', '2023-05-11 23:25:05', '14.00', '13.00', NULL, NULL, NULL),
('2008-07-30', 3, '1', 33091, '30', 'ENT', 'B', 'F', '19.00', '2023-05-10 15:53:43', '2023-05-12 09:13:23', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-30', 3, '2', 33110, '30', 'ENT', 'B', 'F', '19.00', '2023-05-10 22:25:44', '2023-05-12 12:28:33', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-30', 3, '3', 33110, '30', 'ENT', 'B', 'F', '19.00', '2023-05-10 19:05:33', '2023-05-11 10:02:07', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-30', 3, '4', 33451, '30', 'ENT', 'B', 'F', '19.00', '2023-05-09 16:53:55', '2023-05-11 06:23:13', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-30', 3, '5', 33451, '30', 'ENT', 'B', 'F', '19.00', '2023-05-10 05:14:21', '2023-05-12 07:02:07', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-30', 3, '6', 33451, '30', 'ENT', 'B', 'F', '19.00', '2023-05-09 19:27:33', '2023-05-11 04:11:23', '14.00', '12.00', NULL, NULL, NULL),
('2008-07-30', 7, '1', 33080, '25', 'VID', 'E', 'F', '14.50', '2023-05-09 10:34:15', '2023-05-12 16:17:05', '16.00', '15.00', NULL, NULL, NULL),
('2008-07-30', 7, '2', 33080, '35', 'VID', 'E', 'F', '17.50', '2023-05-31 13:53:52', '2023-05-31 19:32:07', '15.00', '14.00', NULL, NULL, NULL),
('2008-07-30', 7, '3', 33080, '25', 'VID', 'E', 'F', '14.50', '2023-05-06 15:15:33', '2023-05-10 15:09:25', '16.00', '15.00', NULL, NULL, NULL),
('2008-07-30', 7, '4', 33080, '35', 'VID', 'E', 'F', '17.50', '2023-05-01 20:50:55', '2023-05-10 14:05:44', '15.00', '14.00', NULL, NULL, NULL),
('2008-07-30', 7, '5', 33080, '25', 'VID', 'E', 'F', '14.50', '2023-05-01 18:47:38', '2023-05-10 11:24:30', '16.00', '15.00', NULL, NULL, NULL),
('2008-07-30', 7, '6', 33080, '35', 'VID', 'E', 'F', '17.50', '2023-05-01 01:26:42', '2023-05-08 17:54:08', '15.00', '14.00', NULL, NULL, NULL),
('2008-07-30', 11, '1', 33080, '40', 'VID', 'E', 'F', '18.50', '2023-05-02 02:18:43', '2023-05-08 21:28:09', '8.00', '7.00', NULL, NULL, NULL),
('2008-07-30', 11, '2', 33080, '40', 'VID', 'E', 'F', '18.50', '2023-05-07 06:55:18', '2023-05-07 06:47:50', '8.00', '7.00', NULL, NULL, NULL),
('2008-07-30', 11, '3', 33080, '40', 'VID', 'E', 'F', '18.50', '2023-05-05 14:42:40', '2023-05-07 07:55:33', '8.00', '7.00', NULL, NULL, NULL),
('2008-08-12', 5, '1', 32050, '25', 'VID', 'E', 'F', '12.00', '2023-05-04 01:13:08', '2023-05-10 17:25:07', '3.00', '5.00', NULL, NULL, NULL),
('2008-08-12', 9, '1', 42040, '10', 'ENT', 'E', 'F', '15.00', '2023-05-03 10:45:34', '2023-05-10 19:37:37', '7.00', '6.00', NULL, NULL, NULL),
('2008-08-12', 9, '2', 42040, '10', 'ENT', 'E', 'F', '20.00', '2023-05-06 01:27:36', '2023-05-10 00:08:50', '7.00', '6.00', NULL, NULL, NULL),
('2008-08-25', 3, '1', 33090, '25', 'ENT', 'E', 'B', '13.00', '2023-05-05 02:54:36', '2023-05-09 18:09:27', '2.00', '2.00', NULL, NULL, NULL),
('2008-08-25', 3, '2', 33090, '25', 'ENT', 'E', 'B', '15.00', '2023-05-05 18:09:04', '2023-05-08 07:40:23', '2.00', '2.00', NULL, NULL, NULL),
('2008-08-25', 3, '3', 33090, '25', 'ENT', 'E', 'B', '15.80', '2023-05-05 06:41:10', '2023-05-07 06:22:10', '2.00', '2.00', NULL, NULL, NULL),
('2008-08-25', 3, '4', 33090, '25', 'ENT', 'E', 'B', '15.80', '2023-05-04 11:40:33', '2023-05-08 03:57:54', '7.00', '6.00', NULL, NULL, NULL),
('2008-08-25', 3, '5', 33090, '25', 'ENT', 'E', 'B', '13.80', '2023-05-07 17:40:03', '2023-05-10 18:00:43', '7.00', '6.00', NULL, NULL, NULL),
('2008-08-25', 3, '6', 33090, '25', 'ENT', 'E', 'B', '11.80', '2023-05-06 14:36:16', '2023-05-07 18:32:52', '7.00', '6.00', NULL, NULL, NULL),
('2008-08-25', 3, '7', 33090, '25', 'ENT', 'E', 'B', '15.80', '2023-05-04 22:28:46', '2023-05-07 22:17:54', '2.00', '2.00', NULL, NULL, NULL),
('2008-08-25', 11, '1', 33091, '25', 'ENT', 'E', 'F', '14.60', '2023-06-02 07:40:24', '2023-06-03 16:44:33', '2.00', '2.00', NULL, NULL, NULL),
('2008-08-25', 11, '2', 33091, '25', 'ENT', 'E', 'F', '15.60', '2023-05-07 15:28:45', '2023-06-02 21:25:37', '2.00', '2.00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `peche`
--

CREATE TABLE `peche` (
  `datePeche` date NOT NULL,
  `idBateau` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `peche`
--

INSERT INTO `peche` (`datePeche`, `idBateau`) VALUES
('2008-07-18', 1),
('2008-07-24', 1),
('2008-07-25', 1),
('2008-07-30', 1),
('2008-07-25', 3),
('2008-07-30', 3),
('2008-08-25', 3),
('2008-07-18', 4),
('2008-08-12', 5),
('2008-07-25', 7),
('2008-07-30', 7),
('2008-07-18', 9),
('2008-08-12', 9),
('2008-07-18', 11),
('2008-07-20', 11),
('2008-07-21', 11),
('2008-07-23', 11),
('2008-07-24', 11),
('2008-07-25', 11),
('2008-07-30', 11),
('2008-08-25', 11);

-- --------------------------------------------------------

--
-- Structure de la table `poster`
--

CREATE TABLE `poster` (
  `idDatePeche` date NOT NULL,
  `idBateau` int(10) UNSIGNED NOT NULL,
  `idLot` decimal(3,0) UNSIGNED NOT NULL,
  `idAcheteur` int(10) UNSIGNED NOT NULL,
  `prixEnchere` decimal(6,2) NOT NULL,
  `heureEnchere` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `presentation`
--

CREATE TABLE `presentation` (
  `id` char(3) NOT NULL,
  `libelle` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `presentation`
--

INSERT INTO `presentation` (`id`, `libelle`) VALUES
('ENT', 'Entier'),
('ET', 'Etété'),
('VID', 'Vidé');

-- --------------------------------------------------------

--
-- Structure de la table `qualite`
--

CREATE TABLE `qualite` (
  `id` char(1) NOT NULL,
  `libelle` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `qualite`
--

INSERT INTO `qualite` (`id`, `libelle`) VALUES
('A', 'Glacé'),
('B', 'Déclassé'),
('E', 'Extra');

-- --------------------------------------------------------

--
-- Structure de la table `taille`
--

CREATE TABLE `taille` (
  `id` decimal(2,0) NOT NULL,
  `specification` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `taille`
--

INSERT INTO `taille` (`id`, `specification`) VALUES
('10', 'Taille de 10'),
('15', 'Taille de 15'),
('20', 'Taille de 20'),
('25', 'Taille de 25'),
('30', 'Taille de 30'),
('35', 'Taille de 35'),
('40', 'Taille de 40'),
('45', 'Taille de 45'),
('50', 'Taille de 50'),
('55', 'Taille de 55'),
('60', 'Taille de 60'),
('65', 'Taille de 65'),
('70', 'Taille de 70'),
('75', 'Taille de 75'),
('80', 'Taille de 80'),
('85', 'Taille de 85'),
('90', 'Taille de 90'),
('95', 'Taille de 95');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `acheteur`
--
ALTER TABLE `acheteur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Index pour la table `bac`
--
ALTER TABLE `bac`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `bateau`
--
ALTER TABLE `bateau`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `espece`
--
ALTER TABLE `espece`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `etat`
--
ALTER TABLE `etat`
  ADD PRIMARY KEY (`code`);

--
-- Index pour la table `lot`
--
ALTER TABLE `lot`
  ADD PRIMARY KEY (`idDatePeche`,`idBateau`,`id`),
  ADD KEY `FK_LOT_ESPECE` (`idEspece`),
  ADD KEY `FK_LOT_TAILLE` (`idTaille`),
  ADD KEY `FK_LOT_PRESENTATION` (`idPresentation`),
  ADD KEY `FK_LOT_BAC` (`idBac`),
  ADD KEY `FK_LOT_ACHETEUR` (`idAcheteur`),
  ADD KEY `FK_LOT_QUALITE` (`idQualite`),
  ADD KEY `FK_LOT_CODEETAT` (`codeEtat`);

--
-- Index pour la table `peche`
--
ALTER TABLE `peche`
  ADD PRIMARY KEY (`datePeche`,`idBateau`),
  ADD KEY `FK_PECHE_BATEAU` (`idBateau`);

--
-- Index pour la table `poster`
--
ALTER TABLE `poster`
  ADD PRIMARY KEY (`idDatePeche`,`idBateau`,`idLot`,`idAcheteur`,`prixEnchere`),
  ADD KEY `FK_POSTER_ACHETEUR` (`idAcheteur`);

--
-- Index pour la table `presentation`
--
ALTER TABLE `presentation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `qualite`
--
ALTER TABLE `qualite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `taille`
--
ALTER TABLE `taille`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `acheteur`
--
ALTER TABLE `acheteur`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `lot`
--
ALTER TABLE `lot`
  ADD CONSTRAINT `FK_LOT_ACHETEUR` FOREIGN KEY (`idAcheteur`) REFERENCES `acheteur` (`id`),
  ADD CONSTRAINT `FK_LOT_BAC` FOREIGN KEY (`idBac`) REFERENCES `bac` (`id`),
  ADD CONSTRAINT `FK_LOT_ESPECE` FOREIGN KEY (`idEspece`) REFERENCES `espece` (`id`),
  ADD CONSTRAINT `FK_LOT_PECHE` FOREIGN KEY (`idDatePeche`,`idBateau`) REFERENCES `peche` (`datePeche`, `idBateau`),
  ADD CONSTRAINT `FK_LOT_PRESENTATION` FOREIGN KEY (`idPresentation`) REFERENCES `presentation` (`id`),
  ADD CONSTRAINT `FK_LOT_QUALITE` FOREIGN KEY (`idQualite`) REFERENCES `qualite` (`id`),
  ADD CONSTRAINT `FK_LOT_TAILLE` FOREIGN KEY (`idTaille`) REFERENCES `taille` (`id`),
  ADD CONSTRAINT `FK_LOT_CODEETAT` FOREIGN KEY (`codeEtat`) REFERENCES `etat` (`code`);

--
-- Contraintes pour la table `peche`
--
ALTER TABLE `peche`
  ADD CONSTRAINT `FK_PECHE_BATEAU` FOREIGN KEY (`idBateau`) REFERENCES `bateau` (`id`);

--
-- Contraintes pour la table `poster`
--
ALTER TABLE `poster`
  ADD CONSTRAINT `FK_POSTER_ACHETEUR` FOREIGN KEY (`idAcheteur`) REFERENCES `acheteur` (`id`),
  ADD CONSTRAINT `FK_POSTER_LOT` FOREIGN KEY (`idDatePeche`,`idBateau`,`idLot`) REFERENCES `lot` (`idDatePeche`, `idBateau`, `id`);

--
-- Événements
--

-- Active les événements MySQL
SET GLOBAL event_scheduler = ON;

-- Supprime l'événement s'il existe déjà
DROP EVENT IF EXISTS update_lot_codeEtat;
DROP EVENT IF EXISTS update_idAcheteur;

DELIMITER $$

CREATE DEFINER=`root`@`localhost` EVENT `update_lot_codeEtat` ON SCHEDULE EVERY 60 SECOND STARTS '2023-06-01 22:55:32' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
        UPDATE lot
    SET idAcheteur = NULL
    WHERE codeEtat IN ('P', 'E');
    
        UPDATE lot
    SET codeEtat = CASE
      WHEN NOW() < dateDebutEnchere THEN 'P'
      WHEN NOW() > dateFinEnchere THEN 'T'
      ELSE 'E'
    END;
  END$$

CREATE DEFINER=`root`@`localhost` EVENT `update_idAcheteur` ON SCHEDULE EVERY 30 SECOND STARTS '2023-06-01 22:55:32' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    UPDATE lot
    SET idAcheteur = (
      SELECT idAcheteur
      FROM poster
      WHERE idDatePeche = lot.idDatePeche
        AND idBateau = lot.idBateau
        AND idLot = lot.id
      ORDER BY prixEnchere DESC
      LIMIT 1
    )
    WHERE codeEtat = 'T';
  END$$

DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
