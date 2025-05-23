<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isAdmin()) {
    redirect('admin_login.php');
}

if (isset($_POST['subir_material'])) {
    $titulo = sanitize($_POST['titulo']);
    $descripcion = sanitize($_POST['descripcion']);
    $curso_id = (int)$_POST['curso_id'];
    $tipo = sanitize($_POST['tipo']);
    
    
    $archivo = '';
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == 0) {
        $allowed = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'zip', 'rar', 'jpg', 'jpeg', 'png', 'gif', 'mp4', 'mp3'];
        $filename = $_FILES['archivo']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $upload_dir = 'assets/uploads/';
            
            // Crear directorio si no existe
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $upload_dir . $new_filename)) {
                $archivo = $new_filename;
            } else {
                $_SESSION['error_msg'] = "Error al subir el archivo";
            }
        } else {
            $_SESSION['error_msg'] = "Formato de archivo no permitido";
        }
    } else {
        $_SESSION['error_msg'] = "Debe seleccionar un archivo";
    }
    
    if (empty($_SESSION['error_msg'])) {
        try {
            // Insertar el nuevo material
            $stmt = $conn->prepare("INSERT INTO materiales (titulo, descripcion, curso_id, tipo, archivo, fecha_publicacion) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$titulo, $descripcion, $curso_id, $tipo, $archivo]);
            
            $_SESSION['success_msg'] = "Material subido correctamente";
            redirect('admin.php'); // Redirigir al dashboard
        } catch (PDOException $e) {
            $_SESSION['error_msg'] = "Error al subir el material: " . $e->getMessage();
        }
    }
}

// Obtener cursos para el formulario
$stmt_cursos = $conn->query("SELECT * FROM cursos ORDER BY titulo");
$cursos = $stmt_cursos->fetchAll(PDO::FETCH_ASSOC);

// Establecer título de página
$titulo_pagina = "Subir Nuevo Material";

// Incluir header de administrador
include 'includes/header_admin.php';
?>

<div class="admin-container">
    <section class="admin-section">
        <h2>Subir Nuevo Material</h2>
        
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
                <label for="titulo">Título del Material</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="curso_id">Curso</label>
                <select id="curso_id" name="curso_id" required>
                    <option value="">Seleccionar curso</option>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?php echo $curso['id']; ?>"><?php echo htmlspecialchars($curso['titulo']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="tipo">Tipo de Material</label>
                <select id="tipo" name="tipo" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="pdf">Documento PDF</option>
                    <option value="doc">Documento Word</option>
                    <option value="ppt">Presentación</option>
                    <option value="video">Video</option>
                    <option value="audio">Audio</option>
                    <option value="imagen">Imagen</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="archivo">Archivo</label>
                <input type="file" id="archivo" name="archivo" required>
                <small>Formatos permitidos: pdf, doc, docx, ppt, pptx, xls, xlsx, zip, rar, jpg, jpeg, png, gif, mp4, mp3</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="subir_material" class="btn">Subir Material</button>
                <a href="admin.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</div>

<?php include 'includes/footer_admin.php'; ?>
