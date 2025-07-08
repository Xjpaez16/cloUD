-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-07-2025 a las 06:20:22
-- Versión del servidor: 10.4.32-MariaDB
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` bigint(20) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `clave` varchar(70) NOT NULL,
  `respuesta_preg` varchar(255) DEFAULT NULL,
  `id_admin` bigint(20) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `correo`, `nombre`, `clave`, `respuesta_preg`, `id_admin`, `activo`) VALUES
(3, 'paez@gmail.com', 'paez', '$2y$10$Y2olAMbBsNdAE9SUqDL03usuoVJaeOuKaKeVVuH0zSj0osCOm043e', 'ssdf', NULL, 1),
(4, 'maicol@gmail.com', 'marlon', '$2y$10$oDUnpMC0P2qoXdAAtOAJuu1MACyqg6ntzBplIlNtThcb6V2WCoxLC', '', NULL, 1),
(5, 'pepa@gmail.com', 'pio', '$2y$10$QY6aZnLzvIrBzanVgDD5/u1Xn.seOAbw0CktOU9uFGoBLYljcyy5K', 'popa', NULL, 1),
(6, 'prueba@gmail.com', 'prueba', '$2y$10$GmmF8TjLeHT4GNEvul9GQeLKTr2sSNmkKh0IizmxWxLHfcvrH4PTW', 'diavlo', NULL, 1),
(7, 'ad@cloud.com', 'admin', '$2y$10$t3lalQjM.7fmxqQWSS2vPuxuAZorKRjm3e66sYF/JUWmSrTSU9a7.', 'juan', NULL, 1),
(1233, 'miau@gmail.com', 'guau', '$2y$10$K9lK0kBeOQUtwc.j.Go3ien/LdO13N4m43/jWSP0z7mG5VhlzNuTa', 'guau', NULL, 1),
(23466, 'elpepe@gmail.com', 'elepé', '$2y$10$OKys7/YHTh5w5pe7xX0I8e.ZUyfAb7RkLhysWQ1CLFYDncrhjbkSa', 'miau', NULL, 1),
(20231578127, 'cris@gmail.com', 'ese soy yo', '$2y$10$PZ6S24tCV/4a1ULmpBLkze6d5D1LIyDw6sZ4v73aJyg/6oLY6u3xu', 'jiji', NULL, 1),
(20231578022, 'darinhpta@udistrital.edu.co', 'Darin Jairo Mosquera Palacios', 'Jpaez123.', 'pollolopepapin', NULL, 1),
(2023310, 'moises@udistrital.edu.co', 'tu marido moises', '$2y$10$K8qRc4TTyVrKfZMfHe3Xpe7xtDs1r0hF/cf3nxJUAWLLo0sMjueMO', 'lolapepapin', NULL, 1),
(1234, 'moi@udistrital.edu.co', 'Mosies', '$2y$10$3vzNxyO5NTLdSwHLAXpuC.LHG0NkQNv1rW2J3W2tLt4V.1Fx/Z2sy', 'perro', NULL, 1),
(2020, 'luis@udistrital.edu.co', 'Jose Luis', '$2y$10$SbRjO0pERs4fxzvvGbt.FO4mMkjqmDYFfi1zoHApFrsfeg0kMuDee', 'gato', NULL, 1),
(2025, 'ja@udistrital.edu.co', 'Juan', 'Clave123.', 'locas', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendar`
--

