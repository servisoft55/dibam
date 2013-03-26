-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-10-2012 a las 05:55:07
-- Versión del servidor: 5.5.25a
-- Versión de PHP: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `anacional`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juzgados`
--

CREATE TABLE IF NOT EXISTS `juzgados` (
  `id_jzgd` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `orden` int(1) NOT NULL,
  PRIMARY KEY (`id_jzgd`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `juzgados`
--

INSERT INTO `juzgados` (`id_jzgd`, `nombre`, `orden`) VALUES
(1, 'PRIMERO', 1),
(2, 'SEGUNDO', 2),
(3, 'TERCERO', 3),
(4, 'CUARTO', 4),
(5, 'MENORES', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimiento`
--

CREATE TABLE IF NOT EXISTS `movimiento` (
  `id_movimiento` int(11) NOT NULL AUTO_INCREMENT,
  `juzgado` int(1) NOT NULL,
  `tipo` int(1) NOT NULL,
  `ciudad` varchar(20) NOT NULL,
  `caja` int(11) NOT NULL,
  `legajo` int(11) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_termino` date NOT NULL,
  `nombre_demandado` varchar(200) NOT NULL,
  `apellido_demandado` varchar(200) NOT NULL,
  `nombre_demandante` varchar(200) NOT NULL,
  `apellido_demandante` varchar(200) NOT NULL,
  `tipo de juicio` varchar(100) NOT NULL,
  `notas` mediumtext NOT NULL,
  `funcionario` varchar(10) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id_movimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `detalle` varchar(30) NOT NULL,
  `id_juzgado` int(11) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `nombre`, `detalle`, `id_juzgado`) VALUES
(1, 'CRIMINAL', 'DEL CRIMEN', 1),
(2, 'CIVIL', 'CIVILES', 1),
(3, 'LABORAL', 'LABORALES', 1),
(4, 'ALCOHOLES', 'ALCOHOLES', 1),
(5, 'CRIMINAL', 'DEL CRIMEN', 2),
(6, 'CIVIL', 'CIVILES', 2),
(7, 'LABORAL', 'LABORALES', 2),
(8, 'ALCOHOLES', 'ALCOHOLES', 2),
(9, 'CRIMINAL', 'DEL CRIMEN', 3),
(10, 'CIVIL', 'CIVILES', 3),
(11, 'LABORAL', 'LABORALES', 3),
(12, 'ALCOHOLES', 'ALCOHOLES', 3),
(13, 'CRIMINAL', 'DEL CRIMEN', 4),
(14, 'CIVIL', 'CIVILES', 4),
(15, 'LABORAL', 'LABORALES', 4),
(16, 'ALCOHOLES', 'ALCOHOLES', 4),
(17, 'MENORES', 'MENORES', 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
