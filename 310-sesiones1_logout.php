<?php
    // Inicializar la sesion
    session_start(); //Unirse a la sesion

    // Destruir todas las variables de sesion
    $_SESSION = array();
    session_destroy(); //Eliminar la sesion
    setcookie(session_name(), 123, time() - 1000); //Eliminar la cookie
    header("Location: 310-sesiones1_login.php");
?>