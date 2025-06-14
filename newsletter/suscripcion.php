<?php
require 'includes/db.php';
require 'includes/auth.php';

requireLogin(); // Verifica que haya sesión

if (!esEstudiante()) {
    exit("Solo los estudiantes pueden suscribirse al newsletter.");
}

$id_usuario = getUserId(); // ID del usuario logueado

// Verificar si ya está suscripto
$stmt = $conn->prepare("SELECT newsletter FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id_usuario]);
$usuario = $stmt->fetch();

if (!$usuario) {
    exit("Usuario no encontrado.");
}

$yaSuscripto = $usuario['newsletter'] == 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$yaSuscripto) {
    // Actualizar estado de suscripción
    $token = bin2hex(random_bytes(32)); // genera un string seguro de 64 caracteres

    $stmt = $conn->prepare("UPDATE usuarios SET newsletter = 1, fecha_suscripcion = NOW(), unsuscribe_token = ? WHERE id_usuario = ?");
    $stmt->execute([$token, $id_usuario]);

    $mensaje = "Te suscribiste al newsletter correctamente.";
    $yaSuscripto = true;
}
?>

<h2>Suscripción al Newsletter IFTS</h2>

<?php if (isset($mensaje)) : ?>
    <p><?= $mensaje ?></p>
<?php endif; ?>

<?php if ($yaSuscripto): ?>
    <p>Ya estás suscripto al newsletter.</p>
<?php else: ?>
    <form method="POST">
        <p>¿Querés recibir noticias y novedades del IFTS por correo electrónico?</p>
        <button type="submit">Suscribirme</button>
    </form>
<?php endif; ?>
