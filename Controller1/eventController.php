<?php


require_once("../Model/EventModel.php");

class EventController
{

    private $model;

    public function __construct()
    {
        $this->model = new EventModel();
    }

    public function registerEvent($nombre, $descripcion, $fecha_evento, $ubicacion, $lat = null, $lng = null)
    {
        if (empty($nombre) || empty($descripcion) || empty($fecha_evento) || empty($ubicacion)) {
            return "campos_vacios";
        } else {

            try {

                return $this->model->register($nombre, $descripcion, $fecha_evento, $ubicacion, $lat, $lng);
            } catch (Exception $e) {
                error_log("DEBUG Controller: Exception capturada en registerEvent: " . $e->getMessage());
                return "error_base_datos";
            }
        }


    }

    public function getEvents($Id_Evento = null)
    {
        try {
            $result = $this->model->getEvents($Id_Evento);
            error_log("Controller getEvents: " . print_r($result, true));
            return $result;
        } catch (Exception $e) {
            error_log("DEBUG Controller: " . $e->getMessage());
            return "error_base_datos";
        }
    }


    public function updateEvent($Id_Evento, $nombre, $descripcion, $fecha_evento, $ubicacion)
    {

        return $this->model->updateEvent($Id_Evento, $nombre, $descripcion, $fecha_evento, $ubicacion);


    }
    public function deleteEvent($Id_Evento)
    {

        return $this->model->deleteEvent($Id_Evento);


    }
}
?>