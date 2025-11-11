<?php
// Usamos nuestro método seguro para iniciar la sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$page_title = '¡Gracias por tu compra!';
require_once 'layouts/header.php';

// Verificamos que tengamos un ID de orden y que el usuario haya iniciado sesión
if (!isset($_GET['orderID']) || empty($_SESSION['user_id'])) {
    // Si no, lo mandamos al inicio para evitar que accedan a esta página directamente
    // Usamos JavaScript para la redirección para evitar errores de "headers already sent"
    echo '<script>window.location.href = "index.php";</script>';
    exit();
}
?>

<div class="container text-center py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="display-4 text-success"><i class="bi bi-check-circle-fill"></i> ¡Pago Completado!</h1>
            <p class="lead mt-3">
                Muchas gracias, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>. Tu pedido ha sido procesado exitosamente.
            </p>
            <p>
                Tu ID de transacción de PayPal es: <strong><?php echo htmlspecialchars($_GET['orderID']); ?></strong>
            </p>
            
            <hr class="my-4">
            
            <div class="card bg-light border-0 shadow-sm p-4">
                <h5 class="card-title">¿Qué sigue ahora?</h5>
                <p class="card-text">
                    Puedes acceder a las credenciales e instrucciones de tu(s) cuenta(s) en cualquier momento desde tu historial de pedidos.
                </p>
                <a href="mis_pedidos.php" class="btn btn-primary btn-lg mt-3">
                    <i class="bi bi-box-seam-fill me-2"></i> Ir a Mis Pedidos Ahora
                </a>
            </div>

            <a href="index.php" class="btn btn-link mt-4">Volver a la tienda</a>
        </div>
    </div>
</div>


<?php
require_once 'layouts/footer.php';
?>