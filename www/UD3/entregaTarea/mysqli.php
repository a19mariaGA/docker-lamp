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


    function select_tarea() {
        try {
            // Crear la conexión a la base de datos
            $conexion = crear_conexion();
            $conexion->select_db('tareas');
            
            // Consulta para obtener las tareas con el nombre del usuario
            $sql = "SELECT t.id, t.descripcion, t.estado, u.username
                    FROM tareas t
                    JOIN usuarios u ON t.id_usuario = u.id";
            
            // Ejecutar la consulta
            $resultado = $conexion->query($sql);
            
            // Verificar si la consulta fue exitosa y si hay filas
            if ($resultado && $resultado->num_rows > 0) {
                // Devolver los resultados como un array asociativo
                return $resultado->fetch_all(MYSQLI_ASSOC);
            } else {
                // Si no hay resultados, devolver un array vacío
                return [];
            }
            
        } catch (mysqli_sql_exception $e) {
            // Manejo de excepciones y retorno de un array con el error
            return [false, $e->getMessage()];
        } finally {
            // Cerrar la conexión
            $conexion->close();
        }
    }
    

    function insert_tarea($titulo, $desc, $estado, $id_usuario)
    {
        try {
            // Crear la conexión
            $conexion = crear_conexion();
            $conexion->select_db('tareas');
    
            // Verificar si ocurrió un error en la conexión
            if ($conexion->connect_error) {
                throw new Exception("Conexión fallida: " . $conexion->connect_error);
            }
    
            // Preparar la consulta SQL con parámetros
            $sql = "INSERT INTO tareas (titulo, descripcion, estado, id_usuario) VALUES (?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);
    
            // Verificar si hubo un error al preparar la consulta
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }
    
            // Enlazar los parámetros
            $stmt->bind_param("sssi", $titulo, $desc, $estado, $id_usuario); // Aquí hemos corregido la coma extra
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Verificar si la consulta fue exitosa
            if ($stmt->affected_rows > 0) {
                return [true, "Tarea guardada correctamente."];
            } else {
                return [false, "No se insertó ninguna tarea."]; // Aquí devolvemos un mensaje más claro
            }
        } catch (Exception $e) {
            // Si ocurre un error, devolver el mensaje de la excepción
            return [false, "Error: " . $e->getMessage()];
        } finally {
            // Cerrar la conexión y la consulta preparada
            if (isset($stmt)) {
                $stmt->close();
            }
            $conexion->close();
        }
    }
    


// Función para obtener todos los usuarios
function obtenerUsuarios() {
    try {
        $conexion = crear_conexion();
        $conexion->select_db('tareas');

        // Verificar si ocurrió un error en la conexión
        if ($conexion->connect_error) {
            throw new Exception("Conexión fallida: " . $conexion->connect_error);
        }

        // Consulta SQL para obtener todos los usuarios
        $sql = "SELECT id, username FROM usuarios";
        $resultado = $conexion->query($sql);

        // Verificar si la consulta fue exitosa
        if ($resultado->num_rows > 0) {
            // Retornar los usuarios
            return $resultado->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return [];
    } finally {
        // Cerrar la conexión
        $conexion->close();
    }
}


?>