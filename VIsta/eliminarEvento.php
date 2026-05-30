<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header('Location: home.php');
    exit();
}

require_once __DIR__ . '/../Controller1/eventController.php';
$eventController = new EventController();

if (isset($_POST['confirmar']) && $_POST['confirmar'] == 'si' && isset($_POST['id_evento'])) {
    $id        = (int)$_POST['id_evento'];
    $resultado = $eventController->deleteEvent($id);

    if ($resultado === 'ok') {
        header('Location: editarEvento.php');
        exit();
    }
}

// Si algo falla, vuelve al editor
header('Location: editarEvento.php');
exit();
?>
