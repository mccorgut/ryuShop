<?php include "./includes/header.php";
require_once "./config/db_operations.php";

$err = false;
$success_message = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $cat_id = $_POST["categoriaId"];
    $sub_cat_id = $_POST["subcategoriaId"];

    $directorio_subida = ".public/img/productsIMG/";
    $max_file_size = 5120000; // 5 megabytes
    $extensiones_validas = array("jpg", "png");

    if (isset($_FILES["imgProducto"])) {
        $errores = 0;
        $nombre_archivo = $_FILES["imgProducto"]["name"];
        $file_size = $_FILES["imgProducto"]["size"];
        $directorio_temporal = $_FILES["imgProducto"]["tmp_name"];
        $tipo_archivo = $_FILES["imgProducto"]["type"];

        $array_archivo = pathinfo($nombre_archivo);
        $extension = $array_archivo["extension"];

        // TODO Modificar para incluir todo esto en el mismo archivo de admin_products_form_add.php
        if (!in_array($extension, $extensiones_validas)) {
            echo "La extensión no es válida";
            exit; // Salir del script si la extensión no es válida
        }

        if ($file_size > $max_file_size) {
            echo "La imagen es demasiado grande. Debe ser de un máximo de 5 MB";
            exit; // Salir del script si la imagen es demasiado grande
        }

        // Si no hay errores se sube el archivo
        if ($errores == 0) {
            $ruta_completa = $directorio_subida . $nombre_archivo;
            // Mueve el archivo del directorio temporal al directorio de subida con el nombre del archivo
            move_uploaded_file($directorio_temporal, $ruta_completa);
        } else {
            echo "Error al mover el archivo al directorio de destino";
            exit; // Salir del script si hay un error al mover el archivo
        }
    }

    $product = insert_product($nombre, $descripcion, $precio, $ruta_completa, $stock, $cat_id, $sub_cat_id);

    if ($product == false) {
        $err = true;
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

            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" required>

            <label for="imgProducto">Imagen</label>
            <!-- accept="image/*" para que acepte solo archivos imagen -->
            <!-- accept="image/png, image/jpeg" para que acepte solo archivos de tipo png y jpeg -->
            <input type="file" name="imgProducto" id="imgProducto" accept="image/*" required>

            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" required>

            <label for="stock">Id de la categoria</label>
            <input type="number" name="categoriaId" id="categoriaId" required>

            <label for="stock">Id de la subcategoria</label>
            <input type="number" name="subcategoriaId" id="subcategoriaId" required>

            <button class="btn btn-register" type="submit">Añadir producto</button>
        </form>

        <?php if ($success_message) : ?>
            <p class="message success">Producto añadido correctamente!</p>
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