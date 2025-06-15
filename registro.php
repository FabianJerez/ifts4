<?php
require 'newsletter/includes/db.php';
session_start();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rol      = $_POST['rol'] ?? 'estudiante';

    // Verificar si ya existe el correo
    $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $existe = $stmt->fetchColumn();

    if ($existe) {
        $mensaje = "Ya existe un usuario con ese correo.";
    } else {
        // Insertar nuevo usuario
        $stmt = $conn->prepare("
            INSERT INTO usuarios (nombre, apellido, email, password, rol, activo, estado_aprobacion) 
            VALUES (?, ?, ?, ?, ?, 1, 'aprobado')
        ");
        $stmt->execute([$nombre, $apellido, $email, $password, $rol]);

        $mensaje = "Usuario registrado correctamente. Ya podés iniciar sesión.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de prueba</title>
</head>
<body>
    <h2>Registrar nuevo usuario (de prueba)</h2>

    <?php if ($mensaje): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Apellido:</label><br>
        <input type="text" name="apellido" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Rol:</label><br>
        <select name="rol">
            <option value="estudiante">Estudiante</option>
            <option value="profesor">Profesor</option>
            <option value="administrativo">Administrativo</option>
        </select><br><br>

        <button type="submit">Registrar</button>
    </form>

    <p><a href="login.php">Ir al Login</a></p>
</body>
</html>
