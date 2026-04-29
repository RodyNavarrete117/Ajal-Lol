-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 29-04-2026 a las 15:58:13
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
-- Base de datos: `prueba1`
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

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id_actividad`, `id_ano`, `titulo_actividad`, `icono_actividad`, `texto_actividad`, `orden_actividad`, `visible`, `created_at`, `updated_at`) VALUES
(1, 1, 'Jornada dental', 'fa-tooth', 'Por segundo año consecutivo, se realizaron Jornadas de servicios dentales con el apoyo de la Fundación Smile y Global Dental. Un equipo de 35 dentistas brindó servicios gratuitos en marzo, abril y junio, atendiendo a 159 pacientes de varios municipios.', 1, 1, '2026-04-26 22:33:16', '2026-04-26 22:33:16'),
(2, 1, 'Jornada de salud', 'fa-heart-pulse', 'Realizamos 2 Jornadas de salud en la localidad de Hoctún, donde se brindaron servicios de detección gratuita de niveles de azúcar, presión arterial, peso, talla, pruebas de la vista y una orientación psicológica, así mismo se brindó atención dental y llevamos a cabo 1 jornada de salud en el municipio de Hocabá, en la que se benefició a 300 personas, adicionalmente se realizaron 5 servicios de ultrasonido a los habitantes de la comunidad de Hoctún, con la que se atendieron 58 pacientes.', 2, 1, '2026-04-26 22:33:16', '2026-04-26 22:33:16'),
(3, 1, 'Talleres de capacitación', 'fa-chalkboard', 'Con el apoyo de la fundación Mentors International, se realizaron cursos de capacitación sobre administración básica para pequeños emprendedores en varios municipios, beneficiando a 150 personas que recibieron materiales e insumos al finalizar.', 3, 1, '2026-04-26 22:33:16', '2026-04-26 22:33:16'),
(4, 1, 'Reforestación', 'fa-tree', 'El Ayuntamiento de Mérida donó 1666 plantas forestales y maderables a 11 localidades para reforestar predios de producción y traspatio.', 4, 1, '2026-04-26 22:33:16', '2026-04-26 22:33:16'),
(5, 1, 'Cria de pavos de engorda', 'fa-crow', 'Como seguimiento al proyecto iniciado en 2022 para la engorda de pavos de traspatio con donativos de OXXO, que benefició a 350 familias, en 2023 se pudo continuar con el proyecto.', 5, 1, '2026-04-26 22:33:16', '2026-04-26 22:33:16'),
(6, 1, 'Entrega de tinacos', 'fa-droplet', 'Gracias a la participación comunitaria, la gestión de Ajal Lol y la aportación de Mariana Trinitaria, se llevaron programas de abastecimiento de agua a varias comunidades mediante tinacos de almacenamiento, beneficiando a más de 400 familias.', 6, 1, '2026-04-26 22:33:16', '2026-04-26 22:33:16');

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

--
-- Volcado de datos para la tabla `actividad_anos`
--

INSERT INTO `actividad_anos` (`id_ano`, `id_pagina`, `ano`, `visible`, `created_at`, `updated_at`) VALUES
(1, 4, 2023, 1, '2026-04-26 22:33:16', '2026-04-26 22:33:16');

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

--
-- Volcado de datos para la tabla `aliados`
--

INSERT INTO `aliados` (`id_aliados`, `id_pagina`, `titulo_seccion`, `descripcion`) VALUES
(1, 3, 'Aliados', 'Nuestros aliados');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aliados_imagenes`
--

