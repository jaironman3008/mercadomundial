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
  `ubicacion` smallint(6) NOT NULL,
  `moneda` smallint(6) NOT NULL,
  PRIMARY KEY  (`idarticulo`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO articulos VALUES("1","4gb","14","100.00","0.00","1_flas.jpeg","2","nuevo","0.00","2014-06-05","02:21:18","0000-00-00","00:00:00","aceptado","3","1","1");
INSERT INTO articulos VALUES("2","4x4g","11","5005.00","5005.00","","2","nuevo","0.00","2014-06-05","02:26:37","0000-00-00","00:00:00","no","3","1","1");
INSERT INTO articulos VALUES("3","nokia","1","200.00","0.00","","2","usado","0.00","2014-06-05","02:35:56","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("4","metalico","10","500.00","0.00","","2","nuevo","0.00","2014-06-05","02:36:34","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("5","auto nissan","12","50000.00","0.00","","2","usado","0.00","2014-06-05","02:51:10","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("6","Nokia","1","70.00","0.00","","2","usado","0.00","2014-06-05","02:52:31","0000-00-00","00:00:00","rechazado","1","1","1");
INSERT INTO articulos VALUES("7","Samsung","1","500.00","0.00","","2","nuevo","0.00","2014-06-05","03:00:31","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("8","flas 2gb","14","120.00","0.00","","2","nuevo","0.00","2014-06-05","03:04:55","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("9","lg","1","200.00","0.00","","1","nuevo","0.00","2014-06-05","03:06:19","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("10","librero","18","200.00","0.00","","2","usado","0.00","2014-06-05","03:07:08","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("11","camioneta jair","11","50000.00","0.00","","35","usado","0.00","2014-06-05","04:32:57","0000-00-00","00:00:00","aceptado","1","1","1");
INSERT INTO articulos VALUES("12","32 pulgadas","4","300.00","0.00","","36","usado","0.00","2014-06-05","05:11:34","0000-00-00","00:00:00","aceptado","1","1","1");
INSERT INTO articulos VALUES("13","multifuncional","3","500.00","0.00","","37","nuevo","0.00","2014-06-05","06:22:03","0000-00-00","00:00:00","aceptado","1","1","1");
INSERT INTO articulos VALUES("14","5gb carmen","14","80.00","0.00","","37","usado","0.00","2014-06-05","06:40:37","0000-00-00","00:00:00","aceptado","1","1","1");
INSERT INTO articulos VALUES("15","","15","0.00","0.00","","2","","0.00","2014-08-02","21:03:56","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("16","prueba de articulo con ubicacion y moneda","18","500.00","0.00","","2","usado","0.00","2014-08-09","00:02:12","0000-00-00","00:00:00","no","1","1","1");
INSERT INTO articulos VALUES("17","prueba 2 de publicacion con ubicacion y moneda","15","300.00","0.00","","2","nuevo","0.00","2014-08-09","00:04:47","0000-00-00","00:00:00","no","1","2","2");
INSERT INTO articulos VALUES("18","4X4","11","7000.00","0.00","","2","usado","0.00","2014-08-13","00:38:06","0000-00-00","00:00:00","no","1","1","2");



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
INSERT INTO banners VALUES("5","celulares.jpg","Celulares","no");
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
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

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
INSERT INTO bitacora VALUES("16","Inicio de sesion","eliseosuper","2014-07-03","22:27:42","0");
INSERT INTO bitacora VALUES("17","Inicio de sesion","eliseosuper","2014-07-03","22:45:28","0");
INSERT INTO bitacora VALUES("18","Inicio de sesion","eliseosuper","2014-07-03","23:08:49","0");
INSERT INTO bitacora VALUES("19","Inicio de sesion","eliseosuper","2014-07-03","23:10:29","0");
INSERT INTO bitacora VALUES("20","Inicio de sesion","abigail","2014-07-04","00:15:50","0");
INSERT INTO bitacora VALUES("21","Inicio de sesion","eliseosuper","2014-07-04","00:18:05","0");
INSERT INTO bitacora VALUES("22","Inicio de sesion","abigail","2014-07-04","00:20:31","0");
INSERT INTO bitacora VALUES("23","Inicio de sesion","ivith","2014-07-04","00:21:54","0");
INSERT INTO bitacora VALUES("24","Inicio de sesion","eliseosuper","2014-07-04","19:36:26","0");
INSERT INTO bitacora VALUES("25","Inicio de sesion","eliseosuper","2014-08-03","09:51:42","0");
INSERT INTO bitacora VALUES("26","Inicio de sesion","eliseosuper","2014-08-09","00:30:55","0");
INSERT INTO bitacora VALUES("27","Inicio de sesion","eliseosuper","2014-08-09","00:33:50","0");
INSERT INTO bitacora VALUES("28","Inicio de sesion","eliseosuper","2014-08-09","00:52:13","0");
INSERT INTO bitacora VALUES("29","Inicio de sesion","eliseosuper","2014-08-09","23:24:30","0");
INSERT INTO bitacora VALUES("30","Inicio de sesion","eliseosuper","2014-08-10","00:38:46","0");
INSERT INTO bitacora VALUES("31","Inicio de sesion","eliseosuper","2014-08-10","20:10:07","0");
INSERT INTO bitacora VALUES("32","Inicio de sesion","eliseosuper","2014-08-10","21:01:54","0");
INSERT INTO bitacora VALUES("33","Inicio de sesion","eliseosuper","2014-08-13","00:36:05","0");
INSERT INTO bitacora VALUES("34","Inicio de sesion","eliseosuper","2014-08-15","23:51:20","0");
INSERT INTO bitacora VALUES("35","Inicio de sesion","eliseosuper","2014-08-16","00:05:21","0");



DROP TABLE IF EXISTS categoriaarticulos;

CREATE TABLE `categoriaarticulos` (
  `idcategoria` int(5) NOT NULL auto_increment,
  `categoria` varchar(50) collate utf8_spanish_ci NOT NULL,
  `ver` varchar(10) collate utf8_spanish_ci NOT NULL,
  `visit` int(10) NOT NULL,
  `fechareg` date NOT NULL,
  `horareg` time NOT NULL,
  PRIMARY KEY  (`idcategoria`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO categoriaarticulos VALUES("1","celulares","si","30","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("2","motocicletas","si","11","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("3","impresoras","si","6","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("4","monitores","si","18","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("5","televisores","si","6","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("6","televisores 3D","si","1","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("7","pcescritorio","si","4","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("8","relojes","si","8","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("9","ventiladores","si","0","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("10","escritorios","si","8","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("11","camionetas","si","19","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("12","automoviles","si","10","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("13","aires acondicionados","si","23","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("14","flash memory","si","36","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("15","portatiles","si","6","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("16","varios","si","0","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("17","Casas","si","7","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("18","Muebles","si","6","0000-00-00","00:00:00");
INSERT INTO categoriaarticulos VALUES("30","Parlantes","si","4","2014-01-13","12:40:23");
INSERT INTO categoriaarticulos VALUES("31","Departamentos","si","0","2014-08-09","00:34:05");
INSERT INTO categoriaarticulos VALUES("32","Oficinas","si","2","2014-08-09","00:36:31");
INSERT INTO categoriaarticulos VALUES("33","Juguetes","si","2","2014-08-09","00:37:00");
INSERT INTO categoriaarticulos VALUES("34","Libros","si","2","2014-08-09","00:37:42");
INSERT INTO categoriaarticulos VALUES("35","Ropa","si","0","2014-08-09","00:38:15");
INSERT INTO categoriaarticulos VALUES("36","Pezca","si","1","2014-08-09","00:38:20");
INSERT INTO categoriaarticulos VALUES("37","Videojuegos","si","0","2014-08-09","00:39:18");
INSERT INTO categoriaarticulos VALUES("38","Instrumentos musicales","si","1","2014-08-09","00:40:23");



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
INSERT INTO detallepaquetearticulos VALUES("11","15","2014-08-02","21:03:56");
INSERT INTO detallepaquetearticulos VALUES("11","16","2014-08-09","00:02:12");
INSERT INTO detallepaquetearticulos VALUES("11","17","2014-08-09","00:04:47");
INSERT INTO detallepaquetearticulos VALUES("12","18","2014-08-13","00:38:06");



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
INSERT INTO detallepaqueteusuarios VALUES("5","39","2014-08-07","01:15:30");
INSERT INTO detallepaqueteusuarios VALUES("5","40","2014-08-07","01:17:44");
INSERT INTO detallepaqueteusuarios VALUES("5","41","2014-08-07","21:52:56");



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
  `deleted` smallint(1) NOT NULL,
  PRIMARY KEY  (`idmensaje`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO mensajes VALUES("1","3","2","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 02:21:18 ha sido aceptada","2014-06-05","02:50:28","leido","mensaje","0");
INSERT INTO mensajes VALUES("2","1","2","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(jair) ha sido dado de alta","2014-06-05","04:16:40","leido","mensaje","0");
INSERT INTO mensajes VALUES("3","1","35","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 04:32:57 ha sido aceptada","2014-06-05","04:33:33","leido","mensaje","0");
INSERT INTO mensajes VALUES("4","1","35","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(yossy) ha sido dado de alta","2014-06-05","04:40:49","leido","mensaje","0");
INSERT INTO mensajes VALUES("5","1","36","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 05:11:34 ha sido aceptada","2014-06-05","05:12:14","sin leer","mensaje","0");
INSERT INTO mensajes VALUES("6","1","36","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(carmen) ha sido dado de alta","2014-06-05","05:15:08","sin leer","mensaje","0");
INSERT INTO mensajes VALUES("7","1","36","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(carmen) ha sido dado de alta","2014-06-05","06:08:39","sin leer","mensaje","0");
INSERT INTO mensajes VALUES("8","1","37","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 06:22:03 ha sido aceptada","2014-06-05","06:23:04","leido","mensaje","0");
INSERT INTO mensajes VALUES("9","3","37","SOLICITUD DE NUEVO USUARIO","Estimado usuario le informamos que su invitado(irma) ha sido dado de alta","2014-06-05","06:27:09","leido","mensaje","0");
INSERT INTO mensajes VALUES("10","1","37","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 06:40:37 ha sido aceptada","2014-06-05","06:41:30","sin leer","mensaje","0");
INSERT INTO mensajes VALUES("11","37","1","CONSULTA","puedo enviar consultas?","2014-06-05","06:43:26","leido","consulta","0");
INSERT INTO mensajes VALUES("12","1","2","SOLICITUD DE NUEVO ARTICULO","Estimado usuario le informamos que su intento de publicacion en fecha 2014-06-05 a horas 02:52:31 ha sido rechazada","2014-07-04","00:00:04","leido","mensaje","0");
INSERT INTO mensajes VALUES("13","2","35","a cuat","asdfasdf","2014-07-04","00:02:57","leido","mensaje","1");
INSERT INTO mensajes VALUES("14","35","2","RE.:a cuat","mm..prueba de respuesta de mensaje","2014-07-04","00:04:19","leido","mensaje","0");
INSERT INTO mensajes VALUES("15","1","35","desde superadmin","desde super","2014-07-04","00:04:52","leido","mensaje","0");
INSERT INTO mensajes VALUES("16","1","3","CONSULTA","otra consulta","2014-07-04","00:15:24","leido","consulta","0");
INSERT INTO mensajes VALUES("17","35","4","CONSULTA","esta consulta le llegara a eliseo\n","2014-07-04","00:16:27","leido","consulta","0");
INSERT INTO mensajes VALUES("18","35","1","CONSULTA","esta otra consulta de llega a abigail","2014-07-04","00:16:48","leido","consulta","0");
INSERT INTO mensajes VALUES("19","4","35","RE.:CONSULTA","respuesa de ivith","2014-07-04","00:22:17","leido","mensaje","0");
INSERT INTO mensajes VALUES("20","2","3","CONSULTA","una consulta de prueba luego de incorporar la opcion de eliminar ","2014-08-08","00:22:23","sin leer","consulta","0");
INSERT INTO mensajes VALUES("21","2","35","prueba ","prueba de guardado mendiante envio de id directo","2014-08-10","20:46:47","leido","mensaje","1");
INSERT INTO mensajes VALUES("22","1","35","desde admin","enviando mensaje de advertencia desla vista de admin","2014-08-10","20:51:13","leido","mensaje","0");
INSERT INTO mensajes VALUES("23","1","36","prueba 2","envio desde el admin","2014-08-10","20:59:33","sin leer","mensaje","0");
INSERT INTO mensajes VALUES("24","1","35","prueba 3","envio de mensaje desde el aministrador. sesion reiniciada","2014-08-10","21:03:35","leido","mensaje","0");
INSERT INTO mensajes VALUES("25","1","35","advertencia","no publique mas mensajes asi","2014-08-10","21:05:32","leido","mensaje","0");
INSERT INTO mensajes VALUES("26","1","2","desde eliseo super","prueba con otro usuario ","2014-08-10","21:12:42","leido","mensaje","0");
INSERT INTO mensajes VALUES("27","2","4","CONSULTA","probando falla de envio de consultas a los administradores","2014-08-10","21:14:53","sin leer","consulta","0");



DROP TABLE IF EXISTS monedas;

CREATE TABLE `monedas` (
  `idmoneda` bigint(20) NOT NULL,
  `moneda` varchar(20) collate utf8_spanish_ci NOT NULL,
  `abrev` varchar(10) collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`idmoneda`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO monedas VALUES("1","bolivianos","Bs");
INSERT INTO monedas VALUES("2","dolares","$us");



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
INSERT INTO paquetearticulos VALUES("11","2014-08-02","21:03:56","2014-08-09","00:46:55","0000-00-00","00:00:00","abierto","1");
INSERT INTO paquetearticulos VALUES("12","2014-08-13","00:38:06","2014-08-13","00:38:20","0000-00-00","00:00:00","abierto","1");



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
INSERT INTO paqueteusuarios VALUES("5","2014-08-07","01:15:30","0000-00-00","00:00:00","0000-00-00","00:00:00","cerrado","0");



DROP TABLE IF EXISTS reg_sessions;

CREATE TABLE `reg_sessions` (
  `session_id` varchar(40) collate utf8_spanish_ci NOT NULL default '0',
  `ip_address` varchar(45) collate utf8_spanish_ci NOT NULL default '0',
  `user_agent` varchar(120) collate utf8_spanish_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL default '0',
  `user_data` text collate utf8_spanish_ci NOT NULL,
  PRIMARY KEY  (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO reg_sessions VALUES("f9bb2da14976c0f40b2e480dee349bc3","127.0.0.1","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36","1404618234","");
INSERT INTO reg_sessions VALUES("18511b530d59a8465aaa736c7ced4f61","127.0.0.1","Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0","1404618304","a:5:{s:9:\"user_data\";s:0:\"\";s:11:\"usuario_ses\";s:6:\"eliseo\";s:9:\"fecha_ses\";s:8:\"05/07/14\";s:8:\"hora_ses\";s:8:\"11:45:10\";s:12:\"is_logged_in\";b:1;}");
INSERT INTO reg_sessions VALUES("5d970137ec7fba3045a48afaafe4f539","127.0.0.1","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36","1404712563","");
INSERT INTO reg_sessions VALUES("1db1baa828a78e52ecced46780d6c6be","127.0.0.1","Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0","1404714307","");
INSERT INTO reg_sessions VALUES("3be232a8c52bfa32e4b4f074e9eed47d","127.0.0.1","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36","1404784043","");
INSERT INTO reg_sessions VALUES("7e05a0b1c4196b883138eb69209ea8ee","127.0.0.1","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36","1405303930","a:5:{s:9:\"user_data\";s:0:\"\";s:11:\"usuario_ses\";s:6:\"eliseo\";s:9:\"fecha_ses\";s:8:\"13/07/14\";s:8:\"hora_ses\";s:8:\"10:12:16\";s:12:\"is_logged_in\";b:1;}");
INSERT INTO reg_sessions VALUES("504807b159980a1de4839ef7aee1a67f","127.0.0.1","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36","1405308384","a:5:{s:9:\"user_data\";s:0:\"\";s:11:\"usuario_ses\";s:6:\"eliseo\";s:9:\"fecha_ses\";s:8:\"13/07/14\";s:8:\"hora_ses\";s:8:\"11:26:35\";s:12:\"is_logged_in\";b:1;}");
INSERT INTO reg_sessions VALUES("6cfaa3732d496fe0b550d5fdae6f6059","127.0.0.1","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36","1407077851","");
INSERT INTO reg_sessions VALUES("8c4a8b928957e6bf90bfd2161d2e5380","127.0.0.1","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36","1407202417","");
INSERT INTO reg_sessions VALUES("b51277394c574b5543cd4571f99084ce","127.0.0.1","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36","1407715506","");



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
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

INSERT INTO usuarios VALUES("1","Eliseo","Villca","Luna","2014-06-05","00:10:41","5198738","6","c/ abadesas sn trinidad","eliseosuper","801-50693381-3-22","047f8a46e7c1d5db35f6c9a6607b9fb0","67403185","4298724","eliseo_villca2013@hotmail.com","superadmin","activo","1","","si","si","aceptado","1");
INSERT INTO usuarios VALUES("2","eliseo","Villca","Luna","2014-06-05","00:15:00","5198738","","c/ abadesas sn trinidad","eliseo","801-50693381-3-22","047f8a46e7c1d5db35f6c9a6607b9fb0","674031851","42987242","","usuario","activo","1","2_IMG_20140604_0002.jpg","si","no","aceptado","1");
INSERT INTO usuarios VALUES("3","abigail","cordero","nina","2014-06-05","01:40:40","5607878","6","fasd","abigail","301-50647004-3-72","2da803198df21f216628ff123af67ddd","78979456","","mi@emial.com","admin","activo","1","","si","","aceptado","1");
INSERT INTO usuarios VALUES("4","Ivith","Villca","Luna","2014-06-05","01:48:06","5607878","6","lejos","ivith","301-50647004-3-72","b05f3148fbe5e722b530cbc54bb91e51","78979456","","mi@emial.com","admin","activo","1","","si","","aceptado","1");
INSERT INTO usuarios VALUES("35","Javier Jair","Cussy","Saucedo","2014-06-05","04:14:33","5607607","1","Av Beni pasillo 1 Barrio Hamacas","jair","301-50647004-3-72","f3e089b8b5f571c1ffcda21bcf87e2ed","72822907","","jaironman_jcs@hotmail.com","usuario","activo","2","5_IMG_20140604_0002.jpg","si","","aceptado","1");
INSERT INTO usuarios VALUES("36","yosselin","Cussy","Saucedo","2014-06-05","04:38:54","579864684","1","lejos","yossy","801-50693381-3-22","e1b58751e0d04bd4a1dd58a72050f11d","70272161","","mi@email.com","usuario","activo","35","36_IMG_20140604_0002.jpg","si","","aceptado","1");
INSERT INTO usuarios VALUES("37","carmen abad","cussy","saucedo","2014-06-05","05:13:53","5608789","1","lejos","carmen","201-50694144-3-87","58aac6618ff327e1f905e720675e74d1","72855907","","email@dsf.com","usuario","activo","36","37_ajax-loader.gif","si","","aceptado","1");
INSERT INTO usuarios VALUES("38","irma","saucedo","nuñez","2014-06-05","06:24:56","1733883","1","av. meliton","irma","801-50693381-3-22","87c3b1099e04e21e90a7c308a8b186b3","70271564","","mi@email.com","usuario","activo","37","38_46 90mt.JPG","si","","aceptado","3");
INSERT INTO usuarios VALUES("39","asdf","asdfas","adsf","2014-08-07","01:15:28","12345667","1","adfs","jj","12345678901234","9ec5389ab2ea8b5358bb382a78f3d235","123456","123456","asfda@sdf.com","usuario","activo","2","39_ajax-loader.gif","no","","no","");
INSERT INTO usuarios VALUES("40","yy","yy","yy","2014-08-07","01:17:42","1234567","2","asdf","eliseo12","12345678902345","b3bf0a96877e28ec819161955510b2c4","123456","123456","adaf@asdf.vasd","usuario","activo","2","40_ajax-loader.gif","no","","no","");
INSERT INTO usuarios VALUES("41","asdff","asdfadf","asdfsad","2014-08-07","21:52:54","1234567","6","asdfasd","prueba","12345678901234","fa5a02c9cc183b3ff1bfcd4c2243f85c","1325458","","adsf@adf.com","usuario","activo","2","41_ajax-loader.gif","no","","no","");



