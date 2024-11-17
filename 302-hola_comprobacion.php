<?php
    echo "- Probamos empty.<br>";
    if(empty($_GET["nombre"])){
        echo "Error, falta el parámetro nombre <br>";
    } else {
        echo "Hola " . $_GET["nombre"] . "<br>";
    }
    echo "- Probamos is_null.<br>";
    if(is_null($_GET["nombre"])){
        echo "Verdadero <br>";
    } else {
        echo "Falso <br>";
    }
?>