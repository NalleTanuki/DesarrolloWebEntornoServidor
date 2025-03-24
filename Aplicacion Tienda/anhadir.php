<?php
    // Comprueba que el usuario haya abierto sesion o redirige
    require_once 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();

    $cod = $_POST['cod'];
    $unidades = (int)$_POST['unidades'];
    $categoria = $_POST['categoria'];

    // Realizamos las comprobaciones previas
    if (comprobar_stock($cod, $unidades)) {
         // Si existe el codigo, sumamos las unidades
        if (isset($_SESSION['carrito'][$cod])){
        // Incrementamos las unidades para ese codigo
        $_SESSION['carrito'][$cod] += $unidades;
        } else {
            // Si NO, pues lo creamos
            $_SESSION['carrito'][$cod] = $unidades;
        }
        
        actualizar_stock($cod, $unidades);
        
        /** Tras anhadir los productos al carrito,
        * redirigimos a la tabla de productos, en vez de al carrito
        */
        header ("Location: productos.php?categoria=$categoria&carrito=1");
    } else {
        // Indicamos que NO se anhadio al carrito por falta de stock
        header ("Location: productos.php?categoria=$categoria&carrito=2");
    }

   
   
?>