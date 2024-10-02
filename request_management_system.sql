-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-10-2024 a las 19:01:14
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
-- Base de datos: `request_management_system`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Gestión de Residuos', 'Departamento encargado de la gestión y manejo de residuos.'),
(2, 'Mantenimiento', 'Departamento encargado del mantenimiento de infraestructuras y equipos.'),
(3, 'Gestión de Residuos', 'Departamento encargado de la gestión y manejo de residuos.'),
(4, 'Mantenimiento', 'Departamento encargado del mantenimiento de infraestructuras y equipos.'),
(6, 'Cementerio', 'Area especifica para poder gestionar todos los asuntos relacionados con el Cementerio Municipal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `email`, `password`, `rol`) VALUES
(1, 'Juan', 'Pérez', 'juan.perez@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'Coordinador de Solicitudes'),
(2, 'María', 'Gómez', 'maria.gomez@example.com', '96b33694c4bb7dbd07391e0be54745fb', 'Técnico de Mantenimiento'),
(3, 'Juan', 'Pérez', 'juan.perez@example.com', '482c811da5d5b4bc6d497ffa98491e38', 'Coordinador de Solicitudes'),
(4, 'María', 'Gómez', 'maria.gomez@example.com', '96b33694c4bb7dbd07391e0be54745fb', 'Técnico de Mantenimiento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_solicitud`
--

CREATE TABLE `estados_solicitud` (
  `id` int(11) NOT NULL,
  `nombre_estado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados_solicitud`
--

INSERT INTO `estados_solicitud` (`id`, `nombre_estado`) VALUES
(1, 'Pendiente'),
(2, 'En Proceso'),
(3, 'Finalizado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportes`
--

CREATE TABLE `reportes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `area_id` int(11) NOT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'Open',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nombre_vecino` varchar(100) NOT NULL,
  `telefono_vecino` varchar(20) NOT NULL,
  `dpi_vecino` varchar(15) NOT NULL,
  `estado_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`id`, `titulo`, `descripcion`, `area_id`, `empleado_id`, `usuario_id`, `estado`, `fecha_creacion`, `fecha_actualizacion`, `nombre_vecino`, `telefono_vecino`, `dpi_vecino`, `estado_id`) VALUES
(1, 'Reparación de luz', 'Se necesita reparar la luz en el edificio principal. uwu', 2, 2, 1, 'Abierto', '2024-09-11 03:23:18', '2024-09-18 07:57:47', '', '', '', NULL),
(2, 'Reparacion de Tuberia', 'Reparacion en calle 111111111111111111112', 1, 1, 1, '4', '2024-09-14 14:27:53', '2024-10-01 17:31:07', 'Vecino de Prueba 1', '11223344', '1234567891234', 4),
(6, 'Reparacion de Postes electricos', 'Se cayo durante un temblor', 2, 1, 2, 'Open', '2024-09-15 02:11:46', '2024-09-14 18:11:46', '', '', '', NULL),
(7, 'Solicitud de Prueba :)', 'Pruebaaa', 1, 1, 3, 'Open', '2024-09-20 12:32:56', '2024-09-20 04:32:56', '', '', '', NULL),
(8, 'Prueba 2', 'PRUEBAAA 2', 2, 1, 3, 'Pendiente', '2024-09-21 06:12:53', '2024-09-20 22:12:53', '', '', '', NULL),
(10, 'PRUEBA 3', 'PRUEBAAAA 333', 3, 1, NULL, 'pendiente', '2024-09-21 07:26:28', '2024-09-20 23:26:28', 'Juan del Valle', '11223344', '123456789987', NULL),
(11, 'Prueba 4', 'PRUEBAAA 4', 6, 1, NULL, 'pendiente', '2024-09-21 07:52:45', '2024-10-01 16:28:02', 'Juan del Valle', '11223344', '123456789987', 5),
(13, 'PRUEBA 13', 'Descripcion prueba 13', 1, 2, NULL, 'pendiente', '2024-10-01 05:28:01', '2024-09-30 21:28:01', 'Vecino Prueba 13', '11223344', '1234567891234', NULL),
(14, 'Prueba 14', 'Descripcion prueba 15', 6, 1, NULL, 'Open', '2024-10-01 05:55:42', '2024-09-30 22:37:28', 'Vecino Prueba 14', '11223344', '1234567891234', NULL),
(15, 'Prueba 15', 'Descripcion Prueba 15 Editada x2', 4, 2, NULL, '', '2024-10-01 06:38:38', '2024-10-01 16:24:59', 'Vecino Prueba 15 ', '11223344', '1234567891234', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_archivos`
--

CREATE TABLE `solicitudes_archivos` (
  `id` int(11) NOT NULL,
  `solicitud_id` int(11) NOT NULL,
  `archivo` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes_archivos`
--

INSERT INTO `solicitudes_archivos` (`id`, `solicitud_id`, `archivo`, `descripcion`) VALUES
(1, 1, 'reparacion_luz.jpg', 'Imagen del área a reparar.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `rol`) VALUES
(1, 'Carlos', 'Martínez', 'carlos.martinez@example.com', 'c03437ea463eaa5cb316cff4faf35a70', 'administrador'),
(2, 'Ana', 'Hernández', 'ana.hernandez@example.com', '00cb8ad34ddd42883bcad09b27fddb79', 'usuario'),
(3, 'Javi', 'Herrera', 'javixxherrera@gmail.com', '$2y$10$Qut5MkhKZOY/4TL1X80q1.3RVkEFUjz23nlHfEH/5ebKIP3SXUM0i', 'admin'),
(4, 'Nery', 'Dubon', 'Nery@gmail.com', '$2y$10$AumWxhNNeDkOpWcXQMVe3.yXA251RoxS4Oi.eIrgDlLZXVzoOle/C', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estados_solicitud`
--
ALTER TABLE `estados_solicitud`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reportes`
--
ALTER TABLE `reportes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `area_id` (`area_id`),
  ADD KEY `empleado_id` (`empleado_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `solicitudes_archivos`
--
ALTER TABLE `solicitudes_archivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitud_id` (`solicitud_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estados_solicitud`
--
ALTER TABLE `estados_solicitud`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reportes`
--
ALTER TABLE `reportes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `solicitudes_archivos`
--
ALTER TABLE `solicitudes_archivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`),
  ADD CONSTRAINT `solicitudes_ibfk_2` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`),
  ADD CONSTRAINT `solicitudes_ibfk_3` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `solicitudes_archivos`
--
ALTER TABLE `solicitudes_archivos`
  ADD CONSTRAINT `solicitudes_archivos_ibfk_1` FOREIGN KEY (`solicitud_id`) REFERENCES `solicitudes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
