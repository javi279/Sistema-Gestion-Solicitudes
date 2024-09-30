<?php
// models/AreaModel.php

class AreaModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todas las áreas
    public function obtenerAreas() {
        $stmt = $this->pdo->query('SELECT * FROM areas');
        return $stmt->fetchAll();
    }

    // Crear una nueva área
    public function crearArea($nombre, $descripcion) {
        $sql = "INSERT INTO areas (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion]);
    }

    // Obtener un área por ID
    public function obtenerAreaPorId($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM areas WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Actualizar área
    public function actualizarArea($id, $nombre, $descripcion) {
        $sql = "UPDATE areas SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['nombre' => $nombre, 'descripcion' => $descripcion, 'id' => $id]);
    }

    // Eliminar área
    public function eliminarArea($id) {
        $stmt = $this->pdo->prepare('DELETE FROM areas WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
?>
