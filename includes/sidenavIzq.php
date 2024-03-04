<?php require_once "./config/db_operations.php";  ?>

<aside class="aside aside-1">
    <div class="asideMenu">
        <?php

        $categories = load_categories();

        if ($categories === false) {
            $err = true;
        }
        ?>

        <?php
        foreach ($categories as $cat) {
        ?>
            <div class="dropdown">
                <button class="dropdown-btn">
                    <a class="categories" href="products.php?categorieId=<?= $cat['idCategoria']; ?>"><?= $cat["nombreCat"]; ?><i class='bx bxs-down-arrow'></i></a>

                </button>
                <div class="dropdown-content">
                    <?php
                    $sub_categories = load_sub_categories($cat['idCategoria']);
                    foreach ($sub_categories as $sub_cat) {
                    ?>
                        <a class=" subCategories" href="products.php?categorieId=<?= $sub_cat['idCategoria']; ?>&subCategorieId=<?= $sub_cat['idSubCategoria']; ?>">
                            <?= $sub_cat["nombreSubCat"]; ?>
                        </a>

                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</aside>