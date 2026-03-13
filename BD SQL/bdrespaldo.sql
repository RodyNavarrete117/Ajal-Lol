-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-03-2026 a las 17:21:00
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
-- Base de datos: `prueba3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int NOT NULL,
  `id_seccion` int NOT NULL,
  `anio_actividad` int DEFAULT NULL,
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
-- Estructura de tabla para la tabla `beneficiarios`
--

CREATE TABLE `beneficiarios` (
  `id_beneficiario` int NOT NULL,
  `id_informe` int NOT NULL,
  `nombre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `curp` char(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `beneficiarios`
--

INSERT INTO `beneficiarios` (`id_beneficiario`, `id_informe`, `nombre`, `curp`, `created_at`) VALUES
(1, 1, 'Juan Pérez López', 'PELJ900101HYNLPN09', '2026-02-20 18:06:10'),
(2, 1, 'Ana María López Tun', 'LOTA920305MYNPNN03', '2026-02-20 18:06:10'),
(3, 1, 'Carlos Méndez Chi', 'MECC880712HYNCHS02', '2026-02-20 18:06:10'),
(4, 2, 'Luis Fernández Pech', 'FEPL930212HYNPRR07', '2026-02-20 18:06:10'),
(5, 2, 'María Gómez Pool', 'GOPM950610MYNPRL08', '2026-02-20 18:06:10'),
(6, 3, 'José Chan Yam', 'CHYJ870914HYNMJR05', '2026-02-20 18:06:10'),
(7, 3, 'Daniela Torres Cauich', 'TOCD990120MYNTRN06', '2026-02-20 18:06:10'),
(8, 3, 'Miguel Uc Ek', 'UCEM910315HYNCMK04', '2026-02-20 18:06:10'),
(9, 3, 'Laura Canul Poot', 'CAPL920725MYNPLN02', '2026-02-20 18:06:10'),
(151, 22, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:05:35'),
(152, 22, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:05:35'),
(153, 22, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:05:35'),
(154, 22, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:05:35'),
(155, 22, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:05:35'),
(156, 22, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:05:35'),
(171, 30, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:20:28'),
(172, 30, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:20:28'),
(173, 30, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:20:28'),
(174, 30, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:20:28'),
(175, 30, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:20:28'),
(176, 30, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:20:28'),
(177, 31, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:22:21'),
(178, 31, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:22:21'),
(179, 31, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:22:21'),
(180, 31, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:22:21'),
(181, 31, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:22:21'),
(182, 31, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:22:21'),
(183, 32, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:25:03'),
(184, 32, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:25:03'),
(185, 32, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:25:03'),
(186, 32, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:25:03'),
(187, 32, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:25:03'),
(188, 32, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:25:03'),
(189, 37, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:28:43'),
(190, 37, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:28:43'),
(191, 37, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:28:43'),
(192, 37, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:28:43'),
(193, 37, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:28:43'),
(194, 37, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:28:43'),
(195, 43, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:32:40'),
(196, 43, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:32:40'),
(197, 43, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:32:40'),
(198, 43, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:32:40'),
(199, 43, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:32:40'),
(200, 43, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:32:40'),
(201, 44, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:33:53'),
(202, 44, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:33:53'),
(203, 44, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:33:53'),
(204, 44, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:33:53'),
(205, 44, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:33:53'),
(206, 44, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:33:53'),
(207, 45, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:35:01'),
(208, 45, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:35:01'),
(209, 45, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:35:01'),
(210, 45, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:35:01'),
(211, 45, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:35:01'),
(212, 45, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:35:01'),
(213, 48, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:37:39'),
(214, 48, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:37:39'),
(215, 48, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:37:39'),
(216, 48, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:37:39'),
(217, 48, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:37:39'),
(218, 48, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:37:39'),
(219, 49, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:38:15'),
(220, 49, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:38:15'),
(221, 49, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:38:15'),
(222, 49, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:38:15'),
(223, 49, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:38:15'),
(224, 49, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:38:15'),
(225, 53, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:51:41'),
(226, 53, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:51:41'),
(227, 53, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:51:41'),
(228, 53, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:51:41'),
(229, 53, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:51:41'),
(230, 53, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:51:41'),
(231, 54, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:52:20'),
(232, 54, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:52:20'),
(233, 54, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:52:20'),
(234, 54, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:52:20'),
(235, 54, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:52:20'),
(236, 54, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:52:20'),
(237, 57, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 18:53:34'),
(238, 57, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 18:53:34'),
(239, 57, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 18:53:34'),
(240, 57, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 18:53:34'),
(241, 57, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 18:53:34'),
(242, 57, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 18:53:34'),
(243, 58, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 21:54:30'),
(244, 58, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 21:54:30'),
(245, 58, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 21:54:30'),
(246, 58, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 21:54:30'),
(247, 58, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 21:54:30'),
(248, 58, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 21:54:30'),
(249, 59, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-02 22:09:53'),
(250, 59, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-02 22:09:53'),
(251, 59, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-02 22:09:53'),
(252, 59, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-02 22:09:53'),
(253, 59, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-02 22:09:53'),
(254, 59, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-02 22:09:53'),
(255, 60, 'José Rodolfo Cabeza Morales', 'NISJ850320HYNCSF01', '2026-03-03 15:31:04'),
(256, 60, 'Juan Carlos Pérez López', 'PELJ880430HYNTRS03', '2026-03-03 15:31:04'),
(257, 60, 'María Fernanda Gómez Ruiz', 'GORM910305MDFMGN06', '2026-03-03 15:31:04'),
(258, 60, 'Carlos Eduardo Flores León', 'FOLC860118HYNLER07', '2026-03-03 15:31:04'),
(259, 60, 'Miguel Ángel Navarro Ortiz', 'NAOM970214HDFVRT10', '2026-03-03 15:31:04'),
(260, 60, 'Gabriela Mendoza Paredes', 'MEPG980418MDFNRB16', '2026-03-03 15:31:04'),
(261, 60, 'Valeria Peña Cabrera', 'PECV990120MYNPBR06', '2026-03-03 15:31:04'),
(262, 60, 'José López Reyes', 'LORJ860118HDFPYR07', '2026-03-03 15:31:04'),
(263, 60, 'Fernando Mendoza Silva', 'MESF840519HDFNLR11', '2026-03-03 15:31:04'),
(264, 60, 'Ángel Medina Torres', 'META900315HDFDTR21', '2026-03-03 15:31:04'),
(265, 60, 'Daniel Aguilar Reyes', 'AGRD880912HDFGLN23', '2026-03-03 15:31:04'),
(266, 60, 'Erika Pacheco Luna', 'PALE970201MDFCHS24', '2026-03-03 15:31:04'),
(267, 60, 'Francisco Ríos Mendoza', 'RIMF850617HDFNSR25', '2026-03-03 15:31:04'),
(268, 60, 'Guadalupe Castro Mejía', 'CAMG920403MDFSTL26', '2026-03-03 15:31:04');

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
-- Volcado de datos para la tabla `formulario_contacto`
--

INSERT INTO `formulario_contacto` (`id_formcontacto`, `nombre_completo`, `correo`, `numero_telefonico`, `asunto`, `mensaje`, `fecha_envio`) VALUES
(1, 'Salomón Alcocer', 'soysalo123@gmail.com', '999-273-4936', 'Me interesa colaborar', 'Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.', '2026-02-19 10:45:03'),
(2, 'María Fernanda López', 'maria.lopez@email.com', '999-111-2233', 'Donación', 'Buenas tardes, me gustaría realizar una donación y conocer el proceso.', '2026-02-19 10:45:03'),
(3, 'Carlos Méndez', 'carlos.mendez@email.com', '999-555-7788', 'Información sobre proyectos', 'Quisiera recibir más información sobre los proyectos activos este año.', '2026-02-19 10:45:03'),
(4, 'Ana Rodríguez', 'ana.rodriguez@email.com', NULL, 'Servicio social', 'Soy estudiante universitaria y estoy interesada en realizar mi servicio social con ustedes.', '2026-02-19 10:45:03'),
(5, 'Roberto Castillo Pérez', 'roberto.castillo@email.com', '999-321-6754', 'Solicitud de apoyo', 'Buen día, represento a una comunidad rural y quisiéramos solicitar apoyo para un programa de nutrición infantil.', '2026-02-22 09:15:00'),
(6, 'Patricia Herrera Leal', 'patricia.herrera@email.com', '999-448-2310', 'Alianza institucional', 'Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza con su organización.', '2026-02-25 11:30:00'),
(7, 'Enrique Sosa Canul', 'enrique.sosa@email.com', '999-677-9021', 'Participación en talleres', 'Estoy interesado en asistir a los talleres de capacitación que mencionan en su página. ¿Cómo puedo inscribirme?', '2026-02-27 14:00:00'),
(8, 'Lucía Balam Tun', 'lucia.balam@email.com', NULL, 'Donación en especie', 'Me gustaría donar ropa y víveres en buen estado para sus beneficiarios. ¿Cuál es el procedimiento?', '2026-03-01 08:45:00'),
(9, 'Alejandro Dzul Uc', 'alejandro.dzul@email.com', '999-512-3388', 'Voluntariado juvenil', 'Soy estudiante de preparatoria y junto con un grupo de compañeros queremos participar como voluntarios en sus actividades comunitarias.', '2026-03-02 16:20:00');

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
--

CREATE TABLE `informe` (
  `id_informe` int NOT NULL,
  `nombre_organizacion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evento` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` date NOT NULL,
  `numero_telefonico` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `informe`
--

INSERT INTO `informe` (`id_informe`, `nombre_organizacion`, `evento`, `lugar`, `fecha`, `numero_telefonico`, `created_at`, `updated_at`) VALUES
(1, 'Ajal-lol AC', 'Campaña de prevención de caries', 'Hoctún, Yucatán', '2026-01-14', '9991234567', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(2, 'Ajal-lol AC', 'Actividad recreativa de Año Nuevo', 'Izamal, Yucatán', '2026-01-16', '9997654321', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(3, 'Ajal-lol AC', 'Entrega de juguetes Día de Reyes', 'Tekit, Yucatán', '2026-01-15', '9998887777', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(7, 'Ajal-lol AC', 'Distribución de despensas alimentarias', 'Akil, Yucatán', '2026-02-20', NULL, '2026-02-26 23:10:08', '2026-02-26 23:10:08'),
(22, 'Ajal-lol AC', 'Entrega de canastas básicas de alimentos', 'Akil, Yucatán', '2026-02-20', NULL, '2026-03-03 00:05:35', '2026-03-03 00:05:35'),
(30, 'Ajal-lol AC', 'Entrega de artículos de primera necesidad', 'Akil, Yucatán', '2026-03-01', NULL, '2026-03-03 00:20:28', '2026-03-03 00:20:28'),
(31, 'Ajal-lol AC', 'Jornada de ayuda humanitaria comunitaria', 'Akil, Yucatán', '2026-03-21', NULL, '2026-03-03 00:22:21', '2026-03-03 00:22:21'),
(32, 'Ajal-lol AC', 'Entrega de insumos para el hogar', 'Akil, Yucatán', '2026-03-02', NULL, '2026-03-03 00:25:03', '2026-03-03 00:25:03'),
(37, 'Ajal-lol AC', 'Apoyo alimentario a familias vulnerables', 'Akil, Yucatán', '2026-02-22', NULL, '2026-03-03 00:28:43', '2026-03-03 00:28:43'),
(43, 'Ajal-lol AC', 'Programa de nutrición infantil comunitaria', 'Akil, Yucatán', '2026-02-20', NULL, '2026-03-03 00:32:40', '2026-03-03 00:32:40'),
(44, 'Ajal-lol AC', 'Jornada de salud preventiva', 'Akil, Yucatán', '2026-03-03', NULL, '2026-03-03 00:33:53', '2026-03-03 00:33:53'),
(45, 'Ajal-lol AC', 'Distribución de suministros educativos', 'Akil, Yucatán', '2026-04-02', NULL, '2026-03-03 00:35:01', '2026-03-03 00:35:01'),
(48, 'Ajal-lol AC', 'Entrega de kit de útiles escolares', 'Akil, Yucatán', '2026-04-15', NULL, '2026-03-03 00:37:39', '2026-03-03 00:37:39'),
(49, 'Ajal-lol AC', 'Campaña de apoyo a adultos mayores', 'Akil, Yucatán', '2026-05-01', NULL, '2026-03-03 00:38:15', '2026-03-03 00:38:15'),
(53, 'Ajal-lol AC', 'Brigada de asistencia social comunitaria', 'Akil, Yucatán', '2026-04-02', NULL, '2026-03-03 00:51:40', '2026-03-03 00:51:40'),
(54, 'Ajal-lol AC', 'Taller de capacitación para el empleo', 'Akil, Yucatán', '2026-05-20', NULL, '2026-03-03 00:52:20', '2026-03-03 00:52:20'),
(57, 'Ajal-lol AC', 'Jornada de reforestación comunitaria', 'Akil, Yucatán', '2026-06-05', NULL, '2026-03-03 00:53:34', '2026-03-03 00:53:34'),
(58, 'Ajal-lol AC', 'Entrega de materiales de construcción', 'Akil, Yucatán', '2026-09-20', NULL, '2026-03-03 03:54:30', '2026-03-03 03:54:30'),
(59, 'Ajal-lol AC', 'Programa de becas y apoyo educativo', 'Akil, Yucatán', '2026-07-20', NULL, '2026-03-03 04:09:53', '2026-03-03 04:09:53'),
(60, 'Ajal-lol AC', 'Entrega de despensas y artículos del hogar', 'Akil, Yucatán', '2026-03-03', NULL, '2026-03-03 21:31:04', '2026-03-03 21:31:04');

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

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id_notificacion`, `id_usuario`, `id_formulario`, `titulo`, `mensaje`, `leido`, `created_at`) VALUES
(1, 1, 1, 'Nueva solicitud de: Salomón Alcocer', 'Me interesa colaborar — Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.', 1, '2026-02-19 16:45:03'),
(2, 5, 1, 'Nueva solicitud de: Salomón Alcocer', 'Me interesa colaborar — Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.', 1, '2026-02-19 16:45:03'),
(3, 8, 1, 'Nueva solicitud de: Salomón Alcocer', 'Me interesa colaborar — Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.', 1, '2026-02-19 16:45:03'),
(4, 1, 2, 'Nueva solicitud de: María Fernanda López', 'Donación — Buenas tardes, me gustaría realizar una donación y conocer el proceso.', 1, '2026-02-19 16:45:03'),
(5, 5, 2, 'Nueva solicitud de: María Fernanda López', 'Donación — Buenas tardes, me gustaría realizar una donación y conocer el proceso.', 0, '2026-02-19 16:45:03'),
(6, 8, 2, 'Nueva solicitud de: María Fernanda López', 'Donación — Buenas tardes, me gustaría realizar una donación y conocer el proceso.', 1, '2026-02-19 16:45:03'),
(7, 1, 3, 'Nueva solicitud de: Carlos Méndez', 'Información sobre proyectos — Quisiera recibir más información sobre los proyectos activos este año.', 1, '2026-02-19 16:45:03'),
(8, 5, 3, 'Nueva solicitud de: Carlos Méndez', 'Información sobre proyectos — Quisiera recibir más información sobre los proyectos activos este año.', 1, '2026-02-19 16:45:03'),
(9, 8, 3, 'Nueva solicitud de: Carlos Méndez', 'Información sobre proyectos — Quisiera recibir más información sobre los proyectos activos este año.', 0, '2026-02-19 16:45:03'),
(10, 1, 4, 'Nueva solicitud de: Ana Rodríguez', 'Servicio social — Soy estudiante universitaria y estoy interesada en realizar mi servicio social.', 1, '2026-02-19 16:45:03'),
(11, 5, 4, 'Nueva solicitud de: Ana Rodríguez', 'Servicio social — Soy estudiante universitaria y estoy interesada en realizar mi servicio social.', 0, '2026-02-19 16:45:03'),
(12, 8, 4, 'Nueva solicitud de: Ana Rodríguez', 'Servicio social — Soy estudiante universitaria y estoy interesada en realizar mi servicio social.', 0, '2026-02-19 16:45:03'),
(13, 1, 5, 'Nueva solicitud de: Roberto Castillo Pérez', 'Solicitud de apoyo — Represento a una comunidad rural y quisiéramos solicitar apoyo para nutrición infantil.', 1, '2026-02-22 15:15:00'),
(14, 5, 5, 'Nueva solicitud de: Roberto Castillo Pérez', 'Solicitud de apoyo — Represento a una comunidad rural y quisiéramos solicitar apoyo para nutrición infantil.', 1, '2026-02-22 15:15:00'),
(15, 8, 5, 'Nueva solicitud de: Roberto Castillo Pérez', 'Solicitud de apoyo — Represento a una comunidad rural y quisiéramos solicitar apoyo para nutrición infantil.', 0, '2026-02-22 15:15:00'),
(16, 1, 6, 'Nueva solicitud de: Patricia Herrera Leal', 'Alianza institucional — Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza.', 1, '2026-02-25 17:30:00'),
(17, 5, 6, 'Nueva solicitud de: Patricia Herrera Leal', 'Alianza institucional — Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza.', 0, '2026-02-25 17:30:00'),
(18, 8, 6, 'Nueva solicitud de: Patricia Herrera Leal', 'Alianza institucional — Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza.', 1, '2026-02-25 17:30:00'),
(19, 1, 7, 'Nueva solicitud de: Enrique Sosa Canul', 'Participación en talleres — Estoy interesado en asistir a los talleres de capacitación. ¿Cómo me inscribo?', 0, '2026-02-27 20:00:00'),
(20, 5, 7, 'Nueva solicitud de: Enrique Sosa Canul', 'Participación en talleres — Estoy interesado en asistir a los talleres de capacitación. ¿Cómo me inscribo?', 0, '2026-02-27 20:00:00'),
(21, 8, 7, 'Nueva solicitud de: Enrique Sosa Canul', 'Participación en talleres — Estoy interesado en asistir a los talleres de capacitación. ¿Cómo me inscribo?', 0, '2026-02-27 20:00:00'),
(22, 1, 8, 'Nueva solicitud de: Lucía Balam Tun', 'Donación en especie — Me gustaría donar ropa y víveres en buen estado. ¿Cuál es el procedimiento?', 0, '2026-03-01 14:45:00'),
(23, 5, 8, 'Nueva solicitud de: Lucía Balam Tun', 'Donación en especie — Me gustaría donar ropa y víveres en buen estado. ¿Cuál es el procedimiento?', 0, '2026-03-01 14:45:00'),
(24, 8, 8, 'Nueva solicitud de: Lucía Balam Tun', 'Donación en especie — Me gustaría donar ropa y víveres en buen estado. ¿Cuál es el procedimiento?', 0, '2026-03-01 14:45:00'),
(25, 1, 9, 'Nueva solicitud de: Alejandro Dzul Uc', 'Voluntariado juvenil — Somos estudiantes de preparatoria y queremos participar como voluntarios.', 1, '2026-03-02 22:20:00'),
(26, 5, 9, 'Nueva solicitud de: Alejandro Dzul Uc', 'Voluntariado juvenil — Somos estudiantes de preparatoria y queremos participar como voluntarios.', 0, '2026-03-02 22:20:00'),
(27, 8, 9, 'Nueva solicitud de: Alejandro Dzul Uc', 'Voluntariado juvenil — Somos estudiantes de preparatoria y queremos participar como voluntarios.', 0, '2026-03-02 22:20:00');

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
  `anio_proyecto` int DEFAULT NULL
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
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id_seccion` int NOT NULL,
  `id_rol_usuario` int NOT NULL,
  `titulo_seccion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado_seccion` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id_seccion`, `id_rol_usuario`, `titulo_seccion`, `estado_seccion`) VALUES
(1, 1, 'Panel Administrador', 1),
(2, 2, 'Panel Editor', 1);

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
('8tQprrdRANzW0y88F5JnPBqR2qYdghPhcUlsjlB8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiMlV4WHdqRWIwWk1KeWNqeUFPeE1OZHd0ckpCZGxkWldoSTd3bkFKbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9ob21lIjtzOjU6InJvdXRlIjtzOjEwOiJhZG1pbi5ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo3OiJ1c2VyX2lkIjtpOjE7czo2OiJub21icmUiO3M6MjA6IlJvZG9sZm8gTmF2YXJyZXRlIEVrIjtzOjU6ImVtYWlsIjtzOjE3OiJhZG1pbkBhamFsbG9sLmNvbSI7czozOiJyb2wiO3M6MTM6ImFkbWluaXN0cmFkb3IiO30=', 1772561007),
('bIPxwXZIOSucCE7xGN9b8OcVgLBdt2VI7TMTlSiH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoicXdTaENTVkdFZXdiQjFZUjFqMWdJclpzYnR1MVRLUVExQnhGQ01UYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvbm90aWZpY2F0aW9ucy9jb3VudCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo3OiJ1c2VyX2lkIjtpOjE7czo2OiJub21icmUiO3M6MjA6IlJvZG9sZm8gTmF2YXJyZXRlIEVrIjtzOjU6ImVtYWlsIjtzOjE3OiJhZG1pbkBhamFsbG9sLmNvbSI7czozOiJyb2wiO3M6MTM6ImFkbWluaXN0cmFkb3IiO30=', 1772644859);

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
-- Indices de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  ADD PRIMARY KEY (`id_beneficiario`),
  ADD UNIQUE KEY `unique_beneficiario_informe` (`id_informe`,`curp`);

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
-- Indices de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD PRIMARY KEY (`id_rol_usuario`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id_seccion`),
  ADD KEY `id_rol_usuario` (`id_rol_usuario`);

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
-- AUTO_INCREMENT de la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  MODIFY `id_beneficiario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

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
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `formulario_contacto`
--
ALTER TABLE `formulario_contacto`
  MODIFY `id_formcontacto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `imagenes_proyectos`
--
ALTER TABLE `imagenes_proyectos`
  MODIFY `id_imagen` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id_informe` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
  MODIFY `id_notificacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
-- AUTO_INCREMENT de la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  MODIFY `id_rol_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id_seccion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

--
-- Filtros para la tabla `aliados`
--
ALTER TABLE `aliados`
  ADD CONSTRAINT `aliados_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

--
-- Filtros para la tabla `beneficiarios`
--
ALTER TABLE `beneficiarios`
  ADD CONSTRAINT `beneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

--
-- Filtros para la tabla `directiva`
--
ALTER TABLE `directiva`
  ADD CONSTRAINT `directiva_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

--
-- Filtros para la tabla `imagenes_proyectos`
--
ALTER TABLE `imagenes_proyectos`
  ADD CONSTRAINT `imagenes_proyectos_ibfk_1` FOREIGN KEY (`proyecto`) REFERENCES `proyectos` (`id_proyecto`);

--
-- Filtros para la tabla `inicio`
--
ALTER TABLE `inicio`
  ADD CONSTRAINT `inicio_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

--
-- Filtros para la tabla `nosotros`
--
ALTER TABLE `nosotros`
  ADD CONSTRAINT `nosotros_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

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
  ADD CONSTRAINT `preguntas_frecuentes_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_seccion`) REFERENCES `seccion` (`id_seccion`),
  ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categoria_proyectos` (`id_categoria`);

--
-- Filtros para la tabla `rol_usuario`
--
ALTER TABLE `rol_usuario`
  ADD CONSTRAINT `rol_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `seccion_ibfk_1` FOREIGN KEY (`id_rol_usuario`) REFERENCES `rol_usuario` (`id_rol_usuario`);

--
-- Filtros para la tabla `widgets_actividades`
--
ALTER TABLE `widgets_actividades`
  ADD CONSTRAINT `widgets_actividades_ibfk_1` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id_actividad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
