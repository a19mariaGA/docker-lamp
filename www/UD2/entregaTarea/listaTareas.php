<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de elementos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="table container mt-4">

    <table class="table table-striped table-hover">
        <thead class="thead">
            <tr>                            
                <th>Identificador</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
                 include_once('utils.php');
                

                 if (empty($tareas)) {
                    echo '<tr><td colspan="3">No existen tareas.</td></tr>';
                } else {
                    $tareas = devolver_tareas();
                    echo "<tr>
                            <td>{$tarea['ID']}</td>
                            <td>{$tarea['contenido']}</td>
                            <td>{$tarea['estado']}</td>                
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</div>
 
</body>
</html>

