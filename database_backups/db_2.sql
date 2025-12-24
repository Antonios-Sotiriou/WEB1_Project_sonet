-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Dez 2025 um 16:28
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `web1_project_sonet`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admins`
--

CREATE TABLE `admins` (
  `user_id` int(11) NOT NULL,
  `date_joined` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `admins`
--

INSERT INTO `admins` (`user_id`, `date_joined`) VALUES
(20, '2025-12-01 23:17:18'),
(11, '2025-12-01 23:30:08');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE `comments` (
  `comm_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `comm_content` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `comments`
--

INSERT INTO `comments` (`comm_id`, `post_id`, `user_id`, `created_at`, `comm_content`) VALUES
(1, 27, 11, '2025-12-01 23:31:33', 'Oft unterschätzt und sträflich vernachlässigt: Blindtexte! Es muss nicht immer Lorem Ipsum sein. Warum nicht Goethe, Kafka oder ein Pangram? Hier eine Auswahl an Blindtexten und Editoren für Blindtexte.'),
(2, 29, 13, '2025-12-01 23:48:21', 'Sed ante.'),
(3, 25, 14, '2025-12-01 23:48:21', 'Aenean fermentum. Donec ut mauris eget massa tempor convallis.'),
(4, 28, 17, '2025-12-01 23:48:21', 'Etiam vel augue.'),
(5, 25, 15, '2025-12-01 23:48:21', 'Mauris lacinia sapien quis libero.'),
(6, 26, 15, '2025-12-01 23:48:21', 'Vivamus tortor. Duis mattis egestas metus.'),
(7, 29, 18, '2025-12-01 23:48:21', 'Cras in purus eu magna vulputate luctus.'),
(8, 27, 12, '2025-12-01 23:48:21', 'Phasellus id sapien in sapien iaculis congue.'),
(9, 29, 14, '2025-12-01 23:48:21', 'In sagittis dui vel nisl.'),
(10, 26, 15, '2025-12-01 23:48:21', 'Praesent blandit lacinia erat.'),
(11, 26, 16, '2025-12-01 23:48:21', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin interdum mauris non ligula pellentesque ultrices.'),
(12, 25, 14, '2025-12-01 23:48:21', 'Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.'),
(13, 27, 22, '2025-12-01 23:48:21', 'Suspendisse potenti.'),
(14, 25, 13, '2025-12-01 23:48:21', 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum.'),
(15, 26, 19, '2025-12-01 23:48:21', 'Donec semper sapien a libero.'),
(16, 29, 25, '2025-12-10 21:34:49', 'Der große Oxmox riet ihr davon ab, da es dort wimmele von bösen Kommata, wilden Fragezeichen und hinterhältigen Semikoli, doch das Blindtextchen ließ sich nicht beirren.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dislikes`
--

CREATE TABLE `dislikes` (
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `dislikes`
--

INSERT INTO `dislikes` (`user_id`, `post_id`) VALUES
(22, 25),
(11, 26),
(25, 29);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`) VALUES
(11, 25),
(21, 25),
(22, 26),
(12, 29),
(12, 26),
(12, 25),
(11, 27),
(25, 25);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `post_content` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`post_id`, `created_at`, `user_id`, `post_content`) VALUES
(25, '2025-11-28 08:46:16', 11, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.'),
(26, '2025-11-28 08:59:37', 21, 'Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte. Abgeschieden wohnen sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans.'),
(27, '2025-11-28 14:42:27', 22, 'Als es die ersten Hügel des Kursivgebirges erklommen hatte, warf es einen letzten Blick zurück auf die Skyline seiner Heimatstadt Buchstabhausen, die Headline von Alphabetdorf und die Subline seiner eigenen Straße, der Zeilengasse. Wehmütig lief ihm eine rhetorische Frage über die Wange, dann setzte es seinen Weg fort. '),
(28, '2025-11-28 23:04:55', NULL, 'Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte.'),
(29, '2025-11-28 23:10:58', 11, 'Tages aber beschloß eine kleine Zeile Blindtex!'),
(30, '2025-12-10 20:32:23', 25, 'Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte. Abgeschieden wohnen sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans. Ein kleines Bächlein namens Duden fließt durch ihren Ort und versorgt sie mit den nötigen Regelialien. Es ist ein paradiesmatisches Land, in dem einem gebratene Satzteile in den Mund fliegen. Nicht einmal von der allmächtigen Interpunktion werden die Blindtexte beherrscht – ein geradezu unorthographisches Leben.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `prof_images`
--

CREATE TABLE `prof_images` (
  `img_id` int(11) NOT NULL,
  `img_name` varchar(100) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `prof_images`
--

INSERT INTO `prof_images` (`img_id`, `img_name`, `user_id`) VALUES
(26, 'white_puppy.jpg', 21),
(27, 'man_with_clockeyes.jpg', 11),
(28, 'bear_on_the_beach.jpg', 22),
(29, 'holiday_house.jpg', 12),
(30, 'curious-boxer-dog.jpg', 25),
(32, 'Antonios_Sotiriou.jpg', 28);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_joined` date NOT NULL DEFAULT current_timestamp(),
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `date_joined`, `password`) VALUES
(10, 'Tester', 'Test', 'test@hotmail.com', '2025-11-22', '$2y$10$J1trP.fnHru/XHeXCcdFJ.UmX.BDDEA5LrnJtXipJW6OM6Z3pxsAa'),
(11, 'John', 'Doe', 'johndoe@gmail.com', '2025-11-28', '$2y$10$hmBlgpShkUGx1IwT6OjoN.PZSqiPIgLqhxR1VacyijHFNQD0p2leK'),
(12, 'Berkeley', 'Macon', 'bmacon@unicef.org', '2025-11-28', '$2y$10$vs5vXVtyhgf7gN.2L2LSpO5PCOfp/vUk0O4bejzxEzsfT4DYTBfaK'),
(13, 'Nedi', 'Rynes', 'nraynes1@etsy.com', '2025-11-28', '$2y$10$m6XaBGA4AL6WxItwoY8d6ebMwP.eDAJlu8W3SQCrBtLl.GujKY6x.'),
(14, 'Ambros', 'Wabey', 'awabey2@flickr.com', '2025-11-28', '$2y$10$8jmdMpvIlnU2dFkPJ6OMaed9NHsqbzJY9X.grHOAyEdHyi1t.gRla'),
(15, 'Boycey', 'Josef', 'bjozef3@chronoengine.com', '2025-11-28', '$2y$10$qxnZzkrR26XX3B.XuThmyuFgHf2Z6oNBeAj4UAd4R4SgcftSiIvGG'),
(16, 'Danielle', 'Flippelli', 'dflippelli4@alexa.com', '2025-11-28', '$2y$10$IelR/e.7oXoIQDFnF3Nmeust8LHTAQXsF0h5GqgJxbD/ctd14zjiW'),
(17, 'Hansiain', 'Meara', 'homeara5@bandcamp.com', '2025-11-28', '$2y$10$Fv.qWldG2CSZh8MF2YHy9ukB9rWwhH93mvWLqsvlBZQmTG0pw5qZe'),
(18, 'Antonietta', 'Gemeau', 'agemeau6@narod.ru', '2025-11-28', '$2y$10$QRgTTtkrFnXm0c0tA/v.r.C.kmDepeosjJKSGZpsi0ilhhPyFVqpK'),
(19, 'Fianna', 'Gocher', 'fgocher7@addtoany.com', '2025-11-28', '$2y$10$dok1r9M9lxQyR2nLV5UFi.AxRyH5YteZODBi6Cs9/TeYYgiRtzyh6'),
(20, 'Lucio', 'Healy', 'lhealy8@feedburner.com', '2025-11-28', '$2y$10$qb7vXnich4u5kjcuXiajrepTsKZHF0j8GdPw/zfPn9ZF5tiBt5ykS'),
(21, 'Seline', 'Burniston', 'sburniston9@yelp.com', '2025-11-28', '$2y$10$2axyluEqZmebmrX5AT1A5OlEAhLjdk.X8czSJp/Ln80y1Ntbi9qyC'),
(22, 'Michael', 'Salivan', 'michaelsal@hotmail.com', '2025-11-28', '$2y$10$DPmLFE6zdSu6Ti8btA/0A.RwnG2osmbLywiXSrVyp5CEkzD/bT2z2'),
(23, 'Donald', 'Duck', 'donaldduck@gmail.com', '2025-12-10', '$2y$10$SMT0OyclsBXyZ4OL4JNX0uj7CO3vLye5oUHj0eJKyD3SHKPPfSNmi'),
(24, 'Dagobert', 'Duck', 'dagobertduck@gmail.com', '2025-12-10', '$2y$10$mXVLw.YEG0zBpXpKef6ib.2BtNgC32qF5Odv7uPdKWEgwHcGe/dCG'),
(25, 'Huey', 'Duck', 'hueyduck@gmail.com', '2025-12-10', '$2y$10$0W0dA8heQhF00CMe5mPVDeuZoQByQs7A24t0e7AVLkXWznsD1krPC'),
(26, 'Dewey', 'Duck', 'deweyduck@gmail.com', '2025-12-10', '$2y$10$lSU5hez3buu1DPjEzZZhb.WuJcWbV11WVDLyxaUoDv7aIUCfnCkpS'),
(27, 'Louie', 'Duck', 'louieduck@gmail.com', '2025-12-10', '$2y$10$ONoH2xdjO8QM0QvEycp/AebAZaQ6oLK04iQkigRXi/FddvHbUJOpW'),
(28, 'Antonios', 'Sotiriou', 'as@hotmail.gr', '2025-12-10', '$2y$10$/E9JCxHEaqqtfa80vb6Q/eG1aUbPNCO3jG1pzaDzzsBIpVfD7jUtu');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `admins`
--
ALTER TABLE `admins`
  ADD KEY `fk_admin_user` (`user_id`);

--
-- Indizes für die Tabelle `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comm_id`),
  ADD KEY `fk_comment_post` (`post_id`),
  ADD KEY `fk_comment_user` (`user_id`);

--
-- Indizes für die Tabelle `dislikes`
--
ALTER TABLE `dislikes`
  ADD KEY `fk_dislike_post` (`post_id`),
  ADD KEY `fk_dislike_user` (`user_id`);

--
-- Indizes für die Tabelle `likes`
--
ALTER TABLE `likes`
  ADD KEY `fk_like_post` (`post_id`),
  ADD KEY `fk_like_user` (`user_id`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `prof_images`
--
ALTER TABLE `prof_images`
  ADD PRIMARY KEY (`img_id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `comments`
--
ALTER TABLE `comments`
  MODIFY `comm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT für Tabelle `prof_images`
--
ALTER TABLE `prof_images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `fk_admin_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `fk_dislike_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dislike_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints der Tabelle `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `fk_like_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_like_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints der Tabelle `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints der Tabelle `prof_images`
--
ALTER TABLE `prof_images`
  ADD CONSTRAINT `fk_prof_img_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
