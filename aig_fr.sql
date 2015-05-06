-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 06 Mai 2015 à 21:56
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `aig_fr`
--

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id_album` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(50) NOT NULL,
  `release_date` date NOT NULL,
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `album`
--

INSERT INTO `album` (`id_album`, `album_name`, `release_date`) VALUES
(1, '??', '2015-05-06');

-- --------------------------------------------------------

--
-- Structure de la table `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `id_artist` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  PRIMARY KEY (`id_artist`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `artist`
--

INSERT INTO `artist` (`id_artist`, `name`, `firstname`) VALUES
(1, 'Go', 'tye');

-- --------------------------------------------------------

--
-- Structure de la table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('e8fa442123e0be6099d491fc27799335', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0', 1430934188, '');

-- --------------------------------------------------------

--
-- Structure de la table `music`
--

CREATE TABLE IF NOT EXISTS `music` (
  `id_music` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `path` varchar(500) NOT NULL,
  `lyrics` text NOT NULL,
  `id_artist` int(11) NOT NULL,
  `id_album` int(11) NOT NULL,
  PRIMARY KEY (`id_music`),
  KEY `id_artist` (`id_artist`),
  KEY `id_album` (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `music`
--

INSERT INTO `music` (`id_music`, `title`, `path`, `lyrics`, `id_artist`, `id_album`) VALUES
(1, 'Somebody That I Used To Know', 'local', '[Gotye:]\r\nNow and then I think of when we were together\r\nLike when you said you felt so happy you could die\r\nTold myself that you were right for me\r\nBut felt so lonely in your company\r\nBut that was love and it''s an ache I still remember\r\n\r\nYou can get addicted to a certain kind of sadness\r\nLike resignation to the end, always the end\r\nSo when we found that we could not make sense\r\nWell you said that we would still be friends\r\nBut I''ll admit that I was glad that it was over\r\n\r\nBut you didn''t have to cut me off\r\nMake out like it never happened and that we were nothing\r\nAnd I don''t even need your love\r\nBut you treat me like a stranger and that feels so rough\r\nNo you didn''t have to stoop so low\r\nHave your friends collect your records and then change your number\r\nI guess that I don''t need that though\r\nNow you''re just somebody that I used to know\r\n\r\nNow you''re just somebody that I used to know\r\nNow you''re just somebody that I used to know\r\n\r\n[Kimbra:]\r\nNow and then I think of all the times you screwed me over\r\nBut had me believing it was always something that I''d done\r\nBut I don''t wanna live that way\r\nReading into every word you say\r\nYou said that you could let it go\r\nAnd I wouldn''t catch you hung up on somebody that you used to know\r\n\r\n[Gotye:]\r\nBut you didn''t have to cut me off\r\nMake out like it never happened and that we were nothing\r\nAnd I don''t even need your love\r\nBut you treat me like a stranger and that feels so rough\r\nNo you didn''t have to stoop so low\r\nHave your friends collect your records and then change your number\r\nI guess that I don''t need that though\r\nNow you''re just somebody that I used to know\r\n\r\n[x2]\r\nSomebody\r\n(I used to know)\r\nSomebody\r\n(Now you''re just somebody that I used to know)\r\n\r\n(I used to know)\r\n(That I used to know)\r\n(I used to know)\r\nSomebody', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id_player` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `best_result` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id_player`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `player`
--

INSERT INTO `player` (`id_player`, `username`, `best_result`, `password`) VALUES
(1, 'Choudoor', 50, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `music_album` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`),
  ADD CONSTRAINT `music_artist` FOREIGN KEY (`id_artist`) REFERENCES `artist` (`id_artist`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
