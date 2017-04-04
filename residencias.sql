-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 31-03-2017 a las 00:46:47
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `residencias`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actInfoAlu` (IN `noo` INT(8), IN `nom` VARCHAR(128), IN `act` SET('S','N'), IN `gru` INT(11), IN `nor` INT(8))  NO SQL
BEGIN 
UPDATE alumnos SET alumnos.noc = noo, alumnos.nombre = nom WHERE alumnos.noc = nor;
UPDATE gru_alum SET gru_alum.activo = act WHERE gru_alum.noc = noo AND gru_alum.id_grup = gru;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actPassAlu` (IN `coo` INT(8), IN `pas` VARCHAR(128), IN `gru` INT(11))  BEGIN
IF EXISTS (SELECT * FROM gru_alum WHERE gru_alum.noc = coo AND gru_alum.id_grup = gru) THEN
	UPDATE alumnos SET alumnos.pass = pas WHERE alumnos.noc = coo;
ELSE
SELECT FALSE;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actTareaCA` (IN `ide` INT(11), IN `fini` DATETIME, IN `flim` DATETIME, IN `tit` VARCHAR(128), IN `con` TEXT, IN `un` INT(2), IN `doc` VARCHAR(128))  NO SQL
UPDATE actividades AS act SET act.fec_ini = fini, act.fec_lim = flim, act.titulo = tit, act.instrucciones = con, act.unidad = un, act.docs = doc WHERE act.id = ide$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `actTareaSA` (IN `ide` INT(11), IN `fini` DATETIME, IN `flim` DATETIME, IN `tit` VARCHAR(128), IN `con` TEXT, IN `un` INT(2))  NO SQL
UPDATE actividades AS act SET act.fec_ini = fini, act.fec_lim = flim, act.titulo = tit, act.instrucciones = con, act.unidad = un WHERE act.id = ide$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cargarAlumnos` (IN `noo` INT(8), IN `nom` VARCHAR(128), IN `fot` VARCHAR(32), IN `pas` VARCHAR(128), IN `act` SET('S','N'), IN `gru` INT(11))  BEGIN
IF EXISTS (SELECT * FROM alumnos WHERE alumnos.noc = noo) THEN
	IF NOT EXISTS (SELECT * FROM gru_alum WHERE gru_alum.noc = noo AND gru_alum.id_grup = gru) THEN
    	INSERT INTO gru_alum VALUES(noo, gru, act);
    END IF;
