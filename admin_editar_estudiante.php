<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isAdmin()) {
    redirect('admin_login.php');
}


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_msg'] = "ID de estudiante no válido";
    redirect('admin.php');
}

$estudiante_id = $_GET['id'];


if (isset($_POST['actualizar_estudiante'])) {
    $nombre = sanitize($_POST['nombre']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password']; // Solo si se va a cambiar
    
    try {
        
        $conn->beginTransaction();
        
        // Si se proporcionó una nueva contraseña, actualizarla
        if (!empty($password)) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$nombre, $email, $password_hash, $estudiante_id]);
        } else {
            // Si no se proporcionó contraseña, actualizar solo nombre y email
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?");
            $stmt->execute([$nombre, $email, $estudiante_id]);
        }
        
       
        $conn->commit();
        
        $_SESSION['success_msg'] = "Información del estudiante actualizada correctamente";
        redirect('admin_ver_estudiante.php?id=' . $estudiante_id);
    } catch (PDOException $e) {
        // Revertir transacción en caso de error
        $conn->rollBack();
        $_SESSION['error_msg'] = "Error al actualizar: " . $e->getMessage();
    }
}

// Obtener información actual del estudiante
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ? AND es_admin = 0");
$stmt->execute([$estudiante_id]);

if ($stmt->rowCount() == 0) {
    $_SESSION['error_msg'] = "Estudiante no encontrado";
    redirect('admin.php');
}

$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

// Establecer título de página
$titulo_pagina = "Editar Estudiante: " . htmlspecialchars($estudiante['nombre']);

include 'includes/header_admin.php';
?>

<div class="admin-container">
    <section class="admin-section">
        <h2>Editar Estudiante</h2>
        
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>
        
        <div class="admin-actions">
            <a href="admin_ver_estudiante.php?id=<?php echo $estudiante_id; ?>" class="btn">← Volver a Detalles</a>
        </div>
    </section>
    
    <section class="admin-section">
        <form method="POST" class="admin-form">
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($estudiante['nombre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($estudiante['email']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                <input type="password" id="password" name="password">
                <small>Mínimo 6 caracteres. Solo complete este campo si desea cambiar la contraseña.</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="actualizar_estudiante" class="btn">Guardar Cambios</button>
                <a href="admin_ver_estudiante.php?id=<?php echo $estudiante_id; ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </section>
    
    <section class="admin-section">
        <h3>Zona de Peligro</h3>
        <div class="danger-zone">
            <p>Las siguientes acciones son irreversibles. Tenga precaución.</p>
            
            <div class="danger-actions">
                <!-- Botón deshabilitado para eliminar estudiante -->
                <button class="btn danger" onclick="alert('Esta funcionalidad aún no está disponible')">Eliminar Estudiante</button>
            </div>
        </div>
    </section>
</div>

<?php include 'includes/footer_admin.php'; ?>
