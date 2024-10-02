<?php
// login.php

session_start();

// Verificar si ya está autenticado
if (isset($_SESSION['user_id'])) {
    header('Location: ../views/admin/dashboard.php'); // Redirige al dashboard del admin si ya está autenticado
    exit;
}

require_once '../config/config.php';
require_once '../models/UsuarioModel.php';

$usuario_model = new UsuarioModel($pdo);

// Inicializar variable de error
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Verificar usuario
    $usuario = $usuario_model->verificarUsuario($email, $password);

    if ($usuario) {
        // Iniciar sesión
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['user_name'] = $usuario['nombre'];
        $_SESSION['user_role'] = $usuario['rol'];

        // Redirigir según el rol
        if ($usuario['rol'] === 'admin') {
            header('Location: ../views/admin/dashboard.php');
        } elseif ($usuario['rol'] === 'empleado') {
            header('Location: ../views/empleado/dashboard.php');
        } else {
            header('Location: ../public/login.php?error=rol_no_autorizado');
            exit;
        }
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./dist/css/style.css" rel="stylesheet">
    <title>Iniciar Sesión</title>
  </head>
  <body>
    <div class="container-fluid">
        <form action="login.php" method="POST" class="mx-auto">
            <h4 class="text-center">Login</h4>
            
            <?php if (!empty($error)) { ?>
                <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
            <?php } ?>

            <div class="mb-3 mt-5">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary mt-5">Iniciar Sesión</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
