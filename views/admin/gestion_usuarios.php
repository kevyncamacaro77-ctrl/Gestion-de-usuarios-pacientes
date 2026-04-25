<?php
// Procesar la actualización de estado si se envía el formulario
if (isset($_POST['btn_actualizar_estado'])) {
    $idU = $_POST['id_usuario'];
    $idE = $_POST['nuevo_estado'];
    
    if ($adminModel->actualizarEstadoUsuario($idU, $idE)) {
        echo "<script>alert('Estado actualizado correctamente'); window.location='index.php?view=gestion_usuarios';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Admin</title>
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
                <a href="index.php?view=gestion_usuarios" class="nav-link active"><i class="fas fa-users-cog"></i> Gestión Usuarios</a>
                <a href="index.php?view=reportes" class="nav-link"><i class="fas fa-file-invoice-dollar"></i> Reportes</a>
                <hr style="opacity: 0.2; margin: 20px 0;">
                <a href="index.php?action=logout" class="nav-link btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            </nav>
        </div>

       <div class="main-content">
            <div class="welcome-container">
                <h1>Gestión de <span style="color: #00d2ff;">Usuarios</span></h1>
                <p>Control de acceso y estados de cuenta del personal y pacientes.</p>
            </div>
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert-wrapper" style="margin-bottom: 20px;">
                <?php if ($_GET['msg'] == 'error_duplicado'): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> El registro ya existe en el sistema.
                    </div>
                <?php elseif ($_GET['msg'] == 'success'): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> Registro guardado exitosamente.
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
           <div class="action-buttons-container">
            <button onclick="openModal('modalEspecialidad')" class="btn-action">
                <i class="fas fa-plus-circle"></i> Nueva Especialidad
            </button>
            <button onclick="openModal('modalEstado')" class="btn-action btn-secondary">
                <i class="fas fa-tag"></i> Nuevo Estado
            </button>
        </div>

<div id="modalEspecialidad" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Nueva Especialidad</h3>
            <button onclick="closeModal('modalEspecialidad')" class="close-btn">&times;</button>
        </div>
        <form action="index.php?view=crear_especialidad" method="POST">
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="nombre_especialidad" placeholder="Ej: Cardiología" required>
            </div>
            <button type="submit" class="btn-update-modal">Guardar Especialidad</button>
        </form>
    </div>
</div>

<div id="modalEstado" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Nuevo Estado</h3>
            <button onclick="closeModal('modalEstado')" class="close-btn">&times;</button>
        </div>
        <form action="index.php?view=crear_estado" method="POST">
            <div class="form-group">
                <label>Nombre del Estado</label>
                <input type="text" name="nombre_estado" placeholder="Ej: Suspendido" required>
            </div>
            <button type="submit" class="btn-update-modal">Guardar Estado</button>
        </form>
    </div>
</div>

    <script>
        function openModal(id) {
            document.getElementById(id).style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        // Cerrar al hacer clic fuera del contenido
        window.onclick = function(event) {
            if (event.target.className === 'modal-overlay') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>