<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'Madrid2025.');
define('DB_NAME', 'curso_online');

// Conexión a la base de datos
try {
    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES 'utf8'");
    
    $pdo = $conn;
} catch(PDOException $e) {
    die("ERROR: No se pudo conectar. " . $e->getMessage());
}

// Configuración del sitio
define('SITE_NAME', 'Curso Online');
define('SITE_URL', 'http://localhost/Proyecto');

?>
