
<?php
session_start();
require_once('config.php');
?>
<html>
    <head>
        <title>equip</title>
        <link rel="stylesheet" type="text/css" href="estilsPerfil.css">
        <style>
           body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-image: url('map.webp');
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
.tablinks {
    
  background-color: #f1f1f1;
  border: none;
  text-align: center;
  display: inline-block;
  font-size: 20px;
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
  margin-bottom: 25%;
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
header {
    background-color: #1a1a1a;
    padding: 1rem;
  }
  nav {
    background-color: #333;
    overflow: hidden;
    display: flex;
 
    align-items: center;
  }

  nav a {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
  }

  nav a:hover {
    background-color: #ddd;
    color: black;
  }

   .buscador {
    display: flex;
    align-items: center;
    border-radius: 4px;
    margin-top: 0.5%;
    padding: 4px 8px;
    margin-left: 50%;
  }
  #nom_equip_buscar {
    border: none;
    padding: 4px 8px;
    border-radius: 4px;
    outline: none;
    font-size: 14px;
    height: 35px;
  }

  

  .boto {
    border: none;
    background-color: #FF6600;
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    height: 35px;
    margin-left: 2%;
  }

  .container-principal {
    flex-grow: 1;
  }
  
  .boto:hover {
    background-color: #c27100;
  }
  .footer {
    background-color: #1a1a1a;
    padding: 1rem;
    color: white;
    text-align: center;
    font-size: 1rem;
    margin-bottom: 0;
    
  }
  .logo {
      max-height: 150px;
      max-width: 200px;
  }
  
  .readonly-input {
    background-color: transparent;
    border: none;
    outline: none;
    border-bottom: 1px dotted #000;
    width: 100%;
    box-sizing: border-box;
}

.input-container {
    width: 100%;
}

.perfil-container .boto-container {
    display: flex;
    margin-left: 20%;
    gap: 25px;
}
table {
  border-collapse: collapse;
  width: 50%;
  margin: auto;
  margin-top: 2%;
  background-color: #f2f2f2;
}



th, td {
  padding: 25px;
  text-align: center;
  border-bottom: 1px solid #ddd;
}

td:hover {
    background-color: #ffffff;
}

.perfil-container button {
    padding: 8px 16px;
    border: none;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 4%;
}


.perfil-container button:hover {
    opacity: 0.8;
}

button[name="actualizar_perfil"] {
    background-color: #4CAF50;
    color: white;
}

button[name="eliminar_compte"] {
    background-color: #f44336; 
    color: white;
}

button[name="tancar_sessio"] {
    background-color: #FFA500;
    color: white;
}

</style>
    </head>
    <body>
         <div class="container-principal">
<header>
    <a href="menu.php"><img src="logo.png" class="logo"></a>
</header>
  <nav>
    <a href="menu.php">Menú</a>
    <a href="equip.php">Equip</a>
    <a href="buscar.php">Buscar</a>
    <a href="partides.php">Partides</a>
    <a href="perfil.php">Perfil</a>
    <form action="buscar_equip.php" method="post" class="buscador">
            <input type="text" name="nom_equip_buscar" id="nom_equip_buscar" placeholder="Buscar equip" required>
            <button type="submit" class ="boto">Buscar</button>
        </form>
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


if(isset($_POST['AbandonarEquip'])) //abandonar equip
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


if (isset($_POST['subir_imagen'])) { //afegir imatge
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
    exit();
  }
}


