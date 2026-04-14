<?php
// Datos de la consulta y control de roles
$id_con = $consulta->idConsulta ?? '';
$fecha_con = $consulta->fecha ?? date('Y-m-d'); 
$mot = $consulta->motivo ?? '';
$diag = $consulta->diagnostico ?? '';
$recom = $consulta->recomendaciones ?? '';
$est = $consulta->estado ?? 'Finalizada';

$rol = $_SESSION['rol'] ?? 0; 
$puede_editar = ($rol == 1 || $rol == 2); 
$es_admin = ($rol == 1);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historia Clínica | Clínica Adventista</title>
    <link rel="stylesheet" href="./public/css/dashboard_medico.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .required-star { color: #dc3545; margin-left: 3px; }
        .hidden-field { display: none; }
    </style>
</head>
<body class="bg-light">
    <div class="main-container">
        <?php include 'views/medico/sidebar.php'; ?>

        <main class="content">
            <header class="consulta-header">
                <h1><i class="fas fa-file-medical"></i> Gestión de Historia Clínica</h1>
                
                <?php if (!$paciente): ?>
                    <div class="status-alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Debe buscar un paciente para registrar la consulta.</span>
                    </div>
                <?php else: ?>
                    <p class="paciente-info">Paciente: <strong><?= $paciente->nombre ?></strong> | Cédula: <?= $paciente->cedula ?></p>
                <?php endif; ?>
                
                <a href="index.php?action=mis_pacientes" class="btn-back"><i class="fas fa-arrow-left"></i> Volver</a>
            </header>

            <div class="full-width-card">
                <form action="index.php?action=guardar_consulta" method="POST" id="formConsulta">
                    
                    <input type="hidden" name="idConsulta" value="<?= $id_con ?>">

                    <?php if (!$paciente): ?>
                    <div class="search-box-active">
                        <label for="cedula_buscar"><i class="fas fa-search"></i> Buscar Paciente por Cédula:</label>
                        <div class="search-input-group">
                            <input type="text" name="cedula_buscar" id="cedula_buscar" class="custom-input" placeholder="Ej: 27123456" required>
                            <span class="search-hint">El sistema vinculará la consulta automáticamente.</span>
                        </div>
                    </div>
                    <?php else: ?>
                        <input type="hidden" name="paciente_idpaciente" value="<?= $paciente->idpaciente ?>">
                    <?php endif; ?>

                    <div class="form-layout">
                        <div class="form-group full-row">
                            <label><i class="fas fa-info-circle"></i> Estado / Tipo de Atención</label>
                            <select name="estado" id="estado_consulta" class="custom-select" onchange="validarTipoAtencion()">
                                <option value="Finalizada" <?= $est == 'Finalizada' ? 'selected' : '' ?>>Consulta Normal (Finalizada)</option>
                                <option value="Emergencia" <?= $est == 'Emergencia' ? 'selected' : '' ?>>Emergencia (Sin cita previa)</option>
                                <option value="Pendiente" <?= $est == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                            </select>
                        </div>

                        <div class="form-group full-row" id="grupo_cita">
                            <label><i class="fas fa-calendar-check"></i> Vincular Cita Pendiente <span class="required-star" id="estrella_cita">*</span></label>
                            <select name="id_cita" id="id_cita" class="custom-select">
                                <option value="">-- Seleccione la cita que está atendiendo --</option>
                                <?php if(isset($citas_pendientes) && !empty($citas_pendientes)): ?>
                                    <?php foreach($citas_pendientes as $cp): ?>
                                        <option value="<?= $cp->id_cita ?>"><?= date('d/m/Y', strtotime($cp->fecha)) ?> - <?= htmlspecialchars($cp->motivo) ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="" disabled>No hay citas pendientes para este paciente</option>
                                <?php endif; ?>
                            </select>
                            <small id="msg_ayuda" style="color: #666;">Si no es emergencia, debe seleccionar una cita para poder guardar.</small>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-calendar-day"></i> Fecha de la Consulta</label>
                            <input type="date" name="fecha" class="custom-input" value="<?= $fecha_con ?>" required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-comment-medical"></i> Motivo de la Consulta</label>
                            <input type="text" name="motivo" class="custom-input" value="<?= $mot ?>" placeholder="Ej: Dolor abdominal..." required>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-stethoscope"></i> Diagnóstico Médico</label>
                            <textarea name="diagnostico" class="custom-textarea" placeholder="Escriba el diagnóstico detallado..." required><?= $diag ?></textarea>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-pills"></i> Recomendaciones / Tratamiento</label>
                            <textarea name="recommendaciones" class="custom-textarea" placeholder="Medicamentos, dosis, reposo..." required><?= $recom ?></textarea>
                        </div>
                    </div>

                    <div class="crud-actions">
                        <div class="primary-actions">
                            <?php if ($puede_editar): ?>
                                <button type="submit" class="btn-main" id="btnGuardar">
                                    <i class="fas fa-save"></i> <?= $id_con ? 'Actualizar Consulta' : 'Registrar Consulta' ?>
                                </button>
                            <?php endif; ?>
                        </div>

                        <?php if ($es_admin && $id_con): ?>
                            <a href="index.php?action=eliminar_consulta&id=<?= $id_con ?>" 
                               class="btn-delete" 
                               onclick="return confirm('¿Estás seguro de eliminar permanentemente esta consulta?')">
                                 <i class="fas fa-trash-alt"></i> Eliminar Registro
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </main>
    </div>

   <script src="/Gestion_medica/public/js/modal_citas.js"></script>
</body>
</html>