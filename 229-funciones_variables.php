<?php
    $var1 = 4;
    $var2 = NULL;
    $var3 = FALSE;
    $var4 = 0;

    echo "var 1 -> ";
    var_dump(isset($var1)); //TRUE
    var_dump(is_null($var1)); //FALSE
    var_dump(empty($var1)); //FALSE
    echo "<br>";

    echo "var 2 -> ";
    var_dump(isset($var2)); //FALSE, porque su valor es NULL
    var_dump(is_null($var2)); //TRUE
    var_dump(empty($var2)); //TRUE
    echo "<br>";

    echo "var 3 -> ";
    var_dump(isset($var3)); //TRUE
    var_dump(is_null($var3)); //FALSE
    var_dump(empty($var3)); //TRUE, porque su valor es FALSE
    echo "<br>";

    echo "var 4 -> ";
    var_dump(empty($var4)); //TRUE, el 0 como boolean es FALSE
    echo "<br>";
    
    echo "unset -> ";
    unset($var1); //Eliminamos la variable. Ya no cuenta como inicializada
    var_dump(isset($var1)); //FALSE
?>