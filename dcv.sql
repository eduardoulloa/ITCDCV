-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-04-2013 a las 10:06:40
-- Versión del servidor: 5.1.41
-- Versión de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `dcv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` varchar(25) NOT NULL DEFAULT '',
  `password` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `matricula` char(9) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido_paterno` varchar(60) NOT NULL,
  `apellido_materno` varchar(60) DEFAULT NULL,
  `plan` varchar(10) NOT NULL,
  `semestre` int(11) NOT NULL,
  `password` varchar(45) NOT NULL,
  `anio_graduado` char(4) DEFAULT NULL,
  `idcarrera` int(11) NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`matricula`),
  KEY `fk_alumno_carrera1` (`idcarrera`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletin_informativo`
--

CREATE TABLE IF NOT EXISTS `boletin_informativo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mensaje` varchar(10000) NOT NULL,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `semestre1` bit(1) NOT NULL DEFAULT b'1',
  `semestre2` bit(1) NOT NULL DEFAULT b'1',
  `semestre3` bit(1) NOT NULL DEFAULT b'1',
  `semestre4` bit(1) NOT NULL DEFAULT b'1',
  `semestre5` bit(1) NOT NULL DEFAULT b'1',
  `semestre6` bit(1) NOT NULL DEFAULT b'1',
  `semestre7` bit(1) NOT NULL DEFAULT b'1',
  `semestre8` bit(1) NOT NULL DEFAULT b'1',
  `semestre9` bit(1) NOT NULL DEFAULT b'1',
  `exatec` bit(1) NOT NULL DEFAULT b'0',
  `idcarrera` int(11) NOT NULL,
  `subject` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_boletinInformativo_carrera1` (`idcarrera`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE IF NOT EXISTS `carrera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siglas` varchar(5) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera_tiene_empleado`
--

