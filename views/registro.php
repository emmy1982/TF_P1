<div class="section">
    <div class="container">
        <div class="form-container" style="max-width: 800px;">
            <h3 class="form-title">Registro de Usuario</h3>
            
            <?php
            if (isset($_SESSION['register_error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['register_error'] . '</div>';
                unset($_SESSION['register_error']);
            }
            ?>
            
            <form action="controllers/register_controller.php" method="post" class="needs-validation" novalidate>
                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <div class="invalid-feedback">
                            Por favor, introduce tu nombre.
                        </div>
                    </div>
                    <div class="form-group form-group-half">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        <div class="invalid-feedback">
                            Por favor, introduce tus apellidos.
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">
                            Por favor, introduce un email válido.
                        </div>
                    </div>
                    <div class="form-group form-group-half">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        <div class="invalid-feedback">
                            Por favor, introduce tu número de teléfono.
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        <div class="invalid-feedback">
                            Por favor, introduce tu fecha de nacimiento.
                        </div>
                    </div>
                    <div class="form-group form-group-half">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select class="form-control" id="sexo" name="sexo" required>
                            <option value="" selected disabled>Selecciona...</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción.
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="direccion" class="form-label">Dirección</label>
                    <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
                </div>
                
                <hr class="form-divider">
                
                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="usuario" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                        <div class="invalid-feedback">
                            Por favor, elige un nombre de usuario.
                        </div>
                    </div>
                    <div class="form-group form-group-half">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback">
                            Por favor, introduce una contraseña.
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                    <div class="invalid-feedback">
                        Por favor, confirma tu contraseña.
                    </div>
                </div>
                
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">Acepto los términos y condiciones</label>
                    <div class="invalid-feedback">
                        Debes aceptar los términos y condiciones para continuar.
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-blue">Registrarse</button>
                </div>
                
                <div class="text-center mt-3">
                    <p>¿Ya tienes una cuenta? <a href="index.php?page=login">Inicia sesión aquí</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
