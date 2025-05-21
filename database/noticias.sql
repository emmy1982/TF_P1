-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2025 a las 20:57:35
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dental_clinic`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  `fecha` date NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `imagen`, `texto`, `fecha`, `idUser`) VALUES
(1, 'Nuevo Sistema de Blanqueamiento Dental Avanzado', 'https://images.unsplash.com/photo-1629909613654-28e377c37b09', 'Nos complace anunciar la incorporación de nuestro nuevo sistema de blanqueamiento dental avanzado. Esta tecnología de última generación permite resultados más rápidos y duraderos, con un mínimo de sensibilidad. El tratamiento se realiza en una sola sesión y los resultados son visibles inmediatamente. Nuestros pacientes pueden esperar una sonrisa hasta 8 tonos más blanca, manteniendo la salud de sus dientes y encías.', '2024-03-15', 3),
(2, 'Importancia de la Higiene Dental en Niños', 'https://images.unsplash.com/photo-1606265752439-1f18756aa5fc', 'La salud dental en los niños es fundamental para su desarrollo. En nuestra clínica, hemos implementado un programa especial de educación dental para niños, donde enseñamos técnicas de cepillado adecuadas y la importancia de una buena higiene oral. Los padres pueden solicitar una cita para una evaluación gratuita y recibirán un kit de higiene dental para sus hijos.', '2024-03-10', 3),
(3, 'Inauguración de Nueva Unidad de Ortodoncia', 'https://images.unsplash.com/photo-1588776814546-1ffcf47267a5', 'Estamos orgullosos de anunciar la inauguración de nuestra nueva unidad de ortodoncia, equipada con la última tecnología en diagnóstico y tratamiento. Ofrecemos una amplia gama de opciones, desde brackets tradicionales hasta alineadores invisibles. Nuestro equipo de ortodoncistas especializados está listo para ayudarte a conseguir la sonrisa que siempre has deseado.', '2024-03-05', 3),
(4, 'Prevención de Caries: Guía Completa', 'https://images.unsplash.com/photo-1541604193435-22287d32c2c2', 'La prevención es la mejor manera de mantener una sonrisa saludable. En este artículo, compartimos consejos expertos sobre cómo prevenir la caries dental: desde técnicas de cepillado hasta recomendaciones dietéticas. Recuerda que una visita regular al dentista cada 6 meses es fundamental para detectar y tratar problemas a tiempo.', '2024-02-28', 3),
(5, 'Nuevo Tratamiento para la Sensibilidad Dental', 'https://images.unsplash.com/photo-1629909615184-74f495363b67', 'Hemos incorporado un nuevo tratamiento para la sensibilidad dental que proporciona alivio inmediato y duradero. Este tratamiento innovador fortalece el esmalte dental y reduce la sensibilidad a alimentos fríos, calientes o dulces. La mayoría de los pacientes experimentan una mejora significativa después de la primera sesión.', '2024-02-20', 3),
(6, 'Cuidado Dental durante el Embarazo', 'https://images.unsplash.com/photo-1516627145497-ae6968895b74', 'El embarazo es un momento especial que requiere cuidados dentales específicos. Hemos creado un programa especial para mujeres embarazadas que incluye revisiones periódicas, limpiezas profesionales y consejos para mantener una salud dental óptima durante esta etapa. La primera consulta es gratuita para todas las futuras mamás.', '2024-02-15', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`),
  ADD UNIQUE KEY `titulo` (`titulo`),
  ADD KEY `idUser` (`idUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users_data` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
