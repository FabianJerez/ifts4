<?php
// Simula vista del estudiante
session_start();
$_SESSION['id_usuario'] = 3;        // Usá un ID real
$_SESSION['rol'] = 'estudiante';
$_SESSION['nombre'] = 'Juan';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test Newsletter - Estudiante</title>
</head>
<body>
    <h2>Bienvenido, <?= $_SESSION['nombre'] ?></h2>
    <p>Probá la suscripción al newsletter:</p>
    <a href="suscripcion.php">📩 Suscribirme al newsletter</a>
</body>
</html>
