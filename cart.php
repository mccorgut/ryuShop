<?php
ob_start();
include "./includes/header.php";
require_once "./config/db_operations.php";

// Verificar si se ha enviado una solicitud de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product"])) {
    // Verificar si se proporcionó un ID de producto válido
    if (isset($_POST["idCarrito"])) {
        $cart_id = $_POST["idCarrito"];
        delete_product_cart($cart_id);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product_unit"])) {
    // Verificar si se proporcionó un ID de producto válido
    if (isset($_POST["idCarrito"]) && isset($_POST["unidades"])) {
        $cart_id = $_POST["idCarrito"];
        $product_units = $_POST["unidades"];
        add_product_units($cart_id, $product_units);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product_unit"])) {
    // Verificar si se proporcionó un ID de producto válido
    if (isset($_POST["idCarrito"]) && isset($_POST["unidades"])) {
        $cart_id = $_POST["idCarrito"];
        $product_units = $_POST["unidades"];
        delete_product_units($cart_id, $product_units);
    }
}

// Verificar si se proporcionó un parámetro 'id' en la URL
if (isset($_SESSION["idUsuario"])) {
    // Este parametro lo obtengo desde admin_users    
    $user_id = $_SESSION["idUsuario"];
    $cart_data = load_cart_data($user_id);
} else {
    // Si no se proporciona 'id', puedes mostrar un mensaje de error o redirigir a otra página
    // Por ejemplo, redirige a la página de administración
    header("Location: index.php");
    exit(); // Asegura que el código se detenga después de redirigir
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
            <p>No hay productos en el carrito</p>
        </div>

    <?php
    }
    ?>
</article>

<?php include "./includes/sidenavIzq.php"; ?>
<?php include "./includes/sidenavDer.php"; ?>
<?php include "./includes/footer.php"; ?>