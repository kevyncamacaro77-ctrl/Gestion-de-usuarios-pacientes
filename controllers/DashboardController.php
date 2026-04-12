<?php
/**
 * ARCHIVO: controllers/DashboardController.php
 * Función: Preparar datos y cargar la vista principal según el rol.
 */
class DashboardController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        if (!isset($_SESSION['rol'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $rol = $_SESSION['rol'];
        $id_usuario = $_SESSION['user_id'];

        // Switch centralizado para todos los roles
        switch ($rol) {
            case 1: // Administrador
                $this->adminDashboard();
                break;
            case 2: // Médico
                $this->medicoDashboard();
                break;
            case 3: // Paciente (Ajustado según tu estructura)
                $this->pacienteDashboard($id_usuario);
                break;
            case 4: // Secretaria
                $this->secretariaDashboard();
                break;
            default:
                header("Location: index.php?action=login");
                break;
        }
    }

    private function pacienteDashboard($id_usuario) {
        // Busca el ID de paciente vinculado al usuario para evitar "citas fantasmas"
        $stmt = $this->db->prepare("SELECT idpaciente FROM paciente WHERE Usuario_id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

        $proximas_citas = [];
        if ($paciente) {
            $id_p = $paciente['idpaciente'];
            $stmtC = $this->db->prepare("SELECT * FROM cita WHERE idpaciente = ? ORDER BY id_cita DESC LIMIT 5");
            $stmtC->execute([$id_p]);
            $proximas_citas = $stmtC->fetchAll(PDO::FETCH_OBJ);
        }
        $this->loadView('pacient/dashboard.php', ['proximas_citas' => $proximas_citas]);
    }

    private function medicoDashboard() {
        // Aquí podrías cargar, por ejemplo, cuántas citas tiene el médico hoy
        $this->loadView('medico/dashboard.php');
    }

    private function adminDashboard() {
        // Datos estadísticos globales para el admin
        $this->loadView('admin/dashboard.php');
    }

    private function secretariaDashboard() {
        // Citas globales para la recepción
        $this->loadView('secretaria/dashboard.php');
    }

    // Función auxiliar para cargar vistas y evitar errores de "File not found"
    private function loadView($path, $data = []) {
        extract($data); // Convierte el array en variables (ej: $proximas_citas)
        $file = "views/$path";
        
        if (file_exists($file)) {
            include $file;
        } else {
            echo "<div style='padding:20px; border:2px solid red;'>
                    <h3>Error de Sistema</h3>
                    <p>No se encontró la vista: <b>$file</b></p>
                    <p>Por favor, crea la carpeta y el archivo correspondiente.</p>
                  </div>";
        }
    }
}