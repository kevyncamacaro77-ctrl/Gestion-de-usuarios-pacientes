<?php
// Verificamos si existe una consulta previa para cargar los datos (Editar)
// Si no existe, inicializamos variables vacías (Crear)
$id_con = $consulta->idConsulta ?? '';
$mot = $consulta->motivo ?? '';
$diag = $consulta->diagnostico ?? '';
$recom = $consulta->recomendaciones ?? '';
$est = $consulta->estado ?? 'Finalizada';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Consulta | Clínica Adventista</title>
    <link rel="stylesheet" href="./public/css/dashboard.css">
</head>
<body>
    <div class="main-container">
        
        <?php include 'views/pacient/sidebar.php'; ?>

        <main class="content" style="padding: 40px;">
            <header style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1>Gestión de Historia Clínica</h1>
                    <p style="font-size: 1.1rem;">
                        Paciente: <strong style="color: var(--neon-cyan);"><?= $paciente->nombre ?? 'Nombre no disponible' ?></strong> 
                        | Cédula: <span style="color: #ccd6f6;"><?= $paciente->cedula ?? 'N/A' ?></span>
                    </p>
                </div>
                <a href="index.php?action=dashboard_medico" class="btn-action" style="text-decoration: none; padding: 10px 20px;">Volver al Panel</a>
            </header>

            <form action="index.php?action=guardar_consulta" method="POST" style="background: var(--glass); padding: 30px; border-radius: 15px; border: 1px solid var(--border);">
                
                <input type="hidden" name="idConsulta" value="<?= $id_con ?>">
                <input type="hidden" name="medico_idmedico" value="<?= $_SESSION['user_id'] ?>">
                <input type="hidden" name="paciente_idpaciente" value="<?= $paciente->id_paciente ?>">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    
                    <div>
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: var(--neon-cyan); margin-bottom: 10px; font-weight: bold;">Motivo de la Consulta</label>
                            <input type="text" name="motivo" maxlength="100" value="<?= $mot ?>" required 
                                   placeholder="Ej: Control de miopía, irritación ocular..."
                                   style="width: 100%; background: #0a1124; border: 1px solid var(--border); color: white; padding: 12px; border-radius: 8px; font-size: 1rem;">
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: var(--neon-cyan); margin-bottom: 10px; font-weight: bold;">Diagnóstico Médico</label>
                            <textarea name="diagnostico" maxlength="455" rows="10" required
                                      placeholder="Describa el hallazgo clínico..."
                                      style="width: 100%; background: #0a1124; border: 1px solid var(--border); color: white; padding: 12px; border-radius: 8px; resize: none; line-height: 1.5;"><?= $diag ?></textarea>
                            <div style="text-align: right; font-size: 0.8rem; color: #555; margin-top: 5px;">Máximo 455 caracteres</div>
                        </div>
                    </div>

                    <div>
                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: var(--neon-cyan); margin-bottom: 10px; font-weight: bold;">Recomendaciones / Tratamiento</label>
                            <textarea name="recomendaciones" maxlength="455" rows="10" required
                                      placeholder="Indique medicamentos, reposo o próximos pasos..."
                                      style="width: 100%; background: #0a1124; border: 1px solid var(--border); color: white; padding: 12px; border-radius: 8px; resize: none; line-height: 1.5;"><?= $recom ?></textarea>
                            <div style="text-align: right; font-size: 0.8rem; color: #555; margin-top: 5px;">Máximo 455 caracteres</div>
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label style="display: block; color: var(--neon-cyan); margin-bottom: 10px; font-weight: bold;">Estado de Consulta</label>
                            <select name="estado" style="width: 100%; background: #0a1124; border: 1px solid var(--border); color: white; padding: 12px; border-radius: 8px; cursor: pointer; font-size: 1rem;">
                                <option value="Finalizada" <?= $est == 'Finalizada' ? 'selected' : '' ?>>Finalizada (Cerrar caso)</option>
                                <option value="Pendiente" <?= $est == 'Pendiente' ? 'selected' : '' ?>>Pendiente (Requiere seguimiento)</option>
                                <option value="Cancelada" <?= $est == 'Cancelada' ? 'selected' : '' ?>>Cancelada</option>
                            </select>
                        </div>

                        <div style="text-align: right; margin-top: 30px;">
                            <button type="submit" style="background: var(--neon-cyan); color: #0a1124; border: none; padding: 15px 50px; border-radius: 10px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(0, 212, 255, 0.3);">
                                <?= $id_con ? '💾 Actualizar Historia' : '➕ Registrar Consulta' ?>
                            </button>
                        </div>
                    </div>

                </div>
            </form>

            <?php if(!empty($consultas_anteriores)): ?>
            <section style="margin-top: 50px;">
                <h3 style="margin-bottom: 20px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Historial de Consultas Recientes</h3>
                <div style="display: grid; gap: 15px;">
                    <?php foreach($consultas_anteriores as $ca): ?>
                        <div style="background: rgba(255,255,255,0.03); padding: 20px; border-radius: 10px; border-left: 4px solid #333;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <strong style="color: var(--neon-cyan);"><?= $ca->motivo ?></strong>
                                <span style="color: #8892b0; font-size: 0.9rem;"><?= date('d/m/Y', strtotime($ca->fecha)) ?></span>
                            </div>
                            <p style="color: #ccd6f6; font-size: 0.95rem; font-style: italic;">"<?= $ca->diagnostico ?>"</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

        </main>
    </div>
</body>
</html>