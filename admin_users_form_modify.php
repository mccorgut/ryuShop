<?php
// Start output buffering
ob_start();
include "./includes/header.php";
require_once "./config/db_operations.php";

// TODO Meter un mensaje de error
$success_message = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["modify_user"])) {
    $user_id = $_POST["idUsuario"];
    $user_email = $_POST["email"];
    $user_name = $_POST["nombreUsu"];
    $user_pass = $_POST["pass"];
    $user_country = $_POST["pais"];
    $user_cp = $_POST["cp"];
    $user_city = $_POST["ciudad"];
    $user_direction = $_POST["direccion"];

    $user_modified = modify_user($user_email, $user_name, $user_pass, $user_country, $user_cp, $user_city, $user_direction, $user_id);

    // Comprueba el resultado de la modificación
    if ($user_modified) {
        $_SESSION["success_message"] = true; // Almacena el estado de éxito en una variable de sesión
        // Redirige a la misma página con el parámetro 'id' incluido en la URL
        header("Location: admin_users_form_modify.php?id=$user_id");
        exit();
    } else {
        $error = true;
    }
}

// Comprueba si se proporcionó un parámetro 'id' en la URL
if (isset($_GET["id"])) {
    // Este parametro lo obtengo desde admin_users    
    $modify_user = $_GET["id"];
    $user = load_user_data($modify_user);
} else {
    // Si no se proporciona 'id', redirige a la página de administración
    header("Location: admin_zone.php");
    exit(); // Asegura que el código se detenga después de redirigir
}

// Verificar si hay un mensaje de éxito almacenado en la variable de sesión
if (isset($_SESSION["success_message"]) && $_SESSION["success_message"] == true) {
    $success_message = true;
    // Elimina el mensaje de éxito de la variable de sesión para que no se muestre nuevamente después de la recarga de la página
    unset($_SESSION["success_message"]);
}

// End output buffering and flush the output
ob_end_flush();
?>

<article class="main">
    <div class="form-container form-admin">
        <h2>Modificar datos de usuario</h2>
        <hr>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="register-form form">
            <label for="idUsuario">Id Usuario</label>
            <input type="number" name="idUsuario" id="idUsuario" value="<?= htmlspecialchars($user['idUsuario']); ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']); ?>">

            <label for="nombreUsu">Nombre de Usuario</label>
            <input type="text" name="nombreUsu" id="nombreUsu" value="<?= htmlspecialchars($user['nombreUsu']); ?>">

            <!-- TODO No se puede mostrar la contraseña solo modificarla -->
            <label for="pass">Contraseña</label>
            <input type="password" name="pass" id="pass">
            <small>No se puede mostrar la contraseña puesto que esta codificada</small>

            <label for="pais">País</label>
            <input type="text" name="pais" id="pais" value="<?= htmlspecialchars($user['pais']); ?>">

            <label for="cp">Código Postal</label>
            <input type="text" name="cp" id="cp" value="<?= htmlspecialchars($user['cp']); ?>">

            <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" id="ciudad" value="<?= htmlspecialchars($user['ciudad']); ?>">

            <label for="direccion">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3"><?= htmlspecialchars($user['direccion']); ?></textarea>

            <button class="btn btn-register" type="submit" name="modify_user">Modificar</button>
        </form>

        <?php if ($success_message) : ?>
            <p class="message success">Los datos del usuario se han modificado correctamente!</p>
        <?php endif; ?>
    </div>

    <!-- TODO añadir un enlace para volver a la tabla de usuarios -->
    <section class="return-admin-zone">
        <hr>
        <p>Volver al area de administracion</p>
        <form action="admin_zone.php" class="return-admin-form form">
            <button class="btn-return" type="submit">Volver</button>
        </form>
    </section>
</article>


</body>

</html>