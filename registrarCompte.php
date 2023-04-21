<?php
require_once('config.php');
?>

<html>
    <head>
        <title>Registre't</title>
        <link rel="stylesheet" type="text/css" href="estilsRegistrarIniciar.css">
    </head>
    <body>
        
        
        <?php
if(isset($_POST['crear']))
{
$gmail = $_POST['email'];
$usuari = $_POST['usuariR'];
$contrasenya = $_POST['contrasenyaR'];
$confirmaContrasenya = $_POST['confirmaContrasenya'];

$sentencia2 = $db->prepare("SELECT email FROM usuaris WHERE usuari = ? LIMIT 1;");
$sentencia2->execute([$usuari]);

$numFiles2 = $sentencia2->rowCount(); 
if($numFiles2 > 0)
{
    echo "<script>alert('email ja existeix'); </script>";
}
else{
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
$sql = "INSERT INTO usuaris (email, usuari, contrasenya) VALUES (?,?,?)";
$stmtinsert = $db->prepare($sql);
$result = $stmtinsert->execute([$gmail, $usuari, $contrasenya]);
echo "<script>alert('Guardat Correctament'); </script>";
header("Location: iniciarSessio.php");
exit();
}
else{
     echo "<script>alert('Contrasenya no concorda'); </script>";
    
}
}
}
}
?>
        <div class="login-container">
		<h2>Registrar Compte</h2>
		<form method="post">
                        <label>Gmail:</label>
			<input type="text" name="email" id="username" required>
			<label>Nom de usuari</label>
			<input type="text" name="usuariR" id="username" required>
			<label>Contrasenya</label>
			<input type="password" name="contrasenyaR" id="password" required>
                        <label>Confirma contrasenya</label>
			<input type="password" name="confirmaContrasenya" id="password" required>
			<button type="submit" name="crear" value="registrarCompte">Crear compte</button>
                        <p>Ja tens un compte?<a href="iniciarSessio.php">Inicia Sessió</a></p>
		</form>
	</div>
      

 </body>
</html>