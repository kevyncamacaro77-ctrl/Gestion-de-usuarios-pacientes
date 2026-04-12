<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Paciente | Clínica Adventista</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Gestion_medica/public/css/dashboard_paciente.css">
</head>
<body>
    <div class="main-container">
        <?php include __DIR__ . '/sidebar.php'; ?>

        <main class="content">
            <header class="page-header">
                <h1>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']); ?></h1>
                <p>Gestiona tus citas y revisa tu historial médico desde aquí.</p>
            </header>

            <section class="dashboard-cards">
                <div class="card card-blue">
                    <div class="card-header">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>Próximas Citas</h3>
                    </div>
                    <div class="card-body">
                        <p class="number"><?= count($proximas_citas) ?> <span>Activas</span></p>
                        <a href="index.php?action=citas">Administrar citas →</a>
                    </div>
                </div>

                <div class="card card-green">
                    <div class="card-header">
                        <i class="fas fa-file-medical"></i>
                        <h3>Mi Historial</h3>
                    </div>
                    <div class="card-body">
                        <p class="number">Consultas</p>
                        <a href="index.php?action=historial">Ver diagnósticos →</a>
                    </div>
                </div>
            </section>

            <div class="dashboard-card-full">
                <div class="section-title">
                    <i class="fas fa-stream"></i>
                    <h3>Resumen de Actividad Reciente</h3>
                </div>
                
                <?php if (!empty($proximas_citas)): ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($proximas_citas as $cita): ?>
                                    <tr>
                                        <td><span class="date-badge"><?= date('d/m/Y', strtotime($cita->fecha_creacion)) ?></span></td>
                                        <td><?= htmlspecialchars($cita->motivo) ?></td>
                                        <td class="text-center">
                                            <a href="#" class="btn-cancel"><i class="fas fa-calendar-times"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="far fa-calendar-minus"></i>
                        <p>Aún no tienes citas programadas en el sistema.</p>
                        <a href="index.php?action=citas" class="btn-schedule">Agendar mi primera cita</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="/Gestion_medica/public/js/modal_citas.js"></script>
</body>
</html>