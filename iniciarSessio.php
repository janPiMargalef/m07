<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>Iniciar Sessio</title>
        <style>
            body {
	font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-image: url('fondo2.jpg');
        background-size: cover;
       position: relative;
        
}

.container-principal {
    flex-grow: 1;
  }

body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5); 
    z-index: -1;
}

.login-container {
	background-color: #FFFFFF;
	border: 1px solid #CCCCCC;
	padding: 40px;
	margin: 70px auto;
	max-width: 400px;
        margin-top: 7%;
}

h2 {
	margin-top: 0;
}

label {
	display: block;
	margin-bottom: 14px;
}

input[type="text"], input[type="password"]{
	padding: 10px;
	border-radius: 5px;
	border: 1px solid #CCCCCC;
	margin-bottom: 24px;
	width: 100%;
	box-sizing: border-box;
}
button[type="submit"] {
	background-color: #FF6600;
	color: #FFFFFF;
	padding: 10px;
	border: none;
	border-radius: 5px;
	cursor: pointer;
	width: 100%;
	font-size: 16px;
}

button[type="submit"]:hover {
	background-color: #c27100;
}
 header {
    background-color: #1a1a1a;
    padding: 1rem;
  }

  
  .logo {
      max-height: 180px;
      max-width: 230px;
  }

.footer {
    background-color: #1a1a1a;
    padding: 1rem;
    color: white;
    text-align: center;
    font-size: 1rem;
    margin-bottom: 0;
    
  }
        </style>
    </head>
    <body>
        <div class="container-principal">
        <header>
            <a href="menu.php"><img src="logo.png" class="logo"></a>
        </header>
  
<?php
$dataHoraActual = date('Y-m-d H:i:s'); //iniciar sessio(pagina mes visitada), per eliminar ofertes inferiors a la actualitat

$stmt_eliminar_ofertes_pasades = $db->prepare("DELETE FROM ofertes WHERE CONCAT(dia, ' ', hora) < :dataHoraActual");
$stmt_eliminar_ofertes_pasades->bindParam(':dataHoraActual', $dataHoraActual);
$stmt_eliminar_ofertes_pasades->execute();


if (isset($_POST["iniciar"])) {
    $emailS = $_POST['emailS'];
    $contrasenyaS = $_POST['contrasenyaS'];
    
    $sentencia = $db->prepare("SELECT * FROM usuaris WHERE email = :email AND contrasenya = :contrasenya");
    $sentencia->bindParam(':email', $emailS);
    $sentencia->bindParam(':contrasenya', $contrasenyaS);
    $sentencia->execute();
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
        </div>
        <footer class="footer">
    Copyright &copy; 2023 <a href="#política de privacitat">Política de privacitat.</a>
  </footer>

 </body>
</html>
