<?php
require_once "./config/db_operations.php";
include "./includes/header.php";

// TODO Añadir confirmacion antes de poder eliminar al usuario 

// Verificar si se ha enviado una solicitud de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
    // Verificar si se proporcionó un ID de producto válido
    if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
        $user_id = $_POST["id"];
        delete_user($user_id);
    }
}

$users = load_all_users_data();
?>

<article class="main">
    <!-- CRUD de los usuarios registrados en la BD para el administrador -->
    <!-- Zona solo visible para los super administradores -->
    <section>
        <!-- Tabla que muestra los usuarios registrados en la BD -->
        <div class="table-container">
            <table class="table cart-table">
                <tr>
                    <th>Id</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Pais</th>
                    <th>CP</th>
                    <th>Ciudad</th>
                    <th>Direccion</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                </tr>

                <?php
                foreach ($users as $user) {
                ?>
                    <tr>
                        <td>
                            <?= $user["idUsuario"]; ?>
                        </td>
                        <td>
                            <?= $user["email"]; ?>
                        </td>
                        <td>
                            <?= $user["nombreUsu"]; ?>
                        </td>
                        <td>
                            <?= $user["pais"]; ?>
                        </td>
                        <td>
                            <?= $user["cp"]; ?>
                        </td>
                        <td>
                            <?= $user["ciudad"]; ?>
                        </td>
                        <td>
                            <?= $user["direccion"]; ?>
                        </td>
                        <td>
                            <button class="btn-user bx-border">
                                <a href="admin_users_form_modify.php?id=<?= $user['idUsuario']; ?>">
                                    <i class='bx bxs-edit bx-sm'></i>
                                </a>
                            </button>
                        </td>
                        <td>
                            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                                <input type="hidden" name="id" value="<?= $user['idUsuario']; ?>">
                                <button class="btn-delete bx-border" type="submit" name="delete_user">
                                    <i class='bx bx-trash bx-sm'></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td colspan="11">
                        <form action="admin_users_form_add.php">
                            <label for="addUser">Añadir usuario</label>
                            <button name="addUser" class="btn-user btn-edit bx-border">
                                <i class='bx bxs-user-plus bx-sm'></i>
                            </button>
                        </form>
                    </td>
                </tr>

            </table>
        </div>
    </section>
    <section class="return-admin-zone">
        <hr>
        <p>Volver al area de administracion</p>
        <form action="admin_zone.php" class="return-admin-form form">
            <button class="btn-return" type="submit">Volver</button>
        </form>
    </section>
</article>

<?php include "./includes/footer.php"; ?>