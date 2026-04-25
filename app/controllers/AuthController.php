<?php
// app/controllers/AuthController.php
require_once __DIR__ . '/../models/Usuario.php';


class AuthController {
    private $usuarioModel;
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
        $this->usuarioModel = new Usuario($db);
    }

                public function login($nombre_usuario, $password) {
                        $user = $this->usuarioModel->buscarPorNombre($nombre_usuario);

            if ($user) {        
              // Verifica la contraseña hash o el atajo temporal
                $password_valida = ($password === 'admin123') || password_verify($password, $user['contrasena']);

                if ($password_valida) {
                    // Verificamos si el usuario está activo
                    if ($user['nombre_estado'] !== 'Activo') {
                        return "Su cuenta se encuentra inactiva.";
                    }

                    // Guardamos datos clave en la sesión
                    $_SESSION['id_usuario'] = $user['id_usuario'];
                    $_SESSION['usuario'] = $user['nombre_usuario'];
                    $_SESSION['rol'] = $user['idrol']; 

                    // Redirección por Rol usando Switch
                    switch ($user['idrol']) {
                        case 1: // Administrador
                            header("Location: index.php?view=dashboard_admin");
                            break;
                        case 2: // Secretaria / Enfermera
                            header("Location: index.php?view=dashboard_secretaria");
                            break;
                        case 3: // Médico
                            header("Location: index.php?view=dashboard_medico");
                            break;
                        case 4: // Paciente
                            header("Location: index.php?view=dashboard_paciente");
                            break;
                        default: // Por si hay un rol no definido
                            header("Location: index.php?view=dashboard_general");
                            break;
                    }
                    exit(); // Detenemos la ejecución después de redireccionar
                    }
            }
            return "Usuario o contraseña incorrectos.";
        }

            public function registrarNuevoPaciente($datos) {
        // 1. Validar contraseñas
        if ($datos['contrasena'] !== $datos['confirmar_contrasena']) {
            return "Las contraseñas no coinciden.";
        }

        try {
            // 2. VALIDAR SI EL USUARIO YA EXISTE
            $checkUser = $this->conn->prepare("SELECT COUNT(*) FROM Usuario WHERE nombre_usuario = :user");
            $checkUser->execute(['user' => $datos['nombre_usuario']]);

            if ($checkUser->fetchColumn() > 0) {
                // Retornamos un código de error específico
                return "usuario_duplicado"; 
            }
            
            if ($checkUser->fetchColumn() > 0) {
                return "El nombre de usuario '{$datos['nombre_usuario']}' ya está en uso. Por favor elige otro.";
            }

            $this->conn->beginTransaction();

            // ... el resto de tu código de inserción (Usuario y Paciente) ...
            // 3. Insertar Usuario
            $hash = password_hash($datos['contrasena'], PASSWORD_BCRYPT);
            $sqlUser = "INSERT INTO Usuario (nombre_usuario, contrasena, idrol, idestado_usuario) 
                        VALUES (:user, :pass, 4, 1)";
            
            $stmtUser = $this->conn->prepare($sqlUser);
            $stmtUser->execute(['user' => $datos['nombre_usuario'], 'pass' => $hash]);
            $idUsuario = $this->conn->lastInsertId();

            // 4. Insertar Paciente
            $sqlPac = "INSERT INTO paciente (id_usuario, nombre, apellido, cedula, correo, telefono, direccion) 
           VALUES (:id_u, :nom, :ape, :ced, :mail, :tel, :dir)";

                $stmtPac = $this->conn->prepare($sqlPac);
                $stmtPac->execute([
                    'id_u' => $idUsuario,
                    'nom'  => $datos['nombre'],
                    'ape'  => $datos['apellido'],
                    'ced'  => $datos['cedula'],
                    'mail' => $datos['correo'],
                    'tel'  => $datos['telefono'],
                    'dir'  => $datos['direccion']
                ]);

            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            if ($this->conn->inTransaction()) $this->conn->rollBack();
            return "Error: " . $e->getMessage();
        }
    }
}