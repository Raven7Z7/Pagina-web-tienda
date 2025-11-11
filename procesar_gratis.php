<?php

// ¡LA SOLUCIÓN! Iniciamos la sesión para poder acceder a $_SESSION
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/database.php';

// Verificamos que el usuario haya iniciado sesión Y que el carrito no esté vacío
if (empty($_SESSION['user_id']) || empty($_SESSION['carrito'])) {
    // Si no, lo mandamos al inicio
    header('Location: index.php');
    exit();
}

$id_usuario = $_SESSION['user_id'];

// Volvemos a calcular el total para asegurarnos de que realmente es gratis
$total = 0;
// Usamos try-catch para manejar posibles errores de base de datos de forma elegante
try {
    $placeholders = implode(',', array_fill(0, count($_SESSION['carrito']), '?'));
    $sql_check = "SELECT SUM(precio) as total FROM cuentas WHERE id IN ($placeholders)";
    $stmt_check = $conexion->prepare($sql_check);
    $tipos = str_repeat('i', count($_SESSION['carrito']));
    $stmt_check->bind_param($tipos, ...$_SESSION['carrito']);
    $stmt_check->execute();
    $resultado_check = $stmt_check->get_result();
    $total = $resultado_check->fetch_assoc()['total'];

    if ($total > 0) {
        // Medida de seguridad: si el carrito contiene items de pago, redirigir al carrito
        header('Location: carrito.php');
        exit();
    }

    // Usamos una transacción para asegurar la integridad de los datos
    $conexion->begin_transaction();
    
    foreach ($_SESSION['carrito'] as $id_cuenta) {
        $id_transaccion = "GRATIS-" . uniqid(); // Creamos un ID de transacción único para el registro
        $monto_pagado = 0.00;

        $sql_pedido = "INSERT INTO pedidos (id_usuario, id_cuenta, id_transaccion_paypal, monto_pagado) VALUES (?, ?, ?, ?)";
        $stmt_pedido = $conexion->prepare($sql_pedido);
        $stmt_pedido->bind_param("iisd", $id_usuario, $id_cuenta, $id_transaccion, $monto_pagado);
        $stmt_pedido->execute();
    }
    
    $conexion->commit();
    
    // Vaciamos el carrito
    unset($_SESSION['carrito']);
    
    // Redirigimos a la página de pedidos para que el usuario vea su nuevo producto
    header('Location: mis_pedidos.php?status=success');
    exit();

} catch (Exception $e) {
    // Si algo falla en cualquier punto, revertimos la transacción
    if ($conexion->ping()) { // Verificamos si la conexión sigue activa antes de hacer rollback
        $conexion->rollback();
    }
    // Mostramos un error genérico (en un sitio en producción, guardaríamos el error en un log)
    die("Hubo un error al procesar tu solicitud. Por favor, intenta de nuevo. Error: ".$e->getMessage());
}
?>