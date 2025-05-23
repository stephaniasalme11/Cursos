<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';


if (!isAdmin()) {
    redirect('admin_login.php');
}

$titulo_pagina = "Panel de Administración";


include 'includes/header_admin.php';

// Obtener últimos estudiantes registrados
$stmt_ultimos = $conn->query("SELECT id, nombre, email, fecha_registro FROM usuarios 
                             WHERE es_admin = 0 
                             ORDER BY fecha_registro DESC LIMIT 5");
$ultimos_estudiantes = $stmt_ultimos->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-container">
    <section class="admin-section">
        <h2>Bienvenido al Panel de Administración</h2>
        <p>Desde aquí puedes gestionar todos los aspectos de la plataforma educativa.</p>
        
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert success"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>
    </section>

    <section class="admin-section">
        <h3>Últimos Estudiantes Registrados</h3>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ultimos_estudiantes)): ?>
                        <tr>
                            <td colspan="5">No hay estudiantes registrados aún.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ultimos_estudiantes as $estudiante): ?>
                            <tr>
                                <td><?php echo $estudiante['id']; ?></td>
                                <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['email']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($estudiante['fecha_registro'])); ?></td>
                                <td>
                                    <a href="admin_editar_estudiante.php?id=<?php echo $estudiante['id']; ?>" class="btn small">Editar</a>
                                    <a href="admin_ver_estudiante.php?id=<?php echo $estudiante['id']; ?>" class="btn small">Ver Detalles</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="admin-section">
        <h3>Acciones Rápidas</h3>
        <div class="quick-actions">
            <a href="admin_nuevo_curso.php" class="btn">Crear Nuevo Curso</a>
            <a href="admin_nuevo_material.php" class="btn">Subir Material</a>
            <a href="admin_estudiantes.php" class="btn">Gestionar Estudiantes</a>
            <a href="admin_configuracion.php" class="btn">Configuración del Sitio</a>
        </div>
    </section>
</div>

<?php include 'includes/footer_admin.php'; ?>
