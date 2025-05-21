<?php
// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo '<div class="alert alert-danger">Debes iniciar sesión para acceder a esta página.</div>';
    echo '<script>setTimeout(function() { window.location.href = "index.php?page=login"; }, 3000);</script>';
    exit;
}

$user_id = $_SESSION['user_id'];

$conn = connectDB();

// Procesar formulario de creación/actualización de cita
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                // Datos del formulario para crear cita
                $fecha_cita = $_POST['fecha_cita'];
                $motivo_cita = trim($_POST['motivo_cita']);
                
                if (empty($fecha_cita)) {
                    echo '<div class="alert alert-danger">La fecha de la cita es obligatoria.</div>';
                } else {
                    try {
                        // Insertar cita
                        $stmt = $conn->prepare("INSERT INTO citas (idUser, fecha_cita, motivo_cita) VALUES (?, ?, ?)");
                        $stmt->bind_param("iss", $user_id, $fecha_cita, $motivo_cita);
                        $stmt->execute();
                        
                        echo '<div class="alert alert-success">Cita creada exitosamente.</div>';
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">Error al crear la cita: ' . $e->getMessage() . '</div>';
                    }
                }
                break;
                
            case 'update':
                // Datos del formulario para actualizar cita
                $idCita = $_POST['id_cita'];
                $fecha_cita = $_POST['fecha_cita'];
                $motivo_cita = trim($_POST['motivo_cita']);
                
                if (empty($fecha_cita)) {
                    echo '<div class="alert alert-danger">La fecha de la cita es obligatoria.</div>';
                } else {
                    try {
                        $stmt = $conn->prepare("SELECT idCita FROM citas WHERE idCita = ? AND idUser = ?");
                        $stmt->bind_param("ii", $idCita, $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result->num_rows === 0) {
                            echo '<div class="alert alert-danger">No tienes permiso para modificar esta cita.</div>';
                        } else {
                            // Actualizar cita
                            $stmt = $conn->prepare("UPDATE citas SET fecha_cita = ?, motivo_cita = ? WHERE idCita = ? AND idUser = ?");
                            $stmt->bind_param("ssii", $fecha_cita, $motivo_cita, $idCita, $user_id);
                            $stmt->execute();
                            
                            echo '<div class="alert alert-success">Cita actualizada exitosamente.</div>';
                        }
                    } catch (Exception $e) {
                        echo '<div class="alert alert-danger">Error al actualizar la cita: ' . $e->getMessage() . '</div>';
                    }
                }
                break;
                
            case 'delete':
                // Eliminar cita
                $idCita = $_POST['id_cita'];
                
                try {
                    // Verificar que la cita pertenece al usuario actual
                    $stmt = $conn->prepare("SELECT idCita FROM citas WHERE idCita = ? AND idUser = ?");
                    $stmt->bind_param("ii", $idCita, $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows === 0) {
                        echo '<div class="alert alert-danger">No tienes permiso para eliminar esta cita.</div>';
                    } else {
                        // Eliminar cita
                        $stmt = $conn->prepare("DELETE FROM citas WHERE idCita = ? AND idUser = ?");
                        $stmt->bind_param("ii", $idCita, $user_id);
                        $stmt->execute();
                        
                        echo '<div class="alert alert-success">Cita eliminada exitosamente.</div>';
                    }
                } catch (Exception $e) {
                    echo '<div class="alert alert-danger">Error al eliminar la cita: ' . $e->getMessage() . '</div>';
                }
                break;
        }
    }
}

$editCita = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $idCita = $_GET['edit'];
    
    // Obtener datos de la cita para editar (solo si pertenece al usuario actual)
    $stmt = $conn->prepare("SELECT * FROM citas WHERE idCita = ? AND idUser = ?");
    $stmt->bind_param("ii", $idCita, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $editCita = $result->fetch_assoc();
    }
}
?>

