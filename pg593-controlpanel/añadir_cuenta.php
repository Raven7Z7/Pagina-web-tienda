<?php
require_once 'includes/header.php'; 
require_once '../config/database.php';

// Verificamos si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recoger y sanear los datos del formulario
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $precio = trim($_POST['precio']);
    $usuario_steam = trim($_POST['usuario_steam']);
    $password_steam = trim($_POST['password_steam']); // No trimeamos la contraseña por si tiene espacios intencionados
    $imagen_url = trim($_POST['imagen_url']);
    $instrucciones = trim($_POST['instrucciones']);
    $estado = $_POST['estado'];

    // 2. Validación simple (puedes añadir más validaciones si quieres)
    if (empty($titulo) || empty($precio) || empty($usuario_steam) || empty($password_steam)) {
        $error = "Los campos Título, Precio, Usuario Steam y Contraseña Steam son obligatorios.";
    } else {
        // 3. Preparar la consulta SQL para evitar inyección SQL
        $sql = "INSERT INTO cuentas (titulo, descripcion, precio, usuario_steam, password_steam, imagen_url, instrucciones, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conexion->prepare($sql);
        
        // 4. Vincular los parámetros
        // 's' para string, 'd' para double (decimal)
        $stmt->bind_param("ssdsssss", $titulo, $descripcion, $precio, $usuario_steam, $password_steam, $imagen_url, $instrucciones, $estado);

        // 5. Ejecutar la consulta y manejar el resultado
        if ($stmt->execute()) {
            // Si todo fue bien, creamos un mensaje de éxito en la sesión
            $_SESSION['mensaje'] = "¡La cuenta ha sido añadida exitosamente!";
            $_SESSION['mensaje_tipo'] = "success";
            // Y redirigimos al usuario de vuelta a la lista de cuentas
            header('Location: gestionar_cuentas.php');
            exit();
        } else {
            // Si algo falló, mostramos un error
            $error = "Error al añadir la cuenta: " . $stmt->error;
        }
        $stmt->close();
    }
    $conexion->close();
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Añadir Nueva Cuenta</h1>
    <a href="gestionar_cuentas.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver a la Lista
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="añadir_cuenta.php" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título *</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción Breve</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="precio" class="form-label">Precio (USD) *</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado *</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="disponible" selected>Disponible</option>
                        <option value="vendida">Vendida</option>
                    </select>
                </div>
            </div>

            <hr>
            <h5 class="mt-4">Credenciales e Instrucciones</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="usuario_steam" class="form-label">Usuario Steam *</label>
                    <input type="text" class="form-control" id="usuario_steam" name="usuario_steam" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_steam" class="form-label">Contraseña Steam *</label>
                    <input type="text" class="form-control" id="password_steam" name="password_steam" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="imagen_url" class="form-label">URL de la Imagen</label>
                <input type="url" class="form-control" id="imagen_url" name="imagen_url" placeholder="https://ejemplo.com/imagen.jpg">
            </div>

            <div class="mb-3">
                <label for="instrucciones" class="form-label">Instrucciones (dejar en blanco para las estándar)</label>
                <textarea class="form-control" id="instrucciones" name="instrucciones" rows="5" placeholder="1. Inicia sesión...&#10;2. Pon en modo desconectado..."></textarea>
                <div class="form-text">Usa saltos de línea para separar los pasos. Estos se mostrarán tal cual al cliente.</div>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle-fill"></i> Guardar Nueva Cuenta
            </button>
        </form>
    </div>
</div>


<?php
require_once 'includes/footer.php'; 
?>