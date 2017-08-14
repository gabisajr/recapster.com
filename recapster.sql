-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 14 2017 г., 21:32
-- Версия сервера: 5.5.53
-- Версия PHP: 7.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `recapster_new`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `remember_token`, `is_super_admin`, `created_at`, `updated_at`) VALUES
(1, 'Lukas Pierce', 'lukas.pierce@recapster.com', '$2y$10$Fqm0TmnYT.gN7Mo19oVv.O3EDvyEF0kwjs5uR9zGkR0fi7/L3VFku', NULL, 1, '2017-07-20 17:23:20', '2017-07-20 17:23:20');

-- --------------------------------------------------------

--
-- Структура таблицы `ceo`
--

CREATE TABLE `ceo` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `avatar_id` int(10) UNSIGNED DEFAULT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `chairs`
--

CREATE TABLE `chairs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `faculty_id` int(10) UNSIGNED DEFAULT NULL,
  `vk_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'id кафедры ВКонтакте',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `chairs`
--

INSERT INTO `chairs` (`id`, `title`, `faculty_id`, `vk_id`, `created_at`, `updated_at`) VALUES
(1, 'Архитектура', 2, NULL, NULL, NULL),
(2, 'Дизайн', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL COMMENT 'название города',
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `region_id` int(10) UNSIGNED DEFAULT NULL,
  `vk_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'id города ВКонтакте',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `alias`, `title`, `country_id`, `region_id`, `vk_id`, `created_at`, `updated_at`) VALUES
(1, 'astana', 'Астана', 1, 1, NULL, NULL, NULL),
(2, 'karaganda', 'Караганда', 1, 8, 284, NULL, NULL),
(3, 'almaty', 'Алматы', 1, 3, NULL, NULL, NULL),
(4, 'moscow', 'Москва', 2, NULL, NULL, NULL, NULL),
(5, 'abai', 'Абай', 1, 8, NULL, NULL, NULL),
(6, 'akkol', 'Акколь', 1, NULL, NULL, NULL, NULL),
(7, 'aksay', 'Аксай', 1, NULL, NULL, NULL, NULL),
(9, 'aktau', 'Актау', 1, NULL, NULL, NULL, NULL),
(10, 'aqtobe', 'Актюбинск', 1, NULL, NULL, NULL, NULL),
(11, 'alga', 'Алга', 1, NULL, NULL, NULL, NULL),
(12, 'aralsk', 'Аральск', 1, NULL, NULL, NULL, NULL),
(13, 'arkalyk', 'Аркалык', 1, NULL, NULL, NULL, NULL),
(14, 'arys', 'Арыс', 1, NULL, NULL, NULL, NULL),
(15, 'atbasar', 'Атбасар', 1, NULL, NULL, NULL, NULL),
(16, 'atyrau', 'Атырау', 1, NULL, NULL, NULL, NULL),
(17, 'ayagoz', 'Аягуз', 1, NULL, NULL, NULL, NULL),
(18, 'baikonur', 'Байконур', 1, NULL, NULL, NULL, NULL),
(19, 'balkhash', 'Балхаш', 1, NULL, NULL, NULL, NULL),
(20, 'bulayevo', 'Булаево', 1, NULL, NULL, NULL, NULL),
(21, 'derzhavinsk', 'Державинск', 1, NULL, NULL, NULL, NULL),
(22, 'yereymentau', 'Ерейментау', 1, NULL, NULL, NULL, NULL),
(23, 'yesik', 'Есик', 1, NULL, NULL, NULL, NULL),
(24, 'yesil', 'Есиль', 1, NULL, NULL, NULL, NULL),
(25, 'zhanaozen', 'Жанаозен', 1, NULL, NULL, NULL, NULL),
(26, 'zhana-tas', 'Жанатас', 1, NULL, NULL, NULL, NULL),
(27, 'zharkent', 'Жаркент', 1, NULL, NULL, NULL, NULL),
(28, 'zhezkazgan', 'Жезказган', 1, NULL, NULL, NULL, NULL),
(29, 'zhem', 'Жем', 1, NULL, NULL, NULL, NULL),
(30, 'zhetysai', 'Жетысай', 1, NULL, NULL, NULL, NULL),
(31, 'zhitikara', 'Житикара', 1, NULL, NULL, NULL, NULL),
(32, 'zaysan', 'Зайсан', 1, NULL, NULL, NULL, NULL),
(33, 'zyryanovsk', 'Зыряновск', 1, NULL, NULL, NULL, NULL),
(34, 'kazalinsk', 'Казалинск', 1, NULL, NULL, NULL, NULL),
(35, 'kandyagash', 'Кандыагаш', 1, NULL, NULL, NULL, NULL),
(36, 'kapchagay', 'Капчагай', 1, NULL, NULL, NULL, NULL),
(37, 'karazhal', 'Каражал', 1, NULL, NULL, NULL, NULL),
(38, 'karatau', 'Каратау', 1, NULL, NULL, NULL, NULL),
(39, 'karkaralinsk', 'Каркаралинск', 1, NULL, NULL, NULL, NULL),
(40, 'kaskelen', 'Каскелен', 1, NULL, NULL, NULL, NULL),
(41, 'kentau', 'Кентау', 1, NULL, NULL, NULL, NULL),
(42, 'kokshetau', 'Кокшетау', 1, NULL, NULL, NULL, NULL),
(43, 'kostanay', 'Костанай', 1, NULL, NULL, NULL, NULL),
(44, 'kulsary', 'Кульсары', 1, NULL, NULL, NULL, NULL),
(45, 'kurchatov', 'Курчатов', 1, NULL, NULL, NULL, NULL),
(46, 'kyzylorda', 'Кызылорда', 1, NULL, NULL, NULL, NULL),
(47, 'lenger', 'Ленгер', 1, NULL, NULL, NULL, NULL),
(48, 'lisakovsk', 'Лисаковск', 1, NULL, NULL, NULL, NULL),
(49, 'makinsk', 'Макинск', 1, NULL, NULL, NULL, NULL),
(50, 'mamlyutka', 'Мамлютка', 1, NULL, NULL, NULL, NULL),
(51, 'pavlodar', 'Павлодар', 1, NULL, NULL, NULL, NULL),
(52, 'petropavlovsk', 'Петропавловск', 1, NULL, NULL, NULL, NULL),
(53, 'priozersk', 'Приозёрск', 1, NULL, NULL, NULL, NULL),
(54, 'ridder', 'Риддер', 1, NULL, NULL, NULL, NULL),
(55, 'rudny', 'Рудный', 1, NULL, NULL, NULL, NULL),
(56, 'saran', 'Сарань', 1, NULL, NULL, NULL, NULL),
(57, 'sarkand', 'Сарканд', 1, NULL, NULL, NULL, NULL),
(58, 'saryagash', 'Сарыагаш', 1, NULL, NULL, NULL, NULL),
(59, 'satpayev', 'Сатпаев', 1, NULL, NULL, NULL, NULL),
(60, 'semey', 'Семей', 1, NULL, NULL, NULL, NULL),
(61, 'sergeyevka', 'Сергеевка', 1, NULL, NULL, NULL, NULL),
(62, 'serebryansk', 'Серебрянск', 1, NULL, NULL, NULL, NULL),
(63, 'stepnogorsk', 'Степногорск', 1, NULL, NULL, NULL, NULL),
(64, 'stepnyak', 'Степняк', 1, NULL, NULL, NULL, NULL),
(65, 'tayynsha', 'Тайынша', 1, NULL, NULL, NULL, NULL),
(66, 'talgar', 'Талгар', 1, NULL, NULL, NULL, NULL),
(67, 'taldykorgan', 'Талдыкорган', 1, NULL, NULL, NULL, NULL),
(68, 'taraz', 'Тараз', 1, NULL, NULL, NULL, NULL),
(69, 'tekeli', 'Текели', 1, NULL, NULL, NULL, NULL),
(70, 'temir', 'Темир', 1, NULL, NULL, NULL, NULL),
(71, 'temirtau', 'Темиртау', 1, NULL, NULL, NULL, NULL),
(72, 'turkestan', 'Туркестан', 1, NULL, NULL, NULL, NULL),
(73, 'uralsk', 'Уральск', 1, NULL, NULL, NULL, NULL),
(74, 'ust-kamenogorsk', 'Усть-Каменогорск', 1, NULL, NULL, NULL, NULL),
(75, 'ucharal', 'Учарал', 1, NULL, NULL, NULL, NULL),
(76, 'ushtobe', 'Уштобе', 1, NULL, NULL, NULL, NULL),
(77, 'fort-shevchenko', 'Форт-Шевченко', 1, NULL, NULL, NULL, NULL),
(78, 'khromtau', 'Хромтау', 1, NULL, NULL, NULL, NULL),
(79, 'chardara', 'Чардара', 1, NULL, NULL, NULL, NULL),
(80, 'shalkar', 'Шалкар', 1, NULL, NULL, NULL, NULL),
(81, 'shar', 'Шар', 1, NULL, NULL, NULL, NULL),
(82, 'shakhtinsk', 'Шахтинск', 1, NULL, NULL, NULL, NULL),
(83, 'shemonaikha', 'Шемонаиха', 1, NULL, NULL, NULL, NULL),
(84, 'shu', 'Шу', 1, NULL, NULL, NULL, NULL),
(85, 'shymkent', 'Шымкент', 1, NULL, NULL, NULL, NULL),
(86, 'shchuchinsk', 'Щучинск', 1, NULL, NULL, NULL, NULL),
(87, 'ekibastuz', 'Экибастуз', 1, NULL, NULL, NULL, NULL),
(88, 'emba', 'Эмба', 1, NULL, NULL, NULL, NULL),
(89, 'aksu-ermak', 'Аксу (быв. Ермак)', 1, NULL, NULL, NULL, NULL),
(90, '', 'Волгоград', 2, NULL, NULL, NULL, NULL),
(92, 'St-Petersburg', 'Санкт-Петербург', 2, NULL, NULL, NULL, NULL),
(93, 'LA', 'Лос-Анджелес', 204, 16, NULL, NULL, NULL),
(94, 'dallas', 'Даллас', 204, 15, NULL, NULL, NULL),
(95, 'San-Diego', 'Сан-Диего', 204, NULL, NULL, NULL, NULL),
(96, 'Dubai', 'Дубай', 159, NULL, NULL, NULL, NULL),
(97, 'Luxembourg', 'Люксембург', 122, NULL, NULL, NULL, NULL),
(98, 'aksu', 'Аксу', 1, NULL, NULL, NULL, NULL),
(99, 'mariupol', 'Мариуполь', 224, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `rating` double(8,2) NOT NULL DEFAULT '0.00',
  `created_user_id` int(10) UNSIGNED DEFAULT NULL,
  `updated_user_id` int(10) UNSIGNED DEFAULT NULL,
  `logo_id` int(10) UNSIGNED DEFAULT NULL,
  `cover_id` int(10) UNSIGNED DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `short_desc` text COMMENT 'короткое описание компании',
  `size_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'размер компании (кол-во сотрудников)',
  `revenue_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'доход компании',
  `hq_city_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'город где находится головной офис',
  `foundation_year` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'год основания',
  `description` varchar(1000) DEFAULT NULL COMMENT 'описание компании',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'подтвержденый аккаунт',
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'активированая компания',
  `reviews_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество активных отзывов',
  `salaries_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество активных зарплат',
  `interviews_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество активных собеседований',
  `jobs_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество вакансий',
  `internship_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество стажировок',
  `benefits_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество активных приемуществ',
  `images_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество активных фотографий',
  `followers_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество подписчиков',
  `tel` varchar(30) DEFAULT NULL COMMENT 'телефон',
  `vk_group_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'id группы ВКонтакте',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `companies`
--

INSERT INTO `companies` (`id`, `alias`, `title`, `rating`, `created_user_id`, `updated_user_id`, `logo_id`, `cover_id`, `site`, `short_desc`, `size_id`, `revenue_id`, `hq_city_id`, `foundation_year`, `description`, `confirmed`, `active`, `reviews_count`, `salaries_count`, `interviews_count`, `jobs_count`, `internship_count`, `benefits_count`, `images_count`, `followers_count`, `tel`, `vk_group_id`, `created_at`, `updated_at`) VALUES
(1, 'recapster', 'Recapster', 0.00, NULL, NULL, 2, 3, 'http://recapster.com/', NULL, 1, NULL, 2, 2015, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, '2017-07-23 03:51:15', '2017-08-01 11:40:28'),
(2, 'epam-kazakhstan', 'Epam Kazakhstan', 0.00, NULL, NULL, 48, NULL, 'https://www.epam.com/', NULL, NULL, NULL, NULL, NULL, 'EPAM Systems один из лидеров ИТ рынка, надежный партнер для сложных и масштабных проектов\r\nОснованная в 1993 году, сегодня ЕРАМ Systems входит в число крупнейших ИТ-компаний мира.\r\nСегодня это офисы в 25-ти странах мира, 25 000 + сотрудников, из них 18 000+ разработчиков.\r\nEPAM Systems является признанным лидером в таких областях, как: Разработка, тестирование, сопровождение и поддержка заказного программного обеспечения и бизнес-приложений. Интеграция приложений, интеграция систем на базе продуктов SAP, Oracle, IBM, Microsoft. Создание выделенных центров разработки (центров компетенции), центров тестирования и контроля качества программного обеспечения ИТ-консалтинг с учетом отраслевой специфики бизнеса.\r\nВ Казахстане EPAM Systems  работает с 2008 года. Мы ведем проекты в городах Астана, Караганда, Атырау и Алматы.', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, NULL, NULL, '2017-08-01 02:40:21', '2017-08-01 12:20:29');

-- --------------------------------------------------------

--
-- Структура таблицы `company_images`
--

CREATE TABLE `company_images` (
  `company_id` int(10) UNSIGNED NOT NULL,
  `image_id` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `company_images`
--

INSERT INTO `company_images` (`company_id`, `image_id`, `sort`) VALUES
(1, 17, 0),
(1, 18, 1),
(1, 19, 2),
(1, 20, 3),
(1, 21, 4),
(1, 22, 5),
(1, 23, 6),
(1, 24, 7),
(1, 25, 8),
(1, 26, 9),
(1, 27, 10),
(1, 28, 11),
(1, 29, 12),
(1, 30, 13);

-- --------------------------------------------------------

--
-- Структура таблицы `company_industries`
--

CREATE TABLE `company_industries` (
  `company_id` int(10) UNSIGNED NOT NULL,
  `industry_id` int(10) UNSIGNED NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `company_revenues`
--

CREATE TABLE `company_revenues` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `company_revenues`
--

INSERT INTO `company_revenues` (`id`, `title`, `sort`, `created_at`, `updated_at`) VALUES
(1, '10 тыс - 50 тыс долл в год', 1, NULL, NULL),
(2, '50 тыс - 100 тыс долл в год', 2, NULL, NULL),
(3, '100 тыс - 500 тыс долл в год', 3, NULL, NULL),
(4, '500 тыс - 1 млн долл в год', 4, NULL, NULL),
(5, '1 млн - 5 млн долл в год', 5, NULL, NULL),
(6, '5 млн - 10 млн долл в год', 6, NULL, NULL),
(7, '10+ млн долл в год', 7, NULL, NULL),
(8, 'Неизвестно / Неприменимо', 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `company_sizes`
--

CREATE TABLE `company_sizes` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(50) NOT NULL,
  `employees_count` varchar(255) DEFAULT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `company_sizes`
--

INSERT INTO `company_sizes` (`id`, `alias`, `employees_count`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'SMALL', '1-50', 1, NULL, NULL),
(2, 'SMALL_TO_MEDIUM', '51-200', 2, NULL, NULL),
(3, 'MEDIUM', '201-500', 3, NULL, NULL),
(4, 'MEDIUM_TO_LARGE', '501-1000', 4, NULL, NULL),
(5, 'LARGE', '1001-5000', 5, NULL, NULL),
(6, 'LARGE_TO_GIANT', '5001-10000', 6, NULL, NULL),
(7, 'GIANT', '10000+', 7, NULL, NULL),
(8, 'UNKNOWN', 'Неизвестно', 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `iso_code` varchar(2) DEFAULT NULL COMMENT 'ISO 3166-1 alpha-2',
  `vk_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'id страны ВКонтакте',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `title`, `iso_code`, `vk_id`, `created_at`, `updated_at`) VALUES
