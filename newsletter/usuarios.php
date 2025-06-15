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
<h2>Listado de usuarios</h2>
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


