<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: " . SITE_URL . "/" . $url);
    exit();
}
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function getCategorias($conn) {
    $stmt = $conn->query("SELECT * FROM categorias");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Función para verificar si el usuario es administrador
function isAdmin() {
    return (isLoggedIn() && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1);
}

function getCursos($conn, $categoria_id = null) {
    $sql = "SELECT c.*, cat.nombre as categoria_nombre, cat.clase as categoria_clase 
            FROM cursos c 
            JOIN categorias cat ON c.categoria_id = cat.id";
    
    if ($categoria_id) {
        $sql .= " WHERE c.categoria_id = :categoria_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
    } else {
        $stmt = $conn->prepare($sql);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCursosInscritos($conn, $usuario_id) {
    $stmt = $conn->prepare("SELECT c.* FROM cursos c
                          JOIN inscripciones i ON c.id = i.curso_id
                          WHERE i.usuario_id = :usuario_id");
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>