<?php
// La lógica de PHP para procesar el formulario no cambia, así que la dejamos como está.
require_once 'config/database.php';

$errores = [];
$mensaje_exito = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if (empty($nombre)) $errores[] = "El campo Nombre es obligatorio.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El formato del email no es válido.";
    if (empty($password)) $errores[] = "El campo Contraseña es obligatorio.";
    if ($password !== $password_confirm) $errores[] = "Las contraseñas no coinciden.";

    if (empty($errores)) {
        $sql_check = "SELECT id FROM usuarios WHERE email = ?";
        $stmt_check = $conexion->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();
        if ($stmt_check->num_rows > 0) $errores[] = "El correo electrónico ya está registrado.";
        $stmt_check->close();
    }

    if (empty($errores)) {
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql_insert = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $stmt_insert = $conexion->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $nombre, $email, $password_hashed);

        if ($stmt_insert->execute()) {
            $mensaje_exito = "¡Registro exitoso! Ya puedes <a href='login.php'>iniciar sesión</a>.";
        } else {
            $errores[] = "Error al registrar el usuario.";
        }
        $stmt_insert->close();
    }
    $conexion->close();
}

// Incluimos la cabecera estándar de nuestra web
require_once 'layouts/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h2>Crear una Cuenta</h2>
            </div>
            <div class="card-body">

                <?php
                // Mostramos errores con el formato de alerta de Bootstrap
                if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php
                // Mostramos el mensaje de éxito con el formato de alerta de Bootstrap
                if (!empty($mensaje_exito)): ?>
                    <div class="alert alert-success text-center">
                        <?php echo $mensaje_exito; // Permitimos el HTML del enlace ?>
                    </div>
                <?php else: ?>
                    <!-- El formulario solo se muestra si no hay un mensaje de éxito -->
                    <form action="registro.php" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar Contraseña:</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Registrarse</button>
                        </div>
                    </form>
                <?php endif; ?>

            </div>
            <div class="card-footer text-center">
                <a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
</div>

<?php
// Incluimos el pie de página estándar
require_once 'layouts/footer.php';
?>