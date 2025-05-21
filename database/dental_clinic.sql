-- CREACION DE LA BASE DE DATOS
CREATE DATABASE IF NOT EXISTS dental_clinic;
USE dental_clinic;

-- CREACION DE LA TABLA users_data
CREATE TABLE IF NOT EXISTS users_data (
    idUser INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    direccion TEXT,
    sexo ENUM('M', 'F', 'Otro')
);

-- CREACION DE LA TABLA users_login
CREATE TABLE IF NOT EXISTS users_login (
    idLogin INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    idUser INT NOT NULL UNIQUE,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'user') NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser)
);

-- CREACION DE LA TABLA citas 
CREATE TABLE IF NOT EXISTS citas (
    idCita INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    idUser INT NOT NULL,
    fecha_cita DATE NOT NULL,
    motivo_cita TEXT,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser)
);

-- CREACION DE LA TABLA noticias 
CREATE TABLE IF NOT EXISTS noticias (
    idNoticia INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL UNIQUE,
    imagen VARCHAR(255) NOT NULL,
    texto TEXT NOT NULL,
    fecha DATE NOT NULL,
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES users_data(idUser)
); 