CREATE TABLE `aliados_imagenes` (
  `id_imagen` int NOT NULL,
  `id_aliados` int NOT NULL,
  `img_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `aliados_imagenes`
--

INSERT INTO `aliados_imagenes` (`id_imagen`, `id_aliados`, `img_path`) VALUES
(1, 1, 'aliados/cgeikVxiRdGnRimowolydT9XYUI9xA5M26jha3Ah.png'),
(2, 1, 'aliados/rtEjY2kTK22VPa3aQ7rwXgZriRSIcRIomuiywEoI.png'),
(3, 1, 'aliados/HQnJZnOHcqQxnOg0EiDmlGHHS5nGyUB5PHU8QC5h.png'),
(4, 1, 'aliados/iwf1IQn16JhEvDXuxZ7N6DpBWgSmIeHsXOaQVZNH.png'),
(5, 1, 'aliados/anaad9YTAGKqGt61kEMfMIWI0csqYUH8IJBHoRCl.png'),
(6, 1, 'aliados/6IEuZ1zblLaNtiulFKM5AbKqknZNznKY2omnrt7u.png'),
(7, 1, 'aliados/LPFqnSxVFf0DffXbXqXK0o9lWPuBsLfnFy6qAa2v.png'),
(8, 1, 'aliados/UNP1CyxBeD96OtiYsALS9YqTm1NeQYx7OdHafeon.png');

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

--
-- Volcado de datos para la tabla `asistenciabeneficiarios`
--

INSERT INTO `asistenciabeneficiarios` (`id_asistenciabeneficiario`, `id_informe`, `asistencianombrebeneficiario`, `asistenciaedadbeneficiario`, `created_at`) VALUES
(1, 1, 'J', 43, '2026-04-28 21:59:53'),
(2, 1, '1', 21, '2026-04-28 21:59:53'),
(3, 1, '2', 21, '2026-04-28 21:59:53'),
(4, 1, '2', 42, '2026-04-28 21:59:53'),
(5, 1, '3', 21, '2026-04-28 21:59:53'),
(6, 1, '2', 43, '2026-04-28 21:59:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-04631642adab1a7d4a1d76eaa64321c7', 'i:3;', 1777138350),
('laravel-cache-04631642adab1a7d4a1d76eaa64321c7:timer', 'i:1777138350;', 1777138350),
('laravel-cache-472dbcf019445efa7c02a6fb8565eeee', 'i:1;', 1777414314),
('laravel-cache-472dbcf019445efa7c02a6fb8565eeee:timer', 'i:1777414314;', 1777414314),
('laravel-cache-c5d45e590efb5ee912f68f9060c3acef', 'i:1;', 1777138333),
('laravel-cache-c5d45e590efb5ee912f68f9060c3acef:timer', 'i:1777138333;', 1777138333);

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

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id_contacto`, `id_pagina`, `direccion_contacto`, `telefono_contacto`, `email_contacto`, `horario_contacto`, `mapa_embed`, `facebook_url`, `instagram_url`, `linkedin_url`, `activo`) VALUES
(1, 8, 'Calle 24 # 99 x 21 y 19 Col. Centro Hoctún, Yucatán.', '+52 9991773532', 'ajal-lol@hotmail.com', 'Horario de atención: de 9:00 a.m. a 1:00 p.m. de lunes a viernes.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d742.7330411277217!2d-89.20539661370069!3d20.867021922962046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f5691003bea8d97%3A0xc86a2696d1d97c7b!2sAjal-Lol%20A.C!5e0!3m2!1ses-419!2smx!4v1777240930555!5m2!1ses-419!2smx\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://www.facebook.com/p/Ajal-Lol-AC-100064161455063/', 'https://www.instagram.com/ajal_lol/?hl=es-la', 'https://mx.linkedin.com/in/ajal-lol-a-c-103b811a0', 1);

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

--
-- Volcado de datos para la tabla `directiva`
--

INSERT INTO `directiva` (`id_directiva`, `id_pagina`, `titulo_directiva`, `subtitulo_directiva`, `nombre_directiva`, `cargo_directiva`, `foto_directiva`, `orden_directiva`) VALUES
(4, 6, 'Directiva', 'Comité Directivo:', 'LEG. Jenevy Ríos Pech.', 'Secretaria', 'directiva/Bd9TbgRBubTyouiKcDrjyhw4d2Kml6dHN33Pr3f2.png', 1),
(5, 6, NULL, NULL, 'Br. Mirna El Pech', 'Tesorera', 'directiva/YIOBSq0tGrmnTFPxBb5kBLJon4N0ATXSENEdhy9H.png', 2),
(6, 6, NULL, NULL, 'Ing. Paula Guadalupe Pech Puc', 'Presidenta', 'directiva/Dq2jBL5ln3A8kcdBufFzIYHLSB7U5ajCu5s4wABQ.png', 3);

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

