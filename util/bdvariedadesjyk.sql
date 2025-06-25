-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 06-06-2025 a las 00:14:47
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdvariedadesjyk`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase_producto`
--

DROP TABLE IF EXISTS `clase_producto`;
CREATE TABLE IF NOT EXISTS `clase_producto` (
  `idClase` int NOT NULL AUTO_INCREMENT,
  `Clase` varchar(20) NOT NULL,
  PRIMARY KEY (`idClase`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `clase_producto`
--

INSERT INTO `clase_producto` (`idClase`, `Clase`) VALUES
(1, 'Accesorios Bebes'),
(2, 'Accesorios Hogar'),
(3, 'Accesorios Mascotas'),
(4, 'Aceites'),
(5, 'Adhesivos'),
(6, 'Aguas'),
(7, 'Alimento de Bebe'),
(8, 'Alimento Mascotas'),
(9, 'Aperitivos'),
(10, 'Arepas'),
(11, 'Aromáticas'),
(12, 'Aseo Hogar'),
(13, 'Aseo Mascotas'),
(14, 'Aseo Personal'),
(15, 'Belleza'),
(16, 'Bisutería'),
(17, 'Café'),
(18, 'Calzado'),
(19, 'Carnes'),
(20, 'Cereales'),
(21, 'Chocolates'),
(22, 'Cocina'),
(23, 'Comidas Precocidas'),
(24, 'Condimentos'),
(25, 'Confitería'),
(26, 'Congelados'),
(27, 'Conservas'),
(28, 'Cremas de Untar'),
(29, 'Cuidado Capilar'),
(30, 'Cuidado Corporal'),
(31, 'Cuidado Facial'),
(32, 'Cuidado Manos'),
(33, 'Cuidado Oral'),
(34, 'Desechables'),
(35, 'Embutidos'),
(36, 'Encendedores'),
(37, 'Endulzantes'),
(38, 'Energizantes'),
(39, 'Enlatados'),
(40, 'Farmacia'),
(41, 'Ferretería'),
(42, 'Frutas'),
(43, 'Frutas Secas'),
(44, 'Galletas'),
(45, 'Gaseosas'),
(46, 'Gelatinas'),
(47, 'Granos'),
(48, 'Harinas'),
(49, 'Helados'),
(50, 'Hidratantes'),
(51, 'Huevos'),
(52, 'Insecticidas'),
(53, 'Jugos'),
(54, 'Lácteos '),
(55, 'Licores'),
(56, 'Maquillaje'),
(57, 'Mermeladas'),
(58, 'Miscelánea'),
(59, 'Otros'),
(60, 'Panadería'),
(61, 'Panadería Empacada'),
(62, 'Panadería Fresca'),
(63, 'Pasabocas'),
(64, 'Pastas'),
(65, 'Perfumería'),
(66, 'Pescado y Mariscos'),
(67, 'Pilas'),
(68, 'Ponqués'),
(69, 'Postres'),
(70, 'Productos Eléctricos'),
(71, 'Pulpa de Fruta'),
(72, 'Refrescos'),
(73, 'Repostería'),
(74, 'Ropa'),
(75, 'Salsas'),
(76, 'Sopas'),
(77, 'Tabaco'),
(78, 'Varios'),
(79, 'Verduras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `idCliente` int NOT NULL AUTO_INCREMENT,
  `idTipoDocum` int NOT NULL,
  `NumIdentificacion` varchar(15) NOT NULL,
  `Nombres` varchar(30) NOT NULL,
  `Apellidos` varchar(30) NOT NULL,
  `NumCelular` varchar(10) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Puntos` decimal(8,2) NOT NULL,
  PRIMARY KEY (`idCliente`),
  KEY `idTipoDocum` (`idTipoDocum`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`idCliente`, `idTipoDocum`, `NumIdentificacion`, `Nombres`, `Apellidos`, `NumCelular`, `Email`, `Puntos`) VALUES
(1, 1, '22222222', 'Cliente', 'No Registrado', '3000000000', 'clientenoregistrado@gmail.com', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigos_barras`
--

DROP TABLE IF EXISTS `codigos_barras`;
CREATE TABLE IF NOT EXISTS `codigos_barras` (
  `idCodigoBarra` int NOT NULL AUTO_INCREMENT,
  `CodigoBarra` varchar(10) NOT NULL,
  PRIMARY KEY (`idCodigoBarra`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `codigos_barras`
--

INSERT INTO `codigos_barras` (`idCodigoBarra`, `CodigoBarra`) VALUES
(1, '1000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada_productos`
--

DROP TABLE IF EXISTS `entrada_productos`;
CREATE TABLE IF NOT EXISTS `entrada_productos` (
  `idEntProducto` int NOT NULL AUTO_INCREMENT,
  `idProducto` int NOT NULL,
  `idProveedor` int NOT NULL,
  `FechaEnt` datetime NOT NULL,
  `FechaVencimiento` date NOT NULL,
  `PrecioCompra` int NOT NULL,
  `CantEnt` decimal(6,2) NOT NULL,
  PRIMARY KEY (`idEntProducto`),
  KEY `idProducto` (`idProducto`),
  KEY `idProveedor` (`idProveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formato_venta`
--

DROP TABLE IF EXISTS `formato_venta`;
CREATE TABLE IF NOT EXISTS `formato_venta` (
  `idFormatoVenta` int NOT NULL AUTO_INCREMENT,
  `FormatoVenta` varchar(10) NOT NULL,
  PRIMARY KEY (`idFormatoVenta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `formato_venta`
--

INSERT INTO `formato_venta` (`idFormatoVenta`, `FormatoVenta`) VALUES
(1, 'Unidad'),
(2, 'Granel');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `idInventario` int NOT NULL AUTO_INCREMENT,
  `idProducto` int NOT NULL,
  `CantActual` decimal(6,2) NOT NULL,
  PRIMARY KEY (`idInventario`),
  KEY `idProducto` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modo_pago`
--

DROP TABLE IF EXISTS `modo_pago`;
CREATE TABLE IF NOT EXISTS `modo_pago` (
  `idModoPago` int NOT NULL AUTO_INCREMENT,
  `ModoPago` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`idModoPago`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `modo_pago`
--

INSERT INTO `modo_pago` (`idModoPago`, `ModoPago`) VALUES
(1, 'Efectivo'),
(2, 'Credito'),
(3, 'Consumo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion_producto`
--

DROP TABLE IF EXISTS `presentacion_producto`;
CREATE TABLE IF NOT EXISTS `presentacion_producto` (
  `idPresentacion` int NOT NULL AUTO_INCREMENT,
  `Presentacion` varchar(20) NOT NULL,
  PRIMARY KEY (`idPresentacion`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `presentacion_producto`
--

INSERT INTO `presentacion_producto` (`idPresentacion`, `Presentacion`) VALUES
(1, 'Aerosol'),
(2, 'Atao'),
(3, 'Barra'),
(4, 'Bolsa'),
(5, 'Botella Plástico'),
(6, 'Botella Vidrio'),
(7, 'Bulto'),
(8, 'Caja'),
(9, 'Cojín'),
(10, 'Conjunto'),
(11, 'Corte de Carne'),
(12, 'Corte de Pescado'),
(13, 'Corte de Pollo'),
(14, 'Cubeta'),
(15, 'Detal'),
(16, 'Enlatados'),
(17, 'Frasco'),
(18, 'Gajo'),
(19, 'Juego'),
(20, 'Kit'),
(21, 'Lata'),
(22, 'Lata Pequeña'),
(23, 'Otra'),
(24, 'Papeleta'),
(25, 'Paquete'),
(26, 'Par'),
(27, 'Pieza'),
(28, 'Racimo'),
(29, 'Recipiente Cartón'),
(30, 'Recipiente Metálico'),
(31, 'Recipiente Plástico'),
(32, 'Rollo'),
(33, 'Sobre'),
(34, 'Taco'),
(35, 'Tetra Pak'),
(36, 'Tubo Metálico'),
(37, 'Tubo Plástico'),
(38, 'Vaso'),
(39, 'DoyPack');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `idProducto` int NOT NULL AUTO_INCREMENT,
  `CodProducto` varchar(20) NOT NULL,
  `idClase` int NOT NULL,
  `Nombre` varchar(40) NOT NULL,
  `Marca` varchar(20) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `idPresentacion` int NOT NULL,
  `ContNeto` int NOT NULL,
  `idUndBase` int NOT NULL,
  `idFormatoVenta` int NOT NULL,
  `PrecioVenta` int NOT NULL,
  `Foto` varchar(100) NOT NULL,
  PRIMARY KEY (`idProducto`),
  KEY `idClase` (`idClase`),
  KEY `idPresentacion` (`idPresentacion`),
  KEY `idUndBase` (`idUndBase`),
  KEY `idFormatoVenta` (`idFormatoVenta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `promociones`
--

DROP TABLE IF EXISTS `promociones`;
CREATE TABLE IF NOT EXISTS `promociones` (
  `idPromocion` int NOT NULL AUTO_INCREMENT,
  `idProducto` int NOT NULL,
  `Descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`idPromocion`),
  KEY `idProducto` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `idProveedor` int NOT NULL AUTO_INCREMENT,
  `NitProveedor` varchar(15) NOT NULL,
  `NombreProveedor` varchar(30) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `CelularProveedor` varchar(10) NOT NULL,
  `NombreVendedor` varchar(30) NOT NULL,
  `CelularVendedor` varchar(10) NOT NULL,
  PRIMARY KEY (`idProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`idProveedor`, `NitProveedor`, `NombreProveedor`, `Email`, `CelularProveedor`, `NombreVendedor`, `CelularVendedor`) VALUES
(1, '22222222', 'Proveedor No Registrado', 'proveedornoregistrado@gmail.com', '3000000000', 'Vendedor No Registrado', '3000000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_usuarios`
--

DROP TABLE IF EXISTS `registro_usuarios`;
CREATE TABLE IF NOT EXISTS `registro_usuarios` (
  `idUsuario` int NOT NULL AUTO_INCREMENT,
  `idTipoDocum` int NOT NULL,
  `NumIdentificacion` varchar(15) NOT NULL,
  `Nombres` varchar(30) NOT NULL,
  `Apellidos` varchar(30) NOT NULL,
  `NumCelular` varchar(10) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `idRol` int NOT NULL,
  `Usuario` varchar(10) NOT NULL,
  `Contraseña` varchar(150) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `idTipoDocum` (`idTipoDocum`),
  KEY `idRol` (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `registro_usuarios`
--

INSERT INTO `registro_usuarios` (`idUsuario`, `idTipoDocum`, `NumIdentificacion`, `Nombres`, `Apellidos`, `NumCelular`, `Email`, `idRol`, `Usuario`, `Contraseña`) VALUES
(1, 1, '11111111', 'Usuario', 'Administrador', '3000000000', 'administradorjyk@gmail.com', 1, 'adminjyk', '$2y$10$11eswcBHJHBHWJQIHr1BSuA.BFyPk7AnzAYnkodLBLskzi3evK0V6'),
(2, 1, '22222222', 'Usuario', 'Empleado', '3000000000', 'empleadojyk@gmail.com', 2, 'empleadojy', '$2y$10$7zRCthp72zHoesqZck4I6eh6rUmHFXdTpWr4Z3.SjEhfCAvQvPhGK');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `idRol` int NOT NULL AUTO_INCREMENT,
  `Rol` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `Rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida_productos`
--

DROP TABLE IF EXISTS `salida_productos`;
CREATE TABLE IF NOT EXISTS `salida_productos` (
  `idSalProducto` int NOT NULL AUTO_INCREMENT,
  `idProducto` int NOT NULL,
  `idCliente` int NOT NULL,
  `FechaSalida` datetime NOT NULL,
  `CantSalida` decimal(6,2) NOT NULL,
  `PrecioVenta` int NOT NULL,
  `idModoPago` int NOT NULL,
  PRIMARY KEY (`idSalProducto`),
  KEY `idProducto` (`idProducto`),
  KEY `idCliente` (`idCliente`),
  KEY `idModoPago` (`idModoPago`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

DROP TABLE IF EXISTS `tipo_documento`;
CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `idTipoDocum` int NOT NULL AUTO_INCREMENT,
  `tipoDocum` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoDocum`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`idTipoDocum`, `tipoDocum`) VALUES
(1, 'CC'),
(2, 'TI'),
(3, 'RC'),
(4, 'PPT'),
(5, 'CE'),
(6, 'VISA'),
(7, 'PASS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_base`
--

DROP TABLE IF EXISTS `unidad_base`;
CREATE TABLE IF NOT EXISTS `unidad_base` (
  `idUndBase` int NOT NULL AUTO_INCREMENT,
  `UndBase` varchar(10) NOT NULL,
  PRIMARY KEY (`idUndBase`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;

--
-- Volcado de datos para la tabla `unidad_base`
--

INSERT INTO `unidad_base` (`idUndBase`, `UndBase`) VALUES
(1, 'g'),
(2, 'Kg'),
(3, 'L'),
(4, 'ml'),
(5, 'Und'),
(6, 'Mts');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`idTipoDocum`) REFERENCES `tipo_documento` (`idTipoDocum`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `entrada_productos`
--
ALTER TABLE `entrada_productos`
  ADD CONSTRAINT `entrada_productos_ibfk_1` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrada_productos_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idClase`) REFERENCES `clase_producto` (`idClase`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`idUndBase`) REFERENCES `unidad_base` (`idUndBase`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`idPresentacion`) REFERENCES `presentacion_producto` (`idPresentacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_4` FOREIGN KEY (`idFormatoVenta`) REFERENCES `formato_venta` (`idFormatoVenta`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `promociones`
--
ALTER TABLE `promociones`
  ADD CONSTRAINT `promociones_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `registro_usuarios`
--
ALTER TABLE `registro_usuarios`
  ADD CONSTRAINT `registro_usuarios_ibfk_1` FOREIGN KEY (`idTipoDocum`) REFERENCES `tipo_documento` (`idTipoDocum`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registro_usuarios_ibfk_2` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `salida_productos`
--
ALTER TABLE `salida_productos`
  ADD CONSTRAINT `salida_productos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salida_productos_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `salida_productos_ibfk_3` FOREIGN KEY (`idModoPago`) REFERENCES `modo_pago` (`idModoPago`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
