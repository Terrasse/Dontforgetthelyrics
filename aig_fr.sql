-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 06 Mai 2015 à 18:27
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
('89ef9cb6ed99ed616d79c96f919c8065', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0', 1430929566, 'a:3:{s:9:"user_data";s:0:"";s:9:"id_player";s:1:"1";s:9:"connected";b:1;}'),
('e6cfd482e5c8cfa22b96da863f94728e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0', 1430923724, ''),
('fa90cbf272c7cf31f4cc24d5c719b1b6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0', 1430924781, ''),
('fbfb44eed26a350d004741701186c49b', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0', 1430923725, '');

-- --------------------------------------------------------

--
-- Structure de la table `music`
--

CREATE TABLE IF NOT EXISTS `music` (
  `id_music` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `lyrics` text NOT NULL,
  PRIMARY KEY (`id_music`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `music`
--

INSERT INTO `music` (`id_music`, `title`, `lyrics`) VALUES
(1, 'Somebody That I Used To Know', '[Gotye:]\r\nNow and then I think of when we were together\r\nLike when you said you felt so happy you could die\r\nTold myself that you were right for me\r\nBut felt so lonely in your company\r\nBut that was love and it''s an ache I still remember\r\n\r\nYou can get addicted to a certain kind of sadness\r\nLike resignation to the end, always the end\r\nSo when we found that we could not make sense\r\nWell you said that we would still be friends\r\nBut I''ll admit that I was glad that it was over\r\n\r\nBut you didn''t have to cut me off\r\nMake out like it never happened and that we were nothing\r\nAnd I don''t even need your love\r\nBut you treat me like a stranger and that feels so rough\r\nNo you didn''t have to stoop so low\r\nHave your friends collect your records and then change your number\r\nI guess that I don''t need that though\r\nNow you''re just somebody that I used to know\r\n\r\nNow you''re just somebody that I used to know\r\nNow you''re just somebody that I used to know\r\n\r\n[Kimbra:]\r\nNow and then I think of all the times you screwed me over\r\nBut had me believing it was always something that I''d done\r\nBut I don''t wanna live that way\r\nReading into every word you say\r\nYou said that you could let it go\r\nAnd I wouldn''t catch you hung up on somebody that you used to know\r\n\r\n[Gotye:]\r\nBut you didn''t have to cut me off\r\nMake out like it never happened and that we were nothing\r\nAnd I don''t even need your love\r\nBut you treat me like a stranger and that feels so rough\r\nNo you didn''t have to stoop so low\r\nHave your friends collect your records and then change your number\r\nI guess that I don''t need that though\r\nNow you''re just somebody that I used to know\r\n\r\n[x2]\r\nSomebody\r\n(I used to know)\r\nSomebody\r\n(Now you''re just somebody that I used to know)\r\n\r\n(I used to know)\r\n(That I used to know)\r\n(I used to know)\r\nSomebody');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
