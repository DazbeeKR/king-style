-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-11-2025 a las 19:51:54
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

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
(2, 'Remera Skibidi', 'remera skibidi toilet', 'Remera de la popular serie de internet Skibidi Toilet.', 10000, 'imgProductos/68dfdd0171fa5_403633896_734534128721164_394961482513270526_n.jpg'),
(3, 'Remera Momo', 'remera remeras momo fantasma italiano', 'Remera del influencer Momo', 10000, 'imgProductos/68e45c29954d8_R.jpg'),
(4, 'Remera Colapinto', 'remera remeras colapinto f1 formula formula1', 'Remera negra con estampado del automovilista argentino Franco Colapinto.', 10000, 'imgProductos/68e45c420a3e3_colapa-mockup-a86e68bfd05c6b1c4c17418484046194-1024-1024.webp'),
(5, 'Remera Chat', 'remera remeras chat', 'Remera blanca con estampado de un chat.', 10000, 'imgProductos/68e827fcc174b_e.jpg'),
(6, 'Remera Fetu Christ', 'remera remeras fetucris cris fetu', 'Remera de la banda de rock Fetu Christ', 10000, 'imgProductos/68e82814ecad9_t.jpg'),
(9, 'Remera Umamusume', 'remera remeras uma umamusume umamusume pretty derby', 'Remera del videojuego japonés Umamusume Pretty Derby', 25000, 'imgProductos/68fa9d4db1545_uma shirt.jpeg'),
(10, 'Remera Stratovarius', 'remera remeras rock banda folk stratovarius', 'Remera de la banda Stratovarius', 14000, 'imgProductos/69026f23b9133_strato.webp'),
(11, 'Remera Python', 'remera remeras python programacion negro negra', 'Remera negra con estampado del lenguaje de programaciÃ³n Python', 12500, 'imgProductos/69026f624c4cd_python.webp'),
(12, 'Pantalon Cargo Negro', 'pantalon pantalones cargo negro', 'PantalÃ³n cargo de color negro', 16000, 'imgProductos/6902704c01eb6_cargonegro.webp'),
(13, 'Pantalon Cargo Marron', 'pantalon pantalones cargo marron', 'Pantalon cargo de color marrÃ³n', 16000, 'imgProductos/6902707a98c07_cargomarron.webp'),
(14, 'Pantalon Nautico Blanco', 'pantalon pantalones nautico blanco comodo', 'Pantalon blanco nautico', 15000, 'imgProductos/690270c32c12b_pantalonblanco.jpg'),
(15, 'Pantalon Jean ', 'pantalon pantalones jean azul', 'PantalÃ³n jean comÃºn de color azul', 18000, 'imgProductos/6902713aa33df_jeanazul.jpg'),
(16, 'PantalÃ³n Jena Negro', 'pantalon pantalones jean negro salida', 'PantalÃ³n jean comÃºn de color negro', 18000, 'imgProductos/6902716c96b27_jean negro.webp'),
(17, 'Short Gris', 'short shorts bermuda bermudas gris verano calor', 'PantalÃ³n corto de color gris', 12000, 'imgProductos/6902741605124_bermuda gris tranqui.png'),
(18, 'Bermuda Verde', 'short shorts bermuda bermudas verde verano calor', 'Bermuda de color verde.', 14200, 'imgProductos/6902746b5284a_bermudaverde.jpg'),
(19, 'Short Adidas Negro', 'short shorts deporte deportivo deportivos negro adidas', 'Short deportivo negro de la marca Adidas', 15000, 'imgProductos/690274a1ce095_short adidas negro.jpg'),
(20, 'Short John Pork', 'short shorts john johnpork pork cerdo pig', 'Short del ciudadano John Pork', 20000, 'imgProductos/69027515804b3_john pork.jpg'),
(21, 'Short Vegeta', 'short shorts vegeta dbz dragon dragonball dragonballz saiyayin saiyan supersaiyan', 'Short del principe saiyan Vegeta de Dragon Ball', 16000, 'imgProductos/69027564ea1c8_short vegeta.jpg'),
(22, 'Short Umbro Negro', 'short shorts deporte deportivo deportivos negro umbro', 'Short deportivo negro de la marca Umbro', 14000, 'imgProductos/69027596106c5_short entrenamiento umbro negro.jpg'),
(23, 'Short Champion Gris', 'short shorts deporte deportivo deportivos mixto gris champion', 'Short gris de la marca Champion', 15000, 'imgProductos/690275d00bfa8_short deportivo champion gris claro.jpg'),
(24, 'Boxer Gris Hanes', 'ropa interior ropainterior boxer hanes gris', 'Boxer liso gris de la marca Hanes', 10000, 'imgProductos/69027736c3e7a_boxer liso gris hanes.webp'),
(25, 'Boxer Lebron James', 'ropa interior ropainterior boxer lebron nba basquetbol basketball', 'Boxer gris de Lebron James.', 11000, 'imgProductos/6902779e72295_boxer lebron.jpg'),
(26, 'Boxer Blanco FrÃ©res', 'ropa interior ropainterior boxer freres blanco', 'Boxer liso blanco de la marca FrÃ©res', 10000, 'imgProductos/690277e9ca903_boxer blanco freres.webp'),
(28, 'Boxer Legacy Negro', 'ropa interior ropainterior boxer legacy negro ', 'Boxer de la marca Legacy de color negro.', 8500, 'imgProductos/69027882bdc96_boxer liso legacy.webp'),
(29, 'Remera Negra Lisa', 'remera remeras negra simple', 'Remera negra lisa comÃºn', 12000, 'imgProductos/690283ae5dd76_negra.png'),
(32, 'Cadena de Plata', 'accesorios cadena plata accesorio cuello', 'Cadena de Plata para el cuello.', 22000, 'imgProductos/690286da89a47_cadena.jpg'),
(33, 'Collar con MoÃ±o', 'accesorios accesorio cadena plata moÃ±o cuello', 'Collar de plata con decoraciÃ³n de un moÃ±o', 24000, 'imgProductos/690287e926828_collarmoÃ±ito.webp'),
(34, 'Pulsera Alpaca', 'accesorios accesorio pulsera alpaca mano', 'Pulsera con diseÃ±o alpaca', 15000, 'imgProductos/6902885ea7d21_pulseraalpaca.jpg'),
(35, 'Pulsera Lisa Azul', 'accesorios accesorio pulsera mano azul simple liso lisa', 'Pulsera lisa comÃºn de color azul', 14000, 'imgProductos/690288a32caac_pulserasimple.jpg'),
(36, 'Camisa de Polo MarrÃ³n', 'camisa remera remeras polo marron', 'Camisa de polo marrÃ³n', 16000, 'imgProductos/690289577b231_camisa de polo marron.jpg'),
(37, 'Camisa Blanca con Cuello Mao', 'remera remeras camisa blanca mao cuello', 'Camisa blanca con diseÃ±o de cuello mao', 16500, 'imgProductos/6902898ce9f0c_camisa cuello mao.jpg'),
(38, 'Cuello TÃ©rmico Negro', 'accesorios cuello negro termico negro', 'Cuello tÃ©rmico negro', 16000, 'imgProductos/69028d72d7d71_cuellonegro.jpg'),
(39, 'Cuello TÃ©rmico Azul', 'accesorios cuello invierno azul termico', 'Cuello tÃ©rmico azul.', 16000, 'imgProductos/69028d9982f8e_cuellotermicoazul.jpg');

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
