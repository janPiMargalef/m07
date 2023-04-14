<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>equip</title>
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
//check si l'equip te 7 usuaris ¡ else no se pot unir
if(isset($_POST['UnirseEquip']))//afegir el nom de l'equip a l'usuari que s'ha unit, aixi puc consultar quins usuaris estan dins d'un equip
{
$UsuariUnir = $_SESSION['usuariS'];
$EquipUnir = $_POST['NomEquipUsuari'];
$ContraUnir = $_POST['ContraEquipUsuari'];

$Consulta = 'SELECT usuari FROM usuaris WHERE nom_equip = :nom_equip';//comprobar que l'equip no està plè (8 usuaris com a màxim)
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

if($numeroFiles >= 0)
{
$consulta = 'UPDATE usuaris SET nom_equip = :nom_equip WHERE usuari = :usuari';
$s = $db->prepare($consulta);
$s->bindParam(':nom_equip', $EquipUnir);
$s->bindParam(':usuari', $UsuariUnir);
$s->execute();
echo "<script>alert('Unit correctament a $EquipUnir'); </script>";
}
else{
    echo "<script>alert('Contrasenya incorrecta'); </script>";
}
}
}

if(isset($_POST["crearEquip"])) //crear equip
{
$nomEquip = $_POST['nomE'];
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
    $sql = "INSERT INTO equips (nom_equip, contrasenya_equip, descripcio) VALUES (?,?,?)";
$stmtinsert = $db->prepare($sql);
$result = $stmtinsert->execute([$nomEquip, $contrasenyaEquip, $descripcioEquip]);
echo "<script>alert('Equip creat'); </script>";
header("Location: equip.php");
exit();
}
}

?>

<?php
$cons = 'SELECT * FROM usuaris WHERE nom_equip = :nom_equip AND usuari = :usuari'; //nomes mostrar formulari si l'usuari no te equip
$sent = $db->prepare($cons);
$sent->bindParam(':nom_equip', $EquipUnir);
$sent->bindParam(':usuari', $UsuariUnir);
$sent->execute();
$numFiles = $sent->rowCount(); 

if($numFiles == 0)
{
    echo '
<h1>Crear Equip</h1>
<form method="post">
  <label for="username">Nom equip</label>
  <input type="text" name="nomE" id="username" required>
  <label for="password">Contrasenya</label>
  <input type="password" name="contrasenyaE" id="password" required>
  <label for="password">Descripcio</label>
  <textarea name="descripcioE"></textarea>
  <button type="submit" name="crearEquip">Crear equip</button>
</form>
<h1>Unir-se a un Equip</h1>
<form method="post">
  <label for="username">Nom de l\'equip</label>
  <input type="text" name="NomEquipUsuari" required>
  <label for="password">Contrasenya de l\'equip</label>
  <input type="password" name="ContraEquipUsuari" required>
  <button type="submit" name="UnirseEquip">Unir-se</button>
</form>
';
}
?>
<form method="POST">
    <label for="group">Seleccionar grupo:</label>
    <select name="group" id="group">
        <?php
            //llistar equips
$pdo = new PDO("mysql:host=$nomservidor;dbname=$db_nom", $db_usuari, $db_contrasenya);
            $stmt = $pdo->prepare('SELECT * FROM equips');
            $stmt->execute();

            foreach ($stmt as $row) {
                echo '<option value="'.$row['id_equip'].'">'.$row['nom_equip'].'</option>';
            }
        ?>
    </select>
</form>
    </body>
</html>

