-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2021 a las 22:47:38
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cm_db_comisiones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cm_vendedores`
--

CREATE TABLE `cm_vendedores` (
  `ven_idvendedor` int(11) NOT NULL,
  `ven_nombre` varchar(50) NOT NULL,
  `ven_ape_pat` varchar(50) NOT NULL,
  `ven_ape_mat` varchar(50) NOT NULL,
  `ven_porcentaje` decimal(10,2) NOT NULL,
  `ven_activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cm_vendedores_clientes`
--

CREATE TABLE `cm_vendedores_clientes` (
  `ven_cl_idcliente` int(11) NOT NULL,
  `ven_cl_idvendedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cm_vendedores`
--
ALTER TABLE `cm_vendedores`
  ADD PRIMARY KEY (`ven_idvendedor`);

--
-- Indices de la tabla `cm_vendedores_clientes`
--
ALTER TABLE `cm_vendedores_clientes`
  ADD KEY `fk_vendedor_cliente` (`ven_cl_idvendedor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cm_vendedores`
--
ALTER TABLE `cm_vendedores`
  MODIFY `ven_idvendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cm_vendedores_clientes`
--
ALTER TABLE `cm_vendedores_clientes`
  ADD CONSTRAINT `fk_vendedor_cliente` FOREIGN KEY (`ven_cl_idvendedor`) REFERENCES `cm_vendedores` (`ven_idvendedor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
