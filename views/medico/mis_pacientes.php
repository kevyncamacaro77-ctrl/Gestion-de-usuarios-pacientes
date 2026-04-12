<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Pacientes | Clínica Adventista</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/dashboard_medico.css">
</head>
<body class="bg-light"> 
    <div class="main-container">
        <?php include 'views/medico/sidebar.php'; ?>

        <main class="content">
            <header class="page-header">
                <h1><i class="fas fa-users-medical" style="color: #007bff;"></i> Mis Pacientes</h1>
                <p>Listado de pacientes que han sido atendidos en sus consultas.</p>
            </header>

            <div class="dashboard-card"> 
                <div class="table-container-custom">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user"></i> Nombre</th>
                                <th><i class="fas fa-id-card"></i> Cédula</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($pacientes)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">No hay registros de pacientes atendidos por usted.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($pacientes as $p): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($p->nombre) ?></strong></td>
                                    <td><?= htmlspecialchars($p->cedula) ?></td>
                                    <td class="text-center">
                                        <a href="index.php?action=ver_historial&id=<?= $p->id_paciente ?>" class="btn-info">
                                            <i class="fas fa-eye"></i> Ver Historial
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>