-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2025 a las 16:06:20
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
-- Base de datos: `raci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accidente`
--

CREATE TABLE `accidente` (
  `id_accidente` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `clasificacion` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `tipo_vinc_lab_` varchar(50) DEFAULT NULL,
  `jornada_laboral` varchar(50) DEFAULT NULL,
  `turno_mom_acc` varchar(50) DEFAULT NULL,
  `uso_epp` text DEFAULT NULL,
  `consecuencias` varchar(100) DEFAULT NULL,
  `gravedad` varchar(50) DEFAULT NULL,
  `tipo_lesion` varchar(50) DEFAULT NULL,
  `parte_cuerpo_afect` varchar(50) DEFAULT NULL,
  `incapacidad_lab` varchar(50) DEFAULT NULL,
  `aten_med_recibida` text DEFAULT NULL,
  `persona_informo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `area_id_area` int(11) DEFAULT NULL,
  `user_num_doc` int(11) DEFAULT NULL,
  `empleado_id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_insegura`
--

CREATE TABLE `condicion_insegura` (
  `id_cond_inseg` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `tipo_doc` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` int(11) DEFAULT NULL,
  `eps` varchar(50) DEFAULT NULL,
  `arl` varchar(50) DEFAULT NULL,
  `cargo_funcion` varchar(100) DEFAULT NULL,
  `antig_cargo` varchar(50) DEFAULT NULL,
  `rol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidente`
--

CREATE TABLE `incidente` (
  `id_incidente` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `tipo_vinc_lab` varchar(50) DEFAULT NULL,
  `jornada_laboral` varchar(50) DEFAULT NULL,
  `turno_mom_inc` varchar(50) DEFAULT NULL,
  `uso_epp` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspeccion_locativa`
--

CREATE TABLE `inspeccion_locativa` (
  `id_insp_loc` int(11) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `tipo_inspeccion` varchar(50) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `act_economica` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado_inspeccion` varchar(50) DEFAULT NULL,
  `element_trab` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `categoria_id_categoria` int(11) DEFAULT NULL,
  `incidente_id_incidente` int(11) DEFAULT NULL,
  `accidente_id_accidente` int(11) DEFAULT NULL,
  `riesgo_id_riesgo` int(11) DEFAULT NULL,
  `reporte_id_reporte` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `riesgo`
--

CREATE TABLE `riesgo` (
  `id_riesgo` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `condicion_insegura_id_cond_inseg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_Rol` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id_Rol`, `nombre`) VALUES
(1, 'admin'),
(2, 'supervisor'),
(3, 'coordinador'),
(4, 'trabajador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `num_doc` int(11) NOT NULL,
  `tipo_doc` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `rol` int(11) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`num_doc`, `tipo_doc`, `nombres`, `apellidos`, `rol`, `contrasena`, `telefono`) VALUES
(1, 'CC', 'admin', 'Administrador', 1, '$2y$10$dg3H63QM9Or7hbEGOTaV5O0B1yyMTNSPzxu6qMYCvDPF.488ggMVm', 123456789),
(2, 'CC', 'super', 'Supervisor', 2, '$2y$10$K1uQk1uQk1uQk1uQk1uQkOeQk1uQk1uQk1uQk1uQk1uQk1uQk1uQk1uQk1uQk1uQk1u', 234567890),
(3, 'CC', 'coord', 'Coordinador', 3, '$2y$10$A1bC2dE3fG4hI5jK6lM7nOePqRsTuVwXyZ0123456789abcdefgHIJKL', 345678901),
(4, 'CC', 'traba', 'Trabajador', 4, '$2y$10$Z9yX8wV7uT6sR5qP4oN3mLeKjIhGfEdCbA0987654321zyxwvutsrqp', 456789012);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accidente`
--
ALTER TABLE `accidente`
  ADD PRIMARY KEY (`id_accidente`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`),
  ADD KEY `area_id_area` (`area_id_area`),
  ADD KEY `user_num_doc` (`user_num_doc`),
  ADD KEY `empleado_id_empleado` (`empleado_id_empleado`);

--
-- Indices de la tabla `condicion_insegura`
--
ALTER TABLE `condicion_insegura`
  ADD PRIMARY KEY (`id_cond_inseg`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `rol` (`rol`);

--
-- Indices de la tabla `incidente`
--
ALTER TABLE `incidente`
  ADD PRIMARY KEY (`id_incidente`);

--
-- Indices de la tabla `inspeccion_locativa`
--
ALTER TABLE `inspeccion_locativa`
  ADD PRIMARY KEY (`id_insp_loc`),
  ADD KEY `categoria_id_categoria` (`categoria_id_categoria`),
  ADD KEY `incidente_id_incidente` (`incidente_id_incidente`),
  ADD KEY `accidente_id_accidente` (`accidente_id_accidente`),
  ADD KEY `riesgo_id_riesgo` (`riesgo_id_riesgo`),
  ADD KEY `reporte_id_reporte` (`reporte_id_reporte`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id_reporte`);

--
-- Indices de la tabla `riesgo`
--
ALTER TABLE `riesgo`
  ADD PRIMARY KEY (`id_riesgo`),
  ADD KEY `condicion_insegura_id_cond_inseg` (`condicion_insegura_id_cond_inseg`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_Rol`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`num_doc`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `accidente`
--
ALTER TABLE `accidente`
  MODIFY `id_accidente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `condicion_insegura`
--
ALTER TABLE `condicion_insegura`
  MODIFY `id_cond_inseg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidente`
--
ALTER TABLE `incidente`
  MODIFY `id_incidente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inspeccion_locativa`
--
ALTER TABLE `inspeccion_locativa`
  MODIFY `id_insp_loc` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `riesgo`
--
ALTER TABLE `riesgo`
  MODIFY `id_riesgo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `categoria_ibfk_2` FOREIGN KEY (`user_num_doc`) REFERENCES `user` (`num_doc`),
  ADD CONSTRAINT `categoria_ibfk_3` FOREIGN KEY (`empleado_id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_Rol`);

--
-- Filtros para la tabla `inspeccion_locativa`
--
ALTER TABLE `inspeccion_locativa`
  ADD CONSTRAINT `inspeccion_locativa_ibfk_1` FOREIGN KEY (`categoria_id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_2` FOREIGN KEY (`incidente_id_incidente`) REFERENCES `incidente` (`id_incidente`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_3` FOREIGN KEY (`accidente_id_accidente`) REFERENCES `accidente` (`id_accidente`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_4` FOREIGN KEY (`riesgo_id_riesgo`) REFERENCES `riesgo` (`id_riesgo`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_5` FOREIGN KEY (`reporte_id_reporte`) REFERENCES `reporte` (`id_reporte`);

--
-- Filtros para la tabla `riesgo`
--
ALTER TABLE `riesgo`
  ADD CONSTRAINT `riesgo_ibfk_1` FOREIGN KEY (`condicion_insegura_id_cond_inseg`) REFERENCES `condicion_insegura` (`id_cond_inseg`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_Rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
