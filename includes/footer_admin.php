</main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Panel de Administración</h3>
                    <p>Gestión de cursos y estudiantes</p>
                </div>
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p>Email: jgsalmeronv@hotmail.com</p>
                    <p>Teléfono: +58 416 905 2216</p>
                </div>
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul>
                        <li><a href="<?php echo SITE_URL; ?>/admin.php">Dashboard</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/admin_estudiantes.php">Estudiantes</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/admin_nuevo_curso.php">Crear Curso</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/admin_nuevo_material.php">Subir Material</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/admin_configuracion.php">Configuración</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/admin_logout.php">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?> - Panel de Administración. Todos los derechos reservados.</p>
                <p>Usuario: <?php echo htmlspecialchars($_SESSION['user_nombre'] ?? 'Administrador'); ?></p>
            </div>
        </div>
    </footer>

    <script src="<?php echo SITE_URL; ?>/assets/js/script.js"></script>
    
    <!-- Script para confirmar eliminaciones -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Buscar todos los botones o enlaces con la clase 'confirm-delete'
        const deleteButtons = document.querySelectorAll('.confirm-delete');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('¿Estás seguro de que deseas eliminar este elemento? Esta acción no se puede deshacer.')) {
                    e.preventDefault();
                }
            });
        });
    });
    </script>
</body>
</html>
