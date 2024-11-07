
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UD2. Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            
        <?php include 'menu.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Un poquito sobre mi</h2>
                </div>
                <div class="container">
                    <p>Mi nombre es Maria, vivo en Santiago de Compostela y trabajo como técnico de sistema.</br>
                        Esta es la última asignatura que me falta para teminar el módulo de DAW. 
                    </p>
                </div>
            </main>
        </div>
    </div>
    <form action="nueva.php" method="POST" class="mb-5">

            <div class="mb-3">
                
            <label for="ID" class="form-label">ID</label>
            <input type="text" name="ID" class="form-control" id="ID" >
            
            </div>
            
            <div class="mb-3">
            
            <label for="contenido" class="form-label">Aquí va el contenido</label>
            <textarea name="contenido" class="form-control" id="contenido" rows="3" ></textarea>
            
            </div>

            <div class="mb-3">
             
            <label for="estado" class="form-label">Estado</label>
             <select name="estado" id="estado" class="form-select" required>
                    <option value="abierta">Proceso</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="cerrada">Completada</option>
            </select>

            </div>
            
            <button type="submit" class="btn btn-primary">Enviar</button>

     </form>


    <?php include 'footer.php'; ?>

</body>
</html>