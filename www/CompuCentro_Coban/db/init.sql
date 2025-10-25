-- ==========================================
--   BASE DE DATOS COMPUCENTRO (Versión final)
-- ==========================================

CREATE DATABASE IF NOT EXISTS compucentro
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE compucentro;

-- ===============================
-- TABLAS BASE/CATÁLOGOS
-- ===============================
CREATE TABLE genero (
    id_genero INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50)
);

CREATE TABLE dias (
    id_dia INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL
);

CREATE TABLE jornadas (
    id_jornada INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    hora_inicio TIME,
    hora_fin TIME
);

-- ===============================
-- TABLAS DE USUARIOS Y SEGURIDAD
-- ===============================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    correo VARCHAR(150) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('admin','editor') DEFAULT 'admin',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_login DATETIME NULL
);

-- ===============================
-- TABLAS DE CONTENIDO
-- ===============================
CREATE TABLE inicio (
    id_inicio INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE galeria (
    id_foto INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150),
    descripcion TEXT,
    imagen VARCHAR(255) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE contenido (
    id_contenido INT AUTO_INCREMENT PRIMARY KEY,
    seccion ENUM('mision','vision','historia','valores','otros') NOT NULL,
    titulo VARCHAR(150),
    descripcion TEXT,
    imagen VARCHAR(255) NULL
);

CREATE TABLE testimonios (
    id_testimonio INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150),
    tipo ENUM('youtube','tiktok','archivo') DEFAULT 'archivo',
    url_video VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===============================
-- TABLAS DE CURSOS Y OFERTAS
-- ===============================
CREATE TABLE cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    subtitulo TEXT,
    descripcion TEXT,
    imagen VARCHAR(255),
    duracion VARCHAR(100),
    modalidad VARCHAR(150),
    estado ENUM('activo','inactivo') DEFAULT 'activo'
);

CREATE TABLE oferta_cursos (
    id_oferta INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT NOT NULL,
    id_jornada INT NOT NULL,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    FOREIGN KEY (id_jornada) REFERENCES jornadas(id_jornada)
);

CREATE TABLE oferta_dias (
    id_oferta INT NOT NULL,
    id_dia INT NOT NULL,
    PRIMARY KEY (id_oferta, id_dia),
    FOREIGN KEY (id_oferta) REFERENCES oferta_cursos(id_oferta) ON DELETE CASCADE,
    FOREIGN KEY (id_dia) REFERENCES dias(id_dia) ON DELETE CASCADE
);

-- ===============================
-- TABLAS DE INSCRIPCIÓN Y PERSONAS
-- ===============================
CREATE TABLE encargados (
    id_encargado INT AUTO_INCREMENT PRIMARY KEY,
    nombre1 VARCHAR(50) NOT NULL,
    nombre2 VARCHAR(50) NULL,
    apellido1 VARCHAR(50) NOT NULL,
    apellido2 VARCHAR(50) NULL,
    telefono VARCHAR(20)
);

CREATE TABLE interesados (
    id_interesado INT AUTO_INCREMENT PRIMARY KEY,
    id_encargado INT NULL,
    id_genero INT NULL,
    nombre1 VARCHAR(50) NOT NULL,
    nombre2 VARCHAR(50) NULL,
    apellido1 VARCHAR(50) NOT NULL,
    apellido2 VARCHAR(50) NULL,
    fecha_nacimiento DATE,
    telefono VARCHAR(20) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_encargado) REFERENCES encargados(id_encargado),
    FOREIGN KEY (id_genero) REFERENCES genero(id_genero)
);

CREATE TABLE preinscripciones (
    id_preinscripcion INT AUTO_INCREMENT PRIMARY KEY,
    id_interesado INT NOT NULL,
    id_oferta INT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fuente VARCHAR(60) DEFAULT 'sitio_web',
    FOREIGN KEY (id_interesado) REFERENCES interesados(id_interesado),
    FOREIGN KEY (id_oferta) REFERENCES oferta_cursos(id_oferta)
);

-- ===============================
-- TABLAS DE SISTEMA
-- ===============================
CREATE TABLE convocatorias (
    id_convocatoria INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    fecha_inicio DATE,
    fecha_fin DATE,
    estado ENUM('Vigente','Cerrada') DEFAULT 'Vigente',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(60),
    destino VARCHAR(160),
    asunto VARCHAR(200),
    mensaje TEXT,
    enviado TINYINT(1) DEFAULT 0,
    intentos INT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_envio TIMESTAMP NULL
);

CREATE TABLE logs (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NULL,
    accion VARCHAR(50),
    descripcion TEXT,
    tabla_afectada VARCHAR(60),
    id_registro_afectado INT,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);
