
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="int" class="form-control" id="username" name="username" value="<?php echo isset($username) ? htmlspecialchars($username) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo isset($apellidos) ? htmlspecialchars($apellidos) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contrasena</label>
                        <input type="text" class="form-control" id="contrasena" name="contrasena" value="<?php echo isset($contrasena) ? htmlspecialchars($contrasena) : '' ?>" required>
                    </div>
                    
                    
                    
