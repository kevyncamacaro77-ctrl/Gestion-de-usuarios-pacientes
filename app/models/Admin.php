<?php
class Admin {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener citas contadas por cada especialidad
    public function getEstadisticasCitas() {
        $sql = "SELECT 
                    e.nombre_especialidad, 
                    COUNT(c.id_cita) as total_citas
                FROM Especialidad e
                LEFT JOIN medico_especialidad me ON e.id_especialidad = me.id_especialidad
                LEFT JOIN medico m ON me.idmedico = m.idmedico
                LEFT JOIN cita c ON m.idmedico = c.medico_idmedico
                GROUP BY e.id_especialidad, e.nombre_especialidad";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener el total de pacientes registrados
    public function getTotalPacientes() {
        $sql = "SELECT COUNT(*) as total FROM paciente";
        $stmt = $this->conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }


    public function listarUsuarios() {
        $sql = "SELECT u.id_usuario, u.nombre_usuario, r.nombre_rol, e.nombre_estado, e.idestado_usuario
                FROM Usuario u
                JOIN rol r ON u.idrol = r.idrol
                JOIN estado_usuario e ON u.idestado_usuario = e.idestado_usuario";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstadoUsuario($idUsuario, $idEstado) {
        $sql = "UPDATE Usuario SET idestado_usuario = :estado WHERE id_usuario = :id";
        return $this->conn->prepare($sql)->execute(['estado' => $idEstado, 'id' => $idUsuario]);
    }

    public function listarRoles() {
        return $this->conn->query("SELECT * FROM rol")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarEstados() {
        return $this->conn->query("SELECT * FROM estado_usuario")->fetchAll(PDO::FETCH_ASSOC);
    }
   
   public function crearEspecialidad($nombre) {
    // 1. Verificar si ya existe (Case Insensitive)
    $check = $this->conn->prepare("SELECT id_especialidad FROM Especialidad WHERE LOWER(nombre_especialidad) = LOWER(:nombre)");
    $check->execute(['nombre' => $nombre]);
    
    if ($check->fetch()) {
        return false; // Retorna falso si ya existe
    }

    // 2. Si no existe, insertar
    $sql = "INSERT INTO Especialidad (nombre_especialidad) VALUES (:nombre)";
    return $this->conn->prepare($sql)->execute(['nombre' => $nombre]);
}

public function crearNuevoEstado($nombre) {
    // 1. Verificar si ya existe
    $check = $this->conn->prepare("SELECT idestado_usuario FROM estado_usuario WHERE LOWER(nombre_estado) = LOWER(:nombre)");
    $check->execute(['nombre' => $nombre]);

    if ($check->fetch()) {
        return false;
    }

    // 2. Si no existe, insertar
    $sql = "INSERT INTO estado_usuario (nombre_estado) VALUES (:nombre)";
    return $this->conn->prepare($sql)->execute(['nombre' => $nombre]);
}
// Verificar si la especialidad ya existe
public function existeEspecialidad($nombre) {
    $sql = "SELECT COUNT(*) FROM Especialidad WHERE nombre_especialidad = :nombre";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['nombre' => $nombre]);
    return $stmt->fetchColumn() > 0;
}

// Verificar si el estado ya existe
public function existeEstado($nombre) {
    $sql = "SELECT COUNT(*) FROM estado_usuario WHERE nombre_estado = :nombre";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['nombre' => $nombre]);
    return $stmt->fetchColumn() > 0;
}
}