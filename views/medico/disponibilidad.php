<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Disponibilidad Médica | Clínica Adventista</title>
    <link rel="stylesheet" href="./public/css/dashboard_medico.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light"> 
    <div class="main-container">
        <?php include 'views/medico/sidebar.php'; ?>

        <main class="content">
            <header class="page-header">
                <h1><i class="fas fa-calendar-alt" style="color: #007bff;"></i> Mi Disponibilidad</h1>
                <p>Configura tus bloques de horario para atención médica semanal.</p>
            </header>

            <div class="dashboard-card"> 
                <form action="index.php?action=guardarDisponibilidad" method="POST">
                    <div class="form-grid-dispo">
                        <div class="form-group-custom">
                            <label><i class="fas fa-calendar-day"></i> Fecha de Atención</label>
                            <input type="date" name="fecha" required class="input-custom">
                        </div>

                        <div class="form-group-custom">
                            <label><i class="fas fa-clock"></i> Hora Inicio</label>
                            <input type="time" name="hora_inicio" required class="input-custom">
                        </div>

                        <div class="form-group-custom">
                            <label><i class="fas fa-hourglass-end"></i> Hora Fin</label>
                            <input type="time" name="hora_fin" required class="input-custom">
                        </div>

                        <div class="form-actions-custom">
                            <button type="submit" class="btn-add-dispo">
                                <i class="fas fa-plus"></i> Añadir Bloque
                            </button>
                        </div>
                    </div>
                </form>

                <hr class="separator">

                <h3><i class="fas fa-list-ul"></i> Horarios Configurados</h3>
                
                <div class="table-container-custom">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Horario</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($horarios)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">No has definido horarios todavía.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($horarios as $h): ?>
                                <tr>
                                    <td><strong><?= date("d/m/Y", strtotime($h->fecha)) ?></strong></td>
                                    <td>
                                        <span class="badge-time">
                                            <?= date("g:i a", strtotime($h->horainicio)) ?> - <?= date("g:i a", strtotime($h->horafin)) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="index.php?action=eliminar_horario&id=<?= $h->id_disponibilidad ?>" 
                                           class="btn-delete-link"
                                           onclick="return confirm('¿Eliminar este bloque?')">
                                           <i class="fas fa-trash"></i> Eliminar
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