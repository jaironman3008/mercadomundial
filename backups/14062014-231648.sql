CREATE DATABASE IF NOT EXISTS dbtutienda;

USE dbtutienda;

DROP TABLE IF EXISTS articulos;

CREATE TABLE `articulos` (
  `idarticulo` int(5) NOT NULL auto_increment,
  `descripcion` text collate utf8_spanish_ci NOT NULL,
  `idcategoria` int(5) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `oferta` decimal(8,2) NOT NULL,
  `img` varchar(50) collate utf8_spanish_ci NOT NULL,
  `idusuario` int(5) NOT NULL,
  `estado` varchar(20) collate utf8_spanish_ci NOT NULL,
  `subasta` decimal(8,2) NOT NULL,
  `fechareg` date NOT NULL,
  `horareg` time NOT NULL,
  `fechaventa` date NOT NULL,
  `horaventa` time NOT NULL,
  `revisado` varchar(15) collate utf8_spanish_ci NOT NULL,
  `revisadopor` varchar(20) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idarticulo`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO articulos VALUES("1","4gb","14","100.00","0.00","1_flas.jpeg","2","nuevo","0.00","2014-06-05","02:21:18","0000-00-00","00:00:00","aceptado","3");
INSERT INTO articulos VALUES("2","4x4","11","5000.00","0.00","","2","nuevo","0.00","2014-06-05","02:26:37","0000-00-00","00:00:00","no","3");
INSERT INTO articulos VALUES("3","nokia","1","200.00","0.00","","2","usado","0.00","2014-06-05","02:35:56","0000-00-00","00:00:00","no","1");
INSERT INTO articulos VALUES("4","metalico","10","500.00","0.00","","2","nuevo","0.00","2014-06-05","02:36:34","0000-00-00","00:00:00","no","1");
INSERT INTO articulos VALUES("5","auto nissan","12","50000.00","0.00","","2","usado","0.00","2014-06-05","02:51:10","0000-00-00","00:00:00","no","1");
INSERT INTO articulos VALUES("6","Nokia","1","70.00","0.00","","2","usado","0.00","2014-06-05","02:52:31","0000-00-00","00:00:00","no","1");
INSERT INTO articulos VALUES("7","Samsung","1","500.00","0.00","","2","nuevo","0.00","2014-06-05","03:00:31","0000-00-00","00:00:00","no","1");
INSERT INTO articulos VALUES("8","flas 2gb","14","120.00","0.00","","2","nuevo","0.00","2014-06-05","03:04:55","0000-00-00","00:00:00","no","1");
INSERT INTO articulos VALUES("9","lg","1","200.00","0.00","","1","nuevo","0.00","2014-06-05","03:06:19","0000-00-00","00:00:00","no","1");
INSERT INTO articulos VALUES("10","librero","18","200.00","0.00","","2","usado","0.00","2014-06-05","03:07:08","0000-00-00","00:00:00","no","1");
INSERT INTO articulos VALUES("11","camioneta jair","11","50000.00","0.00","","35","usado","0.00","2014-06-05","04:32:57","0000-00-00","00:00:00","aceptado","1");
INSERT INTO articulos VALUES("12","32 pulgadas","4","300.00","0.00","","36","usado","0.00","2014-06-05","05:11:34","0000-00-00","00:00:00","aceptado","1");
INSERT INTO articulos VALUES("13","multifuncional","3","500.00","0.00","","37","nuevo","0.00","2014-06-05","06:22:03","0000-00-00","00:00:00","aceptado","1");
INSERT INTO articulos VALUES("14","5gb carmen","14","80.00","0.00","","37","usado","0.00","2014-06-05","06:40:37","0000-00-00","00:00:00","aceptado","1");



DROP TABLE IF EXISTS banners;

CREATE TABLE `banners` (
  `idbanner` int(5) NOT NULL auto_increment,
  `img` varchar(50) collate utf8_spanish_ci NOT NULL,
  `title` varchar(50) collate utf8_spanish_ci NOT NULL,
  `ver` varchar(5) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idbanner`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO banners VALUES("1","logoymouse.png","Tu Tienda","si");
INSERT INTO banners VALUES("2","vendiendo.png","Vende","si");
INSERT INTO banners VALUES("3","contactanos.png","Contactanos","si");
INSERT INTO banners VALUES("4","comprayvende.png","Compra","si");
INSERT INTO banners VALUES("5","celulares.jpg","Celulares","si");
INSERT INTO banners VALUES("37","errorsenal.png","errorsenal","no");
INSERT INTO banners VALUES("38","Puesta de sol.jpg","Sol","no");



DROP TABLE IF EXISTS bitacora;

CREATE TABLE `bitacora` (
  `idbitacora` int(5) NOT NULL auto_increment COMMENT 'Identificador de la tabla',
  `detalle` text character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'detalle de accion realizada',
  `usuario` varchar(20) character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'usuario que realiza la accion',
  `fecha` date NOT NULL COMMENT 'fecha de la accion',
  `hora` time NOT NULL COMMENT 'hora de la accion',
  `idaccion` int(11) NOT NULL COMMENT 'id del registro sobre el que opero',
  PRIMARY KEY  (`idbitacora`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

INSERT INTO bitacora VALUES("1","Inicio de sesion","eliseosuper","2014-06-05","00:27:06","0");
INSERT INTO bitacora VALUES("2","Inicio de sesion","eliseosuper","2014-06-05","00:28:27","0");
INSERT INTO bitacora VALUES("3","Inicio de sesion","eliseosuper","2014-06-05","00:29:17","0");
INSERT INTO bitacora VALUES("4","Inicio de sesion","eliseosuper","2014-06-05","00:30:30","0");
INSERT INTO bitacora VALUES("5","Inicio de sesion","abigail","2014-06-05","01:48:32","0");
INSERT INTO bitacora VALUES("6","Inicio de sesion","eliseosuper","2014-06-05","02:21:54","0");
INSERT INTO bitacora VALUES("7","Inicio de sesion","abigail","2014-06-05","02:23:57","0");
INSERT INTO bitacora VALUES("8","Inicio de sesion","eliseosuper","2014-06-05","02:26:51","0");
INSERT INTO bitacora VALUES("9","Inicio de sesion","abigail","2014-06-05","02:50:04","0");
INSERT INTO bitacora VALUES("10","Inicio de sesion","eliseosuper","2014-06-05","06:08:01","0");
INSERT INTO bitacora VALUES("11","Inicio de sesion","abigail","2014-06-05","06:25:30","0");
INSERT INTO bitacora VALUES("12","Inicio de sesion","eliseosuper","2014-06-05","06:40:59","0");
INSERT INTO bitacora VALUES("13","Inicio de sesion","eliseosuper","2014-06-05","06:43:37","0");
INSERT INTO bitacora VALUES("14","Inicio de sesion","eliseosuper","2014-06-11","21:40:27","0");
INSERT INTO bitacora VALUES("15","Inicio de sesion","eliseosuper","2014-06-13","17:07:52","0");
INSERT INTO bitacora VALUES("16","Inicio de sesion","eliseosuper","2014-06-14","17:20:02","0");
INSERT INTO bitacora VALUES("17","Inicio de sesion","eliseosuper","2014-06-14","17:26:18","0");
INSERT INTO bitacora VALUES("18","Inicio de sesion","eliseosuper","2014-06-14","18:23:48","0");
INSERT INTO bitacora VALUES("19","Inicio de sesion","eliseosuper","2014-06-14","21:32:33","0");
INSERT INTO bitacora VALUES("20","Inicio de sesion","eliseosuper","2014-06-14","21:32:43","0");
INSERT INTO bitacora VALUES("21","Inicio de sesion","eliseosuper","2014-06-14","21:35:13","0");
INSERT INTO bitacora VALUES("22","Inicio de sesion","eliseosuper","2014-06-14","21:35:38","0");
INSERT INTO bitacora VALUES("23","Inicio de sesion","eliseosuper","2014-06-14","21:46:56","0");
INSERT INTO bitacora VALUES("24","Inicio de sesion","eliseosuper","2014-06-14","21:48:03","0");
INSERT INTO bitacora VALUES("25","Inicio de sesion","eliseosuper","2014-06-14","22:08:42","0");
INSERT INTO bitacora VALUES("26","Inicio de sesion","eliseosuper","2014-06-14","22:15:31","0");



DROP TABLE IF EXISTS categoriaarticulos;

CREATE TABLE `categoriaarticulos` (
  `idcategoria` int(5) NOT NULL auto_increment,
  `categoria` varchar(50) collate utf8_spanish_ci NOT NULL,
  `ver` varchar(10) collate utf8_spanish_ci NOT NULL,
  `visit` int(10) NOT NULL,
  `fechareg` date NOT NULL,
  `horareg` time NOT NULL,
  PRIMARY KEY  (`idcategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO categoriaarticulos VALUES("1","celulares","si","24","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("2","motocicletas","si","5","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("3","impresoras","si","2","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("4","monitores","si","14","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("5","televisores","si","5","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("6","televisores 3D","si","1","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("7","pcescritorio","si","3","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("8","relojes","si","5","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("9","ventiladores","si","0","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("10","escritorios","si","5","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("11","camionetas","si","7","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("12","automoviles","si","4","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("13","aires acondicionados","si","16","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("14","flash memory","si","15","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("15","portatiles","si","1","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("16","varios","si","0","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("17","Casas","si","3","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("18","Muebles","si","4","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("30","Parlantes","si","2","2014-01-13","12:40:23");



DROP TABLE IF EXISTS consultas;

CREATE TABLE `consultas` (
  `idconsulta` int(5) NOT NULL auto_increment,
  `consulta` text collate utf8_spanish_ci NOT NULL,
  `fechareg` date NOT NULL,
  `horareg` time NOT NULL,
  `sendFrom` varchar(30) collate utf8_spanish_ci NOT NULL,
  `sendTo` varchar(30) collate utf8_spanish_ci NOT NULL,
  `estado` varchar(15) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idconsulta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS departamentos;

CREATE TABLE `departamentos` (
  `iddepartamento` int(5) NOT NULL,
  `departamento` varchar(50) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`iddepartamento`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO departamentos VALUES("1","Beni");
INSERT INTO departamentos VALUES("2","Santa Cruz");
INSERT INTO departamentos VALUES("3","Pando");
INSERT INTO departamentos VALUES("4","Tarija");
INSERT INTO departamentos VALUES("5","Oruro");
INSERT INTO departamentos VALUES("6","Cochabamba");
INSERT INTO departamentos VALUES("7","La paz");
INSERT INTO departamentos VALUES("8","Potosi");
INSERT INTO departamentos VALUES("9","Chuquisaca");



DROP TABLE IF EXISTS detallepaquetearticulos;

CREATE TABLE `detallepaquetearticulos` (
  `idpaquetearticulo` int(5) NOT NULL,
  `idarticulo` int(5) NOT NULL,
  `fecharegistro` date NOT NULL,
  `horaregistro` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO detallepaquetearticulos VALUES("1","1","2014-06-05","02:21:18");
INSERT INTO detallepaquetearticulos VALUES("1","2","2014-06-05","02:26:37");
INSERT INTO detallepaquetearticulos VALUES("2","3","2014-06-05","02:35:56");
INSERT INTO detallepaquetearticulos VALUES("2","4","2014-06-05","02:36:34");
INSERT INTO detallepaquetearticulos VALUES("3","5","2014-06-05","02:51:10");
INSERT INTO detallepaquetearticulos VALUES("3","6","2014-06-05","02:52:31");
INSERT INTO detallepaquetearticulos VALUES("4","7","2014-06-05","03:00:31");
INSERT INTO detallepaquetearticulos VALUES("5","8","2014-06-05","03:04:55");
INSERT INTO detallepaquetearticulos VALUES("5","9","2014-06-05","03:06:19");
INSERT INTO detallepaquetearticulos VALUES("6","10","2014-06-05","03:07:08");
INSERT INTO detallepaquetearticulos VALUES("7","11","2014-06-05","04:32:57");
INSERT INTO detallepaquetearticulos VALUES("8","12","2014-06-05","05:11:34");
INSERT INTO detallepaquetearticulos VALUES("9","13","2014-06-05","06:22:03");
INSERT INTO detallepaquetearticulos VALUES("10","14","2014-06-05","06:40:37");



DROP TABLE IF EXISTS detallepaqueteusuarios;

CREATE TABLE `detallepaqueteusuarios` (
  `idpaqueteusuario` int(5) NOT NULL,
  `idusuario` int(5) NOT NULL,
  `fecharegistro` date NOT NULL,
  `horaregistro` time NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO detallepaqueteusuarios VALUES("1","35","2014-06-05","04:14:35");
INSERT INTO detallepaqueteusuarios VALUES("2","36","2014-06-05","04:38:56");
INSERT INTO detallepaqueteusuarios VALUES("3","37","2014-06-05","05:13:55");
INSERT INTO detallepaqueteusuarios VALUES("4","38","2014-06-05","06:24:58");



DROP TABLE IF EXISTS mensajes;

CREATE TABLE `mensajes` (
  `idmensaje` int(5) NOT NULL auto_increment COMMENT 'identificador de la tabla',
  `idSendFrom` int(5) NOT NULL,
  `idSendTo` int(5) default NULL,
  `asunto` varchar(50) collate utf8_spanish_ci NOT NULL,
  `mensaje` text collate utf8_spanish_ci NOT NULL COMMENT 'mensaje que se le envio al numero',
  `fecha` date NOT NULL COMMENT 'fecha de envio del sms',
  `hora` time NOT NULL COMMENT 'hora de envio del sms',
  `estado` varchar(20) collate utf8_spanish_ci NOT NULL COMMENT 'estado del mensaje',
  `tipo` varchar(20) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idmensaje`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO mensajes VALUES("1","3","2","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 02:21:18 ha sido aceptada","2014-06-05","02:50:28","leido","mensaje");
INSERT INTO mensajes VALUES("2","1","2","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(jair) ha sido dado de alta","2014-06-05","04:16:40","leido","mensaje");
INSERT INTO mensajes VALUES("3","1","35","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 04:32:57 ha sido aceptada","2014-06-05","04:33:33","leido","mensaje");
INSERT INTO mensajes VALUES("4","1","35","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(yossy) ha sido dado de alta","2014-06-05","04:40:49","leido","mensaje");
INSERT INTO mensajes VALUES("5","1","36","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 05:11:34 ha sido aceptada","2014-06-05","05:12:14","sin leer","mensaje");
INSERT INTO mensajes VALUES("6","1","36","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(carmen) ha sido dado de alta","2014-06-05","05:15:08","sin leer","mensaje");
INSERT INTO mensajes VALUES("7","1","36","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(carmen) ha sido dado de alta","2014-06-05","06:08:39","sin leer","mensaje");
INSERT INTO mensajes VALUES("8","1","37","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 06:22:03 ha sido aceptada","2014-06-05","06:23:04","leido","mensaje");
INSERT INTO mensajes VALUES("9","3","37","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(irma) ha sido dado de alta","2014-06-05","06:27:09","leido","mensaje");
INSERT INTO mensajes VALUES("10","1","37","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 06:40:37 ha sido aceptada","2014-06-05","06:41:30","sin leer","mensaje");
INSERT INTO mensajes VALUES("11","37","1","CONSULTA","puedo enviar consultas?","2014-06-05","06:43:26","leido","consulta");



DROP TABLE IF EXISTS ofertasdesubastas;

CREATE TABLE `ofertasdesubastas` (
  `idoferta` int(5) NOT NULL,
  `idusuario` int(5) NOT NULL,
  `oferta` int(5) NOT NULL,
  `idarticulo` int(5) NOT NULL,
  `fecharegistro` date NOT NULL,
  `horaregistro` time NOT NULL,
  PRIMARY KEY  (`idoferta`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;




DROP TABLE IF EXISTS paquetearticulos;

CREATE TABLE `paquetearticulos` (
  `idpaquetearticulo` int(5) NOT NULL,
  `fechacreacion` date NOT NULL,
  `horacreacion` time NOT NULL,
  `fechaapertura` date NOT NULL,
  `horaapertura` time NOT NULL,
  `fechadistribucion` date NOT NULL,
  `horadistribucion` time NOT NULL,
  `estado` varchar(15) collate utf8_spanish_ci NOT NULL,
  `idresponsable` int(5) NOT NULL,
  PRIMARY KEY  (`idpaquetearticulo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO paquetearticulos VALUES("1","2014-06-05","02:21:18","2014-06-05","02:22:49","0000-00-00","00:00:00","abierto","3");
INSERT INTO paquetearticulos VALUES("2","2014-06-05","02:35:56","2014-06-05","02:36:11","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("3","2014-06-05","02:51:10","2014-06-05","02:51:20","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("4","2014-06-05","02:55:10","2014-06-05","03:04:18","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("5","2014-06-05","03:04:55","2014-06-05","03:07:23","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("6","2014-06-05","03:07:08","2014-06-05","03:07:26","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("7","2014-06-05","04:32:57","2014-06-05","04:33:08","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("8","2014-06-05","05:11:34","2014-06-05","05:11:59","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("9","2014-06-05","06:22:03","2014-06-05","06:22:24","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("10","2014-06-05","06:40:37","2014-06-05","06:41:06","0000-00-00","00:00:00","abierto","1");



DROP TABLE IF EXISTS paqueteusuarios;

CREATE TABLE `paqueteusuarios` (
  `idpaqueteusuario` int(5) NOT NULL,
  `fechacreacion` date NOT NULL,
  `horacreacion` time NOT NULL,
  `fechaapertura` date NOT NULL,
  `horaapertura` time NOT NULL,
  `fechadistribucion` date NOT NULL,
  `horadistribucion` time NOT NULL,
  `estado` varchar(15) collate utf8_spanish_ci NOT NULL,
  `idresponsable` int(5) NOT NULL,
  PRIMARY KEY  (`idpaqueteusuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO paqueteusuarios VALUES("1","2014-06-05","04:14:35","2014-06-05","04:15:25","0000-00-00","00:00:00","abierto","1");
INSERT INTO paqueteusuarios VALUES("2","2014-06-05","04:38:56","2014-06-05","04:40:00","0000-00-00","00:00:00","abierto","1");
INSERT INTO paqueteusuarios VALUES("3","2014-06-05","05:13:55","2014-06-05","05:14:01","0000-00-00","00:00:00","abierto","1");
INSERT INTO paqueteusuarios VALUES("4","2014-06-05","06:24:58","2014-06-05","06:25:13","0000-00-00","00:00:00","abierto","3");



DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `idusuario` int(5) NOT NULL auto_increment COMMENT 'identificador de la tabla',
  `nombre` varchar(30) character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'nombre del usuario',
  `appaterno` varchar(30) character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'apellido paterno del usuario',
  `apmaterno` varchar(30) character set utf8 collate utf8_spanish_ci default NULL COMMENT 'apellido materno del usuario',
  `fecharegistro` date NOT NULL COMMENT 'fecha de registro del usuario',
  `horaregistro` time NOT NULL COMMENT 'hora de registro del usuario',
  `ci` varchar(15) character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'documento de identidad del usuario',
  `expedidoen` varchar(20) NOT NULL,
  `direccion` text character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'direccion del usuario',
  `usuario` varchar(20) character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'usuario para ingresar al sistema',
  `numcuenta` varchar(20) character set utf8 collate utf8_spanish_ci NOT NULL,
  `contrasenia` text character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'contrasenia del usuario',
  `telefonocel` varchar(15) character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'telefono celular del usuario',
  `telefonofijo` varchar(15) character set utf8 collate utf8_spanish_ci default NULL COMMENT 'telefono fijo del usuario',
  `email` varchar(30) NOT NULL,
  `rol` varchar(30) character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'cargo del usuario',
  `estado` varchar(15) character set utf8 collate utf8_spanish_ci NOT NULL COMMENT 'estado del usuario',
  `addedby` int(5) NOT NULL,
  `depositoImg` varchar(50) character set utf8 collate utf8_spanish_ci default NULL,
  `terminosDeUso` varchar(5) character set utf8 collate utf8_spanish_ci NOT NULL,
  `cuentaVencida` varchar(5) character set utf8 collate utf8_spanish_ci NOT NULL,
  `revisado` varchar(15) character set utf8 collate utf8_spanish_ci NOT NULL,
  `revisadopor` varchar(20) character set utf8 collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idusuario`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

INSERT INTO usuarios VALUES("1","Eliseo","Villca","Luna","2014-06-05","00:10:41","5198738","6","c/ abadesas sn trinidad","eliseosuper","801-50693381-3-22","047f8a46e7c1d5db35f6c9a6607b9fb0","67403185","4298724","eliseo_villca2013@hotmail.com","superadmin","activo","1","","si","si","aceptado","1");
INSERT INTO usuarios VALUES("2","eliseo","Villca","Luna","2014-06-05","00:15:00","5198738","6","c/ abadesas sn trinidad","eliseo","801-50693381-3-22","047f8a46e7c1d5db35f6c9a6607b9fb0","67403185","4298724","eliseo_villca2013@hotmail.com","usuario","activo","1","2_IMG_20140604_0002.jpg","si","no","aceptado","1");
INSERT INTO usuarios VALUES("3","abigail","cordero","nina","2014-06-05","01:40:40","5607878","6","fasd","abigail","301-50647004-3-72","2da803198df21f216628ff123af67ddd","78979456","","mi@emial.com","admin","activo","1","","si","","aceptado","1");
INSERT INTO usuarios VALUES("4","Ivith","Villca","Luna","2014-06-05","01:48:06","5607878","6","lejos","ivith","301-50647004-3-72","b05f3148fbe5e722b530cbc54bb91e51","78979456","","mi@emial.com","admin","activo","1","","si","","aceptado","1");
INSERT INTO usuarios VALUES("35","Javier Jair","Cussy","Saucedo","2014-06-05","04:14:33","5607607","1","Lejos","jair","301-50647004-3-72","f3e089b8b5f571c1ffcda21bcf87e2ed","72822907","","jaironman_jcs@hotmail.com","usuario","activo","2","5_IMG_20140604_0002.jpg","si","","aceptado","1");
INSERT INTO usuarios VALUES("36","yosselin","Cussy","Saucedo","2014-06-05","04:38:54","579864684","1","lejos","yossy","801-50693381-3-22","e1b58751e0d04bd4a1dd58a72050f11d","70272161","","mi@email.com","usuario","activo","35","36_IMG_20140604_0002.jpg","si","","aceptado","1");
INSERT INTO usuarios VALUES("37","carmen abad","cussy","saucedo","2014-06-05","05:13:53","5608789","1","lejos","carmen","201-50694144-3-87","58aac6618ff327e1f905e720675e74d1","72855907","","email@dsf.com","usuario","activo","36","37_ajax-loader.gif","si","","aceptado","1");
INSERT INTO usuarios VALUES("38","irma","saucedo","nuñez","2014-06-05","06:24:56","1733883","1","av. meliton","irma","801-50693381-3-22","87c3b1099e04e21e90a7c308a8b186b3","70271564","","mi@email.com","usuario","activo","37","38_46 90mt.JPG","si","","aceptado","3");



