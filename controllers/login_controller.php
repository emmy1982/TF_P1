<?php
session_start();

require_once 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    
    if (empty($usuario) || empty($password)) {
        $_SESSION['login_error'] = 'Por favor, completa todos los campos.';
        header('Location: ../index.php?page=login');
        exit;
    }
    
    $conn = connectDB();
    
    $sql = "SELECT l.idLogin, l.idUser, l.usuario, l.password, l.rol, d.nombre, d.apellidos 
            FROM users_login l
            INNER JOIN users_data d ON l.idUser = d.idUser
            WHERE l.usuario = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['idUser'];
            $_SESSION['username'] = $user['usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['apellidos'] = $user['apellidos'];
            $_SESSION['rol'] = $user['rol'];
            
            header('Location: ../index.php');
            exit;
        } else {
            $_SESSION['login_error'] = 'Usuario o contraseña incorrectos.';
            header('Location: ../index.php?page=login');
            exit;
        }
    } else {
        $_SESSION['login_error'] = 'Usuario o contraseña incorrectos.';
        header('Location: ../index.php?page=login');
        exit;
    }
    
    $stmt->close();
    $conn->close();
} else {
    header('Location: ../index.php?page=login');
    exit;
} 