<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>equip</title>
        <style>
          
.tablinks {
  background-color: #f1f1f1;
  color: black;
  border: none;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 5px;
  cursor: pointer;
  padding: 10px 15px;
  border-radius: 4px;
}

.tablinks:hover {
  background-color: #ddd;
}

.tabcontent {
  display: none;
  padding: 20px;
  border-top: none;
}


  .perfil-img {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  overflow: hidden;
}

.perfil-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

</style>
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
<?php
//obtenir el nom d'equip
$EmailUnir = $_SESSION['UsuariEmail']; 
$co = 'SELECT nom_equip FROM usuaris WHERE email = :email'; 
$se = $db->prepare($co);
$se->bindParam(':email', $EmailUnir);
$se->execute();
$resultat = $se->fetch(PDO::FETCH_ASSOC);
$EquipNom = $resultat['nom_equip']; //obtenir el nom_equip del jugador

$cons = 'SELECT id_equip, equips.nom_equip, nom_curt, contrasenya_equip, descripcio, imatge FROM equips JOIN usuaris ON equips.nom_equip = :nomEquip WHERE email = :email'; //comprobar si usuari està en un equip
$sent = $db->prepare($cons);
$sent->bindParam(':nomEquip', $EquipNom);
$sent->bindParam(':email', $EmailUnir);
$sent->execute();
$result = $sent->fetch(PDO::FETCH_ASSOC);//obtenir info del equip

    if ($resultat === false) {
echo "<script>alert('buit'); </script>";
}
if ($resultat['nom_equip'] === null) { //si usuari no té equip mostra formulari per unir-se o crear(cuidado, si elimines desde phpMyadmin no set null)
    echo '
<h1>Crear Equip</h1>
<form method="post">
  <label for="nomEquip">Nom equip</label>
  <input type="text" name="nomE" required>
  <label for="nomCurt">Nom curt</label>
  <input type="text" name="nomCurt" required>
  <label for="password">Contrasenya</label>
  <input type="password" name="contrasenyaE" required>
  <label for="descripcio">Descripcio</label>
  <textarea name="descripcioE"></textarea>
  <button type="submit" name="crearEquip">Crear equip</button>
</form>
<h1>Unir-se a un Equip</h1>
<form method="post" action = "equip.php">
  <label for="username">Nom de l\'equip</label>
  <input type="text" name="NomEquipUsuari" required>
  <label for="password">Contrasenya de l\'equip</label>
  <input type="password" name="ContraEquipUsuari" required>
  <button type="submit" name="UnirseEquip">Unir-se</button>
</form>
';
}
else{//info equip
$IdEquip = $result['id_equip'];
$NomCurt = $result['nom_curt'];
$ContraEquip = $result['contrasenya_equip'];
$descripcio = $result['descripcio'];
$RutaImatge = $result['imatge'];
$_SESSION['RutaImatge'] = $RutaImatge;    


if(isset($_POST['AbandonarEquip']))
{
$c = ("UPDATE usuaris SET nom_equip = NULL WHERE nom_equip = :EquipNom AND email = :email");
$Sen = $db->prepare($c);
$Sen->bindParam(':EquipNom', $EquipNom);
$Sen->bindParam(':email', $EmailUnir);
$Sen->execute();
 header("Location: ".$_SERVER['PHP_SELF']);
 exit();
 
}
}

