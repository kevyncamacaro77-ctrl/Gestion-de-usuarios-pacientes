<?php
// views/layouts/sidebar.php
$rol = $_SESSION['rol'] ?? '';
?>
<aside class="main-sidebar">
    <nav class="menu">
        <ul>
            <li><a href="index.php?view=dashboard">🏠 Inicio</a></li>

            <?php if ($_SESSION['rol'] == 1): // Usamos el ID 1 para Administrador ?>
                <li>
                    <a href="index.php?view=gestion_usuarios">
                        <i class="fas fa-users-cog"></i>👥 Gestión de Usuarios
                    </a>
                </li>
                <li>
                    <a href="index.php?view=especialidades">
                        <i class="fas fa-stethoscope"></i> 👁️ Especialidades
                    </a>
                </li>
                <li>
                    <a href="index.php?view=reportes">
                        <i class="fas fa-file-invoice-dollar"></i> 📊 Reportes Globales
                    </a>
                </li>
                <li>
                    <a href="index.php?view=agenda_global">
                        <i class="fas fa-calendar-alt"></i> 📅 Calendario General
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($rol == 'Medico'): ?>
                <li><a href="index.php?view=mi_agenda">📅 Mi Agenda</a></li>
                <li><a href="index.php?view=nueva_consulta">🩺 Nueva Consulta</a></li>
                <li><a href="index.php?view=pacientes_atendidos">👤 Mis Pacientes</a></li>
                <li><a href="index.php?view=disponibilidad">⏰ Mi Horario</a></li>
            <?php endif; ?>

            <?php if ($rol == 'Secretaria'): ?>
                <li><a href="index.php?view=gestion_citas">📅 Citas del Día</a></li>
                <li><a href="index.php?view=registrar_paciente">📝 Registrar Paciente</a></li>
                <li><a href="index.php?view=estadisticas">📈 Estadísticas y Porcentajes</a></li>
            <?php endif; ?>

            <?php if ($rol == 'Paciente'): ?>
                <li><a href="index.php?view=agendar_cita">📅 Agendar Cita</a></li>
                <li><a href="index.php?view=mis_consultas">📜 Mi Historial Médico</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</aside>