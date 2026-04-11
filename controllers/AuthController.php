<?php
require_once 'models/Usuario.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new Usuario($db);
    }

   public function login() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = trim($_POST['usuario']);
        $pass = trim($_POST['password']);

        // El modelo devuelve un array con los datos del usuario si tiene éxito
        $auth = $this->userModel->autenticar($user, $pass);

        if ($auth) {
         session_start();
         // CORRECCIÓN: Usar sintaxis de objeto -> en lugar de array []
          $_SESSION['user_id'] = $auth->id_usuario;
          $_SESSION['nombre'] = $auth->nombre_usuario;
          $_SESSION['rol'] = $auth->id_rol;

           header("Location: index.php?action=dashboard");
            exit();
        } else {
            header("Location: index.php?action=login&error=1");
            exit();
        }
    }
}

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }

  public function registrar() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // 1. Validar Cédula única (Usando el método genérico)
        if ($this->userModel->validarDatoUnico('paciente', 'cedula', $_POST['cedula'])) {
            header("Location: index.php?action=registro&error=cedula_duplicada");
            exit();
        }

        // 2. Validar Correo único (Indispensable ahora que lo agregaste)
        if ($this->userModel->validarDatoUnico('paciente', 'correo', $_POST['correo'])) {
            header("Location: index.php?action=registro&error=correo_duplicado");
            exit();
        }

        // 3. Ejecutar el registro integral (Usuario + Paciente)
        $res = $this->userModel->registrarPaciente($_POST);
        
        if ($res) {
            header("Location: index.php?action=login&success=registrado");
        } else {
            header("Location: index.php?action=registro&error=fallo_registro");
        }
    }
}
}