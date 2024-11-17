<!-- Como enviar un correo a traves del servidor de Google -->
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require "vendor/autoload.php";

    $mail = new PHPMailer();
    $mail->IsSMTP();

    // Cambiar a 0 apra no ver mensajes de error
    $mail -> SMTPDebug  =  2;
    $mail -> SMTPAuth   =  true;
    $mail -> SMTPSecure =  "tls";
    $mail -> Host       =  "smtp.gmail.com";
    $mail -> Port       =  587;

    // Introducir usuario de Google
    $mail -> Username = "";

    // Introducir clave
    $mail -> Password = "";
    $mail -> SetFrom('user@gmail.com', 'Test');

    // Asunto
    $mail -> Subject    =  "Correo de prueba";

    // Cuerpo
    $mail -> MsgHTML('Es una prueba.');

    // Adjuntos
    $mail -> addAttachment('empleado.xsd');

    // Destinatarios
    $address = "profe.dwes@gmail.com";
    $mail -> AddAddress($address, "Test");

    // Enviar
    $resul = $mail -> Send();

    if(!$resul){
        echo "Error " . $mail -> ErrorInfo;
    } else {
        echo "Correo enviado con éxito.";
    }
?>