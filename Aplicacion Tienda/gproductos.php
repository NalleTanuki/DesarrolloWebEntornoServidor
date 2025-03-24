<?php
    /**Comprueba que el usuario haya abierto sesion o redirige */
    require 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();


    //Manipulacion de envios
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['add'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $peso = $_POST['peso'];
            $stock = $_POST['stock'];
            $codcat = $_POST['codcat'];
            insertar_producto($nombre, $descripcion, $peso, $stock, $codcat);
        } elseif (isset($_POST['edit'])) {
            $codProd = $_POST['codprod'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $peso = $_POST['peso'];
            $stock = $_POST['stock'];
            $codcat = $_POST['codcat'];
            editar_producto($nombre, $descripcion, $peso, $stock, $codcat, $codProd);
        } elseif (isset($_POST['delete'])) {
            $codProd = $_POST['codprod'];
            eliminar_producto($codProd);
        }
    }

    // Fetch all records
    $productos = cargar_gproductos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>
</head>
<body>
    <?php
        require 'cabecera.php';
    ?>

    <h1>Gestionar Productos</h1>

    <h2>Añadir Producto</h2>
    <form method="POST">
        <label>Nombre:
            <input type="text" name="nombre" required>
        </label>

        <br>

        <label>Descripción: 
            <input type="text" name="descripcion" requried>
        </label>

        <br>

        <label>Peso: 
            <input type="number" step="0.01" name="peso" required>
        </label>

        <br>

        <label>Stock: 
            <input type="number" name="stock" required>
        </label>

        <br>

        <label>Categoría: 
            <select name="codcat" required>
                <?php $categorias = cargar_gcategorias();
                foreach ($categorias as $categoria) { ?>
                 <option value="<?php echo $categoria['CodCat']; ?>">
                    <?php echo $categoria['Nombre']; ?>
                </option>
                <?php } ?>
            </select>
        </label> <br>
        <button type="submit" name="add">Añadir</button>
    </form>

    <h2>Productos Registrados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Peso</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php
            foreach ($productos as $row):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['CodProd'])?></td>
                <td><?= htmlspecialchars($row['Nombre'])?></td>
                <td><?= htmlspecialchars($row['Descripcion'])?></td>
                <td><?= htmlspecialchars($row['Peso'])?></td>
                <td><?= htmlspecialchars($row['Stock'])?></td>
                <td><?= htmlspecialchars($row['CodCat'])?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="codprod" value="<?= $row['CodProd'] ?>">
                        <button type="submit" name="delete">Eliminar</button>
                    </form>
                    
                    <hr>

                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="codprod" value="<?php echo $row['CodProd']; ?>">
                        <label>Nombre: <input type="text" name="nombre" value="<?php echo $row['Nombre']; ?>" required> </label> <br>
                        <label>Descripción: <input type="text" name="descripcion" value="<?php echo $row['Descripcion']; ?>" required> </label> <br>
                        <label>Peso: <input type="number" step="0.01" name="peso" value="<?php echo $row['Peso']; ?>" required> </label> <br>
                        <label>Stock: <input type="number" name="stock" value="<?php echo $row['Stock']; ?>" required> </label> <br>
                        <label>Categoría:
                            <select name="codcat" required>
                                <?php $categorias = cargar_gcategorias();
                                    foreach ($categorias as $categoria) {
                                ?>
                                    <option value="<?php echo $categoria['CodCat']; ?>"  <?php if ($row['CodCat'] == $categoria['CodCat']) {echo "selected";} ?>>
                                        <?php echo $categoria['Nombre']; ?>
                                    </option>
                                    <?php } ?>
                            </select>
                        </label> <br>
                        <button type="submit" name="edit">Actualizar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>