<div class="section">
    <div class="container">
        <div class="form-container">
            <h3 class="form-title">Iniciar Sesión</h3>
            
            <?php
            if (isset($_SESSION['login_error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['login_error'] . '</div>';
                unset($_SESSION['login_error']);
            }
            
            if (isset($_SESSION['register_success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['register_success'] . '</div>';
                unset($_SESSION['register_success']);
            }
            ?>
            
            <form action="controllers/login_controller.php" method="post" class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                    <div class="invalid-feedback">
                        Por favor, introduce tu nombre de usuario.
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">
                        Por favor, introduce tu contraseña.
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-blue">Iniciar Sesión</button>
                </div>
                
                <div class="text-center mt-3">
                    <p>¿No tienes una cuenta? <a href="index.php?page=registro">Regístrate aquí</a></p>
                </div>
            </form>
        </div>
    </div>
</div> 