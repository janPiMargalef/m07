<?php
require_once('confirmarRegistre.php');
?>

<html>
    <head>
        <title>Registre't</title>
    </head>
    <body>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">LOGO</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="menu.php">Menu</a>
        <a class="nav-link active" href="equip.php">Equip</a>
        <!--a class="nav-link" href="#">Pricing</a>
        <a class="nav-link disabled">Disabled</a>
        <a class="nav-link disabled">Disabled</a>-->
        <a class="nav-link active" href="buscar.php">Buscar</a>
        <a class="nav-link active" href="partides.php">Partides</a>
        <a class="nav-link active" href="perfil.php">Perfil</a>
      </div>
    </div>
  </div>
</nav>
        <div>
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
//header("Location: iniciarSessio.php");
echo "<script>alert('Guardat Correctament'); </script>";
}
else{
     echo "<script>alert('Contrasenya no concorda'); </script>";
    
}
}
}
?>
        </div>
        <form method="POST">  <!-- action="iniciarSessio.php" -->
    usuari <input type="text" name="usuariR" required="">
     
    contrasenya <input type="text" name="contrasenyaR" required="">
  confirma  <input type="text" name="confirmaContrasenya" required="">
   
    <input type="submit" name="crear" value="registrarCompte">
</form>


 </body>
</html>