<nav class="main-nav">
    <div class="container">
        <div class="nav-container">
            <div class="logo">
                <a href="index.php">
                <img src="./assets/img/logo.png" alt="Imagen del logo">
                    <div class="tittle-logo">CLÍNICA <strong>BRILLADENT</strong>
                        <p>Dres.Carranza y Del Valle</p>
                    </div>
                </a>
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu" id="nav-menu">
                <li class="nav-item">
                    <a class="nav-link <?php echo $page === 'home' ? 'active' : ''; ?>" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $page === 'noticias' ? 'active' : ''; ?>" href="index.php?page=noticias">Noticias</a>
                </li>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?php echo in_array($page, ['usuarios-administracion', 'citas-administracion', 'noticias-administracion']) ? 'active' : ''; ?>" href="#" id="adminDropdown">
                                Administración <i class="fas fa-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item <?php echo $page === 'usuarios-administracion' ? 'active' : ''; ?>" href="index.php?page=usuarios-administracion">Usuarios</a></li>
                                <li><a class="dropdown-item <?php echo $page === 'citas-administracion' ? 'active' : ''; ?>" href="index.php?page=citas-administracion">Citas</a></li>
                                <li><a class="dropdown-item <?php echo $page === 'noticias-administracion' ? 'active' : ''; ?>" href="index.php?page=noticias-administracion">Noticias</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $page === 'citaciones' ? 'active' : ''; ?>" href="index.php?page=citaciones">Mis Citas</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown">
                            <i class="fas fa-user-circle"></i> <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuario'; ?> <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?page=profile">Mi perfil</a></li>
                            <li><a class="dropdown-item" href="controllers/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page === 'login' ? 'active' : ''; ?>" href="index.php?page=login">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $page === 'registro' ? 'active' : ''; ?>" href="index.php?page=registro">Registrarse</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 