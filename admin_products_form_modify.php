<?php
include "./includes/header.php";
require_once "./config/db_operations.php";

$modify_product = $_GET["id"];

$product = load_product_data($modify_product);

// echo $product['idProducto']
?>

<article class="main">
    <!-- TODO mirar que le pasa al css -->
    <div class="form-container form-admin">
        <h2>Modificar datos del producto</h2>
        <hr>
        <form action="admin_modify_product.php?modifiedProdId=<?= $modify_product; ?>&nombre_imagen=<?= htmlspecialchars($product['imgProducto']); ?>" method="POST" enctype="multipart/form-data" class="register-form form">
            <label for="productId">Id de Producto</label>
            <input type="number" name="productId" id="productId" value="<?= htmlspecialchars($product['idProducto']); ?>">

            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($product['nombreProd']); ?>">

            <label for="descripcion">Descripcion</label>
            <textarea name="descripcion" id="descripcion" rows="3"><?= htmlspecialchars($product['descripcionProd']); ?></textarea>

            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" value="<?= htmlspecialchars($product['precioProd']); ?>">

            <label for="imgProducto">Imagen</label>
            <div class="img-container">
                <img alt="<?= htmlspecialchars($product['nombreProd']); ?>" src="<?= htmlspecialchars($product['imgProducto']); ?>">
            </div>

            <label for="imgProducto">Modificar imagen</label>
            <input type="file" name="imgProducto" id="imgProducto" accept="image/*">

            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" value="<?= htmlspecialchars($product['stock']); ?>">

            <button class="btn btn-register" type="submit">Modificar</button>
        </form>
    </div>


    <!-- TODO añadir un enlace para volver a la tabla de usuarios -->
    <section class="return-admin-zone">
        <hr>
        <p>Volver a la tabla de productos</p>
        <form action="admin_products.php" class="return-admin-form form">
            <button class="btn-return" type="submit"><i class='bx bxs-package'></i>Volver</button>
        </form>
        <p>Volver al area de administracion</p>
        <form action="admin_zone.php" class="return-admin-form form">
            <button class="btn-return" type="submit">Volver</button>
        </form>
    </section>
</article>

</body>

</html>