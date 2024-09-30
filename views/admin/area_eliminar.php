<?php
// area_eliminar.php

require_once '../../config/config.php';
require_once '../../models/AreaModel.php';

// Crear una instancia del modelo de áreas
$area_model = new AreaModel($pdo);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el área
    $area_model->eliminarArea($id);

    // Redirigir a la lista de áreas
    header('Location: areas.php');
    exit;
} else {
    // En caso de que no se proporcione un ID, redirigir a la lista de áreas
    header('Location: areas.php');
    exit;
}
?>
