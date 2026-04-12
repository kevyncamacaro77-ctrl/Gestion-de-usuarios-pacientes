<aside class="sidebar">
    <div class="logo-container" style="width: 50px; height: 50px; margin-bottom: 20px;">
        <img src="public/img/logo_hospital.png" alt="+" class="logo" style="max-width: 50%;">
    </div>
    <h2>Menú</h2>
    <nav>
        <a href="index.php?action=dashboard" class="active">Inicio</a>
        
        <?php if($_SESSION['rol'] == 3): // PACIENTE ?>
            <a href="index.php?action=citas">Mis Citas</a>
            <a href="index.php?action=historial">Mi Historial</a>
        <?php endif; ?>

        <?php if($_SESSION['rol'] == 2): // MÉDICO ?>
            <a href="index.php?action=citas_pendientes">Citas Pendientes</a>
            <a href="index.php?action=pacientes">Mis Pacientes</a>
        <?php endif; ?>

        <?php if($_SESSION['rol'] == 1): // ADMIN ?>
            <a href="index.php?action=reportes">Reportes Globales</a>
            <a href="index.php?action=usuarios">Gestionar Personal</a>
        <?php endif; ?>

        <a href="index.php?action=logout" style="color: #ff4d4d; margin-top: 50px;">Cerrar Sesión</a>
    </nav>
</aside>