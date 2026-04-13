<?php
// Si la variable no llegó del controlador, la creamos aquí mismo
if (!isset($especialidad) || empty($especialidad)) {
    try {
        // Usamos la clase Conectar que ya está cargada en tu index.php
        $conexion_directa = Conectar::conexion();
        
        // Consulta exacta a tu tabla 'especialidad'
        $res_esp = $conexion_directa->query("SELECT id_especialidad, nombre_especialidad FROM especialidad");
        
        // Extraemos los datos dependiendo de si usas PDO o MySQLi
        if (method_exists($res_esp, 'fetch_all')) {
            $especialidad = $res_esp->fetch_all(MYSQLI_ASSOC);
        } else {
            $especialidad = $res_esp->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (Throwable $e) {
        // Si algo falla, dejamos el array vacío para no mostrar errores feos
        $especialidad = [];
    }
}
?>


<?php 
    $rol = $_SESSION['rol'] ?? null;
    $folders = [1 => 'admin', 2 => 'medico', 3 => 'pacient', 4 => 'secretaria'];
    
    // Selección de CSS según el rol para mantener la estética profesional
    $css_file = ($rol == 3) ? 'dashboard_paciente.css' : 'dashboard_medico.css';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda | Clínica Adventista</title>
   <link rel="stylesheet" href="/Gestion_medica/public/css/<?= $css_file ?>">
    <link rel="stylesheet" href="/Gestion_medica/public/css/shared.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php 
            $sidebar_path = "views/{$folders[$rol]}/sidebar.php";
            if (file_exists($sidebar_path)) { include $sidebar_path; }
        ?>

        <main class="content" style="padding: 40px;">
            <header style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1>Gestión de Citas y Consultas</h1>
                    <p style="color: var(--text-muted);">
                        <?= ($rol == 3) ? 'Mi historial y citas programadas' : 'Panel de control administrativo' ?>
                    </p>
                </div>
                
                <?php if ($rol == 3): ?>
                    <button onclick="abrirModal()" class="btn-agendar-principal">
                        <i class="fas fa-plus"></i> Agendar Nueva Cita
                    </button>
                <?php endif; ?>
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
                                // Restricción: Médicos solo cancelan si faltan más de 12 horas
                                $bloqueo_medico = ($rol == 2 && $horas_dif < 12);
                            ?>
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 20px;">
                                    <strong><?= date('d/m/Y', $fecha_cita) ?></strong>
                                    <div style="color: var(--primary-cyan); font-size: 0.9rem;"><?= date('h:i A', $fecha_cita) ?></div>
                                </td>
                                
                                <?php if ($rol != 3): ?> 
                                    <td><?= htmlspecialchars($c->nombre_paciente) ?></td> 
                                <?php endif; ?>
                                
                                <?php if ($rol != 2): ?> 
                                    <td><?= htmlspecialchars($c->nombre_medico) ?></td> 
                                <?php endif; ?>

                                <td><?= htmlspecialchars($c->motivo) ?></td>

                                <td>
                                    <span class="status-pill" style="padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; background: rgba(0,242,255,0.1); color: var(--primary-cyan);">
                                        <?= $c->estado ?>
                                    </span>
                                </td>

                                <td style="padding: 20px;">
                                    <div style="display: flex; gap: 15px; align-items: center;">
                                        <?php if($rol == 2): // VISTA MÉDICO ?>
                                            <a href="index.php?action=atender&id=<?= $c->id_cita ?>" title="Atender Consulta" style="color: #28a745;"><i class="fas fa-stethoscope"></i></a>
                                            <?php if(!$bloqueo_medico): ?>
                                                <a href="index.php?action=cancelar&id=<?= $c->id_cita ?>" title="Cancelar" style="color: #dc3545;"><i class="fas fa-times-circle"></i></a>
                                            <?php else: ?>
                                                <span title="Bloqueado: faltan menos de 12h" style="opacity: 0.5; cursor: not-allowed;">🔒</span>
                                            <?php endif; ?>

                                        <?php elseif($rol == 4 || $rol == 1): // VISTA SECRETARIA / ADMIN ?>
                                            <a href="index.php?action=editar&id=<?= $c->id_cita ?>" title="Editar" style="color: #ffc107;"><i class="fas fa-edit"></i></a>
                                            <a href="index.php?action=eliminar&id=<?= $c->id_cita ?>" title="Eliminar" style="color: #dc3545;" onclick="return confirm('¿Seguro que desea eliminar esta cita?')"><i class="fas fa-trash"></i></a>

                                        <?php else: // VISTA PACIENTE ?>
                                            <span style="color: var(--text-muted); font-size: 0.8rem;">Sin acciones</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 60px; color: var(--text-muted);">
                                    <i class="fas fa-calendar-times" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    No hay citas registradas en el sistema.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <div id="modalAgendar" class="modal-custom">
    <div class="modal-content">
        <div class="modal-header-custom">
            <h3><i class="fas fa-calendar-plus"></i> Agendar Nueva Cita</h3>
            <button onclick="cerrarModal()" class="btn-close-modal" type="button">&times;</button>
        </div>

        <form action="index.php?action=guardar_cita" method="POST">
            <div style="margin-bottom: 15px;">
                <label>Especialidad</label>
                <select name="id_especialidad" id="selectEspecialidad" required onchange="cargarMedicos(this.value)">
                    <option value="">Seleccione una especialidad...</option>
                    <?php if (!empty($especialidad)): ?>
                        <?php foreach($especialidad as $esp): ?>
                            <option value="<?= $esp['id_especialidad'] ?>">
                                <?= htmlspecialchars($esp['nombre_especialidad']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Médico</label>
                <select name="id_medico" id="selectMedico" required disabled onchange="cargarHorarios(this.value)">
                    <option value="">Seleccione especialidad primero...</option>
                </select>
            </div>

            <div style="margin-bottom: 15px;">
                <label>Turnos Disponibles</label>
                <select name="id_disponibilidad" id="selectCupo" required disabled>
                    <option value="">Seleccione médico primero...</option>
                </select>
            </div>

            <div class="info-box-custom">
                <i class="fas fa-info-circle"></i> 
                <span>Seleccione un turno de la lista. Solo se muestran médicos con disponibilidad activa.</span>
            </div>

            <button type="submit" class="btn-submit-modal">
                Confirmar Cita
            </button>
        </form>
    </div>
</div>

    <script src="/Gestion_medica/public/js/modal_citas.js?v=1.1"></script>

</body>
</html>
                