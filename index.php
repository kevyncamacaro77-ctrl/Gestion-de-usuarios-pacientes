<?php
/**
 * ARCHIVO: index.php
 * Función: Enrutador principal del sistema Fundación Adventista
 */

session_start();
require_once 'config/db.php';
require_once 'controllers/AuthController.php';

// Iniciamos la base de datos
$database = new Database();
$db = $database->getConnection();

// Capturamos la acción (si no hay, por defecto es login)
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Lógica de enrutamiento básica
switch ($action) {
    case 'login':
        include 'views/auth/login.php';
        break;

    case 'auth':
        $controller = new AuthController($db);
        $controller->login();
        break;


    case 'dashboard':
    if (isset($_SESSION['rol'])) {
        $rol = $_SESSION['rol'];
        
        // Mapeo de roles a carpetas
        if ($rol == 1) $folder = 'admin';
        elseif ($rol == 2) $folder = 'medico';
        elseif ($rol == 3) $folder = 'pacient';
        elseif ($rol == 4) $folder = 'secretaria';
        else $folder = 'auth';

        $file = "views/$folder/dashboard.php";

        if (file_exists($file)) {
            include $file;
        } else {
            echo "Error: El archivo $file no existe. Revisa la mudanza.";
        }
    } else {
        header("Location: index.php?action=login");
    }
    break;

    case 'logout':
        $controller = new AuthController($db);
        $controller->logout();
        break;

    case 'registro':
        include 'views/auth/registro.php';
        break;

    case 'register_post':
        $auth = new AuthController($db);
        $auth->registrar();
        break;

        case 'citas':
    require_once 'controllers/GestionController.php';
    $controller = new GestionController($db);
    $controller->citas();
    break;

    case 'historial':
    require_once 'controllers/GestionController.php';
    $controller = new GestionController($db);
    $controller->historial();
    break;

    default:
        include 'views/auth/login.php';
        break;


}