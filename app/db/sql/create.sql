SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `kalani`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--
CREATE DATABASE IF NOT EXISTS `kalani`;

USE `kalani`;


CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(45) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `joinDate` DATETIME DEFAULT CURRENT_TIMESTAMP, 
  `rank` varchar(4) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `code` varchar(45) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `anime` (
  `idUser` INT,
  `idAnime` INT,
  `currentDate` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `releaseDate` DATETIME,
  `latestEpisode` INT,
  `airingDate` DATETIME,
  PRIMARY KEY (`idUser`, `idAnime`),
  FOREIGN KEY (`idUser`) REFERENCES `user`(`idUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

