<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin | Clínica Adventista</title>
    <link rel="stylesheet" href="./public/css/dashboard_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/Gestion_medica/views/sidebar.php'; ?>

        <main class="content">
            <header class="page-header">
                <h1>Administración Central</h1>
                <p>Control total del sistema médico.</p>
            </header>

            <div class="dashboard-card-full" style="background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <h2><i class="fas fa-user-shield"></i> Acciones Rápidas</h2>
                <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
                <div style="display: flex; gap: 15px;">
                    <a href="index.php?action=usuarios" class="btn-primary-custom" style="text-decoration: none; padding: 15px 25px;">Gestionar Usuarios</a>
                    <a href="index.php?action=buscar_paciente" class="btn-primary-custom" style="text-decoration: none; padding: 15px 25px; background: #34495e;">Ver Auditoría</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>