(1, 'Казахстан', 'KZ', 4, NULL, NULL),
(2, 'Россия', 'RU', NULL, NULL, NULL),
(4, 'Австралия', NULL, NULL, NULL, NULL),
(5, 'Австрия', NULL, NULL, NULL, NULL),
(6, 'Азербайджан', NULL, NULL, NULL, NULL),
(7, 'Аландские острова', NULL, NULL, NULL, NULL),
(8, 'Албания', NULL, NULL, NULL, NULL),
(9, 'Алжир', NULL, NULL, NULL, NULL),
(10, 'Ангилья', NULL, NULL, NULL, NULL),
(11, 'Ангола', NULL, NULL, NULL, NULL),
(12, 'Андорра', NULL, NULL, NULL, NULL),
(13, 'Антигуа и Барбуда', NULL, NULL, NULL, NULL),
(14, 'Аргентина', NULL, NULL, NULL, NULL),
(15, 'Армения', NULL, NULL, NULL, NULL),
(16, 'Аруба', NULL, NULL, NULL, NULL),
(17, 'Афганистан', NULL, NULL, NULL, NULL),
(18, 'Багамы', NULL, NULL, NULL, NULL),
(19, 'Бангладеш', NULL, NULL, NULL, NULL),
(20, 'Барбадос', NULL, NULL, NULL, NULL),
(21, 'Бахрейн', NULL, NULL, NULL, NULL),
(22, 'Белиз', NULL, NULL, NULL, NULL),
(23, 'Белоруссия', NULL, NULL, NULL, NULL),
(24, 'Бельгия', NULL, NULL, NULL, NULL),
(25, 'Бенин', NULL, NULL, NULL, NULL),
(26, 'Бермуды', NULL, NULL, NULL, NULL),
(27, 'Болгария', NULL, NULL, NULL, NULL),
(28, 'Боливия', NULL, NULL, NULL, NULL),
(29, 'Бонэйр', NULL, NULL, NULL, NULL),
(30, 'Босния и Герцеговина', NULL, NULL, NULL, NULL),
(31, 'Ботсвана', NULL, NULL, NULL, NULL),
(32, 'Бразилия', NULL, NULL, NULL, NULL),
(33, 'Бруней', NULL, NULL, NULL, NULL),
(34, 'Буркина-Фасо', NULL, NULL, NULL, NULL),
(35, 'Бурунди', NULL, NULL, NULL, NULL),
(36, 'Бутан', NULL, NULL, NULL, NULL),
(37, 'Вануату', NULL, NULL, NULL, NULL),
(38, 'Ватикан', NULL, NULL, NULL, NULL),
(39, 'Великобритания', NULL, NULL, NULL, NULL),
(40, 'Венгрия', NULL, NULL, NULL, NULL),
(41, 'Венесуэла', NULL, NULL, NULL, NULL),
(42, 'Виргины (Американские)', NULL, NULL, NULL, NULL),
(43, 'Виргины (Британские)', NULL, NULL, NULL, NULL),
(44, 'Восточный Тимор', NULL, NULL, NULL, NULL),
(45, 'Вьетнам', NULL, NULL, NULL, NULL),
(46, 'Габон', NULL, NULL, NULL, NULL),
(47, 'Гаити', NULL, NULL, NULL, NULL),
(48, 'Гайана', NULL, NULL, NULL, NULL),
(49, 'Гамбия', NULL, NULL, NULL, NULL),
(50, 'Гана', NULL, NULL, NULL, NULL),
(51, 'Гваделупа', NULL, NULL, NULL, NULL),
(52, 'Гватемала', NULL, NULL, NULL, NULL),
(53, 'Гвиана', NULL, NULL, NULL, NULL),
(54, 'Гвинея', NULL, NULL, NULL, NULL),
(55, 'Гвинея-Бисау', NULL, NULL, NULL, NULL),
(56, 'Германия', NULL, NULL, NULL, NULL),
(57, 'Гернси', NULL, NULL, NULL, NULL),
(58, 'Гибралтар', NULL, NULL, NULL, NULL),
(59, 'Гондурас', NULL, NULL, NULL, NULL),
(60, 'Гонконг', NULL, NULL, NULL, NULL),
(61, 'Гренада', NULL, NULL, NULL, NULL),
(62, 'Гренландия', NULL, NULL, NULL, NULL),
(63, 'Греция', NULL, NULL, NULL, NULL),
(64, 'Грузия', NULL, NULL, NULL, NULL),
(65, 'Гуам', NULL, NULL, NULL, NULL),
(66, 'Дания', NULL, NULL, NULL, NULL),
(67, 'Джерси', NULL, NULL, NULL, NULL),
(68, 'Джибути', NULL, NULL, NULL, NULL),
(69, 'Доминика', NULL, NULL, NULL, NULL),
(70, 'Доминиканская Республика', NULL, NULL, NULL, NULL),
(71, 'ДНР', NULL, NULL, NULL, NULL),
(72, 'Египет', NULL, NULL, NULL, NULL),
(73, 'Замбия', NULL, NULL, NULL, NULL),
(74, 'Зимбабве', NULL, NULL, NULL, NULL),
(75, 'Израиль', NULL, NULL, NULL, NULL),
(76, 'Индия', NULL, NULL, NULL, NULL),
(77, 'Индонезия', NULL, NULL, NULL, NULL),
(78, 'Иордания', NULL, NULL, NULL, NULL),
(79, 'Ирак', NULL, NULL, NULL, NULL),
(80, 'Иран', NULL, NULL, NULL, NULL),
(81, 'Ирландия', NULL, NULL, NULL, NULL),
(82, 'Исландия', NULL, NULL, NULL, NULL),
(83, 'Испания', NULL, NULL, NULL, NULL),
(84, 'Италия', NULL, NULL, NULL, NULL),
(85, 'Йемен', NULL, NULL, NULL, NULL),
(86, 'Кабо-Верде', NULL, NULL, NULL, NULL),
(87, 'Кайманы', NULL, NULL, NULL, NULL),
(88, 'Камбоджа', NULL, NULL, NULL, NULL),
(89, 'Камерун', NULL, NULL, NULL, NULL),
(90, 'Канада', NULL, NULL, NULL, NULL),
(91, 'Катар', NULL, NULL, NULL, NULL),
(92, 'Кения', NULL, NULL, NULL, NULL),
(93, 'Кипр', NULL, NULL, NULL, NULL),
(94, 'Северный Кипр', NULL, NULL, NULL, NULL),
(95, 'Киргизия', NULL, NULL, NULL, NULL),
(96, 'Кирибати', NULL, NULL, NULL, NULL),
(97, 'Китай', NULL, NULL, NULL, NULL),
(98, 'Тайвань', NULL, NULL, NULL, NULL),
(99, 'Кокосовые острова', NULL, NULL, NULL, NULL),
(100, 'Колумбия', NULL, NULL, NULL, NULL),
(101, 'Коморские Острова', NULL, NULL, NULL, NULL),
(102, 'Конго', NULL, NULL, NULL, NULL),
(103, 'Республика Конго', NULL, NULL, NULL, NULL),
(104, 'Северная Корея', NULL, NULL, NULL, NULL),
(105, 'Южная Корея', NULL, NULL, NULL, NULL),
(106, 'Косово', NULL, NULL, NULL, NULL),
(107, 'Коста-Рика', NULL, NULL, NULL, NULL),
(108, 'Кот-д’Ивуар', NULL, NULL, NULL, NULL),
(109, 'Куба', NULL, NULL, NULL, NULL),
(110, 'Кувейт', NULL, NULL, NULL, NULL),
(111, 'Кука острова', NULL, NULL, NULL, NULL),
(112, 'Кюрасао', NULL, NULL, NULL, NULL),
(113, 'Лаос', NULL, NULL, NULL, NULL),
(114, 'Латвия', NULL, NULL, NULL, NULL),
(115, 'Лесото', NULL, NULL, NULL, NULL),
(116, 'Либерия', NULL, NULL, NULL, NULL),
(117, 'Ливан', NULL, NULL, NULL, NULL),
(118, 'Ливия', NULL, NULL, NULL, NULL),
(119, 'Литва', NULL, NULL, NULL, NULL),
(120, 'Лихтенштейн', NULL, NULL, NULL, NULL),
(121, 'ЛНР', NULL, NULL, NULL, NULL),
(122, 'Люксембург', NULL, NULL, NULL, NULL),
(123, 'Маврикий', NULL, NULL, NULL, NULL),
(124, 'Мавритания', NULL, NULL, NULL, NULL),
(125, 'Мадагаскар', NULL, NULL, NULL, NULL),
(126, 'Майотта', NULL, NULL, NULL, NULL),
(127, 'Макао', NULL, NULL, NULL, NULL),
(128, 'Македония', NULL, NULL, NULL, NULL),
(129, 'Малави', NULL, NULL, NULL, NULL),
(130, 'Малайзия', NULL, NULL, NULL, NULL),
(131, 'Мали', NULL, NULL, NULL, NULL),
(132, 'Мальдивы', NULL, NULL, NULL, NULL),
(133, 'Мальта', NULL, NULL, NULL, NULL),
(134, 'Марокко', NULL, NULL, NULL, NULL),
(135, 'Мартиника', NULL, NULL, NULL, NULL),
(136, 'Маршалловы Острова', NULL, NULL, NULL, NULL),
(137, 'Мексика', NULL, NULL, NULL, NULL),
(138, 'Микронезия', NULL, NULL, NULL, NULL),
(139, 'Мозамбик', NULL, NULL, NULL, NULL),
(140, 'Молдавия', NULL, NULL, NULL, NULL),
(141, 'Монако', NULL, NULL, NULL, NULL),
(142, 'Монголия', NULL, NULL, NULL, NULL),
(143, 'Монтсеррат', NULL, NULL, NULL, NULL),
(144, 'Мьянма', NULL, NULL, NULL, NULL),
(145, 'Мэн', NULL, NULL, NULL, NULL),
(146, 'Нагорно-Карабахская Республика', NULL, NULL, NULL, NULL),
(147, 'Намибия', NULL, NULL, NULL, NULL),
(148, 'Науру', NULL, NULL, NULL, NULL),
(149, 'Непал', NULL, NULL, NULL, NULL),
(150, 'Нигер', NULL, NULL, NULL, NULL),
(151, 'Нигерия', NULL, NULL, NULL, NULL),
(152, 'Нидерланды', NULL, NULL, NULL, NULL),
(153, 'Никарагуа', NULL, NULL, NULL, NULL),
(154, 'Ниуэ', NULL, NULL, NULL, NULL),
(155, 'Новая Зеландия', NULL, NULL, NULL, NULL),
(156, 'Новая Каледония', NULL, NULL, NULL, NULL),
(157, 'Норвегия', NULL, NULL, NULL, NULL),
(158, 'Норфолк остров', NULL, NULL, NULL, NULL),
(159, 'ОАЭ', NULL, NULL, NULL, NULL),
(160, 'Оман', NULL, NULL, NULL, NULL),
(161, 'Пакистан', NULL, NULL, NULL, NULL),
(162, 'Палау', NULL, NULL, NULL, NULL),
(163, 'Палестина', NULL, NULL, NULL, NULL),
(164, 'Панама', NULL, NULL, NULL, NULL),
(165, 'Папуа — Новая Гвинея', NULL, NULL, NULL, NULL),
(166, 'Парагвай', NULL, NULL, NULL, NULL),
(167, 'Перу', NULL, NULL, NULL, NULL),
(168, 'Питкэрн острова', NULL, NULL, NULL, NULL),
(169, 'Французская Полинезия', NULL, NULL, NULL, NULL),
(170, 'Польша', NULL, NULL, NULL, NULL),
(171, 'Португалия', NULL, NULL, NULL, NULL),
(172, 'ПМР', NULL, NULL, NULL, NULL),
(173, 'Пуэрто-Рико', NULL, NULL, NULL, NULL),
(174, 'Реюньон', NULL, NULL, NULL, NULL),
(175, 'остров Рождества', NULL, NULL, NULL, NULL),
(176, 'Руанда', NULL, NULL, NULL, NULL),
(177, 'Румыния', NULL, NULL, NULL, NULL),
(178, 'Саба', NULL, NULL, NULL, NULL),
(179, 'Сальвадор', NULL, NULL, NULL, NULL),
(180, 'Самоа', NULL, NULL, NULL, NULL),
(181, 'Самоа Американское', NULL, NULL, NULL, NULL),
(182, 'Сан-Марино', NULL, NULL, NULL, NULL),
(183, 'Сан-Томе и Принсипи', NULL, NULL, NULL, NULL),
(184, 'Саудовская Аравия', NULL, NULL, NULL, NULL),
(185, 'Западная Сахара', NULL, NULL, NULL, NULL),
(186, 'Свазиленд', NULL, NULL, NULL, NULL),
(187, 'Святой Елены, Вознесения и Тристан-да-Кунья острова', NULL, NULL, NULL, NULL),
(188, 'Северные Марианские острова', NULL, NULL, NULL, NULL),
(189, 'Сейшельские Острова', NULL, NULL, NULL, NULL),
(190, 'Сенегал', NULL, NULL, NULL, NULL),
(191, 'Сен-Бартелеми', NULL, NULL, NULL, NULL),
(192, 'Сен-Мартен', NULL, NULL, NULL, NULL),
(193, 'Сен-Пьер и Микелон', NULL, NULL, NULL, NULL),
(194, 'Сент-Винсент и Гренадины', NULL, NULL, NULL, NULL),
(195, 'Сент-Китс и Невис', NULL, NULL, NULL, NULL),
(196, 'Сент-Люсия', NULL, NULL, NULL, NULL),
(197, 'Сербия', NULL, NULL, NULL, NULL),
(198, 'Сингапур', NULL, NULL, NULL, NULL),
(199, 'Синт-Мартен', NULL, NULL, NULL, NULL),
(200, 'Синт-Эстатиус', NULL, NULL, NULL, NULL),
(201, 'Сирия', NULL, NULL, NULL, NULL),
(202, 'Словакия', NULL, NULL, NULL, NULL),
(203, 'Словения', NULL, NULL, NULL, NULL),
(204, 'США', NULL, NULL, NULL, NULL),
(205, 'Соломоны', NULL, NULL, NULL, NULL),
(206, 'Сомали', NULL, NULL, NULL, NULL),
(207, 'Судан', NULL, NULL, NULL, NULL),
(208, 'Суринам', NULL, NULL, NULL, NULL),
(209, 'Сьерра-Леоне', NULL, NULL, NULL, NULL),
(210, 'Таджикистан', NULL, NULL, NULL, NULL),
(211, 'Таиланд', NULL, NULL, NULL, NULL),
(212, 'Танзания', NULL, NULL, NULL, NULL),
(213, 'Тёркс и Кайкос', NULL, NULL, NULL, NULL),
(214, 'Того', NULL, NULL, NULL, NULL),
(215, 'Токелау', NULL, NULL, NULL, NULL),
(216, 'Тонга', NULL, NULL, NULL, NULL),
(217, 'Тринидад и Тобаго', NULL, NULL, NULL, NULL),
(218, 'Тувалу', NULL, NULL, NULL, NULL),
(219, 'Тунис', NULL, NULL, NULL, NULL),
(220, 'Туркмения', NULL, NULL, NULL, NULL),
(221, 'Турция', NULL, NULL, NULL, NULL),
(222, 'Уганда', NULL, NULL, NULL, NULL),
(223, 'Узбекистан', NULL, NULL, NULL, NULL),
(224, 'Украина', NULL, NULL, NULL, NULL),
(225, 'Уоллис и Футуна', NULL, NULL, NULL, NULL),
(226, 'Уругвай', NULL, NULL, NULL, NULL),
(227, 'Фареры', NULL, NULL, NULL, NULL),
(228, 'Фиджи', NULL, NULL, NULL, NULL),
(229, 'Филиппины', NULL, NULL, NULL, NULL),
(230, 'Финляндия', NULL, NULL, NULL, NULL),
(231, 'Фолклендские острова', NULL, NULL, NULL, NULL),
(232, 'Франция', NULL, NULL, NULL, NULL),
(233, 'Хорватия', NULL, NULL, NULL, NULL),
(234, 'ЦАР', NULL, NULL, NULL, NULL),
(235, 'Чад', NULL, NULL, NULL, NULL),
(236, 'Черногория', NULL, NULL, NULL, NULL),
(237, 'Чехия', NULL, NULL, NULL, NULL),
(238, 'Чили', NULL, NULL, NULL, NULL),
(239, 'Швейцария', NULL, NULL, NULL, NULL),
(240, 'Швеция', NULL, NULL, NULL, NULL),
(241, 'Шри-Ланка', NULL, NULL, NULL, NULL),
(242, 'Эквадор', NULL, NULL, NULL, NULL),
(243, 'Экваториальная Гвинея', NULL, NULL, NULL, NULL),
(244, 'Эритрея', NULL, NULL, NULL, NULL),
(245, 'Эстония', NULL, NULL, NULL, NULL),
(246, 'Эфиопия', NULL, NULL, NULL, NULL),
(247, 'Южная Осетия', NULL, NULL, NULL, NULL),
(248, 'ЮАР', NULL, NULL, NULL, NULL),
(249, 'Южный Судан', NULL, NULL, NULL, NULL),
(250, 'Ямайка', NULL, NULL, NULL, NULL),
(251, 'Япония', NULL, NULL, NULL, NULL),
(253, 'Абхазия', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `currencies`
--

CREATE TABLE `currencies` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(3) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `symbol` varchar(1) DEFAULT NULL COMMENT 'символ волюты',
  `short` varchar(5) DEFAULT NULL COMMENT 'сокращеное название (тг, руб)',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `title`, `symbol`, `short`, `created_at`, `updated_at`) VALUES
