<?php
    $i = 0;
    while($i < 5){
        echo "$i <br>";
        $i++; //Es lo mismo que $i = $i + 1;
        if($i == 3){
            break;
        }
    }
?>