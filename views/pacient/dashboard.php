<?php 
// Parche temporal para que no salga el error de variable indefinida
$citas_pendientes = $citas_pendientes ?? 0; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control | Clínica Adventista</title>
    <link rel="stylesheet" href="./public/css/dashboard.css">
</head>
<body>
    <div class="main-container">
        
        <?php include __DIR__ . '/sidebar.php'; ?>

        <main class="content" style="padding: 50px;">
            <header>
                <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?></h1>
                <p>Este es tu panel de control donde puedes gestionar tus citas y revisar tu historial médico.</p>
            </header>

            <section class="dashboard-cards">
                <div class="card">
                    <h2>Próximas Citas</h2>
                    <p>Tienes <?php echo $citas_pendientes; ?> citas próximas.</p>
                    <a href="index.php?action=citas" class="btn">Ver Citas</a>
                </div>

                <div class="card">
                    <h2>Historial Médico</h2>
                    <p>Revisa tu historial médico actualizado.</p>
                    <a href="index.php?action=historial" class="btn">Ver Historial</a>
                </div>
            </section>
        </main>
    </div> </body>
</html>