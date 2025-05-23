<?php
include 'includes/config.php';
include 'includes/functions.php';


if (isLoggedIn() && isAdmin()) {
    redirect('admin.php');
}
$title = "Acceso Administrador";
include 'includes/header.php';
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-panel admin-auth">
            <div class="auth-tabs">
                <button class="tab-btn active">Acceso Administrador</button>
            </div>

            <?php if (isset($_SESSION['error_msg'])): ?>
                <div class="alert error"><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
            <?php endif; ?>

            <form action="includes/auth.php" method="POST">
                <div class="form-group">
                    <label for="email">Correo Electrónico Administrador</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="admin_login" class="btn btn-warning">Acceder como Administrador</button>
            </form>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>