<header>
    Usuario: <?php echo $_SESSION['usuario']['correo'] ?> <!-- Para mostrar el correo del usuario -->

    <?php
        if($_SESSION['usuario']['rol'] == 1) {
    ?>
    <b> <hr>
    <?php
        }
    ?>

    <a href="categorias.php">[HOME]</a>
    <a href="carrito.php">[Ver carrito]</a>

    <?php
        if ($_SESSION['usuario']['rol'] == 1) {
            ?> <a href="administracion.php" > [Administración] </a>
            <?php
        }
    ?>

    <a href="logout.php">[Cerrar sesión]</a>

    <?php
        if ($_SESSION['usuario']['rol'] == 1) {
    ?> 
    </b>
    <?php
        }
    ?>
</header>
<hr>