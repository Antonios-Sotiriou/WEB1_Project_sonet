-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Okt 2025 um 00:26
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
(1, '2025-10-09 21:37:20');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `comments`
--

CREATE TABLE `comments` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comm_content` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `dislikes`
--

CREATE TABLE `dislikes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `dislikes`
--

INSERT INTO `dislikes` (`user_id`, `post_id`) VALUES
(1, 14);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`) VALUES
(2, 2),
(1, 6),
(1, 7),
(1, 8),
(1, 11),
(1, 12),
(1, 13),
(1, 3),
(1, 5),
(2, 16),
(1, 17),
(4, 17);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL,
  `post_content` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `posts`
--

INSERT INTO `posts` (`post_id`, `created_at`, `user_id`, `post_content`) VALUES
(1, '2025-09-25 02:34:43', 1, ''),
(2, '2025-09-25 02:35:27', 1, ''),
(3, '2025-09-25 02:45:00', 1, ''),
(4, '2025-09-25 02:45:52', 1, ''),
(5, '2025-09-25 02:48:22', 1, ''),
(6, '2025-09-25 02:49:10', 1, 'Antonios Sotiriou!'),
(7, '2025-09-25 20:22:27', 1, 'akcmac cmoamcoka acmokmckoam acmcmao acmacmakc acmakcmkacm acmcmkcm'),
(8, '2025-09-25 23:32:07', 1, ''),
(11, '2025-09-30 10:01:46', 1, 'Test Post!'),
(12, '2025-09-30 10:02:07', 1, 'Another Test Post!'),
(13, '2025-09-30 14:16:31', 1, 'Hello how are you?'),
(14, '2025-10-03 07:44:29', 1, 'A new Post for testing.'),
(15, '2025-10-03 11:58:55', 2, 'Another post from Mario.'),
(16, '2025-10-03 12:30:59', 2, 'A third Post from Mario.'),
(17, '2025-10-09 21:19:21', 2, 'A forth post from mario to test.');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `prof_images`
--

CREATE TABLE `prof_images` (
  `img_id` int(11) NOT NULL,
  `img_name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `prof_images`
--

INSERT INTO `prof_images` (`img_id`, `img_name`, `user_id`) VALUES
(20, 'stones64x64.bmp', 1),
(23, 'sun.bmp', 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'john', 'Doe', 'johndoe@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(2, 'Mario', 'Donato', 'mariodonato@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(3, 'Alice', 'Wonderland', 'alice@hotmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(4, 'Robert', 'Dawson', 'robdawson@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`user_id`);

--
-- Indizes für die Tabelle `comments`
--
ALTER TABLE `comments`
  ADD KEY `cpkey` (`post_id`),
  ADD KEY `cukey` (`user_id`);

--
-- Indizes für die Tabelle `dislikes`
--
ALTER TABLE `dislikes`
  ADD KEY `dukey` (`user_id`),
  ADD KEY `lukey` (`post_id`);

--
-- Indizes für die Tabelle `likes`
--
ALTER TABLE `likes`
  ADD KEY `luskey` (`user_id`),
  ADD KEY `lpokey` (`post_id`);

--
-- Indizes für die Tabelle `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `pukey` (`user_id`);

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
-- AUTO_INCREMENT für Tabelle `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `prof_images`
--
ALTER TABLE `prof_images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `aukey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `cpkey` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cukey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `dislikes`
--
ALTER TABLE `dislikes`
  ADD CONSTRAINT `dukey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lukey` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `lpokey` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `luskey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `pukey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `prof_images`
--
ALTER TABLE `prof_images`
  ADD CONSTRAINT `iukey` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
