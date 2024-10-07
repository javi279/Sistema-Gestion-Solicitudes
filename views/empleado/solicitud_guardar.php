<?php
// solicitud_guardar.php

require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar que todos los campos requeridos estén presentes
    if (isset($_POST['titulo'], $_POST['descripcion'], $_POST['area_id'], $_POST['empleado_id'], $_POST['nombre_vecino'], $_POST['telefono_vecino'], $_POST['dpi_vecino'])) {
        
        // Obtener los valores del formulario
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $area_id = $_POST['area_id'];
        $empleado_id = $_POST['empleado_id'];
        $nombre_vecino = $_POST['nombre_vecino'];
        $telefono_vecino = $_POST['telefono_vecino'];
        $dpi_vecino = $_POST['dpi_vecino'];
        $fecha_creacion = date('Y-m-d H:i:s'); // Fecha actual
        $estado_id = '1'; // Estado predeterminado (1 para 'Pendiente')

        // Crear una instancia del modelo de solicitudes
        $solicitud_model = new SolicitudModel($pdo);

        // Llamar al método para guardar la solicitud con los nuevos campos
        $resultado = $solicitud_model->crearSolicitud($titulo, $descripcion, $area_id, $empleado_id, $nombre_vecino, $telefono_vecino, $dpi_vecino, $fecha_creacion, $estado_id);

        // Verificar si la solicitud se creó correctamente
        if ($resultado) {
            // Redirigir a la lista de solicitudes con mensaje de éxito
            header('Location: solicitudes.php?mensaje=creado');
            exit;
        } else {
            // Mostrar un mensaje de error si algo salió mal
            echo "Error al crear la solicitud.";
        }
    } else {
        // Si faltan campos requeridos, mostrar un mensaje de error
        echo "Por favor, completa todos los campos.";
    }
} else {
    // Si el script no fue llamado desde un formulario POST, redirigir al formulario de creación de solicitud
    header('Location: solicitud_crear.php');
    exit;
}
?>
