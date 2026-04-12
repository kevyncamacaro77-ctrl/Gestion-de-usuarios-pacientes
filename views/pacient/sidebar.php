<aside class="sidebar">
    <div class="logo-container">
        <img src="/Gestion_medica/public/img/logo_hospital.png" alt="Logo" class="sidebar-logo">
    </div>
    
    <h2 class="sidebar-title">Menú</h2>
    
    <nav class="sidebar-nav">
    <a href="index.php?action=dashboard" class="nav-link <?= (!isset($_GET['action']) || $_GET['action'] == 'dashboard') ? 'active' : '' ?>">
        <i class="fas fa-home"></i> Inicio
    </a>
    
    <?php if($_SESSION['rol'] == 3): ?>
        <a href="index.php?action=citas" class="nav-link <?= ($_GET['action'] == 'citas') ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt"></i> Mis Citas
        </a>
        
        <a href="index.php?action=historial" class="nav-link <?= ($_GET['action'] == 'historial') ? 'active' : '' ?>">
            <i class="fas fa-file-medical"></i> Mi Historial
        </a>
    <?php endif; ?>

    <a href="index.php?action=logout" class="nav-link logout-link">
        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
    </a>
</nav>
</aside>