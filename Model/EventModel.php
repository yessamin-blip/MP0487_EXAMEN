<?php

class EventModel {

    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=mp0487_spark", "root", "");
            //code...
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            //throw $th;
            echo "Error" . $e->getMessage();
        }
    }

    public function register($nombre, $descripcion, $fecha_evento, $ubicacion, $lat = null, $lng = null) {
        try {
            $sql = "INSERT INTO Evento (Nombre_evento, Descripcion, Fecha_evento, Ubicacion, Lat, Lng) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$nombre, $descripcion, $fecha_evento, $ubicacion, $lat, $lng]);
            return "ok";
        } catch (PDOException $e) {
            error_log("DEBUG Model: Exception capturada en register: " . $e->getMessage());
            return "error_base_datos";
        }
        

    }  

    public function getEventById($Id_Evento) {
        try {
            $sql = "SELECT * FROM Evento WHERE Id_Evento = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$Id_Evento]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DEBUG Model: Exception capturada en getEventById: " . $e->getMessage());
            return "error_base_datos";
        }
    }

public function getEvents($Id_Evento = null) {
    try {
        if ($Id_Evento) {
            return $this->getEventById($Id_Evento);
        } else {
            $sql = "SELECT * FROM Evento";
            $stmt = $this->conn->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("getEvents result: " . print_r($result, true)); // ← añade esto
            return $result;
        }
    } catch (PDOException $e) {
        error_log("DEBUG Model: Exception capturada en getEvents: " . $e->getMessage());
        return "error_base_datos";
    }
}

    public function updateEvent($Id_Evento, $nombre, $descripcion, $fecha_evento, $ubicacion ) {
        if(empty($Id_Evento) || empty($nombre) || empty($descripcion) || empty($fecha_evento) || empty($ubicacion)) {
            return "campos_vacios";
        } else {
            try {
                $sql = "UPDATE Evento SET Nombre_evento = ?, Descripcion = ?, Fecha_evento = ?, Ubicacion = ? WHERE Id_Evento = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$nombre, $descripcion, $fecha_evento, $ubicacion, $Id_Evento]);
                $rowCount = $stmt->rowCount();
                if ($rowCount === 0) {
                    return "evento_no_encontrado";
                }
                return "ok";
            } catch (PDOException $e) {
                error_log("DEBUG Model: Exception capturada en updateEvent: " . $e->getMessage());
                return "error_base_datos";
            }
        }
                        
    }


    public function deleteEvent($Id_Evento) {
       
           // Implementation for deleting event
        if (empty($Id_Evento)) {
            return "id_vacio";
        }else {
            try {
                $sql = "DELETE FROM Evento WHERE Id_Evento = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$Id_Evento]);
                $rowCount = $stmt->rowCount();
                if ($rowCount === 0) {
                    return "evento_no_encontrado";
                }
                return "ok";
            } catch (PDOException $e) {
                error_log("DEBUG Model: Exception capturada en deleteEvent: " . $e->getMessage());
                return "error_base_datos";
            }
        }
    }
}
?>