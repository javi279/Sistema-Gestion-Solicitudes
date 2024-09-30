<?php
// solicitud_actualizar.php

require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtener los valores del formulario
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $area_id = $_POST['area_id'];
    $empleado_id = $_POST['empleado_id'];
    $estado = $_POST['estado'];
    $nombre_vecino = $_POST['nombre_vecino'];
    $telefono_vecino = $_POST['telefono_vecino'];
    $dpi_vecino = $_POST['dpi_vecino'];

    // Crear una instancia del modelo de solicitudes
    $solicitud_model = new SolicitudModel($pdo);

    // Llamar al método para actualizar la solicitud
    $resultado = $solicitud_model->actualizarSolicitud($id, $titulo, $descripcion, $area_id, $empleado_id, $estado, $nombre_vecino, $telefono_vecino, $dpi_vecino);

    // Verificar si la solicitud se actualizó correctamente
    if ($resultado) {
        // Redirigir a la lista de solicitudes
        header('Location: solicitudes.php?mensaje=actualizado');
        exit;
    } else {
        // Mostrar un mensaje de error si algo salió mal
        echo "Error al actualizar la solicitud.";
    }
} else {
    // Si el script no fue llamado desde un formulario POST, redirigir al formulario de edición
    header('Location: solicitud_editar.php');
    exit;
}
?>
