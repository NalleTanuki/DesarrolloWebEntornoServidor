<?php
    // Datos de conexion
    $cadena_conexion = "mysql:dbname=empresa; host=127.0.0.1";
    $usuario = 'root';
    $clave = "";

    try {
        // CONECTAR
        $bd = new PDO($cadena_conexion, $usuario, $clave);
        echo "Conexión realizada con éxito.<br>";

        // INSERTAR un nuevo usuario
        $insertar = "insert into usuarios(nombre, clave, rol) values ('Alberto', '33333', '1')";
        $resul = $bd->query($insertar);

        // Comprobar errores
        if ($resul) {
            echo "insert correcto<br>";
            echo "Filas insertadas: " . $resul->rowCount() . "<br>";
        } else print_r ($bd -> errorInfo());


        // Para los autoincrementos
        echo "Código de la fila insertada: " . $bd->lastInsert() . "<br>";


        // ACTUALIZAR
        $update = "update usuarios set rol = 0 where rol = 1";
        $resul = $bd->query($update);

        // Comprobar errores
        if ($resul) {
            echo "update correcto.<br>";
            echo "Filas actualizadas: " . $resul->rowCount() . "<br>";
        }


        // BORRAR
        $delete = "delete from usuarios where nombre = 'Luisa'";
        $resul = $bd->query($delete);
        // Comprobar errores
        if ($resul) {
            echo "delete correcto.<br>";
            echo "Filas borradas: " . $resul->rowCount() . "<br>";
        } else print_r ($bd->errorInfo());
    } catch (PDOException $e) {
        echo "Error con la base de datos: " . $e->getMessage();
    }
?>