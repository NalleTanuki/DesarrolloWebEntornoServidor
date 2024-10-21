<?php
    /*Declaracion de variables*/
    $entero = 4; //Tipo integer
    $numero = 4.5; //Tipo coma flotante
    $cadena = "cadena"; //Tipo cadena de caracteres
    $bool = TRUE; //Tipo booleano

    /* Cambio de tipo de una variable */
    $a = 5; //La variable a es un entero con valor 5
    echo gettype($a); //Imprime el tipo de dato de a
    echo "<br>"; //Imprimo un salto de línea
    $a = "Hola"; //La variable a, cambia a cadena
    echo gettype($a); //Se comprueba que ha cambiado
?>