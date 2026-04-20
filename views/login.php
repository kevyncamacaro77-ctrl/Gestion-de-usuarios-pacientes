<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Sistema - Fundación Hospital Adventista</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/login_moderno.css">
</head>
<body>
    <div class="login-box">
        <div class="logo-container">
            <img src="public/img/logo_hospital.webp" alt="Logo Institucional">
        </div>
        
        <h2>Inicio de Sesión</h2>
        <p class="subtitle">Bienvenido al Portal de Gestión Médica</p>

        <form action="index.php?view=login" method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="nombre_usuario" required>
                <label>Usuario o ID</label>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="contrasena" required>
                <label>Contraseña</label>
            </div>

            <button type="submit" name="btn_login" class="login-btn">Ingresar</button>
        </form>

        <div class="register-link" style="margin-top: 25px; text-align: center;">
            <p style="color: rgba(255,255,255,0.7); font-size: 14px;">
                ¿No tienes una cuenta? 
                <a href="index.php?view=registro_paciente" style="...">Regístrate aquí</a>
            </p>
        </div>

        <div class="footer-note">
        © 2026 Fundación Hospital Adventista
        </div>
    </div>
</body>
</html>