-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 10 Mai 2015 à 11:14
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `aig_fr`
--

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id_album` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `album`
--

INSERT INTO `album` (`id_album`, `album_name`) VALUES
(1, 'A Tribute To The Beatles');

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
(1, 'The Beatles Recovered Band', '');

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
('08174a6def34efdb0e7d28d0f499783d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0', 1431256331, 'a:3:{s:9:"user_data";s:0:"";s:9:"id_player";s:1:"2";s:9:"connected";b:1;}'),
('cedc8fab5c279b53412c94ffb83d8ac9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0', 1431165421, 'a:3:{s:9:"user_data";s:0:"";s:9:"id_player";s:1:"2";s:9:"connected";b:1;}');

-- --------------------------------------------------------

--
-- Structure de la table `music`
--

CREATE TABLE IF NOT EXISTS `music` (
  `id_music` int(11) NOT NULL AUTO_INCREMENT,
  `id_spotify` varchar(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `path` varchar(500) NOT NULL,
  `lyrics` text NOT NULL,
  `id_album` int(11) NOT NULL,
  PRIMARY KEY (`id_music`),
  KEY `music_album` (`id_album`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `music`
--

INSERT INTO `music` (`id_music`, `id_spotify`, `title`, `path`, `lyrics`, `id_album`) VALUES
(1, '7hBPm2JQwxHwMqw79MwWwm', 'Hey Jude', '', 'Hey Jude, don''t make it bad<br>Take a sad song and make it better<br>Remember to let her into your heart<br>Then you can start to make it better<br>Hey Jude, don''t be afraid<br>You were made to go out and get her<br>The minute you let her under your skin<br>Then you begin to make it better<br>And any time you feel the pain<br>Hey Jude, refrain<br>Don''t carry the world upon your shoulder<br>For well you know that it''s a fool<br>Who plays it cool<br>By making his world a little colder<br>Na na na naa-naa<br>na-na-naa naaa<br>Hey Jude, don''t let me down<br>You have found her, now go and get her<br>(Let it out and let it in)<br>Remember (hey Jude) to let her into your heart<br>Then you can start to make it better<br>So let it out and let it in<br>Hey Jude, begin<br>You''re waiting for someone to perform with<br>And don''t you know that it''s just you<br>Hey Jude, you''ll do<br>The movement you need is on your shoulder<br>Na na na naa-naa<br>na-na-naa naaa<br>Yeah<br>Hey, Jude, don''t make it bad<br>Take a sad song<br>And make it better<br>Remember to let her under your skin (got the wrong chord!)<br>Then you begin (fucking hell)<br>To make it better<br>Better, better, better, better, (I''m begging you) better<br>Whoa!<br>Yeah<br>Na na na na-na-na-naa (yeah, yeah, yeah, yeah, yeah, yeah)<br>Na-na-na-naa, hey, Jude<br>Na na na na-na-na-naa<br>Na-na-na-naa, hey, Jude<br>Na na na na-na-na-naa<br>Na-na-na-naa, hey, Jude<br>Na na na na-na-na-naa<br>Na-na-na-naa, hey, Jude<br>Jude, Judy, Judy, Judy, Judy, Judy<br>Ow! wow!<br>Na na na na-na-na-naa<br>Ow, ooh, my, my, my<br>Na-na-na-naa, hey, Jude<br>Jude, Jude, Jude, Jude, Jude<br>Na na na na-na-na-naa<br>Yeah, yeah, yeah<br>Na-na-na-naa, hey, Jude<br>Yeah, you know you can make it, Jude<br>Jude, you''re not gonna break it<br>Na na na (don''t make it bad, Jude) na-na-na-naa<br>Take a sad song and make it better<br>Na-na-na-naa, (oh, Jude) hey, (Jude) Jude<br>Hey, Jude, wo-o-ow!', 1);

-- --------------------------------------------------------

--
-- Structure de la table `music_artist`
--

CREATE TABLE IF NOT EXISTS `music_artist` (
  `id_music` int(11) NOT NULL,
  `id_artist` int(11) NOT NULL,
  PRIMARY KEY (`id_music`,`id_artist`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `music_artist`
--

INSERT INTO `music_artist` (`id_music`, `id_artist`) VALUES
(1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `player`
--

INSERT INTO `player` (`id_player`, `username`, `best_result`, `password`) VALUES
(1, 'Choudoor', 50, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
(2, 'hAppywAy', 0, 'f7c38e1502a5575d9a0bbe75de436d72cbf7819860eaa2c53a09e887bca88b66');

-- --------------------------------------------------------

--
-- Structure de la table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `id_player` int(11) NOT NULL,
  `id_music` int(11) NOT NULL,
  `result` int(11) DEFAULT '0',
  KEY `id_musique` (`id_music`),
  KEY `id_player` (`id_player`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `music_album` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`);

--
-- Contraintes pour la table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_music` FOREIGN KEY (`id_music`) REFERENCES `music` (`id_music`),
  ADD CONSTRAINT `result_player` FOREIGN KEY (`id_player`) REFERENCES `player` (`id_player`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
