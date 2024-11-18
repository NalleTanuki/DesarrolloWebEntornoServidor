<?php
    $contenido = file_get_contents("320-fichero_ejemplo.txt");
    echo "Contenido del fichero: $contenido<br>";

    $res = file_put_contents("323-fichero_salida.txt", "Fichero creado con file_put_contents");

    if ($res) {
        echo "Fichero creado con éxito.";
    } else {
        echo "Error al crear el fichero.";
    }
?>