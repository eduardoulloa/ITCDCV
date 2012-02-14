SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `dcv` ;
CREATE SCHEMA IF NOT EXISTS `dcv` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `dcv` ;

-- -----------------------------------------------------
-- Table `dcv`.`carrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`carrera` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`carrera` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `siglas` VARCHAR(5) NOT NULL ,
  `nombre` VARCHAR(80) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`alumno`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`alumno` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`alumno` (
  `matricula` CHAR(9) NOT NULL ,
  `nombre` VARCHAR(60) NOT NULL ,
  `apellido_paterno` VARCHAR(60) NOT NULL ,
  `apellido_materno` VARCHAR(60) NULL ,
  `plan` VARCHAR(10) NOT NULL ,
  `semestre` INT NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `anio_graduado` CHAR(4) NULL ,
  `idcarrera` INT NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`matricula`) ,
  INDEX `fk_alumno_carrera1` (`idcarrera` ASC) ,
  CONSTRAINT `fk_alumno_carrera1`
    FOREIGN KEY (`idcarrera` )
    REFERENCES `dcv`.`carrera` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`empleado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`empleado` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`empleado` (
  `nomina` CHAR(9) NOT NULL ,
  `nombre` VARCHAR(60) NOT NULL ,
  `apellido_paterno` VARCHAR(60) NOT NULL ,
  `apellido_materno` VARCHAR(60) NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `puesto` ENUM('Director', 'Co-director', 'Secretaria', 'Asistente') NOT NULL ,
  PRIMARY KEY (`nomina`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`carrera_tiene_empleado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`carrera_tiene_empleado` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`carrera_tiene_empleado` (
  `idcarrera` INT NOT NULL ,
  `nomina` CHAR(9) NOT NULL ,
  PRIMARY KEY (`idcarrera`, `nomina`) ,
  INDEX `fk_carrera_tiene_empleado_empleado1` (`nomina` ASC) ,
  INDEX `fk_carrera_tiene_empleado_carrera` (`idcarrera` ASC) ,
  CONSTRAINT `fk_carrera_tiene_empleado_carrera`
    FOREIGN KEY (`idcarrera` )
    REFERENCES `dcv`.`carrera` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_carrera_tiene_empleado_empleado1`
    FOREIGN KEY (`nomina` )
    REFERENCES `dcv`.`empleado` (`nomina` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`solicitud_carta_recomendacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`solicitud_carta_recomendacion` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`solicitud_carta_recomendacion` (
  `id` INT NOT NULL ,
  `fechahora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `status` ENUM('Recibida', 'Pendiente', 'Terminada') NOT NULL ,
  `tipo` VARCHAR(30) NOT NULL ,
  `formato` VARCHAR(30) NULL ,
  `comentarios` VARCHAR(500) NULL ,
  `matriculaalumno` CHAR(9) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_solicitud_carta_recomendacion_alumno1` (`matriculaalumno` ASC) ,
  CONSTRAINT `fk_solicitud_carta_recomendacion_alumno1`
    FOREIGN KEY (`matriculaalumno` )
    REFERENCES `dcv`.`alumno` (`matricula` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`solicitud_baja_semestre`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`solicitud_baja_semestre` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`solicitud_baja_semestre` (
  `id` INT NOT NULL ,
  `fechahora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `status` ENUM('Recibida', 'Pendiente', 'Terminada') NOT NULL ,
  `periodo` ENUM('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL ,
  `anio` CHAR(4) NOT NULL ,
  `domicilio` VARCHAR(100) NOT NULL ,
  `motivo` VARCHAR(20) NOT NULL ,
  `telefono` VARCHAR(12) NOT NULL ,
  `extranjero` BIT(1) NOT NULL ,
  `matriculaalumno` CHAR(9) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_solicitud_baja_semestre_alumno1` (`matriculaalumno` ASC) ,
  CONSTRAINT `fk_solicitud_baja_semestre_alumno1`
    FOREIGN KEY (`matriculaalumno` )
    REFERENCES `dcv`.`alumno` (`matricula` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`sugerencia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`sugerencia` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`sugerencia` (
  `id` INT NOT NULL ,
  `fechahora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `status` ENUM('Recibida', 'Pendiente', 'Terminada') NOT NULL ,
  `sugerencia` VARCHAR(500) NOT NULL ,
  `respuesta` VARCHAR(500) NULL ,
  `matriculaalumno` CHAR(9) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sugerencia_alumno1` (`matriculaalumno` ASC) ,
  CONSTRAINT `fk_sugerencia_alumno1`
    FOREIGN KEY (`matriculaalumno` )
    REFERENCES `dcv`.`alumno` (`matricula` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`solicitud_problemas_inscripcion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`solicitud_problemas_inscripcion` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`solicitud_problemas_inscripcion` (
  `id` INT NOT NULL ,
  `fechahora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `status` ENUM('Recibida', 'Pendiente', 'Terminada') NOT NULL ,
  `periodo` ENUM('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL ,
  `anio` CHAR(4) NOT NULL ,
  `unidades` INT NOT NULL ,
  `quitar_prioridades` BIT(1) NOT NULL ,
  `comentarios` VARCHAR(500) NULL ,
  `matriculaalumno` CHAR(9) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_solicitud_problemas_inscripcion_alumno1` (`matriculaalumno` ASC) ,
  CONSTRAINT `fk_solicitud_problemas_inscripcion_alumno1`
    FOREIGN KEY (`matriculaalumno` )
    REFERENCES `dcv`.`alumno` (`matricula` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`solicitud_baja_materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`solicitud_baja_materia` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`solicitud_baja_materia` (
  `id` INT NOT NULL ,
  `fechahora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `status` ENUM('Recibida', 'Pendiente', 'Terminada') NOT NULL ,
  `motivo` VARCHAR(500) NOT NULL ,
  `clave_materia` VARCHAR(10) NOT NULL ,
  `nombre_materia` VARCHAR(100) NOT NULL ,
  `unidades_materia` INT NOT NULL ,
  `grupo` INT NOT NULL ,
  `atributo` ENUM('presencial', 'en linea', 'U. V.') NOT NULL ,
  `unidades` INT NOT NULL ,
  `periodo` ENUM('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL ,
  `anio` CHAR(4) NOT NULL ,
  `matriculaalumno` CHAR(9) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_solicitud_baja_materia_alumno1` (`matriculaalumno` ASC) ,
  CONSTRAINT `fk_solicitud_baja_materia_alumno1`
    FOREIGN KEY (`matriculaalumno` )
    REFERENCES `dcv`.`alumno` (`matricula` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`solicitud_revalidacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`solicitud_revalidacion` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`solicitud_revalidacion` (
  `id` INT NOT NULL ,
  `fechahora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `status` ENUM('Recibida', 'Pendiente', 'Terminada') NOT NULL ,
  `periodo` ENUM('Enero-Mayo','Verano','Agosto-Diciembre') NOT NULL ,
  `anio` CHAR(4) NOT NULL ,
  `clave_revalidar` VARCHAR(10) NOT NULL ,
  `nombre_revalidar` VARCHAR(100) NOT NULL ,
  `clave_cursada` VARCHAR(10) NOT NULL ,
  `nombre_cursada` VARCHAR(100) NOT NULL ,
  `universidad` VARCHAR(100) NULL ,
  `matriculaalumno` CHAR(9) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_solicitud_revalidacion_alumno1` (`matriculaalumno` ASC) ,
  CONSTRAINT `fk_solicitud_revalidacion_alumno1`
    FOREIGN KEY (`matriculaalumno` )
    REFERENCES `dcv`.`alumno` (`matricula` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dcv`.`boletin_informativo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `dcv`.`boletin_informativo` ;

CREATE  TABLE IF NOT EXISTS `dcv`.`boletin_informativo` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `mensaje` VARCHAR(10000) NOT NULL ,
  `fechahora` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `semestre1` BIT(1) NOT NULL DEFAULT 1 ,
  `semestre2` BIT(1) NOT NULL DEFAULT 1 ,
  `semestre3` BIT(1) NOT NULL DEFAULT 1 ,
  `semestre4` BIT(1) NOT NULL DEFAULT 1 ,
  `semestre5` BIT(1) NOT NULL DEFAULT 1 ,
  `semestre6` BIT(1) NOT NULL DEFAULT 1 ,
  `semestre7` BIT(1) NOT NULL DEFAULT 1 ,
  `semestre8` BIT(1) NOT NULL DEFAULT 1 ,
  `semestre9` BIT(1) NOT NULL DEFAULT 1 ,
  `exatec` BIT(1) NOT NULL DEFAULT 0 ,
  `idcarrera` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_boletinInformativo_carrera1` (`idcarrera` ASC) ,
  CONSTRAINT `fk_boletinInformativo_carrera1`
    FOREIGN KEY (`idcarrera` )
    REFERENCES `dcv`.`carrera` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
