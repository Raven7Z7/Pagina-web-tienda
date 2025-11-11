</main> <!-- Cierre del container principal que abrimos en el header -->

<!-- ===== INICIO DEL FOOTER ===== -->
<footer class="text-white pt-5 pb-4 mt-auto">
    <div class="container text-center text-md-start">
        <div class="row">
            <!-- Columna 1: Sobre la Tienda -->
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                <div class="mb-4">
                    <img src="assets/images/logo.png" alt="Pollo Gaming 593 Logo" width="180">
                </div>
                <p>
                    Tu tienda de confianza para adquirir cuentas de Steam de forma segura y al mejor precio. Llevamos la diversión a jugadores de todo el mundo.
                </p>
            </div>
            <!-- Columna 2: Enlaces Útiles -->
            <div class="col-md-4 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="text-uppercase fw-bold mb-4">Enlaces útiles</h6>
                <p><a href="index.php" class="text-white">Inicio</a></p>
                <p><a href="carrito.php" class="text-white">Ver Carrito</a></p>
                <p><a href="terminos.php" class="text-white">Términos y Condiciones</a></p>
                <p><a href="faq.php" class="text-white">Preguntas Frecuentes</a></p>
            </div>
            <!-- Columna 3: Redes Sociales -->
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h6 class="text-uppercase fw-bold mb-4">Síguenos</h6>
                <div class="social-icons">
                    <a href="https://www.youtube.com/@pollogaming593" class="text-white me-4"><i class="bi bi-youtube"></i></a>
                    <a href="https://www.instagram.com/pollogaming593/" class="text-white me-4"><i class="bi bi-instagram"></i></a>
                    <a href="https://discord.gg/ykPyUZ8K5R" class="text-white me-4"><i class="bi bi-discord"></i></a>
                    <a href="https://wa.link/kvzhpj" class="text-white me-4"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Barra de Copyright -->
<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    &copy; <?php echo date('Y'); ?> Pollo Gaming 593. Todos los derechos reservados.
</div>
<!-- ===== FIN DEL FOOTER ===== -->


<!-- ===== CONTENEDOR DE NOTIFICACIONES "TOAST" ===== -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11" id="toastContainer">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto"><i class="bi bi-bell-fill"></i> Notificación</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="toastBody">
            <!-- El mensaje se insertará aquí con JavaScript -->
        </div>
    </div>
</div>

<!-- ============================================= -->
<!-- =====          SECCIÓN DE SCRIPTS         ===== -->
<!-- ============================================= -->
<!-- 1. SCRIPT ESENCIAL DE BOOTSTRAP (SOLO UNA VEZ) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- 2. LIBRERÍA DE ANIMACIONES AOS -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init({
      duration: 800,
      once: true
  });
</script>

<!-- 3. NUESTRO SCRIPT PERSONALIZADO -->
<script src="assets/js/main.js"></script>

</body>
</html>