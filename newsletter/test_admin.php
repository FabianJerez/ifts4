<?php
session_start();
$_SESSION['id_usuario'] = 1;        // ID real del admin
$_SESSION['rol'] = 'administrativo';
$_SESSION['nombre'] = 'Admin IFTS';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test Newsletter - Admin</title>
</head>
<body>
    <h2>Panel de pruebas - Administrativo</h2>
    <ul>
        <li><a href="usuarios.php">Ver usuarios</a></li>
        <li><a href="enviar_newsletter.php">Enviar newsletter</a></li>
        <li><a href="cron_baja.php">Ejecutar baja automática</a></li>
    </ul>
</body>
</html>
