<?php
require_once('config.php');
?>

<html>
    <head>
        <title>Registre't</title>
        
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

$token = bin2hex(random_bytes(32));


    $stmt = $db->prepare("UPDATE usuaris SET token = :token WHERE email = :email");
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':email', $gmail);
    $stmt->execute();

    
    $to = $_POST['email'];
    $subject = "Verifica tu dirección de correo electrónico";
    $message = "Haz clic en el siguiente enlace para verificar tu correo electrónico: ";
    $message .= "http://localhost/Projectem07/verificar_email.php?token=" . $token;
    $headers = "From: noreply@yourwebsite.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Se ha enviado un correo electrónico de verificación a " . $to . ".";
    } else {
        echo "No se pudo enviar el correo electrónico de verificación.";
    }

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
      
          </div>
          <footer class="footer">
              Copyright &copy; 2023 <a href="#política de privacitat">Política de privacitat.</a>
  </footer>
 </body>
</html>