-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 08-11-2011 a las 17:21:33
-- Versión del servidor: 5.1.44
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `dcv`
--

--
-- Volcar la base de datos para la tabla `boletin_informativo`
--


--
-- Volcar la base de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`id`, `siglas`, `nombre`) VALUES
(1, 'ITC', 'Ingeniería en Tecnologías Computacionales'),
(2, 'ITIC', 'Ingeniería en Tecnologías de la Información y Comunicaciones');
--
-- Volcar la base de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`matricula`, `nombre`, `apellido_paterno`, `apellido_materno`, `plan`, `semestre`, `password`, `anio_graduado`, `idcarrera`, `email`) VALUES
('A01175180', 'Guillermo', 'De los Santos', 'García', 'BCT09', 5, MD5('password'), NULL, 1, 'A01175180@itesm.mx');

--
-- Volcar la base de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`nomina`, `nombre`, `apellido_paterno`, `apellido_materno`, `password`, `puesto`) VALUES
('L01234567', 'Elda', 'Quiroga', NULL, MD5('contrasena'), 'Director');


--
-- Volcar la base de datos para la tabla `carrera_tiene_empleado`
--

INSERT INTO `carrera_tiene_empleado` (`idcarrera`, `nomina`) VALUES
(1, 'L01234567');

--
-- Volcar la base de datos para la tabla `solicitud_baja_materia`
--


--
-- Volcar la base de datos para la tabla `solicitud_baja_semestre`
--


--
-- Volcar la base de datos para la tabla `solicitud_carta_recomendacion`
--


--
-- Volcar la base de datos para la tabla `solicitud_problemas_inscripcion`
--


--
-- Volcar la base de datos para la tabla `solicitud_revalidacion`
--


--
-- Volcar la base de datos para la tabla `sugerencia`
--

