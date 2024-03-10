<?php
ob_start();
require_once "./config/db_operations.php";

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

    // Comprueba si la inserción tuvo exito
    if ($idUsuario == false) {
        // Si no se pudo insertar el usuario, establece la variable de error a true
        $error_message = true;
    } else {
        $success_message = true;
    }
}

include "./includes/header.php";
ob_end_flush();
?>

<article class="main">
    <div class="form-container">
        <h2>Datos de usuario</h2>
        <hr>
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="register-form form">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="Introduce tu email" required>

            <label for="nombreUsu">Nombre de Usuario</label>
            <input type="text" name="nombreUsu" id="nombreUsu" placeholder="Introduce tu nombre de usuario" required>

            <label for="pass">Contraseña</label>
            <input type="password" name="pass" id="pass" placeholder="Introduce tu contraseña" required>

            <!-- TODO Comprobar que ambas contraseñas coincidan 
            comprobar con el evento onkeyup
            <label for="pass2">Repite la contraseña</label>
            <input type="password" id="pass2" placeholder="Repite tu contraseña" required>-->

            <label for="pais">País</label>
            <input type="text" name="pais" id="pais">

            <label for="cp">Código Postal</label>
            <input type="text" name="cp" id="cp">

            <label for="ciudad">Ciudad</label>
            <input type="text" name="ciudad" id="ciudad">

            <label for="direccion">Dirección</label>
            <textarea name="direccion" id="direccion" rows="3"></textarea>

            <button class="btn btn-register" type="submit">Crear cuenta</button>
        </form>

        <?php if ($success_message) : ?>
            <p class="message success">Usuario registrado correctamente!</p>
        <?php endif; ?>

        <?php if ($error_message) : ?>
            <p class="message error">Problema con el registro de usuario!</p>
        <?php endif; ?>
    </div>
</article>

<?php include "./includes/sidenavIzq.php"; ?>
<?php include "./includes/sidenavDer.php"; ?>
<?php include "./includes/footer.php"; ?>