<?php
// usuario_crear.php

require_once '../../config/config.php';
require_once '../../models/UsuarioModel.php';

// Crear una instancia del modelo de usuarios
$usuario_model = new UsuarioModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $rol = $_POST['rol'];

    $datos = [
        'nombre' => $nombre,
        'apellido' => $apellido,
        'email' => $email,
        'password' => $password,
        'rol' => $rol
    ];

    $usuario_model->crearUsuario($datos);

    header('Location: usuarios.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Crear Usuario</title>
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
          <h1>Crear Nuevo Usuario</h1>
          <form action="usuario_crear.php" method="POST">
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
              <label for="apellido">Apellido</label>
              <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="password">Contraseña</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="rol">Rol</label>
              <select class="form-control" id="rol" name="rol" required>
                <option value="admin">Administrador</option>
                <option value="empleado">Empleado</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Usuario</button>
            <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
          </form>
        </div>
      </section>
    </div>
  </div>
  <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
