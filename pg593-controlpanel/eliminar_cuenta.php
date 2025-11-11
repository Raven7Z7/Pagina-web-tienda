<?php
// Incluimos nuestro guardia de seguridad y la conexión a la BD
require_once 'auth.php'; // Es crucial que solo un admin pueda ejecutar esto
require_once '../config/database.php';

// 1. Verificar que el ID sea válido
// Comprobamos que nos han pasado un ID y que es un número.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Si no es válido, creamos un mensaje de error y redirigimos
    $_SESSION['mensaje'] = "ID de cuenta no válido.";
    $_SESSION['mensaje_tipo'] = "danger";
    header('Location: gestionar_cuentas.php');
    exit();
}

$id = $_GET['id'];

// 2. Preparar y ejecutar la consulta DELETE
// Preparamos la consulta para eliminar la cuenta con el ID especificado.
$sql = "DELETE FROM cuentas WHERE id = ?";

$stmt = $conexion->prepare($sql);

if ($stmt) {
    // Vinculamos el ID a la consulta
    $stmt->bind_param("i", $id);

    // Ejecutamos la consulta
    if ($stmt->execute()) {
        // Verificamos si realmente se eliminó una fila.
        // affected_rows nos dice cuántas filas fueron cambiadas por la última consulta.
        if ($stmt->affected_rows > 0) {
            // Si se eliminó al menos una fila, todo fue bien.
            $_SESSION['mensaje'] = "La cuenta ha sido eliminada exitosamente.";
            $_SESSION['mensaje_tipo'] = "success";
        } else {
            // Si no se eliminó ninguna fila, significa que la cuenta con ese ID no existía.
            $_SESSION['mensaje'] = "No se encontró ninguna cuenta con ese ID para eliminar.";
            $_SESSION['mensaje_tipo'] = "warning";
        }
    } else {
        // Si la ejecución de la consulta falla por un error de SQL.
        $_SESSION['mensaje'] = "Error al intentar eliminar la cuenta.";
        $_SESSION['mensaje_tipo'] = "danger";
    }

    $stmt->close();
} else {
    // Si la preparación de la consulta falla.
    $_SESSION['mensaje'] = "Error al preparar la consulta de eliminación.";
    $_SESSION['mensaje_tipo'] = "danger";
}

$conexion->close();

// 3. Redirigir de vuelta a la lista de cuentas
header('Location: gestionar_cuentas.php');
exit();
?>