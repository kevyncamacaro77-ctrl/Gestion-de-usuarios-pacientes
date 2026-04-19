-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 19, 2026 at 07:08 PM
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
  `id_disponibilidad` int NOT NULL,
  `idEstado_cita` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `consulta`
--

CREATE TABLE `consulta` (
  `idConsulta` int NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `motivo` varchar(100) DEFAULT NULL,
  `diagnostico` text,
  `recomendaciones` text,
  `idmedico` int NOT NULL,
  `idpaciente` int NOT NULL,
  `idEstado_Consulta` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `dia_semana`
--

CREATE TABLE `dia_semana` (
  `id_dia_semana` int NOT NULL,
  `dia_semana` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `disponibilidad`
--

CREATE TABLE `disponibilidad` (
  `id_disponibilidad` int NOT NULL,
  `fecha` date DEFAULT NULL,
  `horainicio` time DEFAULT NULL,
  `horafin` time DEFAULT NULL,
  `estatus` varchar(45) DEFAULT 'Disponible',
  `idmedico` int NOT NULL,
  `id_dia_semana` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `especialidad`
--

CREATE TABLE `especialidad` (
  `id_especialidad` int NOT NULL,
  `nombre_especialidad` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `estado_cita`
--

CREATE TABLE `estado_cita` (
  `idEstado_cita` int NOT NULL,
  `Pendiente` varchar(2) DEFAULT 'Si',
  `Cancelada` varchar(2) DEFAULT 'No',
  `Finalizada` varchar(2) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `estado_consulta`
--

CREATE TABLE `estado_consulta` (
  `idEstado_Consulta` int NOT NULL,
  `Emergencia` varchar(2) DEFAULT 'No',
  `Cita_Previa` varchar(2) DEFAULT 'Si'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `estado_paciente`
--

CREATE TABLE `estado_paciente` (
  `idEstado_paciente` int NOT NULL,
  `tipo_sangre` varchar(5) DEFAULT NULL,
  `antecedentes_personales` text,
  `alergias` text,
  `antecedentes_familiares` text,
  `habitos_psicobiologicos` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `examenes`
--

CREATE TABLE `examenes` (
  `idexamen` int NOT NULL,
  `nombre_examen` varchar(100) DEFAULT NULL,
  `lado_ojo` varchar(255) DEFAULT NULL,
  `resultado` varchar(255) DEFAULT NULL,
  `observaciones` text,
  `idConsulta` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `medico`
--

CREATE TABLE `medico` (
  `idmedico` int NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `nro_colegiatura` varchar(25) DEFAULT NULL,
  `id_usuario` int NOT NULL,
  `telefono` varchar(25) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `medico_especialidad`
--

CREATE TABLE `medico_especialidad` (
  `idmedico` int NOT NULL,
  `id_especialidad` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `paciente`
--

CREATE TABLE `paciente` (
  `idpaciente` int NOT NULL,
  `id_usuario` int NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `cedula` varchar(15) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `telefono` varchar(25) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `idEstado_paciente` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `procedimiento`
--

CREATE TABLE `procedimiento` (
  `idProcedimiento` int NOT NULL,
  `idConsulta` int NOT NULL,
  `nota_medica` text,
  `fecha` datetime DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `idrol` int NOT NULL,
  `nombre_rol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `idrol` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `fk_cita_paciente` (`idpaciente`),
  ADD KEY `fk_cita_Disponibilidad1` (`id_disponibilidad`),
  ADD KEY `fk_cita_Estado_cita1` (`idEstado_cita`);

--
-- Indexes for table `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`idConsulta`),
  ADD KEY `fk_Consulta_medico1` (`idmedico`),
  ADD KEY `fk_Consulta_paciente1` (`idpaciente`),
  ADD KEY `fk_Consulta_Estado_Consulta1` (`idEstado_Consulta`);

--
-- Indexes for table `dia_semana`
--
ALTER TABLE `dia_semana`
  ADD PRIMARY KEY (`id_dia_semana`);

--
-- Indexes for table `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD PRIMARY KEY (`id_disponibilidad`),
  ADD KEY `fk_Disponibilidad_medico2` (`idmedico`),
  ADD KEY `fk_Disponibilidad_dia_semana1` (`id_dia_semana`);

--
-- Indexes for table `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id_especialidad`);

--
-- Indexes for table `estado_cita`
--
ALTER TABLE `estado_cita`
  ADD PRIMARY KEY (`idEstado_cita`);

--
-- Indexes for table `estado_consulta`
--
ALTER TABLE `estado_consulta`
  ADD PRIMARY KEY (`idEstado_Consulta`);

--
-- Indexes for table `estado_paciente`
--
ALTER TABLE `estado_paciente`
  ADD PRIMARY KEY (`idEstado_paciente`);

--
-- Indexes for table `examenes`
--
ALTER TABLE `examenes`
  ADD PRIMARY KEY (`idexamen`),
  ADD KEY `fk_Examenes_Consulta1` (`idConsulta`);

--
-- Indexes for table `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`idmedico`),
  ADD KEY `fk_medico_Usuario1` (`id_usuario`);

--
-- Indexes for table `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD PRIMARY KEY (`idmedico`,`id_especialidad`),
  ADD KEY `fk_medico_especialidad_Especialidad1` (`id_especialidad`);

--
-- Indexes for table `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`idpaciente`),
  ADD KEY `fk_paciente_Usuario1` (`id_usuario`),
  ADD KEY `fk_paciente_Estado_paciente1` (`idEstado_paciente`);

--
-- Indexes for table `procedimiento`
--
ALTER TABLE `procedimiento`
  ADD PRIMARY KEY (`idProcedimiento`),
  ADD KEY `fk_Procedimiento_Consulta1` (`idConsulta`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idrol`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_Usuario_rol1` (`idrol`);

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
-- AUTO_INCREMENT for table `dia_semana`
--
ALTER TABLE `dia_semana`
  MODIFY `id_dia_semana` int NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `estado_cita`
--
ALTER TABLE `estado_cita`
  MODIFY `idEstado_cita` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estado_consulta`
--
ALTER TABLE `estado_consulta`
  MODIFY `idEstado_Consulta` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `estado_paciente`
--
ALTER TABLE `estado_paciente`
  MODIFY `idEstado_paciente` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `idpaciente` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `procedimiento`
--
ALTER TABLE `procedimiento`
  MODIFY `idProcedimiento` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `idrol` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `fk_cita_Disponibilidad1` FOREIGN KEY (`id_disponibilidad`) REFERENCES `disponibilidad` (`id_disponibilidad`),
  ADD CONSTRAINT `fk_cita_Estado_cita1` FOREIGN KEY (`idEstado_cita`) REFERENCES `estado_cita` (`idEstado_cita`),
  ADD CONSTRAINT `fk_cita_paciente` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`);

--
-- Constraints for table `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `fk_Consulta_Estado_Consulta1` FOREIGN KEY (`idEstado_Consulta`) REFERENCES `estado_consulta` (`idEstado_Consulta`),
  ADD CONSTRAINT `fk_Consulta_medico1` FOREIGN KEY (`idmedico`) REFERENCES `medico` (`idmedico`),
  ADD CONSTRAINT `fk_Consulta_paciente1` FOREIGN KEY (`idpaciente`) REFERENCES `paciente` (`idpaciente`);

--
-- Constraints for table `disponibilidad`
--
ALTER TABLE `disponibilidad`
  ADD CONSTRAINT `fk_Disponibilidad_dia_semana1` FOREIGN KEY (`id_dia_semana`) REFERENCES `dia_semana` (`id_dia_semana`),
  ADD CONSTRAINT `fk_Disponibilidad_medico2` FOREIGN KEY (`idmedico`) REFERENCES `medico` (`idmedico`);

--
-- Constraints for table `examenes`
--
ALTER TABLE `examenes`
  ADD CONSTRAINT `fk_Examenes_Consulta1` FOREIGN KEY (`idConsulta`) REFERENCES `consulta` (`idConsulta`);

--
-- Constraints for table `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `fk_medico_Usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `medico_especialidad`
--
ALTER TABLE `medico_especialidad`
  ADD CONSTRAINT `fk_medico_especialidad_Especialidad1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`id_especialidad`),
  ADD CONSTRAINT `fk_medico_especialidad_medico1` FOREIGN KEY (`idmedico`) REFERENCES `medico` (`idmedico`);

--
-- Constraints for table `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `fk_paciente_Estado_paciente1` FOREIGN KEY (`idEstado_paciente`) REFERENCES `estado_paciente` (`idEstado_paciente`),
  ADD CONSTRAINT `fk_paciente_Usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `procedimiento`
--
ALTER TABLE `procedimiento`
  ADD CONSTRAINT `fk_Procedimiento_Consulta1` FOREIGN KEY (`idConsulta`) REFERENCES `consulta` (`idConsulta`);

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_Usuario_rol1` FOREIGN KEY (`idrol`) REFERENCES `rol` (`idrol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
