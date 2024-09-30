<?php
// controllers/SolicitudController.php

require_once '../models/SolicitudModel.php';

// Crear una nueva instancia del modelo de Solicitud
$solicitud_model = new SolicitudModel($pdo);

// Verificar la acción solicitada (crear, editar, eliminar)
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'create') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Datos del formulario de creación
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $area_id = $_POST['area_id'];
            $empleado_id = $_POST['empleado_id'];
            $usuario_id = $_POST['usuario_id'];
            $estado = $_POST['estado'];

            // Crear nueva solicitud
            $solicitud_model->crearSolicitud($titulo, $descripcion, $area_id, $empleado_id, $usuario_id, $estado);
            
            // Redirigir a la lista de solicitudes
            header('Location: solicitudes.php');
        }
    }

    if ($action == 'edit') {
        // Similar a create pero para editar solicitudes
    }

    if ($action == 'delete') {
        $id = $_GET['id'];
        $solicitud_model->eliminarSolicitud($id);
        header('Location: solicitudes.php');
    }
}
?>
