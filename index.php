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

        case 'dashboard_admin':
        if ($_SESSION['rol'] != 1) { header("Location: index.php"); exit(); }
        
        // Solo cargamos los datos, SIN agregar includes de layouts aquí
        require_once 'app/models/Admin.php';
        $adminModel = new Admin($db);
        $especialidades = $adminModel->getEstadisticasCitas();
        $totalPacientes = $adminModel->getTotalPacientes();

        // Cargamos tu vista original que ya tiene su propio CSS y Sidebar
        require_once 'views/admin/dashboard_admin.php';
        break;

         case 'dashboard_medico':
        if ($_SESSION['rol'] != 2) { header("Location: index.php"); exit(); }
        require_once 'views/medico/dashboard_medico.php';
        break;

         case 'dashboard_secretaria':
        if ($_SESSION['rol'] != 3) { header("Location: index.php"); exit(); }
        require_once 'views/secretaria/dashboard_secretaria.php';
        break;

         case 'dashboard_paciente':
        if ($_SESSION['rol'] != 4) { header("Location: index.php"); exit(); }
        require_once 'views/paciente/dashboard_paciente.php';
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
            include 'views/paciente/paciente_dashboard.php';
        } else {
            header("Location: index.php?view=login");
        }
        break;

        case 'gestion_usuarios':
         if ($_SESSION['rol'] != 1) { header("Location: index.php"); exit(); }
        require_once 'app/models/Admin.php';
        $adminModel = new Admin($db);
        $usuarios = $adminModel->listarUsuarios(); // Vamos a crear esta función
        $roles = $adminModel->listarRoles();
        $estados = $adminModel->listarEstados();
        require_once 'views/admin/gestion_usuarios.php';
        break;

        case 'especialidades':
        if ($_SESSION['rol'] != 1) { header("Location: index.php"); exit(); }
        require_once 'app/models/Admin.php';
        $adminModel = new Admin($db);
        $especialidades = $adminModel->getEstadisticasCitas(); 
        require_once 'views/admin/especialidades.php';
        break;

        // Dentro del switch ($view) en index.php

    case 'crear_especialidad':
    if ($_SESSION['rol'] != 1) { header("Location: index.php"); exit(); }
    
    if (isset($_POST['nombre_especialidad'])) {
        require_once 'app/models/Admin.php';
        $adminModel = new Admin($db);
        $nombre = trim($_POST['nombre_especialidad']);

        // 1. Validar si ya existe
        if ($adminModel->existeEspecialidad($nombre)) {
            header("Location: index.php?view=gestion_usuarios&msg=error_duplicado");
        } else {
            // 2. Si no existe, crear
            $adminModel->crearEspecialidad($nombre);
            header("Location: index.php?view=gestion_usuarios&msg=success");
        }
        exit(); 
    }
    break;

    case 'crear_estado':
        if ($_SESSION['rol'] != 1) { header("Location: index.php"); exit(); }
        
        if (isset($_POST['nombre_estado'])) {
            require_once 'app/models/Admin.php';
            $adminModel = new Admin($db);
            $nombre = trim($_POST['nombre_estado']);

            // 1. Validar si ya existe
            if ($adminModel->existeEstado($nombre)) {
                header("Location: index.php?view=gestion_usuarios&msg=error_duplicado");
            } else {
                // 2. Si no existe, crear
                $adminModel->crearNuevoEstado($nombre); 
                header("Location: index.php?view=gestion_usuarios&msg=success");
            }
            exit();
        }
        break;
    default:
        // Si la vista no existe, redirige al login centralizado
        require_once 'views/login.php';
        break;
}