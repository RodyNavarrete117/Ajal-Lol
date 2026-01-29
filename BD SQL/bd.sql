-- Crear base de datos
CREATE DATABASE IF NOT EXISTS fundacion_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fundacion_db;

-- Tabla: seccion
CREATE TABLE seccion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    orden INT NOT NULL,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla: inicio
CREATE TABLE inicio (
    id_seccion INT PRIMARY KEY,
    titulo_inicio VARCHAR(255) NOT NULL,
    texto TEXT,
    img VARCHAR(255),
    url VARCHAR(255),
    FOREIGN KEY (id_seccion) REFERENCES seccion(id) ON DELETE CASCADE
);

-- Tabla: widgets_nosotros
CREATE TABLE widgets_nosotros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dato VARCHAR(100) NOT NULL,
    subtitulo_widgets_nosotros VARCHAR(255)
);

-- Tabla: nosotros
CREATE TABLE nosotros (
    id_seccion INT PRIMARY KEY,
    titulo_nosotros VARCHAR(255) NOT NULL,
    imagen VARCHAR(255),
    subtitulo_nosotros VARCHAR(255),
    texto TEXT,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id) ON DELETE CASCADE
);

-- Tabla: aliados
CREATE TABLE aliados (
    id_seccion INT PRIMARY KEY,
    id INT AUTO_INCREMENT UNIQUE,
    img_aliados VARCHAR(255),
    FOREIGN KEY (id_seccion) REFERENCES seccion(id) ON DELETE CASCADE
);

-- Tabla: widgets_actividades
CREATE TABLE widgets_actividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_activades INT,
    icono VARCHAR(255),
    titulo VARCHAR(255),
    texto TEXT
);

-- Tabla: actividades
CREATE TABLE actividades (
    id_seccion INT PRIMARY KEY,
    id INT AUTO_INCREMENT UNIQUE,
    titulo VARCHAR(255) NOT NULL,
    año YEAR,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id) ON DELETE CASCADE
);

-- Tabla: categoria_proyectos
CREATE TABLE categoria_proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL UNIQUE
);

-- Tabla: proyectos
CREATE TABLE proyectos (
    id_seccion INT,
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    categoria_id INT,
    año YEAR,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id) ON DELETE CASCADE,
    FOREIGN KEY (categoria_id) REFERENCES categoria_proyectos(id) ON DELETE SET NULL
);

-- Tabla: imagenes_proyectos
CREATE TABLE imagenes_proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    proyecto_id INT NOT NULL,
    ruta VARCHAR(255) NOT NULL,
    orden INT,
    descripcion TEXT,
    creado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (proyecto_id) REFERENCES proyectos(id) ON DELETE CASCADE
);

-- Tabla: directiva
CREATE TABLE directiva (
    id_seccion INT,
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    img VARCHAR(255),
    orden INT,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id) ON DELETE CASCADE
);

-- Tabla: preguntas_frecuentes
CREATE TABLE preguntas_frecuentes (
    id_seccion INT,
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta TEXT NOT NULL,
    respuesta TEXT NOT NULL,
    FOREIGN KEY (id_seccion) REFERENCES seccion(id) ON DELETE CASCADE
);

-- Tabla: contacto
CREATE TABLE contacto (
    id_seccion INT PRIMARY KEY,
    direccion VARCHAR(255),
    telefono VARCHAR(50),
    email VARCHAR(100),
    FOREIGN KEY (id_seccion) REFERENCES seccion(id) ON DELETE CASCADE
);

-- Tabla: formulario_contacto
CREATE TABLE formulario_contacto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(255) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    asunto VARCHAR(255),
    mensaje TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla: redes_sociales
CREATE TABLE redes_sociales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    url VARCHAR(255) NOT NULL
);

-- Tabla: rol_usuario
CREATE TABLE rol_usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rol VARCHAR(50) NOT NULL UNIQUE
);

-- Tabla: usuario
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    rol_usuario_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rol_usuario_id) REFERENCES rol_usuario(id) ON DELETE SET NULL
);

-- Tabla: informe
CREATE TABLE informe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_organizacion VARCHAR(255) NOT NULL,
    evento VARCHAR(255),
    lugar VARCHAR(255),
    fecha DATE,
    numero INT,
    personas_beneficiarias INT,
    curp VARCHAR(18)
);

-- Insertar roles por defecto
INSERT INTO rol_usuario (rol) VALUES 
('administrador'), 
('editor'), 
('usuario');

-- Insertar secciones principales
INSERT INTO seccion (titulo, orden, activo) VALUES 
('Inicio', 1, TRUE),
('Nosotros', 2, TRUE),
('Aliados', 3, TRUE),
('Actividades', 4, TRUE),
('Proyectos', 5, TRUE),
('Directiva', 6, TRUE),
('Preguntas Frecuentes', 7, TRUE),
('Contacto', 8, TRUE);