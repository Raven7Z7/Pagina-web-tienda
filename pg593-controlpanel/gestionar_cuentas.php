<?php
require_once 'includes/header.php'; 
require_once '../config/database.php'; // Salimos de 'admin' para encontrar la configuración

// Lógica para obtener todas las cuentas de la base de datos
$cuentas = [];
$sql = "SELECT id, titulo, precio, estado, usuario_steam FROM cuentas ORDER BY id DESC";
$resultado = $conexion->query($sql);

if ($resultado) {
    $cuentas = $resultado->fetch_all(MYSQLI_ASSOC);
}

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Gestionar Cuentas</h1>
    <a href="añadir_cuenta.php" class="btn btn-success">
        <i class="bi bi-plus-circle-fill"></i> Añadir Nueva Cuenta
    </a>
</div>

<?php 
// Mostrar mensajes de éxito o error que vendrán de otras páginas (añadir, editar, etc.)
if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['mensaje_tipo']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php 
    // Limpiamos el mensaje para que no se muestre de nuevo al recargar
    unset($_SESSION['mensaje']);
    unset($_SESSION['mensaje_tipo']);
endif; 
?>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Usuario Steam</th>
                        <th>Precio</th>
                        <th>Estado</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cuentas)): ?>
                        <?php foreach ($cuentas as $cuenta): ?>
                            <tr>
                                <td><?php echo $cuenta['id']; ?></td>
                                <td><?php echo htmlspecialchars($cuenta['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($cuenta['usuario_steam']); ?></td>
                                <td>$<?php echo htmlspecialchars($cuenta['precio']); ?></td>
                                <td>
                                    <?php if ($cuenta['estado'] == 'disponible'): ?>
                                        <span class="badge bg-success">Disponible</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Vendida</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="editar_cuenta.php?id=<?php echo $cuenta['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil-fill"></i> Editar
                                    </a>
                                    <a href="eliminar_cuenta.php?id=<?php echo $cuenta['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta cuenta? Esta acción no se puede deshacer.');">
                                        <i class="bi bi-trash-fill"></i> Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No hay cuentas para mostrar. ¡Añade una nueva!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$conexion->close();
require_once 'includes/footer.php'; 
?>