<?php
// models/UsuarioModel.php

class UsuarioModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios() {
        $stmt = $this->pdo->query('SELECT * FROM usuarios');
        return $stmt->fetchAll();
    }

    // Obtener usuario por ID
    public function obtenerUsuarioPorId($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Crear un nuevo usuario
    public function crearUsuario($datos) {
        $sql = "INSERT INTO usuarios (nombre, apellido, email, password, rol) VALUES (:nombre, :apellido, :email, :password, :rol)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($datos);
    }

    // Actualizar usuario
    public function actualizarUsuario($id, $datos) {
        $sql = "UPDATE usuarios SET nombre = :nombre, apellido = :apellido, email = :email, rol = :rol WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_merge($datos, ['id' => $id]));
    }

    // Eliminar usuario
    public function eliminarUsuario($id) {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    // Verificar credenciales de login
    public function verificarCredenciales($email, $password) {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        
        return false;
    }

        // UsuarioModel.php
        public function verificarUsuario($email, $password) {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        return $usuario;
    }

    return false;
}

public function actualizarContraseña($id, $nueva_contraseña) {
    $stmt = $this->pdo->prepare("UPDATE usuarios SET password = :password WHERE id = :id");
    $stmt->execute(['password' => password_hash($nueva_contraseña, PASSWORD_DEFAULT), 'id' => $id]);
}

public function actualizarEmail($id, $nuevo_email) {
    $stmt = $this->pdo->prepare("UPDATE usuarios SET email = :email WHERE id = :id");
    $stmt->execute(['email' => $nuevo_email, 'id' => $id]);
}

public function actualizarPerfil($id, $nombre, $rol) {
    $stmt = $this->pdo->prepare("UPDATE usuarios SET nombre = :nombre, rol = :rol WHERE id = :id");
    $stmt->execute(['nombre' => $nombre, 'rol' => $rol, 'id' => $id]);
}

public function actualizarPreferenciasNotificaciones($id, $notificaciones) {
    $stmt = $this->pdo->prepare("UPDATE usuarios SET notificaciones = :notificaciones WHERE id = :id");
    $stmt->execute(['notificaciones' => $notificaciones, 'id' => $id]);
}
}