<div class="main-content">
<div class="section">
    <div class="container">
        <h1 class="section-title news-h1">Mis <strong>Citas</strong></h1>
        
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab(event, 'tab-list')">Mis Citas</button>
            <button class="tab-btn" onclick="openTab(event, 'tab-create')">Solicitar Nueva Cita</button>
        </div>
        
        <!--  Crear Cita -->
        <div id="tab-create" class="tab-content" style="display: none;">
            <div class="form-container">
                <h2 class="form-title"><?php echo $editCita ? 'Modificar Cita' : 'Solicitar Nueva Cita'; ?></h2>
                
                <form action="" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="<?php echo $editCita ? 'update' : 'create'; ?>">
                    <?php if ($editCita): ?>
                        <input type="hidden" name="id_cita" value="<?php echo $editCita['idCita']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="fecha_cita" class="form-label">Fecha de la Cita</label>
                        <input type="date" class="form-control" id="fecha_cita" name="fecha_cita" required value="<?php echo $editCita ? $editCita['fecha_cita'] : ''; ?>">
                        <div class="invalid-feedback">
                            La fecha de la cita es obligatoria.
                        </div>
                        <small class="form-text">Selecciona la fecha en la que te gustaría reservar tu cita.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="motivo_cita" class="form-label">Motivo de la Cita</label>
                        <textarea class="form-control" id="motivo_cita" name="motivo_cita" rows="3" placeholder="Describe brevemente el motivo de tu cita (revisión, limpieza, tratamiento específico...)"><?php echo $editCita ? $editCita['motivo_cita'] : ''; ?></textarea>
                        <small class="form-text">Cuanta más información nos proporciones, mejor podremos prepararnos para tu visita.</small>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-blue"><?php echo $editCita ? 'Actualizar Cita' : 'Solicitar Cita'; ?></button>
                        <?php if ($editCita): ?>
                            <a href="index.php?page=citaciones" class="btn btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Listar Citas -->
        <div id="tab-list" class="tab-content">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Motivo</th>
                            <th width="150">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener todas las citas del usuario actual
                        $stmt = $conn->prepare("SELECT * FROM citas WHERE idUser = ? ORDER BY fecha_cita DESC");
                        $stmt->bind_param("i", $user_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Formatear fecha
                                $fecha_formateada = date('d/m/Y', strtotime($row['fecha_cita']));
                                
                                // Comprobar si la cita es en el pasado
                                $es_pasada = strtotime($row['fecha_cita']) < strtotime(date('Y-m-d'));
                                $clase_fila = $es_pasada ? 'class="cita-pasada"' : '';
                                
                                echo "<tr $clase_fila>
                                    <td>{$fecha_formateada}</td>
                                    <td>" . (empty($row['motivo_cita']) ? '<em>Sin motivo especificado</em>' : $row['motivo_cita']) . "</td>
                                    <td class='actions'>";
                                
                                // Solo permitir editar/eliminar citas futuras
                                if (!$es_pasada) {
                                    echo "<a href='index.php?page=citaciones&edit={$row['idCita']}' class='btn-action edit' title='Editar'><i class='fas fa-edit'></i></a>
                                          <button class='btn-action delete' onclick='confirmarEliminar({$row['idCita']})' title='Cancelar'><i class='fas fa-times-circle'></i></button>";
                                } else {
                                    echo "<span class='cita-completada'><i class='fas fa-check-circle'></i> Completada</span>";
                                }
                                
                                echo "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3' class='text-center'>No tienes citas programadas. ¡Solicita tu primera cita ahora!</td></tr>";
                        }
                        
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Formulario oculto para eliminar cita -->
            <form id="deleteForm" method="post" style="display: none;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id_cita" id="deleteIdCita">
            </form>
        </div>
    </div>
</div>
</div>

<script>
    // Función para cambiar entre pestañas
    function openTab(evt, tabName) {
        // Ocultar todos los contenidos de pestañas
        var tabContents = document.getElementsByClassName("tab-content");
        for (var i = 0; i < tabContents.length; i++) {
            tabContents[i].style.display = "none";
        }
        
        // Remover la clase "active" de todos los botones
        var tabButtons = document.getElementsByClassName("tab-btn");
        for (var i = 0; i < tabButtons.length; i++) {
            tabButtons[i].className = tabButtons[i].className.replace(" active", "");
        }
        
        // Mostrar la pestaña actual y agregar clase "active" al botón
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    
    // Función para confirmar eliminación de cita
    function confirmarEliminar(idCita) {
        if (confirm("¿Estás seguro de que deseas cancelar esta cita?")) {
            document.getElementById("deleteIdCita").value = idCita;
            document.getElementById("deleteForm").submit();
        }
    }
    
    // Mostrar la pestaña de creación si hay una cita para editar
    <?php if ($editCita): ?>
        document.addEventListener("DOMContentLoaded", function() {
            openTab({currentTarget: document.getElementsByClassName("tab-btn")[1]}, "tab-create");
        });
    <?php else: ?>
        // Mostrar la primera pestaña por defecto
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("tab-list").style.display = "block";
        });
    <?php endif; ?>
</script> 