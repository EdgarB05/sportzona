SET FOREIGN_KEY_CHECKS = 0;



DROP TABLE IF EXISTS `administrador`;

CREATE TABLE `administrador` (
  `idAdministrador` int(11) NOT NULL AUTO_INCREMENT,
  `nombreAdmin` varchar(256) NOT NULL,
  `nomUsuario` varchar(256) NOT NULL,
  `correoUti` varchar(256) NOT NULL,
  `contrasena` varchar(256) NOT NULL,
  `rol` varchar(50) DEFAULT 'admin',
  PRIMARY KEY (`idAdministrador`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `administrador` VALUES("1","Administrador Principal","","admin@sportzona.com","admin123","admin");





DROP TABLE IF EXISTS `avisos`;

CREATE TABLE `avisos` (
  `idAviso` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `audiencia` enum('todos','nuevos','activos','inactivos') DEFAULT 'todos',
  `etiquetas` varchar(500) DEFAULT NULL,
  `nivel` enum('informativo','importante','critico') DEFAULT 'informativo',
  `fecha_envio` datetime DEFAULT NULL,
  `estado` enum('borrador','programado','publicado') DEFAULT 'borrador',
  `idAdministrador` int(11) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`idAviso`),
  KEY `idAdministrador` (`idAdministrador`),
  CONSTRAINT `avisos_ibfk_1` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `avisos` VALUES("3","gfsdf","nknlkn","todos","#mantenimiento","informativo","2025-11-18 13:00:54","publicado","1","2025-11-18 12:41:43");
INSERT INTO `avisos` VALUES("4","Gera 2","zxcxscsdv","todos","#mantenimiento","informativo","2025-11-22 19:21:11","borrador","1","2025-11-21 12:03:11");
INSERT INTO `avisos` VALUES("5","wwww","gdfghfhf","todos","#descuento","informativo","2025-11-22 18:54:03","publicado","1","2025-11-22 18:53:55");
INSERT INTO `avisos` VALUES("6","F1 The Movie","gfjhgvj","todos","#SDFDF","importante","2025-11-24 08:12:02","borrador","1","2025-11-24 08:11:21");





DROP TABLE IF EXISTS `citas`;

CREATE TABLE `citas` (
  `idCita` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `estado` enum('pendiente','confirmada','completada','cancelada') DEFAULT 'pendiente',
  `idNotificadoCoach` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`idCita`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `citas` VALUES("1","7","2025-11-19","10:47:00","visita","cancelada","0");
INSERT INTO `citas` VALUES("2","7","2025-11-19","10:15:00","visita","confirmada","0");
INSERT INTO `citas` VALUES("7","7","2025-11-24","09:43:00","Visita","confirmada","0");
INSERT INTO `citas` VALUES("8","9","2025-11-25","05:48:00","Visita","","0");





DROP TABLE IF EXISTS `coach`;

CREATE TABLE `coach` (
  `idCoach` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(256) NOT NULL,
  `apellidopater` varchar(256) DEFAULT NULL,
  `apellidomater` varchar(256) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `telCoach` varchar(50) DEFAULT NULL,
  `correo` varchar(256) DEFAULT NULL,
  `usuarioAsig` varchar(256) DEFAULT NULL,
  `fechaing` date DEFAULT NULL,
  `contrasena` varchar(256) NOT NULL,
  PRIMARY KEY (`idCoach`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `coach` VALUES("1","Eduardo","Beltran","Garcia","Masculino","777-283-5338","ed@gmail.com","Fitness","2025-11-13","$2y$10$pcLjpkoAcfSWXgs8TfKEXOdzCVvgeUoKccmMdnxFzT929xFx0kjvu");





DROP TABLE IF EXISTS `cuestionario_alimentacion`;

CREATE TABLE `cuestionario_alimentacion` (
  `idCuestionario` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idCoach` int(11) DEFAULT NULL,
  `nombreCompleto` varchar(150) DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `peso` decimal(5,2) DEFAULT NULL,
  `estatura` decimal(4,2) DEFAULT NULL,
  `objetivo` varchar(100) DEFAULT NULL,
  `enfermedades` text DEFAULT NULL,
  `deporte` varchar(100) DEFAULT NULL,
  `diasSemana` int(11) DEFAULT NULL,
  `horasDia` decimal(3,1) DEFAULT NULL,
  `tiempoEjercicio` varchar(100) DEFAULT NULL,
  `horarioGym` varchar(100) DEFAULT NULL,
  `fumaAlcohol` varchar(100) DEFAULT NULL,
  `comidasDia` int(11) DEFAULT NULL,
  `alimentacionHabitos` text DEFAULT NULL,
  `comidasDisponibles` int(11) DEFAULT NULL,
  `alimentosNoGustan` text DEFAULT NULL,
  `alimentosDificilesDejar` text DEFAULT NULL,
  `alimentosDisponibles` text DEFAULT NULL,
  `suplementos` text DEFAULT NULL,
  `horarioSueno` varchar(100) DEFAULT NULL,
  `fechaRegistro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idCuestionario`),
  KEY `idUsuario` (`idUsuario`),
  KEY `cuestionario_alimentacion_fk_coach` (`idCoach`),
  CONSTRAINT `cuestionario_alimentacion_fk_coach` FOREIGN KEY (`idCoach`) REFERENCES `coach` (`idCoach`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `cuestionario_alimentacion_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cuestionario_alimentacion` VALUES("2","5","1","Juan Gaga García","20","80.00","1.80","Aumentar masa muscular","dsfghjkl","Futbol ","5","3.0","2","de 6 de la tarde a 9 de la noche","ninguna","3","fghjklñ","2","ghjkl","el chocolate","fghjklñ","no","me despierto a las 5 y me duermo a las 12","2025-11-10 22:23:54");
INSERT INTO `cuestionario_alimentacion` VALUES("3","2","1","Edgar Eduardo Beltran Garcia","19","60.00","99.99","Aumentar masa muscular","jhgfdfsd","jhgfdd","5","0.0","0","","","0","","0","","","","","","2025-11-17 01:10:46");
INSERT INTO `cuestionario_alimentacion` VALUES("4","1","","Alexandra Beltran Garcia","20","50.00","1.65","Mejorar rendimiento","Ninguna","Natación","4","2.0","","7 am","No","3","sadasddsdads","4","Pollo","ghfdfs","Todos","Ninguno","11 pm - 6 am","2025-11-24 05:19:36");





DROP TABLE IF EXISTS `entrenamiento`;

CREATE TABLE `entrenamiento` (
  `idEntrenamiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRutina` varchar(45) NOT NULL,
  `descripcionEje` varchar(255) DEFAULT NULL,
  `dificultad` varchar(45) DEFAULT NULL,
  `videoURL` varchar(255) DEFAULT NULL,
  `fechaCreacion` date DEFAULT curdate(),
  `idCoach` int(11) DEFAULT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEntrenamiento`),
  KEY `idCoach` (`idCoach`),
  KEY `idUsuario` (`idUsuario`),
  CONSTRAINT `entrenamiento_ibfk_1` FOREIGN KEY (`idCoach`) REFERENCES `coach` (`idCoach`) ON DELETE SET NULL,
  CONSTRAINT `entrenamiento_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `entrenamiento` VALUES("1","Pecho","lagartijas","Media","https://www.shutterstock.com/image-illustration/close-grip-push-up-upper-260nw-2586714299.jpg","2025-11-17","1","0");
INSERT INTO `entrenamiento` VALUES("3","Espalda","dominadas","Media","https://fitcron.com/exercise/dominada-mixta-dorsal/","2025-11-17","1","0");





DROP TABLE IF EXISTS `membresia`;

CREATE TABLE `membresia` (
  `idMembresia` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idTipoMembresia` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `estado` enum('activa','inactiva','vencida','cancelada') NOT NULL DEFAULT 'activa',
  `idAdministrador` int(11) NOT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `fechaActualizacion` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`idMembresia`),
  KEY `fk_membresia_usuario` (`idUsuario`),
  KEY `fk_membresia_tipo` (`idTipoMembresia`),
  KEY `fk_membresia_admin` (`idAdministrador`),
  CONSTRAINT `fk_membresia_admin` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`) ON UPDATE CASCADE,
  CONSTRAINT `fk_membresia_tipo` FOREIGN KEY (`idTipoMembresia`) REFERENCES `tipo_membresia` (`idTipoMembresia`) ON UPDATE CASCADE,
  CONSTRAINT `fk_membresia_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `membresia` VALUES("12","2","1","2025-10-24","2025-11-24","inactiva","1","2025-11-17 23:36:01","2025-11-22 19:52:12");
INSERT INTO `membresia` VALUES("18","7","1","2025-10-23","2025-11-23","vencida","1","2025-11-21 12:05:09","2025-11-24 01:14:13");





DROP TABLE IF EXISTS `promocion`;

CREATE TABLE `promocion` (
  `idPromocion` int(11) NOT NULL AUTO_INCREMENT,
  `nombrePromo` varchar(100) NOT NULL,
  `descripcionPromo` text DEFAULT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaFin` date DEFAULT NULL,
  `estadoAct` enum('borrador','programado','activo','expirado') DEFAULT 'borrador',
  `tipoPromo` enum('descuento','2x1','invitacion','otro') DEFAULT 'descuento',
  `codigoPromo` varchar(45) DEFAULT NULL,
  `etiquetas` varchar(255) DEFAULT NULL,
  `idAdministrador` int(11) DEFAULT NULL,
  `imagenPromo` varchar(255) DEFAULT NULL,
  `fechaCreacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`idPromocion`),
  KEY `idAdministrador` (`idAdministrador`),
  CONSTRAINT `promocion_ibfk_1` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `promocion` VALUES("2","2x1","czxcxzcx","2025-10-28","2025-10-29","activo","2x1","","#descuento","1","","2025-11-09 23:13:18");
INSERT INTO `promocion` VALUES("4","asidasd","axXzxz","2025-10-29","2025-11-04","borrador","2x1","","#descuento","1","","2025-11-09 23:21:40");
INSERT INTO `promocion` VALUES("5","eeeee","cxcxcx","2025-10-27","2025-11-18","activo","invitacion","","#descuento","1","","2025-11-09 23:26:35");





DROP TABLE IF EXISTS `tipo_membresia`;

CREATE TABLE `tipo_membresia` (
  `idTipoMembresia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `duracion_meses` int(11) NOT NULL,
  `incluye_alimentacion` tinyint(1) NOT NULL DEFAULT 0,
  `incluye_entrenamiento` tinyint(1) NOT NULL DEFAULT 0,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idTipoMembresia`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `tipo_membresia` VALUES("1","1 mes","1","0","0","Membresía mensual básica","300.00");
INSERT INTO `tipo_membresia` VALUES("2","2 meses","2","0","0","Membresía de dos meses","550.00");
INSERT INTO `tipo_membresia` VALUES("3","3 meses","3","0","0","Membresía de tres meses","800.00");
INSERT INTO `tipo_membresia` VALUES("4","4 meses","4","0","0","Membresía de cuatro meses","1000.00");
INSERT INTO `tipo_membresia` VALUES("5","Anual","12","0","0","Membresía anual","2500.00");
INSERT INTO `tipo_membresia` VALUES("6","1 mes + Plan de alimentación","1","1","0","Incluye plan de alimentación mensual","400.00");
INSERT INTO `tipo_membresia` VALUES("7","1 mes + Plan de entrenamiento","1","0","1","Incluye plan de entrenamiento mensual","300.00");
INSERT INTO `tipo_membresia` VALUES("8","1 mes + Alimentación y Entrenamiento","1","1","1","Plan completo mensual","500.00");
INSERT INTO `tipo_membresia` VALUES("9","Anual + Alimentación y Entrenamiento","12","1","1","Plan completo anual","3500.00");





DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(256) NOT NULL,
  `apePa` varchar(256) DEFAULT NULL,
  `apeMa` varchar(256) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `correo` varchar(256) NOT NULL,
  `contrasena` varchar(256) NOT NULL,
  `fechaRegi` date DEFAULT curdate(),
  `rol` enum('admin','entrenador','cliente') DEFAULT 'cliente',
  `idMembresia` int(11) DEFAULT NULL,
  `idAdministrador` int(11) DEFAULT NULL,
  `idCoach` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `correo` (`correo`),
  KEY `idAdministrador` (`idAdministrador`),
  KEY `fk_usuario_entrenador` (`idCoach`),
  CONSTRAINT `fk_usuario_entrenador` FOREIGN KEY (`idCoach`) REFERENCES `coach` (`idCoach`) ON DELETE SET NULL,
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idAdministrador`) REFERENCES `administrador` (`idAdministrador`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` VALUES("1","Alexandra","Beltran","Garcia","Femenino","777-283-5338","alex@gmail.com","$2y$10$rwGrh1DhsmRaQUuDX/vdWubKYX0uf3TI.R67BN2bWQwG9o8k/S3HK","2025-11-09","cliente","0","0","0");
INSERT INTO `usuarios` VALUES("2","Edgar","Beltran","Garcia","Masculino","777-283-5338","EdBeltran@gmail.com","$2y$10$zRY97gjo4hlSkK5rn1gnS.tmWUgpL9C6VNShI0s55bHyWFkdGbFam","2025-11-09","cliente","0","0","0");
INSERT INTO `usuarios` VALUES("3","Eduardo","Garcia","Garcia","Masculino","777-283-5338","edu@gmail.com","$2y$10$5sQGvwcmXImv3eTnhbn7Ru07gAmxMFUFz/yuK19qmnV7FdCEtHG1C","2025-11-09","cliente","0","0","0");
INSERT INTO `usuarios` VALUES("4","Juan","Beltran","Garcia","Masculino","777-526-9602","juan@gmail.com","$2y$10$.ubHf6eUtR1QnCrwTPUHy.cYeBL2J59teGVe0Ds2BZmfn03l.MalS","2025-11-10","cliente","0","0","0");
INSERT INTO `usuarios` VALUES("5","Juan","Gaga","Garcia","Masculino","777-526-9602","juan34@gmail.com","$2y$10$ti91RQbg6zhJYshYzagwHeiTI.e7a2y/uYlv51mbL8fBNrS.Vb5fy","2025-11-10","cliente","0","0","0");
INSERT INTO `usuarios` VALUES("7","Edgar Eduardo","Beltran","Garcia","Masculino","777-283-5338","misalalobg@gmail.com","$2y$10$oBUiEOLzB.6LxeSwjWULwePfPZMjj9mKfBFc1/fFk5BhNYqOhuX/u","2025-11-18","cliente","0","0","0");
INSERT INTO `usuarios` VALUES("9","Yesenia","Garcia","Sotelo","Femenino","777-283-5338","ndrusian1123@gmail.com","$2y$10$oZnNCY21yx2xnctgqA9ZrO0cZUGpKbykkTEj6mqoznU0FkZN5hsde","2025-11-22","cliente","0","0","0");



SET FOREIGN_KEY_CHECKS = 1;
