<?php
session_start();
// Destruimos todas las variables de sesión
session_unset();
session_destroy();
// Redirigimos al login del admin
header('Location: login.php');
exit();
?>