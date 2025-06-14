<?php
$host = 'localhost';
$db   = 'ifts4';                // nombre de tu base de datos
$user = 'usuario';
$pass = 'contraseña';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Manejo de errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Devuelve arrays asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Usa sentencias reales
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
    exit;
}
