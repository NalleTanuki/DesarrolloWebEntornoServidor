<?php
    function calculador($operacion, $num_a, $num_b){
        $resultado = $operacion($num_a, $num_b);
        return $resultado;
    }

    function sumar($a, $b){
        return $a + $b;
    }

    function multiplicar($a, $b){
        return $a * $b;
    }

    $a = 4;
    $b = 5;

    $r1 = calculador("multiplicar", $a, $b);
    echo "$r1 <br>";

    $r2 = calculador("sumar", $a, $b);
    echo "$r2";
?>