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
                <!--Los valores recogidos en el formulario se envian a nuevoUsuario.php mediante el método POST  -->
                    <form action="nuevoUsuario.php" method="POST" class="mb-5 w-50">
                    
                     <!--El formulario está guardado en la página formulario.php  -->
                    <?php include_once('formulario.php'); ?>
                    
                    <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                    
                    </form> 

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
