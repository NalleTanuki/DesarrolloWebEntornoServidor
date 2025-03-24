<?php
    require_once 'bd.php';
    /**Formulario de login habitual
     * si va bien -> abre sesion, guarda el nombre de usuario y redirige a principal.php
     * si va mal -> mensaje de error
     */
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usu = comprobar_usuario($_POST['usuario'], $_POST['clave']);

        if ($usu === false) {
            $err = true;
            $usuario = $_POST['usuario'];
        } else {
            session_start();

            // $usu tiene campos correo y conRes, correo
            $_SESSION['usuario'] = $usu;
            $_SESSION['carrito'] = [];
            header("Location: categorias.php");
            return;
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
        if (isset($_GET["redirigido"])) {
            echo "<p>Haga login para continuar.</p>";
        }
    ?>

    <?php
        if (isset($err) and $err == true) {
            echo "<p> Revise usuario y contraseña.</p>";
        }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <label for="usuario">Usuario: </label>
        <input value = "<?php if (isset($usuario)) echo $usuario; ?>" id="usuario" name="usuario" type="text" placeholder="restaurante@mail.com">

        <label for="clave">Clave: </label>
        <input id="clave" name="clave" type="password">
        
        <input type="submit">
    </form>
</body>
</html>