<?php
// Seguridad: Si no es medico (Rol 3), lo mandamos al login
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 3) {
    header("Location: index.php?view=login");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel Médico - Gestión Médica</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/layout.css">
    <link rel="stylesheet" href="public/css/admin.css">
</head>
<body>
<div class="dashboard-container">
    <div class="sidebar">
        <div style="text-align: center; margin-bottom: 40px;">
            <img src="public/img/logo_hospital.webp" width="80" alt="Logo">
            <h4 style="margin-top: 10px;">Dr. <?php echo $_SESSION['usuario']; ?></h4>
        </div>
        <nav class="nav-menu">
            <a href="index.php?view=agenda_hoy" class="nav-link"><i class="fas fa-calendar-day"></i> Agenda Hoy</a>
            <a href="index.php?view=mis_pacientes" class="nav-link"><i class="fas fa-user-injured"></i> Mis Pacientes</a>
            <a href="index.php?view=historial_clinico" class="nav-link"><i class="fas fa-notes-medical"></i> Historiales</a>
            <hr style="opacity: 0.2; margin: 20px 0;">
            <a href="index.php?action=logout" class="nav-link btn-logout"><i class="fas fa-sign-out-alt"></i> Salir</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="welcome-container">
            <h1>Panel <span style="color: #00d2ff;">Médico</span></h1>
            <p>Gestión de consultas y seguimiento de pacientes.</p>
        </div>

        <div class="card-grid">
            <a href="index.php?view=agenda_hoy" class="action-card">
                <i class="fa-solid fa-clock"></i>
                <h3>Citas Pendientes</h3>
                <p>Usted tiene <strong>5</strong> citas programadas para hoy.</p>
            </a>
            <a href="index.php?view=mis_horarios" class="action-card">
                <i class="fa-solid fa-calendar-check"></i>
                <h3>Mis Horarios</h3>
                <p>Configurar disponibilidad y bloqueos de agenda.</p>
            </a>
        </div>
    </div>
</div>
</body>
</html>