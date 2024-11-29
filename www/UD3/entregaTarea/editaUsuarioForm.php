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

                        // Verificamos si el id se recibe y si se recibe por el metodo GET
                        if (isset($_GET['id']) && !empty($_GET['id']) ) 
                        
                        {

                            //variable que almacena el valor 
                            $id = $_GET['id'];

                            /* Depuramos que  el valor del id
                            var_dump($_GET['id']);
                            echo '<pre>ID Recibido: ' . htmlspecialchars($id) . '</pre>';
                            */


                            // llamamos a una funcion que busca el usuario asociado a ese id
                            $resultado = buscarUsuario($id);

                            /* Depuramos el  resultado de la función para ver si funcion y devuelve valores
                            echo '<pre>Resultado de buscarUsuario: ';
                            print_r($resultado);
                            echo '</pre>';
                            */

                            // si existen resultados asociamos estos resultados a las variables
                            if ($resultado && $resultado[0]) {
                                //$usuario es igual a los datos que contiene el array asociativo
                                $usuario = $resultado[1];
                                $username = $usuario['username'];
                                $nombre = $usuario['nombre'];
                                $apellidos = $usuario['apellidos'];
                                $contrasena = $usuario['contrasena'];
                        ?>

                                 <!-- Enviamos el id y el formulario con los nuevos valores -->
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