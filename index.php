<?php
// index.php (En la raíz de GESTION_MEDICA)
session_start();

// 1. CARGA DE DEPENDENCIAS
require_once 'app/core/Database.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/PacienteController.php';
require_once 'app/controllers/CitaController.php';

$db = (new Database())->getConnection();

// 2. GESTIÓN DE VISTAS
// Por defecto, ahora la vista inicial es simplemente 'login'
$view = $_GET['view'] ?? 'login';

// 3. LÓGICA DE ACCESO GLOBAL
// Si no hay sesión y el usuario intenta acceder a algo que no sea el login, se redirige
// AHORA: Permitimos que 'login' Y 'registro_paciente' se vean sin estar logueado
if (!isset($_SESSION['usuario']) && !in_array($view, ['login', 'registro_paciente'])) {
    header("Location: index.php?view=login");
    exit();
}

// 4. PROCESAR LOGIN ÚNICO
if (isset($_POST['btn_login'])) {
    $auth = new AuthController($db);
    
    // Llamada simplificada: solo enviamos usuario y contraseña.
    // El controlador ahora valida el rol internamente.
    $error = $auth->login($_POST['nombre_usuario'], $_POST['contrasena']);
    
    if (is_string($error)) {
        echo "<script>alert('$error');</script>";
    }
}

// 5. ENRUTADOR DE VISTAS
switch ($view) {
    case 'login':
        require_once 'views/login.php';
        break;

    case 'dashboard':
        // Verificación de seguridad extra para el dashboard
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?view=login");
            exit();
        }
        
        include 'views/layouts/header.php';
        include 'views/layouts/sidebar.php';

        // Carga automática de la interfaz según el Rol de la BD
        $rol = $_SESSION['rol'];
        if ($rol === 'Administrador') {
            require_once 'views/admin/index.php';
        } elseif ($rol === 'Medico') {
            require_once 'views/medico/index.php';
        } elseif ($rol === 'Secretaria') {
            require_once 'views/secretaria/index.php';
        } elseif ($rol === 'Paciente') {
            require_once 'views/paciente/index.php';
        }

        include 'views/layouts/footer.php';
        break;

    case 'registrar_paciente':
        // Restricción de acceso por nivel de seguridad
        if ($_SESSION['rol'] !== 'Secretaria' && $_SESSION['rol'] !== 'Administrador') {
            header("Location: index.php?view=dashboard");
            exit();
        }
        
        $controller = new PacienteController($db);
        if (isset($_POST['btn_registrar'])) {
            $controller->registrar();
        }
        
        include 'views/layouts/header.php';
        include 'views/layouts/sidebar.php';
        require_once 'views/secretaria/registrar_paciente.php';
        include 'views/layouts/footer.php';
        break;

         case 'logout':
        require_once 'views/logout.php';
        break;

        // Dentro del switch ($view) en index.php
        case 'registro_paciente':
        // Si se envió el formulario de registro, procesamos los datos
        if (isset($_POST['btn_registrar_cuenta'])) {
            $auth = new AuthController($db);
            $resultado = $auth->registrarNuevoPaciente($_POST);
            
            if ($resultado === true) {
                echo "<script>alert('¡Cuenta creada! Ahora puedes iniciar sesión.'); window.location='index.php?view=login';</script>";
                exit();
            } else {
                echo "<script>alert('$resultado');</script>";
            }
        }

        
        // Cargamos la vista del formulario
        require_once 'views/registro_paciente.php';
        break;

        case 'paciente_dashboard':
        // Seguridad básica: solo permitir si hay sesión de paciente
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == 4) {
            include 'views/paciente_dashboard.php';
        } else {
            header("Location: index.php?view=login");
        }
        break;

         case 'dashboard_general':
        include 'views/dashboard_general.php';
        break;

    default:
        // Si la vista no existe, redirige al login centralizado
        require_once 'views/login.php';
        break;
}