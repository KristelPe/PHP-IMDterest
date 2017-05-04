-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 30 apr 2017 om 17:28
-- Serverversie: 10.1.21-MariaDB
-- PHP-versie: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imdterest`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `boards`
--

CREATE TABLE `boards` (
  `id` int(11) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `boards`
--

INSERT INTO `boards` (`id`, `userid`, `title`, `state`) VALUES
(6, 8, 'Animations', 'public'),
(7, 27, 'banaan', 'public'),
(8, 27, 'test', 'public');

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

--
-- Gegevens worden geëxporteerd voor tabel `comments`
--

INSERT INTO `comments` (`Id`, `comment`, `postId`, `userId`) VALUES
(2, 'test', 59, 8),
(3, 'mooi', 59, 29),
(4, 'test', 59, 29),
(5, 'yea', 59, 29),
(6, 'tetssss', 59, 29),
(7, 'tes', 59, 29),
(8, 'yo Lisa', 59, 8),
(9, 'test', 59, 30),
(10, 'test', 59, 8),
(11, 'dammit robbe', 59, 8),
(12, 'hm', 61, 8),
(13, 'yolo', 59, 27),
(14, 'sub-yolo', 59, 27),
(15, 'rawr xd', 59, 27),
(16, 'huh', 59, 27),
(17, 'waaa', 59, 27);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `following`
--

CREATE TABLE `following` (
  `id` int(11) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `followerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `likes`
--

CREATE TABLE `likes` (
  `id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `posts`
--

INSERT INTO `posts` (`id`, `userId`, `title`, `image`, `description`, `link`, `board`, `date`) VALUES
(59, 8, 'Boomerang', 'uploads/_boomerang_klein.png', 'Just a boomerang', '', 6, '0000-00-00 00:00:00');

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
(9, 59, 27),
(10, 59, 29),
(11, 59, 32);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `selectedtopics`
--
DROP TABLE IF EXISTS `selectedtopics`;

CREATE TABLE `selectedTopic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `selectedtopics`
--

INSERT INTO `selectedTopics` (`id`, `userId`, `topicId`) VALUES
(16, 29, 3),
(17, 29, 5),
(18, 29, 10),
(19, 32, 3);

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

--
-- Gegevens worden geëxporteerd voor tabel `sub_comments`
--

INSERT INTO `sub_comments` (`Id`, `comment`, `userId`, `commentId`) VALUES
(1, 'inderdaad', 27, 16),
(2, 'inderdaad', 27, 8);

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
(8, 'michiel.janssens@thomasmore.be', 'Michiel', 'Janssens', 'uploads/12107171_891937250861060_7517874411059298940_n.jpg', '$2y$12$0OcHyq.HtP9tGlbr21Q6sOp8O2mq1CNPNW5MIdULRcWtcaWGvGIb.', 'Mijans'),
(27, 'bram.janssens@thomasmore.be', 'Bram', 'Janssens', '', '$2y$12$Sbui4M8gTQ/qZcCjIl7FWOfcB9jz2u1WvS23lx0tYQL8Qhx4/tbRG', 'Synrise'),
(28, 'heidi.decat@thomasmore.be', 'Heidi', 'Decat', '', '$2y$12$yfqlBZUGIdLsAwyoTwfAMeK7sVEVtoCbpWGJPYdDHgSo1LjCU4Ige', 'Hecat'),
(29, 'Bart.janssens@thomasmore.be', 'Bart', 'Janssens', 'uploads/11951157_912688378798056_8366126992169365022_n.jpg', '$2y$12$OcLhaG21bSCCilKGsIwy4.XSrpA7YSHuS/G7eZLjB6nedIJLecDNO', 'Bartjans'),
(30, 'testydebesty@gmail.com', 'test', 'mactest', 'images/default.png', '$2y$12$oBGYDqZvxEgAOIRxH69YHOHTz5DwyyHXeIZG6n3vvSAQjPTyvJgDq', 'testerbot'),
(31, 'bart.janssens@thomasmore.be', 'Bart', 'Janssens', 'images/default.png', '$2y$12$3C4fSErGgFYVwwZD3RztBOe.sxTHu4H4u/90HTKfVdLTdaMowLrDm', 'Bartho'),
(32, 'bart.decat@thomasmore.be', 'Bart', 'Decat', 'images/default.png', '$2y$12$hzwmT4l4RYrTgKVW1NKJvuZCWPstpD/V8bb1yTR/xTnhxI.m8psjC', 'Bartheyyy');

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT voor een tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT voor een tabel `reported`
--
ALTER TABLE `reported`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT voor een tabel `selectedtopics`
--
ALTER TABLE `selectedtopics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
