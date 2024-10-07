<?php
// solicitudes.php

// Incluye el archivo de configuración y el modelo
require_once '../../config/config.php'; // Ruta correcta al archivo de configuración
require_once '../../models/SolicitudModel.php'; // Ruta al modelo

// Crear una instancia del modelo de solicitud
$solicitud_model = new SolicitudModel($pdo);

// Obtener todas las solicitudes con detalles completos
$solicitudes = $solicitud_model->obtenerSolicitudesCompletas();

// Función para convertir el estado_id en texto legible
function obtenerEstadoTexto($estado_id) {
    switch ($estado_id) {
        case 1:
            return "Pendiente";
        case 2:
            return "En Proceso";
        case 3:
            return "Finalizada";
        case 4:
            return "Aceptada";
        case 5:
            return "Rechazada";
        default:
            return "Desconocido";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <title>Administrar Solicitudes</title>
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="Sistema_Gestion_Solicitudes/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="Sistema_Gestion_Solicitudes/public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="Sistema_Gestion_Solicitudes/public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
              <h1>Administrar Solicitudes</h1>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Solicitudes Registradas</h3>
            </div>
            <div class="card-body">
              <table id="solicitudesTable" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Área</th>
                    <th>Empleado</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($solicitudes)) { ?>
                    <?php foreach ($solicitudes as $solicitud) { ?>
                    <tr>
                      <td><?php echo htmlspecialchars($solicitud['id']); ?></td>
                      <td><?php echo htmlspecialchars($solicitud['titulo']); ?></td>
                      <td><?php echo htmlspecialchars($solicitud['descripcion']); ?></td>
                      <td><?php echo htmlspecialchars($solicitud['area_nombre']); ?></td>
                      <td><?php echo htmlspecialchars($solicitud['empleado_nombre']); ?></td>
                      <td><?php echo obtenerEstadoTexto($solicitud['estado_id']); ?></td> <!-- Mostrar el estado en formato de texto -->
                      <td>
                        <a href="solicitud_editar.php?id=<?php echo $solicitud['id']; ?>" class="btn btn-warning btn-sm">Ver/Editar</a>
                        <a href="solicitud_eliminar.php?id=<?php echo $solicitud['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta solicitud?');">Eliminar</a>
                        
                        <!-- Botones para Aceptar y Rechazar -->
                        <form action="solicitud_cambiar_estado.php" method="POST" style="display:inline;">
                          <input type="hidden" name="id" value="<?php echo $solicitud['id']; ?>">
                          <button type="submit" name="estado_id" value="4" class="btn btn-success btn-sm">Aceptar</button>
                          <button type="submit" name="estado_id" value="5" class="btn btn-danger btn-sm">Rechazar</button>
                        </form>
                      </td>
                    </tr>
                    <?php } ?>
                  <?php } else { ?>
                    <tr>
                      <td colspan="8">No hay solicitudes registradas.</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <a href="solicitud_crear.php" class="btn btn-primary mt-3">Crear Nueva Solicitud</a>
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
  <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../../plugins/jszip/jszip.min.js"></script>
  <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <!-- Inicializar DataTables -->
  <script>
      $(document).ready(function() {
          $('#solicitudesTable').DataTable({
              responsive: true,
              lengthChange: false,
              autoWidth: false,
              buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#solicitudesTable_wrapper .col-md-6:eq(0)');
      });
  </script>

</body>
</html>
