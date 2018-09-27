-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2017 at 11:26 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmno`
--

-- --------------------------------------------------------

--
-- Table structure for table `uczestnicy`
--

CREATE TABLE `uczestnicy` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `pass` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `imie` text COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` text COLLATE utf8_polish_ci NOT NULL,
  `miasto` text COLLATE utf8_polish_ci NOT NULL,
  `druzyna` text COLLATE utf8_polish_ci NOT NULL,
  `oplata` text COLLATE utf8_polish_ci NOT NULL,
  `level` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `uczestnicy`
--

INSERT INTO `uczestnicy` (`id`, `login`, `pass`, `email`, `imie`, `nazwisko`, `miasto`, `druzyna`, `oplata`, `level`) VALUES
(1, 'Admin', '$2y$10$ADJgvVYN2HZN0jkz0HWHYefB.Cw2GcNLBjKLRB1AqH1vRLvUU/Nj6', 'admin@pmno.pl', 'Bogdan', 'Kowalski', 'GdaÅ„sk', 'Brak', '', 'admin'),
(2, 'Piesek', '$2y$10$/LlFouneunMjy4Q110Is8OGHl2G13OO0u.bvJgadKILcqeo17yei6', 'pies@gmail.com', 'Marcin', 'Pieskowski', 'GdaÅ„sk', 'PieseÅ‚y', '', 'member'),
(3, 'Ela', '$2y$10$xo3CYtMQwpmCehcGKmtrLeWRrIhESupIzURp.hvpfw.7MSTX7pykS', 'puchacz@puchacz.pl', 'Ela', 'Kartofela', 'Miechowo', 'Puchate policzki Eli', '', 'member'),
(4, 'GrzeÅ›', '$2y$10$iuiN5Ts0/qxnScIUyCWFBOzUcHzwOJmIfbr8qLVnRZaMCOUHK4XyK', 'aaa@bbb.pl', 'Grzegorz', 'Fija', 'TarnÃ³w', 'brak', 'tak', 'admin'),
(5, 'Biegacz', '$2y$10$S2JqA/h2v2RyO.W6qLq8I.FvLPh4lIphciW.WsviXw4J7JMLSXNmy', 'biegacz@gmail.com', 'Bartek', 'Patyk', 'WÅ‚odawa', 'PÄ™dzÄ…ce Å»Ã³Å‚wie', '', 'member'),
(6, 'Sensei', '$2y$10$znIqOC3Hy5DVs9sCnF1rX.N.6JY1p9SUpY7CEZzFnoCikrejz8DhO', 'rajdowiec@gmail.com', 'PaweÅ‚', 'Kogut', 'Szczecinek', 'BRAK DANYCH', '', 'admin'),
(7, 'Kokosza', '$2y$10$ruEdJR535i/y7BzeLFx7CO.CUFGjjTw7hub143dvpNw7Ir310P/Mm', 'kokosza@gmail.com', 'Marian', 'Pasibrzuch', 'GodÄ™towo', 'brak', '', 'member'),
(8, 'BaÅ¼ancik77', '$2y$10$BbqNpgoNOeAUPjHQbggjTutZCaL3x.jcR80J4m2uOBBdT./RE6qEu', 'bazancik77@gmail.com', 'Weronika', 'Zalewska', 'Warszawa', 'Byle do przodu', '', 'member'),
(11, 'elaela', '$2y$10$UYeiWILFjMeQwEztrV2m/eRYU4Ony1.ha4bGsiT6CKOciT0YTMq5K', 'kartofel@kartofel.pl', 'puchacz', 'puchacz', 'Å›wieradÃ³w', 'wieprzowiny', '', 'member'),
(12, 'Korniszon', '$2y$10$S773IrELpMaMk54asefaNe/iTkG3uSnpA6kYReW3pelxOUUp4IefC', 'ogor@wp.pl', 'Marta', 'Banaczek', 'GodÄ™towo', 'GDAKK', '', 'member');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `uczestnicy`
--
ALTER TABLE `uczestnicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `uczestnicy`
--
ALTER TABLE `uczestnicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
