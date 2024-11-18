<?php
    $bbdd = "dwes";
    $cadena_conexion = "mysql:dbname=$bbdd; host=127.0.0.1";
    $usuario = 'usr_dwes';
    $clave = "Abc.123";

    try {
        $bd = new PDO($cadena_conexion, $usuario, $clave);
        echo "Conexión exitosa a la BBDD: " . $bbdd;
    } catch (PDOException $e) {
        echo "Error con la base de datos: " . $e->getMessage();
    }
?>