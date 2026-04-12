<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda | Clínica Adventista</title>
    <link rel="stylesheet" href="./public/css/dashboard_medico.css">
</head>
<body>
    <div class="main-container">
        <?php 
            $rol = $_SESSION['rol'];
            $folders = [1 => 'admin', 2 => 'medico', 3 => 'pacient', 4 => 'secretaria'];
            include "views/{$folders[$rol]}/sidebar.php"; 
        ?>

        <main class="content" style="padding: 40px;">
            <header style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1>Gestión de Citas y Consultas</h1>
                    <p><?= ($rol == 3) ? 'Mi historial y citas programadas' : 'Panel de control administrativo' ?></p>
                </div>
            </header>

            <div class="card" style="background: var(--glass); border-radius: 15px; overflow: hidden; border: 1px solid var(--border);">
                <table class="data-table" style="width: 100%; border-collapse: collapse; color: white;">
                    <thead>
                        <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                            <th style="padding: 20px;">Fecha / Hora</th>
                            <?php if ($rol != 3): ?> <th>Paciente</th> <?php endif; ?>
                            <?php if ($rol != 2): ?> <th>Médico</th> <?php endif; ?>
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($citas as $c): 
                            $fecha_cita = strtotime($c->fecha);
                            $horas_dif = ($fecha_cita - time()) / 3600;
                            // Solo el médico tiene la restricción de 12h. Admin y Secre saltan la regla.
                            $restriccion_medico = ($rol == 2 && $horas_dif < 12);
                        ?>
                        <tr>
                            <td style="padding: 20px;">
                                <strong><?= date('d/m/Y', $fecha_cita) ?></strong>
                                <div style="color: var(--neon-cyan);"><?= date('h:i A', $fecha_cita) ?></div>
                            </td>
                            <?php if ($rol != 3): ?> <td><?= $c->nombre_paciente ?></td> <?php endif; ?>
                            <?php if ($rol != 2): ?> <td><?= $c->nombre_medico ?></td> <?php endif; ?>
                            <td><?= $c->motivo ?></td>
                            <td><span class="status-badge"><?= $c->estado ?></span></td>
                            <td>
                                <div style="display: flex; gap: 10px;">
                                    <?php if($rol == 2): // MÉDICO ?>
                                        <a href="index.php?action=atender&id=<?= $c->id_cita ?>" class="btn-atender">Atender</a>
                                        <?php if(!$restriccion_medico): ?>
                                            <a href="index.php?action=cancelar&id=<?= $c->id_cita ?>" class="btn-cancel">Cancelar</a>
                                        <?php else: ?>
                                            <span title="Bloqueado: < 12h">🔒</span>
                                        <?php endif; ?>

                                    <?php elseif($rol == 4 || $rol == 1): // SECRE / ADMIN ?>
                                        <a href="index.php?action=cancelar&id=<?= $c->id_cita ?>" class="btn-cancel" onclick="return confirm('¿Confirmar acción administrativa?')">Cancelar</a>
                                        <a href="index.php?action=editar&id=<?= $c->id_cita ?>">📝</a>

                                    <?php else: // PACIENTE ?>
                                        <span style="color: #8892b0; font-size: 0.8rem;">Contactar secretaria para cambios</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>