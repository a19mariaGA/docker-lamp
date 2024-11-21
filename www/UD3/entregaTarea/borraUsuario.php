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
                    
                <form >
                        <?php
                        
                        require_once('pdo.php');
                        
                        if (!empty($_GET) && isset($_GET['id']))
                        {
                            

                            if (borrarTarea($_GET['id']))
                            {
                                echo '<div class="alert alert-success" role="alert">Usuario borrado correctamente.</div>';
                            }
                            else
                            {
                                echo '<div class="alert alert-danger" role="alert">No se pudo borrar la tarea.</div>';
                            }
                        }
                        else
                        {
                            echo '<div class="alert alert-warning" role="alert">No se puede localizar nnguna  tarea.</div>';
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