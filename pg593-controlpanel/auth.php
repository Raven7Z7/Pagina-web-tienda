<?php
// Iniciamos la sesión para poder comprobarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si la sesión 'admin_id' NO existe, significa que no ha iniciado sesión.
if (!isset($_SESSION['admin_id'])) {
    // Lo redirigimos a la página de login.
    header('Location: login.php');
    // Detenemos la ejecución del script para que no se muestre nada más.
    exit();
}

// Si la sesión SÍ existe, el script simplemente termina y permite que
// el resto de la página que lo incluyó se ejecute con normalidad.
?>