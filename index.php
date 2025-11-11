<?php
$page_title = 'Inicio';
require_once 'config/database.php';
require_once 'layouts/header.php';

// --- NUEVA LÓGICA ---
// 1. Buscamos el juego destacado que esté disponible
$featured_game = null;
$sql_featured = "SELECT id, titulo, descripcion, precio, imagen_url FROM cuentas WHERE is_featured = 1 AND estado = 'disponible' LIMIT 1";
$resultado_featured = $conexion->query($sql_featured);
if ($resultado_featured->num_rows > 0) {
    $featured_game = $resultado_featured->fetch_assoc();
}

// 2. Obtenemos el resto del catálogo, EXCLUYENDO el juego destacado para no repetirlo
$sql_catalogo = "SELECT id, titulo, descripcion, precio, imagen_url FROM cuentas WHERE (is_featured = 0 OR is_featured IS NULL) AND estado = 'disponible' ORDER BY id DESC";
$resultado_catalogo = $conexion->query($sql_catalogo);
?>

<!-- ======================= -->
<!-- ===== HERO PARALLAX ===== -->
<!-- ======================= -->
<div class="hero-parallax">
    <div class="hero-content px-3">
        <h1 class="display-3 fw-bold hero-title">Pollo Gaming 593</h1>
        <p class="lead my-4" data-aos="fade-up" data-aos-delay="500">
            Tu aventura comienza aquí. Las mejores cuentas, al instante.
        </p>
        <div data-aos="fade-up" data-aos-delay="1000">
            <a href="#catalogo" class="btn btn-primary btn-lg px-4 gap-3">Explorar Catálogo</a>
        </div>
    </div>
</div>

<!-- ======================================= -->
<!-- ===== SECCIÓN DE OFERTA DESTACADA ===== -->
<!-- ======================================= -->
<?php if ($featured_game): // Esta sección solo se muestra si encontramos un juego destacado ?>
<div class="container my-5">
    <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg" data-aos="fade-up">
        <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
            <h6 class="text-warning">¡RECLÁMALO GRATIS!</h6>
            <h1 class="display-4 fw-bold lh-1"><?php echo htmlspecialchars($featured_game['titulo']); ?></h1>
            <p class="lead">¡Totalmente gratis por tiempo limitado! Reclama tu copia ahora y únete a la comunidad de Pollo Gaming 593. La oferta termina en:</p>
            
            <!-- El contador regresivo -->
            <div id="countdown" class="d-flex my-4">
                <div class="text-center me-4">
                    <h2 id="days" class="fw-bold">00</h2>
                    <span class="text-muted">Días</span>
                </div>
                <div class="text-center me-4">
                    <h2 id="hours" class="fw-bold">00</h2>
                    <span class="text-muted">Horas</span>
                </div>
                <div class="text-center me-4">
                    <h2 id="minutes" class="fw-bold">00</h2>
                    <span class="text-muted">Minutos</span>
                </div>
                <div class="text-center">
                    <h2 id="seconds" class="fw-bold">00</h2>
                    <span class="text-muted">Segundos</span>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                <form class="add-to-cart-form" action="acciones_carrito.php" method="POST">
                    <input type="hidden" name="id_cuenta" value="<?php echo $featured_game['id']; ?>">
                    <button type="submit" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">
                        <i class="bi bi-gift-fill"></i> Reclamar Gratis
                    </button>
                </form>
            </div>
        </div>
        <div class="col-lg-4 offset-lg-1 p-0 overflow-hidden shadow-lg">
            <img class="img-fluid rounded-3 featured-image" src="<?php echo htmlspecialchars($featured_game['imagen_url']); ?>" alt="Featured Game">
        </div>
    </div>
</div>
<?php endif; ?>

<!-- =============================== -->
<!-- ===== CATÁLOGO DE PRODUCTOS ===== -->
<!-- =============================== -->
<div class="container px-4 py-5" id="catalogo">
    <h2 class="pb-2 border-bottom text-center">Nuestro Catálogo</h2>
    <!-- ===== INICIO DE LA BARRA DE BÚSQUEDA ===== -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar un juego por nombre...">
            </div>
        </div>
    </div>
    <!-- ===== FIN DE LA BARRA DE BÚSQUEDA ===== -->
    <!-- Usamos 'row-cols-md-4' para que haya 4 tarjetas por fila en pantallas medianas y grandes -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-5">
        <?php if ($resultado_catalogo->num_rows > 0): ?>
            <?php while ($cuenta = $resultado_catalogo->fetch_assoc()): ?>
                <!-- El atributo 'data-aos="fade-up"' activa la animación -->
                <div class="col product-col" data-aos="fade-up">
                    <!-- El nuevo contenedor principal de la tarjeta -->
                    <a href="#" class="product-card d-block text-decoration-none">
                        
                        <!-- La imagen de fondo -->
                        <img src="<?php echo !empty($cuenta['imagen_url']) ? htmlspecialchars($cuenta['imagen_url']) : 'https://via.placeholder.com/600x800.png?text=Sin+Imagen'; ?>" class="product-card-img" alt="<?php echo htmlspecialchars($cuenta['titulo']); ?>">
                        
                        <!-- El degradado para la legibilidad -->
                        <div class="product-card-overlay"></div>
                        
                        <!-- El contenido (título y precio) -->
                        <div class="product-card-content">
                            <div>
                                <h5 class="product-card-title"><?php echo htmlspecialchars($cuenta['titulo']); ?></h5>
                            </div>
                            <div class="product-card-price">
                                <?php if ($cuenta['precio'] > 0): ?>
                                    $<?php echo htmlspecialchars($cuenta['precio']); ?>
                                <?php else: ?>
                                    <span class="text-success">GRATIS</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- La capa de acción que aparece al pasar el cursor -->
                        <div class="product-card-actions">
                            <form class="add-to-cart-form m-0" action="acciones_carrito.php" method="POST">
                                <input type="hidden" name="id_cuenta" value="<?php echo $cuenta['id']; ?>">
                                <button type="submit" class="btn btn-lg btn-primary rounded-pill">
                                    <i class="bi bi-cart-plus-fill me-2"></i>Añadir al Carrito
                                </button>
                            </form>
                        </div>
                        
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Lo sentimos, no hay cuentas disponibles en este momento.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$conexion->close();
require_once 'layouts/footer.php'; // Incluimos el pie de página
?>