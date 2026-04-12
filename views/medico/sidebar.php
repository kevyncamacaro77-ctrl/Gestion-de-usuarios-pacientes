<?php
// Validamos que no se acceda directamente al archivo
if (!isset($_SESSION['rol'])) {
    header("Location: index.php?action=login");
    exit();
}
?>

<aside class="sidebar-medico">
    
    <div class="sidebar-logo">
        <h2>MÉDICO</h2>
        <p>Clínica Adventista</p>
    </div>

    <nav class="sidebar-nav">
        <ul>
            <li>
                <a href="index.php?action=dashboard">
                    <span>🏠</span> Inicio
                </a>
            </li>
            
            <li>
                <a href="index.php?action=gestionar_disponibilidad">
                    <span>📅</span> Mi Disponibilidad
                </a>
            </li>

            <li>
                <a href="index.php?action=citas_medico">
                    <span>📋</span> Citas Pendientes
                </a>
            </li>

            <li>
                <a href="index.php?action=mis_pacientes">
                    <span>👥</span> Mis Pacientes
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="index.php?action=logout" class="btn-logout">
            <span>🚪</span> Cerrar Sesión
        </a>
    </div>
</aside>