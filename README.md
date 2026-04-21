# 🏥 Sistema de Gestión de Registro de Pacientes (SGRP) - Área de Oftalmología
## 🏛️ Fundación Hospital Adventista de Venezuela

![Estatus del Proyecto](https://img.shields.io/badge/Estatus-Desarrollo%20Activo-green?style=for-the-badge)
![Licencia](https://img.shields.io/badge/Licencia-Acad%C3%A9mica-orange?style=for-the-badge)
![IUJO](https://img.shields.io/badge/Instituci%C3%B3n-IUJO%20Lara-blue?style=for-the-badge)

Este proyecto nace como una solución tecnológica para la **Fundación Hospital Adventista de Venezuela**, específicamente para el área de **Oftalmología**. El objetivo es digitalizar y automatizar el control de pacientes, agendas médicas y resultados técnicos de exámenes oculares.

---

## 📖 Tabla de Contenidos
1. [Sobre el Proyecto](#-sobre-el-proyecto)
2. [Problemática Solucionada](#-problemática-solucionada)
3. [Características Técnicas](#-características-técnicas)
4. [Arquitectura de Datos](#-arquitectura-de-datos)
5. [Instalación](#-instalación)
6. [Guía de Uso](#-guía-de-uso)

---

## 🧐 Sobre el Proyecto
El sistema permite gestionar de manera eficiente el flujo de atención médica. A diferencia de un registro de pacientes común, este software incluye módulos especializados para la toma de medidas de agudeza visual y diagnósticos específicos para **Ojo Derecho (OD)** y **Ojo Izquierdo (OI)**, integrando la gestión administrativa con la clínica.

### 🎯 Objetivos:
- **Centralizar** la información de los pacientes.
- **Optimizar** el tiempo de respuesta en la asignación de citas.
- **Garantizar** la integridad de los antecedentes médicos.

---

## ⚠️ Problemática Solucionada
Antes de este sistema, la fundación presentaba:
- ❌ **Desconexión:** El agendamiento se realizaba de forma manual o aislada.
- ❌ **Extravío de Información:** Los antecedentes médicos en papel eran difíciles de rastrear.
- ❌ **Ineficiencia en Reportes:** Generar estadísticas de atención tomaba días de trabajo manual.

---

## 🛠️ Características Técnicas
El sistema está construido con un enfoque **Nativo** para asegurar el máximo rendimiento y control sobre el código:

- **Backend:** PHP 7.4+ (Lógica de servidor).
- **Base de Datos:** MySQL (Motor relacional).
- **Frontend:** HTML5, JavaScript y CSS3 con estética **Dark Mode / Tech**.
- **Seguridad:** Manejo de sesiones y roles de usuario (Admin, Médico, Paciente).

---

## 🗄️ Arquitectura de Datos
La base de datos `fundacion_adventista` consta de **15 tablas normalizadas** (3ra Forma Normal) para evitar la duplicidad de información:

- **Módulo de Usuarios:** Control de accesos y roles.
- **Módulo de Pacientes:** Datos demográficos y antecedentes (Alergias, tipo de sangre, familiares).
- **Módulo de Agenda:** Gestión de días de la semana y horarios de disponibilidad médica.
- **Módulo Clínico:** Registro de consultas, evolución, procedimientos y el detalle técnico de exámenes oftalmológicos.

---

## 📥 Instalación

Si deseas probar el proyecto localmente, sigue estos pasos:

1. **Requisitos:** Tener instalado [Laragon](https://laragon.org/) o XAMPP.
2. **Clonar:** ```bash
   git clone [https://github.com/kevyncamacaro77-ctrl/Gestion-de-usuarios-pacientes.git](https://github.com/kevyncamacaro77-ctrl/Gestion-de-usuarios-pacientes.git)
