<?php
require_once('config.php');
session_start();
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Comprueba si el token existe en la base de datos
    $stmt = $db->prepare("SELECT email FROM usuaris WHERE token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Marca el correo electrónico como verificado y borra el token
        $stmt = $db->prepare("UPDATE usuaris SET email_verificat = 1, token = NULL WHERE token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();

        echo "Tu correo electrónico ha sido verificado con éxito.";
    } else {
        echo "El enlace de verificación no es válido o ya ha sido utilizado.";
    }
}


?>