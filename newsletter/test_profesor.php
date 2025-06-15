<?php
session_start();
$_SESSION['id_usuario'] = 11;        // ID real del profesor
$_SESSION['rol'] = 'profesor';
$_SESSION['nombre'] = 'Ruben';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test Newsletter - Profesor</title>
</head>
<body>
    <h2>Panel de pruebas - Profesor</h2>
    <ul>
        <li><a href="usuarios.php">Ver estudiantes suscriptos</a></li>
    </ul>
</body>
</html>
