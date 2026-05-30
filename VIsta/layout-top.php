<?php
/**
 * SPARK · layout-top.php
 * Incluir al principio del <head> en TODAS las páginas
 *
 * Variables que puedes definir ANTES del include:
 *   $page_title  — título de la pestaña  (default: "SPARK")
 *   $page_css    — ruta al CSS específico (default: ninguno)
 *
 * Uso básico:
 *   <?php
 *   $page_title = "SPARK · Perfil";
 *   $page_css   = "perfil.css";
 *   include 'layout-top.php';
 *   ?>
 */

$page_title = $page_title ?? 'SPARK';
$page_css   = $page_css   ?? null;


?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title) ?></title>

  <!-- Fuentes — iguales en todas las páginas -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700;900&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,400&display=swap" rel="stylesheet">

  <!-- CSS específico de la página -->
  <?php if ($page_css): ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($page_css) ?>">
  <?php endif; ?>
  <?php if (isset($page_css2)): ?>
  <link rel="stylesheet" href="<?= htmlspecialchars($page_css2) ?>">
<?php endif; ?>

  <!-- CSS de cookies — siempre -->
  <link rel="stylesheet" href="cookies.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
</head>
<body>
