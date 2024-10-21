<?php
    echo PHP_INT_SIZE.'<br>';
    echo PHP_INT_MIN.'<br>';
    echo PHP_INT_MAX.'<br>';

    // Acepta:
    $a = 0b100; //Octal
    $a = 0100; //Binario
    $a = 0x100; //Hexadecimal

    $a = 3/2; //La division entre enteros no da problemas
    echo $a.'<br>'; //Nos dara 1.5; el resultado de la division superior

    $b = 7.5;
    $a = (int) $b; //Casting a int, le obligo a que sea un entero
    echo $a.'<br>'; //Saldra un 7, se trunca

    // Tambien acepta
    $b = 7e2; //Notación científica
    $b = 7E2;
?>