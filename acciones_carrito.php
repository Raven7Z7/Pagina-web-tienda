<?php
session_start();

// Preparamos la respuesta que enviaremos de vuelta al frontend
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'Error desconocido.',
    'cartCount' => 0
];

// --- LÓGICA PARA AÑADIR UN ITEM ---
if (isset($_POST['id_cuenta'])) {
    
    // Inicializamos el carrito en la sesión si aún no existe.
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $id_cuenta = $_POST['id_cuenta'];

    if (!in_array($id_cuenta, $_SESSION['carrito'])) {
        array_push($_SESSION['carrito'], $id_cuenta);
        $response['success'] = true;
        $response['message'] = '¡Cuenta añadida al carrito!';
    } else {
        // La operación no es un "error", pero no fue exitosa.
        // Lo manejamos como un éxito falso para mostrar un mensaje diferente.
        $response['success'] = false;
        $response['message'] = 'Esa cuenta ya está en tu carrito.';
    }

// --- LÓGICA PARA QUITAR UN ITEM (No la usaremos con AJAX por ahora, pero la dejamos) ---
} elseif (isset($_GET['accion']) && $_GET['accion'] == 'remover') {
    if (isset($_GET['id'])) {
        $id_remover = $_GET['id'];
        $key = array_search($id_remover, $_SESSION['carrito']);
        if ($key !== false) {
            unset($_SESSION['carrito'][$key]);
        }
    }
    header('Location: carrito.php'); // La acción de remover seguirá recargando por ahora
    exit();

} else {
    $response['message'] = 'Acción no válida.';
}

// Calculamos el número final de items en el carrito y lo añadimos a la respuesta
$response['cartCount'] = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;

// Imprimimos la respuesta en formato JSON
echo json_encode($response);
?>