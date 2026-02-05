-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-02-2026 a las 16:20:04
-- Versión del servidor: 8.4.3
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_contenido_web`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cambiar_estado_seccion` (IN `p_id_seccion` INT, IN `p_estado` BOOLEAN)   BEGIN
    UPDATE Seccion 
    SET Estado_seccion = p_estado 
    WHERE id_seccion = p_id_seccion;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_crear_usuario` (IN `p_correo` VARCHAR(100), IN `p_contraseña` VARCHAR(255), IN `p_id_rol` INT)   BEGIN
    INSERT INTO Usuario (correo_usuario, contraseña_usuario, id_rol_usuario)
    VALUES (p_correo, p_contraseña, p_id_rol);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_obtener_secciones_por_rol` (IN `p_id_rol` INT)   BEGIN
    SELECT * FROM Seccion 
    WHERE id_rol_usuario = p_id_rol 
    AND Estado_seccion = TRUE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int NOT NULL,
  `año_actividad` int NOT NULL,
  `titulo_actividad` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto_actividad` text COLLATE utf8mb4_unicode_ci,
  `imagen_actividad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_seccion` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aliados`
--

CREATE TABLE `aliados` (
  `id_aliados` int NOT NULL,
  `nombre_aliado` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_aliados` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_aliado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_seccion` int NOT NULL,
  `orden` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_proyectos`
--

CREATE TABLE `categoria_proyectos` (
  `id_categoria` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `orden` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int NOT NULL,
  `direccion_contacto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_contacto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horario_atencion` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mapa_ubicacion` text COLLATE utf8mb4_unicode_ci,
  `id_seccion` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directiva`
--

CREATE TABLE `directiva` (
  `id_directiva` int NOT NULL,
  `nombre_directiva` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo_directiva` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_directiva` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_directiva` int DEFAULT '0',
  `id_seccion` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_contacto`
--

CREATE TABLE `formulario_contacto` (
  `id_formcontacto` int NOT NULL,
  `nombre_completo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Correo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_telefonico` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asunto` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_envio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `leido` tinyint(1) DEFAULT '0',
  `respondido` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_proyectos`
--

CREATE TABLE `imagenes_proyectos` (
  `id_imagen` int NOT NULL,
  `proyectos` int NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int DEFAULT '0',
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

CREATE TABLE `informe` (
  `id_informe` int NOT NULL,
  `nombre_organizacion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `evento` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `numero_telefonico` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `personas_beneficiarias` int DEFAULT NULL,
  `curp` varchar(18) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio`
--

CREATE TABLE `inicio` (
  `id_inicio` int NOT NULL,
  `titulo_inicio` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto_inicio` text COLLATE utf8mb4_unicode_ci,
  `img_inicio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_inicio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_seccion` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nosotros`
--

CREATE TABLE `nosotros` (
  `id_nosotros` int NOT NULL,
  `titulo_nosotros` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen_nosotros` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitulo_nosotros` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_nosotros` text COLLATE utf8mb4_unicode_ci,
  `id_seccion` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_frecuentes`
--

CREATE TABLE `preguntas_frecuentes` (
  `id_preguntasfrecuentes` int NOT NULL,
  `titulo_pregunta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto_respuesta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int DEFAULT '0',
  `id_seccion` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyectos` int NOT NULL,
  `categoria` int NOT NULL,
  `titulo_proyecto` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_proyecto` text COLLATE utf8mb4_unicode_ci,
  `año_proyecto` int NOT NULL,
  `imagen_principal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_seccion` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id_redes_sociales` int NOT NULL,
  `Nombre_redsocial` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url_redsocial` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icono` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden` int DEFAULT '0',
  `activo` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `id_rol_usuario` int NOT NULL,
  `cargo_usuario` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`id_rol_usuario`, `cargo_usuario`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '2026-02-05 15:55:45', '2026-02-05 15:55:45'),
