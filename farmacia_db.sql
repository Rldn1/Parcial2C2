-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 24-04-2026 a las 15:50:05
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
-- Base de datos: `farmacia_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medicas`
--

CREATE TABLE `citas_medicas` (
  `id` int(11) NOT NULL,
  `paciente_nombre` varchar(60) NOT NULL,
  `telefono` varchar(9) NOT NULL,
  `medico` varchar(50) NOT NULL,
  `tipo_consulta` varchar(20) NOT NULL,
  `fecha_cita` date NOT NULL,
  `fecha_segunda_cita` date DEFAULT NULL,
  `sintomas` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `citas_medicas`
--

INSERT INTO `citas_medicas` (`id`, `paciente_nombre`, `telefono`, `medico`, `tipo_consulta`, `fecha_cita`, `fecha_segunda_cita`, `sintomas`, `fecha_registro`) VALUES
(1, 'María López', '7777-1234', 'Dra. Ana García', 'General', '2026-11-10', NULL, 'Dolor de cabeza y fiebre...', '2026-04-24 13:24:59'),
(2, 'Carlos Menjívar', '7890-5678', 'Dr. José Rodríguez', 'Especialista', '2026-12-12', '2027-03-10', 'Dolor en el pecho...', '2026-04-24 13:25:07'),
(3, 'Laura Flores', '7123-9876', 'Dra. Marta Sánchez', 'General', '2026-11-15', NULL, 'Tos seca y congestión...', '2026-04-24 13:25:19'),
(4, 'Roberto Díaz', '7456-3210', 'Dr. Luis Pérez', 'Especialista', '2026-12-18', '2027-05-18', 'Problemas de visión...', '2026-04-24 13:25:26'),
(5, 'Ana Martínez', '7788-5544', 'Dra. Ana García', 'General', '2026-11-20', NULL, 'Dolor de oído...', '2026-04-24 13:25:33'),
(6, 'Isabel Cruz', '6001-5632', 'Dra. Marta Sánchez', 'Especialista', '2026-04-30', NULL, 'Dolor de cabeza...', '2026-04-24 13:25:45'),
(7, 'Alex', 'Martinez', 'Dra. Ana García', 'General', '2026-06-18', '2026-09-25', 'Dolor de cuello...', '2026-04-24 13:26:11'),
(8, 'Fer Rodríguez', '7456-5476', 'Dr. Luis Pérez', 'General', '2026-04-29', NULL, 'Dolor de espalda...', '2026-04-24 13:26:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `rol`, `email`) VALUES
(1, 'admin', '$2y$10$D.qz5/CMz9C8lE.Bty72vOWezCRiniFExo7aX9VFG1AUd4JCdq0kO', 'admin', 'admin@farmacia.com'),
(2, 'juan_perez', '$2y$10$U1QRyaIIVVPnkhVHZnCZi.4iBt69WCy9nQR2VRrejFS7XUZ5rYonW', 'user', 'juan@farmacia.com'),
(3, 'maria_gomez', '$2y$10$2qziEs0wEGQK4pq.nuU5Y.cvdT51rvtZYxxgEojEaW61FbgPw.OPy', 'user', 'maria@farmacia.com'),
(4, 'carlos_ramirez', '$2y$10$60JkhnreXHFWxxAg.ozEfOhbtOYTLHmEoqVIoE7PgeuzFO56QwPGG', 'user', 'carlos@farmacia.com'),
(5, 'laura_martinez', '$2y$10$URgfPAkuZdMYUwPleRVo6.M.Xbb1IdIBOUyQutGm6fzrHfnre89yy', 'user', 'laura@farmacia.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
