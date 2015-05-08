-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 08 Mai 2015 à 12:46
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `album`
--

INSERT INTO `album` (`id_album`, `album_name`, `release_date`) VALUES
(1, 'Making Mirrors', '2015-05-06'),
(2, 'Demon Days', '2015-05-07'),
(3, 'Dish Of The Day', '2015-05-07');

-- --------------------------------------------------------

--
-- Structure de la table `artist`
--

CREATE TABLE IF NOT EXISTS `artist` (
  `id_artist` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  PRIMARY KEY (`id_artist`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `artist`
--

INSERT INTO `artist` (`id_artist`, `name`, `firstname`) VALUES
(1, 'Gotye', ''),
(2, 'Gorillaz', ''),
(3, 'Fools Garden', ''),
(4, 'The Verve', ''),
(5, 'Oasis', '');

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
('94fd3c3c81d654a966f14547fd61ca6b', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:37.0) Gecko/20100101 Firefox/37.0', 1431081749, 'a:3:{s:9:"user_data";s:0:"";s:9:"id_player";s:1:"1";s:9:"connected";b:1;}');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Contenu de la table `music`
--

INSERT INTO `music` (`id_music`, `title`, `path`, `lyrics`, `id_artist`, `id_album`) VALUES
(1, 'Somebody That I Used To Know', 'local', '[Gotye:]\r\nNow and then I think of when we were together\r\nLike when you said you felt so happy you could die\r\nTold myself that you were right for me\r\nBut felt so lonely in your company\r\nBut that was love and it''s an ache I still remember\r\n\r\nYou can get addicted to a certain kind of sadness\r\nLike resignation to the end, always the end\r\nSo when we found that we could not make sense\r\nWell you said that we would still be friends\r\nBut I''ll admit that I was glad that it was over\r\n\r\nBut you didn''t have to cut me off\r\nMake out like it never happened and that we were nothing\r\nAnd I don''t even need your love\r\nBut you treat me like a stranger and that feels so rough\r\nNo you didn''t have to stoop so low\r\nHave your friends collect your records and then change your number\r\nI guess that I don''t need that though\r\nNow you''re just somebody that I used to know\r\n\r\nNow you''re just somebody that I used to know\r\nNow you''re just somebody that I used to know\r\n\r\n[Kimbra:]\r\nNow and then I think of all the times you screwed me over\r\nBut had me believing it was always something that I''d done\r\nBut I don''t wanna live that way\r\nReading into every word you say\r\nYou said that you could let it go\r\nAnd I wouldn''t catch you hung up on somebody that you used to know\r\n\r\n[Gotye:]\r\nBut you didn''t have to cut me off\r\nMake out like it never happened and that we were nothing\r\nAnd I don''t even need your love\r\nBut you treat me like a stranger and that feels so rough\r\nNo you didn''t have to stoop so low\r\nHave your friends collect your records and then change your number\r\nI guess that I don''t need that though\r\nNow you''re just somebody that I used to know\r\n\r\n[x2]\r\nSomebody\r\n(I used to know)\r\nSomebody\r\n(Now you''re just somebody that I used to know)\r\n\r\n(I used to know)\r\n(That I used to know)\r\n(I used to know)\r\nSomebody', 1, 1),
(2, 'Clint Eastwood', 'local', 'Hahahahahahahahaha,\nFeel good,\nFeel good,\nFeel good,\nFeel good,\nFeel good,\nFeel good,\nFeel good,\nFeel good,\nFeel good...\n\nCity''s breaking down on a camel''s back.\nThey just have to go ''cause they don''t know wack\nSo all you fill the streets it''s appealing to see\nYou won''t get out the county, ''cause you''re bad and free\nYou''ve got a new horizon it''s ephemeral style.\nA melancholy town where we never smile.\nAnd all I wanna hear is the message beep.\nMy dreams, they''ve got to kiss me ''cause I don''t get sleep, no\n\n[Chorus:]\nWindmill, windmill for the land.\nTurned forever hand in hand\nTake it all in on your stride\nIt is ticking, falling down\nLove forever love is free\nLet''s turn forever you and me\nWindmill, windmill for the land\nIs everybody in?\n\nLaughing gas these hazmats, fast cats,\nLining them up like ass cracks,\nLay these ponies at the track\nIt''s my chocolate attack.\nShit, I''m stepping in the heart of this here\nCare bear reppin'' it harder this year\nWatch me as I gravitate\nHahahahahahaa.\n\nYo, we gonna go ghost town,\nThis motown,\nWith your sound\nYou''re in the blink\nGonna bite the dust\nCan''t fight with us\nWith your sound\nYou kill the INC.\nSo don''t stop, get it, get it\nUntil you jet ahead.\nYo, watch the way I navigate\nHahahahahhaa\n\nFeel good, ahhhhahahahah [x4]\n\n[Chorus]\n\nDon''t stop, shit it, get it\nWe are your captains in it\nSteady,\nWatch me navigate,\nAhahahahahhaa.\nDon''t stop, shit it, get it\nWe are your captains in it\nSteady,\nWatch me navigate\nAhahahahahhaa.\n\nFeel good, ahhhhahahahaha\nFeel good,\nFeel good, ahhhhahahahaha\nFeel good...', 2, 2),
(3, 'Lemon Tree', 'local', 'I''m sitting here in the boring room \nIt''s just another rainy Sunday afternoon \nI''m wasting my time \nI got nothing to do \nI''m hanging around \nI''m waiting for you \nBut nothing ever happens and I wonder \n\nI''m driving around in my car \nI''m driving too fast \nI''m driving too far \nI''d like to change my point of view \nI feel so lonely \nI''m waiting for you \nBut nothing ever happens and I wonder \n\nI wonder how \nI wonder why \nYesterday you told me ''bout the blue blue sky \nAnd all that I can see is just a yellow lemon-tree \nI''m turning my head up and down \nI''m turning turning turning turning turning around \nAnd all that I can see is just another lemon-tree \n\nSing, dah...\n\nI''m sitting here \nI miss the power \nI''d like to go out taking a shower \nBut there''s a heavy cloud inside my head \nI feel so tired \nPut myself into bed \nWhile nothing ever happens and I wonder \n\nIsolation is not good for me \nIsolation I don''t want to sit on the lemon-tree \nI''m steppin'' around in the desert of joy \nBaby anyhow I''ll get another toy \nAnd everything will happen and you wonder \n\nI wonder how \nI wonder why \nYesterday you told me ''bout the blue blue sky \nAnd all that I can see is just another lemon-tree \nI''m turning my head up and down \nI''m turning turning turning turning turning around \nAnd all that I can see is just a yellow lemon-tree \nYellow, wonder, wonder \n\nI wonder how \nI wonder why \nYesterday you told me ''bout the blue blue sky \nAnd all that I can see, and all that I can see, and all that I can see \nIs just a yellow lemon-tree', 3, 3);

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
-- Contenu de la table `result`
--

INSERT INTO `result` (`id_player`, `id_music`, `result`) VALUES
(1, 2, 50),
(1, 3, 150);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `music_album` FOREIGN KEY (`id_album`) REFERENCES `album` (`id_album`),
  ADD CONSTRAINT `music_artist` FOREIGN KEY (`id_artist`) REFERENCES `artist` (`id_artist`);

--
-- Contraintes pour la table `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_music` FOREIGN KEY (`id_music`) REFERENCES `music` (`id_music`),
  ADD CONSTRAINT `result_player` FOREIGN KEY (`id_player`) REFERENCES `player` (`id_player`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
