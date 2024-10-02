<?php
class SolicitudModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener estadísticas (ejemplo)
   /* public function obtenerEstadisticas() {
        $sql = "SELECT COUNT(*) AS total_solicitudes FROM solicitudes";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);

        //Solicitudes pendientes
        $stmt = $this->pdo->query("SELECT COUNT(*) as solicitudes_pendientes FROM solicitudes WHERE estado = 1");
        $estadisticas['solicitudes_pendientes'] = $stmt->fetchColumn();

        //Solicitudes resueltas
        $stmt = $this->pdo->query("SELECT COUNT(*) as solicitudes_resueltas FROM solicitudes WHERE estado = 'Finalizado'");
        $estadisticas['solicitudes_resueltas'] = $stmt->fetchColumn();

        // Solicitudes de alta prioridad
        $stmt = $this->pdo->query("SELECT COUNT(*) as solicitudes_altaprioridad FROM solicitudes WHERE prioridad = 'Alta'");
        $estadisticas['solicitudes_altaprioridad'] = $stmt->fetchColumn();
    }
    */

    // Obtener solicitudes recientes (ejemplo)
    public function obtenerSolicitudesRecientes() {
        $sql = "SELECT * FROM solicitudes ORDER BY fecha_creacion DESC LIMIT 10";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener todas las solicitudes (sin nombres, solo para referencia si se necesita en algún lugar)
    public function obtenerTodasLasSolicitudes() {
        $query = "SELECT * FROM solicitudes"; // Sin relaciones con otras tablas
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Obtener solicitudes con todos los detalles (con nombres de área, empleado y los datos del vecino)
    public function obtenerSolicitudesCompletas() {
        $sql = "SELECT s.id, s.titulo, s.descripcion, s.estado, s.fecha_creacion, 
                       a.nombre AS area_nombre, 
                       e.nombre AS empleado_nombre, 
                       s.nombre_vecino, s.telefono_vecino, s.dpi_vecino, s.estado_id
                FROM solicitudes s
                JOIN areas a ON s.area_id = a.id
                JOIN empleados e ON s.empleado_id = e.id";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva solicitud
    public function crearSolicitud($titulo, $descripcion, $area_id, $empleado_id, $nombre_vecino, $telefono_vecino, $dpi_vecino, $fecha_creacion, $estado_id) {
        $sql = "INSERT INTO solicitudes (titulo, descripcion, area_id, empleado_id, nombre_vecino, telefono_vecino, dpi_vecino, estado_id, fecha_creacion)
                VALUES (:titulo, :descripcion, :area_id, :empleado_id, :nombre_vecino, :telefono_vecino, :dpi_vecino, :estado_id, :fecha_creacion)";
        
        $stmt = $this->pdo->prepare($sql);
    
        // Asociar los parámetros a los valores
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':area_id', $area_id);
        $stmt->bindParam(':empleado_id', $empleado_id);
        $stmt->bindParam(':nombre_vecino', $nombre_vecino);
        $stmt->bindParam(':telefono_vecino', $telefono_vecino);
        $stmt->bindParam(':dpi_vecino', $dpi_vecino);
        $stmt->bindParam(':estado_id', $estado_id);
        $stmt->bindParam(':fecha_creacion', $fecha_creacion);
    
        // Ejecutar la consulta
        return $stmt->execute();
    }

    // Editar una solicitud existente
    public function editarSolicitud($id, $titulo, $descripcion, $area_id, $empleado_id, $estado_id, $fecha_actualizacion, $nombre_vecino, $telefono_vecino, $dpi_vecino) {
        $sql = "UPDATE solicitudes 
                SET titulo = :titulo, descripcion = :descripcion, area_id = :area_id, 
                    empleado_id = :empleado_id, estado_id = :estado_id, 
                    fecha_actualizacion = :fecha_actualizacion, nombre_vecino = :nombre_vecino, 
                    telefono_vecino = :telefono_vecino, dpi_vecino = :dpi_vecino 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        
        // Vinculación de parámetros
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':area_id', $area_id);
        $stmt->bindParam(':empleado_id', $empleado_id);
        $stmt->bindParam(':estado_id', $estado_id);
        $stmt->bindParam(':fecha_actualizacion', $fecha_actualizacion);
        $stmt->bindParam(':nombre_vecino', $nombre_vecino);
        $stmt->bindParam(':telefono_vecino', $telefono_vecino);
        $stmt->bindParam(':dpi_vecino', $dpi_vecino);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Método para actualizar una solicitud
    public function actualizarSolicitud($id, $titulo, $descripcion, $area_id, $empleado_id, $estado_id, $nombre_vecino, $telefono_vecino, $dpi_vecino) {
        $sql = "UPDATE solicitudes 
                SET titulo = :titulo, descripcion = :descripcion, area_id = :area_id, 
                    empleado_id = :empleado_id, estado_id = :estado_id, 
                    nombre_vecino = :nombre_vecino, telefono_vecino = :telefono_vecino, dpi_vecino = :dpi_vecino 
                WHERE id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':area_id', $area_id);
        $stmt->bindParam(':empleado_id', $empleado_id);
        $stmt->bindParam(':estado_id', $estado_id);
        $stmt->bindParam(':nombre_vecino', $nombre_vecino);
        $stmt->bindParam(':telefono_vecino', $telefono_vecino);
        $stmt->bindParam(':dpi_vecino', $dpi_vecino);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // Eliminar una solicitud
    public function eliminarSolicitud($id) {
        $sql = "DELETE FROM solicitudes WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // Obtener solicitud por ID
    public function obtenerSolicitudPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM solicitudes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cambiarEstadoSolicitud($id, $estado_id) {
        $sql = "UPDATE solicitudes SET estado_id = :estado_id WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    // Método para obtener las solicitudes por estado
    public function obtenerSolicitudesPorEstado($estado_id) {
        $sql = "SELECT s.id, s.titulo, s.descripcion, a.nombre AS area_nombre, e.nombre AS empleado_nombre, s.estado_id
                FROM solicitudes s
                JOIN areas a ON s.area_id = a.id
                JOIN empleados e ON s.empleado_id = e.id
                WHERE s.estado_id = :estado_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstadisticas() {
        $estadisticas = [];
    
        // Total de solicitudes
        $query = "SELECT COUNT(*) as total_solicitudes FROM solicitudes";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $estadisticas['total_solicitudes'] = $stmt->fetchColumn();
    
        // Solicitudes pendientes (estado = 1)
        $query = "SELECT COUNT(*) as solicitudes_pendientes FROM solicitudes WHERE estado_id = 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $estadisticas['solicitudes_pendientes'] = $stmt->fetchColumn();
    
        // Solicitudes aceptadas (estado = 4)
        $query = "SELECT COUNT(*) as solicitudes_aceptadas FROM solicitudes WHERE estado_id = 4";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $estadisticas['solicitudes_aceptadas'] = $stmt->fetchColumn();
    
        // Solicitudes rechazadas (estado = 5)
        $query = "SELECT COUNT(*) as solicitudes_rechazadas FROM solicitudes WHERE estado_id = 5";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $estadisticas['solicitudes_rechazadas'] = $stmt->fetchColumn();

        $query = "SELECT COUNT(*) as solicitude_finalizadas FROM solicitudes WHERE estado_id = 3";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $estadisticas['solicitudes_finalizadas'] = $stmt->fetchColumn();
    
        return $estadisticas;
    }
    
}
?>
