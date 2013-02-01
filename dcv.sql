-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 29, 2011 at 01:26 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dcv`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumno`
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

--
-- Dumping data for table `alumno`
--

INSERT INTO `alumno` (`matricula`, `nombre`, `apellido_paterno`, `apellido_materno`, `plan`, `semestre`, `password`, `anio_graduado`, `idcarrera`, `email`) VALUES
('1032091', 'David', 'Valenzuela', NULL, '', -1, '172522ec1028ab781d9dfd17eaca4427', '2011', 1, 'ediulloa@hotmail.com'),
('707070', 'jim', 'perez', NULL, '', 0, 'jim', NULL, 1, 'eduardo.ulloa@ymail.com'),
('796570', 'Eduardo', 'Ulloa', NULL, '', 3, '6d6354ece40846bf7fca65dfabd5d9d4', '', 1, 'ulloamagallanes@gmail.com'),
('797979', 'juan', 'perez', '', '1', -1, 'ff338c7d9a0f74e5657f2e21d16721be', '2011', 1, 'eulloamagallanes@gmail.com'),
('808080', 'pedro', 'perez', NULL, '', 1, 'pedro', '2011', 1, 'eduardo.ulloa@ymail.com'),
('909090', 'mano', 'williams', NULL, '', 0, '5b4d762427d4dff75f6e5885cb380080', '2011', 1, 'eduardo.ulloa@ymail.com');

-- --------------------------------------------------------

