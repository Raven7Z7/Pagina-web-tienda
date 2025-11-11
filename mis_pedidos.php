<?php
// Incluimos la cabecera para iniciar la sesión y la seguridad primero.
require_once 'layouts/header.php';
require_once 'config/database.php';

// Si el usuario no ha iniciado sesión, no tiene nada que hacer aquí.
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['user_id'];
$pedidos = [];

// La consulta SQL para obtener los pedidos del usuario, uniendo la tabla de cuentas para obtener los detalles.
$sql = "SELECT 
            p.fecha_pedido, 
            p.id_transaccion_paypal, 
            c.titulo, 
            c.usuario_steam, 
            c.password_steam,
            c.instrucciones,
            c.id AS cuenta_id  -- Usamos un alias para el ID de la cuenta para evitar confusiones
        FROM 
            pedidos p
        JOIN 
            cuentas c ON p.id_cuenta = c.id
        WHERE 
            p.id_usuario = ?
        ORDER BY 
            p.fecha_pedido DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $pedidos[] = $row;
    }
}
$stmt->close();
$conexion->close();
?>

<div class="card shadow-sm">
    <div class="card-header text-center">
        <h2><i class="bi bi-box-seam-fill"></i> Mi Historial de Pedidos</h2>
    </div>
    <div class="card-body p-4">

        <?php if (!empty($pedidos)): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Fecha de Compra</th>
                            <th>Producto</th>
                            <th>ID de Transacción (PayPal)</th>
                            <th class="text-center">Credenciales e Instrucciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?php echo date("d/m/Y H:i", strtotime($pedido['fecha_pedido'])); ?></td>
                                <td><?php echo htmlspecialchars($pedido['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($pedido['id_transaccion_paypal']); ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" onclick="mostrarCredenciales(<?php echo $pedido['cuenta_id']; ?>)">
                                        <i class="bi bi-eye-fill"></i> Mostrar
                                    </button>
                                </td>
                            </tr>
                            <!-- Fila oculta con las credenciales -->
                            <tr id="credenciales-<?php echo $pedido['cuenta_id']; ?>" style="display: none;">
                                <td colspan="4" class="bg-light p-4">
                                    <h5>Detalles de la Cuenta: <?php echo htmlspecialchars($pedido['titulo']); ?></h5>
                                    <p>
                                        <strong>Usuario Steam:</strong> 
                                        <span class="text-danger fw-bold"><?php echo htmlspecialchars($pedido['usuario_steam']); ?></span>
                                    </p>
                                    <p>
                                        <strong>Contraseña:</strong> 
                                        <span class="text-danger fw-bold"><?php echo htmlspecialchars($pedido['password_steam']); ?></span>
                                    </p>
                                    <hr>
                                    <h6><strong>Instrucciones Cruciales:</strong></h6>
                                    <div>
                                        <?php 
                                        // Si hay instrucciones personalizadas, las mostramos. Si no, mostramos un mensaje por defecto.
                                        if (!empty($pedido['instrucciones'])) {
                                            echo nl2br(htmlspecialchars($pedido['instrucciones']));
                                        } else {
                                            echo 'No se proporcionaron instrucciones específicas para esta cuenta. Por favor, sigue el método estándar de jugar en modo desconectado.';
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <h4>Aún no has realizado ninguna compra.</h4>
                <p>¡Explora nuestro catálogo y empieza tu próxima aventura!</p>
                <a href="index.php" class="btn btn-primary">
                    <i class="bi bi-arrow-left-circle"></i> Volver a la tienda
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Pequeño script para mostrar/ocultar las credenciales
    function mostrarCredenciales(cuentaId) {
        const filaCredenciales = document.getElementById('credenciales-' + cuentaId);
        if (filaCredenciales) {
            if (filaCredenciales.style.display === 'none') {
                filaCredenciales.style.display = 'table-row';
            } else {
                filaCredenciales.style.display = 'none';
            }
        }
    }
</script>

<?php
require_once 'layouts/footer.php';
?>