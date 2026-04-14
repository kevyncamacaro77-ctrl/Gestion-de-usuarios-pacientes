<?php
class Cita {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function listarTodo() {
        $sql = "SELECT c.id_cita, d.fecha, d.horainicio, p.nombre as paciente, 
                       m.nombre as nombre_medico, c.motivo, d.estatus as estado 
                FROM cita c
                JOIN paciente p ON c.idpaciente = p.idpaciente
                JOIN disponibilidad d ON c.id_disponibilidad = d.id_disponibilidad
                JOIN medico m ON d.idmedico = m.idmedico
                ORDER BY d.fecha ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Listar según el usuario (Paciente o Médico) - AJUSTADO
        public function listarPorUsuario($id_usuario, $rol) {
        if ($rol == 3) { // Paciente
            // Usamos AS nombre_medico y AS estado para que la vista los encuentre
            $sql = "SELECT c.id_cita, d.fecha, d.horainicio, m.nombre as nombre_medico, 
                        c.motivo, d.estatus as estado 
                    FROM cita c
                    JOIN paciente p ON c.idpaciente = p.idpaciente
                    JOIN disponibilidad d ON c.id_disponibilidad = d.id_disponibilidad
                    JOIN medico m ON d.idmedico = m.idmedico
                    WHERE p.Usuario_id_usuario = :id";
        } else { // Médico
            $sql = "SELECT c.id_cita, d.fecha, d.horainicio, p.nombre as paciente, 
                        c.motivo, d.estatus as estado 
                    FROM cita c
                    JOIN paciente p ON c.idpaciente = p.idpaciente
                    JOIN disponibilidad d ON c.id_disponibilidad = d.id_disponibilidad
                    JOIN medico m ON d.idmedico = m.idmedico
                    WHERE m.Usuario_id_usuario = :id";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function eliminar($id) {
        $sql = "DELETE FROM cita WHERE id_cita = :id";
        return $this->db->prepare($sql)->execute(['id' => $id]);
    }

  public function index() {
    // Consulta exacta a tu tabla
    $sql = "SELECT id_especialidad, nombre_especialidad FROM especialidad";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    
    // Retornamos el array para que el controlador lo reciba
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}