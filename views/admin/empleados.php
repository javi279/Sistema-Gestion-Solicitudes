<?php
// empleados.php

// Incluye el archivo de configuración y el modelo
require_once '../../config/config.php'; 
require_once '../../models/EmpleadoModel.php'; 

// Crear una instancia del modelo de empleados
$empleado_model = new EmpleadoModel($pdo);

// Obtener todos los empleados con detalles completos
$empleados = $empleado_model->obtenerEmpleadosConDetalles();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Administrar Empleados</title>
  <link rel="stylesheet" href="../../public/styles/custom.css"> <!-- Nuevo archivo CSS -->
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Barra de navegación -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    </nav>

    <!-- Sidebar -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Contenido principal -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Administrar Empleados</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Empleados Registrados</h3>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($empleados)) { ?>
                    <?php foreach ($empleados as $empleado) { ?>
                    <tr>
                      <td><?php echo $empleado['id']; ?></td>
                      <td><?php echo $empleado['nombre']; ?></td>
                      <td><?php echo $empleado['apellido']; ?></td>
                      <td><?php echo $empleado['email']; ?></td>
                      <td><?php echo $empleado['rol']; ?></td>
                      <td>
                        <a href="empleado_editar.php?id=<?php echo $empleado['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="empleado_eliminar.php?id=<?php echo $empleado['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                      </td>
                    </tr>
                    <?php } ?>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6">No hay empleados registrados.</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <a href="empleado_crear.php" class="btn btn-primary mt-3">Crear Nuevo Empleado</a>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Pie de página -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-inline">
      <?php include '../includes/footer.php'; ?>
  </div>

  <!-- Scripts necesarios -->
  <script src="../../public/scripts/jquery.min.js"></script>
  <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
