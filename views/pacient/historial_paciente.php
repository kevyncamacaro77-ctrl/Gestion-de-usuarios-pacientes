<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico Digital | Clínica</title>
    <link rel="stylesheet" href="./public/css/dashboard.css">
</head>
<body>
    <div class="main-container">
        
        <?php include 'sidebar.php'; ?>

        <main class="content" style="padding: 40px; overflow-y: auto;">
            <header style="margin-bottom: 30px;">
                <h1>Historial Clínico Digital</h1>
                <p>Consulta tus diagnósticos, exámenes y procedimientos realizados.</p>
            </header>

            <?php if(empty($historial)): ?>
                <div class="card" style="padding: 20px; text-align: center; background: var(--glass);">
                    <p>Aún no posees registros médicos en nuestro sistema.</p>
                </div>
            <?php else: ?>
                <?php foreach($historial as $h): ?>
                <article class="consulta-card" style="background: var(--glass); border: 1px solid var(--border); border-radius: 15px; padding: 25px; margin-bottom: 25px;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid rgba(0,212,255,0.1); padding-bottom: 15px; margin-bottom: 15px;">
                        <div>
                            <span style="color: var(--neon-cyan); font-size: 0.85rem; text-transform: uppercase; font-weight: bold;">
                                <?= $h->especialidad ?? 'Oftalmología General' ?>
                            </span>
                            <h2 style="margin: 5px 0; color: #fff;"><?= $h->motivo ?></h2>
                            <small style="color: #8892b0; font-size: 1rem;">
                                Atendido por: <strong style="color: #ccd6f6;">Dr. <?= $h->nombre_medico ?></strong>
                            </small>
                        </div>
                        <div style="text-align: right;">
                            <span style="display: block; font-weight: bold; color: #fff; font-size: 1.1rem;">
                                <?= date('d/m/Y', strtotime($h->fecha)) ?>
                            </span>
                            <span style="font-size: 0.9rem; color: #8892b0;">
                                <?= date('H:i', strtotime($h->fecha)) ?>
                            </span>
                        </div>
                    </div>

                    <div class="diagnostico" style="margin-bottom: 20px;">
                        <h4 style="color: var(--neon-cyan); margin-bottom: 10px; font-size: 1.1rem;">Diagnóstico:</h4>
                        <p style="font-style: italic; color: #ccd6f6; line-height: 1.6; background: rgba(0,0,0,0.2); padding: 15px; border-radius: 8px;">
                            "<?= $h->diagnostico ?>"
                        </p>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                        <div class="sub-section" style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 10px; border-left: 3px solid var(--neon-cyan);">
                            <h5 style="margin-bottom: 10px; color: #fff; border-bottom: 1px solid #333;">Tratamiento / Receta</h5>
                            <p style="font-size: 0.9rem; color: #8892b0;">
                                <?= $h->tratamiento ?? 'Ver indicaciones en el consultorio.' ?>
                            </p>
                        </div>
                        <div class="sub-section" style="background: rgba(0,0,0,0.3); padding: 15px; border-radius: 10px; border-left: 3px solid #ff4d4d;">
                            <h5 style="margin-bottom: 10px; color: #fff; border-bottom: 1px solid #333;">Próximo Control</h5>
                            <p style="font-size: 0.9rem; color: #8892b0;">
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