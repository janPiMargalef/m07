-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Temps de generació: 05-05-2023 a les 12:46:53
-- Versió del servidor: 10.4.24-MariaDB
-- Versió de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dades: `proves_projecte`
--

-- --------------------------------------------------------

--
-- Estructura de la taula `equips`
--

CREATE TABLE `equips` (
  `id_equip` int(11) NOT NULL,
  `nom_equip` varchar(15) DEFAULT NULL,
  `nom_curt` varchar(15) NOT NULL,
  `contrasenya_equip` varchar(15) NOT NULL,
  `descripcio` varchar(50) NOT NULL,
  `imatge` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Bolcament de dades per a la taula `equips`
--

INSERT INTO `equips` (`id_equip`, `nom_equip`, `nom_curt`, `contrasenya_equip`, `descripcio`, `imatge`) VALUES
(7, 'Alpha', 'Equipo Alpha', 'a', 'Equipo de desarrollo Alpha', NULL),
(8, 'Bravo', 'Equipo Bravo', 'bravo123', 'Equipo de diseño Bravo', NULL),
(9, 'Charlie', 'Equipo Charlie', 'charlie123', 'Equipo de marketing Charlie', NULL),
(10, 'Delta', 'Equipo Delta', 'delta123', 'Equipo de soporte Delta', NULL),
(11, 'Echo', 'Equipo Echo', 'echo123', 'Equipo de ventas Echo', NULL);

-- --------------------------------------------------------

--
-- Estructura de la taula `ofertes`
--

CREATE TABLE `ofertes` (
  `id_oferta` int(11) NOT NULL,
  `dia` date DEFAULT NULL,
  `hora` time(6) DEFAULT NULL,
  `mapa` varchar(15) DEFAULT NULL,
  `nom_equip` varchar(15) DEFAULT NULL,
  `imatge_equip` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Bolcament de dades per a la taula `ofertes`
--

INSERT INTO `ofertes` (`id_oferta`, `dia`, `hora`, `mapa`, `nom_equip`, `imatge_equip`) VALUES
(29, '2023-06-10', '15:00:00.000000', 'Mapa1', 'Alpha', NULL),
(30, '2023-06-11', '17:30:00.000000', 'Mapa2', 'Bravo', NULL),
(31, '2023-06-12', '20:00:00.000000', 'Mapa3', 'Charlie', NULL),
(32, '2023-06-13', '18:15:00.000000', 'Mapa4', 'Delta', NULL),
(33, '2023-06-14', '16:45:00.000000', 'Mapa5', 'Echo', NULL);

-- --------------------------------------------------------

--
-- Estructura de la taula `partides_trobades`
--

CREATE TABLE `partides_trobades` (
  `id_partida` int(11) NOT NULL,
  `mapa` varchar(15) DEFAULT NULL,
  `dia_p` date DEFAULT NULL,
  `hora_p` time(6) DEFAULT NULL,
  `id_oferta` int(11) DEFAULT NULL,
  `nom_equip_acceptat` varchar(15) NOT NULL,
  `nom_equip_accepta` varchar(15) NOT NULL,
  `imatge_p` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Bolcament de dades per a la taula `partides_trobades`
--

INSERT INTO `partides_trobades` (`id_partida`, `mapa`, `dia_p`, `hora_p`, `id_oferta`, `nom_equip_acceptat`, `nom_equip_accepta`, `imatge_p`) VALUES
(22, 'Mapa1', '2023-06-10', '15:00:00.000000', 1, 'Alpha', 'Bravo', NULL),
(23, 'Mapa2', '2023-06-11', '17:30:00.000000', 2, 'Bravo', 'Charlie', NULL),
(24, 'Mapa3', '2023-06-12', '20:00:00.000000', 3, 'Charlie', 'Delta', NULL),
(25, 'Mapa4', '2023-06-13', '18:15:00.000000', 4, 'Delta', 'Echo', NULL),
(26, 'Mapa5', '2023-06-14', '16:45:00.000000', 5, 'Echo', 'Alpha', NULL),
(27, 'Mapa2', '2023-06-11', '17:30:00.000000', 30, 'Bravo', 'Alpha', NULL);

-- --------------------------------------------------------

--
-- Estructura de la taula `usuaris`
--

CREATE TABLE `usuaris` (
  `id_usuari` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `usuari` varchar(15) NOT NULL,
  `contrasenya` varchar(100) DEFAULT NULL,
  `nom_equip` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Bolcament de dades per a la taula `usuaris`
--

INSERT INTO `usuaris` (`id_usuari`, `email`, `usuari`, `contrasenya`, `nom_equip`) VALUES
(43, 'juan.perez@email.com', 'juanp', 'juanp123', 'Alpha'),
(44, 'maria.garcia@email.com', 'mariag', 'mariag123', 'Bravo'),
(45, 'carlos.gonzalez@email.com', 'carlosg', 'carlosg123', 'Charlie'),
(46, 'sofia.rodriguez@email.com', 'sofiar', 'sofiar123', 'Delta'),
(47, 'lucas.martinez@email.com', 'lucasm', 'lucasm123', 'Echo');

--
-- Índexs per a les taules bolcades
--

--
-- Índexs per a la taula `equips`
--
ALTER TABLE `equips`
  ADD PRIMARY KEY (`id_equip`),
  ADD UNIQUE KEY `nom_equip` (`nom_equip`);

--
-- Índexs per a la taula `ofertes`
--
ALTER TABLE `ofertes`
  ADD PRIMARY KEY (`id_oferta`),
  ADD KEY `id_equip` (`nom_equip`);

--
-- Índexs per a la taula `partides_trobades`
--
ALTER TABLE `partides_trobades`
  ADD PRIMARY KEY (`id_partida`),
  ADD KEY `id_oferta` (`id_oferta`),
  ADD KEY `id_equip` (`nom_equip_acceptat`);

--
-- Índexs per a la taula `usuaris`
--
ALTER TABLE `usuaris`
  ADD PRIMARY KEY (`id_usuari`);

--
-- AUTO_INCREMENT per les taules bolcades
--

--
-- AUTO_INCREMENT per la taula `equips`
--
ALTER TABLE `equips`
  MODIFY `id_equip` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la taula `ofertes`
--
ALTER TABLE `ofertes`
  MODIFY `id_oferta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT per la taula `partides_trobades`
--
ALTER TABLE `partides_trobades`
  MODIFY `id_partida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT per la taula `usuaris`
--
ALTER TABLE `usuaris`
  MODIFY `id_usuari` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
