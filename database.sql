-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  pdb3.awardspace.net
-- Généré le :  Sam 26 Mai 2018 à 04:01
-- Version du serveur :  5.7.20-log
-- Version de PHP :  5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `566979_at`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomAdmin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `emailAdmin` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nomAdmin`, `emailAdmin`) VALUES
(1, 'admin', '$2y$13$UBgOsbFcofuVPZaWZBBqBeSBXTyE68UeXpPMad1/tHh.5MMagevGi', 'Administrateur', 'admin@admin.com');

-- --------------------------------------------------------

--
-- Structure de la table `annonceur`
--

CREATE TABLE `annonceur` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_annonceur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `num_annonceur` int(11) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_annonceur` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomAnnonceur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prenomAnnonceur` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `annonceur`
--

INSERT INTO `annonceur` (`id`, `username`, `email_annonceur`, `num_annonceur`, `password`, `image_annonceur`, `nomAnnonceur`, `prenomAnnonceur`, `confirmed`) VALUES
(4, 'rabii96', 'rabibenyoussef@hotmail.fr', 96536335, '$2y$13$JmrRn4ZJJseUwl3Nk/TGCOfqU3apS1UQvZju351bK7WJFTD3CQ6w2', '5055072682e1dbc295754f4352d1a27c.jpeg', 'Ben Youssef', 'Rabï', 1),
(9, 'marwan', 'marwanslim@gmail.com', 28213784, '$2y$13$pcu0vpFwoWHLJu3ZW9XCyecBxi42T5Qw.mJl9nYMM6B4HTdta5n8y', '30fb6540860e17767a0cc5431b19bdb0.jpeg', 'Slim', 'Marwan', 1),
(28, 'ramzi', 'hajjaji.ramzi@gmail.com', 55445546, '$2y$13$3XzKPH8VhmeEezM39.T3gOXuHgr3CJriKA0NP.xOKXCA2wIEuFDfa', 'defaut.png', 'Ramzi', 'HAJJAJI', 1),
(31, 'testConfirm', 'confirmer-compte@live.fr', NULL, '$2y$13$zYIEjM/QBhLmoMSpNfegn.Qk.e6DapzB7gV1SDC83H0/pa7CP1O22', 'defaut.png', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `archive`
--

CREATE TABLE `archive` (
  `id` int(11) NOT NULL,
  `nomprod` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_ajout` datetime NOT NULL,
  `date_suppression` datetime NOT NULL,
  `region` int(11) DEFAULT NULL,
  `id_annonceur` int(11) DEFAULT NULL,
  `categorie` int(11) DEFAULT NULL,
  `ville` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sousCategorie` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `archive`
--

INSERT INTO `archive` (`id`, `nomprod`, `prix`, `description`, `image`, `date_ajout`, `date_suppression`, `region`, `id_annonceur`, `categorie`, `ville`, `type`, `sousCategorie`) VALUES
(15, 'test', 10, 'test', 'ed0d0be7f1af8f5208498e8024e4568b.jpeg', '2018-05-23 12:56:28', '2018-05-23 14:15:07', 1, 4, 10, 96, 'Offre', 10);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nomCategorie` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nomCategorie`, `image`) VALUES
(0, 'Autre', 'autre.png'),
(1, 'Vêtements', 'Vetements.png'),
(6, 'Machines', 'machines.png'),
(7, 'Emploi', 'offre_emploi.png'),
(8, 'Outils', 'outils.png'),
(9, 'Usines', 'usines.png'),
(10, 'Fils', '7a09c0078a387d05dc5b7bf475d9d78c.png');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `nomprod` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_annonceur` int(11) DEFAULT NULL,
  `categorie` int(11) DEFAULT NULL,
  `region` int(11) DEFAULT NULL,
  `date_ajout` datetime NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sousCategorie` int(11) DEFAULT NULL,
  `ville` int(11) DEFAULT NULL,
  `afficherNum` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id`, `nomprod`, `prix`, `description`, `image`, `id_annonceur`, `categorie`, `region`, `date_ajout`, `type`, `sousCategorie`, `ville`, `afficherNum`) VALUES
