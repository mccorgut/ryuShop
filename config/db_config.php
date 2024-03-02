<?php
$hostname = "db";
$database = "Proyecto_RyuShop";
$user_db = "root";
$password_db = "zelda123";

function obtain_connection()
{
    global $hostname, $database, $user_db, $password_db;
    return new PDO("mysql:host=$hostname;dbname=$database", $user_db, $password_db);
}

try {
    $db = obtain_connection();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error con la base de datos: " . $e->getMessage()); // Si se produce un error se cierra la conexion
}
