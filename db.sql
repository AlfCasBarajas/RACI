-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-12-2025 a las 00:54:01
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

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
  `persona_informo` varchar(100) DEFAULT NULL,
  `area_id_area` int(11) DEFAULT NULL,
  `empleado_id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `accidente`
--

INSERT INTO `accidente` (`id_accidente`, `tipo`, `descripcion`, `clasificacion`, `estado`, `fecha_hora`, `lugar`, `tipo_vinc_lab_`, `jornada_laboral`, `turno_mom_acc`, `uso_epp`, `consecuencias`, `gravedad`, `tipo_lesion`, `parte_cuerpo_afect`, `incapacidad_lab`, `aten_med_recibida`, `persona_informo`, `area_id_area`, `empleado_id_empleado`) VALUES
(1, 'Caída', 'Caída en pasillo por piso mojado', 'Leve', 'Cerrado', '2025-09-01 08:00:00', 'Pasillo principal', 'Directo', 'Diurna', 'Mañana', 'Zapatos antideslizantes', 'Contusión menor', 'Leve', 'Contusión', 'Pierna derecha', 'No', 'Observación médica', 'Juan Pérez', 1, 2),
(2, 'Corte', 'Corte con herramienta defectuosa', 'Moderado', 'Abierto', '2025-09-02 09:30:00', 'Taller de mantenimiento', 'Contratista', 'Nocturna', 'Noche', 'Guantes de seguridad', 'Herida profunda', 'Moderada', 'Herida cortante', 'Mano izquierda', 'Sí', 'Sutura y antibióticos', 'Luis Martínez', 3, 3),
(3, 'Golpe', 'Golpe con objeto en almacén', 'Leve', 'Cerrado', '2025-09-03 10:15:00', 'Almacén general', 'Directo', 'Diurna', 'Tarde', 'Casco de seguridad', 'Contusión leve', 'Leve', 'Contusión', 'Cabeza', 'No', 'Analgésicos', 'Sofía López', 5, 4),
(4, 'Resbalón', 'Resbalón en oficina administrativa', 'Leve', 'Cerrado', '2025-09-04 11:00:00', 'Oficina administrativa', 'Directo', 'Diurna', 'Mañana', 'Zapatos de oficina', 'Contusión menor', 'Leve', 'Contusión', 'Brazo derecho', 'No', 'Hielo y reposo', 'Ana García', 1, 2),
(5, 'Lesión ergonómica', 'Lesión muscular por mala postura', 'Moderado', 'Abierto', '2025-09-05 12:45:00', 'Oficina RRHH', 'Directo', 'Diurna', 'Tarde', 'Ninguno', 'Distensión muscular', 'Moderada', 'Distensión', 'Espalda baja', 'Sí', 'Fisioterapia y analgésicos', 'Carlos Ramírez', 4, 5),
(6, 'Quemadura', 'Quemadura con líquido caliente', 'Leve', 'Cerrado', '2025-09-06 13:20:00', 'Cocina', 'Directo', 'Diurna', 'Tarde', 'Delantal', 'Quemadura primer grado', 'Leve', 'Quemadura', 'Antebrazo', 'No', 'Pomada y vendaje', 'Juan Pérez', 1, 1),
(7, 'Atrapamiento', 'Dedo atrapado en maquinaria', 'Grave', 'Abierto', '2025-09-07 08:45:00', 'Área de producción', 'Directo', 'Diurna', 'Mañana', 'Guantes industriales', 'Fractura menor', 'Grave', 'Fractura', 'Dedo índice', 'Sí', 'Radiografía e inmovilización', 'Luis Martínez', 2, 1),
(8, 'Atrapamiento', 'Dedo atrapado en maquinaria', 'Grave', 'Abierto', '2025-09-07 08:45:00', 'Área de producción', 'Directo', 'Diurna', 'Mañana', 'Guantes industriales', 'Fractura menor', 'Grave', 'Fractura', 'Dedo índice', 'Sí', 'Radiografía e inmovilización', 'Luis Martínez', 2, 1),
(9, 'Atrapamiento', 'Dedo atrapado en maquinaria', 'Grave', 'Abierto', '2025-09-07 08:45:00', 'Área de producción', 'Directo', 'Diurna', 'Mañana', 'Guantes industriales', 'Fractura menor', 'Grave', 'Fractura', 'Dedo índice', 'Sí', 'Radiografía e inmovilización', 'Luis Martínez', 2, 1),
(10, 'Atrapamiento', 'Dedo atrapado en maquinaria', 'Grave', 'Abierto', '2025-09-07 08:45:00', 'Área de producción', 'Directo', 'Diurna', 'Mañana', 'Guantes industriales', 'Fractura menor', 'Grave', 'Fractura', 'Dedo índice', 'Sí', 'Radiografía e inmovilización', 'Luis Martínez', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`id_area`, `nombre`, `descripcion`) VALUES
(1, 'Administración', 'Área administrativa y financiera'),
(2, 'Producción', 'Área de producción y manufactura'),
(3, 'Mantenimiento', 'Área de mantenimiento industrial'),
(4, 'Recursos Humanos', 'Área de gestión humana'),
(5, 'Almacén', 'Área de almacenamiento y logística'),
(6, 'Calidad', 'Área de control de calidad'),
(7, 'Seguridad', 'Área de seguridad industrial'),
(8, 'Cafetería', 'Área de alimentación y descanso'),
(9, 'Patio', 'Área de dispersión'),
(10, 'Finanzas', 'Área de finanzas');

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

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`, `descripcion`, `area_id_area`, `user_num_doc`, `empleado_id_empleado`) VALUES
(1, 'Ergonomía', 'Riesgos ergonómicos y posturales', 1, 1053349252, 2),
(2, 'Mecánica', 'Riesgos mecánicos en maquinaria', 2, 1156464465, 1),
(3, 'Eléctrica', 'Riesgos eléctricos e instalaciones', 3, 1546465465, 3),
(4, 'Química', 'Riesgos químicos y exposición', 5, 2147483647, 4),
(5, 'Psicosocial', 'Riesgos psicosociales y estrés', 4, 1053349252, 5),
(6, 'Física', 'Riesgos físicos y ambientales', 2, 1156464465, 6),
(7, 'Biológica', 'Riesgos biológicos y contaminación', 8, 1546465465, 7),
(8, 'Locativa', 'Riesgos de infraestructura', 1, 2147483647, 8),
(9, 'Natural', 'Riesgos por fenómenos naturales', 7, 1053349252, 9),
(10, 'Tecnológica', 'Riesgos por fallas tecnológicas', 6, 1156464465, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_insegura`
--

CREATE TABLE `condicion_insegura` (
  `id_cond_inseg` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `lugar` varchar(100) DEFAULT NULL,
  `area_id_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `condicion_insegura`
--

INSERT INTO `condicion_insegura` (`id_cond_inseg`, `nombre`, `descripcion`, `lugar`, `area_id_area`) VALUES
(1, 'Piso mojado', 'Riesgo de resbalón por superficie húmeda', 'Pasillo principal', 1),
(2, 'Herramienta defectuosa', 'Herramientas en mal estado que pueden causar lesiones', 'Taller de mantenimiento', 3),
(3, 'Cable suelto', 'Riesgo eléctrico por cableado expuesto', 'Oficina administrativa', 1),
(4, 'Iluminación insuficiente', 'Fatiga visual por baja iluminación', 'Almacén general', 5),
(5, 'Estante inestable', 'Riesgo de caída de objetos', 'Bodega de materiales', 5),
(6, 'Máquina sin protección', 'Falta de guardas de seguridad', 'Área de producción', 2),
(7, 'Ventilación deficiente', 'Acumulación de gases y vapores', 'Laboratorio de calidad', 6),
(8, 'Escalera dañada', 'Peldaños sueltos o rotos', 'Acceso segundo piso', 1),
(9, 'Extintor vencido', 'Equipo de emergencia no funcional', 'Pasillo de emergencia', 7),
(10, 'Piso resbaladizo', 'Superficie con aceite o grasa', 'Cocina', 8),
(11, 'Ruido excesivo', 'Niveles de ruido por encima del límite', 'Área de producción', 2),
(12, 'Temperatura extrema', 'Calor excesivo en área de trabajo', 'Sala de calderas', 3);

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
  `rol` int(11) DEFAULT NULL,
  `area_id_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `tipo_doc`, `nombres`, `apellidos`, `telefono`, `eps`, `arl`, `cargo_funcion`, `antig_cargo`, `rol`, `area_id_area`) VALUES
(1, 'CC', 'Juan', 'Pérez', 123456789, 'Sura', 'Colmena', 'Operario', '2 años', 4, 2),
(2, 'CC', 'Ana', 'García', 234567890, 'Nueva EPS', 'Bolívar', 'Administrativa', '1 año', 1, 1),
(3, 'CC', 'Luis', 'Martínez', 345678901, 'Sanitas', 'Sura', 'Técnico Mantenimiento', '3 años', 3, 3),
(4, 'CC', 'Sofía', 'López', 456789012, 'Compensar', 'Colmena', 'Almacenista', '1 año', 2, 5),
(5, 'CC', 'Carlos', 'Ramírez', 567890123, 'Famisanar', 'Bolívar', 'Jefe RRHH', '4 años', 1, 4),
(6, 'CC', 'María', 'González', 678901234, 'Sura', 'Colmena', 'Operaria', '6 meses', 4, 2),
(7, 'CC', 'Pedro', 'Jiménez', 789012345, 'Nueva EPS', 'Sura', 'Supervisor', '5 años', 2, 1),
(8, 'CC', 'Laura', 'Hernández', 890123456, 'Sanitas', 'Bolívar', 'Técnica', '2 años', 3, 3),
(9, 'CC', 'David', 'Morales', 901234567, 'Compensar', 'Colmena', 'Coordinador Almacén', '3 años', 3, 5),
(10, 'CC', 'Carmen', 'Torres', 12345678, 'Famisanar', 'Sura', 'Analista RRHH', '1 año', 4, 4);

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
  `uso_epp` text DEFAULT NULL,
  `area_id_area` int(11) DEFAULT NULL,
  `empleado_id_empleado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `incidente`
--

INSERT INTO `incidente` (`id_incidente`, `tipo`, `descripcion`, `fecha_hora`, `lugar`, `tipo_vinc_lab`, `jornada_laboral`, `turno_mom_inc`, `uso_epp`, `area_id_area`, `empleado_id_empleado`) VALUES
(1, 'Derrame menor', 'Derrame de líquido en el área de almacén', '2025-08-01 08:00:00', 'Almacén', 'Directo', 'Diurna', 'Mañana', 'Guantes', 5, 4),
(2, 'Fallo eléctrico', 'Corte de energía en oficina administrativa', '2025-08-02 09:30:00', 'Oficina', 'Contratista', 'Nocturna', 'Noche', 'Casco', 1, 2),
(3, 'Susto por caída', 'Casi accidente por piso mojado', '2025-08-03 10:15:00', 'Pasillo', 'Directo', 'Diurna', 'Tarde', 'Zapatos antideslizantes', 1, 2),
(4, 'Golpe leve', 'Golpe con herramienta sin lesión', '2025-08-04 11:00:00', 'Taller', 'Contratista', 'Nocturna', 'Mañana', 'Guantes de seguridad', 2, 1),
(5, 'Estrés laboral', 'Estrés por sobrecarga de trabajo', '2025-08-05 12:45:00', 'Oficina RRHH', 'Directo', 'Diurna', 'Tarde', 'Ninguno', 4, 5),
(6, 'Resbalón menor', 'Resbalón en área de mantenimiento', '2025-08-06 14:20:00', 'Sala de máquinas', 'Directo', 'Diurna', 'Tarde', 'Botas antideslizantes', 3, 3),
(7, 'Atrapamiento menor', 'Dedo atrapado en puerta', '2025-08-07 07:30:00', 'Entrada principal', 'Directo', 'Diurna', 'Mañana', 'Ninguno', 1, 2),
(8, 'Exposición química', 'Exposición menor a productos de limpieza', '2025-08-08 16:15:00', 'Baños', 'Contratista', 'Diurna', 'Tarde', 'Guantes y mascarilla', 1, 2),
(9, 'Exposición química', 'Exposición menor a productos de limpieza', '2025-08-08 16:15:00', 'Baños', 'Contratista', 'Diurna', 'Tarde', 'Guantes y mascarilla', 1, 2),
(10, 'Exposición química', 'Exposición menor a productos de limpieza', '2025-08-08 16:15:00', 'Baños', 'Contratista', 'Diurna', 'Tarde', 'Guantes y mascarilla', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inspeccion_locativa`
--

CREATE TABLE `inspeccion_locativa` (
  `id_insp_loc` int(11) NOT NULL,
  `tipo_inspeccion` varchar(50) DEFAULT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado_inspeccion` varchar(50) DEFAULT NULL,
  `element_trab` text DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `categoria_id_categoria` int(11) DEFAULT NULL,
  `incidente_id_incidente` int(11) DEFAULT NULL,
  `accidente_id_accidente` int(11) DEFAULT NULL,
  `riesgo_id_riesgo` int(11) DEFAULT NULL,
  `empleado_id_empleado` int(11) DEFAULT NULL,
  `area_id_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inspeccion_locativa`
--

INSERT INTO `inspeccion_locativa` (`id_insp_loc`, `tipo_inspeccion`, `fecha_hora`, `descripcion`, `estado_inspeccion`, `element_trab`, `observaciones`, `categoria_id_categoria`, `incidente_id_incidente`, `accidente_id_accidente`, `riesgo_id_riesgo`, `empleado_id_empleado`, `area_id_area`) VALUES
(1, 'General', '2025-07-01 08:00:00', 'Inspección rutinaria del área administrativa', 'Aprobada', 'Extintor', 'Extintores en buen estado', 1, 1, 1, 1, 2, 1),
(2, 'Eléctrica', '2025-07-02 09:30:00', 'Revisión de instalaciones eléctricas', 'Pendiente', 'Cableado', 'Cable expuesto requiere protección', 3, 2, 4, 3, 3, 1),
(3, 'Almacén', '2025-07-03 10:15:00', 'Revisión de estanterías y almacenamiento', 'Pendiente', 'Estanterías', 'Estante requiere refuerzo estructural', 4, 1, 3, 5, 4, 5),
(4, 'Iluminación', '2025-07-04 11:00:00', 'Evaluación de niveles de iluminación', 'Pendiente', 'Lámparas', 'Instalar lámparas adicionales', 8, 5, 5, 4, 5, 4),
(5, 'Maquinaria', '2025-07-05 12:45:00', 'Revisión de equipos de producción', 'Rechazada', 'Sierra circular', 'Falta protector de seguridad', 2, 4, 2, 6, 1, 2),
(6, 'Seguridad', '2025-07-06 14:20:00', 'Revisión de equipos de emergencia', 'Aprobada', 'Botiquines', 'Equipos completos y vigentes', 9, NULL, NULL, 9, 9, 7),
(7, 'Calidad del aire', '2025-07-07 07:30:00', 'Medición de calidad del aire', 'Pendiente', 'Ventilación', 'Mejorar sistema de ventilación', 7, NULL, NULL, 7, 8, 6),
(8, 'Ruido', '2025-07-08 16:15:00', 'Medición de niveles de ruido', 'Aprobada', 'Proteón auditiva', 'Niveles dentro de límites permitidos', 6, NULL, NULL, 11, 6, 2),
(9, 'Escaleras', '2025-07-09 08:45:00', 'Inspección de accesos verticales', 'Pendiente', 'Barandas', 'Reparar barandas dañadas', 8, 3, 1, 8, 7, 1),
(10, 'Cocina', '2025-07-10 13:00:00', 'Revisión de área de alimentación', 'Aprobada', 'Campana extractora', 'Sistema de extracción funcionando correctamente', 10, NULL, 6, 10, 10, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte`
--

CREATE TABLE `reporte` (
  `id_reporte` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `fecha_hora` datetime DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `inspeccion_locativa_id_insp_loc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `riesgo`
--

CREATE TABLE `riesgo` (
  `id_riesgo` int(11) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `condicion_insegura_id_cond_inseg` int(11) DEFAULT NULL,
  `area_id_area` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `riesgo`
--

INSERT INTO `riesgo` (`id_riesgo`, `tipo`, `descripcion`, `condicion_insegura_id_cond_inseg`, `area_id_area`) VALUES
(1, 'Caídas al mismo nivel', 'Riesgo de caídas por superficies resbaladizas', 1, 1),
(2, 'Cortes y heridas', 'Riesgo de lesiones con herramientas', 2, 3),
(3, 'Electrocución', 'Riesgo de descarga eléctrica', 3, 1),
(4, 'Fatiga visual', 'Riesgo de daño ocular por mala iluminación', 4, 5),
(5, 'Golpes por objetos', 'Riesgo de impacto por caída de objetos', 5, 5),
(6, 'Atrapamiento', 'Riesgo de atrapamiento en maquinaria', 6, 2),
(7, 'Intoxicación', 'Riesgo de exposición química', 7, 6),
(8, 'Caídas a diferente nivel', 'Riesgo de caída en escaleras', 8, 1),
(9, 'Incendio', 'Riesgo de propagación de fuego', 9, 7),
(10, 'Quemaduras', 'Riesgo de quemaduras por líquidos calientes', 10, 8),
(11, 'Hipoacusia', 'Riesgo de pérdida auditiva por ruido', 11, 2),
(12, 'Golpe de calor', 'Riesgo de estrés térmico', 12, 3);

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
  `usuario` varchar(100) NOT NULL,
  `rol` int(11) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `telefono` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`num_doc`, `tipo_doc`, `usuario`, `rol`, `contrasena`, `telefono`) VALUES
(1053349252, 'CC', 'admin', 1, '$2y$10$1/pkxSXADT6BTgj3YcMwFeTefSGrXZpfFBsQunfY2U7lEboLWVDbi', 123456789),
(1156464465, 'CC', 'super', 2, '$2y$10$ikVtob3xzRywZ51nOtmv9u3VsA/UsW3R51OIXFmnKd1.pwLXZ8Eze', 234567890),
(1546465465, 'CC', 'coord', 3, '$2y$10$Vyduy9Ox9TY.s02w0EMHEumTy5XYSsbvccZ9nG4LZx5UcLuKtiJiS', 345678901),
(2147483647, 'CC', 'trabajador', 4, '$2y$10$Y.p2enqffTyqeEqjXJ14mOIwsqvs8/OTRHeO1mzcpJ9NdbxugSDI.', 456789012);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accidente`
--
ALTER TABLE `accidente`
  ADD PRIMARY KEY (`id_accidente`),
  ADD KEY `area_id_area` (`area_id_area`),
  ADD KEY `empleado_id_empleado` (`empleado_id_empleado`);

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
  ADD PRIMARY KEY (`id_cond_inseg`),
  ADD KEY `area_id_area` (`area_id_area`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `rol` (`rol`),
  ADD KEY `area_id_area` (`area_id_area`);

--
-- Indices de la tabla `incidente`
--
ALTER TABLE `incidente`
  ADD PRIMARY KEY (`id_incidente`),
  ADD KEY `area_id_area` (`area_id_area`),
  ADD KEY `empleado_id_empleado` (`empleado_id_empleado`);

--
-- Indices de la tabla `inspeccion_locativa`
--
ALTER TABLE `inspeccion_locativa`
  ADD PRIMARY KEY (`id_insp_loc`),
  ADD KEY `categoria_id_categoria` (`categoria_id_categoria`),
  ADD KEY `incidente_id_incidente` (`incidente_id_incidente`),
  ADD KEY `accidente_id_accidente` (`accidente_id_accidente`),
  ADD KEY `riesgo_id_riesgo` (`riesgo_id_riesgo`),
  ADD KEY `empleado_id_empleado` (`empleado_id_empleado`),
  ADD KEY `area_id_area` (`area_id_area`);

--
-- Indices de la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD PRIMARY KEY (`id_reporte`),
  ADD KEY `inspeccion_locativa_id_insp_loc` (`inspeccion_locativa_id_insp_loc`);

--
-- Indices de la tabla `riesgo`
--
ALTER TABLE `riesgo`
  ADD PRIMARY KEY (`id_riesgo`),
  ADD KEY `condicion_insegura_id_cond_inseg` (`condicion_insegura_id_cond_inseg`),
  ADD KEY `area_id_area` (`area_id_area`);

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
  MODIFY `id_accidente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `condicion_insegura`
--
ALTER TABLE `condicion_insegura`
  MODIFY `id_cond_inseg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `incidente`
--
ALTER TABLE `incidente`
  MODIFY `id_incidente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `inspeccion_locativa`
--
ALTER TABLE `inspeccion_locativa`
  MODIFY `id_insp_loc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reporte`
--
ALTER TABLE `reporte`
  MODIFY `id_reporte` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `riesgo`
--
ALTER TABLE `riesgo`
  MODIFY `id_riesgo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_Rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accidente`
--
ALTER TABLE `accidente`
  ADD CONSTRAINT `accidente_ibfk_1` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `accidente_ibfk_2` FOREIGN KEY (`empleado_id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `categoria_ibfk_2` FOREIGN KEY (`user_num_doc`) REFERENCES `user` (`num_doc`),
  ADD CONSTRAINT `categoria_ibfk_3` FOREIGN KEY (`empleado_id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `condicion_insegura`
--
ALTER TABLE `condicion_insegura`
  ADD CONSTRAINT `condicion_insegura_ibfk_1` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `empleado_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_Rol`),
  ADD CONSTRAINT `empleado_ibfk_2` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`);

--
-- Filtros para la tabla `incidente`
--
ALTER TABLE `incidente`
  ADD CONSTRAINT `incidente_ibfk_1` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `incidente_ibfk_2` FOREIGN KEY (`empleado_id_empleado`) REFERENCES `empleado` (`id_empleado`);

--
-- Filtros para la tabla `inspeccion_locativa`
--
ALTER TABLE `inspeccion_locativa`
  ADD CONSTRAINT `inspeccion_locativa_ibfk_1` FOREIGN KEY (`categoria_id_categoria`) REFERENCES `categoria` (`id_categoria`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_2` FOREIGN KEY (`incidente_id_incidente`) REFERENCES `incidente` (`id_incidente`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_3` FOREIGN KEY (`accidente_id_accidente`) REFERENCES `accidente` (`id_accidente`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_4` FOREIGN KEY (`riesgo_id_riesgo`) REFERENCES `riesgo` (`id_riesgo`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_5` FOREIGN KEY (`empleado_id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `inspeccion_locativa_ibfk_6` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`);

--
-- Filtros para la tabla `reporte`
--
ALTER TABLE `reporte`
  ADD CONSTRAINT `reporte_ibfk_1` FOREIGN KEY (`inspeccion_locativa_id_insp_loc`) REFERENCES `inspeccion_locativa` (`id_insp_loc`);

--
-- Filtros para la tabla `riesgo`
--
ALTER TABLE `riesgo`
  ADD CONSTRAINT `riesgo_ibfk_1` FOREIGN KEY (`condicion_insegura_id_cond_inseg`) REFERENCES `condicion_insegura` (`id_cond_inseg`),
  ADD CONSTRAINT `riesgo_ibfk_2` FOREIGN KEY (`area_id_area`) REFERENCES `area` (`id_area`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_Rol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
