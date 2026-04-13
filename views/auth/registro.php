<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Paciente - Fundación Adventista</title>
    <link rel="stylesheet" href="./public/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <main class="login-container" style="max-width: 550px;">
        <section class="login-box">
            <header>
                <div class="logo-container">
                    <img src="public/img/logo_hospital.png" alt="+" class="logo">
                </div>
                <h1>Nueva Cuenta</h1>
                <p class="subtitle">Sistema Médico de Autogestión</p>
            </header>

            <?php if (isset($_GET['error'])): ?>
                <div style="background: rgba(220, 53, 69, 0.1); color: #ff6b6b; padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 0.85rem; border: 1px solid rgba(220, 53, 69, 0.2); text-align: left;">
                    <i class="fas fa-circle-exclamation"></i> 
                    <?php 
                        switch($_GET['error']) {
                            case 'cedula_duplicada': echo "La cédula ingresada ya se encuentra registrada."; break;
                            case 'correo_duplicado': echo "El correo electrónico ya está en uso."; break;
                            case 'usuario_duplicado': echo "El nombre de usuario no está disponible."; break;
                            case 'fallo_registro': echo "Ocurrió un error interno. Intente más tarde."; break;
                            default: echo "Error en el registro. Verifique sus datos.";
                        }
                    ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=registrar" method="POST">
                <fieldset style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; border: none; padding: 0;">
                    
                    <div class="input-group" style="text-align: left;">
                        <label>Nombre</label>
                        <input type="text" name="nombre" placeholder="Ej: Kevyn" required>
                    </div>

                    <div class="input-group" style="text-align: left;">
                        <label>Apellido</label>
                        <input type="text" name="apellido" placeholder="Ej: Camacaro" required>
                    </div>

                    <div class="input-group" style="text-align: left;">
                        <label>Cédula</label>
                        <input type="text" name="cedula" placeholder="V-000000" required>
                    </div>

                    <div class="input-group" style="text-align: left;">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" placeholder="usuario@gmail.com" required>
                    </div>

                    <div class="input-group" style="text-align: left;">
                        <label>Usuario</label>
                        <input type="text" name="usuario" placeholder="kcamacaro" required>
                    </div>

                    <div class="input-group" style="text-align: left;">
                        <label>Contraseña</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-login" style="grid-column: span 2; margin-top: 10px;">
                        Crear Cuenta Médica
                    </button>
                </fieldset>
            </form>

            <footer style="margin-top: 25px; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 20px; font-size: 0.9rem;">
                <p style="color: #94a3b8;">¿Ya eres paciente? 
                    <a href="index.php?action=login" style="color: var(--primary-cyan); text-decoration: none; font-weight: 600;">
                        Inicia Sesión
                    </a>
                </p>
            </footer>
        </section>
    </main>
</body>
</html>