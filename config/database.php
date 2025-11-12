<?php
ini_set('display_errors', 0);
error_reporting(0);

// ========= CONFIGURACIÓN DE LA BASE DE DATOS =========
// Este archivo contiene las credenciales para conectar con la base de datos.

// 1. Definimos las credenciales
$db_host = 'localhost';     // El servidor. En XAMPP siempre es 'localhost'.
$db_user = 'root';          // El usuario de la base de datos. Por defecto en XAMPP es 'root'.
$db_pass = '';              // La contraseña. Por defecto en XAMPP está vacía.
$db_name = 'tienda_steam';  // El nombre de la base de datos que creamos en el paso anterior.


// 2. Creamos la conexión usando la librería MySQLi
$conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);


// 3. Verificamos si la conexión fue exitosa
if ($conexion->connect_error) {
    // Si hay un error, el script se detiene y muestra el mensaje.
    // Es una medida de seguridad para que el sitio no siga funcionando si no puede acceder a los datos.
    die("Error de conexión con la base de datos: " . $conexion->connect_error);
}

// 4. Opcional pero muy recomendado: Establecemos el juego de caracteres a UTF-8
// Esto asegura que los acentos y caracteres especiales (como la 'ñ') se muestren correctamente.
$conexion->set_charset("utf8mb4");

?>



