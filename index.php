<?php 

include 'includes/config.php';
include 'includes/functions.php';

$title = "Prof(x)"; 

include 'includes/header.php';

?>

<section class="hero">
    <div class="container">
        <h2>Regístrate hoy y transforma tu carrera</h2>
        <p>Descubre nuestros cursos y mejora tus habilidades</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
        <?php else: ?>
            <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ir a Mi Área</a>
        <?php endif; ?>
    </div>
</section>

<!-- Nueva sección del profesor -->
<section class="profesor">
    <div class="container">
        <h2>Conoce al Profesor</h2>
        <div class="profesor-details">
            <img src="<?php echo SITE_URL; ?>/assets/images/profesor.jpg" alt="Profesor del curso">
            <div class="profesor-info">
                <h3>Prof. José Salmerón</h3>
                <p class="titulo">Profesor en Electricidad Industrial</p>
                
                <div class="experiencia">
                    <h4>Experiencia Profesional</h4>
                    <ul>
                        <li>Profesor en el área tecnológica con conocimientos en electricidad, electrónica, cálculo diferencial e integral, y física (mecánica y eléctrica).</li>
                        <li>Más de 25 años de experiencia en educación universitaria a nivel de ingeniería y en educación técnica a nivel medio.</li>
                        <li>Creación del Método Integral Sistematizado para el Aprendizaje de Circuitos Eléctricos (MISPACE), basado en principios científicos y pedagógicos.</li>
                        <li>MISPACE se adapta a las necesidades individuales del estudiante, considerando los niveles de exigencia de su universidad y profesores.</li>
                    </ul>
                </div>
                
                <div class="metodologia">
                    <h4>Metodología de Enseñanza</h4>
                    <p>Mi enfoque se basa en:</p>
                    <ul>
                        <li><strong>Aprendizaje práctico:</strong> Cada concepto se aplica en ejercicios reales</li>
                        <li><strong>Proyectos integradores:</strong> Desarrollarás soluciones completas</li>
                        <li><strong>Soporte personalizado:</strong> Tutorías individuales cuando lo necesites</li>
                        <li><strong>Actualización constante:</strong> Contenido siempre al día</li>
                    </ul>
                </div>
                
                <div class="logros">
                    <h4>Certificaciones y Logros</h4>
                    <div class="badges">
                        <span class="badge">Google Certified Developer</span>
                        <span class="badge">Microsoft MVP</span>
                        <span class="badge">Premio Nacional de Educación 2020</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="hero">
    <div class="container">
        <h2 id="catalogo">Catálogo de Cursos</h2>
        <p>Domina las ciencias exactas con nuestros cursos especializados</p>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
        <?php else: ?>
            <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ir a Mi Área</a>
        <?php endif; ?>
    </div>
</section>

