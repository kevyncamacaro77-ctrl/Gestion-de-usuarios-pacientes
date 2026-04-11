<?php
/**
 * ARCHIVO: index.php
 * Función: Enrutador principal del sistema Fundación Adventista
 */

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
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?action=login");
        exit();
    }
    
    include 'views/auth/dashboard.php'; 
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