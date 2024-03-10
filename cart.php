<?php
ob_start();
include "./includes/header.php";
require_once "./config/db_operations.php";

// Comprueba si se ha enviado una solicitud de eliminación de un producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product"])) {
    if (isset($_POST["idCarrito"])) {
        $cart_id = $_POST["idCarrito"];
        delete_product_cart($cart_id);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product_unit"])) {
    if (isset($_POST["idCarrito"]) && isset($_POST["unidades"])) {
        $cart_id = $_POST["idCarrito"];
        $product_units = $_POST["unidades"];
        add_product_units($cart_id, $product_units);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product_unit"])) {
    if (isset($_POST["idCarrito"]) && isset($_POST["unidades"])) {
        $cart_id = $_POST["idCarrito"];
        $product_units = $_POST["unidades"];
        delete_product_units($cart_id, $product_units);
    }
}

// Comprueba si existe la sesion de usuario
if (isset($_SESSION["idUsuario"])) {
    $user_id = $_SESSION["idUsuario"];
    // Llama a la funcion para mostrar la info del carrito
    $cart_data = load_cart_data($user_id);
} else {
    header("Location: index.php");
    exit();
}

ob_end_flush();
?>

<article class="main">
    <?php if (!empty($cart_data)) { ?>
        <div class="table-container">
            <table class="table cart-table">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Unidades</th>
                    <th>Modificar Unidades</th>
                    <th>Eliminar</th>
                </tr>
                <?php
                foreach ($cart_data["cart_data"] as $product) {
                ?>
                    <tr>
                        <td>
                            <?= $product["nombreProd"] ?>
                        </td>
                        <td>
                            <?= $product["precioProd"] ?>
                        </td>
                        <td>
                            <?= $product["unidades"] ?>
                        </td>
                        <td>
                            <div class="cart-form-container">
                                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                    <input type="hidden" name="idCarrito" value="<?= $product['idCarrito']; ?>">
                                    <input type="hidden" name="unidades" value="<?= $product['unidades']; ?>">
                                    <button class="btn-cart btn-add bx-border" type="submit" name="add_product_unit">
                                        <i class='bx bx-plus bx-sm'></i>
                                    </button>
                                </form>

                                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                    <input type="hidden" name="idCarrito" value="<?= $product['idCarrito']; ?>">
                                    <input type="hidden" name="unidades" value="<?= $product['unidades']; ?>">
                                    <button class="btn-cart btn-less bx-border" type="submit" name="delete_product_unit">
                                        <i class='bx bx-minus bx-sm'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <input type="hidden" name="idCarrito" value="<?= $product['idCarrito']; ?>">
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
                    <td colspan="4">
                        Precio total: <span class="total-amount"><?= $cart_data["precioTotal"] ?>€</span>
                    </td>
                    <td colspan="2">
                        <form action="process_order.php" method="POST">
                            <input type="hidden" name="idUsuario" value="<?= $user_id; ?>">
                            <button class="btn-pay" type="submit" name="process_order">Realizar Pedido</button>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    <?php
    } else {
    ?>
        <div>
            <p class="message error">No hay productos en el carrito</p>
        </div>

    <?php
    }
    ?>
</article>

<?php include "./includes/sidenavIzq.php"; ?>
<?php include "./includes/sidenavDer.php"; ?>
<?php include "./includes/footer.php"; ?>