<?php
/**
 * ARCHIVO: index.php
 * Función: Enrutador principal y punto de entrada universal.
 */

// 1. Configuración de Sesión y Errores
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Importación de archivos base
require_once 'config/db.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/GestionController.php';

// 3. Inicialización de la Base de Datos
$database = new Database();
$db = $database->getConnection();

// 4. Capturar la acción y el rol (si existe)
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

// 5. Instanciar Controladores
$authCtrl = new AuthController($db);
$gestionCtrl = new GestionController($db);

// 6. ENRUTADOR (SWITCH)
switch ($action) {
    
    // --- ACCESO Y SEGURIDAD ---
    case 'login':
        include 'views/auth/login.php';
        break;

    case 'auth':
        $authCtrl->login();
        break;

    case 'logout':
        $authCtrl->logout();
        break;

  case 'dashboard':
    if ($rol) {
        $folders = [1 => 'admin', 2 => 'medico', 3 => 'pacient', 4 => 'secretaria'];
        $folder = isset($folders[$rol]) ? $folders[$rol] : 'auth';
        $file = "views/$folder/dashboard.php";
        
        if (file_exists($file)) {
            include $file;
        } else {
            echo "Error: La vista $file no existe.";
        }
    } else {
        header("Location: index.php?action=login");
        exit();
    }
    break;

    // --- MÉDICO Y ADMIN ---
case 'gestionar_disponibilidad':
    if ($rol == 2 || $rol == 1) {
        $gestionCtrl->disponibilidad();
    } else {
        header("Location: index.php?action=login");
    }
    break;


case 'guardarDisponibilidad': 
    if ($rol == 2 || $rol == 1) {
        $gestionCtrl->guardarDisponibilidad();
    } else {
        header("Location: index.php?action=login");
    }
    break;

    // --- ACCIÓN PARA ELIMINAR ---
case 'eliminar_horario':
    if ($rol == 2 || $rol == 1) {
        $gestionCtrl->eliminarHorario();
    } else {
        header("Location: index.php?action=login");
    }
    break;


    case 'buscar_paciente':
        if ($rol == 2 || $rol == 4 || $rol == 1) {
            $gestionCtrl->buscarPaciente();
        } else {
            header("Location: index.php?action=login");
        }
        break;

    // --- HISTORIAL (PACIENTE Y MÉDICO) ---
    case 'historial':
        if ($rol == 3 || $rol == 2) {
            $gestionCtrl->historial();
        } else {
            header("Location: index.php?action=login");
        }
        break;

    // --- ADMINISTRADOR (ROL 1) ---
    case 'usuarios':
        if ($rol == 1) {
            $gestionCtrl->gestionarUsuarios();
        } else {
            header("Location: index.php?action=login");
        }
        break;

    // --- REGISTRO ---
    case 'registro':
        include 'views/auth/registro.php';
        break;

    case 'register_post':
        $authCtrl->registrar();
        break;

        
case 'citas':
    if ($rol) {
        $gestionCtrl->citas();
    } else {
        header("Location: index.php?action=login");
    }
    break;

case 'citas_medico':
    if ($rol == 2 || $rol == 1 || $rol == 4) {
        $gestionCtrl->citas(); // Llamamos a la función que ya tienes en el controlador
    } else {
        header("Location: index.php?action=login");
    }
    break;

// --- LISTADO DE PACIENTES ---
case 'mis_pacientes':
    if ($rol == 2 || $rol == 1 || $rol == 4) {
        // Asegúrate de tener esta función en tu GestionController
        $gestionCtrl->buscarPaciente(); 
    } else {
        header("Location: index.php?action=login");
    }
    break;

case 'nueva_consulta':
    $gestionCtrl->mostrarConsulta();
    break;

case 'guardar_consulta':
    $gestionCtrl->guardarConsulta();
    break;

case 'editar_consulta':
    $gestionCtrl->mostrarConsulta(); // Usamos la misma función porque ella detecta el ID
    break;

    
    default:
        header("Location: index.php?action=login");
        break;
}