ELSE
INSERT INTO alumnos VALUES(noo, nom, fot, pas);
INSERT INTO gru_alum VALUES(noo, gru, act);
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cargarArchivos` (IN `gru` INT(11), IN `uni` INT(2), IN `doc` TEXT)  BEGIN
IF NOT EXISTS (SELECT * FROM unidades WHERE unidades.id_grup = gru AND unidades.unidad = uni AND unidades.docs IS NOT NULL) THEN
	UPDATE unidades SET unidades.docs = doc WHERE unidades.id_grup = gru AND unidades.unidad = uni;
ELSE
	UPDATE unidades SET unidades.docs = CONCAT(doc,unidades.docs) WHERE unidades.id_grup = gru AND unidades.unidad = uni;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `catalogoGrupos` (IN `mate` INT(11))  NO SQL
SELECT gru.id, gru.grupo, DATE_FORMAT(gru.fecha, 'Registrado: %e %b %Y') AS fecha, gru.rfc, gru.activo, mat.materia, car.carrera, CONCAT(pro.nombre,' ',pro.apepat,' ', pro.apemat) AS nom FROM grupos AS gru INNER JOIN materias AS mat ON gru.materia = mat.id INNER JOIN carreras AS car ON mat.carrera = car.id INNER JOIN profesores AS pro ON gru.rfc = pro.rfc WHERE gru.materia = mate$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `catalogoPersonal` (IN `rf` VARCHAR(13), IN `car` VARCHAR(4))  NO SQL
SELECT *, carreras.carrera AS carre FROM  profesores AS pro INNER JOIN roles ON pro.rfc = roles.rfc INNER JOIN carreras ON roles.carrera = carreras.id WHERE pro.rfc = rf AND pro.carrera = car$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `consultarProfes` (IN `car` VARCHAR(4))  NO SQL
SELECT pro.rfc, CONCAT(pro.nombre,' ',pro.apepat,' ', pro.apemat) AS nom FROM roles INNER JOIN profesores as pro ON roles.rfc = pro.rfc WHERE roles.carrera = car AND roles.rol = 'P' AND pro.activo = 'S'$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminarDocs` (IN `gru` INT(11), IN `un` INT(2), IN `doc` TEXT)  NO SQL
UPDATE unidades SET unidades.docs = REPLACE(unidades.docs, doc, '')  WHERE unidades.id_grup = gru AND unidades.unidad = un$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guardarNvaCarrera` (IN `idd` VARCHAR(4), IN `carr` VARCHAR(64))  NO SQL
INSERT INTO carreras VALUES(idd, carr)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guardarNvaMateria` (IN `car` VARCHAR(4), IN `mat` VARCHAR(128))  NO SQL
INSERT INTO materias (materias.carrera, materias.materia) VALUES(car, mat)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guardarNvoGrupo` (IN `mat` INT(11), IN `gru` VARCHAR(64), IN `rf` VARCHAR(13))  NO SQL
INSERT INTO grupos (grupos.materia, grupos.grupo, grupos.fecha, grupos.rfc, grupos.activo) VALUES(mat, gru, CURRENT_TIMESTAMP, rf, 'S')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guardarNvoProfe` (IN `rf` VARCHAR(14), IN `nom` VARCHAR(64), IN `ape` VARCHAR(64), IN `apm` VARCHAR(64), IN `car` VARCHAR(4), IN `ema` VARCHAR(64), IN `pas` VARCHAR(64))  NO SQL
INSERT INTO profesores VALUES(rf, nom, ape, apm, ema, NULL, car, 'user.png', pas, NULL, 'S')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guardarTarea` (IN `idmat` INT(11), IN `feci` DATETIME, IN `fecl` DATETIME, IN `cont` TEXT, IN `uni` INT(2), IN `docs` VARCHAR(128), IN `tit` VARCHAR(128))  NO SQL
INSERT INTO actividades(id_grup, fec_ini, fec_lim, titulo, instrucciones, unidad, docs, activa, tipo) VALUES(idmat, feci, fecl, tit, cont, uni, docs, 'S','T')$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guardarTemario` (IN `idg` INT(11), IN `uni` INT(2), IN `tem` TEXT)  NO SQL
UPDATE unidades SET unidades.contenido = tem WHERE unidades.id_grup = idg AND unidades.unidad = uni$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginAlumno` (IN `noo` INT(8))  NO SQL
SELECT * FROM alumnos WHERE alumnos.noc = noo$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `loginPersonal` (IN `rf` VARCHAR(13), IN `ro` SET('A','C','P'))  NO SQL
SELECT pro.rfc, pro.pass, pro.nombre, roles.rol FROM profesores AS pro INNER JOIN roles ON pro.rfc = roles.rfc WHERE pro.rfc = rf AND roles.rol = ro$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `tareasPendientes` (IN `rf` VARCHAR(13))  NO SQL
SELECT act.id, act.fec_ini, act.fec_lim, act.instrucciones, act.activa, act.unidad, act.titulo, grupos.grupo FROM actividades AS act INNER JOIN grupos ON act.id_grup = grupos.id where act.fec_ini < now() AND act.fec_lim > now() AND grupos.rfc = rf$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id` int(11) NOT NULL,
  `id_grup` int(11) NOT NULL,
  `docs` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fec_ini` datetime NOT NULL,
  `fec_lim` datetime NOT NULL,
  `titulo` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `instrucciones` text COLLATE utf8_spanish_ci NOT NULL,
  `activa` set('S','N') COLLATE utf8_spanish_ci NOT NULL,
  `unidad` int(2) NOT NULL,
  `tipo` set('T','P') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`id`, `id_grup`, `docs`, `fec_ini`, `fec_lim`, `titulo`, `instrucciones`, `activa`, `unidad`, `tipo`) VALUES
(18, 7, '83_7_imagenes.php', '2017-03-23 10:48:00', '2017-03-26 10:48:00', 'Script de Imágenes PHP', 'Crear script para cargar mútiples imágenes en PHP, se adjunta archivo.', 'S', 1, 'T'),
(20, 7, NULL, '2017-03-19 12:19:00', '2017-03-26 12:19:00', 'POO', 'Tarea', 'S', 2, 'T'),
(21, 8, NULL, '2017-03-22 12:19:00', '2017-03-26 12:19:00', 'Clases abastractas', 'Contenido', 'S', 1, 'T'),
(24, 7, '2_7_applications.html', '2017-03-24 17:47:00', '2017-03-26 17:47:00', 'Clases e Interfaces 2', '\r\n	\r\n	Clases e interfaces	', 'S', 2, 'T'),
(25, 7, NULL, '2017-03-01 13:20:00', '2017-03-31 18:20:00', 'Algoritmos', '\r\n	Algoritmos<br><br>	', 'S', 1, 'T');

--
-- Disparadores `actividades`
--
DELIMITER $$
CREATE TRIGGER `eliminatare` BEFORE DELETE ON `actividades` FOR EACH ROW DELETE FROM tareas WHERE tareas.id_act = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `noc` int(8) NOT NULL,
  `nombre` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pass` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`noc`, `nombre`, `foto`, `pass`) VALUES
