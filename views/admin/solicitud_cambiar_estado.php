<?php
require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';

// Verificar si se ha enviado una solicitud para cambiar el estado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $estado = $_POST['estado']; // 4 para aceptar, 5 para rechazar

    // Crear una instancia del modelo de solicitudes
    $solicitud_model = new SolicitudModel($pdo);

    // Actualizar el estado de la solicitud
    $resultado = $solicitud_model->cambiarEstadoSolicitud($id, $estado);

    // Verificar si se actualizó correctamente
    if ($resultado) {
        header('Location: solicitudes.php?mensaje=estado_actualizado');
        exit;
    } else {
        echo "Error al cambiar el estado de la solicitud.";
    }
} else {
    header('Location: solicitudes.php');
    exit;
}
?>
