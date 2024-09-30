<?php
// solicitud_crear.php

require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';
require_once '../../models/AreaModel.php';
require_once '../../models/EmpleadoModel.php';

// Crear una instancia de los modelos necesarios
$solicitud_model = new SolicitudModel($pdo);
$area_model = new AreaModel($pdo);
$empleado_model = new EmpleadoModel($pdo);

// Obtener áreas y empleados
$areas = $area_model->obtenerAreas();
$empleados = $empleado_model->obtenerEmpleados();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Solicitud</title>
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <!-- Barra lateral y encabezado -->
    <aside class="main-sidebar">
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
          <li class="nav-item"></li>
        </ul>
      </nav>

      <!-- Sidebar -->
      <?php include '../includes/sidebar.php'; ?>
    </aside>

    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <h1>Crear Nueva Solicitud</h1>
          <form action="solicitud_guardar.php" method="POST">
            <div class="form-group">
              <label for="titulo">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            <div class="form-group">
              <label for="nombre_vecino">Nombre del Vecino</label>
              <input type="text" class="form-control" id="nombre_vecino" name="nombre_vecino" required>
            </div>
            <div class="form-group">
              <label for="telefono_vecino">Teléfono del Vecino</label>
              <input type="text" class="form-control" id="telefono_vecino" name="telefono_vecino" required>
            </div>
            <div class="form-group">
              <label for="dpi_vecino">DPI del Vecino</label>
              <input type="text" class="form-control" id="dpi_vecino" name="dpi_vecino" required>
            </div>
            <div class="form-group">
              <label for="area">Área</label>
              <select class="form-control" id="area" name="area_id" required>
                <option value="">Selecciona un área</option>
                <?php foreach ($areas as $area) { ?>
                <option value="<?php echo $area['id']; ?>"><?php echo $area['nombre']; ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="empleado">Empleado</label>
              <select class="form-control" id="empleado" name="empleado_id" required>
                <option value="">Selecciona un empleado</option>
                <?php foreach ($empleados as $empleado) { ?>
                <option value="<?php echo $empleado['id']; ?>"><?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?></option>
                <?php } ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Solicitud</button>
            <a href="solicitudes.php" class="btn btn-secondary">Cancelar</a>
          </form>
        </div>
      </section>
    </div>
  </div>
  <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
