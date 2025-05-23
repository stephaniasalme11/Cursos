<?php 

require_once 'config.php';
require_once 'functions.php';

// Inicio de sesión de administrador 
if (isset($_POST['admin_login'])) {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    try {
        // Primero verificamos si el usuario existe
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar si la contraseña parece estar hasheada
            $esHasheada = (strlen($admin['password']) > 20 && 
                          (strpos($admin['password'], '$2y$') === 0 || 
                           strpos($admin['password'], '$2a$') === 0));
            
            // Verificar la contraseña según su formato
            $passwordCorrecta = false;
            
            if ($esHasheada) {
                // Si está hasheada, usar password_verify
                $passwordCorrecta = password_verify($password, $admin['password']);
            } else {
                // Si está en texto plano, comparar directamente
                $passwordCorrecta = ($password === $admin['password']);
            }
            
            if ($passwordCorrecta) {
                // Verificar si es administrador
                if ($admin['es_admin'] == 1) {
                    $_SESSION['user_id'] = $admin['id'];
                    $_SESSION['user_nombre'] = $admin['nombre'];
                    $_SESSION['user_email'] = $admin['email'];
                    $_SESSION['is_admin'] = 1;
                    
                    redirect('admin.php');
                    exit();
                } else {
                    $_SESSION['error_msg'] = "No tienes permisos de administrador";
                    redirect('admin_login.php');
                    exit();
                }
            } else {
                $_SESSION['error_msg'] = "Contraseña incorrecta";
                redirect('admin_login.php');
                exit();
            }
        } else {
            $_SESSION['error_msg'] = "El correo electrónico no está registrado";
            redirect('admin_login.php');
            exit();
        }
    } catch(PDOException $e) {
        $_SESSION['error_msg'] = "Error al iniciar sesión: " . $e->getMessage();
        redirect('admin_login.php');
        exit();
    }
}

// Inicio de sesión normal 
if (isset($_POST['login'])) {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar si la contraseña parece estar hasheada
            $esHasheada = (strlen($user['password']) > 20 && 
                          (strpos($user['password'], '$2y$') === 0 || 
                           strpos($user['password'], '$2a$') === 0));
            
            // Verificar la contraseña según su formato
            $passwordCorrecta = false;
            
            if ($esHasheada) {
                // Si está hasheada, usar password_verify
                $passwordCorrecta = password_verify($password, $user['password']);
            } else {
                // Si está en texto plano, comparar directamente
                $passwordCorrecta = ($password === $user['password']);
            }
            
            if ($passwordCorrecta) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nombre'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['is_admin'] = $user['es_admin'];
                
                if ($user['es_admin'] == 1) {
                    redirect('admin.php');
                } else {
                    redirect('estudiantes.php');
                }
                exit();
            } else {
                $_SESSION['error_msg'] = "Contraseña incorrecta";
                redirect('login.php');
            }
        } else {
            $_SESSION['error_msg'] = "El correo electrónico no está registrado";
            redirect('login.php');
        }
    } catch(PDOException $e) {
        $_SESSION['error_msg'] = "Error al iniciar sesión: " . $e->getMessage();
        redirect('login.php');
    }
}

// Registro de usuario 
if (isset($_POST['register'])) {
    $nombre = sanitize($_POST['nombre']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        
        $_SESSION['success_msg'] = "Registro exitoso. Por favor inicia sesión.";
        redirect('login.php');
    } catch(PDOException $e) {
        $_SESSION['error_msg'] = "Error al registrar: " . (strpos($e->getMessage(), 'Duplicate entry') ? "El email ya está registrado" : $e->getMessage());
    }
}
?>

