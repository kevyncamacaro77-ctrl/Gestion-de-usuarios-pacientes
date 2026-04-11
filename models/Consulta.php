<?php
class Consulta {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Trae todas las consultas con especialidad y datos del médico
    public function listarHistorialCompleto($id_usuario) {
        $sql = "SELECT 
                    con.idConsulta, 
                    con.fecha, 
                    con.diagnostico, 
                    con.motivo,
                    m.nombre AS medico, 
                    esp.nombre_especialidad AS especialidad
                FROM Consulta con
                JOIN paciente p ON con.paciente_idpaciente = p.idpaciente
                JOIN medico m ON con.medico_idmedico = m.idmedico
                JOIN medico_especialidad me ON m.idmedico = me.medico_idmedico
                JOIN Especialidad esp ON me.Especialidad_id_especialidad = esp.id_especialidad
                WHERE p.Usuario_id_usuario = :id
                ORDER BY con.fecha DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Trae los exámenes y procedimientos de una consulta específica
    public function obtenerDetallesAnexos($id_consulta) {
        $detalles = [];
        
        // Buscar Exámenes
        $sqlEx = "SELECT nombre_examen, resultado, lado_ojo FROM Examenes WHERE Consulta_idConsulta = :id";
        $stmtEx = $this->db->prepare($sqlEx);
        $stmtEx->execute(['id' => $id_consulta]);
        $detalles['examenes'] = $stmtEx->fetchAll(PDO::FETCH_OBJ);

        // Buscar Procedimientos
        $sqlProc = "SELECT nota_medica, fecha FROM Procedimiento WHERE Consulta_idConsulta = :id";
        $stmtProc = $this->db->prepare($sqlProc);
        $stmtProc->execute(['id' => $id_consulta]);
        $detalles['procedimientos'] = $stmtProc->fetchAll(PDO::FETCH_OBJ);

        return $detalles;
    }

    public function obtenerPorPaciente($id_usuario) {
    // Esta consulta une las tablas para traer el nombre del médico y la fecha
    $sql = "SELECT c.*, m.nombre as nombre_medico 
            FROM Consulta c
            JOIN medico m ON c.medico_idmedico = m.idmedico
            JOIN paciente p ON c.paciente_idpaciente = p.idpaciente
            WHERE p.Usuario_id_usuario = :id_usuario
            ORDER BY c.fecha DESC";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id_usuario' => $id_usuario]);
    
    // IMPORTANTE: Como usas flechas (->) en la vista, usamos FETCH_OBJ
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
}