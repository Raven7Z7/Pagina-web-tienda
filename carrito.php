<?php
// PASO 1: INICIAMOS LA SESIÓN Y LA LÓGICA
// Como no hemos incluido el header aún, necesitamos iniciar la sesión manualmente aquí.
// Pero como nuestro header es inteligente, no habrá conflicto.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';

// PASO 2: LA VERIFICACIÓN CRÍTICA (ANTES DE CUALQUIER HTML)
// Si el usuario no ha iniciado sesión, lo redirigimos AHORA.
if (empty($_SESSION['user_id'])) {
    header('Location: login.php?redirect=carrito.php');
    exit(); // Detenemos todo, no se ejecutará nada más.
}

// PASO 3: SI EL USUARIO TIENE PERMISO, CONTINUAMOS CON LA LÓGICA DE LA PÁGINA
$items_carrito = [];
$total = 0;

if (!empty($_SESSION['carrito'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['carrito']), '?'));
    $sql = "SELECT id, titulo, precio FROM cuentas WHERE id IN ($placeholders)";
    $stmt = $conexion->prepare($sql);
    
    if($stmt) {
        $tipos = str_repeat('i', count($_SESSION['carrito']));
        $stmt->bind_param($tipos, ...$_SESSION['carrito']);
        $stmt->execute();
        $resultado = $stmt->get_result();

        while ($row = $resultado->fetch_assoc()) {
            $items_carrito[] = $row;
            $total += $row['precio'];
        }
        $stmt->close();
    }
}
$conexion->close();

// PASO 4: AHORA QUE TODA LA LÓGICA ESTÁ COMPLETA, "DIBUJAMOS" LA PÁGINA
require_once 'layouts/header.php';
?>

<!-- El resto de tu código HTML para el carrito va aquí, sin cambios -->
<div class="card">
    <div class="card-header text-center">
        <h2><i class="bi bi-cart-check-fill"></i> Tu Carrito de Compras</h2>
    </div>
    <div class="card-body">
        <?php if (!empty($items_carrito)): ?>
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col" class="text-end">Precio</th>
                        <th scope="col" class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items_carrito as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['titulo']); ?></td>
                            <td class="text-end">
                                <!-- Lógica para mostrar "GRATIS" si el precio es 0 -->
                                <?php if ($item['precio'] > 0): ?>
                                    $<?php echo htmlspecialchars(number_format($item['precio'], 2)); ?> USD
                                <?php else: ?>
                                    <span class="text-success fw-bold">GRATIS</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="acciones_carrito.php?accion=remover&id=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash-fill"></i> Quitar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <hr>

            <div class="d-flex justify-content-end align-items-center">
                <h3 class="me-3">Total:</h3>
                <h3 class="text-success">$<?php echo number_format($total, 2); ?></h3>
            </div>

            <!-- ======================================================= -->
            <!-- ===== AQUÍ ESTÁ LA LÓGICA PARA EL BOTÓN DE PAGO ===== -->
            <!-- ======================================================= -->
            <?php if ($total > 0): ?>
                <!-- Si el total es MAYOR a 0, mostramos PayPal -->
                <div class="mt-4 text-center">
                    <p class="text-muted">Paga de forma segura con PayPal</p>
                    <div id="paypal-button-container" style="max-width: 500px; margin: auto;"></div>
                </div>
            <?php else: ?>
                <!-- Si el total es 0, mostramos el botón para obtener gratis -->
                <div class="mt-4 text-center">
                    <p class="text-success fw-bold">¡Este producto es tuyo sin costo!</p>
                    <a href="procesar_gratis.php" class="btn btn-success btn-lg">
                        <i class="bi bi-gift-fill"></i> ¡Obtener Gratis Ahora!
                    </a>
                </div>
            <?php endif; ?>
            <!-- ======================================================= -->
            
        <?php else: ?>
            <div class="text-center py-5">
                <h4>Tu carrito está vacío.</h4>
                <p>No tienes productos en tu carrito de compras.</p>
                <a href="index.php" class="btn btn-primary">
                    <i class="bi bi-arrow-left-circle"></i> ¡Volver a la tienda!
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($items_carrito)): ?>
    <!-- ... (tu script de PayPal) ... -->
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo PAYPAL_CLIENT_ID; ?>&currency=USD"></script>
    <script>
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color:  'gold',
                shape:  'rect',
                label:  'pay',
                tagline: false
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: { value: '<?php echo number_format($total, 2, '.', ''); ?>' }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    fetch('procesar_pago.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ orderID: data.orderID, transactionDetails: details })
                    }).then(res => res.json())
                      .then(data => {
                          if(data.success) {
                              window.location.href = 'gracias.php?orderID=' + data.orderID;
                          } else {
                              alert('Hubo un error al procesar tu pago. Por favor, contacta a soporte.');
                          }
                      });
                });
            }
        }).render('#paypal-button-container');
    </script>
<?php endif; ?>

<?php
require_once 'layouts/footer.php';
?>