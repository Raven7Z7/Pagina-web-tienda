<?php
session_start();
require_once 'config/database.php';

// Obtener el cuerpo de la solicitud (que es JSON enviado desde el frontend)
$json_str = file_get_contents('php://input');
$json_obj = json_decode($json_str);

$orderID = $json_obj->orderID;

// Preparamos la respuesta que enviaremos de vuelta al frontend
header('Content-Type: application/json');
$response = ['success' => false];

// Verificar que la orden y el usuario existan
if ($orderID && isset($_SESSION['user_id']) && !empty($_SESSION['carrito'])) {

    // --- Verificación con la API de PayPal ---
    // 1. Obtener un Access Token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, PAYPAL_API_URL . '/v1/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ':' . PAYPAL_SECRET);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    $headers = ['Accept: application/json', 'Accept-Language: en_US'];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    curl_close($ch);
    $accessToken = json_decode($result)->access_token;

    // 2. Verificar los detalles del pedido con el Access Token
    $ch_verify = curl_init();
    curl_setopt($ch_verify, CURLOPT_URL, PAYPAL_API_URL . '/v2/checkout/orders/' . $orderID);
    curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
    $headers_verify = ['Content-Type: application/json', 'Authorization: Bearer ' . $accessToken];
    curl_setopt($ch_verify, CURLOPT_HTTPHEADER, $headers_verify);
    $result_verify = curl_exec($ch_verify);
    curl_close($ch_verify);
    $paypal_order = json_decode($result_verify);

    // Si el pago está completado
    if ($paypal_order->status === 'COMPLETED') {
        // --- Actualizar nuestra base de datos ---
        $id_usuario = $_SESSION['user_id'];
        $monto_pagado = $paypal_order->purchase_units[0]->amount->value;
        $id_transaccion_paypal = $paypal_order->id;

        // Usar una transacción para asegurar la integridad de los datos
        $conexion->begin_transaction();
        try {
            foreach ($_SESSION['carrito'] as $id_cuenta) {
                // Insertar en la tabla de pedidos
                $sql_pedido = "INSERT INTO pedidos (id_usuario, id_cuenta, id_transaccion_paypal, monto_pagado) VALUES (?, ?, ?, ?)";
                $stmt_pedido = $conexion->prepare($sql_pedido);
                $stmt_pedido->bind_param("iisd", $id_usuario, $id_cuenta, $id_transaccion_paypal, $monto_pagado);
                $stmt_pedido->execute();
                
            }
            
            // Si todo fue bien, confirmamos los cambios
            $conexion->commit();
            
            // Vaciamos el carrito
            unset($_SESSION['carrito']);
            
            $response['success'] = true;
            $response['orderID'] = $id_transaccion_paypal;

        } catch (mysqli_sql_exception $exception) {
            // Si algo falla, revertimos todos los cambios
            $conexion->rollback();
            $response['error'] = "Error al guardar el pedido: " . $exception->getMessage();
        }
    }
}

echo json_encode($response);
?>