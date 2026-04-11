<?php
require_once 'models/Cita.php';
require_once 'models/Consulta.php';

class Gestion {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function citas() {
        session_start();
        if (!isset($_SESSION['user_id'])) header("Location: index.php");

        $citaModel = new Cita($this->db);
        $citas = $citaModel->listarPorUsuario($_SESSION['user_id'], $_SESSION['rol']);
        
        // Si es paciente, va a su carpeta. Si es médico/secretaria, a la suya.
        if ($_SESSION['rol'] == 3) {
            include 'views/pacient/citas.php'; // Asegúrate de mover citas_principal aquí
        } else {
            include 'views/medico/agenda.php';
        }
    }

    public function historial() {
        session_start();
        if (!isset($_SESSION['user_id'])) header("Location: index.php");

        $consultaModel = new Consulta($this->db);
        
        // Usamos el método que creamos para el nuevo MER
        $historial = $consultaModel->obtenerDetalleClinico($_SESSION['user_id']);
        
        // RUTA CORREGIDA: Apunta a la carpeta 'pacient'
        include 'views/pacient/historial_paciente.php';
    }

    public function dashboard() {
    session_start();
    if (!isset($_SESSION['rol'])) {
        header("Location: index.php?action=login");
        exit;
    }

    $rol = $_SESSION['rol'];

    // Aquí resolvemos el tema de roles de forma limpia
    switch ($rol) {
        case 1: include 'views/admin/dashboard.php'; break;
        case 2: include 'views/medico/dashboard.php'; break;
        case 3: include 'views/pacient/dashboard.php'; break; 
        case 4: include 'views/secretaria/dashboard.php'; break;
        default: include 'views/auth/login.php'; break;
    }
}


}