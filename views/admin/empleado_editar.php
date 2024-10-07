<?php
// empleados_editar.php

require_once '../../config/config.php';
require_once '../../models/EmpleadoModel.php';

$empleado_model = new EmpleadoModel($pdo);

if (isset($_GET['id'])) {
    $empleado = $empleado_model->obtenerEmpleadoPorId($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $rol = $_POST['rol']; // Campo para el puesto del empleado

    $empleado_model->actualizarEmpleado($id, $nombre, $apellido, $email, $rol);

    header('Location: empleados.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Empleado</title>
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include '../includes/sidebar.php'; ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar Empleado</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Formulario de Empleado</h3>
                    </div>

                    <form method="POST" action="empleado_editar.php">
                        <div class="card-body">
                            <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="<?php echo $empleado['nombre']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input type="text" name="apellido" class="form-control" value="<?php echo $empleado['apellido']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $empleado['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="rol">Puesto</label>
                                <input type="text" name="rol" class="form-control" value="<?php echo $empleado['rol']; ?>" required>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Actualizar Empleado</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <?php include '../includes/footer.php'; ?>
</div>

<script src="../../public/scripts/jquery.min.js"></script>
<script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
