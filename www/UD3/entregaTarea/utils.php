<?php

$tareas = [
        [
            'id' => 1,
            'descripcion' => 'Corregir tarea unidad 2 grupo A',
            'estado' => 'Pendiente'
        ],
        [
            'id' => 2,
            'descripcion' => 'Corregir tarea unidad 2 grupo A',
            'estado' => 'Pendiente'
        ],
        [
            'id' => 3,
            'descripcion' => 'Preparación unidad 3',
            'estado' => 'En proceso'
        ],
        [
            'id' => 4,
            'descripcion' => 'Publicar en github solución de la tarea unidad 2',
            'estado' => 'Completada'
        ]
    ];

function tareas()
{
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



function validarLargoCampo($data, $longitud)
{
    return (strlen(trim($data)) > $longitud);
}



function validarCampoTexto($data)
{
    return (!empty(test_input($data) && validarLargoCampo($data, 2)));
}




function esNumeroValido($data)
{
    return (!empty(test_input($data) && is_numeric($data)));
}


function esCampoValido($campo)
{
    return !empty(test_input($campo));
}




function guardar($id, $desc, $est)
{
    if (esCampoValido($id) && esCampoValido($est) && esCampoValido($est))
    {
        global $tareas;
        $data =[
            'id' => test_input($id),
            'descripcion' => test_input($desc),
            'estado' => test_input($est)
        ];
        array_push($tareas, $data);
        return true;
    }
    else
    {
        return false;
    }  
    
}




?>