<?php

function crear_conexion(){
    // 1. Crear la conexión
    $conexion = new mysqli('db', 'root', 'test');

    // 2. Comprobar la conexión
    if ($conexion->connect_errno) {
        die('Fallo en la conexión: ' . $conexion->connect_error . ', con número ' . $conexion->connect_errno . '.<br>');
    }
    echo 'Conexión correcta <br>';

    return $conexion;  // Devolver la conexión para usarla en otras funciones
}


function crear_bbdd(){

    $conexion = crear_conexion(); 


    try {
        // 3. Crear base de datos si no existe
        $sql = 'CREATE DATABASE tareas';


        if ($conexion->query($sql)) {
            echo 'Base de datos creada correctamente <br>';

        }
        else {
            echo 'Error creando la base de datos: ' . $conexion->error . '<br>';
        }


        
    } catch (Exception $e) {
        echo 'Error en la operación: ' . $e->getMessage() . '<br>';
    }
  finally {
        // Cerrar la conexión si se estableció
        if (isset($conexion) && $conexion->connect_errno === 0) {
            $conexion->close();
            echo 'Conexión cerrada tras crear la bbdd.<br>';
        
        }

    }
}
    


function seleccionar_bd($conexion){
    // 4. Seleccionar la base de datos 'tareas'
    if ($conexion->select_db('tareas')) {
        echo 'Base de datos "tareas" seleccionada.<br>';
    } else {
        echo 'Error al seleccionar la base de datos "tareas": ' . $conexion->error . '<br>';
    }


}


// Llamar a las funciones
$conexion = crear_conexion();   // Llama la función de conexión
crear_bbdd($conexion);          // Crea la base de datos
seleccionar_bd($conexion); 


?>
