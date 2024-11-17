<?php
    /**Si va bien -> redirige a principal.php
     * Si va mal -> sale un mensaje de error
    */

    if($_POST['usuario'] === "alvaro" and $_POST["clave"] === "1234"){
        header("Location:304-bienvenido.html");
    } else {
        header ("Location:304-error.html");
    }
?>