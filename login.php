<?php
// Incluye el archivo que contiene las operaciones de la base de datos
require_once "./config/db_operations.php";

// Define una variable para indicar si ha ocurrido un error
$error_message = false;

// Comprueba si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera el email y la contraseña enviados a través del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Intenta logear al usuario utilizando la función login_user
    $resultado = login_user($email, $password);

    // Verificación del resultado
    if ($resultado["authenticated"]) {
        // Si la autenticación es correcta, inicia una sesión para el usuario y redirige a index.php
        $nombreUsu = $resultado["nombreUsu"];
        $idUsuario = $resultado["idUsuario"];

        session_start();
        $_SESSION["idUsuario"] = $idUsuario;
        $_SESSION["nombreUsu"] = $nombreUsu;
        $_SESSION["usuario"] = $email;
        $_SESSION["user_role"] = "user"; // Establece el rol de usuario normal en la sesión
        header("Location: index.php");
        exit;
    } else {
        // Establece un indicador de error si la autenticación falla
        $error_message = true;
    }
}
?>
<?php include "./includes/header.php"; ?>

<article class="main">
    <div class="form-container">
        <h2>Iniciar sesión</h2>
        <hr>
        <!-- Formulario de inicio de sesión -->
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="loginForm" class="login-form form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Introduce tu email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Introduce tu contraseña" required>

            <!-- Mostrar mensaje de error si $error_message es true -->
            <?php if ($error_message) : ?>
                <p class="message error">Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>
            <?php endif; ?>

            <button class="btn btn-login" type="submit">Acceder</button>
        </form>
        <hr>
        <p>Si no tienes cuenta aún.</p>
        <!-- Formulario para crear una cuenta -->
        <form action="register.php" class="login-form form">
            <button class="btn btn-login" type="submit">Crear cuenta</button>
        </form>
    </div>
</article>

<?php include "./includes/sidenavIzq.php"; ?>
<?php include "./includes/sidenavDer.php"; ?>
<?php include "./includes/footer.php"; ?>