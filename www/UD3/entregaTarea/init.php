<?php

function crear_conexion(){
    // 1. Crear la conexión
    $conexion = new mysqli('db', 'root', 'test');

    // 2. Comprobar la conexión
    if ($conexion->connect_errno) {
        die('Fallo en la conexión: ' . $conexion->connect_error . ', con número ' . $conexion->connect_errno . '.<br>');
    }
    

    return $conexion;  // Devolver la conexión para usarla en otras funciones
}

function crear_bbdd()
{
    try {
        $conexion = crear_conexion(); 
        
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            // Verificar si la base de datos ya existe
            $sqlCheck = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'tareas'";
            $resultado = $conexion->query($sqlCheck);

            if ($resultado && $resultado->num_rows > 0) {
                return [false, 'La base de datos "tareas" ya existe.'];
            }

            $sql = 'CREATE DATABASE IF NOT EXISTS tareas';
            if ($conexion->query($sql))
            {
                return [true, 'Base de datos "tareas" creada correctamente'];
            }
            else
            {
                return [false, 'No se pudo crear la base de datos "tareas".'];
            }
        }
    }
    catch (mysqli_sql_exception $e)
    {
        return [false, $e->getMessage()];
    }
    finally
    {
                // Cerrar la conexión si se estableció
        if (isset($conexion) && $conexion->connect_errno === 0) {
            $conexion->close();       
        }
    }
}
    
function tabla_usuarios() {

    try {
        $conexion = crear_conexion(); 
        $conexion->select_db('tareas');
         
         if ($conexion->connect_error)
         {
             return [false, $conexion->error];
         }
         else
         {
             // Verificar si la tabla ya existe
             $sqlCheck = "SHOW TABLES LIKE 'usuarios'";
             $result = $conexion->query($sqlCheck);
 
             if ($result && $result->num_rows > 0)
             {
                 return [false, 'La tabla "usuarios" ya existe.'];
             }
 
             $sql = 'CREATE TABLE IF NOT EXISTS usuarios (
                     id INT AUTO_INCREMENT PRIMARY KEY, 
                     username VARCHAR(50) NOT NULL,
                     nombre VARCHAR(50) NOT NULL, 
                     apellidos VARCHAR(100) NOT NULL,
                     contrasena VARCHAR(100)
                 )';
             if ($conexion->query($sql))
             {
                 return [true, 'Tabla "usuarios" creada correctamente'];
             }
             else
             {
                 return [false, 'No se pudo crear la tabla "usuarios".'];
             }
         }
     }
     catch (mysqli_sql_exception $e)
     {
         return [false, $e->getMessage()];
     }
     finally
     {
         $conexion->close();
     }

    
}

function tabla_tareas (){

    try {
        $conexion = crear_conexion(); 
        $conexion->select_db('tareas');
         
         if ($conexion->connect_error)
         {
             return [false, $conexion->error];
         }
         else
         {
             // Verificar si la tabla ya existe
             $sqlCheck = "SHOW TABLES LIKE 'tareas'";
             $resultado = $conexion->query($sqlCheck);
 
             if ($resultado && $resultado->num_rows > 0)
             {
                 return [false, 'La tabla "tareas" ya existe.'];
             }
 
             $sql = 'CREATE TABLE IF NOT EXISTS tareas (
                     id INT AUTO_INCREMENT PRIMARY KEY, 
                     titulo VARCHAR(50) NOT NULL,
                     descripcion VARCHAR(250) NOT NULL, 
                     estado VARCHAR(50) NOT NULL,
                     id_usuario INT
                 )';
             if ($conexion->query($sql))
             {
                 return [true, 'Tabla "tareas" creada correctamente'];
             }
             else
             {
                 return [false, 'No se pudo crear la tabla "tareas".'];
             }
         }
     }
     catch (mysqli_sql_exception $e)
     {
         return [false, $e->getMessage()];
     }
     finally
     {
         $conexion->close();
     }
    
    }


    // Llamar a las funciones
$conexion = crear_conexion();   // Llama la función de conexión
crear_bbdd();          
$result= tabla_usuarios ();
echo $result[1]; 
$resultado = tabla_tareas();
echo $resultado[1];  // Imprime el mensaje de éxito o error

    ?>

