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
                    <h2>Gestión de tarea</h2>
                </div>

                <div class="container justify-content-between">
                <?php
                            // Incluir las funciones necesarias
                            require_once('utils.php');
                            require_once('mysqli.php');

                            // Recoger los datos del formulario
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                // Ya no recogemos el 'id' porque es autoincremental
                                $titulo = $_POST['titulo']; // Títul
                                $desc = $_POST['descripcion']; // Descripción
                                $estado = $_POST['estado']; // Estado
                                $id_usuario = $_POST['id_usuario']; // ID de usuario

                               
                                // Variable para verificar si los campos son válidos
                                $error = false;

                                // Validar los campos
                                if (!esCampoValido($titulo)) {
                                    $error = true;
                                    echo '<div class="alert alert-danger" role="alert">El titulo no es válido</div>';
                                }
                                if (!esCampoValido($desc)) {
                                    $error = true;
                                    echo '<div class="alert alert-danger" role="alert">La descripcion no es válida</div>';
                                }
                                if (!esCampoValido($estado)) {
                                    $error = true;
                                    echo '<div class="alert alert-danger" role="alert">El estado no es válido</div>';
                                }

                                // Si todos los campos son válidos, guardamos la tarea
                                
                                    if (!$error) { 
         
                                        $resultado = insert_tarea($titulo, $desc, $estado, $id_usuario);

                                        if ($resultado[0]) {
                                            echo '<div class="alert alert-success" role="alert">' . $resultado[1] . '</div>';
                                        } else {
                                            echo '<div class="alert alert-danger" role="alert">' . $resultado[1] . '</div>';
                                        }
                                        
                               
                               
                               }
                            }
                            ?>



                </div>
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>
