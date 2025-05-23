<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Destruir todas las variables de sesión
session_unset();
session_destroy();

// Redirigir a la página de inicio
header("Location: index.php");
exit();
?>