<?php
    function manejadorErrores($errno, $str, $file, $line){
        echo "Ocurrió el error con número: $errno";
    }

    set_error_handler("manejadorErrores");
    $a = $b; //Causa error, $b no esta inicializada
?>