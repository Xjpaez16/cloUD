-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 09-06-2025 a las 19:31:42
-- Versión del servidor: 8.0.42
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cloud`
--
CREATE DATABASE IF NOT EXISTS `cloud` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `cloud`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int NOT NULL,
  `correo` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendar`
--

CREATE TABLE `agendar` (
  `cod_estudiante` int NOT NULL,
  `cod_tutor` int NOT NULL,
  `id` int NOT NULL,
  `calf_tutoria` decimal(1,1) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_final` time NOT NULL,
  `cod_estado` int NOT NULL,
  `cod_motivo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo`
--

CREATE TABLE `archivo` (
  `id` int NOT NULL,
  `ruta` varchar(200) NOT NULL,
  `cod_profesor` int NOT NULL,
  `cod_estudiante` int NOT NULL,
  `cod_estado` int NOT NULL,
  `id_tipo` int NOT NULL,
  `id_materia` int NOT NULL,
  `tamaño` varchar(10) NOT NULL,
  `cod_area` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `codigo` int NOT NULL,
  `nombre_area` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_profesor`
--

CREATE TABLE `area_profesor` (
  `cod_profesor` int NOT NULL,
  `cod_area` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_tutor`
--

CREATE TABLE `area_tutor` (
  `cod_tutor` int NOT NULL,
  `cod_area` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `codigo` int NOT NULL,
  `nombre_carrera` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dia`
--

CREATE TABLE `dia` (
  `id` int NOT NULL,
  `dia` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad`
--

CREATE TABLE `disponibilidad` (
  `cod_tutor` int NOT NULL,
  `hora_i` time NOT NULL,
  `hora_fn` time NOT NULL,
  `fecha` date NOT NULL,
  `id_horario` int NOT NULL,
  `cod_estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `codigo` int NOT NULL,
  `tipo_estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `codigo` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contraseña` varchar(45) NOT NULL,
  `respuesta_preg` varchar(45) NOT NULL,
  `cod_carrera` int NOT NULL,
  `cod_estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id` int NOT NULL,
  `id_dia` int NOT NULL,
  `cod_tutor` int NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id` int NOT NULL,
  `nombre_materia` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modificar`
--

CREATE TABLE `modificar` (
  `cod_admin` int NOT NULL,
  `cod_agendar` int NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo`
--

CREATE TABLE `motivo` (
  `codigo` int NOT NULL,
  `tipo_motivo` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `codigo` int NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id` int NOT NULL,
  `nombre_tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor`
--

CREATE TABLE `tutor` (
  `codigo` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contrasena` varchar(45) NOT NULL,
  `calificacion_general` decimal(1,1) DEFAULT NULL,
  `respuesta_preg` varchar(45) DEFAULT NULL,
  `cod_estado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `agendar`
--
ALTER TABLE `agendar`
  ADD PRIMARY KEY (`cod_estudiante`,`cod_tutor`,`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `cod_estado_idx` (`cod_estado`),
  ADD KEY `cod_tutor_idx` (`cod_tutor`),
  ADD KEY `cod_motivo_idx` (`cod_motivo`);

--
-- Indices de la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_profesor_idx` (`cod_profesor`),
  ADD KEY `cod_estado_idx` (`cod_estado`),
  ADD KEY `id_tipo_idx` (`id_tipo`),
  ADD KEY `id_materia_idx` (`id_materia`),
  ADD KEY `cod_estudiante_idx` (`cod_estudiante`),
  ADD KEY `cod_area_idx` (`cod_area`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `area_profesor`
--
ALTER TABLE `area_profesor`
  ADD PRIMARY KEY (`cod_profesor`,`cod_area`),
  ADD KEY `cod_area_idx` (`cod_area`);

--
-- Indices de la tabla `area_tutor`
--
ALTER TABLE `area_tutor`
  ADD PRIMARY KEY (`cod_tutor`,`cod_area`),
  ADD KEY `cod_area_idx` (`cod_area`);

--
-- Indices de la tabla `carrera`
--
ALTER TABLE `carrera`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `dia`
--
ALTER TABLE `dia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD PRIMARY KEY (`cod_tutor`,`hora_i`,`hora_fn`,`fecha`,`id_horario`),
  ADD KEY `cod_estado_idx` (`cod_estado`),
  ADD KEY `id_horario_idx` (`id_horario`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_carrera_idx` (`cod_carrera`),
  ADD KEY `fk_estudiante_cod_estado` (`cod_estado`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dia_idx` (`id_dia`),
  ADD KEY `cod_tutor_idx` (`cod_tutor`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `modificar`
--
ALTER TABLE `modificar`
  ADD PRIMARY KEY (`cod_admin`,`cod_agendar`),
  ADD KEY `cod_agendar_idx` (`cod_agendar`);

--
-- Indices de la tabla `motivo`
--
ALTER TABLE `motivo`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`codigo`,`nombre`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `fk_tutor_cod_estado` (`cod_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agendar`
--
ALTER TABLE `agendar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `archivo`
--
ALTER TABLE `archivo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agendar`
--
ALTER TABLE `agendar`
  ADD CONSTRAINT `fk_agendar_cod_estado` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`),
  ADD CONSTRAINT `fk_agendar_cod_estudiante` FOREIGN KEY (`cod_estudiante`) REFERENCES `estudiante` (`codigo`),
  ADD CONSTRAINT `fk_agendar_cod_motivo` FOREIGN KEY (`cod_motivo`) REFERENCES `motivo` (`codigo`),
  ADD CONSTRAINT `fk_agendar_cod_tutor` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`);

--
-- Filtros para la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `fk_archivo_cod_area` FOREIGN KEY (`cod_area`) REFERENCES `area` (`codigo`),
  ADD CONSTRAINT `fk_archivo_cod_estado` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`),
  ADD CONSTRAINT `fk_archivo_cod_estudiante` FOREIGN KEY (`cod_estudiante`) REFERENCES `estudiante` (`codigo`),
  ADD CONSTRAINT `fk_archivo_cod_profesor` FOREIGN KEY (`cod_profesor`) REFERENCES `profesor` (`codigo`),
  ADD CONSTRAINT `fk_archivo_id_materia` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `fk_archivo_id_tipo` FOREIGN KEY (`id_tipo`) REFERENCES `tipo` (`id`);

--
-- Filtros para la tabla `area_profesor`
--
ALTER TABLE `area_profesor`
  ADD CONSTRAINT `fk_area_profesor_cod_area` FOREIGN KEY (`cod_area`) REFERENCES `area` (`codigo`),
  ADD CONSTRAINT `fk_area_profesor_cod_profesor` FOREIGN KEY (`cod_profesor`) REFERENCES `profesor` (`codigo`);

--
-- Filtros para la tabla `area_tutor`
--
ALTER TABLE `area_tutor`
  ADD CONSTRAINT `fk_area_tutor_cod_area` FOREIGN KEY (`cod_area`) REFERENCES `area` (`codigo`),
  ADD CONSTRAINT `fk_area_tutor_cod_tutor` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`);

--
-- Filtros para la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD CONSTRAINT `fk_disponibilidad_cod_estado` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`),
  ADD CONSTRAINT `fk_disponibilidad_cod_tutor` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`),
  ADD CONSTRAINT `fk_disponibilidad_id_horario` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `fk_estudiante_cod_carrera` FOREIGN KEY (`cod_carrera`) REFERENCES `carrera` (`codigo`),
  ADD CONSTRAINT `fk_estudiante_cod_estado` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `fk_horario_cod_tutor` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`),
  ADD CONSTRAINT `fk_horario_id_dia` FOREIGN KEY (`id_dia`) REFERENCES `dia` (`id`);

--
-- Filtros para la tabla `modificar`
--
ALTER TABLE `modificar`
  ADD CONSTRAINT `fk_modificar_cod_admin` FOREIGN KEY (`cod_admin`) REFERENCES `administrador` (`id`),
  ADD CONSTRAINT `fk_modificar_cod_agendar` FOREIGN KEY (`cod_agendar`) REFERENCES `agendar` (`id`);

--
-- Filtros para la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `fk_tutor_cod_estado` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
