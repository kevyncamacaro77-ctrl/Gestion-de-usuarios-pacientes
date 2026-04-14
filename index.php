<?php
/**
 * ARCHIVO: index.php
 * Función: Enrutador principal y punto de entrada universal.
 * Versión optimizada con DashboardController.
 */

// 1. Configuración de Sesión y Errores
session_start();
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Importación de archivos base (Controladores y DB)
require_once 'controllers/MedicoController.php';
require_once 'controllers/CitaController.php';
require_once 'config/db.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/GestionController.php';
require_once 'controllers/DashboardController.php'; // Nuevo controlador para las vistas principales

// 3. Inicialización de la Base de Datos
$database = new Database();
$db = $database->getConnection();

// 4. Capturar la acción y el rol (si existe)
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

// 5. Instanciar Controladores
$authCtrl = new AuthController($db);
$gestionCtrl = new GestionController($db);
$dashboardCtrl = new DashboardController($db); // Instanciamos el gestor de tableros
$medicoCtrl = new MedicoController($db);
$citaCtrl = new CitaController($db);

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

    case 'registro':
        include 'views/auth/registro.php';
        break;

    case 'register_post':
        $authCtrl->registrar();
        break;

    // --- DASHBOARD CENTRALIZADO ---
    case 'dashboard':
        // El DashboardController decide qué cargar según el rol y limpia datos fantasmas
        $dashboardCtrl->index();
        break;

    // --- DISPONIBILIDAD (MÉDICO Y ADMIN) ---
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

    case 'eliminar_horario':
        if ($rol == 2 || $rol == 1) {
            $gestionCtrl->eliminarHorario();
        } else {
            header("Location: index.php?action=login");
        }
        break;

    // --- GESTIÓN DE PACIENTES Y CONSULTAS ---
    case 'buscar_paciente':
        // El paciente (rol 3 en tu sistema anterior, ajustado a 4 según necesites) también puede buscar
        if ($rol == 2 || $rol == 1 || $rol == 4) {
            $gestionCtrl->buscarPaciente();
        } else {
            header("Location: index.php?action=login");
        }
        break;

    case 'mis_pacientes':
        if ($rol == 2 || $rol == 1) {
            $gestionCtrl->buscarPaciente(); 
        } else {
            header("Location: index.php?action=login");
        }
        break;

    case 'nueva_consulta':
    case 'editar_consulta':
        if ($rol == 2 || $rol == 1) {
            $gestionCtrl->mostrarConsulta(); // Muestra el formulario de historia clínica
        } else {
            header("Location: index.php?action=login");
        }
        break;

    case 'guardar_consulta':
        if ($rol == 2 || $rol == 1) {
            $gestionCtrl->guardarConsulta();
        } else {
            header("Location: index.php?action=login");
        }
        break;

    // --- HISTORIAL Y CITAS ---
    case 'historial':
        $gestionCtrl->historial();
        break;

    case 'citas':
    case 'citas_medico':
        if ($rol) {
            $gestionCtrl->citas();
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

        case 'getMedicosPorEspecialidad':
        $medicoCtrl->getMedicosPorEspecialidad();
        break;

        case 'getHorariosDisponibles':
        $medicoCtrl->getHorariosDisponibles();
        break;

        case 'nueva_consulta': // La acción del icono médico
        $medicoController->mostrarFormularioConsulta();
        break; // <--- SI FALTA ESTO, PASA AL SIGUIENTE Y TE CIERRA SESIÓN

       case 'guardar_cita': 
        $citaCtrl->guardarCita(); 
        break;

     case 'atender': // Cambié el nombre para que coincida con el icono del estetoscopio
        if ($rol == 2 || $rol == 1) {
            $gestionCtrl->mostrarConsulta(); 
        }
        break;

     case 'cancelar_cita': 
        // USAMOS $citaCtrl que es como lo definiste arriba
        if (isset($_GET['id'])) {
            $citaCtrl->cancelar($_GET['id']);
        }
        break; 

 
        default:
        // Si hay sesión, mándalo al dashboard, no al login, para evitar cierres molestos
        if (isset($_SESSION['rol'])) {
            header("Location: index.php?action=dashboard");
        } else {
            header("Location: index.php?action=login");
        }
        break;
}