<?php

function crear_conexion(){
    // 1. Crear la conexión
    $conexion = new mysqli('db', 'root', 'test');

    // 2. Comprobar la conexión
    if ($conexion->connect_errno) {
        die('Fallo en la conexión: ' . $conexion->connect_error . ', con número ' . $conexion->connect_errno . '.<br>');
    }
    

    return $conexion;  // Devuelve la conexión para usarla en otras funciones
}



function crear_bbdd()
{
    try {
        //abrimos la conexión
        $conexion = crear_conexion(); 
        
        //si hay algún error devuelve ese error
        if ($conexion->connect_error)
        {
            return [false, $conexion->error];
        }
        else
        {
            // comprobamos si la bbdd existe
            $sqlCheck = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'tareas'";
            // el resultado se guarda en $resultado
            $resultado = $conexion->query($sqlCheck);

            //si en resultado hay algun valor devuelve un array de booleanos
            if ($resultado && $resultado->num_rows > 0) {
                return [false, 'La base de datos "tareas" ya existe.'];
            }

            // creamos la bbdd si no existe, no se devuelven resultados solo true or false
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
                        // Cerramos la conexión 
                if (isset($conexion) && $conexion->connect_errno === 0) {
                    $conexion->close();       
                }
            }
}


    
function tabla_usuarios() {

    try {
        //creamos la conexion y seleccionamos la bbdd que ya está creada
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

    //funcion que lista todas las tareas creadas
    function select_tarea() {
        try {
            // Crear la conexión a la base de datos
            $conexion = crear_conexion();
            $conexion->select_db('tareas');
            
            // Consulta para obtener las tareas con el nombre del usuario
            $sql = "SELECT t.id, t.titulo, t.descripcion, t.estado, u.username
                    FROM tareas t
                    JOIN usuarios u ON t.id_usuario = u.id";
            
            // Ejecutar la consulta
            $resultado = $conexion->query($sql);
            
            // Verificar si la consulta fue exitosa y si hay filas
            if ($resultado && $resultado->num_rows > 0) {
                // Devolver el estado true y los resultados como un array asociativo
                return [true, $resultado->fetch_all(MYSQLI_ASSOC)];  // esta funcion devuelve un array con resultados
            } else {
                // Si no hay resultados, devolver estado false y un array vacío
                return [true, []];
            }
        } catch (mysqli_sql_exception $e) {
            // Manejo de excepciones y retorno de estado false con el error
            return [false, 'Error al consultar las tareas: ' . $e->getMessage()];
        } finally {
            // Cerrar la conexión
            $conexion->close();
        }
    }
    

    
    function select_tarea_id($id) {
        try {
            // Crear la conexión a la base de datos
            $conexion = crear_conexion();
            $conexion->select_db('tareas');
            
            // Verificar si ocurrió un error en la conexión
            if ($conexion->connect_error) {
                throw new Exception("Conexión fallida: " . $conexion->connect_error);
            }
            
            // Consulta para obtener la tarea específica con el nombre del usuario
            $sql = "SELECT t.id, t.descripcion, t.estado, t.titulo, u.username, t.id_usuario
                    FROM tareas t
                    JOIN usuarios u ON t.id_usuario = u.id
                    WHERE t.id = ?";
            
            // Preparar la consulta
            $stmt = $conexion->prepare($sql);
            
            // Verificar si hubo un error al preparar la consulta
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $conexion->error);
            }
            
            // Enlazar el parámetro $id
            $stmt->bind_param("i", $id);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener los resultados
            $resultado = $stmt->get_result();
            
            // Verificar si la consulta fue exitosa y si hay resultados
            if ($resultado && $resultado->num_rows > 0) {
                // Devolver los resultados como un array asociativo
                return $resultado->fetch_assoc(); // Esto devuelve solo un registro
            } else {
                // Si no hay resultados, devolver un array vacío
                return [];
            }
            
        } catch (Exception $e) {
            // Manejo de excepciones y retorno del error
            return [false, $e->getMessage()];
        } finally {
            // Cerrar la consulta y la conexión
            if (isset($stmt)) {
                $stmt->close();
            }
            if (isset($conexion)) {
                $conexion->close();
            }
        }
    }
    
    


// Función para obtener todos los usuarios, lo voy a utilizar para crear una tarea y asociarla a un usuario 
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


function actualizaTarea($id, $titulo, $desc, $estado, $id_usuario) {
    try {
        // Crear la conexión
        $conexion = crear_conexion();
        $conexion->select_db('tareas');

        // Verificar si ocurrió un error en la conexión
        if ($conexion->connect_error) {
            throw new Exception("Conexión fallida: " . $conexion->connect_error);
        }

        // Preparar la consulta SQL (evitar usar 'desc' directamente)
        $sql = "UPDATE tareas SET titulo = ?, descripcion = ?, estado = ?, id_usuario = ? WHERE id = ?";
        
        // Preparar la consulta
        $stmt = $conexion->prepare($sql);
        
        // Verificar si hubo un error al preparar la consulta
        if ($stmt === false) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }
        
        // Enlazar los parámetros
        $stmt->bind_param("sssii", $titulo, $desc, $estado, $id_usuario, $id); // Corregimos los parámetros

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si la consulta fue exitosa
        if ($stmt->affected_rows > 0) {
            return [true, "Tarea editada correctamente."];
        } else {
            return [false, "No se pudo editar ninguna tarea. Asegúrese de que la tarea existe."];
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




function borrarTarea($id)
{
    try {
        // Crear la conexión
        $conexion = crear_conexion(); 
        $conexion->select_db('tareas'); 

        // Verificar si ocurrió un error en la conexión
        if ($conexion->connect_error) {
            throw new Exception("Conexión fallida: " . $conexion->connect_error);
        }

        // Consulta SQL para borrar la tarea
        $sql = "DELETE FROM tareas WHERE id = ?";
        
        // Preparamos la consulta
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id); // "i" indica que el parámetro $id es de tipo entero

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si la consulta fue exitosa
        if ($stmt->affected_rows > 0) {
            return [true, "Tarea borrada correctamente."];
        } else {
            return [false, "No se pudo borrar la tarea. Asegúrese de que la tarea existe."];
        }
    }
    catch (Exception $e) {
        return [false, "Error: " . $e->getMessage()];
    }
    finally {
        // Cerrar la conexión y el statement si están definidos
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conexion)) {
            $conexion->close();
        }
    }
}



?>