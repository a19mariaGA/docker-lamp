<?php


function conexion_PDO(){

    $servername = "db";
    $username = "root";
    $password = "test";
    $dbname = "tareas";

    try {
        // creamos la conexión 
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // capturamos el error en caso de no poder crear la conexión 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn; // devolve a conexión 

    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
        return null; // Devolvemos null en caso de error
    }   
     finally
    {
        $conn = null;
    }
  

}

function select_usuarios(){

    try {
        $conexion = conexion_PDO();
        $conexion->exec("USE tareas");

        if ($conexion === null)
        {
            return [false, $conexion->error];
        }
        else
        {
            //creamos una consulta 
            $stmt = $conexion->prepare("SELECT id, username, nombre, apellidos, contrasena FROM usuarios");
            $stmt->execute();

            //Recuperamos el resultado y guardamos como array asociativo
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $resultados = $stmt->fetchAll();
            
            //Se recorre el array para recuperar cada fila
           /* foreach($resultados as $row) {
                echo $row["id"] . " - " . $row["username"] . $row["nombre"] . ' ' . $row["apellidos"] .$row["contrasena"] .   '<br>';
            }*/

             // Si se encontraron usuarios
             if ($resultados) {
                //devuelve true y los resultados encontrados
                 return [true, $resultados];
                } else {
                return [false, "No hay usuarios registrados"];
                }

        }
        
    }
    catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
        return null; // Devolvemos null en caso de error
    } 
    finally
    {
        //cerramos siempre la conexión
        $conn = null;
    }
    
}


function nuevoUsuario($username, $nombre, $apellidos, $contrasena)
{
    try {
        // Obtener la conexión a la base de datos
        $conexion = conexion_PDO();
        $conexion->exec("USE tareas");

        // Preparar la sentencia SQL
        $stmt = $conexion->prepare("INSERT INTO usuarios (username, nombre, apellidos, contrasena) VALUES (:username, :nombre, :apellidos, :contrasena)");

        // Vincular los parámetros a la consulta
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':contrasena', $contrasena);

        // Ejecutar la consulta
        $stmt->execute();

        // Confirmación de inserción exitosa
        return [true, 'Usuario guardado correctamente.'];

    } catch (PDOException $e) {
        // En caso de error, mostrar el mensaje de la excepción
        return [false, 'Error al insertar datos: ' . $e->getMessage()];
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}



function buscarUsuario($id) {
    try {
        // Obtener la conexión a la base de datos
        $conexion = conexion_PDO();
        $conexion->exec("USE tareas");

        // Preparar el SELECT con un parámetro preparado
        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id); 
        $stmt->execute();

        // Recuperar el resultado como un array asociativo
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si se encontró algún resultado
        if (count($resultados) > 0) {
            return [true, $resultados[0]]; // devuelve  true y el resultado obtenido
        } else {
            // devuelve false y un string con el mensaje
            return [false, 'No se encontró ningún usuario con ese ID'];
        }
    } catch (PDOException $e) {
        
        return [false, 'Error al consultar la base de datos: ' . $e->getMessage()];
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}



function actualizaUsuario($id,  $username, $nombre, $apellidos, $contrasena)
{ try {


    $conexion = conexion_PDO();
   

   // Establecer el modo de error a excepción
   $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   // Usar la base de datos
   $conexion->exec("USE tareas");

      // $sql = "UPDATE usuarios SET username = ?, nombre = ?, apellidos = ?,  contrasena = ? WHERE id = ?";
        $sql = "UPDATE usuarios SET username='$username',  nombre='$nombre' ,apellidos='$apellidos' ,contrasena='$contrasena' WHERE id=$id;";
        $stmt = $conexion->prepare($sql);
       $stmt->execute();
   
   /*

   // consulta preparada 
   $sql = "UPDATE usuarios SET username = :username, nombre = :nombre, apellidos = :apellidos, contrasena = :contrasena WHERE id = :id";
   $stmt = $conexion->prepare($sql);

   // Vincular los parámetros a la consulta preparada
   $stmt->bindParam(':username', $username);
   $stmt->bindParam(':nombre', $nombre);
   $stmt->bindParam(':apellidos', $apellidos);
   $stmt->bindParam(':contrasena', $contrasena);
   $stmt->bindParam(':id', $id, PDO::PARAM_INT);

   // Ejecutar la consulta
   $stmt->execute();

   */    

            // Si la ejecución es exitosa
   return [true, 'Usuario actualizado correctamente.'];
       
 
   
}
    catch (mysqli_sql_exception $e) {
        return [false, $e->getMessage()];
    }
    finally
    {
        $conexion = null;
    }
}



function borrarUsuario($id)
{
    try {
      
        $conexion = conexion_PDO();
        $conexion->exec("USE tareas");

        $sqlTareas = "DELETE FROM tareas WHERE id_usuario = :usuarioId";
        $stmtTareas = $conexion->prepare($sqlTareas);
        $stmtTareas->bindParam(':usuarioId', $id, PDO::PARAM_INT);
        $stmtTareas->execute();

        $sqlUsuarios = "DELETE FROM usuarios WHERE id = :usuarioId";
        $stmtUsuarios = $conexion->prepare($sqlUsuarios);
        $stmtUsuarios->bindParam(':usuarioId', $id, PDO::PARAM_INT);
        $stmtUsuarios->execute();

        
        return true;
    }
    catch (PDOException $e) {
        error_log("Error al borrar usuario: " . $e->getMessage());
        return false;
    }
    finally
    {
        $conexion = null;
    }
}


function buscarTareaUsername($username, $estado) {
    try {
        // Obtener la conexión a la base de datos
        $conexion = conexion_PDO();
        $conexion->exec("USE tareas");

        // Establecer el modo de error a excepción
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Buscamos tareas por username
        $sql = "SELECT t.id, t.titulo, t.descripcion, t.estado, u.username
                FROM tareas t
                JOIN usuarios u ON t.id_usuario = u.id
                WHERE u.username = :username";

        // Si 'estado' es proporcionado, agregar el filtro adicional
        if (!empty($estado)) {
            $sql .= " AND t.estado = :estado";
        }

        // Preparar la consulta
        $stmt = $conexion->prepare($sql);

        // Vincular los parámetros
        $stmt->bindParam(':username', $username);

        // Si 'estado' se proporciona, vincularlo también
        if (!empty($estado)) {
            $stmt->bindParam(':estado', $estado);
        }

        // Ejecutar la consulta
        $stmt->execute();

        // Recuperar el resultado como un array asociativo
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si se encontró algún resultado
        if ($resultados && count($resultados) > 0) {
            return [true, $resultados]; // Resultados encontrados
        } else {
            return [false, []]; // No hay resultados
        }
    } catch (PDOException $e) {
        // En caso de error, devolver un mensaje
        return [false, 'Error al consultar la base de datos: ' . $e->getMessage()];
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}


?>