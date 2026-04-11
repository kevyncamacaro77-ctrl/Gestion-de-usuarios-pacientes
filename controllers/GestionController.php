<?php
require_once 'models/Cita.php';
require_once 'models/Consulta.php';

class GestionController {
    private $db;
    private $citaModel;
    private $consultaModel;

    public function __construct($db) {
        $this->db = $db;
        $this->citaModel = new Cita($db);
        $this->consultaModel = new Consulta($db);
    }

    // Función principal de Citas (Ver, Crear, Borrar)
    public function citas() {
        session_start();
        if (!isset($_SESSION['user_id'])) header("Location: index.php");

        $rol = $_SESSION['rol'];
        $id = $_SESSION['user_id'];

        // Lógica de acciones rápidas
        if (isset($_GET['delete_id']) && $rol <= 2) {
            $this->citaModel->eliminar($_GET['delete_id']);
            header("Location: index.php?action=citas");
        }

        // Obtener listado según quien lo vea
        $citas = ($rol == 1) ? $this->citaModel->listarTodo() : $this->citaModel->listarPorUsuario($id, $rol);
        
        include 'views/citas_principal.php';
    }

    // Función de Historial/Consultas
    public function historial() {
    session_start();
    if (!isset($_SESSION['user_id'])) header("Location: index.php");

    $consultaModel = new Consulta($this->db);
    // Traemos el historial con especialidades
    $historial = $consultaModel->listarHistorialCompleto($_SESSION['user_id']);
    
    include 'views/historial_paciente.php';
}
}