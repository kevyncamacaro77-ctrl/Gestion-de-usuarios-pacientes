<?php 
    // Capturamos si hay un error de usuario duplicado
    $error_usuario = (isset($resultado) && $resultado === "usuario_duplicado");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Paciente - Hospital Adventista</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/login_moderno.css">
</head>
<body>
    <div class="login-box" style="width: 600px; padding: 40px; margin: 20px;">
        <div class="logo-container">
            <img src="public/img/logo_hospital.webp" alt="Logo">
        </div>
        
        <h2>Registro de Nuevo Paciente</h2>
        <p class="subtitle" style="color: rgba(255,255,255,0.7); margin-bottom: 25px;">Complete sus datos personales y de acceso</p>

       <form action="index.php?view=registro_paciente" method="POST">
            
            <div style="display: flex; gap: 20px;">
                <div class="input-group" style="flex: 1;">
                    <i class="fas fa-user"></i>
                    <input type="text" name="nombre" value="<?php echo $_POST['nombre'] ?? ''; ?>" required>
                    <label>Nombres</label>
                </div>
                <div class="input-group" style="flex: 1;">
                    <i class="fas fa-user"></i>
                    <input type="text" name="apellido" value="<?php echo $_POST['apellido'] ?? ''; ?>" required>
                    <label>Apellidos</label>
                </div>
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="input-group" style="flex: 1;">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="cedula" value="<?php echo $_POST['cedula'] ?? ''; ?>" required>
                    <label>Cédula</label>
                </div>
                <div class="input-group" style="flex: 1;">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="correo" value="<?php echo $_POST['correo'] ?? ''; ?>" required>
                    <label>Correo Electrónico</label>
                </div>
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="input-group" style="flex: 1;">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="telefono" value="<?php echo $_POST['telefono'] ?? ''; ?>" required>
                    <label>Teléfono</label>
                </div>
                <div class="input-group" style="flex: 1;">
                    <i class="fas fa-user-circle"></i>
                    <input type="text" name="nombre_usuario" value="<?php echo $_POST['nombre_usuario'] ?? ''; ?>" required>
                    <label>Nombre de Usuario</label>
                    
                    <?php if (isset($resultado) && $resultado === "usuario_duplicado"): ?>
                        <span style="color: #ff4d4d; font-size: 11px; position: absolute; bottom: -20px; left: 0;">
                            <i class="fas fa-exclamation-circle"></i> Ya hay un usuario ocupando este nombre, elija otro
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="input-group">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" name="direccion" value="<?php echo $_POST['direccion'] ?? ''; ?>" required>
                <label>Dirección de Habitación</label>
            </div>

            <div style="display: flex; gap: 20px;">
                <div class="input-group" style="flex: 1;">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="contrasena" required>
                    <label>Contraseña</label>
                </div>
                <div class="input-group" style="flex: 1;">
                    <i class="fas fa-shield-alt"></i>
                    <input type="password" name="confirmar_contrasena" required>
                    <label>Repetir Contraseña</label>
                </div>
            </div>

            <button type="submit" name="btn_registrar_cuenta" class="login-btn">Finalizar Registro</button>

            <div style="text-align: center; margin-top: 20px;">
                <a href="index.php?view=login" style="color: #fff; text-decoration: none; font-size: 14px; opacity: 0.8; transition: 0.3s;">
                    <i class="fas fa-arrow-left"></i> Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>
</body>
</html>