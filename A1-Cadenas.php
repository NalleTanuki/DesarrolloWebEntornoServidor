<?php
    /*
    Crear una aplicacion en PHP que mediante el uso de funciones determine si una cadena tiene un determinado
    caracter en la tercera y en la antepenultima posiciones.
     */

     //Funcion para verificar si una cadena tiene un caracter especifico en la tercera y antepenultima posiciones
     function verificarCaracter($cadena, $caracter){
        //Verificar si la cadena tiene al menos 3 letras
        if(strlen($cadena) < 3){
            echo "La cadena '$cadena' es demasiado corta para verificar las posiciones.<br>";
            return;
        }

        //Obtener el tercer caracter (indice 2) y el antepenultimo caracter
        $tercerCaracter = $cadena[2];
        $antepenultimoCaracter = $cadena[strlen($cadena) - 3];

        //Verificar si ambos caracteres coinciden con el caracter dado
        if ($tercerCaracter === $caracter && $antepenultimoCaracter === $caracter){
            echo "La cadena '$cadena' tiene el carácter '$caracter' en la tercera y antepenúltima posiciones.<br>";
        } else {
            echo "La cadena '$cadena' NO tiene el carácter '$caracter' en ambas posiciones.<br>";
        }
     }


     //EJEMPLOS DE USO:
     $cadena = "yo";
     $caracter = "e";
     verificarCaracter($cadena, $caracter);

     $cadena = "ejemplo";
     $caracter = "e";
     verificarCaracter($cadena, $caracter);

     $cadena = "ele";
     $caracter = "e";
     verificarCaracter($cadena, $caracter);
?>