(10101010, 'Pedrito Fernandez Lopez', 'user.png', '$1$.3bZPro5$tHXPYLEL.T995SDXkj.bz.'),
(10101011, 'Ana Maria Lopez Lopez', 'user.png', '$1$ypxJ.HhN$a7pej9vaIjomX8ctavXBI.'),
(10101012, 'Federico Simpson Simp', 'user.png', '$1$QR1irEDW$Llv6Jaw7cydGzjSEcU58o/'),
(10101013, 'Hugo Sanchez Sanchez', 'user.png', '$1$xvYLMYLQ$XSPfa4hSHzslywogXwmXp/'),
(10101014, 'Carlos Serrano Chavez', 'user.png', '$1$7ss1BfPY$tcUh0o46bDQF6Le8meyla1'),
(10101015, 'Antolino Hernandez Ortiz', 'user.png', '$1$IhBUjIRa$MNOdBkvboEA8htSdmLsZ40'),
(10101016, 'Teresa Chavez Ortiz', 'user.png', '$1$i8/Fogt1$bHdlX5Xwh4i82Rng3.mKE.'),
(10101017, 'Pedro Martinez Ruiz', 'user.png', '$1$UJRjJzRe$U4IgvLUDe76cp.sJLk5UI.'),
(10101018, 'Ana Maria Lopez Lopez', 'user.png', '$1$iwd759Tx$k7Sb7gMjmEw/lkTc4MhfN1'),
(10101019, 'Federico Simpson Simp', 'user.png', '$1$kxdJnscF$FWB04wn5zzpNuEA5kZfKJ.'),
(10101020, 'Hugo Sanchez Sanchez', 'user.png', '$1$7mWw6DOP$v/IefeoE6ep884cgrKcDE0'),
(10101021, 'Carlos Serrano Chavez', 'user.png', '$1$7f3qjxb/$sz6L0E8FoTMPZ9JKytoPm1'),
(10101022, 'Antolino Hernandez Ortiz', 'user.png', '$1$27p/rDN.$2KwS4PtbhFb8dWhL5DtxV1'),
(10101023, 'Teresa Chavez Ortiz', 'user.png', '$1$19lZe1d4$H/mrQ3YpVsTrJ9SF/tlie.'),
(10101024, 'Pedro Martinez Ruiz', 'user.png', '$1$ySYt9pYn$qeWrVngpQ8iAe1BYXCj4O1'),
(10101025, 'Ana Maria Lopez Lopez', 'user.png', '$1$NjEin5tT$ee/NVxgKcw1ruAztzcU6N.'),
(10101026, 'Federico Simpson Simp', 'user.png', '$1$b357LZC2$03gP5gYB/BcPOB3HzSIv5/'),
(10101027, 'Hugo Sanchez Sanchez', 'user.png', '$1$nOat2X8r$O9dcurYDXaYYqtZYe22L7.'),
(10101028, 'Carlos Serrano Chavez', 'user.png', '$1$CqRakK9F$ctaOBYZojqBUz723siIuQ/'),
(10101029, 'Antolino Hernandez Ortiz', 'user.png', '$1$Q5WHLiKe$yAYT.1O.ozW53L2BozQ0N1'),
(10101030, 'Teresa Chavez Ortiz', 'user.png', '$1$x/bplojn$6zPkMacvkd68Vej1SgDWq0'),
(10101031, 'Pedro Martinez Ruiz', 'user.png', '$1$41oEgAc4$gBNl7krDRCLQO9mgav5yP.'),
(10101032, 'Ana Maria Lopez Lopez', 'user.png', '$1$ZVdrbMF.$Y/sZhZWdQ.ZQ4H8rz8Gow.'),
(10101033, 'Federico Simpson Simp', 'user.png', '$1$/A4lHSH/$.sT2L.MMopUk2TZDnh1hA.'),
(10101034, 'Hugo Sanchez Sanchez', 'user.png', '$1$iXkxm7k4$PhZxzyT2/CP972aDbzpdw1'),
(10101035, 'Carlos Serrano Chavez', 'user.png', '$1$5LwGrJHu$8GcbHZxdQEJT5UNMBBRQl0');

