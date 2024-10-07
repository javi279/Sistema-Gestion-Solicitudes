<?php
// solicitudes_rechazadas.php

// Incluye el archivo de configuración y el modelo
require_once '../../config/config.php';
require_once '../../models/SolicitudModel.php';

// Crear una instancia del modelo de solicitud
$solicitud_model = new SolicitudModel($pdo);

// Obtener las solicitudes con estado "rechazada" (estado_id = 5)
$solicitudes = $solicitud_model->obtenerSolicitudesPorEstado(5);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Solicitudes Rechazadas</title>
    <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <?php include '../includes/sidebar_empleado.php'; ?>
        
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Solicitudes Rechazadas</h1>
                        </div>
                    </div>
                </div>
            </section>
            
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Área</th>
                                        <th>Empleado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($solicitudes)) { ?>
                                        <?php foreach ($solicitudes as $solicitud) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($solicitud['id']); ?></td>
                                                <td><?php echo htmlspecialchars($solicitud['titulo']); ?></td>
                                                <td><?php echo htmlspecialchars($solicitud['descripcion']); ?></td>
                                                <td><?php echo htmlspecialchars($solicitud['area_nombre']); ?></td>
                                                <td><?php echo htmlspecialchars($solicitud['empleado_nombre']); ?></td>
                                                <td>
                                                    <a href="solicitud_editar.php?id=<?php echo $solicitud['id']; ?>" class="btn btn-warning btn-sm">Ver/Editar</a>
                                                    <a href="solicitud_eliminar.php?id=<?php echo $solicitud['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta solicitud?');">Eliminar</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="6">No hay solicitudes rechazadas.</td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    
    <script src="../../public/scripts/jquery.min.js"></script>
    <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
