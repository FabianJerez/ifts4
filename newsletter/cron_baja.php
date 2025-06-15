<?php
require 'includes/db.php';
require 'includes/utils.php';

// Opcional: control de acceso
require 'includes/auth.php';
if (getUserRole() !== 'administrativo') exit("Acceso denegado");

// Ejecutar y mostrar bajas
$bajas = verificarYDarBajaAutomatica($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bajas Automáticas</title>
</head>
<body>

<h2>Bajas Automáticas del Newsletter</h2>

<?php if (!empty($bajas)) : ?>
    <h3>Usuarios dados de baja:</h3>
    <ul>
        <?php foreach ($bajas as $u) : ?>
            <li><?= "{$u['nombre']} {$u['apellido']} - {$u['email']} (desde {$u['fecha_suscripcion']})" ?></li>
        <?php endforeach; ?>
    </ul>
    <p><strong>Total: <?= count($bajas) ?></strong></p>
<?php else : ?>
    <p>No hay usuarios para dar de baja en este momento.</p>
<?php endif; ?>

<!-- Botón para volver al panel -->
<div class="volver">
    <a href="../index.php" style="text-decoration: none;">
        <button style="padding: 5px 10px; font-size: 16px;">Volver al Panel</button>
    </a>
</div>

</body>
</html>
