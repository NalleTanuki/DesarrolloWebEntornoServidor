<?php
    /**
     * Formulario de login habitual:
     * 
     * Si va bien -> abre sesion, guarda el nombre de usuario y redirige a principal.php
     * Si va mal -> mensaje de error.
     * 
     * Admite 2 usuarios: "usuario" y "admin", ambos con clave "1234"
     */

     function comprobar_usuario($nombre, $clave){
        if($nombre === "usuario" and $clave === "1234"){
            $usu['nombre'] = "usuario";
            $usu['rol'] = 0;
            return $usu;
        } elseif ($nombre === "admin" and $clave === "1234"){
            $usu['nombre'] = "admin";
            $usu['rol'] = 1;
            return $usu;
        } else return false;
     }

     if($_SERVER["REQUEST_METHOD"] == "POST"){
        $usu = comprobar_usuario($_POST['usuario'], $_POST['clave']);
        if($usu == false){
            $error = true;
            $usuario = $_POST['usuario'];
        } else {
            session_start();
            $_SESSION['usuario'] = $_POST['usuario'];
            header("Location: 310-sesiones1_principal.php");
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
        if(isset($_GET['redirigido'])){
            echo "<p>Haga login para continuar.</p>";
        }
    ?>

    <?php
        if(isset($error) and $error == true){
            echo "<p>Revise usuario y contraseña.</p>";
        }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        Usuario
        <input value="<?php if(isset($usuario))echo $usuario;?>"
        id="usuario" name="usuario" type="text">
        Clave
        <input type="password" id="clave" name="clave">
        <input type="submit">
    </form>
</body>
</html>