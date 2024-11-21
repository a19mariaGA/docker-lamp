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
                                    <th>Descriptción</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                
                            <div class="container justify-content-between">
                   

                            <?php
                                    require_once('mysqli.php');
                                    $id = null;
                                    if (!empty($_GET) && isset($_GET['id'])) {
                                        $id = $_GET['id'];
                                    }

                                    // Llamada a la función que obtiene las tareas con el nombre del usuario
                                    $resultado = select_tarea();

                                    if ($resultado && count($resultado) > 0) {
                                        // Recorrer y mostrar cada tarea
                                        foreach ($resultado as $result) {
                                            echo '<tr>';
                                            echo '<td>' . $result['id'] . '</td>';
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
