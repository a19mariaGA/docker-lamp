<?php


function conexión_PDO(){

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
        $conexion = conexión_PDO();

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
        $conexion = conexión_PDO();

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
        echo 'Los datos fueron insertados correctamente.<br>';

        // Cerrar el cursor para liberar recursos
        $stmt->closeCursor();

    } catch (PDOException $e) {
        // En caso de error, mostrar el mensaje de la excepción
        echo 'Error al insertar datos: ' . $e->getMessage() . '<br>';
        return null; // Devolvemos null en caso de error
    } finally {
        // Cerrar la conexión
        $conexion = null;
    }
}



$conexion = conexión_PDO();
select_usuarios();
nuevoUsuario($username, $nombre, $apellidos, $contrasena);
?>