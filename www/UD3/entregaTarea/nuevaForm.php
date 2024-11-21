<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD2. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once('menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Nueva tarea</h2>
                </div>

                <?php
                // Incluir la función para obtener los usuarios
                require_once('mysqli.php');

                // Obtener la lista de usuarios desde la base de datos
                $usuarios = obtenerUsuarios();
            ?>

        <div class="container justify-content-between">
            <form action="nueva.php" method="POST" class="mb-5 w-50">

            <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>
                <!-- Campo para Descripción de la tarea -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" required>
                </div>

                <!-- Campo para Estado de la tarea -->
                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    <select class="form-select" id="estado" name="estado" required>
                        <option value="" selected disabled>Seleccione el estado</option>
                        <option value="en_proceso">En Proceso</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="completada">Completada</option>
                    </select>
                </div>

                <!-- Campo para seleccionar el Usuario -->
                <div class="mb-3">
                    <label for="id_usuario" class="form-label">Usuario</label>
                    <select class="form-select" id="id_usuario" name="id_usuario" required>
                        <option value="" selected disabled>Seleccione el usuario</option>
                        <?php foreach ($usuarios as $usuario): ?>
                            <option value="<?= $usuario['id']; ?>">
                                <?= htmlspecialchars($usuario['username']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Botón de envío del formulario -->
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>




                </div>
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>
