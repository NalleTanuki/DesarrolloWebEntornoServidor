<?php
    // Fichero que SI existe
    $fichero = fopen("320-fichero_ejemplo.txt", "r");

    if ($fichero === FALSE) {
        echo "No se encuentra el fichero: 320-fichero_ejemplo.txt<br>";
    } else {
        echo "320-fichero_ejemplo.txt se abrió con éxito.<br>";
    }

    // Fichero que NO existe
    $fichero = fopen("fichero_no_existe.txt", "r");
    
    if ($fichero === FALSE) {
        echo "No se encuentra el fichero: fichero_no_existe.txt<br>";
    } else {
        echo "El fichero: fichero_no_existe.txt se abrió con éxito.<br>";
    }
?>