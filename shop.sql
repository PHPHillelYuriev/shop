-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 05 2018 г., 12:46
-- Версия сервера: 5.7.20
-- Версия PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `parent_id`, `name`) VALUES
(1, NULL, 'Бытовая техника'),
(2, NULL, 'Смартфоны и телефоны'),
(3, NULL, 'Ноутбуки, компьютеры'),
(4, NULL, 'ТВ, аудио и видео'),
(5, 1, 'Крупная техника'),
(6, 1, 'Встраиваемая техника'),
(7, 1, 'Климатическая техника'),
(8, 7, 'Кондиционеры'),
(9, 7, 'Водонагреватели'),
(10, 7, 'Обогреватели'),
(11, 2, 'Смартфоны'),
(12, 2, 'Телефоны'),
(13, 2, 'Аксессуары'),
(14, 3, 'Ноутбуки, компьютеры'),
(15, 3, 'Планшеты'),
(16, 14, 'Ноутбуки'),
(17, 14, 'Компьютеры'),
(18, 4, 'Телевизоры'),
(19, 4, 'Аксессуары для ТВ');

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manufacturer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `category_id`, `model`, `manufacturer`, `price`, `date_added`) VALUES
(1, 11, 'Blue 10', 'Honor', '299', '2018-07-05 07:37:54'),
(2, 11, '9 Black', 'Honor', '199', '2018-07-05 07:37:54'),
(3, 11, 'P20 Black', 'Huawei', '250', '2018-07-05 07:41:01'),
(4, 11, 'P20 Pink', 'Huawei', '250', '2018-07-05 07:41:01'),
(5, 11, 'Galaxy S8', 'Samsung', '400', '2018-07-05 07:44:20'),
(6, 11, 'Galaxy S9', 'Samsung', '500', '2018-07-05 07:44:20'),
(7, 11, 'RedMi 4A', 'Xiaomi', '300', '2018-07-05 07:45:12'),
(8, 11, 'RedMi 5A', 'Xiaomi', '350', '2018-07-05 07:45:12'),
(9, 11, 'S10', 'Apple', '799', '2018-07-05 07:45:49'),
(10, 11, 'S9', 'Apple', '900', '2018-07-05 07:45:49'),
(11, 11, 'M5s', 'Meizu', '400', '2018-07-05 07:48:09'),
(12, 11, 'M8c', 'Meizu', '450', '2018-07-05 07:48:09'),
(13, 16, 'Aspire', 'Acer', '420', '2018-07-05 07:54:17'),
(14, 16, 'Nitro', 'Acer', '450', '2018-07-05 07:54:17'),
(15, 16, 'Inseption', 'Dell', '600', '2018-07-05 07:55:16'),
(16, 16, 'IdeaPad', 'Lenovo', '650', '2018-07-05 07:55:16'),
(17, 16, '15S', 'HP', '540', '2018-07-05 07:56:17'),
(18, 16, '17S', 'HP', '590', '2018-07-05 07:56:17');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64C19C1727ACA70` (`parent_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_64C19C1727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `category` (`id`);

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
