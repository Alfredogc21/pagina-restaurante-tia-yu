-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-09-2024 a las 23:12:56
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
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `idMesa` int(11) NOT NULL,
  `Num_sillas` int(11) DEFAULT NULL,
  `Disponibilidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `idReserva` int(11) NOT NULL,
  `Hora` time DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Comentario` varchar(100) DEFAULT NULL,
  `Num_Personas` int(11) DEFAULT NULL,
  `IdCliente` int(11) DEFAULT NULL,
  `IdMesa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_roles` int(11) NOT NULL,
  `roles` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_roles`, `roles`) VALUES
(1, 'Administador'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `IdCliente` int(11) NOT NULL,
  `Cedula` varchar(20) DEFAULT NULL,
  `P_Nombre` char(60) NOT NULL,
  `S_Nombre` char(60) DEFAULT NULL,
  `P_Apellidos` char(60) NOT NULL,
  `S_Apellido` char(60) DEFAULT NULL,
  `id_roles` int(11) DEFAULT NULL,
  `Telefono` varchar(45) NOT NULL,
  `Correo_Electronico` varchar(45) NOT NULL,
  `Contrasena` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdCliente`, `Cedula`, `P_Nombre`, `S_Nombre`, `P_Apellidos`, `S_Apellido`, `id_roles`, `Telefono`, `Correo_Electronico`, `Contrasena`) VALUES
