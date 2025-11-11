<?php
session_start();
require_once '../config/database.php'; // Usamos ../ para salir de la carpeta 'admin' y encontrar config

// Si ya hay una sesión de admin activa, lo mandamos al dashboard
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, password FROM admins WHERE username = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $admin = $resultado->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                // Login exitoso, creamos la sesión de admin
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $username;
                header('Location: index.php'); // Redirigimos al dashboard del admin
                exit();
            }
        }
    }
    $error = "Usuario o contraseña incorrectos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Pollo Gaming 593</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 15px;
        }
    </style>
</head>
<body>
    <main class="login-form text-center">
        <form action="login.php" method="POST">
            <img class="mb-4" src="../assets/images/logo.png" alt="Logo" width="100">
            <h1 class="h3 mb-3 fw-normal">Acceso de Administrador</h1>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Usuario" required>
                <label for="username">Usuario</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                <label for="password">Contraseña</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
            <p class="mt-5 mb-3 text-muted">&copy; <?php echo date('Y'); ?> Pollo Gaming 593</p>
        </form>
    </main>
</body>
</html>