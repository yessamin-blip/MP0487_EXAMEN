<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 2) {
    header('Location: home.php');
    exit();
}

require_once __DIR__ . '/../Controller1/eventController.php';
$eventController = new EventController();

$error   = "";
$success = "";

$misEventos = $eventController->getEvents();
if (!is_array($misEventos)) {
    $misEventos = [];
}

// ── Evento seleccionado ──
$eventoSeleccionado = null;
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $eventoSeleccionado = $eventController->getEvents($id);
    if (!is_array($eventoSeleccionado) || empty($eventoSeleccionado)) {
        $eventoSeleccionado = null;
    }
}

// ── Procesar edición ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'editar') {
    $id          = (int)$_POST['id_evento'];
    $nombre      = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $fecha       = $_POST['fecha_evento'];
    $ubicacion   = trim($_POST['ubicacion']);

    $resultado = $eventController->updateEvent($id, $nombre, $descripcion, $fecha, $ubicacion);

    if ($resultado === 'ok') {
        header("Location: editarEvento.php?id=$id&updated=1");
        exit();
    } else {
        $error = match($resultado) {
            'campos_vacios'        => 'Completa todos los campos.',
            'evento_no_encontrado' => 'El evento no existe.',
            'error_base_datos'     => 'Error en la base de datos.',
            default                => 'Error al actualizar el evento.'
        };
    }
}

if (isset($_GET['updated'])) {
    $success = "Evento actualizado correctamente.";
}

$page_title = 'SPARK · Editar evento';
$page_css   = 'editarEvento.css';
$page_css2  = 'eliminar.css';
$page_js    = 'js/eliminarEvento.js';
include 'layout-top.php';
?>

<!-- ── NAV ── -->
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

<!-- ── LAYOUT ── -->
<div class="edit-layout">

  <!-- LISTA -->
  <aside class="eventos-lista">
    <h2 class="lista-title">Mis eventos</h2>

    <?php if (empty($misEventos)): ?>
      <p class="lista-empty">No tienes eventos creados todavía.</p>
    <?php else: ?>
      <?php foreach ($misEventos as $ev): ?>
        <a href="editarEvento.php?id=<?= $ev['Id_Evento'] ?>"
           class="evento-item <?= (isset($_GET['id']) && (int)$_GET['id'] === (int)$ev['Id_Evento']) ? 'active' : '' ?>">
          <strong><?= htmlspecialchars($ev['Nombre_evento']) ?></strong>
          <span><?= htmlspecialchars($ev['Fecha_evento']) ?> · <?= htmlspecialchars($ev['Ubicacion']) ?></span>
        </a>
      <?php endforeach; ?>
    <?php endif; ?>

    <a href="crearEvento.php" class="crear-btn">+ Crear nuevo evento</a>
  </aside>

  <!-- FORMULARIO -->
  <main class="edit-main">

    <?php if (!$eventoSeleccionado): ?>
      <div class="edit-empty">
        <div class="empty-icon">✏️</div>
        <h3>Selecciona un evento</h3>
        <p>Elige un evento de la lista para editarlo.</p>
      </div>

    <?php else: ?>

      <div class="edit-card">

        <div class="edit-card-header">
          <div>
            <p class="edit-eyebrow">Editando evento</p>
            <h2 class="edit-title"><?= htmlspecialchars($eventoSeleccionado['Nombre_evento']) ?></h2>
          </div>
          <a href="evento.php?id=<?= $eventoSeleccionado['Id_Evento'] ?>" class="ver-evento-btn">
            Ver evento →
          </a>
        </div>

        <?php if ($error): ?>
          <div class="form-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
          <div class="form-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="editarEvento.php?id=<?= $eventoSeleccionado['Id_Evento'] ?>">
          <input type="hidden" name="action" value="editar">
          <input type="hidden" name="id_evento" value="<?= $eventoSeleccionado['Id_Evento'] ?>">

          <div class="field">
            <label for="nombre">Nombre del evento</label>
            <input type="text" id="nombre" name="nombre"
                   value="<?= htmlspecialchars($eventoSeleccionado['Nombre_evento']) ?>" required>
          </div>

          <div class="field">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($eventoSeleccionado['Descripcion'] ?? '') ?></textarea>
          </div>

          <div class="field-row">
            <div class="field">
              <label for="fecha_evento">Fecha</label>
              <input type="date" id="fecha_evento" name="fecha_evento"
                     value="<?= htmlspecialchars($eventoSeleccionado['Fecha_evento']) ?>" required>
            </div>
            <div class="field">
              <label for="ubicacion">Ubicación</label>
              <input type="text" id="ubicacion" name="ubicacion"
                     value="<?= htmlspecialchars($eventoSeleccionado['Ubicacion']) ?>" required>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="btn-delete" id="btnEliminarEvento">
              Eliminar evento
            </button>
            <a href="perfil.php" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-save">Guardar cambios →</button>
          </div>

        </form>

      </div>

    <?php endif; ?>

  </main>

</div>

<!-- Formulario oculto para eliminar -->
<?php if ($eventoSeleccionado): ?>
<form action="eliminarEvento.php" method="POST" id="deleteEventoForm">
  <input type="hidden" name="id_evento" value="<?= $eventoSeleccionado['Id_Evento'] ?>">
  <input type="hidden" name="confirmar" value="si">
</form>
<?php endif; ?>

<!-- Modal -->
<div class="modal-overlay" id="modalOverlay">
  <div class="modal-box">
    <div class="modal-icon">⚠️</div>
    <h3 class="modal-title">Eliminar evento</h3>
    <p class="modal-desc">
      ¿Seguro que quieres eliminar este evento?
      Esta acción es <strong>permanente</strong> y no se puede deshacer.
    </p>
    <div class="modal-actions">
      <button class="modal-cancel" id="modalCancelar">No, volver</button>
      <button class="modal-confirm" id="modalConfirmar">Sí, eliminar</button>
    </div>
  </div>
</div>

<?php include 'layout-bottom.php'; ?>