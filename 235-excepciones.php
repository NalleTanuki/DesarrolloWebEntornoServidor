<?php
    function dividir($a, $b){
        if ($b == 0){
            throw new Exception ("El segundo argumento es 0");
        }
        return $a/$b;
    }

    try {
        $resultado1 = dividir(5, 0);
        echo "Resultado 1: $resultado1" . "<br>";
    } catch(Exception $e){
        echo "Excepción: " . $e->getMessage() . "<br>";
    } finally {
        echo "Primer finally <br>";
    }

    try {
        $resultado2 = dividir(5, 2);
        echo "Resultado 2: $resultado2" . "<br>";
    } catch(Exception $e){
        echo "Excepción: " . $e->getMessage() . "<br>";
    } finally {
        echo "Segundo finally";
    }
?>