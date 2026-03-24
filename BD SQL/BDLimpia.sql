-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 24-03-2026 a las 22:37:42
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `prueba7`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int NOT NULL,
  `id_seccion` int NOT NULL,
  `año_actividad` int DEFAULT NULL,
  `titulo_actividad` varchar(150) DEFAULT NULL,
  `texto_actividad` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aliados`
--

CREATE TABLE `aliados` (
  `id_aliados` int NOT NULL,
  `id_seccion` int NOT NULL,
  `img_aliados` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistenciabeneficiarios`
--

CREATE TABLE `asistenciabeneficiarios` (
  `id_asistenciabeneficiario` int NOT NULL,
  `id_informe` int NOT NULL,
  `asistencianombrebeneficiario` varchar(150) NOT NULL,
  `asistenciaedadbeneficiario` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_proyectos`
--

CREATE TABLE `categoria_proyectos` (
  `id_categoria` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text,
  `orden` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int NOT NULL,
  `id_seccion` int NOT NULL,
  `direccion_contacto` varchar(255) DEFAULT NULL,
  `telefono_contacto` varchar(50) DEFAULT NULL,
  `email_contacto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directiva`
--

CREATE TABLE `directiva` (
  `id_directiva` int NOT NULL,
  `id_seccion` int NOT NULL,
  `nombre_directiva` varchar(150) DEFAULT NULL,
  `foto_directiva` varchar(255) DEFAULT NULL,
  `orden_directiva` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_contacto`
--

CREATE TABLE `formulario_contacto` (
  `id_formcontacto` int NOT NULL,
  `nombre_completo` varchar(150) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `numero_telefonico` varchar(50) DEFAULT NULL,
  `asunto` varchar(150) DEFAULT NULL,
  `mensaje` text,
  `fecha_envio` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_proyectos`
--

CREATE TABLE `imagenes_proyectos` (
  `id_imagen` int NOT NULL,
  `proyecto` int NOT NULL,
  `ruta` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `fecha_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

CREATE TABLE `informe` (
  `id_informe` int NOT NULL,
  `nombre_organizacion` varchar(150) NOT NULL,
  `evento` varchar(150) NOT NULL,
  `lugar` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio`
--

CREATE TABLE `inicio` (
  `id_inicio` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_inicio` varchar(150) DEFAULT NULL,
  `texto_inicio` text,
  `img_inicio` varchar(255) DEFAULT NULL,
  `url_inicio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nosotros`
--

CREATE TABLE `nosotros` (
  `id_nosotros` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_nosotros` varchar(150) DEFAULT NULL,
  `imagen_nosotros` varchar(255) DEFAULT NULL,
  `subtitulo_nosotros` varchar(150) DEFAULT NULL,
  `texto_nosotros` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_formulario` int DEFAULT NULL,
  `titulo` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `leido` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_frecuentes`
--

CREATE TABLE `preguntas_frecuentes` (
  `id_preguntasfrecuentes` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_pregunta` varchar(150) DEFAULT NULL,
  `texto_respuesta` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int NOT NULL,
  `id_seccion` int NOT NULL,
  `categoria` int NOT NULL,
  `titulo_proyecto` varchar(150) DEFAULT NULL,
  `descripcion_proyecto` text,
  `año_proyecto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id_redes_sociales` int NOT NULL,
  `nombre_redsocial` varchar(50) DEFAULT NULL,
  `url_redsocial` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportebeneficiarios`
--

CREATE TABLE `reportebeneficiarios` (
  `id_reportebeneficiario` int NOT NULL,
  `id_informe` int NOT NULL,
  `reportenombrebeneficiario` varchar(150) NOT NULL,
  `reportecurpbeneficiario` char(18) NOT NULL,
  `reporteedadbeneficiario` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `id_rol_usuario` int NOT NULL,
  `id_usuario` int NOT NULL,
  `cargo_usuario` enum('administrador','editor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones_web`
--

CREATE TABLE `secciones_web` (
  `id_seccion` int NOT NULL,
  `titulo_seccion` varchar(100) NOT NULL,
  `estado_seccion` tinyint(1) DEFAULT '1',
  `id_usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `nombre_usuario` varchar(150) NOT NULL,
  `correo_usuario` varchar(100) NOT NULL,
  `contraseña_usuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `widgets_actividades`
--

CREATE TABLE `widgets_actividades` (
  `id_widgetactividad` int NOT NULL,
  `actividad_id` int NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `texto` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `aliados`
--
ALTER TABLE `aliados`
  ADD PRIMARY KEY (`id_aliados`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `asistenciabeneficiarios`
--
ALTER TABLE `asistenciabeneficiarios`
  ADD PRIMARY KEY (`id_asistenciabeneficiario`),
  ADD KEY `id_informe` (`id_informe`);

--
-- Indices de la tabla `categoria_proyectos`
--
ALTER TABLE `categoria_proyectos`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `directiva`
--
ALTER TABLE `directiva`
  ADD PRIMARY KEY (`id_directiva`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  ADD PRIMARY KEY (`id_formcontacto`);

--
-- Indices de la tabla `imagenes_proyectos`
--
ALTER TABLE `imagenes_proyectos`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `proyecto` (`proyecto`);

--
-- Indices de la tabla `informe`
--
ALTER TABLE `informe`
  ADD PRIMARY KEY (`id_informe`),
  ADD UNIQUE KEY `evento` (`evento`,`lugar`,`fecha`);

--
-- Indices de la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD PRIMARY KEY (`id_inicio`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `nosotros`
--
ALTER TABLE `nosotros`
  ADD PRIMARY KEY (`id_nosotros`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_formulario` (`id_formulario`);

--
-- Indices de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  ADD PRIMARY KEY (`id_preguntasfrecuentes`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `id_seccion` (`id_seccion`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD PRIMARY KEY (`id_redes_sociales`);

--
-- Indices de la tabla `reportebeneficiarios`
--
ALTER TABLE `reportebeneficiarios`
  ADD PRIMARY KEY (`id_reportebeneficiario`),
  ADD UNIQUE KEY `id_informe` (`id_informe`,`reportecurpbeneficiario`);

--
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`id_rol_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `secciones_web`
--
ALTER TABLE `secciones_web`
  ADD PRIMARY KEY (`id_seccion`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_usuario` (`correo_usuario`);

--
-- Indices de la tabla `widgets_actividades`
--
ALTER TABLE `widgets_actividades`
  ADD PRIMARY KEY (`id_widgetactividad`),
  ADD KEY `actividad_id` (`actividad_id`);

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
-- AUTO_INCREMENT de la tabla `asistenciabeneficiarios`
--
ALTER TABLE `asistenciabeneficiarios`
  MODIFY `id_asistenciabeneficiario` int NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  MODIFY `id_preguntasfrecuentes` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  MODIFY `id_redes_sociales` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reportebeneficiarios`
--
ALTER TABLE `reportebeneficiarios`
  MODIFY `id_reportebeneficiario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `id_rol_usuario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `secciones_web`
--
ALTER TABLE `secciones_web`
  MODIFY `id_seccion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `widgets_actividades`
--
ALTER TABLE `widgets_actividades`
  MODIFY `id_widgetactividad` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

--
-- Filtros para la tabla `aliados`
--
ALTER TABLE `aliados`
  ADD CONSTRAINT `aliados_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

--
-- Filtros para la tabla `asistenciabeneficiarios`
--
ALTER TABLE `asistenciabeneficiarios`
  ADD CONSTRAINT `asistenciabeneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

--
-- Filtros para la tabla `directiva`
--
ALTER TABLE `directiva`
  ADD CONSTRAINT `directiva_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

--
-- Filtros para la tabla `imagenes_proyectos`
--
ALTER TABLE `imagenes_proyectos`
  ADD CONSTRAINT `imagenes_proyectos_ibfk_1` FOREIGN KEY (`proyecto`) REFERENCES `proyectos` (`id_proyecto`);

--
-- Filtros para la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD CONSTRAINT `inicio_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

--
-- Filtros para la tabla `nosotros`
--
ALTER TABLE `nosotros`
  ADD CONSTRAINT `nosotros_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_formulario`) REFERENCES `formulario_contacto` (`id_formcontacto`) ON DELETE SET NULL;

--
-- Filtros para la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  ADD CONSTRAINT `preguntas_frecuentes_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`),
  ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categoria_proyectos` (`id_categoria`);

--
-- Filtros para la tabla `reportebeneficiarios`
--
ALTER TABLE `reportebeneficiarios`
  ADD CONSTRAINT `reportebeneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;

--
-- Filtros para la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD CONSTRAINT `rol_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `secciones_web`
--
ALTER TABLE `secciones_web`
  ADD CONSTRAINT `secciones_web_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `widgets_actividades`
--
ALTER TABLE `widgets_actividades`
  ADD CONSTRAINT `widgets_actividades_ibfk_1` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id_actividad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
