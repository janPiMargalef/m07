<?php
session_start();
require_once('config.php');
?>
<?php     //FER UN IF amb $_SESSION[aquest_usuari_te_equip] PER TEURE LA OPCIO DE CREAR EQUIP I AFEGIR LA OPCIO MARXARDE L'EQUIP
//crear equip
if(isset($_POST["crearEquip"]))
{
$nomEquip = $_POST['nomEquip'];
$contrasenyaEquip = $_POST['contrasenyaE'];



}
?>
<form  method="post">
<label for="username">Nom equip</label>
<input type="text" name="nomE" id="username" required>
<label for="password">Contrasenya</label>
<input type="password" name="contrasenyaE" id="password" required>
<button type="submit" name="crearEquip">Crear equip</button>
</form>