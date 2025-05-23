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

// Obtener información del estudiante
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ? AND es_admin = 0");
$stmt->execute([$estudiante_id]);

if ($stmt->rowCount() == 0) {
    $_SESSION['error_msg'] = "Estudiante no encontrado";
    redirect('admin.php');
}

$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener cursos inscritos
$stmt_cursos = $conn->prepare("SELECT c.* FROM cursos c 
                              JOIN inscripciones i ON c.id = i.curso_id 
                              WHERE i.usuario_id = ?");
$stmt_cursos->execute([$estudiante_id]);
$cursos_inscritos = $stmt_cursos->fetchAll(PDO::FETCH_ASSOC);

// Establecer título de página
$titulo_pagina = "Detalles del Estudiante: " . htmlspecialchars($estudiante['nombre']);

// Incluir header de administrador
include 'includes/header_admin.php';
?>

<div class="admin-container">
    <section class="admin-section">
        <h2>Detalles del Estudiante</h2>
        
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert success"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>
        
        <div class="admin-actions">
            <a href="admin.php" class="btn">← Volver al Dashboard</a>
            <a href="admin_editar_estudiante.php?id=<?php echo $estudiante_id; ?>" class="btn">Editar Estudiante</a>
        </div>
    </section>
    
    <section class="admin-section">
        <h3>Información Personal</h3>
        <div class="student-profile">
            <div class="profile-info">
                <table class="info-table">
                    <tr>
                        <th>ID:</th>
                        <td><?php echo $estudiante['id']; ?></td>
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo htmlspecialchars($estudiante['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Registro:</th>
                        <td><?php echo date('d/m/Y H:i', strtotime($estudiante['fecha_registro'])); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
    
    <section class="admin-section">
        <h3>Cursos Inscritos</h3>
        <?php if (empty($cursos_inscritos)): ?>
            <p>Este estudiante no está inscrito en ningún curso.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Fecha de Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos_inscritos as $curso): ?>
                            <tr>
                                <td><?php echo $curso['id']; ?></td>
                                <td><?php echo htmlspecialchars($curso['titulo']); ?></td>
                                <td>
                                    <?php 
                                    // Obtener nombre de categoría
                                    $stmt_cat = $conn->prepare("SELECT nombre FROM categorias WHERE id = ?");
                                    $stmt_cat->execute([$curso['categoria_id']]);
                                    $categoria = $stmt_cat->fetch(PDO::FETCH_ASSOC);
                                    echo htmlspecialchars($categoria['nombre'] ?? 'Sin categoría');
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    // Obtener fecha de inscripción
                                    $stmt_fecha = $conn->prepare("SELECT fecha_inscripcion FROM inscripciones WHERE usuario_id = ? AND curso_id = ?");
                                    $stmt_fecha->execute([$estudiante_id, $curso['id']]);
                                    $inscripcion = $stmt_fecha->fetch(PDO::FETCH_ASSOC);
                                    echo date('d/m/Y', strtotime($inscripcion['fecha_inscripcion'] ?? 'now'));
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php include 'includes/footer_admin.php'; ?>