(41, 'Pantallon filles', 35, 'Pantallon filles rose', 'aeb9ca4ac64f6fd79f6bb810747f2e22.jpeg', 9, 1, 15, '2018-02-18 11:21:00', 'Offre', 2, 137, 1),
(44, 'T-Shirt Shiva the power', 40, 'T-Shirt Shiva the power, disponible en gros ou en détails.\r\nTailles disponibles: de S jusqu\'à XL', '19e9acb4c1f412ea0105f469a216ab1e.jpeg', 4, 1, 15, '2018-02-13 12:00:00', 'Offre', 4, 149, 1),
(45, 'T-Shirt bleu', 25, 'T-Shirt bleu uni', 'eac8a5ab5b2348a709c1bb0ecc5a83f2.jpeg', 9, 1, 7, '2018-02-15 09:37:00', 'Offre', 4, 58, 1),
(46, 'Chemise', 25, 'Chemise bleu clair', '5d49982953b4500b7b1649266fb53c24.png', 9, 1, 9, '2018-02-18 11:00:00', 'Offre', 1, 78, 1),
(47, 'Pantallon', 25, 'Pantallon gris', 'dd1006750a26566e462886167a32a092.jpeg', 9, 1, 18, '2018-02-16 11:19:00', 'Offre', 2, 216, 1),
(48, 'Pantallon adidas', 25, 'Pantallon sport adidas bleu', 'b5c2e93ac2caea09bb7d63c43b40477f.jpeg', 4, 1, 17, '2018-02-15 20:24:00', 'Offre', 2, 194, 1),
(49, 'Pantallon nike', 25, 'Pantallon sport Nike gris', 'ddd4c59f25cfb11a002e1d5289c6d02a.jpeg', 4, 1, 15, '2018-02-16 13:23:00', 'Offre', 2, 137, 1),
(50, 'Pantallon sport', 25, 'Pantallon sport Nike noir', '26b7771aa0d8dc75421a4d5200a46ccf.png', 4, 1, 7, '2018-02-18 05:41:00', 'Offre', 2, 58, 1),
(51, 'Robe', 50, 'Robe noire taille S', '5aced017eb69cec647da6140e2939047.jpeg', 9, 1, 6, '2018-02-17 14:15:00', 'Offre', 3, 48, 1),
(52, 'Robe rouge', 30, 'Robe rouge taille M', '5f2ace3efb7b80496047c140b4b68204.jpeg', 4, 1, 10, '2018-02-18 06:20:00', 'Offre', 3, 91, 1),
(53, 'Robe rose', 40, 'Robe rose 12 ans', 'e443067afc77530afc0ca1c587744492.jpeg', 9, 1, 15, '2018-02-17 15:38:00', 'Offre', 3, 137, 1),
(54, 'Robe grise', 35, 'Robe grise enfant', '40019d0dabe13e1ae04849575f67de55.jpeg', 9, 1, 1, '2018-02-18 08:14:00', 'Offre', 3, 97, 1),
(55, 'Chemise femme', 40, 'Chemise femme rose clair', '94ea3317934062d76423c8f0324fa4c6.jpeg', 4, 1, 3, '2018-02-17 10:47:00', 'Offre', 1, 11, 1),
(56, 'Chemise femme', 33, 'Chemise femme rose', 'ac94ef8457ccfda0d7941f19042947cc.jpeg', 9, 1, 7, '2018-02-18 08:26:00', 'Offre', 1, 59, 1),
(57, 'Chemise femme noire', 33, 'Chemise femme noire tailles disponibles: S => L', '216743a866c95e940cbcab261c3b93cc.jpeg', 4, 1, 23, '2018-02-18 14:50:00', 'Offre', 1, 266, 1),
(58, 'T-Shirt femme', 25, 'T-Shirt femme gris, tailles disponibles: S => L', '6f35c604068b96ae1388cb5262ee87d8.png', 9, 1, 17, '2018-02-19 01:00:00', 'Offre', 4, 193, 1),
(59, 'T-Shirt rose', 30, 'T-Shirt femme rose, tailles disponibles: S et M', '9b3936e324ec0c840861a6fc38ffb5c7.jpeg', 4, 1, 23, '2018-02-19 03:00:00', 'Offre', 4, 266, 1),
(61, 'Machine à coudre', 120, 'Machine à coudre bonne occasion utilisée pendant 1 mois', '0a2eae8fe40801ce101c681586cfdb7b.jpeg', 4, 6, 20, '2018-02-24 04:57:23', 'Offre', 6, 239, 1),
(63, 'Outils de couture', 25, 'Outils de couture jamais servi', '6cf24250abaf52cd23c6f551b0a45c5e.jpeg', 4, 8, 17, '2018-02-24 05:02:09', 'Offre', 7, 194, 1),
(64, 'مطلوب عاملات', 380, 'مطلوب عاملات بمعمل خياطة في مدينة المنستير', '49cc09b6e2df9e6c0b4873e4fb64377f.jpeg', 4, 7, 15, '2018-02-24 05:10:25', 'Offre', 8, 149, 1),
(68, 'Recherche d\'outils', 70, 'Je cherche des outils de couture prix max 70 DT', '38472169361028e772d37e1ce611d059.jpeg', 4, 8, 14, '2018-03-20 16:46:51', 'Demande', 7, 129, 1),
(78, 'tricot benetton', 30, 'tesssssssssssssssssst', '268d5a3a2cea02906644fc4e68f4b011.jpeg', 28, 1, 15, '2018-05-22 16:00:24', 'Offre', 4, 137, 1);

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id` int(11) NOT NULL,
  `nomRegion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `region`
