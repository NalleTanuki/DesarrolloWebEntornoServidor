<?php
    //session_start();   // Unirse a la sesion

    require_once 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();
    vaciar_carrito($_SESSION['carrito']);
    $_SESSION = array();

    session_destroy(); //Eliminar la sesion
    setcookie(session_name(), 123, time() - 1000); //Eliminar la cookie
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión cerrada</title>
</head>
<body>
    <p>La sesión se cerró correctamente, hasta la próxima.</p>
    <a href="login.php">Ir a la página de login.</a>
</body>
</html>