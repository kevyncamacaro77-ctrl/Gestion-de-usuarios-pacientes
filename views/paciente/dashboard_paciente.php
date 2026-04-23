<?php
// Seguridad: Si no es paciente, lo mandamos al login
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 4) {
    header("Location: index.php?view=login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel del Paciente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/layout.css">
    <link rel="stylesheet" href="public/css/paciente.css">
</head>

<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div style="text-align: center; margin-bottom: 40px;">
                <img src="public/img/logo_hospital.webp" width="80" alt="Logo">
                <h4 style="margin-top: 10px;">Bienvenido,<br><?php echo $_SESSION['usuario']; ?></h4>
            </div>
            <nav>
                <a href="#" class="nav-link" style="color: white; display: block; padding: 10px 0;"><i class="fas fa-home"></i> Inicio</a>
                <a href="#" class="nav-link" style="color: white; display: block; padding: 10px 0;"><i class="fas fa-calendar-alt"></i> Mis Citas</a>
                <a href="#" class="nav-link" style="color: white; display: block; padding: 10px 0;"><i class="fas fa-file-medical"></i> Resultados</a>
                <hr style="opacity: 0.2; margin: 20px 0;">
                <a href="index.php?action=logout" style="color: #ff4d4d; text-decoration: none;"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            </nav>
        </div>

        <div class="main-content">
            <div class="welcome-container">
                <h1>Hola, <span class="text-cyan"><?php echo $_SESSION['usuario']; ?></span></h1>
                <p>¿Qué desea hacer hoy?</p>
            </div>
            <div class="card-grid">
                <a href="index.php?view=agendar_cita" class="action-card">
                    <i class="fa-solid fa-calendar-plus"></i> <h3>Agendar Cita</h3>
                    <p>Solicite una nueva cita médica con nuestros especialistas.</p>
                </a>

                <a href="index.php?view=ver_citas" class="action-card">
                    <i class="fa-solid fa-file-waveform"></i> <h3>Mis Consultas</h3>
                    <p>Revise el historial y estado de sus citas agendadas.</p>
                </a>

                <a href="index.php?view=mi_perfil" class="action-card">
                    <i class="fa-solid fa-hospital-user"></i> <h3>Ficha Médica</h3>
                    <p>Consulte sus antecedentes, alergias y tipo de sangre.</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>