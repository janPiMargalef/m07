<?php
require_once('config.php');
?>

<html>
    <head>
        <title>Registre't</title>
        <link rel="stylesheet" type="text/css" href="estils.css">
    </head>
    <body>
        
        
        <?php
if(isset($_POST['crear']))
{
$usuari = $_POST['usuariR'];
$contrasenya = $_POST['contrasenyaR'];
$confirmaContrasenya = $_POST['confirmaContrasenya'];
 
$sentencia = $db->prepare("SELECT usuari FROM usuaris WHERE usuari = ? LIMIT 1;");
$sentencia->execute([$usuari]);

$numFiles = $sentencia->rowCount(); 
if($numFiles > 0)
{
    echo "<script>alert('usuari ja existeix'); </script>";
}
else{
if($contrasenya == $confirmaContrasenya)
{
$sql = "INSERT INTO usuaris (usuari, contrasenya) VALUES (?,?)";
$stmtinsert = $db->prepare($sql);
$result = $stmtinsert->execute([$usuari, $contrasenya]);
echo "<script>alert('Guardat Correctament'); </script>";
header("Location: iniciarSessio.php");
exit();
}
else{
     echo "<script>alert('Contrasenya no concorda'); </script>";
    
}
}
}
?>
        <div class="login-container">
		<h2>Registrar Compte</h2>
		<form method="post">
			<label for="username">Nom de usuari</label>
			<input type="text" name="usuariR" id="username" required>
			<label for="password">Contrasenya</label>
			<input type="password" name="contrasenyaR" id="password" required>
                        <label for="password">Confirma contrasenya</label>
			<input type="password" name="confirmaContrasenya" id="password" required>
			<button type="submit" name="crear" value="registrarCompte">Crear compte</button>
                        <p>Ja tens un compte?<a href="iniciarSessio.php">Inicia Sessió</a></p>
		</form>
	</div>
      

 </body>
</html>