<section class="catalogo">
    <div class="container">
        <h2>Nuestros Programas Académicos</h2>
        
        <!-- Filtros por categoría -->
        <div class="filtros">
            <span class="etiqueta activa" data-categoria="todas">Todos</span>
            <span class="etiqueta" data-categoria="matematica">Matemáticas</span>
            <span class="etiqueta" data-categoria="fisica">Física</span>
            <span class="etiqueta" data-categoria="circuitos">Circuitos Eléctricos</span>
        </div>
        
        <!-- Listado de cursos -->
        <div class="curso-grid">
            <!-- Matemáticas -->
            <div class="curso-card" data-categoria="matematica">
                <img src="<?php echo SITE_URL; ?>/assets/img/algebra.jpg" alt="Álgebra">
                <div class="curso-info">
                    <span class="etiqueta-curso matematica">Matemáticas</span>
                    <span class="etiqueta-curso basico">Básico</span>
                    <h3>Álgebra</h3>
                    <p>Fundamentos algebraicos, ecuaciones polinómicas y sistemas de ecuaciones.</p>
                    <div class="curso-meta">
                        <span>40 horas</span>
                        <span>Nivel Universitario</span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ver Material</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="curso-card" data-categoria="matematica">
                <img src="<?php echo SITE_URL; ?>/assets/img/trigonometria.webp" alt="Trigonometría">
                <div class="curso-info">
                    <span class="etiqueta-curso matematica">Matemáticas</span>
                    <span class="etiqueta-curso basico">Básico</span>
                    <h3>Trigonometría</h3>
                    <p>Funciones trigonométricas, identidades y aplicaciones geométricas.</p>
                    <div class="curso-meta">
                        <span>35 horas</span>
                        <span>Nivel Universitario</span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ver Material</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="curso-card" data-categoria="matematica">
                <img src="<?php echo SITE_URL; ?>/assets/img/derivadas.webp" alt="Derivadas">
                <div class="curso-info">
                    <span class="etiqueta-curso matematica">Matemáticas</span>
                    <span class="etiqueta-curso basico">Intermedio</span>
                    <h3>Derivadas</h3>
                    <p>Cálculo de límites, reglas de derivación, aplicaciones en optimización y razón de cambio.</p>
                    <div class="curso-meta">
                        <span>35 horas</span>
                        <span>Nivel Universitario</span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ver Material</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Continúa con los demás cursos de Matemáticas -->
            <div class="curso-card" data-categoria="matematica">
                <img src="<?php echo SITE_URL; ?>/assets/img/Geometria-analitica.png" alt="Geometría Analítica">
                <div class="curso-info">
                    <span class="etiqueta-curso matematica">Matemáticas</span>
                    <span class="etiqueta-curso intermedio">Intermedio</span>
                    <h3>Geometría Analítica</h3>
                    <p>Estudio de figuras geométricas mediante coordenadas y álgebra.</p>
                    <div class="curso-meta">
                        <span>45 horas</span>
                        <span>Nivel Universitario</span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ver Material</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Física -->
            <div class="curso-card" data-categoria="fisica">
                <img src="<?php echo SITE_URL; ?>/assets/img/cinematica.jpg" alt="Cinemática">
                <div class="curso-info">
                    <span class="etiqueta-curso fisica">Física</span>
                    <span class="etiqueta-curso basico">Básico</span>
                    <h3>Cinemática</h3>
                    <p>Movimiento de los cuerpos sin considerar las causas que lo producen.</p>
                    <div class="curso-meta">
                        <span>30 horas</span>
                        <span>Nivel Universitario</span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ver Material</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="curso-card" data-categoria="fisica">
                <img src="<?php echo SITE_URL; ?>/assets/img/dinamica.jpg" alt="Dinámica">
                <div class="curso-info">
                    <span class="etiqueta-curso fisica">Física</span>
                    <span class="etiqueta-curso intermedio">Intermedio</span>
                    <h3>Dinámica</h3>
                    <p>Estudio de las causas del movimiento y sus efectos en los cuerpos.</p>
                    <div class="curso-meta">
                        <span>40 horas</span>
                        <span>Nivel Universitario</span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ver Material</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Circuitos Eléctricos -->
            <div class="curso-card" data-categoria="circuitos">
                <img src="<?php echo SITE_URL; ?>/assets/img/circuito en serie.jpg" alt="Circuitos DC">
                <div class="curso-info">
                    <span class="etiqueta-curso circuitos">Circuitos Eléctricos</span>
                    <span class="etiqueta-curso basico">Básico</span>
                    <h3>Circuitos resistivos en serie-paralelo en DC</h3>
                    <p>Análisis básico de circuitos con resistencias en configuraciones serie y paralelo.</p>
                    <div class="curso-meta">
                        <span>35 horas</span>
                        <span>Nivel Universitario</span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ver Material</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="curso-card" data-categoria="circuitos">
                <img src="<?php echo SITE_URL; ?>/assets/img/analisis-circuitos.png" alt="Análisis de Circuitos">
                <div class="curso-info">
                    <span class="etiqueta-curso circuitos">Circuitos Eléctricos</span>
                    <span class="etiqueta-curso intermedio">Intermedio</span>
                    <h3>Métodos de análisis de Circuitos en DC</h3>
                    <p>Técnicas avanzadas para el análisis de circuitos eléctricos.</p>
                    <div class="curso-meta">
                        <span>45 horas</span>
                        <span>Nivel Universitario</span>
                    </div>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="<?php echo SITE_URL; ?>/register.php" class="btn">Regístrate para Acceder</a>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/estudiantes.php" class="btn">Ver Material</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>