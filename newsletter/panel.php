<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

requireLogin();
$seccion = $_GET['seccion'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel principal - Newsletter IFTS 4</title>
</head>
<body>

<div style="display: flex; min-height: 100vh; font-family: sans-serif;">

    <!-- Barra lateral -->
    <nav style="min-width: 220px; background-color: #f0f0f0; padding: 20px;">
        <h3>Panel</h3>
        <p><?= $_SESSION['nombre'] ?> (<?= $_SESSION['rol'] ?>)</p>

        <?php if (esEstudiante()) : ?>
            <form method="get">
                <button name="seccion" value="suscripcion" style="width: 100%; margin-bottom: 10px;">Suscribirme al Newsletter</button>
            </form>
        <?php endif; ?>

        <?php if (esProfesor()) : ?>
            <form method="get">
                <button name="seccion" value="usuarios" style="width: 100%; margin-bottom: 10px;">Ver estudiantes suscriptos</button>
            </form>
        <?php endif; ?>

        <?php if (esAdministrativo()) : ?>
            <form method="get">
                <button name="seccion" value="usuarios" style="width: 100%; margin-bottom: 10px;">Ver todos los usuarios</button>
            </form>
            <form method="get">
                <button name="seccion" value="enviar" style="width: 100%; margin-bottom: 10px;">Enviar Newsletter</button>
            </form>
            <form method="get">
                <button name="seccion" value="baja_auto" style="width: 100%; margin-bottom: 10px;">Ejecutar baja automática</button>
            </form>
        <?php endif; ?>

        <form action="../logout.php" method="get">
            <button type="submit" style="width: 100%; margin-top: 20px;">Cerrar sesión</button>
        </form>
    </nav>

    <!-- Contenido principal -->
    <main style="flex: 1; padding: 30px;">
        <?php
        switch ($seccion) {
            case 'usuarios':
                $modo_embebido = true;
                include __DIR__ . '/usuarios.php';
                break;
            case 'suscripcion':
                include __DIR__ . '/suscripcion.php';
                break;
            case 'enviar':
                $modo_embebido = true;
                include __DIR__ . '/enviar_newsletter.php';
                break;
            case 'baja_auto':
                $modo_embebido = true;
                include __DIR__ . '/cron_baja.php';
                break;
            default:
                echo "<h2>Bienvenido/a al sistema Newsletter del IFTS 4</h2>";
                echo "<p>Seleccioná una opción del menú lateral para comenzar.</p>";
                break;
        }

        ?>
    </main>
</div>

</body>
</html>





