<?php
    /**
     * Si va bien -> redirige a principal.php
     * Si va mal -> mensaje de error
     */

     if($_SERVER["REQUEST_METHOD"] === "POST"){
        if($_POST['usuario'] === "maria" and $_POST['clave'] === 1234){
            header("Location: principal.php");
        } else {
            $error = true;
        }
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de login</title>
</head>
<body>
    <?php
        if(isset($error)){
            echo "<p> Revise usuario y contraseña.</p>";
        }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="usuario">Usuario</label>
        <input value="<?php if(isset($usuario)) echo $usuario;?>" id="usuario" name="usuario" type="text">

        <label for="clave">Clave</label>
        <input id="clave" name="clave" type="password">

        <input type="submit">
    </form>
</body>
</html>