<?php
ob_start();
session_start();
require_once "./config/db_operations.php";
require_once "./config/email.php";

// Verificar si se ha enviado una solicitud de eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["process_order"])) {
    // Verificar si se proporcionó un ID de producto válido
    if (isset($_POST["idUsuario"]) && isset($_SESSION['idUsuario'])) {
        $user_id = $_POST["idUsuario"];
        //echo  $user_id;
        // TODO Añadir notificacion de errores
        create_order($user_id);
        $last_order_data = load_last_order_data($user_id);

        $user_data = load_user_data($user_id);

        send_order_confirmation_email($user_data['email'], $user_id, $last_order_data);



        header("Location: show_order.php");
        exit();
    }
}

ob_end_flush();
