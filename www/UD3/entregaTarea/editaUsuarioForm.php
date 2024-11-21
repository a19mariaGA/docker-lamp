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
                    <h2>Edita Usuario</h2>
                </div>

                <div class="container justify-content-between">
                    

                <form action="editaUsuario.php" method="POST" class="mb-2 w-50">
                        <?php
                        require_once('pdo.php');

                        // Verificar si se recibe solo el `id` para cargar los datos
                        if (isset($_GET['id']) && !empty($_GET['id']) ) 
                        
                        {

                            $id = $_GET['id'];

                            // Depuración del ID recibido
                            var_dump($_GET['id']);
                            echo '<pre>ID Recibido: ' . htmlspecialchars($id) . '</pre>';

                            $resultado = buscarUsuario($id);

                            // Depuración del resultado de la función
                            echo '<pre>Resultado de buscarUsuario: ';
                            print_r($resultado);
                            echo '</pre>';

                            if ($resultado && $resultado[0]) {
                                $usuario = $resultado[1];
                                $username = $usuario['username'];
                                $nombre = $usuario['nombre'];
                                $apellidos = $usuario['apellidos'];
                                $contrasena = $usuario['contrasena'];
                        ?>
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <?php include_once('formulario.php'); ?>
                                <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
                        <?php
                            } else 
                            {
                                echo '<div class="alert alert-danger" role="alert">No se pudo recuperar la información del usuario.</div>';
                            }
                        }
                        // Mostrar un error si faltan los datos iniciales
                        else {
                            echo '<div class="alert alert-danger" role="alert">Debes acceder a través del listado de usuarios.</div>';
                        }
                        ?>
                    </form>

                </div>

              <div class="container justify-content-between mb-2">
                  <a class="btn btn-info btn-sm" href="usuarios.php" role="button">Volver</a>
            </div> 

            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>