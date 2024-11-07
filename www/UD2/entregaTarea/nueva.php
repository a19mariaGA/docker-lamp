<?php

include_once('utils.php');

// Definir variables y establecer valores vacíos
$ID = $contenido = $estado = "";

// Inicializamos un array para almacenar los errores
$errores = [];


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST["ID"])) {
        $errores[] = "Es obligatorio indicar el ID";
    } else {
        $ID = test_input($_POST["ID"]);
    }

    if (empty($_POST["contenido"])) {
        $errores[] = "Es obligatorio añadir contenido";
    } else {
        $contenido = test_input($_POST["contenido"]);
    }

    if (empty($_POST["estado"])) {
        $errores[] = "Es obligatorio añadir el estado";
    } else {
        $estado = test_input($_POST["estado"]);
    }

// Inicializamos un array para almacenar las tareas
global $tareas;
$tareas = []; // Esto debe estar fuera de la condición para asegurar que $tareas esté inicializado siempre

if (count($errores) === 0) {
    // Si no hay errores, guardamos la tarea
    $resultado = guardar_tarea($ID, $contenido, $estado);

    if ($resultado) {

        foreach ($tareas as $tarea) {
            echo "<li>ID: " . $tarea['ID'] . ", Contenido: " . $tarea['contenido'] . ", Estado: " . $tarea['estado'] . "</li>";
        }
    } else {
        echo "No se pudo guardar la tarea.</br>";
    }
} else {
    foreach ($errores as $error) {
        echo "Revise los datos introducidos, alguno no está correcto.</br>";
        echo "<li>" . $error . "</li>";
    }
}

}

include 'menu.php';


?>
