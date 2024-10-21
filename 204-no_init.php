<?php
    $var1 = 100;
    $var3 = 100 + $var2; //$var2 no existe, así que se toma como 0
    echo "$var3 <br>";  //Mostrara 100, porque hara 100 + 0

    $var3 = 100 * $var2; //$var2 no existe, asi que se toma como 0
    echo "$var3 <br>"; //Mostrara 0, porque hace 100 x 0
?>