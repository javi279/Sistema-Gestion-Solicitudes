<?php
// ReporteModel.php

class ReporteModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener solicitudes por departamento
    public function obtenerSolicitudesPorDepartamento() {
        $sql = "SELECT d.nombre AS nombre_departamento, COUNT(s.id) AS total_solicitudes
                FROM solicitudes s
                JOIN departamentos d ON s.ID_Departamento_Asignado = d.id
                GROUP BY d.nombre";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener solicitudes por estado (Pendiente, En Proceso, Finalizado)
    public function obtenerSolicitudesPorEstado() {
        $sql = "SELECT estado, COUNT(id) AS total_solicitudes
                FROM solicitudes
                GROUP BY estado";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $solicitudes_por_estado = [
            'pendiente' => 0,
            'en_proceso' => 0,
            'finalizado' => 0,
        ];

        foreach ($result as $row) {
            if ($row['estado'] === 'Pendiente') {
                $solicitudes_por_estado['pendiente'] = $row['total_solicitudes'];
            } elseif ($row['estado'] === 'En Proceso') {
                $solicitudes_por_estado['en_proceso'] = $row['total_solicitudes'];
            } elseif ($row['estado'] === 'Finalizado') {
                $solicitudes_por_estado['finalizado'] = $row['total_solicitudes'];
            }
        }

        return $solicitudes_por_estado;
    }

    public function obtenerReportes() {
        $sql = "SELECT * FROM reportes"; // Asegúrate de que el nombre de la tabla sea correcto
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


        // Método para crear un nuevo reporte
        public function crearReporte($nombre, $descripcion) {
            $sql = "INSERT INTO reportes (nombre, descripcion) VALUES (:nombre, :descripcion)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->execute();
        }
    

         // Método para obtener reportes basados en solicitudes
        public function obtenerReportesSolicitudes() {
        $query = "SELECT id, titulo, descripcion, estado, fecha_creacion FROM solicitudes";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerReportesPorFecha($fecha_inicio, $fecha_fin, $estado = null) {
        $query = "SELECT * FROM solicitudes WHERE fecha_creacion BETWEEN :fecha_inicio AND :fecha_fin";
    
        if (!empty($estado)) {
            $query .= " AND estado = :estado";
        }
    
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
    
        if (!empty($estado)) {
            $stmt->bindParam(':estado', $estado);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
     // Método para obtener reportes con filtros
     public function obtenerReportesFiltrados($estado = '', $fecha_inicio = '', $fecha_fin = '') {
        // Consulta base
        $query = "SELECT * FROM reportes WHERE 1=1"; 

        // Agregar filtros a la consulta
        if (!empty($estado)) {
            $query .= " AND estado = :estado";
        }
        if (!empty($fecha_inicio)) {
            $query .= " AND fecha >= :fecha_inicio";
        }
        if (!empty($fecha_fin)) {
            $query .= " AND fecha <= :fecha_fin";
        }

        // Preparar la consulta
        $stmt = $this->pdo->prepare($query);

        // Asignar valores a los parámetros si existen
        if (!empty($estado)) {
            $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
        }
        if (!empty($fecha_inicio)) {
            $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        }
        if (!empty($fecha_fin)) {
            $stmt->bindParam(':fecha_fin', $fecha_fin);
        }

        // Ejecutar la consulta y obtener los resultados
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
