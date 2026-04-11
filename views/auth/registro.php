<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Paciente - Fundación Adventista</title>
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <main class="login-container" style="max-width: 550px;">
        <section class="login-box">
            <header>
                <div class="logo-container">
                    <img src="public/img/logo_hospital.png" alt="+" class="logo">
                </div>
                <h1>Nueva Cuenta</h1>
                <p>Sistema Médico de Autogestión</p>
            </header>

            <form action="index.php?action=register_post" method="POST">
                <fieldset style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; border: none;">
                    
                    <div class="input-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" placeholder="Ej: Kevyn" required>
                    </div>

                    <div class="input-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" placeholder="Ej: Camacaro" required>
                    </div>

                    <div class="input-group">
                        <label>Cédula</label>
                        <input type="text" name="cedula" placeholder="V-000000" required>
                    </div>

                    <div class="input-group">
                        <label>Correo Electrónico</label>
                        <input type="email" name="correo" placeholder="usuario@gmail.com" required>
                    </div>

                    <div class="input-group">
                        <label>Usuario</label>
                        <input type="text" name="usuario" placeholder="kcamacaro" required>
                    </div>

                    <div class="input-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-login" style="grid-column: span 2; margin-top: 10px;">
                        Crear Cuenta Médica
                    </button>
                </fieldset>
            </form>

            <footer style="margin-top: 20px; font-size: 0.9rem;">
                <p>¿Ya eres paciente? <a href="index.php?action=login" style="color: var(--neon-blue); text-decoration: none; font-weight: bold;">Inicia Sesión</a></p>
            </footer>
        </section>
    </main>
</body>
</html>