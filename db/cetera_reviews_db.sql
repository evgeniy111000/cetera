-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июл 16 2016 г., 18:58
-- Версия сервера: 5.6.15-log
-- Версия PHP: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `cetera_reviews_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `ID_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Category_name` varchar(15) NOT NULL,
  PRIMARY KEY (`ID_category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`ID_category`, `Category_name`) VALUES
(1, 'Категория 1'),
(2, 'Категория 2'),
(3, 'Категория 3'),
(4, 'Категория 4');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `ID_reviews` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Fio` varchar(50) NOT NULL,
  `Email` varchar(35) NOT NULL,
  `Review` text NOT NULL,
  PRIMARY KEY (`ID_reviews`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`ID_reviews`, `Fio`, `Email`, `Review`) VALUES
(9, 'Корнеев Евгений Михайлович', 'evgeniykorneev@yahoo.com', 'мой отзыв'),
(10, 'Корнеев Е.М', 'eug.corneev@yandex.ru', 'мой отзыв 2'),
(11, 'Иванов И', 'ivan@mail.ru', 'другой отзыв 1');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews_category`
--

CREATE TABLE IF NOT EXISTS `reviews_category` (
  `ID_reviews_category` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Id_reviews` int(11) NOT NULL,
  `Id_category` int(11) NOT NULL,
  PRIMARY KEY (`ID_reviews_category`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `reviews_category`
--

INSERT INTO `reviews_category` (`ID_reviews_category`, `Id_reviews`, `Id_category`) VALUES
(4, 9, 4),
(3, 9, 1),
(5, 10, 1),
(6, 10, 2),
(7, 10, 3),
(8, 10, 4),
(9, 11, 2),
(10, 11, 3),
(11, 11, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
