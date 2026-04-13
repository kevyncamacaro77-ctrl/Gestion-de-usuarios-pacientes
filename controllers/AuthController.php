<?php
require_once 'models/Usuario.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new Usuario($db);
    }

    
public function login() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
        $pass = isset($_POST['password']) ? trim($_POST['password']) : '';

        $auth = $this->userModel->autenticar($user, $pass);

        if ($auth) {
            if (session_status() === PHP_SESSION_NONE) session_start();
            session_unset();
            $_SESSION['user_id'] = $auth->id_usuario;
            $_SESSION['nombre'] = $auth->nombre_usuario;
            $_SESSION['rol'] = $auth->id_rol;

            header("Location: index.php?action=dashboard");
            exit(); 
        } else {
            // ESTO ES LO QUE NECESITO QUE ME DIGAS QUÉ SALE:
            die("Error de Login: El usuario '$user' con la clave '$pass' fue rechazado por el modelo.");
        }
    }
}

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }

   public function registrar() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // 1. Validar Cédula (Ya lo tenías)
        if ($this->userModel->validarDatoUnico('paciente', 'cedula', $_POST['cedula'])) {
            header("Location: index.php?action=registro&error=cedula_duplicada");
            exit();
        }

        // 2. Validar Correo (Ya lo tenías)
        if ($this->userModel->validarDatoUnico('paciente', 'correo', $_POST['correo'])) {
            header("Location: index.php?action=registro&error=correo_duplicado");
            exit();
        }

        // 3. NUEVA VALIDACIÓN: Nombre de Usuario
        // Asumiendo que en tu base de datos la columna se llama 'usuario'
        if ($this->userModel->validarDatoUnico('usuarios', 'usuario', $_POST['usuario'])) {
            header("Location: index.php?action=registro&error=usuario_duplicado");
            exit();
        }

        // 4. Si todo está limpio, registrar
        $res = $this->userModel->registrarPaciente($_POST);
        
        if ($res) {
            header("Location: index.php?action=login&success=registrado");
        } else {
            header("Location: index.php?action=registro&error=fallo_registro");
        }
        exit();
    }
}
}