<?php
require_once "db_config.php";

// Funciones para los usuarios

function login_user($email, $password)
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    //  Consulta SQL para comprobar las credenciales de usuario
    // $stmt es un conveio de nomenclatura para las consultas preparadas
    $sql = "SELECT idUsuario, email, nombreUsu, pass FROM Usuarios WHERE email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        $storedPass = $row["pass"];
        $nombreUsu = $row["nombreUsu"];
        $idUsuario = $row["idUsuario"];

        // Compara la contraseña proporcionada con la almacenada usando password_verify
        if (password_verify($password, $storedPass)) {
            // Las contraseñas coinciden, usuario identificado
            // Devuelve un array con el resultado de la autenticación y el nombre de usuario para utilizarlo como nombre que aparace una vez se ha iniciado sesion
            return array("authenticated" => true, "nombreUsu" => $nombreUsu, "idUsuario" => $idUsuario);
        }
    }
    // El usuario no está identificado
    return array("authenticated" => false, "nombreUsu" => null,  "idUsuario" => null);
}

function login_admin($email, $password)
{
    $connection = obtain_connection();

    $sql = "SELECT * FROM Administradores WHERE email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        $storedPass = $row["pass"];
        //   $email = $row["email"];
        $rol = $row["rol"]; // Recupera el valor del rol;

        if (password_verify($password, $storedPass)) {
            // Devuelve un array con el resultado de la autenticación y el rol
            return array("authenticated" => true, "rol" => $rol);
        }
    }
    // Devuelve un array con el resultado de la autenticación como falso y sin rol
    return array("authenticated" => false, "rol" => null);
}


// Función para insertar un nuevo usuario en la tabla Usuarios
function insert_user($user_email, $user_name, $user_pass, $user_country, $user_cp, $user_city, $user_direction)
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    // Opciones para el cifrado de la contraseña
    $options = [
        "cost" => 11,
    ];

    // Hash de la contraseña usando bcrypt
    $hash = password_hash($user_pass, PASSWORD_BCRYPT, $options);

    // Preparar la consulta para insertar el nuevo usuario
    $sql = "INSERT INTO Usuarios (email, nombreUsu, pass, pais, CP, ciudad, direccion) 
    VALUES (:email, :nombreUsu, :pass, :pais, :cp, :ciudad, :direccion)";

    // TODO Hace lo mismo pero con transaciones por si falla el registro
    $stmt = $connection->prepare($sql);
    //   $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(":email", $user_email);
    $stmt->bindParam(":nombreUsu", $user_name);
    // Enlace del hash de la contraseña (almacena el hash de la contraseña)
    $stmt->bindValue(":pass", $hash, PDO::PARAM_STR);
    $stmt->bindParam(":pais", $user_country);
    $stmt->bindParam(":cp", $user_cp);
    $stmt->bindParam(":ciudad", $user_city);
    $stmt->bindParam(":direccion", $user_direction);

    // Ejecuta la consulta
    $stmt->execute();

    // Esto lo hago para mostrar los mensajes de error
    return $stmt->rowCount() > 0 ? true : false;
}

function modify_user($user_email, $user_name, $user_pass, $user_country, $user_cp, $user_city, $user_direction, $user_id)
{
    $connection = obtain_connection();
    // Opciones para el cifrado de la contraseña
    $options = [
        "cost" => 11,
    ];

    // Hash de la contraseña usando bcrypt
    $hash = password_hash($user_pass, PASSWORD_BCRYPT, $options);

    $sql = "UPDATE Usuarios SET email = :email, nombreUsu = :nombreUsu, pass = :pass, pais = :pais, cp = :cp, ciudad = :ciudad, direccion = :direccion WHERE idUsuario = :idUsuario";

    $stmt = $connection->prepare($sql);
    //   $stmt->bindParam(":idUsuario", $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(":email", $user_email);
    $stmt->bindParam(":nombreUsu", $user_name);
    // Enlace del hash de la contraseña (almacena el hash de la contraseña)
    $stmt->bindValue(":pass", $hash, PDO::PARAM_STR);
    $stmt->bindParam(":pais", $user_country);
    $stmt->bindParam(":cp", $user_cp);
    $stmt->bindParam(":ciudad", $user_city);
    $stmt->bindParam(":direccion", $user_direction);
    $stmt->bindParam(":idUsuario", $user_id);

    // Ejecuta la consulta
    $stmt->execute();

    return $stmt->rowCount() > 0 ? true : false;
}

function delete_user($user_id)
{
    $connection = obtain_connection();
    $sql = "DELETE FROM Usuarios WHERE idUsuario = :idUsuario";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':idUsuario', $user_id);
    $stmt->execute();
}

