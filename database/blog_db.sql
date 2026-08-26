-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 25 2026 г., 23:19
-- Версия сервера: 5.7.39-log
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blog_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `content`, `created_at`) VALUES
(1, 4, 1, 'ццццццц', '2026-08-25 20:10:29');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_public` tinyint(1) DEFAULT '1',
  `is_hidden` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `is_public`, `is_hidden`, `created_at`) VALUES
(1, 1, 'pepelnahudi', 'pepelnahudi', 1, 0, '2026-08-25 20:07:07'),
(3, 1, 'Работа с базами данных в PHP', 'Подключение к MySQL через PDO - это современный и безопасный способ работы с базами данных. Подготовленные выражения защищают от SQL-инъекций.\r\n\r\nПример подключения:\r\n$pdo = new PDO($dsn, $user, $pass);\r\n\r\nВсегда используйте подготовленные выражения для запросов с пользовательскими данными.', 1, 0, '2026-08-25 20:08:57'),
(4, 2, 'Тренды веб-дизайна 2026', 'Минимализм продолжает доминировать в веб-дизайне. Чистые линии, много белого пространства и акцент на типографике.\n\nЦветовые палитры становятся более приглушенными, с акцентом на натуральные оттенки. Коричневые, бежевые и зеленые тона создают ощущение тепла и уюта.\n\nАнимации должны быть тонкими и ненавязчивыми.', 1, 0, '2026-08-25 20:08:57'),
(5, 2, 'Приватный проект: редизайн сайта', 'Это скрытый пост с деталями проекта по редизайну корпоративного сайта. Здесь описаны технические требования и сроки выполнения.\n\nЭта информация доступна только по прямой ссылке.', 0, 1, '2026-08-25 20:08:57'),
(6, 3, 'Мое путешествие в горы', 'Прошлые выходные я провел в горах. Это было невероятное приключение!\n\nПодъем занял около 6 часов, но виды с вершины стоили каждого шага. Природа в это время года просто потрясающая.\n\nРекомендую всем хотя бы раз в жизни попробовать горный туризм.', 1, 0, '2026-08-25 20:08:57'),
(7, 3, 'Рецепт идеального завтрака', 'Сегодня делюсь своим любимым рецептом завтрака - овсянка с фруктами и орехами.\n\nИнгредиенты:\n- Овсяные хлопья - 100г\n- Молоко - 200мл\n- Банан - 1 шт\n- Грецкие орехи - 30г\n- Мед - по вкусу\n\nПриготовление простое и занимает не более 10 минут.', 1, 0, '2026-08-25 20:08:57'),
(8, 4, 'JavaScript для начинающих', 'JavaScript - это язык, который оживляет веб-страницы. Без него современные сайты были бы просто статичными документами.\n\nНачнем с основ: переменные, функции и события. Эти три концепции - фундамент любого JS-приложения.\n\nПрактика - ключ к успеху. Пишите код каждый день!', 1, 0, '2026-08-25 20:08:57'),
(9, 4, 'Сравнение фреймворков', 'React, Vue или Angular? Этот вопрос мучает многих разработчиков. Давайте разберем плюсы и минусы каждого.\n\nReact - гибкий и популярный, но требует дополнительных библиотек.\nVue - простой в освоении с хорошей документацией.\nAngular - мощный, но с высоким порогом входа.', 1, 0, '2026-08-25 20:08:57'),
(10, 5, 'Обзор нового ноутбука', 'Тестирую новый ноутбук для разработки. Процессор i7, 16GB RAM, SSD 512GB.\n\nПроизводительность отличная, компиляция проектов проходит быстро. Экран яркий, клавиатура удобная для долгой работы.\n\nЕдинственный минус - время работы от батареи могло быть лучше.', 1, 0, '2026-08-25 20:08:57'),
(11, 5, 'Настройки IDE для продуктивности', 'Правильно настроенная среда разработки экономит часы работы. Вот мои любимые плагины и настройки.\n\n1. Автодополнение кода\n2. Интеграция с Git\n3. Темная тема для снижения нагрузки на глаза\n4. Горячие клавиши для частых операций', 1, 0, '2026-08-25 20:08:57'),
(12, 6, 'Книги, которые изменили мое мышление', 'За последний год я прочитала несколько книг, которые сильно повлияли на мой подход к работе и жизни.\n\n\"Атомные привычки\" Джеймса Клира - о том, как маленькие изменения приводят к большим результатам.\n\"Думай медленно, решай быстро\" Даниэля Канемана - о когнитивных искажениях.', 1, 0, '2026-08-25 20:08:57'),
(13, 6, 'Как побороть прокрастинацию', 'Прокрастинация - враг продуктивности. Вот несколько техник, которые помогают мне оставаться сосредоточенным.\n\nМетод Помодоро: 25 минут работы, 5 минут отдыха.\nПравило двух минут: если задача занимает меньше двух минут - сделай её сразу.\nРазбивайте большие задачи на маленькие шаги.', 1, 0, '2026-08-25 20:08:57'),
(14, 1, 'Скрытый пост: планы на проект', 'Это приватный пост с техническим заданием для нового проекта. Содержит конфиденциальную информацию о требованиях заказчика.\n\nДоступен только по прямой ссылке для членов команды.', 0, 1, '2026-08-25 20:08:57'),
(15, 3, 'Заметки о фотографии', 'Фотография - это мое хобби. Делюсь заметками о композиции и работе со светом.\n\nПравило третей - базовый принцип композиции. Разделите кадр на девять равных частей и разместите важные элементы на пересечениях линий.', 1, 0, '2026-08-25 20:08:57'),
(16, 2, 'UX/UI дизайн мобильного приложения', 'Разрабатываю дизайн для мобильного приложения доставки еды. Основной фокус на удобстве навигации и скорости оформления заказа.\n\nПрототип готов, начинаю работу над визуальным дизайном.', 1, 0, '2026-08-25 20:08:57'),
(17, 8, 'Сткрываем', 'Сткрываем', 0, 1, '2026-08-25 20:15:42'),
(18, 8, 'и', 'цвцфвфцв', 1, 0, '2026-08-25 20:17:52');

-- --------------------------------------------------------

--
-- Структура таблицы `post_tags`
--

CREATE TABLE `post_tags` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `post_tags`
--

INSERT INTO `post_tags` (`post_id`, `tag_id`) VALUES
(1, 1),
(17, 1),
(18, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `subscriptions`
--

CREATE TABLE `subscriptions` (
  `follower_id` int(11) NOT NULL,
  `followee_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `subscriptions`
