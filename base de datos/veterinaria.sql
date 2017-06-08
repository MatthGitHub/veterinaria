-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 08-06-2017 a las 12:02:49
-- Versión del servidor: 5.5.54-0+deb8u1
-- Versión de PHP: 5.6.30-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `veterinaria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditorias`
--

CREATE TABLE IF NOT EXISTS `auditorias` (
`id_auditoria` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  `query` varchar(500) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chipeados`
--

CREATE TABLE IF NOT EXISTS `chipeados` (
`id_chipeado` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  `plan` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `nro_recibo` int(20) NOT NULL,
  `fk_id_ejemplar` int(11) NOT NULL,
  `fk_id_persona` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `chipeados`
--

INSERT INTO `chipeados` (`id_chipeado`, `fecha_alta`, `plan`, `nro_recibo`, `fk_id_ejemplar`, `fk_id_persona`) VALUES
(75, '2017-05-11', 'Barrial', 1234, 76, 17),
(76, '2017-05-02', 'Municipal', 2147483647, 77, 17),
(77, '2017-05-10', 'Municipal', 1234, 78, 17),
(78, '2017-05-16', 'Municipal', 123456789, 79, 17),
(79, '2017-05-02', 'Barrial', 2147483647, 80, 17),
(80, '2017-05-16', 'Municipal', 2147483647, 81, 16),
(81, '2017-05-16', 'Municipal', 2147483647, 82, 16),
(82, '2017-05-04', 'Municipal', 1313131313, 83, 16),
(83, '2017-05-02', 'Municipal', 1346497944, 84, 17),
(84, '2017-05-24', 'Barrial', 789654, 85, 16),
(85, '2017-06-01', 'Barrial', 2147483647, 86, 17),
(91, '2017-06-05', 'Campa&ntilde;a 2017', 33368977, 92, 17),
(92, '2017-06-05', 'Campa&ntilde;a 2017', 310888, 93, 17);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejemplares`
--

CREATE TABLE IF NOT EXISTS `ejemplares` (
`id_ejemplar` int(11) NOT NULL,
  `numero_chip` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `anio_nacimiento` int(11) NOT NULL,
  `sexo` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `caracter` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `capturas` int(11) NOT NULL,
  `tamanio` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `alzada` int(11) DEFAULT NULL,
  `libreta` tinyint(1) DEFAULT NULL,
  `condicion` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `esterilizado` tinyint(1) NOT NULL,
  `castrado` tinyint(1) NOT NULL,
  `fecha_castrado` date DEFAULT NULL,
  `observaciones` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `foto_url` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `fk_id_especie` int(11) NOT NULL,
  `fk_id_raza` int(11) NOT NULL,
  `fk_id_pelaje` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ejemplares`
--

INSERT INTO `ejemplares` (`id_ejemplar`, `numero_chip`, `nombre`, `anio_nacimiento`, `sexo`, `caracter`, `capturas`, `tamanio`, `alzada`, `libreta`, `condicion`, `esterilizado`, `castrado`, `fecha_castrado`, `observaciones`, `foto_url`, `fk_id_especie`, `fk_id_raza`, `fk_id_pelaje`) VALUES
(76, '900119000506151', 'Gustavo', 2012, 'Hembra', 'Peligroso', 4, 'Mediano', 0, 0, 'En Tr&aacute;nsito', 1, 1, '2017-05-03', 'prueba', '', 1, 99, 4),
(77, '900119000506151900119000506151', 'gustavo', 2006, 'Hembra', 'Peligroso', 2, 'Grande', 0, 0, 'Propio', 1, 1, '2017-05-06', '', '', 2, 107, 18),
(78, '900119000506149', 'Gustavo', 2012, 'Hembra', 'Peligroso', 2, 'Mediano', 0, 0, 'Adoptado Asoc', 1, 1, '2017-04-28', 'prueba', '', 1, 97, 27),
(79, '9898988787878787', 'Pepe', 2017, 'Macho', 'Sociable', 0, '', 0, 0, 'Adoptado Perrera', 0, 1, '2017-05-16', 'prueba 1.2', '', 2, 103, 7),
(80, '999999999999', 'Meme', 2016, 'Macho', 'Sociable', 0, 'Extra Grande', 0, 0, 'Adoptado Perrera', 1, 0, '0000-00-00', '', '', 1, 81, 4),
(81, '99999666666666', 'Lino', 2013, 'Macho', 'Seleccione un car&aacute;cter', 0, 'Grande', 0, 0, 'Adoptado Perrera', 0, 0, '0000-00-00', '', '', 1, 82, 8),
(82, '9999966688855555', 'Lali', 2013, 'Macho', 'Seleccione un car&aacute;cter', 0, 'Grande', 0, 0, 'Adoptado Perrera', 0, 0, '0000-00-00', '', '', 1, 82, 8),
(83, '987855858542112', 'Luli', 2011, 'Macho', 'Peligroso', 0, 'Grande', 0, 0, 'Adoptado Asoc', 1, 0, '0000-00-00', '', '', 2, 107, 8),
(84, '98765412336548', 'Merlin', 2016, 'Hembra', 'Sociable', 0, 'Extra Grande', 0, 0, 'Adoptado Asoc', 1, 1, '2017-05-04', 'ladra', '', 1, 99, 18),
(85, '9875222336542641515', 'Lelolito', 2014, 'Macho', 'Sociable', 2, 'Grande', 0, 0, 'Adoptado Asoc', 0, 1, '2017-05-09', 'hola', '', 2, 102, 8),
(86, '9897510587452121', 'Mimiti', 2013, 'Macho', 'Sociable', 0, 'Extra Grande', 0, 0, 'Adoptado Perrera', 0, 0, '0000-00-00', '', '', 2, 138, 8),
(92, '31115444', 'Moro', 2009, 'Hembra', 'Sociable', 0, '', 0, NULL, 'Propio', 0, 1, '2017-06-05', '', '', 2, 46, 9),
(93, '8979879877', 'Moro', 2009, 'Macho', 'Sociable', 0, '', 2, NULL, 'Propio', 0, 1, '2017-06-05', '', '', 2, 101, 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejemplares_fotos`
--

CREATE TABLE IF NOT EXISTS `ejemplares_fotos` (
`id` int(11) NOT NULL,
  `id_ejemplar` int(11) NOT NULL,
  `archivo` varchar(50) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ejemplares_fotos`
--

INSERT INTO `ejemplares_fotos` (`id`, `id_ejemplar`, `archivo`) VALUES
(121, 92, 'Nenúfares.jpg'),
(122, 92, 'earth-day.jpg'),
(124, 92, 'url2.jpeg'),
(130, 79, 'url.jpeg'),
(131, 79, 'earth-day.jpg'),
(133, 79, 'url2.jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejemplares_personas`
--

CREATE TABLE IF NOT EXISTS `ejemplares_personas` (
  `fk_id_ejemplar` int(11) NOT NULL,
  `fk_id_persona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `ejemplares_personas`
--

INSERT INTO `ejemplares_personas` (`fk_id_ejemplar`, `fk_id_persona`) VALUES
(0, 16),
(76, 16),
(77, 16),
(78, 17),
(79, 16),
(80, 0),
(81, 17),
(82, 0),
(83, 17),
(84, 17),
(85, 17),
(86, 16),
(91, 16),
(92, 16),
(93, 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especies`
--

CREATE TABLE IF NOT EXISTS `especies` (
`id_especie` int(11) NOT NULL,
  `especie` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `especies`
--

INSERT INTO `especies` (`id_especie`, `especie`) VALUES
(1, 'Canina'),
(2, 'Equina'),
(3, 'Felina');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelajes`
--

CREATE TABLE IF NOT EXISTS `pelajes` (
`id_pelaje` int(11) NOT NULL,
  `pelaje` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `pelajes`
--

INSERT INTO `pelajes` (`id_pelaje`, `pelaje`) VALUES
(1, 'Negro'),
(2, 'Negro / Blanco'),
(3, 'Blanco'),
(4, 'Pardo'),
(5, 'Dorado'),
(6, 'Mestizo'),
(7, 'Marron'),
(8, 'Marron claro'),
(9, 'Beige'),
(10, 'Tricolor'),
(11, 'Gris'),
(12, 'Marron Atigrado'),
(13, 'Negro Atigrado'),
(14, 'Gris Atigrado'),
(15, 'Marron Claro'),
(16, 'Marron Oscuro'),
(17, 'Chocolate'),
(18, 'Negro y Marron'),
(19, 'Negro y Beige'),
(20, 'Azul'),
(21, 'Champagne'),
(22, 'Gris Jaspeado'),
(23, 'Negro Jaspeado'),
(24, 'Marron Jaspeado'),
(25, 'Negro Fuego'),
(26, 'Negro y Amarillo'),
(27, 'Negro y Gris'),
(28, 'Marron y Blanco'),
(29, 'Colorado'),
(30, 'Gris con Blanco'),
(31, 'Atigrado'),
(32, 'Blanco y Negro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
`id_permiso` int(11) NOT NULL,
  `descripcion` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `fk_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE IF NOT EXISTS `personas` (
`id_persona` int(11) NOT NULL,
  `documento` int(20) NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `apellido` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `telefono` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `calle` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `numero` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `piso` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `departamento` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `barrio` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`id_persona`, `documento`, `nombre`, `apellido`, `telefono`, `calle`, `numero`, `piso`, `departamento`, `barrio`, `email`) VALUES
(17, 9876543, 'Maria', 'García', '2944578695', 'Moreno', '123', '2', '58', 'Belgrano', 'mariagarcia@gmail.com'),
(16, 12345678, 'Mariano', 'Perez', '2944586362', 'Mitre', '531', '', '', 'Centro', 'marianoperez@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razas`
--

CREATE TABLE IF NOT EXISTS `razas` (
`id_raza` int(11) NOT NULL,
  `raza` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `fk_id_especie` smallint(6) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=156 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `razas`
--

INSERT INTO `razas` (`id_raza`, `raza`, `descripcion`, `fk_id_especie`) VALUES
(1, 'Alaskan Malamute', 'Ninguna', 1),
(2, 'Barzoi', 'Ninguna', 1),
(3, 'Basset Azul de Gascuña', 'Ninguna', 1),
(4, 'Basset Hound', 'Ninguna', 1),
(5, 'Beagle', 'Ninguna', 1),
(6, 'Beagle Harrier', 'Ninguna', 1),
(7, 'Beauceron', 'Ninguna', 1),
(8, 'Bichón Maltés', 'Ninguna', 1),
(9, 'Bobtail', 'Ninguna', 1),
(10, 'Border Collie', 'Ninguna', 1),
(11, 'Boxer', 'Ninguna', 1),
(12, 'Boyero de Berna', 'Ninguna', 1),
(13, 'Braco Alemán', 'Ninguna', 1),
(14, 'Braco Francés', 'Ninguna', 1),
(15, 'Briard', 'Ninguna', 1),
(16, 'Bull Terrier Inglés', 'Ninguna', 1),
(17, 'Bulldog Francés', 'Ninguna', 1),
(18, 'Bulldog Inglés', 'Ninguna', 1),
(19, 'Bullmastiff', 'Ninguna', 1),
(20, 'Cairn Terrier', 'Ninguna', 1),
(21, 'Cane Corso', 'Ninguna', 1),
(22, 'Caniche', 'Ninguna', 1),
(23, 'Cavalier King Charles', 'Ninguna', 1),
(24, 'Chihuahua', 'Ninguna', 1),
(25, 'Chow Chow', 'Ninguna', 1),
(27, 'Cocker Spaniel Inglés', 'Ninguna', 1),
(28, 'Collie Rough', 'Ninguna', 1),
(29, 'Collie Smooth', 'Ninguna', 1),
(30, 'Dálmata', 'Ninguna', 1),
(31, 'Doberman', 'Ninguna', 1),
(32, 'Dogo Argentino', 'Ninguna', 1),
(33, 'Dogo de Burdeos', 'Ninguna', 1),
(34, 'Epagneul Bretón', 'Ninguna', 1),
(35, 'Epagneul Francés', 'Ninguna', 1),
(36, 'Epagneul Japonés', 'Ninguna', 1),
(37, 'Fox Terrier', 'Ninguna', 1),
(38, 'Galgo Español', 'Ninguna', 1),
(39, 'Galgo Irlandés', 'Ninguna', 1),
(40, 'Golden Retriever', 'Ninguna', 1),
(41, 'Gordon Setter', 'Ninguna', 1),
(42, 'Gos d''Atura', 'Ninguna', 1),
(43, 'Gran Danés', 'Ninguna', 1),
(44, 'Husky Siberiano', 'Ninguna', 1),
(45, 'Komondor', 'Ninguna', 1),
(46, 'Labrador Retriever', 'Ninguna', 1),
(47, 'Lebrel Afgano', 'Ninguna', 1),
(48, 'Lebrel Polaco', 'Ninguna', 1),
(49, 'Mastiff', 'Ninguna', 1),
(50, 'Mastín de los Pirineos', 'Ninguna', 1),
(51, 'Mastín Español', 'Ninguna', 1),
(52, 'Mastín Napolitano', 'Ninguna', 1),
(53, 'Montaña de los Pirineos', 'Ninguna', 1),
(54, 'Norfolk Terrier', 'Ninguna', 1),
(55, 'Norwich Terrier', 'Ninguna', 1),
(56, 'Papillon', 'Ninguna', 1),
(57, 'Pastor Alemán', 'Ninguna', 1),
(58, 'Pastor Australiano', 'Ninguna', 1),
(59, 'Pastor Belga', 'Ninguna', 1),
(60, 'Pastor Blanco Suizo', 'Ninguna', 1),
(61, 'Pastor de los Pirineos', 'Ninguna', 1),
(62, 'Pekinés', 'Ninguna', 1),
(65, 'Pequeño Brabantino', 'Ninguna', 1),
(66, 'Pequeño Perro León', 'Ninguna', 1),
(67, 'Pequeño Perro Ruso', 'Ninguna', 1),
(69, 'Perdiguero de Burgos', 'Ninguna', 1),
(70, 'Perdiguero Portugués', 'Ninguna', 1),
(71, 'Perro de Agua Español', 'Ninguna', 1),
(73, 'Pinscher miniatura', 'Ninguna', 1),
(74, 'Pit Bull', 'Ninguna', 1),
(75, 'Podenco Canario', 'Ninguna', 1),
(76, 'Podenco Ibicenco', 'Ninguna', 1),
(77, 'Pointer Inglés', 'Ninguna', 1),
(78, 'Presa Canario', 'Ninguna', 1),
(79, 'Pug', 'Ninguna', 1),
(80, 'Rafeiro do Alentejo', 'Ninguna', 1),
(81, 'Rottweiler', 'Ninguna', 1),
(82, 'Samoyedo', 'Ninguna', 1),
(83, 'San Bernardo', 'Ninguna', 1),
(84, 'Schnauzer gigante', 'Ninguna', 1),
(85, 'Schnauzer mediano', 'Ninguna', 1),
(86, 'Schnauzer miniatura', 'Ninguna', 1),
(87, 'Scottish Terrier', 'Ninguna', 1),
(88, 'Setter Inglés', 'Ninguna', 1),
(89, 'Setter Irlandés', 'Ninguna', 1),
(90, 'Shar Pei', 'Ninguna', 1),
(91, 'Shih Tzu', 'Ninguna', 1),
(92, 'Spitz', 'Ninguna', 1),
(95, 'Teckel', 'Ninguna', 1),
(96, 'Terranova', 'Ninguna', 1),
(97, 'Weimaraner', 'Ninguna', 1),
(98, 'Westies', 'Ninguna', 1),
(99, 'Whippet', 'Ninguna', 1),
(100, 'Yorkshire Terrier', 'Ninguna', 1),
(101, 'Arabe', 'Ninguna', 2),
(102, 'Pura Sangre de Carrera ', 'Ninguna', 2),
(103, 'Criollo ', 'Ninguna', 2),
(104, 'Polo', 'Ninguna', 2),
(107, 'Percheron', 'Ninguna', 2),
(110, 'Abisinio', NULL, 3),
(109, 'Mestizo', 'Ninguna', 1),
(111, 'American Curl', NULL, 3),
(112, 'American Shorthair', NULL, 3),
(113, 'Angora Turco', NULL, 3),
(114, 'Azul Ruso', NULL, 3),
(115, 'Balines', NULL, 3),
(116, 'Bengalí', NULL, 3),
(117, 'Bobtail Americano', NULL, 3),
(118, 'Bobtail Japones', NULL, 3),
(119, 'Bombay', NULL, 3),
(120, 'Bosque de Noruega', NULL, 3),
(121, 'British Shorthair', NULL, 3),
(122, 'Burmes', NULL, 3),
(123, 'Burmilla', NULL, 3),
(124, 'Chantilly', NULL, 3),
(125, 'Chartreux', NULL, 3),
(126, 'Chausie', NULL, 3),
(127, 'Común Europeo', NULL, 3),
(128, 'Cornish Rex', NULL, 3),
(129, 'Devon Rex', NULL, 3),
(130, 'Exotic Shorthair', NULL, 3),
(131, 'German Rex', NULL, 3),
(132, 'Korat', NULL, 3),
(133, 'Maine Coon', NULL, 3),
(134, 'Manx', NULL, 3),
(135, 'Mau Egipcio', NULL, 3),
(136, 'Munchkin', NULL, 3),
(137, 'Ocicat', NULL, 3),
(138, 'Persa', NULL, 3),
(139, 'Peterbald', NULL, 3),
(140, 'Ragamuffin', NULL, 3),
(141, 'Ragdoll', NULL, 3),
(142, 'Sagrado de Birmania', NULL, 3),
(143, 'Savannah', NULL, 3),
(144, 'Scottish Fold', NULL, 3),
(145, 'Selkirk Rex', NULL, 3),
(146, 'Serengeti', NULL, 3),
(147, 'Siamés Moderno', NULL, 3),
(148, 'Siames Tradicional', NULL, 3),
(149, 'Siberiano', NULL, 3),
(150, 'Snowshoe', NULL, 3),
(151, 'Somalí', NULL, 3),
(152, 'Sphynx', NULL, 3),
(153, 'Tonkines', NULL, 3),
(154, 'Toyger', NULL, 3),
(155, 'Van Turco', NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`id_rol` int(11) NOT NULL,
  `descripcion` varchar(25) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf32 COLLATE=utf32_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Municipalidad'),
(3, 'Veterinaria'),
(4, 'Consulta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

CREATE TABLE IF NOT EXISTS `roles_permisos` (
  `fk_rol` int(11) NOT NULL,
  `fk_permiso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id_usuario` int(11) NOT NULL,
  `nombre` varchar(25) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `usuario` varchar(25) COLLATE utf8_spanish2_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `fk_rol` int(11) NOT NULL,
  `area` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `subarea` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `CUIT_DNI` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `usuario`, `pass`, `fk_rol`, `area`, `subarea`, `CUIT_DNI`) VALUES
(1, 'gustavo castro', 'gcastro', 'd41d8cd98f00b204e9800998ecf8427e', 1, 'Sistemas', 'Sistemas', NULL),
(2, 'Juan Carlos', 'jramos', 'f6a0aaf00564291cb16ff60d5db73ee2', 1, 'Sistemas', 'Sistemas', NULL),
(7, 'Matias Benditti', 'mbenditti', '090c36e3bb39377468363197afb3e91b', 1, NULL, NULL, NULL),
(8, 'Alicia Varano', 'avarano', 'e94ef563867e9c9df3fcc999bdb045f5', 1, NULL, NULL, NULL),
(9, 'Maria de la Nieves', 'mdnieves', '263bce650e68ab4e23f28263760b9fa5', 2, NULL, NULL, NULL),
(10, 'Marcos Pavone', 'mpavone', 'c5e3539121c4944f2bbe097b425ee774', 3, NULL, NULL, NULL),
(11, 'Ramon Diaz', 'rdiaz', '73d26b52f7a796c0fd8bdac6040263c3', 4, NULL, NULL, NULL),
(14, 'Estefania Klein', 'eklein', 'cb1c89273baea81a798717c7c832f5ca', 1, NULL, NULL, NULL),
(15, 'gustavo', 'veterinaria1', 'e10adc3949ba59abbe56e057f20f883e', 3, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacunas`
--

CREATE TABLE IF NOT EXISTS `vacunas` (
`id_vacuna` int(11) NOT NULL,
  `nombre_vacuna` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `vacunas`
--

INSERT INTO `vacunas` (`id_vacuna`, `nombre_vacuna`) VALUES
(1, 'Sextuple'),
(2, 'Quintuple'),
(3, 'Rabia'),
(4, 'Hidatidosis'),
(5, 'Gusanos Redondos'),
(6, 'Anemia Infecciosa'),
(7, 'Influenza Equina'),
(8, 'Adenitis Equina'),
(9, 'Encefalomielitis'),
(10, 'Triple'),
(11, 'Leucemia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacunas_ejemplares`
--

CREATE TABLE IF NOT EXISTS `vacunas_ejemplares` (
  `fk_vacuna` int(11) NOT NULL,
  `fk_ejemplar` int(11) NOT NULL,
  `fecha_aplicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `vacunas_ejemplares`
--

INSERT INTO `vacunas_ejemplares` (`fk_vacuna`, `fk_ejemplar`, `fecha_aplicacion`) VALUES
(1, 78, '2017-05-05'),
(2, 84, '2017-05-05'),
(2, 85, '2017-05-17');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditorias`
--
ALTER TABLE `auditorias`
 ADD PRIMARY KEY (`id_auditoria`);

--
-- Indices de la tabla `chipeados`
--
ALTER TABLE `chipeados`
 ADD PRIMARY KEY (`id_chipeado`), ADD KEY `fk_id_ejemplar` (`fk_id_ejemplar`), ADD KEY `fk_id_persona` (`fk_id_persona`);

--
-- Indices de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
 ADD PRIMARY KEY (`id_ejemplar`), ADD KEY `fk_id_especie` (`fk_id_especie`), ADD KEY `fk_id_raza` (`fk_id_raza`), ADD KEY `fk_id_pelaje` (`fk_id_pelaje`);

--
-- Indices de la tabla `ejemplares_fotos`
--
ALTER TABLE `ejemplares_fotos`
 ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ejemplares_personas`
--
ALTER TABLE `ejemplares_personas`
 ADD PRIMARY KEY (`fk_id_ejemplar`,`fk_id_persona`), ADD KEY `fk_id_ejemplar` (`fk_id_ejemplar`), ADD KEY `fk_id_persona` (`fk_id_persona`);

--
-- Indices de la tabla `especies`
--
ALTER TABLE `especies`
 ADD PRIMARY KEY (`id_especie`);

--
-- Indices de la tabla `pelajes`
--
ALTER TABLE `pelajes`
 ADD PRIMARY KEY (`id_pelaje`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
 ADD PRIMARY KEY (`id_permiso`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
 ADD PRIMARY KEY (`id_persona`);

--
-- Indices de la tabla `razas`
--
ALTER TABLE `razas`
 ADD PRIMARY KEY (`id_raza`), ADD KEY `fk_id_especie` (`fk_id_especie`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
 ADD PRIMARY KEY (`fk_rol`,`fk_permiso`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id_usuario`), ADD KEY `fk_rol` (`fk_rol`);

--
-- Indices de la tabla `vacunas`
--
ALTER TABLE `vacunas`
 ADD PRIMARY KEY (`id_vacuna`);

--
-- Indices de la tabla `vacunas_ejemplares`
--
ALTER TABLE `vacunas_ejemplares`
 ADD PRIMARY KEY (`fk_vacuna`,`fk_ejemplar`), ADD KEY `fk_vacuna` (`fk_vacuna`), ADD KEY `fk_ejemplar` (`fk_ejemplar`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditorias`
--
ALTER TABLE `auditorias`
MODIFY `id_auditoria` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `chipeados`
--
ALTER TABLE `chipeados`
MODIFY `id_chipeado` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=93;
--
-- AUTO_INCREMENT de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
MODIFY `id_ejemplar` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT de la tabla `ejemplares_fotos`
--
ALTER TABLE `ejemplares_fotos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT de la tabla `especies`
--
ALTER TABLE `especies`
MODIFY `id_especie` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `pelajes`
--
ALTER TABLE `pelajes`
MODIFY `id_pelaje` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
MODIFY `id_permiso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT de la tabla `razas`
--
ALTER TABLE `razas`
MODIFY `id_raza` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=156;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT de la tabla `vacunas`
--
ALTER TABLE `vacunas`
MODIFY `id_vacuna` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
