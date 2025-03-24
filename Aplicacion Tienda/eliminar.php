<?php
    //Comprueba que el usuario haya abierto sesion o redirige
    require_once 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();

    $cod = $_POST['cod'];
    $unidades = $_POST['unidades'];

    //Si existe el codigo, restamos las unidades, con minimo de 0
    if (isset($_SESSION['carrito'][$cod])) {
        $unidadespedidas = $_SESSION['carrito'][$cod];
        $_SESSION['carrito'][$cod] -= $unidades;
        if ($_SESSION['carrito'][$cod] <= 0) {
            unset($_SESSION['carrito'][$cod]);
        }
        // ACtualizamos el stock del producto
        if ($unidades >= $unidadespedidas) {
            $unidades = $unidadespedidas;
        }
        eliminar_productocarrito($cod, $unidades);
    }
    header("Location: carrito.php");
?>