--
-- Table structure for table `boletin_informativo`
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
  PRIMARY KEY (`id`),
  KEY `fk_boletinInformativo_carrera1` (`idcarrera`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `boletin_informativo`
--

INSERT INTO `boletin_informativo` (`id`, `mensaje`, `fechahora`, `semestre1`, `semestre2`, `semestre3`, `semestre4`, `semestre5`, `semestre6`, `semestre7`, `semestre8`, `semestre9`, `exatec`, `idcarrera`) VALUES
(1, 'hola', '2011-11-14 09:08:39', '1', '0', '0', '0', '1', '0', '1', '0', '0', '0', 1),
(2, 'hola kaj', '2011-11-14 09:22:24', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(3, 'bonjour', '2011-11-14 09:26:01', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(4, 'buenas noches', '2011-11-14 09:31:30', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(5, 'CHOCHIN', '2011-11-14 23:00:15', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(6, 'mira mira mria', '2011-11-14 23:00:42', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(7, 'hola', '2011-11-14 23:00:56', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(8, 'JELLO', '2011-11-14 23:02:19', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(9, 'buonasera ragazzi', '2011-11-15 09:42:26', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', 1),
(10, 'aqui va', '2011-11-15 12:11:09', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', 1),
(11, 'va vene eh', '2011-11-15 13:55:38', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', 1),
(12, 'prova 2', '2011-11-15 13:57:38', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', 1),
(13, 'boletin prueba david', '2011-11-15 14:04:08', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', 1),
(14, 'whaaazzaa kidz', '2011-11-15 19:45:29', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(15, 'good evening', '2011-11-16 09:11:28', '1', '1', '0', '0', '0', '1', '0', '0', '0', '0', 1),
(16, 'jaaaaaaaaaaaaar', '2011-11-16 09:19:02', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', 1),
(17, 'aqui va el test para ealumnos', '2011-11-16 09:51:01', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', 1),
(18, 'stavo provando l''italiano. grazie amico', '2011-11-16 14:00:04', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', 1),
(19, 'Cominciamo a provare', '2011-11-16 14:00:50', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', 1),
(20, 'cazzo', '2011-11-16 14:02:18', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(21, 'hola', '2011-11-16 17:09:49', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(22, 'aqui van', '2011-11-16 20:19:09', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(23, 'aqui va', '2011-11-16 20:20:17', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(24, 'juay de rito', '2011-11-16 20:22:36', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(25, 'ajajaja', '2011-11-16 20:37:14', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(26, 'hola', '2011-11-16 20:56:01', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(27, 'let''s see', '2011-11-16 21:00:16', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(28, 'hola', '2011-11-16 21:02:34', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(29, 'hola', '2011-11-16 21:03:29', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(30, 'hola', '2011-11-16 21:04:25', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(31, 'fdfds', '2011-11-16 21:09:24', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(32, 'hofds', '2011-11-16 21:44:53', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(33, 'fdsfas', '2011-11-16 21:47:24', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', 1),
(34, 'fds', '2011-11-16 21:49:00', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', 1),
(35, 'Come on jack', '2011-11-17 10:16:09', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', 1),
(36, 'molto bene', '2011-11-17 10:17:44', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', 1),
(37, 'qaui va el messagio\r\nin italiano ci parliamo', '2011-11-18 12:27:01', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 1),
(38, 'inscripciones 2012 ....\r\n\r\natendion inscribir', '2011-11-18 15:18:30', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 1),
(39, 'cogneta', '2011-11-24 10:31:05', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', 1),
(40, 'ciao', '2011-11-24 12:58:08', '0', '0', '1', '0', '0', '0', '0', '0', '0', '0', 1),
(42, 'Buona seeraaaaa ciao', '2011-11-28 10:56:13', '0', '0', '1', '0', '0', '0', '0', '0', '0', '1', 1),
(43, 'ci vediamo ciao', '2011-11-28 11:03:44', '0', '0', '1', '0', '0', '0', '0', '0', '0', '1', 1),
(44, 'Allora facciamo cosi', '2011-11-28 11:11:52', '0', '0', '1', '0', '0', '0', '0', '0', '0', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `carrera`
--

CREATE TABLE IF NOT EXISTS `carrera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siglas` varchar(5) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `carrera`
--

INSERT INTO `carrera` (`id`, `siglas`, `nombre`) VALUES
(1, 'ITC', 'Ingenieria en Tecnologias Computacionales');

-- --------------------------------------------------------

--
-- Table structure for table `carrera_tiene_empleado`
--

CREATE TABLE IF NOT EXISTS `carrera_tiene_empleado` (
  `idcarrera` int(11) NOT NULL DEFAULT '0',
  `nomina` char(9) NOT NULL,
  PRIMARY KEY (`idcarrera`,`nomina`),
  KEY `fk_carrera_tiene_empleado_empleado1` (`nomina`),
  KEY `fk_carrera_tiene_empleado_carrera` (`idcarrera`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `carrera_tiene_empleado`
--

INSERT INTO `carrera_tiene_empleado` (`idcarrera`, `nomina`) VALUES
(1, 'admin'),
(1, 'carlos');

-- --------------------------------------------------------

--
-- Table structure for table `empleado`
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

--
-- Dumping data for table `empleado`
--

INSERT INTO `empleado` (`nomina`, `nombre`, `apellido_paterno`, `apellido_materno`, `password`, `puesto`) VALUES
('admin', 'mono', 'mono', NULL, '654db8a14a5f633b9ba85ec92dc51f7c', 'Director'),
('carlos', 'mono', 'mono', NULL, '654db8a14a5f633b9ba85ec92dc51f7c', 'Director');

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_baja_materia`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `solicitud_baja_materia`
--

INSERT INTO `solicitud_baja_materia` (`id`, `fechahora`, `status`, `motivo`, `clave_materia`, `nombre_materia`, `unidades_materia`, `grupo`, `atributo`, `unidades`, `periodo`, `anio`, `matriculaalumno`) VALUES
(1, '2011-10-24 14:56:11', 'Recibida', '1', '1', 'Mate 3', 1, 1, 'presencial', 8, 'Enero-Mayo', '00:2', '796570'),
(2, '2011-11-23 12:15:24', 'Recibida', '', '', '', 0, 1, '', 0, 'Enero-Mayo', '00:2', '797979'),
(4, '2011-11-25 10:44:53', 'Recibida', 'kooladi', '10', 'Relxaxing', 30, 1, 'presencial', 20, '', '00:2', '796570'),
(5, '2011-11-27 13:32:10', 'Recibida', 'fhoa', '1', 'algtirt', 20, 1, 'presencial', 20, 'Enero-Mayo', '2011', '796570'),
(7, '2011-11-27 14:04:11', 'Recibida', 'ok', '1', '2', 20, 2, 'presencial', 20, 'Enero-Mayo', '2011', '796570'),
(8, '2011-11-27 14:16:11', 'Recibida', '111', '1', 'come original', 1, 20, 'presencial', 2, 'Enero-Mayo', '2011', '796570'),
(9, '2011-11-27 14:39:47', 'Recibida', 'come on', '1', 'ALGO', 2, 20, 'presencial', 2, 'Enero-Mayo', '2011', '796570'),
(10, '2011-11-27 14:42:22', 'Recibida', 'me cai', '10003', 'mate 3', 0, 2, 'presencial', 3, 'Enero-Mayo', '2011', '796570');

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_baja_semestre`
--

CREATE TABLE IF NOT EXISTS `solicitud_baja_semestre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Recibida','Pendiente','Terminada') NOT NULL DEFAULT 'Recibida',
  `periodo` enum('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL,
  `anio` char(4) NOT NULL,
  `domicilio` varchar(100) NOT NULL,
  `motivo` varchar(20) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `extranjero` char(2) NOT NULL,
  `matriculaalumno` char(9) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitud_baja_semestre_alumno1` (`matriculaalumno`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `solicitud_baja_semestre`
--

INSERT INTO `solicitud_baja_semestre` (`id`, `fechahora`, `status`, `periodo`, `anio`, `domicilio`, `motivo`, `telefono`, `extranjero`, `matriculaalumno`) VALUES
(1, '2011-10-24 14:38:10', 'Recibida', 'Enero-Mayo', '2011', 'calle falsa del sol', '1', '83000000', '1', '796570'),
(2, '2011-10-24 14:45:09', 'Recibida', 'Enero-Mayo', '2011', 'francisco', 'me mori', '787878', '1', '797979'),
(3, '2011-11-27 15:00:00', 'Recibida', 'Enero-Mayo', '2011', 'jota 45', 'jola', '83002215', '0', '796570'),
(4, '2011-11-27 15:05:40', 'Recibida', 'Enero-Mayo', '2011', 'franco', 'comon', '83002215', 'Si', '796570'),
(5, '2011-11-27 15:11:42', 'Recibida', 'Enero-Mayo', '2011', 'franco 2000', 'comon', '83002215', 'No', '796570');

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_carta_recomendacion`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `solicitud_carta_recomendacion`
--

INSERT INTO `solicitud_carta_recomendacion` (`id`, `fechahora`, `status`, `tipo`, `formato`, `comentarios`, `matriculaalumno`) VALUES
(1, '2011-10-24 21:35:42', 'Recibida', '1', '1', 'muy chdo', '797979'),
(3, '2011-11-27 15:39:06', 'Recibida', 'Carta de recomendacion DAE', 'papel', 'muy bien', '796570'),
(4, '2011-11-27 15:41:13', 'Recibida', 'Carta de recomendacion DAE', 'hoja', 'mi carta', '796570'),
(5, '2011-11-27 15:42:39', 'Recibida', 'Carta de Recomendacion para Universidad Extranjera', 'papel', 'uni', '796570');

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_problemas_inscripcion`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `solicitud_problemas_inscripcion`
--

INSERT INTO `solicitud_problemas_inscripcion` (`id`, `fechahora`, `status`, `periodo`, `anio`, `unidades`, `quitar_prioridades`, `comentarios`, `matriculaalumno`) VALUES
(3, '2011-10-24 13:31:22', 'Recibida', 'Verano', '2011', 30, '1', 'holahola', '796570'),
(4, '2011-10-24 14:26:04', 'Recibida', 'Enero-Mayo', '2011', 48, '1', 'hola me estaba fijando que es mentira', '797979'),
(5, '2011-10-25 12:19:52', 'Recibida', '', '2011', 48, '1', 'Los odio.', '797979'),
(6, '2011-10-25 12:52:03', 'Recibida', 'Enero-Mayo', '2011', 48, '0', 'si si si', '797979'),
(7, '2011-10-25 12:59:47', 'Recibida', 'Verano', '2011', 48, '1', 'esta my bien', '797979'),
(8, '2011-10-25 13:01:56', 'Recibida', 'Agosto-Diciembre', '3000', 58, '0', 'si', '797979'),
(9, '2011-11-27 15:51:34', 'Recibida', 'Enero-Mayo', '2011', 20, '0', 'come on inscripciones', '796570'),
(10, '2011-11-27 16:00:42', 'Recibida', 'Enero-Mayo', '2011', 30, 'Si', 'excellent', '796570');

-- --------------------------------------------------------

--
-- Table structure for table `solicitud_revalidacion`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `solicitud_revalidacion`
--

INSERT INTO `solicitud_revalidacion` (`id`, `fechahora`, `status`, `periodo`, `anio`, `clave_revalidar`, `nombre_revalidar`, `clave_cursada`, `nombre_cursada`, `universidad`, `matriculaalumno`) VALUES
(1, '2011-10-24 21:22:41', 'Recibida', 'Enero-Mayo', '2011', '1', 'algoritmos ', '1', 'Redes', 'itesm', '797979'),
(2, '2011-11-27 17:46:18', 'Recibida', 'Enero-Mayo', '2011', 'h1003', 'algoritmos', 'h1343', 'algorithms', 'tech mass', '796570');

-- --------------------------------------------------------

--
-- Table structure for table `sugerencia`
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sugerencia`
--

INSERT INTO `sugerencia` (`id`, `fechahora`, `status`, `sugerencia`, `respuesta`, `matriculaalumno`) VALUES
(1, '2011-10-24 21:24:43', 'Recibida', 'esta bien chido', 'Si gracias pero n nos importas', '797979'),
(2, '2011-11-27 17:57:09', 'Recibida', 'vamos', NULL, '796570');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `fk_alumno_carrera1` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `boletin_informativo`
--
ALTER TABLE `boletin_informativo`
  ADD CONSTRAINT `fk_boletinInformativo_carrera1` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `carrera_tiene_empleado`
--
ALTER TABLE `carrera_tiene_empleado`
  ADD CONSTRAINT `fk_carrera_tiene_empleado_carrera` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_carrera_tiene_empleado_empleado1` FOREIGN KEY (`nomina`) REFERENCES `empleado` (`nomina`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `solicitud_baja_materia`
--
ALTER TABLE `solicitud_baja_materia`
  ADD CONSTRAINT `fk_solicitud_baja_materia_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `solicitud_baja_semestre`
--
ALTER TABLE `solicitud_baja_semestre`
  ADD CONSTRAINT `fk_solicitud_baja_semestre_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `solicitud_carta_recomendacion`
--
ALTER TABLE `solicitud_carta_recomendacion`
  ADD CONSTRAINT `fk_solicitud_carta_recomendacion_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `solicitud_problemas_inscripcion`
--
ALTER TABLE `solicitud_problemas_inscripcion`
  ADD CONSTRAINT `fk_solicitud_problemas_inscripcion_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `solicitud_revalidacion`
--
ALTER TABLE `solicitud_revalidacion`
  ADD CONSTRAINT `fk_solicitud_revalidacion_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sugerencia`
--
ALTER TABLE `sugerencia`
  ADD CONSTRAINT `fk_sugerencia_alumno1` FOREIGN KEY (`matriculaalumno`) REFERENCES `alumno` (`matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

create table admin(username char(20), password char(60));

insert into admin values('admin', MD5('admin'));

--
-- Agrego la tabla revalidacion
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `revalidacion`
  ADD CONSTRAINT `fk_revalidacion_carrera1` FOREIGN KEY (`idcarrera`) REFERENCES `carrera` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;