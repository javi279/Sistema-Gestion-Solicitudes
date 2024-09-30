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
        $_SESSION['user_name'] = $usuario['nombre']; // Suponiendo que tienes un campo 'nombre'
        $_SESSION['user_role'] = $usuario['rol']; // Suponiendo que tienes un campo 'rol'

        // Redirigir según el rol
        if ($usuario['rol'] === 'admin') {
            header('Location: ../views/admin/dashboard.php');
        } elseif ($usuario['rol'] === 'empleado') {
            header('Location: ../views/empleado/dashboard.php'); // Crear un dashboard específico para empleados
        } else {
            // Redirigir a una página de error si el rol no está autorizado
            header('Location: ../public/login.php?error=rol_no_autorizado');
            exit;
        }
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../public/styles/adminlte.min.css">
</head>
<body>
    <div class="container">
        <h1>Iniciar Sesión</h1>
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php } ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