(1, 'AUD', 'Австралийский доллар', NULL, NULL, NULL, NULL),
(2, 'AZN', 'Азербайджанский манат', NULL, NULL, NULL, NULL),
(3, 'DZD', 'Алжирский динар', NULL, NULL, NULL, NULL),
(4, 'ARS', 'Аргентинское песо', NULL, NULL, NULL, NULL),
(5, 'AMD', 'Армянский драм', NULL, NULL, NULL, NULL),
(6, 'AWG', 'Арубанский флорин', NULL, NULL, NULL, NULL),
(7, 'AFN', 'Афгани', NULL, NULL, NULL, NULL),
(8, 'BSD', 'Багамский доллар', NULL, NULL, NULL, NULL),
(9, 'PAB', 'Бальбоа', NULL, NULL, NULL, NULL),
(10, 'BBD', 'Барбадосский доллар', NULL, NULL, NULL, NULL),
(11, 'THB', 'Бат', NULL, NULL, NULL, NULL),
(12, 'BHD', 'Бахрейнский динар', NULL, NULL, NULL, NULL),
(13, 'BZD', 'Белизский доллар', NULL, NULL, NULL, NULL),
(14, 'BYR', 'Белорусский рубль', NULL, NULL, NULL, NULL),
(15, 'BMD', 'Бермудский доллар', NULL, NULL, NULL, NULL),
(16, 'BGN', 'Болгарский лев', NULL, NULL, NULL, NULL),
(17, 'VEF', 'Боливар фуэрте', NULL, NULL, NULL, NULL),
(18, 'BOB', 'Боливиано', NULL, NULL, NULL, NULL),
(19, 'BRL', 'Бразильский реал', NULL, NULL, NULL, NULL),
(20, 'BND', 'Брунейский доллар', NULL, NULL, NULL, NULL),
(21, 'BIF', 'Бурундийский франк', NULL, NULL, NULL, NULL),
(22, 'VUV', 'Вату', NULL, NULL, NULL, NULL),
(23, 'KRW', 'Вона', NULL, NULL, NULL, NULL),
(24, 'XCD', 'Восточно-карибский доллар', NULL, NULL, NULL, NULL),
(25, 'GYD', 'Гайанский доллар', NULL, NULL, NULL, NULL),
(26, 'GHS', 'Ганский седи', NULL, NULL, NULL, NULL),
(27, 'GNF', 'Гвинейский франк', NULL, NULL, NULL, NULL),
(28, 'GIP', 'Гибралтарский фунт', NULL, NULL, NULL, NULL),
(29, 'HKD', 'Гонконгский доллар', NULL, NULL, NULL, NULL),
(30, 'UAH', 'Гривна', NULL, 'грн', NULL, NULL),
(31, 'PYG', 'Гуарани', NULL, NULL, NULL, NULL),
(32, 'HTG', 'Гурд', NULL, NULL, NULL, NULL),
(33, 'GMD', 'Даласи', NULL, NULL, NULL, NULL),
(34, 'DKK', 'Датская крона', NULL, NULL, NULL, NULL),
(35, 'MKD', 'Денар', NULL, NULL, NULL, NULL),
(36, 'AED', 'Дирхам ОАЭ', NULL, NULL, NULL, NULL),
(37, 'STD', 'Добра', NULL, NULL, NULL, NULL),
(38, 'ZWL', 'Доллар Зимбабве', NULL, NULL, NULL, NULL),
(39, 'NAD', 'Доллар Намибии', NULL, NULL, NULL, NULL),
(40, 'KYD', 'Доллар Островов Кайман', NULL, NULL, NULL, NULL),
(41, 'SBD', 'Доллар Соломоновых Островов', NULL, NULL, NULL, NULL),
(42, 'USD', 'Доллар США', NULL, 'usd', NULL, NULL),
(43, 'TTD', 'Доллар Тринидада и Тобаго', NULL, NULL, NULL, NULL),
(44, 'FJD', 'Доллар Фиджи', NULL, NULL, NULL, NULL),
(45, 'DOP', 'Доминиканское песо', NULL, NULL, NULL, NULL),
(46, 'VND', 'Донг', NULL, NULL, NULL, NULL),
(47, 'EUR', 'Евро', NULL, 'eur', NULL, NULL),
(48, 'EGP', 'Египетский фунт', NULL, NULL, NULL, NULL),
(49, 'ZMW', 'Замбийская квача', NULL, NULL, NULL, NULL),
(50, 'PLN', 'Злотый', NULL, NULL, NULL, NULL),
(51, 'NIO', 'Золотая кордоба', NULL, NULL, NULL, NULL),
(52, 'JPY', 'Иена', NULL, NULL, NULL, NULL),
(53, 'INR', 'Индийская рупия', NULL, NULL, NULL, NULL),
(54, 'JOD', 'Иорданский динар', NULL, NULL, NULL, NULL),
(55, 'IQD', 'Иракский динар', NULL, NULL, NULL, NULL),
(56, 'IRR', 'Иранский риал', NULL, NULL, NULL, NULL),
(57, 'ISK', 'Исландская крона', NULL, NULL, NULL, NULL),
(58, 'YER', 'Йеменский риал', NULL, NULL, NULL, NULL),
(59, 'CAD', 'Канадский доллар', NULL, NULL, NULL, NULL),
(60, 'QAR', 'Катарский риал', NULL, NULL, NULL, NULL),
(61, 'AOA', 'Кванза', NULL, NULL, NULL, NULL),
(62, 'MWK', 'Квача', NULL, NULL, NULL, NULL),
(63, 'KES', 'Кенийский шиллинг', NULL, NULL, NULL, NULL),
(64, 'GTQ', 'Кетсаль', NULL, NULL, NULL, NULL),
(65, 'PGK', 'Кина', NULL, NULL, NULL, NULL),
(66, 'LAK', 'Кип', NULL, NULL, NULL, NULL),
(67, 'COP', 'Колумбийское песо', NULL, NULL, NULL, NULL),
(68, 'BAM', 'Конвертируемая марка', NULL, NULL, NULL, NULL),
(69, 'CDF', 'Конголезский франк', NULL, NULL, NULL, NULL),
(70, 'CRC', 'Коста-риканский колон', NULL, NULL, NULL, NULL),
(71, 'CUP', 'Кубинское песо', NULL, NULL, NULL, NULL),
(72, 'KWD', 'Кувейтский динар', NULL, NULL, NULL, NULL),
(73, 'MMK', 'Кьят', NULL, NULL, NULL, NULL),
(74, 'GEL', 'Лари', NULL, NULL, NULL, NULL),
(75, 'ALL', 'Лек', NULL, NULL, NULL, NULL),
(76, 'HNL', 'Лемпира', NULL, NULL, NULL, NULL),
(77, 'SLL', 'Леоне', NULL, NULL, NULL, NULL),
(78, 'LRD', 'Либерийский доллар', NULL, NULL, NULL, NULL),
(79, 'LBP', 'Ливанский фунт', NULL, NULL, NULL, NULL),
(80, 'LYD', 'Ливийский динар', NULL, NULL, NULL, NULL),
(81, 'SZL', 'Лилангени', NULL, NULL, NULL, NULL),
(82, 'LSL', 'Лоти', NULL, NULL, NULL, NULL),
(83, 'MUR', 'Маврикийская рупия', NULL, NULL, NULL, NULL),
(84, 'MGA', 'Малагасийский ариари', NULL, NULL, NULL, NULL),
(85, 'MYR', 'Малайзийский ринггит', NULL, NULL, NULL, NULL),
(86, 'MAD', 'Марокканский дирхам', NULL, NULL, NULL, NULL),
(87, 'MXN', 'Мексиканское песо', NULL, NULL, NULL, NULL),
(88, 'MZN', 'Мозамбикский метикал', NULL, NULL, NULL, NULL),
(89, 'MDL', 'Молдавский лей', NULL, NULL, NULL, NULL),
(90, 'NGN', 'Найра', NULL, NULL, NULL, NULL),
(91, 'ERN', 'Накфа', NULL, NULL, NULL, NULL),
(92, 'BTN', 'Нгултрум', NULL, NULL, NULL, NULL),
(93, 'NPR', 'Непальская рупия', NULL, NULL, NULL, NULL),
(94, 'ANG', 'нидерландский антильский гульден', NULL, NULL, NULL, NULL),
(95, 'NZD', 'Новозеландский доллар', NULL, NULL, NULL, NULL),
(96, 'ILS', 'Новый израильский шекель', NULL, NULL, NULL, NULL),
(97, 'RON', 'Новый румынский лей', NULL, NULL, NULL, NULL),
(98, 'PEN', 'Новый соль', NULL, NULL, NULL, NULL),
(99, 'TWD', 'Новый тайваньский доллар', NULL, NULL, NULL, NULL),
(100, 'TMT', 'Новый туркменский манат', NULL, NULL, NULL, NULL),
(101, 'NOK', 'Норвежская крона', NULL, NULL, NULL, NULL),
(102, 'OMR', 'Оманский риал', NULL, NULL, NULL, NULL),
(103, 'TOP', 'Паанга', NULL, NULL, NULL, NULL),
(104, 'PKR', 'Пакистанская рупия', NULL, NULL, NULL, NULL),
(105, 'MOP', 'Патака', NULL, NULL, NULL, NULL),
(106, 'PRB', 'Приднестровский рубль', NULL, NULL, NULL, NULL),
(107, 'BWP', 'Пула', NULL, NULL, NULL, NULL),
(108, 'KHR', 'Риель', NULL, NULL, NULL, NULL),
(109, 'RUB', 'Российский рубль', NULL, 'руб', NULL, NULL),
(110, 'IDR', 'Рупия', NULL, NULL, NULL, NULL),
(111, 'MVR', 'Руфия', NULL, NULL, NULL, NULL),
(112, 'ZAR', 'Рэнд', NULL, NULL, NULL, NULL),
(113, 'SVC', 'Сальвадорский колон', NULL, NULL, NULL, NULL),
(114, 'SAR', 'Саудовский риял', NULL, NULL, NULL, NULL),
(115, 'KPW', 'Северокорейская вона', NULL, NULL, NULL, NULL),
(116, 'SCR', 'Сейшельская рупия', NULL, NULL, NULL, NULL),
(117, 'RSD', 'Сербский динар', NULL, NULL, NULL, NULL),
(118, 'SGD', 'Сингапурский доллар', NULL, NULL, NULL, NULL),
(119, 'SYP', 'Сирийский фунт', NULL, NULL, NULL, NULL),
(120, 'KGS', 'Сом', NULL, NULL, NULL, NULL),
(121, 'SOS', 'Сомалийский шиллинг', NULL, NULL, NULL, NULL),
(122, 'TJS', 'Сомони', NULL, NULL, NULL, NULL),
(123, 'SDG', 'Суданский фунт', NULL, NULL, NULL, NULL),
(124, 'SRD', 'Суринамский доллар', NULL, NULL, NULL, NULL),
(125, 'BDT', 'Така', NULL, NULL, NULL, NULL),
(126, 'WST', 'Тала', NULL, NULL, NULL, NULL),
(127, 'TZS', 'Танзанийский шиллинг', NULL, NULL, NULL, NULL),
(128, 'KZT', 'Тенге', '₸', 'тг', NULL, NULL),
(129, 'MNT', 'Тугрик', NULL, NULL, NULL, NULL),
(130, 'TND', 'Тунисский динар', NULL, NULL, NULL, NULL),
(131, 'TRY', 'Турецкая лира', NULL, NULL, NULL, NULL),
(132, 'UGX', 'Угандийский шиллинг', NULL, NULL, NULL, NULL),
(133, 'MRO', 'Угия', NULL, NULL, NULL, NULL),
(134, 'UZS', 'Узбекский сум', NULL, NULL, NULL, NULL),
(135, 'UYU', 'Уругвайское песо', NULL, NULL, NULL, NULL),
(136, 'PHP', 'Филиппинское песо', NULL, NULL, NULL, NULL),
(137, 'HUF', 'Форинт', NULL, NULL, NULL, NULL),
(138, 'DJF', 'Франк Джибути', NULL, NULL, NULL, NULL),
(139, 'KMF', 'Франк Комор', NULL, NULL, NULL, NULL),
(140, 'XOF', 'Франк КФА BCEAO', NULL, NULL, NULL, NULL),
(141, 'XAF', 'Франк КФА BEAC', NULL, NULL, NULL, NULL),
(142, 'XPF', 'Франк КФП', NULL, NULL, NULL, NULL),
(143, 'RWF', 'Франк Руанды', NULL, NULL, NULL, NULL),
(144, 'SHP', 'Фунт Святой Елены', NULL, NULL, NULL, NULL),
(145, 'GBP', 'Фунт стерлингов', NULL, NULL, NULL, NULL),
(146, 'FKP', 'Фунт Фолклендских островов', NULL, NULL, NULL, NULL),
(147, 'HRK', 'Хорватская куна', NULL, NULL, NULL, NULL),
(148, 'CZK', 'Чешская крона', NULL, NULL, NULL, NULL),
(149, 'CLP', 'Чилийское песо', NULL, NULL, NULL, NULL),
(150, 'SEK', 'Шведская крона', NULL, NULL, NULL, NULL),
(151, 'CHF', 'Швейцарский франк', NULL, NULL, NULL, NULL),
(152, 'LKR', 'Шри-ланкийская рупия', NULL, NULL, NULL, NULL),
(153, 'CVE', 'Эскудо Кабо-Верде', NULL, NULL, NULL, NULL),
(154, 'ETB', 'Эфиопский быр', NULL, NULL, NULL, NULL),
(155, 'CNY', 'Юань', NULL, NULL, NULL, NULL),
(156, 'SSP', 'Южносуданский фунт', NULL, NULL, NULL, NULL),
(157, 'JMD', 'Ямайский доллар', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `education_forms`
--

CREATE TABLE `education_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'название формы обучения',
  `vk_education_form` varchar(255) NOT NULL COMMENT 'форма обучения ВКонтакте',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `education_forms`
--

INSERT INTO `education_forms` (`id`, `title`, `vk_education_form`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'Очная', 'Очное отделение', 1, NULL, NULL),
(2, 'Очно-заочная', 'Очно-заочное отделение', 2, NULL, NULL),
(3, 'Заочная', 'Заочное отделение', 3, NULL, NULL),
(4, 'Экстернат', 'Экстернат', 4, NULL, NULL),
(5, 'Дистанционная', 'Дистанционное обучение', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `education_statuses`
--

CREATE TABLE `education_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `education_statuses`
--

INSERT INTO `education_statuses` (`id`, `title`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'Абитуриент', 1, NULL, NULL),
(5, 'Аспирант', 8, NULL, NULL),
(6, 'Кандидат наук', 9, NULL, NULL),
(7, 'Доктор наук', 10, NULL, NULL),
(8, 'Студент (специалист)', 2, NULL, NULL),
(9, 'Студент (бакалавр)', 3, NULL, NULL),
(10, 'Студент (магистр)', 4, NULL, NULL),
(11, 'Выпускник (специалист)', 5, NULL, NULL),
(12, 'Выпускник (бакалавр)', 6, NULL, NULL),
(13, 'Выпускник (магистр)', 7, NULL, NULL),
(14, 'Интерн', 11, NULL, NULL),
(15, 'Клинический ординатор', 12, NULL, NULL),
(16, 'Соискатель', 13, NULL, NULL),
(17, 'Ассистент-стажёр', 14, NULL, NULL),
(18, 'Докторант', 15, NULL, NULL),
(19, 'Адъюнкт', 16, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `employment_forms`
--

CREATE TABLE `employment_forms` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `employment_forms`
--

INSERT INTO `employment_forms` (`id`, `alias`, `title`, `sort`, `created_at`, `updated_at`) VALUES
(1, 'watch', 'Вахтовый метод', 5, NULL, NULL),
(2, 'volunteer', 'Волонтерство', 4, NULL, NULL),
(3, 'full', 'Полная занятость', 1, NULL, NULL),
(4, 'project', 'Проектная / Временная работа', 3, NULL, NULL),
(5, 'remote', 'Удаленная работа', 0, NULL, NULL),
(6, 'part', 'Частичная занятость', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `faculties`
--

CREATE TABLE `faculties` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `university_id` int(10) UNSIGNED DEFAULT NULL,
  `vk_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'id факультета ВКонтакте',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `faculties`
--

INSERT INTO `faculties` (`id`, `title`, `university_id`, `vk_id`, `created_at`, `updated_at`) VALUES
(1, 'Горный факультет', 2, NULL, NULL, NULL),
(2, 'Архитектурно-строительный факультет', 2, NULL, NULL, NULL),
(3, 'Факультет энергетики и телекоммуникации', 2, NULL, NULL, NULL),
(4, 'Машиностроительный факультет', 2, NULL, NULL, NULL),
(5, 'Транспортно-дорожный факультет', 2, NULL, NULL, NULL),
(6, 'Факультет информационных технологий', 2, NULL, NULL, NULL),
(7, 'Факультет экономики и менеджмента', 2, NULL, NULL, NULL),
(8, 'Факультет заочного и дистанционного обучения', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `width` int(10) UNSIGNED DEFAULT NULL,
  `height` int(10) UNSIGNED DEFAULT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `optimised` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'картинка оптимизирована',
  `modifier` varchar(255) DEFAULT NULL COMMENT 'модификатор',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `path`, `width`, `height`, `parent_id`, `optimised`, `modifier`, `created_at`, `updated_at`) VALUES
(1, '/uploads/5974a481e8f95.jpg', NULL, NULL, NULL, 0, NULL, '2017-07-23 07:28:33', '2017-07-23 07:28:33'),
(2, '/uploads/5974a52ac75a2.jpg', 600, 600, NULL, 1, NULL, '2017-07-23 07:31:22', '2017-07-23 07:33:17'),
(3, '/uploads/5974a54743451.jpg', 1848, 682, NULL, 1, NULL, '2017-07-23 07:31:51', '2017-07-23 09:28:09'),
(4, '/uploads/5974a52ac75a2-r50x50.jpg', 50, 50, 2, 1, 'r50x50', '2017-07-23 07:33:18', '2017-07-23 07:33:18'),
(5, '/uploads/5974a52ac75a2-r250x250.jpg', 250, 250, 2, 1, 'r250x250', '2017-07-23 08:20:35', '2017-07-23 08:20:35'),
(6, '/uploads/5974a54743451-r970x291.jpg', 788, 291, 3, 1, 'r970x291', '2017-07-23 09:28:09', '2017-07-23 09:28:09'),
(7, '/uploads/5974a52ac75a2-r640x640.jpg', 600, 600, 2, 1, 'r640x640', '2017-07-26 13:12:28', '2017-07-26 13:12:29'),
(9, '/uploads/597a45dc42875-r50x50.jpg', 50, 28, 8, 1, 'r50x50', '2017-07-27 14:00:52', '2017-07-27 14:00:52'),
(10, '/uploads/597a45dc42875-f50x50.jpg', 50, 50, 8, 1, 'f50x50', '2017-07-27 14:14:25', '2017-07-27 14:14:25'),
(11, '/uploads/597a45dc42875-r200x200.jpg', 200, 111, 8, 1, 'r200x200', '2017-07-27 14:25:25', '2017-07-27 14:25:25'),
(12, '/uploads/597a45dc42875-f200x200.jpg', 200, 200, 8, 1, 'f200x200', '2017-07-27 14:27:17', '2017-07-27 14:27:17'),
(14, '/uploads/597a532ca266f-f50x50.jpg', 50, 50, 13, 1, 'f50x50', '2017-07-27 14:55:08', '2017-07-27 14:55:08'),
(17, '/uploads/597a5437a2981.jpg', 628, 350, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:35'),
(18, '/uploads/597a5437a30a0.jpg', 750, 1125, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:36'),
(19, '/uploads/597a5437a3609.jpg', 1920, 1080, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:36'),
(20, '/uploads/597a5437a3ba7.jpg', 736, 490, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:36'),
(21, '/uploads/597a5437a41e5.jpg', 1366, 768, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:36'),
(22, '/uploads/597a5437a476f.jpg', 1366, 768, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:36'),
(23, '/uploads/597a5437a4cce.jpg', 1920, 1080, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:37'),
(24, '/uploads/597a5437a51fb.jpg', 1366, 768, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:37'),
(25, '/uploads/597a5437a5716.jpg', 1366, 768, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:37'),
(26, '/uploads/597a5437a5c8e.jpg', 1366, 768, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:37'),
(27, '/uploads/597a5437a61e4.jpg', 1366, 768, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:38'),
(28, '/uploads/597a5437a673d.jpg', 1366, 768, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:38'),
(29, '/uploads/597a5437a6d0d.jpg', 1366, 768, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:38'),
(30, '/uploads/597a5437a721d.jpg', 1920, 1080, NULL, 1, NULL, '2017-07-27 14:59:35', '2017-07-27 14:59:38'),
(31, '/uploads/597a5437a2981-f50x50.jpg', 50, 50, 17, 1, 'f50x50', '2017-07-27 14:59:35', '2017-07-27 14:59:35'),
(32, '/uploads/597a5437a30a0-f50x50.jpg', 50, 50, 18, 1, 'f50x50', '2017-07-27 14:59:36', '2017-07-27 14:59:36'),
(33, '/uploads/597a5437a3609-f50x50.jpg', 50, 50, 19, 1, 'f50x50', '2017-07-27 14:59:36', '2017-07-27 14:59:36'),
(34, '/uploads/597a5437a3ba7-f50x50.jpg', 50, 50, 20, 1, 'f50x50', '2017-07-27 14:59:36', '2017-07-27 14:59:36'),
(35, '/uploads/597a5437a41e5-f50x50.jpg', 50, 50, 21, 1, 'f50x50', '2017-07-27 14:59:36', '2017-07-27 14:59:36'),
(36, '/uploads/597a5437a476f-f50x50.jpg', 50, 50, 22, 1, 'f50x50', '2017-07-27 14:59:36', '2017-07-27 14:59:37'),
(37, '/uploads/597a5437a4cce-f50x50.jpg', 50, 50, 23, 1, 'f50x50', '2017-07-27 14:59:37', '2017-07-27 14:59:37'),
(38, '/uploads/597a5437a51fb-f50x50.jpg', 50, 50, 24, 1, 'f50x50', '2017-07-27 14:59:37', '2017-07-27 14:59:37'),
(39, '/uploads/597a5437a5716-f50x50.jpg', 50, 50, 25, 1, 'f50x50', '2017-07-27 14:59:37', '2017-07-27 14:59:37'),
(40, '/uploads/597a5437a5c8e-f50x50.jpg', 50, 50, 26, 1, 'f50x50', '2017-07-27 14:59:37', '2017-07-27 14:59:37'),
(41, '/uploads/597a5437a61e4-f50x50.jpg', 50, 50, 27, 1, 'f50x50', '2017-07-27 14:59:38', '2017-07-27 14:59:38'),
(42, '/uploads/597a5437a673d-f50x50.jpg', 50, 50, 28, 1, 'f50x50', '2017-07-27 14:59:38', '2017-07-27 14:59:38'),
(43, '/uploads/597a5437a6d0d-f50x50.jpg', 50, 50, 29, 1, 'f50x50', '2017-07-27 14:59:38', '2017-07-27 14:59:38'),
(44, '/uploads/597a5437a721d-f50x50.jpg', 50, 50, 30, 1, 'f50x50', '2017-07-27 14:59:38', '2017-07-27 14:59:38'),
(45, '/uploads/597a5437a2981-f200x200.jpg', 200, 200, 17, 1, 'f200x200', '2017-07-27 14:59:57', '2017-07-27 14:59:57'),
(46, '/uploads/597a5437a30a0-f200x200.jpg', 200, 200, 18, 1, 'f200x200', '2017-07-27 14:59:57', '2017-07-27 14:59:57'),
(47, '/uploads/597a5437a3609-f200x200.jpg', 200, 200, 19, 1, 'f200x200', '2017-07-27 14:59:57', '2017-07-27 14:59:57'),
(48, '/uploads/59803eef89f7b.jpg', 1260, 1260, NULL, 1, NULL, '2017-08-01 02:42:23', '2017-08-01 02:43:31'),
(49, '/uploads/59803eef89f7b-r640x640.jpg', 640, 640, 48, 1, 'r640x640', '2017-08-01 02:43:31', '2017-08-01 02:43:31'),
(50, '/uploads/59803eef89f7b-r50x50.jpg', 50, 50, 48, 1, 'r50x50', '2017-08-01 02:47:23', '2017-08-01 02:47:23'),
(51, '/uploads/59803eef89f7b-r250x250.jpg', 250, 250, 48, 1, 'r250x250', '2017-08-01 07:53:20', '2017-08-01 07:53:21'),
(52, '/uploads/59803eef89f7b-r200x200.jpg', 200, 200, 48, 1, 'r200x200', '2017-08-11 06:35:21', '2017-08-11 06:35:21'),
(53, '/uploads/5974a52ac75a2-r200x200.jpg', 200, 200, 2, 1, 'r200x200', '2017-08-11 07:31:36', '2017-08-11 07:31:36');

-- --------------------------------------------------------

--
-- Структура таблицы `industries`
--

CREATE TABLE `industries` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'направление одобрено',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `industries`
--

INSERT INTO `industries` (`id`, `title`, `approved`, `created_at`, `updated_at`) VALUES
(59, 'Программное и аппаратное обеспечение', 0, NULL, NULL),
(63, 'ПО для предприятий и сетевые решения', 0, NULL, NULL),
(64, 'Интернет', 1, NULL, NULL),
(65, 'IT услуги', 1, NULL, NULL),
(66, 'Услуги здравоохранения и больницы', 0, NULL, NULL),
(67, 'Производство асфальта', 0, NULL, NULL),
(68, 'Химическое производство', 0, NULL, NULL),
(69, 'Производство потребительских товаров', 0, NULL, NULL),
(70, 'Производство электроники', 0, NULL, NULL),
(71, 'Производство продуктов питания и напитков', 0, NULL, NULL),
(72, 'Производство продуктов здравоохранения', 0, NULL, NULL),
(73, 'Промышленное производство', 0, NULL, NULL),
(74, 'Производство металлов и минералов', 0, NULL, NULL),
(75, 'Производство оборудования для транспортировки', 0, NULL, NULL),
(76, 'Производство древесных изделий', 0, NULL, NULL),
(77, 'Прочее производство', 0, NULL, NULL),
(78, 'Страховые агентства и Брокерские услуги', 0, NULL, NULL),
(79, 'Страховые компании', 0, NULL, NULL),
(80, 'Колледжи и университеты', 0, NULL, NULL),
(81, 'Образовательные услуги', 0, NULL, NULL),
(82, 'Средние школы', 0, NULL, NULL),
(83, 'Дошкольное образование и уход за детьми', 0, NULL, NULL),
(84, 'Прокат потребительских товаров', 0, NULL, NULL),
(85, 'Ритуальные услуги', 0, NULL, NULL),
(86, 'Здоровье, красота и спорт', 0, NULL, NULL),
(87, 'Прачечные и химчистки', 0, NULL, NULL),
(88, 'Охрана', 0, NULL, NULL),
(89, 'Ветеринарные службы', 0, NULL, NULL),
(90, 'Государственные учреждения', 0, NULL, NULL),
(91, 'Банки и кредитные организации', 0, NULL, NULL),
(92, 'Брокерские услуги', 0, NULL, NULL),
(93, 'Финансовая аналитика и исследования', 0, NULL, NULL),
(94, 'Обработка финансовых операций', 0, NULL, NULL),
(95, 'Инвестиционно-банковские услуги и управление активами', 0, NULL, NULL),
(96, 'Кредитование', 0, NULL, NULL),
(97, 'Фондовые биржи', 0, NULL, NULL),
(98, 'Венчурный капитал и частные инвестиции', 0, NULL, NULL),
(99, 'Биотехнологии и фармацевтика', 0, NULL, NULL),
(100, 'Развлечения для взрослых', 0, NULL, NULL),
(101, 'Аудиовизуальные развлечения', 0, NULL, NULL),
(102, 'Бары и ночные клубы', 0, NULL, NULL),
(103, 'Игорный бизнес', 0, NULL, NULL),
(104, 'Кинотеатры', 0, NULL, NULL),
(105, 'Музеи, зоопарки и парки развлечений', 0, NULL, NULL),
(106, 'Театры', 0, NULL, NULL),
(107, 'Фотография', 0, NULL, NULL),
(108, 'Спорт и отдых', 0, NULL, NULL),
(109, 'Модельные агентства', 0, NULL, NULL),
(110, 'Продажа билетов', 0, NULL, NULL),
(111, 'Ремонт автомобилей и техническое обслуживание', 0, NULL, NULL),
(112, 'Ремонт и техническое обслуживание коммерческого оборудования', 0, NULL, NULL),
(113, 'Строительство', 0, NULL, NULL),
(114, 'Общий ремонт и техническое обслуживание', 0, NULL, NULL),
(115, 'Реклама и маркетинг', 1, NULL, NULL),
(116, 'Архитектурные и инженерные услуги', 0, NULL, NULL),
(117, 'Кадровые услуги', 0, NULL, NULL),
(118, 'Аренда коммерческого оборудования', 0, NULL, NULL),
(119, 'Обслуживание бизнес центров и супермарктов', 0, NULL, NULL),
(120, 'Коммерческая полиграфия', 0, NULL, NULL),
(121, 'Консалтинг', 0, NULL, NULL),
(122, 'Членские организации', 0, NULL, NULL),
(123, 'Исследование и разработка', 0, NULL, NULL),
(124, 'Охранные услуги', 0, NULL, NULL),
(125, 'Аутсорсинг', 0, NULL, NULL),
(126, 'Оптовые продажи', 0, NULL, NULL),
(127, 'Бухгалтерские услуги', 0, NULL, NULL),
(128, 'Юридические услуги', 0, NULL, NULL),
(129, 'Животноводство', 0, NULL, NULL),
(130, 'Коммерческое рыболовство', 0, NULL, NULL),
(131, 'Вспомогательные услуги для фермы', 0, NULL, NULL),
(132, 'Цветники', 0, NULL, NULL),
(133, 'Производство продуктов питания', 0, NULL, NULL),
(134, 'Деревообработка и заготовка', 0, NULL, NULL),
(135, 'Оборонный комплекс', 0, NULL, NULL),
(136, 'Аренда коммерческого транспорта и оборудования', 0, NULL, NULL),
(137, 'Службы экспресс-доставки', 0, NULL, NULL),
(138, 'Логистика и управление поставками', 0, NULL, NULL),
(139, 'Услуги по переезду', 0, NULL, NULL),
(140, 'Автостоянки и гаражи', 0, NULL, NULL),
(141, 'Железнодорожные компании', 0, NULL, NULL),
(142, 'Судоходные компании', 0, NULL, NULL),
(143, 'Буксировочные услуги', 0, NULL, NULL),
(144, 'Управление транспортом', 0, NULL, NULL),
(145, 'Аренда и лизинг грузовиков', 0, NULL, NULL),
(146, 'Грузоперевозки', 0, NULL, NULL),
(147, 'Авиакомпании', 0, NULL, NULL),
(148, 'Услуги автобуса', 0, NULL, NULL),
(149, 'Кемпинг', 0, NULL, NULL),
(150, 'Прокат автомобилей', 0, NULL, NULL),
(151, 'Чартерные авиакомпании', 0, NULL, NULL),
(152, 'Круизные суда', 0, NULL, NULL),
(153, 'Отели, гостиницы и курорты', 0, NULL, NULL),
(154, 'Пассажирские железнодорожные перевозки', 0, NULL, NULL),
(155, 'Такси и лимузины', 0, NULL, NULL),
(156, 'Турагенства', 0, NULL, NULL),
(157, 'Аукционы и распродажи', 0, NULL, NULL),
(158, 'Магазины автозапчастей и аксессуаров', 0, NULL, NULL),
(159, 'Магазины косметики и аксессуаров', 0, NULL, NULL),
(160, 'Магазины бытовой техника и электроники', 0, NULL, NULL),
(161, 'Аптеки', 0, NULL, NULL),
(162, 'Магазины продуктов питания и напитков', 0, NULL, NULL),
(163, 'Автозаправки', 0, NULL, NULL),
(164, 'Товары смешанного ассортимента', 0, NULL, NULL),
(165, 'Продажа подарков и сувениров', 0, NULL, NULL),
(166, 'Продажа домашнего инвентаря и оборудования', 0, NULL, NULL),
(167, 'Мебель для дома и посуда', 0, NULL, NULL),
(168, 'Продажа медиа продуктов', 0, NULL, NULL),
(169, 'Магазины канцелярских товаров', 0, NULL, NULL),
(170, 'Другие розничные магазины', 0, NULL, NULL),
(171, 'Кабельное ТВ, Интернет и телефонные провайдеры', 0, NULL, NULL),
(172, 'Производство телекоммуникаций', 0, NULL, NULL),
(173, 'Телекоммуникационные услуги', 0, NULL, NULL),
(174, 'Недвижимость', 0, NULL, NULL),
(175, 'Повседневные рестораны', 0, NULL, NULL),
(176, 'Круглосуточные магазины и стоянки грузовиков', 0, NULL, NULL),
(177, 'Фаст-фуд и Рестораны быстрого обслуживания', 0, NULL, NULL),
(178, 'Высококлассные рестораны', 0, NULL, NULL),
(179, 'Фунды грантодающие', 0, NULL, NULL),
(180, 'Организации по сбору средств на здоровье', 0, NULL, NULL),
(181, 'Религиозные организации', 0, NULL, NULL),
(182, 'Социальная помощь', 0, NULL, NULL),
(183, 'Энергетика', 0, NULL, NULL),
(184, 'Разведка и производство нефти и газа', 0, NULL, NULL),
(185, 'Нефть и газ Услуги', 0, NULL, NULL),
(186, 'Вспомогательные услуги', 0, NULL, NULL),
(187, 'Производство и распространение кинофильмов', 0, NULL, NULL),
(188, 'Создания и дистрибуция музыки', 0, NULL, NULL),
(189, 'Выпуск новостей', 0, NULL, NULL),
(190, 'Издательство', 0, NULL, NULL),
(191, 'Радио', 0, NULL, NULL),
(192, 'Телевещание и кабельные сети', 0, NULL, NULL),
(193, 'Видео игры', 0, NULL, NULL),
(194, 'Продажа металлов', 0, NULL, NULL),
(195, 'Добыча', 0, NULL, NULL),
(196, 'Магазины одежды и обуви', 0, NULL, NULL),
(197, 'Шиномонтаж', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `interviews`
--

CREATE TABLE `interviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(255) NOT NULL COMMENT 'для url',
  `company_id` int(10) UNSIGNED NOT NULL COMMENT 'компания',
  `status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending',
  `process_experience` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'впечатление от собеседования: 1 - позитивное, 2 - нейтральное, 3 - негативное',
  `description` text COMMENT 'описание процесса собеседования',
  `difficulty` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'сложность 1-5',
  `interview_outcome` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'результат собеседования: 1 - да; 2 - да, но отказался; 3 - нет',
  `duration_unit` enum('day','week','month') DEFAULT NULL COMMENT 'длительность процесса, ед измер',
  `duration_value` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'длительность процесса, значение',
  `month` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'когда было, месяц',
  `year` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'когда было, год',
  `we_help` tinyint(1) DEFAULT NULL COMMENT 'помог ли наш сервис',
  `user_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'пользователь оставивший собеседование',
  `source_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'источник собеседования',
  `source_specify` varchar(255) DEFAULT NULL COMMENT 'уточнение источника собеседования',
  `position_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'на какую должность проходило собеседование',
  `position_title` varchar(255) DEFAULT NULL COMMENT 'должность респондента - строкой',
  `city_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'где проходило собеседование',
  `city_title` varchar(255) DEFAULT NULL COMMENT 'местоположение офиса - строкой',
  `step_other` varchar(255) DEFAULT NULL COMMENT 'другой шаг',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `interview_sources`
--

CREATE TABLE `interview_sources` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'название источника',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'сортировка',
  `specifiable` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'источник может иметь уточнение',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `interview_sources`
--

INSERT INTO `interview_sources` (`id`, `title`, `sort`, `specifiable`, `created_at`, `updated_at`) VALUES
(1, 'Подали заявку online', 1, 0, NULL, NULL),
(2, 'Колледж или университет', 2, 0, NULL, NULL),
(3, 'От сотрудника', 3, 0, NULL, NULL),
(4, 'Персонально', 4, 0, NULL, NULL),
(5, 'Рекрутер', 5, 0, NULL, NULL),
(6, 'Кадровое агентство', 6, 0, NULL, NULL),
(7, 'Другое', 7, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
--

CREATE TABLE `jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'заголовок',
  `position_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'должность',
  `employment_form_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'форма занятости',
  `stage_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'опыт работы',
  `salary_min` double(8,2) DEFAULT NULL COMMENT 'мин зарплата',
  `salary_max` double(8,2) DEFAULT NULL COMMENT 'макс зарплата',
  `has_additional_payments` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'есть ли дополнительные выплаты',
  `currency_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'валюта зарплаты',
  `description` varchar(255) DEFAULT NULL COMMENT 'описание',
  `company_id` int(10) UNSIGNED NOT NULL COMMENT 'компания',
  `user_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'пользователь создавший вакансию',
  `status` enum('approved','pending','rejected','draft') NOT NULL DEFAULT 'draft' COMMENT 'статус вакансии: approved - одобрена, pending - в ожинании, rejected - отконена, draft - черновик',
  `is_internship` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'является ли стажировкой',
  `hot` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'горячая вакансия',
  `external_url` varchar(255) DEFAULT NULL COMMENT 'внешняя ссылка на вакансию',
  `apply_type` enum('external','contacts','internal') DEFAULT NULL COMMENT 'тип отклика: переход по внешней по ссылке, показать контакты, внутренняя',
  `contacts` text COMMENT 'контактные данные',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `jobs`
--

INSERT INTO `jobs` (`id`, `title`, `position_id`, `employment_form_id`, `stage_id`, `salary_min`, `salary_max`, `has_additional_payments`, `currency_id`, `description`, `company_id`, `user_id`, `status`, `is_internship`, `hot`, `external_url`, `apply_type`, `contacts`, `created_at`, `updated_at`) VALUES
(3, 'Требуется программист', 9, NULL, NULL, 0.00, 0.00, 0, NULL, '<p>123</p>', 1, NULL, 'approved', 0, 0, NULL, 'internal', NULL, '2017-07-29 15:51:38', '2017-07-31 12:34:57'),
(7, 'Программист-стажер Java', 495, NULL, NULL, 0.00, 0.00, 0, NULL, '<p>Компания EPAM Systems &mdash; ведущий разработчик заказного программного обеспечения и один из ведущих игроков в области консалтинга в Казахстане, Центральной и Восточной Европе, на настоящий момент она имеет филиалы в 25+ странах мира и продолжает ста', 2, NULL, 'approved', 1, 0, NULL, 'internal', NULL, '2017-08-01 02:48:35', '2017-08-01 02:48:35');

-- --------------------------------------------------------

--
-- Структура таблицы `jobs_cities`
--

CREATE TABLE `jobs_cities` (
  `job_id` int(10) UNSIGNED NOT NULL COMMENT 'вакансия',
  `city_id` int(10) UNSIGNED NOT NULL COMMENT 'город',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2017_07_19_193321_create_countries_table', 2),
(5, '2017_07_19_194456_create_regions_table', 3),
(6, '2017_07_19_195539_create_cities_table', 4),
(7, '2014_03_13_000000_create_images_table', 5),
(8, '2017_07_19_201132_create_universities_table', 6),
(9, '2017_07_19_203734_create_faculties_table', 7),
(10, '2017_07_19_205252_create_chairs_table', 8),
(11, '2017_07_19_210512_create_company_sizes_table', 8),
(12, '2017_07_19_211537_create_company_revenues_table', 9),
(13, '2017_07_20_055337_create_education_forms_table', 10),
(14, '2017_07_20_060226_create_education_statuses_table', 11),
(15, '2017_07_20_060924_create_currencies_table', 12),
(16, '2017_07_20_062128_create_employment_forms_table', 13),
(17, '2017_07_20_063125_create_skills_table', 14),
(18, '2017_07_20_063704_create_industries_table', 15),
(19, '2017_07_20_064325_create_tags_table', 16),
(20, '2017_07_20_065131_create_companies_table', 17),
(21, '2017_07_20_094402_create_ceo_table', 18),
(22, '2017_07_20_100833_create_positions_table', 19),
(23, '2017_07_20_101640_create_stages_table', 20),
(24, '2017_07_20_102306_create_reviews_table', 21),
(25, '2017_07_20_104754_create_jobs_table', 22),
(26, '2017_07_20_111214_create_user_educations_table', 23),
(28, '2017_07_20_135724_create_salaries_table', 24),
(29, '2017_07_20_142614_create_salary_additional_payments_types_table', 25),
(30, '2017_07_20_143219_create_salary_additional_payments_table', 26),
(31, '2017_07_20_144127_create_interview_sources_table', 27),
(32, '2017_07_20_144930_create_interviews_table', 28),
(33, '2017_03_18_100758_create_admins_table', 29),
(35, '2017_07_20_231823_drop_admins_job_title', 30),
(36, '2017_07_21_083026_create_company_industries_table', 31),
(38, '2017_07_23_150428_create_company_images_table', 32),
(39, '2017_07_26_201713_create_morpher_table', 33),
(40, '2017_07_28_065906_create_taggables_table', 34),
(41, '2017_07_28_071736_create_jobs_cities_table', 35);

-- --------------------------------------------------------

--
-- Структура таблицы `morpher`
--

CREATE TABLE `morpher` (
  `И` varchar(255) NOT NULL COMMENT 'именительный',
  `Р` varchar(255) DEFAULT NULL COMMENT 'родительный',
  `Д` varchar(255) DEFAULT NULL COMMENT 'дательный',
  `В` varchar(255) DEFAULT NULL COMMENT 'винительный',
  `Т` varchar(255) DEFAULT NULL COMMENT 'творительный',
  `П` varchar(255) DEFAULT NULL COMMENT 'предложный',
  `МИ` varchar(255) DEFAULT NULL COMMENT '(множественное) именительный',
  `МР` varchar(255) DEFAULT NULL COMMENT '(множественное) родительный',
  `МД` varchar(255) DEFAULT NULL COMMENT '(множественное) дательный',
  `МВ` varchar(255) DEFAULT NULL COMMENT '(множественное) винительный',
  `МТ` varchar(255) DEFAULT NULL COMMENT '(множественное) творительный',
  `МП` varchar(255) DEFAULT NULL COMMENT '(множественное) предложный',
  `approved` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'одобрен ли',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `morpher`
--

INSERT INTO `morpher` (`И`, `Р`, `Д`, `В`, `Т`, `П`, `МИ`, `МР`, `МД`, `МВ`, `МТ`, `МП`, `approved`, `created_at`, `updated_at`) VALUES
('4DClick Internet Agency', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Air Astana', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Alser Computers', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Apple', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
('BI Group', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Black and White', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Chegg', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Chocofamily', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Creatida', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Epam Kazakhstan', '', '', '', '', '', '', '', '', '', '', '', 0, '2017-08-01 02:43:29', '2017-08-01 02:43:29'),
('EPAM Systems', 'ЕРАМА Systems', 'ЕРАМУ Systems', 'ЕРАМА Systems', 'ЕРАМОМ Systems', 'ЕРАМЕ Systems', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('ERP-Service KazTransCom', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Facebook', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Fidelity Investments', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Flight.kz', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Flip.kz', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('ForteBank', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('GOOD!', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('GR менеджер', 'GR менеджера', 'GR менеджеру', 'GR менеджера', 'GR менеджером', 'GR менеджере', 'GR менеджеры', 'GR менеджеров', 'GR менеджерам', 'GR менеджеров', 'GR менеджерами', 'GR менеджерах', 0, NULL, NULL),
('HomeAway', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Hoster.KZ', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('HTML-верстальщик', 'HTML-верстальщика', 'HTML-верстальщику', 'HTML-верстальщика', 'HTML-верстальщиком', 'HTML-верстальщике', 'HTML-верстальщики', 'HTML-верстальщиков', 'HTML-верстальщикам', 'HTML-верстальщиков', 'HTML-верстальщиками', 'HTML-верстальщиках', 0, NULL, NULL),
('iBEC Systems Ltd', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Ino Group', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Kaspi Bank', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Kassa Nova', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('kaznetmedia', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('KEGOC', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Lamoda.kz', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Lives', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor i', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip еха еа commodo consequat. Duis aute irure dolor ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip еху еа commodo consequat. Duis aute irure dolor ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip еха еа commodo consequat. Duis aute irure dolor ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ехом еа commodo consequat. Duis aute irure dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ехе еа commodo consequat. Duis aute irure dolor ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ехи еа commodo consequat. Duis aute irure dolor ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ехов еа commodo consequat. Duis aute irure dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ехам еа commodo consequat. Duis aute irure dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ехов еа commodo consequat. Duis aute irure dolor', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ехами еа commodo consequat. Duis aute irure dolo', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ехах еа commodo consequat. Duis aute irure dolor', 0, NULL, NULL),
('Lukas', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
('Lukas Pierce', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Lukas Pierce (Admin)', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
('MARS', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Microsoft Казахстан', 'Microsoft Казахстана', 'Microsoft Казахстану', 'Microsoft Казахстан', 'Microsoft Казахстаном', 'Microsoft Казахстане', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Newinttech', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Orange Point Agency', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Reason', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Recapster', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Rocket Firm', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('sad', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
('SibiTron', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Sulpak', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('super.com', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Tengrinews', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Union Space', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('up', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
('Upse', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
('Upsell', '', '', '', '', '', '', '', '', '', '', '', 0, NULL, NULL),
('Upsell.kz', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('VMware', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Web-master', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Web-master.kz', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Web-дизайнер', 'Web-дизайнера', 'Web-дизайнеру', 'Web-дизайнера', 'Web-дизайнером', 'Web-дизайнере', 'Web-дизайнеры', 'Web-дизайнеров', 'Web-дизайнерам', 'Web-дизайнеров', 'Web-дизайнерами', 'Web-дизайнерах', 0, NULL, NULL),
('Web-программист', 'Web-программиста', 'Web-программисту', 'Web-программиста', 'Web-программистом', 'Web-программисте', 'Web-программисты', 'Web-программистов', 'Web-программистам', 'Web-программистов', 'Web-программистами', 'Web-программистах', 0, NULL, NULL),
('Авиакассир', 'Авиакассира', 'Авиакассиру', 'Авиакассира', 'Авиакассиром', 'Авиакассире', 'Авиакассиры', 'Авиакассиров', 'Авиакассирам', 'Авиакассиров', 'Авиакассирами', 'Авиакассирах', 0, NULL, NULL),
('Автослесарь', 'Автослесаря', 'Автослесарю', 'Автослесаря', 'Автослесарем', 'Автослесаре', 'Автослесари', 'Автослесарей', 'Автослесарям', 'Автослесарей', 'Автослесарями', 'Автослесарях', 0, NULL, NULL),
('Администратор предприятия торговли', 'Администратора предприятия торговли', 'Администратору предприятия торговли', 'Администратора предприятия торговли', 'Администратором предприятия торговли', 'Администраторе предприятия торговли', 'Администраторы предприятия торговли', 'Администраторов предприятия торговли', 'Администраторам предприятия торговли', 'Администраторов предприятия торговли', 'Администраторами предприятия торговли', 'Администраторах предприятия торговли', 0, NULL, NULL),
('Албания', 'Албании', 'Албании', 'Албанию', 'Албанией', 'Албании', '', '', '', '', '', '', 0, NULL, NULL),
('Алматы', 'Алматы', 'Алматы', 'Алматы', 'Алматы', 'Алматы', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Андрей', 'Андрея', 'Андрею', 'Андрея', 'Андреем', 'Андрее', '', '', '', '', '', '', 0, NULL, NULL),
('Андрей Сарафанников', 'Андрея Сарафанникова', 'Андрею Сарафанникову', 'Андрея Сарафанникова', 'Андреем Сарафанниковым', 'Андрее Сарафанникове', '', '', '', '', '', '', 0, NULL, NULL),
('АО «Казкоммерцбанк»', 'АО «Казкоммерцбанк»', 'АО «Казкоммерцбанк»', 'АО «Казкоммерцбанк»', 'АО «Казкоммерцбанк»', 'АО «Казкоммерцбанк»', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Аппаратчик-оператор', 'Аппаратчика-оператора', 'Аппаратчику-оператору', 'Аппаратчика-оператора', 'Аппаратчиком-оператором', 'Аппаратчике-операторе', 'Аппаратчики-операторы', 'Аппаратчиков-операторов', 'Аппаратчикам-операторам', 'Аппаратчиков-операторов', 'Аппаратчиками-операторами', 'Аппаратчиках-операторах', 0, NULL, NULL),
('Архивариус', 'Архивариуса', 'Архивариусу', 'Архивариуса', 'Архивариусом', 'Архивариусе', 'Архивариусы', 'Архивариусов', 'Архивариусам', 'Архивариусов', 'Архивариусами', 'Архивариусах', 0, NULL, NULL),
('Ассистент менеджера по продажам', 'Ассистента менеджера по продажам', 'Ассистенту менеджера по продажам', 'Ассистента менеджера по продажам', 'Ассистентом менеджера по продажам', 'Ассистенте менеджера по продажам', 'Ассистенты менеджера по продажам', 'Ассистентов менеджера по продажам', 'Ассистентам менеджера по продажам', 'Ассистентов менеджера по продажам', 'Ассистентами менеджера по продажам', 'Ассистентах менеджера по продажам', 0, NULL, NULL),
('Астана', 'Астаны', 'Астане', 'Астану', 'Астаной', 'Астане', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('АТФ Банк', 'АТФ Банк', 'АТФ Банк', 'АТФ Банк', 'АТФ Банк', 'АТФ Банк', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Банк ЦентрКредит', 'Банка ЦентрКредит', 'Банку ЦентрКредит', 'Банк ЦентрКредит', 'Банком ЦентрКредит', 'Банке ЦентрКредит', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Банковский кассир-операционист', 'Банковского кассира-операциониста', 'Банковскому кассиру-операционисту', 'Банковского кассира-операциониста', 'Банковским кассиром-операционистом', 'Банковском кассире-операционисте', 'Банковские кассиры-операционисты', 'Банковских кассиров-операционистов', 'Банковским кассирам-операционистам', 'Банковских кассиров-операционистов', 'Банковскими кассирами-операционистами', 'Банковских кассирах-операционистах', 0, NULL, NULL),
('Белый Ветер KZ', 'Белого Ветра KZ', 'Белому Ветру KZ', 'Белый Ветер KZ', 'Белым Ветром KZ', 'Белом Ветре KZ', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Водолаз', 'Водолаза', 'Водолазу', 'Водолаза', 'Водолазом', 'Водолазе', 'Водолазы', 'Водолазов', 'Водолазам', 'Водолазов', 'Водолазами', 'Водолазах', 0, NULL, NULL),
('Дворник', 'Дворника', 'Дворнику', 'Дворника', 'Дворником', 'Дворнике', 'Дворники', 'Дворников', 'Дворникам', 'Дворников', 'Дворниками', 'Дворниках', 0, NULL, NULL),
('дизайнер', 'дизайнера', 'дизайнеру', 'дизайнера', 'дизайнером', 'дизайнере', 'дизайнеры', 'дизайнеров', 'дизайнерам', 'дизайнеров', 'дизайнерами', 'дизайнерах', 0, NULL, NULL),
('Диспетчер', 'Диспетчера', 'Диспетчеру', 'Диспетчера', 'Диспетчером', 'Диспетчере', 'Диспетчеры', 'Диспетчеров', 'Диспетчерам', 'Диспетчеров', 'Диспетчерами', 'Диспетчерах', 0, NULL, NULL),
('Евразийский Банк', 'Евразийского Банка', 'Евразийскому Банку', 'Евразийский Банк', 'Евразийским Банком', 'Евразийском Банке', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Жираф', 'Жирафа', 'Жирафу', 'Жирафа', 'Жирафом', 'Жирафе', 'Жирафы', 'Жирафов', 'Жирафам', 'Жирафов', 'Жирафами', 'Жирафах', 0, NULL, NULL),
('Зайсан', 'Зайсана', 'Зайсан', 'Зайсан', 'Зайсан', 'Зайсан', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Интернет-компания PS', 'Интернет-компании PS', 'Интернет-компании PS', 'Интернет-компанию PS', 'Интернет-компанией PS', 'Интернет-компании PS', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Казалинск', 'Казалинска', 'Казалинску', 'Казалинск', 'Казалинском', 'Казалинске', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Казахстан', 'Казахстана', 'Казахстану', 'Казахстан', 'Казахстаном', 'Казахстане', 'Казахстаны', 'Казахстанов', 'Казахстанам', 'Казахстаны', 'Казахстанами', 'Казахстанах', 0, NULL, NULL),
('Казахстан Темир Жолы (КТЖ)', 'Казахстана Темир Жолы (КТЖ)', 'Казахстану Темир Жолы (КТЖ)', 'Казахстан Темир Жолы (КТЖ)', 'Казахстаном Темир Жолы (КТЖ)', 'Казахстане Темир Жолы (КТЖ)', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Казахтелеком', 'Казахтелекома', 'Казахтелекому', 'Казахтелеком', 'Казахтелекомом', 'Казахтелекоме', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Казкоммерцбанк', 'Казкоммерцбанка', 'Казкоммерцбанку', 'Казкоммерцбанк', 'Казкоммерцбанком', 'Казкоммерцбанке', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('КазМедиа Проект', 'КазМедиа Проект', 'КазМедиа Проект', 'КазМедиа Проект', 'КазМедиа Проект', 'КазМедиа Проект', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('КазМунайГаз – переработка и маркетинг', 'КазМунайГаза – переработка и маркетинг', 'КазМунайГазу – переработка и маркетинг', 'КазМунайГаз – переработка и маркетинг', 'КазМунайГазе – переработка и маркетинг', 'КазМунайГазе – переработка и маркетинг', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Казпочта', 'Казпочты', 'Казпочте', 'Казпочту', 'Казпочтой', 'Казпочте', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Караганда', 'Караганды', 'Караганде', 'Караганду', 'Карагандой', 'Караганде', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Карагандинский государственный технический университет', 'Карагандинского государственного технического университета', 'Карагандинскому государственному техническому университету', 'Карагандинский государственный технический университет', 'Карагандинским государственным техническим университетом', 'Карагандинском государственном техническом университете', 'Карагандинские государственные технические университеты', 'Карагандинских государственных технических университетов', 'Карагандинским государственным техническим университетам', 'Карагандинские государственные технические университеты', 'Карагандинскими государственными техническими университетами', 'Карагандинских государственных технических университетах', 0, NULL, NULL),
('Каратау', 'Каратау', 'Каратау', 'Каратау', 'Каратау', 'Каратау', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Каркаралинск', 'Каркаралинска', 'Каркаралинску', 'Каркаралинск', 'Каркаралинском', 'Каркаралинске', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Кассир', 'Кассира', 'Кассиру', 'Кассира', 'Кассиром', 'Кассире', 'Кассиры', 'Кассиров', 'Кассирам', 'Кассиров', 'Кассирами', 'Кассирах', 0, NULL, NULL),
('Колёса, Крыша, Маркет', 'Колёсы, Крыши, Маркет', 'Колёсе, Крыше, Маркет', 'Колёсу, Крышу, Маркет', 'Колёсой, Крышей, Маркет', 'Колёсе, Крыше, Маркет', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Ландшафтный дизайнер', 'Ландшафтного дизайнера', 'Ландшафтному дизайнеру', 'Ландшафтного дизайнера', 'Ландшафтным дизайнером', 'Ландшафтном дизайнере', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Ливия', 'Ливии', 'Ливии', 'Ливию', 'Ливией', 'Ливии', 'Ливии', 'Ливий', 'Ливиям', 'Ливии', 'Ливиями', 'Ливиях', 0, NULL, NULL),
('Люксембург', 'Люксембурга', 'Люксембургу', 'Люксембург', 'Люксембургом', 'Люксембурге', 'Люксембурги', 'Люксембургов', 'Люксембургам', 'Люксембурги', 'Люксембургами', 'Люксембургах', 0, NULL, NULL),
('Март', 'Марта', 'Марту', 'Марта', 'Мартом', 'Марте', '', '', '', '', '', '', 0, NULL, NULL),
('Меломан', 'Меломана', 'Меломану', 'Меломана', 'Меломаном', 'Меломане', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Менеджер', 'Менеджера', 'Менеджеру', 'Менеджера', 'Менеджером', 'Менеджере', 'Менеджеры', 'Менеджеров', 'Менеджерам', 'Менеджеров', 'Менеджерами', 'Менеджерах', 0, NULL, NULL),
('Менеджер активных продаж', 'Менеджера активных продаж', 'Менеджеру активных продаж', 'Менеджера активных продаж', 'Менеджером активных продаж', 'Менеджере активных продаж', 'Менеджеры активных продаж', 'Менеджеров активных продаж', 'Менеджерам активных продаж', 'Менеджеров активных продаж', 'Менеджерами активных продаж', 'Менеджерах активных продаж', 0, NULL, NULL),
('Менеджер по работе с клиентами', 'Менеджера по работе с клиентами', 'Менеджеру по работе с клиентами', 'Менеджера по работе с клиентами', 'Менеджером по работе с клиентами', 'Менеджере по работе с клиентами', 'Менеджеры по работе с клиентами', 'Менеджеров по работе с клиентами', 'Менеджерам по работе с клиентами', 'Менеджеров по работе с клиентами', 'Менеджерами по работе с клиентами', 'Менеджерах по работе с клиентами', 0, NULL, NULL),
('Менеджер по управлению товарными запасами', 'Менеджера по управлению товарными запасами', 'Менеджеру по управлению товарными запасами', 'Менеджера по управлению товарными запасами', 'Менеджером по управлению товарными запасами', 'Менеджере по управлению товарными запасами', 'Менеджеры по управлению товарными запасами', 'Менеджеров по управлению товарными запасами', 'Менеджерам по управлению товарными запасами', 'Менеджеров по управлению товарными запасами', 'Менеджерами по управлению товарными запасами', 'Менеджерах по управлению товарными запасами', 0, NULL, NULL),
('Мечта Маркет', 'Мечты Маркет', 'Мечте Маркет', 'Мечту Маркет', 'Мечтой Маркет', 'Мечте Маркет', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Москва', 'Москвы', 'Москве', 'Москву', 'Москвой', 'Москве', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Народный Банк Казахстана', 'Народного Банка Казахстана', 'Народному Банку Казахстана', 'Народного Банка Казахстана', 'Народным Банком Казахстана', 'Народном Банке Казахстана', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('новая компания', 'новой компании', 'новой компании', 'новую компанию', 'новой компанией', 'новой компании', 'новые компании', 'новых компаний', 'новым компаниям', 'новые компании', 'новыми компаниями', 'новых компаниях', 0, NULL, NULL),
('новая компания 1', 'новой компании 1', 'новой компании 1', 'новую компанию 1', 'новой компанией 1', 'новой компании 1', 'новые компании 1', 'новых компаний 1', 'новым компаниям 1', 'новые компании 1', 'новыми компаниями 1', 'новых компаниях 1', 0, NULL, NULL),
('новая компания 666', 'новой компании 666', 'новой компании 666', 'новую компанию 666', 'новой компанией 666', 'новой компании 666', 'новые компании 666', 'новых компаний 666', 'новым компаниям 666', 'новые компании 666', 'новыми компаниями 666', 'новых компаниях 666', 0, NULL, NULL),
('ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 'ОАЭ', 0, NULL, NULL),
('ОГО Интеройл', 'ОГО Интеройл', 'ОГО Интеройл', 'ОГО Интеройл', 'ОГО Интеройл', 'ОГО Интеройл', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Октябрь', 'Октября', 'Октябрю', 'Октябрь', 'Октябрём', 'Октябре', 'Октябри', 'Октябрей', 'Октябрям', 'Октябри', 'Октябрями', 'Октябрях', 0, NULL, NULL),
('Офис-менеджер', 'Офис-менеджера', 'Офис-менеджеру', 'Офис-менеджера', 'Офис-менеджером', 'Офис-менеджере', 'Офис-менеджеры', 'Офис-менеджеров', 'Офис-менеджерам', 'Офис-менеджеров', 'Офис-менеджерами', 'Офис-менеджерах', 0, NULL, NULL),
('Павлодар', 'Павлодара', 'Павлодару', 'Павлодара', 'Павлодаром', 'Павлодаре', 'Павлодары', 'Павлодаров', 'Павлодарам', 'Павлодаров', 'Павлодарами', 'Павлодарах', 0, NULL, NULL),
('Петропавловск', 'Петропавловска', 'Петропавловску', 'Петропавловск', 'Петропавловском', 'Петропавловске', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Программист', 'Программиста', 'Программисту', 'Программиста', 'Программистом', 'Программисте', 'Программисты', 'Программистов', 'Программистам', 'Программистов', 'Программистами', 'Программистах', 0, NULL, NULL),
('Программист Java', 'Программиста Java', 'Программисту Java', 'Программиста Java', 'Программистом Java', 'Программисте Java', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Программист PHP', 'Программиста РНР', 'Программисту РНР', 'Программиста РНР', 'Программистом РНР', 'Программисте РНР', 'Программисты РНР', 'Программистов РНР', 'Программистам РНР', 'Программистов РНР', 'Программистами РНР', 'Программистах РНР', 0, NULL, NULL),
('Программист Python', 'Программиста Python', 'Программисту Python', 'Программиста Python', 'Программистом Python', 'Программисте Python', 'Программисты Python', 'Программистов Python', 'Программистам Python', 'Программистов Python', 'Программистами Python', 'Программистах Python', 0, NULL, NULL),
('Продкорпорация', 'Продкорпорации', 'Продкорпорации', 'Продкорпорацию', 'Продкорпорацией', 'Продкорпорации', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Рамазан', 'Рамазана', 'Рамазану', 'Рамазана', 'Рамазаном', 'Рамазане', '', '', '', '', '', '', 0, NULL, NULL),
('Рамазан Койшыбаев', 'Рамазана Койшыбаева', 'Рамазану Койшыбаеву', 'Рамазана Койшыбаева', 'Рамазаном Койшыбаевым', 'Рамазане Койшыбаеве', '', '', '', '', '', '', 0, NULL, NULL),
('Россия', 'России', 'России', 'Россию', 'Россией', 'России', '', '', '', '', '', '', 0, NULL, NULL),
('Самрук-Казына', 'Самрука-Казыны', 'Самруку-Казыне', 'Самрука-Казыну', 'Самруком-Казыной', 'Самруке-Казыне', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Сбербанк', 'Сбербанка', 'Сбербанку', 'Сбербанк', 'Сбербанком', 'Сбербанке', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('США', 'США', 'США', 'США', 'США', 'США', '', '', '', '', '', '', 0, NULL, NULL),
('ТД Арсенал Азия', 'ТД Арсенала Азии', 'ТД Арсеналу Азии', 'ТД Арсенала Азию', 'ТД Арсеналом Азией', 'ТД Арсенале Азии', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Темиртау', 'Темиртау', 'Темиртау', 'Темиртау', 'Темиртау', 'Темиртау', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Тенгизшевройл', 'Тенгизшевройла', 'Тенгизшевройлу', 'Тенгизшевройла', 'Тенгизшевройлом', 'Тенгизшевройле', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Технодом', 'Технодома', 'Технодому', 'Технодом', 'Технодомом', 'Технодоме', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Украина', 'Украины', 'Украине', 'Украину', 'Украиной', 'Украине', 'Украины', 'Украин', 'Украинам', 'Украины', 'Украинами', 'Украинах', 0, NULL, NULL),
('ФудМастер', 'ФудМастера', 'ФудМастеру', 'ФудМастера', 'ФудМастером', 'ФудМастере', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Цеснабанк', 'Цеснабанка', 'Цеснабанку', 'Цеснабанк', 'Цеснабанком', 'Цеснабанке', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
('Экибастуз', 'Экибастуза', 'Экибастузу', 'Экибастуз', 'Экибастузом', 'Экибастузе', 'Экибастузы', 'Экибастузов', 'Экибастузам', 'Экибастузы', 'Экибастузами', 'Экибастузах', 0, NULL, NULL),
('ҚазМұнайГаз Өнімдері', '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('lukas.pierce@recapster.com', '$2y$10$dd9DkuYS2dRu7wS6lqHJnOo3P2dTGbSPfaHv8IQfVWwHJLX1VUo/e', '2017-08-11 11:50:08');

-- --------------------------------------------------------

--
-- Структура таблицы `positions`
--

CREATE TABLE `positions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL COMMENT 'альяс для ссылки',
  `salaries_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество одобренных зарплат',
  `reviews_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество одобренных отзывов',
  `interviews_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество одобренных собеседований',
  `jobs_count` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'количество активных вакансий',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `positions`
--

INSERT INTO `positions` (`id`, `title`, `alias`, `salaries_count`, `reviews_count`, `interviews_count`, `jobs_count`, `created_at`, `updated_at`) VALUES
(1, 'Автомеханик', 'auto-mechanic', 0, 0, 0, 0, NULL, NULL),
(2, 'Автослесарь', 'smith', 0, 0, 0, 0, NULL, NULL),
(3, 'Архитектор', 'architect', 0, 0, 0, 0, NULL, NULL),
(5, 'Инженер', 'engineer', 0, 0, 0, 0, NULL, NULL),
(6, 'Конструктор', 'constructor', 0, 0, 0, 0, NULL, NULL),
(7, 'Металлург', 'metallurgist', 0, 0, 0, 0, NULL, NULL),
(8, 'Механик', 'mechanic', 0, 0, 0, 0, NULL, NULL),
(9, 'Программист', 'programmer', 0, 0, 0, 0, NULL, NULL),
(10, 'Радиоинженер', 'radio-engineer', 0, 0, 0, 0, NULL, NULL),
(11, 'Связист', 'svjazist', 0, 0, 0, 0, NULL, NULL),
(12, 'Энергетик', 'energetic', 0, 0, 0, 0, NULL, NULL),
(13, 'SEO-специалист', 'seo-expert', 0, 0, 0, 0, NULL, NULL),
(14, 'Строитель', 'builder', 0, 0, 0, 0, NULL, NULL),
(15, 'Техник', 'technician', 0, 0, 0, 0, NULL, NULL),
(16, 'Технолог', 'technologist', 0, 0, 0, 0, NULL, NULL),
(17, 'Химик', 'chemist', 0, 0, 0, 0, NULL, NULL),
(18, 'Электрик', 'electrician', 0, 0, 0, 0, NULL, NULL),
(19, 'Аудитор', 'auditor', 0, 0, 0, 0, NULL, NULL),
(20, 'Бухгалтер', 'accountant', 0, 0, 0, 0, NULL, NULL),
(21, 'Маркетолог', 'marketer', 0, 0, 0, 0, NULL, NULL),
(22, 'Менеджер', 'manager', 0, 0, 0, 0, NULL, NULL),
(23, 'Менеджер по продажам', 'sales-manager', 0, 0, 0, 0, NULL, NULL),
(24, 'Риэлтор', 'realtor', 0, 0, 0, 0, NULL, NULL),
(25, 'Товаровед', 'tovaroved', 0, 0, 0, 0, NULL, NULL),
(26, 'Финансист', 'financier', 0, 0, 0, 0, NULL, NULL),
(27, 'Финансовый аналитик', 'financial-analyst', 0, 0, 0, 0, NULL, NULL),
(28, 'Экономист', 'economist', 0, 0, 0, 0, NULL, NULL),
(29, 'Актёр', 'actor', 0, 0, 0, 0, NULL, NULL),
(30, 'Визажист', 'visagiste', 0, 0, 0, 0, NULL, NULL),
(31, 'Дизайнер', 'designer', 0, 0, 0, 0, NULL, NULL),
(32, 'Дизайнер интерьера', 'interior-designer', 0, 0, 0, 0, NULL, NULL),
(33, 'Иллюстратор', 'illustrator', 0, 0, 0, 0, NULL, NULL),
(34, 'Ландшафтный дизайнер', 'landscape-designer', 0, 0, 0, 0, NULL, NULL),
(35, 'Модельер', 'fashion-designer', 0, 0, 0, 0, NULL, NULL),
(36, 'Мультипликатор', 'multiplier', 0, 0, 0, 0, NULL, NULL),
(37, 'Парикмахер', 'hairdresser', 0, 0, 0, 0, NULL, NULL),
(38, 'Режиссер', 'director', 0, 0, 0, 0, NULL, NULL),
(39, 'Стилист', 'stylist', 0, 0, 0, 0, NULL, NULL),
(40, 'Флорист', 'florist', 0, 0, 0, 0, NULL, NULL),
(41, 'Фотограф', 'photographer', 0, 0, 0, 0, NULL, NULL),
(42, 'Художник', 'artist', 0, 0, 0, 0, NULL, NULL),
(43, 'Ювелир', 'jeweler', 0, 0, 0, 0, NULL, NULL),
(44, 'Военный врач', 'military-doctor', 0, 0, 0, 0, NULL, NULL),
(45, 'Военный инженер', 'military-engineer', 0, 0, 0, 0, NULL, NULL),
(46, 'Военный летчик', 'military-pilot', 0, 0, 0, 0, NULL, NULL),
(47, 'Военный связист', 'military-signaller', 0, 0, 0, 0, NULL, NULL),
(48, 'Менеджер по туризму', 'tourism-manager', 0, 0, 0, 0, NULL, NULL),
(49, 'Экскурсовод', 'guide', 0, 0, 0, 0, NULL, NULL),
(50, 'Акушер', 'obstetrician', 0, 0, 0, 0, NULL, NULL),
(51, 'Врач', 'doctor', 0, 0, 0, 0, NULL, NULL),
(52, 'Генный инженер', 'geneticist', 0, 0, 0, 0, NULL, NULL),
(53, 'Косметолог', 'beautician', 0, 0, 0, 0, NULL, NULL),
(54, 'Медицинская сестра', 'nurse', 0, 0, 0, 0, NULL, NULL),
(55, 'Нарколог', 'narcologist', 0, 0, 0, 0, NULL, NULL),
(56, 'Стоматолог', 'dentist', 0, 0, 0, 0, NULL, NULL),
(57, 'Фармацевт', 'pharmacist', 0, 0, 0, 0, NULL, NULL),
(58, 'Фельдшер', 'paramedic', 0, 0, 0, 0, NULL, NULL),
(59, 'Хирург', 'surgeon', 0, 0, 0, 0, NULL, NULL),
(60, 'Библиотекарь', 'librarian', 0, 0, 0, 0, NULL, NULL),
(61, 'Биолог', 'biologist', 0, 0, 0, 0, NULL, NULL),
(62, 'Учитель', 'teacher', 0, 0, 0, 0, NULL, NULL),
(64, 'Адвокат', 'advocate', 0, 0, 0, 0, NULL, NULL),
(65, 'Прокурор', 'prosecutor', 0, 0, 0, 0, NULL, NULL),
(66, 'Социальный работник', 'social-worker', 0, 0, 0, 0, NULL, NULL),
(67, 'Судья', 'judge', 0, 0, 0, 0, NULL, NULL),
(68, 'Юрист', 'lawyer', 0, 0, 0, 0, NULL, NULL),
(69, 'Юрист по авторскому праву', 'copyright-lawyer', 0, 0, 0, 0, NULL, NULL),
(70, 'Администратор', 'administrator', 0, 0, 0, 0, NULL, NULL),
(71, 'Event-менеджер', 'event-manager', 0, 0, 0, 0, NULL, NULL),
(72, 'Менеджер по персоналу', 'hr-manager', 0, 0, 0, 0, NULL, NULL),
(73, 'Переводчик', 'translator', 0, 0, 0, 0, NULL, NULL),
(74, 'Повар', 'cook', 0, 0, 0, 0, NULL, NULL),
(75, 'PR специалист', 'pr-specialist', 0, 0, 0, 0, NULL, NULL),
(76, 'Психолог', 'psychologist', 0, 0, 0, 0, NULL, NULL),
(77, 'Работник радио', 'radio-worker', 0, 0, 0, 0, NULL, NULL),
(78, 'Секретарь', 'secretary', 0, 0, 0, 0, NULL, NULL),
(79, 'Социолог', 'sociologist', 0, 0, 0, 0, NULL, NULL),
(80, 'HR специалист', 'hr-specialist', 0, 0, 0, 0, NULL, NULL),
(81, 'Инженер по охране труда', 'engineer-labor-protection', 0, 0, 0, 0, NULL, NULL),
(82, 'Криминалист', 'criminalist', 0, 0, 0, 0, NULL, NULL),
(83, 'Пожарный', 'firefighter', 0, 0, 0, 0, NULL, NULL),
(84, 'Полицейский', 'policeman', 0, 0, 0, 0, NULL, NULL),
(85, 'Таможенник', 'customs-official', 0, 0, 0, 0, NULL, NULL),
(86, 'Агроном', 'agronomist', 0, 0, 0, 0, NULL, NULL),
(87, 'Ветеринар', 'vet', 0, 0, 0, 0, NULL, NULL),
(88, 'Геолог', 'geologist', 0, 0, 0, 0, NULL, NULL),
(89, 'Картограф', 'cartographer', 0, 0, 0, 0, NULL, NULL),
(90, 'Кинолог', 'canine', 0, 0, 0, 0, NULL, NULL),
(91, 'Ресторатор', 'restaurateur', 0, 0, 0, 0, NULL, NULL),
(92, 'Фермер', 'farmer', 0, 0, 0, 0, NULL, NULL),
(93, 'Эколог', 'ecologist', 0, 0, 0, 0, NULL, NULL),
(94, 'Летчик', 'pilot', 0, 0, 0, 0, NULL, NULL),
(95, 'Логист', 'logist', 0, 0, 0, 0, NULL, NULL),
(97, 'Стюардесса', 'stewardess', 0, 0, 0, 0, NULL, NULL),
(98, 'Копирайтер', 'copywriter', 0, 0, 0, 0, NULL, NULL),
(99, 'Журналист', 'journalist', 0, 0, 0, 0, NULL, NULL),
(100, 'Лингвист', 'linguist', 0, 0, 0, 0, NULL, NULL),
(101, 'Писатель', 'writer', 0, 0, 0, 0, NULL, NULL),
(102, 'Редактор', 'editor', 0, 0, 0, 0, NULL, NULL),
(103, 'Филолог', 'philologist', 0, 0, 0, 0, NULL, NULL),
(104, 'Генеральный секретарь', 'secretary-general', 0, 0, 0, 0, NULL, NULL),
(105, 'Делопроизводитель', 'clerk', 0, 0, 0, 0, NULL, NULL),
(106, 'Детектив', 'detective', 0, 0, 0, 0, NULL, NULL),
(107, 'Дипломат', 'diplomat', 0, 0, 0, 0, NULL, NULL),
(108, 'Конвоир', 'guard', 0, 0, 0, 0, NULL, NULL),
(109, 'Нотариус', 'notary', 0, 0, 0, 0, NULL, NULL),
(110, 'Охранник', 'security', 0, 0, 0, 0, NULL, NULL),
(111, 'Правовед', 'jurisprudent', 0, 0, 0, 0, NULL, NULL),
(113, 'Судебный пристав', 'bailiff', 0, 0, 0, 0, NULL, NULL),
(114, 'Телохранитель', 'bodyguard', 0, 0, 0, 0, NULL, NULL),
(115, 'Тюремный надзиратель', 'jailer', 0, 0, 0, 0, NULL, NULL),
(116, 'Верстальщик', 'makeup-man', 0, 0, 0, 0, NULL, NULL),
(117, 'Выпускающий редактор', 'commissioning-editor', 0, 0, 0, 0, NULL, NULL),
(118, 'Издатель', 'publisher', 0, 0, 0, 0, NULL, NULL),
(119, 'Корректор', 'corrector', 0, 0, 0, 0, NULL, NULL),
(120, 'Переплетчик', 'bookbinder', 0, 0, 0, 0, NULL, NULL),
(121, 'Типограф', 'printer', 0, 0, 0, 0, NULL, NULL),
(123, 'Фальцовщик', 'folder', 0, 0, 0, 0, NULL, NULL),
(124, 'HTML-верстальщик', 'html-coder', 0, 0, 0, 0, NULL, NULL),
(125, 'Web-интегратор', 'web-integrator', 0, 0, 0, 0, NULL, NULL),
(126, 'Web-дизайнер', 'web-designer', 0, 0, 0, 0, NULL, NULL),
(127, 'Web-программист', 'web-developer', 0, 0, 0, 0, NULL, NULL),
(128, 'Администратор базы данных', 'dba', 0, 0, 0, 0, NULL, NULL),
(129, 'Администратор сайта', 'site-administrator', 0, 0, 0, 0, NULL, NULL),
(130, 'Блогер', 'blogger', 0, 0, 0, 0, NULL, NULL),
(131, 'Диктор', 'speaker', 0, 0, 0, 0, NULL, NULL),
(132, 'Контент-менеджер', 'content-manager', 0, 0, 0, 0, NULL, NULL),
(133, 'Оператор-машинист', 'typist', 0, 0, 0, 0, NULL, NULL),
(134, 'Оператор ПК', 'pc-operator', 0, 0, 0, 0, NULL, NULL),
(135, 'Радист', 'radioman', 0, 0, 0, 0, NULL, NULL),
(136, 'Системный администратор', 'system-administrator', 0, 0, 0, 0, NULL, NULL),
(137, 'Телеграфист', 'telegraphist', 0, 0, 0, 0, NULL, NULL),
(138, 'Тележурналист', 'tv-journalist', 0, 0, 0, 0, NULL, NULL),
(139, 'Тестировщик', 'tester', 0, 0, 0, 0, NULL, NULL),
(140, 'Андролог', 'andrologist', 0, 0, 0, 0, NULL, NULL),
(141, 'Анестезиолог', 'anesthetist', 0, 0, 0, 0, NULL, NULL),
(142, 'Венеролог', 'venereologist', 0, 0, 0, 0, NULL, NULL),
(143, 'Вирусолог', 'virologist', 0, 0, 0, 0, NULL, NULL),
(144, 'Врач скорой помощи', 'emergency-doctor', 0, 0, 0, 0, NULL, NULL),
(145, 'Врач-диетолог', 'dietician', 0, 0, 0, 0, NULL, NULL),
(146, 'Гинеколог', 'gynecologist', 0, 0, 0, 0, NULL, NULL),
(147, 'Дерматовенеролог', 'dermato', 0, 0, 0, 0, NULL, NULL),
(148, 'Дерматолог', 'dermatologist', 0, 0, 0, 0, NULL, NULL),
(149, 'Диетолог', 'nutritionist', 0, 0, 0, 0, NULL, NULL),
(150, 'Зубной техник', 'dental-technician', 0, 0, 0, 0, NULL, NULL),
(151, 'Иммунолог', 'immunologist', 0, 0, 0, 0, NULL, NULL),
(152, 'Инфекционист', 'infectious-disease', 0, 0, 0, 0, NULL, NULL),
(153, 'Кардиолог', 'cardiologist', 0, 0, 0, 0, NULL, NULL),
(154, 'Кардиохирург', 'cardiac', 0, 0, 0, 0, NULL, NULL),
(155, 'Лаборант', 'assistant', 0, 0, 0, 0, NULL, NULL),
(156, 'Логопед', 'logopedist', 0, 0, 0, 0, NULL, NULL),
(157, 'Мануалист', 'manualist', 0, 0, 0, 0, NULL, NULL),
(158, 'Массажист', 'massagist', 0, 0, 0, 0, NULL, NULL),
(159, 'Невролог', 'neurologist', 0, 0, 0, 0, NULL, NULL),
(160, 'Невропатолог', 'neuropathist', 0, 0, 0, 0, NULL, NULL),
(161, 'Нейрохирург', 'neurosurgeon', 0, 0, 0, 0, NULL, NULL),
(163, 'Окулист', 'oculist', 0, 0, 0, 0, NULL, NULL),
(164, 'Онколог', 'oncologist', 0, 0, 0, 0, NULL, NULL),
(165, 'Ортопед', 'orthopedist', 0, 0, 0, 0, NULL, NULL),
(166, 'Оториноларинголог (ЛОР)', 'otolaryngologist', 0, 0, 0, 0, NULL, NULL),
(167, 'Офтальмолог', 'ophthalmologist', 0, 0, 0, 0, NULL, NULL),
(168, 'Педиатр', 'pediatrician', 0, 0, 0, 0, NULL, NULL),
(169, 'Прозектор', 'dissector', 0, 0, 0, 0, NULL, NULL),
(170, 'Проктолог', 'proctologist', 0, 0, 0, 0, NULL, NULL),
(171, 'Психиатр', 'psychiatrist', 0, 0, 0, 0, NULL, NULL),
(172, 'Психотерапевт', 'psychotherapist', 0, 0, 0, 0, NULL, NULL),
(173, 'Реабилитолог', 'rehabilitation', 0, 0, 0, 0, NULL, NULL),
(174, 'Реаниматолог', 'resuscitator', 0, 0, 0, 0, NULL, NULL),
(175, 'Сексолог', 'sexologist', 0, 0, 0, 0, NULL, NULL),
(176, 'Спортивный врач', 'sports-doctor', 0, 0, 0, 0, NULL, NULL),
(177, 'Терапевт', 'therapist', 0, 0, 0, 0, NULL, NULL),
(178, 'Токсиколог', 'toxicologist', 0, 0, 0, 0, NULL, NULL),
(179, 'Травматолог', 'traumatologist', 0, 0, 0, 0, NULL, NULL),
(180, 'Уролог', 'urologist', 0, 0, 0, 0, NULL, NULL),
(181, 'Эндокринолог', 'endocrinologist', 0, 0, 0, 0, NULL, NULL),
(182, 'Археолог', 'archaeologist', 0, 0, 0, 0, NULL, NULL),
(183, 'Архивариус', 'archivist', 0, 0, 0, 0, NULL, NULL),
(184, 'Астроном', 'astronomer', 0, 0, 0, 0, NULL, NULL),
(185, 'Библиограф', 'bibliographer', 0, 0, 0, 0, NULL, NULL),
(186, 'Биоинженер', 'bioengineer', 0, 0, 0, 0, NULL, NULL),
(187, 'Биофизик', 'biophysicist', 0, 0, 0, 0, NULL, NULL),
(188, 'Биохимик', 'biochemist', 0, 0, 0, 0, NULL, NULL),
(189, 'Ботаник', 'botanist', 0, 0, 0, 0, NULL, NULL),
(190, 'Востоковед', 'orientalist', 0, 0, 0, 0, NULL, NULL),
(192, 'Гидролог', 'hydrologist', 0, 0, 0, 0, NULL, NULL),
(193, 'Египтолог', 'egyptologist', 0, 0, 0, 0, NULL, NULL),
(194, 'Зоолог', 'zoologist', 0, 0, 0, 0, NULL, NULL),
(195, 'Изобретатель', 'inventor', 0, 0, 0, 0, NULL, NULL),
(196, 'Искусствовед', 'art-critic', 0, 0, 0, 0, NULL, NULL),
(197, 'Историк', 'historian', 0, 0, 0, 0, NULL, NULL),
(198, 'Ихтиолог', 'ichthyologist', 0, 0, 0, 0, NULL, NULL),
(199, 'Культуролог', 'culturologist', 0, 0, 0, 0, NULL, NULL),
(200, 'Математик', 'mathematician', 0, 0, 0, 0, NULL, NULL),
(201, 'Метеоролог', 'meteorologist', 0, 0, 0, 0, NULL, NULL),
(202, 'Микробиолог', 'microbiologist', 0, 0, 0, 0, NULL, NULL),
(203, 'Нанотехнолог', 'nanotechnologists', 0, 0, 0, 0, NULL, NULL),
(204, 'Орнитолог', 'ornithologist', 0, 0, 0, 0, NULL, NULL),
(205, 'Палеонтолог', 'paleontologist', 0, 0, 0, 0, NULL, NULL),
(206, 'Политолог', 'political-scientist', 0, 0, 0, 0, NULL, NULL),
(207, 'Почвовед', 'soil-scientist', 0, 0, 0, 0, NULL, NULL),
(208, 'Религиовед', 'theologian', 0, 0, 0, 0, NULL, NULL),
(210, 'Физик', 'physicist', 0, 0, 0, 0, NULL, NULL),
(211, 'Философ', 'philosopher', 0, 0, 0, 0, NULL, NULL),
(212, 'Этнограф', 'ethnographer', 0, 0, 0, 0, NULL, NULL),
(213, 'Воспитатель', 'educator', 0, 0, 0, 0, NULL, NULL),
(214, 'Дефектолог', 'defectology', 0, 0, 0, 0, NULL, NULL),
(215, 'Педагог', 'schoolmaster', 0, 0, 0, 0, NULL, NULL),
(217, 'Проректор', 'prorektor', 0, 0, 0, 0, NULL, NULL),
(218, 'Ректор', 'rector', 0, 0, 0, 0, NULL, NULL),
(219, 'Сурдопедагог', 'surdopedagogs', 0, 0, 0, 0, NULL, NULL),
(220, 'Тифлопедагог', 'tiflopedagog', 0, 0, 0, 0, NULL, NULL),
(221, 'Пекарь', 'baker', 0, 0, 0, 0, NULL, NULL),
(222, 'Винодел', 'winemaker', 0, 0, 0, 0, NULL, NULL),
(223, 'Кондитер', 'confectioner', 0, 0, 0, 0, NULL, NULL),
(224, 'Месильщик', 'mesilschik', 0, 0, 0, 0, NULL, NULL),
(225, 'Мясник', 'butcher', 0, 0, 0, 0, NULL, NULL),
(227, 'Вышивальщица', 'embroideress', 0, 0, 0, 0, NULL, NULL),
(228, 'Гид-переводчик', 'guide-translator', 0, 0, 0, 0, NULL, NULL),
(229, 'Дегустатор', 'taster', 0, 0, 0, 0, NULL, NULL),
(230, 'Промышленный альпинист', 'industrial-climber', 0, 0, 0, 0, NULL, NULL),
(231, 'Реставратор', 'restorer', 0, 0, 0, 0, NULL, NULL),
(232, 'Референт', 'referent', 0, 0, 0, 0, NULL, NULL),
(233, 'Священнослужитель', 'ecclesiastic', 0, 0, 0, 0, NULL, NULL),
(234, 'Секретарь-референт', 'secretary-referent', 0, 0, 0, 0, NULL, NULL),
(235, 'Секретарь-стенографистка', 'secretary-stenographer', 0, 0, 0, 0, NULL, NULL),
(236, 'Дорожный инспектор', 'waywarden', 0, 0, 0, 0, NULL, NULL),
(237, 'Доярка', 'milkmaid', 0, 0, 0, 0, NULL, NULL),
(238, 'Животновод', 'stockbreeder', 0, 0, 0, 0, NULL, NULL),
(239, 'Комбайнер', 'combine', 0, 0, 0, 0, NULL, NULL),
(240, 'Оператор машинного доения', 'milking-machine-operator', 0, 0, 0, 0, NULL, NULL),
(241, 'Охотник', 'hunter', 0, 0, 0, 0, NULL, NULL),
(242, 'Пастух', 'shepherd', 0, 0, 0, 0, NULL, NULL),
(243, 'Пчеловод', 'beekeeper', 0, 0, 0, 0, NULL, NULL),
(244, 'Скотник', 'cattleman', 0, 0, 0, 0, NULL, NULL),
(245, 'Специалист по стрижке овец', 'specialist-shearing-sheep', 0, 0, 0, 0, NULL, NULL),
(246, 'Тракторист', 'tractor-driver', 0, 0, 0, 0, NULL, NULL),
(247, 'Рыбак', 'fisherman', 0, 0, 0, 0, NULL, NULL),
(248, 'Агент по туризму', 'travel-agent', 0, 0, 0, 0, NULL, NULL),
(249, 'Страховой агент', 'insurance-agent', 0, 0, 0, 0, NULL, NULL),
(250, 'Администратор гостиницы', 'hotel-administrator', 0, 0, 0, 0, NULL, NULL),
(251, 'Администратор ресторана', 'restaurant-manager', 0, 0, 0, 0, NULL, NULL),
(252, 'Администратор салона красоты', 'beauty-salon-administrator', 0, 0, 0, 0, NULL, NULL),
(253, 'Бармен', 'bartender', 0, 0, 0, 0, NULL, NULL),
(254, 'Грузчик', 'loader', 0, 0, 0, 0, NULL, NULL),
(255, 'Дворник', 'janitor', 0, 0, 0, 0, NULL, NULL),
(256, 'Кладовщик', 'storekeeper', 0, 0, 0, 0, NULL, NULL),
(257, 'Консультант по туризму', 'tourism-consultant', 0, 0, 0, 0, NULL, NULL),
(258, 'Консультант телефона доверия', 'helpline-consultant', 0, 0, 0, 0, NULL, NULL),
(260, 'Мусорщик', 'scavenger', 0, 0, 0, 0, NULL, NULL),
(262, 'Настройщик музыкальных инструментов', 'musical-instruments-tuner', 0, 0, 0, 0, NULL, NULL),
(263, 'Оператор call-центра', 'call-center-operator', 0, 0, 0, 0, NULL, NULL),
(264, 'Официант', 'waiter', 0, 0, 0, 0, NULL, NULL),
(265, 'Портье', 'receptionist', 0, 0, 0, 0, NULL, NULL),
(266, 'Почтальон', 'postman', 0, 0, 0, 0, NULL, NULL),
(267, 'Садовник', 'gardener', 0, 0, 0, 0, NULL, NULL),
(268, 'Сапожник', 'shoemaker', 0, 0, 0, 0, NULL, NULL),
(269, 'Уборщица', 'cleaning-woman', 0, 0, 0, 0, NULL, NULL),
(270, 'Упаковщик', 'packer', 0, 0, 0, 0, NULL, NULL),
(271, 'Цветочница', 'flower-girl', 0, 0, 0, 0, NULL, NULL),
(272, 'Шеф-повар', 'chef', 0, 0, 0, 0, NULL, NULL),
(273, 'Инструктор по видам спорта', 'instructor-sport-kinds', 0, 0, 0, 0, NULL, NULL),
(274, 'Спортивный тренер', 'coach', 0, 0, 0, 0, NULL, NULL),
(275, 'Спортсмен', 'athlete', 0, 0, 0, 0, NULL, NULL),
(276, 'Аниматор', 'animator', 0, 0, 0, 0, NULL, NULL),
(277, 'Артист цирка', 'circus-artist', 0, 0, 0, 0, NULL, NULL),
(278, 'Хореограф', 'choreographer', 0, 0, 0, 0, NULL, NULL),
(279, 'Диджей', 'dj', 0, 0, 0, 0, NULL, NULL),
(280, 'Дизайнер рекламы', 'ad-designer', 0, 0, 0, 0, NULL, NULL),
(282, 'Дирижер', 'conductor', 0, 0, 0, 0, NULL, NULL),
(283, 'Закройщик', 'cutter', 0, 0, 0, 0, NULL, NULL),
(284, 'Звукооператор', 'recordist', 0, 0, 0, 0, NULL, NULL),
(285, 'Звукорежиссер', 'soundman', 0, 0, 0, 0, NULL, NULL),
(286, 'Имиджмейкер', 'image-maker', 0, 0, 0, 0, NULL, NULL),
(287, 'Каскадер', 'stuntman', 0, 0, 0, 0, NULL, NULL),
(288, 'Кинодраматург', 'screenwriter', 0, 0, 0, 0, NULL, NULL),
(289, 'Киномеханик', 'projectionist', 0, 0, 0, 0, NULL, NULL),
(290, 'Кинооператор', 'cameraman', 0, 0, 0, 0, NULL, NULL),
(291, 'Кинорежиссер', 'filmmaker', 0, 0, 0, 0, NULL, NULL),
(292, 'Композитор', 'composer', 0, 0, 0, 0, NULL, NULL),
(293, 'Критик', 'critic', 0, 0, 0, 0, NULL, NULL),
(294, 'Манекенщица', 'mannequin', 0, 0, 0, 0, NULL, NULL),
(295, 'Модель', 'model', 0, 0, 0, 0, NULL, NULL),
(296, 'Музыкант', 'musician', 0, 0, 0, 0, NULL, NULL),
(297, 'Телеоператор', 'teleoperator', 0, 0, 0, 0, NULL, NULL),
(298, 'Портной', 'tailor', 0, 0, 0, 0, NULL, NULL),
(300, 'Скульптор', 'sculptor', 0, 0, 0, 0, NULL, NULL),
(301, 'Спичрайтер', 'speechwriter', 0, 0, 0, 0, NULL, NULL),
(303, 'Танцор балета', 'ballet-dancer', 0, 0, 0, 0, NULL, NULL),
(304, 'Татуировщик', 'tattoo-artist', 0, 0, 0, 0, NULL, NULL),
(305, 'Технический писатель', 'technical-writer', 0, 0, 0, 0, NULL, NULL),
(306, 'Фотомодель', 'cover-girl', 0, 0, 0, 0, NULL, NULL),
(308, 'Художник по костюму', 'costume', 0, 0, 0, 0, NULL, NULL),
(309, 'Постановщик трюков', 'stunt-coordinator', 0, 0, 0, 0, NULL, NULL),
(310, 'Автогонщик', 'race-driver', 0, 0, 0, 0, NULL, NULL),
(311, 'Аппаратчик-оператор', 'apparatus-operator', 0, 0, 0, 0, NULL, NULL),
(312, 'Архитектор-проектировщик', 'architect-design', 0, 0, 0, 0, NULL, NULL),
(313, 'Бондарь', 'cooper', 0, 0, 0, 0, NULL, NULL),
(314, 'Бульдозерист', 'bulldozer', 0, 0, 0, 0, NULL, NULL),
(315, 'Вальцовщик стана горячей прокатки', 'roller-hot-rolling-mill', 0, 0, 0, 0, NULL, NULL),
(316, 'Водолаз', 'diver', 0, 0, 0, 0, NULL, NULL),
(317, 'Геодезист', 'geodesist', 0, 0, 0, 0, NULL, NULL),
(318, 'Геоэколог', 'geoecology', 0, 0, 0, 0, NULL, NULL),
(319, 'Главный инженер', 'chief-engineer', 0, 0, 0, 0, NULL, NULL),
(320, 'Главный конструктор', 'chief-designer', 0, 0, 0, 0, NULL, NULL),
(321, 'Главный технолог', 'chief-technologist', 0, 0, 0, 0, NULL, NULL),
(322, 'Шахтер', 'miner', 0, 0, 0, 0, NULL, NULL),
(323, 'Драпировщик', 'draper', 0, 0, 0, 0, NULL, NULL),
(324, 'Инженер-конструктор', 'design-engineer', 0, 0, 0, 0, NULL, NULL),
(325, 'Инженер-технолог', 'process-engineer', 0, 0, 0, 0, NULL, NULL),
(326, 'Инженер-химик', 'chemical-engineer', 0, 0, 0, 0, NULL, NULL),
(327, 'Испытатель', 'investigator', 0, 0, 0, 0, NULL, NULL),
(328, 'Каменщик', 'mason', 0, 0, 0, 0, NULL, NULL),
(329, 'Крановщик', 'crane-driver', 0, 0, 0, 0, NULL, NULL),
(330, 'Краснодеревщик', 'cabinetmaker', 0, 0, 0, 0, NULL, NULL),
(331, 'Кровельщик', 'roofer', 0, 0, 0, 0, NULL, NULL),
(332, 'Литейщик', 'caster', 0, 0, 0, 0, NULL, NULL),
(333, 'Маляр', 'painter', 0, 0, 0, 0, NULL, NULL),
(334, 'Маркшейдер', 'surveyor', 0, 0, 0, 0, NULL, NULL),
(335, 'Мастер', 'master', 0, 0, 0, 0, NULL, NULL),
(336, 'Машинист', 'machinist', 0, 0, 0, 0, NULL, NULL),
(337, 'Монтажник', 'mounter', 0, 0, 0, 0, NULL, NULL),
(338, 'Моторист', 'motorist', 0, 0, 0, 0, NULL, NULL),
(339, 'Наладчик', 'fixer', 0, 0, 0, 0, NULL, NULL),
(340, 'Облицовщик', 'tiles', 0, 0, 0, 0, NULL, NULL),
(341, 'Отделочник', 'finisher', 0, 0, 0, 0, NULL, NULL),
(342, 'Плотник', 'carpenter', 0, 0, 0, 0, NULL, NULL),
(343, 'Производственный мастер', 'production-master', 0, 0, 0, 0, NULL, NULL),
(344, 'Прораб', 'foreman', 0, 0, 0, 0, NULL, NULL),
(345, 'Проходчик', 'sinker', 0, 0, 0, 0, NULL, NULL),
(346, 'Радиомеханик', 'radiomechanic', 0, 0, 0, 0, NULL, NULL),
(347, 'Ремонтник', 'repairer', 0, 0, 0, 0, NULL, NULL),
(348, 'Рихтовщик', 'beaters', 0, 0, 0, 0, NULL, NULL),
(349, 'Сантехник', 'plumber', 0, 0, 0, 0, NULL, NULL),
(350, 'Сварщик', 'welder', 0, 0, 0, 0, NULL, NULL),
(351, 'Слесарь', 'locksmith', 0, 0, 0, 0, NULL, NULL),
(352, 'Сталевар', 'steel-maker', 0, 0, 0, 0, NULL, NULL),
(353, 'Станочник широкого профиля', 'machine-operator-generalist', 0, 0, 0, 0, NULL, NULL),
(355, 'Техник по эксплуатации', 'maintenance-technician', 0, 0, 0, 0, NULL, NULL),
(356, 'Токарь', 'turner', 0, 0, 0, 0, NULL, NULL),
(357, 'Фрезеровщик', 'miller', 0, 0, 0, 0, NULL, NULL),
(359, 'Холодильщик', 'refrigeration', 0, 0, 0, 0, NULL, NULL),
(361, 'Швея', 'seamstress', 0, 0, 0, 0, NULL, NULL),
(362, 'Шлифовщик', 'grinder', 0, 0, 0, 0, NULL, NULL),
(363, 'Штукатур', 'plasterer', 0, 0, 0, 0, NULL, NULL),
(364, 'Электромонтажник', 'electrical', 0, 0, 0, 0, NULL, NULL),
(365, 'Авиадиспетчер', 'aviadispatcher', 0, 0, 0, 0, NULL, NULL),
(366, 'Бортинженер', 'flight-engineer', 0, 0, 0, 0, NULL, NULL),
(367, 'Бортмеханик', 'flight-mechanic', 0, 0, 0, 0, NULL, NULL),
(368, 'Бортпроводник', 'flight-attendant', 0, 0, 0, 0, NULL, NULL),
(369, 'Бригадир железнодорожного пути', 'foreman-railway-tracks', 0, 0, 0, 0, NULL, NULL),
(370, 'Водитель', 'driver', 0, 0, 0, 0, NULL, NULL),
(371, 'Воздухоплаватель', 'balloonist', 0, 0, 0, 0, NULL, NULL),
(372, 'Диспетчер', 'dispatcher', 0, 0, 0, 0, NULL, NULL),
(373, 'Капитан судна', 'ship-captain', 0, 0, 0, 0, NULL, NULL),
(374, 'Космонавт', 'cosmonaut', 0, 0, 0, 0, NULL, NULL),
(375, 'Курьер', 'courier', 0, 0, 0, 0, NULL, NULL),
(376, 'Лоцман', 'lotsman', 0, 0, 0, 0, NULL, NULL),
(377, 'Матрос', 'sailor', 0, 0, 0, 0, NULL, NULL),
(378, 'Проводник', 'train-conductor', 0, 0, 0, 0, NULL, NULL),
(379, 'Слесарь-механик', 'mechanical-fitter', 0, 0, 0, 0, NULL, NULL),
(380, 'Стрелочник', 'switchman', 0, 0, 0, 0, NULL, NULL),
(381, 'Таксист', 'taxi-driver', 0, 0, 0, 0, NULL, NULL),
(382, 'Штурман', 'navigator', 0, 0, 0, 0, NULL, NULL),
(383, 'Экспедитор', 'forwarder', 0, 0, 0, 0, NULL, NULL),
(384, 'Продакт-менеджер', 'product-manager', 0, 0, 0, 0, NULL, NULL),
(385, 'Администратор предприятия торговли', 'trading-enterprise-administrator', 0, 0, 0, 0, NULL, NULL),
(386, 'Ассистент менеджера по продажам', 'sales-manager-assistant', 0, 0, 0, 0, NULL, NULL),
(387, 'Банкир', 'banker', 0, 0, 0, 0, NULL, NULL),
(388, 'Банковский кассир-операционист', 'bank-cashier', 0, 0, 0, 0, NULL, NULL),
(389, 'Бизнес-аналитик', 'business-analyst', 0, 0, 0, 0, NULL, NULL),
(390, 'Бизнес-консультант', 'business-consultant', 0, 0, 0, 0, NULL, NULL),
(391, 'Бизнес-тренер', 'business-trainer', 0, 0, 0, 0, NULL, NULL),
(392, 'Билетный кассир', 'ticket-cashier', 0, 0, 0, 0, NULL, NULL),
(393, 'Бренд-дизайнер', 'brand-designer', 0, 0, 0, 0, NULL, NULL),
(394, 'Бренд-менеджер', 'brand-manager', 0, 0, 0, 0, NULL, NULL),
(395, 'Брокер', 'broker', 0, 0, 0, 0, NULL, NULL),
(396, 'Дистрибьютор', 'distributor', 0, 0, 0, 0, NULL, NULL),
(397, 'Заведующий складом', 'warehouse-manager', 0, 0, 0, 0, NULL, NULL),
(398, 'Инкассатор', 'bill-collector', 0, 0, 0, 0, NULL, NULL),
(399, 'Кассир', 'cashier', 0, 0, 0, 0, NULL, NULL),
(400, 'Кризис-менеджер', 'crisis-manager', 0, 0, 0, 0, NULL, NULL),
(401, 'Лоббист', 'lobbyist', 0, 0, 0, 0, NULL, NULL),
(403, 'Медиа-байер', 'media-buyer', 0, 0, 0, 0, NULL, NULL),
(404, 'Менеджер по PR', 'pr-manager', 0, 0, 0, 0, NULL, NULL),
(405, 'Менеджер по закупкам', 'purchasing-manager', 0, 0, 0, 0, NULL, NULL),
(406, 'Менеджер по логистике', 'logistics-manager', 0, 0, 0, 0, NULL, NULL),
(407, 'Менеджер по работе с клиентами', 'account-manager', 0, 0, 0, 0, NULL, NULL),
(408, 'Менеджер по рекламе', 'advertising-manager', 0, 0, 0, 0, NULL, NULL),
(409, 'Менеджер торгового зала', 'trading-hall-manager', 0, 0, 0, 0, NULL, NULL),
(410, 'Мерчендайзер', 'merchandiser', 0, 0, 0, 0, NULL, NULL),
(411, 'Налоговый инспектор', 'tax-inspector', 0, 0, 0, 0, NULL, NULL),
(412, 'Офис-менеджер', 'office-manager', 0, 0, 0, 0, NULL, NULL),
(413, 'Оценщик', 'appraiser', 0, 0, 0, 0, NULL, NULL),
(414, 'Продавец', 'seller', 0, 0, 0, 0, NULL, NULL),
(415, 'Продавец-консультант', 'shop-assistant', 0, 0, 0, 0, NULL, NULL),
(416, 'Промоутер', 'promoter', 0, 0, 0, 0, NULL, NULL),
(418, 'Сметчик', 'estimator', 0, 0, 0, 0, NULL, NULL),
(419, 'Снабженец', 'supplier', 0, 0, 0, 0, NULL, NULL),
(420, 'Специалист по ВЭД', 'fea-specialist', 0, 0, 0, 0, NULL, NULL),
(421, 'Статистик', 'statistician', 0, 0, 0, 0, NULL, NULL),
(422, 'Супервайзер', 'supervisor', 0, 0, 0, 0, NULL, NULL),
(423, 'Торговый представитель', 'sales-representative', 0, 0, 0, 0, NULL, NULL),
(424, 'Трейдер', 'trader', 0, 0, 0, 0, NULL, NULL),
(425, 'Военнослужащий', 'serviceman', 0, 0, 0, 0, NULL, NULL),
(426, 'Разведчик', 'scout', 0, 0, 0, 0, NULL, NULL),
(427, 'Продюсер', 'producer', 0, 0, 0, 0, NULL, NULL),
(428, 'Авиакассир', 'aviakassir', 0, 0, 0, 0, NULL, NULL),
(429, 'Агент по недвижимости', 'real-estate-agent', 0, 0, 0, 0, NULL, NULL),
(430, 'Администратор 1С', '1c-administrator', 0, 0, 0, 0, NULL, NULL),
(431, 'Администратор Oracle', 'oracle-administrator', 0, 0, 0, 0, NULL, NULL),
(432, 'Администратор офиса', 'office-administrator', 0, 0, 0, 0, NULL, NULL),
(433, 'Арт-диретор', 'art-director', 0, 0, 0, 0, NULL, NULL),
(434, 'Ассистент руководителя', 'directors-assistant', 0, 0, 0, 0, NULL, NULL),
(435, 'Ассистент стоматолога', 'dental-assistant', 0, 0, 0, 0, NULL, NULL),
(436, 'ВидеооператорVideographer', 'videographer', 0, 0, 0, 0, NULL, NULL),
(437, 'Видеомонтажник', 'video-editors', 0, 0, 0, 0, NULL, NULL),
(438, 'Видео дизайнер', 'video-designer', 0, 0, 0, 0, NULL, NULL),
(439, '3D дизайнер', '3d-designer', 0, 0, 0, 0, NULL, NULL),
(440, 'Аналитик МСБ', 'msb-analyst', 0, 0, 0, 0, NULL, NULL),
(441, '1С специалист', '1c-specialist', 0, 0, 0, 0, NULL, NULL),
(442, 'Инженер-энергетик', 'energy-engineer', 0, 0, 0, 0, NULL, NULL),
(443, 'Инженер-сметчик', 'engineer-estimator', 0, 0, 0, 0, NULL, NULL),
(444, 'Инженер ПТО', 'engineer-pto', 0, 0, 0, 0, NULL, NULL),
(445, 'Инженер-проектировщик', 'engineer-proekirovshik', 0, 0, 0, 0, NULL, NULL),
(446, 'GR менеджер', 'gr-manager', 0, 0, 0, 0, NULL, NULL),
(447, 'Дежурный', 'person-on-duty', 0, 0, 0, 0, NULL, NULL),
(448, 'Дизайнер игр', 'game-designer', 0, 0, 0, 0, NULL, NULL),
(449, 'Дизайнер иллюстратор', 'designer-illustrator', 0, 0, 0, 0, NULL, NULL),
(450, 'UX дизайнер', 'ux-designer', 0, 0, 0, 0, NULL, NULL),
(451, 'Дизайнер модельер', 'designer-fashion', 0, 0, 0, 0, NULL, NULL),
(452, 'Закупщик', 'purchasing-agent', 0, 0, 0, 0, NULL, NULL),
(453, 'Звукоинженер', 'sound-engineer', 0, 0, 0, 0, NULL, NULL),
(454, 'Инвестиционный аналитик', 'equity-analyst', 0, 0, 0, 0, NULL, NULL),
(455, 'Информационный работник', 'information-worker', 0, 0, 0, 0, NULL, NULL),
(456, 'кредитный брокер', 'credit-broker', 0, 0, 0, 0, NULL, NULL),
(457, 'Финансовый брокер', 'financial-broker', 0, 0, 0, 0, NULL, NULL),
(458, 'Ипотечный менеджер', 'mortgage-manager', 0, 0, 0, 0, NULL, NULL),
(459, 'Кабельщик', 'cable', 0, 0, 0, 0, NULL, NULL),
(460, 'Консультант по ERP-системе', 'erpsystem-consultant', 0, 0, 0, 0, NULL, NULL),
(461, 'Консультант по аренде', 'rental-consultant', 0, 0, 0, 0, NULL, NULL),
(462, 'Консультант по внедрению', 'implementation-consultant', 0, 0, 0, 0, NULL, NULL),
(463, 'Контролер', 'controller', 0, 0, 0, 0, NULL, NULL),
(464, 'Корреспондент', 'correspondent', 0, 0, 0, 0, NULL, NULL),
(465, 'Креатив-менеджер', 'creative-manager', 0, 0, 0, 0, NULL, NULL),
(466, 'Кредитный эксперт', 'credit-expert', 0, 0, 0, 0, NULL, NULL),
(467, 'Крупье', 'croupier', 0, 0, 0, 0, NULL, NULL),
(468, 'Лектор', 'lecturer', 0, 0, 0, 0, NULL, NULL),
(469, 'Макетчик', 'desktop-publisher', 0, 0, 0, 0, NULL, NULL),
(470, 'Мастер маникюра/педикюра', 'manicure-pedicure', 0, 0, 0, 0, NULL, NULL),
(471, 'Машинист буровой установки', 'machinist-rig', 0, 0, 0, 0, NULL, NULL),
(472, 'Менеджер Аccount', 'manager-account', 0, 0, 0, 0, NULL, NULL),
(473, 'Менеджер гостиницы', 'hotel-manager', 0, 0, 0, 0, NULL, NULL),
(474, 'Менеджер по интернет продажам', 'internet-sales', 0, 0, 0, 0, NULL, NULL),
(475, 'Менеджер по работе с дилерами', 'dealers-manager', 0, 0, 0, 0, NULL, NULL),
(476, 'Менеджер активных продаж', 'manager-of-active-sales', 0, 0, 0, 0, NULL, NULL),
(477, 'Региональный менеджер', 'regional-manager', 0, 0, 0, 0, NULL, NULL),
(478, 'Менеджер по корпоративным продажам', 'corporate-sales-manager', 0, 0, 0, 0, NULL, NULL),
(479, 'Оператор по приему заказов', 'operator-receiving-orders', 0, 0, 0, 0, NULL, NULL),
(480, 'Специалист по работе с клиентами', 'specialist-working-customers', 0, 0, 0, 0, NULL, NULL),
(481, 'Специалист по снабжению', 'procurement-specialist', 0, 0, 0, 0, NULL, NULL),
(482, 'Специалист по логистике', 'logistics-specialist', 0, 0, 0, 0, NULL, NULL),
(483, 'Специалист отдела закупок', 'specialist-purchasing-manager', 0, 0, 0, 0, NULL, NULL),
(484, 'Менеджер по управлению товарными запасами', 'inventory-control-manager', 0, 0, 0, 0, NULL, NULL),
(485, 'Менеджер по продажам HoReCa', 'sales-horeca-manager', 0, 0, 0, 0, NULL, NULL),
(486, 'Оператор АЗС', 'petrol-station-operator', 0, 0, 0, 0, NULL, NULL),
(488, 'Оператор по холодным звонкам', 'operator-direct-calls', 0, 0, 0, 0, NULL, NULL),
(489, 'Программист 1С', '1c-developer', 0, 0, 0, 0, NULL, NULL),
(491, 'Программист C++', 'c-plus-plus-developer', 0, 0, 0, 0, NULL, NULL),
(492, 'Программист Delphi', 'delphi-developer', 0, 0, 0, 0, NULL, NULL),
(493, 'Программист ERP', 'erp-programmer', 0, 0, 0, 0, NULL, NULL),
(494, 'Программист Flash', 'flash-developer', 0, 0, 0, 0, NULL, NULL),
(495, 'Программист Java', 'java-developer', 0, 0, 0, 0, NULL, NULL),
(500, 'Программист PHP', 'php-developer', 0, 0, 0, 0, NULL, NULL),
(501, 'Инженер-программист АСУ', 'software-engineer-asu', 0, 0, 0, 0, NULL, NULL),
(502, 'Инженер программист Scada систем', 'software-engineer-scada', 0, 0, 0, 0, NULL, NULL),
(503, 'Техник-ремонтник электрооборудования', 'technician-electrical-technician', 0, 0, 0, 0, NULL, NULL),
(504, 'Секретарь на ресепшен', 'secretary-receptionist', 0, 0, 0, 0, NULL, NULL),
(505, 'Су-шеф', 'sous-chef', 0, 0, 0, 0, NULL, NULL),
(506, 'Специалист технической поддержки', 'technical-support-specialist', 0, 0, 0, 0, NULL, NULL),
(507, 'Инженер по информационной безопасности', 'information-security-engineer', 0, 0, 0, 0, NULL, NULL),
(508, 'Технический специалист', 'technical-specialist', 0, 0, 0, 0, NULL, NULL),
(509, 'Технолог по производству лекарственных средств', 'production-drugs-technologies', 0, 0, 0, 0, NULL, NULL),
(510, 'Финансовый консультант', 'financial-consultant', 0, 0, 0, 0, NULL, NULL),
(511, 'Фармацевтический представитель', 'pharmaceutical-representative', 0, 0, 0, 0, NULL, NULL),
(512, 'Финансовый контролер', 'financial-controller', 0, 0, 0, 0, NULL, NULL),
(513, 'Хостесс', 'hostess', 0, 0, 0, 0, NULL, NULL),
(514, 'Бухгалтер-экономист', 'accountant-economist', 0, 0, 0, 0, NULL, NULL),
(515, 'Аналитик-экономист', 'analyst-economist', 0, 0, 0, 0, NULL, NULL),
(516, 'Главный энергетик', 'chief-power-engineer', 0, 0, 0, 0, NULL, NULL),
(517, 'Ведущий юрист', 'leading-lawyer', 0, 0, 0, 0, NULL, NULL),
(518, 'Юрист по договорам', 'contracts-lawyer', 0, 0, 0, 0, NULL, NULL),
(519, 'Юрист-кадровик', 'lawyer-personnel-officer', 0, 0, 0, 0, NULL, NULL),
(520, 'Юрист по госзакупкам', 'lawyer-public-procurement', 0, 0, 0, 0, NULL, NULL),
(521, 'Специалист по разрешительной документации', 'allowing-documentation-specialist', 0, 0, 0, 0, NULL, NULL),
(522, 'Специалист по тендерам', 'tenders-specialist', 0, 0, 0, 0, NULL, NULL),
(523, 'Специалист по сбыту', 'sales-specialist', 0, 0, 0, 0, NULL, NULL),
(524, 'iOS-разработчик', 'ios-developer', 0, 0, 0, 0, NULL, NULL),
(525, 'Android-разработчик', 'android-developer', 0, 0, 0, 0, NULL, NULL),
(526, 'Разработчик мобильных приложений', 'mobile-developer', 0, 0, 0, 0, NULL, NULL),
(527, 'Программист Python', 'python-developer', 0, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `regions`
--

CREATE TABLE `regions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_title` varchar(255) DEFAULT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `regions`
--

INSERT INTO `regions` (`id`, `title`, `short_title`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Акмолинская область', NULL, 1, NULL, NULL),
(2, 'Актюбинская область', NULL, 1, NULL, NULL),
(3, 'Алматинская область', NULL, 1, NULL, NULL),
(4, 'Атырауская область', NULL, 1, NULL, NULL),
(5, 'Восточно-Казахстанская область', NULL, 1, NULL, NULL),
(6, 'Жамбылская область', NULL, 1, NULL, NULL),
(7, 'Западно-Казахстанская область', NULL, 1, NULL, NULL),
(8, 'Карагандинская область', NULL, 1, NULL, NULL),
(9, 'Костанайская область', NULL, 1, NULL, NULL),
(10, 'Кызылординская область', NULL, 1, NULL, NULL),
(11, 'Мангистауская область', NULL, 1, NULL, NULL),
(12, 'Павлодарская область', NULL, 1, NULL, NULL),
(13, 'Северо-Казахстанская область', NULL, 1, NULL, NULL),
(14, 'Южно-Казахстанская область', NULL, 1, NULL, NULL),
(15, 'Техас', NULL, 204, NULL, NULL),
(16, 'Калифорния', NULL, 204, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL COMMENT 'для какой компании отзыв',
  `text` varchar(255) NOT NULL COMMENT 'текст отзыва',
  `active_employee` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'отзыв от действующего сотрудника',
  `rating` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'общая оценка компании от респондента',
  `position_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'должность респондента',
  `position_title` varchar(255) DEFAULT NULL COMMENT 'должность респондента - строкой',
  `status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending' COMMENT 'статус отзыва: approved - одобрен, pending - в ожинании, rejected - отконен',
  `employment_form_alias` varchar(255) DEFAULT NULL COMMENT 'форма занятости',
  `recommend` tinyint(1) DEFAULT NULL COMMENT 'рекомендую ли работать',
  `stage_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'стаж работы',
  `city_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'местоположение офиса',
  `city_title` varchar(255) DEFAULT NULL COMMENT 'местоположение офиса - строкой',
  `user_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'пользователь оставивший отзыв',
  `anonym` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'отзыв является анонимным',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `salaries`
--

CREATE TABLE `salaries` (
  `id` int(10) UNSIGNED NOT NULL,
  `base_pay` int(10) UNSIGNED NOT NULL COMMENT 'основная сумма',
  `currency_code` varchar(3) DEFAULT NULL COMMENT 'валюта зарплаты',
  `company_id` int(10) UNSIGNED NOT NULL COMMENT 'компания',
  `employee_status` enum('active','former') DEFAULT NULL COMMENT 'статус работника: active - действующий, former - бывший',
  `last_year` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'последний год работы для бывшего работника',
  `status` enum('approved','pending','rejected') NOT NULL DEFAULT 'pending',
  `position_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'должность респондента',
  `position_title` varchar(255) DEFAULT NULL COMMENT 'должность респондента - строкой',
  `user_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'пользователь оставивший данные о зарплате',
  `period` enum('year','month','day','hour') DEFAULT NULL,
  `stage_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'стаж работы',
  `city_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'местоположение офиса',
  `city_title` varchar(255) DEFAULT NULL COMMENT 'местоположение офиса - строкой',
  `employment_form_alias` varchar(255) DEFAULT NULL COMMENT 'форма занятости',
  `has_additional_payments` tinyint(1) DEFAULT NULL COMMENT 'есть ли дополнительные выплаты: 1 - да, 0 - нет, null - не указал',
  `company_industry_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'направление деятельности компании',
  `company_size_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'размер компании',
  `hidden_employer` tinyint(1) DEFAULT NULL COMMENT 'флаг скрытый работодатель',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `salary_additional_payments`
--

CREATE TABLE `salary_additional_payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `salary_id` int(10) UNSIGNED NOT NULL COMMENT 'к какой зарплате относится',
  `type_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'тип выплаты',
  `value` double(8,2) NOT NULL COMMENT 'сумма',
  `period` enum('year','month') NOT NULL COMMENT 'период',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `salary_additional_payments_types`
--

CREATE TABLE `salary_additional_payments_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `periods` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `salary_additional_payments_types`
--

INSERT INTO `salary_additional_payments_types` (`id`, `title`, `sort`, `periods`, `created_at`, `updated_at`) VALUES
(1, 'Праздничные премии', 2, 'year,month', NULL, NULL),
(2, 'Годовая премия <br>(13-ая зарплата)', 3, 'year', NULL, NULL),
(3, 'Премия по результатам труда', 4, 'year, month', NULL, NULL),
(4, 'Проценты от продаж', 5, 'year,month', NULL, NULL),
(5, 'Единовременные поощрения', 6, 'year,month', NULL, NULL),
(6, 'Другие выплаты', 7, 'year,month', NULL, NULL),
(8, 'Отпускные', 1, 'year,month', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `skills`
--

CREATE TABLE `skills` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `skills`
--

INSERT INTO `skills` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'JavaScript', NULL, NULL),
(2, 'Java', NULL, NULL),
(5, 'Delphi', NULL, NULL),
(6, 'HTML', NULL, NULL),
(7, 'CSS', NULL, NULL),
(8, 'PHP', NULL, NULL),
(9, 'HTTP', NULL, NULL),
(10, 'Linux', NULL, NULL),
(11, 'Twitter Bootstrap', NULL, NULL),
(12, 'Кроссбраузерная верстка', NULL, NULL),
(13, 'Веб разработка', NULL, NULL),
(14, 'Верстка лендингов', NULL, NULL),
(15, 'Sass', NULL, NULL),
(16, 'Gulp', NULL, NULL),
(17, 'JQuery', NULL, NULL),
(18, 'jq', NULL, NULL),
(19, 'JS', NULL, NULL),
(20, 'git', NULL, NULL),
(21, 'svn', NULL, NULL),
(22, 'joomla', NULL, NULL),
(23, 'WordPress', NULL, NULL),
(24, 'Photoshop', NULL, NULL),
(25, 'CorelDRAW', NULL, NULL),
(26, 'ООП', NULL, NULL),
(27, 'Hibernate', NULL, NULL),
(28, 'JPA', NULL, NULL),
(29, 'Spring', NULL, NULL),
(30, 'EJB3', NULL, NULL),
(31, 'XML', NULL, NULL),
(32, 'Scrum', NULL, NULL),
(33, 'Node.js', NULL, NULL),
(34, 'ECMAScript 2016', NULL, NULL),
(35, 'SCSS', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `stages`
--

CREATE TABLE `stages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `stages`
--

INSERT INTO `stages` (`id`, `title`, `sort`, `created_at`, `updated_at`) VALUES
(1, '1-2 года', 2, NULL, NULL),
(3, '5-7 лет', 4, NULL, NULL),
(4, 'более 10 лет', 6, NULL, NULL),
(5, 'Менее года', 1, NULL, NULL),
(6, '3-4 года', 3, NULL, NULL),
(7, '8-10 лет', 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `taggables`
--

CREATE TABLE `taggables` (
  `tag_id` int(10) UNSIGNED NOT NULL COMMENT 'тег',
  `taggable_id` int(10) UNSIGNED NOT NULL COMMENT 'объект',
  `taggable_type` varchar(255) NOT NULL COMMENT 'тип объекта',
  `sort` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'ms', NULL, NULL),
(2, 'jquery', NULL, NULL),
(3, 'html5', NULL, NULL),
(4, 'программирование', NULL, NULL),
(5, 'разработка', NULL, NULL),
(6, 'php', NULL, NULL),
(7, 'ваыва', NULL, NULL),
(8, 'ыва', NULL, NULL),
(9, '123', NULL, NULL),
(10, 'вываыва', NULL, NULL),
(11, 'java', NULL, NULL),
(12, 'mysql', NULL, NULL),
(13, 'js', NULL, NULL),
(14, 'vanilla js', NULL, NULL),
(15, 'nodejs', NULL, NULL),
(16, '456', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `universities`
--

CREATE TABLE `universities` (
  `id` int(10) UNSIGNED NOT NULL,
  `alias` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `country_id` int(10) UNSIGNED DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `logo_id` int(10) UNSIGNED DEFAULT NULL,
  `vk_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'id университета ВКонтакте',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `universities`
--

INSERT INTO `universities` (`id`, `alias`, `title`, `site`, `country_id`, `city_id`, `logo_id`, `vk_id`, `created_at`, `updated_at`) VALUES
(2, 'kstu', 'Карагандинский государственный технический университет', 'http://www.kstu.kz/', NULL, 2, NULL, NULL, NULL, NULL),
(3, 'ksu', 'Карагандинский государственный университет', 'http://www.ksu.kz/', NULL, 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, '', 'kosha.industry@gmail.com', 'kosha.industry', '$2y$10$Jj.TcXYUmUpdtq/qDpmSYuVK0YAYz2BMokFqTeT.xltI2YjVJCASG', 'aY8l3NslmVH9Hka1f3vgUqShUdZYqWuebt6CWIWbN955PGzZSY73xeIVKUL8', '2017-08-11 10:11:35', '2017-08-11 13:15:11');

-- --------------------------------------------------------

--
-- Структура таблицы `user_educations`
--

CREATE TABLE `user_educations` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL COMMENT 'пользователь',
  `university_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'университет',
  `faculty_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'факультет',
  `chair_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'кафедра/направление',
  `edu_form_id` int(10) UNSIGNED DEFAULT NULL,
  `start_year` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'год начала обучения',
  `start_month` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'месяц начала обучения',
  `end_year` smallint(5) UNSIGNED DEFAULT NULL COMMENT 'год окончания обучения',
  `end_month` tinyint(3) UNSIGNED DEFAULT NULL COMMENT 'месяц окончания обучения',
  `text` text NOT NULL COMMENT 'описание (специализация и достижения)',
  `specialty` varchar(255) DEFAULT NULL COMMENT 'специальность',
  `status_id` int(10) UNSIGNED DEFAULT NULL COMMENT 'статус образования',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Индексы таблицы `ceo`
--
ALTER TABLE `ceo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ceo_avatar_id_foreign` (`avatar_id`),
  ADD KEY `ceo_company_id_foreign` (`company_id`);

--
-- Индексы таблицы `chairs`
--
ALTER TABLE `chairs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chairs_vk_id_unique` (`vk_id`),
  ADD KEY `chairs_faculty_id_foreign` (`faculty_id`);

--
-- Индексы таблицы `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_alias_unique` (`alias`),
  ADD UNIQUE KEY `cities_vk_id_unique` (`vk_id`),
  ADD KEY `cities_country_id_foreign` (`country_id`),
  ADD KEY `cities_region_id_foreign` (`region_id`);

--
-- Индексы таблицы `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_created_user_id_foreign` (`created_user_id`),
  ADD KEY `companies_updated_user_id_foreign` (`updated_user_id`),
  ADD KEY `companies_logo_id_foreign` (`logo_id`),
  ADD KEY `companies_cover_id_foreign` (`cover_id`),
  ADD KEY `companies_size_id_foreign` (`size_id`),
  ADD KEY `companies_revenue_id_foreign` (`revenue_id`),
  ADD KEY `companies_hq_city_id_foreign` (`hq_city_id`);

--
-- Индексы таблицы `company_images`
--
ALTER TABLE `company_images`
  ADD KEY `company_images_company_id_foreign` (`company_id`),
  ADD KEY `company_images_image_id_foreign` (`image_id`);

--
-- Индексы таблицы `company_industries`
--
ALTER TABLE `company_industries`
  ADD KEY `company_industries_company_id_foreign` (`company_id`),
  ADD KEY `company_industries_industry_id_foreign` (`industry_id`);

--
-- Индексы таблицы `company_revenues`
--
ALTER TABLE `company_revenues`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_revenues_title_unique` (`title`);

--
-- Индексы таблицы `company_sizes`
--
ALTER TABLE `company_sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_sizes_alias_unique` (`alias`),
  ADD UNIQUE KEY `company_sizes_employees_count_unique` (`employees_count`);

--
-- Индексы таблицы `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_title_unique` (`title`),
  ADD UNIQUE KEY `countries_iso_code_unique` (`iso_code`),
  ADD UNIQUE KEY `countries_vk_id_unique` (`vk_id`);

--
-- Индексы таблицы `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_title_unique` (`title`),
  ADD UNIQUE KEY `currencies_code_unique` (`code`);

--
-- Индексы таблицы `education_forms`
--
ALTER TABLE `education_forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `education_forms_title_unique` (`title`),
  ADD UNIQUE KEY `education_forms_vk_education_form_unique` (`vk_education_form`);

--
-- Индексы таблицы `education_statuses`
--
ALTER TABLE `education_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `education_statuses_title_unique` (`title`);

--
-- Индексы таблицы `employment_forms`
--
ALTER TABLE `employment_forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employment_forms_title_unique` (`title`),
  ADD UNIQUE KEY `employment_forms_alias_unique` (`alias`);

--
-- Индексы таблицы `faculties`
--
ALTER TABLE `faculties`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `faculties_vk_id_unique` (`vk_id`),
  ADD KEY `faculties_university_id_foreign` (`university_id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `images_path_unique` (`path`);

--
-- Индексы таблицы `industries`
--
ALTER TABLE `industries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `industries_title_unique` (`title`);

--
-- Индексы таблицы `interviews`
--
ALTER TABLE `interviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `interviews_alias_unique` (`alias`),
  ADD KEY `interviews_company_id_foreign` (`company_id`),
  ADD KEY `interviews_user_id_foreign` (`user_id`),
  ADD KEY `interviews_source_id_foreign` (`source_id`),
  ADD KEY `interviews_position_id_foreign` (`position_id`),
  ADD KEY `interviews_city_id_foreign` (`city_id`);

--
-- Индексы таблицы `interview_sources`
--
ALTER TABLE `interview_sources`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `interview_sources_title_unique` (`title`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_position_id_foreign` (`position_id`),
  ADD KEY `jobs_stage_id_foreign` (`stage_id`),
  ADD KEY `jobs_company_id_foreign` (`company_id`),
  ADD KEY `jobs_user_id_foreign` (`user_id`),
  ADD KEY `employment_form_id_foreign` (`employment_form_id`),
  ADD KEY `currency_id_foreign` (`currency_id`);

--
-- Индексы таблицы `jobs_cities`
--
ALTER TABLE `jobs_cities`
  ADD UNIQUE KEY `jobs_cities_job_id_city_id_unique` (`job_id`,`city_id`),
  ADD KEY `jobs_cities_city_id_foreign` (`city_id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `morpher`
--
ALTER TABLE `morpher`
  ADD PRIMARY KEY (`И`);

--
-- Индексы таблицы `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Индексы таблицы `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `positions_alias_unique` (`alias`);

--
-- Индексы таблицы `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `regions_country_id_foreign` (`country_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_company_id_foreign` (`company_id`),
  ADD KEY `reviews_position_id_foreign` (`position_id`),
  ADD KEY `reviews_employment_form_alias_foreign` (`employment_form_alias`),
  ADD KEY `reviews_stage_id_foreign` (`stage_id`),
  ADD KEY `reviews_city_id_foreign` (`city_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salaries_currency_code_foreign` (`currency_code`),
  ADD KEY `salaries_company_id_foreign` (`company_id`),
  ADD KEY `salaries_position_id_foreign` (`position_id`),
  ADD KEY `salaries_user_id_foreign` (`user_id`),
  ADD KEY `salaries_stage_id_foreign` (`stage_id`),
  ADD KEY `salaries_city_id_foreign` (`city_id`),
  ADD KEY `salaries_employment_form_alias_foreign` (`employment_form_alias`),
  ADD KEY `salaries_company_industry_id_foreign` (`company_industry_id`),
  ADD KEY `salaries_company_size_id_foreign` (`company_size_id`);

--
-- Индексы таблицы `salary_additional_payments`
--
ALTER TABLE `salary_additional_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_additional_payments_salary_id_foreign` (`salary_id`),
  ADD KEY `salary_additional_payments_type_id_foreign` (`type_id`);

--
-- Индексы таблицы `salary_additional_payments_types`
--
ALTER TABLE `salary_additional_payments_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `salary_additional_payments_types_title_unique` (`title`);

--
-- Индексы таблицы `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `skills_title_unique` (`title`);

--
-- Индексы таблицы `stages`
--
ALTER TABLE `stages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stages_title_unique` (`title`);

--
-- Индексы таблицы `taggables`
--
ALTER TABLE `taggables`
  ADD UNIQUE KEY `taggables_tag_id_taggable_id_taggable_type_unique` (`tag_id`,`taggable_id`,`taggable_type`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_title_unique` (`title`);

--
-- Индексы таблицы `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `universities_alias_unique` (`alias`),
  ADD UNIQUE KEY `universities_site_unique` (`site`),
  ADD UNIQUE KEY `universities_vk_id_unique` (`vk_id`),
  ADD KEY `universities_country_id_foreign` (`country_id`),
  ADD KEY `universities_city_id_foreign` (`city_id`),
  ADD KEY `universities_logo_id_foreign` (`logo_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Индексы таблицы `user_educations`
--
ALTER TABLE `user_educations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_educations_user_id_foreign` (`user_id`),
  ADD KEY `user_educations_university_id_foreign` (`university_id`),
  ADD KEY `user_educations_faculty_id_foreign` (`faculty_id`),
  ADD KEY `user_educations_chair_id_foreign` (`chair_id`),
  ADD KEY `user_educations_edu_form_id_foreign` (`edu_form_id`),
  ADD KEY `user_educations_status_id_foreign` (`status_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `ceo`
--
ALTER TABLE `ceo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `chairs`
--
ALTER TABLE `chairs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- AUTO_INCREMENT для таблицы `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `company_revenues`
--
ALTER TABLE `company_revenues`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `company_sizes`
--
ALTER TABLE `company_sizes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;
--
-- AUTO_INCREMENT для таблицы `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;
--
-- AUTO_INCREMENT для таблицы `education_forms`
--
ALTER TABLE `education_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `education_statuses`
--
ALTER TABLE `education_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT для таблицы `employment_forms`
--
ALTER TABLE `employment_forms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `faculties`
--
ALTER TABLE `faculties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT для таблицы `industries`
--
ALTER TABLE `industries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;
--
-- AUTO_INCREMENT для таблицы `interviews`
--
ALTER TABLE `interviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `interview_sources`
--
ALTER TABLE `interview_sources`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT для таблицы `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=528;
--
-- AUTO_INCREMENT для таблицы `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `salary_additional_payments`
--
ALTER TABLE `salary_additional_payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `salary_additional_payments_types`
--
ALTER TABLE `salary_additional_payments_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT для таблицы `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT для таблицы `stages`
--
ALTER TABLE `stages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT для таблицы `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `user_educations`
--
ALTER TABLE `user_educations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `ceo`
--
ALTER TABLE `ceo`
  ADD CONSTRAINT `ceo_avatar_id_foreign` FOREIGN KEY (`avatar_id`) REFERENCES `images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `ceo_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `chairs`
--
ALTER TABLE `chairs`
  ADD CONSTRAINT `chairs_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `cities_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_cover_id_foreign` FOREIGN KEY (`cover_id`) REFERENCES `images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_created_user_id_foreign` FOREIGN KEY (`created_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_hq_city_id_foreign` FOREIGN KEY (`hq_city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_logo_id_foreign` FOREIGN KEY (`logo_id`) REFERENCES `images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_revenue_id_foreign` FOREIGN KEY (`revenue_id`) REFERENCES `company_revenues` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_size_id_foreign` FOREIGN KEY (`size_id`) REFERENCES `company_sizes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `companies_updated_user_id_foreign` FOREIGN KEY (`updated_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `company_images`
--
ALTER TABLE `company_images`
  ADD CONSTRAINT `company_images_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `company_images_image_id_foreign` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `company_industries`
--
ALTER TABLE `company_industries`
  ADD CONSTRAINT `company_industries_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `company_industries_industry_id_foreign` FOREIGN KEY (`industry_id`) REFERENCES `industries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `faculties`
--
ALTER TABLE `faculties`
  ADD CONSTRAINT `faculties_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `interviews`
--
ALTER TABLE `interviews`
  ADD CONSTRAINT `interviews_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `interviews_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `interviews_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `interviews_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `interview_sources` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `interviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD CONSTRAINT `currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `employment_form_id_foreign` FOREIGN KEY (`employment_form_id`) REFERENCES `employment_forms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `stages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `jobs_cities`
--
ALTER TABLE `jobs_cities`
  ADD CONSTRAINT `jobs_cities_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jobs_cities_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `regions_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_employment_form_alias_foreign` FOREIGN KEY (`employment_form_alias`) REFERENCES `employment_forms` (`alias`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `stages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_company_industry_id_foreign` FOREIGN KEY (`company_industry_id`) REFERENCES `industries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_company_size_id_foreign` FOREIGN KEY (`company_size_id`) REFERENCES `company_sizes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_currency_code_foreign` FOREIGN KEY (`currency_code`) REFERENCES `currencies` (`code`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_employment_form_alias_foreign` FOREIGN KEY (`employment_form_alias`) REFERENCES `employment_forms` (`alias`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `stages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `salaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `salary_additional_payments`
--
ALTER TABLE `salary_additional_payments`
  ADD CONSTRAINT `salary_additional_payments_salary_id_foreign` FOREIGN KEY (`salary_id`) REFERENCES `salaries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salary_additional_payments_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `salary_additional_payments_types` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `taggables`
--
ALTER TABLE `taggables`
  ADD CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `universities`
--
ALTER TABLE `universities`
  ADD CONSTRAINT `universities_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `universities_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `universities_logo_id_foreign` FOREIGN KEY (`logo_id`) REFERENCES `images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_educations`
--
ALTER TABLE `user_educations`
  ADD CONSTRAINT `user_educations_chair_id_foreign` FOREIGN KEY (`chair_id`) REFERENCES `chairs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_educations_edu_form_id_foreign` FOREIGN KEY (`edu_form_id`) REFERENCES `education_forms` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_educations_faculty_id_foreign` FOREIGN KEY (`faculty_id`) REFERENCES `faculties` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_educations_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `education_statuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_educations_university_id_foreign` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `user_educations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
