-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Servidor: fdb13.runhosting.com
-- Tiempo de generación: 30-11-2016 a las 06:32:18
-- Versión del servidor: 5.7.16-log
-- Versión de PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `2195476_am`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autos`
--

CREATE TABLE `autos` (
  `id_auto` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 NOT NULL,
  `modelo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `anio` varchar(255) CHARACTER SET latin1 NOT NULL,
  `precio` varchar(255) CHARACTER SET latin1 NOT NULL,
  `stock` varchar(255) CHARACTER SET latin1 NOT NULL,
  `categoria` varchar(255) CHARACTER SET latin1 NOT NULL,
  `img` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `descripcion` varchar(1000) CHARACTER SET latin1 NOT NULL,
  `marca` varchar(255) CHARACTER SET latin1 NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `autos`
--

INSERT INTO `autos` (`id_auto`, `nombre`, `modelo`, `anio`, `precio`, `stock`, `categoria`, `img`, `date`, `descripcion`, `marca`, `estado`) VALUES
(11, 'Mercedes bens', '1000', '2016', '3333', '4', 'Camioneta', 'resourses/imgs/Jetta_rojo-31829.jpg', '2016-09-02 10:34:53', 'Es muy linda xD', 'Toyota xD', 1),
(12, 'Model 3', '3', '2016', '40000', '5', 'Automóvil deportivo', 'resourses/imgs/section-initial-touch.jpg', '2016-09-03 16:20:49', 'Lo ultimo en tecnología tesla el modelo 3 es uno de los mejores carros electricos que existe por no decir que es el mejor. Adquierelo ya en Auto Maniacos', 'Tesla', 1),
(13, 'Audi - Spyder', 'R8', '2015', '60000', '8', 'Automóvil deportivo', 'resourses/imgs/2015_Audi_R8_CoupÃ©_5.2_FSI_quattro_(19409896583).jpg', '2016-09-03 16:22:53', 'Genial Carro de la marca audi, de los mejores en su categor?a', 'Audi', 1),
(14, 'Toyota Hilux', 'Hilux 2017', '2016', '27000', '15', 'Vehículo deportivo utilitario', 'resourses/imgs/hilux.jpg', '2016-09-03 17:55:35', 'Carro todoterreno para la mayoíia de las actividades básicas de automovilismo.', 'Toyota', 1),
(15, 'BMW X6', 'X6', '2016', '43000', '12', 'Vehículo deportivo utilitario', 'resourses/imgs/bmwx6.jpg', '2016-09-03 17:58:15', 'Carro de la marca bmw para toda ocasión práctico y ergonómico', 'BMW ', 1),
(16, 'Nissan - Altima', 'Altima', '2016', '26000', '6', 'Automóvil de turismo', 'resourses/imgs/altima.jpg', '2016-09-03 18:02:12', 'Carro versátil para todo lugar, util para dezplazamientos largos y cortos, una gran comodidad garantizada.', 'Nissan', 1),
(17, 'Lamborghini - Murcielago 2016', 'Murcielago', '2016', '200000', '5', 'Automóvil deportivo', 'resourses/imgs/lamborghiniMurcielago.jpg', '2016-09-08 01:51:56', 'Auto de lujo de la marca lamborghini', 'Lamborghini', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autos_guardados`
--

CREATE TABLE `autos_guardados` (
  `id_usuario` int(11) NOT NULL,
  `id_auto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `autos_guardados`
--

INSERT INTO `autos_guardados` (`id_usuario`, `id_auto`) VALUES
(5, 11),
(5, 12),
(7, 13),
(7, 12),
(5, 16),
(9, 12),
(9, 13),
(10, 12),
(5, 14),
(12, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_ap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dui` varchar(15) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilegios` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_ap`, `username`, `email`, `dui`, `departamento`, `password`, `privilegios`, `estado`, `date`) VALUES
(3, 'Vendedor 1', 'demo_v', 'vendedor@vendedor.com', '00000000-0', 'San Miguel', '72ebbd778cacbdf917e3599a045e6048906a577b', 1, 1, '2016-09-03 08:29:43'),
(4, 'demo_admin', 'demo_adm', 'demo_adm@demo.com', '00000000-0', 'San Miguel', 'ea48c4bc7295943ccd90658fd5ec3cd868bb6e7f', 2, 1, '2016-09-03 08:31:15'),
(5, 'Saul Isai Alvarenga Bonilla', 'Cliente', 'pul98alvarenga@gmail.com', '1234567891', 'San Miguel', '145b21ee4b8074139114adf98744d7357ff1c0a5', 0, 1, '2016-09-03 16:10:03'),
(6, 'Vendedor 2 - Usulutan', 'demo_v2', 'oigalickehago@gmail.com', '1234567898', 'Usulutan', '9d7fb4987a4a8736ec67940375038b4a44d6b13c', 1, 1, '2016-09-03 16:32:24'),
(7, 'Cliente 2 - Usulutan', 'Cliente2', 'example@gmail.com', '1234567898', 'Usulutan', '145b21ee4b8074139114adf98744d7357ff1c0a5', 0, 1, '2016-09-03 16:34:01'),
(8, 'Luisvillalta', 'Luis', 'amayantonio@hotmail.com', '8764686468', 'San Miguel', '5e80660a8086c231c04f094d73ef214803cd6de1', 0, 1, '2016-09-03 17:46:17'),
(9, 'huddd', 'mmhmm', 'castro@yopmail.com', '8787878787', 'San Miguel', '8cb2237d0679ca88db6464eac60da96345513964', 0, 1, '2016-09-05 04:58:45'),
(10, 'Erick Martinez ', 'erickmin', 'osminerick@gmail.com', '00000000-0', 'San Miguel', '3c37de8b23b7d056307c05f6cb01030f4b3af4bb', 0, 1, '2016-09-06 15:47:20'),
(11, 'Salvador Azucar', 'azucar', 'salva.alexander1995@gmail.com', '00000000-0', 'San Miguel', '86f4bfcb4eadebb139485f41879709291cf20149', 0, 1, '2016-09-06 19:25:29'),
(12, 'Salvador Alexander ', 'azucar1', 'salva.alexander1995@gmail.com', '00000000-0', 'San Miguel', '8cb2237d0679ca88db6464eac60da96345513964', 0, 1, '2016-09-06 19:32:55'),
(13, 'David Guevara', 'Mooses', 'david.jervis93@gmail.com', '03333944-4', 'San Miguel', 'd44896319e1d2255d1c9d8b3bf109a43995f9eb8', 0, 1, '2016-09-13 03:01:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_usuario` int(11) NOT NULL,
  `id_auto` int(11) NOT NULL,
  `id_vendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_usuario`, `id_auto`, `id_vendedor`) VALUES
(5, 11, 3),
(5, 12, 3),
(7, 13, 6),
(7, 12, 6),
(5, 16, 6),
(7, 13, 3),
(5, 11, 3),
(12, 16, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas2`
--

CREATE TABLE `ventas2` (
  `id_venta` int(11) NOT NULL,
  `usuario` varchar(155) NOT NULL,
  `monto` varchar(255) NOT NULL,
  `departamento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ventas2`
--

INSERT INTO `ventas2` (`id_venta`, `usuario`, `monto`, `departamento`) VALUES
(1, 'demo_v', '3333', 'San Miguel'),
(2, 'demo_v', '40000', 'San Miguel'),
(3, 'demo_v2', '60000', 'Usulutan'),
(4, 'demo_v2', '40000', 'Usulutan'),
(5, 'demo_v2', '26000', 'Usulutan'),
(6, 'demo_v', '60000', 'San Miguel'),
(7, 'demo_v', '3333', 'San Miguel'),
(8, 'demo_v', '26000', 'San Miguel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zona`
--

CREATE TABLE `zona` (
  `id_zona` int(11) NOT NULL,
  `zona` varchar(255) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `zona`
--

INSERT INTO `zona` (`id_zona`, `zona`, `data`) VALUES
(4, 'San Miguel', '2016-09-03 00:03:07'),
(5, 'Usulutan', '2016-09-03 00:26:24');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `autos`
--
ALTER TABLE `autos`
  ADD PRIMARY KEY (`id_auto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas2`
--
ALTER TABLE `ventas2`
  ADD PRIMARY KEY (`id_venta`);

--
-- Indices de la tabla `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`id_zona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `autos`
--
ALTER TABLE `autos`
  MODIFY `id_auto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `ventas2`
--
ALTER TABLE `ventas2`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `zona`
--
ALTER TABLE `zona`
  MODIFY `id_zona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
