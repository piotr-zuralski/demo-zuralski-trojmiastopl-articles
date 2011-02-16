-- phpMyAdmin SQL Dump
-- version 3.3.8.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 16 Maj 2011, 15:08
-- Wersja serwera: 5.1.41
-- Wersja PHP: 5.3.2-1ubuntu4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `demo_trojmiasto`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Zrzut danych tabeli `articles`
--


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `authors`
--

CREATE TABLE IF NOT EXISTS `authors` (
  `author_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Zrzut danych tabeli `authors`
--

INSERT INTO `authors` (`author_id`, `first_name`, `last_name`) VALUES
(1, 'Jarosław', 'Kobiński'),
(2, 'Marcin', 'Szuca'),
(3, 'Karol', 'Brzowski'),
(4, 'Regina', 'Stolk'),
(5, 'Danuta', 'Wilc'),
(6, 'Dominika', 'Staszkic'),
(7, 'Radosław', 'Smigły'),
(8, 'Anna', 'Zuzkowska'),
(9, 'Sylwia', 'Szczepańska'),
(10, 'Paweł', 'Majdan'),
(11, 'Bronisław', 'Znocholski'),
(12, 'Ireneusz', 'Kuca'),
(13, 'Dominik', 'Poznański'),
(14, 'Tomasz', 'Piątek'),
(15, 'Miłosz', 'Tumer'),
(16, 'Andrzej', 'Strun'),
(17, 'Bogdan', 'Mint'),
(18, 'Janusz', 'Ming'),
(19, 'Serwryn', 'Kocimski'),
(20, 'Monika', 'Chrobczuk');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `categories`
--

INSERT INTO `categories` (`category_id`, `name`) VALUES
(1, 'Fakty'),
(2, 'Kultura'),
(3, 'Sport'),
(4, 'Rozrywka'),
(5, 'Biznes');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `rel_articles2categories`
--

CREATE TABLE IF NOT EXISTS `rel_articles2categories` (
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  UNIQUE KEY `index_article_category` (`article_id`,`category_id`),
  KEY `article_id` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `rel_articles2categories`
--

