<?php
require_once "config/db_operations.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/5f361d4fee.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="public/img/resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="public/css/style.css">
    <script defer src="public/js/carousel.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <a href="./index.php">
                    <i class="fa-solid fa-dragon"></i> Ryu Shop</a>
            </div>

            <ul class="userLinks">
                <?php
                if (isset($_SESSION["nombreUsu"]) && !isset($_SESSION["admin"])) {
                    // var_dump($_SESSION["nombreUsu"]);
                    //var_dump($_SESSION["user_role"]);
                ?>
                    <li>
                        <span class="userLogged"> <i class="fa-solid fa-circle-user"></i>
                            <?= $_SESSION["nombreUsu"]; ?></span>
                    </li>
                    <li>
                        <?php
                        $user_id = $_SESSION["idUsuario"];
                        $products = products_number_cart($user_id)
                        ?>
                        <a href="./cart.php"><i class="fa-solid fa-cart-shopping"></i><span class="cart-units"> <?= $products["numeroProductos"] ?></span></a>
                    </li>
                    <li>
                        <a href="./logout.php">Log Out <i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                <?php
                } else if (isset($_SESSION["admin"]) && !isset($_SESSION["nombreUsu"])) {
                    // var_dump($_SESSION["admin"]);
                ?>
                    <li>
                        <span class="userLogged"> <i class='bx bxs-lock-alt bx-sm' style='color:#ff9f1c'></i>
                            <?= $_SESSION["admin"]; ?></span>
                    </li>

                    <li>
                        <a href="./logout.php">Log Out <i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                <?php
                } else {
                ?>
                    <li>
                        <a href="./login.php">Login <i class="fa-solid fa-right-to-bracket"></i></i></a>
                    </li>
                <?php
                }
                ?>
            </ul>
        </header>