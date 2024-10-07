<?php
// empleados_eliminar.php

require_once '../../config/config.php';
require_once '../../models/EmpleadoModel.php';

$empleado_model = new EmpleadoModel($pdo);

if (isset($_GET['id'])) {
    $empleado_model->eliminarEmpleado($_GET['id']);
    header('Location: empleados.php');
    exit;
}
?>
