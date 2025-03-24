<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require "vendor/autoload.php";

    function enviar_correos ($carrito, $pedido, $correo) {
        $cuerpo = crear_correo($carrito, $pedido, $correo);
        return enviar_correo_multiples("$correo, dwes@afleal.es", $cuerpo, "Pedido $pedido confirmado");
    }

   function crear_correo ($carrito, $pedido, $correo) {
    $texto = "<h1>Pedido n&uacute;mero $pedido </h1><h2>Restaurante: $correo </h2>";
    $texto .= "Detalle del pedido:";

    $productos = cargar_productos(array_keys($carrito));
    $texto .= "<table>"; // Abrir la tabla
    $texto .= "<tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Peso</th>
                <th>Unidades</th>
            </tr>";
    $pesoTotalPedido = 0.0;
    foreach ($productos as $producto) {
        $cod = $producto['CodProd'];
        $nom = $producto['Nombre'];
        $des = $producto['Descripcion'];
        $peso = $producto['Peso'];

        $unidades = $_SESSION['carrito'][$cod];
        $pesoTotalPedido = $pesoTotalPedido + $peso * $unidades;

        $texto .= "<tr>
                    <td>$nom</td>
                    <td>$des</td>
                    <td>$peso</td>
                    <td>$unidades</td>
                </tr>";
    }
    $texto .= "</table>";
    $texto .= "<hr><h3>Peso total del pedido: $pesoTotalPedido</h3>";
    return $texto;
   }


   function enviar_correo_multiples ($lista_correos, $cuerpo, $asunto = "Pedido realizado")  {
    $mail = new PHPMailer();
    $mail -> IsSMTP();
    $mail-> SMTPDebug   = 0; // Cambiar a 1 o 2 para ver errores
    $mail -> SMTPAuth   = true;
    $mail -> SMTPSecure = "tls";
    $mail -> Host       = "smtp.ionos.es";
    $mail -> Port       = 587;
    $mail -> Username   = "dwes@afleal.es"; // Usuario de ionos
    $mail -> Password   = "Ch1nd4sv1nt0."; // Contrasenha de ionos
    $mail -> SetFrom ('dwes@afleal.es', 'Sistema de pedidos');
    $mail -> Subject    = $asunto;
    $mail -> MsgHTML($cuerpo);
    $mail -> CharSet    = "UTF-8";

    //  Partir la lista de correos por la coma
    $correos = explode(",", $lista_correos);

    foreach ($correos as $correo) {
        $mail -> AddAddress ($correo, $correo);
    }

    if (!$mail -> Send()) {
        return $mail -> ErrorInfo;
    } else {
        return TRUE;
    }
   }
?>