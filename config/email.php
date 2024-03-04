<?php
require_once "./config/db_operations.php";
require "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

function create_mail_content($order_data, $user_id, $user_email)
{
    $text = "<h2>Usuario: {$user_email} </h2>";
    $text .= "<style>
    table, td, th {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    th {
        background-color: lightblue;
    }
    
    </style>";
    $text .= "<table>
                <tr>
                    <th>Nombre Producto</th>
                    <th>Precio</th>
                    <th>Unidades</th>
                    <th>Fecha</th>
                    <th>Enviado</th>
                </tr>";

    $order_data = load_last_order_data($user_id);
    foreach ($order_data["products_same_day"] as $product) {
        $sent = ($product["enviado"] == 0) ? "Pedido no enviado" : "";
        $text .= "<tr>
                    <td>{$product['nombreProd']}</td>
                    <td>{$product['precioProd']}</td>
                    <td>{$product['unidades']}</td>
                    <td>{$product['fecha']}</td> 
                    <td>{$sent}</td> 
                </tr>";
    }

    $text .= "<tr>
                <td colspan='5'>
                    Precio total: <span class='total-amount'>{$order_data['precioTotal']} €</span>
                </td>
            </tr>";
    $text .= "</table>";

    return $text;
}


function send_email($to, $subject, $body)
{
    $mail = new PHPMailer();

    // SMTP Configuration
    $mail->isSMTP();
    $mail->CharSet = "UTF-8";
    $mail->SMTPDebug = 0; // Cambiar a 0 para deshabilitar la salida de depuración. 2 para habilitarla
    $mail->Host = "smtp.freesmtpservers.com";
    $mail->SMTPAuth = false;
    $mail->Port = 25;

    // Email Configuration
    $mail->setFrom("ryuShop@gmail.com", "Tienda web");
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;

    // Send the email
    if ($mail->send()) {
        echo "Email sent successfully";
    } else {
        echo "Email sending failed. Error: " . $mail->ErrorInfo;
    }
}


function send_order_confirmation_email($user_email, $user_id, $order_data)
{
    $subject = "Detalles del pedido";
    $body = create_mail_content($order_data, $user_id, $user_email);
    send_email($user_email, $subject, $body);
}
