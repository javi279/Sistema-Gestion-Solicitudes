<?php
require_once '../models/ReporteModel.php';
require_once '../vendor/autoload.php'; // Para exportación a Excel y PDF (si usas librerías como PhpSpreadsheet y Dompdf)

class ReporteController {
    private $reporteModel;

    public function __construct($pdo) {
        $this->reporteModel = new ReporteModel($pdo);
    }

    // Mostrar las solicitudes en la vista
    public function mostrarReporte($estado = null) {
        if ($estado === 'todas') {
            $solicitudes = $this->reporteModel->obtenerTodasSolicitudes();
        } elseif ($estado === 'aceptadas') {
            $solicitudes = $this->reporteModel->obtenerSolicitudesAceptadas();
        } elseif ($estado === 'rechazadas') {
            $solicitudes = $this->reporteModel->obtenerSolicitudesRechazadas();
        } elseif ($estado === 'finalizadas') {
            $solicitudes = $this->reporteModel->obtenerSolicitudesFinalizadas();
        } else {
            $solicitudes = []; // Vacío si no hay estado
        }

        // Cargar la vista con los datos
        require '../views/reportes.php';
    }

    // Exportar solicitudes a Excel
    public function exportarExcel($estado) {
        $solicitudes = $this->obtenerDatosReporte($estado);

        // Crear una nueva hoja de Excel usando PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'ID Solicitud');
        $sheet->setCellValue('B1', 'Descripción');
        $sheet->setCellValue('C1', 'Fecha Creación');
        $sheet->setCellValue('D1', 'Estado');

        $row = 2;
        foreach ($solicitudes as $solicitud) {
            $sheet->setCellValue("A{$row}", $solicitud['ID_Solicitud']);
            $sheet->setCellValue("B{$row}", $solicitud['descripcion']);
            $sheet->setCellValue("C{$row}", $solicitud['fecha_creacion']);
            $sheet->setCellValue("D{$row}", $solicitud['Estado']);
            $row++;
        }

        // Exportar archivo Excel
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="reporte_solicitudes.xlsx"');
        $writer->save('php://output');
        exit;
    }

    // Exportar solicitudes a PDF
    public function exportarPDF($estado) {
        $solicitudes = $this->obtenerDatosReporte($estado);

        // Usar Dompdf para generar PDF
        $dompdf = new \Dompdf\Dompdf();
        ob_start();
        include '../views/reportes_pdf.php'; // Archivo que contendrá el diseño HTML del PDF
        $html = ob_get_clean();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream("reporte_solicitudes.pdf", ["Attachment" => 1]);
        exit;
    }

    // Método auxiliar para obtener datos basado en estado
    private function obtenerDatosReporte($estado) {
        switch ($estado) {
            case 'todas':
                return $this->reporteModel->obtenerTodasSolicitudes();
            case 'aceptadas':
                return $this->reporteModel->obtenerSolicitudesAceptadas();
            case 'rechazadas':
                return $this->reporteModel->obtenerSolicitudesRechazadas();
            case 'finalizadas':
                return $this->reporteModel->obtenerSolicitudesFinalizadas();
            default:
                return [];
        }
    }
}
?>