--
-- Volcado de datos para la tabla `donaciones`
--

INSERT INTO `donaciones` (`id_donacion`, `id_pagina`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-04-28 00:52:00', '2026-04-28 00:52:00');

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

--
-- Volcado de datos para la tabla `donaciones_bancario`
--

INSERT INTO `donaciones_bancario` (`id_bancario`, `id_donacion`, `beneficiario`, `banco`, `clabe`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ajal-Lol AC', 'ScotiaBank', '044910170030433636', '2026-04-28 00:53:15', '2026-04-29 14:49:11');

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

--
-- Volcado de datos para la tabla `donaciones_info`
--

INSERT INTO `donaciones_info` (`id_info`, `id_donacion`, `titulo`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 1, '!Tu apoyo transforma vidas!', 'Las donaciones se utilizan para financiar nuestras iniciativas, apoyar a la comunidad y mantener en funcionamiento nuestros proyectos. Cada aporte, sin importar el monto, suma.', '2026-04-28 00:52:00', '2026-04-28 00:52:00');

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

--
-- Volcado de datos para la tabla `donaciones_paypal`
--

INSERT INTO `donaciones_paypal` (`id_paypal`, `id_donacion`, `paypal_usuario`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2026-04-28 00:53:30', '2026-04-29 14:49:59');

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
(1, 'Ajal-lol AC', 'Entrega de huevo', 'Hoctún, Yucatán', '2026-04-28', '2026-04-28 21:59:53', '2026-04-28 21:59:53');

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

--
-- Volcado de datos para la tabla `inicio`
--

INSERT INTO `inicio` (`id_inicio`, `id_pagina`, `eyebrow`, `titulo_principal`, `titulo_em`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 1, 'Organización sin fines de lucro', 'Bienvenidos al portal informativo', 'Ajal Lol A.C.', 'Ayudando vidas.', '2026-04-26 21:42:25', '2026-04-26 21:42:39');

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

--
-- Volcado de datos para la tabla `inicio_estadisticas`
--

INSERT INTO `inicio_estadisticas` (`id_estadistica`, `id_pagina`, `ano`, `beneficiarios`, `proyectos`, `horas_apoyo`, `voluntarios`, `bd_include`, `created_at`, `updated_at`) VALUES
(1, 1, 2023, 7451, 5, 1463, 35, 0, '2026-04-26 21:45:10', '2026-04-26 21:45:18');

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

--
-- Volcado de datos para la tabla `inicio_videos`
--

INSERT INTO `inicio_videos` (`id_video`, `id_inicio`, `titulo`, `youtube_url`, `orden`, `created_at`, `updated_at`) VALUES
(1, 1, 'Video Institucional Ajal Lol AC', 'https://www.youtube.com/watch?v=lRM7kJdDUM4', 1, '2026-04-27 23:05:32', '2026-04-27 23:05:32');

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

--
-- Volcado de datos para la tabla `nosotros`
--

INSERT INTO `nosotros` (`id_nosotros`, `id_pagina`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-04-26 21:48:51', '2026-04-26 21:48:51');

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

--
-- Volcado de datos para la tabla `nosotros_encabezado`
--

INSERT INTO `nosotros_encabezado` (`id_encabezado`, `id_nosotros`, `titulo`, `subtitulo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nosotros', 'Conoce más sobre nosotros', '2026-04-26 21:49:46', '2026-04-26 21:49:46');

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

--
-- Volcado de datos para la tabla `nosotros_historia`
--

INSERT INTO `nosotros_historia` (`id_historia`, `id_nosotros`, `imagen`, `badge_texto`, `etiqueta_superior`, `titulo_bloque`, `texto_destacado`, `texto_descriptivo`, `created_at`, `updated_at`) VALUES
(1, 1, 'nosotros/FkO8UEezDKjs7Vube9aOVv0lNALpsxU0JBJewfuP.jpg', 'Fundada en el 2000', 'Nuestra historia', 'Así comenzó Ajal Lol', 'La organización fue fundada en el año 2000 por 5 mujeres quienes compartían la inquietud de buscar una manera de ayudar a las personas de escasos recursos. Actualmente el comité directivo lo conforman 8 mujeres y su trabajo es apoyado por 35 colaboradores y voluntarios.', 'Para nosotros como asociación es muy importante el papel que jugamos en la sociedad, siempre hemos buscado que nuestras acciones tengan un impacto positivo llegando al mayor número posible de beneficiarios. A través de nuestras campañas de salud hemos ayudado a las personas a cambiar hábitos alimenticios, detectar enfermedades a tiempo, promover el cuidado de la salud, mejorar su higiene y dar valor al cuidado físico y emocional.', '2026-04-26 21:48:51', '2026-04-26 21:49:39');

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

--
-- Volcado de datos para la tabla `nosotros_identidad`
--

INSERT INTO `nosotros_identidad` (`id_identidad`, `id_nosotros`, `titulo`, `subtitulo`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nuestra identidad', 'Los principios que nos guían', '2026-04-26 22:21:50', '2026-04-26 22:21:50');

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

--
-- Volcado de datos para la tabla `nosotros_identidad_items`
--

INSERT INTO `nosotros_identidad_items` (`id_item`, `id_identidad`, `tipo`, `titulo`, `contenido`, `orden`, `created_at`, `updated_at`) VALUES
(1, 1, 'mision', 'Misión', 'Impulsar programas que aporten postiviamente al desarrollo integral de las familias en situación vulnerable.', 1, '2026-04-26 22:21:50', '2026-04-26 22:21:50'),
(2, 1, 'vision', 'Visión', 'Ser un referente a nivel nacional como una organización que apoya al desarrollo integral en materia de salud y capacitación para el trabajo. Generar espacios de participación y mejora que ayuden al bienestar social de las familias yucatecas.', 2, '2026-04-26 22:21:50', '2026-04-26 22:21:50'),
(3, 1, 'objetivo', 'Objetivo General', 'Contribuir al mejoramiento de la calidad de vida de las personas que viven en situación vulnerable de las comunidades mayas de Yucatán', 3, '2026-04-26 22:21:50', '2026-04-26 22:21:50'),
(4, 1, 'valores', 'Valores', 'Solidaridad: ser empáticos con la situación de cada beneficiario, atender sus necesidades más apremiantes, ayudarlo y orientarlo.\n\nLa igualdad: apoyar con amor y respeto a cada beneficiario y colaborador, sin importar su sexo, lenguaje o religión. Nuestro objetivo es contribuir a cada familia sin importar sus condiciones e ideas.\n\nCompromiso: un trato digno y ágil, es lo que caracteriza a nuestro equipo, el trabajo social debe hacerse con pasión y entrega, es por ello, que nuestros directivos y colaboradores tienen bien clara la importancia de ser comprometidos.\n\nInterculturalidad: en Ajal Lol estamos abiertos a conocer, convivir, intercambiar y aprender de cada uno de nuestros beneficiarios, donantes y colaboradores.', 4, '2026-04-26 22:21:50', '2026-04-26 22:21:50');

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

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_notificacion`, `id_usuario`, `id_formulario`, `titulo`, `mensaje`, `leido`, `created_at`) VALUES
(107, 1, NULL, 'Nueva solicitud de: a', 'w — q', 0, '2026-04-28 22:01:54');

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

--
-- Volcado de datos para la tabla `preguntas_frecuentes`
--

INSERT INTO `preguntas_frecuentes` (`id_preguntasfrecuentes`, `id_pagina`, `titulo_pregunta`, `texto_respuesta`) VALUES
(1, 7, '¿Te interesa apoyar como colaborador?', 'Sí, siempre estamos abiertos a sumar personas comprometidas con nuestra causa. Si deseas participar como colaborador o voluntario, puedes ponerte en contacto con nosotros a través de nuestros medios de comunicación.'),
(2, 7, '¿Estás interesado en donar?', 'Tu apoyo hace la diferencia. Puedes contribuir con donaciones económicas o en especie para ayudar a impulsar nuestros proyectos y beneficiar a quienes más lo necesitan. Contáctanos para conocer las opciones disponibles.'),
(3, 7, '¿Eres profesionista y quisieras aportar con tus conocimientos y servicios?', 'Tu experiencia puede generar un gran impacto. Te invitamos a colaborar ofreciendo tus conocimientos y servicios en beneficio de nuestras comunidades. Contáctanos para conocer cómo integrarte.');

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

--
-- Volcado de datos para la tabla `proyecto_anos`
--

INSERT INTO `proyecto_anos` (`id_ano`, `id_pagina`, `ano`, `subtitulo`, `visible`, `created_at`, `updated_at`) VALUES
(2, 5, 2023, NULL, 1, '2026-04-26 21:39:46', '2026-04-26 21:39:46'),
(3, 5, 2024, 'Nuestros proyectos 2024', 1, '2026-04-26 22:34:51', '2026-04-26 22:35:26');

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

--
-- Volcado de datos para la tabla `proyecto_categorias`
--

INSERT INTO `proyecto_categorias` (`id_categoria`, `nombre`, `orden`, `created_at`) VALUES
(2, 'Jornadas dentales', 0, '2026-04-26 22:36:14'),
(3, 'Jornadas de salud y oftalmológicas', 0, '2026-04-26 22:36:14'),
(4, 'Proyectos productivos', 0, '2026-04-26 22:36:14'),
(5, 'Entrega de despensas', 0, '2026-04-26 22:36:14'),
(6, 'Gestión de tinacos', 0, '2026-04-26 22:36:14');

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

--
-- Volcado de datos para la tabla `proyecto_imagenes`
--

INSERT INTO `proyecto_imagenes` (`id_imagen`, `id_ano`, `id_categoria`, `titulo`, `image_path`, `description`, `event_date`, `created_at`, `updated_at`) VALUES
(5, 3, 2, 'Jornada dental gratuita', 'proyectos/lbzzYrPnaIJbNzA3NlSeyhkdBhOOMznAbKHswKyj.jpg', 'Acabando con las caries.', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58'),
(6, 3, 2, 'Jornada dental para quienes más lo necesitan.', 'proyectos/ZSYjemLzcEEhqaC113iJ7c5AyIqiR1PgxqfpxaeT.jpg', 'Una pequeña contribución a la comunidad.', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58'),
(7, 3, 3, 'Celebración al 10 de mayo.', 'proyectos/n6hdHnOYaAG2avUWiAHKQlI8TDVwzVKg6Jzb85Ix.jpg', 'Donación de palanganas a las mujeres más luchonas.', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58'),
(8, 3, 3, 'Celebración al 10 de mayo', 'proyectos/L7TCdRoMhOHIvyi4HYUnYTLoXqu3BXJKLqObiVT5.jpg', 'Donación de palanganas a las mujeres de la casa.', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58'),
(9, 3, 4, 'Programa engorda pavo', 'proyectos/F4FbOxJxlZ91Ri3DxUe7NiR6oAbkCaG5uJJzMAcM.jpg', 'Programa de Engorda de pavos de traspatio que se llevó a cabo en la primera etapa en 15 localidades del Estado de Yucatán', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58'),
(10, 3, 4, 'Engorda de pavos', 'proyectos/xbUu0o8EqQDzBwz3tKPs4LKAPYY5SZAfd1o2uMW5.jpg', 'Programa de Engorda de pavos de traspatio que se llevó a cabo en la primera etapa en 15 localidades del Estado de Yucatán', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58'),
(11, 3, 4, 'Engorda de pavos', 'proyectos/eRFkSenoofUfaflTWOdZt9MyRtUjbbciU6FYdnnu.jpg', 'Programa de Engorda de pavos de traspatio que se llevó a cabo en la primera etapa en 15 localidades del Estado de Yucatán', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58'),
(12, 3, 5, 'Día del Adulto Mayor', 'proyectos/qcQyLlXuMlkxBwEaYQXAl7hcYVdTLaR9QzrQ60yL.jpg', 'La comunidad tomó un curso sobre el día el cuidado que pueden tener los adultos a cierta edad.', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58'),
(13, 3, 5, 'Día del Adulto Mayor', 'proyectos/KxWbyxqsiKa2SSa0cOyrX1zol1nrMen7wOoupFzF.jpg', 'Se realizarón actividades para los adultos para beneficiar su salud.', '2026-04-26', '2026-04-26 22:44:58', '2026-04-26 22:44:58');

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
(9, 9, 'administrador');

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

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lMmJBcuFkGSaZLj0OB6ThypdmcI6riLTHHVMScxz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiUDVXWm13YVg2UEpJT3dlc1FvazBycEpaa0RNaDRZejl4QmR4cEJ0cyI7czo3OiJ1c2VyX2lkIjtpOjk7czo2OiJub21icmUiO3M6MTk6IlJhZmFlbCBOaWMgU2FuZG92YWwiO3M6NToiZW1haWwiO3M6MzE6InJhZmFlbG5pY3NhbmRvdmFsMjAwMkBnbWFpbC5jb20iO3M6Mzoicm9sIjtzOjEzOiJhZG1pbmlzdHJhZG9yIjtzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo1MToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2FwaS9ub3RpZmljYXRpb25zL2NvdW50IjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1777478261);

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
  `contraseña_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notif_email` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `contraseña_usuario`, `notif_email`) VALUES
(1, 'Rodolfo Navarrete Ek', 'rodolfonavarreteek@gmail.com', '$2y$12$BxrxEDu56qd3K16hbAT5TO7I9h9cdgNTY2FdzAhmEU9HoaPz/h9nu', 1),
(9, 'Rafael Nic Sandoval', 'rafaelnicsandoval2002@gmail.com', '$2y$12$PGS8ZHIYrxV/aBmwvI66bOm33q1J4sxT.G5kxJD5cv/1ZecakSVm.', 0);

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
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `actividad_anos`
--
ALTER TABLE `actividad_anos`
  MODIFY `id_ano` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `aliados`
--
ALTER TABLE `aliados`
  MODIFY `id_aliados` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `aliados_imagenes`
--
ALTER TABLE `aliados_imagenes`
  MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `asistenciabeneficiarios`
--
ALTER TABLE `asistenciabeneficiarios`
  MODIFY `id_asistenciabeneficiario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id_contacto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `directiva`
--
ALTER TABLE `directiva`
  MODIFY `id_directiva` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id_donacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `donaciones_bancario`
--
ALTER TABLE `donaciones_bancario`
  MODIFY `id_bancario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `donaciones_info`
--
ALTER TABLE `donaciones_info`
  MODIFY `id_info` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `donaciones_paypal`
--
ALTER TABLE `donaciones_paypal`
  MODIFY `id_paypal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  MODIFY `id_formcontacto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id_informe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inicio`
--
ALTER TABLE `inicio`
  MODIFY `id_inicio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inicio_estadisticas`
--
ALTER TABLE `inicio_estadisticas`
  MODIFY `id_estadistica` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inicio_videos`
--
ALTER TABLE `inicio_videos`
  MODIFY `id_video` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_nosotros` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `nosotros_encabezado`
--
ALTER TABLE `nosotros_encabezado`
  MODIFY `id_encabezado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `nosotros_historia`
--
ALTER TABLE `nosotros_historia`
  MODIFY `id_historia` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `nosotros_identidad`
--
ALTER TABLE `nosotros_identidad`
  MODIFY `id_identidad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `nosotros_identidad_items`
--
ALTER TABLE `nosotros_identidad_items`
  MODIFY `id_item` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id_notificacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT de la tabla `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id_pagina` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  MODIFY `id_preguntasfrecuentes` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proyecto_anos`
--
ALTER TABLE `proyecto_anos`
  MODIFY `id_ano` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proyecto_categorias`
--
ALTER TABLE `proyecto_categorias`
  MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `proyecto_imagenes`
--
ALTER TABLE `proyecto_imagenes`
  MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `reportebeneficiarios`
--
ALTER TABLE `reportebeneficiarios`
  MODIFY `id_reportebeneficiario` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `id_rol_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
