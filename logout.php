<?php
session_start();

// Redirige al usuario a la página de inicio
header("Location: index.php");
// Destruye la sesión
session_destroy();
exit();
