<?php
// areas.php

require_once '../../config/config.php';
require_once '../../models/AreaModel.php';

// Crear una instancia del modelo de áreas
$area_model = new AreaModel($pdo);

// Obtener todas las áreas
$areas = $area_model->obtenerAreas();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Áreas</title>
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
          <h1>Áreas</h1>
          <a href="area_crear.php" class="btn btn-primary">Crear Nueva Área</a>
          <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($areas as $area) { ?>
              <tr>
                <td><?php echo $area['id']; ?></td>
                <td><?php echo $area['nombre']; ?></td>
                <td><?php echo $area['descripcion']; ?></td>
                <td>
                  <a href="area_editar.php?id=<?php echo $area['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                  <a href="area_eliminar.php?id=<?php echo $area['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta área?');">Eliminar</a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </div>
  <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
