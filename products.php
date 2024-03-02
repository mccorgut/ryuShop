<?php
include "./includes/header.php";
require_once "./config/db_operations.php";
?>

<article class="main">
    <section class="products">
        <?php
        if (isset($_GET["categorieId"])  && !isset($_GET["subCategorieId"])) {
            $categorie_id = $_GET["categorieId"];
            // Muestra toda la info de los productos que pertenecen a una misma categoria 
            $products = load_products_categories($categorie_id);
            // var_dump($products);
            // echo "<pre>" . print_r($products, 1) . "</pre>";

            foreach ($products as $product) {
        ?>
                <div class="product-card">
                    <div class="product-image">
                        <a href="product_details.php?productId=<?= $product["idProducto"]; ?>">
                            <img src="<?= $product["imgProducto"]; ?>">
                        </a>
                    </div>
                    <div class="product-info">
                        <h4><?= $product["nombreProd"]; ?></h4>
                        <h5><?= $product["precioProd"]; ?>€</h5>
                    </div>
                </div>
            <?php
            }
        } else {

            ?>
            <?php
            if (isset($_GET["categorieId"]) && isset($_GET["subCategorieId"])) {
                $categorie_id = $_GET["categorieId"];
                $sub_cat_id = $_GET["subCategorieId"];
                $products_sub_cat = load_products_sub_categories($categorie_id, $sub_cat_id);

                foreach ($products_sub_cat as $product_sub_cat) {
            ?>
                    <div class="product-card">
                        <div class="product-image">
                            <a href="product_details.php?productId=<?= $product_sub_cat["idProducto"]; ?>">
                                <img src="<?= $product_sub_cat["imgProducto"]; ?>">
                            </a>
                        </div>
                        <div class="product-info">
                            <h4><?= $product_sub_cat["nombreProd"]; ?></h4>
                            <h5><?= $product_sub_cat["precioProd"]; ?>€</h5>
                        </div>
                    </div>
        <?php
                }
            }
        }
        ?>
    </section>

</article>

<?php include "./includes/sidenavIzq.php"; ?>
<?php include "./includes/sidenavDer.php"; ?>
<?php include "./includes/footer.php"; ?>