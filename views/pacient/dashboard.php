<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Paciente | Clínica Adventista</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Gestion_medica/public/css/dashboard_paciente.css">
    <link rel="stylesheet" href="/Gestion_medica/public/css/shared.css">
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
                    <h3 style="color: #000;">Resumen de Actividad Reciente</h3>
                </div>
                
                <?php if (!empty($proximas_citas)): ?>
                    <div class="table-container">
                        <table class="table-custom" style="width: 100%; border-collapse: collapse; background: white;">
                            <thead>
                                <tr style="background: #f8f9fa;">
                                    <th style="padding: 15px; color: #333;">Fecha / Hora</th>
                                    <th style="padding: 15px; color: #333;">Motivo</th>
                                    <th style="padding: 15px; color: #333;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($proximas_citas as $cita): ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px;">
                                            <strong style="color: #000; display: block;">
                                                <?= date('d/m/Y', strtotime($cita->fecha_creacion)) ?>
                                            </strong>
                                            <span style="color: #666; font-size: 0.85rem;">
                                                <?= date('h:i A', strtotime($cita->fecha_creacion)) ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; color: #000;">
                                            <?= htmlspecialchars($cita->motivo) ?>
                                        </td>
                                        <td style="padding: 15px;">
                                            <span style="color: #999; font-size: 0.85rem;">Sin acciones</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="empty-state" style="text-align: center; padding: 40px;">
                        <i class="far fa-calendar-minus" style="font-size: 3rem; color: #ccc;"></i>
                        <p style="color: #666; margin-top: 10px;">Aún no tienes citas programadas en el sistema.</p>
                        <a href="index.php?action=citas" class="btn-agendar-principal" style="display: inline-block; margin-top: 15px;">
                            Agendar mi primera cita
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="/Gestion_medica/public/js/modal_citas.js"></script>
</body>
</html>