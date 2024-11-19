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
                    <h2>Nuevo Usuario</h2>
                </div>

                <div class="container justify-content-between">
                    

                <?php
                    $username = $_POST['username'];
                    $nombre = $_POST['nombre'];
                    $apellidos = $_POST['apellidos'];
                    $contrasena = $_POST['contrasena'];
                   
                    require_once('utils.php');
                    $error = false;
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
                    //verificar edad
                    if (!esNumeroValido($edad))
                    {
                        $error = true;
                        echo '<div class="alert alert-danger" role="alert">El campo edad es obligatorio y debe contener solo números.</div>';
                    }
                    //verificar provincia
                    if (!validarCampoTexto($provincia))
                    {
                        $error = true;
                        echo '<div class="alert alert-danger" role="alert">El campo provincia es obligatorio y debe contener al menos 3 caracteres</div>';
                    }
                    if (!$error)
                    {
                        require_once('database.php');
                        $resultado = nuevoUsuario(filtraCampo($nombre), filtraCampo($apellidos), filtraCampo($edad), filtraCampo($nombre));
                        if ($resultado[0])
                        {
                            echo '<div class="alert alert-success" role="alert">Usuario guardado correctamente.</div>';
                        }
                        else
                        {
                            echo '<div class="alert alert-danger" role="alert">Ocurrió un error guardando el usuario: ' . $resultado[1] . '</div>';
                        }
                    }
                    ?>
                </div>

                <div class="container justify-content-between mb-2">
                     <a class="btn btn-success btn-sm" href="index.php" role="button">Volver</a>
                </div>

                </div>
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>
