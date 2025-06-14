<?php
require 'newsletter/includes/auth.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio Newsletter</title>
</head>
<body>
    <h2>Bienvenido/a, <?= $_SESSION['nombre'] ?> (<?= $_SESSION['rol'] ?>)</h2>

    <ul>
        <?php if (esEstudiante()) : ?>
            <li><a href="newsletter/suscripcion.php">Suscribirme al Newsletter</a></li>
        <?php endif; ?>

        <?php if (esProfesor()) : ?>
            <li><a href="newsletter/usuarios.php">Ver estudiantes suscriptos</a></li>
        <?php endif; ?>

        <?php if (esAdministrativo()) : ?>
            <li><a href="newsletter/usuarios.php">Ver todos los usuarios</a></li>
            <li><a href="newsletter/enviar_newsletter.php">Enviar Newsletter</a></li>
            <li><a href="newsletter/cron_baja.php">Ejecutar baja automática</a></li>
        <?php endif; ?>

        <li><a href="logout.php">Cerrar sesión</a></li>
    </ul>
</body>
</html>
