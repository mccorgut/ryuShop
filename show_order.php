<?php
//session_start();
include "./includes/header.php";
require_once "./config/db_operations.php";
require_once "./config/email.php";

if (isset($_SESSION["idUsuario"])) {
    $user_id = $_SESSION["idUsuario"];
    $last_order_data = load_last_order_data($user_id);

    echo "<pre>" . print_r($last_order_data, 1) . "</pre>";
}

?>
<article class="main">
    <h2 class="info">Información del pedido</h2>
    <section>
        <div class="table-container">
            <table class="table cart-table">
                <tr>
                    <th>Nombre Producto</th>
                    <th>Precio</th>
                    <th>Unidades</th>
                    <th>Fecha</th>
                    <th>Enviado</th>
                </tr>

                <?php
                // TODO Hacer que sea el ultimo pedido no solo los productos encargados en mismo dia (mirar si eso es muy dificil)
                foreach ($last_order_data["products_same_day"] as $product) {
                ?>
                    <tr>
                        <td>
                            <?= $product["nombreProd"] ?>
                        </td>
                        <td>
                            <?= $product["precioProd"] ?> €
                        </td>
                        <td>
                            <?= $product["unidades"] ?>
                        </td>
                        <td>
                            <?= $product["fecha"] ?>
                        </td>
                        <td>
                            <?php if ($product["enviado"] == 0) : ?>
                                Pedido pendiente de envio
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                }
                ?>

                <tr>
                    <td colspan="5">
                        Precio total: <span class="total-amount"><?= $last_order_data["precioTotal"] ?>€</span>
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        <p class="message">Su pedido ha sido registrado con éxito, revise su correo con la información del pedido</p>
    </section>

</article>

<?php include "./includes/sidenavIzq.php"; ?>
<?php include "./includes/sidenavDer.php"; ?>
<?php include "./includes/footer.php"; ?>