if(isset($_POST['UnirseEquip']))//afegir el nom de l'equip a l'usuari que s'ha unit, aixi puc consultar quins usuaris estan dins d'un equip
{
$EquipUnir = $_POST['NomEquipUsuari'];
$ContraUnir = $_POST['ContraEquipUsuari'];

$Consulta = 'SELECT email FROM usuaris WHERE nom_equip = :nom_equip';//comprobar que l'equip no està plè (8 usuaris com a màxim)
$Sentencia = $db->prepare($Consulta);
$Sentencia->bindParam(':nom_equip', $EquipUnir);
$Sentencia->execute();
$NumeroFiles = $Sentencia->rowCount(); 

if($NumeroFiles > 8)
{
    echo "<script>alert('Equip ple'); </script>";
}
else
{
$con = 'SELECT * FROM equips WHERE nom_equip = :nom_equip AND contrasenya_equip = :contrasenya_equip';//comprobar contrasenya d'equip
$sen = $db->prepare($con);
$sen->bindParam(':nom_equip', $EquipUnir);
$sen->bindParam(':contrasenya_equip', $ContraUnir);
$sen->execute();
$numeroFiles = $sen->rowCount(); 

if($numeroFiles > 0)
{
$consulta = 'UPDATE usuaris SET nom_equip = :nom_equip WHERE email = :email';//unir
$s = $db->prepare($consulta);
$s->bindParam(':nom_equip', $EquipUnir);
$s->bindParam(':email', $EmailUnir);
$s->execute();
echo "<script>alert('Unit correctament a $EquipUnir'); </script>";
 header("Location: ".$_SERVER['PHP_SELF']);
 $_SESSION['UsuariEquip'] = $EquipUnir;
}
else{
    echo "<script>alert('Contrasenya incorrecta'); </script>";
}
}
}
if(isset($_POST["crearEquip"])) //crear equip
{
$nomEquip = $_POST['nomE'];
$NomCurt = $_POST['nomCurt'];
$contrasenyaEquip = $_POST['contrasenyaE'];
$descripcioEquip = $_POST['descripcioE'];

$sentencia = $db->prepare("SELECT nom_equip FROM equips WHERE nom_equip = ? LIMIT 1;");
$sentencia->execute([$nomEquip]);

$numFiles = $sentencia->rowCount(); 
if($numFiles > 0)
{
    echo "<script>alert('El nom de l\'equip ja existeix'); </script>";
}
else{
    $sql = "INSERT INTO equips (nom_equip, nom_curt, contrasenya_equip, descripcio) VALUES (?,?,?,?)";
$stmtinsert = $db->prepare($sql);
$result = $stmtinsert->execute([$nomEquip, $NomCurt, $contrasenyaEquip, $descripcioEquip]);
echo "<script>alert('Equip creat'); </script>";
 header("Location: ".$_SERVER['PHP_SELF']);
exit();
}
}


if (isset($_POST['subir_imagen'])) {
  $nom_imatge = $_FILES['imagen']['name'];
  $tipo_imatge = $_FILES['imagen']['type'];
  $tamano_imatge = $_FILES['imagen']['size'];
  $tmp_imatge = $_FILES['imagen']['tmp_name'];

  
  if ($tipo_imatge == "image/jpeg" || $tipo_imatge == "image/jpg" || $tipo_imatge == "image/png") {
    
    $carpeta_imatges = "imatges/";
   
    $nom_imatge = uniqid() . "_" . $nom_imatge;

    move_uploaded_file($tmp_imatge, $carpeta_imatges . $nom_imatge);
    $ruta_imatge = $carpeta_imatges . $nom_imatge;
    $stmt6 = $db->prepare("UPDATE equips SET imatge = :imatge WHERE nom_equip = :nom_equip");
    $stmt6->bindParam(':imatge', $ruta_imatge);
    $stmt6->bindParam(':nom_equip', $EquipNom);
    $stmt6->execute();
    header("Location: ".$_SERVER['PHP_SELF']);
  }
}
?>

<button class="tablinks" onclick="openTab(event, 'Equip')">Equip</button>
<button class="tablinks" onclick="openTab(event, 'Jugadors')">Jugadors</button>

<div id="Equip" class="tabcontent">
  <h3>Informació de l'equip</h3>
<?php  
echo"<h2>Equip $EquipNom</h2> <p>$IdEquip</p><p>$NomCurt</p><p>$descripcio</p><p>$ContraEquip</p>";
echo '<form method="post" action = "equip.php">
<button type="submit" name="AbandonarEquip">Abandonar Equip</button>
</form>';
echo "$_SESSION[RutaImatge]";
echo '<div class="perfil-img">';
echo '<img src="' . $RutaImatge . '">';
echo '</div>';
?>



<form method="POST" action="equip.php" enctype="multipart/form-data">
  <label>Seleccionar imatge</label>
  <input type="file" name="imagen">
  <input type="submit" name="subir_imagen" value="Subir imagen">
</form>

</div>

<div id="Jugadors" class="tabcontent">
  <h3>Jugadors</h3>
  <p>Contingut relacionat amb els jugadors.</p>
</div>
<script>
function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Obre la pestanya "Equip" per defecte en carregar la pàgina
document.addEventListener("DOMContentLoaded", function() {
  document.getElementsByClassName("tablinks")[0].click();
});
</script>

    </body>
</html>