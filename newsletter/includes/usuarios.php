<?php
require 'includes/db.php';
require 'includes/auth.php';
requireLogin(); // Asegura que haya sesión iniciada

$rol = getUserRole();

if (!in_array($rol, ['administrativo', 'profesor'])) {
    exit("Acceso denegado.");
}

// Si el usuario es profesor, mostrar solo estudiantes suscriptos
if ($rol === 'profesor') {
    $sql = "SELECT nombre, apellido, email FROM usuarios WHERE rol = 'estudiante' AND newsletter = 1 AND activo = 1";
} else {
    // Administrativo ve todos
    $sql = "SELECT id_usuario, nombre, apellido, email, rol, activo, newsletter FROM usuarios";
}

$resultado = $conn->query($sql);
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

    <?php while ($u = $resultado->fetch_assoc()) : ?>
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
    <?php endwhile; ?>
</table>
