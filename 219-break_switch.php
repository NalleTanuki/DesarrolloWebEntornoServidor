<?php
    $i = 0;

    echo "Primer switch anidado: <br>";
    while($i < 2){
        switch ($i) {
            case 0:
                echo "Es un cero <br>";
                break;
            case 1:
                echo "Es un uno <br>";
                break;
        }
        $i++;
    }

    $i = 0;

    echo "Segundo switch anidado: <br>";
    while($i < 2){
        switch ($i) {
            case 0:
                echo "Es un cero <br>";
                break 2; //Rompe asi los 2 niveles de control de flujo
            case 1:
                echo "Es un uno <br>";
                break;
        }
        $i++;
    }
?>