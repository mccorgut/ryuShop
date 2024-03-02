<?php
include "./config/db_config.php";
require_once "./config/db_operations.php";

$idModificarProd = $_GET["modifiedProdId"];
$nombreImagenOriginal = $_GET["nombre_imagen"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST["productId"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    $directorio_subida = "./public/img/productsIMG/";
    $max_file_size = 5120000; // 5 megabytes
    $extensiones_validas = array("jpg", "png");

    if ($_FILES["imgProducto"]["name"] != "") {
        $nombre_archivo = $_FILES["imgProducto"]["name"];
        $directorio_temporal = $_FILES["imgProducto"]["tmp_name"];

        // Obtenemos la extensión del archivo
        $array_archivo = pathinfo($nombre_archivo);
        $extension = strtolower($array_archivo["extension"]);

        // Validamos la extensión
        if (!in_array($extension, $extensiones_validas)) {
            echo "La extensión no es válida";
            exit; // Salir del script si la extensión no es válida
        }

        // Validamos el tamaño del archivo
        $file_size = $_FILES["imgProducto"]["size"];
        if ($file_size > $max_file_size) {
            echo "La imagen es demasiado grande. Debe ser de un máximo de 5 MB";
            exit; // Salir del script si la imagen es demasiado grande
        }

        // Generamos un nombre único para el archivo
        $nombre_archivo_final = uniqid() . "." . $extension;

        // Movemos el archivo al directorio de destino
        if (move_uploaded_file($directorio_temporal, $directorio_subida . $nombre_archivo_final)) {
            $ruta_completa = $directorio_subida . $nombre_archivo_final;
        } else {
            echo "Error al mover el archivo al directorio de destino";
            exit; // Salir del script si hay un error al mover el archivo
        }
    } else {
        // Si no se subió una nueva imagen, mantener la imagen original
        $ruta_completa = $nombreImagenOriginal;
    }

    try {
        // Llama a la función para actualizar el producto
        modify_product($nombre, $descripcion, $precio, $ruta_completa, $stock, $idModificarProd);

        header("Location: admin_products.php");
        exit;
    } catch (PDOException $e) {
        // Manejar errores de PDO
        echo "Error: " . $e->getMessage();
    }
}
