<?php
// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo '<div class="alert alert-danger">Debes iniciar sesión para acceder a esta página.</div>';
    echo '<script>setTimeout(function() { window.location.href = "index.php?page=login"; }, 3000);</script>';
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = connectDB();

$personal_info_msg = '';
$password_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_info':
                $nombre = trim($_POST['nombre']);
                $apellidos = trim($_POST['apellidos']);
                $email = trim($_POST['email']);
                $telefono = trim($_POST['telefono']);
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
                $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
                $sexo = $_POST['sexo'];
                
                if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) || empty($fecha_nacimiento) || empty($sexo)) {
                    $personal_info_msg = '<div class="alert alert-danger">Todos los campos obligatorios deben ser completados.</div>';
                } else {
                    try {
                        // Verificar si el email ya está en uso por otro usuario
                        $stmt = $conn->prepare("SELECT idUser FROM users_data WHERE email = ? AND idUser != ?");
                        $stmt->bind_param("si", $email, $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows > 0) {
                            $personal_info_msg = '<div class="alert alert-danger">El email ya está en uso por otro usuario.</div>';
                        } else {
                            // Actualizar información personal
                            $stmt = $conn->prepare("UPDATE users_data SET nombre = ?, apellidos = ?, email = ?, telefono = ?, fecha_nacimiento = ?, direccion = ?, sexo = ? WHERE idUser = ?");
                            $stmt->bind_param("sssssssi", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $user_id);
                            $stmt->execute();
                            
                            $personal_info_msg = '<div class="alert alert-success">Información personal actualizada exitosamente.</div>';
                        }
                    } catch (Exception $e) {
                        $personal_info_msg = '<div class="alert alert-danger">Error al actualizar la información: ' . $e->getMessage() . '</div>';
                    }
                }
                break;
                
            case 'update_password':
                // Datos del formulario para cambiar contraseña
                $current_password = $_POST['current_password'];
                $new_password = $_POST['new_password'];
                $confirm_password = $_POST['confirm_password'];
                
                if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                    $password_msg = '<div class="alert alert-danger">Todos los campos son obligatorios.</div>';
                } elseif ($new_password !== $confirm_password) {
                    $password_msg = '<div class="alert alert-danger">Las nuevas contraseñas no coinciden.</div>';
                } elseif (strlen($new_password) < 6) {
                    $password_msg = '<div class="alert alert-danger">La nueva contraseña debe tener al menos 6 caracteres.</div>';
                } else {
                    try {
                        // Verificar la contraseña actual
                        $stmt = $conn->prepare("SELECT password FROM users_login WHERE idUser = ?");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows === 1) {
                            $user = $result->fetch_assoc();
                            
                            if (password_verify($current_password, $user['password'])) {
                                // Encriptar nueva contraseña
                                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                                
                                // Actualizar contraseña
                                $stmt = $conn->prepare("UPDATE users_login SET password = ? WHERE idUser = ?");
                                $stmt->bind_param("si", $hashed_password, $user_id);
                                $stmt->execute();
                                
                                $password_msg = '<div class="alert alert-success">Contraseña actualizada exitosamente.</div>';
                            } else {
                                $password_msg = '<div class="alert alert-danger">La contraseña actual es incorrecta.</div>';
                            }
                        }
                    } catch (Exception $e) {
                        $password_msg = '<div class="alert alert-danger">Error al actualizar la contraseña: ' . $e->getMessage() . '</div>';
                    }
                }
                break;
        }
    }
}

// Obtener información actual del usuario
$stmt = $conn->prepare("
    SELECT d.*, l.usuario 
    FROM users_data d 
    INNER JOIN users_login l ON d.idUser = l.idUser 
    WHERE d.idUser = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo '<div class="alert alert-danger">No se pudo encontrar la información del usuario.</div>';
    $conn->close();
    exit;
}

$user_data = $result->fetch_assoc();
$conn->close();
?>

<div class="section">
    <div class="container">
        <h1 class="section-title news-h1">Mi <strong>Perfil</strong></h1>
        
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab(event, 'tab-info')">Información Personal</button>
            <button class="tab-btn" onclick="openTab(event, 'tab-password')">Cambiar Contraseña</button>
        </div>
        
        <div id="tab-info" class="tab-content">
            <?php echo $personal_info_msg; ?>
            
            <div class="form-container">
                <h2 class="form-title">Mis Datos</h2>
                
                <form action="" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="update_info">
                    
                    <div class="form-row">
                        <div class="form-group form-group-half">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($user_data['nombre']); ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                        <div class="form-group form-group-half">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required value="<?php echo htmlspecialchars($user_data['apellidos']); ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group form-group-half">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo htmlspecialchars($user_data['email']); ?>">
                            <div class="invalid-feedback">
                                Ingrese un email válido.
                            </div>
                        </div>
                        <div class="form-group form-group-half">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required value="<?php echo htmlspecialchars($user_data['telefono']); ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group form-group-half">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required value="<?php echo $user_data['fecha_nacimiento']; ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                        <div class="form-group form-group-half">
                            <label for="sexo" class="form-label">Sexo</label>
                            <select class="form-control" id="sexo" name="sexo" required>
                                <option value="M" <?php echo $user_data['sexo'] == 'M' ? 'selected' : ''; ?>>Masculino</option>
                                <option value="F" <?php echo $user_data['sexo'] == 'F' ? 'selected' : ''; ?>>Femenino</option>
                                <option value="Otro" <?php echo $user_data['sexo'] == 'Otro' ? 'selected' : ''; ?>>Otro</option>
                            </select>
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2"><?php echo htmlspecialchars($user_data['direccion']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="usuario" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="usuario" disabled value="<?php echo htmlspecialchars($user_data['usuario']); ?>">
                        <small class="form-text">El nombre de usuario no se puede cambiar.</small>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn">Actualizar Información</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div id="tab-password" class="tab-content" style="display: none;">
            <?php echo $password_msg; ?>
            
            <div class="form-container">
                <h2 class="form-title">Cambiar Contraseña</h2>
                
                <form action="" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="update_password">
                    
                    <div class="form-group">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                        <small class="form-text">La contraseña debe tener al menos 6 caracteres.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn">Cambiar Contraseña</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/tabs.js"></script> 