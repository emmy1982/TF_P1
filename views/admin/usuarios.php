<div class="section">
    <div class="container">
        <h1 class="section-title">Administración de Usuarios</h1>
        
        <?php
        $conn = connectDB();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'create':
                        //  formulario para crear usuario
                        $nombre = trim($_POST['nombre']);
                        $apellidos = trim($_POST['apellidos']);
                        $email = trim($_POST['email']);
                        $telefono = trim($_POST['telefono']);
                        $fecha_nacimiento = $_POST['fecha_nacimiento'];
                        $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
                        $sexo = $_POST['sexo'];
                        $usuario = trim($_POST['usuario']);
                        $password = $_POST['password'];
                        $rol = $_POST['rol'];
                        
                        if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) 
                            || empty($fecha_nacimiento) || empty($sexo) || empty($usuario) || empty($password)) {
                            echo '<div class="alert alert-danger">Todos los campos obligatorios deben ser completados.</div>';
                        } else {
                            $stmt = $conn->prepare("SELECT idUser FROM users_data WHERE email = ?");
                            $stmt->bind_param("s", $email);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result->num_rows > 0) {
                                echo '<div class="alert alert-danger">El email ya está registrado.</div>';
                            } else {
                                $stmt = $conn->prepare("SELECT idLogin FROM users_login WHERE usuario = ?");
                                $stmt->bind_param("s", $usuario);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                
                                if ($result->num_rows > 0) {
                                    echo '<div class="alert alert-danger">El nombre de usuario ya está en uso.</div>';
                                } else {
                                    $conn->begin_transaction();
                                    try {
                                        $stmt = $conn->prepare("INSERT INTO users_data (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                        $stmt->bind_param("sssssss", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo);
                                        $stmt->execute();
                                        
                                        $idUser = $conn->insert_id;
                                        
                                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                        
                                        $stmt = $conn->prepare("INSERT INTO users_login (idUser, usuario, password, rol) VALUES (?, ?, ?, ?)");
                                        $stmt->bind_param("isss", $idUser, $usuario, $hashed_password, $rol);
                                        $stmt->execute();
                                        
                                        $conn->commit();
                                        
                                        echo '<div class="alert alert-success">Usuario creado exitosamente.</div>';
                                    } catch (Exception $e) {
                                        $conn->rollback();
                                        echo '<div class="alert alert-danger">Error al crear el usuario: ' . $e->getMessage() . '</div>';
                                    }
                                }
                            }
                        }
                        break;
                        
                    case 'update':
                        // Datos del formulario para actualizar usuario
                        $idUser = $_POST['idUser'];
                        $nombre = trim($_POST['nombre']);
                        $apellidos = trim($_POST['apellidos']);
                        $email = trim($_POST['email']);
                        $telefono = trim($_POST['telefono']);
                        $fecha_nacimiento = $_POST['fecha_nacimiento'];
                        $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
                        $sexo = $_POST['sexo'];
                        $usuario = trim($_POST['usuario']);
                        $rol = $_POST['rol'];
                        $password = isset($_POST['password']) ? $_POST['password'] : '';
                        
                        if (empty($nombre) || empty($apellidos) || empty($email) || empty($telefono) 
                            || empty($fecha_nacimiento) || empty($sexo) || empty($usuario)) {
                            echo '<div class="alert alert-danger">Todos los campos obligatorios deben ser completados.</div>';
                        } else {
                            $conn->begin_transaction();
                            try {
                                // Actualizar datos personales
                                $stmt = $conn->prepare("UPDATE users_data SET nombre = ?, apellidos = ?, email = ?, telefono = ?, fecha_nacimiento = ?, direccion = ?, sexo = ? WHERE idUser = ?");
                                $stmt->bind_param("sssssssi", $nombre, $apellidos, $email, $telefono, $fecha_nacimiento, $direccion, $sexo, $idUser);
                                $stmt->execute();
                                
                                // Actualizar datos de login
                                if (!empty($password)) {
                                    // Si se proporciona nueva contraseña, actualizarla también
                                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                                    $stmt = $conn->prepare("UPDATE users_login SET usuario = ?, password = ?, rol = ? WHERE idUser = ?");
                                    $stmt->bind_param("sssi", $usuario, $hashed_password, $rol, $idUser);
                                } else {
                                    // Si no se proporciona contraseña, mantener la actual
                                    $stmt = $conn->prepare("UPDATE users_login SET usuario = ?, rol = ? WHERE idUser = ?");
                                    $stmt->bind_param("ssi", $usuario, $rol, $idUser);
                                }
                                $stmt->execute();
                                
                                $conn->commit();
                                
                                echo '<div class="alert alert-success">Usuario actualizado exitosamente.</div>';
                            } catch (Exception $e) {
                                // Revertir cambios si hay error
                                $conn->rollback();
                                echo '<div class="alert alert-danger">Error al actualizar el usuario: ' . $e->getMessage() . '</div>';
                            }
                        }
                        break;
                        
                    case 'delete':
                        // Eliminar usuario
                        $idUser = $_POST['idUser'];
                        
                        $conn->begin_transaction();
                        try {
                            
                            $stmt = $conn->prepare("DELETE FROM citas WHERE idUser = ?");
                            $stmt->bind_param("i", $idUser);
                            $stmt->execute();
                            
                            $stmt = $conn->prepare("DELETE FROM noticias WHERE idUser = ?");
                            $stmt->bind_param("i", $idUser);
                            $stmt->execute();
                            
                            $stmt = $conn->prepare("DELETE FROM users_login WHERE idUser = ?");
                            $stmt->bind_param("i", $idUser);
                            $stmt->execute();
                            
                            $stmt = $conn->prepare("DELETE FROM users_data WHERE idUser = ?");
                            $stmt->bind_param("i", $idUser);
                            $stmt->execute();
                            
                            $conn->commit();
                            
                            echo '<div class="alert alert-success">Usuario eliminado exitosamente.</div>';
                        } catch (Exception $e) {
                            $conn->rollback();
                            echo '<div class="alert alert-danger">Error al eliminar el usuario: ' . $e->getMessage() . '</div>';
                        }
                        break;
                }
            }
        }
        
        // Si hay un ID de usuario en la URL para editar
        $editUser = null;
        if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $idUser = $_GET['edit'];
            
            // Obtener datos del usuario para editar
            $stmt = $conn->prepare("
                SELECT d.*, l.usuario, l.rol 
                FROM users_data d 
                INNER JOIN users_login l ON d.idUser = l.idUser 
                WHERE d.idUser = ?
            ");
            $stmt->bind_param("i", $idUser);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $editUser = $result->fetch_assoc();
            }
        }
        ?>
        
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab(event, 'tab-list')">Lista de Usuarios</button>
            <button class="tab-btn" onclick="openTab(event, 'tab-create')">Crear Usuario</button>
        </div>
        
        <div id="tab-create" class="tab-content" style="display: none;">
            <div class="form-container">
                <h2 class="form-title"><?php echo $editUser ? 'Editar Usuario' : 'Crear Nuevo Usuario'; ?></h2>
                
                <form action="" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="<?php echo $editUser ? 'update' : 'create'; ?>">
                    <?php if ($editUser): ?>
                        <input type="hidden" name="idUser" value="<?php echo $editUser['idUser']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-row">
                        <div class="form-group form-group-half">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo $editUser ? $editUser['nombre'] : ''; ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                        <div class="form-group form-group-half">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required value="<?php echo $editUser ? $editUser['apellidos'] : ''; ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group form-group-half">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required value="<?php echo $editUser ? $editUser['email'] : ''; ?>">
                            <div class="invalid-feedback">
                                Ingrese un email válido.
                            </div>
                        </div>
                        <div class="form-group form-group-half">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required value="<?php echo $editUser ? $editUser['telefono'] : ''; ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group form-group-half">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required value="<?php echo $editUser ? $editUser['fecha_nacimiento'] : ''; ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                        <div class="form-group form-group-half">
                            <label for="sexo" class="form-label">Sexo</label>
                            <select class="form-control" id="sexo" name="sexo" required>
                                <option value="" disabled <?php echo !$editUser ? 'selected' : ''; ?>>Seleccionar...</option>
                                <option value="M" <?php echo $editUser && $editUser['sexo'] == 'M' ? 'selected' : ''; ?>>Masculino</option>
                                <option value="F" <?php echo $editUser && $editUser['sexo'] == 'F' ? 'selected' : ''; ?>>Femenino</option>
                                <option value="Otro" <?php echo $editUser && $editUser['sexo'] == 'Otro' ? 'selected' : ''; ?>>Otro</option>
                            </select>
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2"><?php echo $editUser ? $editUser['direccion'] : ''; ?></textarea>
                    </div>
                    
                    <hr class="form-divider">
                    
                    <div class="form-row">
                        <div class="form-group form-group-half">
                            <label for="usuario" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required value="<?php echo $editUser ? $editUser['usuario'] : ''; ?>">
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                        <div class="form-group form-group-half">
                            <label for="password" class="form-label">Contraseña <?php echo $editUser ? '(Dejar en blanco para mantener la actual)' : ''; ?></label>
                            <input type="password" class="form-control" id="password" name="password" <?php echo $editUser ? '' : 'required'; ?>>
                            <div class="invalid-feedback">
                                Este campo es obligatorio.
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-control" id="rol" name="rol" required>
                            <option value="user" <?php echo $editUser && $editUser['rol'] == 'user' ? 'selected' : ''; ?>>Usuario</option>
                            <option value="admin" <?php echo $editUser && $editUser['rol'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn"><?php echo $editUser ? 'Actualizar Usuario' : 'Crear Usuario'; ?></button>
                        <?php if ($editUser): ?>
                            <a href="index.php?page=usuarios-administracion" class="btn btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tabla de Listar Usuarios -->
        <div id="tab-list" class="tab-content">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Email</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener todos los usuarios
                        $sql = "
                            SELECT d.idUser, d.nombre, d.apellidos, d.email, l.usuario, l.rol 
                            FROM users_data d 
                            INNER JOIN users_login l ON d.idUser = l.idUser
                            ORDER BY d.idUser
                        ";
                        $result = $conn->query($sql);
                        
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['idUser']}</td>
                                    <td>{$row['nombre']}</td>
                                    <td>{$row['apellidos']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['usuario']}</td>
                                    <td>{$row['rol']}</td>
                                    <td class='actions'>
                                        <a href='index.php?page=usuarios-administracion&edit={$row['idUser']}' class='btn-action edit' title='Editar'><i class='fas fa-edit'></i></a>
                                        <button class='btn-action delete' onclick='confirmarEliminar({$row['idUser']})' title='Eliminar'><i class='fas fa-trash-alt'></i></button>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>No hay usuarios registrados.</td></tr>";
                        }
                        
                        
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Formulario oculto para eliminar usuario -->
            <form id="deleteForm" method="post" style="display: none;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="idUser" id="deleteIdUser">
            </form>
        </div>
    </div>
</div>

<script src="assets/js/admin.js"></script> 