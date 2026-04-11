<?php
/**
 * Clase Usuario - Maneja la lógica de autenticación y registros
 * siguiendo el patrón de diseño orientado a objetos.
 */
class Usuario {
    private $db;
    private $table = "Usuario";

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Valida las credenciales del usuario
     */
    public function autenticar($nombre, $password) {
        $sql = "SELECT * FROM " . $this->table . " WHERE nombre_usuario = :user LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user', $nombre);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);

        // Verificamos si existe el usuario y si la contraseña coincide con el hash
        if ($row && password_verify($password, $row->contrasena)) {
            return $row;
        }
        return false;
    }

    /**
     * Verifica si un dato ya existe en una tabla específica
     * Útil para validar Cédula y Correo
     */
    public function validarDatoUnico($tabla, $columna, $valor) {
        $sql = "SELECT idpaciente FROM $tabla WHERE $columna = :valor LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['valor' => $valor]);
        return $stmt->fetch() ? true : false;
    }

    /**
     * Registro Integral de Paciente
     * Crea el registro en 'Usuario' y 'paciente' usando Transacciones SQL
     */
    public function registrarPaciente($datos) {
        try {
            // Iniciamos transacción: o se guarda todo o no se guarda nada
            $this->db->beginTransaction();

            // 1. Insertar en la tabla Usuario (Credenciales de acceso)
            // El id_rol para paciente es 3 por defecto
            $sqlUser = "INSERT INTO " . $this->table . " (nombre_usuario, contrasena, id_rol) 
                        VALUES (:user, :pass, :rol)";
            $stmtUser = $this->db->prepare($sqlUser);
            
            $hashed_pass = password_hash($datos['password'], PASSWORD_BCRYPT);
            $rol_paciente = 3; 

            $stmtUser->execute([
                'user' => $datos['usuario'],
                'pass' => $hashed_pass,
                'rol'  => $rol_paciente
            ]);

            // Obtenemos el ID generado para el usuario
            $id_usuario_generado = $this->db->lastInsertId();

            // 2. Insertar en la tabla paciente (Datos personales y correo)
            $sqlPac = "INSERT INTO paciente (nombre, apellido, cedula, correo, Usuario_id_usuario) 
                       VALUES (:nom, :ape, :ced, :correo, :uid)";
            $stmtPac = $this->db->prepare($sqlPac);
            
            $stmtPac->execute([
                'nom'    => $datos['nombre'],
                'ape'    => $datos['apellido'],
                'ced'    => $datos['cedula'],
                'correo' => $datos['correo'],
                'uid'    => $id_usuario_generado
            ]);

            // Si todo salió bien, confirmamos los cambios en la DB
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Si algo falla (ej. error de SQL), deshacemos los cambios
            $this->db->rollBack();
            // Para depuración puedes usar: error_log($e->getMessage());
            return false;
        }
    }
}