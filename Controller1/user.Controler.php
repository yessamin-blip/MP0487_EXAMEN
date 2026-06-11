<?php


require_once("../Model/UserModel.php");

class User_Controler
{

    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }
    

    

    function register($nombre, $email, $password, $usuario, $ruta = null)
    {
        if (empty($nombre) || empty($email) || empty($password)) {
            return "campos_vacios";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "email_invalido";
        }

        if (strlen($password) < 4) {
            return "password_corta";
        }

        try {
            $ok = $this->model->register($nombre, $email, $password, $usuario, $ruta);
            if ($ok) {
                return "ok";
            }

        } catch (PDOException $e) {
            // DEBUG: ver qué error capturó
            error_log("DEBUG Controller: Exception capturada: " . $e->getMessage());

            // Detectar específicamente cuál campo está duplicado
            $errorMsg = $e->getMessage();

            if (strpos($errorMsg, 'Duplicate entry') !== false) {
                // Detectar si es el nombre de usuario duplicado
                if (strpos($errorMsg, 'Nombre_Usuario') !== false) {
                    return "usuario_existe";
                }
                // Detectar si es el correo duplicado
                if (strpos($errorMsg, 'Correo') !== false) {
                    return "correo_existe";
                }
                // Si ambos o no se puede determinar
                return "usuario_o_email_duplicado";
            }
            return "error_base_datos";
        }
    }

    function login($email, $password)
    {
        if (empty($email) || empty($password)) {
            return false;
        }

        $user = $this->model->login($email, $password);

        if ($user) {
            // RETORNAMOS EL ARRAY COMPLETO, NO SOLO "OK"
            return $user;
        } else {
            return false;
        }
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        header("Location: login.php");
        exit();
    }

    public function updateProfile($nombre, $email, $password, $ruta = null)
    {
        $nombre_usuario_actual = $_SESSION['user_nombre'];

        if (empty($nombre) || empty($email) || empty($password)) {
            return "campos_vacios";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "email_invalido";
        }

        if (strlen($password) < 4) {
            return "password_corta";
        }

        try {
            $ok = $this->model->updateProfile($nombre_usuario_actual, $nombre, $email, $password, $ruta);
            if ($ok) {
                // Actualizamos la sesión con el nuevo nombre
                $_SESSION['user_nombre'] = $nombre;
                $_SESSION['user_email'] = $email;
                return "ok";
            } else {
                return "error";
            }
        } catch (PDOException $e) {
            error_log("DEBUG Controller: Exception capturada: " . $e->getMessage());

            $errorMsg = $e->getMessage();

            if (strpos($errorMsg, 'Duplicate entry') !== false) {
                if (strpos($errorMsg, 'Nombre_Usuario') !== false) {
                    return "usuario_existe";
                }
                if (strpos($errorMsg, 'Correo') !== false) {
                    return "correo_existe";
                }
                return "usuario_o_email_duplicado";
            }
            return "error_base_datos";

        }
    }

    public function deleteProfile($email)
    {
        try {
            $ok = $this->model->deleteProfile($email);
            if ($ok) {
                return "ok";
            }
        } catch (PDOException $e) {
            error_log("DEBUG Controller: Exception capturada: " . $e->getMessage());
            return "error_base_datos";
        }
    }
    public function getUserById($nombre)
    {
        return $this->model->getUserById($nombre);
    }
}
?>