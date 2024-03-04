<?php include "./includes/header.php";
require_once "./config/db_operations.php";

$error_message = false;
$success_message = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $cat_id = $_POST["categoriaId"];
    $sub_cat_id = $_POST["subcategoriaId"];

    $directorio_subida = "public/img/productsIMG/";
    $max_file_size = 5120000; // 5 megabytes
    $extensiones_validas = array("jpg", "png");

    if (isset($_FILES["imgProducto"])) {
        $nombre_archivo = $_FILES["imgProducto"]["name"];
        $directorio_temporal = $_FILES["imgProducto"]["tmp_name"];
        //$tipo_archivo = $_FILES["imgProducto"]["type"];

        $array_archivo = pathinfo($nombre_archivo);
        $extension = strtolower($array_archivo["extension"]);

        // TODO Modificar para incluir todo esto en el mismo archivo de admin_products_form_add.php
        if (!in_array($extension, $extensiones_validas)) {
            echo "La extensión no es válida";
            exit; // Salir del script si la extensión no es válida
        }

        $file_size = $_FILES["imgProducto"]["size"];
        if ($file_size > $max_file_size) {
            echo "La imagen es demasiado grande. Debe ser de un máximo de 5 MB";
            exit; // Salir del script si la imagen es demasiado grande
        }

        // Generamos un nombre único para el archivo
        $nombre_archivo_final = uniqid() . "." . $extension;

        // Movemos el archivo al directorio de destino
        if (move_uploaded_file($directorio_temporal, $directorio_subida . $nombre_archivo_final)) {
            $ruta_completa = $directorio_subida . $nombre_archivo_final;
        } else {
            echo "Error al mover el archivo al directorio de destino";
            exit; // Salir del script si hay un error al mover el archivo
        }
    }

    $product = insert_product($nombre, $descripcion, $precio, $ruta_completa, $stock, $cat_id, $sub_cat_id);

    if ($product == false) {
        $error_message = true;
    } else {
        $success_message = true;
    }
}

?>

<article class="main">
    <div class="form-container form-admin">
        <h2>Añadir producto</h2>
        <hr>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" class="register-form form">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" id="descripcion" rows="3"></textarea>

            <!-- step="0.01" para poder añadir decimales -->
            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" placeholder="1.00" step="0.01" required>

            <label for="imgProducto">Imagen</label>
            <!-- accept="image/*" para que acepte solo archivos imagen -->
            <!-- accept="image/png, image/jpeg" para que acepte solo archivos de tipo png y jpeg -->
            <input type="file" name="imgProducto" id="imgProducto" accept="image/*" required>

            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" required>

            <label for="categoriaId">Id de la categoria</label>
            <input type="number" name="categoriaId" id="categoriaId" required>

            <label for="subcategoriaId">Id de la subcategoria</label>
            <input type="number" name="subcategoriaId" id="subcategoriaId" required>

            <button class="btn btn-register" type="submit">Añadir producto</button>
        </form>

        <?php if ($success_message) : ?>
            <p class="message success">Producto añadido correctamente!</p>
        <?php endif; ?>


        <?php if ($error_message) : ?>
            <p class="message error">Problema con el registro del producto!</p>
        <?php endif; ?>
    </div>


    <!-- TODO añadir un enlace para volver a la tabla de usuarios -->
    <section class="return-admin-zone">
        <hr>
        <p>Volver al area de administracion</p>
        <form action="admin_zone.php" class="return-admin-form form">
            <button class="btn-return" type="submit">Volver</button>
        </form>
    </section>
</article>

</body>

</html>