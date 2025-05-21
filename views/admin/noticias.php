<div class="section">
    <div class="container">
        <h1 class="section-title">Administración de Noticias</h1>
        
        <?php
        $conn = connectDB();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                switch ($_POST['action']) {
                    case 'create':
                        $titulo = trim($_POST['titulo']);
                        $imagen = trim($_POST['imagen']);
                        $texto = trim($_POST['texto']);
                        $fecha = $_POST['fecha'];
                        $idUser = $_SESSION['user_id']; // El admin actual es el autor
                        
                        // Validar datos
                        if (empty($titulo) || empty($imagen) || empty($texto) || empty($fecha)) {
                            echo '<div class="alert alert-danger">Todos los campos obligatorios deben ser completados.</div>';
                        } else {
                            try {
                                $stmt = $conn->prepare("SELECT idNoticia FROM noticias WHERE titulo = ?");
                                $stmt->bind_param("s", $titulo);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                
                                if ($result->num_rows > 0) {
                                    echo '<div class="alert alert-danger">Ya existe una noticia con este título.</div>';
                                } else {
                                    // Insertar noticia
                                    $stmt = $conn->prepare("INSERT INTO noticias (titulo, imagen, texto, fecha, idUser) VALUES (?, ?, ?, ?, ?)");
                                    $stmt->bind_param("ssssi", $titulo, $imagen, $texto, $fecha, $idUser);
                                    $stmt->execute();
                                    
                                    echo '<div class="alert alert-success">Noticia creada exitosamente.</div>';
                                }
                            } catch (Exception $e) {
                                echo '<div class="alert alert-danger">Error al crear la noticia: ' . $e->getMessage() . '</div>';
                            }
                        }
                        break;
                        
                    case 'update':
                        // Datos del formulario para actualizar noticia
                        $idNoticia = $_POST['id_noticia'];
                        $titulo = trim($_POST['titulo']);
                        $imagen = trim($_POST['imagen']);
                        $texto = trim($_POST['texto']);
                        $fecha = $_POST['fecha'];
                        
                        if (empty($titulo) || empty($imagen) || empty($texto) || empty($fecha)) {
                            echo '<div class="alert alert-danger">Todos los campos obligatorios deben ser completados.</div>';
                        } else {
                            try {
                                $stmt = $conn->prepare("SELECT idNoticia FROM noticias WHERE titulo = ? AND idNoticia != ?");
                                $stmt->bind_param("si", $titulo, $idNoticia);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                
                                if ($result->num_rows > 0) {
                                    echo '<div class="alert alert-danger">Ya existe otra noticia con este título.</div>';
                                } else {
                                    $stmt = $conn->prepare("UPDATE noticias SET titulo = ?, imagen = ?, texto = ?, fecha = ? WHERE idNoticia = ?");
                                    $stmt->bind_param("ssssi", $titulo, $imagen, $texto, $fecha, $idNoticia);
                                    $stmt->execute();
                                    
                                    echo '<div class="alert alert-success">Noticia actualizada exitosamente.</div>';
                                }
                            } catch (Exception $e) {
                                echo '<div class="alert alert-danger">Error al actualizar la noticia: ' . $e->getMessage() . '</div>';
                            }
                        }
                        break;
                        
                    case 'delete':
                        // Eliminar noticia
                        $idNoticia = $_POST['id_noticia'];
                        
                        try {
                            // Eliminar noticia
                            $stmt = $conn->prepare("DELETE FROM noticias WHERE idNoticia = ?");
                            $stmt->bind_param("i", $idNoticia);
                            $stmt->execute();
                            
                            echo '<div class="alert alert-success">Noticia eliminada exitosamente.</div>';
                        } catch (Exception $e) {
                            echo '<div class="alert alert-danger">Error al eliminar la noticia: ' . $e->getMessage() . '</div>';
                        }
                        break;
                }
            }
        }
        
        $editNoticia = null;
        if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $idNoticia = $_GET['edit'];
            
            $stmt = $conn->prepare("SELECT * FROM noticias WHERE idNoticia = ?");
            $stmt->bind_param("i", $idNoticia);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $editNoticia = $result->fetch_assoc();
            }
        }
        ?>
        
        <!-- Pestañas para navegar entre crear y listar noticias -->
        <div class="tabs">
            <button class="tab-btn active" onclick="openTab(event, 'tab-list')">Lista de Noticias</button>
            <button class="tab-btn" onclick="openTab(event, 'tab-create')">Crear Noticia</button>
        </div>
        
        <!-- Tab de Crear Noticia -->
        <div id="tab-create" class="tab-content" style="display: none;">
            <div class="form-container">
                <h2 class="form-title"><?php echo $editNoticia ? 'Editar Noticia' : 'Crear Nueva Noticia'; ?></h2>
                
                <form action="" method="post" class="needs-validation" novalidate>
                    <input type="hidden" name="action" value="<?php echo $editNoticia ? 'update' : 'create'; ?>">
                    <?php if ($editNoticia): ?>
                        <input type="hidden" name="id_noticia" value="<?php echo $editNoticia['idNoticia']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required value="<?php echo $editNoticia ? $editNoticia['titulo'] : ''; ?>">
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="imagen" class="form-label">URL de la Imagen</label>
                        <input type="text" class="form-control" id="imagen" name="imagen" required value="<?php echo $editNoticia ? $editNoticia['imagen'] : ''; ?>">
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                        <small class="form-text">Ingrese la URL completa de la imagen.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="texto" class="form-label">Contenido de la Noticia</label>
                        <textarea class="form-control" id="texto" name="texto" rows="6" required><?php echo $editNoticia ? $editNoticia['texto'] : ''; ?></textarea>
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="fecha" class="form-label">Fecha de Publicación</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required value="<?php echo $editNoticia ? $editNoticia['fecha'] : date('Y-m-d'); ?>">
                        <div class="invalid-feedback">
                            Este campo es obligatorio.
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn"><?php echo $editNoticia ? 'Actualizar Noticia' : 'Crear Noticia'; ?></button>
                        <?php if ($editNoticia): ?>
                            <a href="index.php?page=noticias-administracion" class="btn btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tab de Listar Noticias -->
        <div id="tab-list" class="tab-content">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Título</th>
                            <th>Imagen</th>
                            <th>Fecha</th>
                            <th>Autor</th>
                            <th style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener todas las noticias
                        $sql = "
                            SELECT n.*, u.nombre, u.apellidos 
                            FROM noticias n 
                            INNER JOIN users_data u ON n.idUser = u.idUser
                            ORDER BY n.fecha DESC
                        ";
                        $result = $conn->query($sql);
                        
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $fecha_formateada = date('d/m/Y', strtotime($row['fecha']));
                                
                                $titulo_corto = (strlen($row['titulo']) > 50) ? substr($row['titulo'], 0, 47) . '...' : $row['titulo'];
                                
                                $imagen_html = '<img src="' . $row['imagen'] . '" alt="Miniatura" style="width: 50px; height: 50px; object-fit: cover;">';
                                
                                echo "<tr>
                                    <td>{$row['idNoticia']}</td>
                                    <td title='{$row['titulo']}'>{$titulo_corto}</td>
                                    <td>{$imagen_html}</td>
                                    <td>{$fecha_formateada}</td>
                                    <td>{$row['nombre']} {$row['apellidos']}</td>
                                    <td class='actions'>
                                        <a href='index.php?page=noticias-administracion&edit={$row['idNoticia']}' class='btn-action edit' title='Editar'><i class='fas fa-edit'></i></a>
                                        <button class='btn-action delete' onclick='confirmarEliminar({$row['idNoticia']})' title='Eliminar'><i class='fas fa-trash-alt'></i></button>
                                        <a href='index.php?page=noticias&id={$row['idNoticia']}' target='_blank' class='btn-action view' title='Ver'><i class='fas fa-eye'></i></a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No hay noticias registradas.</td></tr>";
                        }
                        
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Formulario oculto para eliminar noticia -->
            <form id="deleteForm" method="post" style="display: none;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id_noticia" id="deleteIdNoticia">
            </form>
        </div>
    </div>
</div>

<script src="assets/js/noticias.js"></script>

