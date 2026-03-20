-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 19-03-2026 a las 16:48:14
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
-- Base de datos: `prueba5`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int NOT NULL,
  `id_seccion` int NOT NULL,
  `año_actividad` int DEFAULT NULL,
  `titulo_actividad` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_actividad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aliados`
--

CREATE TABLE `aliados` (
  `id_aliados` int NOT NULL,
  `id_seccion` int NOT NULL,
  `img_aliados` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistenciabeneficiarios`
--

CREATE TABLE `asistenciabeneficiarios` (
  `id_asistenciabeneficiario` int NOT NULL,
  `id_informe` int NOT NULL,
  `asistencianombrebeneficiario` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asistenciaedadbeneficiario` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_proyectos`
--

CREATE TABLE `categoria_proyectos` (
  `id_categoria` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `orden` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int NOT NULL,
  `id_seccion` int NOT NULL,
  `direccion_contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_contacto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directiva`
--

CREATE TABLE `directiva` (
  `id_directiva` int NOT NULL,
  `id_seccion` int NOT NULL,
  `nombre_directiva` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_directiva` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_directiva` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_contacto`
--

CREATE TABLE `formulario_contacto` (
  `id_formcontacto` int NOT NULL,
  `nombre_completo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_telefonico` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asunto` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_envio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `formulario_contacto`
--
DELIMITER $$
CREATE TRIGGER `notificar_nuevo_contacto` AFTER INSERT ON `formulario_contacto` FOR EACH ROW BEGIN
  INSERT INTO `notificaciones` (`id_usuario`, `id_formulario`, `titulo`, `mensaje`)
  SELECT
    ru.id_usuario,
    NEW.id_formcontacto,
    CONCAT('Nueva solicitud de: ', NEW.nombre_completo),
    CONCAT(
      IFNULL(NEW.asunto, 'Sin asunto'), ' — ',
      LEFT(IFNULL(NEW.mensaje, ''), 100),
      IF(CHAR_LENGTH(IFNULL(NEW.mensaje, '')) > 100, '...', '')
    )
  FROM `rol_usuario` ru
  WHERE ru.cargo_usuario = 'administrador';
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_proyectos`
--

CREATE TABLE `imagenes_proyectos` (
  `id_imagen` int NOT NULL,
  `proyecto` int NOT NULL,
  `ruta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
-- NOTA: Se eliminó la columna `numero_telefonico` por no estar en uso
--

CREATE TABLE `informe` (
  `id_informe` int NOT NULL,
  `nombre_organizacion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evento` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio`
--

CREATE TABLE `inicio` (
  `id_inicio` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_inicio` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_inicio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `img_inicio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_inicio` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nosotros`
--

CREATE TABLE `nosotros` (
  `id_nosotros` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_nosotros` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen_nosotros` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitulo_nosotros` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_nosotros` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id_notificacion` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_formulario` int DEFAULT NULL,
  `titulo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_frecuentes`
--

CREATE TABLE `preguntas_frecuentes` (
  `id_preguntasfrecuentes` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_pregunta` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_respuesta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int NOT NULL,
  `id_seccion` int NOT NULL,
  `categoria` int NOT NULL,
  `titulo_proyecto` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion_proyecto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `año_proyecto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id_redes_sociales` int NOT NULL,
  `nombre_redsocial` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_redsocial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reportebeneficiarios`
--

CREATE TABLE `reportebeneficiarios` (
  `id_reportebeneficiario` int NOT NULL,
  `id_informe` int NOT NULL,
  `reportenombrebeneficiario` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reportecurpbeneficiario` char(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reporteedadbeneficiario` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_usuario`
--

CREATE TABLE `rol_usuario` (
  `id_rol_usuario` int NOT NULL,
  `id_usuario` int NOT NULL,
  `cargo_usuario` enum('administrador','editor') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `rol_usuario`
--

INSERT INTO `rol_usuario` (`id_rol_usuario`, `id_usuario`, `cargo_usuario`) VALUES
(1, 1, 'administrador'),
(2, 2, 'editor'),
(5, 5, 'administrador'),
(6, 6, 'editor'),
(7, 7, 'editor'),
(8, 8, 'administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `secciones_web`
--

CREATE TABLE `secciones_web` (
  `id_seccion` int NOT NULL,
  `titulo_seccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_seccion` tinyint(1) DEFAULT '1',
  `id_usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `nombre_usuario` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo_usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contraseña_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `contraseña_usuario`) VALUES
(1, 'Rodolfo Navarrete Ek', 'admin@ajallol.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(2, 'Editor General', 'editor@ajallol.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(5, 'Nintendo Xbox Sanchéz', 'Nintendo2@gmail.com', '$2y$12$iLo8g7nF5zhGdVshUv3mYuKdmAQP5QWAyND84bOv58788ZGE8UOJi'),
(6, 'Lorenzo Sánchez Martín', 'lorenzo@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(7, 'Jefe de Area', 'Nintendo@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(8, 'Oscar Alejandro Sanchéz', 'Martin@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `widgets_actividades`
--

CREATE TABLE `widgets_actividades` (
  `id_widgetactividad` int NOT NULL,
  `actividad_id` int NOT NULL,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

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
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
  ADD UNIQUE KEY `unique_informe_evento` (`evento`,`lugar`,`fecha`);

--
-- Indices de la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD PRIMARY KEY (`id_inicio`),
  ADD KEY `id_seccion` (`id_seccion`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `id_formulario` (`id_formulario`),
  ADD KEY `leido_index` (`leido`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
  ADD UNIQUE KEY `unique_reportebeneficiario_informe` (`id_informe`,`reportecurpbeneficiario`);

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
  ADD KEY `fk_seccion_usuario` (`id_usuario`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

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

ALTER TABLE `actividades`
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `aliados`
  MODIFY `id_aliados` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `asistenciabeneficiarios`
  MODIFY `id_asistenciabeneficiario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

ALTER TABLE `categoria_proyectos`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `contacto`
  MODIFY `id_contacto` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `directiva`
  MODIFY `id_directiva` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `formulario_contacto`
  MODIFY `id_formcontacto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `imagenes_proyectos`
  MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `informe`
  MODIFY `id_informe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

ALTER TABLE `inicio`
  MODIFY `id_inicio` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `nosotros`
  MODIFY `id_nosotros` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

ALTER TABLE `preguntas_frecuentes`
  MODIFY `id_preguntasfrecuentes` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `redes_sociales`
  MODIFY `id_redes_sociales` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `reportebeneficiarios`
  MODIFY `id_reportebeneficiario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

ALTER TABLE `rol_usuario`
  MODIFY `id_rol_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `secciones_web`
  MODIFY `id_seccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

ALTER TABLE `widgets_actividades`
  MODIFY `id_widgetactividad` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

ALTER TABLE `aliados`
  ADD CONSTRAINT `aliados_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

ALTER TABLE `asistenciabeneficiarios`
  ADD CONSTRAINT `asistenciabeneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;

ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

ALTER TABLE `directiva`
  ADD CONSTRAINT `directiva_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

ALTER TABLE `imagenes_proyectos`
  ADD CONSTRAINT `imagenes_proyectos_ibfk_1` FOREIGN KEY (`proyecto`) REFERENCES `proyectos` (`id_proyecto`);

ALTER TABLE `inicio`
  ADD CONSTRAINT `inicio_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

ALTER TABLE `nosotros`
  ADD CONSTRAINT `nosotros_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_formulario`) REFERENCES `formulario_contacto` (`id_formcontacto`) ON DELETE SET NULL;

ALTER TABLE `preguntas_frecuentes`
  ADD CONSTRAINT `preguntas_frecuentes_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`);

ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `secciones_web` (`id_seccion`),
  ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categoria_proyectos` (`id_categoria`);

ALTER TABLE `reportebeneficiarios`
  ADD CONSTRAINT `reportebeneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;

ALTER TABLE `rol_usuario`
  ADD CONSTRAINT `rol_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

ALTER TABLE `secciones_web`
  ADD CONSTRAINT `fk_seccion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

ALTER TABLE `widgets_actividades`
  ADD CONSTRAINT `widgets_actividades_ibfk_1` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id_actividad`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;