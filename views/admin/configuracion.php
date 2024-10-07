<?php
// Verificar si el usuario ha iniciado sesión
session_start();

// Verificar si existe el id en la sesión
if (!isset($_SESSION['id'])) {
    // Redirigir al usuario al inicio de sesión si no está logueado
    header('Location: ../../public/login.php');
    exit;
}

// Obtener el ID del usuario actual desde la sesión
$usuario_id = $_SESSION['id'];

require_once '../../config/config.php';
require_once '../../models/UsuarioModel.php';

$usuario_model = new UsuarioModel($pdo);

// Obtener los detalles del usuario logueado
$usuario = $usuario_model->obtenerUsuarioPorId($usuario_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editar'])) {
        // Procesar la actualización de los datos del usuario
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        
        // Actualizar los detalles del usuario
        $usuario_model->actualizarUsuario($usuario_id, [
            'nombre' => $nombre,
            'email' => $email
        ]);
        header('Location: configuracion.php');
        exit;
    } elseif (isset($_POST['eliminar'])) {
        // Procesar la eliminación del usuario
        $usuario_model->eliminarUsuario($usuario_id);
        // Cerrar sesión después de eliminar la cuenta
        session_destroy();
        header('Location: ../public/login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de la Cuenta</title>
    <link rel="stylesheet" href="../../public/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../public/plugins/fontawesome-free/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Configuración de la Cuenta</h1>
        <form method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email']; ?>" required>
            </div>
            <button type="submit" name="editar" class="btn btn-primary">Guardar Cambios</button>
            <button type="submit" name="eliminar" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta?');">Eliminar Cuenta</button>
        </form>
    </div>

    <script src="../../public/scripts/jquery.min.js"></script>
    <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
