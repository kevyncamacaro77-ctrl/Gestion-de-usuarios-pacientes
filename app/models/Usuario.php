<?php
// app/models/Usuario.php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Busca un usuario por su nombre e incluye su rol y su estado de actividad.
     */
    public function buscarPorNombre($nombre) {
        $sql = "SELECT u.*, r.nombre_rol, e.nombre_estado 
                FROM Usuario u 
                INNER JOIN rol r ON u.idrol = r.idrol 
                INNER JOIN estado_usuario e ON u.idestado_usuario = e.idestado_usuario
                WHERE u.nombre_usuario = :nombre LIMIT 1";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['nombre' => $nombre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}