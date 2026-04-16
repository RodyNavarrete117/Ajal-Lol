-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 16-04-2026 a las 19:53:38
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
-- Base de datos: `prueba12`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int NOT NULL,
  `id_ano` int DEFAULT NULL,
  `titulo_actividad` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono_actividad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_actividad` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `orden_actividad` int DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_encabezado`
--

CREATE TABLE `actividades_encabezado` (
  `id_encabezado` int NOT NULL,
  `id_ano` int DEFAULT NULL,
  `titulo_actividad` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitulo_actividad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ano_visible` int DEFAULT NULL COMMENT 'Año activo visible en la página pública',
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

--
-- Volcado de datos para la tabla `informe`
--

INSERT INTO `informe` (`id_informe`, `nombre_organizacion`, `evento`, `lugar`, `fecha`, `created_at`, `updated_at`) VALUES
(2, 'Ajal-lol AC', 'Actividad recreativa de Año Nuevo', 'Izamal, Yucatán', '2026-01-16', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(3, 'Ajal-lol AC', 'Entrega de juguetes Día de Reyes', 'Tekit, Yucatán', '2026-01-15', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(7, 'Ajal-lol AC', 'Distribución de despensas alimentarias', 'Akil, Yucatán', '2026-02-20', '2026-02-26 23:10:08', '2026-02-26 23:10:08'),
(22, 'Ajal-lol AC', 'Entrega de canastas básicas de alimentos', 'Akil, Yucatán', '2026-02-20', '2026-03-03 00:05:35', '2026-03-03 00:05:35'),
(30, 'Ajal-lol AC', 'Entrega de artículos de primera necesidad', 'Akil, Yucatán', '2026-03-01', '2026-03-03 00:20:28', '2026-03-03 00:20:28'),
(31, 'Ajal-lol AC', 'Jornada de ayuda humanitaria comunitaria', 'Akil, Yucatán', '2026-03-21', '2026-03-03 00:22:21', '2026-03-03 00:22:21'),
(32, 'Ajal-lol AC', 'Entrega de insumos para el hogar', 'Akil, Yucatán', '2026-03-02', '2026-03-03 00:25:03', '2026-03-03 00:25:03'),
(37, 'Ajal-lol AC', 'Apoyo alimentario a familias vulnerables', 'Akil, Yucatán', '2026-02-22', '2026-03-03 00:28:43', '2026-03-03 00:28:43'),
(43, 'Ajal-lol AC', 'Programa de nutrición infantil comunitaria', 'Akil, Yucatán', '2026-02-20', '2026-03-03 00:32:40', '2026-03-03 00:32:40'),
(44, 'Ajal-lol AC', 'Jornada de salud preventiva', 'Akil, Yucatán', '2026-03-03', '2026-03-03 00:33:53', '2026-03-03 00:33:53'),
(45, 'Ajal-lol AC', 'Distribución de suministros educativos', 'Akil, Yucatán', '2026-04-02', '2026-03-03 00:35:01', '2026-03-03 00:35:01'),
(48, 'Ajal-lol AC', 'Entrega de kit de útiles escolares', 'Akil, Yucatán', '2026-04-15', '2026-03-03 00:37:39', '2026-03-03 00:37:39'),
(49, 'Ajal-lol AC', 'Campaña de apoyo a adultos mayores', 'Akil, Yucatán', '2026-05-01', '2026-03-03 00:38:15', '2026-03-03 00:38:15'),
(53, 'Ajal-lol AC', 'Brigada de asistencia social comunitaria', 'Akil, Yucatán', '2026-04-02', '2026-03-03 00:51:40', '2026-03-03 00:51:40'),
(54, 'Ajal-lol AC', 'Taller de capacitación para el empleo', 'Akil, Yucatán', '2026-05-20', '2026-03-03 00:52:20', '2026-03-03 00:52:20'),
(57, 'Ajal-lol AC', 'Jornada de reforestación comunitaria', 'Akil, Yucatán', '2026-06-05', '2026-03-03 00:53:34', '2026-03-03 00:53:34'),
(58, 'Ajal-lol AC', 'Entrega de materiales de construcción', 'Akil, Yucatán', '2026-09-20', '2026-03-03 03:54:30', '2026-03-03 03:54:30'),
(59, 'Ajal-lol AC', 'Programa de becas y apoyo educativo', 'Akil, Yucatán', '2026-07-20', '2026-03-03 04:09:53', '2026-03-03 04:09:53'),
(60, 'Ajal-lol AC', 'Entrega de despensas y artículos del hogar', 'Akil, Yucatán', '2026-03-03', '2026-03-03 21:31:04', '2026-03-03 21:31:04'),
(61, 'Ajal-lol AC', 'Brigada de Salud Integral \"Vida Sana\"', 'Izamal, Yucatán', '2026-03-10', '2026-03-11 00:05:21', '2026-03-11 00:05:21'),
(62, 'Ajal-lol AC', 'Jornada de reforestación comunitaria', 'Akil, Yucatán', '2026-03-11', '2026-03-11 21:57:37', '2026-03-11 21:57:37'),
(63, 'Ajal-lol AC', 'Jornada de reforestación comunitaria', 'Chikindzonot, Yucatán', '2026-03-11', '2026-03-11 22:50:10', '2026-03-11 22:50:10'),
(64, 'Ajal-lol AC', 'Campaña de apoyo a adultos mayores', 'Acanceh, Yucatán', '2026-03-11', '2026-03-11 23:16:43', '2026-03-11 23:16:43'),
(65, 'Ajal-lol AC', 'Taller de capacitación para el empleo', 'Abalá, Yucatán', '2026-03-20', '2026-03-12 21:45:11', '2026-03-12 21:45:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inicio`
--

CREATE TABLE `inicio` (
  `id_inicio` int NOT NULL,
  `id_pagina` int NOT NULL,
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
  `id_pagina` int NOT NULL,
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
(1, 1, 'inicio', '2026-03-25 17:24:08', '2026-03-25 17:24:08'),
(2, 1, 'nosotros', '2026-03-25 17:24:08', '2026-03-25 17:24:08'),
(3, 1, 'aliados', '2026-03-25 17:24:08', '2026-03-25 17:24:08'),
(4, 1, 'actividades', '2026-03-25 17:24:08', '2026-03-25 17:24:08'),
(5, 1, 'proyectos', '2026-03-25 17:24:08', '2026-03-25 17:24:08'),
(6, 1, 'directiva', '2026-03-25 17:24:08', '2026-03-25 17:24:08'),
(7, 1, 'preguntas-frecuentes', '2026-03-25 17:24:08', '2026-03-25 17:24:08'),
(8, 1, 'contacto', '2026-03-25 17:24:08', '2026-03-25 17:24:08');

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
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id_redes_sociales` int NOT NULL,
  `nombre_redsocial` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_redsocial` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1'
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
-- Indices de la tabla `actividades_encabezado`
--
ALTER TABLE `actividades_encabezado`
  ADD PRIMARY KEY (`id_encabezado`),
  ADD UNIQUE KEY `unique_encabezado_ano` (`id_ano`);

--
-- Indices de la tabla `actividad_anos`
--
ALTER TABLE `actividad_anos`
  ADD PRIMARY KEY (`id_ano`),
  ADD UNIQUE KEY `unique_ano_pagina` (`ano`,`id_pagina`),
  ADD KEY `idx_actividad_anos_pagina` (`id_pagina`);

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
-- AUTO_INCREMENT de la tabla `actividades_encabezado`
--
ALTER TABLE `actividades_encabezado`
  MODIFY `id_encabezado` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_informe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `inicio`
--
ALTER TABLE `inicio`
  MODIFY `id_inicio` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  ADD CONSTRAINT `actividades_fk_ano` FOREIGN KEY (`id_ano`) REFERENCES `actividad_anos` (`id_ano`) ON DELETE SET NULL;

--
-- Filtros para la tabla `actividades_encabezado`
--
ALTER TABLE `actividades_encabezado`
  ADD CONSTRAINT `actividades_encabezado_fk_ano` FOREIGN KEY (`id_ano`) REFERENCES `actividad_anos` (`id_ano`) ON DELETE CASCADE;

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
-- Filtros para la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD CONSTRAINT `inicio_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

--
-- Filtros para la tabla `nosotros`
--
ALTER TABLE `nosotros`
  ADD CONSTRAINT `nosotros_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);

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
