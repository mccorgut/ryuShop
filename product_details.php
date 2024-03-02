<?php
// Start output buffering
ob_start();
include "./includes/header.php";
require_once "./config/db_operations.php";

// Definir una variable para el mensaje de error
$error_message = false;

$product_id = $_GET["productId"];
$product = load_product_data($product_id);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {
    // Verificar si el usuario ha iniciado sesión
    session_start();
    if (!isset($_SESSION['idUsuario'])) {
        $product_id = $_POST["productId"];
        // Si el usuario no ha iniciado sesión, muestra un mensaje de error
        $_SESSION["error_message"] = true;
        header("Location: product_details.php?productId=$product_id");
        exit();
    } else {
        $product_id = $_POST["productId"];
        $product_units = $_POST["productUnits"];
        $product_name = $_POST["productName"];
        $product_price = $_POST["productPrice"];

        $user_id = $_SESSION["idUsuario"];

        // Insertar el producto en el carrito
        insert_product_cart($product_id, $user_id, $product_name, $product_price, $product_units);

        // Redirigir a la página del carrito
        header("Location: cart.php");
        exit; // Terminar el script después de redirigir
    }
}

// Verificar si hay un mensaje de error almacenado en la variable de sesión
if (isset($_SESSION["error_message"]) && $_SESSION["error_message"] == true) {
    $error_message = true;
    // Elimina el mensaje de error de la variable de sesión para que no se muestre nuevamente después de la recarga de la página
    unset($_SESSION["error_message"]);
}

ob_end_flush();
?>

<article class="main">
    <div class="product-item-container">

        <div class="product-item">
            <img src="<?= $product["imgProducto"]; ?>" alt="Producto">
        </div>
        <div class="product-description">
            <h3>Descripcion</h3>
            <p><?= $product["descripcionProd"]; ?></p>
        </div>


        <hr>
        <div class="product-deatils">
            <dl>
                <dt>Fabricante</dt>
                <dd></dd>
                <dt>Dimensiones</dt>
                <dd></dd>
                <dt>Material</dt>
                <dd></dd>
            </dl>
        </div>
    </div>
</article>

<aside class="aside aside-2 aside-product">
    <div class="card productData">

        <h2><?= $product["nombreProd"]; ?></h2>
        <h4><?= $product["precioProd"]; ?>€</h4>
        <p>Unidades en stock <span class="stock"><?= $product["stock"]; ?></span></p>

        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input type="hidden" name="productId" value="<?= $product["idProducto"]; ?>">
            <input type="hidden" name="productName" value="<?= $product["nombreProd"]; ?>">
            <input type="hidden" name="productPrice" value="<?= $product["precioProd"]; ?>">
            <select name="productUnits" id="productUnits">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
            <button class="btn add-cart" type="submit" name="add_product">Añadir al carrito<i class='bx bxs-cart-add bx-sm'></i></button>
        </form>

        <!-- Mostrar mensaje de error si $err es true -->
        <?php if ($error_message) : ?>
            <p class="message error">No puedes añadir un producto al carrito a no ser que inicies sesion</p>
        <?php endif; ?>

    </div>
</aside>

<?php include "./includes/sidenavIzq.php"; ?>
<?php include "./includes/footer.php"; ?>