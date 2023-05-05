<?php
require_once('config.php');
session_start();
?>
<?php
$emailE = $_SESSION['UsuariEmail']; //tancar sessió 
if(isset($_POST['tancar_sessio']))
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
        <title>Perfil</title>
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
            <h3>Nova contrasenya</h3>
            <br>
            <label for="contrasenya_nova">Nova contrasenya:</label>
            <input type="password" name="contrasenya_nova" placeholder="Nova contrasenya" class="readonly-input"><br>
            <br>
            <label for="Contrasenya_confirmar">Repeteix la nova contrasenya:</label>
            <input type="password" name="Contrasenya_confirmar" placeholder="Repeteix la nova contrasenya" class="readonly-input"><br>
            <br>
           <div class="boto-container">
    <form action="perfil.php" method="post">
        <button type="submit" name="actualizar_perfil">Actualizar perfil</button>
        <button type="submit" name="eliminar_compte" onclick="return confirm('¿Estas segur d\'eliminar el teu compte?')">Eliminar cuenta</button>
        <button type="submit" name="tancar_sessio">Tancar Sessió</button>
    </form>
               
</div>
                </div>
    </form>
                </div>

</div>
 </div>
    
   <footer class="footer">
    Copyright &copy; <a href="#política de privacitat">Política de privacitat.</a>
  </footer>
</body>
</html>