--

INSERT INTO `subscriptions` (`follower_id`, `followee_id`, `created_at`) VALUES
(1, 2, '2026-08-25 20:09:35');

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(15, 'backend'),
(12, 'books'),
(5, 'css'),
(16, 'database'),
(11, 'food'),
(14, 'frontend'),
(3, 'javascript'),
(9, 'lifestyle'),
(6, 'mysql'),
(1, 'pepelnahudi'),
(2, 'php'),
(7, 'programming'),
(13, 'technology'),
(10, 'travel'),
(8, 'tutorial'),
(4, 'web-design');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'qweqwe', 'admin@flower.com', '$2y$10$/D792SKKZfDK2/qNgkhaoeOjK1Y/NnmuFfcUP57Nzte5aFMivvMbm', '2026-08-25 20:06:10'),
(2, 'alex_dev', 'alex@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-08-25 20:08:57'),
(3, 'maria_design', 'maria@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-08-25 20:08:57'),
(4, 'ivan_blogger', 'ivan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-08-25 20:08:57'),
(5, 'elena_code', 'elena@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-08-25 20:08:57'),
(6, 'dmitry_tech', 'dmitry@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-08-25 20:08:57'),
(7, 'anna_writer', 'anna@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-08-25 20:08:57'),
(8, 'user', 'zxccxz@qwe.com', '$2y$10$1nd8SEm5J4iXf9KOw9QOzemsptVLoJ0MwX1V0OHTkqaj.yTjVvGX6', '2026-08-25 20:15:22');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Индексы таблицы `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`follower_id`,`followee_id`),
  ADD KEY `followee_id` (`followee_id`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_tags`
--
ALTER TABLE `post_tags`
  ADD CONSTRAINT `post_tags_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`followee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