function load_all_users_data()
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    $sql = "SELECT * FROM Usuarios";

    // Preparar la consulta
    $stmt = $connection->prepare($sql);
    $stmt->execute();

    // Obtener el resultado
    $users = $stmt->fetchAll();

    if (!$users) {
        return false;
    }

    return $users;
}

// funcion que cargue todos los usuarios dada su propia id
function load_user_data($user_id)
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    $sql = "SELECT * FROM Usuarios WHERE idUsuario = :idUsuario";

    // Preparar la consulta
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idUsuario", $user_id);
    $stmt->execute();

    // Obtener el resultado
    $user = $stmt->fetch();

    if (!$user) {
        return false;
    }

    return $user;
}


// Funciones para las categorias

function load_categories()
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    // Consulta SQL para obtener todas las categorías
    $sql = "SELECT idCategoria, nombreCat FROM Categorias";

    // Preparar la consulta
    $stmt = $connection->prepare($sql);
    $stmt->execute();

    // Obtener el resultado
    $categories = $stmt->fetchAll();

    if (!$categories) {
        return false;
    }

    return $categories;
}

function load_sub_categories($cat_id)
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    $sql = "SELECT * FROM SubCategorias WHERE idCategoria = :idCategoria";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idCategoria", $cat_id);
    $stmt->execute();

    $subCategories = $stmt->fetchAll();

    if (!$subCategories) {
        return false;
    }

    return $subCategories;
}

// Funciones para los productos

function load_products_categories($cat_id)
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    $sql = "SELECT * FROM Productos WHERE idCategoria = :idCategoria";

    // Preparar la consulta
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idCategoria", $cat_id);
    $stmt->execute();

    // Obtener el resultado
    $productsCat = $stmt->fetchAll();

    if (!$productsCat) {
        return false;
    }

    return $productsCat;
}

function load_products_sub_categories($cat_id, $sub_cat_id)
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    $sql = "SELECT * FROM Productos WHERE idCategoria = :idCategoria AND idSubCategoria = :idSubCategoria";

    // Preparar la consulta
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idCategoria", $cat_id);
    $stmt->bindParam(":idSubCategoria", $sub_cat_id);
    $stmt->execute();

    // Obtener el resultado
    $products_sub_cat = $stmt->fetchAll();

    if (!$products_sub_cat) {
        return false;
    }

    return $products_sub_cat;
}

function load_all_products_data()
{
    $connection = obtain_connection();

    $sql = "SELECT * FROM Productos";

    $stmt = $connection->prepare($sql);
    $stmt->execute();

    // Obtener el resultado
    $products = $stmt->fetchAll();

    if (!$products) {
        return false;
    }

    return $products;
}

// funcion que cargue todos los productos dada su propia id
function load_product_data($product_id)
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    $sql = "SELECT * FROM Productos WHERE idProducto = :idProducto";

    // Preparar la consulta
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idProducto", $product_id);
    $stmt->execute();

    // Obtener el resultado
    $products = $stmt->fetch();

    if (!$products) {
        return false;
    }

    return $products;
}

function load_product_details($product_id)
{
    // Conexión a la base de datos
    $connection = obtain_connection();

    $sql = "SELECT * FROM Detalles WHERE idProducto = :idProducto";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idProducto", $product_id);
    $stmt->execute();

    $productDetails = $stmt->fetch();

    if (!$productDetails) {
        return false;
    }

    return $productDetails;
}

// Función para insertar un nuevo producto en la tabla Productos
function insert_product($product_name, $description, $product_price, $image, $stock, $cat_id, $sub_cat_id)
{
    $connection = obtain_connection();
    $sql = "INSERT INTO Productos (nombreProd, descripcionProd, precioProd, imgProducto, stock, idCategoria, idSubCategoria) VALUES (:nombreProd, :descripcionProd, :precioProd, :imgProducto, :stock, :idCategoria, :idSubCategoria)";
    $stmt = $connection->prepare($sql);

    $stmt->bindParam(":nombreProd", $product_name);
    $stmt->bindParam(":descripcionProd", $description);
    $stmt->bindParam(":precioProd", $product_price);
    $stmt->bindParam(":imgProducto", $image);
    $stmt->bindParam(":stock", $stock);
    $stmt->bindParam(":idCategoria", $cat_id);
    $stmt->bindParam(":idSubCategoria", $sub_cat_id);

    // Ejecuta la consulta
    $stmt->execute();

    // Return true on success or false on failure
    return $stmt->rowCount() > 0 ? true : false;
}

