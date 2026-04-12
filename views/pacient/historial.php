<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico Digital | Clínica Adventista</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/dashboard_paciente.css">
</head>
<body>
    <div class="main-container">
        
        <?php include __DIR__ . '/sidebar.php'; ?>

        <main class="content">
            <header class="page-header" style="margin-bottom: 30px;">
                <h1>Historial Clínico Digital</h1>
                <p>Consulta tus diagnósticos, exámenes y procedimientos realizados.</p>
            </header>

            <?php if(empty($historial)): ?>
                <div class="dashboard-card-full" style="text-align: center;">
                    <i class="fas fa-folder-open" style="font-size: 3rem; color: #ecf0f1; margin-bottom: 15px; display: block;"></i>
                    <p>Aún no posees registros médicos en nuestro sistema.</p>
                </div>
            <?php else: ?>
                <?php foreach($historial as $h): ?>
                <article class="consulta-card">
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #f1f1f1; padding-bottom: 15px; margin-bottom: 15px;">
                        <div>
                            <span class="especialidad-tag">
                                <?= $h->especialidad ?? 'Consulta General' ?>
                            </span>
                            <h2 style="margin: 5px 0; color: #2c3e50;"><?= htmlspecialchars($h->motivo) ?></h2>
                            <small style="color: #7f8c8d; font-size: 0.95rem;">
                                Atendido por: <strong style="color: #34495e;">Dr. <?= htmlspecialchars($h->nombre_medico) ?></strong>
                            </small>
                        </div>
                        <div style="text-align: right;">
                            <span style="display: block; font-weight: bold; color: #2c3e50; font-size: 1.1rem;">
                                <?= date('d/m/Y', strtotime($h->fecha)) ?>
                            </span>
                            <span style="font-size: 0.9rem; color: #95a5a6;">
                                <?= date('H:i', strtotime($h->fecha)) ?> hrs
                            </span>
                        </div>
                    </div>

                    <div class="diagnostico" style="margin-bottom: 20px;">
                        <h4 style="color: #2c3e50; margin-bottom: 10px; font-size: 1.1rem;">Diagnóstico:</h4>
                        <p class="diagnostico-box">
                            "<?= htmlspecialchars($h->diagnostico) ?>"
                        </p>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <div class="sub-section" style="border-top: 3px solid #3498db;">
                            <h5 style="margin-bottom: 10px; color: #2c3e50; border-bottom: 1px solid #f1f1f1; padding-bottom: 5px;">
                                <i class="fas fa-pills" style="color: #3498db;"></i> Tratamiento
                            </h5>
                            <p style="font-size: 0.9rem; color: #555;">
                                <?= $h->tratamiento ?? 'Ver indicaciones en el consultorio.' ?>
                            </p>
                        </div>
                        <div class="sub-section" style="border-top: 3px solid #e74c3c;">
                            <h5 style="margin-bottom: 10px; color: #2c3e50; border-bottom: 1px solid #f1f1f1; padding-bottom: 5px;">
                                <i class="fas fa-clock" style="color: #e74c3c;"></i> Próximo Control
                            </h5>
                            <p style="font-size: 0.9rem; color: #555;">
                                Pendiente por asignar.
                            </p>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>