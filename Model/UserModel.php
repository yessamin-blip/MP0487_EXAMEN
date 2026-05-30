<?php

class UserModel {

    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=mp0487_spark;charset=utf8mb4", "root", "");
            //code...
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES utf8mb4");
        } catch (PDOException $e) {
            //throw $th;
            echo "Error" . $e->getMessage();
        }
    }

    public function register($nombre, $email, $password,  $usuario ,$ruta = null) {

        if ($ruta) {
            $sql = "INSERT INTO Usuario (Nombre_Usuario, Correo, Contrasena, id_perfil, Imagen)
                    VALUES (?, ?, ?, ?, ?)";
        } else {
            $sql = "INSERT INTO Usuario (Nombre_Usuario, Correo, Contrasena, id_perfil)
                    VALUES (?, ?, ?, ?)";
        }
     $stmt = $this->conn->prepare($sql);
        if ($ruta) {
            return $stmt->execute([$nombre, $email,password_hash($password, PASSWORD_DEFAULT), $usuario, $ruta]);
        } else {
            return $stmt->execute([$nombre, $email, password_hash($password, PASSWORD_DEFAULT), $usuario]);
            }
            
            
    }



    public function login($email, $password) {
      $sql = "SELECT * FROM Usuario WHERE Correo = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$email]);
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Si existe el usuario Y la contraseña es correcta
   if ($usuario && password_verify($password, $usuario['Contrasena'])) {
        return $usuario; // devuelves todos los datos del usuario
    }
    
    return false;
    }

    public function getUserById($nombre) {
        $sql = "SELECT * FROM Usuario WHERE Nombre_Usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nombre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($nombre_usuario_actual, $nombre, $email, $password, $ruta = null) {
    if ($ruta) {
        $sql = "UPDATE Usuario 
                SET Nombre_Usuario=?, Correo=?, Contrasena=?, Imagen=? 
                WHERE Nombre_Usuario=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $nombre,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $ruta,
            $nombre_usuario_actual
        ]);
    } else {
        $sql = "UPDATE Usuario 
                SET Nombre_Usuario=?, Correo=?, Contrasena=? 
                WHERE Nombre_Usuario=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $nombre,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $nombre_usuario_actual
        ]);
    }
}

public function deleteProfile ($email){
    $sql = "DELETE FROM Usuario WHERE Correo = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$email]);
    
}
}
?>