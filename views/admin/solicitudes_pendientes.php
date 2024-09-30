<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: ../../public/login.php');
  exit;
}

require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';

$solicitud_model = new SolicitudModel($pdo);
//$solicitudes_pendientes = $solicitud_model->obtenerSolicitudesPorEstado('Pendiente'); // Asegúrate de que este método exista

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Solicitudes Pendientes</title>
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1>Solicitudes Pendientes</h1>
      </section>
      <section class="content">
        <div class="container-fluid">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Título</th>
                <th>Descripción</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($solicitudes_pendientes)) : ?>
                <?php foreach ($solicitudes_pendientes as $solicitud) : ?>
                  <tr>
                    <td><?php echo htmlspecialchars($solicitud['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($solicitud['descripcion']); ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="2">No hay solicitudes pendientes.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </div>
</body>
</html>