--

INSERT INTO `region` (`id`, `nomRegion`) VALUES
(1, 'Ariana'),
(2, 'Béja'),
(3, 'Ben Arous'),
(4, 'Bizerte'),
(5, 'Gabès'),
(6, 'Gafsa'),
(7, 'Jendouba'),
(8, 'Kairouan'),
(9, 'Kasserine'),
(10, 'Kébili'),
(13, 'La Manouba'),
(11, 'Le Kef'),
(12, 'Mahdia'),
(14, 'Médenine'),
(15, 'Monastir'),
(16, 'Nabeul'),
(17, 'Sfax'),
(18, 'Sidi Bouzid'),
(19, 'Siliana'),
(20, 'Sousse'),
(21, 'Tataouine'),
(22, 'Tozeur'),
(23, 'Tunis'),
(24, 'Zaghouan');

-- --------------------------------------------------------

--
-- Structure de la table `reglages`
--

CREATE TABLE `reglages` (
  `id` int(11) NOT NULL,
  `publicite` tinyint(1) NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `reglages`
--

INSERT INTO `reglages` (`id`, `publicite`, `nom`) VALUES
(2, 0, 'Horizentale'),
(3, 0, 'Verticale');

-- --------------------------------------------------------

--
-- Structure de la table `sous_categorie`
--

CREATE TABLE `sous_categorie` (
  `id` int(11) NOT NULL,
  `categorie` int(11) DEFAULT NULL,
  `nomSousCategorie` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `sous_categorie`
--

INSERT INTO `sous_categorie` (`id`, `categorie`, `nomSousCategorie`) VALUES
(1, 1, 'Chemise'),
(2, 1, 'Pantalon'),
(3, 1, 'Robe'),
(4, 1, 'T-Shirt'),
(6, 6, 'Machines'),
(7, 8, 'Outils'),
(8, 7, 'Emploi'),
(9, 9, 'Usines'),
(10, 10, 'Fils'),
(11, 0, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id` int(11) NOT NULL,
  `region` int(11) DEFAULT NULL,
  `nomVille` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `ville`
--

INSERT INTO `ville` (`id`, `region`, `nomVille`) VALUES
(1, 2, 'Beja'),
(2, 2, 'Medjez el-Bab'),
(3, 2, 'Testour'),
(4, 2, 'Teboursouk'),
(5, 2, 'El Maagoula'),
(6, 2, 'Nefza'),
(7, 2, 'Amdoun'),
(8, 2, 'Goubellat'),
(9, 2, 'Thibar'),
(10, 3, 'Mohamedia-Fouchana'),
(11, 3, 'El Mourouj'),
(12, 3, 'Rades'),
(13, 3, 'Ben Arous'),
(14, 3, 'Hammam Lif'),
(15, 3, 'Bou Mhel el-Bassatine'),
(16, 3, 'Ezzahra'),
(17, 3, 'Hammam Chott'),
(18, 3, 'Mornag'),
(19, 3, 'Megrine'),
(20, 3, 'Khalidia'),
(21, 4, 'Bizerte'),
(22, 4, 'Menzel Bourguiba'),
(23, 4, 'Mateur'),
(24, 4, 'Ras Jebel'),
(25, 4, 'Menzel Jemil'),
(26, 4, 'Tinja'),
(27, 4, 'Menzel Abderrahmane'),
(28, 4, 'El Alia'),
(29, 4, 'Metline'),
(30, 4, 'Raf Raf'),
(31, 4, 'Sejnane'),
(32, 4, 'Ghar El Melh'),
(33, 4, 'Aousja'),
(34, 4, 'Ghezala'),
(35, 4, 'Joumine'),
(36, 4, 'Utique'),
(37, 5, 'Gabes'),
(38, 5, 'El Hamma'),
(39, 5, 'Ghannouch'),
(40, 5, 'Chenini Nahal'),
(41, 5, 'Mareth'),
(42, 5, 'Metouia'),
(43, 5, 'Oudhref'),
(44, 5, 'Nouvelle Matmata'),
(45, 5, 'Zarat'),
(46, 5, 'Matmata'),
(47, 5, 'Menzel El Habib'),
(48, 6, 'Gafsa'),
(49, 6, 'Metlaoui'),
(50, 6, 'El Ksar'),
(51, 6, 'Redeyef'),
(52, 6, 'Moulares'),
(53, 6, 'El Guettar'),
(54, 6, 'Mdhilla'),
(55, 6, 'Sened'),
(56, 6, 'Belkhir'),
(57, 6, 'Sidi Aich'),
(58, 7, 'Jendouba'),
(59, 7, 'Bou Salem'),
(60, 7, 'Tabarka'),
(61, 7, 'Ghardimaou'),
(62, 7, 'Ain Draham'),
(63, 7, 'Fernana'),
(64, 7, 'Oued Meliz'),
(65, 7, 'Beni MTir'),
(66, 8, 'Kairouan'),
(67, 8, 'Hajeb El Ayoun'),
(68, 8, 'Oueslatia'),
(69, 8, 'Haffouz'),
(70, 8, 'Sbikha'),
(71, 8, 'Bou Hajla'),
(72, 8, 'Nasrallah'),
(73, 8, 'Menzel Mehiri'),
(74, 8, 'El Alaa'),
(75, 8, 'Chebika'),
(76, 8, 'Ain Djeloula'),
(77, 8, 'Echrarda'),
(78, 9, 'Kasserine'),
(79, 9, 'Feriana'),
(80, 9, 'Sbeitla'),
(81, 9, 'Thala'),
(82, 9, 'Foussana'),
(83, 9, 'Thelepte'),
(84, 9, 'Sbiba'),
(85, 9, 'Majel Bel Abbes'),
(86, 9, 'Jedelienne'),
(87, 9, 'Haidra'),
(88, 9, 'El Ayoun'),
(89, 9, 'Ezzouhour'),
(90, 9, 'Hassi El Ferid'),
(91, 10, 'Kebili'),
(92, 10, 'Douz'),
(93, 10, 'Souk Lahad'),
(94, 10, 'Jemna'),
(95, 10, 'Faouar'),
(96, 1, 'Ettadhamen-Mnihla'),
(97, 1, 'Ariana'),
(98, 1, 'Raoued'),
(99, 1, 'Kalaat el-Andalous'),
(100, 1, 'Sidi Thabet'),
(101, 13, 'Douar Hicher'),
(102, 13, 'Oued Ellil'),
(103, 13, 'Manouba'),
(104, 13, 'Djedeida'),
(105, 13, 'Tebourba'),
(106, 13, 'Den Den'),
(107, 13, 'Mornaguia'),
(108, 13, 'Borj El Amri'),
(109, 13, 'El Batan'),
(110, 12, 'Mahdia'),
(111, 12, 'Ksour Essef'),
(112, 12, 'Chebba'),
(113, 12, 'El Jem'),
(114, 12, 'Rejiche'),
(115, 12, 'Sidi Alouane'),
(116, 12, 'Kerker'),
(117, 12, 'El Bradaa'),
(118, 12, 'Mellouleche'),
(119, 12, 'Chorbane'),
(120, 12, 'Essouassi'),
(121, 12, 'Ouled Chamekh'),
(122, 12, 'Bou Merdes'),
(123, 12, 'Hebira'),
(124, 12, 'Hkaima'),
(125, 12, 'Hkaima'),
(126, 12, 'Sidi Zid'),
(127, 12, 'Tlelsa'),
(128, 12, 'Zelba'),
(129, 14, 'Djerba - Houmt Souk'),
(130, 14, 'Zarzis'),
(131, 14, 'Medenine'),
(132, 14, 'Ben Gardane'),
(133, 14, 'Djerba - Midoun'),
(134, 14, 'Djerba - Ajim'),
(135, 14, 'Sidi Makhlouf'),
(136, 14, 'Beni Khedache'),
(137, 15, 'Monastir'),
(138, 15, 'Moknine'),
(139, 15, 'Jemmal'),
(140, 15, 'Ksar Hellal'),
(141, 15, 'Teboulba'),
(142, 15, 'Ouerdanine'),
(143, 15, 'Sahline Mootmar'),
(144, 15, 'Bekalta'),
(145, 15, 'Zeramdine'),
(146, 15, 'Bembla'),
(147, 15, 'Bennane-Bodheur'),
(148, 15, 'Ksibet el-Mediouni'),
(149, 15, 'Sayada'),
(150, 15, 'Menzel Hayet'),
(151, 15, 'Menzel Ennour'),
(152, 15, 'Khniss'),
(153, 15, 'Beni Hassen'),
(154, 15, 'Menzel Kamel'),
(155, 15, 'Sidi Ameur'),
(156, 15, 'Amiret Hajjaj'),
(157, 15, 'Touza'),
(158, 15, 'Zaouiet Kontoch'),
(159, 15, 'Amiret Touazra'),
(160, 15, 'Bouhjar'),
(161, 15, 'Lamta'),
(162, 15, 'Amiret El Fhoul'),
(163, 15, 'El Ghnada'),
(164, 15, 'El Masdour'),
(165, 15, 'Sidi Bennour'),
(166, 15, 'Cherahil'),
(167, 15, 'Menzel Fersi'),
(168, 16, 'Nabeul'),
(169, 16, 'Hammamet'),
(170, 16, 'Kelibia'),
(171, 16, 'Dar Chaabane'),
(172, 16, 'Menzel Temime'),
(173, 16, 'Korba'),
(174, 16, 'Soliman	'),
(175, 16, 'Grombalia'),
(176, 16, 'Takelsa'),
(177, 16, 'Beni Khiar'),
(178, 16, 'Menzel Bouzelfa'),
(179, 16, 'Beni Khalled'),
(180, 16, 'Bou Argoub'),
(181, 16, 'El Haouaria'),
(182, 16, 'Tazarka'),
(183, 16, 'Hammam Ghezeze'),
(184, 16, 'El Maamoura'),
(185, 16, 'Zaouiet Djedidi	'),
(186, 16, 'Somaa'),
(187, 16, 'Menzel Horr'),
(188, 16, 'Azmour'),
(189, 16, 'Dar Allouch'),
(190, 16, 'El Mida'),
(191, 16, 'El Mida'),
(192, 16, 'Korbous'),
(193, 17, 'Sfax'),
(194, 17, 'Sakiet Ezzit'),
(195, 17, 'Sakiet Eddaier'),
(196, 17, 'El Ain'),
(197, 17, 'Gremda'),
(198, 17, 'Thyna'),
(199, 17, 'Chihia'),
(200, 17, 'Mahres'),
(201, 17, 'Kerkennah'),
(202, 17, 'Skhira'),
(203, 17, 'Agareb'),
(204, 17, 'El Hencha'),
(205, 17, 'Jebiniana'),
(206, 17, 'Bir Ali Ben Khalifa'),
(207, 17, 'Graiba'),
(208, 17, 'Menzel Chaker'),
(209, 17, 'El Amra'),
(210, 17, 'Aachech'),
(211, 17, 'Ennasr'),
(212, 17, 'Hadjeb'),
(213, 17, 'Hazeg Ellouza'),
(214, 17, 'Nadhour Sidi Ali Ben Abed'),
(215, 17, 'Ouabed Khazanet'),
(216, 18, 'Sidi Bouzid'),
(217, 18, 'Meknassy'),
(218, 18, 'Regueb'),
(219, 18, 'Sidi Ali Ben Aoun'),
(220, 18, 'Mezzouna'),
(221, 18, 'Menzel Bouzaiane'),
(222, 18, 'Bir El Hafey'),
(223, 18, 'Jilma'),
(224, 18, 'Cebbala Ouled Asker'),
(225, 18, 'Ouled Haffouz'),
(226, 18, 'Essaida'),
(227, 18, 'Souk Jedid'),
(228, 19, 'Siliana'),
(229, 19, 'Makthar'),
(230, 19, 'Bou Arada'),
(231, 19, 'Gaafour'),
(232, 19, 'El Krib'),
(233, 19, 'Bargou'),
(234, 19, 'Rouhia'),
(235, 19, 'Sidi Bou Rouis'),
(236, 19, 'El Aroussa'),
(237, 19, 'Kesra'),
(238, 20, 'Sousse'),
(239, 20, 'Msaken'),
(240, 20, 'Kalaa Kebira'),
(241, 20, 'Hammam Sousse'),
(242, 20, 'Kalaa Seghira'),
(243, 20, 'Akouda'),
(244, 20, 'Zaouiet Sousse'),
(245, 20, 'Ezzouhour'),
(246, 20, 'Messaadine'),
(247, 20, 'Ksibet Thrayet'),
(248, 20, 'Enfida'),
(249, 20, 'Sidi Bou Ali'),
(250, 20, 'Bouficha'),
(251, 20, 'Hergla'),
(252, 20, 'Kondar'),
(253, 20, 'Sidi El Hani'),
(254, 21, 'Tataouine'),
(255, 21, 'Ghomrassen'),
(256, 21, 'Bir Lahmar'),
(257, 21, 'Remada'),
(258, 21, 'Dehiba'),
(259, 21, 'Smar'),
(260, 22, 'Tozeur'),
(261, 22, 'Nefta'),
(262, 22, 'Degache'),
(263, 22, 'El Hamma du Jerid'),
(264, 22, 'Hazoua'),
(265, 22, 'Tamerza	'),
(266, 23, 'Tunis'),
(267, 23, 'Sidi Hassine'),
(268, 23, 'La Marsa'),
(269, 23, 'Le Kram'),
(270, 23, 'Le Bardo'),
(271, 23, 'La Goulette'),
(272, 23, 'Carthage'),
(273, 23, 'Sidi Bou Said'),
(274, 24, 'Zaghouan'),
(275, 24, 'El Fahs'),
(276, 24, 'Zriba'),
(277, 24, 'Bir Mcherga'),
(278, 24, 'Nadhour'),
(279, 24, 'Djebel Oust'),
(280, 24, 'Djebel Oust'),
(281, 24, 'Saouaf'),
(282, 11, 'Le Kef'),
(283, 11, 'Tajerouine'),
(284, 11, 'Dahmani'),
(285, 11, 'Sers'),
(286, 11, 'Jerissa'),
(287, 11, 'Kalaat Senan'),
(288, 11, 'Sakiet Sidi Youssef'),
(289, 11, 'El Ksour'),
(290, 11, 'Nebeur'),
(291, 11, 'Kalaat Khasba'),
(292, 11, 'Touiref'),
(293, 11, 'Menzel Salem');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_880E0D76F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_880E0D768BDC72EC` (`emailAdmin`);

--
-- Index pour la table `annonceur`
--
ALTER TABLE `annonceur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E795BC5EE89E2375` (`email_annonceur`),
  ADD UNIQUE KEY `UNIQ_E795BC5EF85E0677` (`username`);

--
-- Index pour la table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D5FC5D9CF62F176` (`region`),
  ADD KEY `IDX_D5FC5D9C67A00079` (`id_annonceur`),
  ADD KEY `IDX_D5FC5D9C497DD634` (`categorie`),
  ADD KEY `IDX_D5FC5D9CED0225A2` (`sousCategorie`),
  ADD KEY `IDX_D5FC5D9C43C3D9C3` (`ville`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_497DD6347006D47E` (`nomCategorie`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC2767A00079` (`id_annonceur`),
  ADD KEY `IDX_29A5EC27497DD634` (`categorie`),
  ADD KEY `IDX_29A5EC27F62F176` (`region`),
  ADD KEY `IDX_29A5EC27ED0225A2` (`sousCategorie`),
  ADD KEY `IDX_29A5EC2743C3D9C3` (`ville`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_F62F176280E8449` (`nomRegion`);

--
-- Index pour la table `reglages`
--
ALTER TABLE `reglages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_46E7DCF6C6E55B5` (`nom`);

--
-- Index pour la table `sous_categorie`
--
ALTER TABLE `sous_categorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_52743D7B497DD634` (`categorie`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_43C3D9C3F62F176` (`region`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `annonceur`
--
ALTER TABLE `annonceur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT pour la table `archive`
--
ALTER TABLE `archive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT pour la table `reglages`
--
ALTER TABLE `reglages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `sous_categorie`
--
ALTER TABLE `sous_categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=294;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `archive`
--
ALTER TABLE `archive`
  ADD CONSTRAINT `FK_D5FC5D9C43C3D9C3` FOREIGN KEY (`ville`) REFERENCES `ville` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D5FC5D9C497DD634` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `FK_D5FC5D9C67A00079` FOREIGN KEY (`id_annonceur`) REFERENCES `annonceur` (`id`),
  ADD CONSTRAINT `FK_D5FC5D9CED0225A2` FOREIGN KEY (`sousCategorie`) REFERENCES `sous_categorie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D5FC5D9CF62F176` FOREIGN KEY (`region`) REFERENCES `region` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC2743C3D9C3` FOREIGN KEY (`ville`) REFERENCES `ville` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_29A5EC27497DD634` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_29A5EC2767A00079` FOREIGN KEY (`id_annonceur`) REFERENCES `annonceur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_29A5EC27ED0225A2` FOREIGN KEY (`sousCategorie`) REFERENCES `sous_categorie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_29A5EC27F62F176` FOREIGN KEY (`region`) REFERENCES `region` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sous_categorie`
--
ALTER TABLE `sous_categorie`
  ADD CONSTRAINT `FK_52743D7B497DD634` FOREIGN KEY (`categorie`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `FK_43C3D9C3F62F176` FOREIGN KEY (`region`) REFERENCES `region` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
