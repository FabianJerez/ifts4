<?php
require_once __DIR__ . '/newsletter/includes/db.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id_usuario, nombre, apellido, rol, password FROM usuarios WHERE email = ? AND activo = 1");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && $usuario['password'] === $password) {
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nombre'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
        $_SESSION['rol'] = $usuario['rol'];

        header("Location: panel.php"); // o test_admin.php, según el rol
        exit;
    } else {
        $mensaje = "Email o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login de prueba - Newsletter</title>
</head>
<body>
    <h2>Login de prueba</h2>

    <?php if ($mensaje): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Ingresar</button>
    </form>
    <form action="registro.php" method="get" style="margin-top: 10px;">
        <button type="submit">Registrarse</button>
    </form>

</body>
</html>
