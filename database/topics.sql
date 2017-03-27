-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 27, 2017 at 03:49 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `IMDterest`
--

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `topics`
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
