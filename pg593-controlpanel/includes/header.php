<?php require_once 'auth.php'; // ¡Nuestro guardia de seguridad! ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        .main-container {
            display: flex;
            flex: 1;
        }
        .sidebar {
            width: 280px;
            background-color: #343a40;
            color: white;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Barra Lateral de Navegación -->
        <div class="sidebar p-3 d-flex flex-column">
            <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="assets/images/logo.png" alt="Logo" width="150">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-white">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="gestionar_cuentas.php" class="nav-link text-white">
                        <i class="bi bi-joystick"></i> Gestionar Cuentas
                    </a>
                </li>
                <li>
                    <a href="ver_usuarios.php" class="nav-link text-white">
                        <i class="bi bi-people-fill"></i> Ver Usuarios
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>

        <!-- Contenido Principal de la Página -->
        <main class="content">