<?php
    // Comprueba que el usuario haya abiero sesion o redirige
    require 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();

    // Si el usuario NO es administrador -> lo redirigimos a categorias.php por seguridad
    if ($_SESSION['usuario']['rol'] <> 1) {
        header ("Location: categorias.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
</head>
<body>
    <?php
        require 'cabecera.php';
    ?>

    <h1>Panel de Administración</h1>

    <hr>

    <ul>
        <li><a href="restaurantes.php">[Gestionar Restaurantes]</a></li> <!-- gestion RESTAURANTES -->
        <li><a href="gcategorias.php">[Gestionar Categorías]</a></li>    <!-- gestion CATEGORIAS -->
        <li><a href="gproductos.php">[Gestionar Productos]</a></li>      <!-- gestion PRODUCTOS -->
        <li><a href="gpedidos.php">[Gestionar Pedidos]</a></li>      <!-- gestion PEDIDOS -->
    </ul>
</body>
</html>