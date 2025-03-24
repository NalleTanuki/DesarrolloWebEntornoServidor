<?php
    // VALIDAR
    function leer_config ($nombre, $esquema) {
        $config = new DOMDocument();
        $config -> load($nombre);
        $res = $config -> schemaValidate($esquema);

        if ($res === FALSE) {
            throw new InvalidArgumentException("Revise el fichero de configuración.");
        }

        $datos = simplexml_load_file($nombre);
        $ip = $datos -> xpath("//ip");
        $nombre = $datos -> xpath("//nombre");
        $usu = $datos -> xpath("//usuario");
        $clave = $datos -> xpath("//clave");
        
        $cad = sprintf("mysql:dbname=%s;host=%s", $nombre[0], $ip[0]);

        $resul =   [];
        $resul[] = $cad;
        $resul[] = $usu[0];
        $resul[] = $clave[0];
        return $resul;
    }

    // CARGAR CATEGORIAS
    function cargar_categorias () {
        $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);
        
        $ins = "SELECT codCat, nombre FROM categorias";
        $resul = $bd -> query($ins);

        if (!$resul) {
            return FALSE;
        }

        if ($resul -> rowCount() === 0) {
            return FALSE;
        }
        //Si hay 1 o mas...
        return $resul;
    }

    // CARGAR CATEGORIA
    function cargar_categoria ($codCat) {
        $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $ins = "select nombre, descripcion from categorias where codcat = $codCat";
        $resul = $bd -> query($ins);

        if (!$resul) {
            return FALSE;
        }

        if ($resul -> rowCount() === 0) {
            return FALSE;
        }

        //Si hay 1 o mas...
        return $resul -> fetch();
    }

    // COMPROBAR USUARIO
    function comprobar_usuario ($nombre, $clave) {
        $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $ins = "select codRes, correo, clave, rol from restaurantes where correo = '$nombre'";
        $resul = $bd -> query($ins);

        if ($resul -> rowCount() === 1) {
            $row = $resul -> fetch(PDO::FETCH_ASSOC);
            //var_dump($row); //COMPROBACION PROPIA
            // Verificamos la contrasenha
            $claveCifrada = $row['clave'];
            // echo "$clave - $claveCifrada";
            if (password_verify($clave, $claveCifrada)) {
                // echo "Contraseña verificada.";
                $resul = $bd -> query($ins);
                return $resul -> fetch();
            } else {
                return FALSE;
            }
        }
    }

    // CARGAR PRODUCTOS DE CATEGORIA
    function cargar_productos_categoria ($codCat) {
        $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql = "select * from productos where codcat = $codCat";
        $resul = $bd -> query($sql);

        if (!$resul) {
            return FALSE;
        }

        if ($resul -> rowCount() === 0) {
            return FALSE;
        }
        //Si hay 1 o mas...
        return $resul;
    }

    /**Recibe un array de codigos de productos
     * devuelve un cursor con los datos de esos producgos
     */
    function cargar_productos ($codigosProductos) {
        if (empty($codigosProductos)) {
            return FALSE;  // Si el array esta vacio, devuelve FALSE
        }

        $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $texto_in = implode(",", $codigosProductos); //Mete una , en toda la lista de codigos para separar los elementos y asi luego que pueda buscarlo bien en la parte de abajo
        $ins = "select * from productos where codProd in ($texto_in)";

        //OJO: si no hay productos en el carro, debe mostrar el mensaje correspondiente
        try {
            $resul = $bd -> query($ins);
            return $resul -> fetchAll(PDO::FETCH_ASSOC); //Devolver array
        } catch (Exception $e) {
            return FALSE;
        }
        return $resul;
    }

    // INSERTAR PEDIDO
    function insertar_pedido ($carrito, $codRes) {
        $res = leer_config(dirname(__FILE__) . "/configuracion.xml", dirname(__FILE__) . "/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $bd -> beginTransaction();
        $hora = date("Y-m-d H:i:s", time());

        // Insertar el pedido
        $sql = "insert into pedidos(fecha, enviado, restaurante) values ('$hora', 0, $codRes)";
        $resul = $bd -> query($sql);

        if (!$resul) {
            return FALSE;
        }

        // Coger el ID del nuevo pedido para las filas detalle
        $pedido = $bd -> lastInsertId();
        // Insertar las filas en pedidoproductos
        foreach ($carrito as $codProd => $unidades) {
            $sql = "insert into pedidosproductos(codped, codprod, Unidades) values ($pedido, $codProd, $unidades)";
            $resul = $bd -> query($sql);

            if (!$resul) {
                $bd -> rollBack();
                return FALSE;
            }
        }
        $bd -> commit();
        return $pedido;
    }


    //     MODIFICACIONES


    // CIFRAR CLAVES
    function cifrar_claves () {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql01 = "select CodRes, Clave from restaurantes";
        $restaurantes = $bd -> query($sql01);

        // Ciframos cada clave y actualizamos
        foreach ($restaurantes as $restau) {
            $codRestaurante = $restau['CodRes'];
            $claveOriginal = $restau['Clave'];
            $claveCifrada = password_hash($claveOriginal, PASSWORD_BCRYPT);

            echo "Cifrada la clave: $claveOriginal como $claveCifrada - ";

            // Actualizamos la clave cifrada
            $sql02 = "update restaurantes set Clave = '$claveCifrada' where CodRes = $codRestaurante";
            try {
                $resul = $bd -> query($sql02);
            } catch (Exception $e) {
                return FALSE;
            }
        }
    }

    // COMPROBAR SI HAY STOCK SUFICIENTE AL ANHADIR UN PRODUCTO AL CARRITO
    function comprobar_stock ($CodProd, $unidades) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql = "select stock from productos where codprod = $CodProd";
        $resul = $bd -> query($sql);
        $row = $resul -> fetch(PDO::FETCH_ASSOC);
        $stock = $row['stock'];

        if ($unidades <= $stock) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // FUNCION PARA ACTUALIZAR EL STOCK AL ANHADIR UN PRODUCTO AL CARRITO
    function actualizar_stock ($CodProd, $unidades) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql = "select stock from productos where codprod = $CodProd";
        $resul = $bd -> query($sql);
        $row = $resul -> fetch(PDO::FETCH_ASSOC);
        $stock = $row['stock'];

        if ($unidades <= $stock) {
            // Actualizamos el stock
            $nuevoStock = $stock - $unidades;
            $sql2 = "update productos set stock = $nuevoStock where CodProd = $CodProd"; // Actualizamos al nuevo stock

            try {
                $resul = $bd -> query($sql2);
            } catch (Exception $e) {
                return FALSE;
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }


    // ===========================================================================================================================
    /** GESTION DE RESTAURANTES */
    // INSERTAR un restaurante
    function insertar_restaurante ($correo, $clave, $pais, $cp, $ciudad, $direccion, $rol) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        // Insertar el restaurante
        $sql = "insert into restaurantes(Correo, Clave, Pais, CP, Ciudad, Direccion, Rol)
                values ('$correo', '$clave', '$pais', $cp, '$ciudad', '$direccion', $rol)";

        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    // EDITAR un restuarante
    function editar_restaurante ($correo, $clave, $pais, $cp, $ciudad, $direccion, $rol, $codRes) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        // Editar el restaurante
        if ($clave) {
            $sql = "UPDATE restaurantes SET Correo = '$correo', Clave = '$clave', Pais = '$pais', CP = $cp, Ciudad = '$ciudad', Direccion = '$direccion', Rol = '$rol' WHERE CodRes = $codRes";
        } else {
            $sql = "UPDATE restaurantes SET Correo = '$correo', Pais = '$pais', CP = $cp, Ciudad = '$ciudad', Direccion = '$direccion', Rol = '$rol' WHERE CodRes = $codRes";
        }
        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    // ELIMINAR restaurante
    /**
     * Entrada: $codRes - Codigo de Restaurante
     */
    function eliminar_restaurante ($codRes) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        // Eliminar el restaurante
        $sql = "DELETE FROM restaurantes WHERE CodRes = $codRes";
        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    // CARGAR restaurantes
    function cargar_restaurantes () {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        // Cargar un restaurante
        $sql = "select * from restaurantes";
        $resul = $bd -> query($sql);

        if (!$resul) {
            return FALSE;
        }
        if ($resul -> rowCount() === 0) {
            return FALSE;
        }

        //Si hay 1 o mas...
        return $resul;
    }


    // ===========================================================================================================================
    /** GESTION DE CATEGORIAS */

    // INSERTAR una categoria
    function insertar_categoria ($nombre, $descripcion) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        try{
            // Verificar si la caegoria ya existe
            $sql_comprobacion = "SELECT COUNT(*) FROM categorias WHERE Nombre = ?";
            $comprobacion = $bd -> prepare($sql_comprobacion);
            $comprobacion -> execute([$nombre]);
            $existe = $comprobacion->fetchColumn();

            if ($existe) {
                echo "<p style='color: red;'>Error: La categoría '$nombre' ya existe.</p>";
                return false;
            }

            // Insertar la categoria
            $sql = "INSERT INTO categorias (Nombre, Descripcion) VALUES (?, ?)";
            $insert = $bd->prepare($sql);
            $insert->execute([$nombre, $descripcion]);

            echo "<p style='color: green;'> Categoría '$nombre' añadida correctamente.</p>";
            return true;
        } catch (Exception $e) {
            echo "<p style='color: red;' Error al insertar la categoría: " . $e->getMessage() . "</p>";
            return false;
        }
    }

    // EDITAR una categoria
    function editar_categoria ($nombre, $descripcion, $codCat) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        // Editar la categoria
        $sql = "UPDATE categorias SET Nombre = '$nombre', Descripcion = '$descripcion'
                WHERE CodCat = $codCat";
        
        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    // ELIMINAR una categoria
    function eliminar_categoria ($codCat) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        // Eliminar la categoria
        $sql = "DELETE FROM categorias WHERE CodCat = $codCat";

        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    // CARGAR categorias
    function cargar_gcategorias () {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql = "select * from categorias";
        $resul = $bd -> query($sql);

        if (!$resul) {
            return FALSE;
        }

        if ($resul -> rowCount() === 0) {
            return FALSE;
        }
        //Si hay 1 o mas...
        return $resul;
    }


    // ===========================================================================================================================
    /** GESTION DE PRODUCTOS */

    // INSERTAR un producto
    function insertar_producto ($nombre, $descripcion, $peso, $stock, $codcat) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        //Insertar el producto
        $sql = "INSERT INTO productos(Nombre, Descripcion, Peso, Stock, CodCat)
        values ('$nombre', '$descripcion', $peso, $stock, $codcat)";

        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    // Editar un producto
    function editar_producto ($nombre, $descripcion, $peso, $stock, $codcat, $codProd) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        //Editar el producto
        $sql = "UPDATE productos SET Nombre = '$nombre', Descripcion = '$descripcion', Peso = $peso, Stock = $stock, CodCat = $codcat
                WHERE CodProd = $codProd";
        try{
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    //Eliminar un producto
    function eliminar_producto ($codProd) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        //Eliminar el producto
        $sql = "DELETE FROM productos WHERE CodProd = $codProd";

        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    // Cargar gproductos
    function cargar_gproductos () {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        // Cargar los productos
        $sql = "SELECT * FROM productos";
        $resul = $bd -> query($sql);

        if (!$resul) {
            return FALSE;
        }

        if ($resul -> rowCount() === 0) {
            return FALSE;
        }

        //Si hay 1 o mas...
        return $resul;
    }

    // ===========================================================================================================================
    /** GESTION DE PEDIDOS */

    // EDITAR un pedido
    function editar_pedido ($enviado, $codPed) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        //Editar un pedido
        $sql = "UPDATE pedidos SET Enviado = $enviado WHERE CodPed = $codPed";
        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            return FALSE;
        }
    }

    // ELIMINAR un pedido
    function eliminar_pedido ($codPed) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);
        $bd -> beginTransaction();

        /** Primero eliminamos los registros correspondientes en la tabla pedidosproductos,
         * incrementando el stock correspondiente a cada producto en la tabla productos
         */
        $productosped = cargar_gpedidosproductos($codPed);
        foreach ($productosped as $productoped) {
            // Incrementamos el stock del producto en las unidades que se eliminan del pedido
            // Consultamos el stock del producto
            $CodProd = $productoped['CodProd'];
            $sql = "SELECT stock FROM productos WHERE codprod = $CodProd";

            try {
                $resul1 = $bd -> query($sql);
            } catch (Exception $e) {
                $bd -> rollback();
                return FALSE;
            };

            $row = $resul1 -> fetch(PDO::FETCH_ASSOC);
            $stock = $row['stock'];
            $unidades = $productoped['Unidades'];
            //Actualizamos el stock del producto
            $nuevoStock = $stock + $unidades;
            $act = "UPDATE productos SET stock = $nuevoStock WHERE CodProd = $CodProd";

            try {
                $resul2 = $bd -> query($act);
            } catch (Exception $e) {
                $bd -> rollback();
                return FALSE;
            }


            // Eliminamos el registro del produtco en pedidosproductos
            $del = "DELETE FROM pedidosproductos WHERE CodPed = $codPed AND CodProd = $CodProd";
            
            try {
                $resul = $bd -> query($del);
            } catch (Exception $e) {
                $bd -> rollback();
                return FALSE;
            }
        }
        //Eliminar un pedido
        $sql = "DELETE FROM pedidos WHERE CodPed = $codPed";
        try {
            $resul = $bd -> query($sql);
        } catch (Exception $e) {
            $bd -> rollBack();
            return FALSE;
        }
        $bd -> commit();
    }


    //CARGAR pedido
    function cargar_gpedidos () {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql = "SELECT * FROM pedidos";
        $resul = $bd -> query($sql);

        // ESTO ES UNA PRUEBA PARA CONOCER POSIBLE ERROR
        // var_dump($resul->fetchAll(PDO::FETCH_ASSOC));
        
        if (!$resul) {
            return FALSE;
        }
        if ($resul -> rowCount() === 0) {
            // return FALSE;
            return [];
        }

        $pedidos = $resul -> fetchAll(PDO::FETCH_ASSOC); // Convierto a array

        if (empty($pedidos)) {
            return [];  // Si no hay pedidos, devuelve array vacio
        }
    
        return $pedidos; // Devuele un array en lugar de PDOStatement
        //Si hay 1 o mas
        // return $resul;
    }

    // CARGAR pedidos productos
    function cargar_gpedidosproductos ($codPed) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql = "SELECT * FROM pedidosproductos WHERE CodPed = $codPed";
        $resul = $bd -> query($sql);

        if (!$resul) {
            return FALSE;
        }

        if ($resul -> rowCount() === 0) {
            return FALSE;
        }
        //Si hay 1 o mas
        return $resul;
    }

    //Devuelve el nombre (correo) del restaurante en vez del codigo
    function restaurante_pedido ($codRes) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql = "SELECT Correo FROM restaurantes WHERE CodRes = $codRes";
        $resul = $bd -> query($sql);

        if (!$resul) {
            return FALSE;
        }

        if ($resul -> rowCount() === 0) {
            return FALSE;
        }

        // So hau 1 o mas...
        return $resul -> fetch();
    }

    function cargar_gproductospedido ($codPed) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $sql = "SELECT a.CodProd, b.Nombre, b.Descripcion, a.Unidades FROM pedidosproductos a
                JOIN productos b ON b.CodProd = a.CodProd WHERE CodPed = $codPed";
        $resul = $bd -> query($sql);

        if (!$resul) {
            return FALSE;
        }

        if ($resul -> rowCount() === 0) {
            return FALSE;
        }
        // Si hay mas de 1 o mas
        return $resul;
    }

    //Eliminar cantidades de un producto del carrito
    function eliminar_productocarrito ($codProd, $unidades) {
        $res = leer_config(dirname(__FILE__)."/configuracion.xml", dirname(__FILE__)."/configuracion.xsd");
        $bd = new PDO($res[0], $res[1], $res[2]);

        $bd -> beginTransaction();

        // Incrementamos el stock del producto en las unidades que se eliminan del carrito
        // Consultamos el stock del producto
        $sql = "SELECT stock FROM productos WHERE codprod = $codProd";

        try {
            $resul1 = $bd -> query($sql);
        } catch (Exception $e) {
            $bd -> rollBack();
            return FALSE;
        };

        $row = $resul1 -> fetch(PDO::FETCH_ASSOC);
        $stock = $row['stock'];

        // Actualizamos el stock del producto
        $nuevoStock = $stock + $unidades;
        $act = "UPDATE productos SET stock = $nuevoStock WHERE CodProd = $codProd";

        try {
            $resul2 = $bd -> query($act);
        } catch (Exception $e) {
            $bd -> rollBack();
            return FALSE;
        }
        $bd -> commit();
    }

    // Funcion para eliminar el carrito y devolver el stock
    function vaciar_carrito ($carrito) {
        $productos = cargar_productos(array_keys($carrito));

        if ($productos === FALSE)  { //Si NO hay productos, salir sin mas
            return;
        }

        foreach ($productos as $producto) {
            $codProd = $producto['CodProd'];
            $unidades = $_SESSION['carrito'][$codProd];
            eliminar_productocarrito($codProd, $unidades);
        }
    }
?>