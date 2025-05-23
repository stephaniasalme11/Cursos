<?php
include 'includes/config.php';
include 'includes/functions.php';

include 'includes/auth.php'; 
$title = "Registrarse";

include 'includes/header.php';

if (isLoggedIn()) {
    redirect('estudiantes.php');
}

$title = "Registro";

?>

<section class="auth-section">
    <div class="container">
        <div class="auth-panel">
            <div class="auth-tabs">
                <button class="tab-btn" onclick="window.location.href='<?php echo SITE_URL; ?>/login.php'">Iniciar Sesión</button>
                <button class="tab-btn active">Registrarse</button>
            </div>

            <?php if (isset($_SESSION['error_msg'])): ?>
                <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
            <?php endif; ?>

            <form action="<?php echo SITE_URL; ?>/register.php" method="POST" class="auth-form active">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>
                <button type="submit" name="register" class="btn">Registrarse</button>
                <p class="auth-link">¿Ya tienes una cuenta? <a href="<?php echo SITE_URL; ?>/login.php">Inicia sesión</a></p>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>