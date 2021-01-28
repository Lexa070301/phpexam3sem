-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Янв 28 2021 г., 16:36
-- Версия сервера: 8.0.19
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `exam`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Структура таблицы `answers`
--

CREATE TABLE `answers` (
  `id` int NOT NULL,
  `ip` varchar(16) NOT NULL,
  `datetime` datetime NOT NULL,
  `session_id` int NOT NULL,
  `question_id` int NOT NULL,
  `answer` text NOT NULL,
  `points` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `answers`
--

INSERT INTO `answers` (`id`, `ip`, `datetime`, `session_id`, `question_id`, `answer`, `points`) VALUES
(29, '127.0.0.1', '2021-01-28 13:47:37', 1, 1, '1337', 0),
(30, '127.0.0.1', '2021-01-28 13:47:37', 1, 2, '2001', 0),
(31, '127.0.0.1', '2021-01-28 13:47:37', 1, 3, 'te5st', 0),
(32, '127.0.0.1', '2021-01-28 13:47:37', 1, 4, 'frefrefer', 0),
(33, '127.0.0.1', '2021-01-28 13:47:37', 1, 5, 'Красный', 40),
(34, '127.0.0.1', '2021-01-28 13:47:37', 1, 6, 'Фантастика,Триллер', 70),
(41, '127.0.0.1', '2021-01-28 14:37:28', 1, 1, '55', 0),
(42, '127.0.0.1', '2021-01-28 14:37:28', 1, 2, '1984', 0),
(43, '127.0.0.1', '2021-01-28 14:37:28', 1, 3, 'fdsfsdfsd', 0),
(44, '127.0.0.1', '2021-01-28 14:37:28', 1, 4, 'fsdgdfsgdfgfd', 0),
(45, '127.0.0.1', '2021-01-28 14:37:28', 1, 5, 'Жёлтый', 10),
(46, '127.0.0.1', '2021-01-28 14:37:28', 1, 6, 'Детективы', 25),
(47, '127.0.0.1', '2021-01-28 15:02:01', 1, 1, '45435', 0),
(48, '127.0.0.1', '2021-01-28 15:02:01', 1, 2, '5435', 0),
(49, '127.0.0.1', '2021-01-28 15:02:01', 1, 3, 'gdfg', 0),
(50, '127.0.0.1', '2021-01-28 15:02:01', 1, 4, 'gdfgfd', 0),
(51, '127.0.0.1', '2021-01-28 15:02:01', 1, 5, 'Зелёный', 15),
(52, '127.0.0.1', '2021-01-28 15:02:01', 1, 6, 'Детективы,Фантастика,Триллер', 95),
(53, '127.0.0.1', '2021-01-28 16:30:55', 2, 29, '45435', 0),
(54, '127.0.0.1', '2021-01-28 16:30:55', 2, 30, 'var1', 43),
(55, '127.0.0.1', '2021-01-28 16:30:55', 2, 31, '', 0),
(56, '127.0.0.1', '2021-01-28 16:31:17', 2, 29, '54654', 0),
(57, '127.0.0.1', '2021-01-28 16:31:17', 2, 30, 'var3', 76),
(58, '127.0.0.1', '2021-01-28 16:31:17', 2, 31, 'test1,test2', 35);

-- --------------------------------------------------------

--
-- Структура таблицы `questions`
--

CREATE TABLE `questions` (
  `id` int NOT NULL,
  `session_id` int NOT NULL,
  `question_type` int NOT NULL,
  `question` text NOT NULL,
  `answer` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `questions`
--

INSERT INTO `questions` (`id`, `session_id`, `question_type`, `question`, `answer`) VALUES
(1, 1, 1, 'Ваше любимое число', NULL),
(2, 1, 2, 'Ваш год рождения', NULL),
(3, 1, 3, 'Ваше имя', NULL),
(4, 1, 4, 'Напишите немного о себе', NULL),
(5, 1, 5, 'Выберите ваш любимый цвет', 'Зелёный=15,Жёлтый=10,Красный=40,Синий=50'),
(6, 1, 6, 'Выберите ваши любимые жанры книг', 'Детективы=25,Фантастика=10,Триллер=60'),
(29, 2, 1, 'tretre', NULL),
(30, 2, 5, 'teeeeeeest', 'var1=43,var2=12,var3=76'),
(31, 2, 6, 'ttesstt', 'test1=11,test2=24,test3=88');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` int NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`id`, `status`) VALUES
(1, 'enabled'),
(2, 'enabled');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Индексы таблицы `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT для таблицы `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `sessions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
