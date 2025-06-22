-- Limpieza de restricciones temporales
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

-- Base de datos cloud
CREATE DATABASE IF NOT EXISTS cloud DEFAULT CHARACTER SET utf8;
USE cloud;

-- Tabla administrador
CREATE TABLE IF NOT EXISTS administrador (
  id BIGINT NOT NULL,
  correo VARCHAR(45) NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  clave VARCHAR(45) NOT NULL,
  respuesta_preg VARCHAR(45) NOT NULL,
  id_admin BIGINT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_admin) REFERENCES administrador (id)
) ENGINE=InnoDB;

-- Tabla estado
CREATE TABLE IF NOT EXISTS estado (
  codigo INT AUTO_INCREMENT NOT NULL,
  tipo_estado VARCHAR(20) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB;

-- Tabla carrera
CREATE TABLE IF NOT EXISTS carrera (
  codigo INT AUTO_INCREMENT NOT NULL,
  nombre_carrera VARCHAR(45) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB;

-- Tabla estudiante
CREATE TABLE IF NOT EXISTS estudiante (
  codigo BIGINT NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  correo VARCHAR(45) NOT NULL,
  contrasena VARCHAR(70) NOT NULL,
  respuesta_preg VARCHAR(45) NOT NULL,
  cod_carrera INT NOT NULL,
  cod_estado INT NOT NULL,
  PRIMARY KEY (codigo),
  FOREIGN KEY (cod_carrera) REFERENCES carrera (codigo),
  FOREIGN KEY (cod_estado) REFERENCES estado (codigo)
) ENGINE=InnoDB;

-- Tabla tutor
CREATE TABLE IF NOT EXISTS tutor (
  codigo BIGINT NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  correo VARCHAR(45) NOT NULL,
  contrasena VARCHAR(70) NOT NULL,
  calificacion_general DECIMAL(2,1) NULL,
  respuesta_preg VARCHAR(45) NOT NULL,
  cod_estado INT NOT NULL,
  PRIMARY KEY (codigo),
  FOREIGN KEY (cod_estado) REFERENCES estado (codigo)
) ENGINE=InnoDB;

-- Tabla motivo
CREATE TABLE IF NOT EXISTS motivo (
  codigo INT AUTO_INCREMENT NOT NULL,
  tipo_motivo VARCHAR(45) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB;

-- Tabla agendar
CREATE TABLE IF NOT EXISTS agendar (
  id INT AUTO_INCREMENT NOT NULL,
  cod_estudiante BIGINT NOT NULL,
  cod_tutor BIGINT NOT NULL,
  fecha DATE NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_final TIME NOT NULL,
  cod_estado INT NOT NULL,
  cod_motivo INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (cod_estudiante) REFERENCES estudiante (codigo),
  FOREIGN KEY (cod_tutor) REFERENCES tutor (codigo),
  FOREIGN KEY (cod_estado) REFERENCES estado (codigo),
  FOREIGN KEY (cod_motivo) REFERENCES motivo (codigo)
) ENGINE=InnoDB;

-- Tabla dia
CREATE TABLE IF NOT EXISTS dia (
  id INT AUTO_INCREMENT NOT NULL,
  dia VARCHAR(10) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Tabla horario
CREATE TABLE IF NOT EXISTS horario (
  id INT AUTO_INCREMENT NOT NULL,
  id_dia INT NOT NULL,
  cod_tutor BIGINT NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_fin TIME NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_dia) REFERENCES dia (id),
  FOREIGN KEY (cod_tutor) REFERENCES tutor (codigo)
) ENGINE=InnoDB;

-- Tabla disponibilidad
CREATE TABLE IF NOT EXISTS disponibilidad (
  cod_tutor BIGINT NOT NULL,
  hora_i TIME NOT NULL,
  hora_fn TIME NOT NULL,
  id_horario INT NOT NULL,
  cod_estado INT NOT NULL,
  PRIMARY KEY (cod_tutor, hora_i, hora_fn, id_horario),
  FOREIGN KEY (cod_tutor) REFERENCES tutor (codigo),
  FOREIGN KEY (id_horario) REFERENCES horario (id),
  FOREIGN KEY (cod_estado) REFERENCES estado (codigo)
) ENGINE=InnoDB;

-- Tabla area
CREATE TABLE IF NOT EXISTS area (
  codigo INT AUTO_INCREMENT NOT NULL,
  nombre_area VARCHAR(45) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB;

-- Tabla area_tutor
CREATE TABLE IF NOT EXISTS area_tutor (
  cod_tutor BIGINT NOT NULL,
  cod_area INT NOT NULL,
  PRIMARY KEY (cod_tutor, cod_area),
  FOREIGN KEY (cod_tutor) REFERENCES tutor (codigo),
  FOREIGN KEY (cod_area) REFERENCES area (codigo)
) ENGINE=InnoDB;

-- Tabla profesor
CREATE TABLE IF NOT EXISTS profesor (
  codigo BIGINT NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  PRIMARY KEY (codigo)
) ENGINE=InnoDB;

-- Tabla area_profesor
CREATE TABLE IF NOT EXISTS area_profesor (
  cod_profesor BIGINT NOT NULL,
  cod_area INT NOT NULL,
  PRIMARY KEY (cod_profesor, cod_area),
  FOREIGN KEY (cod_profesor) REFERENCES profesor (codigo),
  FOREIGN KEY (cod_area) REFERENCES area (codigo)
) ENGINE=InnoDB;

-- Tabla tipo_archivo
CREATE TABLE IF NOT EXISTS tipo_archivo (
  id INT AUTO_INCREMENT NOT NULL,
  nombre_tipo VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Tabla materia
CREATE TABLE IF NOT EXISTS materia (
  id INT AUTO_INCREMENT NOT NULL,
  nombre_materia VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

-- Tabla archivo
CREATE TABLE IF NOT EXISTS archivo (
  id INT AUTO_INCREMENT NOT NULL,
  ruta VARCHAR(200) NOT NULL,
  cod_profesor BIGINT NOT NULL,
  cod_estudiante BIGINT,
  cod_tutor BIGINT,
  cod_estado INT NOT NULL,
  cod_area INT NOT NULL,
  id_tipo INT NOT NULL,
  id_materia INT NOT NULL,
  tamaño VARCHAR(10) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (cod_profesor) REFERENCES profesor (codigo),
  FOREIGN KEY (cod_estudiante) REFERENCES estudiante (codigo),
  FOREIGN KEY (cod_estado) REFERENCES estado (codigo),
  FOREIGN KEY (id_tipo) REFERENCES tipo_archivo (id),
  FOREIGN KEY (cod_tutor) REFERENCES tutor (codigo),
  FOREIGN KEY (id_materia) REFERENCES materia (id),
  FOREIGN KEY (cod_area) REFERENCES area (codigo)
) ENGINE=InnoDB;

-- Restaurar restricciones
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;