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
                    
                <!-- En esta misma pagina  -->
                <form action="editaUsuario.php" method="POST" class="mb-2 w-50">
                        <?php
                        
                        require_once('pdo.php');
                        require_once('utils.php');


                        if (!empty($_POST))
                        {
                            $id = $_POST['id'];
                            $username = $_POST['username'];
                            $nombre = $_POST['nombre'];
                            $apellidos = $_POST['apellidos'];
                            $contrasena = $_POST['contrasena'];

                            // creamos una variable para almacenar errores, partiendo que es false, que no existen errores 
                            $error = false;

                                                      
                            if (!validarCampoTexto($username))
                            {
                                $error = true;
                                echo '<div class="alert alert-danger" role="alert">El campo username es obligatorio y debe contener al menos 3 caracteres</div>';
                             }

                            //verificar nombre
                            if (!validarCampoTexto($nombre))
                            {
                                $error = true;
                                echo '<div class="alert alert-danger" role="alert">El campo nombre es obligatorio y debe contener al menos 3 caracteres.</div>';
                            }
                            //verificar apellidos
                            if (!validarCampoTexto($apellidos))
                            {
                                $error = true;
                                echo '<div class="alert alert-danger" role="alert">El campo apellidos es obligatorio y debe contener al menos 3 caracteres.</div>';
                            }
                            //verificar provincia
                            if (!validarCampoTexto($contrasena))
                            {
                                $error = true;
                                echo '<div class="alert alert-danger" role="alert">El campo contrasena es obligatorio y debe contener al menos 3 caracteres</div>';
                            }
                            // if ($error ===false); si no existen errores hasta ahora
                            if (!$error)
                            {
                                require_once('pdo.php');
                                $resultado = actualizaUsuario($id, $username, $nombre, $apellidos, $contrasena);
                                if ($resultado[0])
                                {
                                    echo '<div class="alert alert-success" role="alert">Usuario actualizado correctamente.</div>';
                                }
                                else
                                {
                                    echo '<div class="alert alert-danger" role="alert">Ocurrió un error actualizando el usuario: ' . $resultado[1] . '</div>';
                                }
                            }
                            else
                            {
                                echo '<div class="alert alert-danger" role="alert">No se pudo recuperar la información del usuario.</div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-danger" role="alert">Debes acceder a través del formulario de edición de usuarios.</div>';
                        }
                        ?>
                        
                    </form>
                </div>

                <div class="container justify-content-between mb-2">
                    <a class="btn btn-info btn-sm" href="usuarios.php" role="button">Volver</a>
                </div>

                </div>
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>