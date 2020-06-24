-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 07 Janvier 2020 à 16:44
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `hotel_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `categorie`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 0);

-- --------------------------------------------------------

--
-- Structure de la table `chambres`
--

CREATE TABLE IF NOT EXISTS `chambres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL,
  `type_chambre` varchar(255) DEFAULT NULL,
  `ch_capacite` varchar(50) NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `ch_image` varchar(255) DEFAULT NULL,
  `ch_description` text NOT NULL,
  `ch_avantage` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `code_chambre` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `chambres`
--

INSERT INTO `chambres` (`id`, `hotel_id`, `type_chambre`, `ch_capacite`, `prix`, `ch_image`, `ch_description`, `ch_avantage`, `created_at`, `updated_at`, `code_chambre`) VALUES
(1, 2, 'chambre individuelle', 'deux person', '20000', 'bed-1846251__340.jpg', 'test test test test test c est modifier cet hôtel est très bien à vivre venez  y passer un séjour test 11', 'dîné et petit deujené', '2019-11-08 22:37:47', '2019-12-18 15:26:08', '1'),
(3, 4, 'chambre double', '4 personnes', '50000', 'image_(4)1.jpg', 'cette chambre est très aérée pouvant accueillir jusqu''à quatre personnes', 'dîné offert petit déjeuner offert visite touristique gratuit ', '2019-11-14 16:11:19', '0000-00-00 00:00:00', 'ci-001'),
(4, 4, 'chambre individuelle', 'duex personnes', '1500', 'hotel-room-1447201__340.jpg', 'test test', 'aucun', '2019-11-16 13:21:25', '0000-00-00 00:00:00', 'ci-001'),
(5, 3, 'chambre individuelle', '1 lit', '15000', '6.jpg', 'une chambre bien aérée avec un très grand lit confortable', 'aucun avantage n''est prévu pour cette chambre', '2019-12-02 13:15:17', '0000-00-00 00:00:00', 'civ-0001'),
(6, 3, 'chambre double', '2 lits', '25000', '42.jpg', 'cette chambre peu accueillir jusqu''à 5 personne d''une famille ', 'tous les avantages que notre établissement dispose pour nos clients', '2019-12-02 13:18:30', '0000-00-00 00:00:00', 'civ-0002'),
(7, 1, 'chambre individuelle', 'deux personnes', '20000', '3.jpg', 'cette chambre étant très aérée et peut accueillir deux personnes au maximum', 'petit déjeuné et dîné son offert par notre établissement pendant tous le séjour', '2019-12-02 13:21:30', '2019-12-02 13:21:53', 'civ-01A'),
(8, 1, 'chambre individuelle', 'un lit', '10000', 'hotel-4416515__3404.jpg', 'cette chambre est très grande', 'aucun avantage ', '2019-12-02 13:29:28', '0000-00-00 00:00:00', 'civ-02A');

-- --------------------------------------------------------

--
-- Structure de la table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_prenom` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `evenements`
--

CREATE TABLE IF NOT EXISTS `evenements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre_ev` varchar(255) NOT NULL,
  `date_ev` date NOT NULL,
  `description_ev` text NOT NULL,
  `image_ev` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `evenements`
--

INSERT INTO `evenements` (`id`, `titre_ev`, `date_ev`, `description_ev`, `image_ev`, `created_at`) VALUES
(1, 'aniversaire', '2019-11-30', 'cet événement aura lieu au bord de la mer à Assinie. avec des célébrités invitées nous vous attendons pour faire la fête ', '06.jpg', '2019-11-29 11:06:06');

-- --------------------------------------------------------

--
-- Structure de la table `hotels`
--

CREATE TABLE IF NOT EXISTS `hotels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `localite` varchar(255) NOT NULL,
  `categorie` int(255) NOT NULL,
  `capacite` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `telephone` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `hotels`
--

INSERT INTO `hotels` (`id`, `nom`, `localite`, `categorie`, `capacite`, `description`, `telephone`, `image`, `created_at`, `user_id`, `status`) VALUES
(1, 'ivoiretel ', 'abidjan', 5, '25 chambres', 'test test test test test c est modifier cet hôtel est très bien à vivre', 48027000, '51.jpg', '2019-11-05 16:00:01', 1, 0),
(2, 'totel', 'blabla', 4, '50 chambre', 'test test test test c''est juste ok', 48027000, 'hotel-1749602__340.jpg', '2019-11-07 15:24:16', 1, 0),
(3, 'Hotel Belle-lune', 'Dabou', 0, '250 chambres', 'L''Hôtel Carlton est situé au cœur de Tunis, à seulement 500 mètres de la Médina. Il propose un hébergement 3 étoiles, un service d''étage et une connexion Wi-Fi gratuite. Établissement réservé 2 fois il y a moins de 1 heure', 220480000, 'bg14.jpg', '2019-11-12 17:16:16', 1, 0),
(4, 'vivons ensemble hôtel', 'Abidjan', 5, '350 chambres', 'cet hôtel est un haut standing un hôtel cinq étoile ', 22100000, 'image_(6).jpg', '2019-11-14 13:29:12', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `publicite`
--

CREATE TABLE IF NOT EXISTS `publicite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `web` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `publicite`
--

INSERT INTO `publicite` (`id`, `nom`, `web`, `image`, `description`, `created_at`, `is_active`, `updated_at`) VALUES
(1, 'avance ', 'www.toget.pro', 'icon3.png', 'test', '2020-01-06 00:09:02', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `nom_person` varchar(255) NOT NULL,
  `date_arrive` datetime NOT NULL,
  `date_depart` datetime NOT NULL,
  `type_chambre` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `email_person` varchar(255) NOT NULL,
  `nombre_ch` int(11) NOT NULL,
  `phone_person` varchar(255) NOT NULL,
  `prix_chambre` int(11) NOT NULL,
  `categorie` varchar(255) NOT NULL,
  `localite` varchar(255) NOT NULL,
  `nombre_person` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `reservation`
--

INSERT INTO `reservation` (`id`, `nom`, `nom_person`, `date_arrive`, `date_depart`, `type_chambre`, `is_active`, `email_person`, `nombre_ch`, `phone_person`, `prix_chambre`, `categorie`, `localite`, `nombre_person`, `created_at`) VALUES
(2, 'Hotel Belle-lune', 'Gouandje bi Boris Sylvanus', '2019-11-14 00:00:00', '2019-11-15 00:00:00', '', 0, 'gouandje@gmail.com', 2, '+22548027000', 25000, 'hôtel quatre étoiles', 'Dabou', '', '2019-11-14 00:20:25'),
(3, 'ivoiretel ', 'boris ', '2019-12-28 00:00:00', '2019-12-29 00:00:00', 'chambre individuelle', 1, 'boris@gmail.com', 1, '480270000', 60000, '5', 'abidjan', '1', '2019-12-20 13:20:34');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=Active | 0=Inactive ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `phone`, `created`, `modified`, `status`) VALUES
(1, 'admin', 'boris', 'gouandje@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '22208004', '2019-11-04 16:29:08', '2019-11-04 16:29:08', 1),
(2, 'boris', 'sylvanus', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '48027000', '2019-11-06 02:40:14', '2019-11-06 02:40:14', 1);
--
-- Base de données :  `test`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
