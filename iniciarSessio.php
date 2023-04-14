<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>Iniciar Sessio</title>
         <link rel="stylesheet" type="text/css" href="estils.css">
    </head>
    <body>
<?php
if(isset($_POST["iniciar"]))
{
$usuariS = $_POST['usuariS'];
$contrasenyaS = $_POST['contrasenyaS'];
$sentencia = $db->prepare("SELECT * FROM usuaris WHERE usuari = '$usuariS' AND contrasenya = '$contrasenyaS'");
$sentencia->execute([$usuariS]);
$numFiles = $sentencia->rowCount(); 

if($numFiles > 0)
{
    
$consulta = 'SELECT id_usuari, nom_equip FROM usuaris WHERE usuari = :usuari AND contrasenya = :contrasenya';//obtenir l'id i l'equip del jugador
$stmt = $db->prepare($consulta);
$stmt->bindParam(':usuari', $usuariS);
$stmt->bindParam(':contrasenya', $contrasenyaS);
$stmt->execute();
$fila = $stmt->fetch(PDO::FETCH_ASSOC);
$UsuariId = $fila['id_usuari'];
$UsuariEquip = $fila['nom_equip'];

$_SESSION['UsuariId'] = $UsuariId;
$_SESSION['UsuariEquip'] = $UsuariEquip;
$_SESSION["usuariS"] = $usuariS;
$_SESSION["contrasenyaS"] = $contrasenyaS;
    
    header("Location:menu.php");//header menu i amb session_start recopilar info del user
    exit();
}
else{
    echo "<script>alert('Usuari o Contrasenya incorrecte'); </script>";
}
}

?>
    <div class="login-container">
		<h2>Iniciar sessió</h2>
		<form method="post">
			<label for="username">Usuari</label>
			<input type="text" name="usuariS" id="username" required>
			<label for="password">Contrasenya</label>
			<input type="password" name="contrasenyaS" id="password" required>
			<button type="submit" name="iniciar" value="iniciarSessio">Iniciar sessió</button>
		</form>
                <p>No tens un compte?<a href="registrarCompte.php">Registret</a></p>
	</div>

 </body>
</html>
