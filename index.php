<?php
require_once "./config/db_operations.php";
include "./includes/header.php";
?>

<article class="main">
    <section>
        <div class="carousel-container">
            <div class="carousel">
                <div class="carousel-item">
                    <a href="#"><img src="public/img/resources/banner_1.jpg" alt="Image 1"></a>
                </div>
                <div class="carousel-item">
                    <a href=""><img src="public/img/resources/banner_2.jpg" alt="Image 2"></a>
                </div>
                <div class="carousel-item">
                    <a href=""><img src="public/img/resources/banner_3.jpg" alt="Image 3"></a>
                </div>
            </div>
            <div class="carousel-buttons">
                <button class="prev-btn">
                    <i class='bx bxs-chevron-left'></i>
                </button>
                <button class="next-btn">
                    <i class='bx bxs-chevron-right'></i>
                </button>
            </div>
        </div>
    </section>

    <section class="products">
        <?php
        $products = load_all_products_data();
        foreach ($products as $product) {
        ?>
            <div class="product-card">
                <div class="product-image">
                    <a href="product_details.php?productId= <?= $product["idProducto"]; ?>">
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
        ?>
    </section>
</article>

<?php include "./includes/sidenavIzq.php"; ?>
<?php include "./includes/sidenavDer.php"; ?>
<?php include "./includes/footer.php"; ?>