CREATE TABLE IF NOT EXISTS `carrera_tiene_empleado` (
  `idcarrera` int(11) NOT NULL DEFAULT '0',
  `nomina` char(9) NOT NULL,
  PRIMARY KEY (`idcarrera`,`nomina`),
  KEY `fk_carrera_tiene_empleado_empleado1` (`nomina`),
  KEY `fk_carrera_tiene_empleado_carrera` (`idcarrera`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE IF NOT EXISTS `empleado` (
  `nomina` char(9) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellido_paterno` varchar(60) NOT NULL,
  `apellido_materno` varchar(60) DEFAULT NULL,
  `password` varchar(45) NOT NULL,
  `puesto` enum('Director','Co-director','Secretaria','Asistente') NOT NULL,
  PRIMARY KEY (`nomina`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `revalidacion`
--

CREATE TABLE IF NOT EXISTS `revalidacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `universidad` varchar(100) NOT NULL,
  `clave_materia_local` varchar(10) NOT NULL,
  `nombre_materia_local` varchar(100) NOT NULL,
  `clave_materia_cursada` varchar(20) NOT NULL,
  `nombre_materia_cursada` varchar(100) NOT NULL,
  `periodo_de_revalidacion` enum('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL,
  `anio_de_revalidacion` char(4) NOT NULL,
  `idcarrera` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_revalidacion_carrera1` (`idcarrera`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_baja_materia`
--

CREATE TABLE IF NOT EXISTS `solicitud_baja_materia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Recibida','Pendiente','Terminada') NOT NULL DEFAULT 'Recibida',
  `motivo` varchar(500) NOT NULL,
  `clave_materia` varchar(10) NOT NULL,
  `nombre_materia` varchar(100) NOT NULL,
  `unidades_materia` int(11) NOT NULL,
  `grupo` int(11) NOT NULL,
  `atributo` enum('presencial','en linea','U. V.') NOT NULL,
  `unidades` int(11) NOT NULL,
  `periodo` enum('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL,
  `anio` char(4) NOT NULL,
  `matriculaalumno` char(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_baja_materia_alumno1` (`matriculaalumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_baja_semestre`
--

CREATE TABLE IF NOT EXISTS `solicitud_baja_semestre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Recibida','Pendiente','Terminada') NOT NULL DEFAULT 'Recibida',
  `periodo` enum('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL,
  `anio` char(4) NOT NULL,
  `domicilio` varchar(100) NOT NULL,
  `motivo` varchar(200) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `extranjero` char(2) NOT NULL,
  `matriculaalumno` char(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_baja_semestre_alumno1` (`matriculaalumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_carta_recomendacion`
--

CREATE TABLE IF NOT EXISTS `solicitud_carta_recomendacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Recibida','Pendiente','Terminada') NOT NULL DEFAULT 'Recibida',
  `tipo` varchar(50) NOT NULL,
  `formato` varchar(30) DEFAULT NULL,
  `comentarios` varchar(500) DEFAULT NULL,
  `matriculaalumno` char(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_carta_recomendacion_alumno1` (`matriculaalumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_problemas_inscripcion`
--

CREATE TABLE IF NOT EXISTS `solicitud_problemas_inscripcion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Recibida','Pendiente','Terminada') NOT NULL DEFAULT 'Recibida',
  `periodo` enum('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL,
  `anio` char(4) NOT NULL,
  `unidades` int(11) NOT NULL,
  `quitar_prioridades` varchar(2) NOT NULL,
  `comentarios` varchar(500) DEFAULT NULL,
  `matriculaalumno` char(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_problemas_inscripcion_alumno1` (`matriculaalumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_revalidacion`
--

CREATE TABLE IF NOT EXISTS `solicitud_revalidacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Recibida','Pendiente','Terminada') NOT NULL DEFAULT 'Recibida',
  `periodo` enum('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL,
  `anio` char(4) NOT NULL,
  `clave_revalidar` varchar(10) NOT NULL,
  `nombre_revalidar` varchar(100) NOT NULL,
  `clave_cursada` varchar(10) NOT NULL,
  `nombre_cursada` varchar(100) NOT NULL,
  `universidad` varchar(100) DEFAULT NULL,
  `matriculaalumno` char(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_revalidacion_alumno1` (`matriculaalumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sugerencia`
--

CREATE TABLE IF NOT EXISTS `sugerencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Recibida','Pendiente','Terminada') NOT NULL DEFAULT 'Recibida',
  `sugerencia` varchar(500) NOT NULL,
  `respuesta` varchar(500) DEFAULT NULL,
  `matriculaalumno` char(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sugerencia_alumno1` (`matriculaalumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Filtros para las tablas descargadas (dump)
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `fk_alumno_carrera1` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `boletin_informativo`
--
ALTER TABLE `boletin_informativo`
  ADD CONSTRAINT `fk_boletinInformativo_carrera1` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `carrera_tiene_empleado`
--
ALTER TABLE `carrera_tiene_empleado`
  ADD CONSTRAINT `fk_carrera_tiene_empleado_carrera` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_carrera_tiene_empleado_empleado1` FOREIGN KEY (`nomina`) REFERENCES `empleado` (`nomina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `revalidacion`
--
ALTER TABLE `revalidacion`
  ADD CONSTRAINT `fk_revalidacion_carrera1` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud_baja_materia`
--
ALTER TABLE `solicitud_baja_materia`
  ADD CONSTRAINT `fk_solicitud_baja_materia_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud_baja_semestre`
--
ALTER TABLE `solicitud_baja_semestre`
  ADD CONSTRAINT `fk_solicitud_baja_semestre_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud_carta_recomendacion`
--
ALTER TABLE `solicitud_carta_recomendacion`
  ADD CONSTRAINT `fk_solicitud_carta_recomendacion_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud_problemas_inscripcion`
--
ALTER TABLE `solicitud_problemas_inscripcion`
  ADD CONSTRAINT `fk_solicitud_problemas_inscripcion_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `solicitud_revalidacion`
--
ALTER TABLE `solicitud_revalidacion`
  ADD CONSTRAINT `fk_solicitud_revalidacion_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sugerencia`
--
ALTER TABLE `sugerencia`
  ADD CONSTRAINT `fk_sugerencia_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
