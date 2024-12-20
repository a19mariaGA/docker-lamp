<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD3. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            
            <?php include_once('menu.php'); ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

            <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2>Usuarios registrados</h2>
            </div>

        <div class="container justify-content-between">
                    <div class="table">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>                            
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>Nombre</th>
                                    <th>Apellidos</th>
                                    <th>Contrasena</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    require_once('pdo.php');
                                    $resultado = select_usuarios();

                                    // si la función devuelve algun resultado y es true
                                    if ($resultado && $resultado[0])
                                    {
                                        // los resultados optenidos [1] se guardan en usuarios
                                        $usuarios = $resultado[1];
                                        if ($usuarios)
                                        {
                                            //recorremos el array 
                                            foreach ($usuarios as $usuario)
                                            {
                                                echo '<tr>';   
                                                echo '<td>' . $usuario['id'] . '</td>';
                                                echo '<td>' . $usuario['username'] . '</td>';
                                                echo '<td>' . $usuario['nombre'] . '</td>';
                                                echo '<td>' . $usuario['apellidos'] . '</td>';
                                                echo '<td>' . $usuario['contrasena'] . '</td>';
                                                echo '<td>';
                                                                                                    //boton que nos enlaza con el formulario para editar
                                                echo '<a class="btn btn-outline-success btn-sm me-1" href="editaUsuarioForm.php?id=' . $usuario['id'] . '" role="button">Editar</a></span>';
                                                echo '<a class="btn btn-outline-danger btn-sm" href="borraUsuario.php?id=' . $usuario['id'] . '" role="button">Borrar</a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        }
                                        else{
                                            echo '<tr><td colspan="100">No hay usuarios registrados</td></tr>';
                                        }
                                    }
                                    else
                                    {
                                        echo '<tr><td colspan="100">Error recuperando usuarios: ' . $resultado['1'] . '</td></tr>';
                                    }
                                    
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="container justify-content-between mb-2">
                     <a class="btn btn-success btn-sm" href="index.php" role="button">Volver</a>
                </div>
                
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>
