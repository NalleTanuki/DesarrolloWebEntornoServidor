<?php
    $tamanho = $_FILES["fichero"]["size"];
    if($tamanho > 256*1024){
        echo "<br>Demasiado grande.";
        return;
    }

    echo "Nombre del fichero: " . $_FILES["fichero"]["tmp_name"];
    $resultado = move_uploaded_file($_FILES["fichero"]["tmp_name"], "subidos/" . $_FILES["fichero"]["name"]);
    if($resultado){
        echo "<br>Fichero guardado.";
    } else {
        echo "<br>Error.";
    }
?>