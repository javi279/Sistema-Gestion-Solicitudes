<?php
// reportes.php

// Incluye el archivo de configuración y el modelo
require_once '../../config/config.php'; // Ruta correcta al archivo de configuración
require_once '../../models/ReporteModel.php'; // Ruta al modelo

// Crear una instancia del modelo de reporte
$reporte_model = new ReporteModel($pdo);

// Obtener los reportes
$reportes = $reporte_model->obtenerReportes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Reportes</title>
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Barra de navegación -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Agregar contenido aquí si es necesario -->
    </nav>

    <!-- Sidebar -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Contenido principal -->
    <div class="content-wrapper">
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Reportes</h1>
            </div>
          </div>
        </div>
      </section>


      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Reportes Registrados</h3>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($reportes)) { ?>
                    <?php foreach ($reportes as $reporte) { ?>
                    <tr>
                      <td><?php echo $reporte['id']; ?></td>
                      <td><?php echo $reporte['titulo']; ?></td>
                      <td><?php echo $reporte['descripcion']; ?></td>
                      <td><?php echo $reporte['fecha']; ?></td>
                      <td><?php echo $reporte['autor']; ?></td>
                      <td>
                        <a href="reporte_ver.php?id=<?php echo $reporte['id']; ?>" class="btn btn-info btn-sm">Ver</a>
                        <a href="reporte_eliminar.php?id=<?php echo $reporte['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este reporte?');">Eliminar</a>
                      </td>
                    </tr>
                    <?php } ?>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6">No hay reportes registrados.</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <a href="reportes_crear.php" class="btn btn-primary mt-3">Crear Nuevo Reporte</a>
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
      <strong>Copyright &copy; 2024 <a href="#">Municipalidad de San Jerónimo</a>.</strong> Todos los derechos reservados.
    </footer>
  </div>

  <!-- Scripts necesarios -->
  <script src="../../public/scripts/jquery.min.js"></script>
  <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
