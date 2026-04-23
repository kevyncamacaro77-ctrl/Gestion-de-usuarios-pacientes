<?php
// Seguridad: Si no es administrador (Rol 1), lo mandamos al login
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header("Location: index.php?view=login");
    exit();
}

$especialidades = $this->especialidadModel->obtenerTodas();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo - Gestión Médica</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/layout.css">
    <link rel="stylesheet" href="public/css/admin.css">
</head>

<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div style="text-align: center; margin-bottom: 40px;">
                <img src="public/img/logo_hospital.webp" width="80" alt="Logo">
                <h4 style="margin-top: 10px;">Admin: <br><?php echo $_SESSION['usuario']; ?></h4>
            </div>
            <nav class="nav-menu">
                <a href="index.php?view=dashboard_admin" class="nav-link"><i class="fas fa-chart-pie"></i> Estadísticas</a>
                <a href="index.php?view=gestion_usuarios" class="nav-link"><i class="fas fa-users-cog"></i> Gestión Usuarios</a>
                <a href="index.php?view=reportes" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Reportes</a>
                <hr style="opacity: 0.2; margin: 20px 0;">
                <a href="index.php?action=logout" class="nav-link btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            </nav>
        </div>

        <div class="main-content">
            <div class="welcome-container">
                <h1>Panel de <span style="color: #00d2ff;">Control</span></h1>
                <p>Bienvenido al sistema de gestión administrativa.</p>
            </div>

            <h3 style="margin-bottom: 20px; font-weight: 500;">Citas por Especialidad</h3>
                <div class="card-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); margin-bottom: 40px;">
                    <?php foreach ($especialidades as $esp): ?>
                        <div class="stat-card">
                            <i class="fas fa-stethoscope"></i> <span class="stat-number">
                                <?php echo $esp['total_citas'] ?? '0'; ?>
                            </span>
                            <p><?php echo $esp['nombre_especialidad']; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

            <h3 style="margin-bottom: 20px; font-weight: 500;">Operaciones del Sistema</h3>
            <div class="card-grid">
                <a href="index.php?view=gestion_usuarios" class="action-card">
                    <i class="fa-solid fa-user-gear"></i>
                    <h3>CRUD Usuarios</h3>
                    <p>Administrar cuentas de Médicos, Secretarias y Pacientes.</p>
                </a>

                <a href="index.php?view=configuracion_sistema" class="action-card">
                    <i class="fa-solid fa-gears"></i>
                    <h3>Configuración</h3>
                    <p>Ajustes generales de la Fundación y parámetros del sistema.</p>
                </a>

                <a href="index.php?view=auditoria" class="action-card">
                    <i class="fa-solid fa-list-check"></i>
                    <h3>Auditoría</h3>
                    <p>Ver registros de actividad (Logs) de todos los usuarios.</p>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
