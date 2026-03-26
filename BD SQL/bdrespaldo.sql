-- phpMyAdmin SQL Dump
-- Base de datos: prueba6 — Ajal-lol AC
-- Servidor: localhost:3306 | Versión del servidor: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- AUTENTICACIÓN
-- ============================================================

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id_usuario`         int          NOT NULL AUTO_INCREMENT,
  `nombre_usuario`     varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo_usuario`     varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contraseña_usuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo_usuario` (`correo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `contraseña_usuario`) VALUES
(1, 'Rodolfo Navarrete Ek',    'admin@ajallol.com',   'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(2, 'Editor General',          'editor@ajallol.com',  'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(5, 'Nintendo Xbox Sanchéz',   'Nintendo2@gmail.com', '$2y$12$iLo8g7nF5zhGdVshUv3mYuKdmAQP5QWAyND84bOv58788ZGE8UOJi'),
(6, 'Lorenzo Sánchez Martín',  'lorenzo@gmail.com',   'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(7, 'Jefe de Area',             'Nintendo@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f'),
(8, 'Oscar Alejandro Sanchéz', 'Martin@gmail.com',    '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92');

DROP TABLE IF EXISTS `rol_usuario`;
CREATE TABLE `rol_usuario` (
  `id_rol_usuario` int        NOT NULL AUTO_INCREMENT,
  `id_usuario`     int        NOT NULL,
  `cargo_usuario`  enum('administrador','editor') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_rol_usuario`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `rol_usuario` (`id_rol_usuario`, `id_usuario`, `cargo_usuario`) VALUES
(1, 1, 'administrador'),
(2, 2, 'editor'),
(5, 5, 'administrador'),
(6, 6, 'editor'),
(7, 7, 'editor'),
(8, 8, 'administrador');

-- ============================================================
-- TABLA: paginas (intermediario simplificado)
-- Solo los campos realmente necesarios
-- ============================================================

DROP TABLE IF EXISTS `secciones_web`;
DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `id_pagina`  int          NOT NULL AUTO_INCREMENT,
  `id_usuario` int          NOT NULL,
  `slug`       varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'URL amigable: /nosotros',
  `activo`     tinyint(1)   NOT NULL DEFAULT '1',
  `orden`      int          NOT NULL DEFAULT '0',
  `created_at` timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pagina`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_paginas_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `paginas` (`id_pagina`, `id_usuario`, `slug`, `activo`, `orden`) VALUES
(1, 1, 'inicio',               1, 1),
(2, 1, 'nosotros',             1, 2),
(3, 1, 'aliados',              1, 3),
(4, 1, 'actividades',          1, 4),
(5, 1, 'proyectos',            1, 5),
(6, 1, 'directiva',            1, 6),
(7, 1, 'preguntas-frecuentes', 1, 7),
(8, 1, 'contacto',             1, 8);

-- ============================================================
-- CONTENIDO WEB
-- ============================================================

DROP TABLE IF EXISTS `inicio`;
CREATE TABLE `inicio` (
  `id_inicio`     int          NOT NULL AUTO_INCREMENT,
  `id_pagina`     int          NOT NULL,
  `titulo_inicio` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_inicio`  text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `img_inicio`    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_inicio`    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo`        tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_inicio`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `nosotros`;
CREATE TABLE `nosotros` (
  `id_nosotros`        int          NOT NULL AUTO_INCREMENT,
  `id_pagina`          int          NOT NULL,
  `titulo_nosotros`    varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagen_nosotros`    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitulo_nosotros` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_nosotros`     text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `activo`             tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_nosotros`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `aliados`;
CREATE TABLE `aliados` (
  `id_aliados`  int          NOT NULL AUTO_INCREMENT,
  `id_pagina`   int          NOT NULL,
  `img_aliados` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre`      varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url`         varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo`      tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_aliados`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `contacto`;
CREATE TABLE `contacto` (
  `id_contacto`        int          NOT NULL AUTO_INCREMENT,
  `id_pagina`          int          NOT NULL,
  `direccion_contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_contacto`  varchar(50)  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_contacto`     varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo`             tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_contacto`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `directiva`;
CREATE TABLE `directiva` (
  `id_directiva`     int          NOT NULL AUTO_INCREMENT,
  `id_pagina`        int          NOT NULL,
  `nombre_directiva` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_directiva`   varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_directiva`  int          DEFAULT NULL,
  `activo`           tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_directiva`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `preguntas_frecuentes`;
CREATE TABLE `preguntas_frecuentes` (
  `id_preguntasfrecuentes` int          NOT NULL AUTO_INCREMENT,
  `id_pagina`              int          NOT NULL,
  `titulo_pregunta`        varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_respuesta`        text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `orden`                  int          NOT NULL DEFAULT '0',
  `activo`                 tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_preguntasfrecuentes`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `redes_sociales`;
CREATE TABLE `redes_sociales` (
  `id_redes_sociales` int          NOT NULL AUTO_INCREMENT,
  `nombre_redsocial`  varchar(50)  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url_redsocial`     varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icono`             varchar(50)  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo`            tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_redes_sociales`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `widgets_actividades`;
DROP TABLE IF EXISTS `actividades`;
CREATE TABLE `actividades` (
  `id_actividad`     int          NOT NULL AUTO_INCREMENT,
  `id_pagina`        int          NOT NULL,
  `año_actividad`    int          DEFAULT NULL,
  `titulo_actividad` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto_actividad`  text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `activo`           tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_actividad`),
  KEY `id_pagina` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `widgets_actividades` (
  `id_widgetactividad` int          NOT NULL AUTO_INCREMENT,
  `actividad_id`       int          NOT NULL,
  `titulo`             varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `texto`              text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_widgetactividad`),
  KEY `actividad_id` (`actividad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `imagenes_proyectos`;
DROP TABLE IF EXISTS `proyectos`;
DROP TABLE IF EXISTS `categoria_proyectos`;

CREATE TABLE `categoria_proyectos` (
  `id_categoria` int          NOT NULL AUTO_INCREMENT,
  `nombre`       varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion`  text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `orden`        int          DEFAULT NULL,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `proyectos` (
  `id_proyecto`          int          NOT NULL AUTO_INCREMENT,
  `id_pagina`            int          NOT NULL,
  `categoria`            int          NOT NULL,
  `titulo_proyecto`      varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion_proyecto` text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `año_proyecto`         int          DEFAULT NULL,
  `activo`               tinyint(1)   NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_proyecto`),
  KEY `id_pagina` (`id_pagina`),
  KEY `categoria` (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `imagenes_proyectos` (
  `id_imagen`      int          NOT NULL AUTO_INCREMENT,
  `proyecto`       int          NOT NULL,
  `ruta`           varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion`    text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_creacion` date         DEFAULT NULL,
  PRIMARY KEY (`id_imagen`),
  KEY `proyecto` (`proyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- INFORMES (datos conservados)
-- ============================================================

DROP TABLE IF EXISTS `asistenciabeneficiarios`;
DROP TABLE IF EXISTS `reportebeneficiarios`;
DROP TABLE IF EXISTS `informe`;

CREATE TABLE `informe` (
  `id_informe`          int          NOT NULL AUTO_INCREMENT,
  `nombre_organizacion` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `evento`              varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar`               varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha`               date         NOT NULL,
  `created_at`          timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`          timestamp    NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_informe`),
  UNIQUE KEY `unique_informe_evento` (`evento`,`lugar`,`fecha`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `informe` (`id_informe`, `nombre_organizacion`, `evento`, `lugar`, `fecha`, `created_at`, `updated_at`) VALUES
(2,  'Ajal-lol AC', 'Actividad recreativa de Año Nuevo',          'Izamal, Yucatán',       '2026-01-16', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(3,  'Ajal-lol AC', 'Entrega de juguetes Día de Reyes',           'Tekit, Yucatán',        '2026-01-15', '2026-02-20 18:06:10', '2026-02-20 18:06:10'),
(7,  'Ajal-lol AC', 'Distribución de despensas alimentarias',     'Akil, Yucatán',         '2026-02-20', '2026-02-26 23:10:08', '2026-02-26 23:10:08'),
(22, 'Ajal-lol AC', 'Entrega de canastas básicas de alimentos',   'Akil, Yucatán',         '2026-02-20', '2026-03-03 00:05:35', '2026-03-03 00:05:35'),
(30, 'Ajal-lol AC', 'Entrega de artículos de primera necesidad',  'Akil, Yucatán',         '2026-03-01', '2026-03-03 00:20:28', '2026-03-03 00:20:28'),
(31, 'Ajal-lol AC', 'Jornada de ayuda humanitaria comunitaria',   'Akil, Yucatán',         '2026-03-21', '2026-03-03 00:22:21', '2026-03-03 00:22:21'),
(32, 'Ajal-lol AC', 'Entrega de insumos para el hogar',           'Akil, Yucatán',         '2026-03-02', '2026-03-03 00:25:03', '2026-03-03 00:25:03'),
(37, 'Ajal-lol AC', 'Apoyo alimentario a familias vulnerables',   'Akil, Yucatán',         '2026-02-22', '2026-03-03 00:28:43', '2026-03-03 00:28:43'),
(43, 'Ajal-lol AC', 'Programa de nutrición infantil comunitaria', 'Akil, Yucatán',         '2026-02-20', '2026-03-03 00:32:40', '2026-03-03 00:32:40'),
(44, 'Ajal-lol AC', 'Jornada de salud preventiva',                'Akil, Yucatán',         '2026-03-03', '2026-03-03 00:33:53', '2026-03-03 00:33:53'),
(45, 'Ajal-lol AC', 'Distribución de suministros educativos',     'Akil, Yucatán',         '2026-04-02', '2026-03-03 00:35:01', '2026-03-03 00:35:01'),
(48, 'Ajal-lol AC', 'Entrega de kit de útiles escolares',         'Akil, Yucatán',         '2026-04-15', '2026-03-03 00:37:39', '2026-03-03 00:37:39'),
(49, 'Ajal-lol AC', 'Campaña de apoyo a adultos mayores',         'Akil, Yucatán',         '2026-05-01', '2026-03-03 00:38:15', '2026-03-03 00:38:15'),
(53, 'Ajal-lol AC', 'Brigada de asistencia social comunitaria',   'Akil, Yucatán',         '2026-04-02', '2026-03-03 00:51:40', '2026-03-03 00:51:40'),
(54, 'Ajal-lol AC', 'Taller de capacitación para el empleo',      'Akil, Yucatán',         '2026-05-20', '2026-03-03 00:52:20', '2026-03-03 00:52:20'),
(57, 'Ajal-lol AC', 'Jornada de reforestación comunitaria',       'Akil, Yucatán',         '2026-06-05', '2026-03-03 00:53:34', '2026-03-03 00:53:34'),
(58, 'Ajal-lol AC', 'Entrega de materiales de construcción',      'Akil, Yucatán',         '2026-09-20', '2026-03-03 03:54:30', '2026-03-03 03:54:30'),
(59, 'Ajal-lol AC', 'Programa de becas y apoyo educativo',        'Akil, Yucatán',         '2026-07-20', '2026-03-03 04:09:53', '2026-03-03 04:09:53'),
(60, 'Ajal-lol AC', 'Entrega de despensas y artículos del hogar', 'Akil, Yucatán',         '2026-03-03', '2026-03-03 21:31:04', '2026-03-03 21:31:04'),
(61, 'Ajal-lol AC', 'Brigada de Salud Integral "Vida Sana"',      'Izamal, Yucatán',       '2026-03-10', '2026-03-11 00:05:21', '2026-03-11 00:05:21'),
(62, 'Ajal-lol AC', 'Jornada de reforestación comunitaria',       'Akil, Yucatán',         '2026-03-11', '2026-03-11 21:57:37', '2026-03-11 21:57:37'),
(63, 'Ajal-lol AC', 'Jornada de reforestación comunitaria',       'Chikindzonot, Yucatán', '2026-03-11', '2026-03-11 22:50:10', '2026-03-11 22:50:10'),
(64, 'Ajal-lol AC', 'Campaña de apoyo a adultos mayores',         'Acanceh, Yucatán',      '2026-03-11', '2026-03-11 23:16:43', '2026-03-11 23:16:43'),
(65, 'Ajal-lol AC', 'Taller de capacitación para el empleo',      'Abalá, Yucatán',        '2026-03-20', '2026-03-12 21:45:11', '2026-03-12 21:45:11');

CREATE TABLE `asistenciabeneficiarios` (
  `id_asistenciabeneficiario`    int          NOT NULL AUTO_INCREMENT,
  `id_informe`                   int          NOT NULL,
  `asistencianombrebeneficiario` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `asistenciaedadbeneficiario`   int          DEFAULT NULL,
  `created_at`                   timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_asistenciabeneficiario`),
  KEY `id_informe` (`id_informe`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `asistenciabeneficiarios` (`id_asistenciabeneficiario`, `id_informe`, `asistencianombrebeneficiario`, `asistenciaedadbeneficiario`, `created_at`) VALUES
(6,2,'Margarita Balam Cocom',36,'2026-01-16 16:00:00'),(7,2,'Rafael Cauich Ek',34,'2026-01-16 16:05:00'),(8,2,'Teresa Ucan May',25,'2026-01-16 16:10:00'),(9,2,'Cirilo Tun Dzul',61,'2026-01-16 16:15:00'),
(10,3,'Armando Tun Poot',42,'2026-01-15 14:30:00'),(11,3,'Verónica Moo Chi',29,'2026-01-15 14:35:00'),(12,3,'Héctor Canul Tzec',55,'2026-01-15 14:40:00'),(13,3,'Gabriela Chuc Noh',31,'2026-01-15 14:45:00'),
(14,7,'Humberto Caamal Kú',50,'2026-02-20 17:00:00'),(15,7,'Adriana Pool Tzab',27,'2026-02-20 17:05:00'),(16,7,'Gilberto Chan Chim',37,'2026-02-20 17:10:00'),(17,7,'Lorena Couoh Nah',32,'2026-02-20 17:15:00'),
(18,7,'Domingo Ku Xool',45,'2026-02-20 17:20:00'),(19,7,'Esperanza Dzib Canche',38,'2026-02-20 17:25:00'),(20,7,'Nicolás Pech Baas',60,'2026-02-20 17:30:00'),
(21,22,'Beatriz Yam Xool',25,'2026-02-20 15:00:00'),(22,22,'Aurelio Mis Kauil',53,'2026-02-20 15:05:00'),(23,22,'Claudia Chuc Baas',30,'2026-02-20 15:10:00'),(24,22,'Marcos Cupul Noh',41,'2026-02-20 15:15:00'),
(25,30,'Alejandro Dzib Novelo',44,'2026-03-01 16:00:00'),(26,30,'Patricia Canul Cocom',38,'2026-03-01 16:05:00'),(27,30,'Ramón Tuz Tzec',56,'2026-03-01 16:10:00'),
(28,31,'Isabel Ek Kantún',26,'2026-03-21 15:30:00'),(29,31,'Yolanda Cen Balam',49,'2026-03-21 15:35:00'),(30,31,'Félix Cohuo Xiu',62,'2026-03-21 15:40:00'),
(31,32,'Óscar Tello Mex',34,'2026-03-02 14:00:00'),(32,32,'Fernanda Uicab Chan',25,'2026-03-02 14:05:00'),(33,32,'Crescencio Poot Ku',52,'2026-03-02 14:10:00'),
(34,37,'Liliana Nah Uc',28,'2026-02-22 16:30:00'),(35,37,'Sebastián Chim Cohuó',37,'2026-02-22 16:35:00'),(36,37,'Dolores Cauich Pat',45,'2026-02-22 16:40:00'),
(37,43,'Carmen Kú Xiu',45,'2026-02-20 19:00:00'),(38,43,'Arnulfo Dzul Pat',59,'2026-02-20 19:05:00'),(39,43,'Norma Canché Tun',30,'2026-02-20 19:10:00'),
(40,44,'Víctor Baas Canche',36,'2026-03-03 15:00:00'),(41,44,'Esther May Cocom',47,'2026-03-03 15:05:00'),(42,44,'Rogelio Dzul Xool',31,'2026-03-03 15:10:00'),
(43,45,'Rubén Cauich Dzul',43,'2026-04-02 16:00:00'),(44,45,'Diana Pech Ucan',28,'2026-04-02 16:05:00'),(45,45,'Gregorio Tun Balam',54,'2026-04-02 16:10:00'),
(46,48,'Silvia Cob Kauil',25,'2026-04-15 14:30:00'),(47,48,'Mauricio Xool Moo',40,'2026-04-15 14:35:00'),(48,48,'Lorena Couoh Nah',32,'2026-04-15 14:40:00'),
(49,49,'Dolores Chel Tzuc',32,'2026-05-01 15:00:00'),(50,49,'Francisco Caamal Balam',49,'2026-05-01 15:05:00'),(51,49,'Consuelo Poot Mis',65,'2026-05-01 15:10:00'),(52,49,'Bernardo Xiu Cohuó',71,'2026-05-01 15:15:00'),
(53,53,'Arturo Dzib Cauich',38,'2026-04-02 17:00:00'),(54,53,'Guadalupe Mex Poot',33,'2026-04-02 17:05:00'),(55,53,'Lucero Cohuo Chan',26,'2026-04-02 17:10:00'),
(56,54,'Enrique Noh Tzab',45,'2026-05-20 16:00:00'),(57,54,'Rebeca Chan Ucan',24,'2026-05-20 16:05:00'),(58,54,'Ignacio Ku Tuz',56,'2026-05-20 16:10:00'),(59,54,'Miriam Cauich Balam',31,'2026-05-20 16:15:00'),
(60,57,'Valentina Uc Cen',27,'2026-06-05 14:00:00'),(61,57,'Javier Baalam Cohuo',42,'2026-06-05 14:05:00'),(62,57,'Ignacio Dzul Tun',35,'2026-06-05 14:10:00'),
(63,58,'Consuelo Poot Mis',35,'2026-09-20 15:00:00'),(64,58,'Bernardo Xiu Cohuó',51,'2026-09-20 15:05:00'),(65,58,'Alicia Tun Canché',24,'2026-09-20 15:10:00'),
(66,59,'Roberto Ek Dzib',37,'2026-07-20 16:00:00'),(67,59,'Minerva Ucan Caamal',30,'2026-07-20 16:05:00'),(68,59,'Alicia Tun Canché',24,'2026-07-20 16:10:00'),(69,59,'Samuel Pech Dzul',22,'2026-07-20 16:15:00'),
(70,60,'Lorenzo Balam Tuz',48,'2026-03-03 14:00:00'),(71,60,'Patricia Dzul Cohuo',22,'2026-03-03 14:05:00'),(72,60,'Andrés Cauich May',43,'2026-03-03 14:10:00'),(73,60,'Gregorio Tun Balam',54,'2026-03-03 14:15:00'),(74,60,'Esperanza Mis Xool',39,'2026-03-03 14:20:00'),
(75,62,'Rodolfo Navarrete Ek',21,'2026-03-11 15:57:38'),(76,62,'Alejandro Cab Can',42,'2026-03-11 15:57:38'),(77,62,'Martina Lopéz',23,'2026-03-11 15:57:38'),(78,62,'Mario Muñoz',12,'2026-03-11 15:57:38'),(79,62,'Ignacio Montero',43,'2026-03-11 15:57:38'),(80,62,'Alfredo Dorantes',32,'2026-03-11 15:57:38'),
(81,65,'Rodolfo Navarrete Ek',21,'2026-03-12 15:45:11'),(82,65,'Alejandro Cab Can',42,'2026-03-12 15:45:11'),(83,65,'Martina Lopéz',53,'2026-03-12 15:45:11'),(84,65,'Mario Muñoz',43,'2026-03-12 15:45:11'),(85,65,'Ignacio Montero',32,'2026-03-12 15:45:11'),(86,65,'Alfredo Dorantes',19,'2026-03-12 15:45:11'),(87,65,'Gustavo Pech',20,'2026-03-12 15:45:11');

CREATE TABLE `reportebeneficiarios` (
  `id_reportebeneficiario`    int          NOT NULL AUTO_INCREMENT,
  `id_informe`                int          NOT NULL,
  `reportenombrebeneficiario` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reportecurpbeneficiario`   char(18)     CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `reporteedadbeneficiario`   int          DEFAULT NULL,
  `created_at`                timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reportebeneficiario`),
  UNIQUE KEY `unique_reportebeneficiario_informe` (`id_informe`,`reportecurpbeneficiario`)
) ENGINE=InnoDB AUTO_INCREMENT=306 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `reportebeneficiarios` (`id_reportebeneficiario`, `id_informe`, `reportenombrebeneficiario`, `reportecurpbeneficiario`, `reporteedadbeneficiario`, `created_at`) VALUES
(4,2,'Luis Fernández Pech','FEPL930212HYNPRR07',31,'2026-02-20 18:06:10'),(5,2,'María Gómez Pool','GOPM950610MYNPRL08',29,'2026-02-20 18:06:10'),
(6,3,'José Chan Yam','CHYJ870914HYNMJR05',38,'2026-02-20 18:06:10'),(7,3,'Daniela Torres Cauich','TOCD990120MYNTRN06',26,'2026-02-20 18:06:10'),(8,3,'Miguel Uc Ek','UCEM910315HYNCMK04',34,'2026-02-20 18:06:10'),(9,3,'Laura Canul Poot','CAPL920725MYNPLN02',30,'2026-02-20 18:06:10'),
(151,22,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:05:35'),(152,22,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:05:35'),(153,22,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:05:35'),(154,22,'Carlos Eduardo Flores León','FOLC860118HYNLER07',39,'2026-03-02 18:05:35'),(155,22,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',28,'2026-03-02 18:05:35'),(156,22,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:05:35'),
(171,30,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',44,'2026-03-02 18:20:28'),(172,30,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:20:28'),(173,30,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:20:28'),(174,30,'Carlos Eduardo Flores León','FOLC860118HYNLER07',39,'2026-03-02 18:20:28'),(175,30,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',28,'2026-03-02 18:20:28'),(176,30,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:20:28'),
(177,31,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:22:21'),(178,31,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:22:21'),(179,31,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:22:21'),(180,31,'Carlos Eduardo Flores León','FOLC860118HYNLER07',45,'2026-03-02 18:22:21'),(181,31,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:22:21'),(182,31,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',32,'2026-03-02 18:22:21'),
(183,32,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:25:03'),(184,32,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:25:03'),(185,32,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:25:03'),(186,32,'Carlos Eduardo Flores León','FOLC860118HYNLER07',41,'2026-03-02 18:25:03'),(187,32,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:25:03'),(188,32,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',26,'2026-03-02 18:25:03'),
(189,37,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:28:43'),(190,37,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:28:43'),(191,37,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:28:43'),(192,37,'Carlos Eduardo Flores León','FOLC860118HYNLER07',48,'2026-03-02 18:28:43'),(193,37,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:28:43'),(194,37,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:28:43'),
(195,43,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:32:40'),(196,43,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:32:40'),(197,43,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:32:40'),(198,43,'Carlos Eduardo Flores León','FOLC860118HYNLER07',43,'2026-03-02 18:32:40'),(199,43,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:32:40'),(200,43,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:32:40'),
(201,44,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:33:53'),(202,44,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:33:53'),(203,44,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:33:53'),(204,44,'Carlos Eduardo Flores León','FOLC860118HYNLER07',50,'2026-03-02 18:33:53'),(205,44,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:33:53'),(206,44,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:33:53'),
(207,45,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:35:01'),(208,45,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:35:01'),(209,45,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:35:01'),(210,45,'Carlos Eduardo Flores León','FOLC860118HYNLER07',46,'2026-03-02 18:35:01'),(211,45,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:35:01'),(212,45,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:35:01'),
(213,48,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:37:39'),(214,48,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:37:39'),(215,48,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:37:39'),(216,48,'Carlos Eduardo Flores León','FOLC860118HYNLER07',52,'2026-03-02 18:37:39'),(217,48,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:37:39'),(218,48,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:37:39'),
(219,49,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:38:15'),(220,49,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:38:15'),(221,49,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:38:15'),(222,49,'Carlos Eduardo Flores León','FOLC860118HYNLER07',55,'2026-03-02 18:38:15'),(223,49,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:38:15'),(224,49,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:38:15'),
(225,53,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:51:41'),(226,53,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:51:41'),(227,53,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:51:41'),(228,53,'Carlos Eduardo Flores León','FOLC860118HYNLER07',39,'2026-03-02 18:51:41'),(229,53,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:51:41'),(230,53,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:51:41'),
(231,54,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:52:20'),(232,54,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:52:20'),(233,54,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:52:20'),(234,54,'Carlos Eduardo Flores León','FOLC860118HYNLER07',42,'2026-03-02 18:52:20'),(235,54,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:52:20'),(236,54,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:52:20'),
(237,57,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 18:53:34'),(238,57,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 18:53:34'),(239,57,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 18:53:34'),(240,57,'Carlos Eduardo Flores León','FOLC860118HYNLER07',47,'2026-03-02 18:53:34'),(241,57,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 18:53:34'),(242,57,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 18:53:34'),
(243,58,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 21:54:30'),(244,58,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 21:54:30'),(245,58,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 21:54:30'),(246,58,'Carlos Eduardo Flores León','FOLC860118HYNLER07',53,'2026-03-02 21:54:30'),(247,58,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 21:54:30'),(248,58,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 21:54:30'),
(249,59,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-02 22:09:53'),(250,59,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-02 22:09:53'),(251,59,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-02 22:09:53'),(252,59,'Carlos Eduardo Flores León','FOLC860118HYNLER07',44,'2026-03-02 22:09:53'),(253,59,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-02 22:09:53'),(254,59,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-02 22:09:53'),
(255,60,'Rodolfo Cabeza Navarrete Cab','NISJ850320HYNCSF01',40,'2026-03-03 15:31:04'),(256,60,'Juan Carlos Pérez López','PELJ880430HYNTRS03',37,'2026-03-03 15:31:04'),(257,60,'María Fernanda Gómez Ruiz','GORM910305MDFMGN06',34,'2026-03-03 15:31:04'),(258,60,'Carlos Eduardo Flores León','FOLC860118HYNLER07',39,'2026-03-03 15:31:04'),(259,60,'Miguel Ángel Navarro Ortiz','NAOM970214HDFVRT10',29,'2026-03-03 15:31:04'),(260,60,'Gabriela Mendoza Paredes','MEPG980418MDFNRB16',27,'2026-03-03 15:31:04'),
(261,60,'Valeria Peña Cabrera','PECV990120MYNPBR06',25,'2026-03-03 15:31:04'),(262,60,'José López Reyes','LORJ860118HDFPYR07',39,'2026-03-03 15:31:04'),(263,60,'Fernando Mendoza Silva','MESF840519HDFNLR11',41,'2026-03-03 15:31:04'),(264,60,'Ángel Medina Torres','META900315HDFDTR21',35,'2026-03-03 15:31:04'),(265,60,'Daniel Aguilar Reyes','AGRD880912HDFGLN23',37,'2026-03-03 15:31:04'),(266,60,'Erika Pacheco Luna','PALE970201MDFCHS24',28,'2026-03-03 15:31:04'),(267,60,'Francisco Ríos Mendoza','RIMF850617HDFNSR25',40,'2026-03-03 15:31:04'),(268,60,'Guadalupe Castro Mejía','CAMG920403MDFSTL26',33,'2026-03-03 15:31:04'),
(269,61,'Alejandro García Torres','GATA850522HDFLRN03',56,'2026-03-10 18:05:21'),(270,61,'María Elena López Ruiz','LORM920315MDFZRS08',23,'2026-03-10 18:05:21'),(271,61,'Ricardo Méndez Castro','MECR781110HDFNNN01',32,'2026-03-10 18:05:21'),(272,61,'Sofía Villalobos Sanz','VISS050720MDFLND05',23,'2026-03-10 18:05:21'),(273,61,'Javier Ortiz Pineda','ORPJ600102HDFRRD09',21,'2026-03-10 18:05:21'),(274,61,'Claudia Rivas Montes','RIMC951212MDFNTN02',39,'2026-03-10 18:05:21'),
(275,63,'Alejandro García Torres','GATA850522HDFLRN03',21,'2026-03-11 16:50:10'),(276,63,'María Elena López Ruiz','LORM920315MDFZRS08',43,'2026-03-11 16:50:10'),(277,63,'Ricardo Méndez Castro','MECR781110HDFNNN01',43,'2026-03-11 16:50:10'),(278,63,'Sofía Villalobos Sanz','VISS050720MDFLND05',43,'2026-03-11 16:50:10'),(279,63,'Javier Ortiz Pineda','ORPJ600102HDFRRD09',12,'2026-03-11 16:50:10'),(280,63,'Claudia Rivas Montes','RIMC951212MDFNTN02',42,'2026-03-11 16:50:10'),
(281,64,'Juan Carlos Méndez López','MELJ900315HYNNDN01',32,'2026-03-11 17:16:43'),(282,64,'María Elena López Ruiz','LORM920315MDFZRS08',54,'2026-03-11 17:16:43'),(283,64,'Ricardo Méndez Castro','MECR781110HDFNNN01',21,'2026-03-11 17:16:43'),(284,64,'Sofía Villalobos Sanz','VISS050720MDFLND05',43,'2026-03-11 17:16:43'),(285,64,'Javier Ortiz Pineda','ORPJ600102HDFRRD09',12,'2026-03-11 17:16:43'),(286,64,'Claudia Rivas Montes','RIMC951212MDFNTN02',65,'2026-03-11 17:16:43'),
(287,64,'María Fernanda Ruiz Gómez','RUGM920804MYNRRM02',43,'2026-03-11 17:16:43'),(288,64,'Luis Alberto Chan Poot','CAPL880112HYNHST03',31,'2026-03-11 17:16:43'),(289,64,'Ana Sofía Castillo Pérez','CAPA950623MYNSRN04',67,'2026-03-11 17:16:43'),(290,64,'José Manuel Tun Canul','TUCM870909HYNMNL05',90,'2026-03-11 17:16:43'),(291,64,'Daniela Guadalupe Ek Cauich','ECDG990214MYNCLK06',21,'2026-03-11 17:16:43'),(292,64,'Pedro Antonio Puc May','PUMP910530HYNPCM07',54,'2026-03-11 17:16:43'),
(293,64,'Karla Beatriz Pech Dzib','PEDK960718MYNPBZ08',34,'2026-03-11 17:16:43'),(294,64,'Miguel Ángel Cetz Canché','CACM890421HYNCTZ09',43,'2026-03-11 17:16:43'),(295,64,'Laura Patricia Poot Chi','POCL940102MYNPRC10',23,'2026-03-11 17:16:43'),(296,64,'Teresa del Carmen May Pech','MAPT850627MYNTRS12',24,'2026-03-11 17:16:43'),(297,64,'Rosa María Ek Tun','ETRM910905MYNRST14',54,'2026-03-11 17:16:43'),(298,64,'Andrés Felipe Dzib Chan','DCHA920210HYNFDR15',65,'2026-03-11 17:16:43'),
(299,64,'Gabriela Alejandra Puc Chi','PUCG980701MYNGBC16',76,'2026-03-11 17:16:43'),(300,64,'Víctor Hugo Canché May','CAMV860418HYNVTR17',34,'2026-03-11 17:16:43'),(301,64,'Ricardo Antonio Chan Tun','CHTR900806HYNRCN19',31,'2026-03-11 17:16:43'),(302,64,'Jorge Alberto Pech Canul','PECJ910214HYNGRG21',21,'2026-03-11 17:16:43'),(303,64,'Verónica del Carmen Chan Ek','CHEV940322MYNVRC22',21,'2026-03-11 17:16:43'),(304,64,'Daniela Beatriz Canché Pech','CAPD960406MYNDNL26',43,'2026-03-11 17:16:43'),(305,64,'Oscar Daniel Cetz Poot','CHDC980115MYNCLD30',21,'2026-03-11 17:16:43');

-- ============================================================
-- FORMULARIO Y NOTIFICACIONES
-- ============================================================

DROP TABLE IF EXISTS `notificaciones`;
DROP TABLE IF EXISTS `formulario_contacto`;

CREATE TABLE `formulario_contacto` (
  `id_formcontacto`   int          NOT NULL AUTO_INCREMENT,
  `nombre_completo`   varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo`            varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_telefonico` varchar(50)  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asunto`            varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mensaje`           text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fecha_envio`       datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_formcontacto`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `formulario_contacto` (`id_formcontacto`, `nombre_completo`, `correo`, `numero_telefonico`, `asunto`, `mensaje`, `fecha_envio`) VALUES
(1,'Salomón Alcocer','soysalo123@gmail.com','999-273-4936','Me interesa colaborar','Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.','2026-02-19 10:45:03'),
(2,'María Fernanda López','maria.lopez@email.com','999-111-2233','Donación','Buenas tardes, me gustaría realizar una donación y conocer el proceso.','2026-02-19 10:45:03'),
(3,'Carlos Méndez','carlos.mendez@email.com','999-555-7788','Información sobre proyectos','Quisiera recibir más información sobre los proyectos activos este año.','2026-02-19 10:45:03'),
(4,'Ana Rodríguez','ana.rodriguez@email.com',NULL,'Servicio social','Soy estudiante universitaria y estoy interesada en realizar mi servicio social con ustedes.','2026-02-19 10:45:03'),
(5,'Roberto Castillo Pérez','roberto.castillo@email.com','999-321-6754','Solicitud de apoyo','Buen día, represento a una comunidad rural y quisiéramos solicitar apoyo para un programa de nutrición infantil.','2026-02-22 09:15:00'),
(6,'Patricia Herrera Leal','patricia.herrera@email.com','999-448-2310','Alianza institucional','Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza con su organización.','2026-02-25 11:30:00'),
(7,'Enrique Sosa Canul','enrique.sosa@email.com','999-677-9021','Participación en talleres','Estoy interesado en asistir a los talleres de capacitación que mencionan en su página. ¿Cómo puedo inscribirme?','2026-02-27 14:00:00'),
(8,'Lucía Balam Tun','lucia.balam@email.com',NULL,'Donación en especie','Me gustaría donar ropa y víveres en buen estado para sus beneficiarios. ¿Cuál es el procedimiento?','2026-03-01 08:45:00'),
(9,'Alejandro Dzul Uc','alejandro.dzul@email.com','999-512-3388','Voluntariado juvenil','Soy estudiante de preparatoria y junto con un grupo de compañeros queremos participar como voluntarios en sus actividades comunitarias.','2026-03-02 16:20:00');

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

CREATE TABLE `notificaciones` (
  `id_notificacion` int          NOT NULL AUTO_INCREMENT,
  `id_usuario`      int          NOT NULL,
  `id_formulario`   int          DEFAULT NULL,
  `titulo`          varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje`         text         CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `leido`           tinyint(1)   NOT NULL DEFAULT '0',
  `created_at`      timestamp    NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_notificacion`),
  KEY `id_usuario`    (`id_usuario`),
  KEY `id_formulario` (`id_formulario`),
  KEY `leido_index`   (`leido`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notificaciones` (`id_notificacion`, `id_usuario`, `id_formulario`, `titulo`, `mensaje`, `leido`, `created_at`) VALUES
(1,1,1,'Nueva solicitud de: Salomón Alcocer','Me interesa colaborar — Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.',1,'2026-02-19 16:45:03'),
(2,5,1,'Nueva solicitud de: Salomón Alcocer','Me interesa colaborar — Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.',1,'2026-02-19 16:45:03'),
(3,8,1,'Nueva solicitud de: Salomón Alcocer','Me interesa colaborar — Hola, estoy interesado en colaborar como voluntario en sus próximos proyectos.',1,'2026-02-19 16:45:03'),
(4,1,2,'Nueva solicitud de: María Fernanda López','Donación — Buenas tardes, me gustaría realizar una donación y conocer el proceso.',1,'2026-02-19 16:45:03'),
(5,5,2,'Nueva solicitud de: María Fernanda López','Donación — Buenas tardes, me gustaría realizar una donación y conocer el proceso.',0,'2026-02-19 16:45:03'),
(6,8,2,'Nueva solicitud de: María Fernanda López','Donación — Buenas tardes, me gustaría realizar una donación y conocer el proceso.',1,'2026-02-19 16:45:03'),
(7,1,3,'Nueva solicitud de: Carlos Méndez','Información sobre proyectos — Quisiera recibir más información sobre los proyectos activos este año.',1,'2026-02-19 16:45:03'),
(8,5,3,'Nueva solicitud de: Carlos Méndez','Información sobre proyectos — Quisiera recibir más información sobre los proyectos activos este año.',1,'2026-02-19 16:45:03'),
(9,8,3,'Nueva solicitud de: Carlos Méndez','Información sobre proyectos — Quisiera recibir más información sobre los proyectos activos este año.',0,'2026-02-19 16:45:03'),
(10,1,4,'Nueva solicitud de: Ana Rodríguez','Servicio social — Soy estudiante universitaria y estoy interesada en realizar mi servicio social.',1,'2026-02-19 16:45:03'),
(11,5,4,'Nueva solicitud de: Ana Rodríguez','Servicio social — Soy estudiante universitaria y estoy interesada en realizar mi servicio social.',0,'2026-02-19 16:45:03'),
(12,8,4,'Nueva solicitud de: Ana Rodríguez','Servicio social — Soy estudiante universitaria y estoy interesada en realizar mi servicio social.',0,'2026-02-19 16:45:03'),
(13,1,5,'Nueva solicitud de: Roberto Castillo Pérez','Solicitud de apoyo — Represento a una comunidad rural y quisiéramos solicitar apoyo para nutrición infantil.',1,'2026-02-22 15:15:00'),
(14,5,5,'Nueva solicitud de: Roberto Castillo Pérez','Solicitud de apoyo — Represento a una comunidad rural y quisiéramos solicitar apoyo para nutrición infantil.',1,'2026-02-22 15:15:00'),
(15,8,5,'Nueva solicitud de: Roberto Castillo Pérez','Solicitud de apoyo — Represento a una comunidad rural y quisiéramos solicitar apoyo para nutrición infantil.',0,'2026-02-22 15:15:00'),
(16,1,6,'Nueva solicitud de: Patricia Herrera Leal','Alianza institucional — Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza.',1,'2026-02-25 17:30:00'),
(17,5,6,'Nueva solicitud de: Patricia Herrera Leal','Alianza institucional — Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza.',0,'2026-02-25 17:30:00'),
(18,8,6,'Nueva solicitud de: Patricia Herrera Leal','Alianza institucional — Soy coordinadora de una asociación civil y me gustaría explorar una posible alianza.',1,'2026-02-25 17:30:00'),
(19,1,7,'Nueva solicitud de: Enrique Sosa Canul','Participación en talleres — Estoy interesado en asistir a los talleres de capacitación. ¿Cómo me inscribo?',0,'2026-02-27 20:00:00'),
(20,5,7,'Nueva solicitud de: Enrique Sosa Canul','Participación en talleres — Estoy interesado en asistir a los talleres de capacitación. ¿Cómo me inscribo?',0,'2026-02-27 20:00:00'),
(21,8,7,'Nueva solicitud de: Enrique Sosa Canul','Participación en talleres — Estoy interesado en asistir a los talleres de capacitación. ¿Cómo me inscribo?',0,'2026-02-27 20:00:00'),
(22,1,8,'Nueva solicitud de: Lucía Balam Tun','Donación en especie — Me gustaría donar ropa y víveres en buen estado. ¿Cuál es el procedimiento?',0,'2026-03-01 14:45:00'),
(23,5,8,'Nueva solicitud de: Lucía Balam Tun','Donación en especie — Me gustaría donar ropa y víveres en buen estado. ¿Cuál es el procedimiento?',0,'2026-03-01 14:45:00'),
(24,8,8,'Nueva solicitud de: Lucía Balam Tun','Donación en especie — Me gustaría donar ropa y víveres en buen estado. ¿Cuál es el procedimiento?',0,'2026-03-01 14:45:00'),
(25,1,9,'Nueva solicitud de: Alejandro Dzul Uc','Voluntariado juvenil — Somos estudiantes de preparatoria y queremos participar como voluntarios.',1,'2026-03-02 22:20:00'),
(26,5,9,'Nueva solicitud de: Alejandro Dzul Uc','Voluntariado juvenil — Somos estudiantes de preparatoria y queremos participar como voluntarios.',0,'2026-03-02 22:20:00'),
(27,8,9,'Nueva solicitud de: Alejandro Dzul Uc','Voluntariado juvenil — Somos estudiantes de preparatoria y queremos participar como voluntarios.',0,'2026-03-02 22:20:00');

-- ============================================================
-- TABLAS LARAVEL
-- ============================================================

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (`key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `expiration` int NOT NULL, PRIMARY KEY (`key`), KEY `cache_expiration_index` (`expiration`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (`key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `expiration` int NOT NULL, PRIMARY KEY (`key`), KEY `cache_locks_expiration_index` (`expiration`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (`id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (`id`), UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (`id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `attempts` tinyint UNSIGNED NOT NULL, `reserved_at` int UNSIGNED DEFAULT NULL, `available_at` int UNSIGNED NOT NULL, `created_at` int UNSIGNED NOT NULL, PRIMARY KEY (`id`), KEY `jobs_queue_index` (`queue`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (`id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `total_jobs` int NOT NULL, `pending_jobs` int NOT NULL, `failed_jobs` int NOT NULL, `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, `cancelled_at` int DEFAULT NULL, `created_at` int NOT NULL, `finished_at` int DEFAULT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (`id` int UNSIGNED NOT NULL AUTO_INCREMENT, `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `batch` int NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1);

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (`email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `created_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`email`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (`id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `user_id` bigint UNSIGNED DEFAULT NULL, `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL, `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci, `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `last_activity` int NOT NULL, PRIMARY KEY (`id`), KEY `sessions_user_id_index` (`user_id`), KEY `sessions_last_activity_index` (`last_activity`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (`id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `email_verified_at` timestamp NULL DEFAULT NULL, `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL, `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, PRIMARY KEY (`id`), UNIQUE KEY `users_email_unique` (`email`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- RESTRICCIONES DE CLAVES FORÁNEAS
-- ============================================================

ALTER TABLE `rol_usuario` ADD CONSTRAINT `rol_usuario_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
ALTER TABLE `paginas` ADD CONSTRAINT `fk_paginas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
ALTER TABLE `inicio` ADD CONSTRAINT `inicio_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);
ALTER TABLE `nosotros` ADD CONSTRAINT `nosotros_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);
ALTER TABLE `aliados` ADD CONSTRAINT `aliados_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);
ALTER TABLE `contacto` ADD CONSTRAINT `contacto_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);
ALTER TABLE `directiva` ADD CONSTRAINT `directiva_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);
ALTER TABLE `preguntas_frecuentes` ADD CONSTRAINT `preguntas_frecuentes_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);
ALTER TABLE `actividades` ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`);
ALTER TABLE `widgets_actividades` ADD CONSTRAINT `widgets_actividades_ibfk_1` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id_actividad`);
ALTER TABLE `proyectos` ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_pagina`) REFERENCES `paginas` (`id_pagina`), ADD CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categoria_proyectos` (`id_categoria`);
ALTER TABLE `imagenes_proyectos` ADD CONSTRAINT `imagenes_proyectos_ibfk_1` FOREIGN KEY (`proyecto`) REFERENCES `proyectos` (`id_proyecto`);
ALTER TABLE `asistenciabeneficiarios` ADD CONSTRAINT `asistenciabeneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;
ALTER TABLE `reportebeneficiarios` ADD CONSTRAINT `reportebeneficiarios_ibfk_1` FOREIGN KEY (`id_informe`) REFERENCES `informe` (`id_informe`) ON DELETE CASCADE;
ALTER TABLE `notificaciones` ADD CONSTRAINT `notificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE, ADD CONSTRAINT `notificaciones_ibfk_2` FOREIGN KEY (`id_formulario`) REFERENCES `formulario_contacto` (`id_formcontacto`) ON DELETE SET NULL;

SET FOREIGN_KEY_CHECKS = 1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;