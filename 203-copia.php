<?php
    $var1 = 100; //La variable var1 vale 100
    $var2 = &$var1; //Asignacion por referencia
    $var3 = $var1; //Asignación por copia

    echo "Valor de la variable var2: $var2<br>"; //Mostrara 100

    $var2 = 300; //Cambia el valor de $var2

    echo "Valor de la variable var1 después de cambiar el valor de var2 a 300: $var1<br>"; //$var1 tambien cambia a 300

    $var3 = 400; //Este cambio no afecta a la $var1
    
    echo "Valor de var1 después de cambiar el valor de var3 a 400: $var1";
?>