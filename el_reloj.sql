-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 24-01-2025 a las 11:30:44
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `el_reloj`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `año_ubicado`
--

DROP TABLE IF EXISTS `año_ubicado`;
CREATE TABLE IF NOT EXISTS `año_ubicado` (
  `año_ubicado` int NOT NULL,
  `época` varchar(100) NOT NULL,
  `evento_desencadenante` varchar(200) NOT NULL,
  PRIMARY KEY (`año_ubicado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `año_ubicado`
--

INSERT INTO `año_ubicado` (`año_ubicado`, `época`, `evento_desencadenante`) VALUES
(1492, 'reconquista', 'Desc_America');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
  `autor` varchar(100) NOT NULL,
  `epoca` varchar(200) NOT NULL,
  `genero` varchar(100) NOT NULL,
  `titulo` varchar(200) NOT NULL,
  `niv_polemica` varchar(10) NOT NULL,
  `borrada_en` datetime DEFAULT NULL,
  PRIMARY KEY (`autor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `puesto` varchar(100) NOT NULL,
  `privilegios` varchar(100) NOT NULL,
  PRIMARY KEY (`puesto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`puesto`, `privilegios`) VALUES
('director', 'totales'),
('lector', 'lectura'),
('periodista', 'solo_noticias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `año_ubicado` int NOT NULL,
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `rol` varchar(100) NOT NULL,
  `borrado_en` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_puesto` (`rol`),
  KEY `fk_año` (`año_ubicado`),
  KEY `fk_noticia` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`año_ubicado`, `id`, `nombre`, `rol`, `borrado_en`) VALUES
(1492, 1, 'Alex A', 'director', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
