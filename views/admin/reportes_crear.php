<?php
// reportes_crear.php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../public/login.php');
    exit;
}

require_once '../../config/config.php';
require_once '../../models/ReporteModel.php';

$reporte_model = new ReporteModel($pdo);

$reportes = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = $_POST['estado'];

    $reportes = $reporte_model->obtenerReportesPorFecha($fecha_inicio, $fecha_fin, $estado);
    
    // Verificar si se solicitó la descarga en PDF
    if (isset($_POST['exportar_pdf'])) {
        require_once '../../vendor/tecnickcom/tcpdf/tcpdf.php';

        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        $html = '<h1>Reporte de Solicitudes</h1>';
        $html .= '<table border="1" cellpadding="4"><thead><tr><th>ID</th><th>Título</th><th>Descripción</th><th>Estado</th><th>Fecha de Creación</th></tr></thead><tbody>';
        foreach ($reportes as $reporte) {
            $html .= '<tr><td>' . $reporte['id'] . '</td><td>' . $reporte['titulo'] . '</td><td>' . $reporte['descripcion'] . '</td><td>' . $reporte['estado'] . '</td><td>' . $reporte['fecha_creacion'] . '</td></tr>';
        }
        $html .= '</tbody></table>';
        
        $pdf->writeHTML($html);
        $pdf->Output('reporte_solicitudes.pdf', 'D');
        exit;
    }

    // Verificar si se solicitó la descarga en Excel
    if (isset($_POST['exportar_excel'])) {
        // Cambiar las cabeceras HTTP para el archivo XLSX
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_solicitudes.xlsx"');
        header('Cache-Control: max-age=0');
    
        // Asegúrate de que la ruta a PHPSpreadsheet es correcta
        require_once '../../vendor/autoload.php'; // Carga el autoload de Composer para cargar automáticamente todas las dependencias
    
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Título');
        $sheet->setCellValue('C1', 'Descripción');
        $sheet->setCellValue('D1', 'Estado');
        $sheet->setCellValue('E1', 'Fecha de Creación');
    
        $row = 2;
        foreach ($reportes as $reporte) {
            $sheet->setCellValue('A' . $row, $reporte['id']);
            $sheet->setCellValue('B' . $row, $reporte['titulo']);
            $sheet->setCellValue('C' . $row, $reporte['descripcion']);
            $sheet->setCellValue('D' . $row, $reporte['estado']);
            $sheet->setCellValue('E' . $row, $reporte['fecha_creacion']);
            $row++;
        }
    
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte de Solicitudes</title>
    <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="/Sistema_Gestion_Solicitudes/public/plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include '../includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Generar Reporte de Solicitudes</h1>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Filtrado de Solicitudes</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="reportes_crear.php">
                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha Inicio</label>
                                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha Fin</label>
                                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select id="estado" name="estado" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="1">Pendiente</option>
                                        <option value="2">En Proceso</option>
                                        <option value="3">Completado</option>
                                        <option value="4">Aceptado</option>
                                        <option value="5">Rechazado</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="generar_reporte">Generar Reporte</button>
                                <button type="submit" class="btn btn-secondary" name="exportar_pdf">Exportar PDF</button>
                                <button type="submit" class="btn btn-success" name="exportar_excel">Exportar Excel</button>
                            </form>
                        </div>
                    </div>

                    <?php if (!empty($reportes)) { ?>
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">Reporte de Solicitudes</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Descripción</th>
                                            <th>Estado</th>
                                            <th>Fecha de Creación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reportes as $reporte) { ?>
                                        <tr>
                                            <td><?php echo $reporte['id']; ?></td>
                                            <td><?php echo $reporte['titulo']; ?></td>
                                            <td><?php echo $reporte['descripcion']; ?></td>
                                            <td><?php echo $reporte['estado']; ?></td>
                                            <td><?php echo $reporte['fecha_creacion']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </div>

        

        <footer class="main-footer">
            <?php include '../includes/footer.php'; ?>
        </footer>
    </div>

    <script src="../../public/scripts/jquery.min.js"></script>
    <script src="../../public/scripts/adminlte.min.js"></script>
</body>
</html>
