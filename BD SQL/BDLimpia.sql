-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-04-2026 a las 16:14:31
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
-- Base de datos: `prueba16`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int NOT NULL,
  `id_ano` int NOT NULL,
  `titulo_actividad` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icono_actividad` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fa-star',
  `texto_actividad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `orden_actividad` int NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_anos`
--

CREATE TABLE `actividad_anos` (
  `id_ano` int NOT NULL,
  `id_pagina` int NOT NULL,
  `ano` int NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 = visible en selector público, 0 = oculto',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aliados`
--

CREATE TABLE `aliados` (
  `id_aliados` int NOT NULL,
  `id_pagina` int NOT NULL,
  `titulo_seccion` varchar(150) DEFAULT 'Aliados',
  `descripcion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aliados_imagenes`
--

CREATE TABLE `aliados_imagenes` (
  `id_imagen` int NOT NULL,
  `id_aliados` int NOT NULL,
  `img_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int NOT NULL,
  `id_pagina` int NOT NULL,
  `direccion_contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_contacto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horario_contacto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mapa_embed` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `facebook_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `directiva`
--

CREATE TABLE `directiva` (
  `id_directiva` int NOT NULL,
  `id_pagina` int NOT NULL,
  `titulo_directiva` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Directiva',
  `subtitulo_directiva` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Comité Directivo',
  `nombre_directiva` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cargo_directiva` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_directiva` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_directiva` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE `donaciones` (
  `id_donacion` int NOT NULL,
  `id_pagina` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones_bancario`
--

CREATE TABLE `donaciones_bancario` (
  `id_bancario` int NOT NULL,
  `id_donacion` int NOT NULL,
  `beneficiario` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banco` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clabe` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones_info`
--

CREATE TABLE `donaciones_info` (
  `id_info` int NOT NULL,
  `id_donacion` int NOT NULL,
  `titulo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones_paypal`
--

CREATE TABLE `donaciones_paypal` (
  `id_paypal` int NOT NULL,
  `id_donacion` int NOT NULL,
  `paypal_usuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
-- Estructura de tabla para la tabla `informe`
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
  `id_pagina` int NOT NULL,
  `eyebrow` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo_principal` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo_em` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio_estadisticas`
--

CREATE TABLE `inicio_estadisticas` (
  `id_estadistica` int NOT NULL,
  `id_pagina` int NOT NULL,
  `ano` int NOT NULL,
  `beneficiarios` int NOT NULL DEFAULT '0',
  `proyectos` int NOT NULL DEFAULT '0',
  `horas_apoyo` int NOT NULL DEFAULT '0',
  `voluntarios` int NOT NULL DEFAULT '0',
  `bd_include` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = incluir datos BD en el total del sitio',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio_videos`
--

CREATE TABLE `inicio_videos` (
  `id_video` int NOT NULL,
  `id_inicio` int NOT NULL,
  `titulo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `youtube_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nosotros`
--

CREATE TABLE `nosotros` (
  `id_nosotros` int NOT NULL,
  `id_pagina` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nosotros_encabezado`
--

CREATE TABLE `nosotros_encabezado` (
  `id_encabezado` int NOT NULL,
  `id_nosotros` int NOT NULL,
  `titulo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nosotros_historia`
--

CREATE TABLE `nosotros_historia` (
  `id_historia` int NOT NULL,
  `id_nosotros` int NOT NULL,
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `badge_texto` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etiqueta_superior` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titulo_bloque` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_destacado` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `texto_descriptivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nosotros_identidad`
--

CREATE TABLE `nosotros_identidad` (
  `id_identidad` int NOT NULL,
  `id_nosotros` int NOT NULL,
  `titulo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nosotros_identidad_items`
--

CREATE TABLE `nosotros_identidad_items` (
  `id_item` int NOT NULL,
  `id_identidad` int NOT NULL,
  `tipo` enum('mision','vision','objetivo','valores') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenido` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `orden` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
-- Estructura de tabla para la tabla `paginas`
--

CREATE TABLE `paginas` (
  `id_pagina` int NOT NULL,
  `id_usuario` int NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL amigable: /nosotros',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `paginas`
--

INSERT INTO `paginas` (`id_pagina`, `id_usuario`, `slug`, `created_at`, `updated_at`) VALUES
(1, 1, 'inicio', '2026-04-21 16:11:58', '2026-04-21 16:11:58'),
(2, 1, 'nosotros', '2026-04-21 16:11:58', '2026-04-21 16:11:58'),
(3, 1, 'aliados', '2026-04-21 16:11:58', '2026-04-21 16:11:58'),
(4, 1, 'actividades', '2026-04-21 16:11:58', '2026-04-21 16:11:58'),
(5, 1, 'proyectos', '2026-04-21 16:11:58', '2026-04-21 16:11:58'),
(6, 1, 'directiva', '2026-04-21 16:11:58', '2026-04-21 16:11:58'),
(7, 1, 'preguntas-frecuentes', '2026-04-21 16:11:58', '2026-04-21 16:11:58'),
(8, 1, 'contacto', '2026-04-21 16:11:58', '2026-04-21 16:11:58');

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
  `id_pagina` int NOT NULL,
  `titulo_pregunta` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_respuesta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_anos`
--

CREATE TABLE `proyecto_anos` (
  `id_ano` int NOT NULL,
  `id_pagina` int NOT NULL,
  `ano` int NOT NULL,
  `subtitulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_categorias`
--

CREATE TABLE `proyecto_categorias` (
  `id_categoria` int NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `orden` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_imagenes`
--

CREATE TABLE `proyecto_imagenes` (
  `id_imagen` int NOT NULL,
  `id_ano` int NOT NULL,
  `id_categoria` int NOT NULL,
  `titulo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `event_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
(1, 'Rodolfo Navarrete Ek', 'admin@ajallol.com', '$2y$12$BxrxEDu56qd3K16hbAT5TO7I9h9cdgNTY2FdzAhmEU9HoaPz/h9nu'),
(2, 'Editor General', 'editor@ajallol.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(5, 'Nintendo Xbox Sanchéz', 'Nintendo2@gmail.com', '$2y$12$iLo8g7nF5zhGdVshUv3mYuKdmAQP5QWAyND84bOv58788ZGE8UOJi'),
(6, 'Lorenzo Sánchez Martín', 'lorenzo@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(7, 'Jefe de Area', 'Nintendo@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(8, 'Oscar Alejandro Sanchéz', 'Martin@gmail.com', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `idx_actividades_ano` (`id_ano`),
  ADD KEY `idx_actividades_orden` (`orden_actividad`);

--
-- Indices de la tabla `actividad_anos`
--
ALTER TABLE `actividad_anos`
  ADD PRIMARY KEY (`id_ano`),
  ADD UNIQUE KEY `unique_ano_pagina` (`ano`,`id_pagina`),
  ADD KEY `actividad_anos_fk_pagina` (`id_pagina`);

--
-- Indices de la tabla `aliados`
--
ALTER TABLE `aliados`
  ADD PRIMARY KEY (`id_aliados`),
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indices de la tabla `aliados_imagenes`
--
ALTER TABLE `aliados_imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_aliados` (`id_aliados`);

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
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indices de la tabla `directiva`
--
ALTER TABLE `directiva`
  ADD PRIMARY KEY (`id_directiva`),
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indices de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD PRIMARY KEY (`id_donacion`),
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indices de la tabla `donaciones_bancario`
--
ALTER TABLE `donaciones_bancario`
  ADD PRIMARY KEY (`id_bancario`),
  ADD KEY `id_donacion` (`id_donacion`);

--
-- Indices de la tabla `donaciones_info`
--
ALTER TABLE `donaciones_info`
  ADD PRIMARY KEY (`id_info`),
  ADD KEY `id_donacion` (`id_donacion`);

--
-- Indices de la tabla `donaciones_paypal`
--
ALTER TABLE `donaciones_paypal`
  ADD PRIMARY KEY (`id_paypal`),
  ADD KEY `id_donacion` (`id_donacion`);

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
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indices de la tabla `inicio_estadisticas`
--
ALTER TABLE `inicio_estadisticas`
  ADD PRIMARY KEY (`id_estadistica`),
  ADD UNIQUE KEY `unique_ano_pagina` (`ano`,`id_pagina`),
  ADD KEY `fk_estadistica_pagina` (`id_pagina`);

--
-- Indices de la tabla `inicio_videos`
--
ALTER TABLE `inicio_videos`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `id_inicio` (`id_inicio`);

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
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indices de la tabla `nosotros_encabezado`
--
ALTER TABLE `nosotros_encabezado`
  ADD PRIMARY KEY (`id_encabezado`),
  ADD KEY `id_nosotros` (`id_nosotros`);

--
-- Indices de la tabla `nosotros_historia`
--
ALTER TABLE `nosotros_historia`
  ADD PRIMARY KEY (`id_historia`),
  ADD KEY `id_nosotros` (`id_nosotros`);

--
-- Indices de la tabla `nosotros_identidad`
--
ALTER TABLE `nosotros_identidad`
  ADD PRIMARY KEY (`id_identidad`),
  ADD KEY `id_nosotros` (`id_nosotros`);

--
-- Indices de la tabla `nosotros_identidad_items`
--
ALTER TABLE `nosotros_identidad_items`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_identidad` (`id_identidad`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id_notificacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_formulario` (`id_formulario`),
  ADD KEY `leido_index` (`leido`);

--
-- Indices de la tabla `paginas`
--
ALTER TABLE `paginas`
  ADD PRIMARY KEY (`id_pagina`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_paginas_usuario` (`id_usuario`);

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
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indices de la tabla `proyecto_anos`
--
ALTER TABLE `proyecto_anos`
  ADD PRIMARY KEY (`id_ano`),
  ADD UNIQUE KEY `unique_ano_pagina` (`ano`,`id_pagina`),
  ADD KEY `id_pagina` (`id_pagina`);

--
-- Indices de la tabla `proyecto_categorias`
--
ALTER TABLE `proyecto_categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `proyecto_imagenes`
--
ALTER TABLE `proyecto_imagenes`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `id_ano` (`id_ano`),
  ADD KEY `id_categoria` (`id_categoria`);

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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `actividad_anos`
--
ALTER TABLE `actividad_anos`
  MODIFY `id_ano` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aliados`
--
ALTER TABLE `aliados`
  MODIFY `id_aliados` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `aliados_imagenes`
--
ALTER TABLE `aliados_imagenes`
  MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `asistenciabeneficiarios`
--
ALTER TABLE `asistenciabeneficiarios`
  MODIFY `id_asistenciabeneficiario` int NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id_donacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `donaciones_bancario`
--
ALTER TABLE `donaciones_bancario`
  MODIFY `id_bancario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `donaciones_info`
--
ALTER TABLE `donaciones_info`
  MODIFY `id_info` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `donaciones_paypal`
--
ALTER TABLE `donaciones_paypal`
  MODIFY `id_paypal` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  MODIFY `id_formcontacto` int NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT de la tabla `inicio_estadisticas`
--
ALTER TABLE `inicio_estadisticas`
  MODIFY `id_estadistica` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inicio_videos`
--
ALTER TABLE `inicio_videos`
  MODIFY `id_video` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nosotros`
--
ALTER TABLE `nosotros`
  MODIFY `id_nosotros` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nosotros_encabezado`
--
ALTER TABLE `nosotros_encabezado`
  MODIFY `id_encabezado` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nosotros_historia`
--
ALTER TABLE `nosotros_historia`
  MODIFY `id_historia` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nosotros_identidad`
--
ALTER TABLE `nosotros_identidad`
  MODIFY `id_identidad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nosotros_identidad_items`
--
ALTER TABLE `nosotros_identidad_items`
  MODIFY `id_item` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id_pagina` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  MODIFY `id_preguntasfrecuentes` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyecto_anos`
--
ALTER TABLE `proyecto_anos`
  MODIFY `id_ano` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyecto_categorias`
--
ALTER TABLE `proyecto_categorias`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyecto_imagenes`
--
ALTER TABLE `proyecto_imagenes`
  MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reportebeneficiarios`
--
ALTER TABLE `reportebeneficiarios`
  MODIFY `id_reportebeneficiario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `id_rol_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_fk_ano` FOREIGN KEY (`id_ano`) REFERENCES `actividad_anos` (`id_ano`) ON DELETE CASCADE;

--
-- Filtros para la tabla `actividad_anos`
--
ALTER TABLE `actividad_anos`
  ADD CONSTRAINT `actividad_anos_fk_pagina` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `aliados`
--
ALTER TABLE `aliados`
  ADD CONSTRAINT `aliados_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `aliados_imagenes`
--
ALTER TABLE `aliados_imagenes`
  ADD CONSTRAINT `aliados_imagenes_ibfk_1` FOREIGN KEY (`id_aliados`) REFERENCES `aliados` (`id_aliados`) ON DELETE CASCADE;

--
-- Filtros para la tabla `asistenciabeneficiarios`
--
ALTER TABLE `asistenciabeneficiarios`
  ADD CONSTRAINT `asistenciabeneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `directiva`
--
ALTER TABLE `directiva`
  ADD CONSTRAINT `directiva_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD CONSTRAINT `donaciones_fk_pagina` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `donaciones_bancario`
--
ALTER TABLE `donaciones_bancario`
  ADD CONSTRAINT `donaciones_bancario_fk` FOREIGN KEY (`id_donacion`) REFERENCES `donaciones` (`id_donacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `donaciones_info`
--
ALTER TABLE `donaciones_info`
  ADD CONSTRAINT `donaciones_info_fk` FOREIGN KEY (`id_donacion`) REFERENCES `donaciones` (`id_donacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `donaciones_paypal`
--
ALTER TABLE `donaciones_paypal`
  ADD CONSTRAINT `donaciones_paypal_fk` FOREIGN KEY (`id_donacion`) REFERENCES `donaciones` (`id_donacion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD CONSTRAINT `inicio_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `inicio_estadisticas`
--
ALTER TABLE `inicio_estadisticas`
  ADD CONSTRAINT `fk_estadistica_pagina` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `inicio_videos`
--
ALTER TABLE `inicio_videos`
  ADD CONSTRAINT `inicio_videos_fk` FOREIGN KEY (`id_inicio`) REFERENCES `inicio` (`id_inicio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nosotros`
--
ALTER TABLE `nosotros`
  ADD CONSTRAINT `nosotros_fk_pagina` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `nosotros_encabezado`
--
ALTER TABLE `nosotros_encabezado`
  ADD CONSTRAINT `nosotros_encabezado_fk` FOREIGN KEY (`id_nosotros`) REFERENCES `nosotros` (`id_nosotros`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nosotros_historia`
--
ALTER TABLE `nosotros_historia`
  ADD CONSTRAINT `nosotros_historia_fk` FOREIGN KEY (`id_nosotros`) REFERENCES `nosotros` (`id_nosotros`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nosotros_identidad`
--
ALTER TABLE `nosotros_identidad`
  ADD CONSTRAINT `nosotros_identidad_fk` FOREIGN KEY (`id_nosotros`) REFERENCES `nosotros` (`id_nosotros`) ON DELETE CASCADE;

--
-- Filtros para la tabla `nosotros_identidad_items`
--
ALTER TABLE `nosotros_identidad_items`
  ADD CONSTRAINT `nosotros_identidad_items_fk` FOREIGN KEY (`id_identidad`) REFERENCES `nosotros_identidad` (`id_identidad`) ON DELETE CASCADE;

--
-- Filtros para la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_formulario`) REFERENCES `formulario_contacto` (`id_formcontacto`) ON DELETE SET NULL;

--
-- Filtros para la tabla `paginas`
--
ALTER TABLE `paginas`
  ADD CONSTRAINT `fk_paginas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  ADD CONSTRAINT `preguntas_frecuentes_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `proyecto_anos`
--
ALTER TABLE `proyecto_anos`
  ADD CONSTRAINT `proyecto_anos_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `proyecto_imagenes`
--
ALTER TABLE `proyecto_imagenes`
  ADD CONSTRAINT `proyecto_imagenes_ibfk_1` FOREIGN KEY (`id_ano`) REFERENCES `proyecto_anos` (`id_ano`) ON DELETE CASCADE,
  ADD CONSTRAINT `proyecto_imagenes_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `proyecto_categorias` (`id_categoria`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