if(isset($_POST['actualitzar_equip'])) //actualitzar equip
{
    $id_equip_act = $_POST['id_equip_act'];
    $nom_curt_act = $_POST['nom_curt_act'];
    $descripcio_act = $_POST['descripcio_act'];
    $contrasenya_nova_act = $_POST['contrasenya_nova_equip'];
    $contrasenya_confirmar_act = $_POST['contrasenya_confirmar_equip'];
      if(!empty($contrasenya_nova_act) && $contrasenya_nova_act === $contrasenya_confirmar_act) {
        
    $stmt_act = $db->prepare("UPDATE equips SET nom_curt = :nom_curt, descripcio = :descripcio, contrasenya_equip = :contrasenya WHERE id_equip = :id_equip");
    $stmt_act->bindParam(':id_equip', $id_equip_act);
    $stmt_act->bindParam(':nom_curt', $nom_curt_act);
    $stmt_act->bindParam(':descripcio', $descripcio_act);
    $stmt_act->bindParam(':contrasenya', $contrasenya_nova_act);
    $stmt_act->execute();
    echo "<script>alert('Equip actualitzat amb èxit');</script>";
         header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
   elseif (empty($contrasenya_nova_act)) {
          
    $stmt_act = $db->prepare("UPDATE equips SET nom_curt = :nom_curt, descripcio = :descripcio WHERE id_equip = :id_equip");
    $stmt_act->bindParam(':id_equip', $id_equip_act);
    $stmt_act->bindParam(':nom_curt', $nom_curt_act);
    $stmt_act->bindParam(':descripcio', $descripcio_act);
    $stmt_act->execute();
    echo "<script>alert('Equip actualitzat amb èxit');</script>";
         header("Location: ".$_SERVER['PHP_SELF']);
        exit();
   }

    
    
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

      
    $stmt_jug = $db->prepare("SELECT email, usuari FROM usuaris WHERE nom_equip = :nom_equip");
    $stmt_jug->bindParam(':nom_equip', $EquipNom);
    $stmt_jug->execute();
    

?>

<button class="tablinks" onclick="openTab(event, 'Equip')">Equip</button>
<button class="tablinks" onclick="openTab(event, 'Jugadors')">Jugadors</button>

<div id="Equip" class="tabcontent">
    <div class="perfil-container">
        <h2>Equip <?php echo $EquipNom; ?></h2>
        <br>
        <div class="perfil-content">
            <h3>Informació de perfil</h3>
            <br>
            <form action="equip.php" method="post" class="actualizar-equip">
                <div class="input-container">
                    <label for="id_usuari">Id equip:</label>
                    <input type="text" name="id_equip_act" value="<?php echo $IdEquip; ?>" readonly class="readonly-input"><br>
                    <br>
                    <label for="email_usuari">Nom equip:</label>
                    <input type="text" name="nom_equip_act" value="<?php echo $EquipNom; ?>" readonly  class="readonly-input"><br>
                    <br>
                    <label for="nom_usuari">Nom curt:</label>
                    <input type="text" name="nom_curt_act" value="<?php echo $NomCurt; ?>" class="readonly-input"><br>
                    <br>
                    <label for="nom_usuari">Descripció:</label>
                    <input type="text" name="descripcio_act" value="<?php echo $descripcio; ?>" class="readonly-input"><br>
                    <br>
                    <?php
                    echo '<div class="perfil-img">';
                    echo '<img src="' . $RutaImatge . '">';
                    echo '</div>';
                    ?>
                </div>
                <br>
                <br>
                <h3>Nova contrasenya</h3>
                <br>
                <label for="contrasenya_nova">Nova contrasenya:</label>
                <input type="password" name="contrasenya_nova_equip" placeholder="Nova contrasenya" class="readonly-input"><br>
                <br>
                <label for="Contrasenya_confirmar">Repeteix la nova contrasenya:</label>
                <input type="password" name="contrasenya_confirmar_equip" placeholder="Repeteix la nova contrasenya" class="readonly-input"><br>
                <br>
                <div class="boto-container">
                    <button type="submit" name="actualitzar_equip">Actualizar equip</button>
                </div>
            </form> 
            <form action="equip.php" method="post">
                <div class="boto-container">
                    <button type="submit" name="eliminar_equip" onclick="return confirm('¿Estas segur d\'eliminar aquest equip?')">Eliminar equip</button>
<button type="submit" name="AbandonarEquip">Abandonar Equip</button>
                </div>
            </form> 
             <form method="POST" action="equip.php" enctype="multipart/form-data">
                <label>Seleccionar imatge</label>
                <input type="file" name="imagen">
                <input type="submit" name="subir_imagen" value="Subir imagen">
            </form>
        </div>
    </div>
</div>


</div>

<div id="Jugadors" class="tabcontent">
  <h3>Jugadors</h3>
  
  <table>
       <tr>
      <th>Email</th>
      <th>Usuari</th>
    </tr>
        <tbody>
        <?php
        while ( $resultat_jug = $stmt_jug->fetch(PDO::FETCH_ASSOC)) {
          echo '<tr>
        <td>'.$resultat_jug['email'].'</td>
         <td>'.$resultat_jug['usuari'].'</td>
                </tr>';
  
        }
        ?>
        </tbody>
    </table>
  
  
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

// Obre la pestanya "Equip" per defecte en carregar la pagina
document.addEventListener("DOMContentLoaded", function() {
  document.getElementsByClassName("tablinks")[0].click();
});
</script>
         </div>
<footer class="footer">
    Copyright &copy; <a href="#política de privacitat">Política de privacitat.</a>
  </footer>
    </body>
</html>

