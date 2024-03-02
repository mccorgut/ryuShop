<?php
// Inicia el almacenamiento en búfer de salida
ob_start();

// Incluye el archivo de encabezado
include "./includes/header.php";

// Requiere el archivo de operaciones de base de datos
require_once "./config/db_operations.php";

// Define una variable para indicar si ha ocurrido un error
$err = false;

// Comprueba si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera el email y la contraseña enviados a través del formulario
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Intenta logear al administrador utilizando la función login_admin
    $resultado = login_admin($email, $password);

    // Verificación del resultado
    if ($resultado["authenticated"]) {
        $rol = $resultado["rol"];

        // Inicia la sesión
        session_start();
        $_SESSION["admin"] = $email;
        $_SESSION["user_role"] = ($rol == 0) ? "super_admin" : "admin";

        // Redirige a admin_zone.php
        header("Location: admin_zone.php");
        exit;
    } else {
        // Establece un indicador de error si la autenticación falla
        $err = true;
    }
}

// Detiene el almacenamiento en búfer de salida y envía el contenido almacenado
ob_end_flush();
?>

<article class="main">
    <section class="form-container form-admin">
        <h2>Iniciar sesión</h2>
        <hr>
        <!-- Formulario de inicio de sesión -->
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="login-form-admin form">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Introduce tu email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Introduce tu contraseña">

            <!-- Mostrar mensaje de error si $err es true -->
            <?php if ($err) : ?>
                <p class="message error">Credenciales incorrectas. Por favor, inténtalo de nuevo.</p>
            <?php endif; ?>
            <button class="btn btn-login" type="submit">Acceder</button>
        </form>
    </section>
</article>

</body>

</html>