(2, 'Editor', '2026-02-05 15:55:45', '2026-02-05 15:55:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id_seccion` int NOT NULL,
  `titulo_seccion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Estado_seccion` tinyint(1) DEFAULT '1',
  `id_rol_usuario` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id_seccion`, `titulo_seccion`, `Estado_seccion`, `id_rol_usuario`, `created_at`, `updated_at`) VALUES
(1, 'Inicio', 1, 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47'),
(2, 'Nosotros', 1, 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47'),
(3, 'Aliados', 1, 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47'),
(4, 'Actividades', 1, 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47'),
(5, 'Proyectos', 1, 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47'),
(6, 'Directiva', 1, 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47'),
(7, 'Preguntas Frecuentes', 1, 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47'),
(8, 'Contacto', 1, 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `correo_usuario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contraseña_usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_rol_usuario` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `activo` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `correo_usuario`, `contraseña_usuario`, `id_rol_usuario`, `created_at`, `updated_at`, `last_login`, `activo`) VALUES
(1, 'admin@sistema.com', '0192023a7bbd73250516f069df18b500', 1, '2026-02-05 15:55:47', '2026-02-05 15:55:47', NULL, 1);

--
-- Disparadores `usuario`
--
DELIMITER $$
CREATE TRIGGER `tr_actualizar_last_login` AFTER UPDATE ON `usuario` FOR EACH ROW BEGIN
    IF NEW.last_login != OLD.last_login THEN
        -- Aquí podrías insertar en una tabla de auditoría si la tuvieras
        SET @dummy = 0;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_proyectos_completos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_proyectos_completos` (
`año_proyecto` int
,`categoria_nombre` varchar(100)
,`created_at` timestamp
,`descripcion_proyecto` text
,`id_proyectos` int
,`titulo_proyecto` varchar(200)
,`titulo_seccion` varchar(100)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_secciones_acceso`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_secciones_acceso` (
`created_at` timestamp
,`Estado_seccion` tinyint(1)
,`id_seccion` int
,`rol_requerido` varchar(50)
,`titulo_seccion` varchar(100)
,`updated_at` timestamp
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_usuarios_roles`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_usuarios_roles` (
`activo` tinyint(1)
,`cargo_usuario` varchar(50)
,`correo_usuario` varchar(100)
,`created_at` timestamp
,`id_usuario` int
,`last_login` timestamp
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `widgets_actividades`
--

CREATE TABLE `widgets_actividades` (
  `id_widgetactividad` int NOT NULL,
  `actividad_id` int NOT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci,
  `orden` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `idx_seccion` (`id_seccion`),
  ADD KEY `idx_año` (`año_actividad`);

--
-- Indices de la tabla `aliados`
--
ALTER TABLE `aliados`
  ADD PRIMARY KEY (`id_aliados`),
  ADD KEY `idx_seccion` (`id_seccion`),
  ADD KEY `idx_orden` (`orden`);

--
-- Indices de la tabla `categoria_proyectos`
--
ALTER TABLE `categoria_proyectos`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `unique_nombre` (`nombre`),
  ADD KEY `idx_orden` (`orden`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `idx_seccion` (`id_seccion`);

--
-- Indices de la tabla `directiva`
--
ALTER TABLE `directiva`
  ADD PRIMARY KEY (`id_directiva`),
  ADD KEY `idx_seccion` (`id_seccion`),
  ADD KEY `idx_orden` (`orden_directiva`);

--
-- Indices de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  ADD PRIMARY KEY (`id_formcontacto`),
  ADD KEY `idx_fecha` (`fecha_envio`),
  ADD KEY `idx_leido` (`leido`);

--
-- Indices de la tabla `imagenes_proyectos`
--
ALTER TABLE `imagenes_proyectos`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `idx_proyecto` (`proyectos`),
  ADD KEY `idx_orden` (`orden`);

--
-- Indices de la tabla `informe`
--
ALTER TABLE `informe`
  ADD PRIMARY KEY (`id_informe`),
  ADD KEY `idx_fecha` (`fecha`),
  ADD KEY `idx_organizacion` (`nombre_organizacion`);

--
-- Indices de la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD PRIMARY KEY (`id_inicio`),
  ADD KEY `idx_seccion` (`id_seccion`);

--
-- Indices de la tabla `nosotros`
--
ALTER TABLE `nosotros`
  ADD PRIMARY KEY (`id_nosotros`),
  ADD KEY `idx_seccion` (`id_seccion`);

--
-- Indices de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  ADD PRIMARY KEY (`id_preguntasfrecuentes`),
  ADD KEY `idx_seccion` (`id_seccion`),
  ADD KEY `idx_orden` (`orden`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyectos`),
  ADD KEY `idx_categoria` (`categoria`),
  ADD KEY `idx_seccion` (`id_seccion`),
  ADD KEY `idx_año` (`año_proyecto`);

--
-- Indices de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD PRIMARY KEY (`id_redes_sociales`),
  ADD UNIQUE KEY `unique_nombre` (`Nombre_redsocial`),
  ADD KEY `idx_orden` (`orden`),
  ADD KEY `idx_activo` (`activo`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`id_rol_usuario`),
  ADD UNIQUE KEY `unique_cargo` (`cargo_usuario`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id_seccion`),
  ADD KEY `idx_estado` (`Estado_seccion`),
  ADD KEY `idx_rol` (`id_rol_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `unique_correo` (`correo_usuario`),
  ADD KEY `idx_correo` (`correo_usuario`),
  ADD KEY `idx_rol` (`id_rol_usuario`);

--
-- Indices de la tabla `widgets_actividades`
--
ALTER TABLE `widgets_actividades`
  ADD PRIMARY KEY (`id_widgetactividad`),
  ADD KEY `idx_actividad` (`actividad_id`),
  ADD KEY `idx_orden` (`orden`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aliados`
--
ALTER TABLE `aliados`
  MODIFY `id_aliados` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria_proyectos`
--
ALTER TABLE `categoria_proyectos`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id_contacto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `directiva`
--
ALTER TABLE `directiva`
  MODIFY `id_directiva` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  MODIFY `id_formcontacto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes_proyectos`
--
ALTER TABLE `imagenes_proyectos`
  MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id_informe` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inicio`
--
ALTER TABLE `inicio`
  MODIFY `id_inicio` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nosotros`
--
ALTER TABLE `nosotros`
  MODIFY `id_nosotros` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  MODIFY `id_preguntasfrecuentes` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyectos` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  MODIFY `id_redes_sociales` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `id_rol_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id_seccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `widgets_actividades`
--
ALTER TABLE `widgets_actividades`
  MODIFY `id_widgetactividad` int NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_proyectos_completos`
--
DROP TABLE IF EXISTS `vista_proyectos_completos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_proyectos_completos`  AS SELECT `p`.`id_proyectos` AS `id_proyectos`, `p`.`titulo_proyecto` AS `titulo_proyecto`, `p`.`descripcion_proyecto` AS `descripcion_proyecto`, `p`.`año_proyecto` AS `año_proyecto`, `c`.`nombre` AS `categoria_nombre`, `s`.`titulo_seccion` AS `titulo_seccion`, `p`.`created_at` AS `created_at` FROM ((`proyectos` `p` join `categoria_proyectos` `c` on((`p`.`categoria` = `c`.`id_categoria`))) join `seccion` `s` on((`p`.`id_seccion` = `s`.`id_seccion`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_secciones_acceso`
--
DROP TABLE IF EXISTS `vista_secciones_acceso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_secciones_acceso`  AS SELECT `s`.`id_seccion` AS `id_seccion`, `s`.`titulo_seccion` AS `titulo_seccion`, `s`.`Estado_seccion` AS `Estado_seccion`, `r`.`cargo_usuario` AS `rol_requerido`, `s`.`created_at` AS `created_at`, `s`.`updated_at` AS `updated_at` FROM (`seccion` `s` join `rol_usuario` `r` on((`s`.`id_rol_usuario` = `r`.`id_rol_usuario`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_usuarios_roles`
--
DROP TABLE IF EXISTS `vista_usuarios_roles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_usuarios_roles`  AS SELECT `u`.`id_usuario` AS `id_usuario`, `u`.`correo_usuario` AS `correo_usuario`, `r`.`cargo_usuario` AS `cargo_usuario`, `u`.`activo` AS `activo`, `u`.`last_login` AS `last_login`, `u`.`created_at` AS `created_at` FROM (`usuario` `u` join `rol_usuario` `r` on((`u`.`id_rol_usuario` = `r`.`id_rol_usuario`))) ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `aliados`
--
ALTER TABLE `aliados`
  ADD CONSTRAINT `aliados_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `directiva`
--
ALTER TABLE `directiva`
  ADD CONSTRAINT `directiva_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `imagenes_proyectos`
--
ALTER TABLE `imagenes_proyectos`
  ADD CONSTRAINT `imagenes_proyectos_ibfk_1` FOREIGN KEY (`proyectos`) REFERENCES `proyectos` (`id_proyectos`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD CONSTRAINT `inicio_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `nosotros`
--
ALTER TABLE `nosotros`
  ADD CONSTRAINT `nosotros_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  ADD CONSTRAINT `preguntas_frecuentes_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categoria_proyectos` (`id_categoria`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `seccion_ibfk_1` FOREIGN KEY (`id_rol_usuario`) REFERENCES `rol_usuario` (`id_rol_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol_usuario`) REFERENCES `rol_usuario` (`id_rol_usuario`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Filtros para la tabla `widgets_actividades`
--
ALTER TABLE `widgets_actividades`
  ADD CONSTRAINT `widgets_actividades_ibfk_1` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id_actividad`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