function modify_product($product_name, $description, $product_price, $image, $stock, $product_id)
{
    $connection = obtain_connection();

    try {
        if ($image != "") {
            // Si se subió una nueva imagen, actualizar la imagen y los demás campos
            $sql = "UPDATE Productos SET nombreProd = :nombreProd, descripcionProd = :descripcionProd, precioProd = :precioProd, imgProducto = :imgProducto, stock = :stock WHERE idProducto = :idProducto";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":nombreProd", $product_name);
            $stmt->bindParam(":descripcionProd", $description);
            $stmt->bindParam(":precioProd", $product_price);
            $stmt->bindParam(":imgProducto", $image);
            $stmt->bindParam(":stock", $stock);
            $stmt->bindParam(":idProducto", $product_id);
        } else {
            // Si no se subió una nueva imagen, mantener la imagen original y actualizar los demás campos
            $sql = "SELECT imgProducto FROM Productos WHERE idProducto = :idProducto";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":idProducto", $product_id);
            $stmt->execute();
            $resultado = $stmt->fetch();
            $nombreImagenOriginal = $resultado['imgProducto'];

            $sql = "UPDATE Productos SET nombreProd = :nombreProd, descripcionProd = :descripcionProd, precioProd = :precioProd, imgProducto = :imgProducto, stock = :stock WHERE idProducto = :idProducto";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":nombreProd", $product_name);
            $stmt->bindParam(":descripcionProd", $description);
            $stmt->bindParam(":precioProd", $product_price);
            $stmt->bindParam(":imgProducto", $nombreImagenOriginal);
            $stmt->bindParam(":stock", $stock);
            $stmt->bindParam(":idProducto", $product_id);
        }

        $sql = "INSERT INTO Detalles (idProducto)
        VALUES (:idProducto)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":idProducto", $product_id);

        $stmt->execute();

        return $stmt->rowCount() > 0 ? true : false;
    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function delete_product($product_id)
{
    $connection = obtain_connection();
    // Preparar la consulta SQL para eliminar el producto
    $sql = "DELETE FROM Productos WHERE idProducto = :idProducto";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':idProducto', $product_id);
    $stmt->execute();
}


// Funciones para el carrito

function insert_product_cart($product_id, $user_id, $product_name, $product_price, $product_units)
{
    $connection = obtain_connection();

    // Preparar la consulta SQL
    $sql = "INSERT INTO Carritos (idProducto, idUsuario, nombreProd, precioProd, unidades) VALUES (:idProducto, :idUsuario, :nombreProd, :precioProd, :unidades)";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idProducto", $product_id);
    $stmt->bindParam("idUsuario", $user_id);
    $stmt->bindParam("nombreProd", $product_name);
    $stmt->bindParam("precioProd", $product_price);
    $stmt->bindParam("unidades", $product_units);

    $stmt->execute();

    // Obtener la ID del nuevo carrito
    //$cart_id = $connection->lastInsertId();

    //return $cart_id;
}

function load_cart_data($user_id)
{
    $connection = obtain_connection();
    $sql = "SELECT * FROM Carritos WHERE idUsuario = :idUsuario";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idUsuario", $user_id);
    $stmt->execute();

    $cart_data = $stmt->fetchAll();

    if (!$cart_data) {
        return false;
    }

    // Obtener el precio total de las unidades
    $sql_total = "SELECT ROUND(SUM(precioProd * unidades), 2) AS precioTotal FROM Carritos WHERE idUsuario = :idUsuario";
    $stmt_total = $connection->prepare($sql_total);
    $stmt_total->bindParam(":idUsuario", $user_id);
    $stmt_total->execute();
    $cart_total = $stmt_total->fetch(PDO::FETCH_ASSOC);

    return array("cart_data" => $cart_data, "precioTotal" => $cart_total['precioTotal']);
}

function products_number_cart($user_id)
{
    $connection = obtain_connection();
    $sql = "SELECT COUNT(idProducto) AS numeroProductos FROM Carritos WHERE idUsuario = :idUsuario";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idUsuario", $user_id);
    $stmt->execute();

    $products_cart = $stmt->fetch(PDO::FETCH_ASSOC);

    return $products_cart;
}

function delete_product_cart($cart_id)
{
    $connection = obtain_connection();
    $sql = "DELETE FROM Carritos WHERE idCarrito = :idCarrito ";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':idCarrito', $cart_id);
    $stmt->execute();
}

function add_product_units($cart_id, $product_units)
{
    $connection = obtain_connection();
    // Suma las unidades
    $sql = "UPDATE Carritos SET unidades = :unidades + 1 WHERE idCarrito = :idCarrito";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':idCarrito', $cart_id);
    $stmt->bindParam(':unidades', $product_units);
    $stmt->execute();
}

