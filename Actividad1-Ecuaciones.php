<?php
    /*Crear una aplicacion desarrollada en PHP que mediante el uso de funciones permita
    evaluar la expresión 4/x.
    Si la ecuacion no tiene soluciones reales, se mostrara un mensaje de error.
    
    Para crear una aplicacion en PHP que evalue la expresion 4/x y muestre un mensaje de error si
    no tiene soluciones reales, podemos proceder de la siguiente manera:
    
    1. La ecuación 4/x no tiene soluciones reales cuando x=0 ya que no se puede dividir entre cero.
    2. Si x no es igual a 0, podemos calcular el valor de la expresión 4/x.
    3. Si x=0, debemso mostrar un mensaje de error.
    */

    //Funcion para evaluar la ecuacion 4/x
    function evaluarEcuacion($x){
        //Verificar si x es 0, no se puede dividir entre 0
        if($x == 0){
            throw new Exception('La ecuación 4/x no tiene soluciones reales cuando x=0, ya que no se puede dividir entre cero.');
        } else {
            //Calcular el valor de la ecuacion 4/x
            return 4/$x;
        }
    }

    //Ejemplo de uso:
    for($x = -5; $x < 6; $x++){
        try{
            $resultado = evaluarEcuacion($x);
            echo "El resultado de evaluar la expresión 4/$x es: $resultado<br>";
        } catch(Exception $e){
            echo "Excepción: " . $e->getMessage() . "<br>";
        }
    }
?>