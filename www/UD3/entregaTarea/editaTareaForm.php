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
                    <h2>Edita Tarea</h2>
                </div>

                <div class="container justify-content-between">
                    <form action="editaTarea.php" method="POST" class="mb-2 w-50">
                        <?php
                        require_once('mysqli.php');

                        // Verificar si se recibe el `id` para cargar los datos
                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                            $id = $_GET['id'];


                            var_dump($_GET);


                            // Obtener los detalles de la tarea
                            $resultado = select_tarea_id($id);

                            var_dump($resultado);

                            // Si la tarea existe, mostrar los datos
                            if ($resultado && is_array($resultado) && count($resultado) > 0) {
                                $tarea = $resultado; // Accede directamente al array asociativo
                                $titulo = htmlspecialchars($tarea['titulo']);
                                $descripcion = htmlspecialchars($tarea['descripcion']);
                                $estado = htmlspecialchars($tarea['estado']);
                                $id_usuario = htmlspecialchars($tarea['id_usuario']);



                                
                        ?>
                                <input type="hidden" name="id" value="<?php echo $id ?>">

                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Titulo</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $descripcion; ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="" disabled>Seleccione el estado</option>
                                        <option value="en_proceso" <?php echo ($estado == 'en_proceso') ? 'selected' : ''; ?>>En Proceso</option>
                                        <option value="pendiente" <?php echo ($estado == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="completada" <?php echo ($estado == 'completada') ? 'selected' : ''; ?>>Completada</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="id_usuario" class="form-label">Usuario</label>
                                    <select class="form-select" id="id_usuario" name="id_usuario" required>
                                        <option value="" disabled>Seleccione el usuario</option>
                                        <?php
                                        // Recuperar usuarios para poblar el campo de selección
                                        $usuarios = obtenerUsuarios();  // Función que debes definir para obtener usuarios
                                        foreach ($usuarios as $usuario):
                                        ?>
                                            <option value="<?= $usuario['id']; ?>" <?php echo ($usuario['id'] == $id_usuario) ? 'selected' : ''; ?>>
                                                <?= htmlspecialchars($usuario['username']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
                        <?php
                            } else {
                                echo '<div class="alert alert-danger" role="alert">No se pudo recuperar la información de la tarea.</div>';
                            }
                        } else {
                            echo '<div class="alert alert-danger" role="alert">Debes acceder a través del listado de tareas.</div>';
                        }
                        ?>
                    </form>
                </div>

                <div class="container justify-content-between mb-2">
                    <a class="btn btn-info btn-sm" href="tareas.php" role="button">Volver</a>
                </div> 

            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>
