<?php
$modo_embebido = $modo_embebido ?? false;

require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/utils.php';

if (!$modo_embebido) {
    require_once __DIR__ . '/includes/auth.php';

    if (getUserRole() !== 'administrativo') {  //control de acceso
        exit("Acceso denegado");
    }
}

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

</body>
</html>
