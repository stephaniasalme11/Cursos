<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isAdmin()) {
    redirect('admin_login.php');
}

// Procesar el formulario si se envió
if (isset($_POST['crear_curso'])) {
    $titulo = sanitize($_POST['titulo']);
    $descripcion = sanitize($_POST['descripcion']);
    $categoria_id = (int)$_POST['categoria_id'];
    
    
    $imagen = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $filename = $_FILES['imagen']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $upload_dir = 'assets/images/cursos/';
            
            // Crear directorio si no existe
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $upload_dir . $new_filename)) {
                $imagen = $new_filename;
            } else {
                $_SESSION['error_msg'] = "Error al subir la imagen";
            }
        } else {
            $_SESSION['error_msg'] = "Formato de imagen no permitido. Use: jpg, jpeg, png, gif, webp";
        }
    }
    
    try {
        // Insertar el nuevo curso
        $stmt = $conn->prepare("INSERT INTO cursos (titulo, descripcion, categoria_id, imagen) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $descripcion, $categoria_id, $imagen]);
        
        $curso_id = $conn->lastInsertId();
        
        $_SESSION['success_msg'] = "Curso creado correctamente";
        redirect('admin.php'); // Redirigir al dashboard en lugar de a una página de curso
    } catch (PDOException $e) {
        $_SESSION['error_msg'] = "Error al crear el curso: " . $e->getMessage();
    }
}

// Obtener categorías para el formulario
$stmt_categorias = $conn->query("SELECT * FROM categorias ORDER BY nombre");
$categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);

$titulo_pagina = "Crear Nuevo Curso";

// Incluir header de administrador
include 'includes/header_admin.php';
?>

<div class="admin-container">
    <section class="admin-section">
        <h2>Crear Nuevo Curso</h2>
        
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>
        
        <div class="admin-actions">
            <a href="admin.php" class="btn">← Volver al Dashboard</a>
        </div>
    </section>
    
    <section class="admin-section">
        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <div class="form-group">
                <label for="titulo">Título del Curso</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="5" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id" required>
                    <option value="">Seleccionar categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="imagen">Imagen del Curso</label>
                <input type="file" id="imagen" name="imagen">
                <small>Formatos permitidos: jpg, jpeg, png, gif, webp. Tamaño recomendado: 800x450px.</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="crear_curso" class="btn">Crear Curso</button>
                <a href="admin.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</div>

<?php include 'includes/footer_admin.php'; ?>
