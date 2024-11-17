<!-- Creamos una sesion y, si NO existe ya, una variable de sesion
 $_SESSION['count'] con valor 0
 
 Si existe, le suma 1
 Muestra un vinculo a 309-sesiones_uso_basico2.php
 Este fichero, se una a la sesion y muestra el valor de la variable

 Si accedemos a ambos, comprobaremos que se trata de la misma variable
 -->
<?php
    session_start();

    if(!isset($_SESSION['count'])){
        $_SESSION['count'] = 0;
    } else {
        $_SESSION['count']++;
    }

    echo "Hola " . $_SESSION['count'];
    echo "<br><a href='309-sesiones_uso_basico2.php'>Siguiente</a>";
?>