CREATE TABLE `agendar` (
  `id` int(11) NOT NULL,
  `cod_estudiante` bigint(20) NOT NULL,
  `cod_tutor` bigint(20) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_final` time NOT NULL,
  `cod_estado` int(11) NOT NULL,
  `cod_motivo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `agendar`
--

INSERT INTO `agendar` (`id`, `cod_estudiante`, `cod_tutor`, `fecha`, `hora_inicio`, `hora_final`, `cod_estado`, `cod_motivo`) VALUES
(15, 250051, 1234542, '2025-07-08', '10:00:00', '13:00:00', 6, 2),
(16, 250051, 1234542, '2025-07-14', '12:00:00', '14:00:00', 4, NULL),
(17, 250051, 112214, '2025-07-10', '12:00:00', '16:00:00', 4, NULL),
(18, 250051, 112214, '2025-07-10', '10:00:00', '12:00:00', 4, NULL),
(19, 2050, 112214, '2025-07-10', '08:00:00', '09:00:00', 4, NULL),
(20, 2050, 123344, '2025-07-07', '08:00:00', '09:00:00', 4, NULL),
(21, 2050, 123344, '2025-07-14', '10:00:00', '11:00:00', 4, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo`
--

CREATE TABLE `archivo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `ruta` varchar(200) NOT NULL,
  `cod_profesor` bigint(20) NOT NULL,
  `cod_estudiante` bigint(20) DEFAULT NULL,
  `cod_tutor` bigint(20) DEFAULT NULL,
  `cod_estado` int(11) NOT NULL,
  `cod_area` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `tamaño` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `archivo`
--

INSERT INTO `archivo` (`id`, `nombre`, `ruta`, `cod_profesor`, `cod_estudiante`, `cod_tutor`, `cod_estado`, `cod_area`, `id_tipo`, `id_materia`, `tamaño`) VALUES
(2, '(59)_bart_no_quiero_1374241522085527552.mp4', 'https://cloudgod.s3.us-east-2.amazonaws.com/uploads/%2859%29_bart_no_quiero_1374241522085527552.mp4', 1, 250051, NULL, 7, 2, 13, 8, '5751162'),
(3, 'Parcial 02.pdf', 'https://cloudgod.s3.us-east-2.amazonaws.com/uploads/Parcial%2002.pdf', 5, NULL, 123344, 7, 2, 1, 8, '1793778'),
(4, 'BDCLOUD MAS FINA QUE BEN 10.txt', 'https://cloudgod.s3.us-east-2.amazonaws.com/uploads/BDCLOUD%20MAS%20FINA%20QUE%20BEN%2010.txt', 36, NULL, 123344, 7, 3, 5, 14, '5664'),
(5, 'Ejercicios - Transformada de Laplace (2).pdf', 'https://cloudgod.s3.us-east-2.amazonaws.com/uploads/Ejercicios%20-%20Transformada%20de%20Laplace%20%282%29.pdf', 1, 250051, NULL, 8, 2, 1, 24, '96398');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `codigo` int(11) NOT NULL,
  `nombre_area` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`codigo`, `nombre_area`) VALUES
(1, 'Matemáticas'),
(2, 'Física'),
(3, 'Programación Práctica'),
(4, 'Teoría'),
(5, 'Arquitectura de Sistemas'),
(6, 'Redes'),
(7, 'Bases de Datos'),
(8, 'Textos'),
(9, 'Electivas'),
(10, 'BDD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_profesor`
--

CREATE TABLE `area_profesor` (
  `cod_profesor` bigint(20) NOT NULL,
  `cod_materia` int(11) NOT NULL,
  `cod_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `area_profesor`
--

INSERT INTO `area_profesor` (`cod_profesor`, `cod_materia`, `cod_area`) VALUES
(1, 8, 2),
(1, 24, 2),
(1, 77, 2),
(2, 45, 6),
(2, 61, 6),
(2, 62, 6),
(2, 64, 6),
(2, 80, 6),
(2, 90, 6),
(2, 91, 6),
(2, 92, 6),
(2, 96, 6),
(2, 97, 6),
(2, 99, 6),
(3, 6, 3),
(3, 13, 3),
(3, 14, 3),
(3, 26, 3),
(3, 42, 3),
(3, 48, 3),
(3, 49, 3),
(3, 63, 3),
(3, 67, 3),
(3, 71, 3),
(4, 51, 5),
(4, 52, 5),
(4, 68, 5),
(4, 75, 5),
(4, 81, 6),
(4, 85, 5),
(5, 8, 2),
(5, 24, 2),
(5, 77, 2),
(8, 1, 1),
(8, 3, 1),
(8, 7, 1),
(8, 9, 1),
(8, 29, 1),
(8, 30, 1),
(8, 69, 1),
(8, 72, 1),
(8, 74, 1),
(8, 79, 1),
(13, 27, 7),
(13, 46, 7),
(13, 70, 7),
(13, 94, 7),
(14, 76, 4),
(14, 82, 4),
(17, 69, 1),
(36, 14, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_tutor`
--

CREATE TABLE `area_tutor` (
  `cod_tutor` bigint(20) NOT NULL,
  `cod_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `area_tutor`
--

INSERT INTO `area_tutor` (`cod_tutor`, `cod_area`) VALUES
(2003, 1),
(2003, 4),
(2004, 3),
(2005, 5),
(2005, 6),
(2006, 2),
(2006, 3),
(2007, 3),
(2007, 4),
(2007, 5),
(112214, 1),
(123344, 3),
(123344, 4),
(123344, 7),
(1234542, 1),
(1234542, 2),
(1234542, 6),
(1234542, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrera`
--

CREATE TABLE `carrera` (
  `codigo` int(11) NOT NULL,
  `nombre_carrera` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `carrera`
--

INSERT INTO `carrera` (`codigo`, `nombre_carrera`) VALUES
(1, 'BDD'),
(578, 'Tecnología en Sistematización de Datos'),
(678, 'Ingeniería en Telemática');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dia`
--

CREATE TABLE `dia` (
  `id` int(11) NOT NULL,
  `dia` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `dia`
--

INSERT INTO `dia` (`id`, `dia`) VALUES
(1, 'Lunes'),
(2, 'Martes'),
(3, 'Miércoles'),
(4, 'Jueves'),
(5, 'Viernes'),
(6, 'Sábado'),
(7, 'Domingo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `disponibilidad`
--

CREATE TABLE `disponibilidad` (
  `cod_tutor` bigint(20) NOT NULL,
  `hora_i` time NOT NULL,
  `hora_fn` time NOT NULL,
  `id_horario` int(11) NOT NULL,
  `cod_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `disponibilidad`
--

INSERT INTO `disponibilidad` (`cod_tutor`, `hora_i`, `hora_fn`, `id_horario`, `cod_estado`) VALUES
(112214, '09:00:00', '10:00:00', 4, 7),
(112214, '10:00:00', '11:00:00', 3, 7),
(112214, '11:00:00', '12:00:00', 3, 7),
(123344, '09:00:00', '10:00:00', 5, 7),
(123344, '11:00:00', '12:00:00', 5, 7),
(1234542, '14:00:00', '15:00:00', 1, 7),
(1234542, '15:00:00', '16:00:00', 1, 7),
(1234542, '16:00:00', '17:00:00', 1, 7),
(1234542, '17:00:00', '18:00:00', 1, 7),
(112214, '08:00:00', '09:00:00', 4, 8),
(112214, '10:00:00', '11:00:00', 4, 8),
(112214, '11:00:00', '12:00:00', 4, 8),
(112214, '12:00:00', '13:00:00', 4, 8),
(112214, '13:00:00', '14:00:00', 4, 8),
(112214, '14:00:00', '15:00:00', 4, 8),
(112214, '15:00:00', '16:00:00', 4, 8),
(123344, '08:00:00', '09:00:00', 5, 8),
(123344, '10:00:00', '11:00:00', 5, 8),
(1234542, '10:00:00', '11:00:00', 2, 8),
(1234542, '11:00:00', '12:00:00', 2, 8),
(1234542, '12:00:00', '13:00:00', 1, 8),
(1234542, '12:00:00', '13:00:00', 2, 8),
(1234542, '13:00:00', '14:00:00', 1, 8),
(1234542, '13:00:00', '14:00:00', 2, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `codigo` int(11) NOT NULL,
  `tipo_estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`codigo`, `tipo_estado`) VALUES
(1, 'No verificado'),
(2, 'Verificado'),
(3, 'Baneado'),
(4, 'Pendiente'),
(5, 'Agendada'),
(6, 'Cancelada'),
(7, 'Disponible'),
(8, 'No Disponible'),
(9, 'BDD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `codigo` bigint(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contrasena` varchar(70) NOT NULL,
  `respuesta_preg` varchar(45) NOT NULL,
  `cod_carrera` int(11) NOT NULL,
  `cod_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`codigo`, `nombre`, `correo`, `contrasena`, `respuesta_preg`, `cod_carrera`, `cod_estado`) VALUES
(2050, 'Juan Gutierrez', 'j@udistrital.edu.co', '$2y$10$UVNYIjLTG5e8.kwwxovOkePMg315yERLADz01HgFs5kVi.mp3CW0q', 'paezmargarita', 578, 2),
(250051, 'JPAEZ', 'jdpaezs@udistrital.edu.co', '$2y$10$IPn/pnVrLKB4dox7aNuE0Ob4.8LplCZumb5pM5k45dBVdQJ60eYxm', 'Zeusnelly', 678, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id` int(11) NOT NULL,
  `id_dia` int(11) NOT NULL,
  `cod_tutor` bigint(20) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id`, `id_dia`, `cod_tutor`, `hora_inicio`, `hora_fin`) VALUES
(1, 1, 1234542, '12:00:00', '18:00:00'),
(2, 2, 1234542, '10:00:00', '14:00:00'),
(3, 2, 112214, '10:00:00', '12:00:00'),
(4, 4, 112214, '08:00:00', '16:00:00'),
(5, 1, 123344, '08:00:00', '12:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE `materia` (
  `id` int(11) NOT NULL,
  `nombre_materia` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `materia`
--

INSERT INTO `materia` (`id`, `nombre_materia`) VALUES
(1, 'Cálculo Diferencial'),
(2, 'Cátedra Francisco José de Caldas'),
(3, 'Álgebra Lineal'),
(4, 'Cátedra Democracia y Ciudadanía'),
(5, 'Producción y Comprensión de Textos I'),
(6, 'Introducción a Algoritmos'),
(7, 'Lógica Matemática'),
(8, 'Física I: Mecánica Newtoniana'),
(9, 'Cálculo Integral'),
(10, 'Producción y Comprensión de Textos II'),
(11, 'Administración'),
(12, 'Cátedra de Contexto'),
(13, 'Estructura de Datos'),
(14, 'Programación Orientada a Objetos'),
(15, 'Electiva Económico-Administrativa I'),
(16, 'Contabilidad General'),
(17, 'Fundamentos de Organización'),
(18, 'Segunda Lengua I - Inglés'),
(19, 'Segunda Lengua I - Francés'),
(20, 'Segunda Lengua I - Alemán'),
(21, 'Segunda Lengua I - Italiano'),
(22, 'Segunda Lengua I - Portugués'),
(23, 'Segunda Lengua I - Mandarín'),
(24, 'Física II: Electromagnetismo'),
(25, 'Ciencia Tecnología y Sociedad'),
(26, 'Programación Multinivel'),
(27, 'Bases de Datos'),
(28, 'Electiva Ciencias Básicas I'),
(29, 'Matemáticas Especiales'),
(30, 'Análisis y Métodos Numéricos'),
(31, 'Electiva Económico-Administrativa II'),
(32, 'Fundamentos de Economía'),
(33, 'Tic\'s en las Organizaciones'),
(34, 'Emprendimiento'),
(35, 'Segunda Lengua II - Inglés'),
(36, 'Segunda Lengua II - Francés'),
(37, 'Segunda Lengua II - Alemán'),
(38, 'Segunda Lengua II - Italiano'),
(39, 'Segunda Lengua II - Portugués'),
(40, 'Segunda Lengua II - Mandarín'),
(41, 'Ética y Sociedad'),
(42, 'Programación Avanzada'),
(43, 'Diseño Lógico'),
(44, 'Electiva Profesional I'),
(45, 'Transmisión de Datos'),
(46, 'Bases de Datos Distribuidas'),
(47, 'Electiva Profesional II'),
(48, 'Programación Web'),
(49, 'Aplicaciones para Internet'),
(50, 'Análisis Social Colombiano'),
(51, 'Análisis de Sistemas'),
(52, 'Sistemas Operacionales'),
(53, 'Taller de Investigación'),
(54, 'Segunda Lengua III - Inglés'),
(55, 'Segunda Lengua III - Francés'),
(56, 'Segunda Lengua III - Alemán'),
(57, 'Segunda Lengua III - Italiano'),
(58, 'Segunda Lengua III - Portugués'),
(59, 'Segunda Lengua III - Mandarín'),
(60, 'Electiva Profesional III'),
(61, 'Fundamentos de Telemática'),
(62, 'Protocolos de Comunicación'),
(63, 'Programación por Componentes'),
(64, 'Regulación para Telecomunicaciones'),
(65, 'Globalización'),
(66, 'Trabajo de Grado Tecnológico'),
(67, 'Inteligencia Artificial'),
(68, 'Arquitectura de Computadores'),
(69, 'Ecuaciones Diferenciales'),
(70, 'Bases de Datos Avanzadas'),
(71, 'Ingeniería de Software'),
(72, 'Cálculo Multivariado'),
(73, 'Ingeniería Económica'),
(74, 'Probabilidad y Estadística'),
(75, 'Sistemas Distribuidos'),
(76, 'Teoría General de Sistemas'),
(77, 'Física III: Ondas y Física Moderna'),
(78, 'Formulación y Evaluación de Proyectos'),
(79, 'Análisis de Fourier'),
(80, 'Redes Corporativas'),
(81, 'Sistemas Abiertos'),
(82, 'Teoría de la Información'),
(83, 'Electiva Ciencias Básicas II'),
(84, 'Computación Cuántica'),
(85, 'Simulación de Sistemas Dinámicos'),
(86, 'Electiva Ciencias Básicas III'),
(87, 'Criptología'),
(88, 'Investigación de Operaciones'),
(89, 'Trabajo de Grado I'),
(90, 'Planificación y Diseño de Redes'),
(91, 'Redes de Alta Velocidad'),
(92, 'Seguridad en Redes'),
(93, 'Electiva Económico-Administrativa III'),
(94, 'Análisis de Datos'),
(95, 'Bioinformática'),
(96, 'Seminario de Telemática'),
(97, 'Redes Inalámbricas'),
(98, 'Trabajo de Grado II'),
(99, 'Gerencia y Auditoría en Redes'),
(100, 'Web'),
(101, 'BDD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo`
--

CREATE TABLE `motivo` (
  `codigo` int(11) NOT NULL,
  `tipo_motivo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `motivo`
--

INSERT INTO `motivo` (`codigo`, `tipo_motivo`) VALUES
(1, 'Problemas personales'),
(2, 'Inconvenientes de salud'),
(3, 'Problemas de conectividad'),
(4, 'Cambio de horario'),
(5, 'Motivo académico'),
(6, 'Cancelación por el tutor'),
(7, 'Cancelación por el estudiante'),
(8, 'Otro'),
(9, 'Visual'),
(10, 'BDD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE `profesor` (
  `codigo` bigint(20) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`codigo`, `nombre`) VALUES
(1, 'David Leonardo Cañas Varón'),
(2, 'Diego Fernando Huertas Márquez'),
(3, 'Jorge Eduardo Hernández Rodríguez'),
(4, 'Oscar Gabriel Espejo Mojica'),
(5, 'Ximena Audrey Velásquez Moya'),
(6, 'Nelson Armando Vargas Sánchez'),
(7, 'Karol Yobany Ubaque Brito'),
(8, 'Luis Carlos Rojas Obando'),
(9, 'Dairo Giovanni Rocha Castellanos'),
(10, 'Javier Orlando Daza Torres'),
(11, 'Óscar Enrique Benavides Vega'),
(12, 'Noé Arcos Muñoz'),
(13, 'Ismael Antonio Ardila'),
(14, 'John Fredy Zabala Álvarez'),
(15, 'Juan Carlos Salazar Guadrón'),
(16, 'Nelly Paola Palma Vanegas'),
(17, 'Diana Isabel Martínez Buitrago'),
(18, 'William Bautista Herrera'),
(19, 'Jesús Manuel Paternina Durán'),
(20, 'Jairo Hernández Gutiérrez'),
(21, 'Mireya Bernal Gómez'),
(22, 'Carlos Alberto Vanegas'),
(23, 'Roberto Emilio Salas Ruiz'),
(24, 'Mariluz Romero García'),
(25, 'Jorge Enrique Rodríguez Rodríguez'),
(26, 'José Vicente Reyes Mozo'),
(27, 'Sonia Alexandra Pinzón Núñez'),
(28, 'Marlon Patiño Bernal'),
(29, 'Norberto Novoa Torres'),
(30, 'Wilman Enrique Navarro Mejía'),
(31, 'Luis Felipe Wanumen Silva'),
(32, 'Darin Jairo Mosquera Palacios'),
(33, 'Miguel Ángel Leguizamón Páez'),
(34, 'Juan Carlos Guevara Bolaños'),
(35, 'Miller Gómez Mora'),
(36, 'Héctor Julio Fuquene Ardila'),
(37, 'Héctor Arturo Flórez Fernández'),
(38, 'Gloria Andrea Cavanzo Nisso'),
(39, 'Gerardo Alberto Castang Montiel'),
(40, 'Nelson Reynaldo Becerra Corre'),
(41, 'Andrés Ernesto Mejía Villamil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_archivo`
--

CREATE TABLE `tipo_archivo` (
  `id` int(11) NOT NULL,
  `nombre_tipo` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tipo_archivo`
--

INSERT INTO `tipo_archivo` (`id`, `nombre_tipo`) VALUES
(1, 'PDF'),
(2, 'DOCX'),
(3, 'PPTX'),
(4, 'XLSX'),
(5, 'TXT'),
(6, 'CSV'),
(7, 'JPG'),
(8, 'PNG'),
(9, 'GIF'),
(10, 'ZIP'),
(11, 'RAR'),
(12, '7Z'),
(13, 'MP4'),
(14, 'MP3'),
(15, 'HTML'),
(16, 'CSS'),
(17, 'JS'),
(18, 'PHP'),
(19, 'JAVA'),
(20, 'PY'),
(21, 'C'),
(22, 'CPP'),
(23, 'SQL'),
(24, 'JSON'),
(25, 'XML'),
(26, 'ANA'),
(27, 'BDD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tutor`
--

CREATE TABLE `tutor` (
  `codigo` bigint(20) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `contrasena` varchar(70) NOT NULL,
  `calificacion_general` decimal(2,1) DEFAULT NULL,
  `respuesta_preg` varchar(45) NOT NULL,
  `cod_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tutor`
--

INSERT INTO `tutor` (`codigo`, `nombre`, `correo`, `contrasena`, `calificacion_general`, `respuesta_preg`, `cod_estado`) VALUES
(2001, 'Carlos Ramírez', 'carlosramirez@cloud.com', 'PassTutor1', NULL, 'LunaBeatriz', 2),
(2002, 'María Fernández', 'mariafernandez@cloud.com', 'PassTutor2', NULL, 'TobyLucia', 2),
(2003, 'Andrés López', 'andreslopez@cloud.com', 'PassTutor3', NULL, 'SimbaGloria', 2),
(2004, 'Paola Martínez', 'paola.martinez@cloud.com', 'PassTutor4', NULL, 'ZeusVictoria', 2),
(2005, 'Santiago Herrera', 'santiago.herrera@cloud.com', 'PassTutor5', NULL, 'LolaPatricia', 2),
(2006, 'Camila Torres', 'camila.torres@cloud.com', 'PassTutor6', NULL, 'RexJuana', 2),
(2007, 'Luis Castillo', 'luis.castillo@cloud.com', 'PassTutor7', NULL, 'NinaDolores', 2),
(112214, 'Dianitasech', 'diana@udistrital.edu.co', '$2y$10$UPLVMGjFticudBv6vdlkluyDQoGN9z/HWWukMi17VUMLXeLmLtFay', NULL, 'CastiblancoYutakeuchi', 2),
(123344, 'Jpbrown', 'jpaeztutor@udistrital.edu.co', '$2y$10$xeg7HgycguoWrJfPl51vaeUZsdmQ1MPSDHILBx9G.XW66iz6tU8LC', 5.0, 'perrolola', 2),
(1234542, 'andreshpta', 'andreshpta@udistrital.edu.co', '$2y$10$SJmoS/2CkVfGGKBxhPfMGuorFHKI5Xsjg/VH6kv15jZMw9PbLGkou', NULL, 'perrohpta', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agendar`
--
ALTER TABLE `agendar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_estudiante` (`cod_estudiante`),
  ADD KEY `cod_tutor` (`cod_tutor`),
  ADD KEY `cod_estado` (`cod_estado`),
  ADD KEY `cod_motivo` (`cod_motivo`);

--
-- Indices de la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_profesor` (`cod_profesor`),
  ADD KEY `cod_estudiante` (`cod_estudiante`),
  ADD KEY `cod_estado` (`cod_estado`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `cod_tutor` (`cod_tutor`),
  ADD KEY `id_materia` (`id_materia`),
  ADD KEY `cod_area` (`cod_area`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `area_profesor`
--
ALTER TABLE `area_profesor`
  ADD PRIMARY KEY (`cod_profesor`,`cod_materia`,`cod_area`),
  ADD KEY `cod_area` (`cod_area`),
  ADD KEY `cod_materia` (`cod_materia`);

--
-- Indices de la tabla `area_tutor`
--
ALTER TABLE `area_tutor`
  ADD PRIMARY KEY (`cod_tutor`,`cod_area`),
  ADD KEY `cod_area` (`cod_area`);

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
  ADD PRIMARY KEY (`cod_tutor`,`hora_i`,`hora_fn`,`id_horario`),
  ADD KEY `id_horario` (`id_horario`),
  ADD KEY `cod_estado` (`cod_estado`);

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
  ADD KEY `cod_carrera` (`cod_carrera`),
  ADD KEY `cod_estado` (`cod_estado`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dia` (`id_dia`),
  ADD KEY `cod_tutor` (`cod_tutor`);

--
-- Indices de la tabla `materia`
--
ALTER TABLE `materia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `motivo`
--
ALTER TABLE `motivo`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `tipo_archivo`
--
ALTER TABLE `tipo_archivo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `cod_estado` (`cod_estado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agendar`
--
ALTER TABLE `agendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `archivo`
--
ALTER TABLE `archivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `carrera`
--
ALTER TABLE `carrera`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=679;

--
-- AUTO_INCREMENT de la tabla `dia`
--
ALTER TABLE `dia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `materia`
--
ALTER TABLE `materia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `agendar`
--
ALTER TABLE `agendar`
  ADD CONSTRAINT `agendar_ibfk_1` FOREIGN KEY (`cod_estudiante`) REFERENCES `estudiante` (`codigo`),
  ADD CONSTRAINT `agendar_ibfk_2` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`),
  ADD CONSTRAINT `agendar_ibfk_3` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`),
  ADD CONSTRAINT `agendar_ibfk_4` FOREIGN KEY (`cod_motivo`) REFERENCES `motivo` (`codigo`);

--
-- Filtros para la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `archivo_ibfk_1` FOREIGN KEY (`cod_profesor`) REFERENCES `profesor` (`codigo`),
  ADD CONSTRAINT `archivo_ibfk_2` FOREIGN KEY (`cod_estudiante`) REFERENCES `estudiante` (`codigo`),
  ADD CONSTRAINT `archivo_ibfk_3` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`),
  ADD CONSTRAINT `archivo_ibfk_4` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_archivo` (`id`),
  ADD CONSTRAINT `archivo_ibfk_5` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`),
  ADD CONSTRAINT `archivo_ibfk_6` FOREIGN KEY (`id_materia`) REFERENCES `materia` (`id`),
  ADD CONSTRAINT `archivo_ibfk_7` FOREIGN KEY (`cod_area`) REFERENCES `area` (`codigo`);

--
-- Filtros para la tabla `area_profesor`
--
ALTER TABLE `area_profesor`
  ADD CONSTRAINT `area_profesor_ibfk_1` FOREIGN KEY (`cod_profesor`) REFERENCES `profesor` (`codigo`),
  ADD CONSTRAINT `area_profesor_ibfk_2` FOREIGN KEY (`cod_area`) REFERENCES `area` (`codigo`),
  ADD CONSTRAINT `area_profesor_ibfk_3` FOREIGN KEY (`cod_materia`) REFERENCES `materia` (`id`);

--
-- Filtros para la tabla `area_tutor`
--
ALTER TABLE `area_tutor`
  ADD CONSTRAINT `area_tutor_ibfk_1` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`),
  ADD CONSTRAINT `area_tutor_ibfk_2` FOREIGN KEY (`cod_area`) REFERENCES `area` (`codigo`);

--
-- Filtros para la tabla `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD CONSTRAINT `disponibilidad_ibfk_1` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`),
  ADD CONSTRAINT `disponibilidad_ibfk_2` FOREIGN KEY (`id_horario`) REFERENCES `horario` (`id`),
  ADD CONSTRAINT `disponibilidad_ibfk_3` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`);

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`cod_carrera`) REFERENCES `carrera` (`codigo`),
  ADD CONSTRAINT `estudiante_ibfk_2` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_dia`) REFERENCES `dia` (`id`),
  ADD CONSTRAINT `horario_ibfk_2` FOREIGN KEY (`cod_tutor`) REFERENCES `tutor` (`codigo`);

--
-- Filtros para la tabla `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`cod_estado`) REFERENCES `estado` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
