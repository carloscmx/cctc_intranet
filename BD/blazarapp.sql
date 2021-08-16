-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-06-2021 a las 06:23:24
-- Versión del servidor: 10.4.19-MariaDB
-- Versión de PHP: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `blazarapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `afiliados`
--

CREATE TABLE `afiliados` (
  `idafiliado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `afiliados`
--

INSERT INTO `afiliados` (`idafiliado`) VALUES
(86),
(1);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dr_correos`
--

CREATE TABLE `dr_correos` (
  `dr_id` int(11) NOT NULL,
  `dr_email` varchar(50) NOT NULL,
  `dr_password` text NOT NULL,
  `dr_sr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dr_correos`
--

INSERT INTO `dr_correos` (`dr_id`, `dr_email`, `dr_password`, `dr_sr_id`) VALUES
(1, 'soporte@blazar.com.mx', 'mtSg5dPVVo4=', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fac_archivos`
--

CREATE TABLE `fac_archivos` (
  `fac_arc_id` int(11) NOT NULL,
  `fac_arc_nombre` varchar(50) NOT NULL,
  `fac_arc_ash` text NOT NULL,
  `id_fac_reference` int(11) NOT NULL,
  `fac_arc_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fac_referencias`
--

CREATE TABLE `fac_referencias` (
  `fac_id` int(11) NOT NULL,
  `fac_idinvoice` int(11) NOT NULL,
  `fac_detalle` text NOT NULL,
  `fac_activo` int(11) NOT NULL DEFAULT 1,
  `fac_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fac_tipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lg_perfiles`
--

CREATE TABLE `lg_perfiles` (
  `lg_perfil_id` int(11) NOT NULL,
  `lg_perfil_nombre` varchar(50) NOT NULL,
  `lg_perfil_activo` int(11) NOT NULL DEFAULT 1,
  `lg_patch` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lg_perfiles`
--

INSERT INTO `lg_perfiles` (`lg_perfil_id`, `lg_perfil_nombre`, `lg_perfil_activo`, `lg_patch`) VALUES
(1, 'Administrador', 1, 'home/dashboard'),
(2, 'Vendedores', 1, 'directory/vendedores/vendedores-clientes'),
(3, 'Proveedores de licencia windows', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lg_usuarios`
--

CREATE TABLE `lg_usuarios` (
  `lg_usuarios_id` int(11) NOT NULL,
  `lg_usuarios_nombre` varchar(50) NOT NULL,
  `lg_usuarios_password` text NOT NULL,
  `lg_usuarios_lg_perfiles_id` int(11) NOT NULL,
  `lg_activo` int(11) NOT NULL DEFAULT 1,
  `lg_external_id` int(11) DEFAULT NULL,
  `lg_usuarios_correo` varchar(50) NOT NULL,
  `lg_reset` int(11) NOT NULL,
  `lg_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lg_usuarios`
--

INSERT INTO `lg_usuarios` (`lg_usuarios_id`, `lg_usuarios_nombre`, `lg_usuarios_password`, `lg_usuarios_lg_perfiles_id`, `lg_activo`, `lg_external_id`, `lg_usuarios_correo`, `lg_reset`, `lg_creacion`) VALUES
(20, 'ccauich', 'lbDR4sPsnYqaog==', 1, 1, 1, 'ccauich@blazar.com.mx', 0, '2021-06-07 09:11:02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licenciaswindows`
--

CREATE TABLE `licenciaswindows` (
  `idlicenciawin` int(11) NOT NULL,
  `licencia` varchar(50) NOT NULL,
  `idtipolicencia` int(11) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  `fechacompra` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'Fecha en la que se lo compramos alos probedores',
  `fechaventa` timestamp NULL DEFAULT NULL,
  `costocompralic` decimal(10,2) NOT NULL,
  `costoventalic` decimal(10,2) NOT NULL,
  `idprovedorlic` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provedoreslicencia`
--

CREATE TABLE `provedoreslicencia` (
  `idprovedor` int(11) NOT NULL,
  `nombres` varchar(50) NOT NULL,
  `apellidopat` varchar(50) DEFAULT NULL,
  `apellidomat` varchar(50) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT 1 COMMENT '0-Desactivado 1-Activado 2-Activado y predeterminado',
  `correoproveedor` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedorlicencia`
--

CREATE TABLE `proveedorlicencia` (
  `idlicprov` int(11) NOT NULL,
  `idtipolicencia` int(11) NOT NULL,
  `idprov` int(11) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  `costocompra` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ps_procesos`
--

CREATE TABLE `ps_procesos` (
  `ps_id` int(11) NOT NULL,
  `ps_nombre` varchar(50) NOT NULL,
  `ps_descripcion` text NOT NULL,
  `ps_activo` int(11) NOT NULL DEFAULT 1 COMMENT '1 ACTIVO\r\n0 Eliminado',
  `ps_tipo` int(11) NOT NULL DEFAULT 1 COMMENT '1 Interno'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ps_procesos`
--

INSERT INTO `ps_procesos` (`ps_id`, `ps_nombre`, `ps_descripcion`, `ps_activo`, `ps_tipo`) VALUES
(1, 'PROCESO PRUEBA', '<h1><em>Head</em></h1>', 1, 1),
(2, 'TES2', '<p>TEST22</p>', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sr_correos`
--

CREATE TABLE `sr_correos` (
  `sr_id` int(11) NOT NULL,
  `sr_smtp_host` varchar(50) NOT NULL,
  `sr_smtp_port` varchar(50) NOT NULL,
  `sr_protocol` varchar(50) NOT NULL,
  `sr_activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sr_correos`
--

INSERT INTO `sr_correos` (`sr_id`, `sr_smtp_host`, `sr_smtp_port`, `sr_protocol`, `sr_activo`) VALUES
(1, 'mail.blazar.com.mx', '587', 'smtp', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipolicencia`
--

CREATE TABLE `tipolicencia` (
  `idlicencia` int(11) NOT NULL,
  `nombrelicencia` varchar(50) NOT NULL,
  `activo` int(11) NOT NULL DEFAULT 1,
  `comparativoPanel` varchar(50) DEFAULT NULL COMMENT 'este campo debe tener el mismo nombre que el panel para que busque la coincidencia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipolicencia`
--

INSERT INTO `tipolicencia` (`idlicencia`, `nombrelicencia`, `activo`, `comparativoPanel`) VALUES
(1, 'Windows Server 2012 R2', 1, 'Windows Server 2012 R2'),
(2, 'Windows Server 2016', 1, 'Windows Server 2016'),
(3, 'Windows Server 2019', 1, 'Windows Server 2019');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usr_personas`
--

CREATE TABLE `usr_personas` (
  `usr_id_personas` int(11) NOT NULL,
  `usr_apellido_pat` varchar(50) NOT NULL,
  `usr_apellido_mat` varchar(50) NOT NULL,
  `usr_nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usr_personas`
--

INSERT INTO `usr_personas` (`usr_id_personas`, `usr_apellido_pat`, `usr_apellido_mat`, `usr_nombre`) VALUES
(1, 'Cauich', 'Alvarez', 'Carlos');

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
-- Indices de la tabla `dr_correos`
--
ALTER TABLE `dr_correos`
  ADD PRIMARY KEY (`dr_id`),
  ADD KEY `fk_sr_id` (`dr_sr_id`);

--
-- Indices de la tabla `fac_archivos`
--
ALTER TABLE `fac_archivos`
  ADD PRIMARY KEY (`fac_arc_id`);

--
-- Indices de la tabla `fac_referencias`
--
ALTER TABLE `fac_referencias`
  ADD PRIMARY KEY (`fac_id`);

--
-- Indices de la tabla `lg_perfiles`
--
ALTER TABLE `lg_perfiles`
  ADD PRIMARY KEY (`lg_perfil_id`);

--
-- Indices de la tabla `lg_usuarios`
--
ALTER TABLE `lg_usuarios`
  ADD PRIMARY KEY (`lg_usuarios_id`),
  ADD KEY `fk_lg_ususarios_lg_perfiles` (`lg_usuarios_lg_perfiles_id`);

--
-- Indices de la tabla `licenciaswindows`
--
ALTER TABLE `licenciaswindows`
  ADD PRIMARY KEY (`idlicenciawin`),
  ADD KEY `fk_idlicencias` (`idtipolicencia`),
  ADD KEY `fk_provedor` (`idprovedorlic`);

--
-- Indices de la tabla `provedoreslicencia`
--
ALTER TABLE `provedoreslicencia`
  ADD PRIMARY KEY (`idprovedor`);

--
-- Indices de la tabla `proveedorlicencia`
--
ALTER TABLE `proveedorlicencia`
  ADD PRIMARY KEY (`idlicprov`),
  ADD KEY `fktipolicencia` (`idtipolicencia`),
  ADD KEY `fk_provedors` (`idprov`);

--
-- Indices de la tabla `ps_procesos`
--
ALTER TABLE `ps_procesos`
  ADD PRIMARY KEY (`ps_id`);

--
-- Indices de la tabla `sr_correos`
--
ALTER TABLE `sr_correos`
  ADD PRIMARY KEY (`sr_id`);

--
-- Indices de la tabla `tipolicencia`
--
ALTER TABLE `tipolicencia`
  ADD PRIMARY KEY (`idlicencia`);

--
-- Indices de la tabla `usr_personas`
--
ALTER TABLE `usr_personas`
  ADD PRIMARY KEY (`usr_id_personas`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cm_vendedores`
--
ALTER TABLE `cm_vendedores`
  MODIFY `ven_idvendedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `dr_correos`
--
ALTER TABLE `dr_correos`
  MODIFY `dr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `fac_archivos`
--
ALTER TABLE `fac_archivos`
  MODIFY `fac_arc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `fac_referencias`
--
ALTER TABLE `fac_referencias`
  MODIFY `fac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `lg_perfiles`
--
ALTER TABLE `lg_perfiles`
  MODIFY `lg_perfil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `lg_usuarios`
--
ALTER TABLE `lg_usuarios`
  MODIFY `lg_usuarios_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `licenciaswindows`
--
ALTER TABLE `licenciaswindows`
  MODIFY `idlicenciawin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `provedoreslicencia`
--
ALTER TABLE `provedoreslicencia`
  MODIFY `idprovedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `proveedorlicencia`
--
ALTER TABLE `proveedorlicencia`
  MODIFY `idlicprov` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `ps_procesos`
--
ALTER TABLE `ps_procesos`
  MODIFY `ps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `sr_correos`
--
ALTER TABLE `sr_correos`
  MODIFY `sr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tipolicencia`
--
ALTER TABLE `tipolicencia`
  MODIFY `idlicencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usr_personas`
--
ALTER TABLE `usr_personas`
  MODIFY `usr_id_personas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cm_vendedores_clientes`
--
ALTER TABLE `cm_vendedores_clientes`
  ADD CONSTRAINT `fk_vendedor_cliente` FOREIGN KEY (`ven_cl_idvendedor`) REFERENCES `cm_vendedores` (`ven_idvendedor`);

--
-- Filtros para la tabla `dr_correos`
--
ALTER TABLE `dr_correos`
  ADD CONSTRAINT `fk_sr_id` FOREIGN KEY (`dr_sr_id`) REFERENCES `sr_correos` (`sr_id`);

--
-- Filtros para la tabla `lg_usuarios`
--
ALTER TABLE `lg_usuarios`
  ADD CONSTRAINT `fk_lg_ususarios_lg_perfiles` FOREIGN KEY (`lg_usuarios_lg_perfiles_id`) REFERENCES `lg_perfiles` (`lg_perfil_id`);

--
-- Filtros para la tabla `licenciaswindows`
--
ALTER TABLE `licenciaswindows`
  ADD CONSTRAINT `fk_idlicencias` FOREIGN KEY (`idtipolicencia`) REFERENCES `tipolicencia` (`idlicencia`),
  ADD CONSTRAINT `fk_provedor` FOREIGN KEY (`idprovedorlic`) REFERENCES `provedoreslicencia` (`idprovedor`);

--
-- Filtros para la tabla `proveedorlicencia`
--
ALTER TABLE `proveedorlicencia`
  ADD CONSTRAINT `fk_provedors` FOREIGN KEY (`idprov`) REFERENCES `provedoreslicencia` (`idprovedor`),
  ADD CONSTRAINT `fktipolicencia` FOREIGN KEY (`idtipolicencia`) REFERENCES `tipolicencia` (`idlicencia`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
