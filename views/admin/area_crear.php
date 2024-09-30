<?php
// area_crear.php

require_once '../../config/config.php';
require_once '../../models/AreaModel.php';

// Crear una instancia del modelo de áreas
$area_model = new AreaModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];

    // Crear una nueva área
    $area_model->crearArea($nombre, $descripcion);

    // Redirigir a la lista de áreas
    header('Location: areas.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Crear Área</title>
  <link rel="stylesheet" href="../../public/styles/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Barra lateral y encabezado -->
    <aside class="main-sidebar">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
        </li>
      </ul>
    </nav>

    <!-- Sidebar -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Agregar contenido aquí -->
    </aside>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <h1>Crear Nueva Área</h1>
          <form action="area_crear.php" method="POST">
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Área</button>
            <a href="areas.php" class="btn btn-secondary">Cancelar</a>
          </form>
        </div>
      </section>
    </div>
  </div>
  <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
