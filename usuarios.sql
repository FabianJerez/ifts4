-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-06-2025 a las 01:45:01
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
-- Base de datos: `ifts4`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('estudiante','profesor','administrativo') NOT NULL DEFAULT 'estudiante',
  `activo` tinyint(1) DEFAULT 1,
  `estado_aprobacion` enum('pendiente','aprobado','rechazado') DEFAULT 'aprobado',
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expira` bigint(20) DEFAULT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_suscripcion` datetime NOT NULL DEFAULT current_timestamp(),
  `unsuscribe_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `email`, `password`, `rol`, `activo`, `estado_aprobacion`, `reset_token`, `reset_expira`, `newsletter`, `fecha_suscripcion`, `unsuscribe_token`) VALUES
(1, 'Ana', 'García', 'ana.garcia@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-17 19:14:25', NULL),
(2, 'Luis', 'Pérez', 'luis.perez@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-17 19:16:35', NULL),
(3, 'Camila', 'Díaz', 'camila.diaz@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2020-06-15 19:04:48', NULL),
(4, 'Martín', 'Romero', 'martin.romero@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(5, 'Valeria', 'Torres', 'valeria.torres@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(6, 'Joaquín', 'López', 'joaquin.lopez@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(7, 'Sofía', 'Martínez', 'sofia.martinez@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(8, 'Federico', 'Morales', 'federico.morales@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(9, 'Lucía', 'Fernández', 'lucia.fernandez@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(10, 'Nicolás', 'Castro', 'nicolas.castro@ifts4.edu.ar', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(11, 'Carlos', 'Vega', 'carlos.vega@ifts4.edu.ar', '1234', 'profesor', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(12, 'María', 'Benítez', 'maria.benitez@ifts4.edu.ar', '1234', 'profesor', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(13, 'Administrador', 'General', 'admin@ifts4.edu.ar', '1234', 'administrativo', 1, 'aprobado', NULL, NULL, 0, '2025-06-14 13:03:40', NULL),
(14, 'fabian', 'jerez', 'jerezfabian@hotmail.com', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 1, '2025-06-15 12:31:34', '218f9171f8d8309d80165148f0171155'),
(15, 'daniel', 'ons', 'Scadaniel@hotmail.com', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 1, '2025-06-15 12:31:42', 'aa75765161e74742e254f19942a64475'),
(16, 'sergio', 'ottati', 'sergioottati@hotmail.com', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 1, '2025-06-14 22:15:07', '284fdd687c98c4c199941947170c82549ffc5c3b1edbdb976adc9598538cad47'),
(17, 'fabian ', 'jerez', 'prof.jerez@hotmail.com', '1234', 'profesor', 1, 'aprobado', NULL, NULL, 0, '2025-06-15 17:53:35', NULL),
(18, 'test1', 'test1', 'test1@hotmail.com', '1234', 'estudiante', 1, 'aprobado', NULL, NULL, 0, '2025-06-17 14:44:53', NULL),
(19, 'profe', 'test2', 'test2@hotmail.com', '1234', 'profesor', 1, 'aprobado', NULL, NULL, 0, '2025-06-17 14:45:32', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
