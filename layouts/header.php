<?php
// Usamos nuestro método seguro para iniciar la sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - Pollo Gaming 593' : 'Pollo Gaming 593 - Tu Tienda de Cuentas'; ?></title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    
    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- AOS - Animate on Scroll -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    
    <!-- Estilos Personalizados -->
    <style>
        /* ============================================== */
        /* ===   ESQUEMA DE COLORES ACERO Y NARANJA   === */
        /* ============================================== */
        :root {
            --color-naranja: #FF8C00;
            --color-acero-oscuro: #1c1e21;
            --color-fondo: #f8f9fa;
        }

        body { 
            background-color: var(--color-fondo);
        }

        .navbar {
            background-color: var(--color-acero-oscuro);
            border-bottom: 3px solid var(--color-naranja);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        footer {
            background-color: var(--color-acero-oscuro);
            border-top: 3px solid var(--color-naranja);
        }

        .btn-primary {
            background-color: var(--color-naranja);
            border-color: var(--color-naranja);
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #e67e00;
            border-color: #e67e00;
            box-shadow: 0 0 0 0.25rem rgba(255, 140, 0, 0.5);
        }

        .text-success {
            color: var(--color-naranja) !important;
        }
        
        .social-icons i:hover, footer a:hover {
            color: var(--color-naranja) !important;
        }

        .logo-glow {
            filter: drop-shadow(0 0 3px var(--color-naranja));
            transition: filter 0.3s ease-in-out;
        }
        .logo-glow:hover {
            filter: drop-shadow(0 0 8px var(--color-naranja));
        }

        /* (El resto de tus estilos para Hero, Flip Cards, etc. que ya funcionan) */
        .hero-parallax { background-image: url('https://getwallpapers.com/wallpaper/full/f/1/d/506680.jpg'); height: 75vh; background-attachment: fixed; background-position: center; background-repeat: no-repeat; background-size: cover; position: relative; display: flex; align-items: center; justify-content: center; color: white; text-align: center; }
        .hero-parallax::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); }
        .hero-content { position: relative; z-index: 1; }
        .hero-title { overflow: hidden; border-right: .15em solid var(--color-naranja); white-space: nowrap; margin: 0 auto; letter-spacing: .10em; animation: typing 3.5s steps(30, end), blink-caret .75s step-end infinite; }
        @keyframes typing { from { width: 0 } to { width: 100% } }
        @keyframes blink-caret { from, to { border-color: transparent } 50% { border-color: var(--color-naranja); } }
        /* ================================================= */
        /* ===   REDISEÑO DE TARJETAS ESTILO "STEAM"     === */
        /* ================================================= */

        .product-card {
            position: relative; /* Contenedor principal para posicionar elementos dentro */
            height: 380px;
            border-radius: 12px; /* Bordes más redondeados y modernos */
            overflow: hidden; /* Esconde todo lo que se salga de los bordes redondeados */
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .product-card:hover {
            transform: scale(1.03); /* Un ligero zoom al pasar el cursor */
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .product-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* La imagen siempre cubrirá la tarjeta sin deformarse */
            transition: transform 0.3s ease;
        }
        .product-card:hover .product-card-img {
            transform: scale(1.1); /* Efecto de zoom en la imagen al pasar el cursor */
        }

        .product-card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60%;
            /* Un degradado que asegura que el texto de abajo siempre sea legible */
            background: linear-gradient(to top, rgba(0,0,0,0.95), transparent);
        }

        .product-card-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.25rem;
            color: white;
            display: flex; /* Usamos flexbox para alinear el título y el precio */
            justify-content: space-between;
            align-items: flex-end;
        }

        .product-card-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-right: 1rem; /* Espacio entre el título y el precio */
            text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
        }

        .product-card-price {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--color-naranja); /* Tu color de marca para el precio */
            text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
            flex-shrink: 0; /* Evita que el precio se encoja si el título es largo */
        }
        
        /* La capa de acción que aparece al pasar el cursor */
        .product-card-actions {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0; /* Oculta por defecto */
            transition: opacity 0.3s ease;
        }
        .product-card:hover .product-card-actions {
            opacity: 1; /* Se muestra al pasar el cursor */
        }
        /* === ESTILOS PARA LA IMAGEN DESTACADA === */
        .featured-image {
            width: 100%;
            height: 100%; /* Ocupará toda la altura del contenedor padre */
            max-height: 500px; /* Una altura máxima para que no sea demasiado grande en pantallas altas */
            object-fit: cover; /* La propiedad estrella: la imagen cubre el espacio sin deformarse, recortando el exceso */
            object-position: top; /* Se enfoca en la parte superior de la imagen, bueno para pósters */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="assets/images/logo.png" class="logo-glow" alt="Pollo Gaming 593 Logo" width="100">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <?php $num_items = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0; ?>
                    <a class="nav-link" href="carrito.php">
                        <i class="bi bi-cart-fill"></i> Carrito (<span id="cart-counter"><?php echo $num_items; ?></span>)
                    </a>
                </li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- SI LA SESIÓN ESTÁ INICIADA -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarUserDropdown">
                            <li><a class="dropdown-item" href="mis_pedidos.php"><i class="bi bi-box-seam-fill me-2"></i>Mis Pedidos</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- SI LA SESIÓN NO ESTÁ INICIADA -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-warning ms-2" href="registro.php">Registrarse</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<!-- El 'main' se abre aquí y se cierra en el footer -->
<main class="container pt-5">