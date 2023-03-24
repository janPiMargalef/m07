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
<?php     //FER UN IF amb $_SESSION[aquest_usuari_te_equip] PER TEURE LA OPCIO DE CREAR EQUIP I AFEGIR LA OPCIO MARXARDE L'EQUIP
if(isset($_POST["crearEquip"]))
{
    $db_usuari = "root";
$db_contrasenya = "";
$db_nom = "projecte";
$nomservidor = "localhost";

$pdo = new PDO("mysql:host=$nomservidor;dbname=$db_nom", $db_usuari, $db_contrasenya);

    $name = $_POST['nomEquip'];
    
    $sentencia = $db->prepare("SELECT nom_equip FROM equips WHERE nom_equip = ? LIMIT 1;");
    $sentencia->execute([$name]);
    
$numFiles = $sentencia->rowCount(); 
if($numFiles > 0)
{
    echo "<script>alert('equip ja existeix'); </script>";
}
else{
    $stmt = $pdo->prepare('INSERT INTO equips (nom_equip) VALUES (?)');
    $stmt->execute([$name]);

    $groupId = $pdo->lastInsertId();
}
}
?>
<form  method="POST">
    <label for="name">Nom de l'equip:</label>
    <input type="text" name="nomEquip">
    <button type="submit" name="crearEquip">Crear equip</button>
</form>
<form action="agregar_usuario.php" method="POST">
    <label for="group">Seleccionar grupo:</label>
    <select name="group" id="group">
        <?php
            
$pdo = new PDO("mysql:host=$nomservidor;dbname=$db_nom", $db_usuari, $db_contrasenya);
            $stmt = $pdo->prepare('SELECT * FROM equips');
            $stmt->execute();

            foreach ($stmt as $row) {
                echo '<option value="'.$row['id_equip'].'">'.$row['nom_equip'].'</option>';
            }
        ?>
    </select>
    <label for="name">Nombre del usuario:</label>
    <input type="text" name="name" id="name">
    <label for="email">Correo electrónico:</label>
    <input type="email" name="email" id="email">
    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password">
    <button type="submit">Agregar usuario</button>
</form>
    </body>
</html>

