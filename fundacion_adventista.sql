-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2026 at 11:38 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fundacion_adventista`
--

-- --------------------------------------------------------

--
-- Table structure for table `cita`
--

CREATE TABLE `cita` (
  `id_cita` int NOT NULL,
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  `motivo` varchar(200) DEFAULT NULL,
  `idpaciente` int NOT NULL,
  `id_disponibilidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `consulta`
--

CREATE TABLE `consulta` (
  `idConsulta` int NOT NULL,
  `fecha` datetime NOT NULL,
  `motivo` varchar(100) DEFAULT NULL,
  `diagnostico` varchar(455) DEFAULT NULL,
  `recomendaciones` varchar(455) DEFAULT NULL,
  `medico_idmedico` int NOT NULL,
  `paciente_idpaciente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `disponibilidad`
--

CREATE TABLE `disponibilidad` (
  `id_disponibilidad` int NOT NULL,
  `fecha` date NOT NULL,
  `horainicio` time NOT NULL,
  `horafin` time NOT NULL,
  `estatus` varchar(45) DEFAULT 'Disponible',
  `idmedico` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `especialidad`
--

CREATE TABLE `especialidad` (
  `id_especialidad` int NOT NULL,
  `nombre_especialidad` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `examenes`
--

CREATE TABLE `examenes` (
  `idexamen` int NOT NULL,
  `nombre_examen` varchar(100) NOT NULL,
  `lado_ojo` varchar(50) DEFAULT NULL,
  `resultado` varchar(255) DEFAULT NULL,
  `observaciones` text,
  `Consulta_idConsulta` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `medico`
--

CREATE TABLE `medico` (
  `idmedico` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `nro_colegiatura` varchar(25) NOT NULL,
  `Usuario_id_usuario` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `medico_especialidad`
--

CREATE TABLE `medico_especialidad` (
  `medico_idmedico` int NOT NULL,
  `Especialidad_id_especialidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `idpaciente` int NOT NULL,
  `Usuario_id_usuario` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `tipo_sangre` varchar(5) DEFAULT NULL,
  `antecedentes` varchar(255) DEFAULT NULL,
  `correo` varchar(45) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `alergias` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `paciente`
--

INSERT INTO `paciente` (`idpaciente`, `Usuario_id_usuario`, `nombre`, `apellido`, `cedula`, `tipo_sangre`, `antecedentes`, `correo`, `telefono`, `direccion`, `alergias`) VALUES
(1, 1, 'pepe', 'pipi', '12345', NULL, NULL, 'pepe@gmail.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `procedimiento`
--

CREATE TABLE `procedimiento` (
  `idProcedimiento` int NOT NULL,
  `Consulta_idConsulta` int NOT NULL,
  `nota_medica` varchar(500) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `id_rol` int DEFAULT '3' COMMENT '1:Admin, 2:Medico, 3:Paciente, 4:Secretaria'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `contrasena`, `id_rol`) VALUES
(1, 'pepe', '$2y$10$DysotLuv5KTW07cOxM0LBeCe.5vw6WYx.N/xbPMgsxsy0grQ8/scW', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `fk_cita_paciente` (`idpaciente`),
  ADD KEY `fk_cita_disponibilidad` (`id_disponibilidad`);

--
-- Indexes for table `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`idConsulta`),
  ADD KEY `fk_Consulta_medico` (`medico_idmedico`),
  ADD KEY `fk_Consulta_paciente` (`paciente_idpaciente`);

--
-- Indexes for table `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD PRIMARY KEY (`id_disponibilidad`),
  ADD KEY `fk_Disponibilidad_medico` (`idmedico`);

--
-- Indexes for table `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indexes for table `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`idexamen`),
  ADD KEY `fk_Examenes_Consulta` (`Consulta_idConsulta`);

--
-- Indexes for table `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`idmedico`),
  ADD UNIQUE KEY `nro_colegiatura` (`nro_colegiatura`),
  ADD KEY `fk_medico_Usuario` (`Usuario_id_usuario`);

--
-- Indexes for table `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD PRIMARY KEY (`medico_idmedico`,`Especialidad_id_especialidad`),
  ADD KEY `fk_me_especialidad` (`Especialidad_id_especialidad`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idpaciente`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_paciente_Usuario` (`Usuario_id_usuario`);

--
-- Indexes for table `procedimiento`
--
ALTER TABLE `procedimiento`
  ADD PRIMARY KEY (`idProcedimiento`),
  ADD KEY `fk_Procedimiento_Consulta` (`Consulta_idConsulta`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consulta`
--
ALTER TABLE `consulta`
  MODIFY `idConsulta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `disponibilidad`
--
ALTER TABLE `disponibilidad`
  MODIFY `id_disponibilidad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id_especialidad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examenes`
--
ALTER TABLE `examenes`
  MODIFY `idexamen` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medico`
--
ALTER TABLE `medico`
  MODIFY `idmedico` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paciente`
--
ALTER TABLE `paciente`
  MODIFY `idpaciente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `procedimiento`
--
ALTER TABLE `procedimiento`
  MODIFY `idProcedimiento` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_disponibilidad` FOREIGN KEY (`id_disponibilidad`) REFERENCES `disponibilidad` (`id_disponibilidad`),
  ADD CONSTRAINT `fk_cita_paciente` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`);

--
-- Constraints for table `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `fk_Consulta_medico` FOREIGN KEY (`medico_idmedico`) REFERENCES `medico` (`idmedico`),
  ADD CONSTRAINT `fk_Consulta_paciente` FOREIGN KEY (`paciente_idpaciente`) REFERENCES `paciente` (`idpaciente`);

--
-- Constraints for table `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD CONSTRAINT `fk_Disponibilidad_medico` FOREIGN KEY (`idmedico`) REFERENCES `medico` (`idmedico`);

--
-- Constraints for table `examenes`
--
ALTER TABLE `examenes`
  ADD CONSTRAINT `fk_Examenes_Consulta` FOREIGN KEY (`Consulta_idConsulta`) REFERENCES `consulta` (`idConsulta`);

--
-- Constraints for table `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `fk_medico_Usuario` FOREIGN KEY (`Usuario_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Constraints for table `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD CONSTRAINT `fk_me_especialidad` FOREIGN KEY (`Especialidad_id_especialidad`) REFERENCES `especialidad` (`id_especialidad`),
  ADD CONSTRAINT `fk_me_medico` FOREIGN KEY (`medico_idmedico`) REFERENCES `medico` (`idmedico`);

--
-- Constraints for table `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `fk_paciente_Usuario` FOREIGN KEY (`Usuario_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Constraints for table `procedimiento`
--
ALTER TABLE `procedimiento`
  ADD CONSTRAINT `fk_Procedimiento_Consulta` FOREIGN KEY (`Consulta_idConsulta`) REFERENCES `consulta` (`idConsulta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
