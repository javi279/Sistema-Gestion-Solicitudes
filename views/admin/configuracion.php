<?php
// configuracion.php

session_start();
require_once '../../config/config.php';
require_once '../../models/UsuarioModel.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../public/login.php');
    exit;
}

// Obtener el ID del usuario actual
$user_id = $_SESSION['user_id'];
$usuario_model = new UsuarioModel($pdo);
$usuario = $usuario_model->obtenerUsuarioPorId($user_id);

// Manejar las actualizaciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cambiar_contraseña'])) {
        // Cambiar contraseña
        $nueva_contraseña = $_POST['nueva_contraseña'];
        $usuario_model->actualizarContraseña($user_id, $nueva_contraseña);
    } elseif (isset($_POST['actualizar_email'])) {
        // Actualizar email
        $nuevo_email = $_POST['nuevo_email'];
        $usuario_model->actualizarEmail($user_id, $nuevo_email);
    } elseif (isset($_POST['actualizar_perfil'])) {
        // Actualizar nombre y rol
        $nuevo_nombre = $_POST['nombre'];
        $nuevo_rol = $_POST['rol'];
        $usuario_model->actualizarPerfil($user_id, $nuevo_nombre, $nuevo_rol);
    } elseif (isset($_POST['preferencias_notificaciones'])) {
        // Actualizar preferencias de notificaciones
        $notificaciones = isset($_POST['notificaciones']) ? 1 : 0;
        $usuario_model->actualizarPreferenciasNotificaciones($user_id, $notificaciones);
    }

    // Actualizar la información del usuario después de guardar
    $usuario = $usuario_model->obtenerUsuarioPorId($user_id);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de la Cuenta</title>
    <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Contenido principal -->
        <div class="content-wrapper">
            <section class="content-header">
                <h1>Configuración de la Cuenta</h1>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Ajustes Básicos</h3>
                        </div>
                        <div class="card-body">
                            <!-- Cambiar Contraseña -->
                            <form method="POST" action="configuracion.php">
                                <h5>Cambiar Contraseña</h5>
                                <div class="form-group">
                                    <label for="nueva_contraseña">Nueva Contraseña</label>
                                    <input type="password" name="nueva_contraseña" id="nueva_contraseña" class="form-control" required>
                                </div>
                                <button type="submit" name="cambiar_contraseña" class="btn btn-primary">Cambiar Contraseña</button>
                            </form>
                            <hr>

                            <!-- Actualizar Email -->
                            <form method="POST" action="configuracion.php">
                                <h5>Actualizar Email</h5>
                                <div class="form-group">
                                    <label for="nuevo_email">Nuevo Email</label>
                                    <input type="email" name="nuevo_email" id="nuevo_email" class="form-control" value="<?php echo $usuario['email']; ?>" required>
                                </div>
                                <button type="submit" name="actualizar_email" class="btn btn-primary">Actualizar Email</button>
                            </form>
                            <hr>

                            <!-- Actualizar Información del Perfil -->
                            <form method="POST" action="configuracion.php">
                                <h5>Actualizar Información del Perfil</h5>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="rol">Rol</label>
                                    <select name="rol" id="rol" class="form-control" required>
                                        <option value="Administrador" <?php echo $usuario['rol'] === 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
                                        <option value="Empleado" <?php echo $usuario['rol'] === 'Empleado' ? 'selected' : ''; ?>>Empleado</option>
                                    </select>
                                </div>
                                <button type="submit" name="actualizar_perfil" class="btn btn-primary">Actualizar Perfil</button>
                            </form>
                            <hr>
                            
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Pie de página -->
        <?php include '../includes/footer.php'; ?>
    </div>

    <!-- Scripts necesarios -->
    <script src="../../public/scripts/jquery.min.js"></script>
    <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