function delete_product_units($cart_id, $product_units)
{
    $connection = obtain_connection();

    try {
        $connection->beginTransaction();
        // Resta las unidades
        if ($product_units > 1) {
            $sql = "UPDATE Carritos SET unidades = :unidades - 1 WHERE idCarrito = :idCarrito";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':idCarrito', $cart_id);
            $stmt->bindParam(':unidades', $product_units);
            $stmt->execute();
        } else {
            $sql = "DELETE FROM Carritos WHERE idCarrito = :idCarrito ";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':idCarrito', $cart_id);
            $stmt->execute();
        }

        $connection->commit();
        return true;
    } catch (PDOException $e) {
        $connection->rollBack();
        echo "Se produjo un error en la base de datos: " . $e->getMessage();
        return false;
    }
}

// Funciones para procesar los pedidos
function create_order($user_id)
{
    $connection = obtain_connection();

    try {
        $connection->beginTransaction();
        $date = date("Y-m-d H:i:s", time());
        $sql = "INSERT INTO Pedidos (fecha, enviado, idUsuario) VALUES (:fecha, 0, :idUsuario)";

        $stmt = $connection->prepare($sql);
        $stmt->bindParam(":fecha", $date, PDO::PARAM_STR);
        $stmt->bindParam(":idUsuario", $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Obtener el ID del nuevo pedido
        $order = $connection->lastInsertId();

        $cart_data = load_cart_data($user_id);
        foreach ($cart_data["cart_data"] as $product) {
            $sql = "INSERT INTO PedidosProductos (idPedido, idProducto, nombreProd, precioProd, unidades) VALUES (:idPedido, :idProducto, :nombreProd, :precioProd, :unidades)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(":idPedido", $order, PDO::PARAM_INT);
            $stmt->bindParam(":idProducto", $product["idProducto"], PDO::PARAM_INT);
            $stmt->bindParam(":nombreProd", $product["nombreProd"]);
            $stmt->bindParam(":precioProd", $product["precioProd"]);
            $stmt->bindParam(":unidades", $product["unidades"], PDO::PARAM_INT);
            $stmt->execute();

            // Atualiza el stock en la tabla Productos
            $product_stock = load_product_data($product["idProducto"]);
            // Resta el stock
            if ($product_stock["stock"] > 0) {
                $new_stock = $product_stock["stock"] - $product["unidades"];
                $sql = "UPDATE Productos SET stock = :new_stock WHERE idProducto = :idProducto";
                $stmt = $connection->prepare($sql);
                $stmt->bindParam(":new_stock", $new_stock, PDO::PARAM_INT);
                $stmt->bindParam(":idProducto", $product["idProducto"], PDO::PARAM_INT);
                $stmt->execute();
            }

            if ($new_stock <= 0) {
                $sql = "UPDATE Productos SET sinStock = 1 WHERE idProducto = :idProducto";
                $stmt = $connection->prepare($sql);
                $stmt->bindParam(":idProducto", $product["idProducto"], PDO::PARAM_INT);
                $stmt->execute();
            }

            $sql = "DELETE FROM Carritos WHERE idCarrito = :idCarrito ";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':idCarrito', $product["idCarrito"]);
            $stmt->execute();
        }

        $connection->commit();
        return  $order;
    } catch (PDOException $e) {
        $connection->rollBack();
        echo "Se produjo un error en la base de datos: " . $e->getMessage();
        return false;
    }
}


function load_last_order_data($user_id)
{
    $connection = obtain_connection();

    // Fetch data for the last order
    $sql = "SELECT PedidosProductos.*, Pedidos.fecha, Pedidos.enviado
            FROM PedidosProductos  
            JOIN Pedidos ON PedidosProductos.idPedido = Pedidos.idPedido
            WHERE Pedidos.idUsuario = :idUsuario
            ORDER BY Pedidos.fecha DESC";

    $stmt = $connection->prepare($sql);
    $stmt->bindParam(":idUsuario", $user_id);
    $stmt->execute();

    $last_order_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$last_order_data) {
        return false;
    }

    // Get data of the last order
    $last_order = $last_order_data[0];
    $last_order_date = $last_order['fecha'];

    // Filter last order data to get products ordered on the same day
    // Esto es como https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/filter de JS
    $products_same_day = array_filter($last_order_data, function ($order) use ($last_order_date) {
        return $order['fecha'] == $last_order_date;
    });

    // Calculate total price for the last order
    $last_order_id = $last_order['idPedido'];
    $sql_total = "SELECT ROUND(SUM(precioProd * unidades), 2) AS precioTotal 
                  FROM PedidosProductos 
                  WHERE idPedido = :last_order_id";

    $stmt_total = $connection->prepare($sql_total);
    $stmt_total->bindParam(":last_order_id", $last_order_id);
    $stmt_total->execute();
    $cart_total = $stmt_total->fetch(PDO::FETCH_ASSOC);

    return array("products_same_day" => $products_same_day, "precioTotal" => $cart_total['precioTotal']);
}
