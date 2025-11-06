-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2025 a las 16:30:52
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
-- Base de datos: `halo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) NOT NULL,
  `nombre` text NOT NULL,
  `categoria` varchar(99) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `precio` int(10) NOT NULL,
  `imagen` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `categoria`, `descripcion`, `precio`, `imagen`) VALUES
(2, 'remera skibidi', '', '', 10000, 'imgProductos/68dfdd0171fa5_403633896_734534128721164_394961482513270526_n.jpg'),
(3, 'remera momo', '', '', 10000, 'imgProductos/68e45c29954d8_R.jpg'),
(4, 'remera cola', '', '', 10000, 'imgProductos/68e45c420a3e3_colapa-mockup-a86e68bfd05c6b1c4c17418484046194-1024-1024.webp'),
(5, 'remera chat', '', '', 10000, 'imgProductos/68e827fcc174b_e.jpg'),
(6, 'remera fetucris', '', '', 10000, 'imgProductos/68e82814ecad9_t.jpg'),
(7, 'remera fa', '', '', 12000, 'imgProductos/68e829139fb00_e.jpg'),
(9, 'remera uma musume', 'remera remeras uma umamusume umamusume pretty derby', '', 25000, 'imgProductos/68fa9d4db1545_uma shirt.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(20) NOT NULL,
  `email_usuario` varchar(40) NOT NULL,
  `contraseña_usuario` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `email_usuario`, `contraseña_usuario`) VALUES
(3, 'alejandrocouste13@gmail.com', '$2y$10$hKzRWQsSJ7OqZBA/X/msiu3'),
(4, 'Ketosur2022@gmail.com', '$2y$10$/29ae0IBi035eeZjNcb3k.6'),
(5, 'iygyt8ugu@gamail.cxom', '$2y$10$sQeJzxkHVaPpjOXvObjZb.c');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
