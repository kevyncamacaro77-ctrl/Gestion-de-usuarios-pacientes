<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Médico | Clínica Adventista</title>
    <link rel="stylesheet" href="./public/css/dashboard_medico.css">
</head>
<body>
    <div class="main-container">
        
        <?php include 'views/medico/sidebar.php'; ?>

        <main class="content">
            <header>
                <h1>Panel de Control Médico</h1>
                <p>Bienvenido, Dr. <?php echo $_SESSION['nombre']; ?>. Gestione sus consultas y horarios aquí.</p>
            </header>

         <section class="dashboard-cards">
            <div class="card border-cyan">
                <h3>📅 Disponibilidad</h3>
                <p>Configure sus días y horas de atención semanal.</p>
                <a href="index.php?action=gestionar_disponibilidad" class="btn-outline-cyan">Configurar Horario</a>
            </div>

            <div class="card border-red">
                <h3>🚫 Gestionar Citas</h3>
                <p>Revise su agenda diaria y gestione cancelaciones.</p>
                <a href="index.php?action=citas_medico" class="btn-outline-red">Ver Agenda</a>
            </div>

            <div class="card border-green">
                <h3>👁️ Gestionar Consulta</h3>
                <p>Historias clínicas por cédula.</p>
                <form action="index.php?action=buscar_paciente" method="POST" class="search-form">
                    <input type="text" name="cedula" placeholder="Cédula del paciente..." required>
                    <button type="submit" class="btn-buscar">🔍 Buscar</button>
                </form>
            </div>
        </section>

            <section class="table-section">
                <h2>Pacientes para hoy</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($citas)): ?>
                            <?php foreach($citas as $cita): ?>
                                <tr>
                                    <td><?= $cita->hora ?></td>
                                    <td><?= $cita->nombre . " " . $cita->apellido ?></td>
                                    <td><?= $cita->motivo ?></td>
                                    <td><?= $cita->estado ?></td>
                                    <td><a href="#" class="btn-atender">Atender</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;">No tienes pacientes programados para hoy.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>