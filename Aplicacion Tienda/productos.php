<?php
    // Comprueba que el usuario haya abierto sesion o redirige
    require 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de productos por categoría</title>
</head>
<body>
    <?php
        require 'cabecera.php';
        $cat = cargar_categoria($_GET['categoria']);
        $productos = cargar_productos_categoria($_GET['categoria']);

        if ($cat === FALSE) {
            echo "<p class='error'>Error al conectar con la base de datos.</p>";
            exit;
        }

        if (isset($_GET['carrito']) && $_GET['carrito'] == 1) {
            echo "<h3>Se han añadido los productos al <a href=\"carrito.php\">carrito</a>.<br>Puede proseguir con su pedido.</h3><hr>";
        }

        if (isset($_GET['carrito']) && $_GET['carrito'] == 2) {
            echo "<h3>No se ha añadido el producto al carrito por no haber existencias suficientes.</h3>";
        }

        echo "<h1>" . $cat['nombre'] . "</h1>";
        echo "<p>" . $cat['descripcion'] . "</p>";

        //Si NO hay productos en la categoria, mostrara un mensaje 
        if ($productos === FALSE || empty($productos)) {
            echo "<p style='color:red'>No hay productos en esta categoría.</p>";
            exit;
        } else {
            echo "<table>"; //Abrir la tabla
            echo "<tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Peso</th>
                <th>Stock</th>
                <th>Comprar</th>
            </tr>";

            $hay_productos_disponibles = FALSE;

            foreach ($productos as $producto) {
                $cod = $producto['CodProd'];
                $nom = $producto['Nombre'];
                $des = $producto['Descripcion'];
                $peso = $producto['Peso'];
                $stock = $producto['Stock'];
                $categoria = $producto['CodCat'];

            if ($stock > 0) {
                $hay_productos_disponibles = TRUE; //SI hay productos disponibles
                echo "<tr>
                    <td>$nom</td>
                    <td>$des</td>
                    <td>$peso</td>
                    <td>$stock</td>
                    <td>
                        <form action='anhadir.php' method='POST'>
                            <input name='unidades' type='number' min='1' value='1'>
                            <input type='submit' value='Comprar'>
                            <input name='cod' type='hidden' value='$cod'>
                            <input name='categoria' type='hidden' value = '$categoria'>
                        </form>
                    </td>
                </tr>";
            }
        }
        echo "</table>";

        // Si después de recorrer los productos no hay stock, mostrar mensaje
    if (!$hay_productos_disponibles) {
        echo "<p style='color:red'>No hay productos disponibles en esta categoría.</p>";
    }
        }   
        /** LINEA 59
         * Enviamos tambien la categoria para que al anhadir un producto,
         * se vuelva a este fichero con la misma categoria --> */
    ?>
</body>
</html>