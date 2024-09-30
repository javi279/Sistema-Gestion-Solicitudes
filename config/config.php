<?php
// config.php

$host = 'localhost';
$dbname = 'request_management_system';
$username = 'root'; // Cambia si usas otro usuario
$password = '';     // Cambia si usas una contraseña

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}
