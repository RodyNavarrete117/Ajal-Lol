-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 03-03-2026 a las 16:00:55
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
-- Estructura de tabla: `actividades`
-- --------------------------------------------------------

CREATE TABLE `actividades` (
  `id_actividad` int NOT NULL,
  `id_seccion` int NOT NULL,
  `anio_actividad` int DEFAULT NULL,
  `titulo_actividad` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_actividad` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `aliados`
-- --------------------------------------------------------

CREATE TABLE `aliados` (
  `id_aliados` int NOT NULL,
  `id_seccion` int NOT NULL,
  `img_aliados` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `beneficiarios`
-- --------------------------------------------------------

CREATE TABLE `beneficiarios` (
  `id_beneficiario` int NOT NULL,
  `id_informe` int NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `curp` char(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `beneficiarios` (`id_beneficiario`, `id_informe`, `nombre`, `curp`, `created_at`) VALUES
-- Informe 1
(1,  1, 'Juan Pérez López',      'PELJ900101HYNLPN09', '2026-02-20 18:06:10'),
(2,  1, 'Ana María López Tun',   'LOTA920305MYNPNN03', '2026-02-20 18:06:10'),
(3,  1, 'Carlos Méndez Chi',     'MECC880712HYNCHS02', '2026-02-20 18:06:10'),
-- Informe 2
(4,  2, 'Luis Fernández Pech',   'FEPL930212HYNPRR07', '2026-02-20 18:06:10'),
(5,  2, 'María Gómez Pool',      'GOPM950610MYNPRL08', '2026-02-20 18:06:10'),
-- Informe 3
(6,  3, 'José Chan Yam',         'CHYJ870914HYNMJR05', '2026-02-20 18:06:10'),
(7,  3, 'Daniela Torres Cauich', 'TOCD990120MYNTRN06', '2026-02-20 18:06:10'),
(8,  3, 'Miguel Uc Ek',          'UCEM910315HYNCMK04', '2026-02-20 18:06:10'),
(9,  3, 'Laura Canul Poot',      'CAPL920725MYNPLN02', '2026-02-20 18:06:10'),
-- Informe 22
(151, 22, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:05:35'),
(152, 22, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:05:35'),
(153, 22, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:05:35'),
(154, 22, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:05:35'),
(155, 22, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:05:35'),
(156, 22, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:05:35'),
-- Informe 30
(171, 30, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:20:28'),
(172, 30, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:20:28'),
(173, 30, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:20:28'),
(174, 30, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:20:28'),
(175, 30, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:20:28'),
(176, 30, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:20:28'),
-- Informe 31
(177, 31, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:22:21'),
(178, 31, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:22:21'),
(179, 31, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:22:21'),
(180, 31, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:22:21'),
(181, 31, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:22:21'),
(182, 31, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:22:21'),
-- Informe 32
(183, 32, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:25:03'),
(184, 32, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:25:03'),
(185, 32, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:25:03'),
(186, 32, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:25:03'),
(187, 32, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:25:03'),
(188, 32, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:25:03'),
-- Informe 37
(189, 37, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:28:43'),
(190, 37, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:28:43'),
(191, 37, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:28:43'),
(192, 37, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:28:43'),
(193, 37, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:28:43'),
(194, 37, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:28:43'),
-- Informe 43
(195, 43, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:32:40'),
(196, 43, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:32:40'),
(197, 43, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:32:40'),
(198, 43, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:32:40'),
(199, 43, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:32:40'),
(200, 43, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:32:40'),
-- Informe 44
(201, 44, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:33:53'),
(202, 44, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:33:53'),
(203, 44, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:33:53'),
(204, 44, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:33:53'),
(205, 44, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:33:53'),
(206, 44, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:33:53'),
-- Informe 45
(207, 45, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:35:01'),
(208, 45, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:35:01'),
(209, 45, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:35:01'),
(210, 45, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:35:01'),
(211, 45, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:35:01'),
(212, 45, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:35:01'),
-- Informe 48
(213, 48, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:37:39'),
(214, 48, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:37:39'),
(215, 48, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:37:39'),
(216, 48, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:37:39'),
(217, 48, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:37:39'),
(218, 48, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:37:39'),
-- Informe 49
(219, 49, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:38:15'),
(220, 49, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:38:15'),
(221, 49, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:38:15'),
(222, 49, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:38:15'),
(223, 49, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:38:15'),
(224, 49, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:38:15'),
-- Informe 53
(225, 53, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:51:41'),
(226, 53, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:51:41'),
(227, 53, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:51:41'),
(228, 53, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:51:41'),
(229, 53, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:51:41'),
(230, 53, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:51:41'),
-- Informe 54
(231, 54, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:52:20'),
(232, 54, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:52:20'),
(233, 54, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:52:20'),
(234, 54, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:52:20'),
(235, 54, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:52:20'),
(236, 54, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:52:20'),
-- Informe 57
(237, 57, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 18:53:34'),
(238, 57, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 18:53:34'),
(239, 57, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 18:53:34'),
(240, 57, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:53:34'),
(241, 57, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:53:34'),
(242, 57, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 18:53:34'),
-- Informe 58
(243, 58, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 21:54:30'),
(244, 58, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 21:54:30'),
(245, 58, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 21:54:30'),
(246, 58, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 21:54:30'),
(247, 58, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 21:54:30'),
(248, 58, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 21:54:30'),
-- Informe 59
(249, 59, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-02 22:09:53'),
(250, 59, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-02 22:09:53'),
(251, 59, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-02 22:09:53'),
(252, 59, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 22:09:53'),
(253, 59, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 22:09:53'),
(254, 59, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-02 22:09:53'),
-- Informe 60
(255, 60, 'José Rafael Nic Sandoval',   'NISJ850320HYNCSF01', '2026-03-03 15:31:04'),
(256, 60, 'Juan Carlos Pérez López',    'PELJ880430HYNTRS03', '2026-03-03 15:31:04'),
(257, 60, 'María Fernanda Gómez Ruiz',  'GORM910305MDFMGN06', '2026-03-03 15:31:04'),
(258, 60, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-03 15:31:04'),
(259, 60, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-03 15:31:04'),
(260, 60, 'Gabriela Mendoza Paredes',   'MEPG980418MDFNRB16', '2026-03-03 15:31:04'),
(261, 60, 'Valeria Peña Cabrera',       'PECV990120MYNPBR06', '2026-03-03 15:31:04'),
(262, 60, 'José López Reyes',           'LORJ860118HDFPYR07', '2026-03-03 15:31:04'),
(263, 60, 'Fernando Mendoza Silva',     'MESF840519HDFNLR11', '2026-03-03 15:31:04'),
(264, 60, 'Ángel Medina Torres',        'META900315HDFDTR21', '2026-03-03 15:31:04'),
(265, 60, 'Daniel Aguilar Reyes',       'AGRD880912HDFGLN23', '2026-03-03 15:31:04'),
(266, 60, 'Erika Pacheco Luna',         'PALE970201MDFCHS24', '2026-03-03 15:31:04'),
(267, 60, 'Francisco Ríos Mendoza',     'RIMF850617HDFNSR25', '2026-03-03 15:31:04'),
(268, 60, 'Guadalupe Castro Mejía',     'CAMG920403MDFSTL26', '2026-03-03 15:31:04');

-- --------------------------------------------------------
-- Estructura de tabla: `cache`
-- --------------------------------------------------------

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `cache_locks`
-- --------------------------------------------------------

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `categoria_proyectos`
-- --------------------------------------------------------

CREATE TABLE `categoria_proyectos` (
  `id_categoria` int NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `orden` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `contacto`
-- --------------------------------------------------------

CREATE TABLE `contacto` (
  `id_contacto` int NOT NULL,
  `id_seccion` int NOT NULL,
  `direccion_contacto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_contacto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `directiva`
-- --------------------------------------------------------

CREATE TABLE `directiva` (
  `id_directiva` int NOT NULL,
  `id_seccion` int NOT NULL,
  `nombre_directiva` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_directiva` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_directiva` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `failed_jobs`
-- --------------------------------------------------------

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `formulario_contacto`
-- --------------------------------------------------------

CREATE TABLE `formulario_contacto` (
  `id_formcontacto` int NOT NULL,
  `nombre_completo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_telefonico` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asunto` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci,
  `fecha_envio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `formulario_contacto` (`id_formcontacto`, `nombre_completo`, `correo`, `numero_telefonico`, `asunto`, `mensaje`, `fecha_envio`) VALUES
(1, 'Salomón Alcocer',        'soysalo123@gmail.com',       '999-273-4936', 'Me interesa colaborar',       'Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.', '2026-02-19 10:45:03'),
(2, 'María Fernanda López',   'maria.lopez@email.com',      '999-111-2233', 'Donación',                    'Buenas tardes, me gustaría realizar una donación y conocer el proceso.', '2026-02-19 10:45:03'),
(3, 'Carlos Méndez',          'carlos.mendez@email.com',    '999-555-7788', 'Información sobre proyectos', 'Quisiera recibir más información sobre los proyectos activos este año.', '2026-02-19 10:45:03'),
(4, 'Ana Rodríguez',          'ana.rodriguez@email.com',    NULL,           'Servicio social',             'Soy estudiante universitaria y estoy interesada en realizar mi servicio social con ustedes.', '2026-02-19 10:45:03'),
(5, 'Roberto Castillo Pérez', 'roberto.castillo@email.com', '999-321-6754', 'Solicitud de apoyo',          'Buen día, represento a una comunidad rural y quisiéramos solicitar apoyo para un programa de nutrición infantil.', '2026-02-22 09:15:00'),
(6, 'Patricia Herrera Leal',  'patricia.herrera@email.com', '999-448-2310', 'Alianza institucional',       'Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza con su organización.', '2026-02-25 11:30:00'),
(7, 'Enrique Sosa Canul',     'enrique.sosa@email.com',     '999-677-9021', 'Participación en talleres',   'Estoy interesado en asistir a los talleres de capacitación que mencionan en su página. ¿Cómo puedo inscribirme?', '2026-02-27 14:00:00'),
(8, 'Lucía Balam Tun',        'lucia.balam@email.com',      NULL,           'Donación en especie',         'Me gustaría donar ropa y víveres en buen estado para sus beneficiarios. ¿Cuál es el procedimiento?', '2026-03-01 08:45:00'),
(9, 'Alejandro Dzul Uc',      'alejandro.dzul@email.com',   '999-512-3388', 'Voluntariado juvenil',        'Soy estudiante de preparatoria y junto con un grupo de compañeros queremos participar como voluntarios en sus actividades comunitarias.', '2026-03-02 16:20:00');

-- --------------------------------------------------------
-- Estructura de tabla: `imagenes_proyectos`
-- --------------------------------------------------------

CREATE TABLE `imagenes_proyectos` (
  `id_imagen` int NOT NULL,
  `proyecto` int NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `fecha_creacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `informe`
-- --------------------------------------------------------

CREATE TABLE `informe` (
  `id_informe` int NOT NULL,
  `nombre_organizacion` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `evento` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `numero_telefonico` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `informe` (`id_informe`, `nombre_organizacion`, `evento`, `lugar`, `fecha`, `numero_telefonico`, `created_at`, `updated_at`) VALUES
(1,  'Ajal-lol AC', 'Campaña de prevención de caries',               'Hoctún, Yucatán', '2026-01-14', '9991234567', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(2,  'Ajal-lol AC', 'Actividad recreativa de Año Nuevo',             'Izamal, Yucatán', '2026-01-16', '9997654321', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(3,  'Ajal-lol AC', 'Entrega de juguetes Día de Reyes',              'Tekit, Yucatán',  '2026-01-15', '9998887777', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(7,  'Ajal-lol AC', 'Distribución de despensas alimentarias',        'Akil, Yucatán',   '2026-02-20', NULL,         '2026-02-26 23:10:08', '2026-02-26 23:10:08'),
(22, 'Ajal-lol AC', 'Entrega de canastas básicas de alimentos',      'Akil, Yucatán',   '2026-02-20', NULL,         '2026-03-03 00:05:35', '2026-03-03 00:05:35'),
(30, 'Ajal-lol AC', 'Entrega de artículos de primera necesidad',     'Akil, Yucatán',   '2026-03-01', NULL,         '2026-03-03 00:20:28', '2026-03-03 00:20:28'),
(31, 'Ajal-lol AC', 'Jornada de ayuda humanitaria comunitaria',      'Akil, Yucatán',   '2026-03-21', NULL,         '2026-03-03 00:22:21', '2026-03-03 00:22:21'),
(32, 'Ajal-lol AC', 'Entrega de insumos para el hogar',              'Akil, Yucatán',   '2026-03-02', NULL,         '2026-03-03 00:25:03', '2026-03-03 00:25:03'),
(37, 'Ajal-lol AC', 'Apoyo alimentario a familias vulnerables',      'Akil, Yucatán',   '2026-02-22', NULL,         '2026-03-03 00:28:43', '2026-03-03 00:28:43'),
(43, 'Ajal-lol AC', 'Programa de nutrición infantil comunitaria',    'Akil, Yucatán',   '2026-02-20', NULL,         '2026-03-03 00:32:40', '2026-03-03 00:32:40'),
(44, 'Ajal-lol AC', 'Jornada de salud preventiva',                   'Akil, Yucatán',   '2026-03-03', NULL,         '2026-03-03 00:33:53', '2026-03-03 00:33:53'),
(45, 'Ajal-lol AC', 'Distribución de suministros educativos',        'Akil, Yucatán',   '2026-04-02', NULL,         '2026-03-03 00:35:01', '2026-03-03 00:35:01'),
(48, 'Ajal-lol AC', 'Entrega de kit de útiles escolares',            'Akil, Yucatán',   '2026-04-15', NULL,         '2026-03-03 00:37:39', '2026-03-03 00:37:39'),
(49, 'Ajal-lol AC', 'Campaña de apoyo a adultos mayores',            'Akil, Yucatán',   '2026-05-01', NULL,         '2026-03-03 00:38:15', '2026-03-03 00:38:15'),
(53, 'Ajal-lol AC', 'Brigada de asistencia social comunitaria',      'Akil, Yucatán',   '2026-04-02', NULL,         '2026-03-03 00:51:40', '2026-03-03 00:51:40'),
(54, 'Ajal-lol AC', 'Taller de capacitación para el empleo',         'Akil, Yucatán',   '2026-05-20', NULL,         '2026-03-03 00:52:20', '2026-03-03 00:52:20'),
(57, 'Ajal-lol AC', 'Jornada de reforestación comunitaria',          'Akil, Yucatán',   '2026-06-05', NULL,         '2026-03-03 00:53:34', '2026-03-03 00:53:34'),
(58, 'Ajal-lol AC', 'Entrega de materiales de construcción',         'Akil, Yucatán',   '2026-09-20', NULL,         '2026-03-03 03:54:30', '2026-03-03 03:54:30'),
(59, 'Ajal-lol AC', 'Programa de becas y apoyo educativo',           'Akil, Yucatán',   '2026-07-20', NULL,         '2026-03-03 04:09:53', '2026-03-03 04:09:53'),
(60, 'Ajal-lol AC', 'Entrega de despensas y artículos del hogar',    'Akil, Yucatán',   '2026-03-03', NULL,         '2026-03-03 21:31:04', '2026-03-03 21:31:04');

-- --------------------------------------------------------
-- Estructura de tabla: `inicio`
-- --------------------------------------------------------

CREATE TABLE `inicio` (
  `id_inicio` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_inicio` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_inicio` text COLLATE utf8mb4_unicode_ci,
  `img_inicio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_inicio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `jobs`
-- --------------------------------------------------------

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `job_batches`
-- --------------------------------------------------------

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `migrations`
-- --------------------------------------------------------

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table',  1);

-- --------------------------------------------------------
-- Estructura de tabla: `nosotros`
-- --------------------------------------------------------

CREATE TABLE `nosotros` (
  `id_nosotros` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_nosotros` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen_nosotros` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitulo_nosotros` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_nosotros` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `password_reset_tokens`
-- --------------------------------------------------------

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `preguntas_frecuentes`
-- --------------------------------------------------------

CREATE TABLE `preguntas_frecuentes` (
  `id_preguntasfrecuentes` int NOT NULL,
  `id_seccion` int NOT NULL,
  `titulo_pregunta` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_respuesta` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `proyectos`
-- --------------------------------------------------------

CREATE TABLE `proyectos` (
  `id_proyecto` int NOT NULL,
  `id_seccion` int NOT NULL,
  `categoria` int NOT NULL,
  `titulo_proyecto` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion_proyecto` text COLLATE utf8mb4_unicode_ci,
  `anio_proyecto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `redes_sociales`
-- --------------------------------------------------------

CREATE TABLE `redes_sociales` (
  `id_redes_sociales` int NOT NULL,
  `nombre_redsocial` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_redsocial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `rol_usuario`
-- --------------------------------------------------------

CREATE TABLE `rol_usuario` (
  `id_rol_usuario` int NOT NULL,
  `id_usuario` int NOT NULL,
  `cargo_usuario` enum('administrador','editor') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rol_usuario` (`id_rol_usuario`, `id_usuario`, `cargo_usuario`) VALUES
(1, 1, 'administrador'),
(2, 2, 'editor'),
(5, 5, 'administrador'),
(6, 6, 'editor'),
(7, 7, 'editor'),
(8, 8, 'administrador');

-- --------------------------------------------------------
-- Estructura de tabla: `seccion`
-- --------------------------------------------------------

CREATE TABLE `seccion` (
  `id_seccion` int NOT NULL,
  `id_rol_usuario` int NOT NULL,
  `titulo_seccion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_seccion` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `seccion` (`id_seccion`, `id_rol_usuario`, `titulo_seccion`, `estado_seccion`) VALUES
(1, 1, 'Panel Administrador', 1),
(2, 2, 'Panel Editor',        1);

-- --------------------------------------------------------
-- Estructura de tabla: `sessions`
-- --------------------------------------------------------

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('8tQprrdRANzW0y88F5JnPBqR2qYdghPhcUlsjlB8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiMlV4WHdqRWIwWk1KeWNqeUFPeE1OZHd0ckpCZGxkWldoSTd3bkFKbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXBvcnQvMy9wZGYiO3M6NToicm91dGUiO3M6MTc6ImFkbWluLnJlcG9ydHMucGRmIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo3OiJ1c2VyX2lkIjtpOjE7czo2OiJub21icmUiO3M6MjM6IlJhZmFlbCBTw6FuY2hleiBNYXJ0w61uIjtzOjU6ImVtYWlsIjtzOjE3OiJhZG1pbkBhamFsbG9sLmNvbSI7czozOiJyb2wiO3M6MTM6ImFkbWluaXN0cmFkb3IiO30=', 1772553309),
('HihOEGhdpXZoTMfALztIoixhepXWClHkZI36e9kh', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiVHJFWU05aUNNUlpzUW9ZOUNRdmNxY3dkMzBSc2k0MzU5WTBMVXFTTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXBvcnQiO3M6NToicm91dGUiO3M6MTM6ImFkbWluLnJlcG9ydHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjc6InVzZXJfaWQiO2k6MTtzOjY6Im5vbWJyZSI7czoyMzoiUmFmYWVsIFPDoW5jaGV6IE1hcnTDrW4iO3M6NToiZW1haWwiO3M6MTc6ImFkbWluQGFqYWxsb2wuY29tIjtzOjM6InJvbCI7czoxMzoiYWRtaW5pc3RyYWRvciI7fQ==', 1772489393),
('YOR7JNMERoW4dTKaMASltXH6BGYasKKIBsvg4qmP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiV3hYdzJKZ2lmc3dtT2ZWd3VLeDVHTGpOMk9wVHRITlNidnMydTE3ZyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9yZXBvcnQiO3M6NToicm91dGUiO3M6MTM6ImFkbWluLnJlcG9ydHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjc6InVzZXJfaWQiO2k6MTtzOjY6Im5vbWJyZSI7czoyMzoiUmFmYWVsIFPDoW5jaGV6IE1hcnTDrW4iO3M6NToiZW1haWwiO3M6MTc6ImFkbWluQGFqYWxsb2wuY29tIjtzOjM6InJvbCI7czoxMzoiYWRtaW5pc3RyYWRvciI7fQ==', 1772477614);

-- --------------------------------------------------------
-- Estructura de tabla: `users`
-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Estructura de tabla: `usuario`
-- --------------------------------------------------------

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `nombre_usuario` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo_usuario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contraseña_usuario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `contraseña_usuario`) VALUES
(1, 'Rafael Sánchez Martín',       'admin@ajallol.com',    'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(2, 'Editor General',               'editor@ajallol.com',   'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(5, 'Nintendo Xbox Sanchéz',        'Nintendo2@gmail.com',  '$2y$12$iLo8g7nF5zhGdVshUv3mYuKdmAQP5QWAyND84bOv58788ZGE8UOJi'),
(6, 'Lorenzo Sánchez Martín',       'lorenzo@gmail.com',    'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(7, 'Jefe de Area',                  'Nintendo@gmail.com',   'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(8, 'Oscar Alejandro Sanchéz',      'Martin@gmail.com',     '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');

-- --------------------------------------------------------
-- Estructura de tabla: `widgets_actividades`
-- --------------------------------------------------------

CREATE TABLE `widgets_actividades` (
  `id_widgetactividad` int NOT NULL,
  `actividad_id` int NOT NULL,
  `titulo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- ÍNDICES
-- ============================================================

ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_seccion` (`id_seccion`);

ALTER TABLE `aliados`
  ADD PRIMARY KEY (`id_aliados`),
  ADD KEY `id_seccion` (`id_seccion`);

ALTER TABLE `beneficiarios`
  ADD PRIMARY KEY (`id_beneficiario`),
  ADD UNIQUE KEY `unique_beneficiario_informe` (`id_informe`,`curp`);

ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

ALTER TABLE `categoria_proyectos`
  ADD PRIMARY KEY (`id_categoria`);

ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`),
  ADD KEY `id_seccion` (`id_seccion`);

ALTER TABLE `directiva`
  ADD PRIMARY KEY (`id_directiva`),
  ADD KEY `id_seccion` (`id_seccion`);

ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

ALTER TABLE `formulario_contacto`
  ADD PRIMARY KEY (`id_formcontacto`);

ALTER TABLE `imagenes_proyectos`
  ADD PRIMARY KEY (`id_imagen`),
  ADD KEY `proyecto` (`proyecto`);

ALTER TABLE `informe`
  ADD PRIMARY KEY (`id_informe`),
  ADD UNIQUE KEY `unique_informe_evento` (`evento`,`lugar`,`fecha`);

ALTER TABLE `inicio`
  ADD PRIMARY KEY (`id_inicio`),
  ADD KEY `id_seccion` (`id_seccion`);

ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `nosotros`
  ADD PRIMARY KEY (`id_nosotros`),
  ADD KEY `id_seccion` (`id_seccion`);

ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

ALTER TABLE `preguntas_frecuentes`
  ADD PRIMARY KEY (`id_preguntasfrecuentes`),
  ADD KEY `id_seccion` (`id_seccion`);

ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `id_seccion` (`id_seccion`),
  ADD KEY `categoria` (`categoria`);

ALTER TABLE `redes_sociales`
  ADD PRIMARY KEY (`id_redes_sociales`);

ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`id_rol_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id_seccion`),
  ADD KEY `id_rol_usuario` (`id_rol_usuario`);

ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo_usuario` (`correo_usuario`);

ALTER TABLE `widgets_actividades`
  ADD PRIMARY KEY (`id_widgetactividad`),
  ADD KEY `actividad_id` (`actividad_id`);

-- ============================================================
-- AUTO_INCREMENT
-- ============================================================

ALTER TABLE `actividades`        MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `aliados`            MODIFY `id_aliados` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `beneficiarios`      MODIFY `id_beneficiario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;
ALTER TABLE `categoria_proyectos` MODIFY `id_categoria` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `contacto`           MODIFY `id_contacto` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `directiva`          MODIFY `id_directiva` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `failed_jobs`        MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `formulario_contacto` MODIFY `id_formcontacto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
ALTER TABLE `imagenes_proyectos` MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `informe`            MODIFY `id_informe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
ALTER TABLE `inicio`             MODIFY `id_inicio` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `jobs`               MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `migrations`         MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `nosotros`           MODIFY `id_nosotros` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `preguntas_frecuentes` MODIFY `id_preguntasfrecuentes` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `proyectos`          MODIFY `id_proyecto` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `redes_sociales`     MODIFY `id_redes_sociales` int NOT NULL AUTO_INCREMENT;
ALTER TABLE `rol_usuario`        MODIFY `id_rol_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `seccion`            MODIFY `id_seccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `users`              MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `usuario`            MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
ALTER TABLE `widgets_actividades` MODIFY `id_widgetactividad` int NOT NULL AUTO_INCREMENT;

-- ============================================================
-- RESTRICCIONES / FOREIGN KEYS
-- ============================================================

ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

ALTER TABLE `aliados`
  ADD CONSTRAINT `aliados_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

ALTER TABLE `beneficiarios`
  ADD CONSTRAINT `beneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;

ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

ALTER TABLE `directiva`
  ADD CONSTRAINT `directiva_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

ALTER TABLE `imagenes_proyectos`
  ADD CONSTRAINT `imagenes_proyectos_ibfk_1` FOREIGN KEY (`proyecto`) REFERENCES `proyectos` (`id_proyecto`);

ALTER TABLE `inicio`
  ADD CONSTRAINT `inicio_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

ALTER TABLE `nosotros`
  ADD CONSTRAINT `nosotros_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

ALTER TABLE `preguntas_frecuentes`
  ADD CONSTRAINT `preguntas_frecuentes_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`),
  ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categoria_proyectos` (`id_categoria`);

ALTER TABLE `rol_usuario`
  ADD CONSTRAINT `rol_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

ALTER TABLE `seccion`
  ADD CONSTRAINT `seccion_ibfk_1` FOREIGN KEY (`id_rol_usuario`) REFERENCES `rol_usuario` (`id_rol_usuario`);

ALTER TABLE `widgets_actividades`
  ADD CONSTRAINT `widgets_actividades_ibfk_1` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id_actividad`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;