<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Registro de Usuario</h3>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['register_error'])) {
                        echo '<div class="alert alert-danger">' . $_SESSION['register_error'] . '</div>';
                        unset($_SESSION['register_error']);
                    }
                    ?>
                    
                    <form action="controllers/register_controller.php" method="post" class="needs-validation" novalidate>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce tu nombre.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce tus apellidos.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce un email válido.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce tu número de teléfono.
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce tu fecha de nacimiento.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-select" id="sexo" name="sexo" required>
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
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="2"></textarea>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="usuario" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                                <div class="invalid-feedback">
                                    Por favor, elige un nombre de usuario.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="invalid-feedback">
                                    Por favor, introduce una contraseña.
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                            <div class="invalid-feedback">
                                Por favor, confirma tu contraseña.
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">Acepto los términos y condiciones</label>
                            <div class="invalid-feedback">
                                Debes aceptar los términos y condiciones para continuar.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <p class="mb-0">¿Ya tienes una cuenta? <a href="index.php?page=login">Inicia sesión aquí</a></p>
                </div>
            </div>
        </div>
    </div>
</div> 