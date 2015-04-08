-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 03 2015 г., 10:48
-- Версия сервера: 5.1.73
-- Версия PHP: 5.3.2-1ubuntu4.28

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ampmonitoring`
--

-- --------------------------------------------------------

--
-- Структура таблицы `amps`
--

CREATE TABLE IF NOT EXISTS `amps` (
  `description` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `model` varchar(255) NOT NULL,
  `edit_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `amps`
--

INSERT INTO `amps` (`description`, `ip`, `model`, `edit_date`) VALUES
('test', '172.16.83.189', '', '2015-03-18 11:43:25'),
('Ozinki_KTC_preamp', '192.168.100.166', '', '2015-04-02 14:10:52'),
('Saratov_boost', '192.168.100.12', '', '2015-04-02 14:05:11'),
('Saratov_preamp', '192.168.100.11', '', '2015-04-02 14:06:14'),
('Pushkino_Uralsk', '192.168.100.21', '', '2015-04-02 14:06:46'),
('Pushkino_Saratov', '192.168.100.22', '', '2015-04-02 14:07:01'),
('Ershov_Uralsk', '192.168.100.31', '', '2015-04-02 14:07:48'),
('Ershov_Saratov', '192.168.100.32', '', '2015-04-02 14:08:19'),
('Ozinki_Saratov_boost', '192.168.100.44', '', '2015-04-02 14:09:07'),
('Ozinki_KTC', '192.168.100.47', '', '2015-04-02 14:09:39'),
('Ozinki_preamp', '192.168.100.49', '', '2015-04-02 14:10:05');

-- --------------------------------------------------------

--
-- Структура таблицы `configurations`
--

CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `dwdm` int(11) NOT NULL,
  `direction` int(1) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `number` int(11) NOT NULL,
  `clock` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=64 ;

--
-- Дамп данных таблицы `configurations`
--

INSERT INTO `configurations` (`id`, `description`, `dwdm`, `direction`, `ip`, `number`, `clock`) VALUES
(19, 'test', 2, 0, '172.16.83.189', 0, '2015-03-20 11:48:23'),
(57, 'Saratov_Pushkino_Ershov_Ozinki', 1, 0, '192.168.100.21', 2, '2015-04-02 14:11:49'),
(55, 'Saratov_Pushkino_Ershov_Ozinki', 1, 0, '192.168.100.12', 1, '2015-04-02 14:11:49'),
(56, 'Saratov_Pushkino_Ershov_Ozinki', 1, 0, '192.168.100.166', 4, '2015-04-02 14:11:49'),
(54, 'Saratov_Pushkino_Ershov_Ozinki', 1, 1, '192.168.100.11', 4, '2015-04-02 14:11:49'),
(58, 'Saratov_Pushkino_Ershov_Ozinki', 1, 1, '192.168.100.22', 3, '2015-04-02 14:11:49'),
(59, 'Saratov_Pushkino_Ershov_Ozinki', 1, 0, '192.168.100.31', 3, '2015-04-02 14:11:49'),
(60, 'Saratov_Pushkino_Ershov_Ozinki', 1, 1, '192.168.100.32', 2, '2015-04-02 14:11:49'),
(61, 'Saratov_Pushkino_Ershov_Ozinki', 1, 1, '192.168.100.44', 1, '2015-04-02 14:11:49'),
(62, 'Saratov_Pushkino_Ershov_Ozinki', 1, 0, '192.168.100.47', 5, '2015-04-02 14:11:49'),
(63, 'Saratov_Pushkino_Ershov_Ozinki', 1, 0, '192.168.100.49', 4, '2015-04-02 14:11:49');

-- --------------------------------------------------------

--
-- Структура таблицы `directory`
--

CREATE TABLE IF NOT EXISTS `directory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `phone` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `directory`
--

INSERT INTO `directory` (`id`, `name`, `phone`) VALUES
(1, 'Tom Smith', '512-555-0111'),
(2, 'Bill Smith', '512-555-0112'),
(3, 'John Smith', '512-555-0113'),
(4, 'Jane Smith', '512-555-0114'),
(5, 'Sara Smith', '512-555-0115');

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `description` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `input1` float NOT NULL,
  `output1` float NOT NULL,
  `input2` float NOT NULL,
  `output2` float NOT NULL,
  `power1` float NOT NULL,
  `power2` float NOT NULL,
  `unit_temp` float NOT NULL,
  `mode` varchar(15) NOT NULL,
  `gain_value` float NOT NULL,
  `clock` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `history`
--

