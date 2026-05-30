<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header('Location: home.php');
    exit();
}

require_once __DIR__ . '/../Controller1/eventController.php';
$eventController = new EventController();

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre      = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fecha       = $_POST['fecha_evento'] ?? '';
    $ubicacion   = trim($_POST['ubicacion'] ?? '');
    $lat         = $_POST['lat'] ?? null;
    $lng         = $_POST['lng'] ?? null;

    $resultado = $eventController->registerEvent($nombre, $descripcion, $fecha, $ubicacion, $lat, $lng);

    if ($resultado === 'ok') {
        header('Location: perfil.php');
        exit();
    } elseif ($resultado === 'campos_vacios') {
        $error = 'Por favor rellena todos los campos obligatorios.';
    } else {
        $error = 'Error al crear el evento. Inténtalo de nuevo.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPARK · Crear evento</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="editarEvento.css">
</head>
<body>

<!-- NAV -->
<header class="topbar">
    <a href="home.php" class="nav-logo">
        <img src="recursos/logo.png" alt="SPARK">
    </a>
    <nav class="menu">
        <a href="home.php">Home</a>
        <a href="https://www.google.com/maps" target="_blank">Mapa</a>
        <a href="foro.php">Foro</a>
    </nav>
    <div class="actions">
        <a href="perfil.php" class="login">Perfil</a>
        <a href="logout.php" class="login">Cerrar sesión</a>
    </div>
</header>

<!-- FORMULARIO -->
<div class="update-layout">
    <div class="edit-card">

        <div class="edit-card-header">
            <p class="edit-eyebrow">Organizador</p>
            <h2 class="edit-title">Crear evento</h2>
        </div>

        <?php if ($error): ?>
            <div class="form-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="field">
                <label for="nombre">Nombre del evento *</label>
                <input type="text" id="nombre" name="nombre"
                       placeholder="Ej: Noche Electrónica" required>
            </div>

            <div class="field">
                <label for="descripcion">Descripción *</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                          placeholder="Describe tu evento..." required></textarea>
            </div>

            <div class="field-row">
                <div class="field">
                    <label for="fecha_evento">Fecha *</label>
                    <input type="date" id="fecha_evento" name="fecha_evento" required>
                </div>
                <div class="field">
                    <label for="ubicacion">Ubicación *</label>
                    <input type="text" id="ubicacion" name="ubicacion"
                           placeholder="Ej: Sala Apolo, Barcelona" required>
                    <span class="geo-status" id="geoStatus"></span>
                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="lng" id="lng">
                </div>
            </div>

            <div class="form-actions">
                <a href="perfil.php" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-save">Crear evento →</button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(function() {
    $('#ubicacion').on('blur', function() {
        const dir = $(this).val().trim();
        if (!dir) return;

        $('#geoStatus').text('Buscando ubicación...').css('color', '#9A9186');

        fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(dir + ', Barcelona')}&format=json&limit=1`, {
            headers: { 'Accept-Language': 'es' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.length > 0) {
                $('#lat').val(data[0].lat);
                $('#lng').val(data[0].lon);
                $('#geoStatus').text('✓ Ubicación encontrada').css('color', '#7ECB8F');
            } else {
                $('#lat').val('');
                $('#lng').val('');
                $('#geoStatus').text('⚠ No encontrada — verifica el nombre').css('color', '#C4714A');
            }
        })
        .catch(() => {
            $('#geoStatus').text('⚠ Error al buscar la ubicación').css('color', '#C4714A');
        });
    });
});
</script>

</body>
</html>