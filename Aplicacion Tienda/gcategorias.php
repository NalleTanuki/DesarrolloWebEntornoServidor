<?php
    /**Comprueba que el usuario haya abierto sesion o redirige */
    require 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();

    // Manipulacion de envios
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['add'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            insertar_categoria($nombre, $descripcion);
        } elseif (isset($_POST['edit'])) {
            $codCat = $_POST['codCat'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            editar_categoria($nombre, $descripcion, $codCat);
        } elseif (isset($_POST['delete'])) {
            $codCat = $_POST['codCat'];
            eliminar_categoria($codCat);
        }
    }

    // Fetch all records
    $categorias = cargar_gcategorias();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Categorías</title>
</head>
<body>
    <?php
        require 'cabecera.php';
    ?>
    <h1>Gestionar Categorías</h1>

    <h2>Añadir Categoría</h2>
    
    <form method = "POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="descripcion" placeholder="Descripción" required>

        <button type="submit" name="add">Añadir</button>
    </form>

    <h2>Categorías Registradas</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($categorias as $row){ ?>
                <tr>
                    <td><?php echo $row['CodCat']; ?></td>
                    <td><?php echo $row['Nombre']; ?></td>
                    <td><?php echo $row['Descripcion']; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="codCat" value="<?php echo $row['CodCat']; ?>">
                            <button type="submit" name="delete">Eliminar</button>
                        </form>

                        <hr>

                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="codCat" value="<?php echo $row['CodCat']; ?>">
                            
                            <label for="nombre">Nombre: </label>
                            <input type="text" name="nombre" value="<?php echo $row['Nombre']; ?>" required> <br>

                            <label for="descripcion">Descripción: </label>
                            <input type="text" name="descripcion" value="<?php echo $row['Descripcion']; ?>" required> <br>

                            <button type="submit" name="edit">Actualizar</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>