(1, '5323423423', 'stan', NULL, 'chouman', NULL, 2, '35235235', 'Sstasfaf@gmail.com', 'Aa123-Aa456'),
(2, '53234223', 'Culma', NULL, 'Gomez', NULL, 1, '3423532325', 'alfred@gmail.com', 'Aa123-A456'),
(3, '543235235', 'Carlos', NULL, 'Ortiz', NULL, 2, '3532325', 'machete55@gmail.com', 'Aa123-A456'),
(4, '35325235', 'steeve', NULL, 'donoso', NULL, 2, '', 'stevendv@gmail.com', '$2y$10$qZoQGHpFre1PYyKxcDyNP.XMn7YrPRk.d/bqZut7JPHS6cqMSBbbK'),
(5, '542323423', 'mendes', NULL, 'rodfig', NULL, 2, '', 'sentese@gmail.com', '$2y$10$JW4hpmAZRnVvphakfV6.ne8y.95ic7jCyr8hy5VVnrmw7wvXpv0RW'),
(6, '654234234', 'orte', NULL, 'mento', NULL, 2, '654323234', 'sancocho@gmail.com', '$2y$10$PnJwVf6cYDKQGewnWa4.1eFw4ygwmtSqvw0OP1Eh0Tnvga/KrwUdq'),
(7, '9865776523', 'mota', NULL, 'tota', NULL, 2, '873232525', 'frutaitfip@gmai.com', '$2y$10$ozHgbX4A4k2YxL3EJ26EUOSHrYy1wV3SZ8/RftLe76HtsO.opbWhu'),
(8, '4623425', 'putechito', NULL, 'mamento', NULL, 2, '8765432352', 'chucnaleo@gmail.com', '$2y$10$nL0mtHEBL59b2Rb7iZdws.dWZYzDf9Ougyo7YwHIkgAAFA9oROGAq'),
(9, '7654321245', 'campis', NULL, 'chammos', NULL, 2, '89756432', 'mariguan3000@gmail.com', '$2y$10$9gJBqv0H.3ZoLV8fwBjc5esn/ccInIDgTlbzycJxbCW4pnxgA3Tye'),
(10, '897867432', 'putecita', NULL, 'chamila', NULL, 2, '9435346345', 'juyhnasre@gmail.com', '$2y$10$bE2vk4s6vACRT/QweBFepeO7m3XBF.amScF8w.EGgzWnpqdrE77F6'),
(11, '09834235', 'yuseit', NULL, 'puchilana', NULL, 2, '684434634', 'yuasfer@gmail.com', '$2y$10$oH0VJiMgw45j07XHM7iAserIGdRvDvIzyCjOqsAwi1n64.bjnAESe'),
(12, '5463523432', 'mendes', NULL, 'rodfig', NULL, 2, '98765432', 'sesonte@gmail.com', '$2y$10$WQYywTG/CqhTNtN/B618PuNcx2R4dfGoHWz4DA3erO05H3BTj5bTa'),
(13, '7867564325', 'steeve', NULL, 'chammos', NULL, 2, '436757485', 'kushbaksh@gmail.com', '$2y$10$ZiMBcuTtOm/GZyQ23bbzsOBk3A3BwzjEHlpNeqi3No.43R62d50oi'),
(14, '098656453425', 'orte', NULL, 'donoso', NULL, 2, '685634436346', 'Punchetas@gmail.com', '$2y$10$3e52XGZPlHOaaQGA29uZZOZdc6dEsIF61BiZ3JdHpIwdOG9qVmfXm'),
(15, '98765432', 'putecita', NULL, 'mento', NULL, 2, '0897867564342', 'sentivmettoooo@gmail.com', '$2y$10$dKyURzcgAuumtAPRKolstOP065rMGtbtid/3pooER8BrO6AcUpHj2'),
(16, '0876756432', 'steeve', 'cyulo', 'mento', NULL, 2, '87986574324', 'wijihbuyb@gmail.com', '$2y$10$3qMZtdhDvloEhL9czILBzOP/oNJyZjGfwJg6bVmL2CrKAyxiSreou'),
(17, '786754323423', 'putechito', 'cyulo', 'mento', 'rene', 2, '65764532413', 'sntaesas@gmail.com', '$2y$10$GCqsjaMWYimR098AtRFN4eQm.a3/Ci1FX58TucUYzenMIOgPm8s9.'),
(18, '75645342312', 'steeve', NULL, 'mento', NULL, 2, '8675645342', 'steevendv@gmail.com', '$2y$10$wEVLApn1U1SV6lC.GFFZc.IPOhWLJT6WFpjqdWf1JOMQf.2QXxeyy'),
(19, '24124124', 'putechito', 'cyulo', 'mamento', 'rene', 2, '4635423', 'steevendv@gmail.com', '$2y$10$wQg45159VN1pB66uCeS0HuVL5N2X716VqxTgYalIc7MQyL/n8XddG'),
(20, '23123454657687', 'orte', 'cyulo', 'rodfig', 'rene', 2, '43423254665764', 'kushbaksh@gmail.com', '123456789'),
(21, '5643222345087965', 'mendes', 'cyulo', 'rodfig', 'rene', 2, '9763421342', 'kushbaksh@gmail.com', '$2y$10$VQYLJhVj0z28F0Rr7bPnaO8XUCYI0YAg4oPaggVW8c6s251HE5N5W'),
(22, '12435465887', 'putecita', 'cyulo', 'mamento', 'rene', 2, '76543223423', 'steevendv@gmail.com', '12345678');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `idValoracion` int(11) NOT NULL,
  `Comentario` longtext DEFAULT NULL,
  `Estrellas` int(11) DEFAULT NULL,
  `IdCliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`idReserva`),
  ADD KEY `IdCliente` (`IdCliente`),
  ADD KEY `IdMesa` (`IdMesa`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_roles`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`IdCliente`),
  ADD KEY `id_roles` (`id_roles`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`idValoracion`),
  ADD KEY `IdCliente` (`IdCliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_roles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `IdCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `idValoracion` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`IdCliente`) REFERENCES `usuarios` (`IdCliente`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`IdMesa`) REFERENCES `mesa` (`idMesa`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_roles`) REFERENCES `roles` (`id_roles`);

--
-- Filtros para la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD CONSTRAINT `valoracion_ibfk_1` FOREIGN KEY (`IdCliente`) REFERENCES `usuarios` (`IdCliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
