<?php
require_once "./config/db_operations.php";
include "./includes/header.php";


// Verificar si se ha enviado una solicitud de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product"])) {
    // Verificar si se proporcionó un ID de producto válido
    if (isset($_POST["id"])) {
        $product_id = $_POST["id"];
        delete_product($product_id);
    }
}

$products = load_all_products_data();
?>

<article class="main">
    <!-- CRUD de los productos para el administrador -->
    <!-- Zona visible para todos los tipos de administradores -->
    <!-- CRUD de los usuarios registrados en la BD para el administrador -->
    <!-- Zona solo visible para los super administradores -->
    <section>
        <!-- Tabla que muestra los productos en la BD -->
        <div class="table-container">
            <table class="table cart-table">
                <tr>
                    <th>Id Producto</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Stock</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>

                <?php
                foreach ($products as $product) {
                ?>
                    <tr>
                        <td>
                            <?= $product["idProducto"] ?>
                        </td>
                        <td>
                            <?= $product["nombreProd"] ?>
                        </td>
                        <td>
                            <?= $product["descripcionProd"] ?>
                        </td>
                        <td>
                            <?= $product["precioProd"] ?> €
                        </td>
                        <td>
                            <img class="productImg" height="100px" src="<?= $product["imgProducto"] ?>" alt="Producto">
                        </td>
                        <td>
                            <?= $product["stock"] ?>
                        </td>
                        <td>
                            <button class="btn-cart btn-add bx-border">
                                <a href="admin_products_form_modify.php?id=<?= $product['idProducto']; ?>">
                                    <i class='bx bxs-edit bx-sm'></i>
                                </a>
                            </button>
                        </td>
                        <td>
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <input type="hidden" name="id" value="<?= $product['idProducto']; ?>">
                                <button class="btn-delete bx-border" type="submit" name="delete_product">
                                    <i class='bx bx-trash bx-sm'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>

                <tr>
                    <td colspan="11">
                        <form action="admin_products_form_add.php">
                            <label for="addProduct">Añadir producto</label>
                            <button name="addProduct" class="btn-product btn-add bx-border">
                                <i class='bx bx-plus bx-sm'></i>
                            </button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </section>

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