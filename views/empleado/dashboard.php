<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
  header('Location: ../../public/login.php');
  exit;
}

// Incluye el archivo de configuración y el modelo de Solicitud
require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';

// Crear instancia del modelo de solicitud
$solicitud_model = new SolicitudModel($pdo);

// Obtener estadísticas y solicitudes recientes
$estadisticas = $solicitud_model->obtenerEstadisticas();
$solicitudes_recientes = $solicitud_model->obtenerSolicitudesRecientes($_SESSION['user_id']); // Adaptado para el empleado
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Solicitudes</title>
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Incluye el sidebar para empleados -->
    <?php include '../includes/sidebar_empleado.php'; ?>

    <!-- Contenido principal -->
    <div class="content-wrapper">
      <!-- Encabezado -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Panel de Solicitudes</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Contenido -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- Tarjetas de estadísticas -->
            <div class="col-lg-4 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <h3><?php echo isset($estadisticas['total_solicitudes']) ? $estadisticas['total_solicitudes'] : 'N/A'; ?></h3>
                  <p>Total Solicitudes</p>
                </div>
                <div class="icon">
                  <i class="fas fa-file-alt"></i>
                </div>
              </div>
            </div>

            <!-- Tarjeta de solicitudes pendientes -->
            <div class="col-lg-4 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3><?php echo isset($estadisticas['solicitudes_pendientes']) ? $estadisticas['solicitudes_pendientes'] : 'N/A'; ?></h3>
                  <p>Solicitudes Pendientes</p>
                </div>
                <div class="icon">
                  <i class="fas fa-exclamation-circle"></i>
                </div>
              </div>
            </div>

            <!-- Tarjeta de solicitudes finalizadas -->
            <div class="col-lg-4 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo isset($estadisticas['solicitudes_finalizadas']) ? $estadisticas['solicitudes_finalizadas'] : 'N/A'; ?></h3>
                  <p>Solicitudes Finalizadas</p>
                </div>
                <div class="icon">
                  <i class="fas fa-check-circle"></i>
                </div>
              </div>
            </div>

            <!-- Lista de solicitudes recientes -->
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Solicitudes Recientes</h3>
                </div>
                <div class="card-body">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($solicitudes_recientes)) : ?>
                        <?php foreach ($solicitudes_recientes as $solicitud) : ?>
                          <tr>
                            <td><?php echo htmlspecialchars($solicitud['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($solicitud['descripcion']); ?></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <tr>
                          <td colspan="2">No hay solicitudes recientes.</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <!-- Pie de página -->
    <footer class="main-footer">
      <strong>&copy; 2024 <a href="#">Municipalidad San Jeronimo BV</a>.</strong> Todos los derechos reservados.
    </footer>
  </div>

  <!-- Scripts -->
  <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
