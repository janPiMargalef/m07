<?php
$db_usuari = "root";
$db_contrasenya = "";
$db_nom = "projecte";
$nomservidor = "localhost";

$db = new PDO("mysql:host=$nomservidor;dbname=$db_nom", $db_usuari, $db_contrasenya);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>
