<?php
// views/layouts/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Hospital Adventista</title>
    <link rel="stylesheet" href="public/css/global.css">
    <?php
    // Carga dinámica del CSS por rol
    if (isset($_SESSION['rol'])) {
        $css_rol = strtolower($_SESSION['rol']) . ".css";
        echo '<link rel="stylesheet" href="public/css/' . $css_rol . '">';
    }
    ?>
</head>
<body>
    <header class="main-header">
        <div class="header-content">
            <div class="logo-area">
                <img src="public/img/logo.png" alt="Hospital Logo" width="40">
                <span>Fundación Hospital Adventista</span>
            </div>
            <div class="user-area">
                <span><?php echo $_SESSION['usuario']; ?> (<?php echo $_SESSION['rol']; ?>)</span>
                <a href="index.php?view=logout" class="btn-logout">Salir</a>
            </div>
        </div>
    </header>