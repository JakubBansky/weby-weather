-- phpMyAdmin SQL Dump
-- version 5.2.1deb1+jammy2
-- https://www.phpmyadmin.net/
--
-- Hostiteľ: localhost:3306
-- Čas generovania: St 24.Apr 2024, 15:35
-- Verzia serveru: 8.0.36-0ubuntu0.22.04.1
-- Verzia PHP: 8.3.3-1+ubuntu22.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáza: `countries`
--

-- --------------------------------------------------------

--
-- Štruktúra tabuľky pre tabuľku `countries`
--

CREATE TABLE `countries` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `state` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `number` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Sťahujem dáta pre tabuľku `countries`
--

INSERT INTO `countries` (`id`, `name`, `state`, `number`) VALUES
(8, 'Nitra', 'Slovakia', 50),
(9, 'Bratislava', 'Slovakia', 1),
(10, 'Prievidza', 'Slovakia', 1),
(11, 'Budca', 'Slovakia', 3),
(12, 'Praha', 'Czech Republic', 4),
(13, 'Brno', 'Czech Republic', 2),
(14, 'Lodz', 'Poland', 2),
(16, 'surany', 'Slovakia', 1),
(17, 'Garachico', 'Mexico', 1),
(18, 'vienna', 'Austria', 4),
(19, 'Nove zamky', 'Slovakia', 2);

--
-- Kľúče pre exportované tabuľky
--

--
-- Indexy pre tabuľku `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pre exportované tabuľky
--

--
-- AUTO_INCREMENT pre tabuľku `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
