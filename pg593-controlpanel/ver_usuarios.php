<?php
require_once 'includes/header.php'; 
require_once '../config/database.php';

// Lógica para obtener todos los usuarios de la base de datos
$usuarios = [];
// Seleccionamos los usuarios y los ordenamos por fecha de registro descendente (los más nuevos primero)
$sql = "SELECT id, nombre, email, fecha_registro FROM usuarios ORDER BY fecha_registro DESC";
$resultado = $conexion->query($sql);

if ($resultado) {
    // Obtenemos todos los resultados en un array asociativo
    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC);
}

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Ver Usuarios Registrados</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Fecha de Registro</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                <td><?php echo date("d/m/Y", strtotime($usuario['fecha_registro'])); ?></td>
                                <td class="text-end">
                                    <!-- En el futuro, podríamos añadir aquí botones para ver los pedidos de este usuario -->
                                    <a href="#" class="btn btn-info btn-sm disabled" title="Ver pedidos (próximamente)">
                                        <i class="bi bi-box-seam-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay usuarios registrados.</td>
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