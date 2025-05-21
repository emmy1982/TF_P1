<div class="main-content">
<div class="section">
    <div class="container">
        <h1 class="section-title news-h1">Noticias sobre <strong>Higiene Dental</strong></h1>
        
        <?php
        $conn = connectDB();
        
        
        if ($conn->connect_error) {
            echo '<div class="alert alert-danger">Error de conexión: ' . $conn->connect_error . '</div>';
        }
        
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            
            // Consultar la noticia específica
            $sql = "SELECT n.*, u.nombre, u.apellidos 
                    FROM noticias n 
                    INNER JOIN users_data u ON n.idUser = u.idUser 
                    WHERE n.idNoticia = ?";
            
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $result->num_rows > 0) {
                $noticia = $result->fetch_assoc();
                ?>
                <div class="single-news">
                    <a href="index.php?page=noticias" class="btn back-btn"><i class="fas fa-arrow-left"></i> Volver a todas las noticias</a>
                    
                    <div class="news-header">
                        <h2 class="news-title"><?php echo $noticia['titulo']; ?></h2>
                        <p class="news-meta">
                            <span class="news-date"><i class="fas fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($noticia['fecha'])); ?></span>
                            <span class="news-author"><i class="fas fa-user"></i> <?php echo $noticia['nombre'] . ' ' . $noticia['apellidos']; ?></span>
                        </p>
                    </div>
                    
                    <div class="news-image">
                        <img src="<?php echo $noticia['imagen']; ?>" alt="<?php echo $noticia['titulo']; ?>">
                    </div>
                    
                    <div class="news-content">
                        <p><?php echo nl2br($noticia['texto']); ?></p>
                    </div>
                </div>
                <?php
            } else {
                echo '<div class="alert alert-danger">La noticia no existe o ha sido eliminada.</div>';
            }
            
            $stmt->close();
        } 
        else {
            // Consultar todas las noticias
            $sql = "SELECT n.*, u.nombre, u.apellidos 
                    FROM noticias n 
                    INNER JOIN users_data u ON n.idUser = u.idUser 
                    ORDER BY n.fecha DESC";
            $result = $conn->query($sql);
            
            if (!$result) {
                echo '<div class="alert alert-danger">Error en la consulta: ' . $conn->error . '</div>';
            } else {
                
                if ($result->num_rows > 0) {
                    echo '<div class="news-grid">';
                    
                    while ($row = $result->fetch_assoc()) {
                        //  Mostrar los datos de cada noticia
                        echo "<!-- Noticia: " . print_r($row, true) . " -->";
                        ?>
                        <div class="news-card">
                            <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['titulo']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['titulo']); ?></h5>
                                <p class="news-date"><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars(substr($row['texto'], 0, 150)); ?>...</p>
                                <p class="news-author">Por: <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellidos']); ?></p>
                                <a href="index.php?page=noticias&id=<?php echo $row['idNoticia']; ?>" class="btn">Leer más</a>
                            </div>
                        </div>
                        <?php
                    }
                    
                    echo '</div>';
                } else {
                    echo '<div class="text-center">No hay noticias disponibles en este momento.</div>';
                }
            }
        }
        
        $conn->close();
        ?>
    </div>
</div>
</div> 