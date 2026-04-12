<?php 
    $rol = $_SESSION['rol'] ?? null;
    $folders = [1 => 'admin', 2 => 'medico', 3 => 'pacient', 4 => 'secretaria'];
    
    // Decidimos el CSS según el rol para no afectar al médico
    $css_file = ($rol == 3) ? 'dashboard_paciente.css' : 'dashboard_medico.css';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda | Clínica Adventista</title>
    <link rel="stylesheet" href="/Gestion_medica/public/css/<?= $css_file ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php 
            // Carga el sidebar correspondiente a cada carpeta
            $sidebar_path = "views/{$folders[$rol]}/sidebar.php";
            if (file_exists($sidebar_path)) {
                include $sidebar_path;
            }
        ?>

        <main class="content" style="padding: 40px;">
            <header style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1>Gestión de Citas y Consultas</h1>
                    <p><?= ($rol == 3) ? 'Mi historial y citas programadas' : 'Panel de control administrativo' ?></p>
                </div>
            </header>

            <div class="<?= ($rol == 3) ? 'dashboard-card-full' : 'card' ?>" 
                 style="background: var(--glass); border-radius: 15px; overflow: hidden; border: 1px solid var(--border);">
                
                <table class="<?= ($rol == 3) ? 'table-custom' : 'data-table' ?>" style="width: 100%; border-collapse: collapse; color: white;">
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
                        <?php if (!empty($citas)): ?>
                            <?php foreach($citas as $c): 
                                $fecha_cita = strtotime($c->fecha);
                                $horas_dif = ($fecha_cita - time()) / 3600;
                                $restriccion_medico = ($rol == 2 && $horas_dif < 12);
                            ?>
                            <tr>
                                <td style="padding: 20px;">
                                    <strong><?= date('d/m/Y', $fecha_cita) ?></strong>
                                    <div style="color: var(--neon-cyan);"><?= date('h:i A', $fecha_cita) ?></div>
                                </td>
                                <?php if ($rol != 3): ?> <td><?= htmlspecialchars($c->nombre_paciente) ?></td> <?php endif; ?>
                                <?php if ($rol != 2): ?> <td><?= htmlspecialchars($c->nombre_medico) ?></td> <?php endif; ?>
                                <td><?= htmlspecialchars($c->motivo) ?></td>
                                <td>
                                    <span class="<?= ($rol == 3) ? 'status-pill' : 'status-badge' ?>">
                                        <?= $c->estado ?>
                                    </span>
                                </td>
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
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #8892b0;">
                                    No hay citas registradas.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

                            <div id="modalAgendar" class="modal-custom" style="display:none;">
    <div class="modal-content card">
        <div class="card-header">
            <h3><i class="fas fa-calendar-plus"></i> Agendar Nueva Cita</h3>
            <button onclick="cerrarModal()" class="btn-close">&times;</button>
        </div>
        <div class="card-body">
            <form action="index.php?action=guardar_cita" method="POST">
                <div class="form-group">
                    <label>Especialidad Médica</label>
                    <select name="especialidad" id="selectEspecialidad" required class="form-control">
                        <option value="">Seleccione una especialidad...</option>
                        </select>
                </div>

                <div class="form-group">
                    <label>Médico Disponible</label>
                    <select name="id_medico" id="selectMedico" required class="form-control" disabled>
                        <option value="">Primero elija especialidad...</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Fecha</label>
                        <input type="date" name="fecha" id="fechaCita" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Hora de Inicio</label>
                        <input type="time" name="hora_inicio" id="horaInicio" required class="form-control">
                    </div>
                </div>

                <div class="info-box">
                    <i class="fas fa-clock"></i> 
                    <span>Duración máxima de la consulta: <strong>40 minutos</strong>.</span>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-schedule">Confirmar Cita</button>
                </div>
            </form>
        </div>
    </div>
</div>



</body>
</html>