<?php
/**
 * Clase Usuario - Maneja la lógica de autenticación y registros
 */
class Usuario {
    private $db;
    private $table = "usuario";

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Valida las credenciales del usuario
     */
public function autenticar($user, $pass) {
    $user = trim($user);
    $sql = "SELECT * FROM usuario WHERE nombre_usuario = :user LIMIT 1";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':user', $user);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_OBJ);

    if ($usuario) {
        // SI ES EL MÉDICO, deja pasar con "123" sin cifrar para probar
        if ($user === 'doctor_kevyn' && $pass === '123') {
            return $usuario;
        }

        // Para los demás (como pepe), usa la seguridad normal
        if (password_verify($pass, $usuario->contrasena)) {
            return $usuario;
        }
    }
    return false;
}

    /**
     * Verifica si un dato ya existe en una tabla específica
     */
    public function validarDatoUnico($tabla, $columna, $valor) {
        // Usamos una consulta genérica para que sirva en cualquier tabla
        $sql = "SELECT * FROM $tabla WHERE $columna = :valor LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['valor' => $valor]);
        return $stmt->fetch() ? true : false;
    }

    /**
     * Registro Integral de Paciente con Transacciones
     */
    public function registrarPaciente($datos) {
        try {
            $this->db->beginTransaction();

            // 1. Insertar en la tabla Usuario
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

            $id_usuario_generado = $this->db->lastInsertId();

            // 2. Insertar en la tabla paciente
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

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}