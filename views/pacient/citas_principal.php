<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Citas | Clínica</title>
    <link rel="stylesheet" href="./public/css/dashboard.css">
</head>
<body>
    <div class="main-container">
        <aside class="sidebar">
            <h2>Panel Méd.</h2>
            <nav>
                <a href="index.php?action=dashboard">Inicio</a>
                <a href="index.php?action=citas">Mis Citas</a>
                <a href="index.php?action=historial">Historial</a>
                <a href="index.php?action=logout">Salir</a>
            </nav>
        </aside>

        <main class="content" style="padding: 40px;">
            <header style="margin-bottom: 30px;">
                <h1>Control de Citas</h1>
                <p>Gestiona y programa tus consultas oftalmológicas</p>
            </header>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Médico/Paciente</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($citas as $c): ?>
                    <tr>
                        <td><?= $c->fecha ?></td>
                        <td><?= ($_SESSION['rol'] == 3) ? $c->medico : $c->paciente ?></td>
                        <td><?= $c->motivo ?></td>
                        <td>
                            <button class="btn-action">Ver</button>
                            <?php if($_SESSION['rol'] <= 2): ?>
                                <a href="index.php?action=citas&delete_id=<?= $c->id_cita ?>" class="btn-action" style="border-color: #ff4d4d; color: #ff4d4d;">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>