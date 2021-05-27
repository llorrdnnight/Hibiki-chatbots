-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 29 apr 2021 om 13:40
-- Serverversie: 10.4.16-MariaDB
-- PHP-versie: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chatbot`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `chat`
--

CREATE TABLE `chat` (
  `Random_num` varchar(11) NOT NULL,
  `Awnser_Responce` char(1) NOT NULL,
  `text` varchar(255) NOT NULL,
  `Sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `chat`
--

INSERT INTO `chat` (`Random_num`, `Awnser_Responce`, `text`, `Sequence`) VALUES
('rdJQa', 'A', 'hi', 1),
('rdJQa', 'R', 'Hi there, how can I help?', 2),
('rdJQa', 'A', '\nhello', 3),
('rdJQa', 'R', 'Hello!', 4),
('rdJQa', 'A', 'gg', 5),
('rdJQa', 'R', 'Good to see you again!', 6),
('rdJQa', 'A', '\ng', 7),
('rdJQa', 'R', 'Hi there, how can I help?', 8),
('rdJQa', 'A', '\ng', 9),
('rdJQa', 'R', 'Hi there, how can I help?', 10),
('rdJQa', 'A', '\ng', 11),
('rdJQa', 'R', 'Hi there, how can I help?', 12),
('rdJQa', 'A', '\ng', 13),
('rdJQa', 'R', 'Hi there, how can I help?', 14),
('rdJQa', 'A', '\ng', 15),
('rdJQa', 'R', 'Good to see you again!', 16),
('rdJQa', 'A', '\ng', 17),
('rdJQa', 'R', 'Hello!', 18),
('rdJQa', 'A', '\ng', 19),
('rdJQa', 'R', 'Hi there, how can I help?', 20),
('rdJQa', 'A', '\ng', 21),
('rdJQa', 'R', 'Hello!', 22),
('rdJQa', 'A', '\ng', 23),
('rdJQa', 'R', 'Hi there, how can I help?', 24),
('rdJQa', 'A', '\ng', 25),
('rdJQa', 'R', 'Hi there, how can I help?', 26),
('rdJQa', 'A', 'ffjf', 27),
('rdJQa', 'R', 'Hi there, how can I help?', 28),
('FfQlR', 'A', 'hello', 1),
('FfQlR', 'R', 'Hello!', 2),
('FfQlR', 'A', '\ndf', 3),
('FfQlR', 'R', 'Hi there, how can I help?', 4),
('FfQlR', 'A', '\n', 5),
('FfQlR', 'R', 'Good to see you again!', 6),
('5SVFz', 'A', '\njdjakzdazdaz', 1),
('5SVFz', 'R', 'Hi there, how can I help?', 2),
('5SVFz', 'A', '\nfsdfsdfs', 3),
('5SVFz', 'R', 'Hello!', 4);

--
-- Triggers `chat`
--
DELIMITER $$
CREATE TRIGGER `delete old chat` AFTER UPDATE ON `chat` FOR EACH ROW DELETE FROM chat
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `chatbot`
--

CREATE TABLE `chatbot` (
  `Chat_ID` int(11) NOT NULL,
  `Random_nummer` varchar(8) NOT NULL,
  `AI_ON_OFF` char(3) NOT NULL DEFAULT 'ON',
  `Date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `chatbot`
--

INSERT INTO `chatbot` (`Chat_ID`, `Random_nummer`, `AI_ON_OFF`, `Date`) VALUES
(44, 'FG2yu', 'ON', '2021-04-28'),
(45, 'rdJQa', 'OFF', '2021-04-28'),
(46, 'FfQlR', 'ON', '2021-04-28'),
(47, '5SVFz', 'ON', '2021-04-28');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`Chat_ID`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `Chat_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
