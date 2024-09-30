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
            $usuario_id = $_POST['usuario_id']; // Considera eliminar si ya no lo necesitas
            $estado_id = $_POST['estado_id'];  // nuevo campo para estado_id
            $nombre_vecino = $_POST['nombre_vecino']; // nuevo campo para nombre del vecino
            $telefono_vecino = $_POST['telefono_vecino']; // nuevo campo para teléfono del vecino
            $dpi_vecino = $_POST['dpi_vecino']; // nuevo campo para DPI del vecino
            $fecha_creacion = date('Y-m-d H:i:s'); // Fecha de creación

            // Crear nueva solicitud
            $solicitud_model->crearSolicitud(
                $titulo, 
                $descripcion, 
                $area_id, 
                $empleado_id, 
                $nombre_vecino, 
                $telefono_vecino, 
                $dpi_vecino, 
                $fecha_creacion, 
                $estado_id // Asegúrate de que crearSolicitud maneje este parámetro
            );
            
            // Redirigir a la lista de solicitudes
            header('Location: solicitudes.php');
        }
    }

    if ($action == 'edit') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Datos del formulario de edición
            $id = $_POST['id'];
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $area_id = $_POST['area_id'];
            $empleado_id = $_POST['empleado_id'];
            $estado_id = $_POST['estado_id'];  // nuevo campo para estado_id
            $nombre_vecino = $_POST['nombre_vecino'];
            $telefono_vecino = $_POST['telefono_vecino'];
            $dpi_vecino = $_POST['dpi_vecino'];
            $fecha_actualizacion = date('Y-m-d H:i:s'); // Fecha de actualización

            // Editar la solicitud
            $solicitud_model->editarSolicitud(
                $id, 
                $titulo, 
                $descripcion, 
                $area_id, 
                $empleado_id, 
                $estado_id, 
                $fecha_actualizacion, 
                $nombre_vecino, 
                $telefono_vecino, 
                $dpi_vecino
            );
            
            // Redirigir a la lista de solicitudes
            header('Location: solicitudes.php');
        }
    }

    if ($action == 'delete') {
        $id = $_GET['id'];
        $solicitud_model->eliminarSolicitud($id);
        header('Location: solicitudes.php');
    }
}
?>
