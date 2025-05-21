<?php
$host = 'localhost';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = file_get_contents(__DIR__ . '/dental_clinic.sql');

if ($conn->multi_query($sql)) {
    echo "Database created successfully.<br>";
    
    $conn->close();
    
    $conn = new mysqli($host, $user, $password, 'dental_clinic');
    
    // password administrador: admin123
    $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, sexo) 
            VALUES ('Admin', 'Sistema', 'admin@clinicadental.com', '123456789', '1990-01-01', 'M')";
            
    if ($conn->query($sql) === TRUE) {
        $idUser = $conn->insert_id;
        
        $sql = "INSERT INTO users_login (idUser, usuario, password, rol) 
                VALUES ($idUser, 'admin', '$admin_password', 'admin')";
                
        if ($conn->query($sql) === TRUE) {
            echo "Admin user created successfully.<br>";
            echo "Username: admin<br>";
            echo "Password: admin123<br>";
        } else {
            echo "Error creating admin login: " . $conn->error;
        }
    } else {
        echo "Error creating admin data: " . $conn->error;
    }
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?> 