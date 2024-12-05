-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2024 a las 06:58:21
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
-- Base de datos: `restaurante`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `ultimo_acceso` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id_admin`, `id_empleado`, `username`, `password`, `ultimo_acceso`) VALUES
(1, 1, 'admin', 'admin123', NULL),
(2, 8, 'marco123', 'marco123', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacen`
--

CREATE TABLE `almacen` (
  `id_almacen` int(11) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `stock_actual` int(11) NOT NULL,
  `stock_minimo` int(11) NOT NULL,
  `fecha_actualizacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id_almacen`, `id_producto`, `stock_actual`, `stock_minimo`, `fecha_actualizacion`) VALUES
(2, 12, 3, 5, '2024-12-05 09:24:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_apertura` datetime DEFAULT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_inicial` decimal(10,2) DEFAULT NULL,
  `monto_final` decimal(10,2) DEFAULT NULL,
  `total_ingresos` decimal(10,2) DEFAULT NULL,
  `total_egresos` decimal(10,2) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `id_plato` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `id_rol` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_contratacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_rol`, `nombre`, `apellido`, `dni`, `telefono`, `email`, `direccion`, `fecha_contratacion`) VALUES
(1, 1, 'Diego Martina', 'Chavarry', '75455622', '993443125', '0aaada@gmail.com', '15143', '2024-11-17'),
(8, 7, 'Marco', 'Inta', '44415555', '993144131', 'diegohe1rbay@gmail.com', '15314', '2024-11-21');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `login_sesion`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `login_sesion` (
`id_admin` int(11)
,`nombre` varchar(100)
,`apellido` varchar(100)
,`email` varchar(100)
,`username` varchar(50)
,`password` varchar(255)
,`id_rol` int(11)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento_productos`
--

CREATE TABLE `mantenimiento_productos` (
  `id_mant_prod` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_pedir` int(11) NOT NULL,
  `fecha_llegada` date NOT NULL,
  `precio_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mantenimiento_productos`
--

INSERT INTO `mantenimiento_productos` (`id_mant_prod`, `id_producto`, `cantidad_pedir`, `fecha_llegada`, `precio_total`) VALUES
(0, 12, 20, '2024-12-05', 40.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `fecha_pedido` datetime DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `tipo_pedido` varchar(20) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `id_empleado`, `fecha_pedido`, `estado`, `tipo_pedido`, `total`) VALUES
(1, 15, 8, '2024-12-05 12:00:00', 'Pendiente', 'Dine-in', 50.00),
(2, 16, 8, '2024-12-05 12:30:00', 'En Proceso', 'Delivery', 75.00),
(3, 17, 8, '2024-12-05 13:00:00', 'Completado', 'Para Llevar', 100.00),
(4, 19, 8, '2024-12-05 13:30:00', 'Pendiente', 'Dine-in', 30.00),
(5, 20, 8, '2024-12-05 14:00:00', 'Completado', 'Delivery', 60.00),
(6, 21, 8, '2024-12-05 14:30:00', 'En Proceso', 'Para Llevar', 90.00),
(7, 15, 8, '2024-12-05 15:00:00', 'Pendiente', 'Dine-in', 45.00),
(8, 16, 8, '2024-12-05 15:30:00', 'Completado', 'Delivery', 80.00),
(9, 17, 8, '2024-12-05 16:00:00', 'En Proceso', 'Para Llevar', 55.00),
(10, 19, 8, '2024-12-05 16:30:00', 'Pendiente', 'Dine-in', 25.00),
(11, 20, 8, '2024-12-05 17:00:00', 'Completado', 'Delivery', 70.00),
(12, 21, 8, '2024-12-05 17:30:00', 'En Proceso', 'Para Llevar', 95.00),
(13, 15, 8, '2024-12-05 18:00:00', 'Pendiente', 'Dine-in', 65.00),
(14, 16, 8, '2024-12-05 18:30:00', 'Completado', 'Delivery', 85.00),
(15, 17, 8, '2024-12-05 19:00:00', 'En Proceso', 'Para Llevar', 40.00),
(16, 15, 8, '2024-01-05 12:00:00', 'Pendiente', 'Dine-in', 50.00),
(17, 16, 8, '2024-02-10 12:30:00', 'En Proceso', 'Delivery', 75.00),
(18, 17, 8, '2024-03-15 13:00:00', 'Completado', 'Para Llevar', 100.00),
(19, 19, 8, '2024-04-20 13:30:00', 'Pendiente', 'Dine-in', 30.00),
(20, 20, 8, '2024-05-25 14:00:00', 'Completado', 'Delivery', 60.00),
(21, 21, 8, '2024-06-30 14:30:00', 'En Proceso', 'Para Llevar', 90.00),
(22, 15, 8, '2024-07-05 15:00:00', 'Pendiente', 'Dine-in', 45.00),
(23, 16, 8, '2024-08-10 15:30:00', 'Completado', 'Delivery', 80.00),
(24, 17, 8, '2024-09-15 16:00:00', 'En Proceso', 'Para Llevar', 55.00),
(25, 19, 8, '2024-10-20 16:30:00', 'Pendiente', 'Dine-in', 25.00),
(26, 20, 8, '2024-11-25 17:00:00', 'Completado', 'Delivery', 70.00),
(27, 21, 8, '2024-12-30 17:30:00', 'En Proceso', 'Para Llevar', 95.00),
(28, 15, 8, '2024-01-15 18:00:00', 'Pendiente', 'Dine-in', 65.00),
(29, 16, 8, '2024-02-20 18:30:00', 'Completado', 'Delivery', 85.00),
(30, 17, 8, '2024-03-25 19:00:00', 'En Proceso', 'Para Llevar', 40.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `id_plato` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` enum('Principal','Entrada','Postre','Refresco') NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`id_plato`, `nombre`, `descripcion`, `precio`, `categoria`, `imagen`, `estado`) VALUES
(19, 'picarones', 'Dulces fritos a base de camote y calabaza, bañados en miel de chancaca. ¡Un postre tradicional y delicioso!', 15.00, 'Postre', '', 1),
(20, 'turron', 'Dulce tradicional de almendras, nueces y miel.', 18.00, 'Postre', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos_vendidos_hoy`
--

CREATE TABLE `platos_vendidos_hoy` (
  `id_plato_vendido_hoy` int(11) NOT NULL,
  `id_plato` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `cant_vendida` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos_vendidos_hoy`
--

INSERT INTO `platos_vendidos_hoy` (`id_plato_vendido_hoy`, `id_plato`, `fecha`, `cant_vendida`) VALUES
(7, 19, '2024-12-03', 3),
(8, 19, '2024-12-03', 3),
(9, 19, '2024-12-03', 1),
(10, 19, '2024-12-03', 1),
(11, 19, '2024-12-05', 2),
(12, 19, '2024-12-05', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(300) DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `costo`, `estado`, `id_proveedor`) VALUES
(12, 'huevo', 'huevo para la huancaina', 40.00, 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_empresa` varchar(100) DEFAULT NULL,
  `ruc` varchar(11) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_empresa`, `ruc`, `telefono`, `email`, `direccion`, `estado`) VALUES
(5, 'CAMOTITO S.A.C', '10646562344', '913161616', 'dimaherbay@gmail.com', '1453', 1),
(6, 'CANMONT SAC', '10262646464', '949494661', 'diegoherbay@gmail.com', '15221', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `numero_mesa` int(11) DEFAULT NULL,
  `fecha_reserva` date DEFAULT NULL,
  `hora_reserva` time DEFAULT NULL,
  `cantidad_personas` int(11) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`, `descripcion`) VALUES
(1, 'Administrador', 'Gestor completo del sistema'),
(2, 'Cajero', 'Responsable de las transacciones'),
(3, 'Cocinero', 'Encargado de la preparación de alimentos'),
(7, 'Mesero', 'Atención a los clientes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `dni` varchar(8) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `usuario` varchar(30) NOT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `dni`, `telefono`, `email`, `direccion`, `usuario`, `contrasena`, `fecha_registro`) VALUES
(15, 'Diego', 'Herbay', '46904442', '993443125', 'diegoherbay@gmail.com', '15314', 'dimar123', '$2y$10$eOy6MUyBcM.5ucF7v91kSOGUe7rRuZgqhNv9KFGQH54y898CD1K7e', '2024-11-20'),
(16, 'marco', 'gonzalez', '46464646', '992443125', 'diegohekbay@gmail.com', '15314', 'marco', '$2y$10$GKdmU5Kk/gDfVkpct6CG7uvjBuDsnKEhfezb9LVj200WDoOQRb3q.', '2024-11-20'),
(17, 'Diego', 'Chavarry', '11155566', '907950690', 'dieg11oherbay@gmail.com', '15113', 'diego', '$2y$10$wOWIhwyxpHnj7A8CEvchS.y0In/2AZzZ5ALcQR/4LTjh1uTwYGTLW', '2024-12-03'),
(19, 'Dieguin', 'Herbay', '75444664', '993443125', 'diegoherbay@gmail.com', '15314', 'dino', '$2y$10$EU.Nahdz5UKRpJNgJPPBBu.OxTaQ.m4/KNzHBNyMG3Hgmf01gVnhC', '2024-12-05'),
(20, 'Juan', 'Pérez', '12345678', '987654321', 'juan.perez@example.com', '15123', 'juanperez', '$2y$10$VIflbthoLNc8BkbXntOZs.6X8nM4aLzDRrlsZ3Uk0xNdYCNfavQHG', '2024-12-05'),
(21, 'María', 'Gómez', '23456789', '998877665', 'maria.gomez@example.com', '1513', 'mariagomez', '$2y$10$Hzv7CzC2ujxLbvsB/ouLQecsGW8Q80yxufgyAnFA67WGXESq9u0N6', '2024-12-05'),
(22, 'Carlos', 'Rodríguez', '34567890', '976543210', 'carlos.rodriguez@example.com', 'Lima', 'carlosr', '$2y$10$A.hP/mTeJEQSU/8hyRI1neQm9vUGFCa6XzH5B3unbzf./eDFoW3Ku', '2024-12-05'),
(23, 'Laura', 'Torres', '45678901', '912345678', 'laura.torres@example.com', 'Lima', 'lauratorres', '$2y$10$w2r0OcONIkawUOPXfc1RjOQgsBKWFXL34nNW601U5D0To349iNOGG', '2024-12-05'),
(24, 'Ricardo', 'Sánchez', '56789012', '998877554', 'ricardo.sanchez@example.com', 'Lima', 'ricardosanchez', '$2y$10$4/THqb7GHKJTeEw6bcGrIeO2s7Wu9QCGclHN5JHPfufI3BN4oc.jG', '2024-12-05'),
(25, 'Patricia', 'Díaz', '67890123', '991234567', 'patricia.diaz@example.com', 'Lima', 'patricia.diaz', '$2y$10$HN8X.GE7rE3GlWKQS6oVkueWu7vy/gVqWu8Co14dMCEsJsqY.ySaC', '2024-12-05'),
(26, 'Luis', 'Herrera', '78901234', '996789012', 'luis.herrera@example.com', 'Lima', 'luis.herrera', '$2y$10$uFWjDsqu3vajsGf6IwQvJ.Pci0eRXz8QIfTfudT0DmpmIsTkHUMhO', '2024-12-05'),
(27, 'Antonio', 'Mendoza', '78912345', '987654987', 'antonio.mendoza@example.com', 'Lima', 'antonio.m', '$2y$10$BQ.2NBJ7hqZOK6/CKmoaMepoKx3BTVxnRrdjr7Xk1zCVkBh0ae1A2', '2024-12-05'),
(28, 'Lucía', 'Fernández', '89023456', '998877998', 'lucia.fernandez@example.com', 'Lima', 'luciaf', '$2y$10$ZUyfnI3ynNlp64fGvoiXAuP9aX1fqT7IIKsnwPkgBm8w.LxRgdZV2', '2024-12-05'),
(29, 'Gabriel', 'Martínez', '90134567', '976543876', 'gabriel.martinez@example.com', 'Lima', 'gabrielm', '$2y$10$wsOO1A7k2k9Ee8IJT1fWz.D2SjZMeACwijZACbJisLhvyZjQMRXMK', '2024-12-05'),
(30, 'Eva', 'González', '91245678', '965432123', 'eva.gonzalez@example.com', 'Lima', 'evag', '$2y$10$8YUHq9chUYlsA/X/7aeLCuM9hslv3758aEEW2/f2PTbfBIDKqkycO', '2024-12-05'),
(31, 'Jorge', 'Vásquez', '92356789', '987654321', 'jorge.vasquez@example.com', 'Lima', 'jorgev', '$2y$10$BydrQ80CHcig5eICCJVvTu6MNXBTK.8BopqoFh0BQq.v0EA8r0gUS', '2024-12-05'),
(32, 'Ana', 'Ramírez', '93467890', '973456789', 'ana.ramirez@example.com', 'Lima', 'anar', '$2y$10$qWmjH/88mLA/IFgpSMbjAO/LJuodyaj0w5C.tQHQcL3jjwXT3Ehy6', '2024-12-05'),
(33, 'Pedro', 'Alvarado', '94578901', '982345678', 'pedro.alvarado@example.com', 'Lima', 'pedroa', '$2y$10$t1Rxj27EGFHveJKX9I89/eO./YeX0brIz9aL2AGUzSepzGRWDx8LG', '2024-12-05'),
(34, 'Isabel', 'Paredes', '95689012', '991234567', 'isabel.paredes@example.com', 'Lima', 'isabelp', '$2y$10$VEeaLmps96eb.ggG4QzlhO4cW6CuL8i94im6W9p8AD2rX5XVaqfIW', '2024-12-05'),
(35, 'Roberto', 'Castro', '96790123', '996789012', 'roberto.castro@example.com', 'Lima', 'robertoc', '$2y$10$Mj6vwR/MpemfXlu.EWLYTeC2hY0ds4TQ8qz1iGQT3sri1Eb0ixPIa', '2024-12-05'),
(36, 'Patricia', 'Navarro', '97801234', '988765432', 'patricia.navarro@example.com', 'Lima', 'patrician', '$2y$10$We5C/CgHpBv7xYwSvK8sn.M1oqapwleTLyUIEfjW0GPy2eBZl3rLG', '2024-12-05');

-- --------------------------------------------------------

--
-- Estructura para la vista `login_sesion`
--
DROP TABLE IF EXISTS `login_sesion`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `login_sesion`  AS SELECT `a`.`id_admin` AS `id_admin`, `e`.`nombre` AS `nombre`, `e`.`apellido` AS `apellido`, `e`.`email` AS `email`, `a`.`username` AS `username`, `a`.`password` AS `password`, `e`.`id_rol` AS `id_rol` FROM (`admin` `a` join `empleados` `e` on(`a`.`id_empleado` = `e`.`id_empleado`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD PRIMARY KEY (`id_almacen`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `fk_detalle_pedido_plato` (`id_plato`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `mantenimiento_productos`
--
ALTER TABLE `mantenimiento_productos`
  ADD PRIMARY KEY (`id_mant_prod`),
  ADD KEY `fk_mantenimiento_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id_plato`);

--
-- Indices de la tabla `platos_vendidos_hoy`
--
ALTER TABLE `platos_vendidos_hoy`
  ADD PRIMARY KEY (`id_plato_vendido_hoy`),
  ADD KEY `id_plato` (`id_plato`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `dni` (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
  MODIFY `id_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `id_plato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `platos_vendidos_hoy`
--
ALTER TABLE `platos_vendidos_hoy`
  MODIFY `id_plato_vendido_hoy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);

--
-- Filtros para la tabla `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `fk_detalle_pedido_plato` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id_plato`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `mantenimiento_productos`
--
ALTER TABLE `mantenimiento_productos`
  ADD CONSTRAINT `fk_mantenimiento_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);

--
-- Filtros para la tabla `platos_vendidos_hoy`
--
ALTER TABLE `platos_vendidos_hoy`
  ADD CONSTRAINT `platos_vendidos_hoy_ibfk_1` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id_plato`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE SET NULL;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
