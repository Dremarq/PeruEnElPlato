-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2024 a las 18:12:25
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
(1, 1, 'admin', 'admin123', NULL);

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
`id_producto` int(11) DEFAULT NULL,
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
`fecha_contratacion` date DEFAULT NULL,
`estado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_rol`, `nombre`, `apellido`, `dni`, `telefono`, `email`, `direccion`, `fecha_contratacion`, `estado`) VALUES
(1, 1, 'Diego', 'Chavarry', '7545568', '993443125', 'diegoherbay@gmail.com', '15143', '2024-11-17', 1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
`id_plato` int(11) NOT NULL,
`nombre` varchar(255) NOT NULL,
`descripcion` text DEFAULT NULL,
`precio` decimal(10,2) NOT NULL,
`categoria` enum('Plato Principal','Entrada','Postre','Refresco') NOT NULL,
`imagen` varchar(255) DEFAULT NULL,
`estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`id_plato`, `nombre`, `descripcion`, `precio`, `categoria`, `imagen`, `estado`) VALUES
(1, 'aji de gallina', 'plato principal peruano', 20.00, 'Plato Principal', 'ajidegallina.jpg', 1),
(3, 'Aji de Gallina', 'Pechuga de pollo desmenuzada en una salsa cremosa de ají amarillo', 22.00, 'Plato Principal', 'aji_gallina.jpg', 1),
(4, 'Pollo a la Brasa', 'Pollo marinando en una mezcla de hierbas y especias, luego asado a la perfección', 20.00, 'Plato Principal', 'pollo_brasa.jpg', 1),
(5, 'Causa Rellena', 'Puré de papa amarilla relleno de atún, pollo o mariscos, acompañado con aguacate', 15.00, '', 'causa_rellena.jpg', 1),
(6, 'Tacu Tacu', 'Arroz con frijoles refritos acompañados de un filete de carne o pescado', 18.50, 'Plato Principal', 'tacu_tacu.jpg', 1),
(7, 'Chicha Morada', 'Bebida tradicional de maíz morado, especias y frutas', 5.00, '', 'chicha_morada.jpg', 1),
(8, 'Pisco Sour', 'Cóctel peruano a base de pisco, limón, clara de huevo y jarabe de goma', 7.50, '', 'pisco_sour.jpg', 1),
(9, 'Sopa Criolla', 'Sopa espesa de carne, fideos y verduras, acompañada con un toque de hierba buena', 12.00, '', 'sopa_criolla.jpg', 1),
(10, 'Arroz con Mariscos', 'Arroz preparado con mariscos frescos, cebolla, pimientos y ají', 26.00, 'Plato Principal', 'arroz_mariscos.jpg', 1),
(11, 'Lomo Saltado', 'Delicioso lomo de res salteado con cebollas, tomate, papas fritas y arroz', 28.00, 'Plato Principal', 'lomo_saltado.jpg', 1),
(12, 'Ceviche de Pescado', 'Ceviche fresco de pescado con jugo de limón, cebolla morada, cilantro y ají', 25.50, '', 'ceviche_pescado.jpg', 1);

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
(1, 1, '2024-11-19', 4),
(2, 1, '2024-11-19', 1),
(3, 1, '2024-11-19', 2),
(4, 1, '2024-11-19', 1),
(5, 9, '2024-11-19', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
`id_producto` int(11) NOT NULL,
`nombre` varchar(255) NOT NULL,
`descripcion` text DEFAULT NULL,
`costo` decimal(10,2) NOT NULL,
`estado` tinyint(1) DEFAULT 1,
`id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
`id_reserva` int(11) NOT NULL,
`id_usuario` int(11) DEFAULT NULL,
`id_empleado` int(11) DEFAULT NULL,
`fecha_reserva` datetime DEFAULT NULL,
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
(3, 'Cocinero', 'Encargado de la preparación de alimentos');

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
`usuario` varchar(30) NOT NULL,
`contraseña` varchar(30) NOT NULL,
`direccion` varchar(255) DEFAULT NULL,
`fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
ADD KEY `id_producto` (`id_producto`),
ADD KEY `fk_detalle_pedido_plato` (`id_plato`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
ADD PRIMARY KEY (`id_empleado`),
ADD KEY `id_rol` (`id_rol`);

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
ADD KEY `id_usuario` (`id_usuario`),
ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `almacen`
--
ALTER TABLE `almacen`
MODIFY `id_almacen` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
MODIFY `id_caja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
MODIFY `id_plato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `platos_vendidos_hoy`
--
ALTER TABLE `platos_vendidos_hoy`
MODIFY `id_plato_vendido_hoy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

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
ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

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
ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
ADD CONSTRAINT `detalle_pedido_ibfk_3` FOREIGN KEY (`id_plato`) REFERENCES `platos` (`id_plato`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

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
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
