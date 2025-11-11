<?php
require_once 'includes/header.php'; 
require_once '../config/database.php';

// 1. OBTENER EL ID DE LA CUENTA Y LOS DATOS EXISTENTES

// Verificamos que se nos ha pasado un ID por la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['mensaje'] = "ID de cuenta no válido.";
    $_SESSION['mensaje_tipo'] = "danger";
    header('Location: gestionar_cuentas.php');
    exit();
}
$id = $_GET['id'];

// 2. PROCESAR EL FORMULARIO SI SE HA ENVIADO (LÓGICA DE UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $precio = trim($_POST['precio']);
    $usuario_steam = trim($_POST['usuario_steam']);
    $password_steam = $_POST['password_steam'];
    $imagen_url = trim($_POST['imagen_url']);
    $instrucciones = trim($_POST['instrucciones']);
    $estado = $_POST['estado'];

    // Validación
    if (empty($titulo) || empty($precio) || empty($usuario_steam) || empty($password_steam)) {
        $error = "Los campos con * son obligatorios.";
    } else {
        // Consulta SQL de ACTUALIZACIÓN (UPDATE)
        $sql = "UPDATE cuentas SET 
                    titulo = ?, 
                    descripcion = ?, 
                    precio = ?, 
                    usuario_steam = ?, 
                    password_steam = ?, 
                    imagen_url = ?, 
                    instrucciones = ?, 
                    estado = ? 
                WHERE id = ?";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdsssssi", $titulo, $descripcion, $precio, $usuario_steam, $password_steam, $imagen_url, $instrucciones, $estado, $id);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "¡La cuenta ha sido actualizada exitosamente!";
            $_SESSION['mensaje_tipo'] = "success";
            header('Location: gestionar_cuentas.php');
            exit();
        } else {
            $error = "Error al actualizar la cuenta: " . $stmt->error;
        }
        $stmt->close();
    }
}

// 3. OBTENER LOS DATOS PARA RELLENAR EL FORMULARIO (LÓGICA DE SELECT)
$sql_select = "SELECT * FROM cuentas WHERE id = ?";
$stmt_select = $conexion->prepare($sql_select);
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$resultado = $stmt_select->get_result();

if ($resultado->num_rows === 1) {
    $cuenta = $resultado->fetch_assoc();
} else {
    $_SESSION['mensaje'] = "No se encontró la cuenta especificada.";
    $_SESSION['mensaje_tipo'] = "danger";
    header('Location: gestionar_cuentas.php');
    exit();
}
$stmt_select->close();

?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Editar Cuenta: <?php echo htmlspecialchars($cuenta['titulo']); ?></h1>
    <a href="gestionar_cuentas.php" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver a la Lista
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <!-- El formulario apunta a sí mismo, incluyendo el ID en la URL -->
        <form action="editar_cuenta.php?id=<?php echo $cuenta['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título *</label>
                <!-- Usamos el operador '??' para evitar errores si una variable no existe -->
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($cuenta['titulo'] ?? ''); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción Breve</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?php echo htmlspecialchars($cuenta['descripcion'] ?? ''); ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="precio" class="form-label">Precio (USD) *</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo htmlspecialchars($cuenta['precio'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="estado" class="form-label">Estado *</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="disponible" <?php echo ($cuenta['estado'] ?? '') == 'disponible' ? 'selected' : ''; ?>>Disponible</option>
                        <option value="vendida" <?php echo ($cuenta['estado'] ?? '') == 'vendida' ? 'selected' : ''; ?>>Vendida</option>
                    </select>
                </div>
            </div>

            <hr>
            <h5 class="mt-4">Credenciales e Instrucciones</h5>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="usuario_steam" class="form-label">Usuario Steam *</label>
                    <input type="text" class="form-control" id="usuario_steam" name="usuario_steam" value="<?php echo htmlspecialchars($cuenta['usuario_steam'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_steam" class="form-label">Contraseña Steam *</label>
                    <input type="text" class="form-control" id="password_steam" name="password_steam" value="<?php echo htmlspecialchars($cuenta['password_steam'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="imagen_url" class="form-label">URL de la Imagen</label>
                <input type="url" class="form-control" id="imagen_url" name="imagen_url" value="<?php echo htmlspecialchars($cuenta['imagen_url'] ?? ''); ?>" placeholder="https://ejemplo.com/imagen.jpg">
            </div>

            <div class="mb-3">
                <label for="instrucciones" class="form-label">Instrucciones</label>
                <textarea class="form-control" id="instrucciones" name="instrucciones" rows="5"><?php echo htmlspecialchars($cuenta['instrucciones'] ?? ''); ?></textarea>
            </div>

            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save-fill"></i> Guardar Cambios
            </button>
        </form>
    </div>
</div>

<?php
$conexion->close();
require_once 'includes/footer.php'; 
?>