<?php include_once('head.php'); ?>
<body>

    <?php include_once('header.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <main class="col">
                <div class="container justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h2>Menú</h2>
                </div>

                <div class="container justify-content-between">
                    <?php
                        require_once('database.php');

                        $resultado = creaDB();
                        //Si $resultado[0] (true o false) es verdadero (lo que significa que la base de datos fue creada correctamente)
                        // recuerda la funcion >> return [true, 'Base de datos "tienda" creada correctamente'];
                        if ($resultado[0])
                        {
                            echo '<div class="alert alert-success" role="alert">';
                        }
                        else
                        {
                            echo '<div class="alert alert-warning" role="alert">';
                        }
                        //Este mensaje es el texto que la función creaDB() devuelve, y puede ser una confirmación de éxito o un mensaje de error.
                        echo $resultado[1];
                        echo '</div>';


                        $resultado = createTablaUsuarios();
                        if ($resultado[0])
                        {
                            echo '<div class="alert alert-success" role="alert">';
                        }
                        else
                        {
                            echo '<div class="alert alert-warning" role="alert">';
                        }
                        echo $resultado[1];
                        echo '</div>';

                    ?>
                </div>
                <?php include_once('back.php'); ?>
            </main>
        </div>
    </div>

    <?php include_once('footer.php'); ?>
    
</body>
</html>