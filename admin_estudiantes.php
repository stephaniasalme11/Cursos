<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';


if (!isAdmin()) {
    redirect('admin_login.php');
}

// Configuración de paginación
$registros_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Búsqueda
$busqueda = isset($_GET['busqueda']) ? sanitize($_GET['busqueda']) : '';
$where_clause = '';
$params = [];

if (!empty($busqueda)) {
    $where_clause = " WHERE (nombre LIKE ? OR email LIKE ?)";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
} else {
    $where_clause = " WHERE es_admin = 0";
}

// Obtener total de estudiantes para paginación
$stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM usuarios" . $where_clause);
$stmt_total->execute($params);
$total_estudiantes = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
$total_paginas = ceil($total_estudiantes / $registros_por_pagina);

// Obtener estudiantes para la página actual
$query = "SELECT id, nombre, email, fecha_registro FROM usuarios" . $where_clause . " ORDER BY fecha_registro DESC LIMIT $offset, $registros_por_pagina";
$stmt = $conn->prepare($query);
$stmt->execute($params);
$estudiantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Establecer título de página
$titulo_pagina = "Gestión de Estudiantes";

// Incluir header de administrador
include 'includes/header_admin.php';
?>

<div class="admin-container">
    <section class="admin-section">
        <h2>Gestión de Estudiantes</h2>
        
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert success"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_msg'])): ?>
            <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
        <?php endif; ?>
        
        <div class="admin-actions">
            <a href="admin.php" class="btn">← Volver al Dashboard</a>
            <button class="btn" onclick="alert('Esta funcionalidad aún no está disponible')">Agregar Nuevo Estudiante</button>
        </div>
    </section>
    
    <section class="admin-section">
        <div class="search-filter">
            <form method="GET" class="search-form">
                <div class="form-group">
                    <input type="text" name="busqueda" placeholder="Buscar por nombre o email" value="<?php echo htmlspecialchars($busqueda); ?>">
                    <button type="submit" class="btn">Buscar</button>
                    <?php if (!empty($busqueda)): ?>
                        <a href="admin_estudiantes.php" class="btn">Limpiar</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
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
                    <?php if (empty($estudiantes)): ?>
                        <tr>
                            <td colspan="5">No se encontraron estudiantes<?php echo !empty($busqueda) ? ' con esos criterios de búsqueda' : ''; ?>.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($estudiantes as $estudiante): ?>
                            <tr>
                                <td><?php echo $estudiante['id']; ?></td>
                                <td><?php echo htmlspecialchars($estudiante['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($estudiante['email']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($estudiante['fecha_registro'])); ?></td>
                                <td>
                                    <a href="admin_ver_estudiante.php?id=<?php echo $estudiante['id']; ?>" class="btn small">Ver Detalles</a>
                                    <a href="admin_editar_estudiante.php?id=<?php echo $estudiante['id']; ?>" class="btn small">Editar</a>
                                    <!-- Botón deshabilitado para eliminar estudiante -->
                                    <button class="btn small danger" onclick="alert('Esta funcionalidad aún no está disponible')">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($total_paginas > 1): ?>
            <div class="pagination">
                <?php if ($pagina_actual > 1): ?>
                    <a href="?pagina=<?php echo $pagina_actual - 1; ?><?php echo !empty($busqueda) ? '&busqueda=' . urlencode($busqueda) : ''; ?>" class="btn">Anterior</a>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <?php if ($i == $pagina_actual): ?>
                        <span class="current-page"><?php echo $i; ?></span>
                    <?php else: ?>
                        <a href="?pagina=<?php echo $i; ?><?php echo !empty($busqueda) ? '&busqueda=' . urlencode($busqueda) : ''; ?>"><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
                
                <?php if ($pagina_actual < $total_paginas): ?>
                    <a href="?pagina=<?php echo $pagina_actual + 1; ?><?php echo !empty($busqueda) ? '&busqueda=' . urlencode($busqueda) : ''; ?>" class="btn">Siguiente</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>
    
    <section class="admin-section">
        <h3>Estadísticas</h3>
        <div class="stats-container">
            <div class="stat-item">
                <span class="stat-value"><?php echo $total_estudiantes; ?></span>
                <span class="stat-label">Total de Estudiantes</span>
            </div>
            
            <?php
            // Estudiantes nuevos este mes
            $stmt_nuevos = $conn->query("SELECT COUNT(*) as total FROM usuarios WHERE es_admin = 0 AND MONTH(fecha_registro) = MONTH(CURRENT_DATE()) AND YEAR(fecha_registro) = YEAR(CURRENT_DATE())");
            $nuevos_mes = $stmt_nuevos->fetch(PDO::FETCH_ASSOC)['total'];
            ?>
            
            <div class="stat-item">
                <span class="stat-value"><?php echo $nuevos_mes; ?></span>
                <span class="stat-label">Nuevos este mes</span>
            </div>
            
            <?php
            // Promedio de cursos por estudiante
            $stmt_promedio = $conn->query("SELECT AVG(total_cursos) as promedio FROM (SELECT COUNT(*) as total_cursos FROM inscripciones GROUP BY usuario_id) as t");
            $promedio_cursos = $stmt_promedio->fetch(PDO::FETCH_ASSOC)['promedio'];
            ?>
            
            <div class="stat-item">
                <span class="stat-value"><?php echo number_format($promedio_cursos, 1); ?></span>
                <span class="stat-label">Promedio de cursos por estudiante</span>
            </div>
        </div>
    </section>
</div>

<?php include 'includes/footer_admin.php'; ?>
