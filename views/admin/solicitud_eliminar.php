<?php
// solicitud_eliminar.php

require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';

// Crear una instancia del modelo
$solicitud_model = new SolicitudModel($pdo);

// Verificar si se ha enviado un ID de solicitud
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Eliminar la solicitud
    if ($solicitud_model->eliminarSolicitud($id)) {
        // Redirigir a la lista de solicitudes con un mensaje de éxito
        header('Location: solicitudes.php?mensaje=eliminado');
    } else {
        // Redirigir a la lista de solicitudes con un mensaje de error
        header('Location: solicitudes.php?mensaje=error');
    }
} else {
    // Si no se proporciona un ID, redirigir a la lista de solicitudes
    header('Location: solicitudes.php?mensaje=error');
}
exit;
?>
