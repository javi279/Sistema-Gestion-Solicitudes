<?php
// dashboard.php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
  header('Location: ../../public/login.php'); // Redirige a la página de login
  exit;
}

// Incluye el archivo de configuración y el modelo de Solicitud
require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';

// Crear instancia del modelo de solicitud
$solicitud_model = new SolicitudModel($pdo);

// Obtener estadísticas y solicitudes recientes
$estadisticas = $solicitud_model->obtenerEstadisticas();
$solicitudes_recientes = $solicitud_model->obtenerSolicitudesRecientes();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../public/styles/all.min.css"> <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="../../public/styles/custom.css"> <!-- Nuevo archivo CSS -->
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Incluye el sidebar -->
    <?php include '../includes/sidebar.php'; ?>

    <!-- Contenido principal -->
    <div class="content-wrapper">
      <!-- Encabezado -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Panel de Administración</h1>
            </div>
          </div>
        </div>
      </section>

      <!-- Contenido -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- Tarjetas de estadísticas -->
            <div class="col-lg-3 col-6">
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
            <div class="col-lg-3 col-6">
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

            <!-- Tarjeta de solicitudes resueltas -->
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <h3><?php echo isset($estadisticas['solicitudes_resueltas']) ? $estadisticas['solicitudes_resueltas'] : 'N/A'; ?></h3>
                  <p>Solicitudes Resueltas</p>
                </div>
                <div class="icon">
                  <i class="fas fa-check-circle"></i>
                </div>
              </div>
            </div>

            <!-- Tarjeta de solicitudes de alta prioridad -->
            <div class="col-lg-3 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3><?php echo isset($estadisticas['solicitudes_altaprioridad']) ? $estadisticas['solicitudes_altaprioridad'] : 'N/A'; ?></h3>
                  <p>Solicitudes de Alta Prioridad</p>
                </div>
                <div class="icon">
                  <i class="fas fa-exclamation-triangle"></i>
                </div>
              </div>
            </div>

            <!-- Gráfica de barras -->
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Solicitudes por Estado</h3>
                </div>
                <div class="card-body">
                  <canvas id="estadoSolicitudesChart"></canvas>
                </div>
              </div>
            </div>

            <!-- Gráfica de solicitudes recientes -->
            <div class="col-lg-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Solicitudes Recientes</h3>
                </div>
                <div class="card-body">
                  <canvas id="solicitudesRecientesChart"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Lista de solicitudes recientes -->
          <div class="row">
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
                          <td colspan="3">No hay solicitudes recientes.</td>
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
      <strong>Copyright &copy; 2024 <a href="#">Municipalidad de San Jerónimo</a>.</strong> Todos los derechos reservados.
    </footer>
  </div>

  <!-- Scripts -->
  <script src="../../public/scripts/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Gráfica de estado de solicitudes
    var ctxEstado = document.getElementById('estadoSolicitudesChart').getContext('2d');
    var estadoSolicitudesChart = new Chart(ctxEstado, {
      type: 'bar',
      data: {
        labels: ['Pendiente', 'En Proceso', 'Finalizado'],
        datasets: [{
          label: '# de Solicitudes',
          data: [<?php echo $estadisticas['solicitudes_pendientes'] ?? 0; ?>, 19, <?php echo $estadisticas['solicitudes_resueltas'] ?? 0; ?>], // Cambia estos valores con datos reales
          backgroundColor: ['#f39c12', '#00c0ef', '#00a65a']
        }]
      }
    });

    // Gráfica de solicitudes recientes
    var ctxRecientes = document.getElementById('solicitudesRecientesChart').getContext('2d');
    var solicitudesRecientesChart = new Chart(ctxRecientes, {
      type: 'line',
      data: {
        labels: ['Día 1', 'Día 2', 'Día 3'], // Reemplaza con fechas reales
        datasets: [{
          label: 'Solicitudes',
          data: [3, 6, 4], // Cambia estos valores con datos reales
          borderColor: '#3c8dbc',
          fill: false
        }]
      }
    });
  </script>
</body>
</html>
