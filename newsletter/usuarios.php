<?php
$modo_embebido = $modo_embebido ?? false;

if (!$modo_embebido) {
    require_once __DIR__ . '/includes/db.php';
    require_once __DIR__ . '/includes/auth.php';
}
require_once __DIR__ . '/includes/utils.php';

requireLogin();

$rol = getUserRole();

if (!in_array($rol, ['administrativo', 'profesor'])) {
    exit("Acceso denegado.");
}

$campo = $_GET['campo'] ?? 'nombre_completo';
$buscar = $_GET['buscar'] ?? '';
$condiciones = [];
$parametros = [];

if (!empty($buscar)) {
    if ($campo === 'nombre_completo') {
        $condiciones[] = "CONCAT(nombre, ' ', apellido) LIKE ?";
        $parametros[] = "%$buscar%";
    } elseif ($campo === 'email') {
        $condiciones[] = "email LIKE ?";
        $parametros[] = "%$buscar%";
    }
}
if ($rol === 'profesor') {
    $sql = "SELECT nombre, apellido, email FROM usuarios WHERE rol = 'estudiante' AND newsletter = 1 AND activo = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $usuarios = $stmt->fetchAll();
    
} elseif ($rol === 'administrativo') {
    $sql = "SELECT id_usuario, nombre, apellido, email, rol, activo, newsletter, fecha_suscripcion FROM usuarios";

    if (!empty($condiciones)) {
        $sql .= " WHERE " . implode(" AND ", $condiciones);
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($parametros);
    $usuarios = $stmt->fetchAll();
}

?>

<h2>Listado de usuarios</h2>

<?php if ($rol === 'administrativo') : ?>
    <!-- Formulario de búsqueda solo para administrativos -->
    <form method="GET" action="panel.php" style="margin-bottom: 15px;">
        <input type="hidden" name="seccion" value="usuarios">

        <label for="campo">Buscar por:</label>
        <select name="campo" id="campo">
            <option value="nombre_completo" <?= $campo === 'nombre_completo' ? 'selected' : '' ?>>Nombre completo</option>
            <option value="email" <?= $campo === 'email' ? 'selected' : '' ?>>Email</option>
        </select>

        <input type="text" name="buscar" value="<?= htmlspecialchars($buscar) ?>" placeholder="Buscar..." required>
        <button type="submit">Buscar</button>

        <?php if (!$modo_embebido): ?>
            <a href="usuarios.php">Limpiar</a>
        <?php else: ?>
            <a href="panel.php?seccion=usuarios">Limpiar</a>
        <?php endif; ?>
    </form>
<?php endif; ?>


<table border="1" cellpadding="5">
    <tr>
        <th>Nombre</th>
        <th>Email</th>
        <?php if ($rol === 'administrativo') : ?>
            <th>Rol</th>
            <th>Activo</th>
            <th>Suscripto</th>
            <th>Fecha de suscripción</th>
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
                <td><?= $u['fecha_suscripcion'] ?? '-' ?></td> 

                <td>
                    <?php if ($u['newsletter']) : ?>
                        suscripto
                    <?php else : ?>
                        <a href="newsletter/dar_alta_newsletter.php?id=<?= $u['id_usuario'] ?>" onclick="return confirm('¿Volver a suscribir al newsletter?')">Suscribir</a>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if (!$u['newsletter']) : ?>
                        dado de baja
                    <?php else : ?>
                        <a href="newsletter/dar_baja_newsletter.php?id=<?= $u['id_usuario'] ?>" onclick="return confirm('¿Quitar del newsletter a este usuario?')">Desuscribir</a>
                    <?php endif; ?>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>

<?php if (!$modo_embebido): ?>
    <!-- Solo si se accede directamente -->
    <br><br>
    <div style="text-align: left;">
        <a href="../panel.php" style="text-decoration: none;">
            <button style="padding: 5px 10px; font-size: 16px;">Volver al Panel</button>
        </a>
    </div>
<?php endif; ?>
