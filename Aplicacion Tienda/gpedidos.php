<?php
    //Comprueba que el usuario haya abierto sesion o redirige
    require 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();

    //Manipulacion de envios
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['edit'])) {
            $codPed = $_POST['codped'];
            $enviado = $_POST['enviado'];
            editar_pedido($enviado, $codPed);
        } elseif (isset($_POST['delete'])) {
            $codPed = $_POST['codped'];
            eliminar_pedido($codPed);
        }
    }

    //Fetch all records
    $pedidos = cargar_gpedidos();
    // var_dump($pedidos); Comprobar un error
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Pedidos</title>
</head>
<body>
    <?php
        require 'cabecera.php';
    ?>

    <h1>Gestionar Pedidos</h1>

    <h2>Pedidos Registrados</h2>

    <table border="1">
        <thead>
            <tr>
                <th>CodPed</th>
                <th>Fecha</th>
                <th>Enviado</th>
                <th>Restaurante</th>
                <th>Productos</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($pedidos as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['CodPed']) ?></td>
                    <td><?= htmlspecialchars($row['Fecha']) ?></td>
                    <td><?= htmlspecialchars($row['Enviado']) ?>
                        <?php if ($row['Enviado'] == 0) {
                                echo " - No enviado";
                            } elseif ($row['Enviado'] == 1) {
                                echo " - Enviado";
                            } else {
                                echo "Indeterminado";
                            } ?>
                    </td>
                    <td><?= htmlspecialchars($row['Restaurante']) ?>
                        <?php $prestaurante = restaurante_pedido($row['Restaurante']); ?>
                        <?php echo " - $prestaurante[0]"; ?>
                    </td>
                    <td>
                        <?php $productosped = cargar_gproductospedido($row['CodPed']); ?>
                        <?php foreach ($productosped as $rowprod): ?>
                            Producto: <?= htmlspecialchars($rowprod[0]) ?> .
                                      <?= htmlspecialchars($rowprod[1]) ?> (<?= htmlspecialchars($rowprod[2]) ?>) - Unidades: 
                                      <?= htmlspecialchars($rowprod[3]) ?> <br>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="codped" value="<?php echo $row['CodPed']; ?>">
                            <button type="submit" name="delete">Eliminar</button>
                        </form>

                        <hr>

                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="codped" value="<?php echo $row['CodPed']; ?>">
                            <label for="enviado">Enviado: </label>
                            <select name="enviado" id="enviado" required>
                                <!-- NO ENVIADO -->
                                <option value="0" <?php if ($row['Enviado'] == 0) {
                                    echo "selected";
                                    } ?>>No enviado
                                </option>
                                <!-- ENVIADO -->
                                <option value="1" <?php if ($row['Enviado'] == 1) {
                                    echo "selected";
                                    } ?>>Enviado
                                </option>
                            </select> <br>
                            <button type="submit" name="edit">Actualizar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>