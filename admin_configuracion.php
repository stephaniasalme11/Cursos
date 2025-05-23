<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Verificar si el usuario es administrador
if (!isAdmin()) {
    redirect('admin_login.php');
}

// Procesar el formulario si se envió
if (isset($_POST['guardar_configuracion'])) {
    $site_name = sanitize($_POST['site_name']);
    $site_url = sanitize($_POST['site_url']);
    $admin_email = sanitize($_POST['admin_email']);
        
    $_SESSION['success_msg'] = "Configuración guardada correctamente";
}

$titulo_pagina = "Configuración del Sitio";


include 'includes/header_admin.php';
?>

<div class="admin-container">
    <section class="admin-section">
        <h2>Configuración del Sitio</h2>
        
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert success"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>
        
        <div class="admin-actions">
            <a href="admin.php" class="btn">← Volver al Dashboard</a>
        </div>
    </section>
    
    <section class="admin-section">
        <h3>Configuración General</h3>
        <form method="POST" class="admin-form">
            <div class="form-group">
                <label for="site_name">Nombre del Sitio</label>
                <input type="text" id="site_name" name="site_name" value="<?php echo SITE_NAME; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="site_url">URL del Sitio</label>
                <input type="text" id="site_url" name="site_url" value="<?php echo SITE_URL; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="admin_email">Email de Administración</label>
                <input type="email" id="admin_email" name="admin_email" value="jgsalmeronv@hotmail.com" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="guardar_configuracion" class="btn">Guardar Configuración</button>
            </div>
        </form>
    </section>
    
    <section class="admin-section">
        <h3>Gestión de Categorías</h3>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt_categorias = $conn->query("SELECT * FROM categorias ORDER BY nombre");
                    $categorias = $stmt_categorias->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (empty($categorias)):
                    ?>
                        <tr>
                            <td colspan="4">No hay categorías definidas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($categorias as $categoria): ?>
                            <tr>
                                <td><?php echo $categoria['id']; ?></td>
                                <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($categoria['clase']); ?></td>
                                <td>
                                    <a href="admin_editar_categoria.php?id=<?php echo $categoria['id']; ?>" class="btn small">Editar</a>
                                    <a href="admin_eliminar_categoria.php?id=<?php echo $categoria['id']; ?>" class="btn small danger confirm-delete">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    
</div>

<?php include 'includes/footer_admin.php'; ?>
