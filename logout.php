<?php
session_start();

// 1. Desvincula todas las variables de sesión.
$_SESSION = array();

// 2. Destruye la sesión.
session_destroy();

// 3. Redirige al usuario a la página de inicio.
header("Location: index.php");
exit;
?>