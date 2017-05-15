-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 15 mei 2017 om 23:57
-- Serverversie: 5.6.35-log
-- PHP-versie: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `robber1q_imdterest`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `boards`
--

CREATE TABLE `boards` (
  `id` int(11) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `image` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `boards`
--

INSERT INTO `boards` (`id`, `userid`, `title`, `state`, `image`) VALUES
(25, 38, 'tes', 'public', 'uploads/2zr2qg8.jpg'),
(26, 39, 'designs', 'public', 'uploads/virtusSolo.png'),
(29, 66, 'test', 'public', 'uploads/2zr2qg8.jpg'),
(34, 40, 'Datsun 240z', 'private', 'uploads/4876a27d80479d313af5f6faff0521c2.jpg'),
(36, 40, 'DummyD', 'public', 'uploads/17634622_1230679830362902_3522679240513832631_n.jpg'),
(37, 67, 'Designs', 'public', 'uploads/virtusSolo.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE `comments` (
  `Id` int(11) NOT NULL,
  `comment` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `following`
--

CREATE TABLE `following` (
  `id` int(11) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `followerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `following`
--

INSERT INTO `following` (`id`, `userid`, `followerid`) VALUES
(0, 41, 38),
(0, 41, 39);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `likes`
--

CREATE TABLE `likes` (
  `id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `user_id`) VALUES
(65, 120, 41),
(66, 120, 39),
(67, 121, 39),
(68, 125, 66),
(69, 124, 66),
(70, 123, 66),
(71, 120, 66),
(72, 126, 67),
(73, 125, 67),
(74, 124, 67),
(75, 123, 67),
(76, 120, 67),
(77, 127, 67),
(78, 128, 67),
(79, 129, 67);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `userId` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `board` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `location` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `topic` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `posts`
--

INSERT INTO `posts` (`id`, `userId`, `title`, `image`, `description`, `link`, `board`, `date`, `location`, `topic`) VALUES
(120, 41, 'Zenyatta', 'uploads/nutcracker-zenyatta-winter_wonderland-(9029).jpg', 'This webpage does not exist!', '', 24, '2017-05-15 21:09:47', '', 1),
(121, 39, 'Mickey', 'uploads/mickey.png', 'This is my mickey mouse', '', 26, '2017-05-15 21:10:23', 'Grimbergen, BelgiÃ«', 14),
(122, 38, 'Reportme', '', 'Stack Overflow is the largest online community for programmers to learn, share their knowledge, and advance their careers', 'https://stackoverflow.com', 25, '2017-05-15 21:15:35', 'Leuven, BelgiÃ«', 11),
(123, 40, 'MIYA', 'uploads/539eb2a5d67100f5f2db7a214a67bfd2.jpg', 'Japanese themed logo', '', 27, '2017-05-15 21:18:49', 'Mechelen Fortuinstraat, 2800 Mechelen, Belgium', 1),
(124, 66, 'test', 'uploads/2zr2qg8.jpg', 'test', '', 29, '2017-05-15 21:31:29', 'Leuven, BelgiÃ«', 1),
(125, 66, 'private', 'uploads/438bd86283e3eb812735ceedb7f40e52.jpg', 'test', '', 32, '2017-05-15 21:32:32', 'Leuven, BelgiÃ«', 12),
(126, 40, 'C', 'uploads/4daad2c965640bcef767f3a665bafb71.jpg', 'Creative flower typo', '', 30, '2017-05-15 21:34:27', 'Mechelen Fortuinstraat, 2800 Mechelen, Belgium', 2),
(127, 40, 'FuzuZ', 'uploads/69fd0f1a1f47a89b8ff181126fe52449.jpg', 'Datsun 240z 1973 - FF', '', 34, '2017-05-15 21:43:26', 'Mechelen Fortuinstraat, 2800 Mechelen, Belgium', 14),
(128, 67, 'Mickey', 'uploads/mickey.png', 'This is my mickey mouse!', '', 37, '2017-05-15 21:46:13', 'Grimbergen, BelgiÃ«', 14),
(129, 67, 'Virtus', 'uploads/virtus.png', 'My logo from 2016', '', 37, '2017-05-15 21:49:21', 'Grimbergen, BelgiÃ«', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reported`
--

CREATE TABLE `reported` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reported`
--

INSERT INTO `reported` (`id`, `postId`, `userId`) VALUES
(13, 123, 67),
(14, 120, 67);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `selectedtopics`
--

CREATE TABLE `selectedtopics` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `topicId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `selectedtopics`
--

INSERT INTO `selectedtopics` (`id`, `userId`, `topicId`) VALUES
(35, 38, 1),
(36, 38, 2),
(37, 38, 3),
(38, 38, 6),
(39, 38, 7),
(40, 39, 3),
(41, 39, 5),
(42, 39, 8),
(43, 39, 9),
(44, 39, 13),
(45, 40, 10),
(46, 40, 11),
(47, 40, 12),
(48, 40, 13),
(49, 40, 14),
(50, 41, 1),
(51, 41, 3),
(52, 41, 5),
(53, 41, 7),
(54, 41, 8),
(55, 42, 2),
(56, 42, 3),
(57, 42, 5),
(58, 42, 7),
(59, 42, 8),
(60, 43, 2),
(61, 43, 3),
(62, 43, 5),
(63, 43, 8),
(64, 43, 9),
(65, 63, 1),
(66, 63, 2),
(67, 63, 3),
(68, 63, 6),
(69, 63, 7),
(70, 64, 1),
(71, 64, 3),
(72, 64, 5),
(73, 64, 6),
(74, 64, 9),
(75, 66, 1),
(76, 66, 2),
(77, 66, 3),
(78, 66, 6),
(79, 66, 7),
(80, 67, 1),
(81, 67, 2),
(82, 67, 3),
(83, 67, 5),
(84, 67, 6),
(85, 67, 7),
(86, 67, 8),
(87, 66, 11),
(88, 66, 5),
(89, 66, 8);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `sub_comments`
--

CREATE TABLE `sub_comments` (
  `Id` int(11) NOT NULL,
  `comment` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(11) NOT NULL,
  `commentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `topics`
--

CREATE TABLE `topics` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `topics`
--

INSERT INTO `topics` (`id`, `title`, `img`) VALUES
(1, 'Logo', 'http://payload449.cargocollective.com/1/2/86969/11297497/marssaie-logo-cover_900.jpg'),
(2, 'Typography', 'http://68.media.tumblr.com/3b66cb0bd12225ae9291d9122948bf07/tumblr_mvdq42wYfE1ryq9ado1_500.jpg'),
(3, 'Motion Design', 'https://s-media-cache-ak0.pinimg.com/originals/03/b4/e3/03b4e3d296dda7ccc5078382017da3cd.gif'),
(5, 'Infographic', 'https://s-media-cache-ak0.pinimg.com/564x/5a/d3/48/5ad348d433dc21fd11f2e09cfc78ed32.jpg'),
(6, 'Portfolio website', 'https://s-media-cache-ak0.pinimg.com/564x/1c/1a/75/1c1a758bd8a7ac19a6f9a5b7a9ab02d2.jpg'),
(7, 'Web design', 'https://s-media-cache-ak0.pinimg.com/564x/79/b9/b1/79b9b1558837e48ab4f86736261e06ac.jpg'),
(8, 'Animation', 'https://theultralinx.com/.image/c_fit%2Ccs_srgb%2Cw_960/MTI5MDI2NDc4ODc1OTMwNTk0/sweet-crude-logo-animated.gif'),
(9, 'Drupal theming', 'https://s-media-cache-ak0.pinimg.com/236x/53/75/c2/5375c2b636b3da7896ac4b79e4aaa599.jpg'),
(10, 'Code', 'https://images.pexels.com/photos/92904/pexels-photo-92904.jpeg?w=940&h=650&auto=compress&cs=tinysrgb'),
(11, 'Negative space', 'https://s-media-cache-ak0.pinimg.com/236x/e5/fc/7e/e5fc7ed1417ba8acb1b44083402ec33c.jpg'),
(12, 'Sketching', 'https://s-media-cache-ak0.pinimg.com/236x/7c/7d/98/7c7d9854798c2fb3e3bc28921c5cacdc.jpg'),
(13, 'Film', 'http://static3.businessinsider.com/image/5769a312dd08958e578b465b-/badscenes.gif'),
(14, 'Design', 'https://s-media-cache-ak0.pinimg.com/564x/2d/e4/6b/2de46b3055a0194d3d2e47508923f81d.jpg'),
(15, 'Photography', 'https://s-media-cache-ak0.pinimg.com/564x/70/19/b2/7019b28dbaa5cb2e866f4cb438faee46.jpg'),
(16, 'Project', 'http://www.dimensionx.be/gfx/news/kvm/kvm.gif');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `email`, `firstname`, `lastname`, `image`, `password`, `username`) VALUES
(40, 'kristel_pire@hotmail.com', 'Kristel', 'Pire', 'uploads/15631556_1475874482443759_2074091126_o copy.jpg', '$2y$12$j3jEhzNh0wyARZdcZB56l.gt3PP/UFDgVuusyfc6J80MgJcd7dROS', 'kristel'),
(41, 'michiel.janssens@thomasmore.be', 'Michiel', 'Janssens', 'uploads/tengu.jpg', '$2y$12$a/9Yh48/QNBdvk1fKC96vuQ9K8ktHp9mUsg9Ly2tb84Iwq9X/kgAe', 'Mijans'),
(66, 'robbereygel97@gmail.com', 'Robbe', 'Reygel', 'uploads/chick.png', '$2y$12$7IKquKXIzTTsSIubY8D1uue8WMO0zI/JBlCxCWa6/hEb8/hyMmFuy', 'Robbe'),
(67, 'soren.wagemans@hotmail.com', 'SÃ¶ren', 'Wagemans', 'uploads/ik.jpg', '$2y$12$JC6ADi9uouoNnfAcT8thV.q6ouNlvm5G1o4q5/QiUBxvg91PKev/a', 'SÃ¶ren W');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexen voor tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `reported`
--
ALTER TABLE `reported`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `selectedtopics`
--
ALTER TABLE `selectedtopics`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `sub_comments`
--
ALTER TABLE `sub_comments`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT voor een tabel `reported`
--
ALTER TABLE `reported`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT voor een tabel `selectedtopics`
--
ALTER TABLE `selectedtopics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT voor een tabel `sub_comments`
--
ALTER TABLE `sub_comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
