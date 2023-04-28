<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>Iniciar Sessio</title>
         <link rel="stylesheet" type="text/css" href="estilsRegistrarIniciar.css">
    </head>
    <body>
<?php
$dataHoraActual = date('Y-m-d H:i:s'); //iniciar sessio(pagina mes visitada), per eliminar ofertes inferiors a la actualitat

$stmt_eliminar_ofertes_pasades = $db->prepare("DELETE FROM ofertes WHERE CONCAT(dia, ' ', hora) < :dataHoraActual");
$stmt_eliminar_ofertes_pasades->bindParam(':dataHoraActual', $dataHoraActual);
$stmt_eliminar_ofertes_pasades->execute();


if(isset($_POST["iniciar"]))
{
$emailS = $_POST['emailS'];
$contrasenyaS = $_POST['contrasenyaS'];
$sentencia = $db->prepare("SELECT * FROM usuaris WHERE email = '$emailS' AND contrasenya = '$contrasenyaS'");
$sentencia->execute([$emailS]);
$numFiles = $sentencia->rowCount(); 

if($numFiles > 0)
{
//obtenir el nom d'equip
$EmailUnir = $_POST['emailS'];
$co = 'SELECT nom_equip FROM usuaris WHERE email = :email'; 
$se = $db->prepare($co);
$se->bindParam(':email', $EmailUnir);
$se->execute();
$resultat = $se->fetch(PDO::FETCH_ASSOC);
$EquipNom = $resultat['nom_equip']; //obtenir el nom_equip del jugador
$_SESSION['NomEquipCrear'] = $EquipNom;    
    
$consulta = 'SELECT id_usuari, usuari, email, nom_equip FROM usuaris WHERE email = :email AND contrasenya = :contrasenya';//obtenir info de l'usuari
$stmt = $db->prepare($consulta);
$stmt->bindParam(':email', $emailS);
$stmt->bindParam(':contrasenya', $contrasenyaS);
$stmt->execute();
$fila = $stmt->fetch(PDO::FETCH_ASSOC);
$UsuariId = $fila['id_usuari'];
$Usuari = $fila['usuari'];
$UsuariEmail = $fila['email'];
$UsuariEquip = $fila['nom_equip'];

$_SESSION['UsuariId'] = $UsuariId;
$_SESSION['UsuariEquip'] = $UsuariEquip;
$_SESSION['Usuari'] = $Usuari;
$_SESSION['UsuariEmail'] = $UsuariEmail;
$_SESSION["contrasenyaS"] = $contrasenyaS;
    

$consulta8 = 'SELECT imatge FROM equips WHERE nom_equip = :nom_equip'; 
$sentencia8 = $db->prepare($consulta8);
$sentencia8->bindParam(':nom_equip', $UsuariEquip);
$sentencia8->execute();
$resultat8 = $sentencia8->fetch(PDO::FETCH_ASSOC); 
$numFiles8 = $sentencia8->rowCount(); 

if($numFiles8 > 0)
{
$SesionImatge = $resultat8['imatge'];
$_SESSION['SesionImatge'] = $SesionImatge;  
}
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
			<input type="text" name="emailS" id="username" required>
			<label for="password">Contrasenya</label>
			<input type="password" name="contrasenyaS" id="password" required>
			<button type="submit" name="iniciar" value="iniciarSessio">Iniciar sessió</button>
		</form>
                <p>No tens un compte?<a href="registrarCompte.php">Registret</a></p>
	</div>

 </body>
</html>
