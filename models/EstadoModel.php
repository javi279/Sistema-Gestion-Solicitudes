<?php
// EstadoModel.php

class EstadoModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Método para obtener todos los estados de la tabla 'estados_solicitud'
    public function obtenerEstados() {
        $query = "SELECT id, nombre_estado FROM estados_solicitud";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener un estado por su ID
    public function obtenerEstadoPorId($id) {
        $query = "SELECT id, nombre_estado FROM estados_solicitud WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
