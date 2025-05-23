<?php
if (!isset($title)) {
    $title = 'Prof(x)';
}

$userLoggedIn = isset($_SESSION['user_id']);
$isAdmin = ($userLoggedIn && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title . ' | '; ?>  Inicio</title>
    <link rel="icon" href="<?php echo SITE_URL ?? ''; ?>/assets/img/icon.jpg.png">
    <link rel="stylesheet" href="<?php echo SITE_URL ?? ''; ?>/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <img src="<?php echo SITE_URL ?? ''; ?>/assets/img/logo.jpg.png" alt="Logo <?php echo SITE_NAME ?? 'Prof(x)'; ?>">
                <h1 style="font-style: oblique;">Prof(x)</h1>
            </div>
            <nav>
                <ul>
                    <?php if (!$userLoggedIn): ?>
                        <li><a href="<?php echo SITE_URL ?? ''; ?>" <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>Inicio</a></li>
                        <li><a href="<?php echo SITE_URL ?? ''; ?>/login.php" <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'class="active"' : ''; ?>>Iniciar Sesión</a></li>
                        <li><a href="<?php echo SITE_URL ?? ''; ?>/register.php" <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'class="active"' : ''; ?>>Registrarse</a></li>
                        <li><a href="<?php echo SITE_URL ?? ''; ?>/admin_login.php" class="admin-link">Administrador</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo SITE_URL ?? ''; ?>">Catálogo</a></li>
                        <?php if ($isAdmin): ?>
                            <li><a href="<?php echo SITE_URL ?? ''; ?>/admin.php" <?php echo basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'class="active admin-link"' : 'class="admin-link"'; ?>>Administración</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo SITE_URL ?? ''; ?>/estudiantes.php" <?php echo basename($_SERVER['PHP_SELF']) == 'estudiantes.php' ? 'class="active"' : ''; ?>>Mi Área</a></li>
                        <?php endif; ?>
                        <li><a href="<?php echo SITE_URL ?? ''; ?>/logout.php">Cerrar Sesión</a></li>
                        <li><span class="user-welcome">Bienvenido, <?php echo htmlspecialchars($_SESSION['user_nombre'] ?? 'Usuario'); ?></span></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">