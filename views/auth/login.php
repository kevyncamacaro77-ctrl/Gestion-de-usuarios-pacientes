<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundación Hospital Adventista - Acceso</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>

    <main class="login-container">
        <section class="login-box">
            <header>
                <figure class="logo-container">
                    <img src="public/img/logo_hospital.png" alt="Logo Clínica" class="logo">
                </figure>
                <h1>Gestión Oftalmológica</h1>
                <p>Fundación Hospital Adventista de Venezuela</p>
            </header>

          <form action="index.php?action=auth" method="POST">
                <fieldset>
                    <legend>Identificación de Usuario</legend>

                    <label for="usuario">Nombre de Usuario</label>
                    <input type="text" id="usuario" name="usuario" placeholder="Ej: kcamacaro" required>

                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>

                    <button type="submit" class="btn-login">Ingresar al Sistema</button>
                </fieldset>
            </form>

            <?php if (isset($_GET['error'])): ?>
                <footer class="error-footer">
                    <p>Usuario o contraseña incorrectos.</p>
                </footer>
            <?php endif; ?>

                <footer style="margin-top: 25px; border-top: 1px solid rgba(0, 212, 255, 0.1); padding-top: 20px;">
              <p style="font-size: 0.9rem; color: #8892b0;">
                ¿No tienes una cuenta de paciente? <br>
              <a href="index.php?action=registro" style="color: var(--neon-blue); text-decoration: none; font-weight: bold; display: inline-block; mt-2;">
                Regístrate aquí
                </a>
              </p>
            </footer>

        </section>
    </main>

</body>
</html>