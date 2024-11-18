<?php
    $fich = fopen('320-fichero_ejemplo.txt', 'r');

    if ($fich === FALSE) {
        echo "Error. No se encuentra el fichero o no se pudo leer.<br>";
    } else {
        while (!feof($fich)) {
            $caracter = fgetc($fich);
            echo $caracter;
        }
    }
    fclose($fich);
?>