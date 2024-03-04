<?php
include "./includes/header.php";
require_once "./config/db_operations.php";

// Define una variable para indicar si ha ocurrido un error
$error_message = false;
$success_message = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $nombreUsu = $_POST["nombreUsu"];
    $pass = $_POST["pass"];
    $pais = $_POST["pais"];
    $cp = $_POST["cp"];
    $ciudad = $_POST["ciudad"];
    $direccion = $_POST["direccion"];

    // Llamada a la función para insertar el nuevo usuario
    $idUsuario = insert_user($email, $nombreUsu, $pass, $pais, $cp, $ciudad, $direccion);

    // Verifica si la inserción fue exitosa
    if ($idUsuario == false) {
        // Si no se pudo insertar el usuario, establece la variable de error a true
        $error_message = true;
    } else {
        $success_message = true;
    }
}
?>


<article class="main">
    <!-- TODO mirar que le pasa al css -->
    <div class="form-container form-admin">
        <h2>Añadir usuario</h2>
        <hr>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="register-form form">

            <label for="email">Email</label>
            <input type="email" name="email" id="email">

            <label for="nombreUsu">Nombre de Usuario</label>
            <input type="text" name="nombreUsu" id="nombreUsu">

            <label for="pass">Contraseña</label>
            <input type="password" name="pass" id="pass">

            <label for="pais">País</label>
            <input type="text" name="pais" id="pais">

            <label for="cp">Código Postal</label>
            <input type="text" name="cp" id="cp">

            <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" id="ciudad">

            <label for="direccion">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3"></textarea>

            <!-- Mostrar mensaje de error si $err es true -->
            <?php if ($err) : ?>
                <p class="message error">Error al registrar el usuario. Por favor, inténtalo de nuevo.</p>
            <?php endif; ?>

            <button class="btn btn-register" type="submit">Añadir Usuario</button>
        </form>
        <!-- Mostrar mensaje de éxito si $success_message está definido -->
        <?php if ($success_message) : ?>
            <p class="message success">Usuario registrado correctamente!</p>
        <?php endif; ?>

        <?php if ($error_message) : ?>
            <p class="message error">Problema con el registro de usuario!</p>
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