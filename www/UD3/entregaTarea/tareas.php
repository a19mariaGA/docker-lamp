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
                    <h2>Mis tareas</h2>
                </div>

                <div class="container justify-content-between">
                <?php require_once('utils.php'); ?>
                    <div class="table">
                    <div class="table">
                        <table class="table table-striped table-hover">
                            <thead class="thead">
                                <tr>    
                                                            
                                    <th>Identificador</th>
                                    <th>Titulo</th>
                                    <th>Descriptción</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <div class="container justify-content-between">
                   

                           
                            <?php
                                    require_once('mysqli.php');
                                    require_once('pdo.php');

                                    // esta pagina sirve para listar todas las tareas o la tareas de un usuario por eso se crean las tres variables
                                    $id = null;
                                    $username = null;
                                    $estado = null;

                                    // Verificamos si hay un ID en la URL para buscar tareas por id
                                    if (!empty($_GET) && isset($_GET['id'])) {
                                        $id = $_GET['id'];
                                    }

                                    // Verificamos si lo que se ha recibido es un username 
                                    if (!empty($_GET) && isset($_GET['username'])) {
                                        $username = $_GET['username'];
                                    }

                                    // Verificamos si lo que se ha recibido es un estado 
                                    if (!empty($_GET) && isset($_GET['estado'])) {
                                        $estado = $_GET['estado'];
                                    }

                                    /*Depuración de parámetros
                                    echo "<pre>";
                                    echo "Parámetros de entrada:";
                                    var_dump($username, $estado);
                                    echo "</pre>";
                                    */

                                    if (!empty($username)) {
                                        // Si el username existe, buscar tareas por username y estado (si está definido)
                                        $resultado = buscarTareaUsername($username, $estado ?? null);
                                    
                                        if (!$resultado[0] || count($resultado[1]) == 0) {
                                            // Si no hay resultados, listar todas las tareas
                                            $resultado = select_tarea();
                                        }
                                    } else {
                                        // Si el username no está definido, listar todas las tareas
                                        $resultado = select_tarea();
                                    }
                                    
                                    // Verificamos si tenemos un resultado válido
                                    if ($resultado[0]) { // El primer valor indica si la consulta fue exitosa
                                        $tareas = $resultado[1]; // El segundo valor contiene las tareas
                                        if (count($tareas) > 0) { //si existe alguna
                                            foreach ($tareas as $result) {
                                                echo '<tr>';
                                                echo '<td>' . $result['id'] . '</td>';
                                                echo '<td>' . $result['titulo'] . '</td>';
                                                echo '<td>' . $result['descripcion'] . '</td>';
                                                echo '<td>' . $result['estado'] . '</td>';
                                                echo '<td>' . $result['username'] . '</td>'; // Muestra el nombre del usuario asociado a la tarea
                                                echo '<td>';
                                                echo '<a class="btn btn-outline-success btn-sm me-1" href="editaTareaForm.php?id=' . $result['id'] . '" role="button">Editar</a>';
                                                echo '<a class="btn btn-outline-danger btn-sm" href="borraTarea.php?id=' . $result['id'] . '" role="button">Borrar</a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo '<div class="alert alert-secondary" role="alert">No hay tareas registradas.</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">' . "Error" . '</div>';
                                    }
                                    ?>



                </div>


                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>
