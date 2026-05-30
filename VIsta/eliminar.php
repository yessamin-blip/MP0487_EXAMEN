<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once __DIR__ . "/../Controller1/user.Controler.php";
$user_Controler = new User_Controler();

if (isset($_POST['confirmar']) && $_POST['confirmar'] == 'si') {
    $resultado = $user_Controler->deleteProfile($_SESSION['user_email']);

    if ($resultado == "ok") {
        session_destroy();
        header('Location: login.php');
        exit();
    }
}

// Si llegan aquí sin POST válido, vuelven a update
header('Location: update.php');
exit();
?>