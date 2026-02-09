CREATE DATABASE IF NOT EXISTS prueba1
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE prueba1;

-- =========================
-- USUARIOS
-- =========================
CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    correo_usuario VARCHAR(100) NOT NULL UNIQUE,
    contraseña_usuario VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- =========================
-- ROLES DE USUARIO
-- =========================
CREATE TABLE rol_usuario (
    id_rol_usuario INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    cargo_usuario ENUM('administrador','editor') NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario)
) ENGINE=InnoDB;

-- =========================
-- SECCIONES
-- =========================
CREATE TABLE seccion (
    id_seccion INT AUTO_INCREMENT PRIMARY KEY,
    id_rol_usuario INT NOT NULL,
    titulo_seccion VARCHAR(100) NOT NULL,
    estado_seccion TINYINT(1) DEFAULT 1,
    FOREIGN KEY (id_rol_usuario) REFERENCES rol_usuario(id_rol_usuario)
) ENGINE=InnoDB;

-- =========================
-- INICIO
-- =========================
CREATE TABLE inicio (
    id_inicio INT AUTO_INCREMENT PRIMARY KEY,
    id_seccion INT NOT NULL,
    titulo_inicio VARCHAR(150),
    texto_inicio TEXT,
    img_inicio VARCHAR(255),
    url_inicio VARCHAR(255),
    FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
) ENGINE=InnoDB;

-- =========================
-- NOSOTROS
-- =========================
CREATE TABLE nosotros (
    id_nosotros INT AUTO_INCREMENT PRIMARY KEY,
    id_seccion INT NOT NULL,
    titulo_nosotros VARCHAR(150),
    imagen_nosotros VARCHAR(255),
    subtitulo_nosotros VARCHAR(150),
    texto_nosotros TEXT,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
) ENGINE=InnoDB;

-- =========================
-- ALIADOS
-- =========================
CREATE TABLE aliados (
    id_aliados INT AUTO_INCREMENT PRIMARY KEY,
    id_seccion INT NOT NULL,
    img_aliados VARCHAR(255),
    FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
) ENGINE=InnoDB;

-- =========================
-- ACTIVIDADES
-- =========================
CREATE TABLE actividades (
    id_actividad INT AUTO_INCREMENT PRIMARY KEY,
    id_seccion INT NOT NULL,
    anio_actividad INT,
    titulo_actividad VARCHAR(150),
    texto_actividad TEXT,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
) ENGINE=InnoDB;

-- =========================
-- WIDGETS ACTIVIDADES
-- =========================
CREATE TABLE widgets_actividades (
    id_widgetactividad INT AUTO_INCREMENT PRIMARY KEY,
    actividad_id INT NOT NULL,
    titulo VARCHAR(100),
    texto TEXT,
    FOREIGN KEY (actividad_id) REFERENCES actividades(id_actividad)
) ENGINE=InnoDB;

-- =========================
-- CATEGORÍAS PROYECTOS
-- =========================
CREATE TABLE categoria_proyectos (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    orden INT
) ENGINE=InnoDB;

-- =========================
-- PROYECTOS
-- =========================
CREATE TABLE proyectos (
    id_proyecto INT AUTO_INCREMENT PRIMARY KEY,
    id_seccion INT NOT NULL,
    categoria INT NOT NULL,
    titulo_proyecto VARCHAR(150),
    descripcion_proyecto TEXT,
    anio_proyecto INT,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion),
    FOREIGN KEY (categoria) REFERENCES categoria_proyectos(id_categoria)
) ENGINE=InnoDB;

-- =========================
-- IMÁGENES PROYECTOS
-- =========================
CREATE TABLE imagenes_proyectos (
    id_imagen INT AUTO_INCREMENT PRIMARY KEY,
    proyecto INT NOT NULL,
    ruta VARCHAR(255),
    descripcion TEXT,
    fecha_creacion DATE,
    FOREIGN KEY (proyecto) REFERENCES proyectos(id_proyecto)
) ENGINE=InnoDB;

-- =========================
-- DIRECTIVA
-- =========================
CREATE TABLE directiva (
    id_directiva INT AUTO_INCREMENT PRIMARY KEY,
    id_seccion INT NOT NULL,
    nombre_directiva VARCHAR(150),
    foto_directiva VARCHAR(255),
    orden_directiva INT,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
) ENGINE=InnoDB;

-- =========================
-- PREGUNTAS FRECUENTES
-- =========================
CREATE TABLE preguntas_frecuentes (
    id_preguntasfrecuentes INT AUTO_INCREMENT PRIMARY KEY,
    id_seccion INT NOT NULL,
    titulo_pregunta VARCHAR(150),
    texto_respuesta TEXT,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
) ENGINE=InnoDB;

-- =========================
-- CONTACTO
-- =========================
CREATE TABLE contacto (
    id_contacto INT AUTO_INCREMENT PRIMARY KEY,
    id_seccion INT NOT NULL,
    direccion_contacto VARCHAR(255),
    telefono_contacto VARCHAR(50),
    email_contacto VARCHAR(100),
    FOREIGN KEY (id_seccion) REFERENCES seccion(id_seccion)
) ENGINE=InnoDB;

-- =========================
-- TABLAS INDEPENDIENTES
-- =========================
CREATE TABLE formulario_contacto (
    id_formcontacto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(150),
    correo VARCHAR(100),
    numero_telefonico VARCHAR(50),
    asunto VARCHAR(150),
    mensaje TEXT,
    fecha_envio DATE
) ENGINE=InnoDB;

CREATE TABLE redes_sociales (
    id_redes_sociales INT AUTO_INCREMENT PRIMARY KEY,
    nombre_redsocial VARCHAR(50),
    url_redsocial VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE informe (
    id_informe INT AUTO_INCREMENT PRIMARY KEY,
    nombre_organizacion VARCHAR(150),
    evento VARCHAR(150),
    lugar VARCHAR(150),
    fecha DATE,
    numero_telefonico VARCHAR(50),
    personas_beneficiarias INT,
    curp VARCHAR(30)
) ENGINE=InnoDB;

-- =========================
-- INSERTS ADMIN Y EDITOR (CON CIFRADO)
-- =========================

INSERT INTO usuario (correo_usuario, contraseña_usuario) VALUES
('admin@ajallol.com', SHA2('12345678', 256)),   -- administrador | contraseña: 12345678
('editor@ajallol.com', SHA2('12345678', 256));  -- editor        | contraseña: 12345678

INSERT INTO rol_usuario (id_usuario, cargo_usuario) VALUES
(1, 'administrador'),
(2, 'editor');

INSERT INTO seccion (id_rol_usuario, titulo_seccion, estado_seccion) VALUES
(1, 'Panel Administrador', 1),
(2, 'Panel Editor', 1);