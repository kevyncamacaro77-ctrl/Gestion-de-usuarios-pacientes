<?php
// Seguridad: Si no es secretaria (Rol 2), lo mandamos al login
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 2) {
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
            <h4 style="margin-top: 10px;">Staff: <br><?php echo $_SESSION['usuario']; ?></h4>
        </div>
        <nav class="nav-menu">
            <a href="index.php?view=recepcion" class="nav-link"><i class="fas fa-concierge-bell"></i> Recepción</a>
            <a href="index.php?view=citas_general" class="nav-link"><i class="fas fa-calendar-alt"></i> Todas las Citas</a>
            <a href="index.php?view=registro_paciente" class="nav-link"><i class="fas fa-user-plus"></i> Nuevo Paciente</a>
            <hr style="opacity: 0.2; margin: 20px 0;">
            <a href="index.php?action=logout" class="nav-link btn-logout"><i class="fas fa-sign-out-alt"></i> Salir</a>
        </nav>
    </div>

    <div class="main-content">
        <div class="welcome-container">
            <h1>Panel de <span style="color: #00d2ff;">Recepción</span></h1>
            <p>Gestión de admisiones y coordinación de turnos.</p>
        </div>

        <div class="card-grid">
            <a href="index.php?view=agendar_llamada" class="action-card">
                <i class="fa-solid fa-phone-volume"></i>
                <h3>Agendar Cita</h3>
                <p>Asignar turnos a pacientes que llaman por teléfono.</p>
            </a>
            <a href="index.php?view=lista_espera" class="action-card">
                <i class="fa-solid fa-list-ol"></i>
                <h3>Lista de Espera</h3>
                <p>Monitorear pacientes presentes en la clínica.</p>
            </a>
        </div>
    </div>
</div>
</body>
</html>