<?php

include_once('nueva.php');

// Variable global para almacenar las tareas
$tareas = [];

function devolver_tareas() {
    global $tareas;
    return $tareas;
}

// Filtrar el contenido de un campo para que no contenga caracteres especiales, espacios en blanco duplicados, etc. 
// Recibe la variable y la devuelve filtrada.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Comprobar que un campo contiene información de texto válida, devolviendo true si se cumplen todos los requisitos o false si no es así. 
// Deberá filtrar con la función anterior previamente antes de comprobar si es válido.
function texto_valido($ID, $contenido, $estado) {

    $ID = test_input($ID);
    $contenido = test_input($contenido);
    $estado = test_input($estado);
    
    if (!is_numeric($ID)) {
        echo "El ID debe ser numérico.";
        return false; 
    }

    // Deberá hacer uso de la función de filtrado
    if (!is_string($contenido) || strlen($contenido) < 5) {
        echo "El contenido debe ser un texto con más de 5 caracteres.";
        return false; 
    }

    return [$ID, $contenido, $estado]; 
}

// Guardar una tarea de forma simulada (se añade al array)
function guardar_tarea($ID, $contenido, $estado) {
    global $tareas;

    // Validar los datos y obtener los valores filtrados
    $validacion = texto_valido($ID, $contenido, $estado);
    
    if ($validacion !== false) {
        // Crear un array clave-valor 
        $tareas[] = [
            'ID' => $validacion[0],      // Acceso correcto a los elementos del array
            'contenido' => $validacion[1],
            'estado' => $validacion[2]
        ];
        return $tareas; // Tarea guardada con éxito
    }

    return false; // Fallo en la validación
}


?>