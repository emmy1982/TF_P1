<?php
$host = 'localhost';
$user = 'root';
$password = '';

$conn = new mysqli($host, $user, $password, 'dental_clinic');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = file_get_contents(__DIR__ . '/update_admin.sql');

if ($conn->query($sql) === TRUE) {
    echo "Rol de administrador actualizado exitosamente.<br>";
} else {
    echo "Error al actualizar el rol: " . $conn->error;
}

$conn->close();
?> 