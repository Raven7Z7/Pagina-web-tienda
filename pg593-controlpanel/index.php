<?php
require_once 'includes/header.php'; 
require_once '../config/database.php';

// --- LÓGICA PARA CALCULAR LAS ESTADÍSTICAS DEL DASHBOARD ---

// 1. Contar el número total de cuentas
$total_cuentas_sql = "SELECT COUNT(id) AS total FROM cuentas";
$total_cuentas_resultado = $conexion->query($total_cuentas_sql);
$total_cuentas = $total_cuentas_resultado->fetch_assoc()['total'];

// 2. Contar las cuentas disponibles
$disponibles_sql = "SELECT COUNT(id) AS total FROM cuentas WHERE estado = 'disponible'";
$disponibles_resultado = $conexion->query($disponibles_sql);
$cuentas_disponibles = $disponibles_resultado->fetch_assoc()['total'];

// 3. Contar las cuentas vendidas
$vendidas_sql = "SELECT COUNT(id) AS total FROM cuentas WHERE estado = 'vendida'";
$vendidas_resultado = $conexion->query($vendidas_sql);
$cuentas_vendidas = $vendidas_resultado->fetch_assoc()['total'];

// 4. Calcular los ingresos totales sumando la columna 'monto_pagado' de la tabla 'pedidos'
$ingresos_sql = "SELECT SUM(monto_pagado) AS total FROM pedidos";
$ingresos_resultado = $conexion->query($ingresos_sql);
// Usamos number_format para que se vea bonito, y ?? 0 por si aún no hay pedidos.
$ingresos_totales = number_format($ingresos_resultado->fetch_assoc()['total'] ?? 0, 2);

// 5. Opcional: Obtener los últimos 5 pedidos para una tabla de "Actividad Reciente"
$ultimos_pedidos_sql = "SELECT p.fecha_pedido, c.titulo, p.monto_pagado 
                        FROM pedidos p 
                        JOIN cuentas c ON p.id_cuenta = c.id 
                        ORDER BY p.fecha_pedido DESC 
                        LIMIT 5";
$ultimos_pedidos_resultado = $conexion->query($ultimos_pedidos_sql);

?>

<h1 class="mb-4">Dashboard</h1>
<p class="lead">Resumen general de tu tienda, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>.</p>
<hr>

<!-- Fila de Tarjetas de Estadísticas -->
<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3 shadow">
            <div class="card-header"><i class="bi bi-joystick"></i> Cuentas Totales</div>
            <div class="card-body">
                <h4 class="card-title"><?php echo $total_cuentas; ?></h4>
                <p class="card-text">En inventario.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3 shadow">
            <div class="card-header"><i class="bi bi-check-circle-fill"></i> Cuentas Disponibles</div>
            <div class="card-body">
                <h4 class="card-title"><?php echo $cuentas_disponibles; ?></h4>
                <p class="card-text">Listas para la venta.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3 shadow">
            <div class="card-header"><i class="bi bi-cart-check-fill"></i> Cuentas Vendidas</div>
            <div class="card-body">
                <h4 class="card-title"><?php echo $cuentas_vendidas; ?></h4>
                <p class="card-text">Adquiridas por clientes.</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3 shadow">
            <div class="card-header"><i class="bi bi-cash-stack"></i> Ingresos Totales</div>
            <div class="card-body">
                <h4 class="card-title">$<?php echo $ingresos_totales; ?></h4>
                <p class="card-text">Generados (USD).</p>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Actividad Reciente -->
<div class="card mt-4 shadow-sm">
    <div class="card-header">
        <i class="bi bi-clock-history"></i> Actividad Reciente (Últimos 5 Pedidos)
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto Vendido</th>
                        <th class="text-end">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ultimos_pedidos_resultado->num_rows > 0): ?>
                        <?php while($pedido = $ultimos_pedidos_resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo date("d/m/Y H:i", strtotime($pedido['fecha_pedido'])); ?></td>
                                <td><?php echo htmlspecialchars($pedido['titulo']); ?></td>
                                <td class="text-end">$<?php echo number_format($pedido['monto_pagado'], 2); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">Aún no se han registrado ventas.</td>
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