--
-- Disparadores `alumnos`
--
DELIMITER $$
CREATE TRIGGER `actforomsj` BEFORE UPDATE ON `alumnos` FOR EACH ROW UPDATE foro_msj SET foro_msj.user = NEW.noc WHERE foro_msj.user = OLD.noc
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actmsjalum` AFTER UPDATE ON `alumnos` FOR EACH ROW UPDATE alum_msj SET alum_msj.noc = NEW.noc WHERE alum_msj.noc = OLD.noc
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `elimmsjalum` BEFORE DELETE ON `alumnos` FOR EACH ROW DELETE FROM alum_msj WHERE alum_msj.noc = OLD.noc
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alum_msj`
--

CREATE TABLE `alum_msj` (
  `id` int(11) NOT NULL,
  `noc` int(8) NOT NULL,
  `asunto` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `msj` text COLLATE utf8_spanish_ci NOT NULL,
  `docs` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` set('E','R') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `carrera` varchar(64) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `carrera`) VALUES
('CON', 'Contabilidad'),
('INF', 'Informática'),
('ISC', 'Sistemas Computacionales'),
('ITIC', 'Ingeniería en Tecnologías de la Información y Comunicación');

--
-- Disparadores `carreras`
--
DELIMITER $$
CREATE TRIGGER `carreratg` AFTER UPDATE ON `carreras` FOR EACH ROW UPDATE profesores
SET profesores.carrera = NEW.id
WHERE profesores.carrera = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `eliminaprofe` BEFORE DELETE ON `carreras` FOR EACH ROW DELETE FROM profesores WHERE profesores.carrera = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examenes`
--

CREATE TABLE `examenes` (
  `id` int(11) NOT NULL,
  `id_mat` int(11) NOT NULL,
  `unidad` int(2) NOT NULL,
  `fec_ini` datetime NOT NULL,
  `fec_lim` datetime NOT NULL,
  `descripcion` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` set('O','N') COLLATE utf8_spanish_ci NOT NULL,
  `contenido` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `examenes`
--

INSERT INTO `examenes` (`id`, `id_mat`, `unidad`, `fec_ini`, `fec_lim`, `descripcion`, `tipo`, `contenido`) VALUES
(1, 2, 2, '2017-03-02 00:00:00', '2017-03-02 00:00:00', 'aasas', 'O', 'assa');

--
-- Disparadores `examenes`
--
DELIMITER $$
CREATE TRIGGER `elimexamalu` BEFORE DELETE ON `examenes` FOR EACH ROW DELETE FROM exam_alum WHERE exam_alum.id_exam = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exam_alum`
--

CREATE TABLE `exam_alum` (
  `noc` int(8) NOT NULL,
  `id_exam` int(11) NOT NULL,
  `fec_env` datetime NOT NULL,
  `calif` int(3) NOT NULL,
  `respuestas` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

CREATE TABLE `foro` (
  `id` int(11) NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `docs` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `contenido` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro_msj`
--

CREATE TABLE `foro_msj` (
  `id` int(11) NOT NULL,
  `id_foro` int(11) NOT NULL,
  `user` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `msj` text COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) NOT NULL,
  `materia` int(11) NOT NULL,
  `grupo` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rfc` varchar(13) COLLATE utf8_spanish_ci DEFAULT NULL,
  `activo` set('S','N') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`id`, `materia`, `grupo`, `fecha`, `rfc`, `activo`) VALUES
(7, 3, 'POO Grupo A', '2017-03-17 00:43:25', 'SAHM720522FA4', 'S'),
(8, 3, 'POO Grupo B', '2017-03-17 00:44:14', 'SAHM720522FA4', 'S'),
(9, 6, 'GPS A', '2017-03-29 14:50:08', 'VEFY860815NDA', 'S');

--
-- Disparadores `grupos`
--
DELIMITER $$
CREATE TRIGGER `eligrupalu` AFTER DELETE ON `grupos` FOR EACH ROW DELETE FROM gru_alum WHERE gru_alum.id_grup = OLD.id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `elimact` BEFORE DELETE ON `grupos` FOR EACH ROW DELETE FROM actividades WHERE actividades.id_mat = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gru_alum`
--

CREATE TABLE `gru_alum` (
  `noc` int(8) NOT NULL,
  `id_grup` int(11) NOT NULL,
  `activo` set('S','N') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `gru_alum`
--

INSERT INTO `gru_alum` (`noc`, `id_grup`, `activo`) VALUES
(10101010, 8, 'S'),
(10101011, 7, 'S'),
(10101011, 8, 'S'),
(10101012, 7, 'S'),
(10101012, 8, 'S'),
(10101013, 7, 'S'),
(10101013, 8, 'S'),
(10101014, 7, 'S'),
(10101014, 8, 'S'),
(10101015, 7, 'S'),
(10101016, 7, 'S'),
(10101017, 7, 'S'),
(10101018, 7, 'S'),
(10101018, 8, 'S'),
(10101019, 7, 'S'),
(10101019, 8, 'S'),
(10101020, 7, 'S'),
(10101020, 8, 'S'),
(10101021, 7, 'S'),
(10101021, 8, 'S'),
(10101022, 7, 'S'),
(10101022, 8, 'S'),
(10101023, 7, 'S'),
(10101023, 8, 'S'),
(10101024, 7, 'S'),
(10101024, 8, 'S'),
(10101025, 7, 'S'),
(10101025, 8, 'S'),
(10101026, 7, 'S'),
(10101026, 8, 'S'),
(10101027, 7, 'S'),
(10101027, 8, 'S'),
(10101028, 7, 'S'),
(10101029, 7, 'S'),
(10101030, 7, 'S'),
(10101031, 7, 'S'),
(10101031, 8, 'S'),
(10101032, 7, 'S'),
(10101032, 8, 'S'),
(10101033, 7, 'S'),
(10101033, 8, 'S'),
(10101034, 7, 'S'),
(10101034, 8, 'S'),
(10101035, 7, 'S'),
(10101035, 8, 'S');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `carrera` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `materia` varchar(128) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `carrera`, `materia`) VALUES
(1, 'INF', 'Base de Datos'),
(2, 'INF', 'Telecomunicacion Tarde'),
(3, 'ISC', 'Fundamentos de Progra'),
(4, 'ITIC', 'Tecnologías móviles'),
(5, 'CON', 'Contabilidad 1'),
(6, 'ISC', 'GPS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `rfc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `apepat` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `apemat` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` int(32) DEFAULT NULL,
  `carrera` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `foto` varchar(32) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pass` varchar(64) COLLATE utf8_spanish_ci NOT NULL,
  `cv` text COLLATE utf8_spanish_ci,
  `activo` set('S','N') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`rfc`, `nombre`, `apepat`, `apemat`, `email`, `telefono`, `carrera`, `foto`, `pass`, `cv`, `activo`) VALUES
('SAHM720522FA4', 'Miriam Zulma', 'Sanchez ', 'Hernandez', 'mzulma@gmail.com', NULL, 'ISC', 'user.png', '$1$IpF7KVhB$meD4uUD1K86i2JZsIjjWr0', NULL, 'S'),
('VEFY860815NDA', 'MA. YANETH', 'VEGA', 'FLORES', 'yaneth@gmail.com', NULL, 'ISC', 'user.png', '$1$k5jyZ2ZB$1wbn7w.vGf1BwfvlSd2fx0', NULL, 'S');

--
-- Disparadores `profesores`
--
DELIMITER $$
CREATE TRIGGER `actrfc` AFTER UPDATE ON `profesores` FOR EACH ROW BEGIN UPDATE grupos SET grupos.rfc = NEW.rfc WHERE grupos.rfc = OLD.rfc; UPDATE foro_msj SET foro_msj.user = NEW.rfc WHERE foro_msj.user = OLD.rfc;
UPDATE roles SET roles.rfc = NEW.rfc WHERE roles.rfc = OLD.rfc;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `elimrfc` BEFORE DELETE ON `profesores` FOR EACH ROW BEGIN 
UPDATE grupos SET grupos.rfc = NULL WHERE grupos.rfc = OLD.rfc;
DELETE FROM roles WHERE roles.rfc = OLD.rfc;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profe_msj`
--

CREATE TABLE `profe_msj` (
  `idmsj` int(11) NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `asunto` varchar(128) COLLATE utf8_spanish_ci NOT NULL,
  `msj` text COLLATE utf8_spanish_ci NOT NULL,
  `docs` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` set('E','R') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rfc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `carrera` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `rol` set('A','C','P') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rfc`, `carrera`, `rol`) VALUES
('SAHM720522FA4', 'INF', 'C'),
('SAHM720522FA4', 'ISC', 'A'),
('SAHM720522FA4', 'ISC', 'C'),
('SAHM720522FA4', 'ISC', 'P'),
('VEFY860815NDA', 'ISC', 'P');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `noc` int(8) NOT NULL,
  `id_act` int(11) NOT NULL,
  `docs` varchar(128) COLLATE utf8_spanish_ci DEFAULT NULL,
  `cotenido` text COLLATE utf8_spanish_ci,
  `fec_env` datetime NOT NULL,
  `entregada` set('S','N') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id_grup` int(11) NOT NULL,
  `unidad` int(2) NOT NULL,
  `contenido` text COLLATE utf8_spanish_ci,
  `docs` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id_grup`, `unidad`, `contenido`, `docs`) VALUES
(7, 1, '\r\n	\r\n	<h4>Título de la Unidad 1</h4><br>Lista de Temas:&nbsp;<br><ol><li>Tema uno</li><li>Tema dos</li><li>Tema tres</li><li>tema cuatro</li><li>tema cinco</li><li>Tema seis</li></ol>		', '128_7_1_poo.csv;40_7_1_applications.html;'),
(7, 2, '\r\n	<strong>Algoritmos</strong><br>2.1. Diseño de algoritmos<br>2.2. Estructura de algotirmos', NULL),
(7, 3, '', NULL),
(7, 4, '', NULL),
(7, 5, '', NULL),
(7, 6, 'Unidad 6', NULL),
(7, 7, NULL, NULL),
(8, 1, '<h4>Temario de la Unidad 1</h4>Tema 1<br>Tema 2<br>Tema 4', NULL),
(8, 2, NULL, NULL),
(8, 3, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`noc`);

--
-- Indices de la tabla `alum_msj`
--
ALTER TABLE `alum_msj`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `exam_alum`
--
ALTER TABLE `exam_alum`
  ADD PRIMARY KEY (`noc`,`id_exam`),
  ADD KEY `elimexamidfk` (`id_exam`);

--
-- Indices de la tabla `foro`
--
ALTER TABLE `foro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rfc` (`rfc`);

--
-- Indices de la tabla `foro_msj`
--
ALTER TABLE `foro_msj`
  ADD PRIMARY KEY (`id`,`id_foro`),
  ADD KEY `elimforomsjfk` (`id_foro`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`,`materia`),
  ADD KEY `elimgrupfk` (`materia`);

--
-- Indices de la tabla `gru_alum`
--
ALTER TABLE `gru_alum`
  ADD PRIMARY KEY (`noc`,`id_grup`),
  ADD KEY `elimgrupfk2` (`id_grup`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`,`carrera`),
  ADD KEY `elimmatfk` (`carrera`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`rfc`);

--
-- Indices de la tabla `profe_msj`
--
ALTER TABLE `profe_msj`
  ADD PRIMARY KEY (`idmsj`),
  ADD KEY `rfc` (`rfc`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rfc`,`carrera`,`rol`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`noc`,`id_act`),
  ADD KEY `elimtareafk` (`id_act`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id_grup`,`unidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT de la tabla `alum_msj`
--
ALTER TABLE `alum_msj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `examenes`
--
ALTER TABLE `examenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `foro`
--
ALTER TABLE `foro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `foro_msj`
--
ALTER TABLE `foro_msj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `profe_msj`
--
ALTER TABLE `profe_msj`
  MODIFY `idmsj` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `exam_alum`
--
ALTER TABLE `exam_alum`
  ADD CONSTRAINT `elimexlum` FOREIGN KEY (`noc`) REFERENCES `alumnos` (`noc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `foro`
--
ALTER TABLE `foro`
  ADD CONSTRAINT `elimpostforo` FOREIGN KEY (`rfc`) REFERENCES `profesores` (`rfc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `foro_msj`
--
ALTER TABLE `foro_msj`
  ADD CONSTRAINT `elimforomsjfk` FOREIGN KEY (`id_foro`) REFERENCES `foro` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `elimgrupfk` FOREIGN KEY (`materia`) REFERENCES `materias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `gru_alum`
--
ALTER TABLE `gru_alum`
  ADD CONSTRAINT `elimnocgfk` FOREIGN KEY (`noc`) REFERENCES `alumnos` (`noc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `materias`
--
ALTER TABLE `materias`
  ADD CONSTRAINT `elimmatfk` FOREIGN KEY (`carrera`) REFERENCES `carreras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profe_msj`
--
ALTER TABLE `profe_msj`
  ADD CONSTRAINT `elimmsjprof` FOREIGN KEY (`rfc`) REFERENCES `profesores` (`rfc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `elimalu` FOREIGN KEY (`noc`) REFERENCES `alumnos` (`noc`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD CONSTRAINT `elimunifk` FOREIGN KEY (`id_grup`) REFERENCES `grupos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
