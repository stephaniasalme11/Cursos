    </main>
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Sobre el Curso</h3>
                    <p>Curso online de matemática y física</p>
                </div>
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <p>Email: jgsalmeronv@hotmail.com</p>
                    <p>Teléfono: +58 416 905 2216</p>
                </div>
                <div class="footer-section">
                    <h3>Enlaces Rápidos</h3>
                    <ul>
                        <li><a href="<?php echo SITE_URL; ?>">Catálogo</a></li>
                        <?php if (!isLoggedIn()): ?>
                            <li><a href="<?php echo SITE_URL; ?>/login.php">Iniciar Sesión</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/register.php">Registrarse</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo SITE_URL; ?>/estudiantes.php">Mi Área</a></li>
                            <li><a href="<?php echo SITE_URL; ?>/logout.php">Cerrar Sesión</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="<?php echo SITE_URL; ?>/assets/js/script.js"></script>
</body>
</html>