<?php

include 'includes/config.php';
include 'includes/functions.php';

include 'includes/auth.php'; 

$title = "Iniciar sesión";

include 'includes/header.php';

if (isLoggedIn()) {
    redirect('estudiantes.php');
}

?>

<section class="auth-section">
    <div class="container">
        <div class="auth-panel">
            <div class="auth-tabs">
                <button class="tab-btn active">Iniciar Sesión</button>
                <button class="tab-btn" onclick="window.location.href='<?php echo SITE_URL; ?>/register.php'">Registrarse</button>
            </div>

            <?php if (isset($_SESSION['error_msg'])): ?>
                <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success_msg'])): ?>
                <div class="alert success"><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
            <?php endif; ?>

            <form action="<?php echo SITE_URL; ?>/login.php" method="POST" class="auth-form active">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                <button type="submit" name="login" class="btn">Iniciar Sesión</button>
                <p class="auth-link">¿No tienes una cuenta? <a href="<?php echo SITE_URL; ?>/register.php">Regístrate</a></p>
            </form>
        </div>
    </div>
</section>


<?php include 'includes/footer.php'; ?>