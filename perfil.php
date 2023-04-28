<?php
require_once('config.php');
session_start();
?>
<?php
$emailE = $_SESSION['UsuariEmail']; //tancar sessió 
if(isset($_POST['tancar_sessio']))//potser fer form amb tota la informacio i al donarli a guardar fer un update uk uk
{
session_unset();
session_destroy();
header("Location: iniciarSessio.php");
exit();
}
if (isset($_POST['eliminar_compte'])) { //eliminar compte
$sql = "DELETE FROM usuaris WHERE email = :email";
$stmt = $db->prepare($sql);
$stmt->bindParam(':email', $emailE);
$stmt->execute();
session_unset();
session_destroy();
header('Location: menu.php');
exit();
}
?>
<html>
    <head>
        <title>perfil</title>
        <link rel="stylesheet" type="text/css" href="estilsPerfil.css">
       
    
<style>
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

.perfil-container button {
    padding: 8px 16px;
    border: none;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.perfil-container button:hover {
    opacity: 0.8;
}

button[name="actualizar_perfil"] {
    background-color: #4CAF50; /* Verde */
    color: white;
}

button[name="eliminar_compte"] {
    background-color: #f44336; /* Rojo */
    color: white;
}

button[name="tancar_sessio"] {
    background-color: #FFA500; /* Naranja */
    color: white;
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

$emailS = $_SESSION['UsuariEmail'];
$consulta = 'SELECT id_usuari, usuari, email, nom_equip FROM usuaris WHERE email = :email';//obtenir info de l'usuari
$stmt = $db->prepare($consulta);
$stmt->bindParam(':email', $emailS);
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

if (isset($_POST['actualizar_perfil'])) { //actualitzar valors del perfil
    $contrasenya_nova = $_POST['contrasenya_nova'];
    $Contrasenya_confirmar = $_POST['Contrasenya_confirmar'];
    $nou_usuari = $_POST['nom_usuari'];

    if (!empty($contrasenya_nova) && $contrasenya_nova === $Contrasenya_confirmar) {
        $consulta_actualizar = "UPDATE usuaris SET usuari = :nou_usuari, contrasenya = :contrasenya_nova WHERE id_usuari = :id_usuari";

        $sentencia_actualizar = $db->prepare($consulta_actualizar);
        $sentencia_actualizar->bindParam(':nou_usuari', $nou_usuari);
        $sentencia_actualizar->bindParam(':contrasenya_nova', $contrasenya_nova);
        $sentencia_actualizar->bindParam(':id_usuari', $_SESSION['UsuariId']);
        $sentencia_actualizar->execute();
        echo "<script>alert('Perfil actualitzat amb èxit');</script>";
         header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } elseif (empty($contrasenya_nova)) {
        $consulta_actualizar = "UPDATE usuaris SET usuari = :nou_usuari WHERE id_usuari = :id_usuari";

        $sentencia_actualizar = $db->prepare($consulta_actualizar);
        $sentencia_actualizar->bindParam(':nou_usuari', $nou_usuari);
        $sentencia_actualizar->bindParam(':id_usuari', $_SESSION['UsuariId']);
        $sentencia_actualizar->execute();
       
        echo "<script>alert('Nom d\'usuari actualitzat amb èxit');</script>";
         header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Les contrasenyes no coincideixen');</script>";
    }
}

?>

<div class="perfil-container">
		
			<h2>Configuració d'usuari</h2>
                        <br>
		<div class="perfil-content">
    <h3>Informació de perfil</h3>
    <br>
    <form action="perfil.php" method="post" class="actualizar-perfil">
        <div class="input-container">
            <label for="id_usuari">Id usuari:</label>
            <input type="text" name="id_usuari" value="<?php echo $_SESSION['UsuariId']; ?>" readonly class="readonly-input"><br>
            <br>
            <label for="email_usuari">Email usuari:</label>
            <input type="text" name="email_usuari" value="<?php echo $_SESSION['UsuariEmail']; ?>" readonly class="readonly-input"><br>
            <br>
            <label for="nom_usuari">Nom usuari:</label>
            <input type="text" name="nom_usuari" value="<?php echo $_SESSION['Usuari']; ?>" class="readonly-input"><br>
            <br>
            <br>
            <h2>Nova contrasenya</h2>
            <br>
            <label for="contrasenya_nova">Nova contrasenya:</label>
            <input type="password" name="contrasenya_nova" placeholder="Nova contrasenya" class="readonly-input"><br>
            <br>
            <label for="Contrasenya_confirmar">Repeteix la nova contrasenya:</label>
            <input type="password" name="Contrasenya_confirmar" placeholder="Repeteix la nova contrasenya" class="readonly-input"><br>
            <br>
            <div class="boto-container">
        <button type="submit" name="actualizar_perfil">Actualizar perfil</button>
        
        <form action="perfil.php" method="post">
            <button type="submit" name="eliminar_compte" onclick="return confirm('¿Estas segur d\'eliminar el teu compte?')">Eliminar cuenta</button>
        </form>

        <form action="perfil.php" method="post">
            <button type="submit" name="tancar_sessio">Tancar Sessió</button>
    </form>
		</div>
                </div>
    </form>
                </div>

</body>
</html>