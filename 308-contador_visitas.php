<?php
    /**Buscamos la cookie "visitas"
     * si NO existe -> se crea con valor 1
     * si SI existe -> se le suma 1
     * 
     * En los 2 casos se muestra un mensaje apropiado
     */

     if(!isset($_COOKIE['visitas'])){
        setcookie('visitas', '1', time() + 3600* 24);
        echo "Bienvenido por 1ª vez";
     } else {
        $visitas = (int) $_COOKIE['visitas'];

        $visitas++;
        setcookie('visitas', $visitas, time() + 3600 * 24);
        echo "Bienvenido por $visitas ª vez.";
     }
?>