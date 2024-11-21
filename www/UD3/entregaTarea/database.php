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
            //Preparar el select 
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
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Enlazar el parámetro como entero
        $stmt->execute();

        // Recuperar el resultado como un array asociativo
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Verificar si se encontró algún resultado
        if (count($resultados) > 0) {
            return [true, $resultados[0]]; // Devolver el primer resultado como array asociativo
        } else {
            return [false, 'No se encontró ningún usuario con ese ID'];
        }
    } catch (PDOException $e) {
        // En caso de error, devolver un mensaje
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

?>