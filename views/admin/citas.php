<div class="section">
    <div class="container">
        <h1 class="section-title">Administración de Citas</h1>
        
        <?php
        $conn = connectDB();
        
        $selectedUser = null;
        $userId = isset($_GET['user']) ? intval($_GET['user']) : (isset($_POST['user_id']) ? intval($_POST['user_id']) : 0);
        
        if ($userId > 0) {
            $stmt = $conn->prepare("SELECT idUser, nombre, apellidos FROM users_data WHERE idUser = ?");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $selectedUser = $result->fetch_assoc();
            }
        }
        // Crear cita
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $selectedUser) {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'create':
                        $fecha_cita = $_POST['fecha_cita'];
                        $motivo_cita = trim($_POST['motivo_cita']);
                        
                        if (empty($fecha_cita)) {
                            echo '<div class="alert alert-danger">La fecha de la cita es obligatoria.</div>';
                        } else {
                            try {
                                $stmt = $conn->prepare("INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES (?, ?, ?)");
                                $stmt->bind_param("iss", $userId, $fecha_cita, $motivo_cita);
                                $stmt->execute();
                                
                                echo '<div class="alert alert-success">Cita creada exitosamente.</div>';
                            } catch (Exception $e) {
                                echo '<div class="alert alert-danger">Error al crear la cita: ' . $e->getMessage() . '</div>';
                            }
                        }
                        break;
                        
                    case 'update':
                        $idCita = $_POST['id_cita'];
                        $fecha_cita = $_POST['fecha_cita'];
                        $motivo_cita = trim($_POST['motivo_cita']);
                        
                        if (empty($fecha_cita)) {
                            echo '<div class="alert alert-danger">La fecha de la cita es obligatoria.</div>';
                        } else {
                            try {
                                $stmt = $conn->prepare("UPDATE citas SET fecha_cita = ?, motivo_cita = ? WHERE idCita = ? AND idUser = ?");
                                $stmt->bind_param("ssii", $fecha_cita, $motivo_cita, $idCita, $userId);
                                $stmt->execute();
                                
                                echo '<div class="alert alert-success">Cita actualizada exitosamente.</div>';
                            } catch (Exception $e) {
                                echo '<div class="alert alert-danger">Error al actualizar la cita: ' . $e->getMessage() . '</div>';
                            }
                        }
                        break;
                        
                    case 'delete':
                        // Eliminar cita
                        $idCita = $_POST['id_cita'];
                        
                        try {
                            // Eliminar cita
                            $stmt = $conn->prepare("DELETE FROM citas WHERE idCita = ? AND idUser = ?");
                            $stmt->bind_param("ii", $idCita, $userId);
                            $stmt->execute();
                            
                            echo '<div class="alert alert-success">Cita eliminada exitosamente.</div>';
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">Error al eliminar la cita: ' . $e->getMessage() . '</div>';
                        }
                        break;
                }
            }
        }
        
        // Si hay un ID de cita en la URL para editar
        $editCita = null;
        if ($selectedUser && isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $idCita = $_GET['edit'];
            
            $stmt = $conn->prepare("SELECT * FROM citas WHERE idCita = ? AND idUser = ?");
            $stmt->bind_param("ii", $idCita, $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $editCita = $result->fetch_assoc();
            }
        }
        ?>
        
        <div class="form-container" style="margin-bottom: 30px;">
            <h3 class="form-title">Seleccionar Usuario</h3>
            
            <form action="" method="get" id="userSelectForm">
                <input type="hidden" name="page" value="citas-administracion">
                
                <div class="form-group">
                    <label for="user" class="form-label">Usuario</label>
                    <select class="form-control" id="user" name="user" required onchange="document.getElementById('userSelectForm').submit();">
                        <option value="" selected disabled>Seleccionar usuario...</option>
                        <?php
                        $sql = "SELECT d.idUser, d.nombre, d.apellidos FROM users_data d ORDER BY d.nombre, d.apellidos";
                        $result = $conn->query($sql);
                        
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = ($selectedUser && $selectedUser['idUser'] == $row['idUser']) ? 'selected' : '';
                                echo "<option value='{$row['idUser']}' {$selected}>{$row['nombre']} {$row['apellidos']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </form>
        </div>
        
        <?php if ($selectedUser): ?>
            <div class="tabs">
                <button class="tab-btn active" onclick="openTab(event, 'tab-list')">Citas de <?php echo $selectedUser['nombre'] . ' ' . $selectedUser['apellidos']; ?></button>
                <button class="tab-btn" onclick="openTab(event, 'tab-create')">Crear Nueva Cita</button>
            </div>
            
            <!-- Tabla de Crear Cita -->
            <div id="tab-create" class="tab-content" style="display: none;">
                <div class="form-container">
                    <h2 class="form-title"><?php echo $editCita ? 'Editar Cita' : 'Crear Nueva Cita'; ?></h2>
                    
                    <form action="" method="post" class="needs-validation" novalidate>
                        <input type="hidden" name="action" value="<?php echo $editCita ? 'update' : 'create'; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $selectedUser['idUser']; ?>">
                        <?php if ($editCita): ?>
                            <input type="hidden" name="id_cita" value="<?php echo $editCita['idCita']; ?>">
                        <?php endif; ?>
                        
                        <div class="form-group">
                            <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
                            <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required value="<?php echo $editCita ? $editCita['fecha_cita'] : ''; ?>">
                            <div class="invalid-feedback">
                                La fecha de la cita es obligatoria.
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="motivo_cita" class="form-label">Motivo de la Cita</label>
                            <textarea class="form-control" id="motivo_cita" name="motivo_cita" rows="3"><?php echo $editCita ? $editCita['motivo_cita'] : ''; ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn"><?php echo $editCita ? 'Actualizar Cita' : 'Crear Cita'; ?></button>
                            <?php if ($editCita): ?>
                                <a href="index.php?page=citas-administracion&user=<?php echo $selectedUser['idUser']; ?>" class="btn btn-secondary">Cancelar</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Tabla de Listar Citas -->
            <div id="tab-list" class="tab-content">
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Motivo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Obtener todas las citas del usuario
                            $stmt = $conn->prepare("SELECT * FROM citas WHERE idUser = ? ORDER BY fecha_cita DESC");
                            $stmt->bind_param("i", $selectedUser['idUser']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $fecha_formateada = date('d/m/Y', strtotime($row['fecha_cita']));
                                    
                                    echo "<tr>
                                        <td>{$row['idCita']}</td>
                                        <td>{$fecha_formateada}</td>
                                        <td>{$row['motivo_cita']}</td>
                                        <td class='actions'>
                                            <a href='index.php?page=citas-administracion&user={$selectedUser['idUser']}&edit={$row['idCita']}' class='btn-action edit' title='Editar'><i class='fas fa-edit'></i></a>
                                            <button class='btn-action delete' onclick='confirmarEliminar({$row['idCita']})' title='Eliminar'><i class='fas fa-trash-alt'></i></button>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No hay citas registradas para este usuario.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Formulario oculto para eliminar cita -->
                <form id="deleteForm" method="post" style="display: none;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="user_id" value="<?php echo $selectedUser['idUser']; ?>">
                    <input type="hidden" name="id_cita" id="deleteIdCita">
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Por favor, seleccione un usuario para administrar sus citas.</div>
        <?php endif; ?>
        
        <?php
        $conn->close();
        ?>
    </div>
</div>

<script src="assets/js/citas.js"></script>

