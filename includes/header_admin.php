<?php
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo_pagina) ? $titulo_pagina . ' | ' : ''; ?>Admin - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="icon" href="<?php echo SITE_URL ?? ''; ?>/assets/img/icon.jpg.png">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <div class="logo">
                <img src="<?php echo SITE_URL ?? ''; ?>/assets/img/icon.jpg.png" alt="Logo <?php echo SITE_NAME ?? 'Prof(x)'; ?>">
                <h1 style="font-style: oblique; color: white;">Prof(x)</h1>
            </div>
            <nav class="admin-nav">
                <a href="admin.php">Inicio</a>
                <a href="estudiantes.php">Estudiantes</a>
                <a href="logout.php">Cerrar sesión</a>
            </nav>
        </div>
    </header>