<?php
// usuarios.php

require_once '../../config/config.php';
require_once '../../models/UsuarioModel.php';

// Crear una instancia del modelo de usuarios
$usuario_model = new UsuarioModel($pdo);

// Obtener todos los usuarios
$usuarios = $usuario_model->obtenerUsuarios();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Usuarios</title>
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
          <h1>Usuarios</h1>
          <a href="usuario_crear.php" class="btn btn-primary">Crear Nuevo Usuario</a>
          <table class="table table-bordered mt-3">
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
              <?php foreach ($usuarios as $usuario) { ?>
              <tr>
                <td><?php echo $usuario['id']; ?></td>
                <td><?php echo $usuario['nombre']; ?></td>
                <td><?php echo $usuario['apellido']; ?></td>
                <td><?php echo $usuario['email']; ?></td>
                <td><?php echo $usuario['rol']; ?></td>
                <td>
                  <a href="usuario_editar.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                  <a href="usuario_eliminar.php?id=<?php echo $usuario['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</a>
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
