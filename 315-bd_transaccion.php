<?php
    $cadena_conexion = 'mysql:dbname=empresa; host=127.0.0.1';
    $usuario = 'root';
    $clave = '';

    try {
        $bd = new PDO($cadena_conexion, $usuario, $clave);
        echo "Conexión realizada con éxito.<br>";

        // Comenzar la transaccion
        $bd -> beginTransaction();
        $ins = "insert into usuarios(nombre, clave, rol) values ('Fernando', '33333', '1')";
        $resul = $bd->query($ins);

        /**  Se repite la consulta
         * falla porque el nombre es unique
        */
        $resul = $bd->query($ins);
        if (!$resul) {
            echo "Error: " . print_r($bd->errorInfo());
            // Deshace el primer cambio
            $bd->rollBack();
            echo "<br>Transacción anulada.<br>";
        } else {
            // Si hubiera ido bien, entonces...
            $bd->commit();
        }
    } catch (PDOException $e) {
        echo "Error al conectar: " . $e->getMessage();
    }
?>