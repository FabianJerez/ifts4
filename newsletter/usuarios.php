<?php
require 'includes/db.php';
require 'includes/auth.php';
requireLogin(); // Asegura que haya sesión iniciada

$rol = getUserRole();   //definido en auth.php

if (!in_array($rol, ['administrativo', 'profesor'])) {
    exit("Acceso denegado.");
}

if ($rol === 'profesor') {
    // Profesores ven estudiantes suscriptos y activos
    $stmt = $conn->prepare("SELECT nombre, apellido, email FROM usuarios WHERE rol = 'estudiante' AND newsletter = 1 AND activo = 1");
} else {
    // Administrativos ven todo
    $stmt = $conn->prepare("SELECT id_usuario, nombre, apellido, email, rol, activo, newsletter FROM usuarios");
}

$stmt->execute();
$usuarios = $stmt->fetchAll();
?>

<h2>Listado de usuarios</h2>
<table border="1" cellpadding="5">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <?php if ($rol === 'administrativo') : ?>
            <th>Rol</th>
            <th>Activo</th>
            <th>Suscripto</th>
            <th>Acciones</th>
        <?php endif; ?>
    </tr>

    <?php foreach ($usuarios as $u) : ?>
        <tr>
            <td><?= $u['nombre'] . ' ' . $u['apellido'] ?></td>
            <td><?= $u['email'] ?></td>

            <?php if ($rol === 'administrativo') : ?>
                <td><?= $u['rol'] ?></td>
                <td><?= $u['activo'] ? 'Sí' : 'No' ?></td>
                <td><?= $u['newsletter'] ? 'Sí' : 'No' ?></td>
                <td>
                    <?php if ($u['activo']) : ?>
                        <a href="dar_baja.php?id=<?= $u['id_usuario'] ?>" onclick="return confirm('¿Dar de baja a este usuario?')">Baja</a>
                    <?php endif; ?>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>

