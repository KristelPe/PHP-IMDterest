-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 apr 2017 om 17:08
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
-- Table structure for table `boards`
--

CREATE TABLE `boards` (
  `id` int(11) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `state` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


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
-- Tabelstructuur voor tabel `likes`
--

CREATE TABLE `likes` (
  `id` int(11) UNSIGNED NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `following`
--

CREATE TABLE `following` (
  `id` int(11) UNSIGNED NOT NULL,
  `userid` int(11) NOT NULL,
  `followerid` int(11) NOT NULL
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
  `link` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reported`
--

CREATE TABLE `reported` (
  `id` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` int(11) NOT NULL
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
(8, 'michiel.janssens@thomasmore.be', 'Michiel', 'Janssens', 'uploads/14717310_1468519219830827_5985986830015570317_n.jpg', '$2y$12$0OcHyq.HtP9tGlbr21Q6sOp8O2mq1CNPNW5MIdULRcWtcaWGvGIb.', 'Mijans'),
(9, 'test@test.be', 'test', 'test', 'uploads/438bd86283e3eb812735ceedb7f40e52.jpg', '$2y$12$jZ5e.AEW455Xew3D3t.3xesP1/mRI9gndt5jjvWeTr3jngwjj7K/W', 'test');

--
-- Indexen voor geëxporteerde tabellen
--

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
-- AUTO_INCREMENT voor een tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT voor een tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT voor een tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT voor een tabel `reported`
--
ALTER TABLE `reported`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
