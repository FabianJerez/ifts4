<?php
require 'includes/db.php';
require 'includes/auth.php';
requireLogin(); // Asegura que haya sesión iniciada

$rol = getUserRole();   //definido en auth.php

if (!in_array($rol, ['administrativo', 'profesor'])) {
    exit("Acceso denegado.");
}

//Busqueda por nombre completo o por email
$campo = $_GET['campo'] ?? 'nombre_completo';
$buscar = $_GET['buscar'] ?? '';
$where = '';
$parametros = [];

if (!empty($buscar)) {
    if ($campo === 'nombre_completo') {
        $where = "WHERE CONCAT(nombre, ' ', apellido) LIKE ?";
        $parametros[] = "%$buscar%";
    } elseif ($campo === 'email') {
        $where = "WHERE email LIKE ?";
        $parametros[] = "%$buscar%";
    }
}

if ($rol === 'profesor') {
    $sql = "SELECT nombre, apellido, email FROM usuarios WHERE rol = 'estudiante' AND newsletter = 1 AND activo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll();
} elseif ($rol === 'administrativo') {
    $sql = "SELECT id_usuario, nombre, apellido, email, rol, activo, newsletter FROM usuarios $where";
    $stmt = $conn->prepare($sql);
    $stmt->execute($parametros);
    $usuarios = $stmt->fetchAll();
}


$stmt->execute();
$usuarios = $stmt->fetchAll();
?>

<h2>Listado de usuarios</h2>
<!-- Formulario de busqueda -->
<form method="GET" style="margin-bottom: 15px;">
    <label for="campo">Buscar por:</label>
    <select name="campo" id="campo">
        <option value="nombre_completo" <?= $campo === 'nombre_completo' ? 'selected' : '' ?>>Nombre completo</option>
        <option value="email" <?= $campo === 'email' ? 'selected' : '' ?>>Email</option>
    </select>

    <input type="text" name="buscar" value="<?= htmlspecialchars($buscar) ?>" placeholder="Buscar..." required>
    <button type="submit">Buscar</button>
    <a href="usuarios.php">Limpiar</a>
</form>

<table border="1" cellpadding="5">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <?php if ($rol === 'administrativo') : ?>
            <th>Rol</th>
            <th>Activo</th>
            <th>Suscripto</th>
            <th>Alta newsletter</th>
            <th>Baja newsletter</th>
        <?php endif; ?>
    </tr>

    <?php foreach ($usuarios as $u) : ?>
        <tr>
            <td><?= $u['nombre'] . ' ' . $u['apellido'] ?></td>
            <td><?= $u['email'] ?></td>

            <?php if ($rol === 'administrativo') : ?>
                <td><?= $u['rol'] ?></td>
                <td><?= $u['activo'] ? 'Sí' : 'No' ?></td>
                <td><?= $u['newsletter'] ? 'suscripto' : 'no suscripto' ?></td>

                <!-- Alta newsletter -->
                <td>
                    <?php if ($u['newsletter']) : ?>
                        suscripto
                    <?php else : ?>
                        <a href="dar_alta_newsletter.php?id=<?= $u['id_usuario'] ?>" onclick="return confirm('¿Volver a suscribir al newsletter?')">Suscribir</a>
                    <?php endif; ?>
                </td>

                <!-- Baja newsletter -->
                <td>
                    <?php if (!$u['newsletter']) : ?>
                        dado de baja
                    <?php else : ?>
                        <a href="dar_baja_newsletter.php?id=<?= $u['id_usuario'] ?>" onclick="return confirm('¿Quitar del newsletter a este usuario?')">Desuscribir</a>
                    <?php endif; ?>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
<!-- boton de regreso al panel -->
<br><br>
<div style="text-align: left;">
    <a href="../panel.php" style="text-decoration: none;">
        <button style="padding: 5px 10px; font-size: 16px;">Volver al Panel</button>
    </a>
</div>



