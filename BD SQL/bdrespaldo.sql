-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-04-2026 a las 03:19:12
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
-- Base de datos: `prueba14`
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
(1, 1, 'Jornada dental', 'fa-tooth', 'Por segundo año consecutivo, se realizaron jornadas de servicios dentales con el apoyo de la Fundación Smile y Global Dental. Un equipo de 35 dentistas brindó servicios gratuitos, atendiendo a 159 pacientes de varios municipios.', 1, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(2, 1, 'Jornada de salud', 'fa-heart-pulse', 'Realizamos 2 jornadas de salud en Hoctún con detección gratuita de niveles de azúcar, presión arterial, peso, talla, vista y orientación psicológica, beneficiando a 300 personas.', 2, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(3, 1, 'Talleres de capacitación', 'fa-chalkboard', 'Con el apoyo de Mentors International, se realizaron cursos de administración básica para pequeños emprendedores en varios municipios, beneficiando a 150 personas.', 3, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(4, 1, 'Reforestación', 'fa-tree', 'El Ayuntamiento de Mérida donó 1,666 plantas forestales y maderables a 11 localidades para reforestar predios de producción y traspatio.', 4, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(5, 1, 'Cría de pavos de engorda', 'fa-feather', 'Como seguimiento al proyecto iniciado en 2022 con donativos de OXXO que benefició a 350 familias, en 2023 se pudo continuar con el programa de engorda de pavos de traspatio.', 5, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(6, 1, 'Entrega de tinacos', 'fa-droplet', 'Gracias a la gestión de Ajal Lol y la aportación de Mariana Trinitaria, se llevaron programas de abastecimiento de agua a varias comunidades, beneficiando a más de 400 familias.', 6, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(7, 2, 'Brigada de salud visual', 'fa-eye', 'Se realizaron jornadas de detección de problemas visuales en 5 comunidades del oriente de Yucatán, con la donación de más de 200 pares de lentes gratuitos a adultos mayores y niños en edad escolar.', 1, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(8, 2, 'Huertos familiares', 'fa-seedling', 'Programa de huertos en traspatio para 180 familias de escasos recursos en municipios de la zona oriente, con entrega de semillas, herramientas y capacitación técnica para producción de alimentos.', 2, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(9, 2, 'Apoyo educativo', 'fa-graduation-cap', 'Entrega de útiles escolares, mochilas y material didáctico a más de 400 niños de comunidades rurales al inicio del ciclo escolar, con el apoyo de empresas aliadas del sector privado.', 3, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(10, 2, 'Despensa alimentaria', 'fa-utensils', 'Distribución de más de 600 despensas básicas a familias vulnerables en 8 municipios de Yucatán, incluyendo productos no perecederos, artículos de higiene personal y kits de limpieza del hogar.', 4, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(11, 2, 'Taller de emprendimiento', 'fa-briefcase', 'Se impartieron talleres de emprendimiento y finanzas personales a 120 jóvenes y adultos de comunidades marginadas, en alianza con el Instituto Nacional del Emprendedor.', 5, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(12, 2, 'Reforestación costera', 'fa-globe', 'Jornada de reforestación en zonas costeras del estado con la siembra de más de 2,000 árboles de mangle y especies nativas, en colaboración con la CONANP y voluntarios universitarios.', 6, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(13, 3, 'Jornada de salud integral', 'fa-stethoscope', 'Brigada de salud preventiva con servicios de medicina general, odontología, nutrición y psicología en comunidades rurales de Yucatán. Se atendieron más de 500 personas en 3 días de jornada continua.', 1, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(14, 3, 'Becas educativas', 'fa-certificate', 'Otorgamiento de 50 becas escolares a estudiantes de preparatoria y universidad provenientes de familias de bajos recursos, cubriendo materiales, inscripciones y transporte durante el ciclo escolar.', 2, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(15, 3, 'Programa adulto mayor', 'fa-wheelchair', 'Programa integral de atención al adulto mayor con visitas domiciliarias, entrega de medicamentos, actividades recreativas y acompañamiento emocional a más de 300 personas en situación de vulnerabilidad.', 3, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(16, 3, 'Cisternas comunitarias', 'fa-droplet', 'Construcción e instalación de 15 cisternas de captación de agua pluvial en comunidades sin acceso a agua potable de la zona maya, beneficiando a más de 200 familias con agua de calidad durante todo el año.', 4, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(17, 3, 'Festival cultural maya', 'fa-music', 'Organización del primer festival cultural maya con presentaciones de danza, música tradicional, artesanías y gastronomía local, reuniendo a más de 1,200 asistentes y promoviendo la identidad cultural de las comunidades.', 5, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(18, 3, 'Capacitación agrícola', 'fa-tractor', 'Talleres de agricultura sustentable y técnicas de cultivo orgánico para 90 productores rurales, incluyendo el uso de abonos naturales, control de plagas y sistemas de riego eficiente.', 6, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(19, 4, 'Campaña de nutrición infantil', 'fa-heart', 'Programa de nutrición dirigido a niños menores de 5 años en zonas de alta marginación, con entrega de suplementos alimenticios, orientación nutricional a madres y seguimiento mensual del estado de salud de los menores.', 1, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(20, 4, 'Techo y hogar digno', 'fa-house', 'Proyecto de mejoramiento de vivienda para 20 familias en situación de pobreza extrema, con reparación de techos, pisos firmes y servicios básicos de saneamiento en coordinación con instituciones de gobierno.', 2, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(21, 4, 'Biblioteca comunitaria', 'fa-book-open', 'Apertura de la primera biblioteca comunitaria itinerante de la asociación, con más de 1,500 libros donados, talleres de lectura para niños y adultos y acceso gratuito a computadoras con internet en 4 comunidades.', 3, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(22, 4, 'Brigada veterinaria', 'fa-paw', 'Jornada de esterilización, vacunación antirrábica y desparasitación gratuita para mascotas de familias de escasos recursos, con la participación de 12 médicos veterinarios voluntarios y la atención de más de 350 animales.', 4, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(23, 4, 'Empleo rural', 'fa-hammer', 'Programa de inserción laboral y capacitación en oficios técnicos para 80 jóvenes rurales desempleados, con talleres de albañilería, plomería, electricidad y costura, además de bolsa de trabajo con empresas locales.', 5, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18'),
(24, 4, 'Medio ambiente limpio', 'fa-recycle', 'Campaña de limpieza y reciclaje en 10 comunidades del estado con recolección de más de 5 toneladas de residuos sólidos, instalación de contenedores de separación y talleres de educación ambiental para niños y adultos.', 6, 1, '2026-04-17 17:25:18', '2026-04-17 17:25:18');

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
(1, 4, 2023, 1, '2026-04-17 17:25:18', '2026-04-18 00:10:38'),
(2, 4, 2024, 1, '2026-04-17 17:25:18', '2026-04-18 00:02:02'),
(3, 4, 2025, 1, '2026-04-17 17:25:18', '2026-04-17 23:31:32'),
(4, 4, 2026, 1, '2026-04-17 17:25:18', '2026-04-17 23:31:31');

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
(1, 3, 'Aliados de Ajal-Lol', 'Nuestro compromiso se expande con nuestros aliados.');

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
(1, 1, 'aliados/IuEzRImAUgnAHrKU8vYegfuQRr6drtWrVpWOIyZY.jpg'),
(2, 1, 'aliados/6OPxoH1tJUaPM1aC9lV98ti8CfAG7iskvSpLV9jN.jpg'),
(3, 1, 'aliados/bCRQxmOzV0Bco3eZE5zvpnjmsUAgqOhD8kCro1Qj.jpg'),
(4, 1, 'aliados/eN7eHjENZ3SEJlOmjOt6tnRA0uqRywA6oOnPHKb0.jpg'),
(5, 1, 'aliados/JhpGxS1vDGWzjUNbTGWtHDsKYTfl8ztViwomzNqU.jpg'),
(6, 1, 'aliados/40usDwTnCR9zubewTH5j4qJeFceM73Mwb3tSNcd8.jpg');

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
(1, 1, 'Efrén Villacis', 23, '2026-04-19 22:24:12'),
(2, 1, 'Leon Dan', 23, '2026-04-19 22:24:12'),
(3, 1, 'Cangrellero', 23, '2026-04-19 22:24:12'),
(4, 1, 'Rodylex', 23, '2026-04-19 22:24:12'),
(5, 1, 'Foconacio', 23, '2026-04-19 22:24:12'),
(6, 1, 'Estamos navarrete', 23, '2026-04-19 22:24:12');

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

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id_contacto`, `id_pagina`, `direccion_contacto`, `telefono_contacto`, `email_contacto`, `horario_contacto`, `mapa_embed`, `facebook_url`, `instagram_url`, `linkedin_url`, `activo`) VALUES
(1, 8, 'Calle 18 por 22 Hoctun', '+52 999 177 3532', 'ajal-lol@hotmail.com', 'Lun–Vie · 9:00 a.m. – 1:00 p.m.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3728.111714119478!2d-89.2076931768885!3d20.867546980741725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f56912d96ed21b7%3A0x7f3fade0d648ccf!2sAjal%20-%20Lol%20A.C.!5e0!3m2!1ses-419!2smx!4v1776449248270!5m2!1ses-419!2smx\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'https://www.facebook.com/p/Ajal-Lol-AC-100064161455063/', 'https://www.instagram.com/ajal_lol/?hl=es-la', 'https://mx.linkedin.com/in/ajal-lol-a-c-103b811a0', 1);

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
(1, 6, 'Directiva', 'Comité Directivo', 'María Guadalupe Dzul Pech', 'Presidenta', NULL, 1),
(2, 6, 'Directiva', 'Comité Directivo', 'Rosa Elena Canul Tzab', 'Vicepresidenta', NULL, 2),
(3, 6, 'Directiva', 'Comité Directivo', 'Ana Lucía Moo Cauich', 'Secretaria', NULL, 3),
(4, 6, 'Directiva', 'Comité Directivo', 'Sofía Beatriz Pech Dzib', 'Tesorera', NULL, 4),
(5, 6, 'Directiva', 'Comité Directivo', 'Carmen Itzél Tun Balam', 'Vocal 1', NULL, 5),
(6, 6, 'Directiva', 'Comité Directivo', 'Patricia Yolanda Ek Caamal', 'Vocal 2', NULL, 6),
(7, 6, 'Directiva', 'Comité Directivo', 'Leticia Marisol Cauich Cocom', 'Vocal 3', NULL, 7),
(8, 6, 'Directiva', 'Comité Directivo', 'Miriam Concepción Chi Poot', 'Vocal 4', NULL, 8);

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
(1, 1, '2026-04-21 09:15:11', '2026-04-21 09:15:11');

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

--
-- Volcado de datos para la tabla `donaciones_paypal`
--

INSERT INTO `donaciones_paypal` (`id_paypal`, `id_donacion`, `paypal_usuario`, `created_at`, `updated_at`) VALUES
(1, 1, 'https://www.paypal.com/paypalme/tuusuario/100', '2026-04-21 09:15:11', '2026-04-21 09:15:12');

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
-- Volcado de datos para la tabla `formulario_contacto`
--

INSERT INTO `formulario_contacto` (`id_formcontacto`, `nombre_completo`, `correo`, `numero_telefonico`, `asunto`, `mensaje`, `fecha_envio`) VALUES
(1, 'Rafael Sánchez Martín', 'admin@ajallol.com', '9991208921', 'Quiero colaborar', 'Hola', '2026-04-20 10:05:23');

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
(1, 'Ajal-lol AC', 'Superestamos', 'Akil, Yucatán', '2026-04-19', '2026-04-20 04:24:12', '2026-04-20 04:24:12'),
(2, 'Ajal-lol AC', 'Superestamos reporte', 'Akil, Yucatán', '2026-04-19', '2026-04-20 04:38:04', '2026-04-20 04:38:04');

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
(1, 1, 'Organización sin fines de lucro', 'Portal informativo de', 'Ajal Lol A.C.', 'Ajal Lol A.C. es una organización de asistencia social sin fines de lucro', '2026-04-21 03:23:04', '2026-04-21 03:23:04');

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
(1, 1, 2023, 7451, 5, 1463, 35, 0, '2026-04-19 18:22:03', '2026-04-20 22:48:04'),
(2, 1, 2024, 0, 0, 0, 0, 0, '2026-04-19 18:22:03', '2026-04-20 22:48:04'),
(5, 1, 2025, 0, 0, 0, 0, 0, '2026-04-19 19:22:40', '2026-04-20 22:48:04'),
(6, 1, 2026, 32, 0, 0, 0, 1, '2026-04-19 19:22:40', '2026-04-20 22:48:04');

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
(1, 1, 'Nuestra historia', 'https://www.youtube.com/watch?v=820QWnTYBzw', 1, '2026-04-21 03:23:37', '2026-04-21 03:23:37');

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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `nosotros`
--

INSERT INTO `nosotros` (`id_nosotros`, `id_pagina`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-04-19 02:44:22', '2026-04-19 02:44:22');

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
(1, 1, 'Nosotros', 'Conoce más sobre nuestra historia', '2026-04-19 02:44:22', '2026-04-19 02:44:22');

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
(1, 1, 'nosotros/AP1T2f692MaJTPubQ1ijRttPoqfLyqXuzHUAT4Wp.jpg', 'Fundada en el año 2000', 'Nuestra Historia', 'Así comenzó Ajal Lol', 'La organización fue fundada en el año 2000 por 5 mujeres que compartían la inquietud de buscar una manera de ayudar a las personas de escasos recursos. Actualmente el comité directivo lo conforman 8 mujeres y su trabajo es apoyado por 35 colaboradores y voluntarios.', 'Para nosotros como asociación es muy importante el papel que jugamos en la sociedad. Siempre hemos buscado que nuestras acciones tengan un impacto positivo llegando al mayor número posible de beneficiarios.', '2026-04-19 02:44:22', '2026-04-19 08:44:54');

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
(1, 1, 'Nuestra Identidad', 'Los principios que nos guían', '2026-04-19 02:44:22', '2026-04-19 02:44:22');

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
(1, 1, 'mision', 'Misión', 'Impulsar programas que aporten positivamente al desarrollo integral de las familias en situación vulnerable.', 1, '2026-04-19 02:44:22', '2026-04-19 02:44:22'),
(2, 1, 'vision', 'Visión', 'Ser un referente a nivel nacional como organización que apoya el desarrollo integral en materia de salud y capacitación para el trabajo.', 2, '2026-04-19 02:44:22', '2026-04-19 02:44:22'),
(3, 1, 'objetivo', 'Objetivo General', 'Contribuir al mejoramiento de la calidad de vida de las personas que viven en situación vulnerable de las comunidades mayas de Yucatán.', 3, '2026-04-19 02:44:22', '2026-04-19 02:44:22'),
(4, 1, 'valores', 'Valores', 'Solidaridad: ser empáticos y atender las necesidades de cada beneficiario.\nIgualdad: apoyo con amor y respeto, sin distinción.\nCompromiso: trato digno y trabajo social con pasión.\nInterculturalidad: apertura para convivir y aprender.', 4, '2026-04-19 02:44:22', '2026-04-19 02:44:22');

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
(1, 1, 1, 'Nueva solicitud de: Rafael Sánchez Martín', 'Quiero colaborar — Hola', 0, '2026-04-20 16:05:23'),
(2, 5, 1, 'Nueva solicitud de: Rafael Sánchez Martín', 'Quiero colaborar — Hola', 0, '2026-04-20 16:05:23'),
(3, 8, 1, 'Nueva solicitud de: Rafael Sánchez Martín', 'Quiero colaborar — Hola', 0, '2026-04-20 16:05:23');

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

--
-- Volcado de datos para la tabla `preguntas_frecuentes`
--

INSERT INTO `preguntas_frecuentes` (`id_preguntasfrecuentes`, `id_pagina`, `titulo_pregunta`, `texto_respuesta`) VALUES
(1, 7, '¿Qué es Ajal Lol A.C.?', 'Ajal Lol A.C. es una organización de asistencia social sin fines de lucro fundada en el año 2000 por un grupo de mujeres comprometidas con el bienestar de las comunidades mayas de Yucatán. Su nombre significa \"flor que renace\" en lengua maya.'),
(2, 7, '¿Cómo puedo hacer una donación?', 'Puedes realizar tu donación a través de nuestra cuenta de PayPal disponible en la sección de pie de página, o contactarnos directamente por correo electrónico o teléfono para coordinar una donación en especie o transferencia bancaria.'),
(3, 7, '¿En qué municipios operan?', 'Trabajamos principalmente en comunidades rurales y municipios de alta marginación del estado de Yucatán, con presencia especial en la zona oriente y sur del estado, incluyendo localidades de los municipios de Hoctún, Izamal, Akil, Tekit y otras comunidades mayas.'),
(4, 7, '¿Cómo puedo ser voluntario?', 'Si deseas unirte como voluntario, puedes contactarnos a través del formulario de contacto de esta página o escribirnos directamente a nuestro correo electrónico. Evaluamos cada solicitud y te informaremos sobre las actividades en las que puedes participar.'),
(5, 7, '¿Qué tipo de apoyos brindan?', 'Brindamos una amplia variedad de apoyos que incluyen jornadas de salud, entrega de despensas alimentarias, talleres de capacitación para el trabajo, programas de reforestación, apoyo educativo con útiles escolares y becas, así como programas especiales para adultos mayores y niños.'),
(6, 7, '¿Cómo puedo obtener apoyo de la organización?', 'Para solicitar apoyo puedes comunicarte con nosotros a través del formulario de contacto, por teléfono o correo electrónico. Un miembro de nuestro equipo evaluará tu caso y te orientará sobre los programas disponibles según tus necesidades.'),
(7, 7, '¿La organización cuenta con reconocimiento oficial?', 'Sí, Ajal Lol A.C. está legalmente constituida como Asociación Civil y cuenta con los registros correspondientes ante las autoridades mexicanas, lo que nos permite emitir recibos deducibles de impuestos por las donaciones recibidas.'),
(8, 7, '¿Con qué frecuencia realizan actividades?', 'Realizamos actividades de manera continua a lo largo del año. Las jornadas de salud, entregas de despensas y talleres se programan mensualmente, mientras que proyectos especiales como reforestación y apoyo educativo se coordinan según las temporadas y necesidades de las comunidades.');

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
(1, 5, 2026, NULL, 1, '2026-04-20 01:51:15', '2026-04-20 01:51:15');

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

--
-- Volcado de datos para la tabla `reportebeneficiarios`
--

INSERT INTO `reportebeneficiarios` (`id_reportebeneficiario`, `id_informe`, `reportenombrebeneficiario`, `reportecurpbeneficiario`, `reporteedadbeneficiario`, `created_at`) VALUES
(1, 2, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', 12, '2026-04-19 22:38:04'),
(2, 2, 'Rodolfo Morales', 'GORM910305MDFMGN06', 24, '2026-04-19 22:38:04'),
(3, 2, 'Albert Wesker', 'MEPG980418MDFNRB16', 76, '2026-04-19 22:38:04'),
(4, 2, 'Gabriela Mendoza Paredes', 'NAOM970214HDFVRT10', 56, '2026-04-19 22:38:04'),
(5, 2, 'Miguel Ángel Navarro Ortiz', 'NISJ850320HYNCSF01', 54, '2026-04-19 22:38:04'),
(6, 2, 'Carlos Oliveira', 'PELJ880430HYNTRS03', 55, '2026-04-19 22:38:04');

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

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('PE46lxhYKn5N8CPnYI7umBh5dqVxIDSYAAC9YWWE', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiNjVrNU5hbTFPUUplZUtBVmg0VGlVUWVqMzFYcDBCVnp2R3I2MldjbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9hcGkvbm90aWZpY2F0aW9ucy9jb3VudCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo3OiJ1c2VyX2lkIjtpOjE7czo2OiJub21icmUiO3M6MjA6IlJvZG9sZm8gTmF2YXJyZXRlIEVrIjtzOjU6ImVtYWlsIjtzOjE3OiJhZG1pbkBhamFsbG9sLmNvbSI7czozOiJyb2wiO3M6MTM6ImFkbWluaXN0cmFkb3IiO30=', 1776640215);

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
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `actividad_anos`
--
ALTER TABLE `actividad_anos`
  MODIFY `id_ano` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `aliados`
--
ALTER TABLE `aliados`
  MODIFY `id_aliados` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `aliados_imagenes`
--
ALTER TABLE `aliados_imagenes`
  MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id_directiva` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id_donacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_formcontacto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id_informe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `inicio`
--
ALTER TABLE `inicio`
  MODIFY `id_inicio` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inicio_estadisticas`
--
ALTER TABLE `inicio_estadisticas`
  MODIFY `id_estadistica` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id_notificacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `paginas`
--
ALTER TABLE `paginas`
  MODIFY `id_pagina` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  MODIFY `id_preguntasfrecuentes` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `proyecto_anos`
--
ALTER TABLE `proyecto_anos`
  MODIFY `id_ano` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_reportebeneficiario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
