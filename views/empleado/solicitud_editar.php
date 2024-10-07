<?php
// solicitud_editar.php

require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';
require_once '../../models/AreaModel.php';
require_once '../../models/EmpleadoModel.php';
require_once '../../models/EstadoModel.php';

// Crear instancias de los modelos necesarios
$solicitud_model = new SolicitudModel($pdo);
$area_model = new AreaModel($pdo);
$empleado_model = new EmpleadoModel($pdo);
$estado_model = new EstadoModel($pdo);

// Verificar si se ha enviado un ID de solicitud
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Obtener la solicitud por su ID
    $solicitud = $solicitud_model->obtenerSolicitudPorId($id);
    
    if ($solicitud) {
        // Obtener áreas, empleados y estados
        $areas = $area_model->obtenerAreas();
        $empleados = $empleado_model->obtenerEmpleados();
        $estados = $estado_model->obtenerEstados();  // Obtener los estados de la tabla estados_solicitud
    } else {
        // Si no se encuentra la solicitud, redirigir a la lista de solicitudes
        header('Location: solicitudes.php?mensaje=noencontrado');
        exit;
    }
} else {
    // Si no se proporciona un ID, redirigir a la lista de solicitudes
    header('Location: solicitudes.php?mensaje=error');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Editar Solicitud</title>
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
    <?php include '../includes/sidebar_empleado.php'; ?>

      <!-- Agregar contenido aquí -->
    </aside>
    <div class="content-wrapper">
      <section class="content">
        <div class="container-fluid">
          <h1>Editar Solicitud</h1>
          <form action="solicitud_actualizar.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $solicitud['id']; ?>">
            
            <!-- Título -->
            <div class="form-group">
              <label for="titulo">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $solicitud['titulo']; ?>" required>
            </div>
            
            <!-- Descripción -->
            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required><?php echo $solicitud['descripcion']; ?></textarea>
            </div>
            
            <!-- Área -->
            <div class="form-group">
              <label for="area">Área</label>
              <select class="form-control" id="area" name="area_id" required>
                <option value="">Selecciona un área</option>
                <?php foreach ($areas as $area) { ?>
                <option value="<?php echo $area['id']; ?>" <?php if ($area['id'] == $solicitud['area_id']) echo 'selected'; ?>>
                  <?php echo $area['nombre']; ?>
                </option>
                <?php } ?>
              </select>
            </div>
            
            <!-- Empleado -->
            <div class="form-group">
              <label for="empleado">Empleado</label>
              <select class="form-control" id="empleado" name="empleado_id" required>
                <option value="">Selecciona un empleado</option>
                <?php foreach ($empleados as $empleado) { ?>
                <option value="<?php echo $empleado['id']; ?>" <?php if ($empleado['id'] == $solicitud['empleado_id']) echo 'selected'; ?>>
                  <?php echo $empleado['nombre'] . ' ' . $empleado['apellido']; ?>
                </option>
                <?php } ?>
              </select>
            </div>
            
            <!-- Vecino -->
            <div class="form-group">
              <label for="nombre_vecino">Nombre del Vecino</label>
              <input type="text" class="form-control" id="nombre_vecino" name="nombre_vecino" value="<?php echo $solicitud['nombre_vecino']; ?>" required>
            </div>
            <div class="form-group">
              <label for="telefono_vecino">Teléfono del Vecino</label>
              <input type="text" class="form-control" id="telefono_vecino" name="telefono_vecino" value="<?php echo $solicitud['telefono_vecino']; ?>" required>
            </div>
            <div class="form-group">
              <label for="dpi_vecino">DPI del Vecino</label>
              <input type="text" class="form-control" id="dpi_vecino" name="dpi_vecino" value="<?php echo $solicitud['dpi_vecino']; ?>" required>
            </div>
            
            <!-- Estado -->
            <div class="form-group">
              <label for="estado">Estado de la Solicitud</label>
              <select class="form-control" id="estado" name="estado_id" required>
                <option value="">Selecciona un estado</option>
                <?php foreach ($estados as $estado) { ?>
                <option value="<?php echo $estado['id']; ?>" <?php if ($estado['id'] == $solicitud['estado_id']) echo 'selected'; ?>>
                  <?php echo $estado['nombre_estado']; ?>
                </option>
                <?php } ?>
              </select>
            </div>
            
            <!-- Botones -->
            <button type="submit" class="btn btn-primary">Actualizar Solicitud</button>
            <a href="solicitudes.php" class="btn btn-secondary">Cancelar</a>
          </form>
        </div>
      </section>
    </div>
  </div>
  <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
