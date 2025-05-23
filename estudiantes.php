<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';


if (!isLoggedIn()) {
    redirect('login.php');
}

$title = "Área de Estudiantes";

// Obtener cursos inscritos del estudiante
$stmt = $conn->prepare("SELECT c.id, c.titulo, c.descripcion, c.imagen 
                       FROM cursos c
                       JOIN inscripciones i ON c.id = i.curso_id
                       WHERE i.usuario_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$cursos_inscritos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para obtener materiales de un curso (podría ir en functions.php)
function getMaterialesCurso($conn, $curso_id) {
    $stmt = $conn->prepare("SELECT * FROM materiales 
                          WHERE curso_id = ? 
                          ORDER BY fecha_publicacion DESC");
    $stmt->execute([$curso_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include 'includes/header.php';
?>

<section class="hero">
    <div class="container">
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre']); ?></h2>
        <p>Accede a tus cursos y material de estudio</p>
    </div>
</section>

<section class="mis-cursos">
    <div class="container">
        <h2>Mis Cursos</h2>
        <?php if (empty($cursos_inscritos)): ?>
            <div class="alert info">
                <p>No estás inscrito en ningún curso aún.</p>
                <a href="<?php echo SITE_URL; ?>/#catalogo" class="btn">Explorar cursos disponibles</a>
            </div>
        <?php else: ?>
            <div class="curso-grid">
                <?php foreach ($cursos_inscritos as $curso): ?>
                    <div class="curso-card">
                        <?php if (!empty($curso['imagen'])): ?>
                            <img src="<?php echo SITE_URL; ?>/assets/images/cursos/<?php echo htmlspecialchars($curso['imagen']); ?>" 
                                 alt="<?php echo htmlspecialchars($curso['titulo']); ?>">
                        <?php else: ?>
                            <div class="curso-img-placeholder"></div>
                        <?php endif; ?>
                        <div class="curso-info">
                            <h3><?php echo htmlspecialchars($curso['titulo']); ?></h3>
                            <p><?php echo htmlspecialchars($curso['descripcion']); ?></p>
                            <a href="#curso-<?php echo $curso['id']; ?>" class="btn">Ver Material</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($cursos_inscritos)): ?>
<section class="materiales">
    <div class="container">
        <h2>Material de Estudio</h2>
        
        <?php foreach ($cursos_inscritos as $curso): ?>
            <?php $materiales = getMaterialesCurso($conn, $curso['id']); ?>
            <div class="curso-material" id="curso-<?php echo $curso['id']; ?>">
                <h3><?php echo htmlspecialchars($curso['titulo']); ?></h3>
                
                <?php if (empty($materiales)): ?>
                    <p class="no-material">No hay material disponible para este curso aún.</p>
                <?php else: ?>
                    <div class="material-list">
                        <?php foreach ($materiales as $material): ?>
                            <div class="material-card">
                                <div class="material-info">
                                    <h4><?php echo htmlspecialchars($material['titulo']); ?></h4>
                                    <p><?php echo htmlspecialchars($material['descripcion']); ?></p>
                                    <div class="material-meta">
                                        <span>Publicado: <?php echo date('d/m/Y', strtotime($material['fecha_publicacion'])); ?></span>
                                        <span>Tipo: <?php echo strtoupper($material['tipo']); ?></span>
                                        <?php if (file_exists('assets/uploads/'.$material['archivo'])): ?>
                                            <span>Tamaño: <?php echo formatFileSize('assets/uploads/'.$material['archivo']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="material-actions">
                                    <?php if (file_exists('assets/uploads/'.$material['archivo'])): ?>
                                        <a href="<?php echo SITE_URL; ?>/assets/uploads/<?php echo $material['archivo']; ?>" 
                                           class="btn" 
                                           download="<?php echo htmlspecialchars($material['titulo']).'.'.pathinfo($material['archivo'], PATHINFO_EXTENSION); ?>">
                                            Descargar
                                        </a>
                                        <?php if (in_array(strtolower(pathinfo($material['archivo'], PATHINFO_EXTENSION)), ['pdf', 'jpg', 'jpeg', 'png', 'gif'])): ?>
                                            <a href="<?php echo SITE_URL; ?>/assets/uploads/<?php echo $material['archivo']; ?>" 
                                               class="btn" 
                                               target="_blank">
                                                Ver Online
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="btn disabled">Archivo no disponible</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>