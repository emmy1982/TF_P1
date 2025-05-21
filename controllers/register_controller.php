<?php
session_start();

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = trim($_POST['direccion']);
    $sexo = $_POST['sexo'];
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) 
        || empty($fecha_nacimiento) || empty($sexo) || empty($usuario) || empty($password)) {
        $_SESSION['register_error'] = 'Por favor, completa todos los campos requeridos.';
        header('Location: ../index.php?page=registro');
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['register_error'] = 'Por favor, introduce un email válido.';
        header('Location: ../index.php?page=registro');
        exit;
    }
    
    if ($password !== $password_confirm) {
        $_SESSION['register_error'] = 'Las contraseñas no coinciden.';
        header('Location: ../index.php?page=registro');
        exit;
    }
    
    if (strlen($password) < 6) {
        $_SESSION['register_error'] = 'La contraseña debe tener al menos 6 caracteres.';
        header('Location: ../index.php?page=registro');
        exit;
    }
    
    $conn = connectDB();
    
    $sql = "SELECT idUser FROM users_data WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = 'Este email ya está registrado.';
        header('Location: ../index.php?page=registro');
        exit;
    }
    
    $sql = "SELECT idLogin FROM users_login WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['register_error'] = 'Este nombre de usuario ya está en uso.';
        header('Location: ../index.php?page=registro');
        exit;
    }
    
    $conn->begin_transaction();
    
    try {
        $sql = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);
        $stmt->execute();
        
        $idUser = $conn->insert_id;
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $rol = "user";
        $sql = "INSERT INTO users_login (idUser, usuario, password, rol) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $idUser, $usuario, $hashed_password, $rol);
        $stmt->execute();
        
        $conn->commit();
        
        $_SESSION['register_success'] = '¡Registro completado con éxito! Ahora puedes iniciar sesión.';
        
        header('Location: ../index.php?page=login');
        exit;
        
    } catch (Exception $e) {
        $conn->rollback();
        
        $_SESSION['register_error'] = 'Error al registrar usuario. Por favor, inténtalo de nuevo.';
        header('Location: ../index.php?page=registro');
        exit;
    }
    
    
    $stmt->close();
    $conn->close();
    
} else {
    header('Location: ../index.php?page=registro');
    exit;
} 