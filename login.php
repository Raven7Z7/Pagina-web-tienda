<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
require_once 'config/database.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        $sql = "SELECT id, nombre, password FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_name'] = $usuario['nombre'];
                header('Location: index.php');
                exit();
            }
        }
        $error = "El correo electrónico o la contraseña son incorrectos.";
        $stmt->close();
    }
    $conexion->close();
}

// Aquí incluimos la cabecera. ¡OJO! el session_start() ya no se necesita aquí
// porque lo movimos al header.php y lo llamamos antes de este require.
require_once 'layouts/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <h2>Iniciar Sesión</h2>
            </div>
            <div class="card-body">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger text-center">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </div>
                </form>

            </div>
            <div class="card-footer text-center">
                <a href="registro.php">¿No tienes una cuenta? Regístrate aquí</a>
            </div>
        </div>
    </div>
</div>

<?php
// Incluimos el pie de página
require_once 'layouts/footer.php';
?>