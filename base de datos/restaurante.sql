-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-12-2024 a las 21:21:37
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

--
-- Volcado de datos para la tabla `almacen`
--

INSERT INTO `almacen` (`id_almacen`, `id_producto`, `stock_actual`, `stock_minimo`, `fecha_actualizacion`) VALUES
(1, 1, 1, 1, '2024-11-25 23:20:23');

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
-- Estructura de tabla para la tabla `mantenimiento_productos`
--

CREATE TABLE `mantenimiento_productos` (
  `id_mant_prod` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_pedir` int(11) NOT NULL,
  `fecha_llegada` date NOT NULL,
  `precio_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 4, 1, '2024-11-25 18:55:00', 'En Proceso', 'Delivery', 0.01);

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
(5, 4, '2024-11-19', 3),
(7, 10, '2024-11-25', 2),
(8, 1, '2024-11-19', 1),
(9, 12, '2024-11-25', 1),
(10, 9, '2024-11-25', 1),
(11, 3, '2024-11-26', 7),
(12, 3, '2024-11-26', 1),
(13, 4, '2024-11-26', 2),
(14, 7, '2024-11-26', 8),
(15, 5, '2024-11-26', 8),
(16, 5, '2024-11-26', 8),
(17, 5, '2024-11-26', 2),
(18, 7, '2024-11-26', 2),
(19, 10, '2024-11-26', 1),
(20, 6, '2024-11-26', 1);

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

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `descripcion`, `costo`, `estado`, `id_proveedor`) VALUES
(1, 'Arroz', 'blanco', 132.00, 1, 1),
(2, 'Leche', 'deslactosada', 4.50, 1, 1),
(3, 'Aceite', 'Bellcorp', 7.50, 1, 1);

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
(1, 'La lucha', '817254789', '948751748', 'lucha@gmail.com', 'calle 123', NULL);

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
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `dni`, `telefono`, `email`, `usuario`, `contraseña`, `direccion`, `fecha_registro`) VALUES
(1, 'Juan', 'Pérez', '12345678', '987654321', 'juan.perez@example.com', 'juanperez', 'contrasena123', 'Av. Las Flores 123', '2024-11-25'),
(2, 'María', 'González', '23456789', '976543210', 'maria.gonzalez@example.com', 'mariagonzalez', 'mariapass456', 'Calle Los Pinos 456', '2024-11-24'),
(3, 'Carlos', 'Ramírez', '34567890', '965432109', 'carlos.ramirez@example.com', 'carlosramirez', 'carlosecret789', 'Calle Sol 789', '2024-11-23'),
(4, 'Ana', 'Martínez', '45678901', '954321098', 'ana.martinez@example.com', 'anamartinez', 'ana12345', 'Av. La Libertad 101', '2024-11-22'),
(5, 'Luis', 'Fernández', '56789012', '943210987', 'luis.fernandez@example.com', 'luisfernandez', 'luis67890', 'Calle El Sol 102', '2024-11-21'),
(6, 'Elena', 'Rodríguez', '67890123', '932109876', 'elena.rodriguez@example.com', 'elenarodriguez', 'elena65432', 'Av. Los Pinos 103', '2024-11-20'),
(7, 'Pedro', 'Sánchez', '78901234', '921098765', 'pedro.sanchez@example.com', 'pedrosanchez', 'pedro98765', 'Calle Las Palmas 104', '2024-11-19'),
(8, 'Lucía', 'Gómez', '89012345', '910987654', 'lucia.gomez@example.com', 'luciagomez', 'lucia43210', 'Calle San Martín 105', '2024-11-18'),
(9, 'Raúl', 'Hernández', '90123456', '909876543', 'raul.hernandez@example.com', 'raulhernandez', 'raul54321', 'Av. La Paz 106', '2024-11-17'),
(10, 'Sofía', 'López', '01234567', '898765432', 'sofia.lopez@example.com', 'sofia.lopez', 'sofiaqwerty', 'Calle La Merced 107', '2024-11-16'),
(11, 'José', 'Pérez', '12345679', '887654321', 'jose.perez@example.com', 'joseperez', 'jose2024', 'Av. Primavera 108', '2024-11-15'),
(12, 'Isabel', 'Martín', '23456780', '876543210', 'isabel.martin@example.com', 'isabelmartin', 'isabel1111', 'Calle Santa Cruz 109', '2024-11-14'),
(13, 'Tomás', 'Jiménez', '34567891', '865432109', 'tomas.jimenez@example.com', 'tomasjimenez', 'tomas5555', 'Calle Los Andes 110', '2024-11-13'),
(14, 'Marcos', 'García', '45678902', '854321098', 'marcos.garcia@example.com', 'marcosgarcia', 'marcos4444', 'Calle Real 111', '2024-11-12'),
(15, 'Gabriela', 'Vega', '56789013', '843210987', 'gabriela.vega@example.com', 'gabrielavega', 'gaby7777', 'Calle Las Acacias 112', '2024-11-11');

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
  MODIFY `id_almacen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT de la tabla `mantenimiento_productos`
--
ALTER TABLE `mantenimiento_productos`
  MODIFY `id_mant_prod` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `platos`
--
ALTER TABLE `platos`
  MODIFY `id_plato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `platos_vendidos_hoy`
--
ALTER TABLE `platos_vendidos_hoy`
  MODIFY `id_plato_vendido_hoy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
